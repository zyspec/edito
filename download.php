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


// Script used to display a media in a pop up

include_once("header.php");

if (isset($_GET['id'])) $id = intval($_GET['id']);
if (isset($_POST['id'])) $id = intval($_POST['id']);

if(!isset($id)) {
	redirect_header('index.php', 2, _EDITO_PL_SELECT);
	exit();
}

$sql=" SELECT media, groups FROM ".$xoopsDB->prefix( 'content_'.$xoopsModule->dirname() )." WHERE id = $id AND status != 0 ";
$result = $xoopsDB->queryF($sql);

// Does edito exist?
if( $xoopsDB->getRowsNum( $result )<=0 )  {		// edito can't be found
	redirect_header("index.php",2,_EDITO_NOT_FOUND);
	exit();
}

$myrow 	= $xoopsDB->fetchArray($result);
$info = array();

// Groups permission
$group = is_object($xoopsUser) ? $xoopsUser->getGroups() : array(XOOPS_GROUP_ANONYMOUS);
$groups = explode(" ",$myrow["groups"]);
if (count(array_intersect($group,$groups)) <= 0) {
	redirect_header("index.php",2,_NOPERM);
	exit();
}

// Retrieve options data
$media = explode("|", $myrow["media"]);
$media_file     =  $media[0];
$media_url      =  $media[1];

if ( $media_file ) {
	$media_url =  XOOPS_URL . '/'. $xoopsModuleConfig['sbmediadir'] .'/'. $media_file;
}


// Image align

/* ----------------------------------------------------------------------- */
/*                              Download media                             */
/* ----------------------------------------------------------------------- */

   header('Pragma: anytextexeptno-cache', true);
   header('Content-type: application/force-download');
   header('Content-Transfer-Encoding: Binary');
   header('Content-length: '.filesize($media_url));
   header('Content-disposition: attachment;
   filename='.basename($media_url));
   readfile($file);

?>