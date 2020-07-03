<?php declare(strict_types=1);
/**
 * XOOPS - PHP Content Management System
 * Copyright (c) 2001 - 2006 <https://www.xoops.org>
 *
 * Module	: MimeTypes - Install MimeTypes
 * Version	: 1.0
 * Licence	: GPL
 * Authors	:
 *			- DuGris (http://www.dugris.info)
 * @param mixed $dirname
 */
function install_MimeTypes($dirname = '')
{
    global $xoopsDB;

    $hModule = xoops_getHandler('module');

    if ($ModuleInfo = $hModule->getByDirname($dirname)) {
        if (($hModule->getByDirName('xoopsinfo') && '2.0' == mb_substr(XOOPS_VERSION, 6, 3) && mb_substr(XOOPS_VERSION, 10, 2) < 16) ||
             ($hModule->getByDirName('xoopsinfo') && '2.2' == mb_substr(XOOPS_VERSION, 6, 3))) {
            $ModuleInfo->loadInfoAsVar($dirname);

            $mimeTypes = $ModuleInfo->getInfo('mimetypes');

            foreach ($mimeTypes as $key => $mimeType) {
                $mime_id = 0;

                $sql = 'SELECT mime_id FROM ' . $xoopsDB->prefix('mimetypes') . ' WHERE mime_ext = ' . $xoopsDB->quoteString($mimeType['mime_ext']);

                $result = $xoopsDB->query($sql);

                if (0 == $xoopsDB->getRowsNum($result)) {
                    $sql = 'INSERT INTO ' . $xoopsDB->prefix('mimetypes') . ' VALUES ( 0, ' .
                            $xoopsDB->quoteString($mimeType['mime_ext']) . ', ' .
                            $xoopsDB->quoteString($mimeType['mime_types']) . ', ' .
                            $xoopsDB->quoteString($mimeType['mime_name']) . ', ' .
                            $mimeType['mime_status'] . ')';

                    if ($result = $xoopsDB->queryF($sql)) {
                        $mime_id = $xoopsDB->getInsertId();
                    }
                } else {
                    list($mime_id) = $xoopsDB->fetchRow($result);
                }

                if (0 != $mime_id) {
                    $sql = 'INSERT INTO . ' . $xoopsDB->prefix('mimetypes_perms') . ' VALUES ( 0, ' .
                           $mime_id . ', ' .
                           $ModuleInfo->mid() . ', ' .
                           XOOPS_GROUP_ADMIN . ', ' .
                           $mimeType['mime_status'] . ', ' .
                           $mimeType['mperm_maxwidth'] . ', ' .
                           $mimeType['mperm_maxheight'] . ', ' .
                           $mimeType['mperm_maxsize'] . ')';

                    if ($result = $xoopsDB->queryF($sql)) {
                        $mperm_id = $xoopsDB->getInsertId();
                    }
                }
            }
        }
    }
}
