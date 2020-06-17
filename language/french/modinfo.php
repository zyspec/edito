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
define("_MI_EDITO_DESC",                "Publier du contenu en page principale ou dans un bloc");

// Menu admin
define("_MI_EDITO_GOTO_INDEX",	        "Aller au module");
define("_MI_EDITO_UTILITIES",	        "Utilitaires");
define("_MI_EDITO_HELP",		"Aide");


// Preferences
// Logos
define("_MI_EDITO_MAXFILESIZE",		"[LOGO] Taille maximum d'upload");
define("_MI_EDITO_MAXFILESIZEDSC",	        "Paramètre la taille maximum des fichiers lors de l'upload");
define("_MI_EDITO_IMGSIZE",		"[LOGO] Taille max. des images ");
define("_MI_EDITO_IMGSIZEDSC",			"Dimensions maximums des images à uploader<br />
                                                 (<b>largeur|hauteur|poids</b>).");
define("_MI_EDITO_LOGOWIDTH",		"[LOGO] Affichage des images");
define("_MI_EDITO_LOGOWIDTHDSC",		"Taille standard des images à afficher dans l'index (<b>largeur|hauteur</b>).");
define("_MI_EDITO_LOGO_ALIGN",		"[LOGO] Alignement du logo");
define("_MI_EDITO_LOGO_ALIGNDSC",		"Sélectionnez l'alignement du logo sur chaque page.");
define("_MI_EDITO_LOGO_ALIGN_LEFT",		              "Gauche");
define("_MI_EDITO_LOGO_ALIGN_CENTER",	                      "Centre");
define("_MI_EDITO_LOGO_ALIGN_RIGHT",	                      "Droite");
define("_MI_EDITO_UPLOADDIR",		"[LOGO] Répertoire des images");
define("_MI_EDITO_UPLOADDIRDSC",		"Indiquer le répertoire de stockage des images (Sans \"/\")");


// Index
define("_MI_EDITO_PERPAGE",		"[INDEX] Nombre maximum d'articles par page:");
define("_MI_EDITO_PERPAGEDSC",			"Nombre maximum d'articles par page à afficher dans l'administration des articles et l'index principal.");
define("_MI_EDITO_COLUMNS",		"[INDEX] Affichage de l'index :");
define("_MI_EDITO_COLUMNSDSC",			"Nombre de colonnes à afficher dans l'index");
define("_MI_EDITO_TEXTINDEX",		"[INDEX] Intro");
define("_MI_EDITO_TEXTINDEXDSC",		"Texte d'introduction de l'index");
define("_MI_EDITO_WELCOME",			       "Bienvenue dans Edito, le module de contenu multimedia et multifonction");
define("_MI_EDITO_ORD",		"[INDEX] Classement");
define("_MI_EDITO_ORDDSC",			"Classement standard des pages");
define("_MI_EDITO_ORD_SUBJ_ASC",	               "Titre croissant");
define("_MI_EDITO_ORD_SUBJ_DESC",                 "Titre décroissant");
define("_MI_EDITO_ORD_DATE_ASC",		       "Le plus vieux");
define("_MI_EDITO_ORD_DATE_DESC",		       "Le plus récent");
define("_MI_EDITO_ORD_HIT",			       "Le plus vu");
define("_MI_EDITO_ORD_READ_DESC",		       "Le plus lu");
define("_MI_EDITO_TAGS",		"[INDEX] Afficher les icônes");
define("_MI_EDITO_TAGSDSC",			"Afficher les icônes nouveau et populaire dans la page d'index.");
define("_MI_EDITO_TAGS_NEW",		"[INDEX] Icône nouveau");
define("_MI_EDITO_TAGS_NEWDSC",			"Afficher l'icône nouveau pendant x jours.");
define("_MI_EDITO_TAGS_POP",		"[INDEX] Icône populaire");
define("_MI_EDITO_TAGS_POPDSC",			"Afficher l'icône populaire à partir de x lectures.");
define("_MI_EDITO_INDEX_LOGO",		"[INDEX] Bannière de l'index ou des pages");
define("_MI_EDITO_INDEX_LOGODSC",		"Affiche un logo sur les pages du module.
Laisser vide pour ne rien afficher.");
define("_MI_EDITO_INDEX_CONTENT",	"[INDEX] Page de redirection");
define("_MI_EDITO_INDEX_CONTENTDSC",            "Afficher une page alternative à la place de l'index du module. <br />
- Indiquer l'ID d'une page du module ou une url http/https. <br />
- Laisser vide pour l'index du module.");

define("_MI_EDITO_FOOTERTEXT",	         "[INDEX] Pied de page");
define("_MI_EDITO_FOOTERTEXTDSC",	        "Contenu du pied de page par défaut du module");
define("_MI_EDITO_FOOTER",						"<div style='display: none;'>
Module <b>Edîto</b> développé par la WolFactory (http://wolfactory.wolfpackclan.com/),
la division Xoops du Wolf Pack Clan (http://www.wolfpackclan.com/).
</div>");

define("_MI_EDITO_INDEX_DISP",	"[INDEX] Mode");
define("_MI_EDITO_INDEX_DISPDSC",		"Mode d'affichage de l'index");
define("_MI_EDITO_INDEX_DISP_TABLE",		      "Tableau");
define("_MI_EDITO_INDEX_DISP_IMAGE",		      "Images");
define("_MI_EDITO_INDEX_DISP_BLOG",		      "Blog");
define("_MI_EDITO_INDEX_DISP_NEWS",		      "News");

// Préférences pages
define("_MI_EDITO_SETTINGS",		"Préférences");
define("_MI_EDITO_ADMINHITS",	"[PAGE] Compteur de lectures Admin :");
define("_MI_EDITO_ADMINHITSDSC",		"Autoriser les hits de l'admin pour le compteur de stats ?");
define("_MI_EDITO_NAV_LINKS",		"[PAGE] Liens de navigation");
define("_MI_EDITO_NAV_LINKSDSC",		"Type d'affichage des liens vers les autres pages, pour chaque page.");
define("_MI_EDITO_NAV_LINKS_NONE",			"Aucune");
define("_MI_EDITO_NAV_LINKS_BLOCK",			"Bloc");
define("_MI_EDITO_NAV_LINKS_LIST",			"Liste");
define("_MI_EDITO_NAV_LINKS_PATH",			"Chemin");

// Edition options
define("_MI_EDITO_EDITORS",		"Editeurs disponibles");
define("_MI_EDITO_WYSIWYG",		"[ADMIN] Utiliser l'Editeur Wysiwyg ");
define("_MI_EDITO_WYSIWYGDSC",			"Utiliser l'editeur Wysiwyg pour créer ou éditer une page.");
define("_MI_EDITO_FORM_DHTML","DHTML");
define("_MI_EDITO_FORM_COMPACT","Compact");
define("_MI_EDITO_FORM_SPAW","Spaw Editor");
define("_MI_EDITO_FORM_HTMLAREA","HtmlArea Editor");
define("_MI_EDITO_FORM_FCK","FCK Editor");
define("_MI_EDITO_FORM_KOIVI","Koivi Editor");
define("_MI_EDITO_FORM_INBETWEEN","Inbetween Editor");
define("_MI_EDITO_FORM_TINYEDITOR","TinyEditor");


// Admin options
define("_MI_EDITO_OPT_TITLE",	"[OPTION] Afficher titre");
define("_MI_EDITO_OPT_TITLEDSC",		"Créer une nouvelle page en affichant le titre.");
define("_MI_EDITO_OPT_LOGO",		"[OPTION] Afficher logos");
define("_MI_EDITO_OPT_LOGODSC",		"Créer une nouvelle page en affichant le logo dans l'index.");
define("_MI_EDITO_OPT_BLOCK",	"[OPTION] Afficher le bloc");
define("_MI_EDITO_OPT_BLOCKDSC",		"Créer une nouvelle page en affichant le contenu du blocs dans la page.");
define("_MI_EDITO_OPT_GRPS",	"[OPTION] Accès aux groupes");
define("_MI_EDITO_OPT_GRPSDSC",	"Autorisation par défaut des pages en fonction des groupes d'accès.");
define("_MI_EDITO_SUB_GRPS",	"[INDEX] Soumission de pages");
define("_MI_EDITO_SUB_GRPSDSC",	"Groupes d'accès autorisés à soumettre de nouvelle pages.");
define("_MI_EDITO_OPT_COMMENT",	"[OPTION] Commentaires autorisés");

define("_MI_EDITO_DEFAULTEXT",		"[OPTION] Texte par défaut");
define("_MI_EDITO_DEFAULTEXTDSC",		"Texte par défaut pour chaque nouvelle page.<br /><br />
<i><b>{lorem}</b> : Génère du texte Lorem Ipsum</i>");
define("_MI_EDITO_DEFAULTEXTEXP",			"Bienvenue dans Edito.

Tapez ici votre texte à afficher dans votre page.

Pour supprimer ou modifier ce texte par défaut, rendez-vous dans les préférences du module.");

// Options Meta
define("_MI_EDITO_META_KEYW",	"[META] Mots clés du module");
define("_MI_EDITO_META_KEYWDSC",		"Le module génère automatiquement les mots clés à partir des titres de vos page. Cependant, vous pouvez en ajouter ici même.");

define("_MI_EDITO_META_DESC",	"[META] Meta Description du module");
define("_MI_EDITO_META_DESCDSC","Vous pouvez personnaliser les metas descriptions des pages du module.
Si cette boite des texte est vide, la meta description par défaut de votre site prévaudra.");

define("_MI_EDITO_META_MANAGER",				"[META] Meta Generateur");
define("_MI_EDITO_META_MANAGERDSC",				"Gestion des Meta pour chaque page.<br />
- Auto : générés automatiquement par le script MetaGen.<br />
- Semi-auto : sans valeurs entrées manuellement, automatiquement généré par le script MetaGen.<br />
- Manuel : seuls les entrées manuelles sont considérées.");
define("_MI_EDITO_META_AUTO",				"Auto");
define("_MI_EDITO_META_SEMI",				"Semi-auto");
define("_MI_EDITO_META_MANUAL",	        		"Manuel");


// Blocs
define("_MI_EDITO_BLOCNAME_05",				"Menu 1");
define("_MI_EDITO_BLOCNAME_06",				"Menu 2");
define("_MI_EDITO_BLOCNAME_01",				"Page 1");
define("_MI_EDITO_BLOCNAME_02",				"Aléatoire");
define("_MI_EDITO_BLOCNAME_03",				"Dernier");
define("_MI_EDITO_BLOCNAME_04",				"Populaire");

/*
define("_MI_EDITO_TPL01_DESC","Afficher la liste des pages");
define("_MI_EDITO_TPL02_DESC","Afficher le contenu pour une page");
define("_MI_EDITO_BLOC01_DESC","Voir une page dans un bloc");
define("_MI_EDITO_BLOC02_DESC","Voir une page dans un bloc");
define("_MI_EDITO_BLOC03_DESC","Voir une page dans un bloc");
define("_MI_EDITO_BLOC04_DESC","Voir une page dans un bloc");
define("_MI_EDITO_BLOC05_DESC","Afficher la liste des pages en ligne dans un bloc");
define("_MI_EDITO_BLOC06_DESC","Afficher une page au hasard dans un block");
*/


// Edito 2.4
// Navigation admin
define("_MI_EDITO_INDEX",	        "Index");
define("_MI_EDITO_LIST",	        "Liste de pages");
define("_MI_EDITO_CREATE",	        "Créer une page");
define("_MI_EDITO_SEE",	        	"Voir la page");
define("_MI_EDITO_BLOCKS_GRPS",	"Blocks/Groups permissions");
define("_MI_EDITO_MIMETYPES",		"Types mime");
define("_MI_EDITO_SUBMIT",	        "Soumettre une nouvelle page");

// Edito 3.0
// Option Media
define("_MI_EDITO_MEDIADIR",	         	"[MEDIA] Dossier de base des médias");
define("_MI_EDITO_MEDIADIRDSC",	         	"Dossier qui stocke les médias. (Sans \"/\")");

define("_MI_EDITO_MEDIA_DISP",		"[MEDIA] Affichage des Medias");
define("_MI_EDITO_MEDIA_DISPDSC",		         "Mode d'affichage des médias.");
define("_MI_EDITO_MEDIA_POPUP",	        		"Popup");
define("_MI_EDITO_MEDIA_PAGE",	        		"Page");
define("_MI_EDITO_MEDIA_BOTH",	        		"Page & Popup");

define("_MI_EDITO_REPEAT",	        	"[MEDIA] Jouer en boucle");
define("_MI_EDITO_REPEATDSC",	        	"Jouer les medias en boucle");
define("_MI_EDITO_REWRITING",	        	"[LIENS] Mode Rewriting");
define("_MI_EDITO_REWRITINGDSC",	        	"Générer des liens en mode rewriting et contenant des mots clés.<br />
                                                         Fonctionne uniquement sur un serveur web acceptant l'url rewriting.");
define("_MI_EDITO_URW_NONE",			"Aucun");
define("_MI_EDITO_URW_ALL",			"Tous");
define("_MI_EDITO_URW_MIN_3",			"3 lettres minimum");
define("_MI_EDITO_URW_MIN_5",			"5 lettres minimum");


define("_MI_EDITO_DWNL",                "[MEDIA] Téléchargeable");
define("_MI_EDITO_DWNLDSC",                      "Autoriser le téléchargement des médias.");

define("_MI_EDITO_MEDIA_SIZE",	                "[MEDIA] Taille du Media");
define("_MI_EDITO_MEDIA_SIZEDSC",			"Format d'affichage");
define("_MI_EDITO_SIZE_DEFAULT",			        "- none -");
define("_MI_EDITO_SIZE_TVSMALL",				"TV Petit");
define("_MI_EDITO_SIZE_TVMEDIUM",				"TV Moyen");
define("_MI_EDITO_SIZE_TVBIG",	        		        "TV Large");
define("_MI_EDITO_SIZE_MVSMALL",				"Cinescope Petit");
define("_MI_EDITO_SIZE_MVMEDIUM",				"Cinescope Moyen");
define("_MI_EDITO_SIZE_MVBIG",	        		        "Cinescope Large");
define("_MI_EDITO_CUSTOM_MEDIA",			"[MEDIA] Medias personnalisés");
define("_MI_EDITO_CUSTOM_MEDIADSC",	        		"Force la lecture des fichiers par Windows Media Player.<br />
                                                                 Liste des extensions séparées par |");
define("_MI_EDITO_CUSTOM",			"[MEDIA] Taille personnalisée");
define("_MI_EDITO_SIZE_CUSTOM",	        		"Personnalisé");

define("_MI_EDITO_UPDATE_MODULE" , "Mise à jour du module");

// Utilities
define("_MI_EDITO_CLONE",		"Cloner le module");
define("_MI_EDITO_UPLOAD",		"Téléverser des médias");
define("_MI_EDITO_IMPORT",		"Importer SQL");
define("_MI_EDITO_EXPORT",		"Exporter SQL");
define("_MI_EDITO_HTACCESS",		"Protéger les Médias");
?>