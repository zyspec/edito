<?php

declare(strict_types=1);

/*
 You may not change or alter any portion of this comment or credits of
 supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit
 authors.

 This program is distributed in the hope that it will be useful, but
 WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */
/**
 * Module: Edito
 *
 * @copyright Copyright {@link https://xoops.org XOOPS Project}
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 * @author    Solo (http://www.wolfpackclan.com/wolfactory)
 * @author    DuGris (http://www.dugris.info)
 * @author    XOOPS Module Development Team
 * @link      https://github.com/XoopsModules25x/edito
 */

// This script is used to display the page list
require_once __DIR__ . '/header.php';

/* ----------------------------------------------------------------------- */
/*                              Select template                            */
/* ----------------------------------------------------------------------- */
if ('table' == $xoopsModuleConfig['index_display']) {
    $GLOBALS['xoopsOption']['template_main'] = 'edito_index_ext.tpl';

    $align = 'center';
} elseif ('image' == $xoopsModuleConfig['index_display']) {
    $GLOBALS['xoopsOption']['template_main'] = 'edito_index.tpl';

    $align = 'center';
} elseif ('news' == $xoopsModuleConfig['index_display']) {
    $GLOBALS['xoopsOption']['template_main'] = 'edito_index_news.tpl';

    $align = 'left';
} elseif ('blog' == $xoopsModuleConfig['index_display']) {
    $GLOBALS['xoopsOption']['template_main'] = 'edito_index_blog.tpl';

    $align = 'left';
}
require_once XOOPS_ROOT_PATH . '/header.php';
$startart = isset($_GET['startart']) ? (int)$_GET['startart'] : 0;

/* ----------------------------------------------------------------------- */
/*                    Redirect index to a specific page                    */
/* ----------------------------------------------------------------------- */
if ($xoopsModuleConfig['index_content']) {
    if (preg_match("/http[s]:\/\//i", $xoopsModuleConfig['index_content'])) {
        header('location: ' . $xoopsModuleConfig['index_content']);

        exit();
    }

    $sql = 'SELECT COUNT(*) FROM ' . $xoopsDB->prefix($xoopsModule->dirname() . '_content') . '
				WHERE id=' . $xoopsModuleConfig['index_content'] . ' AND status=2';

    $result = $xoopsDB->queryF($sql);

    [$numrows] = $xoopsDB->fetchRow($result);

    if ($numrows) {
        //	header ("location: content.php?id=".$xoopsModuleConfig['index_content']);

        header('location: http://www.example.com');

        exit();
    }
}

/* ----------------------------------------------------------------------- */
/*                              Render templates variables                 */
/* ----------------------------------------------------------------------- */
/*                              Language variables                         */
/* ----------------------------------------------------------------------- */
$xoopsTpl->assign('module_name', $xoopsModule->getVar('name'));
$xoopsTpl->assign('textindex', $myts->displayTarea($xoopsModuleConfig['textindex']));
$xoopsTpl->assign('lang_page', _MD_EDITO_PAGE);
$xoopsTpl->assign('footer', $myts->displayTarea($xoopsModuleConfig['footer'], 1));
$xoopsTpl->assign('lang_num', _MD_EDITO_NUM);
$xoopsTpl->assign('lang_read', _READS);
$xoopsTpl->assign('lang_image', _MD_EDITO_IMAGE);
$xoopsTpl->assign('lang_subject', _MD_EDITO_SUBJECT);
$xoopsTpl->assign('lang_info', _MD_EDITO_INFOS);
$xoopsTpl->assign('lang_block_texte', _MD_EDITO_BLOCK_TEXTE);

/* ----------------------------------------------------------------------- */
/*                              Generate banner                            */
/* ----------------------------------------------------------------------- */
// Module Banner
if (preg_match('/.swf/i', $xoopsModuleConfig['index_logo'])) {
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
} elseif ($xoopsModuleConfig['index_logo']) {
    $banner = edito_createlink('', '', '', $xoopsModuleConfig['index_logo'], 'center', '800', '600', $xoopsModule->getVar('name') . ' ' . $xoopsModuleConfig['moduleMetaDescription'], $xoopsModuleConfig['url_rewriting']);
} else {
    $banner = '';
}

$xoopsTpl->assign('banner', $banner);

/* ----------------------------------------------------------------------- */
/*                            Create admin links                           */
/* ----------------------------------------------------------------------- */
$adminlink = ''; // init admin links
if ($xoopsUser && $xoopsUser->isAdmin($xoopsModule->mid())) {
    $adminlink = "<a href='admin/content.php' title='" . _MD_EDITO_ADD . "'>
    			   <img src='assets/images/icon/add.gif' alt='" . _MD_EDITO_ADD . "'></a> |
                 <a href='admin/index.php' title='" . _MD_EDITO_LIST . "'>
                   <img src='assets/images/icon/list.gif' alt='" . _MD_EDITO_LIST . "'></a> |
                 <a href='admin/utils_uploader.php' title='" . _MD_EDITO_UTILITIES . "'>
                   <img src='assets/images/icon/utilities.gif' alt='" . _MD_EDITO_UTILITIES . "'></a> |
                 <a href='../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=" . $xoopsModule->getVar('mid') . "' title='" . _MD_EDITO_SETTINGS . "'>
                   <img src='assets/images/icon/settings.gif' alt='" . _MD_EDITO_SETTINGS . "'></a> |
                 <a href='admin/blocks.php' title='" . _MD_EDITO_BLOCKS . "'>
                   <img src='assets/images/icon/blocks.gif' alt='" . _MD_EDITO_BLOCKS . "'></a> |
                 <a href='admin/help.php' title='" . _MD_EDITO_HELP . "'>
                   <img src='assets/images/icon/help.gif' alt='" . _MD_EDITO_HELP . "'></a></span>";
}
$xoopsTpl->assign('adminlink', $adminlink);

/* ----------------------------------------------------------------------- */
/*                              Define columns settings                    */
/* ----------------------------------------------------------------------- */
$xoopsTpl->assign('columns', $xoopsModuleConfig['columns']);
$xoopsTpl->assign('width', number_format(100 / $xoopsModuleConfig['columns'], 2, '.', ' '));

/* ----------------------------------------------------------------------- */
/*                              Count number of available pages            */
/* ----------------------------------------------------------------------- */
$result = $xoopsDB->queryF('SELECT COUNT(*) FROM ' . $xoopsDB->prefix($xoopsModule->dirname() . '_content') . ' WHERE status>2');
[$numrows] = $xoopsDB->fetchRow($result);

$count     = $startart;
$time      = time();
$startdate = time() - (86400 * $xoopsModuleConfig['tags_new']);
$count++;
$subjects = '';

if ($numrows > 0) {    // That is, if there ARE editos in the system
    /* ----------------------------------------------------------------------- */

    /*                            Generate page navigation                     */

    /* ----------------------------------------------------------------------- */

    $pagenav = new XoopsPageNav($numrows, $xoopsModuleConfig['perpage'], $startart, 'startart', '');

    $xoopsTpl->assign('pagenav', $pagenav->renderImageNav());

    $group = is_object($xoopsUser) ? $xoopsUser->getGroups() : [XOOPS_GROUP_ANONYMOUS];

    /* ----------------------------------------------------------------------- */

    /*                              Create query                               */

    /* ----------------------------------------------------------------------- */

    $sql = 'SELECT id, uid, datesub, counter, subject,  block_text, body_text, image, media, meta, groups, options
    		FROM ' . $xoopsDB->prefix($xoopsModule->dirname() . '_content') . ' WHERE status>2 ORDER BY ' . $xoopsModuleConfig['order'];

    $result = $xoopsDB->queryF($sql, $xoopsModuleConfig['perpage'], $startart);

    while (list($id, $uid, $datesub, $counter, $subject, $block_text, $body_text, $image, $media, $meta, $groups, $options) = $xoopsDB->fetchRow($result)) {
        /* ----------------------------------------------------------------------- */

        /*                              Check group access                         */

        /* ----------------------------------------------------------------------- */

        $groups = explode(' ', $groups);

        if (count(array_intersect($group, $groups)) > 0) {
            $info = [];

            /* ----------------------------------------------------------------------- */

            /*                            Display icons                                */

            /* ----------------------------------------------------------------------- */

            $fileinfo = '';

            $alt_user = XoopsUser::getUnameFromId($uid);

            $user = '<a href="../userinfo.php?uid=' . $uid . '">' . $alt_user . '</a>';

            $alt_date = formatTimestamp($datesub, 'm');

            /* ----------------------------------------------------------------------- */

            /*                              Retrieve options                           */

            /* ----------------------------------------------------------------------- */

            $media = explode('|', $media);

            $media_file = $media[0];

            $media_url = $media[1];

            $media_size = $media[2];

            $meta = explode('|', $meta);

            $meta_title = $meta[0];

            $option = explode('|', $options);

            $html = $option[0];

            $xcode = $option[1];

            $smiley = $option[2];

            $logo = $option[3];

            $block = $option[4];

            $title = $option[5];

            $cancomment = $option[6];

            if ($xoopsModuleConfig['tags']) {
                if ($startdate < $datesub) {
                    $datesub = formatTimestamp($datesub, 'm');

                    $fileinfo .= '&nbsp;<img src="assets/images/icon/new.gif" alt="' . $alt_date . '">';
                }

                if ($counter >= $xoopsModuleConfig['tags_pop']) {
                    $fileinfo .= '&nbsp;<img src="assets/images/icon/pop.gif" alt="' . $counter . '&nbsp;' . _READS . '">';
                }

                if ('table' == $xoopsModuleConfig['index_display'] or 'news' == $xoopsModuleConfig['index_display']) {
                    /* ----------------------------------------------------------------------- */

                    /*                              Check media file type                      */

                    /* ----------------------------------------------------------------------- */

                    if ($media_file) {
                        require_once __DIR__ . '/include/functions_mediasize.php';

                        $media = XOOPS_URL . '/' . $xoopsModuleConfig['sbmediadir'] . '/' . $media_file;

                        $format = edito_checkformat($media, $xoopsModuleConfig['custom_media']);

                        $filesize = edito_fileweight($media);

                        $fileinfo .= ' <img src="assets/images/icon/' . $format[1] . '.gif" alt="' . $format[1] . ': ' . $format[0] . ' [' . $filesize . '] [' . $media_file . ']">';
                    } elseif ($media_url) {
                        require_once __DIR__ . '/include/functions_mediasize.php';

                        $media = $media_url;

                        $format = edito_checkformat($media, $xoopsModuleConfig['custom_media']);

                        $fileinfo .= ' <img src="assets/images/icon/' . $format[1] . '.gif"
                                         alt="' . $format[1] . ': ' . $format[0] . ' [' . $media . ']">
                        			   <img src="assets/images/icon/ext.gif" alt="' . _MD_EDITO_MEDIAURL . '">';
                    }

                    if ($media_file || $media_url) {
                        $popup_size = edito_popup_size($media_size, $xoopsModuleConfig['custom']);

                        $info['popup'] = '<a onclick="window.open(\'\', \'wclose\', \'' . $popup_size . ', toolbar=no, scrollbars=yes, status=no, resizable=yes, fullscreen=no, titlebar=no, left=197, top=37\', \'false\')"
							href="popup.php?id=' . $id . ' " target="wclose">
							' . _MD_EDITO_SEE_MEDIA . '
							</a> | ';
                    }
                }

                if ('image' == $xoopsModuleConfig['index_display']) {
                    $fileinfo = $fileinfo;
                } elseif ('news' == $xoopsModuleConfig['index_display']) {
                    $fileinfo = $alt_date . ' ' . $fileinfo . ' ' . $user;
                } else {
                    $fileinfo = $alt_date . '<br>' . $fileinfo . ' ' . $user;
                }
            }

            $info['info'] = $fileinfo;

            /* ----------------------------------------------------------------------- */

            /*                            Create admin links                           */

            /* ----------------------------------------------------------------------- */

            if ($xoopsUser && $xoopsUser->isAdmin($xoopsModule->mid())) {
                $adminlinks = "<a href='admin/content.php?op=mod&id=" . $id . "' title='" . _MD_EDITO_EDIT . "'>
       			                 <img src='assets/images/icon/edit.gif' alt='" . _MD_EDITO_EDIT . "'></a> |
                               <a href='admin/content.php?op=del&id=" . $id . "' title='" . _MD_EDITO_DELETE . "'>
                                 <img src='assets/images/icon/delete.gif' alt='" . _MD_EDITO_DELETE . "'></a> |
                               <a href='print.php?id=" . $id . "' target='_blank'  title='" . _MD_EDITO_PRINT . "'>
                                 <img src='assets/images/icon/print.gif' alt='" . _MD_EDITO_PRINT . "'></a>";
            } else {
                $adminlinks = '';
            }

            /* ----------------------------------------------------------------------- */

            /*                            Display logo                                 */

            /* ----------------------------------------------------------------------- */

            $link = 'content.php?id=' . $id;

            $subject = $myts->displayTarea($subject);
            //            $alt_subject    = $subjects.' '.$subject;

            if ('table' != $xoopsModuleConfig['index_display']) {
                $image_subject = $subject;
            }

            if ($image) {
                $logo = XOOPS_URL . '/' . $xoopsModuleConfig['sbuploaddir'] . '/' . $image;

                $image_size = explode('|', $xoopsModuleConfig['logo_size']);

                $info['logo'] = edito_createlink($link, $subject, '', $logo, $align, $image_size[0], $image_size[1], $meta_title, $xoopsModuleConfig['url_rewriting']);
            } else {
                $info['logo'] = '';
            }

            /* ----------------------------------------------------------------------- */

            /*                            Check comments options                       */

            /* ----------------------------------------------------------------------- */

            $comment_link = '';

            if ($cancomment && $xoopsModuleConfig['com_rule'] >= 1) {
                $comments = $xoopsDB->query('SELECT COUNT(*) FROM ' . $xoopsDB->prefix('xoopscomments') . ' WHERE com_status=2 AND com_modid=' . $xoopsModule->mid() . ' AND com_itemid=' . $id);

                $numb = $xoopsDB->fetchRow($comments);

                if ($numb[0] >= 1) {
                    $comments = $numb[0] . ' ' . _COMMENTS;
                } else {
                    $comments = _NOCOMMENTS;
                }

                $comment_link = edito_createlink($link, ' | ' . $comments, '', '', '', '', '', $meta_title, $xoopsModuleConfig['url_rewriting']) . ' | ';
            }

            /* ----------------------------------------------------------------------- */

            /*                            Generate pages variables                     */

            /* ----------------------------------------------------------------------- */

            if ('blog' == $xoopsModuleConfig['index_display']) {
                $body_test = $body_text;

                $body_text = edito_pagebreak($body_text, '', 0, $link);

                if ($body_text != $body_test) {
                    $readmore_on = 1;
                } else {
                    $readmore_on = 0;
                }

                $body_text = $myts->displayTarea($body_text, $html, $smiley, $xcode);
            } else {
                $body_text = '';
            }

            if ('blog' != $xoopsModuleConfig['index_display'] || $readmore_on) {
                $readmore = edito_createlink($link, _MD_EDITO_READMORE, '', '', '', '', '', $meta_title, $xoopsModuleConfig['url_rewriting']);
            } else {
                $readmore = '';
            }

            if ('image' != $xoopsModuleConfig['index_display']) {
                $block_text = $myts->displayTarea($block_text, $html, $smiley, $xcode);
            } else {
                $block_text = '';
            }

            $info['subject'] = edito_createlink($link, $subject, '', '', '', '', '', $meta_title, $xoopsModuleConfig['url_rewriting']);

            $info['alt_subject'] = $meta_title;

            $info['readmore'] = $readmore;

            $info['comment'] = $comment_link;

            $info['tag'] = $fileinfo;

            $info['count'] = $count++;

            $info['counter'] = $counter;

            $info['block_text'] = $block_text;

            $info['body_text'] = $body_text;

            $info['adminlinks'] = $adminlinks;

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

$metagen['title'] = $xoopsModule->getVar('name');
if ($xoopsModuleConfig['moduleMetaDescription']) {
    $metagen['description'] = $xoopsModuleConfig['moduleMetaDescription'];
} elseif ($xoopsModuleConfig['textindex']) {
    $metagen['description'] = strip_tags($xoopsModuleConfig['textindex']);
}

if ($xoopsModuleConfig['moduleMetaKeywords']) {
    $metagen['keywords'] = $xoopsModuleConfig['moduleMetaKeywords'];
}

if (isset($metagen['title'])) {
    $xoopsTpl->assign('xoops_pagetitle', $metagen['title']);
}

// Assure compatibility with < Xoops 2.0.14
if (isset($metagen['description'])) {
    if (is_file(XOOPS_ROOT_PATH . '/class/theme.php')) {
        $xoTheme->addMeta('meta', 'description', $metagen['description']);
    } else {
        $xoopsTpl->assign('xoops_meta_description', $metagen['description']);
    }
}

if (isset($metagen['keywords'])) {
    if (is_file(XOOPS_ROOT_PATH . '/class/theme.php')) {
        $xoTheme->addMeta('meta', 'keywords', $metagen['keywords']);
    } else {
        $xoopsTpl->assign('xoops_meta_keywords', $metagen['keywords']);
    }
}

require_once XOOPS_ROOT_PATH . '/footer.php';
