<?php if (!defined('SITE')) exit('No direct script access allowed');

/**
* Horizontal Format
*
* Exhbition format
* Originally created for SharoneLifschitz.com
* 
* @version 1.1
* @author Vaska 
*/

$DO = new Horizontally;

$exhibit['exhibit'] = $DO->createExhibit();
$exhibit['dyn_css'] = $DO->dynamicCSS();

class Horizontally
{
	// PADDING AND TEXT WIDTH ADJUSTMENTS UP HERE!!!
	var $picture_block_padding_right = 10;
	var $text_width = 400;
	var $text_padding_right = 20;
	var $final_img_container = 0; // do not adjust this one
	
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

		if (!$pages) return $rs['content'];
	
		$s = ''; $a = ''; $w = 0;
		$this->final_img_container = ($rs['content'] != '') ? ($this->text_padding_right + $this->text_width) : 0;

		foreach ($pages as $go)
		{
			$title='';
			if($go['media_title']){$title = ($go['media_title'] == '') ? '' : "<span class='title'>" . $go['media_title'] . "</span>";}
			if($go['media_caption']){$title .= ($go['media_caption'] == '') ? '' : "<span class='caption'>" . $go['media_caption'] . "</span>";}
		
			$temp_x = $go['media_x'] + $this->picture_block_padding_right;
			$this->final_img_container += ($go['media_x'] + $this->picture_block_padding_right);
			$a .= "<div class='picture_holder' style='width: {$temp_x}px;'>\n";
			$a .= "<div class='one-box picture' style='width: {$go['media_x']}px;'>\n";
			$a .= "<a><img src='" . BASEURL . GIMGS . "/$go[media_file]' width='$go[media_x]' height='$go[media_y]' alt='" . BASEURL . GIMGS . "/$go[media_file]' />\n";
			if($title){$a .= "<span class='caption-box'>$title</span></a>\n";}
			$a .= "</div>\n";
			$a .= "</div>\n\n";
		}

		$s .= "<div id='img-container'>\n";
		if ($rs['content'] != '') $s .= "<div id='text'>" . '<h2>'.$rs['title'].'</h2>'. $rs['content'] . "</div>\n";
		$s .= $a;
		$s .= "<div style='clear: left;'></div>";
		$s .= "</div>\n";
		
		return $s;
	}


	function dynamicCSS()
	{
		return "#img-container { width: " . ($this->final_img_container + 1) . "px; }
		#img-container #text { float: left; width: " . ($this->text_width + $this->text_padding_right) . "px; }
		#img-container .picture_holder { float: left; }";
	}
}