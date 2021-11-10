<?php

namespace XoopsModules\Edito\Common;

/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */
/**
 * Breadcrumb Class
 *
 * @package  \XoopsModules\Edito\Class\Common
 * @copyright  &copy; 2000-2021 {@link https://xoops.org XOOPS Project}
 * @license  {@link https://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU GPL 2}
 * @author  lucio <lucio.rota@gmail.com>
 *
 * Example:
 * $breadcrumb = new Common\Breadcrumb();
 * $breadcrumb->addLink('bread 1', 'index1.php');
 * $breadcrumb->addLink('bread 2', '');
 * $breadcrumb->addLink('bread 3', 'index3.php');
 * echo $breadcrumb->render();
 */
use XoopsModules\Edito;
use XoopsModules\Edito\Common;

/**
 * Class Breadcrumb
 */
class Breadcrumb
{
    /**
     * @var  string
     */
    private $dirname;

    /**
     * @var  array
     */
    private $bread = [];

    public function __construct()
    {
        $this->dirname = basename(dirname(__DIR__, 2));
    }

    /**
     * Add link to breadcrumb
     *
     * @param  null|string  $title
     * @param  null|string  $link
     */
    public function addLink($title = '', $link = '')
    {
        $this->bread[] = [
            'link'  => $link,
            'title' => $title,
        ];
    }

    /**
     * Render BreadCrumb
     *
     * @return  string  HTML string to display breadcrumb
     */
    public function render()
    {
        if (!isset($GLOBALS['xoTheme']) || ($GLOBALS['xoTheme'] instanceof \xos_opal_Theme)) {
            require $GLOBALS['xoops']->path('class/theme.php');
            $GLOBALS['xoTheme'] = new \xos_opal_Theme();
        }

        require $GLOBALS['xoops']->path('class/template.php');
        $breadcrumbTpl = new \XoopsTpl();
        $breadcrumbTpl->assign('breadcrumb', $this->bread);
        $html = $breadcrumbTpl->fetch('db:' . $this->dirname . '_common_breadcrumb.tpl');
        unset($breadcrumbTpl);

        return $html;

    }

    /**
     * Display BreadCrumb
     *
     * @return  void
     */
    public function display()
    {
        echo $this->render();
    }
}
