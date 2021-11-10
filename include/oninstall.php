<?php
/*
 * You may not change or alter any portion of this comment or credits of
 * supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit
 * authors.
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
    Common\Configurator,
    Helper,
    Utility
};

defined('XOOPS_ROOT_PATH') || die('Restricted access');
require_once dirname(__DIR__) . '/preloads/autoloader.php';
/**
 * @internal Make sure you PROTECT THIS FILE
 */
if (!($GLOBALS['xoopsUser'] instanceof \XoopsUser) || !($GLOBALS['xoopsUser']->isAdmin())) {
    die("Restricted access" . PHP_EOL);
}

/**
 * Prepares system prior to attempting to install module
 *
 * @param  \XoopsModule  $module  {@see \XoopsModule}
 * @return  bool  true if ready to install, false if not
 */
function xoops_module_pre_install_edito(\XoopsModule $module)
{
    $xoopsSuccess = Utility::checkVerXoops($module);
    $phpSuccess   = Utility::checkVerPHP($module);
    return $xoopsSuccess && $phpSuccess;
}

/**
 * Performs tasks required during installation of the module
 *
 * @param  \XoopsModule  $module  {@see \XoopsModule}
 * @return bool true if installation successful, false if not
 */
function xoops_module_install_edito(\XoopsModule $module)
{
    $configurator = new Configurator();
    $helper       = Helper::getInstance();
    $helper->loadLanguage('admin');

    // Create the upload directories
    $success = true;
    if (is_array($configurator->uploadFolders) && 0 < count($configurator->uploadFolders)) {
        foreach ($configurator->uploadFolders as $folder) {
            $uploadPathObj = new \SplFileInfo($folder);
            if ((false === $uploadPathObj->isDir()) && (false === mkdir($configurator->paths['uploadPath'], 0755))) {
                $success = false;
                $GLOBALS['xoopsModule']->setErrors(sprintf(_AM_EDITO_ERR_BAD_UPLOAD_PATH, $folder));
            } else {
                // Create index file in new directories
                $newFile   = $folder . '/index.php';
                $fileInfo  = new \SplFileInfo($newFile);
                $fileObj   = $fileInfo->openFile('w');
                $byteCount = $fileObj->fwrite("<?php\nheader('HTTP/1.0 404 Not Found');\n");
                $fileObj   = null; // destroy SplFileObject so it closes file
                $fileInfo  = null; // destroy this splFileInfo object
                if (0 === $byteCount) {
                    $success = false;
                    $GLOBALS['xoopsModule']->setErrors(sprintf(_AM_EDITO_ERR_BAD_INDEX, $newFile));
                }
            }
        }
    }
    return $success;
}
