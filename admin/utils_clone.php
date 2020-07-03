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

use Xmf\Request;

require_once dirname(__DIR__, 3) . '/mainfile.php';
require_once dirname(__DIR__, 3) . '/include/cp_header.php';

$op = Request::getCmd('op', '');
$type_clonage = Request::getCmd('type_clonage', '');

/*
$op = '';
$type_clonage = '';

if ( isset( $_GET['op'] ) ) $op = $_GET['op'];
if ( isset( $_POST['op'] ) ) $op = $_POST['op'];
if ( isset( $_GET['type_clonage'] ) ) $type_clonage = $_GET['type_clonage'];
if ( isset( $_POST['type_clonage'] ) ) $type_clonage = $_POST['type_clonage'];
*/

function utilities()
{
    global $xoopsConfig, $modify, $xoopsModuleConfig, $xoopsModule, $xoopsDB, $XOOPS_URL, $type_clonage;

    $sform = new XoopsThemeForm(_AM_EDITO_CLONE, 'op', xoops_getenv('PHP_SELF'));

    $sform->setExtra('enctype="multipart/form-data"');

    if ('cache' == $type_clonage) {
        $help_display = '<tr><td colspan="2" style="background-color:AntiqueWhite;">' . _AM_EDITO_CLONE_TROUBLE . '</td></tr>';
    } else {
        $help_display = '';
    }

    $sform->addElement($help_display);

    $sform->addElement(new XoopsFormText(_AM_EDITO_CLONENAME, 'clone', 12, 12, ''), true);

    $button_tray = new XoopsFormElementTray('', '');

    $hidden = new XoopsFormHidden('op', 'clonemodule');

    $button_tray->addElement($hidden);

    $butt_create = new XoopsFormButton('', '', _AM_EDITO_SUBMIT, 'submit');

    $butt_create->setExtra('onclick="this.form.elements.op.value=\'clonemodule\'"');

    $button_tray->addElement($butt_create);

    $butt_clear = new XoopsFormButton('', '', _AM_EDITO_CLEAR, 'reset');

    $button_tray->addElement($butt_clear);

    $sform->addElement($button_tray);

    $sform->display();

    unset($hidden);
}//end function utilities

/* create a clone in modules folder */
/**
 * @param $path
 */
function cloneFileFolder($path)
    {
        global $patKeys;

        global $patValues;

        global $safeKeys;

        global $safeValues;

        $newPath = str_replace($patKeys[0], $patValues[0], $path); //full new file path

        chmod(XOOPS_ROOT_PATH . '/modules', 0777);

        if (is_dir($path)) {
            // Create new dir

            mkdir($newPath);

            // check all files in dir, and process it

            if ($handle = opendir($path)) {
                while ($file = readdir($handle)) {
                    if ('.' != $file && '..' != $file) {
                        cloneFileFolder("$path/$file");
                    }
                }

                closedir($handle);
            }
        } else {
            if (preg_match('/(.jpg|.gif|.png|.zip)$/i', $path)) {
                copy($path, $newPath);
            } else {
                // file, read it

                $content = file_get_contents($path);

                $content = str_replace($safeKeys, $safeValues, $content); // Save 'Editor' values
          $content = str_replace($patKeys, $patValues, $content);   // Rename Clone values
          $content = str_replace($safeValues, $safeKeys, $content);  // Restore 'Editor' values
          file_put_contents($newPath, $content);
            }
        }

        chmod(XOOPS_ROOT_PATH . '/modules', 0444);
    }

// Check wether the cloning function is available
// work around for PHP < 5.0.x
    if (!function_exists('file_put_contents')) {
        /**
         * @param       $filename
         * @param       $data
         * @param false $file_append
         */
        function file_put_contents($filename, $data, $file_append = false)
        {
            $fp = fopen($filename, (!$file_append ? 'w+' : 'a+'));

            if (!$fp) {
                trigger_error('file_put_contents cannot write in file.', E_USER_ERROR);

                return;
            }

            fwrite($fp, $data);

            fclose($fp);
        }//end function file_put_contents
    }//end if

/* -- Available operations -- */
switch ($op) {
    case 'clonemodule':
        $clone = Request::getString('clone', '');
        // Define Cloning parameters : check clone name
        $clone = trim($clone);
        $clone_orig = $clone;
        if (function_exists('mb_convert_encoding')) {
            $clone = mb_convert_encoding($clone, '', 'auto');
        }
        //$clone = eregi_replace("[[:digit:]]","", $clone);
        $clone = str_replace('-', 'xyz', $clone);
        $clone = preg_replace('/[[:punct:]]/', '', $clone);
        $clone = str_replace('xyz', '-', $clone);
        $clone = preg_replace('/ /', '_', $clone);

        // Check wether the cloned module exists or not
        if ($clone && is_dir(XOOPS_ROOT_PATH . '/modules/' . $clone)) {
            redirect_header('utils_clone.php', 2, _AM_EDITO_MODULEXISTS);
        }

        // Define clone naming parameteres
        $module = $xoopsModule->dirname();

        if ($clone) {
            $CLONE = mb_strtoupper(preg_replace('/-/', '_', $clone));

            $clone = mb_strtolower(preg_replace('/-/', '_', $clone));

            $Clone = ucfirst($clone_orig);

            $MODULE = mb_strtoupper($module);

            $Module = ucfirst($module);

            $patterns = [
            // first one must be module directory name
            $module => $clone,
            $MODULE => $CLONE,
            $Module => $Clone,
            ];

            $patKeys = array_keys($patterns);

            $patValues = array_values($patterns);

            // Clone everything but 'Editor' - usefull for edito only

            $safepat = [
                // Prevent unwilling change for wysiwyg functions
                'editor' => 'squizzz',
                'EDITOR' => 'SQUIZZZ',
                'Editor' => 'Squizzz',
            ];

            $safeKeys = array_keys($safepat);

            $safeValues = array_values($safepat);

            /**
             * @param $dir2copy
             * @param $dir_paste
             */
            function copy_dir($dir2copy, $dir_paste)
            {
                global $patKeys, $patValues, $safeKeys, $safeValues, $clone, $module;

                // On v�rifie si $dir2copy est un dossier

                if (is_dir($dir2copy)) {
                    // Si oui, on l'ouvre

                    if ($dh = opendir($dir2copy)) {
                        // On liste les dossiers et fichiers de $dir2copy

                        while ((false !== $file = readdir($dh))) {
                            // Si le dossier dans lequel on veut coller n'existe pas, on le cr��

                            if (!is_dir($dir_paste)) {
                                $oldumask = umask(0000);

                                mkdir($dir_paste);

                                umask($oldumask);
                            }

                            // S'il s'agit d'un dossier, on relance la fonction r�cursive

                            if (is_dir($dir2copy . $file) && '..' != $file && '.' != $file) {
                                copy_dir($dir2copy . $file . '/', $dir_paste . $file . '/');

                            // S'il sagit d'un fichier, on le copie simplement
                            } elseif ('..' != $file && '.' != $file) {
                                if (preg_match(mb_strtolower($module), mb_strtolower($file))) { //je cherche le mot 'edito' dans le nom du fichier
                                    $filedest = preg_replace(mb_strtolower($module), mb_strtolower($clone), $file); //si je trouve je remplace par le nom du clone
                                    copy($dir2copy . $file, $dir_paste . $filedest); //et je copie le fichier avec le bon nom
                                    $file = $filedest;
                                } else {
                                    copy($dir2copy . $file, $dir_paste . $file);
                                }

                                if (!preg_match('/(.jpg|.gif|.png|.zip)$/i', $dir_paste . $file)) {
                                    $content = file_get_contents($dir_paste . $file);

                                    $content = str_replace($safeKeys, $safeValues, $content); // Save 'Editor' values
                                    $content = str_replace($patKeys, $patValues, $content);   // Rename Clone values
                                    $content = str_replace($safeValues, $safeKeys, $content);  // Restore 'Editor' values
                                    file_put_contents($dir_paste . $file, $content);
                                }
                            }
                        }

                        // On ferme $dir2copy

                        closedir($dh);
                    }
                }
            }

            $dir2copy = '../../' . $module . '/';

            $dir_paste = '../../../cache/' . $clone . '/';

            // Create clone

            $module_dir = XOOPS_ROOT_PATH . '/modules';

            $fileperm = fileperms($module_dir);

            if (@chmod($module_dir, 0777)) {
                cloneFileFolder('../../' . $module);

                chmod(XOOPS_ROOT_PATH . '/modules', $fileperm);

                redirect_header('../../system/admin.php?fct=modulesadmin&op=install&module=' . $clone, 1, _AM_EDITO_CLONED);
            }

            copy_dir($dir2copy, $dir_paste);

            redirect_header('utils_clone.php?type_clonage=cache', 1, _AM_EDITO_CLONED);
        } else { //end "if $clone"
            redirect_header('utils_clone.php', 1, _AM_EDITO_NOTCLONED);
        }
        break;
  case 'utilities':
    default:
        require_once __DIR__ . '/admin_header.php';
        edito_adminmenu(2, _AM_EDITO_UTILITIES . '<br>' . _AM_EDITO_CLONE);
        edito_statmenu(1, '');
        utilities();
        require_once __DIR__ . '/admin_footer.php';
        break;
}
