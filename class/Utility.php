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
    /**
     * @param  null|string  $type
     * @param  string  $caption
     * @param  string  $name
     * @param  null|string  $value
     * @param  null|string  $width
     * @param  null|string  $height
     * @param  null|string  $supplemental
     * @return  \XoopsFormEditor
     */
    public static function getWysiwygForm($type = 'dhtml', $caption, $name, $value = '', $width = '100%', $height = '400px', $supplemental='')
    {

        $wysiwyg_editor = $GLOBALS['xoopsModuleConfig']['wysiwyg'];
        if (empty($wysiwyg_editor)) {
            $wysiwyg_editor = 'dhtmltextarea';
        }
        $editorConfigs = [
            'editor' => $wysiwyg_editor,
            'rows'   => 35,
            'cols'   => 60,
            'width'  => $width,
            'height' => $height,
            'name'   => $type,
            'value'  => $value
        ];
        $wysiwyg = new \XoopsFormEditor($caption, $name, $editorConfigs);

        return $wysiwyg;
    }
}
