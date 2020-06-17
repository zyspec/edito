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

if ( isset( $_GET['op'] ) ) $op = $_GET['op'];
if ( isset( $_POST['op'] ) ) $op = $_POST['op'];

function utilities()
	{
                global $xoopsConfig, $modify, $xoopsModule, $xoopsDB;
// DB feed
		$sform = new XoopsThemeForm( _MD_EDITO_DB_IMPORT, "op", xoops_getenv( 'PHP_SELF' ) );
		$sform -> setExtra( 'enctype="multipart/form-data"' );
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
        	$topics_tray = new XoopsFormElementTray( _MD_EDITO_TOPIC._MD_EDITO_TOPIC_INFOS, '&nbsp;' );
        	$topics_tray -> addElement( $topics_select );
        	$sform -> addElement( $topics_tray );
*/
                $sform->addElement(new XoopsFormTextArea(_MD_EDITO_DB_DATAS,    'db_datas', '', 20, 90 ), TRUE );

		$button_tray = new XoopsFormElementTray( '', '' );
		$hidden = new XoopsFormHidden( 'op', 'database_feed' );
		$button_tray -> addElement( $hidden );
		$butt_create = new XoopsFormButton( '', '', _MD_EDITO_SUBMIT, 'submit' );
		$butt_create->setExtra('onclick="this.form.elements.op.value=\'database_feed\'"');
		$button_tray->addElement( $butt_create );
		$butt_clear = new XoopsFormButton( '', '', _MD_EDITO_CLEAR, 'reset' );
		$button_tray->addElement( $butt_clear );
		$sform -> addElement( $button_tray );
		$sform -> display();
		unset( $hidden );
	 }
	 

/* -- Available operations -- */
switch ( $op )
{

  case "database_feed":
                if ( isset( $_POST['db_datas'] ) ) { $db_datas = $_POST['db_datas']; }
                if ( isset( $_POST['catid'] ) ) { $topic = $_POST['catid']; }

                if (substr($db_datas, -1) == ';') { $db_datas = substr($db_datas, 0, -1); }  // Get ride of the latest ; if necessary

             		 $patterns = array();                                                // Replace useless datas in SQL backup : update and insert values
          		 $replacements = array();
          		 $patterns[] = "/\`/";                                               // Clean queries
          		 $replacements[] = "";
          	if( ereg('INSERT INTO', $db_datas) ) {
                         $patterns[]     = "/VALUES \(([0-9]+), /";                               // Id suppression if insert
          		 $replacements[] = "VALUES ('', ";
                }
                if( $topic && ereg('edito_content', $db_datas) ) {
                         if( ereg('UPDATE', $db_datas) ) {
                             $patterns[]     = "/catid = ([0-9]+), /";                                // Topics definition & Id suppression
              		     $replacements[] = "catid = ".$topic.", ";
          		 }
          		 if( ereg('INSERT INTO', $db_datas) ) {                        // VALUES ('', 1, 1,
          		     $patterns[]     = "/VALUES \('', ([0-9]+), /";      // Topics definition & Id suppression
          		     $replacements[] = "VALUES ('', ".$topic.", ";
          		 }
                }
          		 $patterns[]     = "/INSERT INTO (.*)edito_/";                         // Table prefix : insert
          		 $replacements[] = "INSERT INTO ".XOOPS_DB_PREFIX."_edito_";
          		 $patterns[]     = "/REPLACE INTO (.*)edito_/";                         // Table prefix : replace
          		 $replacements[] = "REPLACE INTO ".XOOPS_DB_PREFIX."_edito_";
          		 $patterns[]     = "/UPDATE (.*)edito_/";                               // Table prefix : update
          		 $replacements[] = "UPDATE ".XOOPS_DB_PREFIX."_edito_";
          		 $db_datas = preg_replace($patterns, $replacements, $db_datas);
          		 $db_datas = explode(';', $db_datas);

                $i=0;
                $ii=0;
                $inserted = '';
                foreach( $db_datas as $db_data) {                                         // For each insert, insert into DB if insert is valid
                if( ereg('_edito_', substr($db_data, 7, 35)) ) {                          // Insert datas for this module only ! ! !
                    if ( $xoopsDB -> queryF( $db_data ) ) { $inserted .= $db_data.';<br />'; $i++;}  else { $inserted .= '<font color="red">'.$db_data.';</font><br />'; }
                    }
                $ii++;
                }

		if ( $inserted )                                                              // Report results
			{       redirect_header( "utils_import.php", $i+2, $i.'/'.$ii.' '._MD_EDITO_UPDATED . '<p style="text-align:left;">' . $inserted . '</p>' );
			} else {
				redirect_header( "utils_import.php", $i+2, _MD_EDITO_NOTUPDATED);
			}
    exit();
    break;


  case "utilities":
  	default:
  	    include_once( "admin_header.php" );
        edito_adminmenu(2, _MD_EDITO_UTILITIES.'<br />'._MD_EDITO_DB_IMPORT);
        edito_statmenu(3, '');
        utilities();
        include_once( 'admin_footer.php' );
    break;

}

?>