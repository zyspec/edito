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

include_once( '../../../mainfile.php');
include_once( '../../../include/cp_header.php');
include_once( '../../../include/functions.php');
include_once( XOOPS_ROOT_PATH . '/class/xoopsmodule.php');
include_once( XOOPS_ROOT_PATH . '/class/xoopsformloader.php' );
include_once( XOOPS_ROOT_PATH . '/class/module.errorhandler.php');
$eh = new ErrorHandler;
$myts =& MyTextSanitizer::getInstance();
include_once( XOOPS_ROOT_PATH .'/modules/'.$xoopsModule->getVar('dirname').'/include/functions_edito.php' );

if ( file_exists(XOOPS_ROOT_PATH . '/modules/'.$xoopsModule->getVar('dirname').'/language/' . $xoopsConfig['language'] . '/common.php') ) {
	include_once(XOOPS_ROOT_PATH . '/modules/'.$xoopsModule->getVar('dirname').'/language/' . $xoopsConfig['language'] . '/common.php');
	include_once(XOOPS_ROOT_PATH . '/modules/'.$xoopsModule->getVar('dirname').'/language/' . $xoopsConfig['language'] . '/modinfo.php');
} else {
	include_once(XOOPS_ROOT_PATH .'/modules/'.$xoopsModule->getVar('dirname').'/language/english/common.php');
	include_once(XOOPS_ROOT_PATH .'/modules/'.$xoopsModule->getVar('dirname').'/language/english/modinfo.php');
}

if ( basename($_SERVER["PHP_SELF"]) == 'index.php') {
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
?>