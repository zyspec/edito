<?php

declare(strict_types=1);

namespace XoopsModules\Edito;

/*
 Utility Class Definition

 You may not change or alter any portion of this comment or credits of
 supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit
 authors.

 This program is distributed in the hope that it will be useful, but
 WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */
/**
 *
 * @license  {@link https://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU GPL 2}
 * @copyright  &copy; 2000-2020 {@link https://xoops.org XOOPS Project}
 * @author  Mamba <mambax7@gmail.com>
 */

use XoopsModules\Edito;
use XoopsModules\Edito\Common;
use XoopsModules\Edito\Constants;

/**
 * Class Utility
 */
class Utility extends Common\SysUtility
{
    use Common\VersionChecks; //checkVerXoops, checkVerPhp Traits
    use Common\ServerStats; // getServerStats Trait
    use Common\FilesManagement; // Files Management Trait

    //--------------- Custom module methods -----------------------------

}
