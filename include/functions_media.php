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

if (!defined("XOOPS_ROOT_PATH")) { die("XOOPS root path not defined"); }


function edito_media( $media_url, $thumb, $media_size, $options, $description, $custom_media='' ) {
        $is_mpeg=0;
	$ext = pathinfo( $media_url, PATHINFO_EXTENSION ) ;
	$ext = strtolower( $ext );
	$ext_thumb = pathinfo( $thumb, PATHINFO_EXTENSION ) ;
	$ext_thumb = strtolower( $ext_thumb );
	if( $custom_media ) {
	    $custom_medias = explode('|', $custom_media);
            foreach($custom_medias as $custom_media) {
                               if(eregi($custom_media, '.'.$ext)) { $is_mpeg=1; }
            }
        }

	// $myts =& MyTextSanitizer::getInstance();
	// $description = $myts->makeTareaData4Show($description);

	if ( $ext == 'swf' ) {
		$media = edito_media_flash( $media_url, $thumb, $media_size, $options, $description );
	} elseif ( $ext == 'flv' ) {
		$media = edito_media_flv( $media_url, $thumb, $media_size, $options, $description );
	} elseif ( $ext == 'mov' ) {
		$media = edito_media_mov( $media_url, $thumb, $media_size, $options, $description );
	} elseif ( $ext == 'avi' || $ext == 'mpg' || $ext == 'mpeg' || $ext == 'wmv'  || eregi('asx', $ext) ||  $is_mpeg ) {
		$media = edito_media_mpg( $media_url, $thumb, $media_size, $options, $description );
	} elseif ( $ext == 'ram' || $ext == 'rm' ) {
		$media = edito_media_ram( $media_url, $thumb, $media_size, $options, $description );
	} elseif ( $ext == 'mp3' || $ext == 'wav' || $ext == 'mid' ) {
		$media = edito_media_mp3( $media_url, $thumb, $media_size, $options, $description );
	} elseif ( ($ext == 'jpeg' || $ext == 'jpg' || $ext == 'gif' || $ext == 'tif' || $ext == 'png') && ($ext_thumb == 'jpeg' || $ext_thumb == 'jpg' || $ext_thumb == 'gif' || $ext_thumb == 'tif' || $ext_thumb == 'png') ) {
		$media = edito_media_image( $media_url, $thumb, $media_size, $options, $description );
	} elseif ( ($ext == 'jpeg' || $ext == 'jpg' || $ext == 'gif' || $ext == 'tif' || $ext == 'png') && ($ext_thumb != 'jpeg' && $ext_thumb != 'jpg' && $ext_thumb != 'gif' && $ext_thumb != 'tif' && $ext_thumb != 'png')) {
		$media = '<div class="errorMsg">ERROR : thumbnail not found!</div>';
	} else {
		$media = '<div class="errorMsg">ERROR : file not found!</div>';
	}

	return $media;
}

// Options function : convert options into optionnal setting
function edito_media_options( $options ) {
	if ( $options ) {
    	$option = explode(",", $options);
		foreach ( $option as $parameters ) {
			$par = explode("=", $parameters);
			$param 	= trim($par[0]);
			$value	= trim($par[1]);

			if ( strtolower($value) == 'yes' OR strtolower($value) == 'true' ) { $value = 1; }
			if ( strtolower($value) == 'no'  OR strtolower($value) == 'false' ) { $value = 0; }

			if ( trim($param) == 'align') {
            	$align = $par[1];
            } elseif ( $param == 'width' ) {
            	$image_width 	= $par[1];
            } elseif ( $param == 'height')	{
            	$image_height 	= $par[1];
            } else {
				if ( $value == 0 ) {
                	$value = "false"; $ff_value = 0;
                } elseif ( $value == 1 ) {
                	$value = "true";  $ff_value = 1;
                }
			}

            $opt.= '<param name="'.$param.'" value="'.$value.'">';
			$ff_opt.= strtolower($param).'="'.$ff_value.'"';
		}
	}
	return $opt;
}



function edito_media_mp3( $media_url, $thumb, $media_size, $options, $description) {
	// Different options
	$opt 		= '';
	$ff_opt 	= '';
	$align  	= '';
	$align_in = '';
	$align_out = '';
	$media_width = '';
	$media_height = '';

	if ( $options ) {
    	$option = explode(",", $options);
		foreach ( $option as $parameters ) {
			$par = explode("=", $parameters);
			$param 	= trim($par[0]);
			$value	= trim($par[1]);

			switch( strtolower($value) ) {
                case "yes" :
                case "true" :
                case "1" :
				$value = "true";
				$ff_value = "true";
				break;

                case "no" :
                case "false" :
                case "0" :
				$value = "false";
				$ff_value = "false";
				break;

				default:
                $value = $value;
				$ff_value = $value;
			}

 			if ( $param == 'align') {
            	$align  = $par[1];
            } elseif ( $param == 'width') {
            	$width  = $par[1]; $media_width  = 'width="'.$width.'"';
            } elseif ( $param == 'height' )	{
            	$height = $par[1]; $media_height = 'height="'.$height.'"';
            } else {
				$opt.= '<param name="'.$param.'" value="'.$value.'">';
				$ff_opt.= strtolower($param).'="'.$ff_value.'" ';
			}
		}
	}
	if ( $media_width OR $media_height ) {
    	$media_size = $media_width.' '.$media_height;
    }
	if ( $align == 'left' ) {
    	$align = ' align="left"';
    }
	if ( $align == 'right' ) {
    	$align = ' align="right"';
    }
	if ( $align == 'center' ) {
    	$align = ' ';
		$align_in = '<div align="center">';
		$align_out = '</div>';
    }

	$sound = $align_in;
	$sound .= '<!-- BEGIN wmp -->';
	$sound .= '<object';
	$sound .= 'ID="player" ';
	$sound .= $media_size;
	$sound .= $align.'';
	$sound .= 'classid="CLSID:22D6F312-B0F6-11D0-94AB-0080C74C7E95"';
	$sound .= 'CODEBASE="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,4,5,715" ';
	$sound .= 'standby="Loading..." ';
	$sound .= 'type="application/x-oleobject">';
	$sound .= '<param name="FileName" value="'.$media_url.'">';
	$sound .= $opt;
	$sound .= '<embed ';
	$sound .= 'type="video/x-ms-asf-plugin" ';
	$sound .= 'pluginsmyMedia="http://www.microsoft.com/Windows/Downloads/Contents/Products/MediaPlayer/" ';
	$sound .= 'src="'.$media_url.'" ';
	$sound .= 'name=\"MediaPlayer\" ';
	$sound .= $ff_opt;
	$sound .= $media_size;
	$sound .= $align;
	$sound .= '/>';
	$sound .= '</embed>';
	$sound .= '</object>';
	$sound .= '<!-- END wmp -->';
	$sound .= $align_out;

    return $sound;
}

// Windows Media Player
function edito_media_mpg( $media_url, $thumb, $media_size, $options, $description) {
	// Different options
	$opt = '';
	$ff_opt = '';
	$align = '';
	$align_in = '';
	$align_out = '';
	$media_width = '';
	$media_height = '';

	if ( $options ) {
    	$option = explode(",", $options);
		foreach ( $option as $parameters ) {
			$par = explode("=", $parameters);
			$param 	= trim($par[0]);
			$value	= trim($par[1]);

			switch( strtolower($value) ) {
                case "yes" :
                case "true" :
                case "1" :
				if ($param == 'playcount') {
        	        $value = $value; $ff_value = $value;
                } elseif ($param == 'balance') {
    	            $value = $value; $ff_value = $value;
                } elseif ($param == 'rate') {
	                $value = $value; $ff_value = $value;
                } else {
                	$value = "1";	$ff_value = "true";
                }
				break;

                case "no" :
                case "false" :
                case "0" :
                     if ($param == 'playcount') {
	                $value = $value; $ff_value = $value;
                } elseif ($param == 'balance') {
    	            $value = $value; $ff_value = $value;
                } elseif ($param == 'rate') {
        	        $value = $value; $ff_value = $value;
                } else {
            	    $value = "0";	$ff_value = "false";
                }
				break;

				default:
                $value = $value;
				$ff_value = $value;
			}

			if ( $param == 'align') {
            	$align  = $par[1];
            } elseif ( $param == 'width') {
	            $width  = $par[1]; $media_width  = 'width="'.$width.'"';
            } elseif ( $param == 'height' )	{
    	        $height = $par[1]; $media_height = 'height="'.$height.'"';
            } else {
				$opt.= '<param name="'.$param.'" value="'.$value.'">';
				$ff_opt.= strtolower($param).'="'.$ff_value.'" ';
			}
		}
	}
	if ( $media_width OR $media_height ) {
    	$media_size = $media_width.' '.$media_height;
    }
	if ( $align == 'left' ) {
    	$align = ' align="left"';
    }
	if ( $align == 'right' ) {
    	$align = ' align="right"';
    }
	if ( $align == 'center' ) {
    	$align = '';
		$align_in = '<div align="center">';
		$align_out = '</div>';
    }


	$video = $align_in;
	$video .= '<!-- BEGIN wmp -->';
	$video .= '<object ';
	$video .= 'ID="player" ';
	$video .= $media_size.' ';
	$video .= $align;
	$video .= 'classid="CLSID:22D6F312-B0F6-11D0-94AB-0080C74C7E95"';
	$video .= '	CODEBASE="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=5,1,52,701" ';
	$video .= 'standby="Loading..." ';
	$video .= 'type="application/x-oleobject">';
	$video .= '<param name="filename" value="'.$media_url.'">';
	$video .= $opt;
	$video .= '<embed ';
	$video .= 'type="video/x-ms-asf-plugin" ';
	$video .= 'pluginsmyMedia="http://www.microsoft.com/Windows/Downloads/Contents/Products/MediaPlayer/" ';
	$video .= 'src="'.$media_url.'" ';
	$video .= 'name="MediaPlayer" ';
	$video .= $ff_opt;
	$video .= $media_size;
	$video .= ' '.$align;
	$video .= '/>';
	$video .= '</embed>';
	$video .= '</object>';
	$video .= '<!-- END wmp -->';
	$video .= $align_out;

	return $video;
}

function edito_media_flash( $media_url, $thumb, $media_size, $options, $description) {
	// Different options
	// Available Media options
	$is_align = '';
	$opt = '';
	$ff_opt = '';
	$media_width = '';
	$media_height = '';
	$align_in = '';
	$align_out = '';

	if ( $options ) {
    	$option = explode(",", $options);
		foreach ( $option as $parameters ) {
			$par = explode("=", $parameters);
			$param 	= trim($par[0]);
			$value	= trim($par[1]);

			switch( strtolower($value) ) {
                case "yes" :
                case "true" :
                case "1" :
				$value = "1";
				$ff_value = "true";
				break;

                case "no" :
                case "false" :
                case "0" :
				$value = "0";
				$ff_value = "false";
				break;

                default:
                $value = $value;
				$ff_value = $value;
			}

            if ( $param == 'align' ){
            	if ( $is_align == 0 ) {
                	$align  = $par[1]; $is_align = 1;
                }
            } elseif ( $param == 'width') {
            	$width  = $par[1]; $media_width  = 'width="'.$width.'"';
            } elseif ( $param == 'height' )	{
            	$height = $par[1]; $media_height = 'height="'.$height.'"';
            } else {
				$opt.= '<param name="'.$param.'" value="'.$value.'">';
				$ff_opt.= strtolower($param).'="'.$ff_value.'" ';
	     	}
		}
	}

	if ( $media_width OR $media_height ) {
    	$media_size = $media_width.' '.$media_height;
    }
	if ( !$media_size ) {
		list($flash_width, $flash_height, $flash_type, $flash_attr) = @getimagesize( $media_url );
		$media_size = $flash_attr;
	}

	if ( $align == 'left' ) {
    	$align = ' align="left"';
    }
	if ( $align == 'right' ) {
    	$align = ' align="right"';
    }
	if ( $align == 'center' ) {
	    $align = '';
		$align_in = '<div align="center">';
		$align_out = '</div>';
    }

	$flash = $align_in;
	$flash .= '<!-- BEGIN flash -->';
	$flash .= '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"';
	$flash .= ' codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0" ';
	$flash .= $media_size;
	$flash .= $align;
	$flash .= '><param name="movie" value="'.$media_url.'">';
	$flash .= $opt;
	$flash .= '<embed src="'.$media_url.'" ';
	$flash .= '	pluginsmyMedia="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" ';
	$flash .= '	type="application/x-shockwave-flash" ';
	$flash .= $media_size;
	$flash .= ' '.$ff_opt;
	$flash .= $align;
	$flash .= '></embed>';
	$flash .= '</object>';
	$flash .= '<!-- END flash -->';
	$flash .= $align_out;

	return $flash;
}


function edito_media_flv( $media_url, $thumb, $media_size, $options, $description) {
	// Different options
	// Available Media options
	$is_align = '';
	$opt = '';
	$ff_opt = '';
	$media_width = '';
	$media_height = '';
	$align_in = '';
	$align_out = '';

	if ( $options ) {
    	$option = explode(",", $options);
		foreach ( $option as $parameters ) {
			$par = explode("=", $parameters);
			$param 	= trim($par[0]);
			$value	= trim($par[1]);

			switch( strtolower($value) ) {
                case "yes" :
                case "true" :
                case "1" :
				$value = "1";
				$ff_value = "true";
				break;

                case "no" :
                case "false" :
                case "0" :
				$value = "0";
				$ff_value = "false";
				break;

                default:
                $value = $value;
				$ff_value = $value;
			}

            if ( $param == 'align' ){
            	if ( $is_align == 0 ) {
                	$align  = $par[1]; $is_align = 1;
                }
            } elseif ( $param == 'width') {
            	$width  = $par[1]; $media_width  = 'width="'.$width.'"';
            } elseif ( $param == 'height' )	{
            	$height = $par[1]; $media_height = 'height="'.$height.'"';
            } else {
				$opt.= '<param name="'.$param.'" value="'.$value.'">';
				$ff_opt.= strtolower($param).'="'.$ff_value.'" ';
	     	}
		}
	}

	if ( $media_width OR $media_height ) {
    	$media_size = $media_width.' '.$media_height;
    }
	if ( !$media_size ) {
		list($flash_width, $flash_height, $flash_type, $flash_attr) = @getimagesize( $media_url );
		$media_size = $flash_attr;
	}

	if ( $align == 'left' ) {
    	$align = ' align="left"';
    }
	if ( $align == 'right' ) {
    	$align = ' align="right"';
    }
	if ( $align == 'center' ) {
	    $align = '';
		$align_in = '<div align="center">';
		$align_out = '</div>';
    }

	$flash = $align_in;
	$flash .= '<!-- BEGIN flash -->';
	$flash .= '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"';
	$flash .= ' codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0" ';
	$flash .= $media_size;
	$flash .= $align;
	$flash .= '><param name="movie" value="'.$media_url.'">';
	$flash .= $opt;
	$flash .= '<embed src="class/flashplay.swf" ';
	$flash .= 'flashvars="url='.$media_url.'"';
	$flash .= '	pluginsmyMedia="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" ';
	$flash .= '	type="application/x-shockwave-flash" ';
	$flash .= $media_size;
	$flash .= ' '.$ff_opt;
	$flash .= $align;
	$flash .= '></embed>';
	$flash .= '</object>';
	$flash .= '<!-- END flash -->';
	$flash .= $align_out;

	return $flash;
}

// Movie Player
function edito_media_mov( $media_url, $thumb, $media_size, $options, $description) {
	// Different options
	// Available Media options

	$opt = '';
	$ff_opt = '';
	$media_width = '';
	$media_height = '';
	$align_in = '';
	$align_out = '';

	if ( $options ) {
    	$option = explode(",", $options);
		foreach ( $option as $parameters ) {
			$par = explode("=", $parameters);
			$param 	= trim($par[0]);
			$value	= trim($par[1]);

			switch( strtolower($value) ) {
                case "yes" :
                case "true" :
                case "1" :
				$value = "1";
				$ff_value = "true";
				break;

                case "no" :
                case "false" :
                case "0" :
				$value = "0";
				$ff_value = "false";
				break;

                default:
                $value = $value;
				$ff_value = $value;
			}

			if ( $param == 'align') {
    	        $align  = $par[1];
            } elseif ( $param == 'width') {
	            $width  = $par[1]; $media_width  = 'width="'.$width.'"';
            } elseif ( $param == 'height' )	{
            	$height = $par[1]; $media_height = 'height="'.$height.'"';
            } else {
				$opt.= '<param name="'.$param.'" value="'.$value.'">';
				$ff_opt.= strtolower($param).'="'.$ff_value.'" ';
		 	}
		}
	}
	if ( $media_width OR $media_height ) {
    	$media_size = $media_width.' '.$media_height;
    }
	if ( $align == 'left' ) {
    	$align = ' align="left"';
    }
	if ( $align == 'right' ) {
    	$align = ' align="right"';
    }
	if ( $align == 'center' ) {
    	$align = '';
		$align_in = '<div align="center">';
		$align_out = '</div>';
    }

	$mov = $align_in;
	$mov .= '<!-- BEGIN mov -->';
	$mov .= '<object ';
	$mov .= 'classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" ';
	$mov .= 'codebase="http://www.apple.com/qtactivex/qtplugin.cab" ';
	$mov .= $media_size;
	$mov .= $align;
	$mov .= '>';
	$mov .= '<param name="src" value="'.$media_url.'"> ';
	$mov .= '<param name="type" value="video/quicktime">';
	$mov .= '<param name="pluginsmyMedia" value="http://www.apple.com/quicktime/dowload/"> ';
	$mov .= $opt;
	$mov .= '<embed src="'.$media_url.'" type="video/quicktime" ';
	$mov .= 'pluginsmyMedia="http://www.apple.com/quicktime/dowload/" ';
	$mov .= $ff_opt;
	$mov .= $media_size;
	$mov .= ' '.$align;
	$mov .= '/>';
	$mov .= '</embed>';
	$mov .= '</object>';
	$mov .= '<!-- END mov -->';
	$mov .= $align_out;

	return $mov;
}

function edito_media_ram( $media_url, $thumb, $media_size, $options, $description) {
	// Different options
	// Options generator
	$opt = '';
	$ff_opt = '';
	$media_width = '';
	$media_height = '';
	$align_in = '';
	$align_out = '';

	if ( $options ) {
    	$option = explode(",", $options);
		foreach ( $option as $parameters ) {
			$par = explode("=", $parameters);
			$param 	= trim($par[0]);
			$value	= trim($par[1]);

			switch( strtolower($value) ) {
                case "yes" :
                case "true" :
                case "1" :
				$value = "1";
				$ff_value = "true";
				break;

                case "no" :
                case "false" :
                case "0" :
				$value = "0";
				$ff_value = "false";
				break;

                default:
                $value = $value;
				$ff_value = $value;
			}

			if ( $param == 'align') {
    	        $align  = $par[1];
            } elseif ( $param == 'width') {
	            $width  = $par[1]; $media_width  = 'width="'.$width.'"';
            } elseif ( $param == 'height' )	{
            	$height = $par[1]; $media_height = 'height="'.$height.'"';
            } else {
            	$opt.= '<param name="'.$param.'" value="'.$value.'">';
				$ff_opt.= strtolower($param).'="'.$ff_value.'" ';
            }
		}
	}
	if ( $media_width OR $media_height ) {
    	$media_size = $media_width.' '.$media_height;
    }
	if ( $align == 'left' ) {
    	$align = ' align="left"';
    }
	if ( $align == 'right' ) {
    	$align = ' align="right"';
    }
	if ( $align == 'center' ) {
    	$align = '';
		$align_in = '<div align="center">';
		$align_out = '</div>';
    }

	$ram = $align_in;
	$ram .= '<!-- BEGIN ram/rm -->';
	$ram .= '<object ';
	$ram .= 'id="RVOCX" ';
	$ram .= 'classid="clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA" ';
	$ram .= $media_size;
	$ram .= $align;
	$ram .= '>';
	$ram .= $opt;
	$ram .= '<param name="src" value="'.$media_url.'"/>';
	$ram .= '<embed type="audio/x-pn-realaudio-plugin" src="';
	$ram .= $media_url.'" ';
	$ram .= $media_size;
	$ram .= $align;
	$ram .= ' '.$ff_opt;
	$ram .= '/>';
	$ram .= '</embed>';
	$ram .= '</object>';
	$ram .= '<!-- END ram/rm -->';
	$ram .= $align_out;

	return $ram;
}

// Function to display image popup
function edito_media_image( $image_url, $thumb, $thumb_width, $options, $description) {
	// Options generator
	$opt = '';
	$ff_opt = '';
	$plus = '';
	$align = '';
	$activate = '';
	$popcode = '';
	$image_width = '';
	$image_height = '';

	if ( $options ) {
    	$option = explode(",", $options);
		foreach ( $option as $parameters ) {
			$par = explode("=", $parameters);
			$param = trim($par[0]);
			$value = trim($par[1]);

            if ( $par[1] == '0' ) {
            	$value = "no";
            } elseif ( $par[1] == '1' ) {
            	$value = "yes";
            }

    		if ( $param == 'activate') {
            	$activate = $par[1];
            } elseif ( $param == 'align' ) {
        	    $align 	= $par[1];
            } elseif ( $param == 'width' ) {
    	        $image_width 	= $par[1];
            } elseif ( $param == 'height' )	{
	            $image_height 	= $par[1];
            } elseif ( $param == 'scrollbars' AND $par[1] == '1' )	{
            	$plus = 20; $opt.= $param.'=yes, ';
            } else {
            	$opt.= trim($param).'='.$value.', ';
            }
		}
	}

	// Check pictures
	if ( !$image_width AND !$image_height ) {
    	list( $image_width, $image_height, $image_type, $image_attr ) = @getimagesize( $image_url );

		if ( $thumb AND $thumb != $image_url ) {
        	list($thumbs_width, $thumb_height, $thumb_type, $thumb_attr) = @getimagesize( $thumb );
        } else {
        	$thumb	= $image_url;
			$thumb_type	= $image_type;
        }
	} else {
    	$thumbs_width = $thumb_width;
    }

	if ( $image_width ) {
		// Define popup window size
		$image_width 	= $image_width  + 20 + $plus;
		$image_height   	= $image_height + 20 + $plus;

//	if ( $image_width > 800 OR $image_height > 600 ) {
//    	$scrollbars = "scrollbars=yes, ";
//    }

	// Define popup window position
	$lpos = 600 - $image_width; if ( $lpos < 0 ) { $lpos = 0; }
	$tpos = 400 - $image_height; if ( $tpos < 0 ) { $tpos = 0; }

	// Define thumb position and check size
	if ( $thumb_width AND $thumbs_width >= $thumb_width ) 	{
	    $thumb_width = ' width="'.$thumb_width.'"';
    } else {
    	$thumb_width = '';
    }

	$align_in = ''; $align_out = '</a>';
	if ( $align == 'left' ) {
    	$align = ' align="left"';
    }
	if ( $align == 'right' ) {
    	$align = ' align="right"';
    }
	if ( $align == 'center' ) {
    	$align = '';
		$align_in = '<div align="center">';
		$align_out = '</a>
		</div>';
    }

	// Alt tag text
	$alt = strip_tags( $description );

	// Create code
	if ( $activate == "onload") {
		$popcode = "<script type='text/javascript'>
				   <!--
					function popup(mylink, windowname) {
					if (! window.focus)return true;
					var href;
					if (typeof(mylink) == 'string')
						href=mylink;
					} else {
						href=mylink.href;
					}
					window.open(href, windowname, 'width=".$image_width.", height=".$image_height.", ".$opt."left=".$lpos.", top=".$tpos."');
					return false;
					}
					//-->
					</SCRIPT>
					<img src=\"".$thumb."\"".$align."".$thumb_width." alt=\"".$alt."\" onLoad=\"popup('".$image_url."', 'ad')\" />
					";

	} elseif ($activate == "onmouse") {
		$popcode = $align_in . "
				   <a href=\"#\" onMouseOver=\"w = window.open('".$image_url."', 'PopUp', 'width=".$image_width.", height=".$image_height.", ".$opt."left=".$lpos.", top=".$tpos."', 'false'); return true;\" onMouseOut=\" w.window.close(); return true;\">
				   <img src=\"".$thumb."\"".$align."".$thumb_width." alt=\"".$alt."\" />
					" . $align_out;
	} else {
		$popcode = $align_in . "
				   <a onclick=\"pop=window.open('', 'wclose', 'width=".$image_width.", height=".$image_height.", ".$opt."left=".$lpos.", top=".$tpos."', 'false'); pop.focus();\" href=\"".$image_url."\" target=\"wclose\">
                   <img src=\"".$thumb."\"".$align."".$thumb_width." alt=\"".$alt."\" />" . $align_out;
	}

 	} // Does images and thumb exist
	return $popcode;
}
?>