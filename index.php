<?php
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
 * @package   \XoopsModules\Edito
 * @copyright Copyright {@link https://xoops.org XOOPS Project}
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 * @author    Solo (http://www.wolfpackclan.com/wolfactory)
 * @author    DuGris (http://www.dugris.info)
 * @author    XOOPS Module Development Team
 * @link      https://github.com/XoopsModules25x/edito
 */

use Xmf\Request;

// This script is used to display the page list
require_once __DIR__ . '/header.php';

/** @var MyTextSanitizer $myts */
/* ----------------------------------------------------------------------- */
/*                              Select template                            */
/* ----------------------------------------------------------------------- */
$GLOBALS['xoopsoption']['template_main'] = 'edito_index.html';
$align = 'center';
if ('table' == $GLOBALS['xoopsModuleConfig']['index_display']) {
    $GLOBALS['xoopsoption']['template_main'] = 'edito_index_ext.html';
    $align = 'center';
} elseif ('news' == $GLOBALS['xoopsModuleConfig']['index_display']) {
    $GLOBALS['xoopsoption']['template_main'] = 'edito_index_news.html';
    $align = 'left';
} elseif ('blog' == $GLOBALS['xoopsModuleConfig']['index_display']) {
    $GLOBALS['xoopsoption']['template_main'] = 'edito_index_blog.html';
    $align = 'left';
}
include_once XOOPS_ROOT_PATH . '/header.php';
$startart = Request::getInt('startart', 0, 'GET');

/* ----------------------------------------------------------------------- */
/*                    Redirect index to a specific page                    */
/* ----------------------------------------------------------------------- */
if ($GLOBALS['xoopsModuleConfig']['index_content']) {
    if ((preg_match("/http[s]:\/\//i", $GLOBALS['xoopsModuleConfig']['index_content']))) {
        header ("location: " . $GLOBALS['xoopsModuleConfig']['index_content']);
        exit();
    } else {
        $sql = "SELECT COUNT(*) FROM " . $GLOBALS['xoopsDB']->prefix($GLOBALS['xoopsModule']->dirname() . "_content") . "
                WHERE id=" . $GLOBALS['xoopsModuleConfig']['index_content'] . " AND status=2";

        $result        = $GLOBALS['xoopsDB']->queryF($sql);
        list($numrows) = $GLOBALS['xoopsDB']->fetchRow($result);
//@todo where is this suppose to redirect to? clearly example.com isn't right
        if ($numrows) {
        //header ("location: content.php?id=".$GLOBALS['xoopsModuleConfig']['index_content']);
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
$GLOBALS['xoopsTpl']->assign([
    'module_name'      => $GLOBALS['xoopsModule']->getVar('name'),
    'textindex'        => $myts->displayTarea($GLOBALS['xoopsModuleConfig']['textindex']),
    'lang_page'        => _MD_EDITO_PAGE,
    'footer'           => $myts->displayTarea($GLOBALS['xoopsModuleConfig']['footer'], 1),
    'lang_num'         => _MD_EDITO_NUM,
    'lang_read'        => _READS,
    'lang_image'       => _MD_EDITO_IMAGE,
    'lang_subject'     => _MD_EDITO_SUBJECT,
    'lang_info'        => _MD_EDITO_INFOS,
    'lang_block_texte' => _MD_EDITO_BLOCK_TEXTE
]);

/* ----------------------------------------------------------------------- */
/*                              Generate banner                            */
/* ----------------------------------------------------------------------- */
// Module Banner
$banner = '';
if (preg_match('/.swf/i', $GLOBALS['xoopsModuleConfig']['index_logo'])) {
    $banner = '<object
                classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
                codebase="https://download.macromedia.com/pub/shockwave/cabs/flash/ swflash.cab#version=6,0,40,0" ;=""
                height="60"
                width="468">
                <param  name="movie"
                value="' . trim($GLOBALS['xoopsModuleConfig']['index_logo']) . '">
                <param name="quality" value="high">
                <embed src="' . trim($GLOBALS['xoopsModuleConfig']['index_logo']) . '"
                quality="high"
                pluginspage="https://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" ;=""
                type="application/x-shockwave-flash"
                height="60"
                width="468">
                </object>';
} elseif ($GLOBALS['xoopsModuleConfig']['index_logo']) {
    $banner = edito_createlink('', '', '', $GLOBALS['xoopsModuleConfig']['index_logo'], 'center', '800', '600', $GLOBALS['xoopsModule']->getVar('name') . ' ' . $GLOBALS['xoopsModuleConfig']['moduleMetaDescription'], $GLOBALS['xoopsModuleConfig']['url_rewriting']);
}

$GLOBALS['xoopsTpl']->assign('banner', $banner);

/* ----------------------------------------------------------------------- */
/*                            Create admin links                           */
/* ----------------------------------------------------------------------- */
$adminlink = ''; // init admin links
if ($GLOBALS['xoopsUser'] && $GLOBALS['xoopsUser']->isAdmin($GLOBALS['xoopsModule']->mid())) {
    $adminlink = "<a href='admin/content.php' title='" . _MD_EDITO_ADD . "'>
                   <img src='assets/images/icon/add.gif' alt='" . _MD_EDITO_ADD . "'></a> |
                 <a href='admin/index.php' title='" . _MD_EDITO_LIST . "'>
                   <img src='assets/images/icon/list.gif' alt='" . _MD_EDITO_LIST . "'></a> |
                 <a href='admin/utils_uploader.php' title='" . _MD_EDITO_UTILITIES . "'>
                   <img src='assets/images/icon/utilities.gif' alt='" . _MD_EDITO_UTILITIES . "'></a> |
                 <a href='../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=" . $GLOBALS['xoopsModule']->getVar('mid') . "' title='" . _MD_EDITO_SETTINGS . "'>
                   <img src='assets/images/icon/settings.gif' alt='" . _MD_EDITO_SETTINGS . "'></a> |
                 <a href='admin/blocks.php' title='" . _MD_EDITO_BLOCKS . "'>
                   <img src='assets/images/icon/blocks.gif' alt='" . _MD_EDITO_BLOCKS . "'></a> |
                 <a href='admin/help.php' title='" . _MD_EDITO_HELP . "'>
                   <img src='assets/images/icon/help.gif' alt='" . _MD_EDITO_HELP . "'></a></span>";
}
$GLOBALS['xoopsTpl']->assign('adminlink', $adminlink);

/* ----------------------------------------------------------------------- */
/*                              Define columns settings                    */
/* ----------------------------------------------------------------------- */
$GLOBALS['xoopsTpl']->assign('columns', $GLOBALS['xoopsModuleConfig']['columns']);
$GLOBALS['xoopsTpl']->assign('width', number_format(100 / $GLOBALS['xoopsModuleConfig']['columns'], 2, '.', ' '));

/* ----------------------------------------------------------------------- */
/*                              Count number of available pages            */
/* ----------------------------------------------------------------------- */
$result        = $GLOBALS['xoopsDB']->queryF("SELECT COUNT(*) FROM " . $GLOBALS['xoopsDB']->prefix($GLOBALS['xoopsModule']->dirname() . "_content") . " WHERE status>2");
list($numrows) = $GLOBALS['xoopsDB']->fetchRow($result);

$count     = $startart;
$time      = time();
$startdate = ($time - (86400 * $GLOBALS['xoopsModuleConfig']['tags_new']));
++$count;
$subjects  = '';

if (0 < $numrows) { // That is, if there ARE editos in the system
    /* ----------------------------------------------------------------------- */
    /*                            Generate page navigation                     */
    /* ----------------------------------------------------------------------- */
    $pagenav = new XoopsPageNav($numrows, $GLOBALS['xoopsModuleConfig']['perpage'], $startart, 'startart', '');
    $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderImageNav());
    $group = is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->getGroups() : array(XOOPS_GROUP_ANONYMOUS);

    /* ----------------------------------------------------------------------- */
    /*                              Create query                               */
    /* ----------------------------------------------------------------------- */
    $sql = "SELECT id, uid, datesub, counter, subject,  block_text, body_text, image, media, meta, groups, options
            FROM " . $GLOBALS['xoopsDB']->prefix($GLOBALS['xoopsModule']->dirname() . "_content") . " WHERE status>2 ORDER BY " . $GLOBALS['xoopsModuleConfig']['order'];

    $result = $GLOBALS['xoopsDB']->queryF($sql, $GLOBALS['xoopsModuleConfig']['perpage'], $startart);
    while(list($id, $uid, $datesub, $counter, $subject, $block_text, $body_text, $image, $media, $meta, $groups, $options) = $GLOBALS['xoopsDB']->fetchRow($result)) {
        /* ----------------------------------------------------------------------- */
        /*                              Check group access                         */
        /* ----------------------------------------------------------------------- */
        $groups = explode(' ', $groups);
        if (0 < count(array_intersect($group, $groups))) {
            $info = [];

            /* ----------------------------------------------------------------------- */
            /*                            Display icons                                */
            /* ----------------------------------------------------------------------- */
            $fileinfo = '';
            $alt_user = XoopsUser::getUnameFromId($uid);
            $user     = '<a href="../userinfo.php?uid=' . $uid . '">' . $alt_user . '</a>';
            $alt_date = formatTimestamp($datesub,'m');

            /* ----------------------------------------------------------------------- */
            /*                              Retrieve options                           */
            /* ----------------------------------------------------------------------- */
            $media      = explode("|", $media);
            $media_file = $media[0];
            $media_url  = $media[1];
            $media_size = $media[2];

            $meta       = explode("|", $meta);
            $meta_title = $meta[0];

            $option     = explode("|", $options);
            $html       = $option[0];
            $xcode      = $option[1];
            $smiley     = $option[2];
            $logo       = $option[3];
            $block      = $option[4];
            $title      = $option[5];
            $cancomment = $option[6];


            if ($GLOBALS['xoopsModuleConfig']['tags']) {
                if ($startdate < $datesub) {
                    $datesub   = formatTimestamp($datesub, 'm');
                    $fileinfo  .= '&nbsp;<img src="assets/images/icon/new.gif" alt="' . $alt_date . '">';
                }

                if ($counter >= $GLOBALS['xoopsModuleConfig']['tags_pop']) {
                    $fileinfo .= '&nbsp;<img src="assets/images/icon/pop.gif" alt="' . $counter . '&nbsp;' . _READS . '">';
                }

                if ('table' == $GLOBALS['xoopsModuleConfig']['index_display'] || 'news' == $GLOBALS['xoopsModuleConfig']['index_display']) {
                    /* ----------------------------------------------------------------------- */
                    /*                              Check media file type                      */
                    /* ----------------------------------------------------------------------- */
                    if ($media_file) {
                        include_once __DIR__ . '/include/functions_mediasize.php';
                        $media    =  XOOPS_URL . '/' .  $GLOBALS['xoopsModuleConfig']['sbmediadir'] . '/' . $media_file;
                        $format   = edito_checkformat($media, $GLOBALS['xoopsModuleConfig']['custom_media']);
                        $filesize = edito_fileweight($media);
                        $fileinfo .= ' <img src="assets/images/icon/' . $format[1] . '.gif" alt="' . $format[1] . ': ' . $format[0] . ' [' . $filesize . '] [' . $media_file . ']">';
                    } elseif ($media_url) {
                        include_once __DIR__ . '/include/functions_mediasize.php';
                        $media    =  $media_url;
                        $format   = edito_checkformat($media, $GLOBALS['xoopsModuleConfig']['custom_media']);
                        $fileinfo .= ' <img src="assets/images/icon/' . $format[1] . '.gif"
                                         alt="' . $format[1] . ': ' . $format[0] . ' [' . $media . ']">
                                       <img src="assets/images/icon/ext.gif" alt="' . _MD_EDITO_MEDIAURL . '">';
                    }

                    if ($media_file || $media_url) {
                        $popup_size    = edito_popup_size($media_size, $GLOBALS['xoopsModuleConfig']['custom']);
                        $info['popup'] = '<a onclick="window.open(\'\', \'wclose\', \'' . $popup_size . ', toolbar=no, scrollbars=yes, status=no, resizable=yes, fullscreen=no, titlebar=no, left=197, top=37\', \'false\')"
                            href="popup.php?id=' . $id . ' " target="wclose">
                            ' . _MD_EDITO_SEE_MEDIA . '
                            </a> | ';
                    }
                }

                $fileinfo = $alt_date . '<br>' . $fileinfo . ' ' . $user;
                if ('image' == $GLOBALS['xoopsModuleConfig']['index_display']) {
                    $fileinfo = $fileinfo;
                } elseif ('news' == $GLOBALS['xoopsModuleConfig']['index_display']) {
                    $fileinfo = $alt_date . ' ' . $fileinfo . ' ' . $user;
                }
            }

            $info['info']= $fileinfo;

            /* ----------------------------------------------------------------------- */
            /*                            Create admin links                           */
            /* ----------------------------------------------------------------------- */
            $adminlinks = '';
            if ($GLOBALS['xoopsUser'] && $GLOBALS['xoopsUser']->isAdmin($GLOBALS['xoopsModule']->mid())) {
                $adminlinks = "<a href='admin/content.php?op=mod&id=" . $id . "' title='" . _MD_EDITO_EDIT . "'>
                                    <img src='assets/images/icon/edit.gif' alt='" . _MD_EDITO_EDIT . "'></a> |
                               <a href='admin/content.php?op=del&id=" . $id . "' title='" . _MD_EDITO_DELETE . "'>
                                 <img src='assets/images/icon/delete.gif' alt='" . _MD_EDITO_DELETE . "'></a> |
                               <a href='print.php?id=" . $id . "' target='_blank'  title='" . _MD_EDITO_PRINT . "'>
                                 <img src='assets/images/icon/print.gif' alt='" . _MD_EDITO_PRINT . "'></a>";
           }

            /* ----------------------------------------------------------------------- */
            /*                            Display logo                                 */
            /* ----------------------------------------------------------------------- */
            $link        =  "content.php?id={$id}";
            $subject     = $myts->displayTarea($subject);
            //$alt_subject = $subjects . ' ' . $subject;
            if ('table' !== $GLOBALS['xoopsModuleConfig']['index_display']) {
                $image_subject = $subject;
            }
            if ($image) {
                $logo =  XOOPS_URL . '/' . $GLOBALS['xoopsModuleConfig']['sbuploaddir'] . '/' . $image;
                $image_size = explode('|', $GLOBALS['xoopsModuleConfig']['logo_size']);
                $info['logo'] = edito_createlink($link, $subject, '', $logo, $align, $image_size[0], $image_size[1], $meta_title, $GLOBALS['xoopsModuleConfig']['url_rewriting']);
            } else {
                $info['logo'] = '';
            }

            /* ----------------------------------------------------------------------- */
            /*                            Check comments options                       */
            /* ----------------------------------------------------------------------- */
            $comment_link = '';
            if ($cancomment && 1 <= $GLOBALS['xoopsModuleConfig']['com_rule']) {
                $comments     = $GLOBALS['xoopsDB']->query("SELECT COUNT(*) FROM " . $GLOBALS['xoopsDB']->prefix('xoopscomments') . " WHERE com_status=2 AND com_modid=" . $GLOBALS['xoopsModule']->mid() . " AND com_itemid={$id}");
                $numb         = $GLOBALS['xoopsDB']->fetchRow($comments);
                $comments     = (1 <= $numb[0]) ? $numb[0] . ' ' . _COMMENTS : _NOCOMMENTS;
                $comment_link = edito_createlink($link, ' | ' . $comments, '', '', '', '', '', $meta_title, $GLOBALS['xoopsModuleConfig']['url_rewriting']) . ' | ';
            }

            /* ----------------------------------------------------------------------- */
            /*                            Generate pages variables                     */
            /* ----------------------------------------------------------------------- */

            $body_text = '';
            if ('blog' == $GLOBALS['xoopsModuleConfig']['index_display']) {
                $body_test   = $body_text;
                $body_text   = edito_pagebreak($body_text, '', 0, $link);
                $readmore_on = $body_text != $body_test ? 1 : 0;
                $body_text   = $myts->displayTarea($body_text, $html, $smiley, $xcode);
            }

            $readmore = '';
            if ($GLOBALS['xoopsModuleConfig']['index_display'] != 'blog' || $readmore_on) {
                $readmore    = edito_createlink($link, _MD_EDITO_READMORE, '', '', '', '', '', $meta_title, $GLOBALS['xoopsModuleConfig']['url_rewriting']);
            }

            $block_text = '';
            if ($GLOBALS['xoopsModuleConfig']['index_display'] != 'image') {
                $block_text      = $myts->displayTarea($block_text, $html, $smiley, $xcode);
            }

            $info['subject']     = edito_createlink($link, $subject, '', '', '', '', '', $meta_title, $GLOBALS['xoopsModuleConfig']['url_rewriting']);
            $info['alt_subject'] = $meta_title;
            $info['readmore']    = $readmore;
            $info['comment']     = $comment_link;
            $info['tag']         = $fileinfo;
            $info['count']       = $count++;
            $info['counter']     = $counter;
            $info['block_text']  = $block_text;
            $info['body_text']   = $body_text;
            $info['adminlinks']  = $adminlinks;

            $GLOBALS['xoopsTpl']->append('infos', $info);
            unset($info);
        } // Groups
    } // While
}// Numrows

/* ----------------------------------------------------------------------- */
/*                             Create Meta tags                            */
/* createMetaTags(
/*      Page title,             // Current page title
/*      Page texte,             // Page content which will be used to generate keywords
/*      Default Meta Keywords,  // The default current module meta keywords - if any
/*      Page Meta Keywords,     // The default current page meta keywords - if any
/*      Meta Description,       // The current page meta description
/*      Page Status (0 / 1),    // Is the current page online of offline?
/*      Min keyword caracters,  // Minimu size a words must have to be considered
/*      Min keyword occurence,  // How many time a word must appear to be considered
/*      Max keyword occurence)  // Maximum time a word must appear to be considered
/* ----------------------------------------------------------------------- */
/*
edito_createMetaTags($GLOBALS['xoopsModuleConfig']['moduleMetaDescription'], $GLOBALS['xoopsModuleConfig']['textindex'], $GLOBALS['xoopsModuleConfig']['moduleMetaKeywords'], '', $GLOBALS['xoopsModuleConfig']['moduleMetaDescription'], 1, 2, 1, 9);
*/

$metagen['title'] = $GLOBALS['xoopsModule']->getVar('name');
if ($GLOBALS['xoopsModuleConfig']['moduleMetaDescription']) {
    $metagen['description'] = $GLOBALS['xoopsModuleConfig']['moduleMetaDescription'];
} elseif ($GLOBALS['xoopsModuleConfig']['textindex']) {
    $metagen['description'] = strip_tags($GLOBALS['xoopsModuleConfig']['textindex']);
}

if ($GLOBALS['xoopsModuleConfig']['moduleMetaKeywords']) {
    $metagen['keywords'] = $GLOBALS['xoopsModuleConfig']['moduleMetaKeywords'];
}

if (isset($metagen['title'])) {
    $GLOBALS['xoopsTpl']->assign('xoops_pagetitle', $metagen['title']);
}

// Assure compatibility with < Xoops 2.0.14
if (isset($metagen['description'])) {
    if (is_file(XOOPS_ROOT_PATH . '/class/theme.php')) {
        $GLOBALS['xoTheme']->addMeta('meta', 'description', $metagen['description']);
    } else {
        $GLOBALS['xoopsTpl']->assign('xoops_meta_description', $metagen['description']);
    }
}

if (isset($metagen['keywords'])) {
    if (is_file(XOOPS_ROOT_PATH . '/class/theme.php')) {
        $GLOBALS['xoTheme']->addMeta('meta', 'keywords', $metagen['keywords']);
    } else {
        $GLOBALS['xoopsTpl']->assign('xoops_meta_keywords',  $metagen['keywords']);
    }
}

require_once XOOPS_ROOT_PATH . '/footer.php';
