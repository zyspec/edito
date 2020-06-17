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

include_once( "admin_header.php" );
include_once("../include/functions_mediasize.php");
include_once("../include/functions_content.php");

if (!isset($_POST["op"])) {
	$op = isset($_GET["op"]) ? $_GET["op"] : "";
} else {
	$op = $_POST["op"];
}

if (!isset($_POST["ord"])) {
	$ord = isset($_GET["ord"]) ? $_GET["ord"] : "";
} else {
	$ord = $_POST["ord"];
}

if (!isset($_POST["stat"])) {
	$stat = isset($_GET["stat"]) ? $_GET["stat"] : "";
} else {
	$stat = $_POST["stat"];
}


if ($ord == "" OR $ord == "id") {
	$ord = "id";
	$sort = "DESC";
	$ord_text = _MD_EDITO_ID;
}
if ($ord == "subject") {
	$sort = "ASC";
	$ord_text = _MD_EDITO_SUBJECT;
}
if ($ord == "media") {
	$sort = "ASC";
	$ord_text = _MD_EDITO_MEDIA;
}
if ($ord == "image") {
	$sort = "DESC";
	$ord_text = _MD_EDITO_IMAGE;
}
if ($ord == "counter") {
	$sort = "DESC";
	$ord_text = _MD_EDITO_COUNTER;
}
if ($ord == "body_text") {
	$sort = "ASC";
	$ord_text = _MD_EDITO_BODY;
}
if ($ord == "status") {
	$sort = "DESC";
	$ord_text = _MD_EDITO_STATUS;
}


switch ( $op ) {
	case "default":
	default:

    	$startart = isset( $HTTP_GET_VARS['startart'] ) ? intval( $HTTP_GET_VARS['startart'] ) : 0;
        if ( $startart ) { $start = '&startart='.$startart; } else { $start = ''; }

        $on		= '<a href="index.php?stat=on&ord='.$ord.$start.'">
				  <img src="../images/icon/online.gif"   alt="'._MD_EDITO_ONLINE.'"  align="absmiddle" /></a>';

        $off	= '<a href="index.php?stat=off&ord='.$ord.'">
				  <img src="../images/icon/offline.gif"  alt="'._MD_EDITO_OFFLINE.'" align="absmiddle" /></a>';

	$hide	= '<a href="index.php?stat=hide&ord='.$ord.'">
				  <img src="../images/icon/hidden.gif"   alt="'._MD_EDITO_HIDDEN.'"  align="absmiddle" /></a>';

        $html  = '<a href="index.php?stat=html&ord='.$ord.'">
				 <img src="../images/icon/html.gif"       alt="'._MD_EDITO_HTMLMODE.'"    align="absmiddle" /></a>';

	$php   = '<a href="index.php?stat=php&ord='.$ord.'">
				 <img src="../images/icon/php.gif"       alt="'._MD_EDITO_PHPMODE.'"    align="absmiddle" /></a>';

        $all	= '<a href="index.php?ord='.$ord.'">
				  <img src="../images/icon/all.gif"       alt="'._MD_EDITO_ALL.'"    align="absmiddle" /></a>';
				  
        $waiting	= '<a href="index.php?stat=waiting&ord='.$ord.'">
				  <img src="../images/icon/waiting.gif"       alt="'._MD_EDITO_WAITING.'"    align="absmiddle" /></a>';
				  $waiting_c = $waiting;

        $blank	= '<img src="../images/icon/blank.gif"     alt=""    align="absmiddle" />';

		if ( $stat == 'off' ) {
        	        $off = $blank;
                        $status = '=0';
                        $status_text = _MD_EDITO_OFFLINE;
		} elseif ( $stat == 'waiting' ) {
			$waiting = $blank;
			$status = '=1';
			$status_text = _MD_EDITO_WAITING;
		} elseif ( $stat == 'hide' ) {
        	        $hide = $blank;
                        $status = '=2';
                        $status_text = _MD_EDITO_HIDDEN;
		} elseif ( $stat == 'on' ) {
			$on = $blank;
                        $status = '=3';
                        $status_text = _MD_EDITO_ONLINE;
		} elseif ( $stat == 'html' ) {
        	        $html = $blank;
			$status = '=4';
			$status_text = _MD_EDITO_HTMLMODE;
		} elseif ( $stat == 'php' ) {
			$php = $blank;
			$status = '=5';
			$status_text = _MD_EDITO_PHPMODE;
		} else {
			$all = '';
			$status = '>=0';
			$status_text = _MD_EDITO_ALL;
		}
		

  // Count submited pages
		$sql =  " ( SELECT COUNT(id) FROM " . $xoopsDB -> prefix('content_'.$xoopsModule->dirname() )." WHERE status = 1 )";
                $result = $xoopsDB->queryF( $sql );
                list( $total_sub ) = $xoopsDB -> fetchRow( $result );
                if ( $total_sub ) { // $waiting_c = "|".$waiting_c ."=<b>". $total_sub . "</b>";
                                     $total_sub = " | <a href='index.php?stat=waiting&ord=".$ord."'>"._MD_EDITO_WAITING." : <b>". $total_sub . "</b></a>" .$waiting_c; }  else { $total_sub = ''; }

		edito_adminmenu(0, _MD_EDITO_LIST);
                include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
                if(edito_check_urw_htaccess()) { $urw=' | <img src="../images/icon/rewriting.gif" align="absmiddle" width="24" /> ' . _MD_EDITO_REWRITING; } elseif ($xoopsModuleConfig['url_rewriting']) { $urw=' | <a onmouseover="stm(Text[0],Style[0]);" onmouseout="htm();"><img src="../images/icon/important.gif" align="absmiddle" width="20"/><font style="color:red; font-weight:bold;">'._MD_EDITO_NOREWRITING.'</font></a>'; }  else { $urw=''; }
		// To create existing editos table
		echo '<div id="popdata" style="visibility:hidden; position:absolute; z-index:1000; top:-100"></div>';
		echo '<script language="JavaScript1.2" src="../script/popmenu.js" type="text/javascript"></script>';
		echo "<p style='text-align:left;'><b>"._MD_EDITO_ORDEREDBY.":</b> ".$ord_text." | ".$status_text.$urw.$total_sub."</p>";
		echo "<table width='100%' cellspacing=1 cellpadding=3 border=0 class='outer'>";
		echo "<tr>";

		echo "      <th width='40' class='bg3' align='center'>
					<a href='index.php?stat=$stat&ord=id$start'>    " . _MD_EDITO_ID . "</a></th>";

		echo "      <th width='65' class='bg3' align='center'>
		                        <a href='index.php?stat=$stat&ord=image$start'> " . _MD_EDITO_IMAGE . "</a></th>";

		echo "      <th width='60' class='bg3' align='center'>
					<a href='index.php?stat=$stat&ord=media$start'> " . _MD_EDITO_MEDIA . "</a></th>";

		echo "      <th width='20%' class='bg3' style='text-align:center; width:45%;'>
					<a href='index.php?stat=$stat&ord=subject$start'>" . _MD_EDITO_SUBJECT . "</a></th>";

		echo "      <th class='bg3' style='text-align:center; width:70px;' >
					<a href='index.php?stat=$stat&ord=counter$start'>" . _MD_EDITO_COUNTER . "</a></th>";

		echo "      <th class='bg3' style='text-align:center; width:70px;'>
					<a href='index.php?stat=$stat&ord=status$start'> " . _MD_EDITO_STATUS . "</a><br />
					".$all."<br />".$on.$hide.$off."<br />".$html.$php.$waiting."</th>";

		echo "      <th width='60' class='bg3' style='text-align:center; width:110px;'>
					<b>" . _MD_EDITO_ACTIONS . "</b></th>";

		echo "</tr>";

        // Check edito total
		$sql =  " ( SELECT COUNT(id) FROM " . $xoopsDB -> prefix('content_'.$xoopsModule->dirname() )." WHERE status".$status." ) ";
                $result = $xoopsDB->queryF( $sql );
                list( $total ) = $xoopsDB -> fetchRow( $result );

		$pagenav = new XoopsPageNav( $total, $xoopsModuleConfig['perpage'], $startart, 'stat='.$stat.'&ord='.$ord.'&startart' );

		if ( $total > 0 ) {				// That is, if there ARE editos in the system
			$sql = "SELECT id, subject, image, media, meta, counter, status
            		FROM " . $xoopsDB->prefix( 'content_'.$xoopsModule->dirname() )."
                    WHERE status".$status." ORDER BY ".$ord." ".$sort;

		$pop_sql = "SELECT id, uid, subject, left(block_text, 260) as xblock_text, left(body_text, 360) as xbody_text, datesub
					FROM " . $xoopsDB->prefix( 'content_'.$xoopsModule->dirname() )."
					WHERE status".$status." ORDER BY ".$ord." ".$sort;

		$result = $xoopsDB->queryF( $sql, $xoopsModuleConfig['perpage'], $startart );
		$pop_result = $xoopsDB->queryF( $pop_sql, $xoopsModuleConfig['perpage'], $startart );

		echo '
                <script language="JavaScript1.2"  type="text/javascript">
                Text[0]=["'._MD_EDITO_NOREWRITING.'","'._MD_EDITO_REWRITING_INFO.'"];
                     ';

        while ( list( $pop_id, $pop_uid, $pop_subject, $pop_xblock_text, $pop_xbody_text, $pop_date) = $xoopsDB -> fetchrow( $pop_result ) ) {
			$pop_xblock_text  = preg_replace( '/\[(.*)\]/sU', ' ', $pop_xblock_text);
            $pop_xblock_text  = strip_tags($myts->displayTarea($pop_xblock_text, 1, 1, 1));
            $pop_xbody_text   = preg_replace( '/\[(.*)\]/sU', ' ', $pop_xbody_text);
            $pop_xbody_text   = strip_tags($myts->displayTarea($pop_xbody_text, 1, 1, 1));
            $pop_text         = $pop_xblock_text.'<hr />'.$pop_xbody_text.'...';
            $pop_subject      = $myts->displayTarea($pop_subject, 1, 1, 1);

            echo '
            Text['.$pop_id.']=["'.XoopsUser::getUnameFromId($pop_uid).'&nbsp;&nbsp;&nbsp;'.formatTimestamp($pop_date,'m').'","'.addslashes($pop_text).'"];
            ';
		}
// The Style array parameters come in the following order
//		Style[...]=[titleColor,TitleBgColor,TitleBgImag,TitleTextAlign,TitleFontFace,TitleFontSize,
//		TextColor,TextBgColor,TextBgImag,TextTextAlign,TextFontFace,TextFontSize, Width,Height,BorderSize,BorderColor,Textpadding,transition number,Transition duration, Transparency level,shadow type,shadow color,Appearance behavior,TipPositionType,Xpos,Ypos]


        echo '
              Style[0]=["white","#2F5376","","","","","black","white","","center","",,300,,1,"#2F5376",2,,,95,2,"black",,,,];
              var TipId="popdata";
              var FiltersEnabled = 1;
              mig_clay();
              </script>
              ';


		while ( list( $id, $subject, $image, $media, $meta, $counter, $status ) = $xoopsDB -> fetchrow( $result ) ) {
        	$modify = "<a href='content.php?op=mod&id=".$id."' title='"._MD_EDITO_EDIT."'><img src=" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/edit.gif alt='"._MD_EDITO_EDIT."'></a>";
            $duplicate = "<a href='content.php?op=dup&id=".$id."' title='"._MD_EDITO_DUPLICATE."'><img src=" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/duplicate.gif alt='"._MD_EDITO_DUPLICATE."'></a>";
            $delete = "<a href='content.php?op=del&id=".$id."' title='"._MD_EDITO_DELETE."'><img src=" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/delete.gif alt='"._MD_EDITO_DELETE."'></a>";

            if ( $image ) {
              $logo = edito_createlink('../content.php?id='.$id, '', '_self',
                                        XOOPS_URL.'/'. $xoopsModuleConfig['sbuploaddir'] .'/'. $image, 'center', '90', '90',
                                        $subject, $xoopsModuleConfig['url_rewriting']);
            //	$logo =  '<a href="../content.php?id='.$id.'"><img src="'.XOOPS_URL . '/'. $xoopsModuleConfig['sbuploaddir'] .'/'. $image.'" width="60" alt="'. $image.'"/></a>';
            } else {
            	$logo = '';
            }
            
            if($urw) {
            $meta = explode("|", $meta);
            $meta_title       =  $meta[0];
//            $urw_url = '<br />'.edito_createlink('../content.php?id='.$id, $subject, '_self',
//                                          XOOPS_URL.'/modules/edito/images/icon/rewriting.gif', '', '', '',
//                                         $meta_title, $xoopsModuleConfig['url_rewriting']);
              $urw_url = '<a href="../'.edito_urw('content.php?id='.$id, $subject, $meta_title, $xoopsModuleConfig['url_rewriting']).'" title="'._MD_EDITO_REWRITING.'">
                          <img src="../images/icon/rewriting.gif" align="absmiddle" width="24" /></a>';
            } else { $urw_url=''; }


            $media  = explode("|", $media);
            if ( $media[0] ) {
            	$media_url  = XOOPS_URL . '/'. $xoopsModuleConfig['sbmediadir'] .'/'. $media[0];
                $format     = edito_checkformat( $media_url, $xoopsModuleConfig['custom_media'] );
                $filesize   = edito_fileweight( $media_url );
                $media_info = ' <a href="'.$media_url.'" target="_blank" title="'._MD_EDITO_MEDIALOCAL.' : '.$format[1].': '.$media[0].'  ['.$filesize.']">
                				<img src="../images/icon/'.$format[1].'.gif" alt="'._MD_EDITO_MEDIALOCAL.' : '.$format[1].': '.$media[0].'  ['.$filesize.']"/>
                                </a>';
			} elseif ( $media[1] ) {
				$media_url  = $media[1];
                $format     = edito_checkformat( $media_url, $xoopsModuleConfig['custom_media'] );
                $media_info = ' <a href="'.$media_url.'" target="_blank" title="'._MD_EDITO_MEDIAURL.' : '.$format[1].': '.$media[1].'">
								<img src="../images/icon/'.$format[1].'.gif" alt="'.$format[1].': '.$media[1].'" />
								<img src="../images/icon/ext.gif" alt="'._MD_EDITO_MEDIAURL.'"/>
								</a>';
			} else {
            	$media_info = '';
            }

            $subject    = $myts->displayTarea($subject, 1, 1, 1);

            echo "<tr>";
            echo "<td class='head' align='center'>  " . $id . "</td>";
            echo "<td class='even' align='center'>  " . $logo . "</td>";
            echo "<td class='even' align='center'>  " . $media_info. "</td>";
            echo "<td class='even' align='left'>    ".$urw_url."
                  <a onMouseOver='stm(Text[".$id."],Style[0])' onMouseOut='htm()' href='../content.php?id=$id'>
                 " . $subject . "</a></td>";
            echo "<td class='even' style='text-align:center; width:70px;'>" . $counter . "</td>";
			if ( $status == 0 ) {
				echo "<td class='even' style='text-align:right; width:70px;'><img src='../images/icon/offline.gif' alt='"._MD_EDITO_OFFLINE."'></td>";
			} elseif ( $status == 3 ) {
				echo "<td class='even' style='text-align:left; width:70px;'><img src='../images/icon/online.gif' alt='"._MD_EDITO_ONLINE."'></td>";
			} elseif ( $status == 2 ) {
				echo "<td class='even' style='text-align:center; width:70px;'><img src='../images/icon/hidden.gif' alt='"._MD_EDITO_HIDDEN."'></td>";
			} elseif ( $status == 4 ) {
				echo "<td class='even' style='text-align:right; width:70px;'><img src='../images/icon/html.gif' alt='"._MD_EDITO_HTMLMODE."'></td>";
			} elseif ( $status == 5 ) {
				echo "<td class='even' style='text-align:right; width:70px;'><img src='../images/icon/php.gif' alt='"._MD_EDITO_PHPMODE."'></td>";
			} elseif ( $status == 1 ) {
				echo "<td class='even' style='text-align:center; width:70px;'><img src='../images/icon/waiting.gif' alt='"._MD_EDITO_WAITING."'></td>";
			}

            echo "<td class='even' style='text-align:center; width:110px;'><nobr>". $modify . $duplicate . $delete."</nobr></td>";
			echo "</tr>";
		}
	} else {		// that is, $numrows = 0, there's no columns yet
    	echo "<tr>";
        echo "<td class='head' align='center' colspan= '8'>"._MD_EDITO_NO_EDITO."</td>";
        echo "</tr>";
	}

    echo "  <tr>
    		<td class='even' align='center' colspan='9'>
            <form name='addedito' method='post' action='content.php'>
            <input type='submit' name='go' value='"._MD_EDITO_CREATE."'>
            </form>
            </td>
            </tr>";
	echo "</table>\n";
	echo "<div style='text-align:right;'>" . $pagenav -> renderNav() . "</div>";
	echo "<br />\n";

}

include_once( 'admin_footer.php' );

?>