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
 * @package   \XoopsModules\Edito
 * @copyright Copyright {@link https://xoops.org XOOPS Project}
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 * @author    Solo (http://www.wolfpackclan.com/wolfactory)
 * @author    DuGris (http://www.dugris.info)
 * @author    XOOPS Module Development Team
 * @link      https://github.com/XoopsModules25x/edito
 */

defined('XOOPS_ROOT_PATH') || exit('Restricted access');

// Check url and if on local, wether the destination file exists or not
/**
 * @param  string  $url
 * @return  string|string[]
 */
function edito_function_checkurl($url)
{
	if (!preg_match("/mailto:/i", $url) &&
		!preg_match("/http[s]:\/\//i", $url) &&
        !preg_match("/ftp[s]:\/\//i", $url)) {
    	$url = XOOPS_ROOT_PATH . '/' . $url ;
	} else {
		$url = preg_replace('/' . XOOPS_URL . '/i', XOOPS_ROOT_PATH, $url );
	}

    $url = '';
	if (file_exists($url) && is_file($url)) {
    	$url = str_replace(XOOPS_ROOT_PATH, XOOPS_URL, $url);
    }

	return $url;
}

/**
 * @param  string  $content
 * @param  int  $urw
 * @return  string
 */
function edito_cleankeywords($content, $urw)
{
        $content = strip_tags($content);
        $content = mb_strtolower($content);
        $content = htmlentities($content, ENT_QUOTES | ENT_HTML5);
        $content = preg_replace('/&([a-zA-Z])(uml|acute|grave|circ|tilde);/', '$1', $content);
        $content = html_entity_decode($content);
        $content = preg_replace('/quot/i', ' ', $content);
        $content = preg_replace("/\'/", ' ', $content);
        $content = preg_replace('/-/', ' ', $content);
        $content = preg_replace('/\[\[:punct:\]\]/i', '', $content);
        $content = preg_replace('/\[\[:digit:\]\]/i', '', $content);

        $words = explode(' ', $content);
        $keywords = '';
        foreach($words as $word) {
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
 * @param  null|string  $link_url
 * @param  null|string  $title
 * @param  null|string  $alt_title
 * @param  null|int  $urw
 * @return  string
 */
function edito_urw($link_url = '', $title = '', $alt_title = '', $urw = 0)
{
    // Rewrite urls
    $target = XOOPS_ROOT_PATH.'/modules/edito/.htaccess';
    if (is_file($target)
     && !preg_match('/127\.0\.0\.1/', XOOPS_URL))
    {
        if ($alt_title) {
            $title = $alt_title;
        }
        $title = edito_cleankeywords($title, $urw);
        $id    = explode('=', $link_url);
        $sub   = '';
        if (mb_strstr($id[0], '../')) {
            $sub = '../';
        }
        if (isset($id[1])) {
            //$link_url = $sub.'page-'.$id[1]. $title . '.html';
            $link_url = $sub . $id[1] . $title . '.html';
        }
    }
    return $link_url;
}

/**
 * @return  bool
 */
function edito_check_urw_htaccess()
{
    // Check if htaccess file exists
    $target = XOOPS_ROOT_PATH.'/modules/edito/.htaccess';
    if (!is_file($target)
        && function_exists('fopen')
        && function_exists('fwrite')
        && !preg_match('/127\.0\.0\.1/', XOOPS_URL))
    {
        $handle =  @fopen($target, 'w+b');
		if ($handle) {
            $file_content = 'RewriteEngine on
                RewriteRule	^page-([0-9]+)(-).*(\.html)$	content.php?id=$1	[L]';
            fwrite($handle, $file_content);
            fclose($handle);
            return true;
        } else {
		    return false;
		}
    }
    return is_file($target);
}

/**
 * @param  null|string  $link_url
 * @param  null|string  $title
 * @param  null|string  $target
 * @param  null|string  $image_url
 * @param  null|string  $image_align
 * @param  null|string  $image_max_width
 * @param  null|string  $image_max_height
 * @param  null|string  $alt_title
 * @param  null|int  $urw
 * @return  string
 */
function edito_createlink($link_url = '', $title = '', $target = '_self', $image_url = '', $image_align = 'center', $image_max_width = '800', $image_max_height = '600', $alt_title = '', $urw = 0 )
{
    // Initiate variables
	$a           = '';
    $br          = '';
    $link        = '';
    $image       = '';
    $align       = '';
    $align_in    = '';
    $align_out   = '';
    $link_target = '';

	if ($image_url) {
        $image_url = edito_function_checkurl($image_url);
    }

	// Create link
    if ($link_url) {
    	if ($target && !preg_match('/self/i', $target)) {
        	if ('_' !== substr($target, 0, 1)) {
        	    $target = '_' . $target;
        	}
            $link_target = 'target="' . $target . '" ';
		}

        if ($urw && edito_check_urw_htaccess()) {
            $link_url = edito_urw($link_url, $title, $alt_title, $urw);
        }
        $alt_title = preg_replace('/\"/', '', $alt_title);
        $link = '<a href="' . $link_url . '" ' . $link_target . 'title="' . strip_tags($alt_title) . '">';
        $a    = '</a>';
	}

    // Create image
    //@todo refactor this code to scale image if either height or width is too big
	if ($image_url) {
		$image_size = getimagesize($image_url);
		if (false !== $image_size) {
        	if ($image_size[1] >= $image_max_height ) {
            	$height = ' height="' . $image_max_height . '" ';
            } else {
                $height  = '';
            }

            $width = '';
            if ($image_size[0] >= $image_max_width)  {
            	$width  = ' width="' . $image_max_width . '" ';
                $height = '';
            }

            if ( 'center' == $image_align) {
            	$br        = '<br>';
                $align_in  = '<div style="text-align:center;">';
                $align_out = '</div>';
            } else {
            	$align = ' align="' . $image_align . '"';
                $title = '';
            }

			$image = '<img src="' . $image_url . '" alt="' . strip_tags($alt_title) . '"' . $align . $width . $height . '>';
    	}
	}

    return $align_in . $link . $image . $br . $title . $a . $align_out;
}

/**
 * @param  null|string  $body_text
 * @param  null|string  $pagebreak
 * @param  null|int  $current_page
 * @param  null|string  $item
 * @return  mixed|string
 */
function edito_pagebreak($body_text = '', $pagebreak = '[pagebreak]', $current_page = 0, $item = '')
{
	$array_text  = explode('[pagebreak]', $body_text);
    $total_pages = count($array_text);

    if (1 < $total_pages) {
        $pagenav = new \XoopsPageNav($total_pages, 1, $current_page, 'page', $item);
        $GLOBALS['xoopsTpl']->assign('breaknav', $pagenav->renderImageNav());
        $body_text = isset($array_text[$current_page]) ? $array_text[$current_page] : '';
	}
	return $body_text;
}
