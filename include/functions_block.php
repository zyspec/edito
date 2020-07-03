<?php declare(strict_types=1);
/**
 * XOOPS - PHP Content Management System
 * Copyright (c) 2004 <https://www.xoops.org>
 *
 * Module: edito 3.0
 * Licence : GPL
 * Authors :
 *           - solo (http://www.wolfpackclan.com/wolfactory)
 *            - DuGris (http://www.dugris.info)
 * @param mixed $option
 * @param mixed $repmodule
 * @return false|mixed
 * @return false|mixed
 */
function edito_getmoduleoption($option, $repmodule = 'edito')
{
    global $xoopsModuleConfig, $xoopsModule;

    static $tbloptions = [];

    if (is_array($tbloptions) && array_key_exists($option, $tbloptions)) {
        return $tbloptions[$option];
    }

    $retval = false;

    if (isset($xoopsModuleConfig) && (is_object($xoopsModule) && $xoopsModule->getVar('dirname') == $repmodule && $xoopsModule->getVar('isactive'))) {
        if (isset($xoopsModuleConfig[$option])) {
            $retval = $xoopsModuleConfig[$option];
        }
    } else {
        $moduleHandler = xoops_getHandler('module');

        $module = $moduleHandler->getByDirname($repmodule);

        $configHandler = xoops_getHandler('config');

        if ($module) {
            $moduleConfig = $configHandler->getConfigsByCat(0, $module->getVar('mid'));

            if (isset($moduleConfig[$option])) {
                $retval = $moduleConfig[$option];
            }
        }
    }

    $tbloptions[$option] = $retval;

    return $retval;
}
