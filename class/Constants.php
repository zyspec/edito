<?php

namespace XoopsModules\Edito;

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
 * Module: Simplepage
 *
 * @package  \XoopsModules\Edito\Class
 * @copyright  {@link https://xoops.org The XOOPS Project}
 * @license   {@link https://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU GPL 2 or later}
 * @author  XOOPS Module Dev Team (https://xoops.org)
 * @link https://github.com/XoopsModules25x/simplepage
 * @since  3.1
 */

/**
 * Interface \XoopsModules\Edito\Constants
 */
interface Constants
{
    /**#@+
     * Constant definition
     */
    /**
     * XOOPSTOKEN Request Timeout value
     */
    const TOKEN_TIMEOUT = 360;
    /**
     * DO NOT Hide YAML Sample Button in Admin
     */
    const DO_NOT_DISP_SAMPLE_BTN = 0;
    const HIDE_SAMPLE_BTN = 0;
    /**
     * Show YAML Sample Button in Admin
     */
    const DISP_SAMPLE_BTN = 1;
    /**
     * default items to show per page in lists
     */
    const DEFAULT_PER_PAGE = 25;
    /**
     * Default download file size
     */
    const DEFAULT_FILE_SIZE = 2097152; // 2MB
    /**
     * Default Image height
     */
    const DEFAULT_IMAGE_HEIGHT = 1000;
    /**
     * Default Image width
     */
    const DEFAULT_IMAGE_WIDTH = 1500;
    /**
     * Default Thumbnail widths
     */
    const DEFAULT_THUMB_WIDTH = 150;
    /**
     * default order
     */
    const DEFAULT_ORDER = 0;
    /**
     * start / beginning
     */
    const BEGINNING = 0;
    /**
     * item is not active
     */
    const IS_NOT_PUBLISHED = 0;
    /**
     * item is active
     */
    const IS_PUBLISHED = 1;
    /**
     * is not locked
     */

    // Navigation
    /**
     * no delay XOOPS redirect delay (in seconds)
     */
    const REDIRECT_DELAY_NONE = 0;
    /**
     * short XOOPS redirect delay (in seconds)
     */
    const REDIRECT_DELAY_SHORT = 1;
    /**
     * medium XOOPS redirect delay (in seconds)
     */
    const REDIRECT_DELAY_MEDIUM = 3;
    /**
     * long XOOPS redirect delay (in seconds)
     */
    const REDIRECT_DELAY_LONG = 7;
    /**
     * confirm not ok to take action
     */
    const CONFIRM_NOT_OK = 0;
    /**
     * confirm ok to take action
     */
    const CONFIRM_OK = 1;
    /**#@-*/
}
