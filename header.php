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
 * @package   \XoopsModules\Edito
 * @copyright Copyright {@link https://xoops.org XOOPS Project}
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 * @author    Solo (http://www.wolfpackclan.com/wolfactory)
 * @author    DuGris (http://www.dugris.info)
 * @author    XOOPS Module Development Team
 * @link      https://github.com/XoopsModules25x/edito
 */

use \XoopsModules\Edito\Helper;

include __DIR__ . '/preloads/autoloader.php';

require_once dirname(__DIR__, 2) . '/mainfile.php';
require_once XOOPS_ROOT_PATH . '/class/pagenav.php';
require_once __DIR__ . '/include/functions_content.php';

/** @var \XoopsModules\Edito\Helper $helper */
$helper = Helper::getInstance();

$moduleDirName = basename(__DIR__);
$modulePath    = XOOPS_ROOT_PATH . '/modules/' . $moduleDirName;

$myts          = \MyTextSanitizer::getInstance();

// Load language files
$helper->loadLanguage('main');

if (!isset($GLOBALS['xoTheme']) || !($GLOBALS['xoTheme'] instanceof \xos_opal_Theme)) {
    require $GLOBALS['xoops']->path('class/theme.php');
    $GLOBALS['xoTheme'] = new \xos_opal_Theme();
}

if (!isset($GLOBALS['xoopsTpl']) || !($GLOBALS['xoopsTpl'] instanceof \XoopsTpl)) {
    require $GLOBALS['xoops']->path('class/template.php');
    $xoopsTpl = new \XoopsTpl();
}
