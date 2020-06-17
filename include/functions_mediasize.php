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

if (!defined("XOOPS_ROOT_PATH")) { die("XOOPS root path not defined"); }


function edito_media_size( $media_size, $options )
{
if ( $media_size == 'default' )  		{ $media_size = ''; }

if ( $media_size == 'custom' ) 	{ $option = explode( '|', $options );
     $media_size = 'width="'.$option[0].'" height="'.$option[1].'"';
}

if ( $media_size == 'small' ) 	{$media_size = 'width="320" height="240"'; }
if ( $media_size == 'medium' )	{$media_size = 'width="480" height="360"'; }
if ( $media_size == 'large' ) 	{$media_size = 'width="800" height="600"'; }
if ( $media_size == 'fullscreen' ) 	{$media_size = 'width="1024" height="768"'; }

if ( $media_size == 'tv_small' ) 	{$media_size = 'width="320" height="240"'; }
if ( $media_size == 'tv_medium' )	{$media_size = 'width="480" height="360"'; }
if ( $media_size == 'tv_large' ) 	{$media_size = 'width="800" height="600"'; }
if ( $media_size == 'mv_small' ) 	{$media_size = 'width="320" height="127"'; }
if ( $media_size == 'mv_medium' )	{$media_size = 'width="480" height="206"'; }
if ( $media_size == 'mv_large' ) 	{$media_size = 'width="720" height="309"'; }

return $media_size;
}

function edito_popup_size( $popup_size, $options )
{

if ( $popup_size == 'custom' ) 	{ $option = explode( '|', $options );
     $option[0] = $option[0]+100;  $option[1] = $option[1]+100;
     $popup_size = 'width='.$option[0].', height='.$option[1];
}

// if ( $popup_size == '' ) 	          {$popup_size = ''; }
if ( $popup_size == 'small' ) 	       {$popup_size = 'width=345, height=480'; }
if ( $popup_size == 'medium' OR !$popup_size ) {$popup_size = 'width=505, height=600'; }
if ( $popup_size == 'large' ) 	       {$popup_size = 'width=825, height=840'; }
if ( $popup_size == 'fullscreen' )     {$popup_size = 'width=1050, height=1000'; }

if ( $popup_size == 'tv_small' ) 	{$popup_size = 'width=345, height=400'; }
if ( $popup_size == 'tv_medium' )	{$popup_size = 'width=505, height=500'; }
if ( $popup_size == 'tv_large' ) 	{$popup_size = 'width=825, height=740'; }
if ( $popup_size == 'mv_small' ) 	{$popup_size = 'width=345, height=270'; }
if ( $popup_size == 'mv_medium' )	{$popup_size = 'width=505, height=350'; }
if ( $popup_size == 'mv_large' ) 	{$popup_size = 'width=745, height=450'; }

return $popup_size;
}


// Check url and if on local, wether the destination file exists or not
function edito_checkurl( $url ) {
	if (	!eregi("mailto:", $url  ) &&
		!eregi("http://", $url  ) &&
		!eregi("https://", $url ) &&
		!eregi("ftp://", $url ) )
 		{
		$url = XOOPS_ROOT_PATH."/".$url ;
		} else {
		$url = eregi_replace( XOOPS_URL, XOOPS_ROOT_PATH, $url );
		}

	if ( ereg( XOOPS_ROOT_PATH, $url ) ) {
		if ( file_exists( $url ) ) { $url = eregi_replace( XOOPS_ROOT_PATH, XOOPS_URL, $url ); }
	    else { $url = ''; }
	}
	return $url;
}

function edito_checkformat( $url, $custom_media='' ) {
	$format = @pathinfo ( strtolower($url), PATHINFO_EXTENSION ) ;
	$formats[0] = $format;
	$is_mpeg=0;

	if( $custom_media ) {
	    $custom_medias = explode('|', $custom_media);
            foreach($custom_medias as $custom_media) {
                               if(eregi($custom_media, '.'.$format)) { $is_mpeg=1; }
            }
        }

	if ( $format == 'swf' || $format == 'flv' )	{ $formats[1] = 'flash'; }
	if ( $format == 'mov' )	{ $formats[1] = 'mov'; }
	if ( $format == 'ram' || $format == 'rm' ){ $formats[1] = 'ram'; }
	if ( $format == 'gif' || $format == 'jpg' || $format == 'jpeg' || $format == 'png')	{ $formats[1] = 'image'; }
	if ( $format == 'avi' || $format == 'wmv' || $format == 'mpg' || $format == 'mpeg' 
             || eregi('asx', $format) || $is_mpeg
	     || $format == 'mp3' || $format == 'wav' || $format == 'mid' )         { $formats[1] = 'wmp'; }

    if ( eregi('asx', $format) ) { $formats[0] = 'asx'; }
    if ( eregi('php', $format) ) { $formats[0] = 'php'; }
	return $formats;
}

function edito_fileweight( $file ) {
	$file = eregi_replace( XOOPS_URL, XOOPS_ROOT_PATH, $file );

	if ( @filesize($file) ) {
		$filesize = sprintf("%u", filesize($file));
		if ( 0 > $filesize ) {
			return $filesize ;
		}
		$names = array( 'B', 'KB', 'MB', 'GB', 'TB');
		$i = 0;
		$count = count($names) ;

        while ($i < $count && $filesize  > 1024) {
			$filesize  = $filesize /1024;
			$i++;
		}
		$filesize = number_format($filesize, 2, '.', ' ').' '.$names[$i];
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
?>