<?php declare(strict_types=1);
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
 * @copyright Copyright {@link https://xoops.org XOOPS Project}
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 * @author    Solo (http://www.wolfpackclan.com/wolfactory)
 * @author    DuGris (http://www.dugris.info)
 * @author    XOOPS Module Development Team
 * @link      https://github.com/XoopsModules25x/edito
 */
defined('XOOPS_ROOT_PATH') || exit('Restricted access');

function edito_getWysiwygForm($type, $caption, $name, $value = '', $width = '100%', $height = '400px', $supplemental = '')
{
    $wysiwyg_editor = $GLOBALS['xoopsModuleConfig']['wysiwyg'];

    if (empty($wysiwyg_editor)) {
        $wysiwyg_editor = 'dhtmltextarea';
    }

    $editorConfigs = [
        'editor' => $wysiwyg_editor,
        'rows' => 35,
        'cols' => 60,
        'width' => $width,
        'height' => $height,
        'name' => $type,
        'value' => $value,
    ];

    $wysiwyg = new \XoopsFormEditor($caption, $name, $editorConfigs);

    return $wysiwyg;
    //	global $xoopsModuleConfig;

    $wysiwyg = false;

    $x22 = false;

    $xv = str_replace('XOOPS ', '', XOOPS_VERSION);

    if ('2' == mb_substr($xv, 2, 1)) {
        $x22 = true;
    }

    $wysiwyg_configs = [];

    $wysiwyg_configs['name'] = $name;

    $wysiwyg_configs['value'] = $value;

    $wysiwyg_configs['rows'] = 35;

    $wysiwyg_configs['cols'] = 60;

    $wysiwyg_configs['width'] = '100%';

    $wysiwyg_configs['height'] = '400px';

    switch (mb_strtolower($type)) {
    case 'spaw':
        if (!$x22) {
            if (is_readable(XOOPS_ROOT_PATH . '/class/spaw/formspaw.php')) {
                require_once XOOPS_ROOT_PATH . '/class/spaw/formspaw.php';

                $wysiwyg = new XoopsFormSpaw($caption, $name, $value);
            }
        } else {
            $wysiwyg = new XoopsFormEditor($caption, 'spaw', $wysiwyg_configs);
        }
        break;
    case 'fck':
        if (!$x22) {
            if (is_readable(XOOPS_ROOT_PATH . '/class/fckeditor/formfckeditor.php')) {
                require_once XOOPS_ROOT_PATH . '/class/fckeditor/formfckeditor.php';

                $wysiwyg = new XoopsFormFckeditor($caption, $name, $value);
            }
        } else {
            $wysiwyg = new XoopsFormEditor($caption, 'fckeditor', $wysiwyg_configs);
        }
        break;
    case 'htmlarea':
        if (!$x22) {
            if (is_readable(XOOPS_ROOT_PATH . '/class/htmlarea/formhtmlarea.php')) {
                require_once XOOPS_ROOT_PATH . '/class/htmlarea/formhtmlarea.php';

                $wysiwyg = new XoopsFormHtmlarea($caption, $name, $value);
            }
        } else {
            $wysiwyg = new XoopsFormEditor($caption, 'htmlarea', $wysiwyg_configs);
        }
        break;
    case 'dhtml':
        if (!$x22) {
            $wysiwyg = new XoopsFormDhtmlTextArea($caption, $name, $value, 10, 50, $supplemental);
        } else {
            $wysiwyg = new XoopsFormEditor($caption, 'dhtmltextarea', $wysiwyg_configs);
        }
        break;
    case 'textarea':
        $wysiwyg = new XoopsFormTextArea($caption, $name, $value);
        break;
    case 'koivi':
        if (!$x22) {
            if (is_readable(XOOPS_ROOT_PATH . '/class/xoopseditor/wysiwyg/formwysiwygtextarea.php')) {
                require_once XOOPS_ROOT_PATH . '/class/xoopseditor/wysiwyg/formwysiwygtextarea.php';

                $wysiwyg = new XoopsFormWysiwygTextArea($caption, $name, $value, '100%', '400px', '');
            }
        } else {
            $wysiwyg = new XoopsFormEditor($caption, 'koivi', $wysiwyg_configs);
        }
        break;
    case 'tinyeditor':
        if (!$x22) {
            if (is_readable(XOOPS_ROOT_PATH . '/class/xoopseditor/tinyeditor/formtinyeditortextarea.php')) {
                require_once XOOPS_ROOT_PATH . '/class/xoopseditor/tinyeditor/formtinyeditortextarea.php';

                $wysiwyg = new XoopsFormTinyeditorTextArea([$caption, $name, $value, $width, $height]);
            }
        } else {
            $wysiwyg = new XoopsFormEditor($caption, 'tinyeditor', $wysiwyg_configs);
        }
        break;
    }

    return $wysiwyg;
}
