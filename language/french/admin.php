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
define("_MD_EDITO_CREATE",		"Créer une nouvelle page");
define("_MD_EDITO_DUPLICATE",		"Dupliquer une page");
define("_MD_EDITO_EDIT",		"Editer une page");
define("_MD_EDITO_DELETE",		"Supprimer une page");
define("_MD_EDITO_HELP",		"Aide");

define("_MD_EDITO_ADD",			"Ajouter");
define("_MD_EDITO_LIST",		"Liste des pages");
define("_MD_EDITO_ID",			"ID");
define("_MD_EDITO_SUBJECT",		"Sujet");
define("_MD_EDITO_METATITLE",		"[META] Titre");
define("_MD_EDITO_METAKEYWORDS",	"[META] Mots clés");
define("_MD_EDITO_METADESCRIPTION",	"[META] Description");
define("_MD_EDITO_METAGEN",	        "[METAGEN] <p />Mots clés générés<br />automatiquement<br />par le script MetaGen.");
define("_MD_EDITO_BEGIN",		"Début page");
define("_MD_EDITO_COUNTER",		"Lectures");
define("_MD_EDITO_ONLINE",		"Afficher");
define("_MD_EDITO_HIDDEN",		"Cacher");
define("_MD_EDITO_OFFLINE",		"Désactiver");
define("_MD_EDITO_ACTIONS",		"Actions");
// define("_MD_NO_EDITO",			"Aucune page à afficher");
define("_MD_EDITO_ALL",		        "Tous");
define("_MD_EDITO_ORDEREDBY",		"Classement");
define("_MD_EDITO_REWRITING",		"Url Rewriting actif");
define("_MD_EDITO_NOREWRITING",		"Url Rewriting inactif");
define("_MD_EDITO_REWRITING_INFO",	"Un problème est survenu lors de l'écriture du fichier .htaccess sur le serveur.<p />Pour éviter ce problème, copier le fichier<br /><b>'modules/edito/doc/htaccess/.htaccess'</b><br />dans le répertoire<br /><b>'modules/edito/'</b>");

// admin/content.php
define("_MD_EDITO_NOEDITOTOEDIT",	"Aucune page à éditer");
define("_MD_EDITO_ADMINARTMNGMT",	"Gestion des pages");
define("_MD_EDITO_MODEDITO",		"Modification d'une page");
define("_MD_EDITO_BODYTEXT",		"Corps du texte<p />
<i><font color='red'>[pagebreak]</font><br />
pour afficher<br />
le contenu sur<br />
plusieurs pages.</i><br />
<br />
<i><font color='red'>{media}</font><br />
pour afficher<br />
le media courant<br />
dans le texte.</i><br />
<br />
<i><font color='red'>{block}</font><br />
pour afficher<br />
le contenu du bloc<br />
dans le texte.</i>");
define("_MD_EDITO_BLOCKTEXT",		"Contenu du bloc");
define("_MD_EDITO_BODY",		"Contenu");
define("_MD_EDITO_IMAGE",	        "Image");
define("_MD_EDITO_SELECT_IMG",	        "Image");
define("_MD_EDITO_UPLOADIMAGE",	        "Charger une image");
define("_MD_EDITO_STATUS",	        "Statuts");
define("_MD_EDITO_BLOCK",		"Afficher le contenu <br />du bloc<br />dans la page");

define("_MD_EDITO_OPTIONS",		"Options");
define("_MD_EDITO_HTML",		" Activer les balises HTML");
define("_MD_EDITO_SMILEY",		" Activer les Smileys ");
define("_MD_EDITO_XCODE",		" Activer codes XOOPS (BBCodes)<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i>Désactiver cette option, désactive aussi les fonctionnalités multilangues éventuelles.</i>");
define("_MD_EDITO_TITLE",		" Afficher le titre");
define("_MD_EDITO_LOGO",		" Afficher le logo");
define("_MD_EDITO_ALLOWCOMMENTS",       " Autoriser les commentaires");

define("_MD_EDITO_SUBMIT",		"Valider");
define("_MD_EDITO_CLEAR",		"Effacer");
define("_MD_EDITO_CANCEL",		"Annuler");             
define("_MD_EDITO_MODIFY",		"Modifier");
define("_MD_EDITO_FILEEXISTS",	        "Le fichier existe déjà");
define("_MD_EDITO_CREATED",	        "Nouvelle page créée avec succès");
define("_MD_EDITO_NOTCREATED",	        "Impossible de créer une nouvelle page");
define("_MD_EDITO_CANTPARENT",	        "Une page mère ne peut se lier à elle-même ou à sa fille !");
define("_MD_EDITO_MODIFIED",	        "Base de données mise à jour avec succès");
define("_MD_EDITO_NOTUPDATED",	        "La base de données n'a pu être mise à jour");
define ("_MD_EDITO_DELETED",	        "Page supprimée avec succès");
define ("_MD_EDITO_DELETETHIS",         "Confirmez-vous la suppression de cette page :");

define("_MD_EDITO_YES",			_YES);
define("_MD_EDITO_NO",			_NO);
define("_MD_EDITO_NO_EDITO",		"Aucune page");

// Barre de Navigation
define("_MD_EDITO_NAV_INDEX",		"Aller au module");
define("_MD_EDITO_NAV_LIST",		"Liste des pages");
define("_MD_EDITO_NAV_CREATE",	        "Créer une page");
define("_MD_EDITO_NAV_PREFERENCES",	"Préférences");
define("_MD_EDITO_NAV_SEE",		"Voir la page");
define("_MD_EDITO_NAV_HELP",		"Aide");
define("_MD_EDITO_NAV_CONFIG",	        "Administration");
define("_MD_EDITO_NAV_PERMS",	        "Permissions");
define("_MD_EDITO_NAV_BLOCKS_GROUPS",	"Blocs et Groupes");
//define("_MD_EDITO_BLOCKS_GROUPS",	"Blocs et Groupes");
define("_MD_EDITO_BLOCKS",	        "Blocs");
define("_MD_EDITO_GROUPS",	        "Groupes");

define("_MD_EDITO_BLOCK_LINK",	"Administration des blocs");
define("_MD_EDITO_BLOCK_EDITO",	"Blocs Edito");
define("_MD_EDITO_BLOCK_MENU",	"Blocs Menu");

// myMedia
define("_MD_EDITO_SELECT_MEDIA",	"Media local<br /><br />
                                         <i><font color='red'>
                                         Fichiers du répertoire :<br />
                                         '".$xoopsModuleConfig['sbmediadir']."'
                                         </font><br />
                                         *Prioritaire sur le média externe.</i>");
define("_MD_EDITO_MEDIA",		"Media");
define("_MD_EDITO_UPLOADMEDIA",	        "Charger un media");

define("_MD_EDITO_MEDIALOCAL",		"Media Local ");
define("_MD_EDITO_MEDIAURL",		"Media externe");

define("_MD_EDITO_MEDIA_SIZE",	"Format d'affichage");

define("_MD_EDITO_SELECT_DEFAULT",	"- aucun -");
define("_MD_EDITO_SELECT_TVSMALL",	"TV Petit");
define("_MD_EDITO_SELECT_TVMEDIUM",	"TV Moyen");
define("_MD_EDITO_SELECT_TVBIG",	"TV Large");
define("_MD_EDITO_SELECT_CUSTOM",	"Personnalisé");
define("_MD_EDITO_SELECT_MVSMALL",	"MOVIE Petit");
define("_MD_EDITO_SELECT_MVMEDIUM",	"MOVIE Moyen");
define("_MD_EDITO_SELECT_MVBIG",		"MOVIE Large");

define("_MD_EDITO_METAOPTIONS",	        "Options Metas");
define("_MD_EDITO_MEDIAOPTIONS",	"Options Medias");
define("_MD_EDITO_IMAGEOPTIONS",	"Options Images");
define("_MD_EDITO_MISCOPTIONS",	        "Options Diverses");

define("_MD_EDITO_HIDE",	        "Masquer");
define("_MD_EDITO_SHOW",	        "Afficher");
define("_MD_EDITO_SHOWHIDE",	        "Afficher/Masquer");
define("_MD_EDITO_HTMLMODE",	        "Mode Html");
define("_MD_EDITO_PHPMODE",	        "Mode Php");
define("_MD_EDITO_WAITING",	        "En attente");

// Utilities
define("_MD_EDITO_PAGE",		"Page");
define("_MD_EDITO_UTILITIES",	        "Utilitaires");
define("_MD_EDITO_WYSIWYG",	        "Editeurs wysiwyg disponibles");
define("_MD_EDITO_UPLOAD",		"Téléverser un media");
define("_MD_EDITO_UPLOAD_ERROR",	"Le téléchargement du média a échoué");
define("_MD_EDITO_MEDIAUPLOADED",	"Media téléchargé avec succès");
define("_MD_EDITO_FILECREATED",	        "Fichier créé avec succès.");
define("_MD_EDITO_UPLOADED",	        "Image téléchargée avec succès.");
define("_MD_EDITO_UPDATED",	        "Image mise à jour avec succès.");
define("_MD_EDITO_CLONE",	        "Cloner le module");
define("_MD_EDITO_CLONED",	        "Module cloné avec succès");
define("_MD_EDITO_MODULEXISTS",	        "Ce module existe déjà");
define("_MD_EDITO_NOTCLONED",	        "Les paramètres du clonage sont incorrectes");
define("_MD_EDITO_CLONE_TROUBLE",	"Le clone a été créé dans le dossier 'cache' à la racine de votre site.<br />Vous devez simplement le déplacer dans le dossier 'modules' avec votre client ftp.
<br />
Et changer les attributs du clone et des sous-dossiers en 644, toujours avec votre client ftp par exemple.<br />
<br />
Vous pourrez ensuite installer votre clone comme n'importe quel module.
");
define("_MD_EDITO_CLONENAME",	        "Nom du clone<br /><i>
                                         <ul>
                                             <li>Pas de chiffres</li>
                                             <li>Pas plus de 12 caractères</li>
                                             <li>Pas de caractères spéciaux</li>
                                             <li>Pas de nom de module déjà existant</li>
                                             <li>Lettre capitale et espacements accéptés</li>
                                         </ul></i>
                                         Exemple : 'Mon Module'. ");
define("_MD_EDITO_EDITORS",		"Editeurs disponibles");

define("_MD_EDITO_DB_DATAS",		"Données SQL");
define("_MD_EDITO_DB_IMPORT",		"Importation dans la base de donnée");
define("_MD_EDITO_DB_EXPORT",		"Exportation de la base de donnée");
define("_MD_EDITO_EXPORT",		"Exporter");
define("_MD_EDITO_INSERT",		"Ajouter");
define("_MD_EDITO_UPDATE",		"Mettre à jour");
define("_MD_EDITO_TYPE",		"Type d'export");
define("_MD_EDITO_SITELIST",		"Liste des sites autorisés<p />
<i>Exemple :<br />
www.frxoops.org|<br />
wolfpackclan.com|<br />
127.0.0.1</i>");

// Anti-leech
define("_MD_EDITO_HTACCESS",		"Protection des médias");
define("_MD_EDITO_COPY",		"Copier le code");
define("_MD_EDITO_HTACCESS_INFO1",		"Si vous ne voulez pas que d'autres sites utilisent vos medias, suivez ces instructions pour créer un fichier .htaccess.
<ol><li>Ouvrez le Notepad (ou editeur équivalent suivant votre OS) et copiez le code suivant :</li></ol>");

define("_MD_EDITO_HTACCESS_INFO2",		"<ol><li>Déposez le fichier .htaccess.txt ainsi créé via FTP en mode ASCII, dans le répertoire de stockage de vos médias.</li>
<li>Après l'avoir téléchargé, cliquez sur le fichier et renommez-le.</li>
<li>Editez le nom du fichier en '.htaccess' (sans l'extension .txt).</li></ol>Voilà, maintenant, les autres sites ne pourront plus utiliser vos médias sur votre propre site.
Bon amusement !");

define("_MD_EDITO_MAKE_UPDATE", "La mise à jour du module n'a pas été effectuée : ");
define("_MD_EDITO_MAKE_UPGRADE", "Une nouvelle version d'Edito est disponible en téléchargement à cette adresse : <br /><br />");

// Help datas
define("_MD_EDITO_CONTENT_HELP","
<ul><b>1) <u>Sujet</u></b>
Indiquez le titre court de la page (Voir aussi meta titre). Ce titre est employé dans les liens de navigation, et par défaut en cas d'absence de meta-title.
</ul>
<ul><b>2) <u>Statuts</u></b>
Il y a 6 statuts possibles pour votre page.
<ul><ol>
    <li><img src='../images/icon/online.gif' align='absmiddle' /> <b>Afficher :</b> Affichage normal de la page dans le module.</li>
    <li><img src='../images/icon/waiting.gif' align='absmiddle' /> <b>En attente :</b> La page est en attente de validation. Elle n'est visible que par les administrateurs.</li>
    <li><img src='../images/icon/hidden.gif' align='absmiddle' /> <b>Cacher :</b> Affichage de la page indépendamment de toute information relative au module.
	La page n'est pas reprise dans les indexes du module, ni dans le bloc de menu.</li>
	<li><img src='../images/icon/offline.gif' align='absmiddle' /> <b>Désactiver :</b> La page est totalement innaccessible.</li>
    <li><img src='../images/icon/html.gif' align='absmiddle' /> <b>Mode HTML :</b> Affiche le contenu de la page uniquement en mode html. 
	N'interprête pas les codes XOOPS et autre retours à la ligne éventuels.</li>
	<li><img src='../images/icon/php.gif' align='absmiddle' /> <b>Mode php :</b> Interprête le contenu de la page comme du code php.</li>
</ol></ul><ul>
<b>3) <u>Contenu du Block</u></b>
Le contenu renseigné dans cette zone de texte, s'affichera prioritairement dans les blocs de contenu du module.
Dans le cas de la page d'index, il s'affichera en mode 'tableau' et 'news'.
Le contenu de cette zone n'est pas interprété en mode 'php'.
Le contenu de cette zone est aussi utilisé pour générer automatiquement les metakeywords.
</ul>
<ul><b>4) <u>Afficher le contenu du bloc dans la page</u></b>
En cochant cette option, le contenu du bloc s'affichera dans la page liée (Voir aussi balises spéciales). 
</ul>
<ul><b>5) <u>Corps du texte</u></b>
Le contenu renseigné dans cette zone de texte est utilisé sur la page principale.
Le contenu de cette zone est aussi utilisé pour générer automatiquement les metakeywords.
En mode php, c'est dans cette zone que doit être indiquée le code php à interpréter. A noter qu'il ne faut pas renseigner les balises <b>&#139;? php</b> et <b>?&#155;</b> habituelles.
</ul>
<img src='../images/icon/tip.gif' align='absleft' /><b>Balises spéciales</b> : les balises suivantes peuvent être utilisées dans le texte :
<ul><ol>
    <li><i><b>[pagebreak]</b></i> : pour afficher le contenu sur plusieurs pages.</li>
    <li><i><b>{media}</b></i> pour afficher le media courant dans le texte. En utilisant cette balise, le media ne s'affichera plus en tête de page.</li>
	<li><i><b>{block}</b></i> pour afficher le contenu du bloc dans le texte, sous forme d'encadré.</li>
    <li><i><b>{block align=\"left\"}</b></i> : le bloc s'affichera à gauche.</li>
	<li><i><b>{block align=\"right\"}</b></i> : le bloc s'affichera à droite.</li>
	<li><i><b>{block align=\"center\"}</b></i> : le bloc s'affichera au centre.</li>
</ol></ul>
");
define("_MD_EDITO_IMAGE_HELP",		
"Pour chaque page créée, il est possible d'y affecter une image représentative.
<ul><b>1) <u>Image</b></u>
L'emplacement de stockage des images est défini dans les Préférences du module (cf. <b>[LOGO] Répertoire des images</b>) et doit impérativement être hébergé sur le serveur du site. La liste des images ainsi disponibles s'affiche dans la liste déroulante. Vous pouvez prévisualiser l'image en la sélectionnant.
</ul>
<ul><b>2) <u>Charger un média</b></u>
Il est possible de téléverser une image directement à partir du disque dur. Veillez à respecter les dimensions et les tailles maximum autorisées, paramétrables dans les Préférences du module.</ul>");
define("_MD_EDITO_MEDIA_HELP",		"Pour chaque page, il est possible d'y affecter un média. Les media supportés sont les suivants : images, son, vidéo et flash.

<ul><b>1) <u>Média local</b></u>
L'emplacement de stockage des images est défini dans les Préférences du module (cf. <b>[LOGO] Répertoire des images</b>) et doit impérativement être hébergé sur le serveur du site. La liste des medias ainsi disponibles s'affiche dans la liste déroulante.
Les medias locaux sont prioriataires sur les medias externes.
</ul>
<ul><b>2) <u>Charger un média</b></u>
Il est possible de téléverser un media directement à partir du disque dur. Veillez à respecter les dimensions et les tailles maximum autorisées, paramétrables dans les paramètres du module.
</ul>
<ul><b>3) <u>Media externe</b></u>
Il est possible d'indiquer l'adresse (url) d'un media hébergé sur un autre serveur. Il est aussi possible d'utiliser des <b>[MEDIA] Medias personnalisés</b> (Voir Préférences du module) afin de forcer la lecture des fichiers par Windows Media Player.
</ul>
<ul><b>4) <u>Formats d'affichage</b></u>
Le format d'affichage du média est défini soit par défaut, soit en sélectionnant l'un des modes proposés. Il est possible d'utiliser un mode d'affichage <i>personnalisé</i>, défini dans les Préférences du module. Voir <b>[MEDIA] Taille personnalisée</b>.</ul>");
/* define("_MD_EDITO_META_HELP",		"Pour chaque page crée, il est possible de personnaliser les metas à afficher :

<ul><li><b>Meta Title :</b> Titre des pages. Ce champ sera utilisé comme titre long et affiché en priorité dans les pages du module, ainsi que les balises 'alt' et 'title' utilisées dans les liens.</li>
<li><b>Meta Description :</b> Description de la page pour les moteurs de recherche.</li>
<li><b>Meta Keywords :</b> Mots clés de la page.</li></ul>
<b><u>3 modes différents</u></b>
Dans les préférences du site (cf <b>[META] Meta Generateur</b>), il est possible d'activer l'un des trois modes suivants, afin de définir le mode de création des meta balises des pages du module.
<ul><b>1) Manuel :</b> Ne prend en considération que ce qui est strictement indiqué dans la page éditée. Si je ne mets rien, rien n'apparaît dans les metas.
</ul>
<ul><b>2) Semi-auto :</b> Prend en considération les données dans l'ordre suivante :
<ol><li>a. Ce qui est indiqué dans la page.</li>
<li>b. Ce qui est indiqué dans le module.</li>
<li>c. Ce qui est indiqué dans le core.</li></ol></ul>
<ul><b>3) Auto :</b> A défaut de données manuelles, le module va générer les metas automatiquement en fonction du contenu de la page. Prend en considération les données dans l'ordre suivant :
<ol><li>Les metas mots-clé de la page + les metas mots-clés issus du contenu et générés automatiquement pas le script metagen.</li>
<li>Les metas mots-clés issus du contenu et générés automatiquement pas le script metagen.</li>
<li>Ce qui est indiqué dans les préférences du module.</li>
<li>Ce qui est indiqué dans le core.</li></ol></ul>
<u><b>Priorité des informations</b></u>

<ul><b>1) Semi-auto et auto</b> - les meta-titles sont générés dans l'ordre de priorité suivant :
<ol><li>Le meta-title de la page.</li>
<li>Le titre de la page.</li>
<li>Le titre du site (issu du core).</li></ol></ul>
<ul><b>2) Auto</b> - les meta-descriptions sont générées dans l'ordre de priorité suivant :
<ol><li>La meta-description de la page.</li>
<li>Les 255 première lettres du contenu de la page (bloc et contenu confondu).</li>
<li>Le meta-titre de la page.</li>
<li>Le titre de la page.</li>
<li>La meta-description issue du Core.</li></ol></ul> ");
*/
define("_MD_EDITO_META_HELP",		"Pour chaque page créée, il est possible de personnaliser les metas à afficher, en fonction du mode de gestion des metas défini dans les préférences du module.
<table cellspacing='0' cellpadding='1' border='1' style='width:100%; margin:10px;'> <tr>
  <td style='width:15%;border:0px;'> </th>
  <th style='width:30%;text-align:center;'><u>Meta Title</u><br />
      Titre des pages. Ce champ sera utilisé comme titre long et affiché en priorité dans les pages du module, ainsi que les balises 'alt' et 'title' utilisées dans les liens.</th>
  <th style='width:30%;text-align:center;'><u>Meta Description</u><br />Description de la page pour les moteurs de recherche.</th>
  <th style='width:30%;text-align:center;'><u>Meta Keywords</u><br />Mots clés de la page.</th>
  </tr><tr><th><div align='center'><strong><u>Manuel</u></strong></div>
Ne prend en considération que les données strictement indiquées dans la page éditée.</th>
<td colspan='3'><ul><li> Ce qui est indiqué dans la page uniquement.</li>
</ul>
</td>
</tr>
<tr>  <th><div align='center'><strong><u>Semi-auto</u></strong>
</div>
Prend en considération les données indiquée selon les 3 niveaux (page, module, core).</th>
  <td> <ul><li>Meta-titre de la page.</li>
<li>Titre de la page.</li>
<li>Core (préf. du site).</li>
</ul></td>
  <td colspan='2'> <ul><li>Page (Meta-description ou Meta-keywords).</li>
<li>Module (préf. du module.)</li>
<li>Core (préf. du site).</li>
</ul>
 </td>
 </tr>
 <tr>  <th><div align='center'> <strong><u>Auto</u></strong>
</div>
A défaut de données, le module va générer les metas automatiquement en fonction du contenu de la page.</th>
<td> <ul><li>Meta-titre de la page.</li>
<li>Titre de la page.</li>
</ul>
</td>
  <td> <ul><li>La meta-description de la page.</li>
<li>Les 255 premières lettres du contenu de la page (bloc et contenu confondu).</li>
<li>Meta-titre ou titre de la page<br />&nbsp;&nbsp;+ description du module (préf. du module).</li>
<li>Core (préf. du site).</li>
</ul>
</td>
  <td> <ul><li>Les metas mots-clé de la page<br />&nbsp;&nbsp;+ les metas mots-clés issus du contenu, générés pas le script metagen<br />&nbsp;&nbsp;+ les metas mots-clés du module (préf. du module).</li>
<li>Les metas mots-clés issus du contenu et générés automatiquement pas le script metagen<br />&nbsp;&nbsp;+ Mots clés du module (préf. du module).</li>
<li>Titre ou meta-titre de la page<br />&nbsp;&nbsp;+ Mots clés du module (préf. du module).</li>
</ul>
</td>
 </tr>
 </table>
 <u><b>Script Metagen</b></u><br />
 Le script metagen fonctionne de la façon suivante :
 <ol><li>
 Récupération de l'ensemble du contenu de la page
 (titre, meta-titre, contenu du bloc et coprs du texte) 
 et extraction d'une liste de mots clés sur base
 de leur taille (min et max de lettres) 
 et leur occurences (min et max d'occurence), en supprimant accents, chiffres et codes.</li>
 <li>Extraction de 90 mots minuscules à afficher dans les meta-balises.</li>
 <li>S'il y a moins de 45 mots, duplication des mots créés avec ajout d'une majuscule. </li>
 <li>S'il y a moins de 30 mots, nouvelle duplication en majuscule.</li></ol>
 Le script ne tient pas compte des formes pluriel ou singulier, ou du genre des mots.<p>
 Les meta données sont enregistrées lors de la création ou de la mise à jour de la page.
 Si le mode de gestion des meta est modifiées dans les préférences du module,
 il faut mettre à jour les pages précedemment créées pour prendre en compte les nouvelles modifications. 
  ");
define("_MD_EDITO_MISC_HELP",		"Permet d'affiner les options concernant la page en cours. Ces options peuvent être définies par défaut dans les préférences du module (voir tags <b>[OPTION]</b>.
<ul>
<b>1) <u>Groupes</u></b>

Défini les groupes ayant accès ou non à la page en cours. Ces autorisations d'accès s'appliquent aussi bien aux pages de contenu, qu'a l'index du module ou les blocs de contenu ou de menu.</ul>
<ul><b>2) <u>Lectures</u></b>

Défini le nombre de fois que la page a été vue. Dans les préférences du module, il est possible d'indiquer si l'on souhaite que les pages vues par l'administrateur soient vue ou non (cf. <b>[PAGE] Compteur de lectures Admin</b>).</ul>
<ul><b>3) <u>Options</u></b>

Définit diverses options applicables à la page.
<ol>
<li><b>Afficher le titre</b> : afficher ou non le titre sur la page.</li>
<li><b>Afficher le logo</b> : afficher ou non le logo sur la page.</li>
<li><b>Autoriser les commentaires</b> : autoriser ou non les commentaires sur la page. Dépend des <b>Règles des commentaires</b> dans les préférences du module.</li>
<li><b>Activer les balises HTML</b> : active ou non le html sur la page.</li>
<li><b>Activer les Smileys </b> : active ou non les smileys sur la page.</li>
<li><b>Activer codes XOOPS (BBCodes)</b> : active ou non les BBcodes sur la page. Désactiver cette option, désactive aussi les fonctionnalités multilangues éventuelles.</li></ol></ul>");
?>