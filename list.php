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

defined('XOOPS_ROOT_PATH') || exit('Restricted access');

$count_list    = 0;
$new_list      = '';
$pop_list      = '';
$readmore_list = '';

$result         = "SELECT COUNT(*) FROM " . $GLOBALS['xoopsDB']->prefix($GLOBALS['xoopsModule']->dirname() . '_content') . " WHERE status > 2";
list( $totals ) = $GLOBALS['xoopsDB']->fetchRow($GLOBALS['xoopsDB']->queryF($result));

$total_list = $totals/$GLOBALS['xoopsModuleConfig']['columns'];
if( $totals > $GLOBALS['xoopsModuleConfig']['perpage'] ) {
	$readmore_list = '<div class="right"><a href="index.php?startart='.$GLOBALS['xoopsModuleConfig']['perpage'].'">' . _MD_EDITO_READMORE . '</a></div>';
}

$GLOBALS['xoopsTpl']->assign('readmore', $readmore_list);

$sql = "SELECT id, subject, groups, datesub, counter, meta FROM ".$GLOBALS['xoopsDB']->prefix($GLOBALS['xoopsModule']->dirname() . "_content")."
		WHERE status > 2 ORDER BY " . $GLOBALS['xoopsModuleConfig']['order'];

$listing = $GLOBALS['xoopsDB']->queryF($sql, $GLOBALS['xoopsModuleConfig']['perpage'], 0 );

while(list( $ids, $subject_list, $groups_list, $datesub_list, $counter_list, $meta_list) = $GLOBALS['xoopsDB']->fetchRow($listing)) {
	$groups_list = explode(" ",$groups_list);
	if (count(array_intersect($group,$groups_list)) > 0 ) {

$meta_list = explode("|", $meta_list);
$meta_title_list       =  $meta_list[0];
if( $meta_title_list ) { $alt_subject_list=$meta_title_list; } else { $alt_subject_list=$subject_list; }
		$liste = array();

		/* ----------------------------------------------------------------------- */
		/*                            Display icons                                */
		/* ----------------------------------------------------------------------- */
		if ($GLOBALS['xoopsModuleConfig']['tags']) {
			$time           = time();
            $startdate_list = ($time - (86400 * $GLOBALS['xoopsModuleConfig']['tags_new']));

            $new_list = '';
			if ($startdate_list < $datesub_list) {
            	$datesub_list = formatTimestamp($datesub_list, 'm');
                $new_list = '&nbsp;<img src="assets/images/icon/new.gif" alt="' . $datesub_list . '">';
         	}

         	$pop_list = '';
			if ($counter_list >= $GLOBALS['xoopsModuleConfig']['tags_pop']) {
				$pop_list = '&nbsp;<img src="assets/images/icon/pop.gif" alt="' . $counter_list . '&nbsp;' . _READS . '">';
			}
		}
		$liste['tag'] = $pop_list . $new_list;

		/* ----------------------------------------------------------------------- */
		/*                            List images                                  */
		/* ----------------------------------------------------------------------- */
		/*
		if ($image) {
			$logo =  '<img src="' . XOOPS_URL . '/'. $GLOBALS['xoopsModuleConfig']['sbuploaddir'] . '/' . $image . '" align="absmiddle" height="32">';
		} else {
			$logo =  '<img src="assets/images/blank.gif" align="absmiddle" height="32">';
		}
		*/

		/* ----------------------------------------------------------------------- */
		/*                            List pages                                   */
		/* ----------------------------------------------------------------------- */
		if ($count_list >= $total_list) {
			$liste['cols'] = 1;
			$count_list    = 1;
		} else {
			$liste['cols'] = 0;
			++$count_list;
		}
		$subject_list = $myts->displayTarea($subject_list);

        if ($ids != $id) {
			$liste['link'] = "<nobr>" .edito_createlink('content.php?id='.$ids, $subject_list, '', '', '', '', '', $alt_subject_list, $GLOBALS['xoopsModuleConfig']['url_rewriting'])."</nobr>";
                        // "<a href='content.php?id=$ids' alt='".$alt_subject."'><nobr>" . $subject . "</nobr></a>";
		} else {
			$liste['link'] = "<nobr><i>" . $subject_list . "</i></nobr>";
   		}

        $GLOBALS['xoopsTpl']->append('liste', $liste);
        unset($liste);
	}
}
