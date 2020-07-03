<?php declare(strict_types=1);
/**
 * XOOPS - PHP Content Management System
 * Copyright (c) 2004 <https://www.xoops.org>
 *
 * Module: edito
 * Licence : GPL
 * Authors :
 *           - solo (http://www.wolfpackclan.com/wolfactory)
 *			- DuGris (http://www.dugris.info)
 */

use Xmf\Request;

require_once dirname(__DIR__, 3) . '/mainfile.php';
require_once dirname(__DIR__, 3) . '/include/cp_header.php';

//@todo replace the following code - is is VERY insecure/dangerous
foreach ($_POST as $k => $v) {
    ${$k} = $v;
}
foreach ($_GET as $k => $v) {
    ${$k} = $v;
}

/*
$op = '';
if ( isset( $_GET['op'] ) ) $op = $_GET['op'];
if ( isset( $_POST['op'] ) ) $op = $_POST['op'];
if ( isset($_GET['dir'])) { $dir = $_GET['dir']; } else { $dir = ''; }
if ( isset($_POST['dir'])) { $dir = $_POST['dir']; }
*/

$op = Request::getCmd('op', '');
$dir = Request::getString('dir', '');

/**
 * @param $dir
 */
function utilities($dir)
{
    global $xoopsConfig, $modify, $xoopsModuleConfig, $xoopsModule, $XOOPS_URL, $xoopsDB;

    if (!isset($uploadir)) {
        $uploadir = 0;
    }

    //$select_form = edito_selector($id, 'content_edito|id|subject|||', 'uploader.php?id');

    $current_dir = $xoopsModuleConfig['sbuploaddir'];

    $select[1] = '';

    if ('media' == $dir) {
        $select = ' selected';

        $current_dir = $xoopsModuleConfig['sbmediadir'];
    } else {
        $select = '';

        $current_dir = $xoopsModuleConfig['sbuploaddir'];
    }

    $select_form = '
                <select size="1"  name="selectcontent_edito" onchange="location=\'utils_uploader.php?dir=\'+this.options[this.selectedIndex].value">
                <option value="logo">             [LOGO]: ' . $xoopsModuleConfig['sbuploaddir'] . '/</option>
                <option value="media"' . $select . '> [MEDIA]: ' . $xoopsModuleConfig['sbmediadir'] . ' /</option>
                </select>
    ';

    $sform = new XoopsThemeForm(_AM_EDITO_UPLOAD . ' : ' . $select_form, 'op', xoops_getenv('PHP_SELF'));

    $sform->setExtra('enctype="multipart/form-data"');

    // Media

    $dirs = ['logo', 'media'];

    $pagedir_array = $dirs;

    $pagedir_select = new XoopsFormSelect('', 'dir', $dir);

    $pagedir_select->addOptionArray($pagedir_array);

    $pagedir_tray = new XoopsFormElementTray(_AM_EDITO_PAGE, '&nbsp;');

    $pagedir_tray->addElement($pagedir_select);

    $sform->addElement(new XoopsFormHidden('dir', $dir));

    // File selector

    $sform->addElement(new XoopsFormFile(_AM_EDITO_UPLOADMEDIA, 'cmedia', ''), true);

    $button_tray = new XoopsFormElementTray('', '');

    $hidden = new XoopsFormHidden('op', 'uploadmedia');

    $button_tray->addElement($hidden);

    $butt_create = new XoopsFormButton('', '', _AM_EDITO_SUBMIT, 'submit');

    $butt_create->setExtra('onclick="this.form.elements.op.value=\'uploadmedia\'"');

    $button_tray->addElement($butt_create);

    $butt_clear = new XoopsFormButton('', '', _AM_EDITO_CLEAR, 'reset');

    $button_tray->addElement($butt_clear);

    $butt_cancel = new XoopsFormButton('', '', _AM_EDITO_CANCEL, 'button');

    $butt_cancel->setExtra('onclick="history.go(-1)"');

    $button_tray->addElement($butt_cancel);

    $sform->addElement($button_tray);

    //	Code to create the media selector

    $graph_array = XoopsLists::getImgListAsArray(XOOPS_ROOT_PATH . '/' . $current_dir);

    $image_select = new XoopsFormSelect('', 'image', '');

    $image_select->addOptionArray($graph_array);

    $image_select->setExtra('onchange=\'showImgSelected("image5", "image", "' . $current_dir . '", "", "' . XOOPS_URL . '")\'');

    $image_tray = new XoopsFormElementTray(_AM_EDITO_MEDIA, '&nbsp;');

    $image_tray->addElement($image_select);

    $image_tray->addElement(new XoopsFormLabel('', '<p><img src="' . XOOPS_URL . '/modules/edito/assets/images/blank.gif" name="image5" id="image5" alt="">'));

    $sform->addElement($image_tray);

    $sform->display();

    unset($hidden);
}

/**
 * @param string $file_name
 * @param string $allowed_mimetypes
 * @param string $dir
 * @param string $redirecturl
 * @param string $file_options
 * @param int    $num
 * @param int    $redirect
 */
function edito_uploader(
    $file_name = '',
    $allowed_mimetypes = '',
    $dir = 'uploads/edito/',
    $redirecturl = 'utils_uploader.php',
    $file_options = '1024|748|1024000)',
    $num = 0,
    $redirect = 1
) {
    require_once XOOPS_ROOT_PATH . '/class/uploader.php';

    $media_options = explode('|', $file_options);

    $maxfilewidth = $media_options[0];

    $maxfileheight = $media_options[1];

    $maxfilesize = $media_options[2];

    $uploaddir = XOOPS_ROOT_PATH . '/' . $dir;

    $file = $uploaddir . '/' . $file_name;

    $comment = _AM_EDITO_UPLOADED; // init comment

    if (is_file($file)) {
        unlink($file);

        $comment = _AM_EDITO_UPDATED;
    }

    $uploader = new XoopsMediaUploader($uploaddir, $allowed_mimetypes, $maxfilesize, $maxfilewidth, $maxfileheight);

    if ($uploader->fetchMedia($_POST['xoops_upload_file'][$num])) {
        if (!$uploader->upload()) {
            $errors = $uploader->getErrors();

            redirect_header($redirecturl, 3, _AM_EDITO_UPLOAD_ERROR . $errors);
        } else {
            if ($redirect) {
                redirect_header($redirecturl, $redirect, $comment);
            }
        }
    } else {
        $errors = $uploader->getErrors();

        redirect_header($redirecturl, 3, _AM_EDITO_UPLOAD . $errors);
    }
}

/* -- Available operations -- */
switch ($op) {
    case 'uploadmedia':
        //$xoopsModuleConfig['sbuploaddir'],$xoopsModuleConfig['sbmediadir']
        $allowed_mimetypes = [
            'image/gif',
            'image/jpeg',
            'image/pjpeg',
            'image/x-png',
            'image/png',
        ];
        $file_name = $_FILES['cmedia']['name'];
        $current_dir = 'media' == $dir ? $xoopsModuleConfig['sbmediadir'] : $xoopsModuleConfig['sbuploaddir'];
        edito_uploader($file_name, $allowed_mimetypes, $current_dir, "utils_uploader.php?dir={$dir}");
        break;
    case 'utilities':
    default:
        require_once __DIR__ . '/admin_header.php';
        edito_adminmenu(2, _AM_EDITO_UTILITIES . '<br>' . _AM_EDITO_UPLOAD);
        edito_statmenu(0, '');
        utilities($dir);
        require_once __DIR__ . '/admin_footer.php';
        break;
}
