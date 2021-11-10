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

require_once __DIR__ . '/admin_header.php';

//$guide = _AM_MYREFERER_GUIDE;
//$guide = $myts->displayTarea($guide);

edito_adminmenu(-1, _AM_EDITO_NAV_HELP);
echo "<table class='width100' cellspacing='1' cellpadding='8' style='border: 2px solid #2F5376;'>\n"
   . "  <tr class='bg4'>\n"
   . "    <td class='top'>\n";

//echo $guide;
$helpfile = XOOPS_ROOT_PATH . '/modules/edito/language/' . $xoopsConfig['language'] . '/help.html';
if (file_exists($helpfile)) {
	require_once ($helpfile);
} else {
    require_once XOOPS_ROOT_PATH . '/modules/edito/language/english/help.tpl';
}

//echo $guide;
CloseTable();
require_once __DIR__ . '/admin_footer.php';
