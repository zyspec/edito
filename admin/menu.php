<?php

declare(strict_types=1);

/**
 * XOOPS - PHP Content Management System
 * Copyright (c) 2004 <https://www.xoops.org>
 *
 * Module: edito 3.0
 * Licence : GPL
 * Authors :
 *           - solo (http://www.wolfpackclan.com/wolfactory)
 *            - DuGris (http://www.dugris.info)
 */

include dirname(__DIR__) . '/preloads/autoloader.php';

$moduleDirName = basename(dirname(__DIR__));
$moduleDirNameUpper = mb_strtoupper($moduleDirName);
/** @var \XoopsModules\Edito\Helper $helper */
$helper = \XoopsModules\Edito\Helper::getInstance();
$helper->loadLanguage('common');
$helper->loadLanguage('feedback');

$pathIcon32 = \Xmf\Module\Admin::menuIconPath('');
if (is_object($helper->getModule())) {
    //    $pathModIcon32 = $helper->getModule()->getInfo('modicons32');
    $pathModIcon32 = $helper->url($helper->getModule()->getInfo('modicons32'));
}

$id = $_POST['id'] ?? $_GET['id'] ?? '';
$op = $_POST['op'] ?? $_GET['op'] ?? '';
$i  = 0;

if (false !== mb_strpos($op, '_ok')) {
    //if (ereg('_ok', $op) ) {
    $adminmenu[] = [
        'title' => _MI_EDITO_GOTO_INDEX,
        'link' => 'index.php',
        'icon' => $pathIcon32 . '/home.png',
    ];
}

$adminmenu[] = [
    'title' => _MI_EDITO_MENU_HOME,
    'link'  => 'admin/index.php',
    'icon' => $pathIcon32 . '/home.png',
];

$adminmenu[] = [
    'title' => _MI_EDITO_MENU_01,
    'link'  => 'admin/main.php',
    'icon' => $pathIcon32 . '/manage.png',
];

$adminmenu[] = [
    'title' => _MI_EDITO_CREATE,
    'link'  => 'admin/content.php',
    'icon' => $pathIcon32 . '/add.png',
];

if ($id) {
    $adminmenu[] = [
        'title' => _MI_EDITO_SEE,
        'link'  => 'content.php?id=' . $id,
        'icon' => $pathIcon32 . '/album.png',
    ];
}

$adminmenu[] = [
    'title' => _MI_EDITO_UTILITIES,
    'link'  => 'admin/utils_uploader.php',
    'icon' => $pathIcon32 . '/administration.png',
];

$adminmenu[] = [
    'title' => _MI_EDITO_BLOCKS_GRPS,
    'link'  => 'admin/blocks.php',
    'icon' => $pathIcon32 . '/block.png',
];

//$moduleHandler = xoops_getHandler('module');

require_once XOOPS_ROOT_PATH . '/class/uploader.php';
if (defined('_XI_MIMETYPE')) {
    $adminmenu[] = [
        'title' => _MI_EDITO_MIMETYPES,
        'link'  => 'admin/mimetypes.php',
        'icon' => $pathIcon32 . '/home.png',
    ];

}

// Blocks Admin
$adminmenu[] = [
    'title' => constant('CO_' . $moduleDirNameUpper . '_' . 'BLOCKS'),
    'link' => 'admin/blocksadmin.php',
    'icon' => $pathIcon32 . '/block.png',
];

//Feedback
$adminmenu[] = [
    'title' => constant('CO_' . $moduleDirNameUpper . '_' . 'ADMENU_FEEDBACK'),
    'link'  => 'admin/feedback.php',
    'icon'  => $pathIcon32 . '/mail_foward.png',
];

if (is_object($helper->getModule()) && $helper->getConfig('displayDeveloperTools')) {
    $adminmenu[] = [
        'title' => constant('CO_' . $moduleDirNameUpper . '_' . 'ADMENU_MIGRATE'),
        'link' => 'admin/migrate.php',
        'icon' => $pathIcon32 . '/database_go.png',
    ];
}

$adminmenu[] = [
    'title' => _MI_EDITO_MENU_ABOUT,
    'link' => 'admin/about.php',
    'icon' => $pathIcon32 . '/about.png',
];



//headermenu
if (isset($xoopsModule)) {
    $headermenu[] = [
        'title' => '<img src="../assets/images/icon/home.gif" align="absmiddle" alt="' . _MI_EDITO_GOTO_INDEX . '">',
        'alt' => _MI_EDITO_GOTO_INDEX,
        'link' => '../',
    ];

    $headermenu[] = [
        'title' => '<img src="../assets/images/icon/submit.gif" align="absmiddle" alt="' . _MI_EDITO_SUBMIT . '">',
        'alt' => _MI_EDITO_SUBMIT,
        'link' => '../submit.php',
    ];

    $headermenu[] = [
        'title' => '<img src="../assets/images/icon/settings.gif" align="absmiddle" alt="' . _MI_EDITO_SETTINGS . '">',
        'alt' => _MI_EDITO_SETTINGS,
        'link' => '../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=' . $xoopsModule->getVar('mid'),
    ];

    $headermenu[] = [
        'title' => '<img src="../assets/images/icon/update.gif" align="absmiddle" alt="' . _MI_EDITO_UPDATE_MODULE . '">',
        'alt' => _MI_EDITO_UPDATE_MODULE,
        'link' => '../../system/admin.php?fct=modulesadmin&op=update&module=' . $xoopsModule->getVar('dirname'),
    ];

    $headermenu[] = [
        'title' => '<img src="../assets/images/icon/help.gif" align="absmiddle" alt="' . _MI_EDITO_HELP . '">',
        'alt' => _MI_EDITO_HELP,
        'link' => 'help.php',
    ];
}

// Utilities statmenu

$statmenu[] = [
    'title' => _MI_EDITO_UPLOAD,
    'link'  => 'admin/utils_uploader.php',
    'icon' => $pathIcon32 . '/home.png',
];

$statmenu[] = [
    'title' => _MI_EDITO_CLONE,
    'link'  => 'admin/utils_clone.php',
    'icon' => $pathIcon32 . '/home.png',
];

$statmenu[] = [
    'title' => _MI_EDITO_EXPORT,
    'link'  => 'admin/utils_export.php',
    'icon' => $pathIcon32 . '/home.png',
];

$statmenu[] = [
    'title' => _MI_EDITO_IMPORT,
    'link'  => 'admin/utils_import.php',
    'icon' => $pathIcon32 . '/home.png',
];

$statmenu[] = [
    'title' => _MI_EDITO_EDITORS,
    'link'  => 'admin/utils_wysiwyg.php',
    'icon' => $pathIcon32 . '/home.png',
];

$statmenu[] = [
    'title' => _MI_EDITO_HTACCESS,
    'link'  => 'admin/utils_htaccess.php',
    'icon' => $pathIcon32 . '/home.png',
];

