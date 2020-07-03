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

/*
$op = '';

if ( isset( $_GET['op'] ) ) $op = $_GET['op'];
if ( isset( $_POST['op'] ) ) $op = $_POST['op'];
*/

function utilities()
{
    global $xoopsConfig, $modify, $xoopsModule, $xoopsDB;

    // DB feed

    $sform = new XoopsThemeForm(_AM_EDITO_DB_IMPORT, 'op', xoops_getenv('PHP_SELF'));

    $sform->setExtra('enctype="multipart/form-data"');

    // Topics

    // Code to create the topics selector

    /*
            $sql = " SELECT catid, cat_subject
                     FROM ".$xoopsDB->prefix($xoopsModule->dirname() . "_topics" )."
                     ORDER BY cat_subject ASC";
            $result = $xoopsDB->queryF($sql);
            $topics = array();
            $topics[0] = ' ';
            while(list( $catid, $cat_subject ) = $xoopsDB->fetchRow($result))
                   {
                         $topics[$catid] = $cat_subject;
                       }

                $topics_array = $topics;
                 $topics_select = new XoopsFormSelect( '', 'catid', ' ');
                $topics_select -> addOptionArray( $topics_array );
                $topics_tray = new XoopsFormElementTray( _AM_EDITO_TOPIC._AM_EDITO_TOPIC_INFOS, '&nbsp;' );
                $topics_tray -> addElement( $topics_select );
                $sform -> addElement( $topics_tray );
    */

    $sform->addElement(new XoopsFormTextArea(_AM_EDITO_DB_DATAS, 'db_datas', '', 20, 90), true);

    $button_tray = new XoopsFormElementTray('', '');

    $hidden = new XoopsFormHidden('op', 'database_feed');

    $button_tray->addElement($hidden);

    $butt_create = new XoopsFormButton('', '', _AM_EDITO_SUBMIT, 'submit');

    $butt_create->setExtra('onclick="this.form.elements.op.value=\'database_feed\'"');

    $button_tray->addElement($butt_create);

    $butt_clear = new XoopsFormButton('', '', _AM_EDITO_CLEAR, 'reset');

    $button_tray->addElement($butt_clear);

    $sform->addElement($button_tray);

    $sform->display();

    unset($hidden);
}

/* -- Available operations -- */
switch ($op) {
    case 'database_feed':
    if (isset($_POST['db_datas'])) {
        $db_datas = $_POST['db_datas'];
    }
    if (isset($_POST['catid'])) {
        $topic = $_POST['catid'];
    }

    if (';' == mb_substr($db_datas, -1)) {
        $db_datas = mb_substr($db_datas, 0, -1);
    }  // Get ride of the latest ; if necessary

    $patterns = [];      // Replace useless datas in SQL backup : update and insert values
    $replacements = [];
    $patterns[] = "/\`/";  // Clean queries
    $replacements[] = '';
    if (preg_match('/INSERT INTO/', $db_datas)) {
        $patterns[] = "/VALUES \(([0-9]+), /";  // Id suppression if insert

        $replacements[] = "VALUES ('', ";
    }
    if ($topic && preg_match('/edito_content/', $db_datas)) {
        if (preg_match('/UPDATE/', $db_datas)) {
            $patterns[] = '/catid = ([0-9]+), /'; // Topics definition & Id suppression

            $replacements[] = 'catid = ' . $topic . ', ';
        }

        if (preg_match('/INSERT INTO/', $db_datas)) {      // VALUES ('', 1, 1,
            $patterns[] = "/VALUES \('', ([0-9]+), /";  // Topics definition & Id suppression
            $replacements[] = "VALUES ('', " . $topic . ', ';
        }
    }
    $patterns[] = '/INSERT INTO (.*)edito_/';               // Table prefix : insert
    $replacements[] = 'INSERT INTO ' . XOOPS_DB_PREFIX . '_edito_';
    $patterns[] = '/REPLACE INTO (.*)edito_/';              // Table prefix : replace
    $replacements[] = 'REPLACE INTO ' . XOOPS_DB_PREFIX . '_edito_';
    $patterns[] = '/UPDATE (.*)edito_/';                    // Table prefix : update
    $replacements[] = 'UPDATE ' . XOOPS_DB_PREFIX . '_edito_';
    $db_datas = preg_replace($patterns, $replacements, $db_datas);
    $db_datas = explode(';', $db_datas);

    $i = 0;
    $ii = 0;
    $inserted = '';
    foreach ($db_datas as $db_data) { // For each insert, insert into DB if insert is valid
        if (preg_match('/_edito_/', mb_substr($db_data, 7, 35))) { // Insert datas for this module only ! ! !
            if ($xoopsDB->queryF($db_data)) {
                $inserted .= $db_data . ';<br>';

                ++$i;
            } else {
                $inserted .= '<font color="red">' . $db_data . ';</font><br>';
            }
        }

        ++$ii;
    }

    if ($inserted) { // Report results
        redirect_header('utils_import.php', $i + 2, $i . '/' . $ii . ' ' . _AM_EDITO_UPDATED . '<p style="text-align:left;">' . $inserted . '</p>');
    }
    redirect_header('utils_import.php', $i + 2, _AM_EDITO_NOTUPDATED);
    break;
  case 'utilities':
    default:
        require_once __DIR__ . '/admin_header.php';
        edito_adminmenu(2, _AM_EDITO_UTILITIES . '<br>' . _AM_EDITO_DB_IMPORT);
        edito_statmenu(3, '');
        utilities();
        require_once __DIR__ . '/admin_footer.php';
        break;
}
