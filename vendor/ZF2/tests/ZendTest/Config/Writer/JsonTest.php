<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   Zend_Config
 */

namespace ZendTest\Config\Writer;

use Zend\Config\Writer\Json as JsonWriter;
use Zend\Config\Config;
use Zend\Config\Reader\Json as JsonReader;

/**
 * @category   Zend
 * @package    Zend_Config
 * @subpackage UnitTests
 * @group      Zend_Config
 */
class JsonTest extends AbstractWriterTestCase
{
    public function setUp()
    {
        $this->reader = new JsonReader();
        $this->writer = new JsonWriter();
    }

    public function testNoSection()
    {
        $config = new Config(array('test' => 'foo', 'test2' => array('test3' => 'bar')));

        $this->writer->toFile($this->getTestAssetFileName(), $config);

        $config = $this->reader->fromFile($this->getTestAssetFileName());

        $this->assertEquals('foo', $config['test']);
        $this->assertEquals('bar', $config['test2']['test3']);
    }

    public function testWriteAndReadOriginalFile()
    {
        $config = $this->reader->fromFile(__DIR__ . '/_files/allsections.json');

        $this->writer->toFile($this->getTestAssetFileName(), $config);

        $config = $this->reader->fromFile($this->getTestAssetFileName());

        $this->assertEquals('multi', $config['all']['one']['two']['three']);

    }
}
