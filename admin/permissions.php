<?php

declare(strict_types=1);

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
require_once __DIR__ . '/admin_header.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsform/grouppermform.php';

if (!is_object($xoopsUser) || (is_object($xoopsUser) && !$xoopsUser->isAdmin())) {
    redirect_header('javascript:history.go(-1)', 1, _NOPERM);
}

$op = '';
//@todo sanitize this input - this is VERY dangerous
foreach ($_POST as $k => $v) {
    ${$k} = $v;
}

foreach ($_GET as $k => $v) {
    ${$k} = $v;
}

$myts = \MyTextSanitizer::getInstance();
myReferer_adminmenu(6, _AM_MYREFERER_PERMISSIONS);

$item_list_view = [];
$block_view     = [];

echo "<h3 style='color: #2F5376; font-weight: bold; font-size: 14px; margin: 6px 0 0 0; '>" . _AM_MYREFERER_PERMISSIONS_DSC . '</h3>';

$form_view = new \XoopsGroupPermForm('', $xoopsModule->getVar('mid'), 'myReferer_wiew', '');
$form_view->addItem(1, _AM_EDITO_REFERER);
$form_view->addItem(2, _AM_EDITO_ENGINE);
$form_view->addItem(3, _AM_EDITO_KEYWORDS);
$form_view->addItem(4, _AM_EDITO_QUERY);
$form_view->addItem(5, _AM_EDITO_ROBOTS);
$form_view->addItem(6, _AM_EDITO_PAGE);

echo $form_view->render();

require_once __DIR__ . '/admin_footer.php';
