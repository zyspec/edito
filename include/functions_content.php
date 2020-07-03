<?php declare(strict_types=1);
/**
 * XOOPS - PHP Content Management System
 * Copyright (c) 2004 <https://www.xoops.org>
 *
 * Module: edito 3.0
 * Licence : GPL
 * Authors :
 *           - solo (http://www.wolfpackclan.com/wolfactory)
 *			- DuGris (http://www.dugris.info)
 */
if (!defined('XOOPS_ROOT_PATH')) {
    die('XOOPS root path not defined');
}

// Check url and if on local, wether the destination file exists or not
/**
 * @param $url
 * @return string|string[]
 */
function edito_function_checkurl($url)
{
    if (!preg_match('/mailto:/i', $url) &&
        !preg_match("/http[s]:\/\//i", $url) &&
        !preg_match("/ftp[s]:\/\//i", $url)) {
        $url = XOOPS_ROOT_PATH . '/' . $url;
    } else {
        $url = preg_replace('/' . XOOPS_URL . '/i', XOOPS_ROOT_PATH, $url);
    }

    if (file_exists($url)) {
        $url = str_replace(XOOPS_ROOT_PATH, XOOPS_URL, $url);
    } else {
        $url = '';
    }

    return $url;
}

/**
 * @param $content
 * @param $urw
 * @return string
 */
function edito_cleankeywords($content, $urw)
{
    $content = strip_tags($content);

    $content = mb_strtolower($content);

    $content = htmlentities($content);

    $content = preg_replace('/&([a-zA-Z])(uml|acute|grave|circ|tilde);/', '$1', $content);

    $content = html_entity_decode($content);

    $content = str_ireplace("quot", ' ', $content);

    $content = preg_replace("/\'/", ' ', $content);

    $content = str_replace("-", ' ', $content);

    $content = preg_replace('/\[\[:punct:\]\]/i', '', $content);

    $content = preg_replace('/\[\[:digit:\]\]/i', '', $content);

    $words = explode(' ', $content);

    $keywords = '';

    foreach ($words as $word) {
        if (mb_strlen($word) >= $urw) {
            $keywords .= '-' . trim($word);
        }
    }

    if (!$keywords) {
        $keywords = '-';
    }

    return $keywords;
}

/**
 * @param string $link_url
 * @param string $title
 * @param string $alt_title
 * @param int    $urw
 * @return string
 */
function edito_urw($link_url = '', $title = '', $alt_title = '', $urw = 0)
{
    // Rewrite urls

    $target = XOOPS_ROOT_PATH . '/modules/edito/.htaccess';

    if (is_file($target)
     && !preg_match('/127\.0\.0\.1/', XOOPS_URL)
   ) {
        if ($alt_title) {
            $title = $alt_title;
        }

        $title = edito_cleankeywords($title, $urw);

        $id = explode('=', $link_url);

        if (mb_strstr($id[0], '../')) {
            $sub = '../';
        } else {
            $sub = '';
        }
//         if( isset($id[1]) ) { $link_url = $sub.'page-'.$id[1]. $title . '.html'; }

        if (isset($id[1])) {
            $link_url = $sub . $id[1] . $title . '.html';
        }
    }

    return $link_url;
}

/**
 * @return bool
 */
function edito_check_urw_htaccess()
{
    // Check if htaccess file exists

    $target = XOOPS_ROOT_PATH . '/modules/edito/.htaccess';

    if (!is_file($target)
    && function_exists('fopen')
    && function_exists('fwrite')
    && !preg_match('/127\.0\.0\.1/', XOOPS_URL)
   ) {
        $handle = @fopen($target, 'w+b');

        if ($handle) {
            $file_content = 'RewriteEngine on
                      RewriteRule	^page-([0-9]+)(-).*(\.html)$	content.php?id=$1	[L]';

            fwrite($handle, $file_content);

            fclose($handle);
        } else {
            return false;
        }

        return true;
    }

    if (is_file($target)) {
        return true;
    }
  

    return false;
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
 * @param int    $urw
 * @return string
 */
function edito_createlink($link_url = '', $title = '', $target = '_self', $image_url = '', $image_align = 'center', $image_max_width = '800', $image_max_height = '600', $alt_title = '', $urw = 0)
{
    // Initiate variables

    $a = '';

    $br = '';

    $link = '';

    $image = '';

    $align = '';

    $align_in = '';

    $align_out = '';

    $link_target = '';

    if ($image_url) {
        $image_url = edito_function_checkurl($image_url);
    }

    // Create link

    if ($link_url) {
        if (false === stripos($target, "self") and $target) {
            if ('_' == !mb_substr($target, 0, 1)) {
                $target = '_' . $target;
            }

            $link_target = 'target="' . $target . '" ';
        }

        if ($urw && edito_check_urw_htaccess()) {
            $link_url = edito_urw($link_url, $title, $alt_title, $urw);
        }

        $alt_title = preg_replace('/\"/', '', $alt_title);

        $link = '<a href="' . $link_url . '" ' . $link_target . 'title="' . strip_tags($alt_title) . '">';

        $a = '</a>';
    }

    // Create image

    if ($image_url) {
        $image_size = @getimagesize($image_url);

        if ($image_size) {
            if ($image_size[1] >= $image_max_height) {
                $height = 'height="' . $image_max_height . '" ';
            } else {
                $height = '';
            }

            if ($image_size[0] >= $image_max_width) {
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

    $result = $align_in . $link . $image . $br . $title . $a . $align_out;

    return $result;
}

/**
 * @param string $body_text
 * @param string $pagebreak
 * @param int    $current_page
 * @param string $item
 * @return mixed|string
 */
function edito_pagebreak($body_text = '', $pagebreak = '[pagebreak]', $current_page = 0, $item = '')
{
    $array_text = explode('[pagebreak]', $body_text);

    $total_pages = count($array_text);

    if ($total_pages > 1) {
        global $xoopsTpl;

        $pagenav = new XoopsPageNav($total_pages, 1, $current_page, 'page', $item);

        $xoopsTpl->assign('breaknav', $pagenav->renderImageNav());

        $body_text = $array_text[$current_page];
    }

    return $body_text;
}
