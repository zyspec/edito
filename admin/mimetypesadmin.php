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
global $xoopsDB, $xoopsConfig, $xoopsModule;

require_once XOOPS_ROOT_PATH . '/kernel/mimetypes.php';
require_once XOOPS_ROOT_PATH . '/modules/xoopsinfo/include/functions.php';
require_once XOOPS_ROOT_PATH . '/modules/xoopsinfo/include/mimetypes.php';
require_once XOOPS_ROOT_PATH . '/class/pagenav.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

// language files
if (file_exists(XOOPS_ROOT_PATH . '/modules/xoopsinfo/language/' . $xoopsConfig['language'] . '/admin.php')) {
    require_once XOOPS_ROOT_PATH . '/modules/xoopsinfo/language/' . $xoopsConfig['language'] . '/admin.php';
} else {
    require_once XOOPS_ROOT_PATH . '/modules/xoopsinfo/language/english/admin.php';
}
if (file_exists(XOOPS_ROOT_PATH . '/language/' . $xoopsConfig['language'] . '/global.php')) {
    @require XOOPS_ROOT_PATH . '/language/' . $xoopsConfig['language'] . '/global.php';
} else {
    @require XOOPS_ROOT_PATH . '/language/english/admin/global.php';
}
if (file_exists(XOOPS_ROOT_PATH . '/modules/system/language/' . $xoopsConfig['language'] . '/admin.php')) {
    @require XOOPS_ROOT_PATH . '/modules/system/language/' . $xoopsConfig['language'] . '/admin.php';
} else {
    @require XOOPS_ROOT_PATH . '/modules/system/language/english/admin/admin.php';
}
// language files

$op       = isset($_REQUEST['op']) ? trim($_REQUEST['op']) : '';
$create   = isset($_REQUEST['new']);
$start    = isset($_REQUEST['start']) ? (int)$_REQUEST['start'] : 0;
$status   = isset($_REQUEST['status']) ? (int)$_REQUEST['status'] : -1;
$mid      = isset($_REQUEST['mid']) ? (int)$_REQUEST['mid'] : -1;
$confirm  = isset($_REQUEST['confirm']) ? (int)$_REQUEST['confirm'] : 0;
$mime_id  = isset($_REQUEST['mime_id']) ? (int)$_REQUEST['mime_id'] : 0;
$mperm_id = isset($_REQUEST['mperm_id']) ? (int)$_REQUEST['mperm_id'] : 0;
$type     = $_REQUEST['type'] ?? -1;
$mid      = $xoopsModule->mid();

$uri = 'mid=' . $mid . '&start=' . $start . '&status=' . $status . '&type=' . $type;

if ($create) {
    $op = 'edit';
}

if ('POST' == $_SERVER['REQUEST_METHOD'] && !$create) {
    if ('save' == $op) {
        $mperm_id        = isset($_REQUEST['mperm_id']) ? (int)$_REQUEST['mperm_id'] : 0;
        $mperm_mime      = $_REQUEST['mperm_mime'] ?? '';
        $mperm_module    = $_REQUEST['mperm_module'] ?? '';
        $mperm_groups    = $_REQUEST['mperm_groups'] ?? [];
        $mperm_status    = isset($_REQUEST['mperm_status']) ? (int)$_REQUEST['mperm_status'] : 0;
        $mperm_maxwidth  = isset($_REQUEST['mperm_maxwidth']) ? (int)$_REQUEST['mperm_maxwidth'] : 0;
        $mperm_maxheight = isset($_REQUEST['mperm_maxheight']) ? (int)$_REQUEST['mperm_maxheight'] : 0;
        $mperm_maxsize   = isset($_REQUEST['mperm_maxsize']) ? (int)$_REQUEST['mperm_maxsize'] : 0;

        $result = true;

        $mimetypesHandler = xoops_getHandler('mimetypes_perms');

        if (0 != $mperm_id) {
            $mimeObj = new \XoopsMimetypes_perms($mperm_id);

            if ($mperm_mime == $mimeObj->mperm_mime()) {
                $result = $mimetypesHandler->deletebyMimeModule($mimeObj, true);
            }
        }

        if ($result) {
            foreach ($mperm_groups as $key => $group) {
                $mimeObj = new \XoopsMimetypes_perms();
                $mimeObj->setVar('mperm_id', 0);
                $mimeObj->setVar('mperm_mime', $mperm_mime);
                $mimeObj->setVar('mperm_module', $mperm_module);
                $mimeObj->setVar('mperm_groups', $group);
                $mimeObj->setVar('mperm_status', $mperm_status);
                $mimeObj->setVar('mperm_maxwidth', $mperm_maxwidth);
                $mimeObj->setVar('mperm_maxheight', $mperm_maxheight);
                $mimeObj->setVar('mperm_maxsize', $mperm_maxsize);

                if (!$mimetypesHandler->insert($mimeObj, true)) {
                    redirect_header('mimetypes.php?' . $uri, 3, $mimetypesHandler->getHtmlErrors());
                }
            }
        }

        redirect_header('mimetypes.php?' . $uri, 3, _AM_AM_DBUPDATED);
    }

    if ('saveall' == $op) {
        $mimetypesHandler = xoops_getHandler('mimetypes_perms');

        $mperm_ids = $_REQUEST['mperm_id'] ?: [];

        foreach ($mperm_ids as $mperm_id => $value) {
            $mperm_mime      = $_REQUEST['mperm_mime'][$mperm_id];
            $mperm_module    = $_REQUEST['mperm_module'][$mperm_id];
            $mperm_maxwidth  = $_REQUEST['mperm_maxwidth'][$mperm_id];
            $mperm_maxheight = $_REQUEST['mperm_maxheight'][$mperm_id];
            $mperm_maxsize   = $_REQUEST['mperm_maxsize'][$mperm_id];
            $mperm_groups    = $_REQUEST['mperm_groups'][$mperm_id];
            $mimetypeObjs    = $mimetypesHandler->get_byMimeModule($mperm_mime, $mperm_module);

            $groups = [];

            foreach ($mimetypeObjs as $key => $mimetypeObj) {
                $groups[] = $mimetypeObj->getVar('mperm_groups');

                $mperm_status = $mimetypeObj->getVar('mperm_status');

                if (in_array($mimetypeObj->getVar('mperm_groups'), $mperm_groups, true)) {
                    if ($mimetypeObj->getVar('mperm_maxwidth') != $mperm_maxwidth || $mimetypeObj->getVar('mperm_maxheight') != $mperm_maxheight || $mimetypeObj->getVar('mperm_maxsize') != $mperm_maxsize) {
                        $mimetypeObj->setVar('mperm_maxwidth', $mperm_maxwidth);

                        $mimetypeObj->setVar('mperm_maxheight', $mperm_maxheight);

                        $mimetypeObj->setVar('mperm_maxsize', $mperm_maxsize);

                        if (!$mimetypesHandler->insert($mimetypeObj, true)) {
                            redirect_header('mimetypes.php?' . $uri, 3, $mimetypesHandler->getHtmlErrors());
                        }
                    }
                } else {
                    if (!$mimetypesHandler->delete($mimetypeObj, true)) {
                        redirect_header('mimetypes.php?' . $uri, 3, $mimetypesHandler->getHtmlErrors());
                    }
                }
            }

            $newgroups = array_diff($mperm_groups, $groups);

            foreach ($newgroups as $key => $group) {
                $mimeObj = new \XoopsMimetypes_perms();
                $mimeObj->setVar('mperm_id', 0);
                $mimeObj->setVar('mperm_mime', $mperm_mime);
                $mimeObj->setVar('mperm_module', $mperm_module);
                $mimeObj->setVar('mperm_groups', $group);
                $mimeObj->setVar('mperm_status', $mperm_status);
                $mimeObj->setVar('mperm_maxwidth', $mperm_maxwidth);
                $mimeObj->setVar('mperm_maxheight', $mperm_maxheight);
                $mimeObj->setVar('mperm_maxsize', $mperm_maxsize);

                if (!$mimetypesHandler->insert($mimeObj, true)) {
                    redirect_header('mimetypes.php?' . $uri, 3, $mimetypesHandler->getHtmlErrors());
                }
            }
        }

        redirect_header('mimetypes.php?' . $uri, 3, _AM_AM_DBUPDATED);

        exit();
    }

    if ('dele' == $op && $confirm) {
        $mimetypesHandler = xoops_getHandler('mimetypes_perms');

        $mimeObj = new \XoopsMimetypes_perms($mperm_id);

        if (!$mimetypesHandler->deletebyMime($mimeObj, true)) {
            redirect_header('mimetypes.php?' . $uri, 3, $mimetypesHandler->getHtmlErrors());
        }

        redirect_header('mimetypes.php?mid=' . $mid . '&status=' . $status, 3, _AM_AM_DBUPDATED);

        exit();
    }
}

switch ($op) {
    case 'hide':
        $mimetypesHandler = xoops_getHandler('mimetypes_perms');
        $mimeObjs         = $mimetypesHandler->get_byMimeModule($mime_id, $mid);
        foreach ($mimeObjs as $mimeObj) {
            $mimeObj->setVar('mperm_status', 0);

            if (!$mimetypesHandler->insert($mimeObj, true)) {
                redirect_header('mimetype.php?' . $uri, 3, $mimetypesHandler->getHtmlErrors());
            }
        }
        redirect_header('mimetypes.php?' . $uri, 3, _AM_AM_DBUPDATED);
        break;
    case 'view':
        $mimetypesHandler = xoops_getHandler('mimetypes_perms');
        $mimeObjs         = $mimetypesHandler->get_byMimeModule($mime_id, $mid);
        foreach ($mimeObjs as $mimeObj) {
            $mimeObj->setVar('mperm_status', 1);

            if (!$mimetypesHandler->insert($mimeObj, true)) {
                redirect_header('mimetypes.php?' . $uri, 3, $mimetypesHandler->getHtmlErrors());
            }
        }
        redirect_header('mimetypes.php?' . $uri, 3, _AM_AM_DBUPDATED);
        break;
    case 'dele':
        $mime_id = isset($_REQUEST['mime_id']) ? (int)$_REQUEST['mime_id'] : (int)$mime_id;
        $sql     = 'SELECT p.mperm_id, t.mime_id, t.mime_name, m.name FROM ' . $xoopsDB->prefix('mimetypes_perms') . ' p LEFT JOIN ' . $xoopsDB->prefix('mimetypes') . ' t on p.mperm_mime = t.mime_id LEFT JOIN ' . $xoopsDB->prefix('modules')
                   . ' m on p.mperm_module = m.mid WHERE mperm_id=' . $mime_id;
        $result  = $xoopsDB->queryF($sql);
        [
            $mperm_id,
            $mime_id,
            $mime_name,
            $mod_name,
        ]
            = $xoopsDB->fetchRow($result);
        xoops_confirm([
                          'op'        => 'dele',
                          'mperm_id'  => $mperm_id,
                          'mime_id'   => $mime_id,
                          'confirm'   => 1,
                          'mime_name' => $mime_name,
                          'mod_name'  => $mod_name,
                          'status'    => $status,
                          'mid'       => $mid,
                      ], 'mimetypes.php?', _AM_XI_MIME_DELETETHIS . "<br><br><font color='#CC0000'>" . $mod_name . '</font><br>' . $mime_name, _AM_XI_MIME_DELE);
        break;
    case 'edit':
        edit_mimetypes_modules();
        break;
    default:
        require_once XOOPS_ROOT_PATH . '/class/uploader.php';
        if (!defined('_XI_MIMETYPE')) {
            if (file_exists(XOOPS_ROOT_PATH . '/modules/xoopsinfo/language/' . $xoopsConfig['language'] . '/mimetypes.txt')) {
                require_once XOOPS_ROOT_PATH . '/modules/xoopsinfo/language/' . $xoopsConfig['language'] . '/mimetypes.txt';
            } else {
                require_once XOOPS_ROOT_PATH . '/modules/xoopsinfo/language/english/mimetypes.txt';
            }
        } else {
            list_mimetypes_perms();
        }
        break;
}
