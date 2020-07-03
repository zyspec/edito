<?php declare(strict_types=1);

if (!defined('XOOPS_ROOT_PATH')) {
    die('XOOPS root path not defined');
}

// referer check
$ref = xoops_getenv('HTTP_REFERER');
if ('' == $ref || 0 === mb_strpos($ref, XOOPS_URL . '/modules/system/admin.php')) {
    /* module specific part */

    /* General part */

    // Keep the values of block's options when module is updated (by nobunobu)

    include __DIR__ . '/updateblock.inc.php';
}
