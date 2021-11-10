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
 * @copyright   XOOPS Project (https://xoops.org)
 * @license     http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author      mamba <mambax7@gmail.com>
 */
trait VersionChecks
{
    /**
     * Verifies XOOPS version meets minimum requirements for this module
     * @static
     * @param \XoopsModule|null $module
     *
     * @param null|string       $requiredVer
     * @return bool true if meets requirements, false if not
     */
    public static function checkVerXoops(\XoopsModule $module = null, $requiredVer = null)
    {
        $moduleDirName      = basename(dirname(dirname(__DIR__)));
        $moduleDirNameUpper = mb_strtoupper($moduleDirName);
        if (null === $module) {
            $module = \XoopsModule::getByDirname($moduleDirName);
        }
        xoops_loadLanguage('admin', $moduleDirName);
        xoops_loadLanguage('common', $moduleDirName);

        //check for minimum XOOPS version
        $currentVer = mb_substr(XOOPS_VERSION, 6); // get the numeric part of string
        if (null === $requiredVer) {
            $requiredVer = '' . $module->getInfo('min_xoops'); //making sure it's a string
        }
        $success = true;

        if (version_compare($currentVer, $requiredVer, '<')) {
            $success = false;
            $module->setErrors(sprintf(constant('CO_' . $moduleDirNameUpper . '_ERROR_BAD_XOOPS'), $requiredVer, $currentVer));
        }

        return $success;
    }

    /**
     * Verifies PHP version meets minimum requirements for this module
     * @static
     * @param \XoopsModule|null $module
     *
     * @return bool true if meets requirements, false if not
     */
    public static function checkVerPhp(\XoopsModule $module = null)
    {
        $moduleDirName      = basename(dirname(dirname(__DIR__)));
        $moduleDirNameUpper = mb_strtoupper($moduleDirName);
        if (null === $module) {
            $module = \XoopsModule::getByDirname($moduleDirName);
        }
        xoops_loadLanguage('admin', $moduleDirName);
        xoops_loadLanguage('common', $moduleDirName);

        // check for minimum PHP version
        $success = true;

        $verNum = PHP_VERSION;
        $reqVer = &$module->getInfo('min_php');

        if (false !== $reqVer && '' !== $reqVer && !is_array($reqVer)) {
            if (version_compare($verNum, $reqVer, '<')) {
                $module->setErrors(sprintf(constant('CO_' . $moduleDirNameUpper . '_ERROR_BAD_PHP'), $reqVer, $verNum));
                $success = false;
            }
        }

        return $success;
    }

    /**
     * Compares current module version with latest GitHub release
     *
     * @param  \Xmf\Module\Helper  $helper  module helper object
     * @param  null|string  $source  repository location
     * @param  null|string  $default  repository branch to check
     *
     * @return array info about the latest module version, if newer
     */
    public static function checkVerModule(
        \Xmf\Module\Helper $helper,
        ?string $source = 'github',
        ?string $default = 'master'): array
    {
        require_once dirname(__DIR__, 2) . '/include/common.php';

        $moduleDirName      = basename(dirname(dirname(__DIR__)));
        $moduleDirNameUpper = mb_strtoupper($moduleDirName);
        $update             = '';
        $ret                = [];
        $repository         = 'XoopsModules25x/' . $moduleDirName;
        //$repository         = 'XoopsModules25x/publisher'; //for testing only
        $infoReleasesUrl    = "https://api.github.com/repos/$repository/releases";

        // 1st check to see if repository releases exist
        if (!self::remoteFileExists($infoReleasesUrl)) {
            return $ret;
        }
        if (('github' === $source)
            && (false !== ($curlHandle = curl_init()))) {
            curl_setopt_array($curlHandle, [
                CURLOPT_URL => $infoReleasesUrl,
                CURLINFO_HEADER_OUT => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false, // handles http[s]
                CURLOPT_USERAGENT => $GLOBALS['xoopsConfig']['sitename'] . "- " . ucfirst($moduleDirName)
            ]);
            $curlReturn = curl_exec($curlHandle);
            if (false === $curlReturn) {
                trigger_error(curl_error($curlHandle));
            } elseif (false !== mb_strpos($curlReturn, 'Not Found')) {
                trigger_error('Repository Not Found: ' . $infoReleasesUrl);
            } else {
                $file = json_decode($curlReturn, false);
                if (empty($file)) { // exit if there aren't any releases
                    curl_close($curlHandle);
                    return $ret;
                }
                $latestVersionLink = sprintf("https://github.com/$repository/archive/%s.zip", $file ? reset($file)->tag_name : $default);
                $latestVersion = $file[0]->tag_name;
                $prerelease = $file[0]->prerelease;
                if ('master' !== $latestVersionLink) {
                    $update = constant('CO_' . $moduleDirNameUpper . '_' . 'NEW_VERSION') . $latestVersion;
                }
                //"PHP-standardized" version
                $latestVersion = mb_strtolower($latestVersion);
                if (false !== mb_strpos($latestVersion, 'final')) {
                    $latestVersion = str_replace('_', '', mb_strtolower($latestVersion));
                    $latestVersion = str_replace('final', '', mb_strtolower($latestVersion));
                }
                $moduleVersion = ($helper->getModule()->getInfo('version') . '_' . $helper->getModule()->getInfo('module_status'));
                //"PHP-standardized" version
                $moduleVersion = str_replace(' ', '', mb_strtolower($moduleVersion));
                //$moduleVersion = '1.0'; //for testing only
                //$moduleDirName = 'publisher'; //for testing only
                if (!$prerelease && version_compare($moduleVersion, $latestVersion, '<')) {
                    $ret = [
                        'CO_' . $moduleDirNameUpper . '_' . 'RELEASE_INTRO_INDEX' => $update,
                        'CO_' . $moduleDirNameUpper . '_' . 'RELEASE_LINK_INDEX' => $latestVersionLink
                    ];
                }
                //} else {
                //trigger_error(sprintf('Uknown repository error: (%s) No: %s', curl_error($curlHandle), curl_errno($curlHandle)));
            }
        }
        curl_close($curlHandle);
        return $ret;
    }

    /**
     * Checks to see if a file/folder exists on a remote server
     *
     * @param  string  $url
     * @return  bool
     */
    public static function remoteFileExists(string $url): bool
    {
        $moduleDirName = basename(dirname(__DIR__, 2));

        $ch = curl_init();
        curl_setopt_array($ch, [
                CURLOPT_URL            => $url,
                CURLINFO_HEADER_OUT    => true,
                CURLOPT_NOBODY         => true,
                CURLOPT_RETURNTRANSFER => true, // trying this
                CURLOPT_SSL_VERIFYPEER => false, // handles http[s]
                //CURLOPT_USERAGENT      => ["User-Agent:" . ucfirst($moduleDirName) . "\r\n"]
                CURLOPT_USERAGENT      => $GLOBALS['xoopsConfig']['sitename'] . "- " . ucfirst($moduleDirName)
            ]
        );
        curl_exec($ch);

        $httpCode  = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        curl_close($ch);

        return 200 == $httpCode;
    }
}
