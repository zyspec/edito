<?php
// $Id: comment_new.php,v 1.1 2004/01/29 14:45:23 buennagel Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
include '../../mainfile.php';
$com_itemid = isset($_GET['com_itemid']) ? intval($_GET['com_itemid']) : 0;
if ($com_itemid > 0) {
  $myts =& MyTextSanitizer::getInstance();
  
$sql=" SELECT subject, uid, image, block_text, body_text, options, datesub FROM ".$xoopsDB->prefix("content_edito")." WHERE id=$com_itemid AND status > 0";
$result = $xoopsDB->queryF($sql);
$myrow 	= $xoopsDB->fetchArray($result);
$info = array();

$image = $myrow["image"];

$option = explode("|", $myrow["options"]);
$html            =  $option[0];
$xcode           =  $option[1];
$smiley          =  $option[2];
$logo            =  $option[3];
$block           =  $option[4];
$title           =  $option[5];
$cancomment      =  $option[6];

	if ( $image ) {
                include_once("include/functions_content.php");
		$logo =  $xoopsModuleConfig['sbuploaddir'] .'/'. $image;
		$image_size = explode('|', $xoopsModuleConfig['logo_size']);
		$logo = edito_createlink('', '', '', $logo, $xoopsModuleConfig['logo_align'], '800', '600', $myrow["subject"]);
	} else {
		$logo = '';
	}


$text = '';
if($block) { $text .= $myrow["block_text"]; }
$text .= $myrow["body_text"];

        $com_replytext = _POSTEDBY.'&nbsp;<b>'.XoopsUser::getUnameFromId($myrow['uid']).'</b>&nbsp;'._DATE.'&nbsp;<b>'.formatTimestamp($myrow["datesub"],'m').'</b><br /><br />'.$logo.$myts->makeTareaData4Show($text, $html, $smiley, $xcode);
        $com_replytitle = $myrow["subject"];

	include_once XOOPS_ROOT_PATH.'/include/comment_new.php';
}

?>