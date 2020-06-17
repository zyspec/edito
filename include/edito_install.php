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

if( !defined("EDITO_DIRNAME") ){
	define("EDITO_DIRNAME", 'edito');
}

if( !defined("EDITO_ROOT_PATH") ){
	define("EDITO_ROOT_PATH", XOOPS_ROOT_PATH . '/modules/' . EDITO_DIRNAME . '/');
}

if ( file_exists(XOOPS_ROOT_PATH . '/modules/xoopsinfo/include/mimetypes.php') ) {
	include_once( XOOPS_ROOT_PATH . '/modules/xoopsinfo/include/mimetypes.php');
	include_once( XOOPS_ROOT_PATH . '/class/uploader.php');
	if ( defined("_XI_MIMETYPE") ) {
		install_MimeTypes( 'edito' );
	}
}

edito_create_all_dir();

function edito_create_all_dir() {
	$img_edito = EDITO_ROOT_PATH . "images/edito_slogo.png";
	$img_source = EDITO_ROOT_PATH . "images/blank.gif";
	$ind_source = XOOPS_ROOT_PATH . "/uploads/index.html";

	$dest = edito_create_dir();
    if ($dest) {
        $ind_dest = $dest . "index.html";
		edito_copyr($ind_source, $ind_dest);
    }

	$dest = edito_create_dir("images");
    if ($dest) {
		$img_dest = $dest . "blank.gif";
        $ind_dest = $dest . "index.html";
		$edito_dest = $dest . "content_slogo.png";
		edito_copyr($img_source, $img_dest);
		edito_copyr($ind_source, $ind_dest);
		edito_copyr($img_edito , $edito_dest);
    }

	$dest = edito_create_dir("media");
    if ($dest) {
        $ind_dest = $dest . "index.html";
		edito_copyr($ind_source, $ind_dest);
    }

}
function edito_create_dir( $directory = "" )
{
	$thePath = XOOPS_ROOT_PATH . "/uploads/edito/";
    if ($directory != "") {
	$thePath .= $directory . "/";
    }

	if(@is_writable($thePath)){
		edito_admin_chmod($thePath, $mode = 0777);
        return $thePath;
	} elseif(!@is_dir($thePath)) {
    	edito_admin_mkdir($thePath);
        return $thePath;
	}
    return 0;
}

/**
* Thanks to the NewBB2 Development Team
*/
function edito_admin_mkdir($target)
{
	// http://www.php.net/manual/en/function.mkdir.php
	// saint at corenova.com
	// bart at cdasites dot com
	if (is_dir($target) || empty($target)) {
		return true; // best case check first
	}

	if (file_exists($target) && !is_dir($target)) {
		return false;
	}

	if (edito_admin_mkdir(substr($target,0,strrpos($target,'/')))) {
		if (!file_exists($target)) {
			$res = mkdir($target, 0777); // crawl back up & create dir tree
			edito_admin_chmod($target);
	  	    return $res;
	  }
	}
    $res = is_dir($target);
	return $res;
}

/**
* Thanks to the NewBB2 Development Team
*/
function edito_admin_chmod($target, $mode = 0777)
{
	return @chmod($target, $mode);
}

/**
 * Copy a file, or a folder and its contents
 *
 * @author      Aidan Lister <aidan@php.net>
 * @version     1.0.0
 * @param       string   $source    The source
 * @param       string   $dest      The destination
 * @return      bool     Returns true on success, false on failure
 */
function edito_copyr($source, $dest)
{
    // Simple copy for a file
    if (is_file($source)) {
        return copy($source, $dest);
    }

    // Make destination directory
    if (!is_dir($dest)) {
        mkdir($dest);
    }

    // Loop through the folder
    $dir = dir($source);
    while (false !== $entry = $dir->read()) {
        // Skip pointers
        if ($entry == '.' || $entry == '..') {
            continue;
        }

        // Deep copy directories
        if (is_dir("$source/$entry") && ($dest !== "$source/$entry")) {
            copyr("$source/$entry", "$dest/$entry");
        } else {
            copy("$source/$entry", "$dest/$entry");
        }
    }

    // Clean up
    $dir->close();
    return true;
}
?>