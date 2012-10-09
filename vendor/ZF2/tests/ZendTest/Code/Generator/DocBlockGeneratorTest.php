<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   Zend_Code
 */

namespace ZendTest\Code\Generator;

use Zend\Code\Generator\DocBlockGenerator;
use Zend\Code\Generator\DocBlock\Tag;

/**
 * @category   Zend
 * @package    Zend_Code_Generator
 * @subpackage UnitTests
 *
 * @group      Zend_Code_Generator
 * @group      Zend_Code_Generator_Php
 */
class DocBlockGeneratorTest extends \PHPUnit_Framework_TestCase
{
    /** @var DocBlockGenerator */
    protected $docBlockGenerator;

    protected function setUp()
    {
        $this->docBlockGenerator = $this->docBlockGenerator = new DocBlockGenerator();
    }

    public function testShortDescriptionGetterAndSetter()
    {
        $this->docBlockGenerator->setShortDescription('Short Description');
        $this->assertEquals('Short Description', $this->docBlockGenerator->getShortDescription());
    }

    public function testLongDescriptionGetterAndSetter()
    {
        $this->docBlockGenerator->setLongDescription('Long Description');
        $this->assertEquals('Long Description', $this->docBlockGenerator->getLongDescription());
    }

    public function testTagGettersAndSetters()
    {
        $paramTag = new Tag\ParamTag();
        $paramTag->setDatatype('string');

        $returnTag = new Tag\ReturnTag();
        $returnTag->setDatatype('int');

        $this->docBlockGenerator->setTag(array('name' => 'blah'));
        $this->docBlockGenerator->setTag($paramTag);
        $this->docBlockGenerator->setTag($returnTag);
        $this->assertEquals(3, count($this->docBlockGenerator->getTags()));

        $target = <<<EOS
/**
 * @blah
 * @param string
 * @return int
 */

EOS;

        $this->assertEquals($target, $this->docBlockGenerator->generate());

    }

    public function testGenerationOfDocBlock()
    {
        $this->docBlockGenerator->setShortDescription('@var Foo this is foo bar');

        $expected = '/**' . DocBlockGenerator::LINE_FEED . ' * @var Foo this is foo bar'
            . DocBlockGenerator::LINE_FEED . ' */' . DocBlockGenerator::LINE_FEED;
        $this->assertEquals($expected, $this->docBlockGenerator->generate());
    }

}
