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

// Function used to display an content inside a block
// Parameters passed to this function :
// 1) max length of page's content
// 2) Page to display

function a_edito_show($options) {
	global $xoopsDB, $xoopsUser;
    $myts 	=& MyTextSanitizer::getInstance();
    $module = "edito";
    include_once (XOOPS_ROOT_PATH. "/modules/".$module."/include/functions_block.php");
    include_once (XOOPS_ROOT_PATH. "/modules/".$module."/include/functions_content.php");
	// Mise à Zero des variables
    $group = is_object($xoopsUser) ? $xoopsUser->getGroups() : array(XOOPS_GROUP_ANONYMOUS);
    $where = 'id='.$options[1];
    $order = '';
    $rand  = 0;

	/* ----------------------------------------------------------------------- */
	/*                            Query settings                               */
	/* ----------------------------------------------------------------------- */
    if ($options[1] == "random")	{
    	$result = $xoopsDB->queryF("SELECT COUNT(*) FROM " . $xoopsDB->prefix('content_'.$module)." WHERE status >= 3");
        list( $total )=$xoopsDB->fetchRow($result);
        $total = $total-1;
        $rand  = rand(0,$total);
        $where = "status >= 3";}

		// Afficher un edito pour chaque jours de l'année
        if ($options[1] == "day")	{
        	$rand = date("z");
            $where = " >= 3";
        }

		// Afficher un edito pour chaque semaine de l'année
        if ($options[1] == "week")	{
        	$rand = date("W");
	        $where = "status >= 3";
        }

        // Afficher un edito pour chaque jour de la semaine
        if ($options[1] == "week_day") {
			$rand = date("w");
        	$where = "status >= 3";
        }

        // Afficher le dernier edito
        if ($options[1] == "latest")	{
        	$order = "ORDER BY datesub DESC";
            $where = "status >= 3";
        }

        // Afficher l'edito le plus lu
		if ($options[1] == "read")	{
        	$order = "ORDER BY counter DESC";
            $where = "status >= 3";
        }

        // Afficher un edito lié
        if ($options[1] == "linked") {
        	$content_link = isset($_GET['id']) ? intval($_GET['id']) : 0;
	        $where = 'id='.$content_link;
        }

        $sql="SELECT id, status, subject, block_text, body_text, image, media, groups, options
        	  FROM ".$xoopsDB->prefix('content_'.$module)."
              WHERE $where $order";

        $result=$xoopsDB->queryF($sql ,1 ,$rand);

	/* ----------------------------------------------------------------------- */
	/*                            Check if edito exists                        */
	/* ----------------------------------------------------------------------- */
    if($xoopsDB->getRowsNum($result)<=0) {
    	return '';
        exit();
	}

    $myrow 	= $xoopsDB->fetchArray($result);

	/* ----------------------------------------------------------------------- */
	/*                            Groups access                                */
	/* ----------------------------------------------------------------------- */
    $groups = explode(" ",$myrow['groups']);
    if (count(array_intersect($group,$groups)) <= 0) {
		return '';
		exit();
	}

	/* ----------------------------------------------------------------------- */
	/*                            Variables settings                           */
	/* ----------------------------------------------------------------------- */
	$goon                  = '';
	$readmore              = '';
	$logo_width            = '';

    $media = explode("|", $myrow['media']);
	$media_file      =  $media[0];
	$media_url       =  $media[1];
	$media_sizes      =  $media[2];

    $option = explode("|", $myrow['options']);
    $html            =  $option[0];
    $xcode           =  $option[1];
    $smiley          =  $option[2];

    $image                 = $myrow['image'];
    $alt_subject           = strip_tags($myrow['subject']);
    $subject               = '';
    $id                    = $myrow['id'];
    $image_url             = edito_getmoduleoption('sbuploaddir');
    $align                 = edito_getmoduleoption('logo_align');

    $urw                   = edito_getmoduleoption('url_rewriting');
	/* ----------------------------------------------------------------------- */
	/*                            Create block content                         */
	/* ----------------------------------------------------------------------- */

	// Subject
	if ( $options[2] )	{
    	$subject = '<b>'.$myts->makeTareaData4Show($myrow['subject']).'</b><br />';
    }

	// Texte
    if ( $myrow['block_text'] ) {
    	$contents	= $myrow['block_text'];
        $content	= $myts->makeTareaData4Show($myrow['block_text'], $html, $smiley, $xcode);
	} else {
    	$contents	= $myrow['body_text'];
//        $content	= edito_substr($myts->makeTareaData4Show($myrow['body_text'], $html, $smiley, $xcode),0,$options[0],'');

        
	if ( $myrow["status"] == '4' ) {
	  $content  = $myrow['body_text'];  // Html mode
        } elseif($myrow["status"] == '5') {
          $content  = ''; $readmore = 1;
        } else {
	  $content  = xoops_substr($myts->makeTareaData4Show($myrow['body_text'], $html, $smiley, $xcode),0,$options[0],'');
        }

	}

	// Content TagReplace
	// include_once (XOOPS_ROOT_PATH. "/modules/".$module."/include/tagreplace.php");
	// $informations = edito_tagreplace($myrow["informations"]);
	// Création du media/logo

	/* ----------------------------------------------------------------------- */
	/*                            Create media content                         */
	/* ----------------------------------------------------------------------- */
	
if ( $options[3] )	{
	include_once(XOOPS_ROOT_PATH. "/modules/".$module."/include/functions_mediasize.php");

	if ( $media_file ) {
    	include_once(XOOPS_ROOT_PATH. "/modules/".$module."/include/functions_media.php");
        $media =  XOOPS_URL . '/'. edito_getmoduleoption('sbmediadir') .'/'. $media_file;
        $media_size =  edito_media_size($media_sizes, edito_getmoduleoption('custom'));
        $format = edito_checkformat( $media, edito_getmoduleoption('custom_media') );
        $filesize =  edito_fileweight( $media );
        $fileinfo = '<img src="images/icon/'.$format[1].'.gif" alt="'.$filesize.'" />';
	} elseif ( $media_url ) {
    	include_once(XOOPS_ROOT_PATH. "/modules/".$module."/include/functions_media.php");
        include_once(XOOPS_ROOT_PATH. "/modules/".$module."/include/functions_mediasize.php");
        $media =  $media_url;
        $media_size =  edito_media_size($media_sizes, edito_getmoduleoption('custom'));
        $format = edito_checkformat( $media, edito_getmoduleoption('custom_media') );
	} else {
    	$media = ''; $fileinfo = '';
    }

	// Media/logo alignment info
	if ( $align == 'center' )  {
    	$align_image = '';
	    $align_media = '';
    	$align_in = '<div align="center">';
	    $align_out = '</div>';
	} else {
    	$align_image = 'align="'.$align.'"';
	    $align_media = ', align='.$align;
    	$align_in = '';
	    $align_out = '';
    }


    // Media display mode
    // Media in page
       $media_display = '';
	if ( $options[4] == 'page' AND $media ) {
	$media_options = 'AutoStart=1, ShowControls=1, ShowTracker=1, AnimationAtStart=1, TransparentAtStart=0, enableContextMenu=0, BufferingProgress=1, PreBuffer=1, VideoDelay=999, VideoBufferSize=9, loop='.$xoopsModuleConfig['repeat'].$align_media;
	    $media_display = edito_media($media, $image, $media_size, $media_options, $myrow["subject"], edito_getmoduleoption('custom_media'));
    	$image_display = '';
    } elseif ( $options[4] == 'popup' AND $media ) {
    	//  include_once(XOOPS_ROOT_PATH. "/modules/".$module."/include/functions_media.php");
	    $logo =  XOOPS_URL . '/'. edito_getmoduleoption('sbuploaddir') .'/'. $image;
   		if ( !$image ) { $image = XOOPS_URL . '/modules/'. $module .'/images/media_video.gif'; }
        if ( $format[1] == 'image' ) {
        	$image_display = $align_in.edito_media($media, $logo, '', '', $myrow["subject"], edito_getmoduleoption('custom_media')).$align_out;
        } else {
        	$popup_size = edito_popup_size($media_size, edito_getmoduleoption('custom'));
            $image_display = $align_in.' <a onclick="window.open(\'\', \'wclose\', \''.$popup_size.', toolbar=no, scrollbars=yes, status=no, resizable=yes, fullscreen=no, titlebar=no, left=197, top=37\', \'false\')"
            				href="'.XOOPS_URL. '/modules/'.$module.'/popup.php?id=' . $id . ' " target="wclose">
                            <img src="' . $logo . '" alt="' . $alt_subject . '" ' . $align_image. ' />
                            </a>'.$align_out;
		}

        $info['displaylogo'] = 1;
        $media_display = '';
        // Media in page and popup
	} elseif ( $options[4] == 'both' AND $media ) {
	    include_once(XOOPS_ROOT_PATH. "/modules/".$module."/include/functions_media.php");
	$media_options = 'AutoStart=1, ShowControls=1, ShowTracker=1, AnimationAtStart=1, TransparentAtStart=0, enableContextMenu=0, BufferingProgress=1, PreBuffer=1, VideoDelay=999, VideoBufferSize=9, loop='.edito_getmoduleoption('repeat').$align_media;
	    $logo =  XOOPS_URL . '/'. edito_getmoduleoption('sbuploaddir') .'/'. $image;
    	if ( !$image ) { $logo = XOOPS_URL . '/modules/'. $module .'/images/media_video.gif'; }
	    if ( $format[1] == 'image' ) {
    		$image_display = $align_in.edito_media($media, $logo, '', '', $myrow["subject"], edito_getmoduleoption('custom_media')).$align_out;
	    	$logo = $media;
	    } else {
    		$popup_size = edito_popup_size($media_size, edito_getmoduleoption('custom'));
	    	$image_display = $align_in.' <a onclick="window.open(\'\', \'wclose\', \''.$popup_size.', toolbar=no, scrollbars=yes, status=no, resizable=yes, fullscreen=no, titlebar=no, left=197, top=37\', \'false\')"
			       		href="'.XOOPS_URL. '/modules/'.$module.'/popup.php?id=' . $id . ' " target="wclose">
                        <img src="' . $logo . '" alt="' . $alt_subject . '" ' . $align_image. ' />
                        </a>'.$align_out;

//			$info['displaylogo'] = 1;
			if ( $format[1] == 'image' )  {
    	    	$media_display = $align_in.'<img src="' . $media . '" alt="' . $alt_subject . '" />'.$align_out;
        	} else {
        	$media_display = edito_media($media, $logo, $media_size, $media_options, $myrow["subject"], edito_getmoduleoption('custom_media'));
    	    }
    	}
	} else {
		if ( $image ) {
			include_once (XOOPS_ROOT_PATH. "/modules/".$module."/include/functions_content.php");
			$logo_url =  XOOPS_URL . '/'. $image_url .'/'. $image;
			$link_url = XOOPS_URL.'/modules/'.$module.'/content.php?id='.$myrow['id'];
                        if( $urw ) {  $link_url = XOOPS_URL.'/modules/edito/'.edito_urw($link_url, $subject, $alt_subject, $urw); }

			$image_size = explode('|', edito_getmoduleoption('logo_size'));
			$image_display = edito_createlink($link_url, '', '', $logo_url, $align, trim($image_size[0]), trim($image_size[1]), $alt_subject.' '.$contents, $urw);
		} else {
			$image_display = '';
		}
	   $media_display = '';
	}
 }

	/* ----------------------------------------------------------------------- */
	/*                            Create redirection link                      */
	/* ----------------------------------------------------------------------- */
	if ( ($myrow['body_text'] && $myrow['block_text'] && $options[1] != 'linked') || strlen(strip_tags($contents)) >= $options[0] || $readmore ) {

          $link = XOOPS_URL.'/modules/edito/content.php?id='.$id;

          if( $urw ) {  $link = edito_urw($link_url, $subject, $alt_subject, $urw); }
		$readmore = '<div style="text-align:right; padding:6px;">'
                             .edito_createlink($link, _MB_EDITO_READMORE, '', '', '', '', '', $alt_subject, $urw).
                             '</div>';
       }
       if ( strlen(strip_tags($contents)) >= $options[0] && !$myrow['block_text'] && $myrow["status"] != '4') { $goon = '...'; }
       
	/* ----------------------------------------------------------------------- */
	/*                            Return data to template                      */
	/* ----------------------------------------------------------------------- */

    $block 	= array();
    $block['image']     = $image_display;
    $block['media']     = $media_display;
    $block['subject']   = $subject;
    $block['texte']     = $content.$goon;
    $block['link']      = $readmore;
    return $block;
    unset($block);
}

function a_edito_edit($options) {
	global $xoopsDB;
    $myts =& MyTextSanitizer::getInstance();
    $i = 0;
    $lst='';
    $module = 'edito';

    $sql = "SELECT id, subject, status FROM ".$xoopsDB->prefix('content_'.$module)." WHERE status >= 2";
    $result = $xoopsDB->queryF($sql);
    while( $myrow = $xoopsDB->fetchArray($result) ) {
    	$selected='';
    	if($myrow["status"]==0) { $status = 'off'; }
        if($myrow["status"]==1) { $status = 'wait'; }
        if($myrow["status"]==2) { $status = 'hid'; }
        if($myrow["status"]==3) { $status = 'on'; }
        if($myrow["status"]==4) { $status = 'htm'; }
        if($myrow["status"]==5) { $status = 'php'; }
        if($myrow["id"] == $options[1]) {
        	$selected=" selected ";
        }
        $lst.="<option value='" . $myrow["id"] . "'" . $selected . ">[" . $status ."] ". $myts->makeTareaData4Show($myrow["subject"]) . "</option>";
    }

	/*                            Max. text lenght                      */
    $form = _MB_EDITO_MAXLENGTH.'&nbsp;<input type="text" size="4" name="options['.$i.']" value="' . $options[$i] . '" />&nbsp;'._MB_EDITO_CHAR;

	/*                            Content selection                     */
    $i++;
    $form.= '<br />'._MB_EDITO_SELECT_EDITO.'&nbsp;<select name="options['.$i.']">';

    $form.= '<option value="random"';
    if ($options[$i] == "random") {
    	$form .= ' selected="selected"';
    }
   	$form.= '>'._MB_EDITO_SELECT_RANDOM.'</option>';
    $form.= '<option value="latest"';
   	if ($options[$i] == "latest") {
       	$form .= ' selected="selected"';
    }
    $form.= '>'._MB_EDITO_SELECT_LATEST.'</option>';

    $form.= '<option value="read"';
    if ($options[$i] == "read") {
       	$form .= ' selected="selected"';
	}
	$form.= '>'._MB_EDITO_SELECT_POP.'</option>';

	$form.= '<option value="linked"';
	if ($options[$i] == "linked") {
		$form .= ' selected="selected"';
	}
	$form.= '>'._MB_EDITO_SELECT_LINKED.'</option>';

	$form.= '<option value="day"';
	if ($options[$i] == "day") {
		$form .= ' selected="selected"';
	}
	$form.= '>'._MB_EDITO_SELECT_DAY.'</option>';

	$form.= '<option value="week"';
	if ($options[$i] == "week") {
		$form .= ' selected="selected"';
	}
	$form.= '>'._MB_EDITO_SELECT_WEEK.'</option>';

	$form.= '<option value="week_day"';
	if ($options[$i] == "week_day") {
		$form .= ' selected="selected"';
	}
	$form.= '>'._MB_EDITO_SELECT_WEEKDAY.'</option>';

	$form.= '<option value= "0"';
	if ($options[$i] == "0") {
		$form .= ' selected="selected"';
	}
	$form.= '>'._MB_EDITO_SELECT_NONE.'</option>';

	$form.= $lst;
	$form.= '</select><br />';

	/*                            Title display                     */
	$i++;
	$form .= _MB_EDITO_SHOWTITLE."&nbsp;<input type='radio' id='options[".$i."]' name='options[".$i."]' value='1'";
	if ( $options[$i] == 1 ) {
    	$form .= " checked='checked'";
    }
    $form .= " />&nbsp;"._YES."&nbsp;<input type='radio' id='options[".$i."]' name='options[".$i."]' value='0'";
    if ( $options[$i] == 0 ) {
		$form .= " checked='checked'";
	}
    $form .= " />&nbsp;"._NO."<br />";

	/*                            Logo display                     */
	$i++;
    $form .= _MB_EDITO_SHOWLOGO."&nbsp;<input type='radio' id='options[".$i."]' name='options[".$i."]' value='1'";
    if ( $options[$i] == 1 ) {
    	$form .= " checked='checked'";
    }
    $form .= " />&nbsp;"._YES."&nbsp;<input type='radio' id='options[".$i."]' name='options[".$i."]' value='0'";
    if ( $options[$i] == 0 ) {
    	$form .= " checked='checked'";
    }
    $form .= " />&nbsp;"._NO."";

	/*                            Media display                     */
    $i++;
    $form.= '<br />'._MB_EDITO_MEDIA_DISPLAY.'&nbsp;<select name="options['.$i.']">';

    $form.= '<option value=""';
    if ($options[$i] == "") {
		$form .= ' selected="selected"';
	}
	$form.= '></option>';

	$form.= '<option value="popup"';
	if ($options[$i] == "popup") {
		$form .= ' selected="selected"';
	}
	$form.= '>'._MB_EDITO_SELECT_POPUP.'</option>';

	$form.= '<option value="page"';
	if ($options[$i] == "page") {
		$form .= ' selected="selected"';
	}
	$form.= '>'._MB_EDITO_SELECT_PAGE.'</option>';

	$form.= '<option value="both"';
	if ($options[$i] == "both") {
		$form .= ' selected="selected"';
	}
	$form.= '>'._MB_EDITO_SELECT_BOTH.'</option>';
	$form.= '</select>';

	return $form;
}

function a_edito_menu_show($options) {
	global $xoopsDB, $xoopsUser;
	$myts 	=& MyTextSanitizer::getInstance();
	$module = "edito";
	include_once (XOOPS_ROOT_PATH. "/modules/".$module."/include/functions_block.php");
        include_once (XOOPS_ROOT_PATH. "/modules/".$module."/include/functions_content.php");
    $group = is_object($xoopsUser) ? $xoopsUser->getGroups() : array(XOOPS_GROUP_ANONYMOUS);

	/* ----------------------------------------------------------------------- */
	/*                            Query settings                               */
	/* ----------------------------------------------------------------------- */


	$sql = "SELECT id, uid, subject, block_text, media, meta, groups, image, datesub, counter, options
			FROM ".$xoopsDB->prefix('content_'.$module)."
			WHERE status >= 3
			ORDER BY ". $options[3];

	$numrows = $xoopsDB->getRowsNum($xoopsDB->query($sql));

	if( !$numrows ){
		return '';
		exit();
	}

	/* ----------------------------------------------------------------------- */
	/*                            Variables settings                           */
	/* ----------------------------------------------------------------------- */
	$perpage     = $options[4];
	$sbuploaddir = edito_getmoduleoption('sbuploaddir');
	$sbmediadir  = edito_getmoduleoption('sbmediadir');
	$tags        = edito_getmoduleoption('tags');
	$tags_pop    = edito_getmoduleoption('tags_pop');
	$tags_new    = edito_getmoduleoption('tags_new');
        $urw         = edito_getmoduleoption('url_rewriting');
	$i = 1;
	$time = time();
	$startdate = (time()-(86400 * $tags_new));

	$block = array();
	$block['format']       = $options[0];
	$block['columns']      = $options[2];
	$block['width']        = number_format(100/$options[2], 2, '.', ' ');
	$block['lang_num']     = _MB_EDITO_NUM;
	$block['lang_illu']    = _MB_EDITO_PIC;
	$block['lang_subject'] = _MB_EDITO_SUBJECT;
	$block['lang_read']    = _MB_EDITO_READ;
	$block['lang_summary'] = _MB_EDITO_SUMMARY;
	$block['lang_info']    = _MB_EDITO_INFO;

	/*                              Readmore link                            */
	if ( $numrows > $perpage ) {
	 $block['readmore'] = '<div style="text-align:right; padding:6px;">
                               <a href="'.XOOPS_URL.'/modules/'.$module.'/index.php?startart='.$perpage.'">
                              '._MB_EDITO_SEEMORE.'
                              </a>
                              </div>';
														}
	/* ----------------------------------------------------------------------- */
	/*                            Create each links                            */
	/* ----------------------------------------------------------------------- */
	$result = $xoopsDB->queryF($sql, $perpage, 0);

	if( !$urw && !edito_check_urw_htaccess() ) { !$urw = 0; }
	while( list($id, $uid, $subject, $block_text, $media, $meta, $groups, $image, $datesub, $counter, $content_options ) = $xoopsDB->fetchRow($result)  ) {

		/*                            Group permissions                            */
		$groups = explode(" ",$groups);
		if (count(array_intersect($group,$groups))) {

			/* ----------------------------------------------------------------------- */
			/*                              Retrieve options                           */
			/* ----------------------------------------------------------------------- */
			$media = explode("|", $media);
			$media_file     =  $media[0];
			$media_url      =  $media[1];
			$media_size     =  $media[2];
			
			$meta = explode("|", $meta);
                        if( $meta[0] ) { $meta_title = $meta[0]; } else { $meta_title = strip_tags($subject); }
			
                        $option = explode("|", $content_options);
			$html            =  $option[0];
			$xcode           =  $option[1];
			$smiley          =  $option[2];
                        $logo            =  $option[3];
			$block_option    =  $option[4];
			$title           =  $option[5];
			$cancomment      =  $option[6];

			/* ----------------------------------------------------------------------- */
			/*                              Infos to display                           */
			/* ----------------------------------------------------------------------- */
			/*                            User infos                                   */
			$alt_user    = XoopsUser::getUnameFromId($uid);
			$user        = '<a href="'.XOOPS_URL.'/userinfo.php?uid='.$uid.'">'.$alt_user.'</a>';
            $alt_date = formatTimestamp($datesub,'m');
            $fileinfo = '';

			if ( $tags ){
            	if ( $startdate < $datesub ) {
                	$fileinfo  .= '&nbsp;<img src="'.XOOPS_URL.'/modules/'.$module.'/images/icon/new.gif" alt="'.$alt_date.'" />';
                }

                if ( $counter >= $tags_pop ) {
                	$fileinfo .= '&nbsp;<img src="'.XOOPS_URL.'/modules/'.$module.'/images/icon/pop.gif" alt="'.$counter.'&nbsp;'._READS.'" />';
                }

				if ( $media_file ) {
                	include_once (XOOPS_ROOT_PATH. "/modules/".$module."/include/functions_mediasize.php");
                    $media    =  XOOPS_URL . '/'. $sbmediadir .'/'. $media_file;
                    $format   = edito_checkformat( $media, edito_getmoduleoption('custom_media') );
                    $filesize = edito_fileweight( $media );
                    $fileinfo .= ' <img src="'.XOOPS_URL.'/modules/'.$module.'/images/icon/'.$format[1].'.gif" alt="'.$format[1].': '.$format[0].' ['.$filesize.'] ['.$media_file.']" />
                    			   &nbsp;&nbsp;&nbsp;&nbsp;';
				} elseif ( $media_url ) {
					include_once (XOOPS_ROOT_PATH. "/modules/".$module."/include/functions_mediasize.php");
                    $media    =  $media_url;
                    $format   = edito_checkformat( $media, edito_getmoduleoption('custom_media') );
                    $fileinfo .= ' <img src="'.XOOPS_URL.'/modules/'.$module.'/images/icon/'.$format[1].'.gif" alt="'.$format[1].': '.$format[0].' ['.$media.']" />
                    			   <img src="'.XOOPS_URL.'/modules/'.$module.'/images/icon/ext.gif" alt="'._MB_EDITO_MEDIAURL.'"/>';
				}
			}

            $infos       = $alt_date."<br />". $fileinfo . $user;

			/*                              Title display                              */
            $subject = $myts->makeTareaData4Show($subject);
            if ($options[3] == "counter DESC") {
            	$subject .= " (".$counter.")";
            }
//            $alt_subject = strip_tags($subject);

			/*                              Image and link display                        */
            $link = '';
            $link_url = XOOPS_URL.'/modules/'.$module.'/content.php?id='.$id;
            if( $urw ) {  $link_url = XOOPS_URL.'/modules/'.$module.'/'.edito_urw($link_url, $subject, $meta_title, $urw); }

            if ( $image ) {
            	$logo_url =  XOOPS_URL . '/'. $sbuploaddir .'/'. $image;
            } else {
            	$logo_url =  '';
            }

            $image_size = explode('-',$options[1]);
            if ( $options[0] == 'pic' ) {
            	$image_link = edito_createlink($link_url, $subject, '', $logo_url, 'center', trim($image_size[0]), trim($image_size[1]), $meta_title, $urw);
			} else {
            	$image_link = edito_createlink($link_url, '', '', $logo_url, 'center', trim($image_size[0]), trim($image_size[1]), $meta_title, $urw);
                $link = edito_createlink($link_url, $subject, '', '', '', '', '', $meta_title, $urw);
			}

			/*                              Send to template                            */
            $data['link']       = $link;
            $data['image_link'] = $image_link;
            $data['alt_subject']= $meta_title;
            $data['subject']    = $subject;
            $data['link_url']   = $link_url;

			// Ext Infos
            $data['summary'] = $myts->makeTboxData4Show($block_text, $html, $smiley, $xcode);
            $data['read']    = $counter;
            $data['infos']   = $infos;
            $block['content'][]    = $data;
        }  // Groups
    } // While
    return $block;
    unset ($block);
}


function a_edito_menu_edit($options) {
	$i = 0;
	$form = '<table class="outer"><tr class="odd"><td>';

	/*                            Display mode                     */
    $form .= _MB_EDITO_FORMAT.'&nbsp;<select name="options[]">';

    $form.= '<option value="menu"';
    if ($options[$i] == "menu") {
		$form .= ' selected="selected"';
	}
	$form.= '>'._MB_EDITO_MENU.'</option>';

	$form.= '<option value="list"';
	if ($options[$i] == "list") {
    	$form .= ' selected="selected"';
    }
	$form.= '>'._MB_EDITO_LIST.'</option>';

	$form.= '<option value="pic"';
	if ($options[$i] == "pic") {
    	$form .= ' selected="selected"';
    }
    $form.= '>'._MB_EDITO_PIC.'</option>';

	$form.= '<option value="ext"';
    if ($options[$i] == "ext") {
    	$form .= ' selected="selected"';
    }
    $form.= '>'._MB_EDITO_EXT.'</option>';

    $form.= '</select><br />';

	/*                            Pic Def size                     */
	$form .= '</td><td>';
	$i++;
	$form.= _MB_EDITO_PICSIZE . '<input type="text" size="10" name="options['.$i.']" value="' . $options[$i] . '" /><br />';

	/*                            Columns                     */
	$form .= '</td></tr><tr class="even"><td>';
    $i++;
	$form.= _MB_EDITO_COLUMNS.'&nbsp;<select name="options['.$i.']">';

    $form.= '<option value="1"';
	if ($options[$i] == "1") {
		$form .= ' selected="selected"';
	}
	$form.= '>1</option>';

	$form.= '<option value="2"';
	if ($options[$i] == "2") {
		$form .= ' selected="selected"';
	}
	$form.= '>2</option>';

	$form.= '<option value="3"';
	if ($options[$i] == "3") {
		$form .= 'selected="selected"';
	}
	$form.= '>3</option>';

	$form.= '<option value="4"';
	if ($options[$i] == "4") {
		$form .= 'selected="selected"';
	}
	$form.= '>4</option>';
	$form.= '</select><br />';

	/*                            Order                     */
	$form .= '</td><td>';
	$i++;
	$form.= _MB_EDITO_ORDER.'&nbsp;<select name="options['.$i.']">';

	$form.= '<option value="subject ASC"';
	if ($options[$i] == "subject ASC") {
		$form .= ' selected="selected"';
	}
	$form.= '>'._MB_EDITO_ORDER_SUBJECT_ASC.'</option>';

	$form.= '<option value="datesub DESC"';
	if ($options[$i] == "datesub DESC") {
		$form .= 'selected="selected"';
	}
	$form.= '>'._MB_EDITO_ORDER_DATE_DESC.'</option>';

	$form.= '<option value="counter DESC"';
	if ($options[$i] == "counter DESC") {
		$form .= 'selected="selected"';
	}
	$form.= '>'._MB_EDITO_ORDER_COUNTER.'</option>';
	$form .= '</td></tr><tr><td colspan="2">';

	 /*                            Order                     */
	$i++;
	$form.= _MB_EDITO_NUMBER.'&nbsp;<select name="options['.$i.']">';

	$form.= '<option value="6"';
	if ($options[$i] == "6") {
		$form .= ' selected="selected"';
	}
	$form.= '>6</option>';

	$form.= '<option value="10"';
	if ($options[$i] == "10") {
		$form .= ' selected="selected"';
	}
	$form.= '>10</option>';

	$form.= '<option value="16"';
	if ($options[$i] == "16") {
		$form .= 'selected="selected"';
	}
	$form.= '>16</option>';

	$form.= '<option value="20"';
	if ($options[$i] == "20") {
		$form .= 'selected="selected"';
	}
	$form.= '>20</option>';

	$form.= '<option value="30"';
	if ($options[$i] == "30") {
		$form .= 'selected="selected"';
	}
	$form.= '>30</option>';

	$form.= '<option value="50"';
	if ($options[$i] == "50") {
		$form .= 'selected="selected"';
	}
	$form.= '>50</option>';

	$form.= '</select>';
	$form .= '</td></tr></table>';

	return $form;
}
?>