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


//	Partie administration
// define("_MD_EDITO_UPDATE_INFO",	"Vous pouvez modifier les informations du module<br />Insérez [blockbreak] pour indiquer la limite du texte dans le bloc.");

// admin/fichier index.php
define("_MD_EDITO_CREATE",		"Create a new page");

define("_MD_EDITO_ADD",			"Add");
define("_MD_EDITO_LIST",		"Page list");
define("_MD_EDITO_ID",			"ID");
define("_MD_EDITO_SUBJECT",		"Subject");
define("_MD_EDITO_METATITLE",		"[META] Title");
define("_MD_EDITO_METAKEYWORDS",	"[META] Keywords");
define("_MD_EDITO_METADESCRIPTION",	"[META] Description");
define("_MD_EDITO_METAGEN",	        "[METAGEN] <p />Keywords generated<br />automatically<br />by MetaGen script.");
define("_MD_EDITO_BEGIN",		"Starting text");
define("_MD_EDITO_COUNTER",		"Read");
define("_MD_EDITO_ONLINE",		"Online");
define("_MD_EDITO_HIDDEN",		"Hidden");
define("_MD_EDITO_OFFLINE",		"Offline");
define("_MD_EDITO_ACTIONS",		"Actions");
define("_MD_EDITO_EDIT",		"Edit");
define("_MD_EDITO_DELETE",		"Delete");
// define("_MD_NO_EDITO",			"No page to display");
define("_MD_EDITO_ALL",		        "All");
define("_MD_EDITO_ORDEREDBY",		"Ranking");
define("_MD_EDITO_REWRITING",		"Url Rewriting actived");
define("_MD_EDITO_NOREWRITING",		"Url Rewriting deactivated");
define("_MD_EDITO_REWRITING_INFO",	"A problem occured while writing the .htaccess file on the server.<p />
To solve this problem, copy the <br /><b>'modules/edito/doc/htaccess/.htaccess'</b>file<br />
into the <br /><b>'modules/edito/'</b> directory.");


// admin/content.php
define("_MD_EDITO_NOEDITOTOEDIT",	"There is no page to edit yet");
// define("_MD_EDITO_ADMINARTMNGMT",	"Gestion des pages");
define("_MD_EDITO_MODEDITO",		"Page modification");
define("_MD_EDITO_BODYTEXT",		"Body text<p />
                                        <i><font color='red'>[pagebreak]</font><br />
                                        to display<br />
                                        content on<br />
                                        several pages.</i><br />
                                        <br />
                                        <i><font color='red'>{media}</font><br />
                                        to display<br />
                                        current media<br />
                                        in the text.</i><br />
                                        <br />
                                        <i><font color='red'>{block}</font><br />
                                        to display<br />
                                        bloc's content<br />
                                        in the text.</i>");
define("_MD_EDITO_BLOCKTEXT",		"Block content");
define("_MD_EDITO_BODY",		"Content");
define("_MD_EDITO_IMAGE",	        "Image");
define("_MD_EDITO_SELECT_IMG",	        "Image");
define("_MD_EDITO_UPLOADIMAGE",	        "Upload image");
define("_MD_EDITO_STATUS",	        "Status");
define("_MD_EDITO_BLOCK",		"Display block's<br />content<br />in the page");

define("_MD_EDITO_OPTIONS",		"Options");
define("_MD_EDITO_HTML",		" Activate HTML");
define("_MD_EDITO_SMILEY",		" Activate Smileys ");
define("_MD_EDITO_XCODE",		" Activate XOOPS codes(BBCodes)<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i>Deactivate this option, also deactivate eventual multilangual functions.</i>");
define("_MD_EDITO_TITLE",		" Display title");
define("_MD_EDITO_LOGO",		" Display image");
define("_MD_EDITO_ALLOWCOMMENTS",       " Autorise comments");

define("_MD_EDITO_SUBMIT",		"Submit");
define("_MD_EDITO_CLEAR",		"Clear");
define("_MD_EDITO_CANCEL",		"Cancel");
define("_MD_EDITO_MODIFY",		"Modifie");
define("_MD_EDITO_FILEEXISTS",	        "File already exists");
define("_MD_EDITO_EDITOCREATED",	"New page successfully created");
define("_MD_EDITO_EDITONOTCREATED",	"Error: impossible to create a new page");
// define("_MD_EDITO_CANTPARENT",	        "Une page mère ne peut se lier à elle-même ou à sa fille !");
define("_MD_EDITO_EDITOMODIFIED",	"Database successfully updated!");
define("_MD_EDITO_EDITONOTUPDATED",	"Error: Database not updated");
define ("_MD_EDITO_EDITODELETED",	"Page successfully deleted");
define ("_MD_EDITO_DELETETHISEDITO",    "Do you really want to delete this page:");

// Modifs Hervé
define("_MD_EDITO_YES",			_YES);
define("_MD_EDITO_NO",			_NO);
// Ajouts Hervé
define("_MD_EDITO_NO_EDITO",		"No page available");

// Barre de Navigation
define("_MD_EDITO_NAV_INDEX",		"Go to module");
define("_MD_EDITO_NAV_LIST",		"Pages list");
define("_MD_EDITO_NAV_CREATE",	        "Create a new page");
define("_MD_EDITO_NAV_PREFERENCES",	"Settings");
define("_MD_EDITO_NAV_SEE",		"See current page");
define("_MD_EDITO_NAV_HELP",		"Help");
define("_MD_EDITO_NAV_CONFIG",	        "Administration");
define("_MD_EDITO_NAV_PERMS",	        "Permissions");
define("_MD_EDITO_NAV_BLOCKS_GROUPS",	"Blocks and Groupes");
define("_MD_EDITO_BLOCKS_GROUPS",	"Blocks and Groupes");
define("_MD_EDITO_BLOCKS",	        "Blocks");
define("_MD_EDITO_GROUPS",	        "Groups");

define("_MD_EDITO_BLOCK_LINK",	        "Blocks administration");
define("_MD_EDITO_BLOCK_EDITO",	        "Content blocks");
define("_MD_EDITO_BLOCK_MENU",	        "Menu blocs");

// myMedia
define("_MD_EDITO_SELECT_MEDIA",	"Local media <br /><br />
                                         <i><font color='red'>
                                         Directory files from:<br />
                                         '".$xoopsModuleConfig['sbmediadir']."'
                                         </font><br />
                                         *Prioritary on the external media.</i>");
define("_MD_EDITO_MEDIA",		"Media");
define("_MD_EDITO_UPLOADMEDIA",	        "Upload a media");

define("_MD_EDITO_MEDIALOCAL",		"Local media");
define("_MD_EDITO_MEDIAURL",		"External Media");

define("_MD_EDITO_MEDIA_SIZE",	        "Display format");

define("_MD_EDITO_SELECT_DEFAULT",	"- none -");
define("_MD_EDITO_SELECT_TVSMALL",	"TV Small");
define("_MD_EDITO_SELECT_TVMEDIUM",	"TV Medium");
define("_MD_EDITO_SELECT_TVBIG",	"TV Large");
define("_MD_EDITO_SELECT_CUSTOM",	"Custom");
define("_MD_EDITO_SELECT_MVSMALL",	"MOVIE Small");
define("_MD_EDITO_SELECT_MVMEDIUM",	"MOVIE Medium");
define("_MD_EDITO_SELECT_MVBIG",	"MOVIE Large");

define("_MD_EDITO_METAOPTIONS",	        "Metas Options");
define("_MD_EDITO_MEDIAOPTIONS",	"Medias Options");
define("_MD_EDITO_IMAGEOPTIONS",	"Images Options");
define("_MD_EDITO_MISCOPTIONS",	        "Misc. Options");

define("_MD_EDITO_HIDE",	        "Hide");
define("_MD_EDITO_SHOW",	        "Display");
define("_MD_EDITO_SHOWHIDE",	        "Display/Hide");
define("_MD_EDITO_HTMLMODE",	        "Html mode");
define("_MD_EDITO_PHPMODE",	        "Php mode");
define("_MD_EDITO_WAITING",	        "Waiting content:");

// Utilities
define("_MD_EDITO_PAGE",		"Page");
define("_MD_EDITO_UTILITIES",	        "Utilities");
define("_MD_EDITO_WYSIWYG",	        "Available wysiwyg editors");
define("_MD_EDITO_UPLOAD",		"Uplad a media");
define("_MD_EDITO_UPLOAD_ERROR",	"Error: Media upload failed");
define("_MD_EDITO_MEDIAUPLOADED",	"Media successfully uploaded");
define("_MD_EDITO_FILECREATED",	        "File successfully created.");
define("_MD_EDITO_UPLOADED",	        "Picture successfully uploaded.");
define("_MD_EDITO_UPDATED",	        "Picture successfully updated.");
define("_MD_EDITO_CLONE",	        "Clone the module");
define("_MD_EDITO_CLONED",	        "Module successfully cloned");
define("_MD_EDITO_MODULEXISTS",	        "Error: this module already exists!");
define("_MD_EDITO_NOTCLONED",	        "Error: Cloning settings are wrong");
define("_MD_EDITO_CLONE_TROUBLE",	"Error: Hosting settings do not allow the cloning of this module.
Please, try on a server which allow directory CHMODing.
(Tip: try on a local server)");


define("_MD_EDITO_CLONENAME",	        "Clone name<br /><i>
                                         <ul>
                                             <li>Not more than 16 caracters</li>
                                             <li>No special caracters</li>
                                             <li>No already existing module name</li>
                                             <li>Capital letters and spaces accepted</li>
                                         </ul></i>
                                         Sample : 'Mon Module 01'. ");

// Anti-leech
define("_MD_EDITO_HTACCESS",		"Media anti-leeching protection");
define("_MD_EDITO_COPY",		"Copy code");
define("_MD_EDITO_HTACCESS_INFO1",		"If you'd like to prevent other sites from leeching medias from your site, this guide will assist you in doing so using the .htaccess file.
<ol><li>Open Notepad (or equivalent software depending on your OS) and paste in the following code:</li></ol>");

define("_MD_EDITO_HTACCESS_INFO2",		"<ol><li>Upload the .htaccess.txt file via FTP in ASCII mode and place in the media upload directory.</li>
<li>After upload, right click the file (server copy) and choose rename.</li>
<li>Edit the file name, so that it will be .htaccess (without the .txt extension).</li></ol>Now, other web sites won't be able to leech any media from your site.
Enjoy!");

define("_MD_EDITO_MAKE_UPDATE", "The update of the module was not made : ");
define("_MD_EDITO_MAKE_UPGRADE", "A new version of Edito is available in downloading on this address : <br /><br />");

?>