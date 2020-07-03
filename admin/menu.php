<?php
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

use Xmf\Request;

$id = Request::getInt('id', 0);
$op = Request::getCmd('op', '');

if (preg_match('/_ok/', $op)) {
	$adminmenu[] = [
        'title'	=> _MI_EDITO_GOTO_INDEX,
	    'link'	=> 'index.php',
	    'desc'  => _MI_EDITO_GOTO_INDEX_DSC,
	    'icon'  => \Xmf\Module\Admin::menuIconPath('home.png')
    ];
}
$adminmenu[] = [
    'title' => _MI_EDITO_LIST,
    'link'  => 'admin/index.php',
    'desc'  => _MI_EDITO_LIST_DESC,
    'icon'  => \Xmf\Module\Admin::menuIconPath('content.png')
];
$adminmenu[] = [
    'title' => _MI_EDITO_CREATE,
    'link'  => 'admin/content.php',
    'desc'  => _MI_EDITO_CREATE_DESC,
    'icon'  => \Xmf\Module\Admin::menuIconPath('add.png')
];
if (0 < $id) {
	$adminmenu[] = [
        'title' => _MI_EDITO_SEE,
    	'link'  => "content.php?id={$id}",
	    'desc'  => _MI_EDITO_SEE_DESC,
    	'icon'  => \Xmf\Module\Admin::menuIconPath('album.png')
	];
}

$adminmenu[] = [
    'title'	=> _MI_EDITO_UTILITIES,
    'link'  => 'admin/utils_uploader.php',
    'desc'  => _MI_EDITO_UTILITIES_DESC,
    'icon'  => \Xmf\Module\Admin::menuIconPath('administration.png')
];
$adminmenu[] = [
    'title' => _MI_EDITO_BLOCKS_GRPS,
    'link'  => "admin/blocks.php",
    'desc'  => _MI_EDITO_BLOCKS_DESC,
    'icon'  => \Xmf\Module\Admin::menuIconPath('block.png')
];

$hModule = xoops_gethandler('module');

include_once( XOOPS_ROOT_PATH . '/class/uploader.php');
if (defined('_XI_MIMETYPE')) {
	$adminmenu[] = [
	    'title' => _MI_EDITO_MIMETYPES,
        'link'  => 'admin/mimetypes.php',
	    'desc'  => _MI_EDITO_MIMETYPES_DESC,
	    'icon'  => \Xmf\Module\Admin::menuIconPath('metagen.png')
    ];
}

if (isset($xoopsModule)) {
  	$i=0;
  	$headermenu[$i]['title']	= '<img src="../assets/images/icon/home.gif" align="absmiddle" alt="'._MI_EDITO_GOTO_INDEX.'"/>';
  	$headermenu[$i]['alt']	        = _MI_EDITO_GOTO_INDEX;
	$headermenu[$i++]['link']	= '../';

	$headermenu[$i]['title']	= '<img src="../assets/images/icon/submit.gif" align="absmiddle" alt="'._MI_EDITO_SUBMIT.'"/>';
	$headermenu[$i]['alt']	        = _MI_EDITO_SUBMIT;
	$headermenu[$i++]['link']	= "../submit.php";

	$headermenu[$i]['title']	= '<img src="../assets/images/icon/settings.gif" align="absmiddle" alt="'._MI_EDITO_SETTINGS.'"/>';
	$headermenu[$i]['alt']	        = _MI_EDITO_SETTINGS;
	$headermenu[$i++]['link']	= '../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=' . $xoopsModule->getVar('mid');

	$headermenu[$i]['title']	= '<img src="../assets/images/icon/update.gif" align="absmiddle" alt="'._MI_EDITO_UPDATE_MODULE.'"/>';
	$headermenu[$i]['alt']	        = _MI_EDITO_UPDATE_MODULE;
	$headermenu[$i++]['link']	= "../../system/admin.php?fct=modulesadmin&op=update&module=" . $xoopsModule->getVar('dirname');

	$headermenu[$i]['title']	= '<img src="../assets/images/icon/help.gif" align="absmiddle" alt="'._MI_EDITO_HELP.'"/>';
	$headermenu[$i]['alt']	        = _MI_EDITO_HELP;
	$headermenu[$i++]['link']	= "help.php";
}

// Utilities
$i=0;
$statmenu[$i]['title'] = _MI_EDITO_UPLOAD;
$statmenu[$i++]['link'] = "admin/utils_uploader.php";
$statmenu[$i]['title'] = _MI_EDITO_CLONE;
$statmenu[$i++]['link'] = "admin/utils_clone.php";
$statmenu[$i]['title'] = _MI_EDITO_EXPORT;
$statmenu[$i++]['link'] = "admin/utils_export.php";
$statmenu[$i]['title'] = _MI_EDITO_IMPORT;
$statmenu[$i++]['link'] = "admin/utils_import.php";
$statmenu[$i]['title'] = _MI_EDITO_EDITORS;
$statmenu[$i++]['link'] = "admin/utils_wysiwyg.php";
$statmenu[$i]['title'] = _MI_EDITO_HTACCESS;
$statmenu[$i++]['link'] = "admin/utils_htaccess.php";
