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

if ( file_exists(XOOPS_ROOT_PATH . '/modules/xoopsinfo/include/mimetypes.php') ) {
	include_once( XOOPS_ROOT_PATH . '/modules/xoopsinfo/include/mimetypes.php');
	include_once( XOOPS_ROOT_PATH . '/class/uploader.php');
	if ( defined("_XI_MIMETYPE") ) {
		uninstall_MimeTypes( 'edito' );
	}
}
?>