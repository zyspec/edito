<?php declare(strict_types=1);
/**
 * XOOPS - PHP Content Management System
 * Copyright (c) 2004 <https://www.xoops.org>
 *
 * Module: edito 3.0
 * Licence : GPL
 * Authors :
 *           - solo (http://www.wolfpackclan.com/wolfactory)
 *			- DuGris (http://www.dugris.info)
 */

// Script used to display an edito's content, for example when it was too short
// on the main page
require_once __DIR__ . '/header.php';
$GLOBALS['xoopsOption']['template_main'] = 'edito_content_index.html';
require_once XOOPS_ROOT_PATH . '/header.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
}
// if (isset($_POST['id'])) $id = intval($_POST['id']);

if (!isset($id)) {
    redirect_header('index.php', 2, _MD_EDITO_PL_SELECT);
}

$sql = ' SELECT * FROM ' . $xoopsDB->prefix($xoopsModule->dirname() . '_content') . " WHERE id=$id AND status > 0";
$result = $xoopsDB->queryF($sql);

if (0 == $xoopsDB->getRowsNum($result)) {
    redirect_header('index.php', 2, _MD_EDITO_NOT_FOUND);

    exit();
}
$myrow = $xoopsDB->fetchArray($result);
if (is_object($xoopsUser) && $xoopsUser->isAdmin($xoopsModule->mid())) {
    $admin = 1;
} else {
    $admin = 0;
}
if (!$admin && 1 == $myrow['status']) {
    redirect_header('index.php', 2, _MD_EDITO_NOT_FOUND);

    exit();
}

$info = [];

$group = is_object($xoopsUser) ? $xoopsUser->getGroups() : [XOOPS_GROUP_ANONYMOUS];
$groups = explode(' ', $myrow['groups']);

if (count(array_intersect($group, $groups)) <= 0) {
    redirect_header('index.php', 2, _NOPERM);

    exit();
}

$info['status'] = $myrow['status'];

/* ----------------------------------------------------------------------- */
/*                              Retrieve options                           */
/* ----------------------------------------------------------------------- */
$media = explode('|', $myrow['media']);
$media_file = $media[0];
$media_url = $media[1];
$media_size = $media[2];

$meta = explode('|', $myrow['meta']);
$meta_title = $meta[0];
$meta_description = $meta[1];
$meta_keywords = $meta[2];
$meta_gen = $meta[3];

$option = explode('|', $myrow['options']);
$html = $option[0];
$xcode = $option[1];
$smiley = $option[2];
$logo = $option[3];
$block = $option[4];
$title = $option[5];
$cancomment = $option[6];

/* ----------------------------------------------------------------------- */
/*                              Display banner on pages                    */
/* ----------------------------------------------------------------------- */

// Module Banner
if (preg_match('/.swf/i', $xoopsModuleConfig['index_logo']) && $myrow['status'] >= 3) {
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
} elseif ($xoopsModuleConfig['index_logo'] && $myrow['status'] >= 3) {
    $banner = edito_createlink(XOOPS_URL . '/modules/' . $xoopsModule->dirname(), '', '', $xoopsModuleConfig['index_logo'], 'center', '800', '600', $xoopsModule->getVar('name') . ' ' . $xoopsModuleConfig['moduleMetaDescription'], $xoopsModuleConfig['url_rewriting']);
} else {
    $banner = '';
}
$xoopsTpl->assign('banner', $banner);

/* ----------------------------------------------------------------------- */
/*                              Render  variables                          */
/* ----------------------------------------------------------------------- */
$xoopsTpl->assign('list', _MD_EDITO_LIST);
$xoopsTpl->assign('index', _MD_EDITO_INDEX);
$xoopsTpl->assign('page', _MD_EDITO_PAGE);
$xoopsTpl->assign('footer', $myts->displayTarea($xoopsModuleConfig['footer'], 1));
// Content TagReplace
// require_once __DIR__ . '/include/tagreplace.php';
// $myrow["informations"] = edito_tagreplace($myrow["informations"]);

$logo_align = $xoopsModuleConfig['logo_align'];
$count = $myrow['counter'];
$alt_user = XoopsUser::getUnameFromId($myrow['uid']);
$user = '<a href="../../userinfo.php?uid=' . $myrow['uid'] . '">' . $alt_user . '</a>';
$datesub = formatTimestamp($myrow['datesub'], 'm') . ' ' . $user;
$image = $myrow['image'];
$subject = $myts->displayTarea($myrow['subject']);
$subject_org = $subject;
$info['title'] = $subject;

if ($meta_title) {
    $meta_title = $myts->displayTarea($meta_title);

    $subject = $meta_title;

    $alt_subject = strip_tags($meta_title);
} else {
    $alt_subject = strip_tags($subject);
}
$info['meta_title'] = $alt_subject;
$info['subject'] = $subject;
$info['displaytitle'] = $title;
$info['cancomment'] = $cancomment;
$info['displaylogo'] = $logo;

/* ----------------------------------------------------------------------- */
/*                              Render media files                         */
/* ----------------------------------------------------------------------- */
/*                              Check media file type                      */
/* ----------------------------------------------------------------------- */
if ($media_file) {
    require_once __DIR__ . '/include/functions_media.php';

    require_once __DIR__ . '/include/functions_mediasize.php';

    $media = XOOPS_URL . '/' . $xoopsModuleConfig['sbmediadir'] . '/' . $media_file;

    $media_display = edito_media_size($media_size, $xoopsModuleConfig['custom']);

    $format = edito_checkformat($media, $xoopsModuleConfig['custom_media']);

    $filesize = edito_fileweight($media, $xoopsModuleConfig['custom_media']);

    $fileinfo = '<img src="assets/images/icon/' . $format[1] . '.gif" alt="' . $format[1] . ': ' . $format[0] . ' [' . $filesize . '] [' . $media_file . ']">';
} elseif ($media_url) {
    require_once __DIR__ . '/include/functions_media.php';

    require_once __DIR__ . '/include/functions_mediasize.php';

    $media = $media_url;

    $media_display = edito_media_size($media_size, $xoopsModuleConfig['custom']);

    $format = edito_checkformat($media, $xoopsModuleConfig['custom_media']);

    $fileinfo = '|&nbsp;<img src="assets/images/icon/' . $format[1] . '.gif" alt="' . $format[1] . ': ' . $format[0] . ' [' . $media . ']">
				<img src="assets/images/icon/ext.gif" alt="' . _MD_EDITO_MEDIAURL . '">';
} else {
    $media = '';

    $fileinfo = '';
}

/* ----------------------------------------------------------------------- */
/*                              Check if file is downloadable              */
/* ----------------------------------------------------------------------- */
if ($media && ($xoopsModuleConfig['downloadable'] || (is_object($xoopsUser) && $xoopsUser->isAdmin($xoopsModule->mid())))) {
    /*
        $info['downloadable'] = ' <a onclick="pop=window.open(\'\', \'wclose\', \'width=100, height=100, dependent=yes, toolbar=no, scrollbars=no, status=no, resizable=no, fullscreen=no, titlebar=no, left=100, top=30\', \'false\'); pop.focus();"
                                         target="wclose"
                                         title="'._MD_EDITO_DOWNLOAD.'"
                                         href="'.$media.'">
                                  <img src="assets/images/icon/download.gif"
                                           alt="'._MD_EDITO_DOWNLOAD.'">
                                  </a>';
                                  */

    $info['downloadable'] = ' <a title="' . _MD_EDITO_DOWNLOAD . '"  target="_blank"
                                     href="download.php?id=' . $id . '">
	                          <img src="assets/images/icon/download.gif"
                                       alt="' . _MD_EDITO_DOWNLOAD . '">
	                          </a>';
} else {
    $info['downloadable'] = '';
}

/* ----------------------------------------------------------------------- */
/*                              Check alignement                           */
/* ----------------------------------------------------------------------- */

if ('center' == $logo_align) {
    $align = '';

    $align_in = '<div align="center">';

    $align_out = '</div>';
} else {
    $align = 'align="' . $logo_align . '"';

    $align_in = '';

    $align_out = '';
}

/* ----------------------------------------------------------------------- */
/*                              Render Media                               */
/* ----------------------------------------------------------------------- */
/*                              Media display in page only                 */
/* ----------------------------------------------------------------------- */

if ('page' == $xoopsModuleConfig['media_display'] and $media) {
    $align = ', align=' . $logo_align;

    $media_options = 'AutoStart=1, ShowControls=1, ShowTracker=1, AnimationAtStart=1, TransparentAtStart=0, enableContextMenu=0, BufferingProgress=1, PreBuffer=1, VideoDelay=999, VideoBufferSize=9, loop=' . $xoopsModuleConfig['repeat'] . $align;

    $media_size = edito_popup_size($media_size, '');

    $info['media'] = edito_media($media, $media, $media_display, $media_options, $myrow['subject'], $xoopsModuleConfig['custom_media']);

/* -----------------------------------------------------------------------  */
/*                       Media display in popup only                        */
/* -----------------------------------------------------------------------  */
} elseif ('popup' == $xoopsModuleConfig['media_display'] and $media) {
    $logo = XOOPS_URL . '/' . $xoopsModuleConfig['sbuploaddir'] . '/' . $image;

    if (!$image) {
        $logo = 'assets/images/media_video.gif';
    }

    $option = 'align=' . $logo_align;

    if ('image' == $format[1]) {
        $info['logo'] = $align_in . edito_media($media, $logo, '', $option, $myrow['subject'], $xoopsModuleConfig['custom_media']) . $align_out;
    } else {
        $popup_size = edito_popup_size($media_size, $xoopsModuleConfig['custom']);

        $info['logo'] = $align_in . ' <a onclick="window.open(\'\', \'wclose\', \'' . $popup_size . ', toolbar=no, scrollbars=yes, status=no, resizable=yes, fullscreen=no, titlebar=no, left=197, top=37\', \'false\')"
							href="popup.php?id=' . $id . ' " target="wclose">
							<img src="' . $logo . '" alt="' . $alt_subject . '" ' . $align . '><br>
							' . _MD_EDITO_SEE_MEDIA . '
							</a>' . $align_out;
    }

    $info['displaylogo'] = 1;

    $info['media'] = '';

/* ----------------------------------------------------------------------- */
/*                       Media display in page & popup                     */
/* ----------------------------------------------------------------------- */
} elseif ('both' == $xoopsModuleConfig['media_display'] and $media) {
    $align = ', align=' . $logo_align;

    $media_options = 'AutoStart=1, ShowControls=1, ShowTracker=1, AnimationAtStart=1, TransparentAtStart=0, enableContextMenu=0, BufferingProgress=1, PreBuffer=1, VideoDelay=999, VideoBufferSize=9, loop=' . $xoopsModuleConfig['repeat'] . $align;

    $logo = XOOPS_URL . '/' . $xoopsModuleConfig['sbuploaddir'] . '/' . $image;

    if (!$image) {
        $logo = 'assets/images/media_video.gif';
    }

    /*                       Media is an image                                */

    if ('image' == $format[1]) {
        $info['logo'] = $align_in . edito_media($media, $logo, '', '', $myrow['subject'], $xoopsModuleConfig['custom_media']) . $align_out;

        $logo = $media;

    /*                       Media is not an image                            */
    } else {
        $popup_size = edito_popup_size($media_size, $xoopsModuleConfig['custom']);

        $info['logo'] = $align_in . ' <a onclick="window.open(\'\', \'wclose\', \'' . $popup_size . ', toolbar=no, scrollbars=yes, status=no, resizable=yes, fullscreen=no, titlebar=no, left=197, top=37\', \'false\')"
						href="popup.php?id=' . $id . ' " target="wclose">
						<img src="' . $logo . '" alt="' . $alt_subject . '" ' . $align . '><br>
						' . _MD_EDITO_SEE_MEDIA . '
						</a>' . $align_out;

        $info['displaylogo'] = 1;
    }

    /*                       Generate media logo                            */

    if ('image' == $format[1]) {
        $info['media'] = $align_in . '<img src="' . $media . '" alt="' . $alt_subject . '">' . $align_out;
    } else {
        $info['media'] = edito_media($media, $logo, $media_display, $media_options, $myrow['subject'], $xoopsModuleConfig['custom_media']);
    }

    /* ----------------------------------------------------------------------- */
    /*                       No media to display                               */
    /* ----------------------------------------------------------------------- */
} else {
    /*                       Generate logo                                     */

    if ($image) {
        $logo = $xoopsModuleConfig['sbuploaddir'] . '/' . $image;

        $image_size = explode('|', $xoopsModuleConfig['logo_size']);

        $info['logo'] = edito_createlink('', '', '', $logo, $logo_align, '800', '600', $alt_subject, $xoopsModuleConfig['url_rewriting']);

    // Quoted line: change if you want to apply default size to logo on pages
        //   $info['logo'] = edito_createlink('', '', $logo, $logo_align, trim($image_size[0]), trim($image_size[1]), $alt_subject);

        /*                       No logo                                     */
    } else {
        $info['logo'] = '';
    }

    $info['media'] = '';
}

/* ----------------------------------------------------------------------- */
/*                              Render Text                                */
/* ----------------------------------------------------------------------- */
$alt_bodytext = strip_tags($myrow['body_text']);
$current_page = isset($_GET['page']) ? intval($_GET['page']) : 0;
$texte = edito_pagebreak($myrow['body_text'], '', $current_page, 'id=' . $id);

$pattern_media = [];
$pattern_media[] = "/\{media\}/sU";
$pattern_media[] = "/\{media align=(['\"]?)(left|center|right)\\1}/sU";

 if (preg_match('/{media/i', $texte)) {
     $texte = preg_replace($pattern_media, $info['media'], $texte);

     $info['media'] = '';
 }
//	$info['body_text']  = $myts->displayTarea($texte, $html, $smiley, $xcode);

$pattern_block = [];
$pattern_block[] = "/\{block\}/sU";
$pattern_block[] = "/\{block align=(['\"]?)(left|center|right)\\1}/sU";

if (preg_match('/{block/i', $texte) and $block) {
    $replacement_block = [];

    $block_text = $myts->displayarea($myrow['block_text'], $html, $smiley, $xcode);

    $replacement_block[] = $block_text;

    $replacement_block[] = '<table align="\\2" style="padding:3px; margin:6px; border:2px outset; width:33%;">
                  			<tr><td>' . $block_text . '</td></tr></table>';

    $texte = preg_replace($pattern_block, $replacement_block, $texte);

    $block_text = '';
} elseif ($block) {
    $block_text = $myts->displayTarea($myrow['block_text'], $html, $smiley, $xcode);
} else {
    $block_text = '';
}

if ('4' == $myrow['status']) {
    $info['body_text'] = $texte;  // Html mode
} elseif ('5' == $myrow['status']) {
    eval($texte);

    $info['body_text'] = '';
} else {
    $info['body_text'] = $myts->displayTarea($texte, $html, $smiley, $xcode);
}
$info['block_text'] = $block_text;

/* ----------------------------------------------------------------------- */
/*                          Render Footer links                            */
/* ----------------------------------------------------------------------- */
/*                             Page Status                                 */
/* ----------------------------------------------------------------------- */
// Admin Links
if (1 == $myrow['status']) {
    $status = "<img src='assets/images/icon/waiting.gif' alt='" . _MD_EDITO_WAITING . "' align='left'>";

    $online = 1;

    $path = "<a href='.'>" . $xoopsModule->getVar('name') . '</a> > ' . $subject_org;

    if ('none' != $xoopsModuleConfig['navlink_type']) {
        $xoopsTpl->assign('navlink', $path);

        $xoopsTpl->assign('navlink_type', $xoopsModuleConfig['navlink_type']);

        require_once __DIR__ . '/list.php';
    }
} elseif (3 == $myrow['status']) {
    $status = "<img src='assets/images/icon/online.gif' alt='" . _MD_EDITO_ONLINE . "' align='left'>";

    $online = 1;

    $path = "<a href='.'>" . $xoopsModule->getVar('name') . '</a> > ' . $subject_org;

    if ('none' != $xoopsModuleConfig['navlink_type']) {
        $xoopsTpl->assign('navlink', $path);

        $xoopsTpl->assign('navlink_type', $xoopsModuleConfig['navlink_type']);

        require_once __DIR__ . '/list.php';
    }
} elseif (4 == $myrow['status']) {
    $status = "<img src='assets/images/icon/html.gif' alt='" . _MD_EDITO_HTML . "' align='left'>";

    $online = 1;

    $xoopsTpl->assign('navlink', '');

    $xoopsTpl->assign('navlink_type', 'none');
} elseif (5 == $myrow['status']) {
    $status = "<img src='assets/images/icon/php.gif' alt='" . _MD_EDITO_PHP . "' align='left'>";

    $online = 1;

    $xoopsTpl->assign('navlink', '');

    $xoopsTpl->assign('navlink_type', 'none');
} else {
    $status = "<img src='assets/images/icon/hidden.gif' alt='" . _MD_EDITO_HIDDEN . "' align='left'>";

    $xoopsTpl->assign('navlink', '');

    $xoopsTpl->assign('navlink_type', 'none');

    $online = 0;

    $path = '';
}

/* ----------------------------------------------------------------------- */
/*                             Admin links                                 */
/* ----------------------------------------------------------------------- */
if (is_object($xoopsUser) && $xoopsUser->isAdmin($xoopsModule->mid()) and 5 != $myrow['status']) {
    $info['adminlink'] = $status . "<a href='admin/content.php?op=mod&id=$id' title='" . _MD_EDITO_EDIT . "'>
						 <img src='assets/images/icon/edit.gif' alt='" . _MD_EDITO_EDIT . "'></a> |
						 <a href='admin/content.php?op=dup&id=$id' title='" . _MD_EDITO_DUPLICATE . "'>
                         <img src='assets/images/icon/duplicate.gif' alt='" . _MD_EDITO_DUPLICATE . "'></a> |
                         <a href='admin/content.php?op=del&id=$id' title='" . _MD_EDITO_DELETE . "'>
                         <img src='assets/images/icon/delete.gif' alt='" . _MD_EDITO_DELETE . "'></a> |
                         <a href='print.php?id=$id' target='_blank' title='" . _MD_EDITO_PRINT . "'>
                         <img src='assets/images/icon/print.gif' alt='" . _MD_EDITO_PRINT . "'></a>";

    $info['infos'] = $datesub . '&nbsp;|&nbsp;(' . $count . ' ' . _READS . ')' . $fileinfo;

    $info['adminlinks'] = "<a href='admin/content.php' title='" . _MD_EDITO_ADD . "'>
                           <img src='assets/images/icon/add.gif' alt='" . _MD_EDITO_ADD . "'></a> |
                           <a href='admin/index.php' title='" . _MD_EDITO_LIST . "'>
                           <img src='assets/images/icon/list.gif' alt='" . _MD_EDITO_LIST . "'></a> |
                           <a href='admin/utils_uploader.php' title='" . _MD_EDITO_UTILITIES . "'>
                           <img src='assets/images/icon/utilities.gif' alt='" . _MD_EDITO_UTILITIES . "'></a> |
                           <a href='../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=" . $xoopsModule->getVar('mid') . "'  title='" . _MD_EDITO_SETTINGS . "'>
                           <img src='assets/images/icon/settings.gif' alt='" . _MD_EDITO_SETTINGS . "'></a> |
                           <a href='admin/myblocksadmin.php' title='" . _MD_EDITO_BLOCKS . "'>
                           <img src='assets/images/icon/blocks.gif' alt='" . _MD_EDITO_BLOCKS . "'></a> |
                           <a href='admin/help.php' title='" . _MD_EDITO_HELP . "'>
                           <img src='assets/images/icon/help.gif' alt='" . _MD_EDITO_HELP . "'></a></span>";
} elseif (is_object($xoopsUser) && $xoopsUser->isAdmin($xoopsModule->mid()) and 5 == $myrow['status']) {
    $info['adminlink'] = $status . "<a href='admin/content.php?op=mod&id=$id'>
    								<img src='assets/images/icon/edit.gif' alt='" . _MD_EDITO_EDIT . "'></a> |
                                    <a href='admin/content.php?op=dup&id=$id'>
                                    <img src='assets/images/icon/duplicate.gif' alt='" . _MD_EDITO_DUPLICATE . "'></a> |
                                    <a href='admin/content.php?op=del&id=$id'>
                                    <img src='assets/images/icon/delete.gif' alt='" . _MD_EDITO_DELETE . "'></a>";

    $info['infos'] = '';

    $info['adminlinks'] = '';
} elseif (5 != $myrow['status']) {
    $info['adminlink'] = "<a href='print.php?id=$id' target='_blank'>
    					  <img src='assets/images/icon/print.gif' alt='" . _MD_EDITO_PRINT . "'></a>";

    $info['infos'] = '';

    $info['adminlinks'] = '';
}

$xoopsTpl->assign('infos', $info);

/* ----------------------------------------------------------------------- */
/*                             Create Meta tags                            */
/* ----------------------------------------------------------------------- */

if ($online) {
    $metagen['title'] = $xoopsModule->getVar('name') . ' - ';
} else {
    $metagen['title'] = '';
}
// Metagen
    $metagen['title'] .= $meta_title;
    $metagen['description'] = $meta_description;
    if ('auto' == $xoopsModuleConfig['metamanager']) {
        $metagen['keywords'] = $meta_gen;
    } else {
        $metagen['keywords'] = $meta_keywords;
    }

$xoopsTpl->assign('xoops_pagetitle', $alt_subject);

// Assure compatibility with < Xoops 2.0.14
if ($metagen['description'] || 'manual' == $xoopsModuleConfig['metamanager']) {
    if (is_file(XOOPS_ROOT_PATH . '/class/theme.php')) {
        $xoTheme->addMeta('meta', 'description', $metagen['description']);
    } else {
        $xoopsTpl->assign('xoops_meta_description', $metagen['description']);
    }
}

if ($metagen['keywords'] || 'manual' == $xoopsModuleConfig['metamanager']) {
    if (is_file(XOOPS_ROOT_PATH . '/class/theme.php')) {
        $xoTheme->addMeta('meta', 'keywords', $metagen['keywords']);
    } else {
        $xoopsTpl->assign('xoops_meta_keywords', $metagen['keywords']);
    }
}

/* ----------------------------------------------------------------------- */
/*                             Page Counter                                */
/* ----------------------------------------------------------------------- */
if (!$xoopsUser || ($xoopsUser->isAdmin($xoopsModule->mid()) && 1 == $xoopsModuleConfig['adminhits'])) {
    $xoopsDB->queryF('UPDATE ' . $xoopsDB->prefix($xoopsModule->dirname() . '_content') . "
					  SET counter=counter+1 WHERE id = $id ");
}

/* ----------------------------------------------------------------------- */
/*                            Insert Comments                              */
/* ----------------------------------------------------------------------- */
if ($cancomment) {
    require_once XOOPS_ROOT_PATH . '/include/comment_view.php';
}

require_once XOOPS_ROOT_PATH . '/footer.php';
