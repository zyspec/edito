<?php
#################################################################################################################
#                                                                                                               #
#  Preferences admin manager for Xoops 2.0.x	                                                                #
#  						                                                                #
#  © 2007, Solo ( wolfactory.wolfpackclan.com )                                                                 #
#  Special thanks to Hervé and DuGris for their suggestions     	                                        #
#  Licence : GPL 	         		                                                                #
#                                                                                                               #
#################################################################################################################

#################################################################################################################
#                                                                                                               #
#  How to use this script in your module? 4 steps.                                                              #
#                                                                                                               #
#  1) Put the current page 'settings.php' in your admin directory.                                              #
#                                                                                                               #
#  2) Edit your 'xoops_version.php' and rename all your preferences variable using category tags as following   #
#                                                                                                               #
#    [category-name]_[preference-variable]                                                                      #
#                                                                                                               #
#    Exemple :                                                                                                  #
#            index_banner                                                                                       #
#            index_texte_index                                                                                  #
#            meta_value1                                                                                        #
#            meta_value2                                                                                        #
#                                                                                                               #
#  3) Edit your language/english/modinfo.php file and enter the new language define as following                #
#                                                                                                               #
#    _MI_[YOUR_MODULE_NAME]_[SETTINGS_VARIABLE*]                                                                #
#    _MI_[YOUR_MODULE_NAME]_[SETTINGS_VARIABLE*]_DSC  // As a category description. Optionnal.                  #
#                                                                                                               #
#    * Note that the setting variable must appear without the cat tag.                                          #
#                                                                                                               #
#    Exemple :                                                                                                  #
#            _MI_EDITO_BANNER                                                                                   #
#            _MI_EDITO_TEXTE_INDEX                                                                              #
#            _MI_EDITO_VALUE1                                                                                   #
#            _MI_EDITO_VALUE2                                                                                   #
#                                                                                                               #
#  4) Customise the tabs display.                                                                               #
#                                                                                                               #
#   See belows...                                                                                               #
#                                                                                                               #
# To remove this help note and it's tab, edit the setting.php file and set 'display_help' value to 0.           #
#                                                                                                               #
################################################################################################################

include_once ("admin_header.php");

//////////////////////////////////////////////////////////////////////////////////////////////////////
// Sort settings variables tabs in alphabetical order/////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////
// Display help in file //////////////////////////////////////////////////////////////////////////////

   $display_help      = 1;        // Set to 0 to hide the help menu and instructions.
   $def_menu          = 'select'; // Set 'tab' or 'select'.
   $def_sub           = '';       // Default sub menu.
   $menu_select_max   = 10;    // How many menus before switching to the 'select' mode
   $menu_select_multi = 20;    // How many menus before switching to the 'multi-select' mode.

//////////////////////////////////////////////////////////////////////////////////////////////////////
// If not, respect the xoops_version.php variable order///////////////////////////////////////////////

   $alpha_sort=0;

//////////////////////////////////////////////////////////////////////////////////////////////////////
// Custom Tab colors//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////
// Set tabs colors from left to right.////////////////////////////////////////////////////////////////

   $colors = array( 'Gold|PaleGoldenRod',
                    'GoldenRod|Gold',
                    'GoldenRod|Gold' );

//  If none is set, default color is set. ////////////////////////////////////////////////////////////

    $default_color = 'LightGrey|WhiteSmoke';

// For more informations about color names, see http://www.w3schools.com/html/html_colornames.asp/////
//////////////////////////////////////////////////////////////////////////////////////////////////////


   $help = "
   <h2 align='center'>How to customise this script in your module in 4 steps.</h1>
<ul>
  <li>Put the current page 'settings.php' in your admin directory.</li>
                                                                                                               
  <li>Edit your 'xoops_version.php' and rename all your preferences variables using category tags as following
                                                                                                               
    [category-name]_[preference-variable]                                                                      
                                                                                                               
    Exemple :<ol>
            <li>index_banner</li>            <li>index_texte_index </li>            <li>meta_value1</li>            <li>meta_value2</li>
  </li></ol>
  <li>Edit your language/english/modinfo.php file and enter the new language define as following
    <ol>
    <li>_MI_[YOUR_MODULE_NAME]_[SETTINGS_VARIABLE*]</li>    <li>_MI_[YOUR_MODULE_NAME]_[SETTINGS_VARIABLE*]_DSC  // As a category description. Optionnal.</li>
    </ol>
    * Note that the setting variable must appear without the cat tag.
    ** If you don't create your custom define, a default title will appear with a red <font color='red'>*</font>.

    Exemple :<ol>
            <li>_MI_EDITO_BANNER</li>     <li>_MI_EDITO_TEXTE_INDEX</li>        <li>_MI_EDITO_VALUE1</li>      <li>_MI_EDITO_VALUE2</li></ol>
  </li>
  <li>Customise the tabs display.
                                                                                                               
   Edit file for options.</li>
   </ul>
   
   NOTE : To remove this help note and it's tab, edit the setting.php file and set 'display_help' value to 0.
   NOTE 2 : If you experience weird display, edit the file and quote the following line (line 167): 'xoops_cp_header();'.

";


// Define here your operator list + the default values
                $op = array(        'op'                 =>      '',
                                    'sub'                =>      $def_sub,
                                    'menu'               =>      $def_menu
                                    );

                foreach( $op as $op_name=>$op_value ) {
                
                                  if (!isset($_POST[$op_name])) {
                                      $$op_name       = isset($_GET[$op_name]) ? $_GET[$op_name] : $op_value;
                                      if( eregi('\|', $$op_name) ) {
                                        $operator_array = explode('|', $$op_name);
                                        $$op_name = $operator_array;
                                      }
                                  } else {
                                        $$op_name       = $_POST[$op_name];
                                  }
                  }

// Select operation
switch( $op )
  {
    
  default:
// Display editor



       xoops_cp_header();   // Quote this line if you experience weird display as it is has been previously declared.

         if( $xoopsModule -> getVar( "dirname" )=='xoopsotron' ) {
            xoopsotron_adminmenu(1, _PREFERENCES . ' : ' . $xoopsModule -> getVar( "name" ));
         } else {

            echo '<h1 align="center">' . _PREFERENCES . ' : ' . $xoopsModule -> getVar( "name" ) . '</h1>';
         }

           if( $display_help&&$sub=='Help' ) {
               echo settings_sub_menu( $sub );
               $myts =& MyTextSanitizer::getInstance();
               echo '<p>' . themecenterposts(_PREFERENCES, $myts->makeTareaData4Show( $help )).'</p>';

           } else {

               echo settings_sub_menu( $sub );
               echo settings_display( $sub );
           }

         function_exists('xoopsotron_adminfooter')?xoopsotron_adminfooter():'';

       xoops_cp_footer();

    break;

  case ( 'save' ):
                      if (isset($_POST)) {
                        foreach ( $_POST as $k => $v ) {
                            ${$k} = $v;
                        }
                      }
                      
                      if (!$GLOBALS['xoopsSecurity']->check()) {
                        redirect_header("settings.php", 3, implode('<br />', $GLOBALS['xoopsSecurity']->getErrors()));
                    }
            
                    $count = count($conf_ids);
            
                    if ($count > 0) {
                        for ($i = 0; $i < $count; $i++) {
                            $config =& $config_handler->getConfig($conf_ids[$i]);
                            $new_value =& ${$config->getVar('conf_name')};
                            if (is_array($new_value) || $new_value != $config->getVar('conf_value')) {
                                $config->setConfValueForInput($new_value);
                                $config_handler->insertConfig($config);
                            }
                            unset($new_value);
                        }
                    }

                        redirect_header('?sub='.$sub,0,_FETCHING);
  break;
}




// Function to generate settings' form
function settings_display( $sub='' ) {
        Global $xoopsConfig, $xoopsModule;
        
                $mod = $xoopsModule -> getVar( "mid" );
                $like  = $sub?$sub . '_%':'%';

                $config_handler =& xoops_gethandler('config');
                $criteria = new CriteriaCompo(new Criteria('conf_modid', $xoopsModule -> getVar( "mid" ) ));
                $criteria->add(new Criteria('conf_name', $like, 'like'));
                $criteria->setSort('conf_order');
                $config = $config_handler->getConfigs($criteria, true);


        $config =& $config_handler->getConfigs($criteria);
        $count = count($config);
        if ($count < 1) {
            redirect_header('settings.php', 1);
        }
        include_once XOOPS_ROOT_PATH.'/class/xoopsformloader.php';
        $form = new XoopsThemeForm(_PREFERENCES, 'pref_form', 'settings.php?sub='.$sub, 'post', true);
        $module_handler =& xoops_gethandler('module');
        $module =& $module_handler->get($mod);
        if (file_exists(XOOPS_ROOT_PATH.'/modules/'.$module->getVar('dirname').'/language/'.$xoopsConfig['language'].'/modinfo.php')) {
            include_once XOOPS_ROOT_PATH.'/modules/'.$module->getVar('dirname').'/language/'.$xoopsConfig['language'].'/modinfo.php';
        } else {
            include_once XOOPS_ROOT_PATH.'/modules/'.$module->getVar('dirname').'../language/english/modinfo.php';
	}

        // if has comments feature, need comment lang file
        if ($module->getVar('hascomments') == 1) {
            include_once XOOPS_ROOT_PATH.'/language/'.$xoopsConfig['language'].'/comment.php';
        }
        // RMV-NOTIFY
        // if has notification feature, need notification lang file
        if ($module->getVar('hasnotification') == 1) {
            include_once XOOPS_ROOT_PATH.'/language/'.$xoopsConfig['language'].'/notification.php';
        }

        $modname = $module->getVar('name');
        if ($module->getInfo('adminindex')) {
            $form->addElement(new XoopsFormHidden('redirect', XOOPS_URL.'/modules/'.$module->getVar('dirname').'/'.$module->getInfo('adminindex')));
        }

        for ($i = 0; $i < $count; $i++) {
            $title = (!defined($config[$i]->getVar('conf_desc')) || constant($config[$i]->getVar('conf_desc')) == '') ? constant($config[$i]->getVar('conf_title')) : constant($config[$i]->getVar('conf_title')).'<br /><br /><span style="font-weight:normal;">'.constant($config[$i]->getVar('conf_desc')).'</span>';
            switch ($config[$i]->getVar('conf_formtype')) {
            case 'textarea':
                $myts =& MyTextSanitizer::getInstance();
                if ($config[$i]->getVar('conf_valuetype') == 'array') {
                    // this is exceptional.. only when value type is arrayneed a smarter way for this
                    $ele = ($config[$i]->getVar('conf_value') != '') ? new XoopsFormTextArea($title, $config[$i]->getVar('conf_name'), $myts->htmlspecialchars(implode('|', $config[$i]->getConfValueForOutput())), 5, 50) : new XoopsFormTextArea($title, $config[$i]->getVar('conf_name'), '', 5, 50);
                } else {
                    $ele = new XoopsFormTextArea($title, $config[$i]->getVar('conf_name'), $myts->htmlspecialchars($config[$i]->getConfValueForOutput()), 5, 50);
                }
                break;
            case 'select':
                $ele = new XoopsFormSelect($title, $config[$i]->getVar('conf_name'), $config[$i]->getConfValueForOutput());
                $options =& $config_handler->getConfigOptions(new Criteria('conf_id', $config[$i]->getVar('conf_id')));
                $opcount = count($options);
                for ($j = 0; $j < $opcount; $j++) {
                    $optval = defined($options[$j]->getVar('confop_value')) ? constant($options[$j]->getVar('confop_value')) : $options[$j]->getVar('confop_value');
                    $optkey = defined($options[$j]->getVar('confop_name')) ? constant($options[$j]->getVar('confop_name')) : $options[$j]->getVar('confop_name');
                    $ele->addOption($optval, $optkey);
                }
                break;
            case 'select_multi':
                $ele = new XoopsFormSelect($title, $config[$i]->getVar('conf_name'), $config[$i]->getConfValueForOutput(), 5, true);
                $options =& $config_handler->getConfigOptions(new Criteria('conf_id', $config[$i]->getVar('conf_id')));
                $opcount = count($options);
                for ($j = 0; $j < $opcount; $j++) {
                    $optval = defined($options[$j]->getVar('confop_value')) ? constant($options[$j]->getVar('confop_value')) : $options[$j]->getVar('confop_value');
                    $optkey = defined($options[$j]->getVar('confop_name')) ? constant($options[$j]->getVar('confop_name')) : $options[$j]->getVar('confop_name');
                    $ele->addOption($optval, $optkey);
                }
                break;
            case 'yesno':
                $ele = new XoopsFormRadioYN($title, $config[$i]->getVar('conf_name'), $config[$i]->getConfValueForOutput(), _YES, _NO);
                break;
            case 'group':
                include_once XOOPS_ROOT_PATH.'/class/xoopslists.php';
                $ele = new XoopsFormSelectGroup($title, $config[$i]->getVar('conf_name'), false, $config[$i]->getConfValueForOutput(), 1, false);
                break;
            case 'group_multi':
                include_once XOOPS_ROOT_PATH.'/class/xoopslists.php';
                $ele = new XoopsFormSelectGroup($title, $config[$i]->getVar('conf_name'), false, $config[$i]->getConfValueForOutput(), 5, true);
                break;
            // RMV-NOTIFY: added 'user' and 'user_multi'
            case 'user':
                include_once XOOPS_ROOT_PATH.'/class/xoopslists.php';
                $ele = new XoopsFormSelectUser($title, $config[$i]->getVar('conf_name'), false, $config[$i]->getConfValueForOutput(), 1, false);
                break;
            case 'user_multi':
                include_once XOOPS_ROOT_PATH.'/class/xoopslists.php';
                $ele = new XoopsFormSelectUser($title, $config[$i]->getVar('conf_name'), false, $config[$i]->getConfValueForOutput(), 5, true);
                break;
            case 'password':
                $myts =& MyTextSanitizer::getInstance();
                $ele = new XoopsFormPassword($title, $config[$i]->getVar('conf_name'), 50, 255, $myts->htmlspecialchars($config[$i]->getConfValueForOutput()));
                break;
            case 'color':
                $myts =& MyTextSanitizer::getInstance();
                $ele = new XoopsFormColorPicker($title, $config[$i]->getVar('conf_name'), 9, $myts->htmlspecialchars($config[$i]->getConfValueForOutput()));
                break;
            case 'hidden':
                $myts =& MyTextSanitizer::getInstance();
                $ele = new XoopsFormHidden( $config[$i]->getVar('conf_name'), $myts->htmlspecialchars( $config[$i]->getConfValueForOutput() ) );
                break;
            case 'textbox':
            default:
                $myts =& MyTextSanitizer::getInstance();
                $ele = new XoopsFormText($title, $config[$i]->getVar('conf_name'), 50, 255, $myts->htmlspecialchars($config[$i]->getConfValueForOutput()));
                break;
            }
            $hidden = new XoopsFormHidden('conf_ids[]', $config[$i]->getVar('conf_id'));
            $form->addElement($ele);
            $form->addElement($hidden);
            unset($ele);
            unset($hidden);
        }


        $form->addElement(new XoopsFormHidden('op', 'save'));
        $form->addElement(new XoopsFormButton('', 'button', _GO, 'submit'));
        Return $form->display();

 } 
 
 
 // Functiont to detect the various settings' variables
 function settings_sub_menu_list() {
Global $xoopsModule, $xoopsConfig, $xoopsModuleConfig, $alpha_sort, $colors, $default_color, $display_help;

$i=0;
// Default : General préférences
           $sub_menu[$i]['title']   = _PREFERENCES;
           $sub_menu[$i]['link']    = "settings.php";
           $sub_menu[$i]['color']   = isset($colors[$i])?$colors[$i]:$default_color;

// Create category list
$cat_liste='';
$alpha_sort?ksort($xoopsModuleConfig,SORT_STRING):'';
foreach( $xoopsModuleConfig as $name=>$value ) {
         $cat = explode('_',$name);

         if( !ereg($cat[0],$cat_liste) && isset($cat[1]) ) {

           $NAME         = @constant( strtoupper('_MI_'. $xoopsModule->dirname() . '_' . $cat[0]) );
           $NAME_DESC    = @constant( strtoupper('_MI_'. $xoopsModule->dirname() . '_' . $cat[0] . 'DSC') );
           $ALT_NAME     = '<span title="' . $NAME_DESC . '">
                           ' . ucfirst($cat[0]) . '
                           <font color="red">*</font>
                           </span>';
           $title       = $NAME       ? $NAME                         :$ALT_NAME;
           $description = $NAME_DESC  ? '" title="' . $NAME_DESC . '"' :'';

           $sub_menu[++$i]['title'] = $title;
           $sub_menu[$i]['link']    = '?sub='.$cat[0] . $description;
           $sub_menu[$i]['color']   = isset($colors[$i])?$colors[$i]:$default_color;
           $cat_liste .='|'.$cat[0];
         }
  }
  if($display_help) {
           $sub_menu[++$i]['title'] = 'Help';
           $sub_menu[$i]['link']    = '?sub=Help';
           $sub_menu[$i]['color']   = 'Salmon|LightSalmon ';
  }

  Return $sub_menu;
 }



// Function to create generate tabs
 function settings_sub_menu( $currentoption='' ) {
	global $xoopsConfig, $menu, $menu_select_max, $menu_select_multi;
	$sub_menu = settings_sub_menu_list();
        $menu = count($sub_menu)>=$menu_select_max  ? 'select'   :$menu;
        $size = count($sub_menu)>=$menu_select_multi? 'size="5"' :'';
    switch ( $menu )
    {
    case ('tab'):
    Default:

    $ret = '
             <style type="text/css">
              #subbar { float:right; font-size: 10px; line-height:normal; margin-bottom: 0px; }
              #subbar ul { margin:0; margin-top: 0px; padding:0px; list-style:none;}
              #subbar li { display:inline; margin:0px; padding:0px;}
              #subbar a  { float:left; baCkground-color: #DDE; margin:0; padding: 5px;
                           text-align: center; text-decoration:none;
                           border: 2px outset #000000; white-space: nowrap; }
              #subbar a span { display:block; white-space: nowrap; }
           /* Commented Backslash Hack hides rule from IE5-Mac \*/
              #subbar a span { float:none; }
           /* End IE5-Mac hack */
              #subbar #current a      { background-color: Beige; border: 2px inset Lightgrey; }
              #subbar #current a span { background-color: Beige; color:#333; }
              ';


            $previous['color']='';
    
          foreach( $sub_menu as $submenu ) {
            $submenu['color'] = explode('|',$submenu['color']);
            $submenu['color'][1] = isset($submenu['color'][1])?$submenu['color'][1]:$submenu['color'][0];
            $color = '
                      #subbar #'.$submenu['color'][0].' a      { background-color: '.$submenu['color'][0].'; border: 2px outset '.$submenu['color'][0].'; }
                      #subbar #'.$submenu['color'][0].' a span { background-color: '.$submenu['color'][0].'; color:#333; }
                      #subbar #'.$submenu['color'][0].' a:hover { background-position:0% -150px; background-color: '.$submenu['color'][1].'; }
                      #subbar #'.$submenu['color'][0].' a:hover span { color:#333; background-position:100% -150px; background-color: '.$submenu['color'][1].'; }
          ';
            $ret.= $submenu['color'][0]==$previous['color']?'':$color;
            $previous['color']=$submenu['color'][0];
          }
            $ret.= '</style>
            ';
            $ret.= '<div id="subbar"><ul>
            ';
          foreach( $sub_menu as $submenu ) {
                $submenu['color'] = explode('|',$submenu['color']);
                $tblColors = eregi( $currentoption?$currentoption:'settings', $submenu['link'] )?'current':$submenu['color'][0];
            $ret.= '<li id="' . $tblColors . '"><a href="' . $submenu['link'] . '"><span>' . $submenu['title'] . '</span></a></li>
            ';
        	}
            $ret.= '</ul></div>
            ';
            $ret.= '<div style="float: left; width: 100%;">
            ';
    break;
    
    
     case ('select'):
            $i=0;
            $ret ='<div style="padding-left:36px;">' . _SELECT . ' ' . strtolower(_PREFERENCES) . ' : ';
            $ret.='<select name="select_settings" '.$size.'
                          onchange="location=this.options[this.selectedIndex].value">
                 ';
          foreach( $sub_menu as $submenu ) {
                   $selected = eregi( $currentoption?$currentoption:'settings', $submenu['link'] )?'selected':'';
                   $nbsp = $i++?'&nbsp;&deg; ':'';
                   $ret.='<option value="'.$submenu['link'].'"'.$selected.'>' . $nbsp . $submenu['title'].'</option>';
        	}
            $ret.='</select>
                      </div>';
            $ret.='<div style="float: left; width: 100%;">
            ';

    break;
    }
 Return $ret;
}
?>