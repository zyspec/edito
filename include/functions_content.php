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

// Check url and if on local, wether the destination file exists or not
function edito_function_checkurl( $url ) {  
	if (    !eregi("mailto:", $url  ) &&
		!eregi("http://", $url  ) &&
                !eregi("https://", $url ) &&
                !eregi("ftp://", $url ) )  {
        
            	$url = XOOPS_ROOT_PATH."/".$url ;    
	} else {
		$url = eregi_replace( XOOPS_URL, XOOPS_ROOT_PATH, $url );
	}
        
		if ( file_exists( $url ) ) {
        	$url = str_replace( XOOPS_ROOT_PATH, XOOPS_URL, $url );
        } else {
        	$url = '';
        }

	return $url;
}

function edito_cleankeywords( $content, $urw ) {

        $content = strip_tags($content);
        $content = strtolower($content);
        $content = htmlentities($content);
        $content = preg_replace('/&([a-zA-Z])(uml|acute|grave|circ|tilde);/','$1',$content);
        $content = html_entity_decode($content);
        $content = eregi_replace('quot',' ', $content);
        $content = eregi_replace("'",' ', $content);
        $content = eregi_replace('-',' ', $content);
        $content = eregi_replace('[[:punct:]]','', $content);
        $content = eregi_replace('[[:digit:]]','', $content);

        $words = explode(' ', $content);
        $keywords = '';
        foreach($words as $word) { if( strlen($word) >= $urw ) { $keywords .= '-'.trim($word); } }
        if( !$keywords) { $keywords = '-'; }
	return $keywords;
}


function edito_urw($link_url='', $title='', $alt_title='', $urw=0) {
 // Rewrite urls
 $target = XOOPS_ROOT_PATH.'/modules/edito/.htaccess';
 if(    is_file($target)
     && !ereg('127.0.0.1', XOOPS_URL)
   ) {
        if( $alt_title ) { $title = $alt_title; }
        $title = edito_cleankeywords( $title, $urw );
        $id = explode('=', $link_url);
        if( strstr($id[0], '../') ) { $sub = '../'; } else { $sub = ''; }
//         if( isset($id[1]) ) { $link_url = $sub.'page-'.$id[1]. $title . '.html'; }
        if( isset($id[1]) ) { $link_url = $sub.$id[1]. $title . '.html'; }
}
return $link_url;
}

function edito_check_urw_htaccess() {
// Check if htaccess file exists
$target = XOOPS_ROOT_PATH.'/modules/edito/.htaccess';
if(    !is_file($target)
    && function_exists('fopen')
    && function_exists('fwrite')
    && !ereg('127.0.0.1', XOOPS_URL)
   ) {
       	$handle =  @fopen($target, 'w+');
		if ( $handle ) {
                      $file_content = 'RewriteEngine on
                      RewriteRule	^page-([0-9]+)(-).*(\.html)$	content.php?id=$1	[L]';
                      fwrite($handle, $file_content);
                      fclose($handle);
		} else { return FALSE; }
 return TRUE;
 } 
 
 if( is_file($target)) { return TRUE; }
 else { return FALSE; }
}

function edito_createlink( $link_url='', $title='', $target='_self', $image_url='', $image_align='center', $image_max_width='800', $image_max_height='600', $alt_title='', $urw=0 ) {
	 // Initiate variables

	$a = '';
        $br = '';
        $link = '';
        $image = '';
        $align = '';
        $align_in = '';
        $align_out= '';
        $link_target = '';

	if ( $image_url ) { $image_url = edito_function_checkurl( $image_url); }

	// Create link
    if ( $link_url ) {
    	if ( !eregi('self', $target) AND $target ) {
        	if( !substr($target, 0, 1) == '_' ) { $target = '_'.$target; }
         $link_target = 'target="'.$target.'" ';
		}

        if( $urw && edito_check_urw_htaccess() ) { $link_url = edito_urw($link_url, $title, $alt_title, $urw); }
        $alt_title = eregi_replace('"','', $alt_title);
        $link = '<a href="'.$link_url.'" '.$link_target.'title="'.strip_tags($alt_title).'">';
        $a    = '</a>';
	}
        
    // Create image
	if ( $image_url ) {
		$image_size = @getimagesize( $image_url );
        if ( $image_size ) {
        	if ( $image_size[1] >= $image_max_height ) {
            	$height = 'height="' . $image_max_height . '" ';
            } else { $height  = ''; }

            if ( $image_size[0] >= $image_max_width )  {
            	$width = 'width="' . $image_max_width . '" ';
                $height= '';
            } else { $width  = ''; }

            if ( $image_align == 'center' ) {
            	$br = '<br />';
                $align_in = '<div style="text-align:center;">';
                $align_out= '</div>';
            } else {
            	$align = 'align="'.$image_align.'" ';
                $title = '';
            }

			$image  = '<img src="'. $image_url .'" alt="'. strip_tags($alt_title) .'" '.$align.'' . $width . '' . $height . '/>';
    	}
	}

    $result = $align_in.$link.$image.$br.$title.$a.$align_out;
	return $result;
}

function edito_pagebreak( $body_text='', $pagebreak='[pagebreak]', $current_page=0, $item='' ) {
	$array_text = explode("[pagebreak]", $body_text);
    $total_pages = count($array_text);

    if ($total_pages > 1) {
    	global $xoopsTpl;
        $pagenav = new XoopsPageNav($total_pages, 1, $current_page, 'page', $item);
        $xoopsTpl->assign('breaknav', $pagenav->renderImageNav());
        $body_text = $array_text[$current_page];
	}
	return $body_text;
}

?>