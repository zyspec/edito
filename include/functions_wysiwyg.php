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

function edito_getWysiwygForm($type = 'dhtml', $caption, $name, $value = '', $width = '100%', $height = '400px', $supplemental='') {
//	global $xoopsModuleConfig;
	$wysiwyg = false;
	$x22 = false;
	$xv = str_replace('XOOPS ','',XOOPS_VERSION);
	if(substr($xv,2,1)=='2') {
		$x22=true;
	}
	$wysiwyg_configs=array();
	$wysiwyg_configs["name"] =$name;
	$wysiwyg_configs["value"] = $value;
	$wysiwyg_configs["rows"] = 35;
	$wysiwyg_configs["cols"] = 60;
	$wysiwyg_configs["width"] = '100%';
	$wysiwyg_configs["height"] = '400px';


	switch(strtolower($type)){
	case "spaw":
		if(!$x22) {
			if (is_readable(XOOPS_ROOT_PATH . "/class/spaw/formspaw.php"))	{
				include_once(XOOPS_ROOT_PATH . "/class/spaw/formspaw.php");
				$wysiwyg = new XoopsFormSpaw($caption, $name, $value);
			}
		} else {
			$wysiwyg = new XoopsFormEditor($caption, "spaw", $wysiwyg_configs);
		}
		break;

	case "fck":
		if(!$x22) {
			if ( is_readable(XOOPS_ROOT_PATH . "/class/fckeditor/formfckeditor.php"))	{
				include_once(XOOPS_ROOT_PATH . "/class/fckeditor/formfckeditor.php");
				$wysiwyg = new XoopsFormFckeditor($caption, $name, $value);
			}
		} else {
			$wysiwyg = new XoopsFormEditor($caption, "fckeditor", $wysiwyg_configs);
		}
		break;

	case "htmlarea":
		if(!$x22) {
			if ( is_readable(XOOPS_ROOT_PATH . "/class/htmlarea/formhtmlarea.php"))	{
				include_once(XOOPS_ROOT_PATH . "/class/htmlarea/formhtmlarea.php");
				$wysiwyg = new XoopsFormHtmlarea($caption, $name, $value);
			}
		} else {
			$wysiwyg = new XoopsFormEditor($caption, "htmlarea", $wysiwyg_configs);
		}
		break;

	case "dhtml":
		if(!$x22) {
			$wysiwyg = new XoopsFormDhtmlTextArea($caption, $name, $value, 10, 50, $supplemental);
		} else {
			$wysiwyg = new XoopsFormEditor($caption, "dhtmltextarea", $wysiwyg_configs);
		}
		break;

	case "textarea":
		$wysiwyg = new XoopsFormTextArea($caption, $name, $value);
		break;

	case "koivi":
		if(!$x22) {
			if ( is_readable(XOOPS_ROOT_PATH . "/class/xoopseditor/wysiwyg/formwysiwygtextarea.php"))	{
				include_once(XOOPS_ROOT_PATH . "/class/xoopseditor/wysiwyg/formwysiwygtextarea.php");
				$wysiwyg = new XoopsFormWysiwygTextArea($caption, $name, $value, '100%', '400px', '');
			}
		} else {
			$wysiwyg = new XoopsFormEditor($caption, "koivi", $wysiwyg_configs);
		}
		break;

	case "tinyeditor":
    	if(!$x22) {
        	if ( is_readable(XOOPS_ROOT_PATH . "/class/xoopseditor/tinyeditor/formtinyeditortextarea.php")) {
            	include_once(XOOPS_ROOT_PATH . "/class/xoopseditor/tinyeditor/formtinyeditortextarea.php");
                $wysiwyg = new XoopsFormTinyeditorTextArea(array($caption, $name, $value, $width, $height));
            }
        } else {
        	$wysiwyg = new XoopsFormEditor($caption, "tinyeditor", $wysiwyg_configs);
		}
		break;
	}
	return $wysiwyg;
}
?>