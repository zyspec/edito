<?php

declare(strict_types=1);

/*
 You may not change or alter any portion of this comment or credits of
 supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit
 authors.

 This program is distributed in the hope that it will be useful, but
 WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */
/**
 * Module: Edito
 *
 * @copyright Copyright {@link https://xoops.org XOOPS Project}
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 * @author    Solo (http://www.wolfpackclan.com/wolfactory)
 * @author    DuGris (http://www.dugris.info)
 * @author    XOOPS Module Development Team
 * @link      https://github.com/XoopsModules25x/edito
 */



include dirname(__DIR__) . '/preloads/autoloader.php';

require  dirname(dirname(dirname(__DIR__))) . '/include/cp_header.php';
require $GLOBALS['xoops']->path('www/class/xoopsformloader.php');
require  dirname(__DIR__) . '/include/common.php';

$moduleDirName = basename(dirname(__DIR__));

/** @var \XoopsModules\Edito\Helper $helper */
$helper = \XoopsModules\Edito\Helper::getInstance();

/** @var \Xmf\Module\Admin $adminObject */
$adminObject = \Xmf\Module\Admin::getInstance();

// Load language files
$helper->loadLanguage('admin');
$helper->loadLanguage('modinfo');
$helper->loadLanguage('common');
$helper->loadLanguage('main');

$myts = \MyTextSanitizer::getInstance();


require_once dirname(__DIR__) . '/include/functions_edito.php';

if ('index.php' == basename($_SERVER['PHP_SELF'])) {
    edito_UpdatedModule();
}

//xoops_cp_header();

echo '<style type="text/css">';
echo 'th a:link {text-decoration: none; color: #ffff00; font-weight: bold; background-color: transparent;}';
echo 'th a:active {text-decoration: none; color: #ffffff; font-weight: bold; background-color: transparent;}';
echo 'th a:visited {text-decoration: none; color: #ffff00; font-weight: bold; background-color: transparent;}';
echo 'th a:hover {text-decoration: none; color: #ff0000; font-weight: bold; background-color: transparent;}';
echo '</style>';
//edito_GetLastVersion();
