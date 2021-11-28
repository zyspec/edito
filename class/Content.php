<?php

declare(strict_types=1);

namespace XoopsModules\Edito;

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
 * @package   \XoopsModules\Edito\Class
 * @copyright 2001-2021 {@link https://xoops.org The XOOPS Project}
 * @license   {@link https://www.fsf.org/copyleft/gpl.html GNU public license}
 * @author    XOOPS Module Development Team
 * @author    ZySpec <zyspec@yahoo.com>
 */

defined('XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class Edito\Content
 */
class Content extends \XoopsObject
{
    /**
     * Class constructor
     */
    public function __construct()
    {
        // definitions of the table field names from the database
        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('uid', XOBJ_DTYPE_INT, 0, true);
        $this->initVar('datesub', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('counter', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('state', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('subject', XOBJ_DTYPE_TXTBOX, null, true, 255);
        $this->initVar('block_text', XOBJ_DTYPE_TXTAREA, null, true);
        $this->initVar('body_text', XOBJ_DTYPE_TXTAREA, null, true);
        $this->initVar('image', XOBJ_DTYPE_TXTBOX, '', false, 255);
        $this->initVar('media', XOBJ_DTYPE_TXTBOX, '|media.mpg|', false, 255);
        $this->initVar('meta', XOBJ_DTYPE_TXTAREA, null, true);
        $this->initVar('groups', XOBJ_DTYPE_TXTBOX, '', false, 255);
        $this->initVar('options', XOBJ_DTYPE_TXTBOX, '', false, 36);
        parent::__construct();
    }

    /**
     * Magic display function
     *
     * @return string \XoopsModules\Edito\Content::subject
     */
    public function __toString()
    {
        return $this->getVar('subject', 's');
    }
}
