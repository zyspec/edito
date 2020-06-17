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


// General
define("_MI_EDITO_NAME",		"Edito");
define("_MI_EDITO_DESC",                "Display multimedia content in a page or in a block");

// Menu admin
define("_MI_EDITO_GOTO_INDEX",	        "Go to index");
define("_MI_EDITO_UTILITIES",	        "Utilities");
define("_MI_EDITO_HELP",		"Help");


// Preferences
// Logos
define("_MI_EDITO_MAXFILESIZE",		"[LOGO] Max. upload weight");
define("_MI_EDITO_MAXFILESIZEDSC",	        "Maximum weight for uploaded pictures");
define("_MI_EDITO_IMGSIZE",		"[LOGO] Max. upload size");
define("_MI_EDITO_IMGSIZEDSC",			"Max. size for uploaded pictures (<b>width|height</b>).");
define("_MI_EDITO_LOGOWIDTH",		"[LOGO] Default image size");
define("_MI_EDITO_LOGOWIDTHDSC",		"Default image size in the index page (<b>width|height</b>).");
define("_MI_EDITO_LOGO_ALIGN",		"[LOGO] Image position");
define("_MI_EDITO_LOGO_ALIGNDSC",		"Select the image postion in pages and blocks.");
define("_MI_EDITO_LOGO_ALIGN_LEFT",		              "Left");
define("_MI_EDITO_LOGO_ALIGN_CENTER",	                      "Centre");
define("_MI_EDITO_LOGO_ALIGN_RIGHT",	                      "Right");
define("_MI_EDITO_UPLOADDIR",		"[LOGO] Image upload directory");
define("_MI_EDITO_UPLOADDIRDSC",		"Directory where images are stocked. (No \"/\")");


// Index
define("_MI_EDITO_PERPAGE",		"[INDEX] Max. articles per page");
define("_MI_EDITO_PERPAGEDSC",			"Maximum articles to be displayed per index and administration pages.");
define("_MI_EDITO_COLUMNS",		"[INDEX] Index columns");
define("_MI_EDITO_COLUMNSDSC",			"Number of columns to be displayed in index.");
define("_MI_EDITO_TEXTINDEX",		"[INDEX] Intro");
define("_MI_EDITO_TEXTINDEXDSC",		"Introduction and index text.");
define("_MI_EDITO_WELCOME",			       "Welcome to Edito, the multifonction and multimedia content module.");
define("_MI_EDITO_ORD",		"[INDEX] Order");
define("_MI_EDITO_ORDDSC",			"Default page and index link order.");
define("_MI_EDITO_ORD_SUBJ_ASC",	               "Ascending title");
define("_MI_EDITO_ORD_SUBJ_DESC",                 "Descending title");
define("_MI_EDITO_ORD_DATE_ASC",		       "Oldest first");
define("_MI_EDITO_ORD_DATE_DESC",		       "Most recent first");
// define("_MI_EDITO_ORD_HIT",			       "Le plus vu");
define("_MI_EDITO_ORD_READ_DESC",		       "Le plus lu");
define("_MI_EDITO_TAGS",		"[INDEX] Display icons");
define("_MI_EDITO_TAGSDSC",			"Afficher les icônes nouveau et populaire dans la page d'index.");
define("_MI_EDITO_TAGS_NEW",		"[INDEX] New icon");
define("_MI_EDITO_TAGSDSC_NEW",			"Display new icon for X days.");
define("_MI_EDITO_TAGS_POP",		"[INDEX] Popular icon");
define("_MI_EDITO_TAGSDSC_POP",			"Display popular icon for when X hits.");
define("_MI_EDITO_INDEX_LOGO",		"[INDEX] Index and page banner");
define("_MI_EDITO_INDEX_LOGODSC",		"URL of the banner to display on the index and pages.
Laisser vide pour ne rien afficher.");
define("_MI_EDITO_INDEX_CONTENT",	"[INDEX] Redirection");
define("_MI_EDITO_INDEXDSC_CONTENT",            "Display an alternative index page.<br />
- ID of a page or an URL (http/https). <br />
- Empty for default index.");

define("_MI_EDITO_FOOTERTEXT",	         "[INDEX] Footer");
define("_MI_EDITO_FOOTERTEXTDSC",	        "Contenu du pied de page par défaut du module");
define("_MI_EDITO_FOOTER",						"<div style='display: none;'>
Module <b>Edîto</b> développé par la WolFactory (http://wolfactory.wolfpackclan.com/),
la division Xoops du Wolf Pack Clan (http://www.wolfpackclan.com/).
</div>");

define("_MI_EDITO_INDEX_DISP",	"[INDEX] Display mode");
define("_MI_EDITO_INDEX_DISPDSC",		"Index display mode");
define("_MI_EDITO_INDEX_DISP_TABLE",		      "Table");
define("_MI_EDITO_INDEX_DISP_IMAGE",		      "Images");
define("_MI_EDITO_INDEX_DISP_BLOG",		      "Blog");
define("_MI_EDITO_INDEX_DISP_NEWS",		      "News");

// Préférences pages
define("_MI_EDITO_SETTINGS",		"Settings");
define("_MI_EDITO_ADMINHITS",	"[PAGE] Admin counter");
define("_MI_EDITO_ADMINHITSDSC",		"Allow counter for admin.");
define("_MI_EDITO_NAV_LINKS",		"[PAGE] Navigation links");
define("_MI_EDITO_NAV_LINKSDSC",		"Display navigation links on each and every pages.");
define("_MI_EDITO_NAV_LINKS_NONE",			"None");
define("_MI_EDITO_NAV_LINKS_BLOCK",			"Block");
define("_MI_EDITO_NAV_LINKS_LIST",			"List");
define("_MI_EDITO_NAV_LINKS_PATH",			"Path");

// Edition options
define("_MI_EDITO_EDITORS",		"Available editors");
define("_MI_EDITO_WYSIWYG",		"[ADMIN] Wysiwyg Editor");
define("_MI_EDITO_WYSIWYGDSC",			"Select the Wysiwyg editor to be used for page edition.");
define("_MI_EDITO_FORM_DHTML",                  "DHTML");
define("_MI_EDITO_FORM_COMPACT",                "Compact");
define("_MI_EDITO_FORM_SPAW",                   "Spaw Editor");
define("_MI_EDITO_FORM_HTMLAREA",               "HtmlArea Editor");
define("_MI_EDITO_FORM_FCK",                    "FCK Editor");
define("_MI_EDITO_FORM_KOIVI",                  "Koivi Editor");
define("_MI_EDITO_FORM_INBETWEEN",              "Inbetween Editor");
define("_MI_EDITO_FORM_TINYEDITOR",             "TinyEditor");

// Admin options
define("_MI_EDITO_OPT_TITLE",	"[OPTION] Display title");
define("_MI_EDITO_OPTDSC_TITLE",		"Create a new page with title displayed.");
define("_MI_EDITO_OPT_LOGO",		"[OPTION] Display image");
define("_MI_EDITO_OPTDSC_LOGO",		"Create a new page with image displayed.");
define("_MI_EDITO_OPT_BLOCK",	"[OPTION] Display block content");
define("_MI_EDITO_OPTDSC_BLOCK",		"Create a new page with the block content displayed.");
define("_MI_EDITO_OPT_GRPS",	"[OPTION] Groups access");
define("_MI_EDITO_OPT_GRPSDSC",	"Default pages access depending on access groups.");
define("_MI_EDITO_SUB_GRPS",	"[INDEX] Submit page");
define("_MI_EDITO_SUB_GRPSDSC",	"Access groupes allowed to submit new pages.");
define("_MI_EDITO_OPT_COMMENT",	"[OPTION] Allow comments");

define("_MI_EDITO_DEFAULTEXT",		"[OPTION] Default text");
define("_MI_EDITO_DEFAULTEXTDSC",		"Default text for each and every new page.<br /><br />
<i><b>{lorem}</b> : Tag to display default Lorem Ipsum text.</i>");
define("_MI_EDITO_DEFAULTEXTEXP",			"Welcome to Edito.

Type here the text you want to display in your page.

To edit or delete the current default text, see in the module settings.");

// Options Meta
define("_MI_EDITO_META_KEYW",	"[META] Module keywords");
define("_MI_EDITO_META_KEYWDSC",		"The module automatically generate keywords from your texte. You can add default keywords here if necessary.");

define("_MI_EDITO_META_DESC",	"[META] Module description");
define("_MI_EDITO_META_DESCDSC",        "Change the default meta description of each and every page.
Leave empty, for default Xoops site description.");

define("_MI_EDITO_META_MANAGER",				"[META] Meta Generator");
define("_MI_EDITO_META_MANAGERDSC",				"Activate the automatic meta generator.<br />
- Auto: automatically generated by the MetaGen script.<br />
- Mixte: Pick manual page meta datas, first, then the ones automatically generated by MetaGen.<br />
- Manuel: Only manual meta datas are used.");
define("_MI_EDITO_META_AUTO",					"Auto");
define("_MI_EDITO_META_SEMI",					"Mixt");
define("_MI_EDITO_META_MANUAL",	        		        "Manual");


// Blocs
define("_MI_EDITO_BLOCNAME_05",				"Menu 1");
define("_MI_EDITO_BLOCNAME_06",				"Menu 2");
define("_MI_EDITO_BLOCNAME_01",				"Page 1");
define("_MI_EDITO_BLOCNAME_02",				"Random");
define("_MI_EDITO_BLOCNAME_03",				"Latest");
define("_MI_EDITO_BLOCNAME_04",				"Popular");

/*
define("_MI_EDITO_TPL01_DESC","Display la liste des pages");
define("_MI_EDITO_TPL02_DESC","Display le contenu pour une page");
define("_MI_EDITO_BLOC01_DESC","Voir une page dans un bloc");
define("_MI_EDITO_BLOC02_DESC","Voir une page dans un bloc");
define("_MI_EDITO_BLOC03_DESC","Voir une page dans un bloc");
define("_MI_EDITO_BLOC04_DESC","Voir une page dans un bloc");
define("_MI_EDITO_BLOC05_DESC","Display la liste des pages en ligne dans un bloc");
define("_MI_EDITO_BLOC06_DESC","Display une page au hasard dans un block");
*/



/*
define("_MI_EDITO_PARENT",	"[EDITO] Catégorisation");
define("_MI_EDITO_PARENTDSC",	"Display et utiliser le système de catégorie père/fils.");
*/

// Edito 2.4
// Navigation admin
define("_MI_EDITO_INDEX",	        "Index");
define("_MI_EDITO_LIST",	        "Page list");
define("_MI_EDITO_CREATE",	        "Create new page");
define("_MI_EDITO_SEE",	        	"See current page");
define("_MI_EDITO_BLOCKS_GRPS",	"Blocks/Groups permissions");
define("_MI_EDITO_MIMETYPES",		"Mimetypes");
define("_MI_EDITO_SUBMIT",	        "Submit a new page");




// Edito 3.0
// Option Media
define("_MI_EDITO_MEDIADIR",	         	"[MEDIA] Upload media directory");
define("_MI_EDITO_MEDIADIRDSC",	         	"Directory where medias are stocked. (No \"/\")");

define("_MI_EDITO_MEDIA_DISP",		"[MEDIA] Default Media display");
define("_MI_EDITO_MEDIA_DISPDSC",		        "Default media display setting.");
define("_MI_EDITO_MEDIA_POPUP",	        		"Popup");
define("_MI_EDITO_MEDIA_PAGE",	        		"Page");
define("_MI_EDITO_MEDIA_BOTH",	        		"Page and Popup");

define("_MI_EDITO_REPEAT",	        	"[MEDIA] Loop play");
define("_MI_EDITO_REPEATDSC",	        	"Loop media play.");
define("_MI_EDITO_REWRITING",	        	"[LINKS] Rewriting Mod");
define("_MI_EDITO_REWRITINGDSC",	        	"Generate url rewrited links with page keywords.<br />
                                                         Available only on servers accepting url rewriting.");
define("_MI_EDITO_URW_NONE",			"None");
define("_MI_EDITO_URW_ALL",			"All");
define("_MI_EDITO_URW_MIN_3",			"3 letters minimum");
define("_MI_EDITO_URW_MIN_5",			"5 letters minimum");

define("_MI_EDITO_DWNL",                "[MEDIA] Downloadable");
define("_MI_EDITO_DWNLDSC",                      "Allow media download.");

define("_MI_EDITO_MEDIA_SIZE",	                "[MEDIA] Media display");
define("_MI_EDITO_MEDIADSC_SIZE",			"Default display format");
define("_MI_EDITO_SIZE_DEFAULT",			        "- none -");
define("_MI_EDITO_SIZE_TVSMALL",				"TV small");
define("_MI_EDITO_SIZE_TVMEDIUM",				"TV Medium");
define("_MI_EDITO_SIZE_TVBIG",	        		        "TV Large");
define("_MI_EDITO_SIZE_MVSMALL",				"Cine Small");
define("_MI_EDITO_SIZE_MVMEDIUM",				"Cine Medium");
define("_MI_EDITO_SIZE_MVBIG",	        		        "Cine Large");
define("_MI_EDITO_SIZE_CUSTOM",	        		"Custom");
define("_MI_EDITO_CUSTOM",			"[MEDIA] Custom size");
define("_MI_EDITO_CUSTOM_MEDIA",			"[MEDIA] Custom media");
define("_MI_EDITO_CUSTOM_MEDIADSC",	        		"Force media file reading by Windows Media Player.<br />
                                                                Extension list separated by |");


define("_MI_EDITO_UPDATE_MODULE" , "Update module");

// Utilities
define("_MI_EDITO_CLONE",		"Clone module");
define("_MI_EDITO_UPLOAD",		"Upload medias");
define("_MI_EDITO_IMPORT",		"Import SQL");
define("_MI_EDITO_EXPORT",		"Export SQL");
define("_MI_EDITO_HTACCESS",		"Protect Medias");
?>