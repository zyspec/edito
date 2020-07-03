<?php declare(strict_types=1);
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

// MetaTag Generator
// createMetaTags(
//			 Page title, 		// Current page title
//			 Page texte, 		// Page content which will be used to generate keywords
//			 Default Meta Keywords, // The default current module meta keywords - if any
//			 Page Meta Keywords,  	// The default current page meta keywords - if any
//			 Meta Description, 	// The current page meta description
//			 Page Status (0 / 1), 	// Is the current page online of offline?
//			 Min keyword caracters, // Minimu size a words must have to be considered
//			 Min keyword occurence, // How many time a word must appear to be considered
//			 Max keyword occurence) // Maximum time a word must appear to be considered

/**
 * @param $page_title
 * @param $page_content
 * @param $module_meta_keywords
 * @param $page_meta_keywords
 * @param $page_meta_description
 * @param $status
 * @param $minChar
 * @param $min_occ
 * @param $max_occ
 */
function edito_createMetaTags($page_title, $page_content, $module_meta_keywords, $page_meta_keywords, $page_meta_description, $status, $minChar, $min_occ, $max_occ)
{
    global $xoopsTpl, $xoopsModule;

    $myts = MyTextSanitizer::getInstance();

    $ret = '';

    $metakeywords = '';

    if ($status) {
        $status = 1;
    }

    if ($minChar) {
        $minChar = 3;
    }

    if ($min_occ) {
        $min_occ = 1;
    }

    if ($max_occ) {
        $max_occ = 9;
    }

    // 1. Page Title

    if (isset($xoopsModule)) {
        $moduleName = $myts->displayTarea($xoopsModule->name());

        if ($status) {
            $modName = $moduleName . ' : ';
        } else {
            $modName = '';
        } // If page is offline, do not display module name

        if ($page_title && (mb_strtoupper($page_title) != mb_strtoupper($moduleName))) {
            $page_title = strip_tags($page_title);

            $page_title = $myts->displayTarea($page_title);

            $page_title = strip_tags($page_title);

            $page_title = $myts->undoHtmlSpecialChars($page_title);
        }

        $xoopsTpl->assign('xoops_pagetitle', $modName . $page_title);        // Template
    }

    // 2. Meta Description

    if ($page_meta_description) {
        $description = $page_title . ' ' . $page_meta_description;

        $xoopsTpl->assign('xoops_meta_description', $description);        // Template
    }

    // 3. Meta Keywords

    $ret = '';

    // Add custom page keywords - if any

    if ($page_meta_keywords) {
        $pageKeywords = explode(',', $page_meta_keywords);

        foreach ($pageKeywords as $pageKeyword) {
            $metakeywords[] = trim($pageKeyword);
        }
    }

    // a.Creating Meta Keywords from content

    if ($page_content) {
        $page_content    = edito_cleanContent($page_title . ' ' . $page_content);                    // Clean up content
        $contentKeywords = edito_findKeyWordsInString($page_content, $minChar, $min_occ, $max_occ);    // Select basis keywords

        foreach ($contentKeywords as $contentKeyword) {
            $metakeywords[] = trim($contentKeyword);
        }
    }

    // b. Add module custom keywords - if any

    if ($module_meta_keywords) {
        $moduleKeywords = explode(',', $module_meta_keywords);

        foreach ($moduleKeywords as $moduleKeyword) {
            $metakeywords[] = trim($moduleKeyword);
        }
    }

    // c. Limit Metas to 90 keywords

    if ($metakeywords) {
        $keywordsCount = count($metakeywords);

        for ($i = 0; $i < $keywordsCount and $i < 90; $i++) {
            $ret .= $metakeywords[$i];

            if ($i < $keywordsCount - 1 and $i < 89) {
                $ret .= ', ';
            }
        }

        $ret_let = '';

        $ret_caps = '';

        if ($i <= 45) {
            $ret_let = ', ' . ucwords($ret);
        }    // Add a majucule if less than 45 keywords

        if ($i <= 30) {
            $ret_caps = ', ' . mb_strtoupper($ret);
        }    // All words in majucule if less than 30 keywords
        $xoopsTpl->assign('xoops_meta_keywords', $ret . $ret_let . $ret_caps);        // Template
    }
} // End of function

// Remove useless code from original content (html, code, numbers, etc.)
/**
 * @param $content
 * @return string
 */
function edito_cleanContent($content)
{
    $myts = MyTextSanitizer::getInstance();

    $content = str_replace('<br>', ' ', $content);

    $content = str_replace("'", ' ', $content);

    $content = strip_tags($content);

    $content = $myts->displayTarea($content);

    $content = strip_tags($content);

    $content = $myts->undoHtmlSpecialChars($content);

    $content = preg_replace("/\[\[:punct:\]\]/i", ' ', $content);

    $content = preg_replace("/\[\[:digit:\]\]/i", ' ', $content);

    $content = trim($content);

    return $content;
}

// Keywords selection
/**
 * @param $content
 * @param $minChar
 * @param $min_occ
 * @param $max_occ
 * @return array
 */
function edito_findKeyWordsInString($content, $minChar, $min_occ, $max_occ)
{
    $arr = spliti(' ', $content);

    // Random variable

    if (count($arr) > 250) {
        $MIN_SIZE = mt_rand($minChar, $minChar + 1);

        $MIN_OCCURENCES = $min_occ;

        $MAX_OCCURENCES = mt_rand($min_occ, $max_occ);
    } else {
        $MIN_SIZE = mt_rand(2, 4);

        $MIN_OCCURENCES = 1;

        $MAX_OCCURENCES = $max_occ;
    }

    // Keywords selection

    $idx = [];

    foreach ($arr as $word) {
        $word = mb_strtolower(trim($word));

        if (mb_strlen($word) >= $MIN_SIZE) {
            if (!isset($idx[$word])) {
                $idx[$word] = 0;
            }

            $idx[$word]++;
        }
    }

    //  Keywords ordering

    $i = 0;

    arsort($idx);

    $content = [];

    foreach ($idx as $word => $cnt) {
        if ($cnt >= $MIN_OCCURENCES and $cnt <= $MAX_OCCURENCES) {
            $content[$i++] = $word;

            if (90 == $i) {
                return $content;
            }
        }
    }

    return $content;
}
