<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   Zend_View
 */

namespace Zend\View\Helper;

/**
 * @category   Zend
 * @package    Zend_View
 * @subpackage UnitTests
 */
class Stub2
{
    public $view;

    public function direct()
    {
        return 'bar';
    }

    public function setView(\Zend\View\View $view)
    {
        $this->view = $view;
        return $this;
    }
}
