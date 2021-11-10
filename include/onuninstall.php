<?php
/*
 * You may not change or alter any portion of this comment or credits of
 * supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit
 * authors.
 *
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */
/**
 * Module: Edito
 *
 * @package  \XoopsModules\Edito\Install
 * @copyright  &copy; 2001-2021 {@link https://xoops.org XOOPS Project}
 * @license  {@link https://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU GPL 2}
 * @author  XOOPS Module Development Team
 * @since  3.1
 */

use XoopsModules\Edito\{
    Helper,
    Utility
};

/**
 * @internal {Make sure you PROTECT THIS FILE}
 */
if ((!defined('XOOPS_ROOT_PATH')) || !($GLOBALS['xoopsUser'] instanceof XoopsUser) || !($GLOBALS['xoopsUser']->isAdmin())) {
    die('Restricted access' . PHP_EOL);
}

/**
 * Prepare to uninstall module
 *
 * @param  \XoopsModule  $module
 * @return  bool  success
 */
function xoops_module_pre_uninstall_edito(\XoopsModule $module)
{
    // NOP
    return true;
}

/**
 * Performs tasks required during uninstallation of the module.
 *
 * @param  \XoopsModule  $module  {@link \XoopsModule}
 * @return  bool  true if uninstallation successful, false if not
 */
function xoops_module_uninstall_edito(\XoopsModule $module): bool
{
    $configurator = new Configurator();

    // Load language files
    /*
    $helper = Helper::getInstance();
    $helper->loadLanguage('admin');
    $helper->loadLanguage('common');
    */

    // Remove uploads folder (and all subfolders) if they exist
    $success = true;
    if (is_array($configurator->uploadFolders) && 0 < count($configurator->uploadFolders)) {
        foreach ($configurator->uploadFolders as $folder) {
            $success = $success && Utility::deleteDirectory($folder);
        }
    }

    /** @fixme Figure out why Utility::deleteDirectory doesn't return true when it should */
    //return true; // temporarily bypass $success value
    return $success;
    //------------ END  ----------------
}
