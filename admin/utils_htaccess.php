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


	 include_once( '../../../mainfile.php');
	 include_once( '../../../include/cp_header.php');

$op=''; $dir='logos';  $sitelist='';
if ( isset( $_POST['op'] )) $op = $_POST['op'];
if ( isset( $_POST['dir'] )) $dir = $_POST['dir'];
if ( isset( $_POST['sitelist'] )) $sitelist = $_POST['sitelist'];

function copy_htaccess($target, $file_content) {
  
       	$handle = fopen($target, 'w+');
		if ($handle) {
			if ( fwrite($handle, $file_content) ) {
               	return true;
			}
        }
        return false;
    }

function utilities( $dir, $sitelist ) {
	global $xoopsConfig, $modify, $xoopsModuleConfig, $xoopsModule, $XOOPS_URL, $xoopsDB;
        if ( !isset($uploadir)) { $uploadir=0; }
//       $select_form = edito_selector($id, 'content_edito|id|subject|||', 'uploader.php?id');
$current_dir=$xoopsModuleConfig['sbuploaddir']; $select[1]='';
// if($dir=='media') { $select=" selected"; $current_dir='media';  } else { $select=''; $current_dir='';}

        $sform = new XoopsThemeForm( _MD_EDITO_HTACCESS, "op", xoops_getenv( 'PHP_SELF' ) );
        $sform -> setExtra( 'enctype="multipart/form-data"' );

// Directories
        $dirs = array('logos'=>'logos','media'=>'media');
	$pagedir_array = $dirs;
 	$pagedir_select = new XoopsFormSelect( '', 'dir', $dir );
	$pagedir_select -> addOptionArray( $pagedir_array );
	$pagedir_tray = new XoopsFormElementTray( _MD_EDITO_HTACCESS, '&nbsp;' );
	$pagedir_tray -> addElement( $pagedir_select );
	$sform -> addElement( $pagedir_tray );

        $hidden = new XoopsFormHidden( 'dir', $dir );
        
        $sform->addElement(new XoopsFormTextArea(_MD_EDITO_SITELIST, 'sitelist', $sitelist, 5 ), FALSE );

        $button_tray = new XoopsFormElementTray( '', '' );
	$hidden = new XoopsFormHidden( 'op', '' );

	$button_tray -> addElement( $hidden );
	$butt_create = new XoopsFormButton( '', '', _MD_EDITO_SUBMIT, 'submit' );
	$butt_create->setExtra('onclick="this.form.elements.op.value=\'protect\'"');
	$button_tray->addElement( $butt_create );
	$butt_cancel = new XoopsFormButton( '', '', _MD_EDITO_CANCEL, 'button' );
	$butt_cancel->setExtra('onclick="history.go(-1)"');
	$button_tray->addElement( $butt_cancel );

	$sform -> addElement( $button_tray );

	$sform -> display();
	unset( $hidden );
}


function create_htaccess ( $dir, $sitelist='' ) {
  global $xoopsModule, $xoopsModuleConfig;
    	$domain = ereg_replace('http://', '', XOOPS_URL);
    	$domain = ereg_replace('www.', '', $domain);
    	$domain = explode('/', $domain);
    	$domain = $domain[0].pathinfo($domain[1],PATHINFO_EXTENSION);

    $media_list = 'gif|tif|jpg|jpeg|png|mpg|mpeg|avi|mp3|flx|swf|wmv|asx|ram|rm|mp3|wav|mid';

    $code = "
RewriteEngine On
RewriteCond %{HTTP_REFERER} !^$
RewriteCond %{HTTP_REFERER} !^http://(www\.)?".$domain."/.*$ [NC]";
if($sitelist) {
    $sitelist=explode('|',$sitelist);
    foreach($sitelist as $siteurl) {
    	$domain = ereg_replace('http://', '', trim($siteurl));
    	$domain = ereg_replace('www.', '', $domain);
    	$domain = explode('/', $domain);
    	$domain = ereg_replace('\.', '\\.', $domain[0]);
    $code .= "
RewriteCond %{HTTP_REFERER} !^http://(www\.)?".$domain."/.*$ [NC]
";
    }
}
    
    $code .= "
RewriteRule [^/]+.(".$media_list.")$ ".XOOPS_URL."/images/logo.gif [R,L,NC]";
if($dir=='media') { $current_dir=$xoopsModuleConfig['sbmediadir'];  } else { $current_dir=$xoopsModuleConfig['sbuploaddir']; }

   $target = XOOPS_ROOT_PATH . "/" . $current_dir . "/.htaccess";
  copy_htaccess($target, $code);
}

function display_htaccess( $dir, $sitelist='' ) {
	global $xoopsModule;
	$myts =& MyTextSanitizer::getInstance();
	$info1 = _MD_EDITO_HTACCESS_INFO1;
	$info2 = _MD_EDITO_HTACCESS_INFO2;

	$instructions_01 = '<tr class="odd"><td colspan="2" align="left">
                       '.$myts->makeTareaData4Show($info1).'
                       </td></tr>';

	$instructions_02 = '<tr class="odd"><td colspan="2" align="left">
                           '.$myts->makeTareaData4Show($info2).'
                       </td></tr>';


    	$domain = ereg_replace('http://', '', XOOPS_URL);
    	$domain = ereg_replace('www.', '', $domain);
    	$domain = explode('/', $domain);
    	$domain = $domain[0].pathinfo($domain[1],PATHINFO_EXTENSION);

    $media_list = 'gif|tif|jpg|jpeg|png|mpg|mpeg|avi|mp3|flx|swf|wmv|asx|ram|rm|mp3|wav|mid';

    $code = "
RewriteEngine On
RewriteCond %{HTTP_REFERER} !^$
RewriteCond %{HTTP_REFERER} !^http://(www\.)?".$domain."/.*$ [NC]";
if($sitelist) {
    $sitelist=explode('|',$sitelist);
    foreach($sitelist as $siteurl) {
    	$domain = ereg_replace('http://', '', trim($siteurl));
    	$domain = ereg_replace('www.', '', $domain);
    	$domain = explode('/', $domain);
    	$domain = ereg_replace('\.', '\\.', $domain[0]);
    $code .= "
RewriteCond %{HTTP_REFERER} !^http://(www\.)?".$domain."/.*$ [NC]
";
    }
}
    
    $code .= "
RewriteRule [^/]+.(".$media_list.")$ ".XOOPS_URL."/images/logo.gif [R,L,NC]";

	// To display a picture insert this code
	// RewriteRule [^/]+.(".$media_list.")$ ".XOOPS_URL."/modules/" . $xoopsModule->dirname()."/images/restricted.gif [R,L]

	$htaccess = '<tr class="odd"><td colspan="2">
    			 <script type="text/javascript" language="Javascript">
                 function SelectIt(Code){
                 	if (Code.value=="") {
						alert(\'No code to copy\')
					}else{
						Code.focus();
						Code.select();
                        if (document.getElementById("1")){
                        	Code.createTextRange().execCommand("Copy");
						}
					}
				 }
				 </script>

                 <form name="copy">
                 <textarea rows="10" cols="160" name="Obj" id="1" wrap="off">'.$code.'</textarea><br />
                 <input onclick="SelectIt(this.form.Obj)" type="button" name="copy" value="'._MD_EDITO_COPY.'" />
                 </div>
                 </form>
                 </td>
                 </tr>';

    $sform = new XoopsThemeForm( _MD_EDITO_HTACCESS, "", "" );
    $sform -> setExtra( 'enctype="multipart/form-data"' );
    $sform -> addElement($instructions_01);
    $sform -> addElement($htaccess);
    $sform -> addElement($instructions_02);
    $sform -> display();
    unset( $hidden );
}


/* -- Available operations -- */
switch ( $op ) {
  	case "utilities":
	default:
	include_once( "admin_header.php" );
	edito_adminmenu(2, _MD_EDITO_UTILITIES.'<br />'._MD_EDITO_HTACCESS);
	edito_statmenu(5, '');
	utilities( $dir, $sitelist );
        include_once( 'admin_footer.php' );
    break;
    

	case "protect":
	if($dir=='media') { $current_dir=$xoopsModuleConfig['sbmediadir'];  } else { $current_dir=$xoopsModuleConfig['sbuploaddir']; }

	include_once( "admin_header.php" );
	edito_adminmenu(2, _MD_EDITO_UTILITIES.'<br />'._MD_EDITO_HTACCESS);
	edito_statmenu(5, '');
	if( function_exists('fopen') ) {create_htaccess( $dir, $sitelist );}
          utilities( $dir, $sitelist );
          display_htaccess( $dir, $sitelist ); 
        include_once( 'admin_footer.php' );


    break;
}
?>