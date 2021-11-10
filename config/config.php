<?php
/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright  &copy; 2000-2021 {@link https://xoops.org XOOPS Project}
 * @license  {@link https://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU GPL 2}
 * @package  \XoopsModules\Edito
 * @author  XOOPS Development Team
 * @since  3.1
 */

$moduleDirName      = basename(dirname(__DIR__));
$moduleDirNameUpper = mb_strtoupper($moduleDirName);
$helper = \Xmf\Module\Helper::getHelper($moduleDirName);

return (object)[
    'name'           => mb_strtoupper($moduleDirName) . ' ModuleConfigurator',
    'paths'          => [
        'dirname'    => $moduleDirName,
        'admin'      => XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . '/admin',
        'modPath'    => XOOPS_ROOT_PATH . '/modules/' . $moduleDirName,
        'modUrl'     => XOOPS_URL . '/modules/' . $moduleDirName,
        'uploadPath' => XOOPS_UPLOAD_PATH . '/' . $moduleDirName,
        'uploadUrl'  => XOOPS_UPLOAD_URL . '/' . $moduleDirName,
    ],
    'uploadFolders'  => [
        XOOPS_UPLOAD_PATH . '/' . $moduleDirName,
        XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/images',
        XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/media',
        //XOOPS_UPLOAD_PATH . '/flags'
    ],
    'copyBlankFiles' => [
        //XOOPS_UPLOAD_PATH . '/' . $moduleDirName,
        XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/images',
        XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/media',
    ],

    'copyTestFolders' => [
        [
            XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . '/testdata/uploads',
            XOOPS_UPLOAD_PATH . '/' . $moduleDirName,
        ],
        //            [
        //                XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . '/testdata/thumbs',
        //                XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/thumbs',
        //            ],
    ],

    'templateFolders' => [
        '/templates/',
        '/templates/blocks/',
        //'/templates/admin/'
    ],
    'oldFiles'        => [
        'admin/blocks/index.html',
        'admin/index.html',
        'assets/images/icon/index.html',
        'assets/js/index.html',
        'blocks/index.html',
        'class/index.html',
        'docs/htaccess/index.html',
        'docs/index.html',
        'include/index.html',
        'language/english/help.html',
        'language/english/index.html',
        '/language/index.html',
        'sql/index.html',
        'templates/blocks/index.html',
        'templates/index.html',
        //'/include/constants.php',
        //'/include/functions.php',
        'include/updateblock.inc.php',
    ],
    'oldFolders'      => [
        '/images',
        '/css',
    ],
    //  'oldTableName'     => 'newTableName',
    'renameTables' => [
        'content_edito' => 'edito_content'
    ],
    // Fix column name(s)
    // syntax: ['tableName' => ['from' => 'oldColumn', 'to' =>'newColumn', ...]
    'renameColumns' => [
        'edito_content' => ['from' => 'status', 'to' => 'state']
    ],
    'moduleStats'  => [
        //            'totalcategories' => $helper->getHandler('Category')->getCategoriesCount(-1),
        //            'totalitems'      => $helper->getHandler('Content')->getCount(),
        //            'totalsubmitted'  => $helper->getHandler('Item')->getItemsCount(-1, [Constants::PUBLISHER_STATUS_SUBMITTED]),
    ],
    'modCopyright' => "<a href='https://xoops.org' title='XOOPS Project' target='_blank'>
                     <img src='" . \Xmf\Module\Admin::iconUrl('xoopsmicrobutton.gif') . "' alt='XOOPS Project'></a>",
];

