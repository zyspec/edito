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

// Script used to display an edito's content, for example when it was too short
// on the main page
include_once("header.php");
$xoopsOption['template_main'] = 'edito_content_submit.html';
include_once(XOOPS_ROOT_PATH."/header.php");


$group = is_object($xoopsUser) ? $xoopsUser->getGroups() : array(XOOPS_GROUP_ANONYMOUS);
// $groups = explode(" ",$xoopsModuleConfig['submit_groups']);
if (count(array_intersect($group,$xoopsModuleConfig['submit_groups'])) <= 0) {
	redirect_header("index.php",2,_NOPERM);
}


if ( isset($_POST['subject']) && $_POST['subject'] != '') {
  $subject = $_POST['subject'];
  if ( isset($_POST['media'])   )      { $media = $_POST['media']; } else { $media = ''; }
  if ( isset($_POST['description']) )  { $description = $_POST['description']; } else { $description = ''; }

        $groups          = (is_array($xoopsModuleConfig['groups'])) ? implode(" ", $xoopsModuleConfig['groups']) : '';
	$html = 1;
	$xcode = 1;
	$smiley = 1;
        $logo = $xoopsModuleConfig['option_logo'];
	$block = $xoopsModuleConfig['option_block'];
	$title = $xoopsModuleConfig['option_title'];
 	$cancomment = $xoopsModuleConfig['cancomment'];
        $options = $html . '|' . $xcode . '|' . $smiley . '|' . $logo . '|' . $block . '|' . $title . '|' . $cancomment;
        $meta = '|||';
        $uid = $xoopsUser->uid();
        $datesub = time();
        $media = edito_function_checkurl($media);
        $media = '|' . $media . '|';

  		if ( $xoopsDB -> queryF( "INSERT INTO " . $xoopsDB -> prefix( "edito_content" ) .
                  " ( uid,
                      datesub,
                      status,
                      subject,
                      body_text,
                      media,
                      meta,
                      groups,
                      options
                       )
                        VALUES (
                            '$uid',
                            '$datesub',
                            '1',
                            '$subject',
                            '$description',
                            '$media',
                            '$meta',
                            '$groups',
                            '$options')" ) )
			{
				$redirect = _MD_EDITO_THANKS_SUBMIT;
			}
			else
			{
				$redirect = _MD_EDITO_THANKS_NOSUBMIT;
			}

	redirect_header('submit.php', 2, $redirect);
	exit();
}
/* ----------------------------------------------------------------------- */
/*                              Display banner on pages                    */
/* ----------------------------------------------------------------------- */

// Module Banner
if ( preg_match('/.swf/i', $xoopsModuleConfig['index_logo']) ) {
	$banner = '<object
			   classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
               codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/ swflash.cab#version=6,0,40,0" ;=""
               height="60"
               width="468">
               <param  name="movie"
               value="' . trim($xoopsModuleConfig['index_logo']) . '">
               <param name="quality" value="high">
               <embed src="' . trim($xoopsModuleConfig['index_logo']) . '"
               quality="high"
               pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" ;=""
               type="application/x-shockwave-flash"
               height="60"
               width="468">
               </object>';
} elseif ( $xoopsModuleConfig['index_logo'] ) {
	$banner = edito_createlink(XOOPS_URL.'/modules/'.$xoopsModule->dirname(), '', '', $xoopsModuleConfig['index_logo'], 'center', '800', '600', $xoopsModule -> getVar( 'name' ).' '. $xoopsModuleConfig['moduleMetaDescription'], $xoopsModuleConfig['url_rewriting']);
} else {
	$banner = '';
}
$xoopsTpl->assign("banner", $banner);

/* ----------------------------------------------------------------------- */
/*                              Render  variables                          */
/* ----------------------------------------------------------------------- */
$xoopsTpl->assign('submit',  _MD_EDITO_SUBMIT);
$xoopsTpl->assign('submitext',  _MD_EDITO_SUBMITEXT);
$xoopsTpl->assign('subject', _MD_EDITO_SUBJECT);
$xoopsTpl->assign('media',   _MD_EDITO_MEDIA);
$xoopsTpl->assign('text',    _MD_EDITO_TEXT);
$xoopsTpl->assign("footer",  $myts->displayTarea($xoopsModuleConfig['footer']));

/* ----------------------------------------------------------------------- */
/*                             Admin links                                 */
/* ----------------------------------------------------------------------- */
$adminlinks = ''; //init administration links
if ($xoopsUser && $xoopsUser->isAdmin($xoopsModule->mid())) {
	$adminlinks = "<a href='admin/content.php' title='"._MD_EDITO_ADD."'>
    			 <img src='assets/images/icon/add.gif' alt='"._MD_EDITO_ADD."' /></a> |
                 <a href='admin/index.php' title='"._MD_EDITO_LIST."'>
                 <img src='assets/images/icon/list.gif' alt='"._MD_EDITO_LIST."' /></a> |
                 <a href='admin/utils_uploader.php' title='"._MD_EDITO_UTILITIES."'>
                 <img src='assets/images/icon/utilities.gif' alt='"._MD_EDITO_UTILITIES."' /></a> |
                 <a href='../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=" . $xoopsModule->getVar('mid'). "' title='"._MD_EDITO_SETTINGS."'>
                 <img src='assets/images/icon/settings.gif' alt='"._MD_EDITO_SETTINGS."' /></a> |
                 <a href='admin/myblocksadmin.php' title='"._MD_EDITO_BLOCKS."'>
                 <img src='assets/images/icon/blocks.gif' alt='"._MD_EDITO_BLOCKS."' /></a> |
                 <a href='admin/help.php' title='"._MD_EDITO_HELP."'>
                 <img src='assets/images/icon/help.gif' alt='"._MD_EDITO_HELP."' /></a></span>";
}

$xoopsTpl->assign('adminlinks', $adminlinks);

require_once XOOPS_ROOT_PATH . '/footer.php';
