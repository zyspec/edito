<?php

namespace XoopsModules\Edito\Common;

/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */
/**
 * Module: Edito
 *
 * @package   XoopsModules\Edito\Class
 * @copyright 2001-2019 {@link https://xoops.org The XOOPS Project}
 * @license   {@link https://www.fsf.org/copyleft/gpl.html GNU public license}
 * @author  Mamba <mambax7@gmail.com>
 * @author  XOOPS Module Development Team
 * @since  3.1
 */

/**
 * Methods to obtain PHP Server information
 */
trait ServerStats
{

    /**
     * Get the Server Stats
     *
     * @return  mixed[]  server settings/stats
     */
    public static function getServerStats()
    {
        $moduleDirName      = basename(dirname(dirname(__DIR__)));
        $moduleDirNameUpper = mb_strtoupper($moduleDirName);

        xoops_loadLanguage('common', $moduleDirName);

        $gdLib = false;
        $gdVer = '';
        if (function_exists('gd_info') && is_array(($gdInfo = gd_info()))) {
            $gdLib = true;
            $gdVer = $gdInfo['GD Version'];
        }

        return
            ['gdLib'         => $gdLib,
             'gdVer'         => $gdVer,
             'fileUploads'   => (bool) ini_get('file_uploads'),
             'maxUploadSize' => ini_get('upload_max_filesize'),
             'maxPostSize'   => ini_get('post_max_size'),
             'memoryLimit'   => ini_get('memory_limit')
        ];
    }

    /**
     * Get the Server Stats
     *
     * @return  string  HTML representing server settings/stats
     */
    public static function renderServerStats()
    {
        $moduleDirName      = basename(dirname(dirname(__DIR__)));
        $moduleDirNameUpper = mb_strtoupper($moduleDirName);

        xoops_loadLanguage('common', $moduleDirName);

        $statsArray = static::getServerStats();

        $html = "<fieldset>\n"
              . "<legend style='font-weight: bold; color: #900;'>" . constant('CO_' . $moduleDirNameUpper . '_IMAGEINFO') . "</legend>\n"
              . "<div style='padding: 8px;'>\n"
              . '<div>' . constant('CO_' . $moduleDirNameUpper . '_SPHPINI') . "</div>\n";
        $gdlib = $statsArray['gdLib'] ? '<span style="color: #008000;">' . constant('CO_' . $moduleDirNameUpper . '_GDON') . '</span>' : '<span style="color: red;">' . constant('CO_' . $moduleDirNameUpper . '_GDOFF') . '</span>';
        $html .= "<ul>\n"
               . '<li>' . constant('CO_' . $moduleDirNameUpper . '_GDLIBSTATUS') . $gdlib . "</li>\n";
        if ('' !== $statsArray['gdVer']) {
            $html .= '<li>' . constant('CO_' . $moduleDirNameUpper . '_GDLIBVERSION') . '<b>' . $statsArray['gdVer'] . '</b></li>';
        }
        $downloads = $statsArray['fileUploads'] ? '<span style="color: green;">' . constant('CO_' . $moduleDirNameUpper . '_ON') . '</span>' : '<span style="color: #ff0000;">' . constant('CO_' . $moduleDirNameUpper . '_OFF') . '</span>';
        $html .= '<li>' . constant('CO_' . $moduleDirNameUpper . '_SERVERUPLOADSTATUS') . $downloads . "</li>\n"
               . '<li>' . constant('CO_' . $moduleDirNameUpper . '_MAXUPLOADSIZE') . ' <b><span style="color: #0000ff;">' . $statsArray['maxUploadSize'] . "</span></b></li>\n"
               . '<li>' . constant('CO_' . $moduleDirNameUpper . '_MAXPOSTSIZE') . ' <b><span style="color: #0000ff;">' . $statsArray['maxPostSize'] . "</span></b></li>\n"
               . '<li>' . constant('CO_' . $moduleDirNameUpper . '_MEMORYLIMIT') . ' <b><span style="color: #0000ff;">' . $statsArray['memoryLimit'] . "</span></b></li>\n"
               . "</ul>\n"
               . "<ul>\n"
               . '<li>' . constant('CO_' . $moduleDirNameUpper . '_SERVERPATH') . ' <b>' . XOOPS_ROOT_PATH . "</b></li>\n"
               . "</ul>\n"
               . "<br>\n"
               . constant('CO_' . $moduleDirNameUpper . '_UPLOADPATHDSC') . "\n"
               . "</div>\n"
               . "</fieldset><br>\n";
        return $html;
    }

    /**
     * Display Server Statistics
     *
     * @return  void
     */
    public static function displayServerStats()
    {
        echo static::renderServerStats();
    }
}
