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
 * Script used to display an edito's content, for example when it was too short
 * on the main page
 *
 * @package  \XoopsModules\Edito
 * @copyright  &copy; 2000-2021 {@link https://xoops.org XOOPS Project}
 * @license  {@link https://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU GPL 2}
 * @author  Solo (http://www.wolfpackclan.com/wolfactory)
 * @author  DuGris (http://www.dugris.info)
 * @author  XOOPS Module Development Team
 * @link  https://github.com/XoopsModules25x/edito
 */

use Xmf\Request;
use XoopsModules\Edito\{
    Constants,
    Utility
};

/**
 * @var  XoopsModules\Edito\Helper  $helper
 * @var  MyTextSanitizer $myts
 */
require_once __DIR__ . '/header.php';

$GLOBALS['xoopsOption']['template_main'] = 'edito_content_submit.tpl';
require_once XOOPS_ROOT_PATH . '/header.php';

$group = $GLOBALS['xoopsUser'] instanceof \XoopsUser ? $GLOBALS['xoopsUser']->getGroups() : [XOOPS_GROUP_ANONYMOUS];
// $groups = explode(" ",$xoopsModuleConfig['submit_groups']);
if (0 >= count(array_intersect($group, $GLOBALS['xoopsModuleConfig']['submit_groups']))) {
	$helper->redirect('index.php', Constants::REDIRECT_DELAY_MEDIUM, _NOPERM);
}

if (Request::hasVar('subject', 'POST') && '' !== trim($_POST['subject'])) {
    $subject     = Request::getString('subject', '', 'POST');
    $media       = Request::getUrl('media', '', 'POST');
    $description = Request::getString('description', '', 'POST');
    $groups      = is_array($GLOBALS['xoopsModuleConfig']['groups']) ? implode(' ', $GLOBALS['xoopsModuleConfig']['groups']) : '';
	$html        = 1; // allow HTML
	$xcode       = 1; // allow xcode
	$smiley      = 1; // allow smilies
    $logo        = $GLOBALS['xoopsModuleConfig']['option_logo'];
	$block       = $GLOBALS['xoopsModuleConfig']['option_block'];
	$title       = $GLOBALS['xoopsModuleConfig']['option_title'];
 	$cancomment  = $GLOBALS['xoopsModuleConfig']['cancomment'];
    $options     = $html . '|' . $xcode . '|' . $smiley . '|' . $logo . '|' . $block . '|' . $title . '|' . $cancomment;
    $meta        = '|||';
    $uid         = $GLOBALS['xoopsUser'] instanceof \XoopsUser ? $GLOBALS['xoopsUser']->uid() : 0;
    $datesub     = time();
    $media       = edito_function_checkurl($media);
    $media       = '|' . $media . '|';

    $contentHandler = $helper->getHandler('Content');
    $contentObj = $contentHandler->create();
    $contentObj->setVars([
        'uid'       => $uid,
        'datesub'   => $datesub,
        'state'     => '1',
        'subject'   => $subject,
        'body_text' => $description,
        'media'     => $media,
        'meta'      => $meta,
        'groups'    => $groups,
        'options'   => $options
    ]);

    if (false !== $contentHandler->insert($contentObj)) {
    /*
    if ($GLOBALS['xoopsDB']->queryF("INSERT INTO " . $GLOBALS['xoopsDB']->prefix('edito_content') .
        " (id,
           uid,
           datesub,
           state,
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
    */
    	$redirectMsg = _MD_EDITO_THANKS_SUBMIT;
    } else {
        $redirectMsg = _MD_EDITO_THANKS_NOSUBMIT;
    }

	$helper->redirect('submit.php', Constants::REDIRECT_DELAY_MEDIUM, $redirectMsg);
}
/* ----------------------------------------------------------------------- */
/*                              Display banner on pages                    */
/* ----------------------------------------------------------------------- */
$banner = '';
if (preg_match('/.swf/i', $GLOBALS['xoopsModuleConfig']['index_logo'])) {
	$banner = '<object
			   classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
               codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/ swflash.cab#version=6,0,40,0" ;=""
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
	$banner = edito_createlink($helper->url(''), '', '', $GLOBALS['xoopsModuleConfig']['index_logo'], 'center', '800', '600', $GLOBALS['xoopsModule']->getVar( 'name' ).' '. $GLOBALS['xoopsModuleConfig']['moduleMetaDescription'], $GLOBALS['xoopsModuleConfig']['url_rewriting']);
}
$GLOBALS['xoopsTpl']->assign('banner', $banner);

/* ----------------------------------------------------------------------- */
/*                              Render  variables                          */
/* ----------------------------------------------------------------------- */
$GLOBALS['xoopsTpl']->assign('submit',  _MD_EDITO_SUBMIT);
$GLOBALS['xoopsTpl']->assign('submitext',  _MD_EDITO_SUBMITEXT);
$GLOBALS['xoopsTpl']->assign('subject', _MD_EDITO_SUBJECT);
$GLOBALS['xoopsTpl']->assign('media',   _MD_EDITO_MEDIA);
$GLOBALS['xoopsTpl']->assign('text',    _MD_EDITO_TEXT);
$GLOBALS['xoopsTpl']->assign('footer',  $myts->displayTarea($GLOBALS['xoopsModuleConfig']['footer'], 1));

/* ----------------------------------------------------------------------- */
/*                             Admin links                                 */
/* ----------------------------------------------------------------------- */
$adminlinks = ''; //init administration links
if ($GLOBALS['xoopsUser'] && $GLOBALS['xoopsUser']->isAdmin($GLOBALS['xoopsModule']->mid())) {
    $adminlinks = "<a href='" . $helper->url('admin/edit_content.php?op=add') . "' title='" . _MD_EDITO_ADD . "'>
    			 <img src='" . $helper->url('assets/images/icon/add.gif') . "' alt='" . _MD_EDITO_ADD . "'></a> |
                 <a href='" . $helper->url('admin/index.php') . "' title='" . _MD_EDITO_LIST . "'>
                 <img src='" . $helper->url('assets/images/icon/list.gif') . "' alt='" . _MD_EDITO_LIST . "'></a> |
                 <a href='" . $helper->url('admin/utils_uploader.php') . "' title='" . _MD_EDITO_UTILITIES . "'>
                 <img src='" . $helper->url('assets/images/icon/utilities.gif') . "' alt='" . _MD_EDITO_UTILITIES . "'></a> |
                 <a href='../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=" . $GLOBALS['xoopsModule']->getVar('mid') . "' title='" . _MD_EDITO_SETTINGS . "'>
                 <img src='" . $helper->url('assets/images/icon/settings.gif') . "' alt='" . _MD_EDITO_SETTINGS . "'></a> |
                 <a href='" . $helper->url('admin/blocks/admin.php') . "' title='" . _MD_EDITO_BLOCKS . "'>
                 <img src='" . $helper->url('assets/images/icon/blocks.gif') . "' alt='" . _MD_EDITO_BLOCKS . "'></a> |
                 <a href='" . $helper->url('admin/help.php') . "' title='" . _MD_EDITO_HELP . "'>
                 <img src='" . $helper->url('assets/images/icon/help.gif') . "' alt='" . _MD_EDITO_HELP . "'></a></span>";
}

$GLOBALS['xoopsTpl']->assign('adminlinks', $adminlinks);

require_once XOOPS_ROOT_PATH . '/footer.php';
