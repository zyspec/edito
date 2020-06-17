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

$op = '';

foreach ( $HTTP_POST_VARS as $k => $v ) {
    ${$k} = $v;
}

foreach ( $HTTP_GET_VARS as $k => $v ) {
    ${$k} = $v;
}

if ( isset( $_GET['op'] ) ) $op = $_GET['op'];
if ( isset( $_POST['op'] ) ) $op = $_POST['op'];

// -- Edit function -- //
function editarticle( $id = '', $op = '' ) {
	global $xoopsUser, $xoopsConfig, $xoopsDB, $modify, $xoopsModuleConfig, $xoopsModule, $XOOPS_URL;
	$myts =& MyTextSanitizer::getInstance();

        edito_create_dir( $xoopsModuleConfig['sbmediadir'] );
	edito_create_dir( $xoopsModuleConfig['sbuploaddir'] );

//	include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
//	include_once XOOPS_ROOT_PATH .'/modules/edito/include/functions.php';

	/**
	* Clear all variables before we start
	*/
	if(!isset($counter)) { $counter = 0; }
	if(!isset($status)) { $status = 1; } else { $status = intval($status); }
	if(!isset($subject)) { $subject = ""; }

	if(!isset($block_text)) { $block_text = ''; } else { $block_text = intval($block_text); }

	if(!isset($body_text)) {
    	if ( $xoopsModuleConfig['informations'] == '{lorem}') {
        	$body_text = _MD_EDITO_LOREMIPSUM;
        } else {
        	$body_text = $xoopsModuleConfig['informations'];
        }
	} else {
    	intval($body_text);
    }

	if(!isset($image)) { $image = 'blank.gif'; } else { $image = intval($image); }

	if(!isset($media_url)) { $media_url = ''; } else { $media_url = intval($media_url); }
	if(!isset($media_file)) { $media_file = ''; } else { $media_file = intval($media); }
	if(!isset($media_size)) { $media_size = $xoopsModuleConfig['media_size']; } else { $media_size = intval($media_size); }

	if(!isset($meta_title)) { $meta_title = ''; } else { $meta_title = intval($meta_title); }
	if(!isset($meta_description)) { $meta_description = $xoopsModuleConfig['moduleMetaDescription']; } else { $meta_description = intval($meta_description); }
	if(!isset($meta_keywords)) { $meta_keywords = $xoopsModuleConfig['moduleMetaKeywords']; } else { $meta_keywords = intval($meta_keywords); }

	if(!isset($groups)) { $groups = $xoopsModuleConfig['groups']; } else { $groups = intval($groups); }

    // Options
	if(!isset($html)) { $html = 1; } else { $html = intval($html); }
	if(!isset($xcode)) { $xcode = 1; } else { $xcode = intval($xcode); }
	if(!isset($smiley)) { $smiley = 1; } else { $smiley = intval($smiley); }
	if(!isset($logo)) { $logo = $xoopsModuleConfig['option_logo']; } else { $logo = intval($logo); }
	if(!isset($block)) { $block = $xoopsModuleConfig['option_block']; } else { $block = intval($block); }
	if(!isset($title)) { $title = $xoopsModuleConfig['option_title']; } else { $title = intval($title); }
 	if(!isset($cancomment)) { $cancomment = $xoopsModuleConfig['cancomment']; } else { $cancomment = intval($cancomment); }

        $option_def = '1\|1\|1\|' .
    		  $xoopsModuleConfig['option_logo'] . 
                  '\|.\|' .
                  $xoopsModuleConfig['option_title'] . '\|' .
                  $xoopsModuleConfig['cancomment'];

	if(!isset($options)) { $options = $option_def; }
	$meta_gen = '';

    // If there is a parameter, and the id exists, retrieve data: we're editing an edito
        	// Activate Content guide
    	$block_help = '<div style="text-align:right;"><a title="show/hide"
                    id="helpblock_link"
                    href="javascript: void(0);"
                    onclick="toggle(this, \'helpblock\');">[-]</a>['._MD_EDITO_HELP.']</div>';

	if ( $id ) {
		$result = $xoopsDB -> queryF( "SELECT * FROM " . $xoopsDB -> prefix( "content_" .$xoopsModule->dirname() ) . " WHERE id = $id" );

		if ( !$xoopsDB -> getRowsNum( $result ) ) {
			redirect_header( "index.php", 1, _MD_EDITO_NOEDITOTOEDIT );
			exit();
		}

		list( $id, $uid, $datesub, $counter, $status, $subject, $block_text, $body_text, $image, $media, $meta, $groups, $options ) = $xoopsDB -> fetchrow( $result );

//		$myts =& MyTextSanitizer::getInstance();

        $sform = new XoopsThemeForm( _MD_EDITO_MODEDITO . ": ". $subject . $block_help, "op", xoops_getenv( 'PHP_SELF' ) );
        $groups 			= explode(" ", $groups);

        $media 				= explode("|", $media);
        $media_file      	=  $media[0];
        $media_url       	=  $media[1];
        $media_size      	=  $media[2];

        $meta 			= explode("|", $meta);
        $meta_title		=  $meta[0];
        $meta_description	=  $meta[1];
        $meta_keywords		=  $meta[2];
        $meta_gen		=  $meta[3];

        $option				= explode("|", $options);
		$html				=  $option[0];
		$xcode				=  $option[1];
		$smiley				=  $option[2];
		$logo				=  $option[3];
		$block				=  $option[4];
		$title				=  $option[5];
		$cancomment			=  $option[6];
	} else {				// there's no parameter, so we're adding an edito
		$sform = new XoopsThemeForm( _MD_EDITO_CREATE . $block_help, "op", xoops_getenv( 'PHP_SELF' ) );
	}

  $script = '<script language="JavaScript" type="text/javascript" src="../script/expandable.js"></script>
  <style type="text/css">td .head { width: 25%; }</style>';

	// Activate Content options
	$block_in = '<tr><th colspan="2">
    			 <div align="center">
                 <!-- flooble Expandable Content box start -->
                 <a title="show/hide"
                    id="selectblock_link"
                    href="javascript: void(0);"
                    onclick="toggle(this, \'selectblock\');">[-]</a>['._MD_EDITO_BLOCKS.']
                                     </div>
                 </th></tr></table>
                 <div id="selectblock">
                 <table width="100%" class="outer" cellspacing="1">';

	$block_out = "</table></div>";

    if ( !$block_text ) {
		$block_out .= "<script type='text/javascript' language='javascript'>toggle(getObject(\"selectblock_link\"), \"selectblock\");</script>";
	}

        $block_out .= "<!-- flooble Expandable Content box end  --><table width='100%' class='outer' cellspacing='1'>";


	$block_help_in = '
                 <tr><td colspan="2">
    		         <div id="helpblock" style="text-align:left;">
                             ' . $myts->displayTarea(_MD_EDITO_CONTENT_HELP, 1, 1, 1) . '
                         </div>
                 </td></tr></table>
                 <script type="text/javascript" language="javascript">toggle(getObject(\'helpblock_link\'), \'helpblock\');</script>
                 <!-- flooble Expandable Content box end  -->
                 <table width="100%" class="outer" cellspacing="1">';

// Activate Images options
        // Activate image guide
    	$image_help = '<div style="text-align:right;">
            <a title="show/hide"
                    id="helpimage_link"
                    href="javascript: void(0);"
                    onclick="toggle(this, \'helpimage\');">[-]</a>['._MD_EDITO_HELP.']</div>';

	$image_help_in = '
                 <tr><td colspan="2">
    		         <div id="helpimage" style="text-align:left;">
                             ' . $myts->displayTarea(_MD_EDITO_IMAGE_HELP, 1, 1, 1) . '
                         </div>
                 </td></tr></table>
                 <script type="text/javascript" language="javascript">toggle(getObject(\'helpimage_link\'), \'helpimage\');</script>
                 <!-- flooble Expandable Content box end  -->
                 ';

	$image_in = '<tr><th colspan="2">
    			 <div align="center">
                 <!-- flooble Expandable Content box start -->
                 <a title="show/hide"
                    id="selectimage_link"
                    href="javascript: void(0);"
                    onclick="toggle(this, \'selectimage\');">[-]</a>['._MD_EDITO_IMAGEOPTIONS.'] ' . $image_help . '
                 </div>

                 </th></tr>
                 ' . $image_help_in . '
                 <div id="selectimage">
                 <table width="100%" class="outer" cellspacing="1">';

     $image_out = "</table></div>";

     $image_out .= "<!-- flooble Expandable Content box end  --><table width='100%' class='outer' cellspacing='1'>";

    if ( !$image || $image == 'blank.gif' ) {
		$image_out .= '<script type="text/javascript" language="javascript">toggle(getObject("selectimage_link"), "selectimage");</script>';
	}

    $image_out .= "<!-- flooble Expandable Content box end  --><table width='100%' class='outer' cellspacing='1'>";


// Activate Media options

        // Activate image guide
    	$media_help = '<div style="text-align:right;">
            <a title="show/hide"
                    id="helpmedia_link"
                    href="javascript: void(0);"
                    onclick="toggle(this, \'helpmedia\');">[-]</a>['._MD_EDITO_HELP.']</div>';

	$media_help_in = '
                 <tr><td colspan="2">
    		         <div id="helpmedia" style="text-align:left;">
                             ' . $myts->displayTarea(_MD_EDITO_MEDIA_HELP, 1, 1, 1) . '
                         </div>
                 </td></tr></table>
                 <script type="text/javascript" language="javascript">toggle(getObject(\'helpmedia_link\'), \'helpmedia\');</script>
                 <!-- flooble Expandable Content box end  -->';

	$media_in = '<tr><th colspan="2">
    			 <div align="center">
                 <!-- flooble Expandable Content box start -->
                 <a title="show/hide"
                    id="selectmedia_link"
                    href="javascript: void(0);"
                    onclick="toggle(this, \'selectmedia\');">[-]</a>['._MD_EDITO_MEDIAOPTIONS.'] ' . $media_help . '
                 </div>
                 </th></tr>
                 '.$media_help_in.'
                 <div id="selectmedia">
                 <table width="100%" class="outer" cellspacing="1">';

     $media_out = "</table></div>";

     if ( !$media_file && !$media_url ) {
		$media_out .= '<script type="text/javascript" language="javascript">toggle(getObject("selectmedia_link"), "selectmedia");</script>';
	}

    $media_out .= "<!-- flooble Expandable Content box end  --><table width='100%' class='outer' cellspacing='1'>";


// Activate Meta options
        // Activate meta guide
    	$meta_help = '<div style="text-align:right;">
            <a title="show/hide"
                    id="helpmeta_link"
                    href="javascript: void(0);"
                    onclick="toggle(this, \'helpmeta\');">[-]</a>['._MD_EDITO_HELP.']</div>';

	$meta_help_in = '
                 <tr><td colspan="2">
    		         <div id="helpmeta" style="text-align:left;">
                             ' . _MD_EDITO_META_HELP . '
                         </div>
                 </td></tr></table>
                 <script type="text/javascript" language="javascript">toggle(getObject(\'helpmeta_link\'), \'helpmeta\');</script>
                 <!-- flooble Expandable Content box end  -->';

	$meta_in = '<tr><th colspan="2">
    			 <div align="center">
                 <!-- flooble Expandable Content box start -->
                 <a title="show/hide"
                    id="selectmeta_link"
                    href="javascript: void(0);"
                    onclick="toggle(this, \'selectmeta\');">[-]</a>['._MD_EDITO_METAOPTIONS.']   ' . $meta_help . '
                 </div>
                 </th></tr>
                 '.$meta_help_in.'
                 <div id="selectmeta">
                 <table width="100%" class="outer" cellspacing="1">';

    $meta_out = "</table></div>";

    if ( $xoopsModuleConfig['metamanager'] != 'manual' ) {
    	$meta_out .= '<script type="text/javascript" language="javascript">toggle(getObject("selectmeta_link"), "selectmeta");</script>';
    }

    $meta_out .= "<!-- flooble Expandable Content box end  --><table width='100%' class='outer' cellspacing='1'>";

// Misc data
        // Activate misc guide
    	$misc_help = '<div style="text-align:right;">
            <a title="show/hide"
                    id="helpmisc_link"
                    href="javascript: void(0);"
                    onclick="toggle(this, \'helpmisc\');">[-]</a>['._MD_EDITO_HELP.']</div>';

	$misc_help_in = '
                 <tr><td colspan="2">
    		         <div id="helpmisc" style="text-align:left;">
                             ' . $myts->displayTarea(_MD_EDITO_MISC_HELP, 1, 1, 1) . '
                         </div>
                 </td></tr></table>
                 <script type="text/javascript" language="javascript">toggle(getObject(\'helpmisc_link\'), \'helpmisc\');</script>
                 <!-- flooble Expandable Content box end  -->';

	$misc_in = '<tr><th colspan="2">
    			 <div align="center">
                 <!-- flooble Expandable Content box start -->
                 <a title="show/hide"
                    id="selectmisc_link"
                    href="javascript: void(0);"
                    onclick="toggle(this, \'selectmisc\');">[-]</a>['._MD_EDITO_MISCOPTIONS.'] ' . $misc_help . '
                 </div>
                 </th></tr>
                 '.$misc_help_in.'
                 <div id="selectmisc">
                 <table width="100%" class="outer" cellspacing="1">';

    $misc_out = "</table></div>";

	if ( (ereg($option_def, $options) OR $option_def==$options) && $groups == $xoopsModuleConfig['groups'] ) {
		$misc_out .= '<script type="text/javascript" language="javascript">toggle(getObject("selectmisc_link"), "selectmisc");</script>';
    }

    $misc_out .= "<!-- flooble Expandable Content box end  --><table width='100%' class='outer' cellspacing='1'>";


    $sform -> addElement($script);
    $sform -> setExtra( 'enctype="multipart/form-data"' );

	// Subject
	// This part is common to edit/add
        $sform -> addElement($block_help_in);
        $sform -> addElement($block_help_out);
	$sform -> addElement( new XoopsFormText( _MD_EDITO_SUBJECT, 'subject', 50, 255, $myts->htmlSpecialChars($subject) ), true );
    // ONLINE
	// Code to take article offline, for maintenance purposes
//	$status_radio = new XoopsFormRadioYN(_MD_EDITO_SWITCHOFFLINE, 'offline', $status, ' '._MD_EDITO_YES.'', ' '._MD_EDITO_NO.'');
//	$sform -> addElement($status_radio);

	$status_radio = new XoopsFormSelect(_MD_EDITO_STATUS, 'status', $status);
	$status_radio->addOption("0", _MD_EDITO_OFFLINE);
	$status_radio->addOption("1", _MD_EDITO_WAITING);
	$status_radio->addOption("2", _MD_EDITO_HIDDEN);
	$status_radio->addOption("3", _MD_EDITO_ONLINE);
	$status_radio->addOption("4", _MD_EDITO_HTMLMODE);
	$status_radio->addOption("5", _MD_EDITO_PHPMODE);
	$sform -> addElement( $status_radio );

/*
	if ( $xoopsModuleConfig['parents']){
//		PARENT
		$db =& Database::getInstance();
		$xt = new XoopsTree($db->prefix("edito"), "id", "pid");

		ob_start();
		$xt->makeMySelBox('subject', 'subject', $pid, 1,'pid');
		$sform->addElement(new XoopsFormLabel(_MD_EDITO_FATHER_INDEX, ob_get_contents()));
		ob_end_clean();
	}
*/

	$sform -> addElement($block_in);

    // Block text
/*
	if ( $xoopsModuleConfig['wysiwyg'] == 'koivi' AND is_file(XOOPS_ROOT_PATH . '/class/wysiwyg/formwysiwygtextarea.php') ) {
		include_once XOOPS_ROOT_PATH . '/class/wysiwyg/formwysiwygtextarea.php';
		$wysiwyg_text_area_01= new XoopsFormWysiwygTextArea( 'Koivi Editor<p />'._MD_EDITO_BLOCKTEXT, 'block_text', $block_text, '100%', '400px','');
		$wysiwyg_text_area_01->setUrl("/class/wysiwyg");
		$wysiwyg_text_area_01->setSkin("default");
		$sform -> addElement( $wysiwyg_text_area_01, false );
	} elseif ( $xoopsModuleConfig['wysiwyg'] == 'tiny' AND is_file(XOOPS_ROOT_PATH . '/class/xoopseditor/tinyeditor/formtinyeditortextarea.php') ) {
		include_once XOOPS_ROOT_PATH . '/class/xoopseditor/tinyeditor/formtinyeditortextarea.php';
		$sform->addElement(new XoopsFormTinyeditorTextArea(array('caption'=> 'Tiny Editor<p />'._MD_EDITO_BLOCKTEXT, 'name'=>'block_text', 'value'=>$block_text, 'width'=>'100%', 'height'=>'468px'),false));
	} elseif ( $xoopsModuleConfig['wysiwyg'] == 'inbetween' AND is_file(XOOPS_ROOT_PATH . '/class/xoopseditor/inbetween/forminbetweentextarea.php') ) {
		include_once XOOPS_ROOT_PATH . '/class/xoopseditor/inbetween/forminbetweentextarea.php';
		$sform->addElement(new XoopsFormInbetweenTextArea(array('caption'=> 'Inbetween Editor<p />'._MD_EDITO_BLOCKTEXT, 'name'=>'block_text', 'value'=>$block_text, 'width'=>'100%', 'height'=>'468px'),false));
	} else {
		$sform -> addElement( new XoopsFormDhtmlTextArea( 'DHTML Editor<p />'._MD_EDITO_BLOCKTEXT, 'block_text', $block_text, 15, 60 ) );
	}
*/

	$block_text = $myts->makeTareaData4Edit( $block_text );
	if ( $xoopsModuleConfig['wysiwyg'] == 'koivi' AND is_file(XOOPS_ROOT_PATH . '/class/wysiwyg/formwysiwygtextarea.php') ) {
    	include_once XOOPS_ROOT_PATH . '/class/wysiwyg/formwysiwygtextarea.php';
		$wysiwyg_text_area_02= new XoopsFormWysiwygTextArea( 'Koivi Editor<p />'._MD_EDITO_BLOCKTEXT, 'block_text', $block_text, '100%', '400px','');
		$wysiwyg_text_area_02->setUrl("/class/wysiwyg");
		$wysiwyg_text_area_02->setSkin("default");
		$sform -> addElement( $wysiwyg_text_area_02, false );
	} elseif ( $xoopsModuleConfig['wysiwyg'] == 'tinyeditor'  AND is_file(XOOPS_ROOT_PATH . '/class/xoopseditor/tinyeditor/formtinyeditortextarea.php') ) {
		include_once XOOPS_ROOT_PATH . "/class/xoopseditor/tinyeditor/formtinyeditortextarea.php";
		$sform->addElement(new XoopsFormTinyeditorTextArea(array('caption'=> 'Tiny Editor<p />'._MD_EDITO_BLOCKTEXT, 'name'=>'block_text', 'value'=>$block_text, 'width'=>'100%', 'height'=>'468px'),false));
	} elseif ( $xoopsModuleConfig['wysiwyg'] == 'inbetween' AND is_file(XOOPS_ROOT_PATH . '/class/xoopseditor/inbetween/forminbetweentextarea.php') ) {
		include_once XOOPS_ROOT_PATH . "/class/xoopseditor/inbetween/forminbetweentextarea.php";
		$sform->addElement(new XoopsFormInbetweenTextArea(array('caption'=> 'Inbetween Editor<p />'._MD_EDITO_BLOCKTEXT, 'name'=>'block_text', 'value'=>$block_text, 'width'=>'100%', 'height'=>'468px'),false));
	} elseif ( $xoopsModuleConfig['wysiwyg'] == 'fck' AND is_file(XOOPS_ROOT_PATH . '/class/fckeditor/formfckeditor.php') ) {
		include_once XOOPS_ROOT_PATH . "/class/fckeditor/formfckeditor.php";
		$sform->addElement(new XoopsFormFckeditor(array('caption'=> 'FCK Editor<p />'._MD_EDITO_FCK, 'name'=>'block_text', 'value'=>$block_text),false));
	} elseif ( $xoopsModuleConfig['wysiwyg'] == 'spaw' AND is_file(XOOPS_ROOT_PATH . '/class/spaw/formspaw.php') ) {
		include_once XOOPS_ROOT_PATH . "/class/spaw/formspaw.php";
		$sform->addElement(new XoopsFormSpaw(array('caption'=> 'Spaw Editor<p />'._MD_EDITO_SPAW, 'name'=>'block_text', 'value'=>$block_text),false));
	} elseif ( $xoopsModuleConfig['wysiwyg'] == 'textarea' AND is_file(XOOPS_ROOT_PATH . '/class/xoopseditor/inbetween/forminbetweentextarea.php') ) {
		$sform->addElement(new XoopsFormTextArea(array('caption'=> 'Inbetween Editor<p />'._MD_EDITO_BLOCKTEXT, 'name'=>'block_text', 'value'=>$block_text),false));
	} else {
		$sform -> addElement( new XoopsFormDhtmlTextArea( 'DHTML Editor<p />'._MD_EDITO_BLOCKTEXT, 'block_text', $block_text, 15, 60 ) );
	}

//	include_once( '../include/functions_wysiwyg.php');
//	edito_getWysiwygForm($type = 'dhtml', $caption, $name, $value = '', $width = '100%', $height = '400px', $supplemental='')
//	$wysiwyg1 = edito_getWysiwygForm( $xoopsModuleConfig['wysiwyg'], _MD_EDITO_BLOCKTEXT, 'block_text', $block_text, '100%', '468px', '');
//	$sform -> addElement($wysiwyg1,false);

	// Block content in article?
	// Code to put article in block
	$block_radio = new XoopsFormRadioYN( _MD_EDITO_BLOCK, 'block', $block , ' ' . _MD_EDITO_YES . '', ' ' . _MD_EDITO_NO . '' );
	$sform -> addElement( $block_radio );

	$sform -> addElement($block_out);

	// Body text
	$body_text = $myts->makeTareaData4Edit( $body_text );
	if ( $xoopsModuleConfig['wysiwyg'] == 'koivi' AND is_file(XOOPS_ROOT_PATH . '/class/wysiwyg/formwysiwygtextarea.php') AND $status != 5 ) {
		include_once XOOPS_ROOT_PATH . '/class/wysiwyg/formwysiwygtextarea.php';
		$wysiwyg_text_area_02= new XoopsFormWysiwygTextArea( 'Koivi Editor<p />'._MD_EDITO_BODYTEXT, 'body_text', $body_text, '100%', '400px','');
		$wysiwyg_text_area_02->setUrl("/class/wysiwyg");
		$wysiwyg_text_area_02->setSkin("default");
		$sform -> addElement( $wysiwyg_text_area_02, false );
	} elseif ( $xoopsModuleConfig['wysiwyg'] == 'tinyeditor'  AND is_file(XOOPS_ROOT_PATH . '/class/xoopseditor/tinyeditor/formtinyeditortextarea.php') AND $status != 5 ) {
		include_once XOOPS_ROOT_PATH . "/class/xoopseditor/tinyeditor/formtinyeditortextarea.php";
		$sform->addElement(new XoopsFormTinyeditorTextArea(array('caption'=> 'Tiny Editor<p />'._MD_EDITO_BODYTEXT, 'name'=>'body_text', 'value'=>$body_text, 'width'=>'100%', 'height'=>'468px'),false));
	} elseif ( $xoopsModuleConfig['wysiwyg'] == 'inbetween' AND is_file(XOOPS_ROOT_PATH . '/class/xoopseditor/inbetween/forminbetweentextarea.php') AND $status != 5 ) {
		include_once XOOPS_ROOT_PATH . "/class/xoopseditor/inbetween/forminbetweentextarea.php";
		$sform->addElement(new XoopsFormInbetweenTextArea(array('caption'=> 'Inbetween Editor<p />'._MD_EDITO_BODYTEXT, 'name'=>'body_text', 'value'=>$body_text, 'width'=>'100%', 'height'=>'468px'),false));
	} elseif ( $xoopsModuleConfig['wysiwyg'] == 'fck' AND is_file(XOOPS_ROOT_PATH . '/class/fckeditor/formfckeditor.php') AND $status != 5 ) {
		include_once XOOPS_ROOT_PATH . "/class/fckeditor/formfckeditor.php";
		$sform->addElement(new XoopsFormFckeditor(array('caption'=> 'FCK Editor<p />'._MD_EDITO_FCK, 'name'=>'body_text', 'value'=>$body_text),false));
	} elseif ( $xoopsModuleConfig['wysiwyg'] == 'spaw' AND is_file(XOOPS_ROOT_PATH . '/class/spaw/formspaw.php') AND $status != 5 ) {
		include_once XOOPS_ROOT_PATH . "/class/spaw/formspaw.php";
		$sform->addElement(new XoopsFormSpaw(array('caption'=> 'Spaw Editor<p />'._MD_EDITO_SPAW, 'name'=>'body_text', 'value'=>$body_text),false));
	} elseif ( $xoopsModuleConfig['wysiwyg'] == 'textarea' AND is_file(XOOPS_ROOT_PATH . '/class/xoopseditor/inbetween/forminbetweentextarea.php') AND $status != 5 ) {
		$sform->addElement(new XoopsFormTextArea(array('caption'=> 'Inbetween Editor<p />'._MD_EDITO_BODYTEXT, 'name'=>'body_text', 'value'=>$body_text),false));
	} else {
		$sform -> addElement( new XoopsFormDhtmlTextArea( 'DHTML Editor<p />'._MD_EDITO_BODYTEXT, 'body_text', $body_text, 15, 60 ) );
	}

//	$wysiwyg2 = edito_getWysiwygForm( $xoopsModuleConfig['wysiwyg'], _MD_EDITO_BODYTEXT, 'body_text', $body_text, '100%', '468px', '');
//	$sform -> addElement($wysiwyg2,false);

	$sform -> addElement($image_in);
	// IMAGE
	// The edito CAN have its own image :)
	// First, if the edito's image doesn't exist, set its value to the blank file
	if (!file_exists(XOOPS_ROOT_PATH . "/" . $xoopsModuleConfig['sbuploaddir'] . "/" . $image) || !$image) {
		$image = 'blank.gif';
	}

    // Code to create the image selector
	$graph_array = & XoopsLists :: getImgListAsArray( XOOPS_ROOT_PATH . "/" . $xoopsModuleConfig['sbuploaddir'] );
	$image_select = new XoopsFormSelect( '', 'image', $image );
	$image_select -> addOption( 'blank.gif' );
	$image_select -> addOptionArray( $graph_array );
	$image_select -> setExtra( "onchange='showImgSelected(\"image5\", \"image\", \"" . $xoopsModuleConfig['sbuploaddir'] . "\", \"\", \"" . XOOPS_URL . "\")'" );
	$image_tray = new XoopsFormElementTray( _MD_EDITO_SELECT_IMG, '&nbsp;' );
	$image_tray -> addElement( $image_select );
 	$image_tray -> addElement( new XoopsFormLabel( "", "<br /><br /><img src='".XOOPS_URL . "/". $xoopsModuleConfig['sbuploaddir'] ."/" . $image . "' name='image5' id='image5' alt='" . $image . "' />" ) );
	$sform -> addElement( $image_tray );

	// Code to call the file browser to select an image to upload
	$sform -> addElement( new XoopsFormFile( _MD_EDITO_UPLOADIMAGE, 'cimage', '' ), false );
	$sform -> addElement($image_out);

	// MEDIA FILE
	// The myMedia CAN have its own media
	// First, if the myMedia's media doesn't exist, set its value to the blank file
   // Expand function
	$sform -> addElement($media_in);
	if ( !file_exists(XOOPS_ROOT_PATH ."/" . $xoopsModuleConfig['sbmediadir'] . "/" . $media_file) OR !$media_file ) {
		$media_file = '';
	}

    // Code to create the media selector
	$media_array = & XoopsLists :: getFileListAsArray( XOOPS_ROOT_PATH . "/" . $xoopsModuleConfig['sbmediadir'] );
 	$media_select = new XoopsFormSelect( '', 'media_file', $media_file );
	$media_select -> addOption( '' );
	$media_select -> addOptionArray( $media_array );
//	$media_select -> setExtra( "onchange='showImgSelected(\"media5\", \"media_file\", \"" . $xoopsModuleConfig['sbmediadir'] . "\", \"\", \"" . XOOPS_URL . "\")'" );
	$media_tray = new XoopsFormElementTray( _MD_EDITO_SELECT_MEDIA, '&nbsp;' );
	$media_tray -> addElement( $media_select );
//	$media_tray -> addElement( new XoopsFormLabel( "", "<br /><br /><img src='".XOOPS_URL . "/". $xoopsModuleConfig['sbmediadir'] ."/" . $display_media . "' name='media5' id='media5' alt='" . $media_file . "' />" ) );
	$sform -> addElement( $media_tray );

	// Code to call the file browser to select a media to upload
	$sform -> addElement( new XoopsFormFile( _MD_EDITO_UPLOADMEDIA, 'cmedia', '' ), false );

	// MEDIA URL
	// Code for direct media url
	$sform -> addElement( new XoopsFormText( _MD_EDITO_MEDIAURL, 'media_url', 80, 255, $media_url), false );

	// MEDIA SIZE
	// Code to create the media size selector
	$media_s_array = array( 'default'			=>_MD_EDITO_SELECT_DEFAULT,
    						'custom'			=>_MD_EDITO_SELECT_CUSTOM,
                            'tv_small'			=>_MD_EDITO_SELECT_TVSMALL,
                            'tv_medium'			=> _MD_EDITO_SELECT_TVMEDIUM,
                            'tv_large' 			=> _MD_EDITO_SELECT_TVBIG,
                            'mv_small' 			=>_MD_EDITO_SELECT_MVSMALL,
                            'mv_medium'			=> _MD_EDITO_SELECT_MVMEDIUM,
                            'mv_large'			=> _MD_EDITO_SELECT_MVBIG  );

	$media_s_select = new XoopsFormSelect( '', 'media_size', $media_size );
	$media_s_select -> addOptionArray( $media_s_array );
	$media_s_tray = new XoopsFormElementTray( _MD_EDITO_MEDIA_SIZE, '&nbsp;' );
	$media_s_tray -> addElement( $media_s_select );
	$sform -> addElement( $media_s_tray );

	// Expand function
	$sform -> addElement($media_out);

	// Meta Options
	// if ( $xoopsModuleConfig['metamanager'] != 'manual' ){
	$sform -> addElement($meta_in);

	// Meta Title
	$sform -> addElement( new XoopsFormText( _MD_EDITO_METATITLE, 'meta_title', 70, 512, $meta_title), false );

	// Meta Description
	$sform -> addElement( new XoopsFormTextArea( _MD_EDITO_METADESCRIPTION, 'meta_description', $meta_description, 5, 512) );

	// Meta Keywords
	$sform -> addElement( new XoopsFormTextArea( _MD_EDITO_METAKEYWORDS, 'meta_keywords', $meta_keywords, 5, 512) );


    // Meta Keywords
	if($xoopsModuleConfig['metamanager'] == 'auto' ) {
	$meta_gen_display = '<tr  valign="top" align="left">
    					 <td class="head">'._MD_EDITO_METAGEN.'</td>
                         <td class="even">'. $meta_gen .' </td>
                         </tr>';

    $sform -> addElement( $meta_gen_display );
	 }

    $sform -> addElement($meta_out);

	// Misc Options
	$sform -> addElement($misc_in);

    // GROUPS
	$sform -> addElement(new XoopsFormSelectGroup(_MD_EDITO_GROUPS, "groups", true, $groups, 5, true));


	//COUNTER
	$sform -> addElement( new XoopsFormText( _MD_EDITO_COUNTER, 'counter', 5, 11, $counter ), false );

	// LOGO
	// Code to display or hidde image
/*
    $logo_radio = new XoopsFormRadioYN(_MD_EDITO_LOGO, 'logo', $logo, ' '._MD_EDITO_YES.'', ' '._MD_EDITO_NO.'');
	$sform -> addElement($logo_radio);
*/

	// VARIOUS OPTIONS
	$options_tray = new XoopsFormElementTray(_MD_EDITO_OPTIONS,'</input><br />');

	$title_checkbox = new XoopsFormCheckBox( '', 'title', $title );
	$title_checkbox -> addOption( 1, _MD_EDITO_TITLE );
	$options_tray -> addElement( $title_checkbox );

	$logo_checkbox = new XoopsFormCheckBox( '', 'logo', $logo );
	$logo_checkbox -> addOption( 1, _MD_EDITO_LOGO );
	$options_tray -> addElement( $logo_checkbox );

	$comment_checkbox = new XoopsFormCheckBox( '', 'cancomment', $cancomment );
	$comment_checkbox -> addOption( 1, _MD_EDITO_ALLOWCOMMENTS.'<hr/>' );
	$options_tray -> addElement( $comment_checkbox );

	$html_checkbox = new XoopsFormCheckBox( '', 'html', $html );
	$html_checkbox -> addOption( 1, _MD_EDITO_HTML );
	$options_tray -> addElement( $html_checkbox );

	$smiley_checkbox = new XoopsFormCheckBox( '', 'smiley', $smiley );
	$smiley_checkbox -> addOption( 1, _MD_EDITO_SMILEY );
	$options_tray -> addElement( $smiley_checkbox );

	$xcodes_checkbox = new XoopsFormCheckBox( '', 'xcode', $xcode );
	$xcodes_checkbox -> addOption( 1, _MD_EDITO_XCODE );
	$options_tray -> addElement( $xcodes_checkbox );

	$sform -> addElement( $options_tray );

	$sform -> addElement($misc_out);
	if ( $op == 'dup' ) { $id = ''; }

    $sform -> addElement( new XoopsFormHidden( 'id', $id ) );

	$button_tray = new XoopsFormElementTray( '', '' );
	$hidden = new XoopsFormHidden( 'op', 'addart' );
	$button_tray -> addElement( $hidden );

	if ( !$id OR $op == 'dup' )  { // there's no id? Then it's a new edito
		$butt_create = new XoopsFormButton( '', '', _MD_EDITO_SUBMIT, 'submit' );
		$butt_create->setExtra('onclick="this.form.elements.op.value=\'addart\'"');
		$button_tray->addElement( $butt_create );

		$butt_clear = new XoopsFormButton( '', '', _MD_EDITO_CLEAR, 'reset' );
		$button_tray->addElement( $butt_clear );

		$butt_cancel = new XoopsFormButton( '', '', _MD_EDITO_CANCEL, 'button' );
		$butt_cancel->setExtra('onclick="history.go(-1)"');
		$button_tray->addElement( $butt_cancel );

	} else { // we're editing an existing article
		$butt_create = new XoopsFormButton( '', '', _MD_EDITO_MODIFY, 'submit' );
		$butt_create->setExtra('onclick="this.form.elements.op.value=\'addart\'"');
		$button_tray->addElement( $butt_create );
		$butt_cancel = new XoopsFormButton( '', '', _MD_EDITO_CANCEL, 'button' );
		$butt_cancel->setExtra('onclick="history.go(-1)"');
		$button_tray->addElement( $butt_cancel );
	}

    $sform -> addElement( $button_tray );
	$sform -> display();
	unset( $hidden );
}

/* -- Available operations -- */
switch ( $op ) {
	case "mod":
		include_once( "admin_header.php" );
        edito_adminmenu(2, _MD_EDITO_EDIT);
        editarticle($id);
        include_once( 'admin_footer.php' );
    break;

    case "dup":
    	include_once( "admin_header.php" );
        edito_adminmenu(1, _MD_EDITO_DUPLICATE);
        editarticle($id, 'dup');
        include_once( 'admin_footer.php' );
    break;

    case "addart":
    //	include_once( "admin_header.php" );
        $myts =& MyTextSanitizer::getInstance();
        include_once('../include/functions_metagen.php');
        include_once('../include/functions_edito.php'  );
        $id              = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $date            = time();
        $counter         = isset( $counter ) ? intval( $counter ) : 0;
        $status          = isset($_POST['status']) ? intval($_POST['status']) : 0;

        $subject         = $myts -> AddSlashes($_POST['subject']);

/*
		$block_text      = $myts -> htmlSpecialChars($_POST['block_text']);
		$body_text       = $myts -> htmlSpecialChars($_POST['body_text']);
*/
		$block_text      = $myts -> AddSlashes($_POST['block_text']);
		$body_text       = $myts -> AddSlashes($_POST['body_text']);
		$image           = (isset($_POST['image'])) ? intval($_POST['image']) : '';


        /* ----------------------------------------------------------------------- */
	/*                             Create Meta tags                            */
        /* createMetaTags(   Page title,                                           */
        /*                   Page Texte,                                           */
        /*                   Module Meta Keywords,                                 */
        /*                   Page Meta Keywords,                                   */
        /*                   Meta Description,                                     */
        /*                   Status,                                               */
        /*                   Min caracters,                                        */
        /*                   Min Occurence,                                        */
        /*                   Max Occurence )                                       */
        /*                                                                         */
        /* ----------------------------------------------------------------------- */
		// Display mode
        // Manual = Only page datas are kept in accunt
        // Mix = if page data is empty use page module/site data
        // Auto = use metagen only data

// Manual
        if($xoopsModuleConfig['metamanager'] == 'manual' ) {
                $metagen['title']         = $myts -> htmlSpecialChars($_POST['meta_title']);
                $meta_description         = $myts -> htmlSpecialChars($_POST['meta_description']);
                $metagen['keywords']      = $myts -> htmlSpecialChars($_POST['meta_keywords']);
        }

// Semi-auto
        if($xoopsModuleConfig['metamanager'] == 'semi' ) {

               $metagen = edito_createMetaTags( '',
                                                $_POST['meta_title'],
                                                $_POST['meta_description'],
                                                $xoopsModuleConfig['moduleMetaDescription'],
                                                '',
                                                $_POST['meta_keywords'],
                                                $xoopsModuleConfig['moduleMetaKeywords'],
                                                5, 1, 9);
              if ( $_POST['meta_keywords'] ) { $meta_keywords = $myts -> htmlSpecialChars($_POST['meta_keywords']);
                   } elseif ( $xoopsModuleConfig['moduleMetaKeywords'] ) {
                                               $meta_keywords = $xoopsModuleConfig['moduleMetaKeywords'];
                   } else {                    $meta_keywords = ''; }
                   
                   $meta_description = $metagen['description'];
        }

// Auto
        if( $xoopsModuleConfig['metamanager'] == 'auto' ) {
               if( $status == 4 ) { $content_datas = ''; } else { $content_datas = strip_tags($block_text.' '.$body_text); }
               $metagen = edito_createMetaTags( $subject,
                                                $_POST['meta_title'],
                                                $_POST['meta_description'],
                                                $xoopsModuleConfig['moduleMetaDescription'],
                                                $content_datas,
                                                $_POST['meta_keywords'],
                                                $xoopsModuleConfig['moduleMetaKeywords'],
                                                5, 1, 9);

              if ( $_POST['meta_keywords'] ) { $meta_keywords = $myts -> htmlSpecialChars($_POST['meta_keywords']);
                   } elseif ( $xoopsModuleConfig['moduleMetaKeywords'] ) {
                                               $meta_keywords = $xoopsModuleConfig['moduleMetaKeywords'];
                   } else {                    $meta_keywords = ''; }
                   
              if ( $_POST['meta_description'] ) { $meta_description = $myts -> htmlSpecialChars($_POST['meta_description']);
                   } elseif ( $metagen['description'] ) {
                                                  $meta_description = $metagen['description'];
                   } elseif ( $_POST['meta_title'] && $xoopsModuleConfig['moduleMetaDescription'] ) {
                                               $meta_description = $_POST['meta_title']. ' : ' . $xoopsModuleConfig['moduleMetaDescription'];
                   } elseif ( $xoopsModuleConfig['moduleMetaDescription'] ) {
                                               $meta_description = $subject . ' : ' . $xoopsModuleConfig['moduleMetaDescription'];
                   } else {                    $meta_keywords = ''; }

        }
        if(!isset($metagen['keywords'])) { $metagen['keywords'] = ''; }
        $meta = $metagen['title'] . '|' . $meta_description . '|' . $meta_keywords . '|' . $metagen['keywords'];

        $groups          = $_POST['groups'];
        $groups          = (is_array($groups)) ? implode(" ", $groups) : '';

        $html            = isset( $html ) ? intval( $html ) : 0;
        $xcode           = isset( $xcode ) ? intval( $xcode ) : 0;
        $smiley          = isset( $smiley ) ? intval( $smiley ) : 0;
        $logo            = isset( $logo ) ? intval( $logo ) : 0;
        $block           = isset( $block ) ? intval( $block ) : 0;
        $title           = isset( $title ) ? intval( $title ) : 0;
        $cancomment      = isset( $cancomment ) ? intval( $cancomment ) : 0;
/*
        $cancomment      = isset( $_POST['cancomment'] ) ? intval( $_POST['cancomment'] ) : $xoopsModuleConfig['cancomment'];
*/
		$options = $html . '|' . $xcode . '|' . $smiley . '|' . $logo . '|' . $block . '|' . $title . '|' . $cancomment;

		// Define variables
		$error = 0;
		$word = null;
		$uid = $xoopsUser->uid();
		$submit = 1;
		$datesub = time();

        /* --------------------------------------------------------------------	*/
		/* 					Traitement des images et des médias					*/
        /* --------------------------------------------------------------------	*/
        $image = ($_POST["image"] AND $_POST["image"] != 'blank.gif') ? $myts -> addSlashes( $_POST["image"] ) : '';
		$media_file = ($_POST["media_file"] AND $_POST["media_file"] != 'blank.gif') ? $myts -> addSlashes( $_POST["media_file"] ) : '';

        foreach ($_FILES as $keyname => $fileup) {
        	if ( $fileup['name'] != '' && $keyname == 'cimage') {
                if ( edito_uploading_image( $keyname ) ) {
					$image = $HTTP_POST_FILES['cimage']['name'];
                }
            } elseif ( $fileup['name'] != '' && $keyname == 'cmedia') {
                if ( edito_uploading_media( $keyname ) ) {
					$media_file = $HTTP_POST_FILES['cmedia']['name'];
                }
			}
        }
        /* --------------------------------------------------------------------	*/
        /* 					Traitement des images et des médias					*/
        /* --------------------------------------------------------------------	*/


		if ( $media_file == 'none' ) {$media_file = ''; }

        $media_url       = $_POST['media_url'];
		$media_size      = $_POST['media_size'];
        $media = $media_file . '|' . $media_url . '|' . $media_size;

		// Save to database
		if ( !$id ) {
			if ( $xoopsDB -> queryF( "INSERT INTO " . $xoopsDB -> prefix( "content_" . $xoopsModule->dirname() ) .
				" ( uid,
                	datesub,
                    counter,
                    status,
                    subject,
                    block_text,
                    body_text,
                    image,
                    media,
                    meta,
                    groups,
                    options
                  ) VALUES (
                  	'$uid',
                    '$datesub',
                    '$counter',
                    '$status',
                    '$subject',
                    '$block_text',
                    '$body_text',
                    '$image',
                    '$media',
                    '$meta',
                    '$groups',
                    '$options' )" ) ) {

                                redirect_header( "index.php", 3, _MD_EDITO_CREATED );
			} else {
				redirect_header( "index.php", 3, _MD_EDITO_NOTCREATED );
			}
		} else {  // That is, $id exists, thus we're editing an article


			// Vérifier la validité de l'insert
/*
			$sql = $xoopsDB->queryF( "SELECT COUNT(*)
            	   FROM ".$xoopsDB -> prefix( $module)."
                   WHERE id = ".$pid." AND pid = ".$id."" );
                   list( $numrows ) = $xoopsDB -> fetchRow( $sql );
                   if ( $numrows > 0 OR $pid == $id ) {
						redirect_header( 'index.html', 3, _MD_EDITO_CANTPARENT);
                   }
*/

			if ( $xoopsDB -> queryF( "UPDATE " . $xoopsDB -> prefix( "content_" . $xoopsModule->dirname() ) . "
            					SET uid    =     '$uid',
                                datesub    =     '$datesub',
                                counter    =     '$counter',
                                status     =     '$status',
                                subject    =     '$subject',
                                block_text =     '$block_text',
                                body_text =      '$body_text',
                                image      =     '$image',
                                media      =     '$media',
                                meta       =     '$meta',
                                groups     =     '$groups',
                                options    =     '$options'
                                WHERE id = '$id'" ) ) {
				if( !$status ) {
					redirect_header( "index.php", 1, _MD_EDITO_MODIFIED );
				} else {
					redirect_header( "../content.php?id=".$id, 1, _MD_EDITO_MODIFIED );
				};
			} else {
				redirect_header( "index.php", 1, _MD_EDITO_NOTUPDATED);
			}
		}
		exit();
	break;

	case "del":

        $confirm = ( isset($confirm)) ? 1 : 0;
        if ($confirm) {
           $xoopsDB->queryF( "DELETE FROM " . $xoopsDB->prefix("content_" . $xoopsModule->dirname() ) . " WHERE id = $id" );
           xoops_comment_delete($xoopsModule->getVar('mid'), $id);
           redirect_header( "index.php", 1, sprintf( _MD_EDITO_DELETED, $subject) );
           exit();
		} else {
           include_once( "admin_header.php" );
        	$id = ( isset( $_POST['id'] ) ) ? intval($_POST['id']) : intval($id);
            $result = $xoopsDB -> queryF( "SELECT id, subject FROM " . $xoopsDB -> prefix("content_" . $xoopsModule->dirname() ) . " WHERE id = $id" );
            list( $id, $subject ) = $xoopsDB -> fetchrow( $result );
            xoops_confirm( array( 'op' => 'del', 'id' => $id, 'confirm' => 1, 'subject' => $subject ), 'content.php', _MD_EDITO_DELETETHIS . "<br /><br>" . $myts->displayTarea($subject), _MD_EDITO_DELETE );
           include_once( 'admin_footer.php' );
        }

        exit();
    break;

	case "default":
	default:
	include_once( "admin_header.php" );
        edito_adminmenu(1, _MD_EDITO_CREATE);
        editarticle();
        include_once( 'admin_footer.php' );
	break;
}

?>