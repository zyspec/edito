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

/**
 * @param $media_size
 * @param $options
 * @return string
 */
function edito_media_size($media_size, $options)
{
    if ('default' == $media_size) {
        $media_size = '';
    }

    if ('custom' == $media_size) {
        $option = explode('|', $options);

        $media_size = 'width="' . $option[0] . '" height="' . $option[1] . '"';
    }

    if ('small' == $media_size) {
        $media_size = 'width="320" height="240"';
    }

    if ('medium' == $media_size) {
        $media_size = 'width="480" height="360"';
    }

    if ('large' == $media_size) {
        $media_size = 'width="800" height="600"';
    }

    if ('fullscreen' == $media_size) {
        $media_size = 'width="1024" height="768"';
    }

    if ('tv_small' == $media_size) {
        $media_size = 'width="320" height="240"';
    }

    if ('tv_medium' == $media_size) {
        $media_size = 'width="480" height="360"';
    }

    if ('tv_large' == $media_size) {
        $media_size = 'width="800" height="600"';
    }

    if ('mv_small' == $media_size) {
        $media_size = 'width="320" height="127"';
    }

    if ('mv_medium' == $media_size) {
        $media_size = 'width="480" height="206"';
    }

    if ('mv_large' == $media_size) {
        $media_size = 'width="720" height="309"';
    }

    return $media_size;
}

/**
 * @param $popup_size
 * @param $options
 * @return string
 */
function edito_popup_size($popup_size, $options)
{
    if ('custom' == $popup_size) {
        $option = explode('|', $options);

        $option[0] = $option[0] + 100;

        $option[1] = $option[1] + 100;

        $popup_size = 'width=' . $option[0] . ', height=' . $option[1];
    }

    // if ( $popup_size == '' ) 	          {$popup_size = ''; }

    if ('small' == $popup_size) {
        $popup_size = 'width=345, height=480';
    }

    if ('medium' == $popup_size or !$popup_size) {
        $popup_size = 'width=505, height=600';
    }

    if ('large' == $popup_size) {
        $popup_size = 'width=825, height=840';
    }

    if ('fullscreen' == $popup_size) {
        $popup_size = 'width=1050, height=1000';
    }

    if ('tv_small' == $popup_size) {
        $popup_size = 'width=345, height=400';
    }

    if ('tv_medium' == $popup_size) {
        $popup_size = 'width=505, height=500';
    }

    if ('tv_large' == $popup_size) {
        $popup_size = 'width=825, height=740';
    }

    if ('mv_small' == $popup_size) {
        $popup_size = 'width=345, height=270';
    }

    if ('mv_medium' == $popup_size) {
        $popup_size = 'width=505, height=350';
    }

    if ('mv_large' == $popup_size) {
        $popup_size = 'width=745, height=450';
    }

    return $popup_size;
}

// Check url and if on local, whether the destination file exists or not
/**
 * @param $url
 * @return string|string[]|null
 */
function edito_checkurl($url)
{
    if (!preg_match('/mailto:/i', $url) &&
        !preg_match("/http[s]:\/\//i", $url) &&
        !preg_match("/ftp[s]:\/\//i", $url)) {
        $url = XOOPS_ROOT_PATH . '/' . $url;
    } else {
        $url = preg_replace('/' . XOOPS_URL . '/i', XOOPS_ROOT_PATH, $url);
    }

    if (preg_match(XOOPS_ROOT_PATH, $url)) {
        if (file_exists($url)) {
            $url = preg_replace('/' . XOOPS_ROOT_PATH . '/i', XOOPS_URL, $url);
        } else {
            $url = '';
        }
    }

    return $url;
}

/**
 * @param        $url
 * @param string $custom_media
 * @return mixed
 */
function edito_checkformat($url, $custom_media = '')
{
    $format = @pathinfo(mb_strtolower($url), PATHINFO_EXTENSION);

    $formats[0] = $format;

    $is_mpeg = 0;

    if ($custom_media) {
        $custom_medias = explode('|', $custom_media);

        foreach ($custom_medias as $custom_media) {
            if (preg_match("/{$custom_media}/i", '.' . $format)) {
                $is_mpeg = 1;
            }
        }
    }

    if ('swf' == $format || 'flv' == $format) {
        $formats[1] = 'flash';
    }

    if ('mov' == $format) {
        $formats[1] = 'mov';
    }

    if ('ram' == $format || 'rm' == $format) {
        $formats[1] = 'ram';
    }

    if ('gif' == $format || 'jpg' == $format || 'jpeg' == $format || 'png' == $format) {
        $formats[1] = 'image';
    }

    if ('avi' == $format || 'wmv' == $format || 'mpg' == $format || 'mpeg' == $format
        || false !== stripos($format, "asx")
        || $is_mpeg
         || 'mp3' == $format || 'wav' == $format || 'mid' == $format) {
        $formats[1] = 'wmp';
    }

    if (false !== stripos($format, "asx")) {
        $formats[0] = 'asx';
    }

    if (false !== stripos($format, "php")) {
        $formats[0] = 'php';
    }

    return $formats;
}

/**
 * @param $file
 * @return string
 */
function edito_fileweight($file)
{
    $file = preg_replace('/' . XOOPS_URL . '/i', XOOPS_ROOT_PATH, $file);

    if (@filesize($file)) {
        $filesize = sprintf('%u', filesize($file));

        if ($filesize < 0) {
            return $filesize;
        }

        $names = [ 'B', 'KB', 'MB', 'GB', 'TB'];

        $i = 0;

        $count = count($names);

        while ($i < $count && $filesize > 1024) {
            $filesize = $filesize / 1024;

            $i++;
        }

        $filesize = number_format($filesize, 2, '.', ' ') . ' ' . $names[$i];

        return $filesize;
    }
}

/*
function edito_spotrobots( )
{
$user_agent = strtolower( getenv("HTTP_USER_AGENT") );
$robot = 0;
if (	eregi("bot", 	$user_agent ) ||
    eregi("spider", 	$user_agent ) ||
    eregi("robot", 	$user_agent ) ||
    eregi("crawler", 	$user_agent ) )
    {
    $robot = 1;
    }

return $robot;
}
*/

/*
function edito_iturl( $media_url, $startit, $endit )
{
$dirname_startit  =  $startit;
$basename_startit = $startit;
$tag_basename = '';
$tag_dirname  = '';
$media_link   = '';

$url = @pathinfo ( $media_url );

// File extension check
$extension = explode(".", $url['basename']);
$count_basename 	= substr_count( $url['basename'], '#' );				// Is there num in filname?
if ( !$count_basename ) { $basename_startit = $endit; }
$count_dirname  	= substr_count( $url['dirname'], '#' );				// Is there num in directory?
if ( !$count_dirname ) { $dirname_startit = $endit; }

for ($i = 1; $i <= $count_basename; $i++) { $tag_basename.= '#'; }
for ($i = 1; $i <= $count_dirname; $i++)  { $tag_dirname.= '#'; }
$form_dirname   	= '%0'.$count_dirname.'d';
$form_basename  	= '%0'.$count_basename.'d';
$url['basename']	= ereg_replace('.'.$extension[1], '', $url['basename']); // Remove extension
$media_urls = array();

for ($i = $dirname_startit; $i <= $endit; $i++) {
    if ( $count_dirname ) {
     $dirname = ereg_replace( 	$tag_dirname, 	sprintf($form_dirname, $i), 	$url['dirname'] );
    } else { $dirname = $url['dirname']; }

for ($ii = $basename_startit; $ii <= $endit; $ii++) {
if ( $count_basename ) {
    $basename = ereg_replace( 	$tag_basename, 	sprintf($form_basename, $ii), $url['basename'] );
    } else { $basename = $url['basename']; }
    $urls = edito_checkurl( $dirname . '/'. $basename . '.'. $extension[1] );
    if ( $urls ) { $media_urls[] = $urls; }
    }
 }

return $media_urls;
}
*/
