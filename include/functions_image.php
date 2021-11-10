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
if (!defined('XOOPS_ROOT_PATH')) {
    die('XOOPS root path not defined');
}

/**
 * @param string $link_url
 * @param string $title
 * @param string $target
 * @param string $image_url
 * @param string $image_align
 * @param string $image_max_width
 * @param string $image_max_height
 * @param string $alt_title
 * @return string
 */
function edito_createlink($link_url = '', $title = '', $target = '_self', $image_url = '', $image_align = 'center', $image_max_width = '800', $image_max_height = '600', $alt_title = '')
{
    // Initiate variables

    $image = '';

    $br = '';

    $align = '';

    $align_in = '';

    $align_out = '';

    $link = '';

    $a = '';

    $link_target = '';

    // Create link

    if ($link_url) {
        if (false === mb_stripos($target, 'self') and $target) {
            if ('_' == !mb_substr($target, 0, 1)) {
                $target = '_' . $target;
            }

            $link_target = 'target="' . $target . '" ';
        }

        $link = '<a href="' . $link_url . '" ' . $link_target . 'title="' . strip_tags($alt_title) . '">';

        $a = '</a>';
    }

    // Create image

    if ($image_url) {
        $image_size = @getimagesize($image_url);

        if ($image_size) {
            if ($image_size[1] > $image_max_height) {
                $height = 'height="' . $image_max_height . '" ';
            } else {
                $height = '';
            }

            if ($image_size[0] > $image_max_width) {
                $width = 'width="' . $image_max_width . '" ';

                $height = '';
            } else {
                $width = '';
            }

            if ('center' == $image_align) {
                $br = '<br>';

                $align_in = '<div style="text-align:center;">';

                $align_out = '</div>';
            } else {
                $align = 'align="' . $image_align . '" ';

                $title = '';
            }

            $image = '<img src="' . $image_url . '" alt="' . strip_tags($alt_title) . '" ' . $align . '' . $width . '' . $height . '>';
        }
    }

    return $align_in . $link . $image . $br . $title . $a . $align_out;
}
