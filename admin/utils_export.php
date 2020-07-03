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
 * @author    XOOPS Module Development Team
 * @link      https://github.com/XoopsModules25x/edito
 */

use Xmf\Request;

require_once dirname(__DIR__, 3) . '/mainfile.php';
require_once dirname(__DIR__, 3) . '/include/cp_header.php';

$op = Request::getCmd('op', '');
/*
$op = '';
if ( isset( $_GET['op'] ) )      $op = $_GET['op'];
if ( isset( $_POST['op'] ) )     $op = $_POST['op'];
// if ( isset( $_POST['table'] ) )  $table = $_POST['table'];
*/

/**
 * @param string $table
 */
function select($table = '')
{
    global $xoopsConfig, $modify, $xoopsModule, $xoopsDB;

    $op = Request::getCmd('op', 'database_export_insert', 'POST');

    // DB feed

    $sform = new XoopsThemeForm(_AM_EDITO_DB_EXPORT, 'op', xoops_getenv('SCRIPT_NAME'));

    $sform->setExtra('enctype="multipart/form-data"');

    // Tables

    // Code to create the tables selector

    /*
        $tables = array('edito_content');

        $tables_array = $tables;
        $tables_select = new XoopsFormSelect( '', 'table', $table);
        $tables_select -> addOptionArray( $tables_array );
        $tables_tray = new XoopsFormElementTray( _AM_EDITO_DB_DATAS, '&nbsp;' );
        $tables_tray -> addElement( $tables_select );
        $sform -> addElement( $tables_tray );
    */

    // Data conversion

    // Code to define how to export datas

    $export_radio = new XoopsFormRadio(_AM_EDITO_TYPE, 'op', $op, '<br>');

    $export_radio->addOption('database_export_insert', _AM_EDITO_INSERT);

    $export_radio->addOption('database_export_update', _AM_EDITO_UPDATE);

    $sform->addElement($export_radio);

    $button_tray = new XoopsFormElementTray('', '');

    $butt_create = new XoopsFormButton('', '', _AM_EDITO_EXPORT, 'submit');

    $button_tray->addElement($butt_create);

    $sform->addElement($button_tray);

    $sform->display();
}

/**
 * @param $result
 * @param $count
 * @param $table
 */
function display($result, $count, $table)
{
    $sform = new XoopsThemeForm(_AM_EDITO_DB_DATAS, '', '');

    $sform->addElement($javascript01);

    $sform->addElement(new XoopsFormTextArea('Table : ' . $table . '<br>Total : ' . $count . ' ' . _AM_EDITO_DB_DATAS, '', $result, 20), false);

    $sform->display();
}

/**
 * @param $table
 * @return array
 */
function edito_table_rows($table)
{
    global $xoopsDB;

    $sql = ' DESCRIBE ' . XOOPS_DB_PREFIX . '_' . $table;

    $result = $xoopsDB->queryF($sql);

    $i = 0;

    $datas = [];

    while (list($name, $format) = $xoopsDB->fetchRow($result)) {
        $datas[$i]['name'] = $name;

        $datas[$i++]['format'] = $format;
    }

    return $datas;
}

/**
 * @param        $table
 * @param string $nul_rows
 * @return mixed
 */
function create_db_results_insert($table, $nul_rows = 'id')
{
    global $xoopsDB;

    $variables = '';

    $sql_datas['count'] = 0;

    $variables_data = '';

    $ret = '';

    $num_rows = 'int';

    $sql = ' SELECT * FROM ' . $xoopsDB->prefix($table);

    $result = $xoopsDB->queryF($sql);

    $pattern_nul = explode('|', $nul_rows);

    $pattern_num = explode('|', $num_rows);

    $rows = edito_table_rows($table);

    $i = 0;

    $sql_datas['db'] = '
--
-- Content for table `' . $table . '`
--
';

    foreach ($rows as $row) {
        $variables .= '$' . $row['name'] . ', ';

        $isnum = 0;

        $isnul = 0;

        foreach ($pattern_num as $num) {
            if (preg_match("/{$num}/", $row['format'])) {
                $isnum = 1;
            }
        }

        foreach ($pattern_nul as $this_pattern) {
            if ($this_pattern == $row['name']) {
                $isnul = 1;
            }
        }

        if ($isnum && !$isnul) {
            $variables_data .= '" . $' . $row['name'] . ' . ", ';
        } elseif ($isnul) {
            $variables_data .= '\'\', ';
        } else {
            $variables_data .= '\'" . addslashes($' . $row['name'] . ') . "\', ';
        }
    }

    $ret .= 'while(list( ';

    $ret .= mb_substr($variables, 0, -2);

    $ret .= ' ) = $xoopsDB->fetchRow($result))
    	           { $sql_datas["count"]++;
                         $sql_datas["db"] .= "

INSERT INTO " . $table . " VALUES (';

    $ret .= mb_substr($variables_data, 0, -2);

    $ret .= ');";';

    $ret .= '}';

    eval($ret);

    return $sql_datas;
}

/**
 * @param        $table
 * @param string $nul_rows
 * @return mixed
 */
function create_db_results_update($table, $nul_rows = 'id')
{
    global $xoopsDB;

    $variables = '';

    $sql_datas['count'] = 0;

    $variables_data = '';

    $ret = '';

    $num_rows = 'int';

    $sql = ' SELECT * FROM ' . $xoopsDB->prefix($table);

    $result = $xoopsDB->queryF($sql);

    $pattern_nul = explode('|', $nul_rows);

    $pattern_num = explode('|', $num_rows);

    $rows = edito_table_rows($table);

    $i = 0;

    $sql_datas['db'] = '
--
-- Contenu de la table `' . $table . '`
--
';

    foreach ($rows as $row) {
        $variables .= '$' . $row['name'] . ', ';

        $isnum = 0;

        $isnul = 0;

        if (0 == $i) {
            $id = $row['name'];

            ++$i;
        }

        foreach ($pattern_num as $num) {
            if (preg_match("/{$num}/", $row['format'])) {
                $isnum = 1;
            }
        }

        foreach ($pattern_nul as $nul) {
            if ($row['name'] == $nul) {
                $isnul = 1;
            }
        }

        if ($isnum && !$isnul) {
            $variables_data .= ' ' . $row['name'] . '=" . $' . $row['name'] . ' . ", ';
        } elseif ($isnul) {
            // $id = $row['name'];
        } else {
            $variables_data .= ' ' . $row['name'] . '=\'" . addslashes($' . $row['name'] . ') . "\', ';
        }
    }

    $ret .= 'while(list( ';

    $ret .= mb_substr($variables, 0, -2);

    $ret .= ' ) = $xoopsDB->fetchRow($result))
    	           { $sql_datas["count"]++;
                         $sql_datas["db"] .= "

UPDATE " . $table . " SET ';

    $ret .= mb_substr($variables_data, 0, -2);

    $ret .= ' WHERE \'' . $id . '\'=$' . $id . ';";';

    $ret .= '}';

    // UPDATE 214_edito_bot SET botid = 1, status = 1, bot_name = 'Francis', bot_description = 'Responsable du d�partement bois.', bot_image = '', bot_directory = 'uploads/edito/francis/', bot_background = 'francis_bkg.jpg|', text_color = 'black|white no-repeat top left|green|white|2px', topics = ' Eliza', start = 'Bonjour, comment puis-je vous aider ?|Bienvenue dans le d�partement bois, comment puis-je vous �tre utile ?|Bonjour. Si vous avez des questions, je suis � votre disposition.', dumb = 'Hmm...|Int�ressant.|Ah ?|Ah !|Oh oh...', zero = 'Excusez-moi, mais je ne comprend pas votre question.|Je ne suis pas s�r de bien comprendre...|Pourriez-vous pr�ciser votre demande ?|Pour que je puisse bien vous comprendre, il vaut mieux poser des questions simples.|Si ma r�ponse ne vous satisfait pas, n''h�sitez pas � me contacter en direct.', end = 'Nous avons fait le tour de la question.|Je n''ai rien d''autre � ajouter � ce sujet pour le moment.|Pour plus d''information, contactez-moi directement.|Vous pouvez passer au magasin pour plus d''information.|Que puis-je faire d''autre pour vous ?|Souhaitez-vous avoir d''autres renseignements ? Dans quel domaine ?', groups = '1 2 3'

    // WHERE  `botid` = 1;

    eval($ret);

    return $sql_datas;
}

switch ($op) {
    case 'database_export_insert':
        require_once __DIR__ . '/admin_header.php';
        edito_adminmenu(6, _AM_EDITO_INSERT);
        edito_statmenu(2, '');
        select('content_edito');
        $datas = create_db_results_insert('edito_content', 'id');
        display($datas['db'], $datas['count'], 'edito_content');
        require_once __DIR__ . '/admin_footer.php';
        break;
    case 'database_export_update':
        require_once __DIR__ . '/admin_header.php';
        edito_adminmenu(6, _AM_EDITO_UPDATE);
        edito_statmenu(2, '');
        select('edito_content');
        $datas = create_db_results_update($table, 'id');
        display($datas['db'], $datas['count'], $table);
        require_once __DIR__ . '/admin_footer.php';
        break;
    case 'utilities':
    default:
        require_once __DIR__ . '/admin_header.php';
        edito_adminmenu(2, _AM_EDITO_UTILITIES . '<br>' . _AM_EDITO_DB_EXPORT);
        edito_statmenu(2, '');
        select();
        require_once __DIR__ . '/admin_footer.php';
        break;
}
