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

include_once( "admin_header.php" );
$myts =& MyTextSanitizer::getInstance();

//$guide = _MD_MYREFERER_GUIDE;
//$guide = $myts->makeTareaData4Show($guide);

edito_adminmenu(-1, _MD_EDITO_NAV_HELP);
OpenTable();
$helpfile = XOOPS_ROOT_PATH . '/modules/edito/language/' . $xoopsConfig['language'] . '/help.html';
if ( file_exists($helpfile) ) {
	include_once ( $helpfile );
} else {
	include_once ( XOOPS_ROOT_PATH . '/modules/edito/language/english/help.html' );
}

//echo $guide;
CloseTable();
include_once( 'admin_footer.php' );
?>