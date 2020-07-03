<?php

declare(strict_types=1);

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

//	Partie administration
// define("_AM_EDITO_UPDATE_INFO",	"Vous pouvez modifier les informations du module<br>Ins�rez [blockbreak] pour indiquer la limite du texte dans le bloc.");

// admin/fichier index.php
define('_AM_EDITO_CREATE', 'Cr�er une nouvelle page');
define('_AM_EDITO_DUPLICATE', 'Dupliquer une page');
define('_AM_EDITO_EDIT', 'Editer une page');
define('_AM_EDITO_DELETE', 'Supprimer une page');
define('_AM_EDITO_HELP', 'Aide');

define('_AM_EDITO_ADD', 'Ajouter');
define('_AM_EDITO_LIST', 'Liste des pages');
define('_AM_EDITO_ID', 'ID');
define('_AM_EDITO_SUBJECT', 'Sujet');
define('_AM_EDITO_METATITLE', '[META] Titre');
define('_AM_EDITO_METAKEYWORDS', '[META] Mots cl�s');
define('_AM_EDITO_METADESCRIPTION', '[META] Description');
define('_AM_EDITO_METAGEN', '[METAGEN] <p>Mots cl�s g�n�r�s<br>automatiquement<br>par le script MetaGen.');
define('_AM_EDITO_BEGIN', 'D�but page');
define('_AM_EDITO_COUNTER', 'Lectures');
define('_AM_EDITO_ONLINE', 'Afficher');
define('_AM_EDITO_HIDDEN', 'Cacher');
define('_AM_EDITO_OFFLINE', 'D�sactiver');
define('_AM_EDITO_ACTIONS', 'Actions');
// define("_AM_NO_EDITO",			"Aucune page � afficher");
define('_AM_EDITO_ALL', 'Tous');
define('_AM_EDITO_ORDEREDBY', 'Classement');
define('_AM_EDITO_REWRITING', 'Url Rewriting actif');
define('_AM_EDITO_NOREWRITING', 'Url Rewriting inactif');
define('_AM_EDITO_REWRITING_INFO',
       "Un probl�me est survenu lors de l'�criture du fichier .htaccess sur le serveur.<p>Pour �viter ce probl�me, copier le fichier<br><b>'modules/edito/doc/htaccess/.htaccess'</b><br>dans le r�pertoire<br><b>'modules/edito/'</b>");

// admin/content.php
define('_AM_EDITO_NOEDITOTOEDIT', 'Aucune page � �diter');
define('_AM_EDITO_ADMINARTMNGMT', 'Gestion des pages');
define('_AM_EDITO_MODEDITO', "Modification d'une page");
define('_AM_EDITO_BODYTEXT', "Corps du texte<p>
<i><font color='red'>[pagebreak]</font><br>
pour afficher<br>
le contenu sur<br>
plusieurs pages.</i><br>
<br>
<i><font color='red'>{media}</font><br>
pour afficher<br>
le media courant<br>
dans le texte.</i><br>
<br>
<i><font color='red'>{block}</font><br>
pour afficher<br>
le contenu du bloc<br>
dans le texte.</i>");
define('_AM_EDITO_BLOCKTEXT', 'Contenu du bloc');
define('_AM_EDITO_BODY', 'Contenu');
define('_AM_EDITO_IMAGE', 'Image');
define('_AM_EDITO_SELECT_IMG', 'Image');
define('_AM_EDITO_UPLOADIMAGE', 'Charger une image');
define('_AM_EDITO_STATUS', 'Statuts');
define('_AM_EDITO_BLOCK', 'Afficher le contenu <br>du bloc<br>dans la page');

define('_AM_EDITO_OPTIONS', 'Options');
define('_AM_EDITO_HTML', ' Activer les balises HTML');
define('_AM_EDITO_SMILEY', ' Activer les Smileys ');
define('_AM_EDITO_XCODE', ' Activer codes XOOPS (BBCodes)<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i>D�sactiver cette option, d�sactive aussi les fonctionnalit�s multilangues �ventuelles.</i>');
define('_AM_EDITO_TITLE', ' Afficher le titre');
define('_AM_EDITO_LOGO', ' Afficher le logo');
define('_AM_EDITO_ALLOWCOMMENTS', ' Autoriser les commentaires');

define('_AM_EDITO_SUBMIT', 'Valider');
define('_AM_EDITO_CLEAR', 'Effacer');
define('_AM_EDITO_CANCEL', 'Annuler');
define('_AM_EDITO_MODIFY', 'Modifier');
define('_AM_EDITO_FILEEXISTS', 'Le fichier existe d�j�');
define('_AM_EDITO_CREATED', 'Nouvelle page cr��e avec succ�s');
define('_AM_EDITO_NOTCREATED', 'Impossible de cr�er une nouvelle page');
define('_AM_EDITO_CANTPARENT', 'Une page m�re ne peut se lier � elle-m�me ou � sa fille !');
define('_AM_EDITO_MODIFIED', 'Base de donn�es mise � jour avec succ�s');
define('_AM_EDITO_NOTUPDATED', "La base de donn�es n'a pu �tre mise � jour");
define('_AM_EDITO_DELETED', 'Page supprim�e avec succ�s');
define('_AM_EDITO_DELETETHIS', 'Confirmez-vous la suppression de cette page :');

define('_AM_EDITO_YES', _YES);
define('_AM_EDITO_NO', _NO);
define('_AM_EDITO_NO_EDITO', 'Aucune page');

// Barre de Navigation
define('_AM_EDITO_NAV_INDEX', 'Aller au module');
define('_AM_EDITO_NAV_LIST', 'Liste des pages');
define('_AM_EDITO_NAV_CREATE', 'Cr�er une page');
define('_AM_EDITO_NAV_PREFERENCES', 'Pr�f�rences');
define('_AM_EDITO_NAV_SEE', 'Voir la page');
define('_AM_EDITO_NAV_HELP', 'Aide');
define('_AM_EDITO_NAV_CONFIG', 'Administration');
define('_AM_EDITO_NAV_PERMS', 'Permissions');
define('_AM_EDITO_NAV_BLOCKS_GROUPS', 'Blocs et Groupes');
//define("_AM_EDITO_BLOCKS_GROUPS",	"Blocs et Groupes");
define('_AM_EDITO_BLOCKS', 'Blocs');
define('_AM_EDITO_GROUPS', 'Groupes');

define('_AM_EDITO_BLOCK_LINK', 'Administration des blocs');
define('_AM_EDITO_BLOCK_EDITO', 'Blocs Edito');
define('_AM_EDITO_BLOCK_MENU', 'Blocs Menu');

// myMedia
define('_AM_EDITO_SELECT_MEDIA', "Media local<br><br>
                                         <i><font color='red'>
                                         Fichiers du r�pertoire :<br>
                                         '" . $xoopsModuleConfig['sbmediadir'] . "'
                                         </font><br>
                                         *Prioritaire sur le m�dia externe.</i>");
define('_AM_EDITO_MEDIA', 'Media');
define('_AM_EDITO_UPLOADMEDIA', 'Charger un media');

define('_AM_EDITO_MEDIALOCAL', 'Media Local ');
define('_AM_EDITO_MEDIAURL', 'Media externe');

define('_AM_EDITO_MEDIA_SIZE', "Format d'affichage");

define('_AM_EDITO_SELECT_DEFAULT', '- aucun -');
define('_AM_EDITO_SELECT_TVSMALL', 'TV Petit');
define('_AM_EDITO_SELECT_TVMEDIUM', 'TV Moyen');
define('_AM_EDITO_SELECT_TVBIG', 'TV Large');
define('_AM_EDITO_SELECT_CUSTOM', 'Personnalis�');
define('_AM_EDITO_SELECT_MVSMALL', 'MOVIE Petit');
define('_AM_EDITO_SELECT_MVMEDIUM', 'MOVIE Moyen');
define('_AM_EDITO_SELECT_MVBIG', 'MOVIE Large');

define('_AM_EDITO_METAOPTIONS', 'Options Metas');
define('_AM_EDITO_MEDIAOPTIONS', 'Options Medias');
define('_AM_EDITO_IMAGEOPTIONS', 'Options Images');
define('_AM_EDITO_MISCOPTIONS', 'Options Diverses');

define('_AM_EDITO_HIDE', 'Masquer');
define('_AM_EDITO_SHOW', 'Afficher');
define('_AM_EDITO_SHOWHIDE', 'Afficher/Masquer');
define('_AM_EDITO_HTMLMODE', 'Mode Html');
define('_AM_EDITO_PHPMODE', 'Mode Php');
define('_AM_EDITO_WAITING', 'En attente');

// Utilities
define('_AM_EDITO_PAGE', 'Page');
define('_AM_EDITO_UTILITIES', 'Utilitaires');
define('_AM_EDITO_WYSIWYG', 'Editeurs WYSIWYG disponibles');
define('_AM_EDITO_UPLOAD', 'T�l�verser un media');
define('_AM_EDITO_UPLOAD_ERROR', 'Le t�l�chargement du m�dia a �chou�');
define('_AM_EDITO_MEDIAUPLOADED', 'Media t�l�charg� avec succ�s');
define('_AM_EDITO_FILECREATED', 'Fichier cr�� avec succ�s.');
define('_AM_EDITO_UPLOADED', 'Image t�l�charg�e avec succ�s.');
define('_AM_EDITO_UPDATED', 'Image mise � jour avec succ�s.');
define('_AM_EDITO_CLONE', 'Cloner le module');
define('_AM_EDITO_CLONED', 'Module clon� avec succ�s');
define('_AM_EDITO_MODULEXISTS', 'Ce module existe d�j�');
define('_AM_EDITO_NOTCLONED', 'Les param�tres du clonage sont incorrectes');
define('_AM_EDITO_CLONE_TROUBLE', "Le clone a �t� cr�� dans le dossier 'cache' � la racine de votre site.<br>Vous devez simplement le d�placer dans le dossier 'modules' avec votre client ftp.
<br>
Et changer les attributs du clone et des sous-dossiers en 644, toujours avec votre client ftp par exemple.<br>
<br>
Vous pourrez ensuite installer votre clone comme n'importe quel module.
");
define('_AM_EDITO_CLONENAME', "Nom du clone<br><i>
                                         <ul>
                                             <li>Pas de chiffres</li>
                                             <li>Pas plus de 12 caract�res</li>
                                             <li>Pas de caract�res sp�ciaux</li>
                                             <li>Pas de nom de module d�j� existant</li>
                                             <li>Lettre capitale et espacements acc�pt�s</li>
                                         </ul></i>
                                         Exemple : 'Mon Module'. ");
define('_AM_EDITO_EDITORS', 'Editeurs disponibles');

define('_AM_EDITO_DB_DATAS', 'Donn�es SQL');
define('_AM_EDITO_DB_IMPORT', 'Importation dans la base de donn�e');
define('_AM_EDITO_DB_EXPORT', 'Exportation de la base de donn�e');
define('_AM_EDITO_EXPORT', 'Exporter');
define('_AM_EDITO_INSERT', 'Ajouter');
define('_AM_EDITO_UPDATE', 'Mettre � jour');
define('_AM_EDITO_TYPE', "Type d'export");
define('_AM_EDITO_SITELIST', 'Liste des sites autoris�s<p>
<i>Exemple :<br>
www.frxoops.org|<br>
wolfpackclan.com|<br>
127.0.0.1</i>');

// Anti-leech
define('_AM_EDITO_HTACCESS', 'Protection des m�dias');
define('_AM_EDITO_COPY', 'Copier le code');
define('_AM_EDITO_HTACCESS_INFO1', "Si vous ne voulez pas que d'autres sites utilisent vos medias, suivez ces instructions pour cr�er un fichier .htaccess.
<ol><li>Ouvrez le Notepad (ou editeur �quivalent suivant votre OS) et copiez le code suivant :</li></ol>");

define('_AM_EDITO_HTACCESS_INFO2', "<ol><li>D�posez le fichier .htaccess.txt ainsi cr�� via FTP en mode ASCII, dans le r�pertoire de stockage de vos m�dias.</li>
<li>Apr�s l'avoir t�l�charg�, cliquez sur le fichier et renommez-le.</li>
<li>Editez le nom du fichier en '.htaccess' (sans l'extension .txt).</li></ol>Voil�, maintenant, les autres sites ne pourront plus utiliser vos m�dias sur votre propre site.
Bon amusement !");

define('_AM_EDITO_MAKE_UPDATE', "La mise � jour du module n'a pas �t� effectu�e : ");
define('_AM_EDITO_MAKE_UPGRADE', "Une nouvelle version d'Edito est disponible en t�l�chargement � cette adresse : <br><br>");

// Help datas
define('_AM_EDITO_CONTENT_HELP', "
<ul><b>1) <u>Sujet</u></b>
Indiquez le titre court de la page (Voir aussi meta titre). Ce titre est employ� dans les liens de navigation, et par d�faut en cas d'absence de meta-title.
</ul>
<ul><b>2) <u>Statuts</u></b>
Il y a 6 statuts possibles pour votre page.
<ul><ol>
    <li><img src='../assets/images/icon/online.gif' align='absmiddle'> <b>Afficher :</b> Affichage normal de la page dans le module.</li>
    <li><img src='../assets/images/icon/waiting.gif' align='absmiddle'> <b>En attente :</b> La page est en attente de validation. Elle n'est visible que par les administrateurs.</li>
    <li><img src='../assets/images/icon/hidden.gif' align='absmiddle'> <b>Cacher :</b> Affichage de la page ind�pendamment de toute information relative au module.
	La page n'est pas reprise dans les indexes du module, ni dans le bloc de menu.</li>
	<li><img src='../assets/images/icon/offline.gif' align='absmiddle'> <b>D�sactiver :</b> La page est totalement innaccessible.</li>
    <li><img src='../assets/images/icon/html.gif' align='absmiddle'> <b>Mode HTML :</b> Affiche le contenu de la page uniquement en mode html.
	N'interpr�te pas les codes XOOPS et autre retours � la ligne �ventuels.</li>
	<li><img src='../assets/images/icon/php.gif' align='absmiddle'> <b>Mode php :</b> Interpr�te le contenu de la page comme du code php.</li>
</ol></ul><ul>
<b>3) <u>Contenu du Block</u></b>
Le contenu renseign� dans cette zone de texte, s'affichera prioritairement dans les blocs de contenu du module.
Dans le cas de la page d'index, il s'affichera en mode 'tableau' et 'news'.
Le contenu de cette zone n'est pas interpr�t� en mode 'php'.
Le contenu de cette zone est aussi utilis� pour g�n�rer automatiquement les metakeywords.
</ul>
<ul><b>4) <u>Afficher le contenu du bloc dans la page</u></b>
En cochant cette option, le contenu du bloc s'affichera dans la page li�e (Voir aussi balises sp�ciales).
</ul>
<ul><b>5) <u>Corps du texte</u></b>
Le contenu renseign� dans cette zone de texte est utilis� sur la page principale.
Le contenu de cette zone est aussi utilis� pour g�n�rer automatiquement les metakeywords.
En mode php, c'est dans cette zone que doit �tre indiqu�e le code php � interpr�ter. A noter qu'il ne faut pas renseigner les balises <b>&#139;? php</b> et <b>?&#155;</b> habituelles.
</ul>
<img src='../assets/images/icon/tip.gif' align='absleft'><b>Balises sp�ciales</b> : les balises suivantes peuvent �tre utilis�es dans le texte :
<ul><ol>
    <li><i><b>[pagebreak]</b></i> : pour afficher le contenu sur plusieurs pages.</li>
    <li><i><b>{media}</b></i> pour afficher le media courant dans le texte. En utilisant cette balise, le media ne s'affichera plus en t�te de page.</li>
	<li><i><b>{block}</b></i> pour afficher le contenu du bloc dans le texte, sous forme d'encadr�.</li>
    <li><i><b>{block align=\"left\"}</b></i> : le bloc s'affichera � gauche.</li>
	<li><i><b>{block align=\"right\"}</b></i> : le bloc s'affichera � droite.</li>
	<li><i><b>{block align=\"center\"}</b></i> : le bloc s'affichera au centre.</li>
</ol></ul>
");
define('_AM_EDITO_IMAGE_HELP', "Pour chaque page cr��e, il est possible d'y affecter une image repr�sentative.
<ul><b>1) <u>Image</b></u>
L'emplacement de stockage des images est d�fini dans les Pr�f�rences du module (cf. <b>[LOGO] R�pertoire des images</b>) et doit imp�rativement �tre h�berg� sur le serveur du site. La liste des images ainsi disponibles s'affiche dans la liste d�roulante. Vous pouvez pr�visualiser l'image en la s�lectionnant.
</ul>
<ul><b>2) <u>Charger un m�dia</b></u>
Il est possible de t�l�verser une image directement � partir du disque dur. Veillez � respecter les dimensions et les tailles maximum autoris�es, param�trables dans les Pr�f�rences du module.</ul>");
define('_AM_EDITO_MEDIA_HELP', "Pour chaque page, il est possible d'y affecter un m�dia. Les media support�s sont les suivants : images, son, vid�o et flash.

<ul><b>1) <u>M�dia local</b></u>
L'emplacement de stockage des images est d�fini dans les Pr�f�rences du module (cf. <b>[LOGO] R�pertoire des images</b>) et doit imp�rativement �tre h�berg� sur le serveur du site. La liste des medias ainsi disponibles s'affiche dans la liste d�roulante.
Les medias locaux sont prioriataires sur les medias externes.
</ul>
<ul><b>2) <u>Charger un m�dia</b></u>
Il est possible de t�l�verser un media directement � partir du disque dur. Veillez � respecter les dimensions et les tailles maximum autoris�es, param�trables dans les param�tres du module.
</ul>
<ul><b>3) <u>Media externe</b></u>
Il est possible d'indiquer l'adresse (url) d'un media h�berg� sur un autre serveur. Il est aussi possible d'utiliser des <b>[MEDIA] Medias personnalis�s</b> (Voir Pr�f�rences du module) afin de forcer la lecture des fichiers par Windows Media Player.
</ul>
<ul><b>4) <u>Formats d'affichage</b></u>
Le format d'affichage du m�dia est d�fini soit par d�faut, soit en s�lectionnant l'un des modes propos�s. Il est possible d'utiliser un mode d'affichage <i>personnalis�</i>, d�fini dans les Pr�f�rences du module. Voir <b>[MEDIA] Taille personnalis�e</b>.</ul>");
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
define('_AM_EDITO_META_HELP', "Pour chaque page cr��e, il est possible de personnaliser les metas � afficher, en fonction du mode de gestion des metas d�fini dans les pr�f�rences du module.
<table cellspacing='0' cellpadding='1' border='1' style='width:100%; margin:10px;'> <tr>
  <td style='width:15%;border:0px;'> </th>
  <th style='width:30%;text-align:center;'><u>Meta Title</u><br>
      Titre des pages. Ce champ sera utilis� comme titre long et affich� en priorit� dans les pages du module, ainsi que les balises 'alt' et 'title' utilis�es dans les liens.</th>
  <th style='width:30%;text-align:center;'><u>Meta Description</u><br>Description de la page pour les moteurs de recherche.</th>
  <th style='width:30%;text-align:center;'><u>Meta Keywords</u><br>Mots cl�s de la page.</th>
  </tr><tr><th><div align='center'><strong><u>Manuel</u></strong></div>
Ne prend en consid�ration que les donn�es strictement indiqu�es dans la page �dit�e.</th>
<td colspan='3'><ul><li> Ce qui est indiqu� dans la page uniquement.</li>
</ul>
</td>
</tr>
<tr>  <th><div align='center'><strong><u>Semi-auto</u></strong>
</div>
Prend en consid�ration les donn�es indiqu�e selon les 3 niveaux (page, module, core).</th>
  <td> <ul><li>Meta-titre de la page.</li>
<li>Titre de la page.</li>
<li>Core (pr�f. du site).</li>
</ul></td>
  <td colspan='2'> <ul><li>Page (Meta-description ou Meta-keywords).</li>
<li>Module (pr�f. du module.)</li>
<li>Core (pr�f. du site).</li>
</ul>
 </td>
 </tr>
 <tr>  <th><div align='center'> <strong><u>Auto</u></strong>
</div>
A d�faut de donn�es, le module va g�n�rer les metas automatiquement en fonction du contenu de la page.</th>
<td> <ul><li>Meta-titre de la page.</li>
<li>Titre de la page.</li>
</ul>
</td>
  <td> <ul><li>La meta-description de la page.</li>
<li>Les 255 premi�res lettres du contenu de la page (bloc et contenu confondu).</li>
<li>Meta-titre ou titre de la page<br>&nbsp;&nbsp;+ description du module (pr�f. du module).</li>
<li>Core (pr�f. du site).</li>
</ul>
</td>
  <td> <ul><li>Les metas mots-cl� de la page<br>&nbsp;&nbsp;+ les metas mots-cl�s issus du contenu, g�n�r�s pas le script metagen<br>&nbsp;&nbsp;+ les metas mots-cl�s du module (pr�f. du module).</li>
<li>Les metas mots-cl�s issus du contenu et g�n�r�s automatiquement pas le script metagen<br>&nbsp;&nbsp;+ Mots cl�s du module (pr�f. du module).</li>
<li>Titre ou meta-titre de la page<br>&nbsp;&nbsp;+ Mots cl�s du module (pr�f. du module).</li>
</ul>
</td>
 </tr>
 </table>
 <u><b>Script Metagen</b></u><br>
 Le script metagen fonctionne de la fa�on suivante :
 <ol><li>
 R�cup�ration de l'ensemble du contenu de la page
 (titre, meta-titre, contenu du bloc et coprs du texte)
 et extraction d'une liste de mots cl�s sur base
 de leur taille (min et max de lettres)
 et leur occurences (min et max d'occurence), en supprimant accents, chiffres et codes.</li>
 <li>Extraction de 90 mots minuscules � afficher dans les meta-balises.</li>
 <li>S'il y a moins de 45 mots, duplication des mots cr��s avec ajout d'une majuscule. </li>
 <li>S'il y a moins de 30 mots, nouvelle duplication en majuscule.</li></ol>
 Le script ne tient pas compte des formes pluriel ou singulier, ou du genre des mots.<p>
 Les meta donn�es sont enregistr�es lors de la cr�ation ou de la mise � jour de la page.
 Si le mode de gestion des meta est modifi�es dans les pr�f�rences du module,
 il faut mettre � jour les pages pr�cedemment cr��es pour prendre en compte les nouvelles modifications.
  ");
define('_AM_EDITO_MISC_HELP', "Permet d'affiner les options concernant la page en cours. Ces options peuvent �tre d�finies par d�faut dans les pr�f�rences du module (voir tags <b>[OPTION]</b>.
<ul>
<b>1) <u>Groupes</u></b>

D�fini les groupes ayant acc�s ou non � la page en cours. Ces autorisations d'acc�s s'appliquent aussi bien aux pages de contenu, qu'a l'index du module ou les blocs de contenu ou de menu.</ul>
<ul><b>2) <u>Lectures</u></b>

D�fini le nombre de fois que la page a �t� vue. Dans les pr�f�rences du module, il est possible d'indiquer si l'on souhaite que les pages vues par l'administrateur soient vue ou non (cf. <b>[PAGE] Compteur de lectures Admin</b>).</ul>
<ul><b>3) <u>Options</u></b>

D�finit diverses options applicables � la page.
<ol>
<li><b>Afficher le titre</b> : afficher ou non le titre sur la page.</li>
<li><b>Afficher le logo</b> : afficher ou non le logo sur la page.</li>
<li><b>Autoriser les commentaires</b> : autoriser ou non les commentaires sur la page. D�pend des <b>R�gles des commentaires</b> dans les pr�f�rences du module.</li>
<li><b>Activer les balises HTML</b> : active ou non le html sur la page.</li>
<li><b>Activer les Smileys </b> : active ou non les smileys sur la page.</li>
<li><b>Activer codes XOOPS (BBCodes)</b> : active ou non les BBcodes sur la page. D�sactiver cette option, d�sactive aussi les fonctionnalit�s multilangues �ventuelles.</li></ol></ul>");
