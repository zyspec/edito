<?php declare(strict_types=1);
// ------------------------------------------------------------------------- //
//                            myblocksadmin.php                              //
//                - XOOPS block admin for each modules -                     //
//                          GIJOE <http://www.peak.ne.jp>                   //
// ------------------------------------------------------------------------- //

use Xmf\Request;

require_once dirname(__DIR__, 3) . '/include/cp_header.php';
require_once dirname(__DIR__) . '/class/EditoGroupPermForm.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsblock.php';

// check $xoopsModule
if (!is_object($xoopsModule)) {
    redirect_header(XOOPS_URL . '/user.php', 1, _NOPERM);
}

$xoops_system_path = XOOPS_ROOT_PATH . '/modules/system';

// language files
$language = $xoopsConfig['language'];
if (!file_exists("{$xoops_system_path}/language/{$language}/admin/blocksadmin.php")) {
    $language = 'english';
}

// to prevent from notice that constants already defined
$error_reporting_level = error_reporting(0);
require_once "{$xoops_system_path}/constants.php";
require_once "{$xoops_system_path}/language/{$language}/admin.php";
require_once "{$xoops_system_path}/language/{$language}/admin/blocksadmin.php";
require_once "{$xoops_system_path}/language/{$language}/admin/groups.php";
error_reporting($error_reporting_level);

// set target_module if specified by $_GET['dirname']
$moduleHandler = xoops_getHandler('module');
if (!empty($_GET['dirname'])) {
    $target_module = $moduleHandler->getByDirname(Request::getPath('dirname', '', 'GET'));
}/* else if( ! empty( $_GET['mid'] ) ) {
    $target_module = $moduleHandler->get( intval( $_GET['mid'] ) );
}*/

if (!empty($target_module) && is_object($target_module)) {
    // specified by dirname

    $target_mid = $target_module->getVar('mid');

    $target_mname = $target_module->getVar('name') . '&nbsp;' . sprintf('(%2.2f)', $target_module->getVar('version') / 100.0);

    $query4redirect = '?dirname=' . urlencode(strip_tags(Request::getPath('dirname', '', 'GET')));
} elseif (Request::hasVar('mid', 'GET') && (0 == Request::getInt('mid', 0, 'GET')) || 'blocksadmin' == $GLOBALS['xoopsModule']->getVar('dirname')) {
    $target_mid = 0;

    $target_mname = '';

    $query4redirect = '?mid=0';
} else {
    $target_mid = $GLOBALS['xoopsModule']->getVar('mid');

    $target_mname = $GLOBALS['xoopsModule']->getVar('name');

    $query4redirect = '';
}

// check access right (needs system_admin of BLOCK)
$syspermHandler = xoops_getHandler('groupperm');
if (!$syspermHandler->checkRight('system_admin', XOOPS_SYSTEM_BLOCK, $xoopsUser->getGroups())) {
    redirect_header(XOOPS_URL . '/user.php', 1, _NOPERM);
}

// get blocks owned by the module (Imported from xoopsblock.php then modified)
//$block_arr = XoopsBlock::getByModule( $target_mid ) ;
$db        = \XoopsDatabaseFactory::getDatabaseConnection();
$sql       = 'SELECT * FROM ' . $db->prefix('newblocks') . " WHERE mid='$target_mid' ORDER BY visible DESC,side,weight";
$result    = $db->query($sql);
$block_arr = [];
while (false !== ($myrow = $db->fetchArray($result))) {
    $block_arr[] = new XoopsBlock($myrow);
}

function list_blocks()
{
    global $query4redirect, $block_arr;

    // cachetime options

    $cachetimes = [
        '0'       => _NOCACHE,
        '30'      => sprintf(_SECONDS, 30),
        '60'      => _MINUTE,
        '300'     => sprintf(_MINUTES, 5),
        '1800'    => sprintf(_MINUTES, 30),
        '3600'    => _HOUR,
        '18000'   => sprintf(_HOURS, 5),
        '86400'   => _DAY,
        '259200'  => sprintf(_DAYS, 3),
        '604800'  => _WEEK,
        '2592000' => _MONTH,
    ];

    // displaying TH

    echo "
	<style>
        .radio { border: 0px; }
    </style>
	<form action='blocks/admin.php' name='blockadmin' method='post'>
		<table class='outer width100' cellpadding='4' cellspacing='1'>
		<tr class='middle'>
			<th>" . _AM_SYSTEM_BLOCKS_TITLE . "</th>
			<th class='center' nowrap='nowrap'>" . _AM_SYSTEM_BLOCKS_TYPE . "</th>
			<th class='center'>" . _AM_SYSTEM_BLOCKS_WEIGHT . "</th>
			<th class='center'>" . _AM_SYSTEM_BLOCKS_VISIBLEIN . "</th>
			<th class='center'>" . _AM_SYSTEM_BLOCKS_BCACHETIME . "</th>
			<th class='right'>" . _AM_SYSTEM_GROUPS_ACTION . "</th>
		</tr>\n";

    // blocks displaying loop

    $class = 'even';

    //$block_configs = get_block_configs();

    $error_reporting_level = error_reporting(0);

    if (preg_match('/^[.0-9A-Z_-]+$/i', Request::getPath('dirname', '', 'GET'))) {
        include dirname(__DIR__, 3) . '/' . Request::getPath('dirname', '', 'GET') . '/xoops_version.php';
    } else {
        require dirname(__DIR__) . '/xoops_version.php';
    }

    error_reporting($error_reporting_level);

    $block_configs = empty($modversion['blocks']) ? [] : $modversion['blocks'];

    foreach (array_keys($block_arr) as $i) {
        $sseln = $ssel0 = $ssel1 = $ssel2 = $ssel3 = $ssel4 = $ssel5 = $ssel6 = $ssel7 = '';

        $scoln = $scol0 = $scol1 = $scol2 = $scol3 = $scol4 = $scol5 = $scol6 = $scol7 = 'transparent';

        $weight = $block_arr[$i]->getVar('weight');

        $title = $block_arr[$i]->getVar('title');

        $name = $block_arr[$i]->getVar('name');

        $bcachetime = $block_arr[$i]->getVar('bcachetime');

        $bid = $block_arr[$i]->getVar('bid');

        // visible and side

        if (1 != $block_arr[$i]->getVar('visible')) {
            $sseln = ' checked';

            $scoln = 'black';
        } else {
            switch ($block_arr[$i]->getVar('side')) {
                default:
                case XOOPS_SIDEBLOCK_LEFT:
                    $ssel0 = ' checked';
                    $scol0 = 'gray';
                    break;
                case XOOPS_SIDEBLOCK_RIGHT:
                    $ssel1 = ' checked';
                    $scol1 = 'gray';
                    break;
                case XOOPS_CENTERBLOCK_LEFT:
                    $ssel2 = ' checked';
                    $scol2 = 'gray';
                    break;
                case XOOPS_CENTERBLOCK_RIGHT:
                    $ssel4 = ' checked';
                    $scol4 = 'gray';
                    break;
                case XOOPS_CENTERBLOCK_CENTER:
                    $ssel3 = ' checked';
                    $scol3 = 'gray';
                    break;
                case XOOPS_CENTERBLOCK_BOTTOMLEFT:
                    $ssel5 = ' checked';
                    $scol5 = 'gray';
                    break;
                case XOOPS_CENTERBLOCK_BOTTOMRIGHT:
                    $ssel6 = 'checked';
                    $scol6 = 'gray';
                    break;
                case XOOPS_CENTERBLOCK_BOTTOM:
                    $ssel7 = 'checked';
                    $scol7 = 'gray';
                    break;
            }
        }

        // bcachetime

        $cachetime_options = '';

        foreach ($cachetimes as $cachetime => $cachetime_name) {
            if ($bcachetime == $cachetime) {
                $cachetime_options .= "<option value='$cachetime' selected>$cachetime_name</option>\n";
            } else {
                $cachetime_options .= "<option value='$cachetime'>$cachetime_name</option>\n";
            }
        }

        // target modules

        $db = \XoopsDatabaseFactory::getDatabaseConnection();

        $result = $db->query('SELECT module_id FROM ' . $db->prefix('block_module_link') . " WHERE block_id='$bid'");

        $selected_mids = [];

        while (list($selected_mid) = $db->fetchRow($result)) {
            $selected_mids[] = (int)$selected_mid;
        }

        $moduleHandler = xoops_getHandler('module');

        $criteria = new CriteriaCompo(new Criteria('hasmain', 1));

        $criteria->add(new Criteria('isactive', 1));

        $module_list = $moduleHandler->getList($criteria);

        $module_list[-1] = _AM_SYSTEM_BLOCKS_TOPPAGE;

        $module_list[0] = _AM_SYSTEM_BLOCKS_ALLPAGES;

        ksort($module_list);

        $module_options = '';

        foreach ($module_list as $mid => $mname) {
            if (in_array($mid, $selected_mids, true)) {
                $module_options .= "<option value='{$mid}' selected='selected'>{$mname}</option>\n";
            } else {
                $module_options .= "<option value='{$mid}'>{$mname}</option>\n";
            }
        }

        // delete link if it is cloned block

        if ('D' == $block_arr[$i]->getVar('block_type') || 'C' == $block_arr[$i]->getVar('block_type')) {
            $delete_link = "<br><a href='" . XOOPS_URL . "/system/admin.php?fct=blocksadmin&amp;op=delete&amp;bid={$bid}'>" . _DELETE . '</a>';

            //$delete_link = "<br><a href='blocks/admin.php?fct=blocksadmin&amp;op=delete&amp;bid={$bid}'>" . _DELETE . "</a>";

            $can_clone = true;
        } else {
            $delete_link = '';

            $can_clone = false;

            // clone link if it is marked as cloneable block

            foreach ($block_configs as $bconf) {
                if ($block_arr[$i]->getVar('show_func') == $bconf['show_func'] && $block_arr[$i]->getVar('func_file') == $bconf['file'] && (empty($bconf['template']) || $block_arr[$i]->getVar('template') == $bconf['template'])) {
                    if (!empty($bconf['can_clone'])) {
                        $can_clone = true;
                    }
                }
            }
        }

        $clone_link = $can_clone ? "<br><a href='" . XOOPS_URL . "/modulessystem/admin.php?fct=blocksadmin&amp;op=clone&amp;bid={$bid}'>" . _CLONE . '</a>' : '';

        //$clone_link = $can_clone ? "<br><a href='blocks/admin.php?fct=blocksadmin&amp;op=clone&amp;bid={$bid}'>" . _CLONE . "</a>" : '';

        // displaying part

        echo "
		<tr class='middle'>
			<td class='{$class}'>
				$name
				<br>
				<input type='text' name='title[{$bid}]' value='{$title}' size='20'>
			</td>
			<td class='{$class} center' nowrap='nowrap' width='125px'>";

        //if (substr(XOOPS_VERSION , 10 , 2) >= 14 ) {

        echo "
               	<div class='center'>
           	        <input class='radio' style='background-color:{$scol2};' type='radio' name='side[{$bid}]' value='" . XOOPS_CENTERBLOCK_LEFT . "'{$ssel2}>
               		<input class='radio' style='background-color:{$scol3};' type='radio' name='side[{$bid}]' value='" . XOOPS_CENTERBLOCK_CENTER . "'$ssel3>
               	    <input class='radio' style='background-color:{$scol4};' type='radio' name='side[{$bid}]' value='" . XOOPS_CENTERBLOCK_RIGHT . "'{$ssel4}>
               	</div>
               	<div>
               		<span style='float:right'>
					    <input class='radio' style='background-color:{$scol1};' type='radio' name='side[{$bid}]' value='" . XOOPS_SIDEBLOCK_RIGHT . "'{$ssel1}>
					</span>
					<div class='left'>
					    <input class='radio' style='background-color:{$scol0};' type='radio' name='side[{$bid}]' value='" . XOOPS_SIDEBLOCK_LEFT . "'{$ssel0}>
					</div>
				</div>
				<div class='center'>
                    <input class='radio' style='background-color:{$scol5};' type='radio' name='side[{$bid}]' value='" . XOOPS_CENTERBLOCK_BOTTOMLEFT . "'{$ssel5}>
   	           		<input class='radio' style='background-color:$scol7;' type='radio' name='side[$bid]' value='" . XOOPS_CENTERBLOCK_BOTTOM . "'{$ssel7}>
       	            <input class='radio'  style='background-color:$scol6;' type='radio' name='side[$bid]' value='" . XOOPS_CENTERBLOCK_BOTTOMRIGHT . "'{$ssel6}>
               	</div>";

        /*
        } else {
        echo "
            <div style='float:left; background-color:$scol0;'>
                <input class='radio' type='radio' name='side[$bid]' value='".XOOPS_SIDEBLOCK_LEFT."' style='background-color:$scol0;' $ssel0>
            </div>
            <div style='float:left;'>-</div>
            <div style='float:left; background-color:$scol2;'>
                <input class='radio' type='radio' name='side[$bid]' value='".XOOPS_CENTERBLOCK_LEFT."' style='background-color:$scol2;' $ssel2>
            </div>
            <div style='float:left; background-color:$scol3;'>
                <input class='radio' type='radio' name='side[$bid]' value='".XOOPS_CENTERBLOCK_CENTER."' style='background-color:$scol3;' $ssel3>
            </div>
            <div style='float:left; background-color:$scol4;'>
                <input class='radio' type='radio' name='side[$bid]' value='".XOOPS_CENTERBLOCK_RIGHT."' style='background-color:$scol4;' $ssel4>
            </div>
            <div style='float:left;'>-</div>
            <div style='float:left; background-color:$scol1;'>
                <input class='radio' type='radio' name='side[$bid]' value='".XOOPS_SIDEBLOCK_RIGHT."' style='background-color:$scol1;' $ssel1>
            </div>";
        }
        */

        echo "
				<br>
				<div style='float:left;width:40px;'>&nbsp;</div>
				<div style='float:left; background-color:{$scoln};'>
					<input class='radio' type='radio' name='side[{$bid}]' value='-1' style='background-color:{$scoln};' {$sseln}>
				</div>
				<div style='float:left;'>&nbsp;" . _NONE . "</div>
			</td>
			<td class='$class center'>
				<input type='text' name=weight[{$bid}] value='{$weight}' size='3' maxlength='5' style='text-align:right;'>
			</td>
			<td class='$class center'>
				<select name='bmodule[{$bid}][]' size='5' multiple='multiple'>
					$module_options
				</select>
			</td>
			<td class='$class center'>
				<select name='bcachetime[{$bid}]' size='1'>
					$cachetime_options
				</select>
			</td>
			<td class='$class right'>
				<a href='" . XOOPS_URL . "/modules/system/admin.php?fct=blocksadmin&amp;op=edit&amp;bid={$bid}'>" . _EDIT . "</a>{$delete_link}{$clone_link}
				<!-- <a href='blocks/admin.php?fct=blocksadmin&amp;op=edit&amp;bid={$bid}'>" . _EDIT . "</a>{$delete_link}{$clone_link}-->
				<input class='radio' type='hidden' name='bid[{$bid}]' value='{$bid}'>
			</td>
		</tr>\n";

        $class = 'even' == $class ? 'odd' : 'even';
    }

    echo "
		<tr>
			<td class='foot center' colspan='6'>
				<input type='hidden' name='query4redirect' value='$query4redirect'>
				<input type='hidden' name='fct' value='blocksadmin'>
				<input type='hidden' name='op' value='order'>
                " . $GLOBALS['xoopsSecurity']->getTokenHTML() . "
				<input type='submit' name='submit' value='" . _SUBMIT . "'>
			</td>
		</tr>
		</table>
	</form>\n";
}

if (!empty(Request::getString('submit', null, 'POST'))) {
    // Check to make sure this is from known location

    if (!$GLOBALS['xoopsSecurity']->check()) {
        redirect_header(XOOPS_URL . '/', 3, implode('<br>', $GLOBALS['xoopsSecurity']->getErrors()));
    }

    require __DIR__ . '/blocks/mygroupperm.php';

    redirect_header(XOOPS_URL . '/modules/' . $GLOBALS['xoopsModule']->dirname() . '/admin/blocks.php', 1, _MD_AM_DBUPDATED);
}

require_once __DIR__ . '/admin_header.php';
edito_adminmenu(3, _AM_SYSTEM_BLOCKS_ADMIN);

if (!empty($block_arr)) {
    echo "<h4 class='left'>" . _AM_SYSTEM_BLOCKS_ADMIN . "</h4>\n";

    list_blocks();
}

$item_list = [];
foreach (array_keys($block_arr) as $i) {
    $item_list[$block_arr[$i]->getVar('bid')] = $block_arr[$i]->getVar('title');
}

echo "<h4 class='left'>" . _AM_SYSTEM_ADGS . "</h4>\n";
require_once dirname(__DIR__) . '/class/EditoGroupPermForm.php';
$form = new EditoGroupPermForm('', 1, 'block_read', '');
if ($target_mid > 1) {
    $form->addAppendix('module_admin', $target_mid, $target_mname . ' ' . _AM_SYSTEM_GROUPS_ACTIVERIGHTS);

    $form->addAppendix('module_read', $target_mid, $target_mname . ' ' . _AM_SYSTEM_GROUPS_ACCESSRIGHTS);
}
foreach ($item_list as $item_id => $item_name) {
    $form->addItem($item_id, $item_name);
}
echo $form->render();
echo '<p></p>';
xoops_cp_footer();
