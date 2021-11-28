<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * @package  \XoopsModules\Edito
 * @copyright  &copy; 2000-2021 {@link https://xoops.org XOOPS Project}
 * @license  {@link https://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU GPL 2}
 * @author  XOOPS Project <www.xoops.org> <www.xoops.ir>
 */

/**
 * Class EditoCorePreload
 */
class EditoCorePreload extends \XoopsPreloadItem
{
    // to add PSR-4 autoloader
    /**
     * @param $args
     */
    public static function eventCoreIncludeCommonEnd($args)
    {
        require_once __DIR__ . '/autoloader.php';
    }
}