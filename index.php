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


// This script is used to display the page list
include_once("header.php");

/* ----------------------------------------------------------------------- */
/*                              Select template                            */
/* ----------------------------------------------------------------------- */
if ($xoopsModuleConfig['index_display'] == 'table') {
	$xoopsOption['template_main'] = 'edito_index_ext.html';
	$align = 'center';
} elseif ( $xoopsModuleConfig['index_display'] == 'image') {
	$xoopsOption['template_main'] = 'edito_index.html';
	$align = 'center';
} elseif ( $xoopsModuleConfig['index_display'] == 'news') {
	$xoopsOption['template_main'] = 'edito_index_news.html';
	$align = 'left';
} elseif ( $xoopsModuleConfig['index_display'] == 'blog') {
	$xoopsOption['template_main'] = 'edito_index_blog.html';
	$align = 'left';
}
include_once(XOOPS_ROOT_PATH."/header.php");
$startart = isset( $_GET['startart'] ) ? intval( $_GET['startart'] ) : 0;

/* ----------------------------------------------------------------------- */
/*                    Redirect index to a specific page                    */
/* ----------------------------------------------------------------------- */
if ($xoopsModuleConfig['index_content']) {
	if ((eregi("http://", $xoopsModuleConfig['index_content'])) || (eregi("https://", $xoopsModuleConfig['index_content']))) {
		header ("location: ".$xoopsModuleConfig['index_content']);
		exit();
	} else {
		$sql = "SELECT COUNT(*) FROM " . $xoopsDB->prefix("content_" . $xoopsModule->dirname())."
				WHERE id=".$xoopsModuleConfig['index_content']." AND status=2";

        $result = $xoopsDB -> queryF( $sql );
        list( $numrows )=$xoopsDB->fetchRow($result);
        if ( $numrows ) {
		//	header ("location: content.php?id=".$xoopsModuleConfig['index_content']);
			header("location: http://www.example.com");
			exit();
		}
	}
}

/* ----------------------------------------------------------------------- */
/*                              Render templates variables                 */
/* ----------------------------------------------------------------------- */
/*                              Language variables                         */
/* ----------------------------------------------------------------------- */
$xoopsTpl->assign("module_name", $xoopsModule -> getVar( 'name' ));
$xoopsTpl->assign("textindex", $myts->makeTareaData4Show($xoopsModuleConfig['textindex']));
$xoopsTpl->assign("lang_page", _EDITO_PAGE);
$xoopsTpl->assign("footer", $myts->makeTareaData4Show($xoopsModuleConfig['footer']));
$xoopsTpl->assign("lang_num", _EDITO_NUM);
$xoopsTpl->assign("lang_read", _READS);
$xoopsTpl->assign("lang_image", _EDITO_IMAGE);
$xoopsTpl->assign("lang_subject", _EDITO_SUBJECT);
$xoopsTpl->assign("lang_info", _EDITO_INFOS);
$xoopsTpl->assign("lang_block_texte", _EDITO_BLOCK_TEXTE);

/* ----------------------------------------------------------------------- */
/*                              Generate banner                            */
/* ----------------------------------------------------------------------- */
// Module Banner
if ( eregi('.swf', $xoopsModuleConfig['index_logo']) ) {
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
	$banner = edito_createlink('','', '', $xoopsModuleConfig['index_logo'], 'center', '800', '600', $xoopsModule -> getVar( 'name' ).' '. $xoopsModuleConfig['moduleMetaDescription'], $xoopsModuleConfig['url_rewriting']);
} else {
	$banner = '';
}

$xoopsTpl->assign("banner", $banner);

/* ----------------------------------------------------------------------- */
/*                            Create admin links                           */
/* ----------------------------------------------------------------------- */

if ( $xoopsUser && $xoopsUser->isAdmin($xoopsModule->mid()) ) {
	$adminlink = "<a href='admin/content.php' title='"._EDITO_ADD."'>
    			 <img src='images/icon/add.gif' alt='"._EDITO_ADD."' /></a> |
                 <a href='admin/index.php' title='"._EDITO_LIST."'>
                 <img src='images/icon/list.gif' alt='"._EDITO_LIST."' /></a> |
                 <a href='admin/utils_uploader.php' title='"._EDITO_UTILITIES."'>
                 <img src='images/icon/utilities.gif' alt='"._EDITO_UTILITIES."' /></a> |
                 <a href='../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=" . $xoopsModule->getVar('mid'). "' title='"._EDITO_SETTINGS."'>
                 <img src='images/icon/settings.gif' alt='"._EDITO_SETTINGS."' /></a> |
                 <a href='admin/myblocksadmin.php' title='"._EDITO_BLOCKS."'>
                 <img src='images/icon/blocks.gif' alt='"._EDITO_BLOCKS."' /></a> |
                 <a href='admin/help.php' title='"._EDITO_HELP."'>
                 <img src='images/icon/help.gif' alt='"._EDITO_HELP."' /></a></span>";
}else{
	$adminlink = '';
}
$xoopsTpl->assign("adminlink", $adminlink);

/* ----------------------------------------------------------------------- */
/*                              Define columns settings                    */
/* ----------------------------------------------------------------------- */
$xoopsTpl->assign("columns", $xoopsModuleConfig['columns']);
$xoopsTpl->assign("width", number_format(100/$xoopsModuleConfig['columns'], 2, '.', ' ') );

/* ----------------------------------------------------------------------- */
/*                              Count number of available pages            */
/* ----------------------------------------------------------------------- */
$result = $xoopsDB -> queryF( "SELECT COUNT(*) FROM " . $xoopsDB->prefix("content_" . $xoopsModule->dirname())." WHERE status>2");
list( $numrows )=$xoopsDB->fetchRow($result);

$count = $startart;
$time = time();
$startdate = (time()-(86400 * $xoopsModuleConfig['tags_new']));
$count++;
$subjects = '';

if ($numrows > 0) {	// That is, if there ARE editos in the system
	/* ----------------------------------------------------------------------- */
	/*                            Generate page navigation                     */
	/* ----------------------------------------------------------------------- */
	$pagenav = new XoopsPageNav( $numrows, $xoopsModuleConfig['perpage'], $startart, 'startart', '' );
	$xoopsTpl->assign('pagenav', $pagenav->renderImageNav());
	$group = is_object($xoopsUser) ? $xoopsUser->getGroups() : array(XOOPS_GROUP_ANONYMOUS);

    /* ----------------------------------------------------------------------- */
    /*                              Create query                               */
    /* ----------------------------------------------------------------------- */
	$sql = "SELECT id, uid, datesub, counter, subject,  block_text, body_text, image, media, meta, groups, options
    		FROM ".$xoopsDB->prefix("content_" . $xoopsModule->dirname())." WHERE status>2 ORDER BY ".$xoopsModuleConfig['order'];

	$result = $xoopsDB->queryF($sql, $xoopsModuleConfig['perpage'], $startart );
	while(list( $id, $uid, $datesub, $counter, $subject, $block_text, $body_text, $image, $media, $meta, $groups, $options) = $xoopsDB->fetchRow($result)) {
		/* ----------------------------------------------------------------------- */
		/*                              Check group access                         */
		/* ----------------------------------------------------------------------- */
		$groups = explode(" ",$groups);    
		if (count(array_intersect($group,$groups)) > 0) {
			$info = array();

			/* ----------------------------------------------------------------------- */
			/*                            Display icons                                */
			/* ----------------------------------------------------------------------- */
            $fileinfo = '';
            $alt_user = XoopsUser::getUnameFromId($uid);
            $user     = '<a href="../userinfo.php?uid='.$uid.'">'.$alt_user.'</a>';
            $alt_date = formatTimestamp($datesub,'m');

            				/* ----------------------------------------------------------------------- */
				/*                              Retrieve options                           */
				/* ----------------------------------------------------------------------- */
                $media = explode("|", $media);
                $media_file     =  $media[0];
                $media_url      =  $media[1];
                $media_size     =  $media[2];
                
                $meta = explode("|", $meta);
                $meta_title       =  $meta[0];

                $option = explode("|", $options);
                $html            = $option[0];
                $xcode           = $option[1];
                $smiley          = $option[2];
                $logo            = $option[3];
                $block           = $option[4];
                $title           = $option[5];
                $cancomment      = $option[6];
                

			if ( $xoopsModuleConfig['tags'] ){
            	if ( $startdate < $datesub ) {
					$datesub = formatTimestamp($datesub,'m');
					$fileinfo  .= '&nbsp;<img src="images/icon/new.gif" alt="'.$alt_date.'" />';
        		}

                if ($counter >= $xoopsModuleConfig['tags_pop']) {
					$fileinfo .= '&nbsp;<img src="images/icon/pop.gif" alt="'.$counter.'&nbsp;'._READS.'" />';
        		}

				if ( $xoopsModuleConfig['index_display'] == 'table' OR $xoopsModuleConfig['index_display'] == 'news') {
					/* ----------------------------------------------------------------------- */
					/*                              Check media file type                      */
					/* ----------------------------------------------------------------------- */
					if ( $media_file ) {
						include_once ("include/functions_mediasize.php");
						$media    =  XOOPS_URL . '/'. $xoopsModuleConfig['sbmediadir'] .'/'. $media_file;
                                                $format   = edito_checkformat( $media, $xoopsModuleConfig['custom_media'] );
                                                $filesize = edito_fileweight( $media );
                                                $fileinfo .= ' <img src="images/icon/'.$format[1].'.gif" alt="'.$format[1].': '.$format[0].' ['.$filesize.'] ['.$media_file.']" />
 				     ';
					} elseif ( $media_url ) {
						include_once ("include/functions_mediasize.php");
						$media    =  $media_url;
						$format   = edito_checkformat( $media, $xoopsModuleConfig['custom_media'] );
						$fileinfo .= ' <img 
                                                                    src="images/icon/'.$format[1].'.gif" 
                                                                    alt="'.$format[1].': '.$format[0].' ['.$media.']" />
                        			   <img src="images/icon/ext.gif" alt="'._EDITO_MEDIAURL.'"/>';
            		}

            		if ( $media_file || $media_url ) {
			$popup_size = edito_popup_size($media_size, $xoopsModuleConfig['custom']);
			$info['popup'] = '<a onclick="window.open(\'\', \'wclose\', \''.$popup_size.', toolbar=no, scrollbars=yes, status=no, resizable=yes, fullscreen=no, titlebar=no, left=197, top=37\', \'false\')"
							href="popup.php?id=' . $id . ' " target="wclose">
							'._EDITO_SEE_MEDIA.'
							</a> | ';
                         }
				}

				if ( $xoopsModuleConfig['index_display'] == 'image') {
					$fileinfo = $fileinfo;
				} elseif ( $xoopsModuleConfig['index_display'] == 'news' ) {
					$fileinfo = $alt_date .' '. $fileinfo .' '. $user;
				} else {
					$fileinfo = $alt_date .'<br />'. $fileinfo .' '. $user;
				}
			}

			$info['info']= $fileinfo;

			/* ----------------------------------------------------------------------- */
			/*                            Create admin links                           */
			/* ----------------------------------------------------------------------- */
            if ( $xoopsUser && $xoopsUser->isAdmin($xoopsModule->mid()) ) {
            	$adminlinks = "<a href='admin/content.php?op=mod&id=".$id."' title='"._EDITO_EDIT."'>
       			      <img src='images/icon/edit.gif' alt='"._EDITO_EDIT."' /></a> |
                              <a href='admin/content.php?op=del&id=".$id."' title='"._EDITO_DELETE."'>
                              <img src='images/icon/delete.gif' alt='"._EDITO_DELETE."' /></a> |
                              <a href='print.php?id=".$id."' target='_blank'  title='"._EDITO_PRINT."'/>
                              <img src='images/icon/print.gif' alt='"._EDITO_PRINT."' /></a>";
			} else {
				$adminlinks = '';
   			}

            /* ----------------------------------------------------------------------- */
			/*                            Display logo                                 */
            /* ----------------------------------------------------------------------- */
            $link           =  'content.php?id='.$id;
            $subject        = $myts->makeTareaData4Show($subject);
//            $alt_subject    = $subjects.' '.$subject;
            if ($xoopsModuleConfig['index_display'] != 'table') { $image_subject = $subject; }
			if ( $image ){
            	$logo =  XOOPS_URL . '/'. $xoopsModuleConfig['sbuploaddir'] .'/'. $image;
                $image_size = explode('|', $xoopsModuleConfig['logo_size']);
                $info['logo'] = edito_createlink($link, $subject, '', $logo, $align, $image_size[0], $image_size[1], $meta_title, $xoopsModuleConfig['url_rewriting']);
			} else {
            	$info['logo'] = '';
            }

			/* ----------------------------------------------------------------------- */
			/*                            Check comments options                       */
			/* ----------------------------------------------------------------------- */
			$comment_link = '';
		if ( $cancomment && $xoopsModuleConfig['com_rule'] >= 1 ){
                $comments = $xoopsDB->query("SELECT COUNT(*) FROM ".$xoopsDB->prefix("xoopscomments")." WHERE com_status=2 AND com_modid=" . $xoopsModule->mid() . " AND com_itemid=".$id);
                $numb = $xoopsDB->fetchRow($comments);
                if($numb[0] >= 1) { $comments = $numb[0] .' '. _COMMENTS; } else { $comments = _NOCOMMENTS; }
            	$comment_link = edito_createlink($link, ' | ' . $comments, '', '', '', '', '', $meta_title, $xoopsModuleConfig['url_rewriting']).' | ';
               }


			/* ----------------------------------------------------------------------- */
			/*                            Generate pages variables                     */
			/* ----------------------------------------------------------------------- */

            if ($xoopsModuleConfig['index_display'] == 'blog') {
            	$body_test = $body_text;
                $body_text      = edito_pagebreak( $body_text, '', 0, $link );
                if ( $body_text != $body_test ) { $readmore_on = 1; } else { $readmore_on = 0; }
                	$body_text      = $myts->makeTareaData4Show($body_text, $html, $smiley, $xcode);
             } else {
                	$body_text     = '';
             }

            if ($xoopsModuleConfig['index_display'] != 'blog' || $readmore_on ) {
                	$readmore    = edito_createlink($link, _EDITO_READMORE, '', '', '', '', '', $meta_title, $xoopsModuleConfig['url_rewriting']);
            } else {
                	$readmore = '';
            }

            if ($xoopsModuleConfig['index_display'] != 'image') {
                	$block_text     = $myts->makeTareaData4Show($block_text, $html, $smiley, $xcode);
            } else {
                	$block_text     = '';
            }
                
                $info['subject']     = edito_createlink($link, $subject, '', '', '', '', '', $meta_title, $xoopsModuleConfig['url_rewriting']);
                $info['alt_subject'] = $meta_title;
                $info['readmore']    = $readmore;
                $info['comment']     = $comment_link;
                $info['tag']         = $fileinfo;
                $info['count']       = $count++;
                $info['counter']     = $counter;
                $info['block_text']  = $block_text;
                $info['body_text']   = $body_text;
                $info['adminlinks']  = $adminlinks;

                $xoopsTpl->append('infos', $info);
                unset($info);
			} // Groups
		} // While
}// Numrows

/* ----------------------------------------------------------------------- */
/*                             Create Meta tags                            */
/* createMetaTags(
/* 		Page title,				// Current page title
/* 		Page texte, 			// Page content which will be used to generate keywords
/* 		Default Meta Keywords,	// The default current module meta keywords - if any
/* 		Page Meta Keywords,		// The default current page meta keywords - if any
/* 		Meta Description,		// The current page meta description
/* 		Page Status (0 / 1),	// Is the current page online of offline?
/* 		Min keyword caracters,	// Minimu size a words must have to be considered
/* 		Min keyword occurence,	// How many time a word must appear to be considered
/* 		Max keyword occurence)	// Maximum time a word must appear to be considered
/* ----------------------------------------------------------------------- */
/*
edito_createMetaTags($xoopsModuleConfig['moduleMetaDescription'], $xoopsModuleConfig['textindex'], $xoopsModuleConfig['moduleMetaKeywords'], '', $xoopsModuleConfig['moduleMetaDescription'], 1, 2, 1, 9);
*/

$metagen['title'] = $xoopsModule -> getVar( 'name' );
if ( $xoopsModuleConfig['moduleMetaDescription'] ) {
	$metagen['description'] = $xoopsModuleConfig['moduleMetaDescription'];
}
elseif ( $xoopsModuleConfig['textindex'] ) {
	$metagen['description'] = strip_tags($xoopsModuleConfig['textindex']);
}

if ( $xoopsModuleConfig['moduleMetaKeywords'] ) {
	$metagen['keywords'] = $xoopsModuleConfig['moduleMetaKeywords'];
}

if ( isset($metagen['title']) ) {
	$xoopsTpl->assign('xoops_pagetitle',   	$metagen['title']);
}

// Assure compatibility with < Xoops 2.0.14
if ( isset($metagen['description']) ) {
	if ( is_file(XOOPS_ROOT_PATH . '/class/theme.php') ) {
		$xoTheme->addMeta( 'meta', 'description',  	$metagen['description']);
	} else {
		$xoopsTpl->assign('xoops_meta_description',	$metagen['description']);
	}
}

if ( isset($metagen['keywords']) ) {
	if ( is_file(XOOPS_ROOT_PATH . '/class/theme.php') ) {
		$xoTheme->addMeta( 'meta', 'keywords',  	$metagen['keywords']);
   	} else {
		$xoopsTpl->assign('xoops_meta_keywords',  $metagen['keywords']);
	}
}

include_once(XOOPS_ROOT_PATH."/footer.php");
?>