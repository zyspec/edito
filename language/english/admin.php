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

// Administration Part
// define('_MD_EDITO_UPDATE_INFO', "Vous pouvez modifier les informations du module<br>Ins�rez [blockbreak] pour indiquer la limite du texte dans le bloc.");

// admin/fichier index.php
define('_AM_EDITO_CREATE', 'Create a new page');
define('_AM_EDITO_DUPLICATE', 'Duplicate');
define('_AM_EDITO_HELP', 'Help');

define('_AM_EDITO_ADD', 'Add');
define('_AM_EDITO_LIST', 'Page list');
define('_AM_EDITO_ID', 'ID');
define('_AM_EDITO_SUBJECT', 'Subject');
define('_AM_EDITO_METATITLE', '[META] Title');
define('_AM_EDITO_METAKEYWORDS', '[META] Keywords');
define('_AM_EDITO_METADESCRIPTION', '[META] Description');
define('_AM_EDITO_METAGEN', '[METAGEN] <p>Keywords generated<br>automatically<br>by MetaGen script.');
define('_AM_EDITO_BEGIN', 'Starting text');
define('_AM_EDITO_COUNTER', 'Read');
define('_AM_EDITO_ONLINE', 'Online');
define('_AM_EDITO_HIDDEN', 'Hidden');
define('_AM_EDITO_OFFLINE', 'Offline');
define('_AM_EDITO_ACTIONS', 'Actions');
define('_AM_EDITO_EDIT', 'Edit');
define('_AM_EDITO_DELETE', 'Delete');
// define('_AM_NO_EDITO', "No page to display");
define('_AM_EDITO_ALL', 'All');
define('_AM_EDITO_ORDEREDBY', 'Ranking');
define('_AM_EDITO_REWRITING', 'Url Rewriting actived');
define('_AM_EDITO_NOREWRITING', 'Url Rewriting deactivated');
define('_AM_EDITO_REWRITING_INFO', "A problem occured while writing the .htaccess file on the server.<p>
To solve this problem, copy the <br><b>'modules/edito/doc/htaccess/.htaccess'</b>file<br>
into the <br><b>'modules/edito/'</b> directory.");

// admin/content.php
define('_AM_EDITO_NOEDITOTOEDIT', 'There is no page to edit yet');
// define('_AM_EDITO_ADMINARTMNGMT', "Gestion des pages");
define('_AM_EDITO_MODEDITO', 'Page modification');
define('_AM_EDITO_BODYTEXT', "Body text<p>
                                        <i><font color='red'>[pagebreak]</font><br>
                                        to display<br>
                                        content on<br>
                                        several pages.</i><br>
                                        <br>
                                        <i><font color='red'>{media}</font><br>
                                        to display<br>
                                        current media<br>
                                        in the text.</i><br>
                                        <br>
                                        <i><font color='red'>{block}</font><br>
                                        to display<br>
                                        block's content<br>
                                        in the text.</i>");
define('_AM_EDITO_BLOCKTEXT', 'Block content');
define('_AM_EDITO_BODY', 'Content');
define('_AM_EDITO_IMAGE', 'Image');
define('_AM_EDITO_SELECT_IMG', 'Image');
define('_AM_EDITO_UPLOADIMAGE', 'Upload image');
define('_AM_EDITO_STATUS', 'Status');
define('_AM_EDITO_BLOCK', "Display block's<br>content<br>in the page");

define('_AM_EDITO_OPTIONS', 'Options');
define('_AM_EDITO_HTML', ' Activate HTML');
define('_AM_EDITO_SMILEY', ' Activate Smileys ');
define('_AM_EDITO_XCODE', ' Activate XOOPS codes(BBCodes)<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i>Deactivate this option, also deactivate eventual multilangual functions.</i>');
define('_AM_EDITO_TITLE', ' Display title');
define('_AM_EDITO_LOGO', ' Display image');
define('_AM_EDITO_ALLOWCOMMENTS', ' Allow comments');

define('_AM_EDITO_SUBMIT', 'Submit');
define('_AM_EDITO_CLEAR', 'Clear');
define('_AM_EDITO_CANCEL', 'Cancel');
define('_AM_EDITO_MODIFY', 'Modify');
define('_AM_EDITO_FILEEXISTS', 'File already exists');
define('_AM_EDITO_EDITOCREATED', 'New page successfully created');
define('_AM_EDITO_EDITONOTCREATED', 'Error: impossible to create a new page');
// define('_AM_EDITO_CANTPARENT', "Une page m�re ne peut se lier � elle-m�me ou � sa fille !");
define('_AM_EDITO_EDITOMODIFIED', 'Database successfully updated!');
define('_AM_EDITO_EDITONOTUPDATED', 'Error: Database not updated');
define('_AM_EDITO_EDITODELETED', 'Page successfully deleted');
define('_AM_EDITO_DELETETHISEDITO', 'Do you really want to delete this page:');

// Modifications  - Herve
define('_AM_EDITO_YES', _YES);
define('_AM_EDITO_NO', _NO);
// Additions -  Herve
define('_AM_EDITO_NO_EDITO', 'No page available');

// Navigation Bar
define('_AM_EDITO_NAV_INDEX', 'Go to module');
define('_AM_EDITO_NAV_LIST', 'Pages list');
define('_AM_EDITO_NAV_CREATE', 'Create a new page');
define('_AM_EDITO_NAV_PREFERENCES', 'Settings');
define('_AM_EDITO_NAV_SEE', 'See current page');
define('_AM_EDITO_NAV_HELP', 'Help');
define('_AM_EDITO_NAV_CONFIG', 'Administration');
define('_AM_EDITO_NAV_PERMS', 'Permissions');
define('_AM_EDITO_NAV_BLOCKS_GROUPS', 'Blocks and Groups');
define('_AM_EDITO_BLOCKS_GROUPS', 'Blocks and Groups');
define('_AM_EDITO_BLOCKS', 'Blocks Intro');
define('_AM_EDITO_GROUPS', 'Groups');

define('_AM_EDITO_BLOCK_LINK', 'Blocks administration');
define('_AM_EDITO_BLOCK_EDITO', 'Content blocks');
define('_AM_EDITO_BLOCK_MENU', 'Menu blocs');

// myMedia
define('_AM_EDITO_SELECT_MEDIA', "Local media <br><br>
                                         <i><font color='red'>
                                         Directory files from:<br>
                                         '" . $xoopsModuleConfig['sbmediadir'] . "'
                                         </font><br>
                                         *Priority given on external media.</i>");
define('_AM_EDITO_MEDIA', 'Media');
define('_AM_EDITO_UPLOADMEDIA', 'Upload a media');

define('_AM_EDITO_MEDIALOCAL', 'Local media');
define('_AM_EDITO_MEDIAURL', 'External Media');

define('_AM_EDITO_MEDIA_SIZE', 'Display format');

define('_AM_EDITO_SELECT_DEFAULT', '- none -');
define('_AM_EDITO_SELECT_TVSMALL', 'TV Small');
define('_AM_EDITO_SELECT_TVMEDIUM', 'TV Medium');
define('_AM_EDITO_SELECT_TVBIG', 'TV Large');
define('_AM_EDITO_SELECT_CUSTOM', 'Custom');
define('_AM_EDITO_SELECT_MVSMALL', 'MOVIE Small');
define('_AM_EDITO_SELECT_MVMEDIUM', 'MOVIE Medium');
define('_AM_EDITO_SELECT_MVBIG', 'MOVIE Large');

define('_AM_EDITO_METAOPTIONS', 'Metas Options');
define('_AM_EDITO_MEDIAOPTIONS', 'Medias Options');
define('_AM_EDITO_IMAGEOPTIONS', 'Images Options');
define('_AM_EDITO_MISCOPTIONS', 'Misc. Options');

define('_AM_EDITO_HIDE', 'Hide');
define('_AM_EDITO_SHOW', 'Display');
define('_AM_EDITO_SHOWHIDE', 'Display/Hide');
define('_AM_EDITO_HTMLMODE', 'Html mode');
define('_AM_EDITO_PHPMODE', 'Php mode');
define('_AM_EDITO_WAITING', 'Waiting content:');

// Utilities
define('_AM_EDITO_PAGE', 'Page');
define('_AM_EDITO_UTILITIES', 'Utilities');
define('_AM_EDITO_WYSIWYG', 'Available WYSIWYG editors');
define('_AM_EDITO_UPLOAD', 'Upload a media');
define('_AM_EDITO_UPLOAD_ERROR', 'Error: Media upload failed');
define('_AM_EDITO_MEDIAUPLOADED', 'Media successfully uploaded');
define('_AM_EDITO_FILECREATED', 'File successfully created.');
define('_AM_EDITO_UPLOADED', 'Picture successfully uploaded.');
define('_AM_EDITO_UPDATED', 'Picture successfully updated.');
define('_AM_EDITO_CLONE', 'Clone the module');
define('_AM_EDITO_CLONED', 'Module successfully cloned');
define('_AM_EDITO_MODULEXISTS', 'Error: this module already exists!');
define('_AM_EDITO_NOTCLONED', 'Error: Cloning settings are wrong');
define('_AM_EDITO_CLONE_TROUBLE', '
Error: Hosting settings do not allow the cloning of this module.
Please, try on a server which allow directory CHMODing.
(Tip: try on a local server)
');
define('_AM_EDITO_CLONENAME', "
Clone name<br><i>
  <ul>
      <li>Not more than 16 characters</li>
      <li>No special characters</li>
      <li>No already existing module name</li>
      <li>Capital letters and spaces accepted</li>
  </ul></i>
Sample : 'Mon Module 01'.
");

define('_AM_EDITO_IMPORT', 'Import');
define('_AM_EDITO_EXPORT', 'Export');
define('_AM_EDITO_DB_IMPORT', 'Import SQL');
define('_AM_EDITO_DB_EXPORT', 'Export SQL');
define('_AM_EDITO_INSERT', 'INSERT INTO database');
define('_AM_EDITO_UPDATE', 'Update database');
define('_AM_EDITO_TYPE', 'Action Type');
define('_AM_EDITO_DB_DATAS', 'SQL Statements to Import');
define('_AM_EDITO_EDITORS', 'Content Editors');

// Anti-leech
define('_AM_EDITO_HTACCESS', 'Media anti-leeching protection');
define('_AM_EDITO_COPY', 'Copy code');
define('_AM_EDITO_SITELIST', 'Allowed sites (separated by | [pipe])');
define('_AM_EDITO_HTACCESS_INFO1', "If you'd like to prevent other sites from leeching medias from your site, this guide will assist you in doing so using the .htaccess file.
<ol><li>Open Notepad (or equivalent software depending on your OS) and paste in the following code:</li></ol>");

define('_AM_EDITO_HTACCESS_INFO2', "<ol><li>Upload the .htaccess.txt file via FTP in ASCII mode and place in the media upload directory.</li>
<li>After upload, right click the file (server copy) and choose rename.</li>
<li>Edit the file name, so that it will be .htaccess (without the .txt extension).</li></ol>Now, other web sites won't be able to leech any media from your site.
Enjoy!");

define('_AM_EDITO_MAKE_UPDATE', 'The update of the module was not made : ');
define('_AM_EDITO_MAKE_UPGRADE', 'A new version of Edito is available in downloading on this address : <br><br>');

// Help datas
define('_AM_EDITO_CONTENT_HELP', "
<ul><b>1) <u>Topic</u></b>
Indicate the short title of the page (See also meta title). This title is used in the navigation links, and by default in the absence of a meta-title.
</ul>
<ul><b>2) <u>Statuses</u></b>
There are 6 possible statuses for your page.
<ul><ol>
    <li><img src='../assets/images/icon/online.gif' align='absmiddle'> <b>Display: </b> Normal display of the page in the module.</li>
    <li><img src='../assets/images/icon/waiting.gif' align='absmiddle'> <b>Pending: </b> The page is awaiting validation. It is only visible to administrators.</li>
    <li><img src='../assets/images/icon/hidden.gif' align='absmiddle'> <b>Cacher :</b> Display of the page regardless of any information relating to the module.
The page is not included in the module indexes, nor in the menu block.</li>
	<li><img src='../assets/images/icon/offline.gif' align='absmiddle'> <b>Disable: </b> The page is completely inaccessible.</li>
    <li><img src='../assets/images/icon/html.gif' align='absmiddle'> <b>Mode HTML :</b> Displays the content of the page only in html mode.
Does not interpret XOOPS codes and any other line breaks.</li>
	<li><img src='../assets/images/icon/php.gif' align='absmiddle'> <b>Mode php :</b> Interprets the content of the page as php code.</li>
</ol></ul>
<ul>
<b>3) <u>Content of the Block</u></b>
The content entered in this text box will be displayed first in the content blocks of the module.
In the case of the index page, it will be displayed in 'table' and 'news' mode.
The content of this area is not interpreted in 'php' mode.
The content of this area is also used to automatically generate metakeywords.
</ul>
<ul><b>4) <u>Display the content of the block on the page </u> </b>
By checking this option, the content of the block will be displayed in the linked page (See also special tags).
</ul>
<ul><b>5) <u>Body text</u></b>
The content entered in this text box is used on the main page.
The content of this area is also used to automatically generate metakeywords.
In php mode, it is in this area that the php code to be interpreted must be indicated. Note that the <b> &#139; tags should not be filled in? php </b> and <b>? &#155; </b> usual.</ul>
<img src='../assets/images/icon/tip.gif' align='absleft'><b>Special tags </b>: The following tags can be used in the text:
<ul><ol>
    <li><i><b>[pagebreak]</b></i> : to display content on multiple pages.</li>
    <li><i><b>{media}</b></i> to display the current media in the text. By using this tag, the media will no longer be displayed at the top of the page.</li>
	<li><i><b>{block}</b></i> to display the content of the block in the text, as a box.</li>
    <li><i><b>{block align=\"left\"}</b></i> : the block will be displayed on the left.</li>
	<li><i><b>{block align=\"right\"}</b></i> : the block will be displayed on the right</li>
	<li><i><b>{block align=\"center\"}</b></i> : the block will be displayed in the center.</li>
</ol></ul>
");
define('_AM_EDITO_IMAGE_HELP', '
For each page created, it is possible to assign a representative image to it.
<ul><b>1) <u>Image</b></u>
The storage location of the images is defined in the Preferences of the module (cf. <b> [LOGO] Directory of images </b>) and must imperatively be hosted. on the site server. The list of images thus available is displayed in the drop-down list. You can preview the image by selecting it.
</ul>
<ul><b>2) <u>Load media</b></u>
It is possible to upload an image directly from the hard drive. Be sure to respect the maximum authorized dimensions and sizes, which can be configured in the Module Preferences.</ul>');
define('_AM_EDITO_MEDIA_HELP', '
For each page, it is possible to assign a media to it. The media supported are: images, sound, video and flash.

<ul><b>1) <u>Local media</b></u>
The storage location of the images is defined in the Preferences of the module (cf. <b> [LOGO] Directory of images </b>) and must imperatively be hosted. on the site server. The list of media thus available is displayed in the drop-down list.
Local media have priority over external media.</ul>
<ul><b>2) <u>Load media</b></u>
It is possible to download media directly from the hard drive. Be sure to respect the maximum authorized dimensions and sizes, which can be set in the module settings.
</ul>
<ul><b>3) <u>External media</b></u>
t is possible to indicate the address (url) of a media hosted on another server. It is also possible to use <b> [MEDIA] Custom Media </b> (See Module Preferences) to force playback of files by Windows Media Player.
</ul>
<ul><b>4) <u>Display formats</b></u>
The display format of the media is defined either by default, or by selecting one of the modes offered. It is possible to use a <i> custom </i> display mode, defined in the module Preferences. See <b> [MEDIA] Custom size</b>.</ul>
');
/* define("_AM_EDITO_META_HELP",		"Pour chaque page cr�e, il est possible de personnaliser les metas � afficher :

<ul><li><b>Meta Title :</b> Titre des pages. Ce champ sera utilis� comme titre long et affich� en priorit� dans les pages du module, ainsi que les balises 'alt' et 'title' utilis�es dans les liens.</li>
<li><b>Meta Description :</b> Description de la page pour les moteurs de recherche.</li>
<li><b>Meta Keywords :</b> Mots cl�s de la page.</li></ul>
<b><u>3 modes diff�rents</u></b>
Dans les pr�f�rences du site (cf <b>[META] Meta Generateur</b>), il est possible d'activer l'un des trois modes suivants, afin de d�finir le mode de cr�ation des meta balises des pages du module.
<ul><b>1) Manuel :</b> Ne prend en consid�ration que ce qui est strictement indiqu� dans la page �dit�e. Si je ne mets rien, rien n'appara�t dans les metas.
</ul>
<ul><b>2) Semi-auto :</b> Prend en consid�ration les donn�es dans l'ordre suivante :
<ol><li>a. Ce qui est indiqu� dans la page.</li>
<li>b. Ce qui est indiqu� dans le module.</li>
<li>c. Ce qui est indiqu� dans le core.</li></ol></ul>
<ul><b>3) Auto :</b> A d�faut de donn�es manuelles, le module va g�n�rer les metas automatiquement en fonction du contenu de la page. Prend en consid�ration les donn�es dans l'ordre suivant :
<ol><li>Les metas mots-cl� de la page + les metas mots-cl�s issus du contenu et g�n�r�s automatiquement pas le script metagen.</li>
<li>Les metas mots-cl�s issus du contenu et g�n�r�s automatiquement pas le script metagen.</li>
<li>Ce qui est indiqu� dans les pr�f�rences du module.</li>
<li>Ce qui est indiqu� dans le core.</li></ol></ul>
<u><b>Priorit� des informations</b></u>

<ul><b>1) Semi-auto et auto</b> - les meta-titles sont g�n�r�s dans l'ordre de priorit� suivant :
<ol><li>Le meta-title de la page.</li>
<li>Le titre de la page.</li>
<li>Le titre du site (issu du core).</li></ol></ul>
<ul><b>2) Auto</b> - les meta-descriptions sont g�n�r�es dans l'ordre de priorit� suivant :
<ol><li>La meta-description de la page.</li>
<li>Les 255 premi�re lettres du contenu de la page (bloc et contenu confondu).</li>
<li>Le meta-titre de la page.</li>
<li>Le titre de la page.</li>
<li>La meta-description issue du Core.</li></ol></ul> ");
*/
define('_AM_EDITO_META_HELP', "
For each page created, it is possible to customize the metas to display, depending on the meta management mode defined in the module preferences.
<table cellspacing='0' cellpadding='1' border='1' style='width:100%; margin:10px;'>
<tr>
  <th style='width:15%;border:0px;'> </th>
  <th style='width:30%;text-align:center;'><u>Meta Title</u><br>
      Title of pages. This field will be used as a long title and displayed in priority in the module pages, as well as the 'alt' and 'title' tags used in the links.
  </th>
  <th style='width:30%;text-align:center;'><u>Meta Description</u><br>Description of the page for search engines.</th>
  <th style='width:30%;text-align:center;'><u>Meta Keywords</u><br>Keywords of the page.</th>
</tr>
<tr>
  <th><div align='center'><strong><u>Manual</u></strong></div>
Only takes into account the data strictly indicated on the page.</th>
<td colspan='3'><ul><li> What is shown on the page only.</li></ul></td>
</tr>
<tr>
  <th><div align='center'><strong><u>Semi-auto</u></strong></div>
Takes into consideration the data indicated according to the 3 levels (page, module, core).</th>
<td><ul><li>Meta-title of the page.</li>
<li>Page title.</li>
<li>Core (site prefs).</li>
</ul></td>
  <td colspan='2'> <ul><li>Page (Meta-description or Meta-keywords).</li>
<li>Module (module prefs.)</li>
<li>Core (site prefs.).</li>
</ul>
 </td>
 </tr>
 <tr><th><div align='center'> <strong><u>Auto</u></strong></div>
In the absence of data, the module will generate the metas automatically according to the content of the page.
</th>
<td> <ul><li>Meta-title of the page.</li>
<li>Page title.</li>
</ul>
</td>
  <td> <ul><li>The meta-description of the page.</li>
<li>The first 255 letters of the page content (block and content combined).</li>
<li>Meta-title or page title <br> & nbsp; & nbsp; + module description (module prefs).</li>
<li>Core (site prefs.).</li>
</ul>
</td>
  <td> <ul><li>The metas keywords of the page <br> & nbsp; & nbsp; + the metas keywords from the content, not generated by the metagen script <br> & nbsp; & nbsp; + the metas keywords of the module (pref. of the module).</li>
<li>The metas keywords from the content and automatically generated by the metagen script <br> & nbsp; & nbsp; + Module keywords (module prefs).</li>
<li>
Title or meta-title of the page <br> & nbsp; & nbsp; + Keywords of the module (module prefs.).</li>
</ul>
</td>
 </tr>
 </table>
 <u><b>Script Metagen</b></u><br>
The metagen script works like this:
 <ol><li>
 Retrieving all page content

(title, meta-title, block content and text cops)
 and extracting a list of key words based on
 their size (min and max of letters)
 and their occurrences (min and max occurrences), by removing accents, numbers and codes. </li>
 <li> Extraction of 90 lowercase words to display in meta-tags. </li>
 <li> If there are less than 45 words, duplicate the created words with the addition of a capital letter. </li>
 <li> If there are less than 30 words, new duplication in capital letters. </li> </ol>
 The script ignores plural or singular forms, or the gender of words. <p>
 The meta data are saved when the page is created or updated.
 If the meta management mode is modified in the module preferences,
 it is necessary to update the previously created pages to take into account the new modifications.
");
define('_AM_EDITO_MISC_HELP', '
Allows you to refine the options concerning the current page. These options can be defined by default in the module preferences (see tags <b> [OPTION])</b>.
<ul>
<b>1) <u>Groups</u></b>
Defines the groups which have access or not to the current page. These access permissions apply to content pages as well as to the module index, content or menu blocks.</ul>
<ul><b>2) <u>Readings</u></b>
Set the number of times the page has been viewed. In the module preferences, it is possible to indicate whether you want the pages viewed by the administrator to be viewed or not (cf. <b> [PAGE] Admin read counter </b> ). </ul>
<ul><b>3) <u>Options</u></b>
Sets various options applicable to the page.
<ol>
<li><b>Display title </b>: display the title on the page or not.</li>
<li><b>Display logo </b>: display or not the logo on the page.</li>
<li><b>Allow comments </b>: Whether or not to allow comments on the page. Depends on <b> Comment Rules </b> in module preferences.</li>
<li><b>Activate HTML tags </b>: activate or not the html on the page.</li>
<li><b>Activate Smileys </b>: activate or not the smileys on the page.</li>
<li><b>Activate XOOPS codes (BBCodes) </b>: activate or not the BBcodes on the page. Disabling this option also disables any multilingual functionality, if any.</li></ol></ul>
');
