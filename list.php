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

if (!defined("XOOPS_ROOT_PATH")) { die("XOOPS root path not defined"); }

$count_list = 0;
$new_list = '';
$pop_list = '';
$readmore_list = '';

$result = "SELECT COUNT(*) FROM " . $xoopsDB -> prefix('content_'.$xoopsModule->dirname() ) . " WHERE status > 2";
list( $totals ) = $xoopsDB -> fetchRow( $xoopsDB->queryF($result) );

$total_list = $totals/$xoopsModuleConfig["columns"];
if( $totals > $xoopsModuleConfig['perpage'] ) {
	$readmore_list = '<div style="text-align:right;"><a href="index.php?startart='.$xoopsModuleConfig['perpage'].'">'._EDITO_READMORE.'</a></div>';
}

$xoopsTpl->assign('readmore', $readmore_list);

$sql = "SELECT id, subject, groups, datesub, counter, meta FROM ".$xoopsDB->prefix("content_" . $xoopsModule->dirname())."
		WHERE status > 2 ORDER BY " . $xoopsModuleConfig["order"];

$listing = $xoopsDB->queryF($sql, $xoopsModuleConfig['perpage'], 0 );

while(list( $ids, $subject_list, $groups_list, $datesub_list, $counter_list, $meta_list) = $xoopsDB->fetchRow($listing)) {
	$groups_list = explode(" ",$groups_list);
	if (count(array_intersect($group,$groups_list)) > 0 ) {

$meta_list = explode("|", $meta_list);
$meta_title_list       =  $meta_list[0];
if( $meta_title_list ) { $alt_subject_list=$meta_title_list; } else { $alt_subject_list=$subject_list; }
		$liste = array();

		/* ----------------------------------------------------------------------- */
		/*                            Display icons                                */
		/* ----------------------------------------------------------------------- */
		if ( $xoopsModuleConfig['tags'] ){
			$time = time();
            $startdate_list = (time()-(86400 * $xoopsModuleConfig['tags_new']));

			if ($startdate_list < $datesub_list) {
            	$datesub_list = formatTimestamp($datesub_list,'m');
                $new_list = '&nbsp;<img src="images/icon/new.gif" alt="'.$datesub_list_list.'" />';
            } else {
				$new_list ='';
         	}

			if ( $counter_list >= $xoopsModuleConfig['tags_pop'] ) {
				$pop_list = '&nbsp;<img src="images/icon/pop.gif" alt="'.$counter_list.'&nbsp;'._READS.'" />';
			} else {
				$pop_list ='';
			}
		}
		$liste['tag'] = $pop_list.$new_list;

		/* ----------------------------------------------------------------------- */
		/*                            List images                                  */
		/* ----------------------------------------------------------------------- */
		/*
		if ( $image ) {
			$logo =  '<img src="'.XOOPS_URL . '/'. $xoopsModuleConfig['sbuploaddir'] .'/'. $image.'" align="absmiddle" height="32" />';
		} else {
			$logo =  '<img src="images/blank.gif" align="absmiddle" height="32" />';
		}
		*/

		/* ----------------------------------------------------------------------- */
		/*                            List pages                                   */
		/* ----------------------------------------------------------------------- */
		if ( $count_list >= $total_list ) {
			$liste['cols'] = 1; $count_list = 1;
		} else {
			$liste['cols'] = 0; $count_list++;
		}
		$subject_list = $myts->displayTarea($subject_list);

        if ($ids != $id ) {
			$liste['link'] = "<nobr>" .edito_createlink('content.php?id='.$ids, $subject_list, '', '', '', '', '', $alt_subject_list, $xoopsModuleConfig['url_rewriting'])."</nobr>";
                        // "<a href='content.php?id=$ids' alt='".$alt_subject."'><nobr>" . $subject . "</nobr></a>";
		} else {
			$liste['link'] = "<nobr><i>". $subject_list . "</i></nobr>";
   		}

        $xoopsTpl->append('liste', $liste);
        unset($liste);
	}
}
?>