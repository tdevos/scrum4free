<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   Zend_Filter
 */

namespace ZendTest\Filter\Word;

use Zend\Filter\Word\DashToSeparator as DashToSeparatorFilter;

/**
 * Test class for Zend_Filter_Word_DashToSeparator.
 *
 * @category   Zend
 * @package    Zend_Filter
 * @subpackage UnitTests
 * @group      Zend_Filter
 */
class DashToSeparatorTest extends \PHPUnit_Framework_TestCase
{
    public function testFilterSeparatesDashedWordsWithDefaultSpaces()
    {
        $string   = 'dash-separated-words';
        $filter   = new DashToSeparatorFilter();
        $filtered = $filter($string);

        $this->assertNotEquals($string, $filtered);
        $this->assertEquals('dash separated words', $filtered);
    }

    public function testFilterSeparatesDashedWordsWithSomeString()
    {
        $string   = 'dash-separated-words';
        $filter   = new DashToSeparatorFilter(':-:');
        $filtered = $filter($string);

        $this->assertNotEquals($string, $filtered);
        $this->assertEquals('dash:-:separated:-:words', $filtered);
    }

}
