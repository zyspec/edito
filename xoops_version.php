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
 * @package   \XoopsModules\Edito
 * @copyright Copyright {@link https://xoops.org XOOPS Project}
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 * @author    Solo (http://www.wolfpackclan.com/wolfactory)
 * @author    DuGris (http://www.dugris.info)
 * @author    XOOPS Module Development Team
 * @link      https://github.com/XoopsModules25x/edito
 */

use XoopsModules\Edito;

include __DIR__ . '/preloads/autoloader.php';

require_once XOOPS_ROOT_PATH . '/modules/edito/include/functions_block.php';

$moduleDirName      = basename(__DIR__);
$moduleDirNameUpper = mb_strtoupper($moduleDirName);

/** @var \XoopsModules\Edito\Helper $helper */
$helper = \XoopsModules\Edito\Helper::getInstance();
$helper->loadLanguage('common');
$helper->loadLanguage('feedback');
$helper->loadLanguage('modinfo');

//InfoModule
/*  @var  array  $modversion */
$modversion = [
    'version'             => 3.10,
    'module_status'       => 'Alpha.2',
    'release_date'        => '2021/11/08',
    'name'                => _MI_EDITO_NAME,
    'description'         => _MI_EDITO_DESC,
    'official'            => 0, //1 indicates official XOOPS module supported by XOOPS Dev Team, 0 means 3rd party supported
    'author'              => 'Brandycoke Productions, Dylian Melgert, Juan Garcés',
    'author_website_url'  => 'https://xoops.org/',
    'author_website_name' => 'XOOPS',
    'credits'             => 'XOOPS Development Team: Black_beard, Cesag, Philou, Mamba, ZySpec',
    'license'             => 'GNU GPL 2.0 or later',
    'license_url'         => 'www.gnu.org/licenses/gpl-2.0.html',
    'image'               => 'assets/images/edito_slogo.png',
    'dirname'             => $moduleDirName,

    // ------------------- Folders & Files -------------------
    'release_info'        => 'Changelog',
    'release_file'        => XOOPS_URL . "/modules/$moduleDirName/docs/changelog.txt",

    'manual'              => 'link to manual file',
    'manual_file'         => XOOPS_URL . "/modules/$moduleDirName/docs/install.txt",
    // Local path icons
    'modicons16'          => 'assets/images/icons/16',
    'modicons32'          => 'assets/images/icons/32',
    //About
    'demo_site_url'       => 'https://xoops.org',
    'demo_site_name'      => 'XOOPS Demo Site',
    'support_url'         => 'https://xoops.org/modules/newbb/viewforum.php?forum=28/',
    'support_name'        => 'Support Forum',
    'submit_bug'          => 'https://github.com/XoopsModules25x/' . $moduleDirName . '/issues',
    'module_website_url'  => 'www.xoops.org',
    'module_website_name' => 'XOOPS Project',
    // ------------------- Min Requirements -------------------
    'min_php'             => '7.1',
    'min_xoops'           => '2.5.10',
    'min_admin'           => '1.2',
    'min_db'              => ['mysql' => '5.6', 'mysqli' => '5.6'],

    // ------------------- Mysql -----------------------------
    'sqlfile'             => ['mysql' => 'sql/mysql.sql'],
    // ------------------- Tables ----------------------------
    'tables'              => [
        $moduleDirName . '_' . 'content',
    ],
    // ------------------- Install/Update -------------------
    'onInstall'           => 'include/oninstall.php',
    'onUpdate'            => 'include/edito_update.php',
    'onUninstall'         => 'include/onuninstall.php',
    // -------------------  PayPal ---------------------------
    'paypal'              => [
        'business'      => 'xoopsfoundation@gmail.com',
        'item_name'     => 'Donation : ' . _MI_EDITO_NAME,
        'amount'        => 0,
        'currency_code' => 'USD'
    ],
    // ------------------- Search ---------------------------
    'hasSearch'           => 1,
    'search'              => [
        'file' => 'include/search.inc.php',
        'func' => 'edito_search'
    ],
    // ------------------- Comments -------------------------
    'hasComments'         => 1,
    'comments'            => [
        'pageName'     => 'content.php',
        'itemName'     => 'id',
        'callbackFile' => 'include/comment_functions.php',
        'callback'     => [
            'approve' => 'edito_comments_approve',
            'update'  => 'edito_comments_update'
        ],
    ],
    // ------------------- Notification ----------------------
    'hasNotification'     => 0,

    // ------------------- Admin -------------------------
    'hasAdmin'   => 1,
    'adminindex' => 'admin/index.php',
    'adminmenu'  => 'admin/menu.php',

    // ------------------- Help files ------------------- //
    'help'        => 'page=help',
    'helpsection' => [
        ['name' => _MI_EDITO_OVERVIEW, 'link' => 'page=help'],
        ['name' => _MI_EDITO_DISCLAIMER, 'link' => 'page=disclaimer'],
        ['name' => _MI_EDITO_LICENSE, 'link' => 'page=license'],
        ['name' => _MI_EDITO_SUPPORT, 'link' => 'page=support'],
    ],
    // ------------------- Menu ------------------- //
    'hasMain'     => 1,
];
if ($GLOBALS['xoopsModule'] && $GLOBALS['xoopsModule']->getVar('dirname') == $modversion['dirname']) {
    require_once XOOPS_ROOT_PATH . '/modules/edito/include/functions_content.php';
    $group = $GLOBALS['xoopsUser'] instanceof \XoopsUser ? $GLOBALS['xoopsUser']->getGroups() : [XOOPS_GROUP_ANONYMOUS];
    $i     = 0;

    // Menu admin links
    if (@defined('_MD_EDITO_ADD')) {
        if (count(array_intersect($group, $GLOBALS['xoopsModuleConfig']['submit_groups'])) > 0) {
            $modversion['sub'][$i]['name']  = '<img src="assets/images/icon/submit.gif" align="absmiddle" width="20px;" alt="' . _MD_EDITO_SUBMIT . '">&nbsp;<i>' . _MD_EDITO_SUBMIT . '</i></img>';
            $modversion['sub'][$i++]['url'] = 'submit.php';
        }

        if ($GLOBALS['xoopsUser'] instanceof \XoopsUser && $GLOBALS['xoopsUser']->isAdmin($GLOBALS['xoopsModule']->mid())) {
            $modversion['sub'][$i]['name']  = '<img src="assets/images/icon/add.gif" align="absmiddle" width="20px;" alt="' . _MD_EDITO_ADD . '">&nbsp;<i>' . _MD_EDITO_ADD . '</i></img>';
            $modversion['sub'][$i++]['url'] = 'admin/content.php';
            $modversion['sub'][$i]['name']  = '<img src="assets/images/icon/list.gif" align="absmiddle" width="20px;" alt="' . _MD_EDITO_LIST . '">&nbsp;<i>' . _MD_EDITO_LIST . '</i></img>';
            $modversion['sub'][$i++]['url'] = 'admin/index.php';
            $modversion['sub'][$i]['name']  = '<img src="assets/images/icon/utilities.gif" align="absmiddle" width="20px;" alt="' . _MD_EDITO_UTILITIES . '">&nbsp;<i>' . _MD_EDITO_UTILITIES . '</i></img>';
            $modversion['sub'][$i++]['url'] = 'admin/utils_uploader.php';
            $modversion['sub'][$i]['name']  = '<img src="assets/images/icon/settings.gif" align="absmiddle" width="20px;" alt="' . _MD_EDITO_SETTINGS . '">&nbsp;<i>' . _MD_EDITO_SETTINGS . '</i></img>';
            $modversion['sub'][$i++]['url'] = '../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=' . $GLOBALS['xoopsModule']->getVar('mid');
            $modversion['sub'][$i]['name']  = '<img src="assets/images/icon/blocks.gif" align="absmiddle" width="20px;" alt="' . _MD_EDITO_BLOCKS . '">&nbsp;<i>' . _MD_EDITO_BLOCKS . '</i></img>';
            $modversion['sub'][$i++]['url'] = 'admin/blocks.php';
        }
    }

    // Display menu pages list
	// Start comment here to not display pages'list
    $sql = "SELECT id, subject, meta, groups FROM " . $GLOBALS['xoopsDB']->prefix($modversion['dirname'] . '_content') . "
            WHERE state >= 3 ORDER BY " . edito_getmoduleoption('order');

    $result = $GLOBALS['xoopsDB']->queryF($sql, edito_getmoduleoption('perpage'), 0);

    //	$group = $GLOBALS['xoopsUser'] instanceof \XoopsUser ? $GLOBALS['xoopsUser']->getGroups() : [XOOPS_GROUP_ANONYMOUS];
    while (list($id, $subject, $meta, $groups) = $GLOBALS['xoopsDB']->fetchRow($result)) {
        $groups = explode(' ', $groups);
        if (count(array_intersect($group, $groups))) {
            $meta             = explode('|', $meta);
            $meta_title       = $meta[0];
            $meta_description = $meta[1];

            $link = edito_createlink('content.php?id=' . $id, $subject, '', '', '', '', '', $meta_title, $GLOBALS['xoopsModuleConfig']['url_rewriting']);
            $link = explode('"', $link);
            if ($link[1]) {
                $link = $link[1];
            } else {
                $link = 'content.php?id=' . $id;
            }
            $modversion['sub'][$i]['name']  = $subject;
            $modversion['sub'][$i++]['url'] = $link;
        } // Groups
    } // While
    // End comment here to not display pages'list
}  // Active module

// ------------------- Templates ------------------- //
$modversion['templates'] = [
    // Header and footer
    ['file'        => 'edito_head.tpl',
     'description' => ''],
    ['file'        => 'edito_foot.tpl',
     'description' => ''],
    // Index templates
    ['file'        => 'edito_index.tpl',
    'description'  => ''],
    ['file'        => 'edito_index_ext.tpl',
     'description' => ''],
    ['file'        => 'edito_index_news.tpl',
     'description' => ''],
    ['file'        => 'edito_index_blog.tpl',
     'description' => ''],
    // Pages templates
    ['file'        => 'edito_content_index.tpl',
     'description' => ''],
    ['file'        => 'edito_content_item.tpl',
     'description' => ''],
    ['file'        => 'edito_content_html.tpl',
     'description' => ''],
    ['file'        => 'edito_content_php.tpl',
     'description' => ''],
    // Content blocks templates
    ['file'        => 'edito_block_content.tpl',
     'description' => ''],
    // Menu blocks templates
    ['file'        => 'edito_block_menu.tpl',
     'description' => ''],
    ['file'        => 'edito_block_image.tpl',
     'description' => ''],
    ['file'        => 'edito_block_list.tpl',
     'description' => ''],
    ['file'        => 'edito_block_ext.tpl',
     'description' => ''],
    // Submit template
    ['file'        => 'edito_content_submit.tpl',
     'description' => ''],
    // Breadcrumb template
    ['file'        => 'edito_common_breadcrumb.tpl',
     'description' => ''],
];

// Blocks
$modversion['blocks'] = [
    ['file'        => 'content.php',
     'name'        => _MI_EDITO_BLOCNAME_01,
     'description' => '',
     'show_func'   => 'a_edito_show',
     'edit_func'   => 'a_edito_edit',
     'options'     => '512|1|1|0|',
     'template'    => 'edito_block_01.tpl'],

    ['file'        => 'content.php',
     'name'        => _MI_EDITO_BLOCNAME_02,
     'description' => '',
     'show_func'   => 'a_edito_show',
     'edit_func'   => 'a_edito_edit',
     'options'     => '512|random|1|0|',
     'template'    => 'edito_block_02.tpl'],

    ['file'        => 'content.php',
     'name'        => _MI_EDITO_BLOCNAME_03,
     'description' => '',
     'show_func'   => 'a_edito_show',
     'edit_func'   => 'a_edito_edit',
     'options'     => '512|latest|1|0|10',
     'template'    => 'edito_block_03.tpl'],

    ['file'        => 'content.php',
     'name'        => _MI_EDITO_BLOCNAME_04,
     'description' => '',
     'show_func'   => 'a_edito_show',
     'edit_func'   => 'a_edito_edit',
     'options'     => '512|read|1|0|',
     'template'    => 'edito_block_04.tpl'],

    ['file'        => 'content.php',
     'name'        => _MI_EDITO_BLOCNAME_05,
     'description' => '',
     'show_func'   => 'a_edito_menu_show',
     'edit_func'   => 'a_edito_menu_edit',
     'options'     => 'menu|120-120|1|subject ASC|6',
     'template'    => 'edito_menu_block_01.tpl'],

    ['file'        => 'content.php',
     'name'        => _MI_EDITO_BLOCNAME_06,
     'description' => '',
     'show_func'   => 'a_edito_menu_show',
     'edit_func'   => 'a_edito_menu_edit',
     'options'     => 'menu|120-120|1|subject ASC|6',
     'template'    => 'edito_menu_block_02.tpl'],
];

// Module options
$modversion['config'] = [
    ['name'        => 'index_logo',
     'title'       => '_MI_EDITO_INDEX_LOGO',
     'description' => '_MI_EDITO_INDEX_LOGODSC',
     'formtype'    => 'textbox',
     'valuetype'   => 'text',
     'default'     => 'modules/edito/assets/images/logo.gif'],

    ['name'        => 'textindex',
     'title'       => '_MI_EDITO_TEXTINDEX',
     'description' => '_MI_EDITO_TEXTINDEXDSC',
     'formtype'    => 'textarea',
     'valuetype'   => 'text',
     'default'     => _MI_EDITO_WELCOME],

    ['name'        => 'informations',
     'title'       => '_MI_EDITO_DEFAULTEXT',
     'description' => '_MI_EDITO_DEFAULTEXTDSC',
     'formtype'    => 'textarea',
     'valuetype'   => 'text',
     'default'     => _MI_EDITO_DEFAULTEXTEXP],

    ['name'        => 'footer',
     'title'       => '_MI_EDITO_FOOTERTEXT',
     'description' => '_MI_EDITO_FOOTERTEXTDSC',
     'formtype'    => 'textarea',
     'valuetype'   => 'text',
     'default'     => _MI_EDITO_FOOTER],

    ['name'        => 'index_display',
     'title'       => '_MI_EDITO_INDEX_DISP',
     'description' => '_MI_EDITO_INDEX_DISPDSC',
     'formtype'    => 'select',
     'valuetype'   => 'text',
     'default'     => 'image',
     'options'     => [
        '_MI_EDITO_INDEX_DISP_IMAGE' => 'image',
        '_MI_EDITO_INDEX_DISP_TABLE' => 'table',
        '_MI_EDITO_INDEX_DISP_BLOG'  => 'blog',
        '_MI_EDITO_INDEX_DISP_NEWS'  => 'news',
     ]],

    ['name'        => 'columns',
     'title'       => '_MI_EDITO_COLUMNS',
     'description' => '_MI_EDITO_COLUMNSDSC',
     'formtype'    => 'select',
     'valuetype'   => 'int',
     'default'     => 2,
     'options'     => [
        '1' => 1,
        '2' => 2,
        '3' => 3,
        '4' => 4,
        '5' => 5,
    ]],

    ['name'        => 'order',
     'title'       => '_MI_EDITO_ORD',
     'description' => '_MI_EDITO_ORDDSC',
     'formtype'    => 'select',
     'valuetype'   => 'text',
     'default'     => 'subject ASC',
     'options'     => [
        '_MI_EDITO_ORD_SUBJ_ASC'  => 'subject ASC',
        '_MI_EDITO_ORD_DATE_DESC' => 'datesub DESC',
        '_MI_EDITO_ORD_READ_DESC' => 'counter DESC',
    ]],

    ['name'        => 'perpage',
     'title'       => '_MI_EDITO_PERPAGE',
     'description' => '_MI_EDITO_PERPAGEDSC',
     'formtype'    => 'select',
     'valuetype'   => 'int',
     'default'     => 10,
     'options'     => [
        '6'  => 6,
        '10' => 10,
        '16' => 16,
        '20' => 20,
        '26' => 26,
        '30' => 30,
        '50' => 50,
    ]],

    ['name'        => 'logo_size',
     'title'       => '_MI_EDITO_LOGOWIDTH',
     'description' => '_MI_EDITO_LOGOWIDTHDSC',
     'formtype'    => 'textbox',
     'valuetype'   => 'text',
     'default'     => '160|160'],

    ['name'        => 'logo_align',
     'title'       => '_MI_EDITO_LOGO_ALIGN',
     'description' => '_MI_EDITO_LOGO_ALIGNDSC',
     'formtype'    => 'select',
     'valuetype'   => 'text',
     'default'     => 'center',
     'options'     => [
        '_MI_EDITO_LOGO_ALIGN_LEFT'   => 'left',
        '_MI_EDITO_LOGO_ALIGN_CENTER' => 'center',
        '_MI_EDITO_LOGO_ALIGN_RIGHT'  => 'right',
    ]],

    ['name'        => 'adminhits',
     'title'       => '_MI_EDITO_ADMINHITS',
     'description' => '_MI_EDITO_ADMINHITSDSC',
     'formtype'    => 'yesno',
     'valuetype'   => 'int',
     'default'     => 0],

/*
    ['name'        =>  'maxfilesize',
     'title'       =>  "_MI_EDITO_MAXFILESIZE",
     'description' =>  "_MI_EDITO_MAXFILESIZEDSC",
     'formtype'    =>  'textbox',
     'valuetype'   =>  'int',
     'default'     =>  250000],
*/

    ['name'        => 'maximgsize',
     'title'       => '_MI_EDITO_IMGSIZE',
     'description' => '_MI_EDITO_IMGSIZEDSC',
     'formtype'    => 'textbox',
     'valuetype'   => 'text',
     'default'     => '800|600|250000'],

    ['name'        => 'sbuploaddir',
     'title'       => '_MI_EDITO_UPLOADDIR',
     'description' => '_MI_EDITO_UPLOADDIRDSC',
     'formtype'    => 'textbox',
     'valuetype'   => 'text',
     'default'     => 'uploads/' . $modversion['dirname'] . '/images'],

    ['name'        => 'sbmediadir',
     'title'       => '_MI_EDITO_MEDIADIR',
     'description' => '_MI_EDITO_MEDIADIRDSC',
     'formtype'    => 'textbox',
     'valuetype'   => 'text',
     'default'     => 'uploads/' . $modversion['dirname'] . '/media'],

    ['name'        => 'downloadable',
     'title'       => '_MI_EDITO_DWNL',
     'description' => '_MI_EDITO_DWNLDSC',
     'formtype'    => 'yesno',
     'valuetype'   => 'int',
     'default'     => 0],
];

if ( $GLOBALS['xoopsModule'] && $GLOBALS['xoopsModule'] -> getVar( 'dirname' ) == 'system' ) {
    /** @var  \XoopsMemberHandler  $memberHandler */
	$memberHandler = xoops_getHandler('member');
	$xoopsgroups    = $memberHandler->getGroupList();
	foreach ($xoopsgroups as $key=>$group) {
		$groups[$group] = $key;
	}
	$def_group[1] = 1;

    $modversion['config'][] = [
        'name'        => 'groups',
        'title'       => '_MI_EDITO_OPT_GRPS',
        'description' => '_MI_EDITO_OPT_GRPSDSC',
        'formtype'    => 'select_multi',
        'valuetype'   => 'array',
        'options'     => $groups,
        'default'     => $groups,
    ];

    $modversion['config'][] = [
        'name'        => 'submit_groups',
        'title'       => '_MI_EDITO_SUB_GRPS',
        'description' => '_MI_EDITO_SUB_GRPSDSC',
        'formtype'    => 'select_multi',
        'valuetype'   => 'array',
        'options'     => $groups,
        'default'     => $def_group,
    ];
}

$modversion['config'][] = [
    'name'        => 'option_block',
    'title'       => '_MI_EDITO_OPT_BLOCK',
    'description' => '_MI_EDITO_OPT_BLOCKDSC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];

$modversion['config'][] = [
    'name'        => 'option_title',
    'title'       => '_MI_EDITO_OPT_TITLE',
    'description' => '_MI_EDITO_OPT_TITLEDSC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];

$modversion['config'][] = [
    'name'        => 'option_logo',
    'title'       => '_MI_EDITO_OPT_LOGO',
    'description' => '_MI_EDITO_OPT_LOGODSC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];

$modversion['config'][] = [
    'name'        => 'cancomment',
    'title'       => '_MI_EDITO_OPT_COMMENT',
    'description' => '_MI_EDITO_OPT_COMMENTDSC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];

//* Editor to Use
xoops_load('xoopslists');
$modversion['config'][] = [
    'name'        => 'wysiwyg',
    'title'       => '_MI_EDITO_WYSIWYG',
    'description' => '_MI_EDITO_WYSIWYGDSC',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'options'     => XoopsLists::getDirListAsArray($GLOBALS['xoops']->path('/class/xoopseditor')),
    'default'     => 'dhtmltextarea'
];

/*
$modversion['config'][] = [
    'name'        => 'wysiwyg',
    'title'       => '_MI_EDITO_WYSIWYG',
    'description' => '_MI_EDITO_WYSIWYGDSC',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'default'     => 'dhtml',
    'options'     => [
        _MI_EDITO_FORM_DHTML      => 'dhtml',
        _MI_EDITO_FORM_COMPACT    => 'textarea',
        _MI_EDITO_FORM_SPAW       => 'spaw',
        _MI_EDITO_FORM_HTMLAREA   => 'htmlarea',
        _MI_EDITO_FORM_KOIVI      => 'koivi',
        _MI_EDITO_FORM_FCK        => 'fck',
        _MI_EDITO_FORM_INBETWEEN  => 'inbetween',
        _MI_EDITO_FORM_TINYEDITOR => 'tinyeditor'
    ],
];
*/
$modversion['config'][] = [
    'name'        => 'tags',
    'title'       => '_MI_EDITO_TAGS',
    'description' => '_MI_EDITO_TAGSDSC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];

$modversion['config'][] = [
    'name'        => 'tags_new',
    'title'       => '_MI_EDITO_TAGS_NEW',
    'description' => '_MI_EDITO_TAGS_NEWDSC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 7,
];

$modversion['config'][] = [
    'name'        => 'tags_pop',
    'title'       => '_MI_EDITO_TAGS_POP',
    'description' => '_MI_EDITO_TAGS_POPDSC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 100,
];

$modversion['config'][] = [
    'name'        => 'metamanager',
    'title'       => '_MI_EDITO_META_MANAGER',
    'description' => '_MI_EDITO_META_MANAGERDSC',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'default'     => 'auto',
    'options'     => [
        '_MI_EDITO_META_MANUAL' => 'manual',
        '_MI_EDITO_META_SEMI'   => 'semi',
        '_MI_EDITO_META_AUTO'   => 'auto',
    ],
];

$modversion['config'][] = [
    'name'        => 'moduleMetaDescription',
    'title'       => '_MI_EDITO_META_DESC',
    'description' => '_MI_EDITO_META_DESCDSC',
    'formtype'    => 'textarea',
    'valuetype'   => 'text',
    'default'     => '',
];

$modversion['config'][] = [
    'name'        => 'moduleMetaKeywords',
    'title'       => '_MI_EDITO_META_KEYW',
    'description' => '_MI_EDITO_META_KEYWDSC',
    'formtype'    => 'textarea',
    'valuetype'   => 'text',
    'default'     => '',
];

$modversion['config'][] = [
    'name'        => 'index_content',
    'title'       => '_MI_EDITO_INDEX_CONTENT',
    'description' => '_MI_EDITO_INDEX_CONTENTDSC',
    'formtype'    => 'textbox',
    'valuetype'   => 'text',
    'default'     => '',
];

$modversion['config'][] = [
    'name'        => 'navlink_type',
    'title'       => '_MI_EDITO_NAV_LINKS',
    'description' => '_MI_EDITO_NAV_LINKSDSC',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'default'     => 'list',
    'options'     => [
        '_MI_EDITO_NAV_LINKS_NONE'  => 'none',
        '_MI_EDITO_NAV_LINKS_BLOCK' => 'bloc',
        '_MI_EDITO_NAV_LINKS_LIST'  => 'list',
        '_MI_EDITO_NAV_LINKS_PATH'  => 'path',
    ],
];

$modversion['config'][] = [
    'name'        => 'url_rewriting',
    'title'       => '_MI_EDITO_REWRITING',
    'description' => '_MI_EDITO_REWRITINGDSC',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'default'     => '0',
    'options'     => [
        '_MI_EDITO_URW_NONE'  => '0',
        '_MI_EDITO_URW_MIN_3' => '3',
        '_MI_EDITO_URW_MIN_5' => '5',
        '_MI_EDITO_URW_ALL'   => '1',
    ],
];

$modversion['config'][] = [
    'name'        => 'media_display',
    'title'       => '_MI_EDITO_MEDIA_DISP',
    'description' => '_MI_EDITO_MEDIA_DISPDSC',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'default'     => 'both',
    'options'     => [
        '_MI_EDITO_MEDIA_POPUP' => 'popup',
        '_MI_EDITO_MEDIA_PAGE'  => 'page',
        '_MI_EDITO_MEDIA_BOTH'  => 'both',
    ],
];

$modversion['config'][] = [
    'name'        => 'custom',
    'title'       => '_MI_EDITO_CUSTOM',
    'description' => '_MI_EDITO_CUSTOMDSC',
    'formtype'    => 'textbox',
    'valuetype'   => 'text',
    'default'     => '480|360',
];

$modversion['config'][] = [
    'name'        => 'custom_media',
    'title'       => '_MI_EDITO_CUSTOM_MEDIA',
    'description' => '_MI_EDITO_CUSTOM_MEDIADSC',
    'formtype'    => 'textbox',
    'valuetype'   => 'text',
    'default'     => '.asp|.php',
];

$modversion['config'][] = [
    'name'        => 'repeat',
    'title'       => '_MI_EDITO_REPEAT',
    'description' => '_MI_EDITO_REPEATDSC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];

$modversion['config'][] = [
    'name'        => 'media_size',
    'title'       => '_MI_EDITO_MEDIA_SIZE',
    'description' => '_MI_EDITO_MEDIA_SIZEDSC',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'default'     => 'medium',
    'options'     => [
        '_MI_EDITO_SIZE_DEFAULT'  => 'default',
        '_MI_EDITO_SIZE_CUSTOM'   => 'custom',
        '_MI_EDITO_SIZE_TVSMALL'  => 'tv_small',
        '_MI_EDITO_SIZE_TVMEDIUM' => 'tv_medium',
        '_MI_EDITO_SIZE_TVBIG'    => 'tv_big',
        '_MI_EDITO_SIZE_MVSMALL'  => 'mv_small',
        '_MI_EDITO_SIZE_MVMEDIUM' => 'mv_medium',
        '_MI_EDITO_SIZE_MVBIG'    => 'mv_big',
    ],
];

// default admin editor
xoops_load('XoopsEditorHandler');
$editorHandler = \XoopsEditorHandler::getInstance();
$editorList    = array_flip($editorHandler->getList());

$modversion['config'][] = [
    'name'        => 'editorAdmin',
    'title'       => '_MI_EDITO_EDITOR_ADMIN',
    'description' => '_MI_EDITO_EDITOR_ADMIN_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'default'     => 'dhtmltextarea',
    'options'     => $editorList,
];

$modversion['config'][] = [
    'name'        => 'editorUser',
    'title'       => '_MI_EDITO_EDITOR_USER',
    'description' => '_MI_EDITO_EDITOR_USER_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'default'     => 'dhtmltextarea',
    'options'     => $editorList,
];

/**
 * Make Sample button visible?
 */
$modversion['config'][] = [
    'name'        => 'displaySampleButton',
    'title'       => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLE_BUTTON',
    'description' => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLE_BUTTON_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];

/**
 * Show Developer Tools?
 */
$modversion['config'][] = [
    'name'        => 'displayDeveloperTools',
    'title'       => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_DEV_TOOLS',
    'description' => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_DEV_TOOLS_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 0,
];

// MimeTypes
$modversion['mimetypes'][] = [
    'mime_ext'        => 'gif',
    'mime_types'      => 'image/gif',
    'mime_name'       => 'Graphic Interchange Format',
    'mime_status'     => 1,    // 1 = visible - 0 = hidden
    'mperm_maxwidth'  => 240,
    'mperm_maxheight' => 240,
    'mperm_maxsize'   => 100000,
];

$modversion['mimetypes'][] = [
    'mime_ext'        => 'jpg',
    'mime_types'      => 'image/jpeg',
    'mime_name'       => 'JPEG/JIFF Image',
    'mime_status'     => 1,    // 1 = visible - 0 = hidden
    'mperm_maxwidth'  => 240,
    'mperm_maxheight' => 240,
    'mperm_maxsize'   => 100000,
];

$modversion['mimetypes'][] = [
    'mime_ext'        => 'png',
    'mime_types'      => 'image/png',
    'mime_name'       => 'Portable (Public) Network Graphic',
    'mime_status'     => 1,    // 1 = visible - 0 = hidden
    'mperm_maxwidth'  => 240,
    'mperm_maxheight' => 240,
    'mperm_maxsize'   => 100000,
];


$modversion['mimetypes'][] = [
    'mime_ext'        => 'webp',
    'mime_types'      => 'image/webp',
    'mime_name'       => 'Web Picture',
    'mime_status'     => 1,    // 1 = visible - 0 = hidden
    'mperm_maxwidth'  => 240,
    'mperm_maxheight' => 240,
    'mperm_maxsize'   => 100000,
];

$modversion['mimetypes'][] = [
    'mime_ext'        => 'aiff',
    'mime_types'      => 'audio/aiff',
    'mime_name'       => 'Audio Interchange File',
    'mime_status'     => 1,    // 1 = visible - 0 = hidden
    'mperm_maxwidth'  => 320,
    'mperm_maxheight' => 240,
    'mperm_maxsize'   => 500000,
];

$modversion['mimetypes'][] = [
    'mime_ext'        => 'mid',
    'mime_types'      => 'audio/mid',
    'mime_name'       => 'Musical Instrument Digital Interface MIDI-sequention Sound',
    'mime_status'     => 1,    // 1 = visible - 0 = hidden
    'mperm_maxwidth'  => 320,
    'mperm_maxheight' => 240,
    'mperm_maxsize'   => 500000,
];

$modversion['mimetypes'][] = [
    'mime_ext'        => 'mpg',
    'mime_types'      => 'audio/mpeg|video/mpeg',
    'mime_name'       => 'MPEG 1 System Stream',
    'mime_status'     => 1,    // 1 = visible - 0 = hidden
    'mperm_maxwidth'  => 320,
    'mperm_maxheight' => 240,
    'mperm_maxsize'   => 500000,
];

$modversion['mimetypes'][] = [
    'mime_ext'        => 'wav',
    'mime_types'      => 'audio/wav',
    'mime_name'       => 'Waveform Audio',
    'mime_status'     => 1,    // 1 = visible - 0 = hidden
    'mperm_maxwidth'  => 320,
    'mperm_maxheight' => 240,
    'mperm_maxsize'   => 500000,
];

$modversion['mimetypes'][] = [
    'mime_ext'        => 'vma',
    'mime_types'      => 'audio/x-ms-wma',
    'mime_name'       => 'Windows Media Audio File',
    'mime_status'     => 1,    // 1 = visible - 0 = hidden
    'mperm_maxwidth'  => 320,
    'mperm_maxheight' => 240,
    'mperm_maxsize'   => 500000,
];

$modversion['mimetypes'][] = [
    'mime_ext'        => 'asf',
    'mime_types'      => 'video/x-ms-asf',
    'mime_name'       => 'Advanced Streaming Format',
    'mime_status'     => 1,    // 1 = visible - 0 = hidden
    'mperm_maxwidth'  => 320,
    'mperm_maxheight' => 240,
    'mperm_maxsize'   => 500000,
];

$modversion['mimetypes'][] = [
    'mime_ext'        => 'avi',
    'mime_types'      => 'video/avi',
    'mime_name'       => 'Audio Video Interleave File',
    'mime_status'     => 1,    // 1 = visible - 0 = hidden
    'mperm_maxwidth'  => 320,
    'mperm_maxheight' => 240,
    'mperm_maxsize'   => 500000,
];

$modversion['mimetypes'][] = [
    'mime_ext'        => 'wmv',
    'mime_types'      => 'video/x-ms-wmv',
    'mime_name'       => 'Windows Media File',
    'mime_status'     => 1,    // 1 = visible - 0 = hidden
    'mperm_maxwidth'  => 320,
    'mperm_maxheight' => 240,
    'mperm_maxsize'   => 500000,
];

$modversion['mimetypes'][] = [
    'mime_ext'        => 'vmx',
    'mime_types'      => 'video/x-ms-wmx',
    'mime_name'       => 'Windows Media Redirector',
    'mime_status'     => 1,    // 1 = visible - 0 = hidden
    'mperm_maxwidth'  => 320,
    'mperm_maxheight' => 240,
    'mperm_maxsize'   => 500000,
];

$modversion['mimetypes'][] = [
    'mime_ext'        => 'qt',
    'mime_types'      => 'video/quicktime',
    'mime_name'       => 'QuickTime Movie',
    'mime_status'     => 1,    // 1 = visible - 0 = hidden
    'mperm_maxwidth'  => 320,
    'mperm_maxheight' => 240,
    'mperm_maxsize'   => 500000,
];

$modversion['mimetypes'][] = [
    'mime_ext'        => 'swf',
    'mime_types'      => 'application/x-shockwave-flash',
    'mime_name'       => 'Macromedia Flash Format File',
    'mime_status'     => 1,    // 1 = visible - 0 = hidden
    'mperm_maxwidth'  => 320,
    'mperm_maxheight' => 240,
    'mperm_maxsize'   => 500000,
];

$modversion['mimetypes'][] = [
    'mime_ext'        => 'ra',
    'mime_types'      => 'audio/vnd.rn-realaudio',
    'mime_name'       => 'RealMedia Streaming Media',
    'mime_status'     => 1,    // 1 = visible - 0 = hidden
    'mperm_maxwidth'  => 320,
    'mperm_maxheight' => 240,
    'mperm_maxsize'   => 500000,
];

$modversion['mimetypes'][] = [
    'mime_ext'        => 'ram',
    'mime_types'      => 'audio/x-pn-realaudio',
    'mime_name'       => 'RealMedia Metafile',
    'mime_status'     => 1,    // 1 = visible - 0 = hidden
    'mperm_maxwidth'  => 320,
    'mperm_maxheight' => 240,
    'mperm_maxsize'   => 500000,
];

$modversion['mimetypes'][] = [
    'mime_ext'        => 'rm',
    'mime_types'      => 'application/vnd.rn-realmedia',
    'mime_name'       => 'RealMedia Streaming Media',
    'mime_status'     => 1,    // 1 = visible - 0 = hidden
    'mperm_maxwidth'  => 320,
    'mperm_maxheight' => 240,
    'mperm_maxsize'   => 500000,
];
