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

include_once(XOOPS_ROOT_PATH. "/modules/".$xoopsModule->dirname()."/include/functions_media.php");
include_once(XOOPS_ROOT_PATH. "/modules/".$xoopsModule->dirname()."/include/functions_mediasize.php");
include_once(XOOPS_ROOT_PATH. "/modules/".$xoopsModule->dirname()."/include/functions_block.php");

$sql=" SELECT * FROM ".$xoopsDB->prefix( 'content_'.$xoopsModule->dirname() )." WHERE id = $id AND status != 0 ";
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
$media_size     =  $media[2];

$meta = explode("|", $myrow["meta"]);
$meta_title       =  $meta[0];
$meta_description =  $meta[1];
$meta_keywords    =  $meta[2];

$option = explode("|", $myrow["options"]);
$html            =  $option[0];
$xcode           =  $option[1];
$smiley          =  $option[2];
$logo            =  $option[3];
$block           =  $option[4];
$title           =  $option[5];
$cancomment      =  $option[6];

// Display title
if ( $title ) {
	$subject = '<h3 style="color:#FFF;">'.$myts->displayTarea($myrow["subject"]).'</h3>';
} else {
	$subject = '';
}



// Media
$option .= 'AutoStart=1, ShowControls=1, ShowTracker=1, AnimationAtStart=1, TransparentAtStart=0, enableContextMenu=0, BufferingProgress=1, PreBuffer=1, VideoDelay=999, VideoBufferSize=9, align='. $xoopsModuleConfig['logo_align'];

if ( $xoopsModuleConfig['repeat'] ) {
	$option .= ', Loop=1';
}

// Image align
if ($xoopsModuleConfig['logo_align'] == "center") {
	$image_align = '';
	$align = '<div align="center">';
	$align02 = '</div>';
} else {
	$image_align = 'align="'. $xoopsModuleConfig['logo_align'].'"';
	$align = '';
	$align02 = '';
}

$media_display =  edito_media_size($media_size, $xoopsModuleConfig['custom']);
if ( $media_file ) {
	$media_url =  XOOPS_URL . '/'. $xoopsModuleConfig['sbmediadir'] .'/'. $media_file;
} 

$media_data = edito_media($media_url,'', $media_display, $option, $myrow["subject"], $xoopsModuleConfig['custom_media']);



if ($myrow["image"] AND $logo) {
	$logo = $align.'<img src="'.XOOPS_URL . '/'. $xoopsModuleConfig['sbuploaddir'] .'/'. $myrow['image'].'"
    				alt="'.$myrow['subject'].'" '.$image_align.' /><br />'.$align02;
} else {
	$logo = '';
}

/* ----------------------------------------------------------------------- */
/*                              Display Result                             */
/* ----------------------------------------------------------------------- */

echo "<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'>\n";
echo "<html>\n<head>\n";
echo "<meta http-equiv='Content-Type' content='text/html; charset=" . _CHARSET . "' />\n";
echo "<meta name='AUTHOR' content='" . $xoopsConfig ["sitename"] . "' />\n";
echo "<meta name='COPYRIGHT' content='Copyright (c) 2001 by " . $xoopsConfig ["sitename"] . "' />\n";
echo "<meta name='DESCRIPTION' content='" . $xoopsConfig ["slogan"] . "' />\n";
echo "<meta name='GENERATOR' content='" . XOOPS_VERSION . "' />\n";
echo "<title>" .strip_tags($myrow["subject"]). "</title>\n";
echo "</head>\n\n\n";
echo "<link rel='stylesheet' type='text/css' media='screen' href='../../xoops.css' />\n";
echo "<link rel='stylesheet' type='text/css' media='screen' href='../../themes/" . $xoopsConfig ["theme_set"] . "/styleNN.css' />\n";

echo '<body style="background-color:black;">';
echo '<div align="center">';
// echo $logo;
echo $subject;
echo $media_data.'</br>';
echo '<form action="0">
	  <input type="button" value="'._EDITO_CLOSE.'" onclick="self.close()">
      </form>';
echo '</div>';
echo '</body>';
?>