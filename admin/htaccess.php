<?php

declare(strict_types=1);

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
 * @copyright Copyright {@link https://xoops.org XOOPS Project}
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 * @author    Solo (http://www.wolfpackclan.com/wolfactory)
 * @author    DuGris (http://www.dugris.info)
 * @author    XOOPS Module Development Team
 * @link      https://github.com/XoopsModules25x/edito
 */

use Xmf\Request;

require_once dirname(__DIR__, 3) . '/mainfile.php';
require_once dirname(__DIR__, 3) . '/include/cp_header.php';

// foreach ( $_POST as $k => $v ) { ${$k} = $v; }
// foreach ( $_GET as $k => $v ) { ${$k} = $v; }

$op       = Request::getCmd('op', '', 'POST');
$dir      = Request::getString('dir', '', 'POST');
$sitelist = Request::getString('sitelist', 'logos', 'POST');
/*
$op       = '';
$dir      = 'logos';
$sitelist = '';
if ( isset( $_POST['op'] )) $op = $_POST['op'];
if ( isset( $_POST['dir'] )) $dir = $_POST['dir'];
if ( isset( $_POST['sitelist'] )) $sitelist = $_POST['sitelist'];
*/

/**
 * @param $target
 * @param $file_content
 * @return bool
 */
function copy_htaccess($target, $file_content)
{
    $handle = fopen($target, 'w+b');

    if ($handle && fwrite($handle, $file_content)) {
        return true;
    }

    return false;
}

/**
 * @param $dir
 * @param $sitelist
 */
function utilities($dir, $sitelist)
{
    global $xoopsConfig, $modify, $xoopsModuleConfig, $xoopsModule, $XOOPS_URL, $xoopsDB;

    if (!isset($uploadir)) {
        $uploadir = 0;
    }

    //$select_form = edito_selector($id, 'content_edito|id|subject|||', 'uploader.php?id');

    $current_dir = $xoopsModuleConfig['sbuploaddir'];

    $select[1] = '';

    /*
    $select='';
    $current_dir='';
    if ('media' == $dir)
        $select=" selected";
        $current_dir='media';
    }
    */

    $sform = new XoopsThemeForm(_AM_EDITO_HTACCESS, 'op', xoops_getenv('PHP_SELF'));

    $sform->setExtra('enctype="multipart/form-data"');

    // Directories

    $dirs = [
        'logos' => 'logos',
        'media' => 'media',
    ];

    $pagedir_array = $dirs;

    $pagedir_select = new XoopsFormSelect('', 'dir', $dir);

    $pagedir_select->addOptionArray($pagedir_array);

    $pagedir_tray = new XoopsFormElementTray(_AM_EDITO_HTACCESS, '&nbsp;');

    $pagedir_tray->addElement($pagedir_select);

    $sform->addElement($pagedir_tray);

    $sform->addElement(new XoopsFormHidden('dir', $dir));

    $sform->addElement(new XoopsFormTextArea(_AM_EDITO_SITELIST, 'sitelist', $sitelist, 5), false);

    $button_tray = new XoopsFormElementTray('', '');

    $hidden = new XoopsFormHidden('op', '');

    $button_tray->addElement($hidden);

    $butt_create = new XoopsFormButton('', '', _AM_EDITO_SUBMIT, 'submit');

    $butt_create->setExtra('onclick="this.form.elements.op.value=\'protect\'"');

    $button_tray->addElement($butt_create);

    $butt_cancel = new XoopsFormButton('', '', _AM_EDITO_CANCEL, 'button');

    $butt_cancel->setExtra('onclick="history.go(-1)"');

    $button_tray->addElement($butt_cancel);

    $sform->addElement($button_tray);

    $sform->display();

    unset($hidden);
}

/**
 * @param        $dir
 * @param string $sitelist
 */
function create_htaccess($dir, $sitelist = '')
{
    global $xoopsModule, $xoopsModuleConfig;

    $domain = preg_replace('/http[s]:\/\//', '', XOOPS_URL);

    $domain = preg_replace('/www\./', '', $domain);

    $domain = explode('/', $domain);

    $domain = $domain[0] . pathinfo($domain[1], PATHINFO_EXTENSION);

    $media_list = 'gif|tif|jpg|jpeg|png|mpg|mpeg|avi|mp3|flx|swf|wmv|asx|ram|rm|mp3|wav|mid';

    $code = "
RewriteEngine On
RewriteCond %{HTTP_REFERER} !^$
RewriteCond %{HTTP_REFERER} !^http(s)?://(www\.)?" . $domain . '/.*$ [NC]';

    if ($sitelist) {
        $sitelist = explode('|', $sitelist);

        foreach ($sitelist as $siteurl) {
            $domain = preg_replace('/http[s]:\/\//', '', trim($siteurl));

            $domain = preg_replace('/www\./', '', $domain);

            $domain = explode('/', $domain);

            $domain = str_replace('.', '\\.', $domain[0]);

            $code .= "
RewriteCond %{HTTP_REFERER} !^http(s)?://(www\.)?" . $domain . '/.*$ [NC]
';
        }
    }

    $code .= '
RewriteRule [^/]+.(' . $media_list . ')$ ' . XOOPS_URL . '/assets/images/logo.gif [NC,F,L]';

    $current_dir = 'media' == $dir ? $xoopsModuleConfig['sbmediadir'] : $xoopsModuleConfig['sbuploaddir'];

    $target = XOOPS_ROOT_PATH . "/{$current_dir}/.htaccess";

    copy_htaccess($target, $code);
}

/**
 * @param        $dir
 * @param string $sitelist
 */
function display_htaccess($dir, $sitelist = '')
{
    global $xoopsModule;

    $myts = MyTextSanitizer::getInstance();

    $info1 = _AM_EDITO_HTACCESS_INFO1;

    $info2 = _AM_EDITO_HTACCESS_INFO2;

    $instructions_01 = '<tr class="odd"><td colspan="2" align="left">
                       ' . $myts->displayTarea($info1) . '
                       </td></tr>';

    $instructions_02 = '<tr class="odd"><td colspan="2" align="left">
                           ' . $myts->displayTarea($info2) . '
                       </td></tr>';

    $domain = preg_replace('/http:\/\//', '', XOOPS_URL);

    $domain = preg_replace('/www\./', '', $domain);

    $domain = explode('/', $domain);

    $domain = $domain[0] . pathinfo($domain[1], PATHINFO_EXTENSION);

    $media_list = 'gif|tif|jpg|jpeg|png|mpg|mpeg|avi|mp3|flx|swf|wmv|asx|ram|rm|mp3|wav|mid';

    $code = "
RewriteEngine On
RewriteCond %{HTTP_REFERER} !^$
RewriteCond %{HTTP_REFERER} !^http://(www\.)?" . $domain . '/.*$ [NC]';

    if ($sitelist) {
        $sitelist = explode('|', $sitelist);

        foreach ($sitelist as $siteurl) {
            $domain = preg_replace('/http[s]:\/\//', '', trim($siteurl));

            $domain = preg_replace('/www\./', '', $domain);

            $domain = explode('/', $domain);

            $domain = str_replace('.', '\\.', $domain[0]);

            $code .= "
RewriteCond %{HTTP_REFERER} !^http(s)?://(www\.)?" . $domain . '/.*$ [NC]
';
        }
    }

    $code .= '
RewriteRule [^/]+.(' . $media_list . ')$ ' . XOOPS_URL . '/assets/images/logo.gif [NC,F,L]';

    // To display a picture insert this code

    // RewriteRule [^/]+.(".$media_list.")$ ".XOOPS_URL."/modules/" . $xoopsModule->dirname()."/assets/images/restricted.gif [R,L]

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
                 <textarea rows="10" cols="160" name="Obj" id="1" wrap="off">' . $code . '</textarea><br>
                 <input onclick="SelectIt(this.form.Obj)" type="button" name="copy" value="' . _AM_EDITO_COPY . '">
                 </div>
                 </form>
                 </td>
                 </tr>';

    $sform = new XoopsThemeForm(_AM_EDITO_HTACCESS, '', '');

    $sform->setExtra('enctype="multipart/form-data"');

    $sform->addElement($instructions_01);

    $sform->addElement($htaccess);

    $sform->addElement($instructions_02);

    $sform->display();

    unset($hidden);
}

/* -- Available operations -- */
switch ($op) {
    case 'utilities':
    default:
        require_once __DIR__ . '/admin_header.php';
        edito_adminmenu(2, _AM_EDITO_HTACCESS);
        edito_statmenu(5, '');
        utilities($dir, $sitelist);
        require_once __DIR__ . '/admin_footer.php';
        break;
    case 'protect':
        $current_dir = 'media' == $dir ? $xoopsModuleConfig['sbmediadir'] : $xoopsModuleConfig['sbuploaddir'];
        require_once __DIR__ . '/admin_header.php';
        edito_adminmenu(2, _AM_EDITO_HTACCESS);
        edito_statmenu(5, '');
        if (function_exists('fopen')) {
            create_htaccess($dir, $sitelist);
        }
        utilities($dir, $sitelist);
        display_htaccess($dir, $sitelist);
        require_once __DIR__ . '/admin_footer.php';
        break;
}
