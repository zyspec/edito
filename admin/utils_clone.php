<?php
/**
* Module: edito
* Licence : GPL
* Authors :
*           - solo (http://www.wolfpackclan.com)
*/

include_once( '../../../mainfile.php');
include_once( '../../../include/cp_header.php');

$op = '';
$type_clonage = '';

if ( isset( $_GET['op'] ) ) $op = $_GET['op'];
if ( isset( $_POST['op'] ) ) $op = $_POST['op'];
if ( isset( $_GET['type_clonage'] ) ) $type_clonage = $_GET['type_clonage'];
if ( isset( $_POST['type_clonage'] ) ) $type_clonage = $_POST['type_clonage'];

function utilities()
	{
		global $xoopsConfig, $modify, $xoopsModuleConfig, $xoopsModule, $xoopsDB, $XOOPS_URL, $type_clonage;

		$sform = new XoopsThemeForm( _MD_EDITO_CLONE, "op", xoops_getenv( 'PHP_SELF' ) );
		$sform -> setExtra( 'enctype="multipart/form-data"' );
		if ($type_clonage == 'cache')
			{
			$help_display = '<tr><td colspan="2" style="background-color:AntiqueWhite;">'._MD_EDITO_CLONE_TROUBLE.'</td></tr>';
			}
			else {$help_display = '';}
		$sform -> addElement( $help_display );
		$sform -> addElement( new XoopsFormText( _MD_EDITO_CLONENAME, 'clone', 12, 12, '' ), TRUE );
		$button_tray = new XoopsFormElementTray( '', '' );
		$hidden = new XoopsFormHidden( 'op', 'clonemodule' );
		$button_tray -> addElement( $hidden );
		$butt_create = new XoopsFormButton( '', '', _MD_EDITO_SUBMIT, 'submit' );
		$butt_create->setExtra('onclick="this.form.elements.op.value=\'clonemodule\'"');
		$button_tray->addElement( $butt_create );
		$butt_clear = new XoopsFormButton( '', '', _MD_EDITO_CLEAR, 'reset' );
		$button_tray->addElement( $butt_clear );
		$sform -> addElement( $button_tray );
		$sform -> display();
		unset( $hidden );
	 }//end function utilities


/* create a clone in modules folder */
    function cloneFileFolder($path)
    {
      global $patKeys;
      global $patValues;
      global $safeKeys;
      global $safeValues;
      $newPath = str_replace($patKeys[0], $patValues[0], $path); //full new file path
      chmod(XOOPS_ROOT_PATH.'/modules', 0777);
      if (is_dir($path))
      {
// Create new dir
        mkdir($newPath);

// check all files in dir, and process it
        if ($handle = opendir($path))
        {
          while ($file = readdir($handle))
          {
            if ($file != '.' && $file != '..')
            {
              cloneFileFolder("$path/$file");
            }
          }
          closedir($handle);
        }
      }
      else
      {
        if(preg_match('/(.jpg|.gif|.png|.zip)$/i', $path))
        {
          copy($path, $newPath);
        }
        else
        {
// file, read it
          $content = file_get_contents($path);
          $content = str_replace($safeKeys, $safeValues, $content); // Save 'Editor' values
          $content = str_replace($patKeys, $patValues, $content);   // Rename Clone values
          $content = str_replace($safeValues, $safeKeys, $content);  // Restore 'Editor' values
          file_put_contents($newPath, $content);
        }
      }
              chmod(XOOPS_ROOT_PATH.'/modules', 0444);
    }	 

// Check wether the cloning function is available
// work around for PHP < 5.0.x
    if(!function_exists('file_put_contents'))
		{
		function file_put_contents($filename, $data, $file_append = false)
			{
			$fp = fopen($filename, (!$file_append ? 'w+' : 'a+'));
			if(!$fp)
					{
					trigger_error('file_put_contents cannot write in file.', E_USER_ERROR);
					return;
					}
			fputs($fp, $data);
			fclose($fp);
			}//end function file_put_contents
		}//end if

/* -- Available operations -- */
switch ( $op )
{
  case "clonemodule":
  
    if ( isset( $_GET['clone'] ) ) { $clone = $_GET['clone']; }  else { $clone =''; }
    if ( isset( $_POST['clone'] ) ) { $clone = $_POST['clone']; }
 
// Define Cloning parameters : check clone name
      $clone = trim($clone);
      $clone_orig = $clone;
      if ( function_exists('mb_convert_encoding') ) { $clone = mb_convert_encoding($clone, "", "auto"); }
//    $clone = eregi_replace("[[:digit:]]","", $clone);
      $clone = str_replace('-', 'xyz', $clone);
      $clone = eregi_replace("[[:punct:]]","", $clone);
      $clone = str_replace('xyz', '-', $clone);
      $clone = ereg_replace(' ', '_', $clone);

// Check wether the cloned module exists or not
    if ( $clone && is_dir(XOOPS_ROOT_PATH.'/modules/'.$clone))
		{
        redirect_header( "utils_clone.php", 2, _MD_EDITO_MODULEXISTS );
        }

// Define clone naming parameteres
    $module = $xoopsModule->dirname();
 
    if ( $clone )
		{
		$CLONE  = strtoupper(eregi_replace("-","_", $clone));
		$clone  = strtolower(eregi_replace("-","_", $clone));
		$Clone  = ucfirst($clone_orig);
		$MODULE = strtoupper($module);
		$Module = ucfirst($module);

		$patterns = array(
        // first one must be module directory name
        $module  => $clone,
        $MODULE  => $CLONE,
        $Module => $Clone,
        );
		$patKeys = array_keys($patterns);
	    $patValues = array_values($patterns);

	 // Clone everything but 'Editor' - usefull for edito only
     $safepat = array(
      // Prevent unwilling change for wysiwyg functions
      'editor'  => 'squizzz',
      'EDITOR'  => 'SQUIZZZ',
      'Editor'  => 'Squizzz',
     );

    $safeKeys = array_keys($safepat);
    $safeValues = array_values($safepat);

function copy_dir ($dir2copy,$dir_paste) {

  global $patKeys;
  global $patValues;
  global $safeKeys;
  global $safeValues;
  global $clone;
  global $module;

	// On vérifie si $dir2copy est un dossier
	if (is_dir($dir2copy)) {
   
			// Si oui, on l'ouvre
			if ($dh = opendir($dir2copy)) {     

					// On liste les dossiers et fichiers de $dir2copy
					while (($file = readdir($dh)) !== false) {
				   
							// Si le dossier dans lequel on veut coller n'existe pas, on le créé
							if (!is_dir($dir_paste))
								{
								$oldumask = umask(0000);
								mkdir ($dir_paste);
								umask($oldumask);
								}
				   
							// S'il s'agit d'un dossier, on relance la fonction récursive
							if(is_dir($dir2copy.$file) && $file != '..'  && $file != '.')
								copy_dir ( $dir2copy.$file.'/' , $dir_paste.$file.'/' );     
							// S'il sagit d'un fichier, on le copie simplement
							elseif($file != '..'  && $file != '.')
						{
								if (eregi($module,$file)) //je cherche le mot 'edito' dans le nom du fichier
									{
									$filedest = eregi_replace($module, $clone, $file); //si je trouve je remplace par le nom du clone
									copy ( $dir2copy.$file , $dir_paste.$filedest );//et je copie le fichier avec le bon nom
									$file = $filedest;
									}
									else copy ( $dir2copy.$file , $dir_paste.$file );

								if(!preg_match('/(.jpg|.gif|.png|.zip)$/i', $dir_paste.$file))
								{
							  $content = file_get_contents($dir_paste.$file);
							  $content = str_replace($safeKeys, $safeValues, $content); // Save 'Editor' values
							  $content = str_replace($patKeys, $patValues, $content);   // Rename Clone values
							  $content = str_replace($safeValues, $safeKeys, $content);  // Restore 'Editor' values
							  file_put_contents($dir_paste.$file, $content);
								}
						}
					}
			// On ferme $dir2copy
			closedir($dh);
			}
	}       
}

$dir2copy = '../../'.$module.'/';
$dir_paste = '../../../cache/'.$clone.'/';

// Create clone

$module_dir = XOOPS_ROOT_PATH.'/modules';
$fileperm = fileperms($module_dir);
if ( @chmod($module_dir, 0777) )
   {
	cloneFileFolder('../../'.$module);
	chmod(XOOPS_ROOT_PATH.'/modules', $fileperm);
	redirect_header( "../../system/admin.php?fct=modulesadmin&op=install&module=".$clone, 1, _MD_EDITO_CLONED );
	exit();
   }

	copy_dir ($dir2copy,$dir_paste);
	redirect_header( "utils_clone.php?type_clonage=cache", 1, _MD_EDITO_CLONED );
	exit();
    }//end "if $clone"
	else {
         redirect_header( "utils_clone.php", 1, _MD_EDITO_NOTCLONED );
         exit();
         }
    break;

  case "utilities":
  	default:
        include_once( "admin_header.php" );
        edito_adminmenu(2, _MD_EDITO_UTILITIES.'<br />'._MD_EDITO_CLONE);
        edito_statmenu(1, '');
        utilities();
        include_once( 'admin_footer.php' );
    break;

}

?>