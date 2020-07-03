<?php declare(strict_types=1);
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
 * @copyright Copyright {@link https://xoops.org XOOPS Project}
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 * @author    Solo (http://www.wolfpackclan.com/wolfactory)
 * @author    DuGris (http://www.dugris.info)
 * @author    XOOPS Module Development Team
 * @link      https://github.com/XoopsModules25x/edito
 */
defined('XOOPS_ROOT_PATH') || exit('Restricted access');

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

/**
 * @param string $page_title
 * @param string $page_meta_title
 * @param string $page_meta_description
 * @param string $module_meta_description
 * @param string $page_content
 * @param string $page_meta_keywords
 * @param string $module_meta_keywords
 * @param int    $minChar
 * @param int    $min_occ
 * @param int    $max_occ
 * @return array
 */
function edito_createMetaTags(
    $page_title = '',
    $page_meta_title = '',
    $page_meta_description = '',
    $module_meta_description = '',
    $page_content = '',
    $page_meta_keywords = '',
    $module_meta_keywords = '',
    $minChar = 3,
    $min_occ = 1,
    $max_occ = 12
) {
    //echo  $module_meta_description;

    global $xoopsTpl, $xoopsModule;

    $myts = MyTextSanitizer::getInstance();

    $ret = '';

    $metakeywords = '';

    $metagen = [];

    $module_meta_description = $myts->htmlSpecialChars($module_meta_description);

    $page_meta_description = $myts->htmlSpecialChars($page_meta_description);

    $module_meta_keywords = $myts->htmlSpecialChars($module_meta_keywords);

    $page_meta_keywords = $myts->htmlSpecialChars($page_meta_keywords);

    $page_meta_title = $myts->htmlSpecialChars($page_meta_title);

    // 1. Page Title

    if (!$page_meta_title) {
        $page_meta_title = $page_title;
    }

    $page_meta_title = strip_tags($page_meta_title);

    $page_meta_title = $myts->displayTarea($page_meta_title);

    $page_meta_title = strip_tags($page_meta_title);

    //$page_meta_title = $myts->undoHtmlSpecialChars( $page_meta_title );

    //$page_meta_title = eregi_replace('[[:punct:]]','', $page_meta_title);

    $metagen['title'] = $page_meta_title;

    // 2. Meta Description

    if ($page_meta_description) {
        $metagen['description'] = $page_meta_description;

        $metagen['description'] = preg_replace('#\r\n|\n|\r#', ' ', trim($metagen['description']));
    } elseif ($page_content) {
        $metagen['description'] = $myts->htmlSpecialChars(mb_substr(strip_tags($page_content), 0, 256));

        $metagen['description'] = preg_replace('#\r\n|\n|\r#', ' ', trim($metagen['description']));
    } elseif ($module_meta_description) {
        $metagen['description'] = $module_meta_description;

        $metagen['description'] = preg_replace('#\r\n|\n|\r#', ' ', trim($metagen['description']));
    } else {
        $metagen['description'] = $metagen['title'];

        $metagen['description'] = preg_replace('#\r\n|\n|\r#', ' ', trim($metagen['description']));
    }

    if (' ' == $metagen['description']) {
        $metagen['description'] = '';
    }

    // 3. Meta Keywords

    $ret = '';

    $ret_let = '';

    $ret_caps = '';

    //	if( $page_content ) {

    // a. Add custom page keywords - if any

    if ($page_meta_keywords) {
        $pageKeywords = explode(',', $page_meta_keywords);

        foreach ($pageKeywords as $pageKeyword) {
            $metakeywords[] = trim($pageKeyword);
        }
    }

    // b.Creating Meta Keywords from content

    if ($page_content) {
        $page_content = edito_cleanContent($page_title . ' ' . $page_content); // Clean up content
        $contentKeywords = edito_findKeyWordsInSting($page_content, $minChar, $min_occ, $max_occ);	// Select basis keywords

        foreach ($contentKeywords as $contentKeyword) {
            $metakeywords[] = trim($contentKeyword);
        }

        //	}

        // c. Add module custom keywords - if any

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
            } 	// Add a majucule if less than 45 keywords

            if ($i <= 30) {
                $ret_caps = ', ' . mb_strtoupper($ret);
            }	// All words in majucule if less than 30 keywords
        }

        $metagen['keywords'] = $myts->htmlSpecialChars($ret . $ret_let . $ret_caps);
    }

    return $metagen;
} // End of function

// Remove useless code from original content (html, code, numbers, etc.)
/**
 * @param $content
 * @return string
 */
function edito_cleanContent($content)
{
    $myts = MyTextSanitizer::getInstance();

    $content = mb_strtolower($content);

    $i = 0;

    $patterns[$i++] = '<br>';

    $patterns[$i++] = '<br>';
//        $patterns[$i++] = '<p>';
//        $patterns[$i++] = '</p>';
//        $patterns[$i++] = '<p>';

    $patterns[$i++] = '<td>';

    $patterns[$i++] = '</td>';

    $patterns[$i++] = '<div>';

    $patterns[$i++] = '</div>';

    $i = 0;

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

    $content = preg_replace('/\"/', ' ', $content);

    $content = preg_replace("/\'/", ' ', $content);

    $content = $myts->displayTarea($content);

    $content = strip_tags($content);

    $content = preg_replace('/\[\[:punct:\]\]/i', '', $content);

    $content = preg_replace('/\[\[:digit:\]\]/', '', $content);

    $content = mb_substr($content, 0, 61464);

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
function edito_findKeyWordsInSting($content, $minChar, $min_occ, $max_occ)
{
    $arr = explode(' ', $content);

    arsort($arr);

    // Random variable

    if (count($arr) > 250) {
        $MIN_SIZE = mt_rand($minChar, $minChar + 1);

        $MIN_OCCURENCES = $min_occ;

        $MAX_OCCURENCES = mt_rand($min_occ + $MIN_SIZE, $max_occ + $MIN_SIZE);
    } else {
        $MIN_SIZE = mt_rand(2, 4);

        $MIN_OCCURENCES = 1;

        $MAX_OCCURENCES = $max_occ;
    }

    // Keywords selection

    $idx = [];

    foreach ($arr as $word) {
        $word = trim($word);

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
