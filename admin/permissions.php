<?php
/**
* XOOPS - PHP Content Management System
* Copyright (c) 2004 <http://www.xoops.org/>
*
* Module: edito 3.0
* Licence : GPL
* Authors :
*           - solo (http://www.wolfpackclan.com/wolfactory)
*			- DuGris (http://www.dugris.info)
*/

include_once("admin_header.php");
include_once XOOPS_ROOT_PATH . '/class/xoopsform/grouppermform.php';

if ( !is_object($xoopsUser) or (is_object($xoopsUser) and !$xoopsUser->isadmin() ) ){
    redirect_header("javascript:history.go(-1)", 1, _NOPERM);
    exit;
}

$op = '';

foreach ($_POST as $k => $v) {
    ${$k} = $v;
}

foreach ($_GET as $k => $v) {
    ${$k} = $v;
}

$myts =& MyTextSanitizer::getInstance();
myReferer_adminmenu(6, _MD_MYREFERER_PERMISSIONS);

$item_list_view = array();
$block_view = array();

echo "<h3 style='color: #2F5376; font-weight: bold; font-size: 14px; margin: 6px 0 0 0; '>" . _MD_MYREFERER_PERMISSIONS_DSC . "</h3>";

$form_view = new XoopsGroupPermForm("", $xoopsModule->getVar('mid'), "myReferer_wiew", "");
$form_view->addItem(1, _MD_EDITO_REFERER);
$form_view->addItem(2, _MD_EDITO_ENGINE);
$form_view->addItem(3, _MD_EDITO_KEYWORDS);
$form_view->addItem(4, _MD_EDITO_QUERY);
$form_view->addItem(5, _MD_EDITO_ROBOTS);
$form_view->addItem(6, _MD_EDITO_PAGE);

echo $form_view->render();

include_once( 'admin_footer.php' );
?>