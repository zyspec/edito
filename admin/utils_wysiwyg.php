<?php
/*
 You may not change or alter any portion of this comment or credits of
 supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit
 authors.

 This program is distributed in the hope that it will be useful, but
 WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */
/**
 * Module: Edito
 *
 * @package   \XoopsModules\Edito
 * @copyright Copyright {@link https://xoops.org XOOPS Project}
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 * @author    Solo (http://www.wolfpackclan.com/wolfactory)
 * @author    DuGris (http://www.dugris.info)
 * @author    XOOPS Module Development Team
 * @link      https://github.com/XoopsModules25x/edito
 */

require_once dirname(__DIR__, 3) . '//mainfile.php';
require_once dirname(__DIR__, 3) . '//include/cp_header.php';

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

	$sform = new XoopsThemeForm( _AM_EDITO_EDITORS, "op", xoops_getenv( 'PHP_SELF' ) );
    $sform -> setExtra( 'enctype="multipart/form-data"' );

//    $sform -> addElement( new XoopsFormText( _AM_EDITO_CLONENAME, 'clone', 16, 16, '' ), true );
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
        edito_adminmenu(2, _AM_EDITO_UTILITIES.'<br>'._AM_EDITO_WYSIWYG);
        edito_statmenu(4, '');
        check_wysiwyg();
        include_once( 'admin_footer.php' );
    break;
}
