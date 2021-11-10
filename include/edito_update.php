<?php

declare(strict_types=1);

/**
 * XOOPS - PHP Content Management System
 * Copyright (c) 2004 <https://www.xoops.org>
 *
 * Module: edito 3.0
 * Licence : GPL
 * Authors :
 *           - solo (http://www.wolfpackclan.com/wolfactory)
 *            - DuGris (http://www.dugris.info)
 */
if (!defined('EDITO_DIRNAME')) {
    define('EDITO_DIRNAME', 'edito');
}

if (!defined('EDITO_ROOT_PATH')) {
    define('EDITO_ROOT_PATH', XOOPS_ROOT_PATH . '/modules/' . EDITO_DIRNAME . '/');
}

require_once EDITO_ROOT_PATH . 'include/edito_install.php';
