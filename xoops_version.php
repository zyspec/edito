<?php
/**
* XOOPS - PHP Content Management System
* Copyright (c) 2004 <http://www.xoops.org/>
*
* Module: edito 3.0 RC 1.1
* Licence : GPL
* Authors :
*           - solo (http://www.wolfpackclan.com/wolfactory)
*			- DuGris (http://www.dugris.info)
*/


global $xoopsDB, $xoopsUser, $xoopsModule, $xoopsModuleConfig;
include_once (XOOPS_ROOT_PATH . "/modules/edito/include/functions_block.php");

//InfoModule
$modversion['name'] = _MI_EDITO_NAME;
$modversion['version'] = 3.07;
$modversion['description'] = _MI_EDITO_DESC;
$modversion['credits'] = "<a href='http://www.wolfpackclan.com/wolfactory' target='_blank'>Wolfactory</a>, <a href='http://www.dugris.info' target='_blank'>dugris</a>";
$modversion['author'] = "Solo, DuGris";
$modversion['license'] = "GPL";
$modversion['dirname'] = "edito";
$modversion['image'] = "images/edito_slogo.png";

//install
$modversion['onInstall'] = 'include/edito_install.php';
//update
$modversion['onUpdate'] = 'include/edito_update.php';
//uninstall
$modversion['onUninstall'] = 'include/edito_uninstall.php';

//SQL
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";
$modversion['tables'][0] = "content_".$modversion['dirname'];

//Admin
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

// Search
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = "include/search.inc.php";
$modversion['search']['func'] = "edito_search";

//Menu
$modversion['hasMain'] = 1;
if ( $xoopsModule && $xoopsModule -> getVar( 'dirname' ) == $modversion['dirname'] ) {
include_once (XOOPS_ROOT_PATH . "/modules/edito/include/functions_content.php");
$group = is_object($xoopsUser) ? $xoopsUser->getGroups() : array(XOOPS_GROUP_ANONYMOUS);
$i = 0 ;
// Menu admin links
if( @defined('_EDITO_ADD') ) {
        if (count(array_intersect($group,$xoopsModuleConfig['submit_groups'])) > 0) {
 		$modversion['sub'][$i]['name'] = '<img src="images/icon/submit.gif" align="absmiddle" width="20" alt="'._EDITO_SUBMIT.'" />&nbsp;<i>'._EDITO_SUBMIT.'</i></img>';
		$modversion['sub'][$i++]['url'] = "submit.php";
        }

	if ( is_object($xoopsUser) && $xoopsUser->isAdmin($xoopsModule->mid()) ) {
 		$modversion['sub'][$i]['name'] = '<img src="images/icon/add.gif" align="absmiddle" width="20" alt="'._EDITO_ADD.'" />&nbsp;<i>'._EDITO_ADD.'</i></img>';
		$modversion['sub'][$i++]['url'] = "admin/content.php";
		$modversion['sub'][$i]['name'] = '<img src="images/icon/list.gif" align="absmiddle" width="20" alt="'._EDITO_LIST.'" />&nbsp;<i>'._EDITO_LIST.'</i></img>';
		$modversion['sub'][$i++]['url'] = 'admin/index.php';
		$modversion['sub'][$i]['name'] = '<img src="images/icon/utilities.gif" align="absmiddle" width="20" alt="'._EDITO_UTILITIES.'" />&nbsp;<i>'._EDITO_UTILITIES.'</i></img>';
		$modversion['sub'][$i++]['url'] = 'admin/utils_uploader.php';
	        $modversion['sub'][$i]['name'] = '<img src="images/icon/settings.gif" align="absmiddle" width="20" alt="'._EDITO_SETTINGS.'" />&nbsp;<i>'._EDITO_SETTINGS.'</i></img>';
		$modversion['sub'][$i++]['url'] = '../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=' . $xoopsModule->getVar('mid');
		$modversion['sub'][$i]['name'] = '<img src="images/icon/blocks.gif" align="absmiddle" width="20" alt="'._EDITO_BLOCKS.'" />&nbsp;<i>'._EDITO_BLOCKS.'</i></img>';
		$modversion['sub'][$i++]['url'] = 'admin/myblocksadmin.php';
	}
}

    // Display menu pages list
	// Start comment here to not display pages'list
	$sql = "SELECT id, subject, meta, groups FROM ".$xoopsDB->prefix("content_" . $modversion['dirname'])."
          WHERE status >= 3 ORD BY " . edito_getmoduleoption('order');

	$result = $xoopsDB->queryF($sql, edito_getmoduleoption('perpage'), 0 ) ;

//	$group = is_object($xoopsUser) ? $xoopsUser->getGroups() : array(XOOPS_GROUP_ANONYMOUS);
	while( list( $id, $subject, $meta, $groups ) = $xoopsDB->fetchRow($result) ) {
		$groups = explode(" ",$groups);
		if (count(array_intersect($group,$groups))) {
                   $meta = explode("|", $meta);
                   $meta_title       =  $meta[0];
                   $meta_description =  $meta[1];

                        $link = edito_createlink('content.php?id='.$id, $subject, '', '', '', '', '', $meta_title, $xoopsModuleConfig['url_rewriting']);
                        $link = explode('"', $link); if( $link[1] ) { $link = $link[1]; } else { $link = 'content.php?id='.$id; }
			$modversion['sub'][$i]['name'] = $subject ;
			$modversion['sub'][$i++]['url'] = $link ;
		} // Groups
	} // While
	// End comment here to not display pages'list
}  // Active module



// Templates
$i = 1;
// Module blocks templates
  // Header and footer
$modversion['templates'][$i]['file'] = 'edito_head.html';
$modversion['templates'][$i++]['description'] = "";
$modversion['templates'][$i]['file'] = 'edito_foot.html';
$modversion['templates'][$i++]['description'] = "";
  // Index templates
$modversion['templates'][$i]['file'] = 'edito_index.html';
$modversion['templates'][$i++]['description'] = "";
$modversion['templates'][$i]['file'] = 'edito_index_ext.html';
$modversion['templates'][$i++]['description'] = "";
$modversion['templates'][$i]['file'] = 'edito_index_news.html';
$modversion['templates'][$i++]['description'] = "";
$modversion['templates'][$i]['file'] = 'edito_index_blog.html';
$modversion['templates'][$i++]['description'] = "";
// Pages templates
$modversion['templates'][$i]['file'] = 'edito_content_index.html';
$modversion['templates'][$i++]['description'] = "";
$modversion['templates'][$i]['file'] = 'edito_content_item.html';
$modversion['templates'][$i++]['description'] = "";
$modversion['templates'][$i]['file'] = 'edito_content_html.html';
$modversion['templates'][$i++]['description'] = "";
$modversion['templates'][$i]['file'] = 'edito_content_php.html';
$modversion['templates'][$i++]['description'] = "";
  // Content blocks templates
$modversion['templates'][$i]['file'] = 'edito_block_content.html';
$modversion['templates'][$i++]['description'] = "";
  // Menu blocks templates
$modversion['templates'][$i]['file'] = 'edito_block_menu.html';
$modversion['templates'][$i++]['description'] = "";
$modversion['templates'][$i]['file'] = 'edito_block_image.html';
$modversion['templates'][$i++]['description'] = "";
$modversion['templates'][$i]['file'] = 'edito_block_list.html';
$modversion['templates'][$i++]['description'] = "";
$modversion['templates'][$i]['file'] = 'edito_block_ext.html';
$modversion['templates'][$i++]['description'] = "";
  // Submit templates
$modversion['templates'][$i]['file'] = 'edito_content_submit.html';
$modversion['templates'][$i++]['description'] = "";


// Blocks
$i = 1;
$modversion['blocks'][$i]['file'] = "content.php";
$modversion['blocks'][$i]['name'] = _MI_EDITO_BLOCNAME_01;
$modversion['blocks'][$i]['description'] ="";
$modversion['blocks'][$i]['show_func'] = 'a_edito_show';
$modversion['blocks'][$i]['edit_func'] = 'a_edito_edit';
$modversion['blocks'][$i]['options'] = '512|1|1|0|';
$modversion['blocks'][$i]['template'] = 'edito_block_01.html';
$i++;
$modversion['blocks'][$i]['file'] = "content.php";
$modversion['blocks'][$i]['name'] = _MI_EDITO_BLOCNAME_02;
$modversion['blocks'][$i]['description'] = "";
$modversion['blocks'][$i]['show_func'] = 'a_edito_show';
$modversion['blocks'][$i]['edit_func'] = 'a_edito_edit';
$modversion['blocks'][$i]['options'] = '512|random|1|0|';
$modversion['blocks'][$i]['template'] = 'edito_block_02.html';
$i++;
$modversion['blocks'][$i]['file'] = "content.php";
$modversion['blocks'][$i]['name'] = _MI_EDITO_BLOCNAME_03;
$modversion['blocks'][$i]['description'] = "";
$modversion['blocks'][$i]['show_func'] = 'a_edito_show';
$modversion['blocks'][$i]['edit_func'] = 'a_edito_edit';
$modversion['blocks'][$i]['options'] = '512|latest|1|0|10';
$modversion['blocks'][$i]['template'] = 'edito_block_03.html';
$i++;
$modversion['blocks'][$i]['file'] = "content.php";
$modversion['blocks'][$i]['name'] = _MI_EDITO_BLOCNAME_04;
$modversion['blocks'][$i]['description'] = "";
$modversion['blocks'][$i]['show_func'] = 'a_edito_show';
$modversion['blocks'][$i]['edit_func'] = 'a_edito_edit';
$modversion['blocks'][$i]['options'] = '512|read|1|0|';
$modversion['blocks'][$i]['template'] = 'edito_block_04.html';
$i++;
$modversion['blocks'][$i]['file'] = "content.php";
$modversion['blocks'][$i]['name'] = _MI_EDITO_BLOCNAME_05;
$modversion['blocks'][$i]['description'] = "";
$modversion['blocks'][$i]['show_func'] = 'a_edito_menu_show';
$modversion['blocks'][$i]['edit_func'] = 'a_edito_menu_edit';
$modversion['blocks'][$i]['options'] = 'menu|120-120|1|subject ASC|6';
$modversion['blocks'][$i]['template'] = 'edito_menu_block_01.html';
$i++;
$modversion['blocks'][$i]['file'] = "content.php";
$modversion['blocks'][$i]['name'] = _MI_EDITO_BLOCNAME_06;
$modversion['blocks'][$i]['description'] = "";
$modversion['blocks'][$i]['show_func'] = 'a_edito_menu_show';
$modversion['blocks'][$i]['edit_func'] = 'a_edito_menu_edit';
$modversion['blocks'][$i]['options'] = 'menu|120-120|1|subject ASC|6';
$modversion['blocks'][$i]['template'] = 'edito_menu_block_02.html';

// Search
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = "include/search.inc.php";
$modversion['search']['func'] = "edito_search";

// Module options
$i = 1;
$modversion['config'][$i]['name'] = 'index_logo';
$modversion['config'][$i]['title'] = '_MI_EDITO_INDEX_LOGO';
$modversion['config'][$i]['description'] = '_MI_EDITO_INDEX_LOGODSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'modules/edito/images/logo.gif';
$i++;
$modversion['config'][$i]['name'] = 'textindex';
$modversion['config'][$i]['title'] = '_MI_EDITO_TEXTINDEX';
$modversion['config'][$i]['description'] = '_MI_EDITO_TEXTINDEXDSC';
$modversion['config'][$i]['formtype'] = 'textarea';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = _MI_EDITO_WELCOME;
$i++;
$modversion['config'][$i]['name'] = 'informations';
$modversion['config'][$i]['title'] = '_MI_EDITO_DEFAULTEXT';
$modversion['config'][$i]['description'] = '_MI_EDITO_DEFAULTEXTDSC';
$modversion['config'][$i]['formtype'] = 'textarea';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = _MI_EDITO_DEFAULTEXTEXP;
$i++;
$modversion['config'][$i]['name'] = 'footer';
$modversion['config'][$i]['title'] = '_MI_EDITO_FOOTERTEXT';
$modversion['config'][$i]['description'] = '_MI_EDITO_FOOTERTEXTDSC';
$modversion['config'][$i]['formtype'] = 'textarea';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = _MI_EDITO_FOOTER;
$i++;
$modversion['config'][$i]['name'] = 'index_display';
$modversion['config'][$i]['title'] = '_MI_EDITO_INDEX_DISP';
$modversion['config'][$i]['description'] = '_MI_EDITO_INDEX_DISPDSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'image';
$modversion['config'][$i]['options'] = array( '_MI_EDITO_INDEX_DISP_IMAGE' => 'image',
                                              '_MI_EDITO_INDEX_DISP_TABLE' => 'table',
                                              '_MI_EDITO_INDEX_DISP_BLOG'  => 'blog',
                                              '_MI_EDITO_INDEX_DISP_NEWS'  =>  'news' );
$i++;
$modversion['config'][$i]['name'] = 'columns';
$modversion['config'][$i]['title'] = '_MI_EDITO_COLUMNS';
$modversion['config'][$i]['description'] = '_MI_EDITO_COLUMNSDSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 2;
$modversion['config'][$i]['options'] = array( '1' => 1, 
                                              '2' => 2, 
                                              '3' => 3, 
                                              '4' => 4,
                                              '5' => 5  );
$i++;
$modversion['config'][$i]['name'] = 'order';
$modversion['config'][$i]['title'] = '_MI_EDITO_ORD';
$modversion['config'][$i]['description'] = '_MI_EDITO_ORDDSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'subject ASC';
$modversion['config'][$i]['options'] = array( '_MI_EDITO_ORD_SUBJ_ASC' => 'subject ASC',
                                              '_MI_EDITO_ORD_DATE_DESC'   => 'datesub DESC',
                                              '_MI_EDITO_ORD_READ_DESC'   => 'counter DESC' );
$i++;
$modversion['config'][$i]['name'] = 'perpage';
$modversion['config'][$i]['title'] = '_MI_EDITO_PERPAGE';
$modversion['config'][$i]['description'] = '_MI_EDITO_PERPAGEDSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 10;
$modversion['config'][$i]['options'] = array( '6'  => 6,
                                              '10' => 10,
                                              '16' => 16,
                                              '20' => 20,
                                              '26' => 26,
                                              '30' => 30,
                                              '50' => 50 );
$i++;
$modversion['config'][$i]['name'] = 'logo_size';
$modversion['config'][$i]['title'] = '_MI_EDITO_LOGOWIDTH';
$modversion['config'][$i]['description'] = '_MI_EDITO_LOGOWIDTHDSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '160|160';
$i++;
$modversion['config'][$i]['name'] = 'logo_align';
$modversion['config'][$i]['title'] = '_MI_EDITO_LOGO_ALIGN';
$modversion['config'][$i]['description'] = '_MI_EDITO_LOGO_ALIGNDSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'center';
$modversion['config'][$i]['options'] = array( '_MI_EDITO_LOGO_ALIGN_LEFT' => 'left',
                                              '_MI_EDITO_LOGO_ALIGN_CENTER' => 'center',
                                              '_MI_EDITO_LOGO_ALIGN_RIGHT' => 'right' );
$i++;
$modversion['config'][$i]['name'] = 'adminhits';
$modversion['config'][$i]['title'] = '_MI_EDITO_ADMINHITS';
$modversion['config'][$i]['description'] = '_MI_EDITO_ADMINHITSDSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;
$i++;
/*
$modversion['config'][$i]['name'] = 'maxfilesize';
$modversion['config'][$i]['title'] = "_MI_EDITO_MAXFILESIZE";
$modversion['config'][$i]['description'] = "_MI_EDITO_MAXFILESIZEDSC";
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 250000;
*/
$i++;
$modversion['config'][$i]['name'] = 'maximgsize';
$modversion['config'][$i]['title'] = '_MI_EDITO_IMGSIZE';
$modversion['config'][$i]['description'] = '_MI_EDITO_IMGSIZEDSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '800|600|250000';
$i++;
$modversion['config'][$i]['name'] = 'sbuploaddir';
$modversion['config'][$i]['title'] = '_MI_EDITO_UPLOADDIR';
$modversion['config'][$i]['description'] = '_MI_EDITO_UPLOADDIRDSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'uploads/'.$modversion['dirname'].'/images';
$i++;
$modversion['config'][$i]['name'] = 'sbmediadir';
$modversion['config'][$i]['title'] = '_MI_EDITO_MEDIADIR';
$modversion['config'][$i]['description'] = '_MI_EDITO_MEDIADIRDSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'uploads/'.$modversion['dirname'].'/media';
$i++;
$modversion['config'][$i]['name'] = 'downloadable';
$modversion['config'][$i]['title'] = '_MI_EDITO_DWNL';
$modversion['config'][$i]['description'] = '_MI_EDITO_DWNLDSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;

if ( $xoopsModule && $xoopsModule -> getVar( 'dirname' ) == 'system' ) {
	$member_handler =& xoops_gethandler('member');
	$xoopsgroups = &$member_handler->getGroupList();
	foreach ($xoopsgroups as $key=>$group) {
		$groups[$group] = $key;
	}
	$def_group[1] = 1;
$i++;
$modversion['config'][$i]['name'] = 'groups';
$modversion['config'][$i]['title'] = '_MI_EDITO_OPT_GRPS';
$modversion['config'][$i]['description'] = '_MI_EDITO_OPT_GRPSDSC';
$modversion['config'][$i]['formtype'] = 'select_multi';
$modversion['config'][$i]['valuetype'] = 'array';
$modversion['config'][$i]['options'] = $groups;
$modversion['config'][$i]['default'] = $groups;
$i++;
$modversion['config'][$i]['name'] = 'submit_groups';
$modversion['config'][$i]['title'] = '_MI_EDITO_SUB_GRPS';
$modversion['config'][$i]['description'] = '_MI_EDITO_SUB_GRPSDSC';
$modversion['config'][$i]['formtype'] = 'select_multi';
$modversion['config'][$i]['valuetype'] = 'array';
$modversion['config'][$i]['options'] = $groups;
$modversion['config'][$i]['default'] = $def_group;
}
$i++;
$modversion['config'][$i]['name'] = 'option_block';
$modversion['config'][$i]['title'] = '_MI_EDITO_OPT_BLOCK';
$modversion['config'][$i]['description'] = '_MI_EDITO_OPT_BLOCKDSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$i++;
$modversion['config'][$i]['name'] = 'option_title';
$modversion['config'][$i]['title'] = '_MI_EDITO_OPT_TITLE';
$modversion['config'][$i]['description'] = '_MI_EDITO_OPT_TITLEDSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$i++;
$modversion['config'][$i]['name'] = 'option_logo';
$modversion['config'][$i]['title'] = '_MI_EDITO_OPT_LOGO';
$modversion['config'][$i]['description'] = '_MI_EDITO_OPT_LOGODSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$i++;
$modversion['config'][$i]['name'] = 'cancomment';
$modversion['config'][$i]['title'] = '_MI_EDITO_OPT_COMMENT';
$modversion['config'][$i]['description'] = '_MI_EDITO_OPT_COMMENTDSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$i++;
$modversion['config'][$i]['name'] = 'wysiwyg';
$modversion['config'][$i]['title'] = '_MI_EDITO_WYSIWYG';
$modversion['config'][$i]['description'] = '_MI_EDITO_WYSIWYGDSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'dhtml';
$modversion['config'][$i]['options'] = array( _MI_EDITO_FORM_DHTML       => 'dhtml',
                                              _MI_EDITO_FORM_COMPACT     => 'textarea',
					      _MI_EDITO_FORM_SPAW        => 'spaw',
					      _MI_EDITO_FORM_HTMLAREA    => 'htmlarea',
					      _MI_EDITO_FORM_KOIVI       => 'koivi',
					      _MI_EDITO_FORM_FCK         => 'fck',
					      _MI_EDITO_FORM_INBETWEEN   => 'inbetween',
					      _MI_EDITO_FORM_TINYEDITOR  => 'tinyeditor' );
$i++;
$modversion['config'][$i]['name'] = 'tags';
$modversion['config'][$i]['title'] = '_MI_EDITO_TAGS';
$modversion['config'][$i]['description'] = '_MI_EDITO_TAGSDSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$i++;
$modversion['config'][$i]['name'] = 'tags_new';
$modversion['config'][$i]['title'] = '_MI_EDITO_TAGS_NEW';
$modversion['config'][$i]['description'] = '_MI_EDITO_TAGS_NEWDSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 7;
$i++;
$modversion['config'][$i]['name'] = 'tags_pop';
$modversion['config'][$i]['title'] = '_MI_EDITO_TAGS_POP';
$modversion['config'][$i]['description'] = '_MI_EDITO_TAGS_POPDSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 100;
$i++;
$modversion['config'][$i]['name'] = 'metamanager';
$modversion['config'][$i]['title'] = '_MI_EDITO_META_MANAGER';
$modversion['config'][$i]['description'] = '_MI_EDITO_META_MANAGERDSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'auto';
$modversion['config'][$i]['options'] = array( '_MI_EDITO_META_MANUAL' => 'manual',
                                              '_MI_EDITO_META_SEMI' => 'semi',
                                              '_MI_EDITO_META_AUTO' => 'auto' );
$i++;
$modversion['config'][$i]['name'] = 'moduleMetaDescription';
$modversion['config'][$i]['title'] = '_MI_EDITO_META_DESC';
$modversion['config'][$i]['description'] = '_MI_EDITO_META_DESCDSC';
$modversion['config'][$i]['formtype'] = 'textarea';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';
$i++;
$modversion['config'][$i]['name'] = 'moduleMetaKeywords';
$modversion['config'][$i]['title'] = '_MI_EDITO_META_KEYW';
$modversion['config'][$i]['description'] = '_MI_EDITO_META_KEYWDSC';
$modversion['config'][$i]['formtype'] = 'textarea';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';
$i++;
$modversion['config'][$i]['name'] = 'index_content';
$modversion['config'][$i]['title'] = '_MI_EDITO_INDEX_CONTENT';
$modversion['config'][$i]['description'] = '_MI_EDITO_INDEX_CONTENTDSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';
$i++;
$modversion['config'][$i]['name'] = 'navlink_type';
$modversion['config'][$i]['title'] = '_MI_EDITO_NAV_LINKS';
$modversion['config'][$i]['description'] = '_MI_EDITO_NAV_LINKSDSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'list';
$modversion['config'][$i]['options'] = array( '_MI_EDITO_NAV_LINKS_NONE'  => 'none',
                                              '_MI_EDITO_NAV_LINKS_BLOCK' => 'bloc',
                                              '_MI_EDITO_NAV_LINKS_LIST'  => 'list',
                                              '_MI_EDITO_NAV_LINKS_PATH'  => 'path' );
$i++;
$modversion['config'][$i]['name'] = 'url_rewriting';
$modversion['config'][$i]['title'] = '_MI_EDITO_REWRITING';
$modversion['config'][$i]['description'] = '_MI_EDITO_REWRITINGDSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '0';
$modversion['config'][$i]['options'] = array( '_MI_EDITO_URW_NONE'  => '0',
                                              '_MI_EDITO_URW_MIN_3' => '3',
                                              '_MI_EDITO_URW_MIN_5' => '5',
                                              '_MI_EDITO_URW_ALL'   => '1' );
$i++;
$modversion['config'][$i]['name'] = 'media_display';
$modversion['config'][$i]['title'] = '_MI_EDITO_MEDIA_DISP';
$modversion['config'][$i]['description'] = '_MI_EDITO_MEDIA_DISPDSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'both';
$modversion['config'][$i]['options'] = array( '_MI_EDITO_MEDIA_POPUP' => 'popup',
                                              '_MI_EDITO_MEDIA_PAGE'  => 'page',
                                              '_MI_EDITO_MEDIA_BOTH'  => 'both' );
$i++;
$modversion['config'][$i]['name'] = 'custom';
$modversion['config'][$i]['title'] = '_MI_EDITO_CUSTOM';
$modversion['config'][$i]['description'] = '_MI_EDITO_CUSTOMDSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '480|360';
$i++;
$modversion['config'][$i]['name'] = 'custom_media';
$modversion['config'][$i]['title'] = '_MI_EDITO_CUSTOM_MEDIA';
$modversion['config'][$i]['description'] = '_MI_EDITO_CUSTOM_MEDIADSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '.asp|.php';
$i++;
$modversion['config'][$i]['name'] = 'repeat';
$modversion['config'][$i]['title'] = '_MI_EDITO_REPEAT';
$modversion['config'][$i]['description'] = '_MI_EDITO_REPEATDSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$i++;
$modversion['config'][$i]['name'] = 'media_size';
$modversion['config'][$i]['title'] = '_MI_EDITO_MEDIA_SIZE';
$modversion['config'][$i]['description'] = '_MI_EDITO_MEDIA_SIZEDSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'medium';
$modversion['config'][$i]['options'] = array( '_MI_EDITO_SIZE_DEFAULT' => 'default',
                                              '_MI_EDITO_SIZE_CUSTOM' => 'custom',
                                              '_MI_EDITO_SIZE_TVSMALL' => 'tv_small',
                                              '_MI_EDITO_SIZE_TVMEDIUM' => 'tv_medium',
                                              '_MI_EDITO_SIZE_TVBIG' => 'tv_big',
                                              '_MI_EDITO_SIZE_MVSMALL' => 'mv_small',
                                              '_MI_EDITO_SIZE_MVMEDIUM' => 'mv_medium',
                                              '_MI_EDITO_SIZE_MVBIG' => 'mv_big'  );


// Comments
$modversion['hasComments'] = 1;
$modversion['comments']['pageName'] = 'content.php';
$modversion['comments']['itemName'] = 'id';

// Comment callback functions
$modversion['comments']['callbackFile'] = 'include/comment_functions.php';
$modversion['comments']['callback']['approve'] = 'edito_com_approve';
$modversion['comments']['callback']['update'] = 'edito_com_update';

// Notification
$modversion['hasNotification'] = 0;

// MimeTypes
$modversion['mimetypes'][1]['mime_ext']			= 'gif';
$modversion['mimetypes'][1]['mime_types']		= 'image/gif';
$modversion['mimetypes'][1]['mime_name']		= 'Graphic Interchange Format';
$modversion['mimetypes'][1]['mime_status'] 		= 1; // 1 = visible - 0 = hidden
$modversion['mimetypes'][1]['mperm_maxwidth']	= 240;
$modversion['mimetypes'][1]['mperm_maxheight']	= 240;
$modversion['mimetypes'][1]['mperm_maxsize']	= 100000;

$modversion['mimetypes'][2]['mime_ext']			= 'jpg';
$modversion['mimetypes'][2]['mime_types']		= 'image/jpeg';
$modversion['mimetypes'][2]['mime_name']		= 'JPEG/JIFF Image';
$modversion['mimetypes'][2]['mime_status'] 		= 1; // 1 = visible - 0 = hidden
$modversion['mimetypes'][2]['mperm_maxwidth']	= 240;
$modversion['mimetypes'][2]['mperm_maxheight']	= 240;
$modversion['mimetypes'][2]['mperm_maxsize']	= 100000;

$modversion['mimetypes'][3]['mime_ext']			= 'png';
$modversion['mimetypes'][3]['mime_types']		= 'image/png';
$modversion['mimetypes'][3]['mime_name']		= 'Portable (Public) Network Graphic';
$modversion['mimetypes'][3]['mime_status'] 		= 1; // 1 = visible - 0 = hidden
$modversion['mimetypes'][3]['mperm_maxwidth']	= 240;
$modversion['mimetypes'][3]['mperm_maxheight']	= 240;
$modversion['mimetypes'][3]['mperm_maxsize']	= 100000;

$modversion['mimetypes'][4]['mime_ext']			= 'aiff';
$modversion['mimetypes'][4]['mime_types']		= 'audio/aiff';
$modversion['mimetypes'][4]['mime_name']		= 'Audio Interchange File';
$modversion['mimetypes'][4]['mime_status'] 		= 1; // 1 = visible - 0 = hidden
$modversion['mimetypes'][4]['mperm_maxwidth']	= 320;
$modversion['mimetypes'][4]['mperm_maxheight']	= 240;
$modversion['mimetypes'][4]['mperm_maxsize']	= 500000;

$modversion['mimetypes'][5]['mime_ext']			= 'mid';
$modversion['mimetypes'][5]['mime_types']		= 'audio/mid';
$modversion['mimetypes'][5]['mime_name']		= 'Musical Instrument Digital Interface MIDI-sequention Sound';
$modversion['mimetypes'][5]['mime_status'] 		= 1; // 1 = visible - 0 = hidden
$modversion['mimetypes'][5]['mperm_maxwidth']	= 320;
$modversion['mimetypes'][5]['mperm_maxheight']	= 240;
$modversion['mimetypes'][5]['mperm_maxsize']	= 500000;

$modversion['mimetypes'][6]['mime_ext']			= 'mpg';
$modversion['mimetypes'][6]['mime_types']		= 'audio/mpeg|video/mpeg';
$modversion['mimetypes'][6]['mime_name']		= 'MPEG 1 System Stream';
$modversion['mimetypes'][6]['mime_status'] 		= 1; // 1 = visible - 0 = hidden
$modversion['mimetypes'][6]['mperm_maxwidth']	= 320;
$modversion['mimetypes'][6]['mperm_maxheight']	= 240;
$modversion['mimetypes'][6]['mperm_maxsize']	= 500000;

$modversion['mimetypes'][6]['mime_ext']			= 'wav';
$modversion['mimetypes'][6]['mime_types']		= 'audio/wav';
$modversion['mimetypes'][6]['mime_name']		= 'Waveform Audio';
$modversion['mimetypes'][6]['mime_status'] 		= 1; // 1 = visible - 0 = hidden
$modversion['mimetypes'][6]['mperm_maxwidth']	= 320;
$modversion['mimetypes'][6]['mperm_maxheight']	= 240;
$modversion['mimetypes'][6]['mperm_maxsize']	= 500000;

$modversion['mimetypes'][7]['mime_ext']			= 'vma';
$modversion['mimetypes'][7]['mime_types']		= 'audio/x-ms-wma';
$modversion['mimetypes'][7]['mime_name']		= 'Windows Media Audio File';
$modversion['mimetypes'][7]['mime_status'] 		= 1; // 1 = visible - 0 = hidden
$modversion['mimetypes'][7]['mperm_maxwidth']	= 320;
$modversion['mimetypes'][7]['mperm_maxheight']	= 240;
$modversion['mimetypes'][7]['mperm_maxsize']	= 500000;

$modversion['mimetypes'][8]['mime_ext']			= 'asf';
$modversion['mimetypes'][8]['mime_types']		= 'video/x-ms-asf';
$modversion['mimetypes'][8]['mime_name']		= 'Advanced Streaming Format';
$modversion['mimetypes'][8]['mime_status'] 		= 1; // 1 = visible - 0 = hidden
$modversion['mimetypes'][8]['mperm_maxwidth']	= 320;
$modversion['mimetypes'][8]['mperm_maxheight']	= 240;
$modversion['mimetypes'][8]['mperm_maxsize']	= 500000;

$modversion['mimetypes'][9]['mime_ext']			= 'avi';
$modversion['mimetypes'][9]['mime_types']		= 'video/avi';
$modversion['mimetypes'][9]['mime_name']		= 'Audio Video Interleave File';
$modversion['mimetypes'][9]['mime_status'] 		= 1; // 1 = visible - 0 = hidden
$modversion['mimetypes'][9]['mperm_maxwidth']	= 320;
$modversion['mimetypes'][9]['mperm_maxheight']	= 240;
$modversion['mimetypes'][9]['mperm_maxsize']	= 500000;

$modversion['mimetypes'][10]['mime_ext']		= 'wmv';
$modversion['mimetypes'][10]['mime_types']		= 'video/x-ms-wmv';
$modversion['mimetypes'][10]['mime_name']		= 'Windows Media File';
$modversion['mimetypes'][10]['mime_status'] 	= 1; // 1 = visible - 0 = hidden
$modversion['mimetypes'][10]['mperm_maxwidth']	= 320;
$modversion['mimetypes'][10]['mperm_maxheight']	= 240;
$modversion['mimetypes'][10]['mperm_maxsize']	= 500000;

$modversion['mimetypes'][11]['mime_ext']		= 'vmx';
$modversion['mimetypes'][11]['mime_types']		= 'video/x-ms-wmx';
$modversion['mimetypes'][11]['mime_name']		= 'Windows Media Redirector';
$modversion['mimetypes'][11]['mime_status'] 	= 1; // 1 = visible - 0 = hidden
$modversion['mimetypes'][11]['mperm_maxwidth']	= 320;
$modversion['mimetypes'][11]['mperm_maxheight']	= 240;
$modversion['mimetypes'][11]['mperm_maxsize']	= 500000;

$modversion['mimetypes'][12]['mime_ext']		= 'qt';
$modversion['mimetypes'][12]['mime_types']		= 'video/quicktime';
$modversion['mimetypes'][12]['mime_name']		= 'QuickTime Movie';
$modversion['mimetypes'][12]['mime_status'] 	= 1; // 1 = visible - 0 = hidden
$modversion['mimetypes'][12]['mperm_maxwidth']	= 320;
$modversion['mimetypes'][12]['mperm_maxheight']	= 240;
$modversion['mimetypes'][12]['mperm_maxsize']	= 500000;

$modversion['mimetypes'][13]['mime_ext']		= 'swf';
$modversion['mimetypes'][13]['mime_types']		= 'application/x-shockwave-flash';
$modversion['mimetypes'][13]['mime_name']		= 'Macromedia Flash Format File';
$modversion['mimetypes'][13]['mime_status'] 	= 1; // 1 = visible - 0 = hidden
$modversion['mimetypes'][13]['mperm_maxwidth']	= 320;
$modversion['mimetypes'][13]['mperm_maxheight']	= 240;
$modversion['mimetypes'][13]['mperm_maxsize']	= 500000;

$modversion['mimetypes'][14]['mime_ext']		= 'ra';
$modversion['mimetypes'][14]['mime_types']		= 'audio/vnd.rn-realaudio';
$modversion['mimetypes'][14]['mime_name']		= 'RealMedia Streaming Media';
$modversion['mimetypes'][14]['mime_status'] 	= 1; // 1 = visible - 0 = hidden
$modversion['mimetypes'][14]['mperm_maxwidth']	= 320;
$modversion['mimetypes'][14]['mperm_maxheight']	= 240;
$modversion['mimetypes'][14]['mperm_maxsize']	= 500000;

$modversion['mimetypes'][15]['mime_ext']		= 'ram';
$modversion['mimetypes'][15]['mime_types']		= 'audio/x-pn-realaudio';
$modversion['mimetypes'][15]['mime_name']		= 'RealMedia Metafile';
$modversion['mimetypes'][15]['mime_status'] 	= 1; // 1 = visible - 0 = hidden
$modversion['mimetypes'][15]['mperm_maxwidth']	= 320;
$modversion['mimetypes'][15]['mperm_maxheight']	= 240;
$modversion['mimetypes'][15]['mperm_maxsize']	= 500000;

$modversion['mimetypes'][15]['mime_ext']		= 'rm';
$modversion['mimetypes'][15]['mime_types']		= 'application/vnd.rn-realmedia';
$modversion['mimetypes'][15]['mime_name']		= 'RealMedia Streaming Media';
$modversion['mimetypes'][15]['mime_status'] 	= 1; // 1 = visible - 0 = hidden
$modversion['mimetypes'][15]['mperm_maxwidth']	= 320;
$modversion['mimetypes'][15]['mperm_maxheight']	= 240;
$modversion['mimetypes'][15]['mperm_maxsize']	= 500000;

if( ! empty( $_POST['fct'] ) && ! empty( $_POST['op'] ) && $_POST['fct'] == 'modulesadmin' && $_POST['op'] == 'update_ok' && $_POST['dirname'] == $modversion['dirname'] ) {
	include dirname( __FILE__ ) . "/include/onupdate.inc.php" ;
}
?>