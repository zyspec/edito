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

$edito_allowed_image = array( 'gif'		=>	'image/gif',
                              'jpg'		=>	'image/jpeg',
                              'jpeg'	        =>	'image/pjpeg',
                              'png'		=>	'image/x-png',
                              'png'		=>	'image/png'
                              ) ;

$edito_allowed_media = array( 'gif'		=>	'image/gif',
                              'jpg'		=>	'image/jpeg',
                              'jpeg'	        =>	'image/pjpeg',
                              'png'		=>	'image/x-png',
                              'png'		=>	'image/png',
                              
                              'aiff' 	        =>	'audio/aiff',
                              'mid'		=>	'audio/mid',
                              'mpg'		=>	'audio/mpeg',
                              'mpeg'	        =>	'audio/mpeg',
                              'wav'		=>	'audio/wav',
                              'vma'		=>	'audio/x-ms-wma',
                              'asf'		=>	'video/x-ms-asf',
                              'avi'		=>	'video/avi',
                              'wmv'		=>	'video/x-ms-wmv',
                              'vmx'		=>	'video/x-ms-wmx',
                              'mpeg'	        =>	'video/mpeg',
                              'mpg'		=>	'video/mpeg',
                              'mpe'		=>	'video/mpeg',
                              'qt'		=>	'video/quicktime',
                              'swf'		=>	'application/x-shockwave-flash',
                              'ra'		=>	'audio/vnd.rn-realaudio',
                              'ram'		=>	'audio/x-pn-realaudio',
                              'rm'		=>	'application/vnd.rn-realmedia',
                              'rv'		=>	'video/vnd.rn-realvideo'
                              );


// function edito_uploading( $allowed_mimetypes, $httppostfiles, $redirecturl = "index.php", $num = 0, $dir = "uploads", $redirect = 0 ) {
function edito_uploading_image( $filename ) {
	include_once XOOPS_ROOT_PATH . "/class/uploader.php";
	global $xoopsConfig, $xoopsModuleConfig, $edito_allowed_image, $edito_allowed_media, $error_uploading;

	$ext_fileup = edito_GetExtensionName( $filename );

	foreach( $edito_allowed_image as $type_image) {
		if ( strstr($type_image, $ext_fileup) ) {
			$uploaddir = XOOPS_ROOT_PATH . "/" . $xoopsModuleConfig['sbuploaddir'] . "/" ;
			$allowed_mimetypes = $edito_allowed_image;
		}
	}

	$image_size = explode('|', $xoopsModuleConfig['maximgsize']);
	$maxfilewidth = $image_size[0];
	$maxfileheight = $image_size[1];
	$maxfilesize = $image_size[2];
	$redirecturl = "index.php";
	$redirect = 0;

	$uploader = new XoopsMediaUploader( $uploaddir, $allowed_mimetypes, $maxfilesize, $maxfilewidth, $maxfileheight );
        
	if ( $uploader -> fetchMedia( $filename ) ) {
		if ( !$uploader -> upload() ) {
			xoops_error('<font color="#000000">' . $uploader->getErrors() . '</font>');
			return( false);
		} else {
			return( true );
		} 
	} else {   
		xoops_error('<font color="#000000">' . $uploader->getErrors() . '</font>');
		return( false);
	}
}


function edito_uploading_media( $filename ) {
	include_once XOOPS_ROOT_PATH . "/class/uploader.php";
	global $xoopsConfig, $xoopsModuleConfig, $edito_allowed_image, $edito_allowed_media, $error_uploading;

	$ext_fileup = edito_GetExtensionName( $filename );

	foreach( $edito_allowed_media as $type_media) {
		if ( strstr($type_media, $ext_fileup) ) {
			$uploaddir = XOOPS_ROOT_PATH . "/" . $xoopsModuleConfig['sbmediadir'] . "/" ;
			$allowed_mimetypes = $edito_allowed_media;
		}
	}

	$image_size = explode('|', $xoopsModuleConfig['maximgsize']);
	$maxfilewidth = $image_size[0];
	$maxfileheight = $image_size[1];
//	$maxfilesize = $image_size[2];
        $maxfilesize = editoreturn_bytes(ini_get('post_max_size'));
	$redirecturl = "index.php";
	$redirect = 0;

	$uploader = new XoopsMediaUploader( $uploaddir, $allowed_mimetypes, $maxfilesize, $maxfilewidth, $maxfileheight );
        
	if ( $uploader -> fetchMedia( $filename ) ) {
		if ( !$uploader -> upload() ) {
			xoops_error('<font color="#000000">' . $uploader->getErrors() . '</font>');
			return( false);
		} else {
			return( true );
		} 
	} else {   
		xoops_error('<font color="#000000">' . $uploader->getErrors() . '</font>');
		return( false);
	}
}

function editoreturn_bytes($val) {
   $val = trim($val);
   $last = strtolower($val{strlen($val)-1});
   switch($last) {
       // Le modifieur 'G' est disponible depuis PHP 5.1.0
       case 'g':
           $val *= 1024;
       case 'm':
           $val *= 1024;
       case 'k':
           $val *= 1024;
   }

   return $val;
}


/* 
function edito_media_uploading( $allowed_mimetypes, $httppostfiles, $redirecturl = "index.php", $num = 0, $dir = "uploads", $redirect = 0 ) {
	include_once XOOPS_ROOT_PATH . "/class/uploader.php";

    global $xoopsConfig, $xoopsModuleConfig, $HTTP_POST_VARS;
    echo $tmpmedia = $HTTP_POST_VARS['xoops_upload_file'][$num];
    $image_size = explode('|', $xoopsModuleConfig['maximgsize']);
    $maxfilewidth = $image_size[0];
    $maxfileheight = $image_size[1];
    $maxfilesize = $xoopsModuleConfig['maxfilesize'];
    $uploaddir = XOOPS_ROOT_PATH . "/" . $dir . "/";
    $uploader = new XoopsMediaUploader( $uploaddir, $allowed_mimetypes, $maxfilesize, $maxfilewidth, $maxfileheight );

    if ( $uploader -> fetchMedia( $tmpmedia ) ) {
    	if ( !$uploader -> upload() ) {
        	$errors = $uploader -> getErrors();
        	redirect_header( $redirecturl, 1, $errors );
        } else {
        	if ( $redirect ) {
            	redirect_header( $redirecturl, '1' , "Image Uploaded" );
            }
        }
	} else {
    	$errors = $uploader -> getErrors();
        redirect_header( $redirecturl, 1, $errors );
    }
}
*/
function edito_GetExtensionName( $file, $dot=false) {
	if ($dot == true) {
		$ext = strtolower(substr($file, strrpos($file, '.')));
	} else {
    	$ext = strtolower(substr($file, strrpos($file, '.') + 1));
    }
	return $ext;
}


function edito_adminmenu($currentoption = 0, $breadcrumb = '') {
	echo "<style type='text/css'>
    	  #buttontop { float:left; width:100%; background: #e7e7e7; font-size:93%; line-height:normal; border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black; margin: 0; }
          #buttonbar { float:left; width:100%; background: #e7e7e7 url('" . XOOPS_URL . "/modules/edito/images/bg.gif') repeat-x left bottom; font-size: 10px; line-height:normal; border-left: 1px solid black; border-right: 1px solid black; margin-bottom: 12px; }
          #buttonbar ul { margin:0; margin-top: 15px; padding:0px 5px 0; list-style:none; }
          #buttonbar li { display:inline; margin:0; padding:0; }
          #buttonbar a { float:left; background:url('" . XOOPS_URL . "/modules/edito/images/left_both.gif') no-repeat left top; margin:0; padding:0 0 0 9px; border-bottom:1px solid #000; text-decoration:none; white-space: nowrap}
          #buttonbar a span { float:left; display:block; background:url('" . XOOPS_URL . "/modules/edito/images/right_both.gif') no-repeat right top; padding:5px 15px 4px 6px; font-weight:bold; color:#765; white-space: nowrap}
          * Commented Backslash Hack hides rule from IE5-Mac \*/
          #buttonbar a span {float:none;}
          /* End IE5-Mac hack */
          #buttonbar a:hover span { color:#333; }
          #buttonbar #current a { background-position:0 -150px; border-width:0; }
          #buttonbar #current a span { background-position:100% -150px; padding-bottom:5px; color:#333; }
          #buttonbar a:hover { background-position:0% -150px; }
          #buttonbar a:hover span { background-position:100% -150px; }
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

	echo '<div id="buttontop">';
	echo '<table style="width: 100%; padding: 5px;" cellspacing="0"><tr>';
	echo '<td style="font-size: 10px; text-align: left; color: #2F5376; padding: 0 6px; line-height: 18px;">';
	for( $i=0; $i<count($headermenu); $i++ ){
		echo '<a class="nobutton" href="' . $headermenu[$i]['link'] .'" title="'.$headermenu[$i]['alt'].'">' . $headermenu[$i]['title'] . '</a> ';
		if ($i < count($headermenu)-1) {
			echo " &nbsp; ";
		}
	}
	echo '</td>';
	echo '<td><h1><a href="../">'.$xoopsModule->name().'</a></h1></td>';
	echo '<td colspan="2" style="font-size: 12px; text-align: right; color: #CC0000; padding: 0 6px; line-height: 18px; font-weight: bold;">' . $breadcrumb . '</td>';
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
	echo "
    	<style type='text/css'>
    	#statbar { float:right; font-size: 10px; line-height:normal; margin-bottom: 0px;}
    	#statbar ul { margin:0px; margin-top: 0px; padding:0px 0px; list-style:none; }
		#statbar li { display:inline; margin:0; padding:0px;}
		#statbar a  { float:left; background-color: #DDE; margin:0px; padding: 5px; text-align: center; text-decoration:none;
                              border: 1px outset #008; border-bottom: 0px; white-space: nowrap}
		#statbar a span { display:block; white-space: nowrap; color:#888;}
		/* Commented Backslash Hack hides rule from IE5-Mac \*/
		#statbar a span {float:none;}
		/* End IE5-Mac hack */
		#statbar a:hover span { color:#008; }
		#statbar #current a { background-color: #EEE; border: 1px inset #008; border-bottom: 0px;}
		#statbar #current a span { background-color: #EEE; color:#800; }
		#statbar a:hover { background-position:0% -150px; background-color: #FEE; 
                                   border: 1px inset #008; border-bottom: 0px;}
		#statbar a:hover span { background-position:100% -150px; background-color: #FEE; }
		</style>
    ";
	// global $xoopsDB, $xoopsModule, $xoopsConfig, $xoopsModuleConfig;
	global $xoopsModule, $xoopsConfig;
	$myts = &MyTextSanitizer::getInstance();

	$tblColors = Array_Fill(0,6,'');
	$tblColors[$currentoption] = 'current';


	if (file_exists(XOOPS_ROOT_PATH . '/modules/edito/language/' . $xoopsConfig['language'] . '/modinfo.php')) {
		include_once XOOPS_ROOT_PATH . '/modules/edito/language/' . $xoopsConfig['language'] . '/modinfo.php';
	} else {
		include_once XOOPS_ROOT_PATH . '/modules/edito/language/english/modinfo.php';
	}

	include 'menu.php';
/*
echo '<div id="adminmenu" style="visibility:hidden;position:absolute;z-index:100;top:-100"></div>';
echo '<script language="JavaScript1.2" src="../script/popmenu.js" type="text/javascript"></script>';
echo'
     <script language="JavaScript1.2"  type="text/javascript">
     ';

	for( $i=0; $i<count($statmenu); $i++ ){
echo '
      Text['.$i.']=["'.$statmenu[$i]['title'].'","'.$statmenu[$i]['help'].'"]
';
 }
*/
 /* The Style array parameters come in the following order
Style[...]=[titleColor,TitleBgColor,TitleBgImag,TitleTextAlign,TitleFontFace,TitleFontSize,
            TextColor,TextBgColor,TextBgImag,TextTextAlign,TextFontFace,TextFontSize,
            Width,Height,BorderSize,BorderColor,
            Textpadding,transition number,Transition duration,
            Transparency level,shadow type,shadow color,Appearance behavior,TipPositionType,Xpos,Ypos]
*/
/*
echo '
      Style[0]=["white","#2F5376","","","","","black","white","","center","",,300,,1,"#2F5376",2,,,96,2,"black",,,,]
';
echo '
     var TipId="adminmenu"
     var FiltersEnabled = 1
     mig_clay()
     </script>
     ';
*/
	echo '<br /><div id="statbar">';
	echo "<ul>";

	for( $i=0; $i<count($statmenu); $i++ ){
		echo '<li id="' . $tblColors[$i] . '">
                      <a onMouseOver="stm(Text['.$i.'],Style[0])" onMouseOut="htm()"
                         href="' . XOOPS_URL . '/modules/edito/' . $statmenu[$i]['link'] . '">
                      <span>' . $statmenu[$i]['title'] . '</span></a></li>';
	}
	echo '</ul></div>';
    echo '<div style="float: left; width: 100%; text-align: center; margin: 0px; padding: 0px">';
}

function edito_adminfooter() {
	echo '<p/>';
	OpenTable();
	echo '<div style="text-align: center; vertical-align: center">';
    echo sprintf(_MD_EDITO_CREDIT,'<a href="http://wolfactory.wolfpackclan.com" target="_blank">WolFactory</a>', '<a href="http://www.dugris.info" target="_blank">DuGris</a>', '<a href="http://www.blueteen.info" target="_blank">Blueteen</a>' );
    echo '</div>';
	CloseTable();
	echo '<p/>';
}


// Thanks to Mithrandir :-)
function edito_substr($str, $start, $length, $trimmarker = '...')
{
	// If the string is empty, let's get out ;-)
	if ($str == '') {
		return $str;
	}

	// reverse a string that is shortened with '' as trimmarker
	$reversed_string = strrev(xoops_substr($str, $start, $length, ''));

	// find first space in reversed string
	$position_of_space = strpos($reversed_string, " ", 0);

	// truncate the original string to a length of $length
	// minus the position of the last space
	// plus the length of the $trimmarker
	$truncated_string = xoops_substr($str, $start, $length-$position_of_space+strlen($trimmarker), $trimmarker);

	return $truncated_string;
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



function edito_create_dir( $directory = "config" )
{
//	$thePath = XOOPS_ROOT_PATH . "/modules/'.$xoopsModule->dirname().'/" . $directory . "/";
$thePath = XOOPS_ROOT_PATH .'/'.$directory;

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
	$final_target = $target;
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
			Global $xoopsModule;
		  $blank_file = XOOPS_ROOT_PATH . '/modules/'.$xoopsModule->dirname().'/images/blank.gif';
		  copy($blank_file, $final_target.'/blank.gif');
		  $logo_file = XOOPS_ROOT_PATH . '/modules/'.$xoopsModule->dirname().'/images/content_slogo.png';
		  copy($logo_file, $final_target.'/content_slogo.png');
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

// selected, table|id|name|image|groups|where,
// destination, caption, display, size, options
function edito_selector( $sel=0,
                           $sql='|||||',
                           $destination='', 
                           $caption='',
                           $display='select',
                           $size=1,
                           $target='self')
{
          Global $xoopsDB,$xoopsUser;
          $db = explode('|',$sql); // table|id|name|image|groups|where
          $db_table   = $db[0];
          $db_id      = $db[1];
          $db_name    = $db[2];
          if($db[3])  { $db_image =$db[3]; } else { $db_image=$db[1];}
          if($db[4])  { $db_groups=$db[4]; } else {$db_groups=$db[2];}
          $db_where   = $db[5];
          if($db_groups) { $group = is_object($xoopsUser) ? $xoopsUser->getGroups() : array(XOOPS_GROUP_ANONYMOUS); }
          $sql = "SELECT ".$db_id.", ".$db_name.", ".$db_image.", ".$db_groups."
                FROM " . $xoopsDB->prefix( $db_table )."
                ".$db_where."
                ORDER BY ".$db[2]." ASC ";
          $result = $xoopsDB->queryF( $sql);
          $operator='';
          if($target!='self') { $target=' target="_'.$target.'" '; } else { $taget=''; }

// Drop down list
if($display=='select' || $display=='box') {
        $selected[0] = '';
        $selected[$sel] = 'selected';
        $select = '<select size="'.$size.'" name="select'.$db_table.'"
                           onchange="location=\''.$destination.'=\'+this.options[this.selectedIndex].value">
                     <option value=""'.$selected[0].'>'.$caption.'</option>';

while ( list( $id, $name, $image, $groups ) = $xoopsDB -> fetchrow( $result ) )
	{ $select_tmp = $select;
          if( !isset($selected[$id]) ) { $selected[$id] = ''; }
          if( is_numeric($name) && $name < 10000 ) { $name = constant( strtoupper($db_table.'_'.$db_name.'_'.$name)); }
          if( is_numeric($name) && $name >= 10000 ) { $name = formatTimestamp($name,'m'); }
          $select .= '<option value="'.$id.'"'.$selected[$id].'>'.edito_short_title($name, 24).'</option>
          ';}
          $select .= '</select> 
          ';
        if($groups!=$name) {
            $groups = explode(" ",$groups);
            if (count(array_intersect($group,$groups))==0) { $select = $select_tmp; }
	}
 }
 
 

// Unordered list
if($display=='list' ) {
        $select = '<ul>';
while ( list( $id, $name, $image, $groups ) = $xoopsDB -> fetchrow( $result ) )
	{ $select_tmp = $select;
          if( is_numeric($name) && $name < 10000 ) { $name = constant( strtoupper($key[0].'_'.$key[2].'_'.$name)); }
          if( is_numeric($name) && $name >= 10000 ) { $name = formatTimestamp($name,'m'); }
          if( !is_numeric($image) ) { $image = '<img src="'.$image.'" />'; } else { $image = ''; }
          $select .= '<li><a href="'.$destination.'='.$id.'"'.$target.'>'.$image.edito_short_title($name, 42).'</li>
          ';}
          $select .= '</ul>
          ';
          
           if($groups!=$name) {
            $groups = explode(" ",$groups);
            if (count(array_intersect($group,$groups))==0) { $select = $select_tmp; }
           }
 }




 // Align
if($display=='tab' ) {
        $colors_a='#888';
        $colors_txt='#008';
        $colors_bck='#DDD';
        $colors_bck_current='#FFF';
        $colors_bck_hover='#EEE';
        $select = "
    	<style type='text/css'>
    	#edito_tabs { float:left; font-size: 10px; line-height:normal; margin-bottom: 0px;}
    	#edito_tabs ul { margin:0px; margin-top: -11px; padding:0px 0px; list-style:none; }
		#edito_tabs li { display:inline; margin:0; padding:0px;}
		#edito_tabs a  { float:left; background-color: ".$colors_bck."; margin:0px; padding: 5px; text-align: center; text-decoration:none;
                              border: 1px outset ".$colors_txt."; border-bottom: 0px; white-space: nowrap}
		#edito_tabs a span { display:block; white-space: nowrap; color:".$colors_a.";}
		/* Commented Backslash Hack hides rule from IE5-Mac \*/
		#edito_tabs a span {float:none;}
		/* End IE5-Mac hack */
		#edito_tabs a:hover span { color:".$colors_txt."; }
		#edito_tabs #current a { background-color: ".$colors_bck_current."; border: 1px inset ".$colors_txt."; border-bottom: 0px;}
		#edito_tabs #current a span { background-color: ".$colors_bck_current."; color:".$colors_txt."; }
		#edito_tabs a:hover { background-position:0% -150px; background-color: ".$colors_bck_hover."; 
                                   border: 1px inset ".$colors_txt."; border-bottom: 0px;}
		#edito_tabs a:hover span { background-position:100% -150px; background-color: ".$colors_bck_hover."; }
		</style>
    ";
        $select .= '<div id="edito_tabs"><ul>
        ';
        $selected[$sel] = 'current';
while ( list( $id, $name, $image, $groups ) = $xoopsDB -> fetchrow( $result ) )
	{ $select_tmp = $select;
          if( !isset($selected[$id]) ) { $selected[$id] = ''; }
          if( is_numeric($name) && $name < 10000 ) { $name = constant( strtoupper($key[0].'_'.$key[2].'_'.$name)); }
          if( is_numeric($name) && $name >= 10000 ) { $name = formatTimestamp($name,'m'); }
          if( !is_numeric($image) ) { $image = '<img src="../uploads/edito/'.$name.'/'.$image.'" />'; } else { $image = ''; }
          $select .= '<li id="' . $selected[$id] . '">
                      <a href="'.$destination.'='.$id.'"'.$target.'>
                      <span>'.$image.edito_short_title($name, 42).'</span>
                      </a>
                      </li>
          ';
          if($groups!=$name) {
            $groups = explode(" ",$groups);
            if (count(array_intersect($group,$groups))==0) { $select = $select_tmp; }
	}


          }
          $select .= '</ul></div>
          ';
 }


return $select;
}

function edito_short_title( $title='', $length=24, $tiddle='[...]' )
{
     $tiddle_length=round(strlen($tiddle)/4,1);
     $length=round($length-$tiddle_length,1);
     $part2=round($length/4,1);
     $part1=$part2*3;
     $length=round($length);
 if( strlen($title) > $length )
   { $title_01 = substr($title,0,$part1).$tiddle;
     $title_02 = substr($title,-$part2);
     $title=$title_01.$title_02;
   }
//   echo $part1.'+'.$tiddle_length.'+'.$part2.'='.$part1+$tiddle_length+$part2.'/'.$length.'<br />';
   return $title;
}


function edito_GetLastVersion() {
	include_once( '../xoops_version.php');
	$version = @file_get_contents("http://www.wolfpackclan.com/wolfactory/version/edito.version");
	if ($version) {
		if ( $version != ($GLOBALS['xoopsModule']->getVar('version')/100) ) {
       		echo '<div class="bg1" style="margin-bottom:20px; padding:5px; border:2px solid #FF0000; text-align:center; font-weight:bold;">';
			echo _MD_EDITO_MAKE_UPGRADE . '<a href="http://wolfactory.wolfpackclan.com/" target="_blank">http://wolfactory.wolfpackclan.com/</a>';
   	        echo '</div>';

			edito_adminmenu(0, _MD_EDITO_LIST);
			xoops_cp_footer();
   			exit();
		}
	}
}

function edito_UpdatedModule() {
	include_once('../xoops_version.php');
	if ( $modversion['version'] != ($GLOBALS['xoopsModule']->getVar('version')/100) ) {
    	$redirect = XOOPS_URL . '/modules/system/admin.php?fct=modulesadmin&op=update&module=' . $xoopsModule->getVar('dirname');
    	redirect_header( $redirect , 3, _MD_EDITO_MAKE_UPDATE ) ;
	}
}
?>