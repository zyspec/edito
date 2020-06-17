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


function edito_search($queryarray, $andor, $limit, $offset, $userid){
	global $xoopsDB, $xoopsUser;
	$sql = "SELECT id, uid, subject, datesub, groups  FROM ".$xoopsDB->prefix("content_edito")." WHERE status > 0 ";

	if ( $userid != 0 ) {
		$sql .= " AND uid=".$userid." ";
	}
	// because count() returns 1 even if a supplied variable
	// is not an array, we must check if $querryarray is really an array
	if ( is_array($queryarray) && $count = count($queryarray) ) {
		$sql .= " AND ((block_text LIKE '%$queryarray[0]%' OR body_text LIKE '%$queryarray[0]%'  OR subject LIKE '%$queryarray[0]%')";
		for($i=1;$i<$count;$i++){
			$sql .= " $andor ";
			$sql .= "((block_text LIKE '%$queryarray[0]%' OR body_text LIKE '%$queryarray[0]%'  OR subject LIKE '%$queryarray[0]%')";
		}
		$sql .= ") ";
	}
	$sql .= "ORDER BY datesub DESC";
	$result = $xoopsDB->queryF($sql,$limit,$offset);
	$ret = array();
	$i = 0;

	$group = is_object($xoopsUser) ? $xoopsUser->getGroups() : array(XOOPS_GROUP_ANONYMOUS);
 	while($myrow = $xoopsDB->fetchArray($result))
 	{
		$groups = explode(" ",$myrow['groups']);
		if (count(array_intersect($group,$groups)) > 0)
		{
			$ret[$i]['image'] = "images/content.gif";
			$ret[$i]['link'] = "content.php?id=".$myrow['id']."";
			$ret[$i]['title'] = $myrow['subject'];
			$ret[$i]['time'] = $myrow['datesub'];
			$ret[$i]['uid'] = $myrow['uid'];
			$i++;
		}
	}
	return $ret;
}
?>