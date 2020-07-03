<?php declare(strict_types=1);
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
require_once dirname(__DIR__, 3) . '/mainfile.php';
require_once XOOPS_ROOT_PATH . '/include/cp_header.php';
require_once XOOPS_ROOT_PATH . '/include/functions.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
//require_once XOOPS_ROOT_PATH . '/class/module.errorhandler.php');
//$eh = new ErrorHandler;
$myts = MyTextSanitizer::getInstance();

$moduleDirName = basename(__DIR__);

require_once dirname(__DIR__) . '/include/functions_edito.php';

if (file_exists(XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname') . '/language/' . $xoopsConfig['language'] . '/common.php')) {
    require_once XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname') . '/language/' . $xoopsConfig['language'] . '/common.php';

    require_once XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname') . '/language/' . $xoopsConfig['language'] . '/modinfo.php';

    require_once XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname') . '/language/' . $xoopsConfig['language'] . '/main.php';
} else {
    require_once XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname') . '/language/english/common.php';

    require_once XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname') . '/language/english/modinfo.php';

    require_once XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname') . '/language/english/main.php';
}

if ('index.php' == basename($_SERVER['PHP_SELF'])) {
    edito_UpdatedModule();
}

xoops_cp_header();
echo '<style type="text/css">';
echo 'th a:link {text-decoration: none; color: #ffff00; font-weight: bold; background-color: transparent;}';
echo 'th a:active {text-decoration: none; color: #ffffff; font-weight: bold; background-color: transparent;}';
echo 'th a:visited {text-decoration: none; color: #ffff00; font-weight: bold; background-color: transparent;}';
echo 'th a:hover {text-decoration: none; color: #ff0000; font-weight: bold; background-color: transparent;}';
echo '</style>';
//edito_GetLastVersion();
