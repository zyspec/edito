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

$sql    = "SELECT media, groups FROM " . $GLOBALS['xoopsDB']->prefix($GLOBALS['xoopsModule']->dirname() . '_content' )." WHERE id = {$id} AND status != 0 ";
$result = $GLOBALS['xoopsDB']->queryF($sql);

// Does edito exist?
if (0 >= $GLOBALS['xoopsDB']->getRowsNum($result)) {
    // edito can't be found
	redirect_header('index.php', 2, _MD_EDITO_NOT_FOUND);
}

$myrow 	= $GLOBALS['xoopsDB']->fetchArray($result);
$info = [];

// Groups permission
$group  = is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->getGroups() : [XOOPS_GROUP_ANONYMOUS];
$groups = explode(' ', $myrow['groups']);
if (0 >= count(array_intersect($group,$groups))) {
	redirect_header('index.php', 2, _NOPERM);
}

// Retrieve options data
$media      = explode('|', $myrow['media']);
$media_file =  $media[0];
$media_url  =  $media[1];

if ($media_file) {
	$media_url =  XOOPS_URL . '/'. $GLOBALS['xoopsModuleConfig']['sbmediadir'] . '/' . $media_file;
}

// Image align

/* ----------------------------------------------------------------------- */
/*                              Download media                             */
/* ----------------------------------------------------------------------- */

   header('Pragma: anytextexeptno-cache', true);
   header('Content-type: application/force-download');
   header('Content-Transfer-Encoding: Binary');
   header('Content-length: ' . filesize($media_url));
   header('Content-disposition: attachment;
   filename=' . basename($media_url));
   readfile($file);
