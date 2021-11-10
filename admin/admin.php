<?php

declare(strict_types=1);

// $Id: admin.php,v 1.4 2005/11/30 22:13:22 malanciault Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <https://www.xoops.org>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
// Author: Kazumi Ono (AKA onokazu)                                          //
// URL: http://www.myweb.ne.jp/, https://www.xoops.org/, http://jp.xoops.org/ //
// Project: The XOOPS Project                                                //
// ------------------------------------------------------------------------- //

use Xmf\Request;

$admin_mydirname = basename(dirname(__DIR__));

$fct = Request::getString('fct', '');
$fct = trim($fct);
if (empty($fct)) {
    $fct = 'preferences';
}
//if (isset($fct) && $fct == "users") {
//	$xoopsOption['pagetype'] = "user";
//}

require __DIR__ . '/admin_header.php';

require_once XOOPS_ROOT_PATH . '/class/xoopsmodule.php';

$admintest = 0;

if (is_object($GLOBALS['xoopsUser'])) {
    $xoopsModule = XoopsModule::getByDirname('system');

    if (!$GLOBALS['xoopsUser']->isAdmin($xoopsModule->mid())) {
        redirect_header(XOOPS_URL . '/user.php', 3, _NOPERM);
    }

    $admintest = 1;
} else {
    redirect_header(XOOPS_URL . '/user.php', 3, _NOPERM);
}

// include system category definitions
require_once XOOPS_ROOT_PATH . '/modules/system/constants.php';
$error = false;
if (0 !== $admintest) {
    if ('' !== $fct) {
        if (file_exists(XOOPS_ROOT_PATH . '/modules/system/admin/' . $fct . '/xoops_version.php')) {
            if (file_exists(XOOPS_ROOT_PATH . '/modules/system/language/' . $GLOBALS['xoopsConfig']['language'] . '/admin.php')) {
                require XOOPS_ROOT_PATH . '/modules/system/language/' . $GLOBALS['xoopsConfig']['language'] . '/admin.php';
            } else {
                require XOOPS_ROOT_PATH . '/modules/system/language/english/admin.php';
            }

            if (file_exists(XOOPS_ROOT_PATH . '/modules/system/language/' . $GLOBALS['xoopsConfig']['language'] . '/admin/' . $fct . '.php')) {
                require XOOPS_ROOT_PATH . '/modules/system/language/' . $GLOBALS['xoopsConfig']['language'] . '/admin/' . $fct . '.php';
            } elseif (file_exists(XOOPS_ROOT_PATH . '/modules/system/language/english/admin/' . $fct . '.php')) {
                require XOOPS_ROOT_PATH . '/modules/system/language/english/admin/' . $fct . '.php';
            }

            require XOOPS_ROOT_PATH . '/modules/system/admin/' . $fct . '/xoops_version.php';

            $syspermHandler = xoops_getHandler('groupperm');
            $category       = !empty($modversion['category']) ? (int)$modversion['category'] : 0;

            unset($modversion);

            if (0 < $category) {
                $groups = $GLOBALS['xoopsUser']->getGroups();

                if (in_array(XOOPS_GROUP_ADMIN, $groups, true) || false !== $syspermHandler->checkRight('system_admin', $category, $groups, $GLOBALS['xoopsModule']->getVar('mid'))) {
                    //					if (file_exists(XOOPS_ROOT_PATH."/modules/system/admin/".$fct."/main.php")) {

                    //						require_once XOOPS_ROOT_PATH."/modules/system/admin/".$fct."/main.php"; GIJ

                    if (file_exists("../include/{$fct}.inc.php")) {
                        require_once "../include/{$fct}.inc.php";
                    } else {
                        $error = true;
                    }
                } else {
                    $error = true;
                }
            } elseif ('version' == $fct) {
                if (file_exists(XOOPS_ROOT_PATH . '/modules/system/admin/version/main.php')) {
                    require_once XOOPS_ROOT_PATH . '/modules/system/admin/version/main.php';
                } else {
                    $error = true;
                }
            } else {
                $error = true;
            }
        } else {
            $error = true;
        }
    } else {
        $error = true;
    }
}

if (false !== $error) {
    xoops_cp_header();

    echo '<h4>System Configuration</h4>';
    echo '<table class="outer" cellpadding="4" cellspacing="1">';
    echo '<tr>';

    $groups = $GLOBALS['xoopsUser']->getGroups();
    $all_ok = true;

    if (!in_array(XOOPS_GROUP_ADMIN, $groups, true)) {
        $syspermHandler = xoops_getHandler('groupperm');
        $ok_syscats     = $syspermHandler->getItemIds('system_admin', $groups);
        $all_ok         = false;
    }

    $admin_dir = XOOPS_ROOT_PATH . '/modules/system/admin';
    $handle    = opendir($admin_dir);
    $counter   = 0;
    $class     = 'even';

    while ($file = readdir($handle)) {
        if ('cvs' != mb_strtolower($file) && !preg_match('/[.]/', $file) && is_dir($admin_dir . '/' . $file)) {
            include $admin_dir . '/' . $file . '/xoops_version.php';

            if ($modversion['hasAdmin']) {
                $category = isset($modversion['category']) ? (int)$modversion['category'] : 0;

                if (false !== $all_ok || in_array($modversion['category'], $ok_syscats, true)) {
                    echo "<td class='$class' align='center' valign='bottom' width='19%'>";
                    echo "<a href='" . XOOPS_URL . '/modules/system/admin.php?fct=' . $file . "'><b>" . trim($modversion['name']) . "</b></a>\n";
                    echo '</td>';

                    ++$counter;
                    $class = 'even' == $class ? 'odd' : 'even';
                }

                if ($counter > 4) {
                    $counter = 0;
                    echo '</tr>';
                    echo '<tr>';
                }
            }

            unset($modversion);
        }
    }

    while ($counter < 5) {
        echo '<td class="' . $class . '">&nbsp;</td>';
        $class = 'even' == $class ? 'odd' : 'even';
        ++$counter;
    }

    echo '</tr></table>';

    xoops_cp_footer();
}
