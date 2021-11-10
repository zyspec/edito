<?php

declare(strict_types=1);

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
 * Module: Edito
 *
 * @package   \XoopsModules\Edito\Class
 * @copyright Copyright {@link https://xoops.org XOOPS Project}
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 * @author    XOOPS Module Development Team
 * @link      https://github.com/XoopsModules25x/edito
 */

/**
 * ContentHandler class
 *
 * @package  \XoopsModules\Edito
 * @subpackage  class
 */
class ContentHandler extends \XoopsPersistableObjectHandler
{
    /**
     * Constructor
     *
     * @param \XoopsDatabase $db
     */
    function __construct(&$db)
    {
        parent::__construct($db, 'edito_content', Content::class, 'id', 'subject');
    }
}
