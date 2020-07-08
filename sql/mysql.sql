#
# Table structure for Edito 'content' table
#

CREATE TABLE `edito_content` (
    `id`         INT(11)             NOT NULL AUTO_INCREMENT,
    `uid`        INT(6) UNSIGNED     NOT NULL DEFAULT 1,
    `datesub`    INT(11) UNSIGNED    NOT NULL DEFAULT 0,
    `counter`    INT(8)  UNSIGNED    NOT NULL DEFAULT 0,
    `status`     TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
    `subject`    VARCHAR(255)                 DEFAULT NULL,
    `block_text` TEXT,
    `body_text`  TEXT,
    `image`      VARCHAR(255)        NOT NULL DEFAULT '',
    `media`      VARCHAR(255)        NOT NULL DEFAULT '|media.mpg|',
    `meta`       TEXT,
    `groups`     VARCHAR(255)        NOT NULL DEFAULT '',
    `options`    VARCHAR(36)         NOT NULL DEFAULT '',
    PRIMARY KEY (`id`),
    KEY uid (`uid`)
)
    ENGINE = MyISAM;


INSERT INTO `edito_content` VALUES (null, 1, 1593608400, 0, 1, 'All about &Eacute;dito...', '<p class="center"><strong>&Eacute;dito is a simple multifunction content module.</strong></p><p class="center">The main objective of this module is to allow users or webmasters who are not used to web or module management to easily display articles or similar material on their site.<br><br>Other benefits include plenty of features that allow the webmaster to personalize the use of the module. This includes very flexible block content allowing many display type options.<br><br>Another top feature is the ability to display content meta information such as keywords and description within the page html. This can be set on a module basis in admin and also parsed on an individual page basis.<br><br>This module do not include any categorization system. This is made on purpose, as may other content modules (publisher, news, and others) already fill that purpose.<br><br>Thanks for choosing &Eacute;dito, as always, we are happy to receive any comments and feedback so that we may continually improve the quality and features of this module.</p><p class="right"><em>Solo</em></p><p class="right"><hr></p><div><ol><li>Preferences</li><li>Blocks settings</li><li>Utilities</li><li>Credits</li></ol></div>', '<h1 class="center">Preferences (or module settings)</h1><div class="left">Before using this module, we suggest you have a careful look at the admin settings. This is where you will define the functional and personal settings for the module. These settings have a direct impact on the content pages, blocks and admin preferences.<br><br>They are all classified in sections, indicated by square braces around each [SECTION NAME] as follows:<br><br><strong>~Banner:</strong> Put the url of your module banner here. Pictures and flash supported.<br><br><strong>~Intro:</strong> Put the text you want to see above the index list here. This text accept XOOPS and HTML codes.<br><br><strong>~Default text: </strong>You can set a default page content for each and every new page created. This can be useful if you want to keep or define some particular template for you content. Using the <em><strong>{lorem}</strong></em> tag would display Ipsus Lorem content.<br><br><strong>~Footer:</strong> Content of your module footer.<br><br><strong>~Index Columns:</strong> Ranging from 1 to 5, it defines the number of columns to display in the index page on <em><strong>index image</strong></em> mode.<br><br><strong><em>~Order:</em> </strong>The pages order in the displayed list � This setting affect the whole module content except the blocks.</div><ol><li><div class="left"><strong>Title:</strong> display in alphabetical order </div></li><li><div class="left"><strong>Recent:</strong> The most recent first </div></li><li><div class="left"><strong>Popular:</strong> The most viewed first. </div></li></ol><div class="left">Note that if you use the two last method, the page title will show up the publication date or number of view.<br><br><strong><em>~Maximum articles per page:</em> </strong><br>Ranging from 65 to 50, it defines the amount of pages to display in the main page. If your amount of pages is bigger than this number, a page index number will automatically show up at the bottom of the index page. Note that this option affects the number of pages to display in the whole module, admin, blocks and page lists also.<br><br><strong><em>~Images sizes:</em> </strong><br>Regardless of the real size of the logo you have uploaded on the server, this setting will automatically resize the picture width for each and every page�s pictures. Note that an undersized picture would keep its original size. Value is set as following:<em><strong> ''''width|height''''</strong> .</em> <br><strong><em>~Logo alignment: </em></strong>Select the alignment of the logo for each and every page. You can choose, left, right or center. Not this affect the whole module and blocks logo and media display.<br><br><strong><em>~Admin counter read: </em></strong>define whether or not you want the counter to consider admin as a visit. Default is set to �no�.<br><br><strong><em>~Maximum upload size:</em> </strong>Sets the maximum file size allowed when uploading files. This option is restricted to max upload permitted on the server.<br><br><strong><em>~Maximum image size: </em></strong>Sets the maximum allowed width and height of an image when uploading. Value is set as following:<strong><em> ''''width|height''''.</em> </strong><br><br><strong><em>~Image upload directory: </em></strong>This is the directory where illustration pics will be stored. (No trailing ''''/'''') Changing the directory name would automatically generate the new directory on the server.<br><br><strong><em>~Media base directory: </em></strong>This is the directory where illustration pics will be stored. (No trailing ''''/'''') Changing the directory name would automatically generate the new directory on the server.<br><br><strong><em>~Media downloadable:</em> </strong>Define whether you want to display the download icon on media pages.<br><br><br><strong>Extended options : </strong><br>If you select yes, the below options would be available for each and every new page. If not, they won�t display, and the current option would be used as default.<br><br><strong><em>~Groups access:</em> </strong>Define the default group permissions for each and every new pages.<br><br><strong><em>~Show Block�s content:</em> </strong>Define whether you want to display or hide page�s related block content.<br><br><strong><em>~Show Title:</em> </strong><br>Define whether you want to display or hide page�s title.<br><br><strong><em>~Show Logo:</em> </strong><br>Define whether you want to display or hide page�s logo/picture.<br><br><strong><em>~Authorise Comments: </em></strong>Define whether you want to authorise comments on the current page.<br><br><strong><em>~Use WYSIWYG Editor: </em></strong>define which wysiwyg editor: standard DHTML Xoops editor, or installed XOOPS WYSIWYG editor.<br><br><strong><em>~Show icons: </em></strong>define whether or not you want to show the media infos, �popular� (most read) or �new� (most recent) icons in the index or on pages.<br><br><strong><em>~New icons (in days):</em> </strong><br>Fix the value in days to define whether the page is new or not. Default is set to 7, but there are no limits.<br><br><strong><em>~Popularity icons:</em> </strong><br>Fix the value of views to define whether the page is popular or not. Default is set to 100, but there are no limits.<br><br><strong><em>~Meta generator: </em></strong>The module uses the metagen script which allow to automatically generate the meta tags regarding the page content. 3 available options : </div><ol><li><div class="left"><strong>Auto:</strong> let the metagen manage your meta tags.</div></li><li><div class="left"><strong>Mix:</strong> use both the metagen and custom metatags (default).</div></li><li><div class="left"><strong>Manual:</strong> use only custom metatags.</div></li></ol><div class="left"><strong><em>~Module Meta Keywords: </em></strong>Add here the custom keywords you would like to add on each page of this module. </div><div class="left"><br><strong><em>~Module Meta Description: </em></strong>You can customize here the meta description of the pages inside your module. If this text area is empty, the default Meta Description of your site will prevail.</div><div class="left"></div><strong><em><div class="left"><br>~Redirection page: Define here the default index redirection page. This can be both an url or a module page id. <br><strong><em><br>~Index mode: </em></strong>several possible mode/template for your index display : </div></em></strong>Define here the default index redirection page. This can be both an url or a module page id. several possible mode/template for your index display : <div><ol><li><div class="left"><strong>Images:</strong> display only pages logo (no content displayed).</div></li><li><div class="left"><strong>Table:</strong> display a more complet table with various pages infos (display block content).</div></li><li><div class="left"><strong>News:</strong> display like the news index module (display block content).</div></li><li><div class="left"><strong>Blog:</strong> display the full page content like a blog module (display both block and body content).</div></li></ol></div><div class="left"><strong><em>~Navigation links: </em></strong>display a navigation box under each and every module content pages. </div><div><ol><li><div class="left"><strong>None:</strong> don''''t display any navigation links.</div></li><li><div class="left"><strong>Bloc:</strong> display the menu as a list block directly in the content area.</div></li><li><div class="left"><strong>List:</strong> display a list of link at the bottom of the page.</div></li><li><div class="left"><strong>Path:</strong> display a path like list at the bottom of the content area.</div></li></ol><strong><em>~Media display mode:</em> </strong>display a navigation box under each and every module content pages. </div><ol><li><div class="left"><strong>Popup:</strong> display media in a popup.</div></li><li><div class="left"><strong>Page:</strong> display media within the page</div></li><li><div class="left"><strong>Popup &amp; Page:</strong> allow both options.</div></li></ol><p class="left"><strong><em>~Media custom size:</em> </strong>Custom media display size.<br>Value is set as following:<em><strong> ''''width|height''''</strong> .</em> </p><p class="left"><strong><em>~Media options:</em> </strong>Media options.<br>Loop|Autostart|background<br><br><strong><em>~Default Media display:</em> </strong>select the default display size for each and every new page. </p><ol><li><div class="left"><strong>None:</strong> default media size.</div></li><li><div class="left"><strong>Custom:</strong> Custom size (see above setting).</div></li><li><div class="left"><strong>TV (small - medium - big):</strong> 3/4 size style.</div></li><li><div class="left"><strong>Cine (small - medium - big):</strong> cinemascopr size style.</div></li></ol><p class="left"><strong><em>~Comment Rules:</em> </strong><br>Define the general comments rules on your module.<br><br><strong><em>~Allow anonymous post in comments:</em> </strong><br>Self-explanatory.<br><br>[pagebreak]</p><h1 class="center">Blocks settings </h1><p class="left">One of the most important features of this module is the blocks. You have 2 menu blocks and 4 content linked blocks. Why so many? Because for each and every available blocks, you can have a very wide range of applications and options.<br><br>When editing a block, use the �Setting� option.<br><br><strong>a) <u>Menu Block</u> </strong><u></u>There are 2 of them. Those blocs display the module page list.<br><br><em><strong>~Display mode:</strong> Different possibilities to display the module pages list.</em> </p><ol><li><div><strong>Menu</strong> (no pictures)</div></li><li><div><strong>List</strong> (no pictures)</div></li><li><div><strong>Images</strong> </div></li><li><div><strong>Extended table</strong> (Informations and pictures)</div></li></ol><p><strong><em>~Images sizes:</em> </strong>Regardless of the real size of the logo you have uploaded on the server, this setting will automatically resize the picture width for each and every page�s pictures. Note that an undersized picture would keep its original size. Value is set as following:<em><strong> ''''width|height''''</strong> .</em> <strong>~Index Columns:</strong> Ranging from 1 to 5, it defines the number of columns to display in the block on <strong><em>Images</em> </strong>mode.</p><p class="left"><strong><em>~Order:</em> </strong>The pages order in the displayed list � This setting affect the whole module content except the blocks.</p><ol><li><div class="left"><strong>Title:</strong> display in alphabetical order </div></li><li><div class="left"><strong>Recent:</strong> The most recent first </div></li><li><div class="left"><strong>Popular:</strong> The most viewed first. </div></li></ol><p class="left"><br><strong>b) <u>Content Blocks</u> </strong><u></u>There are 4 of them. </p><p class="left"><strong><em>~Maximum size:</em> </strong>Maximum text size to be displayed in block.</p><p><strong><em>~Page selection:</em> </strong>You can display page content in various different ways:</p><ol><li><div><strong>Random: </strong>pick randomly an &Eacute;dito (must be online).</div></li><li><div><strong>Latest: </strong>display the most recent page (must be online).</div></li><li><div><strong>Most viewed (or most popular):</strong> displays the most viewed page (must be online).</div></li><li><div><strong>Linked to &Eacute;dito:</strong> this block will display the current page�s block content. That is, if you are on the &Eacute;dito 1, the block will display the &Eacute;dito 1 block�s content (thanks to the [blockbreak] fconsistingon-lineon-lineon lineon lineon lineon lineunction).</div></li><li><div><strong>Each day of the year, of the month, of the weekday: </strong>those functions are linked to the &Eacute;dito�s id. Let say we are the day 71 of the year, it would display the &Eacute;dito number 71.</div></li><li><div><strong>Specific page: </strong>you can define a specific page to be displayed in the current block. Just pick it in the list. It can be offline or not.</div></li></ol><p><strong><em>~Display title:</em> </strong>Check to display the page title.</p><p><strong><em>~Display logo:</em> </strong>Check to display the page image.</p><p><strong><em>~Media Display mode:</em> </strong></p><ol><li><div class="left"><strong>Popup:</strong> display media in a popup.</div></li><li><div class="left"><strong>Block:</strong> display media within the page.</div></li><li><div class="left"><strong>Popup &amp; Block:</strong> allow both options.</div></li></ol><p class="left">[pagebreak]</p><h1 class="center">Utilities </h1><p class="left">Included with the module, you will find a utilities section. <br><br><strong>a) <u>Upload a media</u> </strong></p><p class="left">With this form, you will be able to upload new medias directly from your hard drive to your web server. All uploaded files are going to be stocked in the <strong>Media base directory</strong> , defined in your module settings.<br><br><strong>b) <u>Clone the module</u> </strong></p><p class="left">With this form, you will be able to clone the entire module. <br><br>You just have to respect the following naming rules:</p><ul><li>No numbers </li><li>Not more than 16 caracters</li><li>No special caracters (Capital letters, spaces, underscore and minus signs accepted though).</li></ul><p>No already existing module name (neither the ''''content'''' word).<br><br>Once cloned, you will be able to install the new module... Optionnaly, you may want to change the cloned module logo for a easier spotting on the admin section. For that matter, use the ''''blank_slogo.png'''' file included in the module ''''image'''' directory. <br>[pagebreak]</p><h1 class="center">Credits </h1><p>With respect to the design and creation of this module, credits and thanks go to several xoopers who have contributed directly or indirectly: </p><ul><li>Christian </li><li>Herv&eacute;</li><li>Marcan </li><li>Carnuke </li><li>DuGRis </li><li>Blueteen</li><li>Solo</li><li>Every Xoopser on forums for their help, coding tricks and suggestions...</li></ul>', 'content_slogo.png', '||default', '&Eacute;dito 3.x: the multipurpose and multimedia XOOPS content module|&Eacute;dito is a multifunction and multimedia content module designed for XOOPS 2.5.x. by the WolFActory. ||&Eacute;dito, edito, multifunctions, content, XOOPS, wolfactory', '1 2 3', '1|1|1|1|1|1|1');
