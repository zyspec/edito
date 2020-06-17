<?php
/**
* XOOPS - PHP Content Management System
* Copyright (c) 2004 <http://www.xoops.org/>
*
* Module: edito 
* Licence : GPL
* Authors :
*           - solo (http://www.wolfpackclan.com/wolfactory)
*			- DuGris (http://www.dugris.info)
*/


include_once( '../../../mainfile.php');
include_once( '../../../include/cp_header.php');

$op = '';
foreach ( $HTTP_POST_VARS as $k => $v ) { ${$k} = $v; }
foreach ( $HTTP_GET_VARS as $k => $v ) { ${$k} = $v; }
if ( isset( $_GET['op'] ) ) $op = $_GET['op'];
if ( isset( $_POST['op'] ) ) $op = $_POST['op'];
if ( isset($_GET['dir'])) { $dir = $_GET['dir']; } else { $dir = ''; }
if ( isset($_POST['dir'])) { $dir = $_POST['dir']; }

function utilities( $dir ) {
	global $xoopsConfig, $modify, $xoopsModuleConfig, $xoopsModule, $XOOPS_URL, $xoopsDB;
        if ( !isset($uploadir)) { $uploadir=0; }
//       $select_form = edito_selector($id, 'content_edito|id|subject|||', 'uploader.php?id');
$current_dir=$xoopsModuleConfig['sbuploaddir']; $select[1]='';
if($dir=='media') { $select=" selected"; $current_dir=$xoopsModuleConfig['sbmediadir'];  } else { $select=''; $current_dir=$xoopsModuleConfig['sbuploaddir']; }
$select_form = '
                <select size="1"  name="selectcontent_edito" onchange="location=\'utils_uploader.php?dir=\'+this.options[this.selectedIndex].value">
                <option value="logo">             [LOGO]: '.$xoopsModuleConfig['sbuploaddir'].'/</option>
                <option value="media"'.$select.'> [MEDIA]: '.$xoopsModuleConfig['sbmediadir'].' /</option>
                </select>
';

        $sform = new XoopsThemeForm( _MD_EDITO_UPLOAD .' : '.$select_form , "op", xoops_getenv( 'PHP_SELF' ) );
        $sform -> setExtra( 'enctype="multipart/form-data"' );
        
// Media
        $dirs = array('logo','media');
 	$pagedir_array = $dirs;
 	$pagedir_select = new XoopsFormSelect( '', 'dir', $dir );
	$pagedir_select -> addOptionArray( $pagedir_array );
	$pagedir_tray = new XoopsFormElementTray( _MD_EDITO_PAGE, '&nbsp;' );
	$pagedir_tray -> addElement( $pagedir_select );

	$sform -> addElement( new XoopsFormHidden( 'dir', $dir ) );


// File selector
	$sform -> addElement( new XoopsFormFile( _MD_EDITO_UPLOADMEDIA, 'cmedia', '' ), TRUE );

	$button_tray = new XoopsFormElementTray( '', '' );
	$hidden = new XoopsFormHidden( 'op', 'uploadmedia' );
	$button_tray -> addElement( $hidden );
	$butt_create = new XoopsFormButton( '', '', _MD_EDITO_SUBMIT, 'submit' );
	$butt_create->setExtra('onclick="this.form.elements.op.value=\'uploadmedia\'"');
	$button_tray->addElement( $butt_create );
	$butt_clear = new XoopsFormButton( '', '', _MD_EDITO_CLEAR, 'reset' );
	$button_tray->addElement( $butt_clear );
	$butt_cancel = new XoopsFormButton( '', '', _MD_EDITO_CANCEL, 'button' );
	$butt_cancel->setExtra('onclick="history.go(-1)"');
	$button_tray->addElement( $butt_cancel );

	$sform -> addElement( $button_tray );
	
	//	Code to create the media selector
	$graph_array = & XoopsLists :: getImgListAsArray( XOOPS_ROOT_PATH . '/'.$current_dir );
	$image_select = new XoopsFormSelect( '', 'image', '' );
	$image_select -> addOptionArray( $graph_array );
	$image_select -> setExtra( 'onchange=\'showImgSelected("image5", "image", "' . $current_dir . '", "", "' . XOOPS_URL . '")\'' );
	$image_tray = new XoopsFormElementTray( _MD_EDITO_MEDIA, '&nbsp;' );
	$image_tray -> addElement( $image_select );
 	$image_tray -> addElement( new XoopsFormLabel( '', '<p /><img src="' . XOOPS_URL . '/modules/edito/images/blank.gif" name="image5" id="image5" alt="" />' ) );
	$sform -> addElement( $image_tray );


	$sform -> display();
	unset( $hidden );
}


function edito_uploader( $file_name='',
                            $allowed_mimetypes='',
                            $dir='uploads/edito/',
                            $redirecturl = 'utils_uploader.php',
                            $file_options='1024|748|1024000)',
                            $num=0, $redirect=1 )
{
    global $HTTP_POST_VARS;
    include_once XOOPS_ROOT_PATH . "/class/uploader.php";
    $media_options  = explode('|', $file_options);
    $maxfilewidth   = $media_options[0];
    $maxfileheight  = $media_options[1];
    $maxfilesize    = $media_options[2];
    $uploaddir      = XOOPS_ROOT_PATH . "/" . $dir;
    $file           = $uploaddir .'/'. $file_name;
    if( is_file($file) ) { unlink($file); $comment=_MD_EDITO_UPDATED;} else { $comment=_MD_EDITO_UPLOADED; }
    
    $uploader = new XoopsMediaUploader( $uploaddir, $allowed_mimetypes, $maxfilesize, $maxfilewidth, $maxfileheight );

    if ( $uploader -> fetchMedia( $HTTP_POST_VARS['xoops_upload_file'][$num] ) )
    {
                    if ( !$uploader -> upload() ) {
                        $errors = $uploader -> getErrors();
                        redirect_header( $redirecturl, 3, _MD_EDITO_UPLOAD_ERROR . $errors );
                    } else {
                        if ( $redirect ) { redirect_header( $redirecturl, $redirect, $comment ); }
                    }
    } else {
        $errors = $uploader -> getErrors();
        redirect_header( $redirecturl, 3, _MD_EDITO_UPLOAD . $errors );
    }

}


/* -- Available operations -- */
switch ( $op ) {
	case "uploadmedia":
	// $xoopsModuleConfig['sbuploaddir'],$xoopsModuleConfig['sbmediadir']
	$allowed_mimetypes = array( 'image/gif', 
                                    'image/jpeg', 
                                    'image/pjpeg', 
                                    'image/x-png', 
                                    'image/png' );
        $file_name = $HTTP_POST_FILES['cmedia']['name'];
        if($dir=='media') { $current_dir=$xoopsModuleConfig['sbmediadir'];  } else { $current_dir=$xoopsModuleConfig['sbuploaddir']; }
        edito_uploader( $file_name,
                           $allowed_mimetypes, 
                           $current_dir,
                           'utils_uploader.php?dir='.$dir );
        break;


    case "utilities":
    default:
    	include_once( "admin_header.php" );
        edito_adminmenu(2, _MD_EDITO_UTILITIES.'<br />'._MD_EDITO_UPLOAD);
        edito_statmenu(0, '');
        utilities($dir);
        include_once( 'admin_footer.php' );
	break;
}
?>