<?php

namespace XoopsModules\Edito\Common;

/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */
/**
 * Configurator Class
 *
 * @package  \XoopsModules\Edito\Class
 * @copyright  &copy; 2000-2021 {@link https://xoops.org XOOPS Project}
 * @license  {@link https://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU GPL 2 or later}
 * @author  XOOPS Development Team
 * @link  https://github.com/XoopsModules25x/edito
 */

/**
 * Class Configurator
 */
class Configurator
{
    public $name;
    public $paths           = [];
    public $uploadFolders   = [];
    public $copyBlankFiles  = [];
    public $copyTestFolders = [];
    public $templateFolders = [];
    public $oldFiles        = [];
    public $oldFolders      = [];
    public $renameTables    = [];
    public $moduleStats     = [];
    public $modCopyright;
    public $icons;

    /**
     * Configurator constructor.
     */
    public function __construct()
    {
        //$moduleDirName      = basename(dirname(dirname(__DIR__)));
        //$moduleDirNameUpper = mb_strtoupper($moduleDirName);

        $config = include dirname(__DIR__, 2) . '/config/config.php';

        $this->name            = $config->name;
        $this->uploadFolders   = $config->uploadFolders;
        $this->copyBlankFiles  = $config->copyBlankFiles;
        $this->copyTestFolders = $config->copyTestFolders;
        $this->templateFolders = $config->templateFolders;
        $this->oldFiles        = $config->oldFiles;
        $this->oldFolders      = $config->oldFolders;
        $this->renameTables    = $config->renameTables;
        $this->moduleStats     = $config->moduleStats;
        $this->modCopyright    = $config->modCopyright;

        $this->icons = include dirname(dirname(__DIR__)) . '/config/icons.php';
        $this->paths = include dirname(dirname(__DIR__)) . '/config/paths.php';
    }
}
