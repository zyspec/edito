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

// Script used to display a media in a pop up

require_once __DIR__ . '/header.php';

$id = Request::getInt('id', 0);

if (0 >= $id) {
	redirect_header('index.php', 2, _MD_EDITO_PL_SELECT);
}

require_once XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->dirname() . '/include/functions_media.php';
require_once XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->dirname() . '/include/functions_mediasize.php';
require_once XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->dirname() . '/include/functions_block.php';

$sql    = "SELECT * FROM " . $GLOBALS['xoopsDB']->prefix( $GLOBALS['xoopsModule']->dirname() . '_content' )." WHERE id = {$id} AND  state != 0 ";
$result = $GLOBALS['xoopsDB']->queryF($sql);

// Does edito exist?
if (0 >= $GLOBALS['xoopsDB']->getRowsNum($result)) {
    // edito can't be found
	redirect_header('index.php', 2, _MD_EDITO_NOT_FOUND);
}

$myrow 	= $GLOBALS['xoopsDB']->fetchArray($result);
$info   = [];

// Groups permission
$group  = is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->getGroups() : [XOOPS_GROUP_ANONYMOUS];
$groups = explode(' ', $myrow['groups']);
if (0 >= count(array_intersect($group, $groups))) {
    // user does not have permission
	redirect_header('index.php', 2, _NOPERM);
}

// Retrieve options data
$media      = explode('|', $myrow['media']);
$media_file = $media[0];
$media_url  = $media[1];
$media_size = $media[2];

$meta             = explode('|', $myrow['meta']);
$meta_title       = $meta[0];
$meta_description = $meta[1];
$meta_keywords    = $meta[2];

$option     = explode('|', $myrow['options']);
$html       = $option[0];
$xcode      = $option[1];
$smiley     = $option[2];
$logo       = $option[3];
$block      = $option[4];
$title      = $option[5];
$cancomment = $option[6];

// Display title
$subject = '';
if ($title) {
	$subject = '<h3 style="color:#FFF;">' . $myts->displayTarea($myrow['subject']) . '</h3>';
}

// Media
$option .= 'AutoStart=1, ShowControls=1, ShowTracker=1, AnimationAtStart=1, TransparentAtStart=0, enableContextMenu=0, BufferingProgress=1, PreBuffer=1, VideoDelay=999, VideoBufferSize=9, align=' . $GLOBALS['xoopsModuleConfig']['logo_align'];

if ($GLOBALS['xoopsModuleConfig']['repeat']) {
	$option .= ', Loop=1';
}

// Image align
if ('center' === $GLOBALS['xoopsModuleConfig']['logo_align']) {
	$image_align = '';
	$align       = '<div align="center">';
	$align02     = '</div>';
} else {
	$image_align = 'align="' . $GLOBALS['xoopsModuleConfig']['logo_align'] . '"';
	$align       = '';
	$align02     = '';
}

$media_display = edito_media_size($media_size, $GLOBALS['xoopsModuleConfig']['custom']);
if ($media_file) {
	$media_url =  XOOPS_URL . '/'. $GLOBALS['xoopsModuleConfig']['sbmediadir'] . '/' . $media_file;
}

$media_data = edito_media($media_url, '', $media_display, $option, $myrow['subject'], $GLOBALS['xoopsModuleConfig']['custom_media']);
$logo       = '';
if ($myrow['image'] && $logo) {
	$logo = $align . '<img src="' . XOOPS_URL . '/' . $GLOBALS['xoopsModuleConfig']['sbuploaddir'] . '/' . $myrow['image'] . '"
            alt="' . $myrow['subject'] . '" ' . $image_align . '><br>' . $align02;
}

/* ----------------------------------------------------------------------- */
/*                              Display Result                             */
/* ----------------------------------------------------------------------- */

echo "<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'>\n";
echo "<html>\n<head>\n";
echo "<meta http-equiv='Content-Type' content='text/html; charset=" . _CHARSET . "' />\n";
echo "<meta name='AUTHOR' content='" . $GLOBALS['xoopsConfig']['sitename'] . "' />\n";
echo "<meta name='COPYRIGHT' content='Copyright (c) 2021 by " . $GLOBALS['xoopsConfig']['sitename'] . "' />\n";
echo "<meta name='DESCRIPTION' content='" . $xoopsConfig ['slogan'] . "' />\n";
echo "<meta name='GENERATOR' content='" . XOOPS_VERSION . "' />\n";
echo "<title>" . strip_tags($myrow['subject']) . "</title>\n";
echo "</head>\n\n\n";
echo "<link rel='stylesheet' type='text/css' media='screen' href='../../xoops.css' />\n";
echo "<link rel='stylesheet' type='text/css' media='screen' href='../../themes/" . $GLOBALS['xoopsConfig']['theme_set'] . "/styleNN.css' />\n";
echo '<body style="background-color:black;">';
echo '<div class="center">';
// echo $logo;
echo $subject;
echo $media_data . '<br>';
echo '<form action="0">
	  <input type="button" value="' . _MD_EDITO_CLOSE . '" onclick="self.close()">
      </form>';
echo '</div>';
echo '</body>';
