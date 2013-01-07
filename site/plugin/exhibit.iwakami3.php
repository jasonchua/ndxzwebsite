<?php if (!defined('SITE')) exit('No direct script access allowed');

/**
* SlideThumb PowerCombo
* Based on Iwakami and JodyRogac.com
* Modified by Jan Schjetne http://diggetydamn.com
*
* Exhibition format
* 
* @version 1
* @author Vaska
*/


// defaults from the general libary - be sure these are installed
$exhibit['dyn_css'] = dynamicCSS();
$exhibit['dyn_js'] = dynamicJS();
$exhibit['exhibit'] = createExhibit();


function dynamicJS()
{
	return "function show_image(id)
	{
		$('.pic').hide();
		$('#p' + id).fadeIn();
		$('#num').html(id);
		return false;
	}
	function swap() {
		if(document.getElementById('img-container').style.display != 'none'){
			document.getElementById('img-container').style.display =  'none';
			document.getElementById('d-image').style.display =  'inline';
		}
		else {
			document.getElementById('img-container').style.display =  'inline';
			document.getElementById('d-image').style.display =  'none';
		}
	}
	";
}


function createExhibit()
{
	$OBJ =& get_instance();
	global $rs;
	
	$pages = $OBJ->db->fetchArray("SELECT * 
		FROM ".PX."media, ".PX."objects_prefs 
		WHERE media_ref_id = '$rs[id]' 
		AND obj_ref_type = 'exhibit' 
		AND obj_ref_type = media_obj_type 
		ORDER BY media_order ASC, media_id ASC");

		
	// ** DON'T FORGET THE TEXT ** //
	$s = $rs['content'];

	if (!$pages) return $s;
	
	$i = 1; $a = ''; $t = '';
	
	$total = count($pages);

	$s .= "<!--[if lte IE 6]><style type='text/css'>.thumb-img { #top: -50%; }</style><![endif]-->";
	$s .= "<div id='img-container'>\n";
	// $s .= "<p id='nums'><span id='num'>1</span>/$total</p>";
	
	// people will probably want to customize this up
	foreach ($pages as $go)
	{
	    $title 		= ($go['media_title'] == '') ? '' : $go['media_title'] . '&nbsp;';
	    $caption 	= ($go['media_caption'] == '') ? '&nbsp;' : $go['media_caption'];

		$x = getimagesize(DIRNAME . GIMGS . '/' . $go['media_file']);
		
		$off = ($i == 1) ? "style='display: block;'" :  "style='display: none;'";
		
		$next = ($i == $total) ? 1 : $i+1;
		$prev = ($i == 0) ? $total : $i-1;
		
		
		
		$a .= "\n<div id='p$i' class='pic' $off>";
		$a .= "	<p><a href='#' onclick='show_image($prev); return false;'>Prev</a> | <a href='#' onclick='show_image($next); return false;'>Next</a>";
		$a .= "	<span style='margin-left: 9px'>$i/$total</span></p>";
		$a .= "	<a href='#' onclick='show_image($next); return false;'><img src='" . BASEURL . GIMGS . "/$go[media_file]' width='" . $x[0] . "' height='" . $x[1] . "' class='img-bot' /></a><p>{$title}<br />{$caption}</p></div>\n";
		
		$i++;
	}
	
	// images
	
	
	$s .= "<div id='img-container'>\n";
	$s .= "<div id='pics'>\n";
	$s .= $a;
	$s .= "</div>\n";
	$s .= "</div>\n\n";
		
	return $s;
}


function dynamicCSS()
{
	return "#img-container {  }
#pics {  }
p#nums {  }
.img-bot { margin-bottom: 12px; }";
}



?>