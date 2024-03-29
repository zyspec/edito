<?php

declare(strict_types=1);

// ------------------------------------------------------------------------- //
//                     myblocksadmin_for_2.2.php                             //
//                - XOOPS block admin for each modules -                     //
//                          GIJOE <http://www.peak.ne.jp>                   //
// ------------------------------------------------------------------------- //

defined('XOOPS_ROOT_PATH') || exit('Restricted access');

require_once dirname(__DIR__, 4) . '/include/cp_header.php';
require_once dirname(__DIR__, 2) . '/class/EditoGroupPermForm.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsblock.php';

$xoops_system_path = XOOPS_ROOT_PATH . '/modules/system';

// language files
$language = $GLOBALS['xoopsConfig']['language'];
if (!file_exists("{$xoops_system_path}/language/{$language}/admin/blocksadmin.php")) {
    $language = 'english';
}

// to prevent from notice that constants already defined
$error_reporting_level = error_reporting(0);
require_once "{$xoops_system_path}/constants.php";
require_once "{$xoops_system_path}/language/$language/admin.php";
require_once "{$xoops_system_path}/language/$language/admin/blocksadmin.php";
require_once "{$xoops_system_path}/language/$language/admin/groups.php";
error_reporting($error_reporting_level);

$group_defs = file("$xoops_system_path/language/$language/admin/groups.php");
foreach ($group_defs as $def) {
    if (mb_strstr($def, '_AM_SYSTEM_GROUPS_ACCESSRIGHTS') || mb_strstr($def, '_AM_SYSTEM_GROUPS_ACTIVERIGHTS')) {
        eval($def);
    }
}

// check $GLOBALS['xoopsModule']
if (!is_object($GLOBALS['xoopsModule'])) {
    redirect_header(XOOPS_URL . '/user.php', 1, _NOPERM);
}

// set target_module if specified by $_GET['dirname']
$moduleHandler = xoops_getHandler('module');
if (!empty($_GET['dirname'])) {
    $target_module = $moduleHandler->getByDirname($_GET['dirname']);
}/* else if (!empty($_GET['mid'])) {
    $target_module = $moduleHandler->get((int)$_GET['mid']);
}*/

if (!empty($target_module) && is_object($target_module)) {
	// specified by dirname
	$target_mid     = $target_module->getVar('mid');
	$target_mname   = $target_module->getVar('name') . '&nbsp;' . sprintf("(%2.2f)", $target_module->getVar('version') / 100.0);
	$query4redirect = '?dirname=' . urlencode(strip_tags($_GET['dirname']));
} elseif (isset($_GET['mid']) && 0 == (int)$_GET['mid'] || 'blocksadmin' == $GLOBALS['xoopsModule']->getVar('dirname')) {
	$target_mid     = 0;
	$target_mname   = '';
	$query4redirect = '?mid=0';
} else {
	$target_mid     = $GLOBALS['xoopsModule']->getVar('mid');
	$target_mname   = $GLOBALS['xoopsModule']->getVar('name');
	$query4redirect = '';
}

// check access right (needs system_admin of BLOCK)
$syspermHandler = xoops_getHandler('groupperm');
if (!$syspermHandler->checkRight('system_admin', XOOPS_SYSTEM_BLOCK, $xoopsUser->getGroups())) {
    redirect_header(XOOPS_URL . '/user.php', 1, _NOPERM);
}

// get blocks owned by the module (Imported from xoopsblock.php then modified)
$db     = \XoopsDatabaseFactory::getDatabaseConnection();
$sql    = "SELECT bid,name,show_func,func_file,template FROM " . $db->prefix('newblocks')." WHERE mid='$target_mid'";
$result = $db->query($sql);
$block_arr = [];
while (list($bid, $bname, $show_func, $func_file, $template) = $db->fetchRow( $result)) {
	$block_arr[$bid] = [
		'name'      => $bname,
		'show_func' => $show_func,
		'func_file' => $func_file,
		'template'  => $template
	];
}

// for 2.2
function list_blockinstances()
{
	global $query4redirect, $block_arr;

    $myts = \MyTextSanitizer::getInstance();

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
	<form action='admin.php' name='blockadmin' method='post'>
		<table width='95%' class='outer' cellpadding='4' cellspacing='1'>
		<tr valign='middle'>
			<th>" . _AM_SYSTEM_BLOCKS_TITLE . "</th>
			<th class='center' nowrap='nowrap'>" . _AM_SYSTEM_BLOCKS_SIDE . "</th>
			<th class='center'>" . _AM_SYSTEM_BLOCKS_WEIGHT . "</th>
			<th class='center'>" . _AM_SYSTEM_BLOCKS_VISIBLEIN . "</th>
			<th class='center'>" . _AM_SYSTEM_BLOCKS_BCACHETIME . "</th>
			<th class='center'>" . _AM_SYSTEM_GROUPS_ACTION . "</th>
		</tr>\n";

	// get block instances
	$crit = new \Criteria('bid', '(' . implode(',', array_keys($block_arr)) . ')', 'IN');
	$criteria = new \CriteriaCompo($crit);
	$criteria->setSort('visible DESC, side ASC, weight');
	$instanceHandler = xoops_getHandler('blockinstance');
	$instances = $instanceHandler->getObjects($criteria, true, true);

	//Get modules and pages for visible in
	$module_list[_AM_SYSTEMLEVEL]['0-2'] = _AM_SYSTEM_BLOCKS_ADMIN;
	$module_list[_AM_SYSTEMLEVEL]['0-1'] = _AM_SYSTEM_BLOCKS_TOPPAGE;
	$module_list[_AM_SYSTEMLEVEL]['0-0'] = _AM_SYSTEM_BLOCKS_ALLPAGES;
	$criteria = new \CriteriaCompo(new \Criteria('hasmain', 1));
	$criteria->add(new \Criteria('isactive', 1));
	$moduleHandler = xoops_getHandler('module');
	$module_main = $moduleHandler->getObjects($criteria, true, true);
	if (count($module_main) > 0) {
		foreach (array_keys($module_main) as $mid) {
		    $module_list[$module_main[$mid]->getVar('name')][$mid . '-0'] = _AM_SYSTEM_BLOCKS_ALLPAGES;
			$pages = $module_main[$mid]->getInfo('pages');
			if (false === $pages) {
				$pages = $module_main[$mid]->getInfo('sub');
			}
			if (is_array($pages) && [] != $pages) {
				foreach ($pages as $id => $pageinfo) {
					$module_list[$module_main[$mid]->getVar('name')][$mid . '-' . $id] = $pageinfo['name'];
				}
			}
		}
	}

	// blocks displaying loop
	$class = 'even';
	$block_configs = get_block_configs();
	foreach ($instances as $i => $instObj) {
		$sseln = $ssel0 = $ssel1 = $ssel2 = $ssel3 = $ssel4 = '';
		$scoln = $scol0 = $scol1 = $scol2 = $scol3 = $scol4 = '#FFF';

		$weight     = $instances[$i]->getVar('weight');
		$title      = $instances[$i]->getVar('title');
		$bcachetime = $instances[$i]->getVar('bcachetime');
		$bid        = $instances[$i]->getVar('bid');
		$name       = $myts->htmlSpecialChars($block_arr[$bid]['name']);
		$visiblein  = $instances[$i]->getVisibleIn();

		// visible and side
		if (1 !== $instances[$i]->getVar('visible')) {
			$sseln = ' checked';
			$scoln = '#FF0000';
		} else switch($instances[$i]->getVar('side')) {
			default :
            case XOOPS_SIDEBLOCK_LEFT:
				$ssel0 = ' checked';
				$scol0 = '#00FF00';
				break;
			case XOOPS_SIDEBLOCK_RIGHT:
				$ssel1 = ' checked';
				$scol1 = '#00FF00';
				break;
			case XOOPS_CENTERBLOCK_LEFT:
				$ssel2 = ' checked';
				$scol2 = '#00FF00';
				break;
			case XOOPS_CENTERBLOCK_RIGHT:
				$ssel4 = ' checked';
				$scol4 = '#00FF00';
				break;
			case XOOPS_CENTERBLOCK_CENTER:
				$ssel3 = ' checked';
				$scol3 = '#00FF00';
				break;
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

		$module_options = '';
		foreach ($module_list as $mname => $module) {
			$module_options .= "<optgroup label='$mname'>\n";
			foreach ($module as $mkey => $mval) {
				if (in_array($mkey, $visiblein, true)) {
					$module_options .= "<option value='$mkey' selected>$mval</option>\n";
				} else {
					$module_options .= "<option label='$mval' value='$mkey'>$mval</option>\n";
				}
			}
			$module_options .= "</optgroup>\n";
		}

		// delete link if it is cloned block
		$delete_link = "<br><a href='" . XOOPS_URL . "/modules/system/admin.php?fct=blocksadmin&amp;op=delete&amp;id=$i&amp;selmod=$mid'>" . _DELETE . "</a>";

		// displaying part
		echo "
		<tr valign='middle'>
			<td class='$class'>
				$name
				<br>
				<input type='text' name='title[$i]' value='$title' size='20'>
			</td>
			<td class='$class' align='center' nowrap='nowrap' width='125px'>
				<div style='float:left;background-color:$scol0;'>
					<input type='radio' name='side[$i]' value='" . XOOPS_SIDEBLOCK_LEFT . "' style='background-color:$scol0;'$ssel0>
				</div>
				<div style='float:left;'>-</div>
				<div style='float:left;background-color:$scol2;'>
					<input type='radio' name='side[$i]' value='" . XOOPS_CENTERBLOCK_LEFT . "' style='background-color:$scol2;'$ssel2>
				</div>
				<div style='float:left;background-color:$scol3;'>
					<input type='radio' name='side[$i]' value='" . XOOPS_CENTERBLOCK_CENTER . "' style='background-color:$scol3;'$ssel3>
				</div>
				<div style='float:left;background-color:$scol4;'>
					<input type='radio' name='side[$i]' value='" . XOOPS_CENTERBLOCK_RIGHT . "' style='background-color:$scol4;'$ssel4>
				</div>
				<div style='float:left;'>-</div>
				<div style='float:left;background-color:$scol1;'>
					<input type='radio' name='side[$i]' value='" . XOOPS_SIDEBLOCK_RIGHT . "' style='background-color:$scol1;'$ssel1>
				</div>
				<br>
				<br>
				<div style='float:left;width:40px;'>&nbsp;</div>
				<div style='float:left;background-color:$scoln;'>
					<input type='radio' name='side[$i]' value='-1' style='background-color:$scoln;'$sseln>
				</div>
				<div style='float:left;'>" . _NONE . "</div>
			</td>
			<td class='$class' align='center'>
				<input type='text' name=weight[$i] value='$weight' size='3' maxlength='5' style='text-align:right;'>
			</td>
			<td class='$class' align='center'>
				<select name='bmodule[$i][]' size='5' multiple='multiple'>
					$module_options
				</select>
			</td>
			<td class='$class' align='center'>
				<select name='bcachetime[$i]' size='1'>
					$cachetime_options
				</select>
			</td>
			<td class='$class' align='right'>
				<a href='" . XOOPS_URL . "/modules/system/admin.php?fct=blocksadmin&amp;op=edit&amp;id={$i}'>" . _EDIT . "</a>{$delete_link}
				<input type='hidden' name='id[$i]' value='$i'>
			</td>
		</tr>\n";

        $class = 'even' == $class ? 'odd' : 'even';
    }

	// list block classes for add (not instances)
	foreach ($block_arr as $bid => $block) {
		$description4show = '';
		foreach ($block_configs as $bconf) {
			if ($block['show_func'] == $bconf['show_func'] && $block['func_file'] == $bconf['file'] && (empty($bconf['template']) || $block['template'] == $bconf['template'])) {
			    if (!empty($bconf['description'])) {
			        $description4show = $myts->htmlSpecialChars($bconf['description']);
			    }
			}
		}

        echo "
		<tr>
			<td class='$class' align='left'>
				" . $myts->htmlSpecialChars($block['name']) . "
			</td>
			<td class='$class' align='left' colspan='4'>
				$description4show
			</td>
			<td class='$class' align='center'>
				<input type='submit' name='addblock[$bid]' value='" . _ADD . "'>
			</td>
		</tr>
		\n";
		$class = 'even' == $class ? 'odd' : 'even';
	}

	echo "
		<tr>
			<td class='foot' align='center' colspan='6'>
				<input type='hidden' name='query4redirect' value='$query4redirect'>
				<input type='hidden' name='fct' value='blocksadmin'>
				<input type='hidden' name='op' value='order2'>
				" . $GLOBALS['xoopsSecurity']->getTokenHTML() . "
				<input type='submit' name='submit' value='" . _SUBMIT . "'>
			</td>
		</tr>
		</table>
	</form>\n";
}

// for 2.2
function list_groups2()
{
	global $target_mid, $target_mname;

	$result = $GLOBALS['xoopsDB']->query( "SELECT i.instanceid,i.title FROM " . $GLOBALS['xoopsDB']->prefix('block_instance') . " i LEFT JOIN " . $GLOBALS['xoopsDB']->prefix('newblocks') . " b ON i.bid=b.bid WHERE b.mid='$target_mid'");

	$item_list = [];
	while (list($iid, $title) = $GLOBALS['xoopsDB']->fetchRow($result)) {
		$item_list[$iid] = $title;
	}

	$form = new EditoGroupPermForm(_AM_SYSTEM_ADGS, 1, 'block_read', '');
	if(1 < $target_mid) {
	    $form->addAppendix('module_admin', $target_mid, $target_mname . ' ' . _AM_SYSTEM_GROUPS_ACTIVERIGHTS);
	    $form->addAppendix('module_read', $target_mid, $target_mname . ' ' . _AM_SYSTEM_GROUPS_ACTIVERIGHTS);
	}
	foreach( $item_list as $item_id => $item_name) {
			$form->addItem($item_id, $item_name);
	}
	echo $form->render() ;
}

if (!empty($_POST['submit'])) {
    // Check to make sure this is from known location
    if (!$GLOBALS['xoopsSecurity']->check()) {
        redirect_header(XOOPS_URL . '/', 3, implode('<br>', $GLOBALS['xoopsSecurity']->getErrors()));
    }

    require __DIR__ . '/mygroupperm.php';
    redirect_header(XOOPS_URL . '/modules/' . $GLOBALS['xoopsModule']->dirname() . "/admin/blocks.php$query4redirect", 1, _AM_SYSTEM_BLOCKS_DBUPDATED);
}

xoops_cp_header();
if (file_exists(__DIR__ . '/mymenu.php')) {
    require __DIR__ . '/mymenu.php';
}

echo "<h3 class='left'>{$target_mname}</h3>\n";

if (!empty($block_arr)) {
    echo "<h4 class='left'>" . _AM_SYSTEM_BLOCKS_ADMIN . "</h4>\n";
	list_blockinstances();
}

list_groups2();
xoops_cp_footer();
