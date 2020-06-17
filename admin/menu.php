<?php
/**
* XOOPS - PHP Content Management System
* Copyright (c) 2004 <http://www.xoops.org/>
*
* Module: edito 3.0
* Licence : GPL
* Authors :
*           - solo (http://www.wolfpackclan.com/wolfactory)
*			- DuGris (http://www.dugris.info)
*/

if (!isset($_POST["id"])) {
	$id = isset($_GET["id"]) ? $_GET["id"] : "";
} else {
	$id = $_POST["id"];
}
if (!isset($_POST["op"])) {
	$op = isset($_GET["op"]) ? $_GET["op"] : "";
} else {
	$op = $_POST["op"];
}
$i=0;

 if ( ereg('_ok', $op) ) {
	$adminmenu[$i]['title']		= _MI_EDITO_GOTO_INDEX;
	$adminmenu[$i++]['link']	= "index.php";
}
$adminmenu[$i]['title']	    = _MI_EDITO_LIST;
$adminmenu[$i++]['link']    = "admin/index.php";
$adminmenu[$i]['title']     = _MI_EDITO_CREATE;
$adminmenu[$i++]['link']    = "admin/content.php";

if ( $id ) {
	$adminmenu[$i]['title'] 	= _MI_EDITO_SEE;
	$adminmenu[$i++]['link'] 	= "content.php?id=".$id;
}

$adminmenu[$i]['title']		= _MI_EDITO_UTILITIES;
$adminmenu[$i++]['link']	= "admin/utils_uploader.php";

$adminmenu[$i]['title']		= _MI_EDITO_BLOCKS_GRPS;
$adminmenu[$i++]['link']	= "admin/blocks.php";

$hModule = &xoops_gethandler('module');

include_once( XOOPS_ROOT_PATH . '/class/uploader.php');
if ( defined("_XI_MIMETYPE") ) {
	$adminmenu[$i]['title'] = _MI_EDITO_MIMETYPES;
	$adminmenu[$i++]['link'] = "admin/mimetypes.php";
}

if (isset($xoopsModule)) {
  	$i=0;
  	$headermenu[$i]['title']	= '<img src="../images/icon/home.gif" align="absmiddle" alt="'._MI_EDITO_GOTO_INDEX.'"/>';
  	$headermenu[$i]['alt']	        = _MI_EDITO_GOTO_INDEX;
	$headermenu[$i++]['link']	= '../';

	$headermenu[$i]['title']	= '<img src="../images/icon/submit.gif" align="absmiddle" alt="'._MI_EDITO_SUBMIT.'"/>';
	$headermenu[$i]['alt']	        = _MI_EDITO_SUBMIT;
	$headermenu[$i++]['link']	= "../submit.php";

	$headermenu[$i]['title']	= '<img src="../images/icon/settings.gif" align="absmiddle" alt="'._MI_EDITO_SETTINGS.'"/>';
	$headermenu[$i]['alt']	        = _MI_EDITO_SETTINGS;
	$headermenu[$i++]['link']	= '../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=' . $xoopsModule->getVar('mid');

	$headermenu[$i]['title']	= '<img src="../images/icon/update.gif" align="absmiddle" alt="'._MI_EDITO_UPDATE_MODULE.'"/>';
	$headermenu[$i]['alt']	        = _MI_EDITO_UPDATE_MODULE;
	$headermenu[$i++]['link']	= "../../system/admin.php?fct=modulesadmin&op=update&module=" . $xoopsModule->getVar('dirname');

	$headermenu[$i]['title']	= '<img src="../images/icon/help.gif" align="absmiddle" alt="'._MI_EDITO_HELP.'"/>';
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
?>