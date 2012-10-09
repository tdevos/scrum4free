<?php
namespace ZendTest\Db\Adapter\Driver\Sqlsrv;

use Zend\Db\Adapter\Driver\Sqlsrv\Sqlsrv;
use Zend\Db\Adapter\Driver\Sqlsrv\Connection;

/**
 * @group integration
 * @group integration-sqlserver
 */
class ConnectionIntegrationTest extends \PHPUnit_Framework_TestCase
{
    protected $variables = array(
        'hostname' => 'ZEND_DB_ADAPTER_DRIVER_SQLSRV_HOSTNAME',
        'username' => 'ZEND_DB_ADAPTER_DRIVER_SQLSRV_USERNAME',
        'password' => 'ZEND_DB_ADAPTER_DRIVER_SQLSRV_PASSWORD',
    );

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        foreach ($this->variables as $name => $value) {
            if (!isset($GLOBALS[$value])) {
                $this->fail('Missing required variable ' . $value . ' from phpunit.xml for this integration test');
            }
            $this->variables[$name] = $GLOBALS[$value];
        }

        if (!extension_loaded('sqlsrv')) {
            $this->fail('The phpunit group integration-sqlsrv was enabled, but the extension is not loaded.');
        }
    }

    /**
     * @covers Zend\Db\Adapter\Driver\Sqlsrv\Connection::getCurrentSchema
     */
    public function testGetCurrentSchema()
    {
        $connection = new Connection($this->variables);
        $this->assertInternalType('string', $connection->getCurrentSchema());
    }

    /**
     * @covers Zend\Db\Adapter\Driver\Sqlsrv\Connection::setResource
     */
    public function testSetResource()
    {
        $resource = sqlsrv_connect(
            $this->variables['hostname'], array(
                'UID' => $this->variables['username'],
                'PWD' => $this->variables['password']
            )
        );
        $connection = new Connection(array());
        $this->assertSame($connection, $connection->setResource($resource));

        $connection->disconnect();
        unset($connection);
        unset($resource);
    }

    /**
     * @covers Zend\Db\Adapter\Driver\Sqlsrv\Connection::getResource
     */
    public function testGetResource()
    {
        $connection = new Connection($this->variables);
        $connection->connect();
        $this->assertInternalType('resource', $connection->getResource());

        $connection->disconnect();
        unset($connection);
    }

    /**
     * @covers Zend\Db\Adapter\Driver\Sqlsrv\Connection::connect
     */
    public function testConnect()
    {
        $connection = new Connection($this->variables);
        $this->assertSame($connection, $connection->connect());
        $this->assertTrue($connection->isConnected());

        $connection->disconnect();
        unset($connection);
    }

    /**
     * @covers Zend\Db\Adapter\Driver\Sqlsrv\Connection::isConnected
     */
    public function testIsConnected()
    {
        $connection = new Connection($this->variables);
        $this->assertFalse($connection->isConnected());
        $this->assertSame($connection, $connection->connect());
        $this->assertTrue($connection->isConnected());

        $connection->disconnect();
        unset($connection);
    }

    /**
     * @covers Zend\Db\Adapter\Driver\Sqlsrv\Connection::disconnect
     */
    public function testDisconnect()
    {
        $connection = new Connection($this->variables);
        $connection->connect();
        $this->assertTrue($connection->isConnected());
        $connection->disconnect();
        $this->assertFalse($connection->isConnected());
    }

    /**
     * @covers Zend\Db\Adapter\Driver\Sqlsrv\Connection::beginTransaction
     * @todo   Implement testBeginTransaction().
     */
    public function testBeginTransaction()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Zend\Db\Adapter\Driver\Sqlsrv\Connection::commit
     * @todo   Implement testCommit().
     */
    public function testCommit()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Zend\Db\Adapter\Driver\Sqlsrv\Connection::rollback
     * @todo   Implement testRollback().
     */
    public function testRollback()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Zend\Db\Adapter\Driver\Sqlsrv\Connection::execute
     */
    public function testExecute()
    {
        $sqlsrv = new Sqlsrv($this->variables);
        $connection = $sqlsrv->getConnection();

        $result = $connection->execute('SELECT \'foo\'');
        $this->assertInstanceOf('Zend\Db\Adapter\Driver\Sqlsrv\Result', $result);
    }

    /**
     * @covers Zend\Db\Adapter\Driver\Sqlsrv\Connection::prepare
     */
    public function testPrepare()
    {
        $sqlsrv = new Sqlsrv($this->variables);
        $connection = $sqlsrv->getConnection();

        $statement = $connection->prepare('SELECT \'foo\'');
        $this->assertInstanceOf('Zend\Db\Adapter\Driver\Sqlsrv\Statement', $statement);
    }

    /**
     * @covers Zend\Db\Adapter\Driver\Sqlsrv\Connection::getLastGeneratedValue
     */
    public function testGetLastGeneratedValue()
    {
        $this->markTestIncomplete('Need to create a temporary sequence.');
        $connection = new Connection($this->variables);
        $connection->getLastGeneratedValue();
    }
}
