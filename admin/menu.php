<?php

declare(strict_types=1);

/**
 * Module: Edito
 *
 * @package   \XoopsModules\Edito
 * @copyright  &copy; 2000-2021 {@link https://xoops.org XOOPS Project}
 * @license  {@link https://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU GPL 2}
 * @author  Solo (http://www.wolfpackclan.com/wolfactory)
 * @author  DuGris (http://www.dugris.info)
 * @author  XOOPS Module Development Team
 * @link  https://github.com/XoopsModules25x/edito
 */

use Xmf\{
    Module\Admin,
    Request
};
use XoopsModules\Edito\Helper;

include dirname(__DIR__) . '/preloads/autoloader.php';

$moduleDirName      = basename(dirname(__DIR__));
$moduleDirNameUpper = mb_strtoupper($moduleDirName);

/** @var \XoopsModules\Edito\Helper $helper */
$helper = Helper::getInstance();
$helper->loadLanguage('common');
$helper->loadLanguage('feedback');

$pathIcon32 = Admin::menuIconPath('');
if (is_object($helper->getModule())) {
    //    $pathModIcon32 = $helper->getModule()->getInfo('modicons32');
    $pathModIcon32 = $helper->url($helper->getModule()->getInfo('modicons32'));
}

$id = Request::getInt('id', 0);
$op = Request::getCmd('op', '');

if (preg_match('/_ok/', $op)) {
    $adminmenu[] = [
        'title'	=> _MI_EDITO_INDEX,
        'link'	=> 'index.php',
        'desc'  => _MI_EDITO_INDEX_DESC,
        'icon'  => \Xmf\Module\Admin::menuIconPath('home.png')
    ];
}

$adminmenu[] = [
    'title' => _MI_EDITO_LIST,
    'link'  => 'admin/index.php',
    'desc'  => _MI_EDITO_LIST_DESC,
    'icon'  => Admin::menuIconPath('content.png')
];
$adminmenu[] = [
    'title' => _MI_EDITO_CREATE,
    'link'  => 'admin/content.php',
    'desc'  => _MI_EDITO_CREATE_DESC,
    'icon'  => Admin::menuIconPath('add.png')
];
if (0 < $id) {
    $adminmenu[] = [
        'title' => _MI_EDITO_SEE,
        'link'  => "content.php?id={$id}",
        'desc'  => _MI_EDITO_SEE_DESC,
        'icon'  => Admin::menuIconPath('album.png')
    ];
}

$adminmenu[] = [
    'title'	=> _MI_EDITO_UTILITIES,
    'link'  => 'admin/utils_uploader.php',
    'desc'  => _MI_EDITO_UTILITIES_DESC,
    'icon'  => Admin::menuIconPath('administration.png')
];
$adminmenu[] = [
    'title' => _MI_EDITO_BLOCKS_GRPS,
    'link'  => "admin/blocks.php",
    'desc'  => _MI_EDITO_BLOCKS_DESC,
    'icon'  => Admin::menuIconPath('block.png')
];

// Blocks Admin
$adminmenu[] = [
    'title' => constant('CO_' . $moduleDirNameUpper . '_' . 'BLOCKS'),
    'link'  => 'admin/blocksadmin.php',
    'desc'  => '',
    'icon'  => $pathIcon32 . '/block.png',
];

include_once( XOOPS_ROOT_PATH . '/class/uploader.php');
if (defined('_XI_MIMETYPE')) {
	$adminmenu[] = [
	    'title' => _MI_EDITO_MIMETYPES,
        'link'  => 'admin/mimetypes.php',
	    'desc'  => _MI_EDITO_MIMETYPES_DESC,
	    'icon'  => Admin::menuIconPath('metagen.png')
    ];
}

//Feedback
$adminmenu[] = [
    'title' => constant('CO_' . $moduleDirNameUpper . '_' . 'ADMENU_FEEDBACK'),
    'link'  => 'admin/feedback.php',
    'desc'  => '',
    'icon'  => $pathIcon32 . '/mail_foward.png',
];

//Migration
if (is_object($helper->getModule()) && $helper->getConfig('displayDeveloperTools')) {
    $adminmenu[] = [
        'title' => constant('CO_' . $moduleDirNameUpper . '_' . 'ADMENU_MIGRATE'),
        'link' => 'admin/migrate.php',
        'desc'  => '',
        'icon' => $pathIcon32 . '/database_go.png',
    ];
}

$adminmenu[] = [
    'title' => _MI_EDITO_MENU_ABOUT,
    'link'  => 'admin/about.php',
    'desc'  => '',
    'icon'  => $pathIcon32 . '/about.png',
];

// Utilities
$statmenu = [
    ['title' => _MI_EDITO_UPLOAD,
     'link'  => 'admin/utils_uploader.php'],
    ['title' => _MI_EDITO_CLONE,
     'link'  => 'admin/utils_clone.php'],
    ['title' => _MI_EDITO_EXPORT,
     'link'  => 'admin/utils_export.php'],
    ['title' => _MI_EDITO_IMPORT,
     'link'  => 'admin/utils_import.php'],
    ['title' => _MI_EDITO_EDITORS,
     'link'  => 'admin/utils_wysiwyg.php'],
    ['title' => _MI_EDITO_HTACCESS,
     'link'  => 'admin/utils_htaccess.php']
];
