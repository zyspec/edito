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

require dirname(__DIR__, 2) . '/mainfile.php';
$com_itemid = Request::getInt('com_itemid', 0);
if (0 < $com_itemid) {
    $myts   = \MyTextSanitizer::getInstance();
    $sql    ='SELECT subject, uid, image, block_text, body_text, options, datesub FROM ' . $GLOBALS['xoopsDB']->prefix('edito_content') . ' WHERE id={$com_itemid} AND state > 0';
    $result = $GLOBALS['xoopsDB']->queryF($sql);
    $myrow 	= $GLOBALS['xoopsDB']->fetchArray($result);
    $image      = $myrow['image'];
    $info       = [];
    $option     = explode('|', $myrow['options']);
    $html       = $option[0];
    $xcode      = $option[1];
    $smiley     = $option[2];
    $logo       = $option[3];
    $block      = $option[4];
    $title      = $option[5];
    $cancomment = $option[6];

	if ( $image ) {
                require_once __DIR__ . '/include/functions_content.php';
		$logo =  $xoopsModuleConfig['sbuploaddir'] .'/'. $image;
		$image_size = explode('|', $xoopsModuleConfig['logo_size']);
		$logo = edito_createlink('', '', '', $logo, $xoopsModuleConfig['logo_align'], '800', '600', $myrow['subject']);
	} else {
		$logo = '';
	}


    $text = '';
    if($block) {
        $text .= $myrow['block_text'];
    }
    $text .= $myrow['body_text'];

    $com_replytext = _POSTEDBY . '&nbsp;<b>' . XoopsUser::getUnameFromId($myrow['uid']) . '</b>&nbsp;' . _DATE . '&nbsp;<b>' . formatTimestamp($myrow['datesub'], 'm') . '</b><br><br>' . $logo.$myts->displayTarea($text, $html, $smiley, $xcode);
    $com_replytitle = $myrow['subject'];

	include_once XOOPS_ROOT_PATH . '/include/comment_new.php';
}
