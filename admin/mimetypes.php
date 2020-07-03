<?php

declare(strict_types=1);

/**
 * XOOPS - PHP Content Management System
 * Copyright (c) 2001 - 2006 <https://www.xoops.org>
 *
 * Module: MimeTypes 1.0
 * Licence : GPL
 * Authors :
 *            - DuGris (http://www.dugris.info)
 */
require_once dirname(__DIR__, 3) . '/mainfile.php';
require_once dirname(__DIR__, 3) . '/include/cp_header.php';
require_once dirname(__DIR__, 3) . '/include/functions.php';

xoops_cp_header();
require_once __DIR__ . '/mimetypesadmin.php';
xoops_cp_footer();
