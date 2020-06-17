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

function edito_adminmenu($currentoption = 0, $breadcrumb = '') {
	echo "<style type='text/css'>
		  #buttontop { float:left; width:100%; background: #e7e7e7; font-size:93%; line-height:normal; border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black; margin: 0; }
          #buttonbar { float:left; width:100%; background: #e7e7e7 url('" . XOOPS_URL . "/modules/'.$xoopsModule->dirname().'/images/bg.gif') repeat-x left bottom; font-size: 10px; line-height:normal; border-left: 1px solid black; border-right: 1px solid black; margin-bottom: 12px; }
          #buttonbar ul { margin:0; margin-top: 15px; padding:0px 5px 0; list-style:none; }
          #buttonbar li { display:inline; margin:0; padding:0; }
          #buttonbar a { float:left; background:url('" . XOOPS_URL . "/modules/'.$xoopsModule->dirname().'/images/left_both.gif') no-repeat left top; margin:0; padding:0 0 0 9px; border-bottom:1px solid #000; text-decoration:none; white-space: nowrap}
          #buttonbar a span { float:left; display:block; background:url('" . XOOPS_URL . "/modules/'.$xoopsModule->dirname().'/images/right_both.gif') no-repeat right top; padding:5px 15px 4px 6px; font-weight:bold; color:#765; white-space: nowrap}
          /* Commented Backslash Hack hides rule from IE5-Mac \*/
          #buttonbar a span {float:none;}
          /* End IE5-Mac hack */
          #buttonbar a:hover span { color:#333; }
          #buttonbar #current a { background-position:0 -150px; border-width:0; }
          #buttonbar #current a span { background-position:100% -150px; padding-bottom:5px; color:#333; }
          #buttonbar a:hover { background-position:0% -150px; }
          #buttonbar a:hover span { background-position:100% -150px; }
          </style>";

    // global $xoopsDB, $xoopsModule, $xoopsConfig, $xoopsModuleConfig;
	global $xoopsModule, $xoopsConfig;
	$myts = &MyTextSanitizer::getInstance();

	$tblColors = Array_Fill(0,8,'');
	$tblColors[$currentoption] = 'current';

	//echo XOOPS_ROOT_PATH . '/modules/'.$xoopsModule->dirname().'/language/' . $xoopsConfig['language'] . '/modinfo.php';

	if (file_exists(XOOPS_ROOT_PATH . '/modules/'.$xoopsModule->dirname().'/language/' . $xoopsConfig['language'] . '/modinfo.php')) {
		include_once XOOPS_ROOT_PATH . '/modules/'.$xoopsModule->dirname().'/language/' . $xoopsConfig['language'] . '/modinfo.php';
	} else {
		include_once XOOPS_ROOT_PATH . '/modules/'.$xoopsModule->dirname().'/language/french/modinfo.php';
	}

	include 'menu.php';

	echo '<div id="buttontop">';
	echo '<table style="width: 100%; padding: 0;" cellspacing="0"><tr>';
	echo '<td style="font-size: 10px; text-align: left; color: #2F5376; padding: 0 6px; line-height: 18px;">';
	for( $i=0; $i<count($headermenu); $i++ ){
		echo '<a class="nobutton" href="' . $headermenu[$i]['link'] .'">' . $headermenu[$i]['title'] . '</a> ';
		if ($i < count($headermenu)-1) {
			echo "| ";
		}
	}
	echo '</td>';
	echo '<td style="font-size: 12px; text-align: right; color: #CC0000; padding: 0 6px; line-height: 18px; font-weight: bold;">' . $breadcrumb . '</td>';
	echo '</tr></table>';
	echo '</div>';

	echo '<div id="buttonbar">';
	echo "<ul>";

	for( $i=0; $i<count($adminmenu); $i++ ){
		echo '<li id="' . $tblColors[$i] . '"><a href="' . XOOPS_URL . '/modules/'.$xoopsModule->dirname().'/' . $adminmenu[$i]['link'] . '"><span>' . $adminmenu[$i]['title'] . '</span></a></li>';
	}
	echo '</ul></div>';
    echo '<div style="float: left; width: 100%; text-align: center; margin: 0px; padding: 0px">';
}

function edito_statmenu($currentoption = 0, $breadcrumb = '') {
	echo "<style type='text/css'>
    	  #statbar { float:right; font-size: 10px; line-height:normal; margin-bottom: 0px; }
          #statbar ul { margin:0; margin-top: 0px; padding:0px 0px 0; list-style:none;}
          #statbar li { display:inline; margin:0; padding:0;}
          #statbar a 		{ float:left; background-color: #DDE; margin:0; padding: 5px; text-align: center; text-decoration:none; border: 1px solid #000000; border-bottom: 0px; white-space: nowrap}
          #statbar a span { display:block; white-space: nowrap;}
          /* Commented Backslash Hack hides rule from IE5-Mac \*/
          #statbar a span {float:none;}
          /* End IE5-Mac hack */
          #statbar a:hover span { color:#333; }
          #statbar #current a { background-color: #00FFFF; border: 1px solid #000000; border-bottom: 0px;}
          #statbar #current a span { background-color: #00FFFF; color:#333; }
          #statbar a:hover { background-position:0% -150px; background-color: #00FFFF; }
          #statbar a:hover span { background-position:100% -150px; background-color: #00FFFF; }
          </style>";

	global $xoopsModule, $xoopsConfig;
	$myts = &MyTextSanitizer::getInstance();

	$tblColors = Array_Fill(0,8,'');
	$tblColors[$currentoption] = 'current';

	if (file_exists(XOOPS_ROOT_PATH . '/modules/'.$xoopsModule->dirname().'/language/' . $xoopsConfig['language'] . '/modinfo.php')) {
		include_once XOOPS_ROOT_PATH . '/modules/'.$xoopsModule->dirname().'/language/' . $xoopsConfig['language'] . '/modinfo.php';
	} else {
		include_once XOOPS_ROOT_PATH . '/modules/'.$xoopsModule->dirname().'/language/french/modinfo.php';
	}

	include 'menu.php';
	echo '<br /><div id="statbar">';
	echo "<ul>";

	for( $i=0; $i<count($statmenu); $i++ ){
		echo '<li id="' . $tblColors[$i] . '"><a href="' . XOOPS_URL . '/modules/'.$xoopsModule->dirname().'/' . $statmenu[$i]['link'] . '"><span>' . $statmenu[$i]['title'] . '</span></a></li>';
	}
	echo '</ul></div>';
    echo '<div style="float: left; width: 100%; text-align: center; margin: 0px; padding: 0px">';
}

function edito_metamenu($currentoption = 0, $breadcrumb = '') {
	echo "<style type='text/css'>
    	  #statbar { float:right; font-size: 10px; line-height:normal; margin-bottom: 0px; }
          #statbar ul { margin:0; margin-top: 0px; padding:0px 0px 0; list-style:none;}
          #statbar li { display:inline; margin:0; padding:0;}
          #statbar a 		{ float:left; background-color: #DDE; margin:0; padding: 5px; text-align: center; text-decoration:none; border: 1px solid #000000; border-bottom: 0px; white-space: nowrap}
          #statbar a span { display:block; white-space: nowrap;}
          /* Commented Backslash Hack hides rule from IE5-Mac \*/
          #statbar a span {float:none;}
          /* End IE5-Mac hack */
          #statbar a:hover span { color:#333; }
          #statbar #current a { background-color: #00FFFF; border: 1px solid #000000; border-bottom: 0px;}
          #statbar #current a span { background-color: #00FFFF; color:#333; }
          #statbar a:hover { background-position:0% -150px; background-color: #00FFFF; }
          #statbar a:hover span { background-position:100% -150px; background-color: #00FFFF; }
          </style>";

	global $xoopsModule, $xoopsConfig;
	$myts = &MyTextSanitizer::getInstance();

	$tblColors = Array_Fill(0,8,'');
	$tblColors[$currentoption] = 'current';

	if (file_exists(XOOPS_ROOT_PATH . '/modules/'.$xoopsModule->dirname().'/language/' . $xoopsConfig['language'] . '/modinfo.php')) {
		include_once XOOPS_ROOT_PATH . '/modules/'.$xoopsModule->dirname().'/language/' . $xoopsConfig['language'] . '/modinfo.php';
	} else {
		include_once XOOPS_ROOT_PATH . '/modules/'.$xoopsModule->dirname().'/language/french/modinfo.php';
	}

	include 'menu.php';
	echo '<br /><div id="statbar">';
	echo "<ul>";

	for( $i=0; $i<count($metamenu); $i++ ){
		echo '<li id="' . $tblColors[$i] . '"><a href="' . XOOPS_URL . '/modules/'.$xoopsModule->dirname().'/' . $metamenu[$i]['link'] . '"><span>' . $metamenu[$i]['title'] . '</span></a></li>';
	}
	echo '</ul></div>';
    echo '<div style="float: left; width: 100%; text-align: center; margin: 0px; padding: 0px">';
}

function edito_search() {
	echo '<div style="text-align:right; padding-right:10px;">
    	  <form style="margin:0px; vertical-align: center; " action="'. $_SERVER['SCRIPT_NAME'] .'?ord='.$ord.'&search='.$search.'&engine='.$engine.'&week='.$week.'&op=&startart='.$startart.'" method="post">
          <input style="margin:0px; vertical-align: center; " type="text" name="search" size="30" maxlength="30" value="'.$search.'">&nbsp;<button style="font-size:11px; " type="submit">'._MD_EDITO_SEARCH.'</button>
          </form>
          </div>';
}

function edito_adminfooter() {
	echo '<p/>';
    OpenTable();
//	echo '<div style="text-align: right; vertical-align: center"><img src="../images/'.$xoopsModule->dirname().'.gif" border="0" align="center" valign="absmiddle" />';
    echo sprintf(_MD_EDITO_CREDIT,'<a href="http://wolfactory.wolfpackclan.com" target="_blank">WolFactory</a>', '<a href="http://www.dugris.info" target="_blank">DuGris</a>' );
    echo '</div>';
	CloseTable();
	echo '<p/>';
}


/**
 * Get module preference
 *
 * @param string $option
 * @param string module directory
 * @return string
 *
 */
function edito_GetOption($option, $repmodule = '.$xoopsModule->dirname().' ) {
	global $xoopsModuleConfig, $xoopsModule;
	static $tbloptions= Array();
	if(is_array($tbloptions) && array_key_exists($option,$tbloptions)) {
		return $tbloptions[$option];
	}

	$retval=false;
	if (isset($xoopsModuleConfig) && (is_object($xoopsModule) && $xoopsModule->getVar('dirname') == $repmodule && $xoopsModule->getVar('isactive'))) {
		if(isset($xoopsModuleConfig[$option])) {
			$retval= $xoopsModuleConfig[$option];
		}
	} else {
		$module_handler =& xoops_gethandler('module');
		$module =& $module_handler->getByDirname($repmodule);
		$config_handler =& xoops_gethandler('config');
		if ($module) {
		    $moduleConfig =& $config_handler->getConfigsByCat(0, $module->getVar('mid'));
	    	if(isset($moduleConfig[$option])) {
	    		$retval= $moduleConfig[$option];
	    	}
		}
	}
	$tbloptions[$option]=$retval;
	return $retval;
}

/**
 * check permissions
 *
 * @param int $refererid
 *			1 -> Referers
 *			2 -> Engines
 *			3 -> Keywords
 *			4 -> Queries
 *			5 -> Robots
 * @return bool
 *
 */
function edito_checkRight( $refererid ) {
	global $xoopsUser;
    $groups = is_object( $xoopsUser ) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
    $gperm_handler = &xoops_gethandler( 'groupperm' );

	$module_handler =& xoops_gethandler('module');
	$editoModule =& $module_handler->getByDirname($xoopsModule->dirname());
	if ( $gperm_handler->checkRight( 'edito_wiew', $refererid, $groups, $editoModule->getVar('mid') ) ) {
    	return true;
    }
    return false;
}

/**
 * Gets a value for a key in the edito_config table
 *
 * @param string $key
 * @return string $value
 *
 */
function edito_GetMeta($key)
{
    $xoopsDB =& Database::getInstance();
    $sql = sprintf("SELECT conf_value FROM %s WHERE conf_name=%s", $xoopsDB->prefix('myref_config'), $xoopsDB->quoteString($key));
    $ret = $xoopsDB->query($sql);
    if (!$ret) {
        $value = false;
    } else {
        list($value) = $xoopsDB->fetchRow($ret);
    }
    return $value;
}


function edito_create_dir( $directory = "config" )
{
	$thePath = XOOPS_ROOT_PATH . "/modules/'.$xoopsModule->dirname().'/" . $directory . "/";

	if(@is_writable($thePath)){
		edito_admin_chmod($thePath, $mode = 0777);
        return $thePath;
	} elseif(!@is_dir($thePath)) {
    	edito_admin_mkdir($thePath);
        return $thePath;
	}
    return 0;
}

function edito_admin_mkdir($target)
{
	// http://www.php.net/manual/en/function.mkdir.php
	// saint at corenova.com
	// bart at cdasites dot com
	if (is_dir($target) || empty($target)) {
		return true; // best case check first
	}

	if (file_exists($target) && !is_dir($target)) {
		return false;
	}

	if (edito_admin_mkdir(substr($target,0,strrpos($target,'/')))) {
		if (!file_exists($target)) {
			$res = mkdir($target, 0777); // crawl back up & create dir tree
			edito_admin_chmod($target);
	  	    return $res;
	  }
	}
    $res = is_dir($target);
	return $res;
}

function edito_admin_chmod($target, $mode = 0777)
{
	return @chmod($target, $mode);
}

/**
 * Sets a value for a key in the edito_config table
 *
 * @param string $key
 * @param string $value
 * @return bool TRUE if success, FALSE if failure
 *
 */
function edito_SetMeta($key, $value)
{
    $xoopsDB =& Database::getInstance();
    if(edito_GetMeta($key)){
        $sql = sprintf("UPDATE %s SET conf_value = %s WHERE conf_name = %s", $xoopsDB->prefix('myref_config'), $xoopsDB->quoteString($value), $xoopsDB->quoteString($key));
    } else {
        $sql = sprintf("INSERT INTO %s (conf_id , conf_name, conf_title, conf_value, conf_desc, conf_formtype, conf_valuetype, conf_order) VALUES (0, %s, '', %s, '', 'hidden', hidden', 0)", $xoopsDB->prefix('myref_config'), $xoopsDB->quoteString($key), $xoopsDB->quoteString($value));
    }
    $ret = $xoopsDB->queryF($sql);
    if (!$ret) {
        return false;
    }
    return true;
}


/**
 * Detemines if a field exists in the current db
 *
 * @param string $table the table name (without XOOPS prefix)
 * @param string $field the field name
 * @return bool True if table exists, false if not
 *
 */
function edito_FieldnameExists($table, $field)
{
    $bRetVal = false;
    $xoopsDB =& Database::getInstance();
    $sql = 'SHOW COLUMNS FROM ' . $xoopsDB->prefix($table);
    $ret = $xoopsDB->queryF($sql);
    while (list($m_fieldname)=$xoopsDB->fetchRow($ret)) {
        if ($m_fieldname ==  $field) {
            $bRetVal = true;
            break;
        }
    }
    $xoopsDB->freeRecordSet($ret);
    return ($bRetVal);
}


/**
 * Detemines if a table exists in the current db
 *
 * @param string $table the table name (without XOOPS prefix)
 * @return bool True if table exists, false if not
 *
 */
function edito_TableExists($table)
{

    $bRetVal = false;
    //Verifies that a MySQL table exists
    $xoopsDB =& Database::getInstance();
    $realname = $xoopsDB->prefix($table);
    $sql = "SHOW TABLES FROM " . XOOPS_DB_NAME;
    $ret = $xoopsDB->queryF($sql);
    while (list($m_table)=$xoopsDB->fetchRow($ret)) {

        if ($m_table ==  $realname) {
            $bRetVal = true;
            break;
        }
    }
    $xoopsDB->freeRecordSet($ret);
    return ($bRetVal);
}

?>