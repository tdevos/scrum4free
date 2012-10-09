<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   Zend_Config
 */

namespace ZendTest\Config\Reader;

use Zend\Config\Reader\Ini;

/**
 * @category   Zend
 * @package    Zend_Config
 * @subpackage UnitTests
 * @group      Zend_Config
 */
class IniTest extends AbstractReaderTestCase
{
    public function setUp()
    {
        $this->reader = new Ini();
    }

    /**
     * getTestAssetPath(): defined by AbstractReaderTestCase.
     *
     * @see    AbstractReaderTestCase::getTestAssetPath()
     * @return string
     */
    protected function getTestAssetPath($name)
    {
        return __DIR__ . '/TestAssets/Ini/' . $name . '.ini';
    }

    public function testInvalidIniFile()
    {
        $this->reader = new Ini();
        $this->setExpectedException('Zend\Config\Exception\RuntimeException');
        $arrayIni = $this->reader->fromFile($this->getTestAssetPath('invalid'));
    }

    public function testFromString()
    {
        $ini = <<<ECS
test= "foo"
bar[]= "baz"
bar[]= "foo"

ECS;

        $arrayIni = $this->reader->fromString($ini);
        $this->assertEquals($arrayIni['test'], 'foo');
        $this->assertEquals($arrayIni['bar'][0], 'baz');
        $this->assertEquals($arrayIni['bar'][1], 'foo');
    }

    public function testInvalidString()
    {
        $ini = <<<ECS
test== "foo"

ECS;
        $this->setExpectedException('Zend\Config\Exception\RuntimeException');
        $arrayIni = $this->reader->fromString($ini);
    }

    public function testFromStringWithSection()
    {
        $ini = <<<ECS
[all]
test= "foo"
bar[]= "baz"
bar[]= "foo"

ECS;

        $arrayIni = $this->reader->fromString($ini);
        $this->assertEquals($arrayIni['all']['test'], 'foo');
        $this->assertEquals($arrayIni['all']['bar'][0], 'baz');
        $this->assertEquals($arrayIni['all']['bar'][1], 'foo');
    }

    public function testFromStringNested()
    {
        $ini = <<<ECS
foo.bar = foobar
foobar[] = foobarArray
foo.baz[] = foobaz1
foo.baz[] = foobaz2

ECS;

        $arrayIni = $this->reader->fromString($ini);
        $this->assertEquals($arrayIni['foo']['bar'], 'foobar');
        $this->assertEquals($arrayIni['foobar'][0], 'foobarArray');
        $this->assertEquals($arrayIni['foo']['baz'][0], 'foobaz1');
        $this->assertEquals($arrayIni['foo']['baz'][1], 'foobaz2');
    }
}
