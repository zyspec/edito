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

// Script used to display an edito's content, for example when it was too short
// on the main page
require_once __DIR__ . '/header.php';
$GLOBALS['xoopsOption']['template_main'] = 'edito_content_submit.tpl';
include_once XOOPS_ROOT_PATH . '/header.php';

$group = is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->getGroups() : [XOOPS_GROUP_ANONYMOUS];
// $groups = explode(" ",$xoopsModuleConfig['submit_groups']);
if (0 >= count(array_intersect($group, $GLOBALS['xoopsModuleConfig']['submit_groups']))) {
	redirect_header('index.php', 2, _NOPERM);
}

if (Request::hasVar('subject', 'POST') && '' !== $_POST['subject']) {
    // Check to make sure this is from known location
    if (!$GLOBALS['xoopsSecurity']->check()) {
        redirect_header(XOOPS_URL . '/', 3, implode('<br>', $GLOBALS['xoopsSecurity']->getErrors()));
    }

    $subject     = Request::getString('subject', '', 'POST');
    $media       = Request::getUrl('media', '', 'POST');
    $description = Request::getString('description', '', 'POST');
    $groups      = (is_array($GLOBALS['xoopsModuleConfig']['groups'])) ? implode(' ', $GLOBALS['xoopsModuleConfig']['groups']) : '';
	$html        = 1; // disallow HTML
	$xcode       = 1; // disallow xcode
	$smiley      = 1; // disallow smilies
    $logo        = $GLOBALS['xoopsModuleConfig']['option_logo'];
	$block       = $GLOBALS['xoopsModuleConfig']['option_block'];
	$title       = $GLOBALS['xoopsModuleConfig']['option_title'];
 	$cancomment  = $GLOBALS['xoopsModuleConfig']['cancomment'];
    $options     = $html . '|' . $xcode . '|' . $smiley . '|' . $logo . '|' . $block . '|' . $title . '|' . $cancomment;
    $meta        = '|||';
    $uid         = is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->uid() : 0;
    $datesub     = time();
    $media       = '|' . edito_function_checkurl($media) . '|';

    if ($GLOBALS['xoopsDB']->queryF("INSERT INTO " . $GLOBALS['xoopsDB']->prefix('edito_content') .
        " (id,
           uid,
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
                  null,
                  '$uid',
                  '$datesub',
                  '1',
                  '$subject',
                  '$description',
                  '$media',
                  '$meta',
                  '$groups',
                  '$options')"))
    {
    	$redirect = _MD_EDITO_THANKS_SUBMIT;
    } else {
        $redirect = _MD_EDITO_THANKS_NOSUBMIT;
    }

	redirect_header('submit.php', 2, $redirect);
}
/* ----------------------------------------------------------------------- */
/*                              Display banner on pages                    */
/* ----------------------------------------------------------------------- */

// Module Banner
if (preg_match('/.swf/i', $GLOBALS['xoopsModuleConfig']['index_logo'])) {
	$banner = '<object
			   classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
               codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/ swflash.cab#version=6,0,40,0" ;=""
               height="60"
               width="468">
               <param  name="movie"
               value="' . trim($GLOBALS['xoopsModuleConfig']['index_logo']) . '">
               <param name="quality" value="high">
               <embed src="' . trim($xoopsModuleConfig['index_logo']) . '"
               quality="high"
               pluginspage="https://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" ;=""
               type="application/x-shockwave-flash"
               height="60"
               width="468">
               </object>';
} elseif ($GLOBALS['xoopsModuleConfig']['index_logo']) {
	$banner = edito_createlink(XOOPS_URL . '/modules/' . $GLOBALS['xoopsModule']->dirname(), '', '', $GLOBALS['xoopsModuleConfig']['index_logo'], 'center', '800', '600', $GLOBALS['xoopsModule']->getVar( 'name' ).' '. $GLOBALS['xoopsModuleConfig']['moduleMetaDescription'], $GLOBALS['xoopsModuleConfig']['url_rewriting']);
} else {
	$banner = '';
}
$GLOBALS['xoopsTpl']->assign('banner', $banner);

/* ----------------------------------------------------------------------- */
/*                              Render  variables                          */
/* ----------------------------------------------------------------------- */
$GLOBALS['xoopsTpl']->assign([
    'submit'         => _MD_EDITO_SUBMIT,
    'submitext'      => _MD_EDITO_SUBMITEXT,
    'subject'        => _MD_EDITO_SUBJECT,
    'media'          => _MD_EDITO_MEDIA,
    'text'           => _MD_EDITO_TEXT,
    'security_token' => $GLOBALS['xoopsSecurity']->getTokenHTML(),
    'footer'         => $myts->displayTarea($xoopsModuleConfig['footer'], 1)
]);

/* ----------------------------------------------------------------------- */
/*                             Admin links                                 */
/* ----------------------------------------------------------------------- */
$adminlinks = ''; //init administration links
if ($GLOBALS['xoopsUser'] && $GLOBALS['xoopsUser']->isAdmin($GLOBALS['xoopsModule']->mid())) {
	$adminlinks = "<a href='admin/content.php' title='" . _MD_EDITO_ADD . "'>
    			 <img src='assets/images/icon/add.gif' alt='" . _MD_EDITO_ADD . "'></a> |
                 <a href='admin/index.php' title='" . _MD_EDITO_LIST . "'>
                 <img src='assets/images/icon/list.gif' alt='" . _MD_EDITO_LIST . "'></a> |
                 <a href='admin/utils_uploader.php' title='" . _MD_EDITO_UTILITIES . "'>
                 <img src='assets/images/icon/utilities.gif' alt='" . _MD_EDITO_UTILITIES . "'></a> |
                 <a href='../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=" . $xoopsModule->getVar('mid'). "' title='"._MD_EDITO_SETTINGS."'>
                 <img src='assets/images/icon/settings.gif' alt='" . _MD_EDITO_SETTINGS . "'></a> |
                 <a href='admin/myblocksadmin.php' title='" . _MD_EDITO_BLOCKS . "'>
                 <img src='assets/images/icon/blocks.gif' alt='" . _MD_EDITO_BLOCKS . "'></a> |
                 <a href='admin/help.php' title='" . _MD_EDITO_HELP . "'>
                 <img src='assets/images/icon/help.gif' alt='" . _MD_EDITO_HELP . "'></a></span>";
}

$GLOBALS['xoopsTpl']->assign('adminlinks', $adminlinks);

require_once XOOPS_ROOT_PATH . '/footer.php';
