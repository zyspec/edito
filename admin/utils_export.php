<?php
/**
* Module: edito
* Licence : GPL
* Authors :
*           - solo (http://www.wolfpackclan.com)
*/
               

	 include_once( '../../../mainfile.php');
	 include_once( '../../../include/cp_header.php');

$op = '';

if ( isset( $_GET['op'] ) )      $op = $_GET['op'];
if ( isset( $_POST['op'] ) )     $op = $_POST['op'];
// if ( isset( $_POST['table'] ) )  $table = $_POST['table'];

function select($table='')
	{
		global $xoopsConfig, $modify, $xoopsModule, $xoopsDB;
		$op='database_export_insert';
                if ( isset( $_POST['op'] ) )     $op = $_POST['op'];
		// DB feed
		$sform = new XoopsThemeForm( _MD_EDITO_DB_EXPORT, "op", xoops_getenv( 'PHP_SELF' ) );
		$sform -> setExtra( 'enctype="multipart/form-data"' );
// Tables
	// Code to create the tables selector 
/*
                $tables = array('content_edito');

        	$tables_array = $tables;
         	$tables_select = new XoopsFormSelect( '', 'table', $table);
        	$tables_select -> addOptionArray( $tables_array );
        	$tables_tray = new XoopsFormElementTray( _MD_EDITO_DB_DATAS, '&nbsp;' );
        	$tables_tray -> addElement( $tables_select );
        	$sform -> addElement( $tables_tray );
 */

// Data conversion
	// Code to define how to export datas
	        $export_radio = new XoopsFormRadio(_MD_EDITO_TYPE, 'op', $op);
	        $export_radio->addOption("database_export_insert", _MD_EDITO_INSERT.'<br />');
	        $export_radio->addOption("database_export_update", _MD_EDITO_UPDATE);
	        $sform -> addElement( $export_radio );

		$button_tray = new XoopsFormElementTray( '', '' );
		$butt_create = new XoopsFormButton( '', '', _MD_EDITO_EXPORT, 'submit' );
		$button_tray->addElement( $butt_create );
		$sform -> addElement( $button_tray );
		$sform -> display();
		unset( $hidden );
	 }

function display( $result, $count, $table ) {
  
         	$sform = new XoopsThemeForm( _MD_EDITO_DB_DATAS, '', '' );
         	$sform->addElement($javascript01);
		$sform->addElement(new XoopsFormTextArea('Table : '.$table.'<br />Total : '.$count.' '._MD_EDITO_DB_DATAS,    '', $result, 20 ), FALSE );
		$sform -> display();
}

function edito_table_rows( $table ) {
                Global $xoopsDB;
                $sql =  ' DESCRIBE ' . XOOPS_DB_PREFIX.'_'.$table;
                $result = $xoopsDB->queryF( $sql );
                $i=0;
                $datas=array();
                while ( list( $name, $format ) = $xoopsDB -> fetchrow( $result ) ) { $datas[$i]['name']=$name; $datas[$i++]['format']=$format; }
return $datas;
}

function create_db_results_insert( $table, $nul_rows='id' ) {
                Global $xoopsDB;
                $variables=''; $sql_datas["count"]=0; $variables_data=''; $ret='';
                $num_rows ='int';
                $sql = " SELECT * FROM ".$xoopsDB->prefix($table);
                $result = $xoopsDB->queryF($sql);
                $pattern_nul = explode('|', $nul_rows);
                $pattern_num = explode('|', $num_rows);
                $rows = edito_table_rows( $table );
                $i=0;
$sql_datas["db"] = '
--
-- Contenu de la table `'.$table.'`
--
';
                foreach($rows as $row) { $variables .= '$'.$row['name'].', ';
                $isnum=0;$isnul=0;
                foreach($pattern_num as $num) { if( ereg($num,$row['format']) ) { $isnum=1; } }
                foreach($pattern_nul as $nul) { if( $row['name']==$nul )        { $isnul=1; } }
                                         if( $isnum && !$isnul) {  $variables_data .= '" . $'.$row['name'].' . ", '; }
                                     elseif( $isnul ) {  $variables_data .= '\'\', '; }
                                     else             {  $variables_data .= '\'" . addslashes($'.$row['name'].') . "\', '; }
                                          }
                $ret .= 'while(list( ';
                $ret .= substr($variables,0,-2);
                $ret .= ' ) = $xoopsDB->fetchRow($result))
                	           { $sql_datas["count"]++;
                                     $sql_datas["db"] .= "

INSERT INTO " . $table . " VALUES (';
                $ret .= substr($variables_data,0,-2);
                $ret .= ');";';
                $ret .= '}';
                eval($ret);
return $sql_datas;
}

function create_db_results_update( $table, $nul_rows='id' ) {
                Global $xoopsDB;
                $variables=''; $sql_datas["count"]=0; $variables_data=''; $ret='';
                $num_rows ='int';
                $sql = " SELECT * FROM ".$xoopsDB->prefix($table);
                $result = $xoopsDB->queryF($sql);
                $pattern_nul = explode('|', $nul_rows);
                $pattern_num = explode('|', $num_rows);
                $rows = edito_table_rows( $table );
                $i=0;
$sql_datas["db"] = '
--
-- Contenu de la table `'.$table.'`
--
';
                foreach($rows as $row) { $variables .= '$'.$row['name'].', ';
                $isnum=0;$isnul=0;
                if($i==0) { $id = $row['name'];$i++; }
                foreach($pattern_num as $num) { if( ereg($num,$row['format']) ) { $isnum=1; } }
                foreach($pattern_nul as $nul) { if( $row['name']==$nul )        { $isnul=1; } }
                                         if( $isnum && !$isnul) {  $variables_data .= ' '.$row['name'].'=" . $'.$row['name'].' . ", '; }
                                     elseif( $isnul ) {  // $id = $row['name'];
                                     }
                                     else             {  $variables_data .= ' '.$row['name'].'=\'" . addslashes($'.$row['name'].') . "\', '; }
                                          }
                $ret .= 'while(list( ';
                $ret .= substr($variables,0,-2);
                $ret .= ' ) = $xoopsDB->fetchRow($result))
                	           { $sql_datas["count"]++;
                                     $sql_datas["db"] .= "

UPDATE " . $table . " SET ';
                $ret .= substr($variables_data,0,-2);
                $ret .= ' WHERE \''.$id.'\'=$'.$id.';";';
                $ret .= '}';

// UPDATE 214_edito_bot SET botid = 1, status = 1, bot_name = 'Francis', bot_description = 'Responsable du département bois.', bot_image = '', bot_directory = 'uploads/edito/francis/', bot_background = 'francis_bkg.jpg|', text_color = 'black|white no-repeat top left|green|white|2px', topics = ' Eliza', start = 'Bonjour, comment puis-je vous aider ?|Bienvenue dans le département bois, comment puis-je vous être utile ?|Bonjour. Si vous avez des questions, je suis à votre disposition.', dumb = 'Hmm...|Intéressant.|Ah ?|Ah !|Oh oh...', zero = 'Excusez-moi, mais je ne comprend pas votre question.|Je ne suis pas sûr de bien comprendre...|Pourriez-vous préciser votre demande ?|Pour que je puisse bien vous comprendre, il vaut mieux poser des questions simples.|Si ma réponse ne vous satisfait pas, n''hésitez pas à me contacter en direct.', end = 'Nous avons fait le tour de la question.|Je n''ai rien d''autre à ajouter à ce sujet pour le moment.|Pour plus d''information, contactez-moi directement.|Vous pouvez passer au magasin pour plus d''information.|Que puis-je faire d''autre pour vous ?|Souhaitez-vous avoir d''autres renseignements ? Dans quel domaine ?', groups = '1 2 3'
// WHERE  `botid` = 1;
                eval($ret);
return $sql_datas;
}


switch ( $op )
{
  case "database_export_insert":
    	include_once( "admin_header.php" );
        edito_adminmenu(6, _MD_EDITO_INSERT);
        edito_statmenu(2, '');
        select('content_edito');
        $datas = create_db_results_insert('content_edito','id');
        display( $datas["db"], $datas["count"], 'content_edito' );
        include_once( 'admin_footer.php' );

    exit();
    break;

  case "database_export_update":
    	include_once( "admin_header.php" );
        edito_adminmenu(6, _MD_EDITO_UPDATE);
        edito_statmenu(2, '');
        select('content_edito');
        $datas = create_db_results_update($table,'id');
        display( $datas["db"], $datas["count"], $table );
        include_once( 'admin_footer.php' );

    exit();
    break;

  case "utilities":
  	default:
  	include_once( "admin_header.php" );
        edito_adminmenu(2, _MD_EDITO_UTILITIES.'<br />'._MD_EDITO_DB_EXPORT);
        edito_statmenu(2, '');
        select();
        include_once( 'admin_footer.php' );
    break;

}

?>