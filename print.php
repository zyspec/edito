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

// Script used to print an edito's content
include '../../mainfile.php';

if (isset($_GET ["id"])) $id = intval($_GET ["id"]);
if (isset($_POST ["id"])) $id = intval($_POST ["id"]);

if(!isset($id)) {
	redirect_header('index.php', 2, _EDITO_PL_SELECT);
	exit();
}

$myts =& MyTextSanitizer::getInstance();

/* ----------------------------------------------------------------------- */
/*                              Render Query                               */
/* ----------------------------------------------------------------------- */

$sql = "SELECT uid, groups, options, block_text, body_text, image, subject, datesub
		FROM ".$xoopsDB->prefix("content_" . $xoopsModule->dirname())."
        WHERE id=$id AND status > 0 AND status < 4";

$result=$xoopsDB->queryF($sql);

if($xoopsDB->getRowsNum($result)<=0) {		// Edito can't be found
	redirect_header("index.php",2,_EDITO_NOT_FOUND);
	exit();
}

$myrow 	= $xoopsDB->fetchArray($result);

/* ----------------------------------------------------------------------- */
/*                              Check group permission                     */
/* ----------------------------------------------------------------------- */
$group = is_object($xoopsUser) ? $xoopsUser->getGroups() : array(XOOPS_GROUP_ANONYMOUS);
$groups = explode(" ",$myrow["groups"]);
if (count(array_intersect($group,$groups)) <= 0) {
	redirect_header("index.php",2,_NOPERM);
	exit();
}

/* ----------------------------------------------------------------------- */
/*                              Create Datas                               */
/* ----------------------------------------------------------------------- */
$option = explode("|", $myrow["options"]);
$html  =  $option[0];
$xcode =  $option[1];
$smiley=  $option[2];
$logo  =  $option[3];
$block =  $option[4];
$title =  $option[5];
$cancomment      =  $option[6];

/*
if ( $xoopsModuleConfig["index_logo"] ) {
$banner = '<img src="'.$xoopsModuleConfig ["index_logo"].'" alt="'.$xoopsModule -> getVar( 'name' ).'">'; } else {
$banner = '';}
*/

$subject  = $myts->displayTarea($myrow["subject"]);
$username = XoopsUser::getUnameFromId($myrow["uid"]);
$date = formatTimestamp($myrow["datesub"],"m");

/* ----------------------------------------------------------------------- */
/*                              Create Logo                                */
/* ----------------------------------------------------------------------- */

if ($xoopsModuleConfig ["logo_align"] != "center" && $myrow["image"] && $logo ) {
	$logo_align  = "align='".$xoopsModuleConfig ["logo_align"]."'";
	$logo  =  "<img src='".XOOPS_URL ."/".$xoopsModuleConfig ["sbuploaddir"]."/".$myrow["image"]."' ".$logo_align ." />";
} elseif ($xoopsModuleConfig ["logo_align"] == "center" && $myrow["image"] && $logo) {
	$logo  =  "<div align='center'><img src='".XOOPS_URL ."/".$xoopsModuleConfig ["sbuploaddir"]."/".$myrow["image"]."' /></div>";
}else {
	$logo = "";
}

/* ----------------------------------------------------------------------- */
/*                              Create Text                                */
/* ----------------------------------------------------------------------- */
$bodytext = '';
if ( $block ) { $bodytext .= $myrow["block_text"]; }

$bodytext .= str_replace('[pagebreak]', '', $myrow["body_text"]);
$bodytext =  $myts->makeTareaData4Show($bodytext, $html, $smiley, $xcode);

/* ----------------------------------------------------------------------- */
/*                              Display Result                             */
/* ----------------------------------------------------------------------- */

echo "<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'>\n";
echo "<html>\n<head>\n";
echo "<title>" ._EDITO_COMEFROM. " " . $xoopsConfig ["sitename"] . "</title>\n";
echo "<meta http-equiv='Content-Type' content='text/html; charset=" . _CHARSET . "' />\n";
echo "<meta name='AUTHOR' content='" . $xoopsConfig ["sitename"] . "' />\n";
echo "<meta name='COPYRIGHT' content='Copyright (c) 2001 by " . $xoopsConfig ["sitename"] . "' />\n";
echo "<meta name='DESCRIPTION' content='" . $xoopsConfig ["slogan"] . "' />\n";
echo "<meta name='GENERATOR' content='" . XOOPS_VERSION . "' />\n";
echo "</head>\n\n\n";

echo "<body bgcolor='#ffffff' text='#000000' onload='window.print()'>
	  <div style='width: 650px; border: 1px solid #000; padding: 20px; text-align: left; display: block; margin: 0 0 6px 0;'>
      ".$logo ."
      <div align='center'><h3>".$subject."</h3></div>
      <div>".$bodytext ."</div>
      <div style='padding-top: 12px; border-bottom: 2px solid #ccc;'></div>
      <div style='text-align:center;'>
      <font size='1'>
      "._EDITO_COMEFROM.$xoopsConfig ["sitename"] ." : ".XOOPS_URL."/modules/".$xoopsModule->dirname()."/content.php?id=".$id."<br />
      ".$username." ".$date."
      </font></div>
      </div>";
echo "</body>
     </html>";
?>