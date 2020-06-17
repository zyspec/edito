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


// MetaTag Generator
// createMetaTags(
//			 Page title, 		// Current page title
//                       Page meta_title        // Current page meta title
//			 Meta Description, 	// The current page meta description
//			 Page texte, 		// Page content which will be used to generate keywords
//			 Page Meta Keywords,  	// The default current page meta keywords - if any
//			 Default Meta Keywords, // The default current module meta keywords - if any
//			 Min keyword caracters, // Minimu size a words must have to be considered
//			 Min keyword occurence, // How many time a word must appear to be considered
//			 Max keyword occurence) // Maximum time a word must appear to be considered


function edito_createMetaTags( $page_title='',
                               $page_meta_title='',
                               $page_meta_description='',
                               $module_meta_description='',
                               $page_content='',
                               $page_meta_keywords='',
                               $module_meta_keywords='',
                               $minChar=3,
                               $min_occ=1,
                               $max_occ=12 ) {
                                 
//        echo  $module_meta_description;
	global $xoopsTpl, $xoopsModule;
	$myts =& MyTextSanitizer::getInstance();
    $ret = '';
    $metakeywords = '';
    $metagen = array();
    $module_meta_description = $myts -> htmlSpecialChars($module_meta_description);
    $page_meta_description = $myts -> htmlSpecialChars($page_meta_description);
    $module_meta_keywords = $myts -> htmlSpecialChars($module_meta_keywords);
    $page_meta_keywords = $myts -> htmlSpecialChars($page_meta_keywords);
    $page_meta_title = $myts -> htmlSpecialChars($page_meta_title);

    // 1. Page Title
        if ( !$page_meta_title ) { $page_meta_title = $page_title; }
			$page_meta_title = strip_tags( $page_meta_title );
			$page_meta_title = $myts->displayTarea( $page_meta_title );
			$page_meta_title = strip_tags( $page_meta_title );
//			$page_meta_title = $myts->undoHtmlSpecialChars( $page_meta_title );
//			$page_meta_title = eregi_replace('[[:punct:]]','', $page_meta_title);

                $metagen['title'] = $page_meta_title;

 
	// 2. Meta Description
	if ( $page_meta_description ) {
		 $metagen['description'] = $page_meta_description;
		 $metagen['description'] = preg_replace('#\r\n|\n|\r#', ' ', trim($metagen['description'])); }
    elseif ( $page_content ) {
                 $metagen['description'] = $myts -> htmlSpecialChars(substr(strip_tags($page_content), 0, 256));
				 $metagen['description'] = preg_replace('#\r\n|\n|\r#', ' ', trim($metagen['description']));}
    elseif ( $module_meta_description ) {
                 $metagen['description'] = $module_meta_description;
				 $metagen['description'] = preg_replace('#\r\n|\n|\r#', ' ', trim($metagen['description']));}
    else {       $metagen['description'] = $metagen['title'];
				 $metagen['description'] = preg_replace('#\r\n|\n|\r#', ' ', trim($metagen['description']));}
    
         if ($metagen['description'] == ' ') { $metagen['description'] = ''; }

	// 3. Meta Keywords
	$ret = ''; $ret_let=''; $ret_caps='';
//	if( $page_content ) {
	// a. Add custom page keywords - if any
	if ( $page_meta_keywords ) {
		$pageKeywords = explode(",", $page_meta_keywords);
		foreach ($pageKeywords as $pageKeyword) {
        	$metakeywords[] = trim($pageKeyword);
		}
	}

	// b.Creating Meta Keywords from content
	if ( $page_content ) {
    	$page_content = edito_cleanContent( $page_title.' '.$page_content );					// Clean up content
		$contentKeywords = edito_findKeyWordsInSting( $page_content, $minChar, $min_occ, $max_occ );	// Select basis keywords

        foreach ($contentKeywords as $contentKeyword) {
        	$metakeywords[] = trim($contentKeyword);
		}
//	}

        // c. Add module custom keywords - if any
	if ( $module_meta_keywords ) {
		$moduleKeywords = explode(",",  $module_meta_keywords );
		foreach ($moduleKeywords as $moduleKeyword) {
		$metakeywords[] = trim($moduleKeyword);
		}
	}


	// c. Limit Metas to 90 keywords
	if ( $metakeywords ) {
		$keywordsCount = count( $metakeywords );
		for ($i = 0; $i < $keywordsCount AND $i < 90; $i++) {
        	$ret .= $metakeywords[$i];
			if ($i < $keywordsCount -1 AND $i < 89) {
				$ret .= ', ';
			}
		}
	$ret_let = ''; $ret_caps = '';
	if ( $i <= 45 ) { $ret_let  = ', ' . ucwords($ret); } 	// Add a majucule if less than 45 keywords
	if ( $i <= 30 ) { $ret_caps = ', ' . strtoupper($ret); }	// All words in majucule if less than 30 keywords
 }
    $metagen['keywords'] = $myts -> htmlSpecialChars($ret.$ret_let.$ret_caps);
	}

    return $metagen;

} // End of function



// Remove useless code from original content (html, code, numbers, etc.)
function edito_cleanContent( $content ) {
        $myts =& MyTextSanitizer::getInstance();

        $content = strtolower($content);

        $i=0;
        $patterns[$i++] = '<br />';
        $patterns[$i++] = '<br>';
//        $patterns[$i++] = '<p>';
//        $patterns[$i++] = '</p>';
//        $patterns[$i++] = '<p />';
        $patterns[$i++] = '<td>';
        $patterns[$i++] = '</td>';
        $patterns[$i++] = '<div>';
        $patterns[$i++] = '</div>';

        $i=0;
        $replacements[$i++] = ' ';
        $replacements[$i++] = ' ';
//        $replacements[$i++] = ' ';
//        $replacements[$i++] = ' ';
//        $replacements[$i++] = ' ';
        $replacements[$i++] = ' ';
        $replacements[$i++] = ' ';
        $replacements[$i++] = ' ';
        $replacements[$i++] = ' ';

        $content = preg_replace($patterns, $replacements, $content);


        $content = html_entity_decode($content);
        $content = strip_tags($content);
        $content = eregi_replace('"',' ', $content);
        $content = eregi_replace("'",' ', $content);
        $content = $myts->displayTarea($content);

        $content = strip_tags($content);
        $content = eregi_replace('[[:punct:]]','', $content);
        $content = eregi_replace('[[:digit:]]','', $content);
        $content = substr($content, 0, 61464);
        $content = trim($content);

	return $content;
}



// Keywords selection
function edito_findKeyWordsInSting( $content, $minChar, $min_occ, $max_occ ) {
	$arr = explode(' ',$content);
        arsort($arr);
	// Random variable
	if ( count($arr) > 250 ) {
		$MIN_SIZE = rand($minChar, $minChar+1) ;
		$MIN_OCCURENCES = $min_occ;
		$MAX_OCCURENCES = rand($min_occ+$MIN_SIZE, $max_occ+$MIN_SIZE);
	} else {
		$MIN_SIZE = rand(2, 4);
		$MIN_OCCURENCES = 1;
		$MAX_OCCURENCES = $max_occ;
	}

	// Keywords selection
	$idx = array();
	foreach($arr as $word) {
		$word = trim($word);
		
		if(strlen($word) >= $MIN_SIZE) {
			if ( !isset($idx[$word]) ) {  $idx[$word] = 0; }
			$idx[$word]++;
		}
	}
        
	//  Keywords ordering
	$i=0;
	arsort($idx);
	$content = array();

	foreach($idx as $word => $cnt) {
		if ($cnt >= $MIN_OCCURENCES AND $cnt <= $MAX_OCCURENCES) {
			$content[$i++] = $word;
			if( $i == 90 ) { return $content; }
		}
	}
	return $content;
}

?>