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

// Script used to print an edito's content
require_once dirname(__DIR__, 2) . '/mainfile.php';

$id = Request::getInt('id', 0);

if (0 == $id) {
	redirect_header('index.php', 2, _MD_EDITO_PL_SELECT);
}

$myts = MyTextSanitizer::getInstance();

/* ----------------------------------------------------------------------- */
/*                              Render Query                               */
/* ----------------------------------------------------------------------- */

$sql = "SELECT uid, groups, options, block_text, body_text, image, subject, datesub
		FROM " . $GLOBALS['xoopsDB']->prefix($GLOBALS['xoopsModule']->dirname() . "_content")."
        WHERE id={$id} AND status > 0 AND status < 4";

$result = $GLOBALS['xoopsDB']->queryF($sql);

if (0 >= $GLOBALS['xoopsDB']->getRowsNum($result)) { // Edito can't be found
	redirect_header('index.php', 2, _MD_EDITO_NOT_FOUND);
}

$myrow 	= $GLOBALS['xoopsDB']->fetchArray($result);

/* ----------------------------------------------------------------------- */
/*                              Check group permission                     */
/* ----------------------------------------------------------------------- */
$group  = is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->getGroups() : [XOOPS_GROUP_ANONYMOUS];
$groups = explode(' ', $myrow['groups']);
if (0 >= count(array_intersect($group, $groups))) {
	redirect_header('index.php', 2, _NOPERM);
}

/* ----------------------------------------------------------------------- */
/*                              Create Datas                               */
/* ----------------------------------------------------------------------- */
$option     = explode('|', $myrow['options']);
$html       = $option[0];
$xcode      = $option[1];
$smiley     = $option[2];
$logo       = $option[3];
$block      = $option[4];
$title      = $option[5];
$cancomment = $option[6];

/*
if ( $xoopsModuleConfig["index_logo"] ) {
$banner = '<img src="'.$xoopsModuleConfig ["index_logo"].'" alt="'.$xoopsModule -> getVar( 'name' ).'">'; } else {
$banner = '';}
*/

$subject  = $myts->displayTarea($myrow['subject']);
$username = XoopsUser::getUnameFromId($myrow['uid']);
$date     = formatTimestamp($myrow['datesub'], 'm');

/* ----------------------------------------------------------------------- */
/*                              Create Logo                                */
/* ----------------------------------------------------------------------- */
$logo = '';
if ('center' != $GLOBALS['xoopsModuleConfig']['logo_align'] && $myrow['image'] && $logo) {
	$logo_align  = "align='" . $GLOBALS['xoopsModuleConfig']['logo_align'] . "'";
	$logo        =  "<img src='" . XOOPS_URL . "/" . $GLOBALS['xoopsModuleConfig']['sbuploaddir'] . "/" . $myrow['image'] . "' {$logo_align}>";
} elseif ('center' == $GLOBALS['xoopsModuleConfig']['logo_align'] && $myrow['image'] && $logo) {
	$logo = "<div align='center'><img src='" . XOOPS_URL . "/" . $GLOBALS['xoopsModuleConfig']['sbuploaddir'] . "/" . $myrow['image'] . "'></div>";
}

/* ----------------------------------------------------------------------- */
/*                              Create Text                                */
/* ----------------------------------------------------------------------- */
$bodytext = '';
if ($block) {
    $bodytext .= $myrow['block_text'];
}

$bodytext .= str_replace('[pagebreak]', '', $myrow['body_text']);
$bodytext =  $myts->displayTarea($bodytext, $html, $smiley, $xcode);

/* ----------------------------------------------------------------------- */
/*                              Display Result                             */
/* ----------------------------------------------------------------------- */
$original_level = error_reporting();
error_reporting(0); // turn off error reporting
echo "<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'>\n";
echo "<html>\n<head>\n";
echo "<title>" . _MD_EDITO_COMEFROM . " " . $GLOBALS['xoopsConfig']['sitename'] . "</title>\n";
echo "<meta http-equiv='Content-Type' content='text/html; charset=" . _CHARSET . "' />\n";
echo "<meta name='AUTHOR' content='" . $GLOBALS['xoopsConfig']['sitename'] . "' />\n";
echo "<meta name='COPYRIGHT' content='Copyright (c) 2001 by " . $GLOBALS['xoopsConfig']['sitename'] . "' />\n";
echo "<meta name='DESCRIPTION' content='" . $GLOBALS['xoopsConfig']['slogan'] . "' />\n";
echo "<meta name='GENERATOR' content='" . XOOPS_VERSION . "' />\n";
echo "</head>\n\n\n";

echo "<body bgcolor='#ffffff' text='#000000' onload='window.print()'>
	  <div style='width: 650px; border: 1px solid #000; padding: 20px; text-align: left; display: block; margin: 0 0 6px 0;'>
      " . $logo ."
      <div align='center'><h3>{$subject}</h3></div>
      <div>{$bodytext}</div>
      <div style='padding-top: 12px; border-bottom: 2px solid #ccc;'></div>
      <div style='text-align:center;'>
      <font size='1'>
      " . _MD_EDITO_COMEFROM . $GLOBALS['xoopsConfig']['sitename'] ." : " . XOOPS_URL . "/modules/" . $GLOBALS['xoopsModule']->dirname() . "/content.php?id={$id}<br>
      " . $username . " " . $date . "
      </font></div>
      </div>";
echo "</body>
     </html>";
error_reporting($original_level); // restore error reporting level