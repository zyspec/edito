<?php

declare(strict_types=1);

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
 * @copyright Copyright {@link https://xoops.org XOOPS Project}
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 * @author    Solo (http://www.wolfpackclan.com/wolfactory)
 * @author    DuGris (http://www.dugris.info)
 * @author    XOOPS Module Development Team
 * @link      https://github.com/XoopsModules25x/edito
 */

use Xmf\Request;

require_once __DIR__ . '/admin_header.php';
require_once dirname(__DIR__) . '/include/functions_mediasize.php';
require_once dirname(__DIR__) . '/include/functions_content.php';

$op   = Request::getCmd('op', 'default');
$ord  = Request::getCmd('ord', '');
$stat = Request::getCmd('stat', '');

switch ($ord) {
    default:
    case 'id':
        $ord      = 'id';
        $sort     = 'DESC';
        $ord_text = _AM_EDITO_ID;
        break;
    case 'subject':
        $sort     = 'ASC';
        $ord_text = _AM_EDITO_SUBJECT;
        break;
    case 'media':
        $sort     = 'ASC';
        $ord_text = _AM_EDITO_MEDIA;
        break;
    case 'image':
        $sort     = 'DESC';
        $ord_text = _AM_EDITO_IMAGE;
        break;
    case 'counter':
        $sort     = 'DESC';
        $ord_text = _AM_EDITO_COUNTER;
        break;
    case 'body_text':
        $sort     = 'ASC';
        $ord_text = _AM_EDITO_BODY;
        break;
    case 'status':
        $sort     = 'DESC';
        $ord_text = _AM_EDITO_STATUS;
        break;
}

switch ($op) {
    case 'default':
    default:
        $startart = Request::getInt('startart', 0, 'GET');
        $start    = $startart > 0 ? "&startart={$startart}" : '';

        $on      = "<a href='main.php?stat=on&ord={$ord}{$start}'>" . "<img src='../assets/images/icon/online.gif' alt='" . _AM_EDITO_ONLINE . "' class='middle'></a>\n";
        $off     = "<a href='main.php?stat=off&ord={$ord}'>" . "<img src='../assets/images/icon/offline.gif' alt='" . _AM_EDITO_OFFLINE . "' class='middle'></a>\n";
        $hide    = "<a href='main.php?stat=hide&ord={$ord}'>" . "<img src='../assets/images/icon/hidden.gif' alt='" . _AM_EDITO_HIDDEN . "' class='middle'></a>\n";
        $html    = "<a href='main.php?stat=html&ord={$ord}'>" . "<img src='../assets/images/icon/html.gif' alt='" . _AM_EDITO_HTMLMODE . "' class='middle'></a>\n";
        $php     = "<a href='main.php?stat=php&ord={$ord}'>" . "<img src='../assets/images/icon/php.gif' alt='" . _AM_EDITO_PHPMODE . "' class='middle'></a>\n";
        $all     = "<a href='main.php?ord={$ord}'>" . "<img src='../assets/images/icon/all.gif' alt='" . _AM_EDITO_ALL . "' class='middle'></a>\n";
        $waiting = "<a href='main.php?stat=waiting&ord={$ord}'>" . "<img src='../assets/images/icon/waiting.gif' alt='" . _AM_EDITO_WAITING . "' class='middle'></a>\n";

        $waiting_c = $waiting;
        $blank     = "<img src='../assets/images/icon/blank.gif'  alt='' class=''middle'>\n";

        switch ($stat) {
            case 'off':
                $off         = $blank;
                $status      = '=0';
                $status_text = _AM_EDITO_OFFLINE;
                break;
            case 'waiting':
                $waiting     = $blank;
                $status      = '=1';
                $status_text = _AM_EDITO_WAITING;
                break;
            case 'hide':
                $hide        = $blank;
                $status      = '=2';
                $status_text = _AM_EDITO_HIDDEN;
                break;
            case 'on':
                $on          = $blank;
                $status      = '=3';
                $status_text = _AM_EDITO_ONLINE;
                break;
            case 'html':
                $html        = $blank;
                $status      = '=4';
                $status_text = _AM_EDITO_HTMLMODE;
                break;
            case 'php':
                $php         = $blank;
                $status      = '=5';
                $status_text = _AM_EDITO_PHPMODE;
                break;
            default:
                $all         = '';
                $status      = '>=0';
                $status_text = _AM_EDITO_ALL;
        }

        // Count submited pages
        $sql    = ' ( SELECT COUNT(id) FROM ' . $xoopsDB->prefix($xoopsModule->dirname() . '_content') . ' WHERE status = 1)';
        $result = $xoopsDB->queryF($sql);
        [$total_sub] = $xoopsDB->fetchRow($result);
        if ($total_sub) { // $waiting_c = "|".$waiting_c ."=<b>". $total_sub . "</b>";
            $total_sub = " | <a href='main.php?stat=waiting&ord={$ord}'>" . _AM_EDITO_WAITING . " : <b>{$total_sub}</b></a>{$waiting_c}";
        } else {
            $total_sub = '';
        }

        edito_adminmenu(0, _AM_EDITO_LIST);
        require_once XOOPS_ROOT_PATH . '/class/pagenav.php';
        $urw = '';
        if (edito_check_urw_htaccess()) {
            $urw = " | <img src='../assets/images/icon/rewriting.gif' class='middle' width='24px;'> " . _AM_EDITO_REWRITING;
        } elseif ($xoopsModuleConfig['url_rewriting']) {
            $urw = " | <a onmouseover='stm(Text[0],Style[0]);' onmouseout='htm();'><img src='../assets/images/icon/important.gif' class='middle red bold' width='20px'>" . _AM_EDITO_NOREWRITING . '</a>';
        }
        // To create existing editos table
        echo '<div id="popdata" style="visibility:hidden; position:absolute; z-index:1000; top:-100"></div>';
        echo '<script language="JavaScript1.2" src="../assets/js/popmenu.js" type="text/javascript"></script>';
        echo "<p class='left'><b>" . _AM_EDITO_ORDEREDBY . ":</b> {$ord_text} | {$status_text}{$urw}{$total_sub}</p>";
        echo "<table cellspacing=1 cellpadding=3 class='outer bnone width100'>\n";
        echo "<tr>\n";
        echo "  <th class='bg3 center'><a href='main.php?stat={$stat}&ord=id{$start}'>    " . _AM_EDITO_ID . "</a></th>\n";
        echo "  <th width='65px' class='bg3 center'><a href='main.php?stat={$stat}&ord=image{$start}'> " . _AM_EDITO_IMAGE . "</a></th>\n";
        echo "  <th class='bg3 center width60'><a href='main.php?stat={$stat}&ord=media{$start}'> " . _AM_EDITO_MEDIA . "</a></th>\n";
        echo "  <th class='bg3 center width20'><a href='main.php?stat={$stat}&ord=subject{$start}'>" . _AM_EDITO_SUBJECT . "</a></th>\n";
        echo "  <th class='bg3 center' style='width:70px;'><a href='main.php?stat={$stat}&ord=counter{$start}'>" . _AM_EDITO_COUNTER . "</a></th>\n";
        echo "  <th class='bg3 center' style='width:70px;'><a href='main.php?stat={$stat}&ord=status{$start}'> " . _AM_EDITO_STATUS . "</a><br>\n" . "    {$all}<br>{$on}{$hide}{$off}<br>{$html}{$php}{$waiting}\n" . "  </th>\n";
        echo "  <th class='bg3 center bold' style='width:110px;'>" . _AM_EDITO_ACTIONS . "</th>\n";
        echo "</tr>\n";

        // Check edito total
        $sql    = ' SELECT COUNT(id) FROM ' . $xoopsDB->prefix($xoopsModule->dirname() . '_content') . " WHERE status{$status}";
        $result = $xoopsDB->queryF($sql);
        [$total] = $xoopsDB->fetchRow($result);

        $pagenav = new \XoopsPageNav($total, $xoopsModuleConfig['perpage'], $startart, "stat={$stat}&ord={$ord}&startart");

        if ($total > 0) {                // That is, if there ARE editos in the system
            $sql = 'SELECT id, subject, image, media, meta, counter, status
            		FROM ' . $xoopsDB->prefix($xoopsModule->dirname() . '_content') . '
                    WHERE status' . $status . ' ORDER BY ' . $ord . ' ' . $sort;

            $pop_sql = 'SELECT id, uid, subject, left(block_text, 260) as xblock_text, left(body_text, 360) as xbody_text, datesub
					FROM ' . $xoopsDB->prefix($xoopsModule->dirname() . '_content') . '
					WHERE status' . $status . ' ORDER BY ' . $ord . ' ' . $sort;

            $result = $xoopsDB->queryF($sql, $xoopsModuleConfig['perpage'], $startart);

            $pop_result = $xoopsDB->queryF($pop_sql, $xoopsModuleConfig['perpage'], $startart);

            echo '
                <script language="JavaScript1.2"  type="text/javascript">
                Text[0]=["' . _AM_EDITO_NOREWRITING . '","' . _AM_EDITO_REWRITING_INFO . '"];
                     ';

            while (list($pop_id, $pop_uid, $pop_subject, $pop_xblock_text, $pop_xbody_text, $pop_date) = $xoopsDB->fetchRow($pop_result)) {
                $pop_xblock_text = preg_replace('/\[(.*)\]/sU', ' ', $pop_xblock_text);

                $pop_xblock_text = strip_tags($myts->displayTarea($pop_xblock_text, 1, 1, 1));

                $pop_xbody_text = preg_replace('/\[(.*)\]/sU', ' ', $pop_xbody_text);

                $pop_xbody_text = strip_tags($myts->displayTarea($pop_xbody_text, 1, 1, 1));

                $pop_text = $pop_xblock_text . '<hr>' . $pop_xbody_text . '...';

                $pop_subject = $myts->displayTarea($pop_subject, 1, 1, 1);

                echo '
            Text[' . $pop_id . ']=["' . XoopsUser::getUnameFromId($pop_uid) . '&nbsp;&nbsp;&nbsp;' . formatTimestamp($pop_date, 'm') . '","' . addslashes($pop_text) . '"];
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

            while (list($id, $subject, $image, $media, $meta, $counter, $status) = $xoopsDB->fetchRow($result)) {
                $modify = "<a href='content.php?op=mod&id=" . $id . "' title='" . _AM_EDITO_EDIT . "'><img src=" . XOOPS_URL . '/modules/' . $xoopsModule->dirname() . "/assets/images/icon/edit.gif alt='" . _AM_EDITO_EDIT . "'></a>";

                $duplicate = "<a href='content.php?op=dup&id=" . $id . "' title='" . _AM_EDITO_DUPLICATE . "'><img src=" . XOOPS_URL . '/modules/' . $xoopsModule->dirname() . "/assets/images/icon/duplicate.gif alt='" . _AM_EDITO_DUPLICATE . "'></a>";

                $delete = "<a href='content.php?op=del&id=" . $id . "' title='" . _AM_EDITO_DELETE . "'><img src=" . XOOPS_URL . '/modules/' . $xoopsModule->dirname() . "/assets/images/icon/delete.gif alt='" . _AM_EDITO_DELETE . "'></a>";

                if ($image) {
                    $logo = edito_createlink('../content.php?id=' . $id, '', '_self', XOOPS_URL . '/' . $xoopsModuleConfig['sbuploaddir'] . '/' . $image, 'center', '90', '90', $subject, $xoopsModuleConfig['url_rewriting']);

                    //	$logo =  '<a href="../content.php?id='.$id.'"><img src="'.XOOPS_URL . '/'. $xoopsModuleConfig['sbuploaddir'] .'/'. $image.'" width="60" alt="'. $image.'"></a>';
                } else {
                    $logo = '';
                }

                if ($urw) {
                    $meta = explode('|', $meta);

                    $meta_title = $meta[0];
                    //            $urw_url = '<br>'.edito_createlink('../content.php?id='.$id, $subject, '_self',
                    //                                          XOOPS_URL.'/modules/edito/assets/images/icon/rewriting.gif', '', '', '',
                    //                                         $meta_title, $xoopsModuleConfig['url_rewriting']);

                    $urw_url = '<a href="../' . edito_urw('content.php?id=' . $id, $subject, $meta_title, $xoopsModuleConfig['url_rewriting']) . '" title="' . _AM_EDITO_REWRITING . '">
                          <img src="../assets/images/icon/rewriting.gif" align="absmiddle" width="24"></a>';
                } else {
                    $urw_url = '';
                }

                $media = explode('|', $media);

                if ($media[0]) {
                    $media_url = XOOPS_URL . '/' . $xoopsModuleConfig['sbmediadir'] . '/' . $media[0];

                    $format = edito_checkformat($media_url, $xoopsModuleConfig['custom_media']);

                    $filesize = edito_fileweight($media_url);

                    $media_info = ' <a href="' . $media_url . '" target="_blank" title="' . _AM_EDITO_MEDIALOCAL . ' : ' . $format[1] . ': ' . $media[0] . '  [' . $filesize . ']">
                				<img src="../assets/images/icon/' . $format[1] . '.gif" alt="' . _AM_EDITO_MEDIALOCAL . ' : ' . $format[1] . ': ' . $media[0] . '  [' . $filesize . ']">
                                </a>';
                } elseif ($media[1]) {
                    $media_url = $media[1];

                    $format = edito_checkformat($media_url, $xoopsModuleConfig['custom_media']);

                    $media_info = ' <a href="' . $media_url . '" target="_blank" title="' . _AM_EDITO_MEDIAURL . ' : ' . $format[1] . ': ' . $media[1] . '">
								<img src="../assets/images/icon/' . $format[1] . '.gif" alt="' . $format[1] . ': ' . $media[1] . '">
								<img src="../assets/images/icon/ext.gif" alt="' . _AM_EDITO_MEDIAURL . '">
								</a>';
                } else {
                    $media_info = '';
                }

                $subject = $myts->displayTarea($subject, 1, 1, 1);

                echo '<tr>';

                echo "<td class='head' align='center'>  " . $id . '</td>';

                echo "<td class='even' align='center'>  " . $logo . '</td>';

                echo "<td class='even' align='center'>  " . $media_info . '</td>';

                echo "<td class='even' align='left'>    " . $urw_url . "
                  <a onMouseOver='stm(Text[" . $id . "],Style[0])' onMouseOut='htm()' href='../content.php?id=$id'>
                 " . $subject . '</a></td>';

                echo "<td class='even' style='text-align:center; width:70px;'>" . $counter . '</td>';

                if (0 == $status) {
                    echo "<td class='even' style='text-align:right; width:70px;'><img src='../assets/images/icon/offline.gif' alt='" . _AM_EDITO_OFFLINE . "'></td>";
                } elseif (3 == $status) {
                    echo "<td class='even' style='text-align:left; width:70px;'><img src='../assets/images/icon/online.gif' alt='" . _AM_EDITO_ONLINE . "'></td>";
                } elseif (2 == $status) {
                    echo "<td class='even' style='text-align:center; width:70px;'><img src='../assets/images/icon/hidden.gif' alt='" . _AM_EDITO_HIDDEN . "'></td>";
                } elseif (4 == $status) {
                    echo "<td class='even' style='text-align:right; width:70px;'><img src='../assets/images/icon/html.gif' alt='" . _AM_EDITO_HTMLMODE . "'></td>";
                } elseif (5 == $status) {
                    echo "<td class='even' style='text-align:right; width:70px;'><img src='../assets/images/icon/php.gif' alt='" . _AM_EDITO_PHPMODE . "'></td>";
                } elseif (1 == $status) {
                    echo "<td class='even' style='text-align:center; width:70px;'><img src='../assets/images/icon/waiting.gif' alt='" . _AM_EDITO_WAITING . "'></td>";
                }

                echo "<td class='even' style='text-align:center; width:110px;'><nobr>" . $modify . $duplicate . $delete . '</nobr></td>';

                echo '</tr>';
            }
        } else {        // that is, $numrows = 0, there's no columns yet
            echo '<tr>';

            echo "<td class='head' align='center' colspan= '8'>" . _AM_EDITO_NO_EDITO . '</td>';

            echo '</tr>';
        }

        echo "  <tr>
    		<td class='even' align='center' colspan='9'>
            <form name='addedito' method='post' action='content.php'>
            <input type='submit' name='go' value='" . _AM_EDITO_CREATE . "'>
            </form>
            </td>
            </tr>";
        echo "</table>\n";
        echo "<div style='text-align:right;'>" . $pagenav->renderNav() . '</div>';
        echo "<br>\n";
}

require_once __DIR__ . '/admin_footer.php';
