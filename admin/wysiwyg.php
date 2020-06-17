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

function check_wysiwyg() {
	global $xoopsConfig, $modify, $xoopsModuleConfig, $xoopsModule, $XOOPS_URL;

    $on   = '<img src="../images/icon/online.gif"   alt=""  align="absmiddle" />';
    $off  = '<img src="../images/icon/offline.gif"  alt="" align="absmiddle" />';

    // Spaw
    if ( is_readable(XOOPS_ROOT_PATH . "/class/spaw/formspaw.php"))	{
    	$check = $on;
    } else {
    	$check = $off;
    }
    $spaw = '<tr class="odd">
   			 <td width="12">'.$check.'</td>
           	 <td align="left"><a href="http://xoops.org.cn/modules/wfdownloads/visit.php?lid=201" target="_blank">'._MI_EDITO_FORM_SPAW.'</a>
           	 <br />/class/spaw/</td>
             </tr>';

    // fckeditor
	if ( is_readable(XOOPS_ROOT_PATH . "/class/fckeditor/formfckeditor.php"))	{
    	$check = $on;
    } else {
    	$check = $off;
    }
    $fck = '<tr class="odd">
    		<td width="12">'.$check.'</td>
   	        <td align="left"><a href="http://dev.xoops.org/modules/xfmod/project/showfiles.php?group_id=1155" target="_blank">'._MI_EDITO_FORM_FCK.'</a>
       	    <br />/class/fckeditor/</td>
            </tr>';

    // EDITO htmlarea
	if ( is_readable(XOOPS_ROOT_PATH . "/class/htmlarea/formhtmlarea.php"))	{
    	$check = $on;
    } else {
	    $check = $off;
    }
    $dhtml = '<tr class="odd">
    		  <td width="12">'.$check.'</td>
              <td align="left">'._MI_EDITO_FORM_DHTML.'</td>
              </tr>';

    // htmlarea
	if ( is_readable(XOOPS_ROOT_PATH . "/class/htmlarea/formhtmlarea.php"))	{
	    $check = $on;
    } else {
    	$check = $off;
    }
	$htmlarea = '<tr class="odd">
    			 <td width="12">'.$check.'</td>
                 <td align="left"><a href="http://dev.xoops.org/modules/xfmod/project/showfiles.php?group_id=1155" target="_blank">'._MI_EDITO_FORM_HTMLAREA.'</a>
                 <br />/class/htmlarea/</td>
                 </tr>';

	// dhtml
    $check = $on;
    $dhtml = '<tr class="odd">
    		  <td width="12">'.$check.'</td>
              <td align="left">'._MI_EDITO_FORM_DHTML.'</td>
              </tr>';

	// compact
	$check = $on;
    $compact = '<tr class="odd">
    			<td width="12">'.$check.'</td>
                <td align="left">'._MI_EDITO_FORM_COMPACT.'</td>
                </tr>';

	// Koivi
	if ( is_readable(XOOPS_ROOT_PATH . "/class/xoopseditor/wysiwyg/formwysiwygtextarea.php"))	{
    	$check = $on;
    } else {
	    $check = $off;
    }
    $koivi = '<tr class="odd">
    		  <td width="12">'.$check.'</td>
              <td align="left"><a href="http://dev.xoops.org/modules/xfmod/project/showfiles.php?group_id=1038" target="_blank">'._MI_EDITO_FORM_KOIVI.'</a>
              <br />class/xoopseditor/wysiwyg/</td>
              </tr>';


	// TinyEditor
	if ( is_readable(XOOPS_ROOT_PATH . "/class/xoopseditor/tinyeditor/formtinyeditortextarea.php"))	{
    	$check = $on;
    } else {
	    $check = $off;
    }
    $tiny = '<tr class="odd">
    		 <td width="12">'.$check.'</td>
             <td align="left"><a href="http://dev.xoops.org/modules/xfmod/project/showfiles.php?group_id=1197" target="_blank">'._MI_EDITO_FORM_TINYEDITOR.'</a>
             <br />/class/xoopseditor/tinyeditor/</td>
             </tr>';

/*
	// inbetween
	if ( is_readable(XOOPS_ROOT_PATH . "/class/xoopseditor/tinyeditor/formtinyeditortextarea.php"))	{
    	$check = $on;
    } else {
	    $check = $off;
    }
    $inbetween = '<tr class="odd">
    			  <td>'._MI_EDITO_FORM_INBETWEEN.'</td>
                  <td>'.$check.'</td>
                  </tr>';
*/

	$sform = new XoopsThemeForm( _MD_EDITO_EDITORS, "op", xoops_getenv( 'PHP_SELF' ) );
    $sform -> setExtra( 'enctype="multipart/form-data"' );

//    $sform -> addElement( new XoopsFormText( _MD_EDITO_CLONENAME, 'clone', 16, 16, '' ), true );
	$sform -> addElement($compact);
    $sform -> addElement($dhtml);
    $sform -> addElement($tiny);
    $sform -> addElement($koivi);
    $sform -> addElement($htmlarea);
    $sform -> addElement($fck);
    $sform -> addElement($spaw);
//	$sform -> addElement($inbetween);
	$sform -> display();
    unset( $hidden );
}


/* -- Available operations -- */
switch ( $op ) {
	case "check_wysiwyg":
    default:
    	include_once( "admin_header.php" );
        edito_adminmenu(2, _MD_EDITO_EDITORS);
        edito_statmenu(4, '');
        check_wysiwyg();
        include_once( 'admin_footer.php' );
    break;
}
?>