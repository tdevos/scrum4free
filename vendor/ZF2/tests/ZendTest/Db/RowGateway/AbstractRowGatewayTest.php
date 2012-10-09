<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   Zend_Db
 */

namespace ZendTest\Db\RowGateway;

use Zend\Db\RowGateway\RowGateway;

class AbstractRowGatewayTest extends \PHPUnit_Framework_TestCase
{

    protected $mockAdapter = null;

    /** @var RowGateway */
    protected $rowGateway = null;

    protected $mockResult = null;

    public function setup()
    {
        // mock the adapter, driver, and parts
        $mockResult = $this->getMock('Zend\Db\Adapter\Driver\ResultInterface');
        $mockResult->expects($this->any())->method('getAffectedRows')->will($this->returnValue(1));
        $this->mockResult = $mockResult;
        $mockStatement = $this->getMock('Zend\Db\Adapter\Driver\StatementInterface');
        $mockStatement->expects($this->any())->method('execute')->will($this->returnValue($mockResult));
        $mockConnection = $this->getMock('Zend\Db\Adapter\Driver\ConnectionInterface');
        $mockDriver = $this->getMock('Zend\Db\Adapter\Driver\DriverInterface');
        $mockDriver->expects($this->any())->method('createStatement')->will($this->returnValue($mockStatement));
        $mockDriver->expects($this->any())->method('getConnection')->will($this->returnValue($mockConnection));

        // setup mock adapter
        $this->mockAdapter = $this->getMock('Zend\Db\Adapter\Adapter', null, array($mockDriver));

        $this->rowGateway = $this->getMockForAbstractClass('Zend\Db\RowGateway\AbstractRowGateway');

        $rgPropertyValues = array(
            'primaryKeyColumn' => 'id',
            'table' => 'foo',
            'sql' => new \Zend\Db\Sql\Sql($this->mockAdapter)
        );
        $this->setRowGatewayState($rgPropertyValues);
    }

    /**
     * @covers Zend\Db\RowGateway\RowGateway::offsetSet
     */
    public function testOffsetSet()
    {
        // If we set with an index, both getters should retrieve the same value:
        $this->rowGateway['testColumn'] = 'test';
        $this->assertEquals('test', $this->rowGateway->testColumn);
        $this->assertEquals('test', $this->rowGateway['testColumn']);
    }

    /**
     * @covers Zend\Db\RowGateway\RowGateway::__set
     */
    public function test__set()
    {
        // If we set with a property, both getters should retrieve the same value:
        $this->rowGateway->testColumn = 'test';
        $this->assertEquals('test', $this->rowGateway->testColumn);
        $this->assertEquals('test', $this->rowGateway['testColumn']);
    }

    /**
     * @covers Zend\Db\RowGateway\RowGateway::__isset
     */
    public function test__isset()
    {
        // Test isset before and after assigning to a property:
        $this->assertFalse(isset($this->rowGateway->foo));
        $this->rowGateway->foo = 'bar';
        $this->assertTrue(isset($this->rowGateway->foo));
    }

    /**
     * @covers Zend\Db\RowGateway\RowGateway::offsetExists
     */
    public function testOffsetExists()
    {
        // Test isset before and after assigning to an index:
        $this->assertFalse(isset($this->rowGateway['foo']));
        $this->rowGateway['foo'] = 'bar';
        $this->assertTrue(isset($this->rowGateway['foo']));
    }

    /**
     * @covers Zend\Db\RowGateway\RowGateway::__unset
     */
    public function test__unset()
    {
        $this->rowGateway->foo = 'bar';
        $this->assertEquals('bar', $this->rowGateway->foo);
        unset($this->rowGateway->foo);
        $this->assertEmpty($this->rowGateway->foo);
        $this->assertEmpty($this->rowGateway['foo']);
    }

    /**
     * @covers Zend\Db\RowGateway\RowGateway::offsetUnset
     */
    public function testOffsetUnset()
    {

        $this->rowGateway['foo'] = 'bar';
        $this->assertEquals('bar', $this->rowGateway['foo']);
        unset($this->rowGateway['foo']);
        $this->assertEmpty($this->rowGateway->foo);
        $this->assertEmpty($this->rowGateway['foo']);
    }

    /**
     * @covers Zend\Db\RowGateway\RowGateway::offsetGet
     */
    public function testOffsetGet()
    {
        // If we set with an index, both getters should retrieve the same value:
        $this->rowGateway['testColumn'] = 'test';
        $this->assertEquals('test', $this->rowGateway->testColumn);
        $this->assertEquals('test', $this->rowGateway['testColumn']);
    }

    /**
     * @covers Zend\Db\RowGateway\RowGateway::__get
     */
    public function test__get()
    {
        // If we set with a property, both getters should retrieve the same value:
        $this->rowGateway->testColumn = 'test';
        $this->assertEquals('test', $this->rowGateway->testColumn);
        $this->assertEquals('test', $this->rowGateway['testColumn']);
    }

    /**
     * @covers Zend\Db\RowGateway\RowGateway::save
     */
    public function testSaveInsert()
    {
        // test insert
        $this->mockResult->expects($this->any())->method('current')->will($this->returnValue(array('id' => 5, 'name' => 'foo')));
        $this->mockResult->expects($this->any())->method('getGeneratedValue')->will($this->returnValue(5));
        $this->rowGateway->populate(array('name' => 'foo'));
        $this->rowGateway->save();
        $this->assertEquals(5, $this->rowGateway->id);
        $this->assertEquals(5, $this->rowGateway['id']);
    }

    /**
     * @covers Zend\Db\RowGateway\RowGateway::save
     */
    public function testSaveInsertMultiKey()
    {
        $this->rowGateway = $this->getMockForAbstractClass('Zend\Db\RowGateway\AbstractRowGateway');

        $mockSql = $this->getMockForAbstractClass('Zend\Db\Sql\Sql', array($this->mockAdapter));

        $rgPropertyValues = array(
            'primaryKeyColumn' => array('one', 'two'),
            'table' => 'foo',
            'sql' => $mockSql
        );
        $this->setRowGatewayState($rgPropertyValues);

        // test insert
        $this->mockResult->expects($this->any())->method('current')->will($this->returnValue(array('one' => 'foo', 'two' => 'bar')));

        // @todo Need to assert that $where was filled in

        $refRowGateway = new \ReflectionObject($this->rowGateway);
        $refRowGatewayProp = $refRowGateway->getProperty('primaryKeyData');
        $refRowGatewayProp->setAccessible(true);

        $this->rowGateway->populate(array('one' => 'foo', 'two' => 'bar'));

        $this->assertNull($refRowGatewayProp->getValue($this->rowGateway));

        // save should setup the primaryKeyData
        $this->rowGateway->save();

        $this->assertEquals(array('one' => 'foo', 'two' => 'bar'), $refRowGatewayProp->getValue($this->rowGateway));
    }

    /**
     * @covers Zend\Db\RowGateway\RowGateway::save
     */
    public function testSaveUpdate()
    {
        // test update
        $this->mockResult->expects($this->any())->method('current')->will($this->returnValue(array('id' => 6, 'name' => 'foo')));
        $this->rowGateway->populate(array('id' => 6, 'name' => 'foo'), true);
        $this->rowGateway->save();
        $this->assertEquals(6, $this->rowGateway['id']);
    }

    /**
     * @covers Zend\Db\RowGateway\RowGateway::delete
     */
    public function testDelete()
    {
        $this->rowGateway->foo = 'bar';
        $affectedRows = $this->rowGateway->delete();
        $this->assertFalse($this->rowGateway->rowExistsInDatabase());
    }

    /**
     * @covers Zend\Db\RowGateway\RowGateway::populate
     * @covers Zend\Db\RowGateway\RowGateway::rowExistsInDatabase
     */
    public function testPopulate()
    {
        $this->rowGateway->populate(array('id' => 5, 'name' => 'foo'));
        $this->assertEquals(5, $this->rowGateway['id']);
        $this->assertEquals('foo', $this->rowGateway['name']);
        $this->assertFalse($this->rowGateway->rowExistsInDatabase());

        $this->rowGateway->populate(array('id' => 5, 'name' => 'foo'), true);
        $this->assertTrue($this->rowGateway->rowExistsInDatabase());
    }

    /**
     * @covers Zend\Db\RowGateway\RowGateway::processPrimaryKeyData
     */
    public function testProcessPrimaryKeyData()
    {
        $this->rowGateway->populate(array('id' => 5, 'name' => 'foo'), true);

        $this->setExpectedException('Zend\Db\RowGateway\Exception\RuntimeException', 'a known key id was not found');
        $this->rowGateway->populate(array('boo' => 5, 'name' => 'foo'), true);
    }

    /**
     * @covers Zend\Db\RowGateway\RowGateway::count
     */
    public function testCount()
    {
        $this->rowGateway->populate(array('id' => 5, 'name' => 'foo'), true);
        $this->assertEquals(2, $this->rowGateway->count());
    }

    /**
     * @covers Zend\Db\RowGateway\RowGateway::toArray
     */
    public function testToArray()
    {
        $this->rowGateway->populate(array('id' => 5, 'name' => 'foo'), true);
        $this->assertEquals(array('id' => 5, 'name' => 'foo'), $this->rowGateway->toArray());
    }

    protected function setRowGatewayState(array $properties)
    {
        $refRowGateway = new \ReflectionObject($this->rowGateway);
        foreach ($properties as $rgPropertyName => $rgPropertyValue) {
            $refRowGatewayProp = $refRowGateway->getProperty($rgPropertyName);
            $refRowGatewayProp->setAccessible(true);
            $refRowGatewayProp->setValue($this->rowGateway, $rgPropertyValue);
        }
    }
}
