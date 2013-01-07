<?php if (!defined('SITE')) exit('No direct script access allowed');

/**
* Slideshow
*
* Exhibition format
* 
* @version 1.0.0.0.0.0.0.0.0.0.1 (Because Simon ate a banana for lunch)
* @author Simon Lagneaux 
* @author Vaska
*/



$exhibit['exhibit'] = createExhibit();

function createExhibit()
{
	$OBJ =& get_instance();
	global $rs;
	

	$thumbs='';

	$thumbs_text='Thumbnails';
	$info_text='Info';
	$next_text='Next';
	$prev_text='Prev';


	$req=explode('/', str_replace('/index.php?', '', $_SERVER['REQUEST_URI']));
	$req=$req[4];

	if(is_numeric($req)){
		$limit="LIMIT ".($req-1).", 1";
		$ext='';
	}
	elseif($req=='thumbs'){
		$ext='sys-';
		$limit='';
		$thumbs='./';
	}
	else{
		$ext='';
		$limit="LIMIT 0, 1";	
	}
		
	$max = $OBJ->db->fetchArray($query="
		SELECT count(*) as 'photos'
		FROM ".PX."media, ".PX."objects_prefs 
		WHERE media_ref_id = '$rs[id]' 
		AND obj_ref_type = 'exhibit' 
		AND obj_ref_type = media_obj_type 
		GROUP BY media_ref_id
		ORDER BY media_order ASC, media_id ASC"
	);
		
	$pages = $OBJ->db->fetchArray($query="SELECT * 
		FROM ".PX."media, ".PX."objects_prefs 
		WHERE media_ref_id = '$rs[id]' 
		AND obj_ref_type = 'exhibit' 
		AND obj_ref_type = media_obj_type 
		ORDER BY media_order ASC, media_id ASC
		".$limit);
	
	
	if($rs['content']){
		// ** DON'T FORGET THE TEXT ** //
		if($req==0 && $req!='thumbs'){$s .= '<div id="exhibit_title"><h2>'.$rs['title'].'</h2></div>'.'<div id="content_desc">'.$rs['content'].'</div>';}
	}
	elseif($req==0 && $req!='thumbs'){
		header('location: 1');	
	}
	
	if (!$pages) return $s;
	
		$i = 1; $a = '';
	
	// people will probably want to customize this up
	foreach ($pages as $go)
	{
	    $title 		= ($go['media_title'] == '') ? '' : $go['media_title'] . '&nbsp;';
	    $caption 	= ($go['media_caption'] == '') ? '&nbsp;' : $go['media_caption'];

		//$x = getimagesize(BASEURL . GIMGS . '/' . $go['media_file']);
		if($thumbs){$a .= "\n<a href='".($i)."'><img src='" . BASEURL . GIMGS . "/$ext$go[media_file]'/></a>\n";}
		else{$a .= "\n<img src='" . BASEURL . GIMGS . "/$ext$go[media_file]' class='slideshow'/><div id='pic_caption'><div id='caption_title'>{$title}</div><div id='caption_body'>{$caption}</div></div>\n";}
		$i++;
	}
	
	$s .= "<div id='paging_links'>";
	
		$s .="<a id='info' href='./'><span>$info_text</span></a>";
		$s .="<a id='thumbs' href='thumbs'><span>$thumbs_text</span></a>";
		if(($req!=0) && (($req==1 && $rs['content']) || $req>1)){$s .= "<a id='prev' href='./'><span>$prev_text</span></a>";}
		else{$s .= "<a id='prev' href='#' class='done'><span>$prev_text</span></a>";}
		if($req!=$max[0]['photos']){$s .= "<a id='next' href='".($req+1)."'><span>$next_text</span></a>";}
		else{$s .= "<a id='next' href='#' class='done'><span>$next_text</span></a>";}
	
	$s .= "</div>\n\n";

	if($req!=0 || $req=='thumbs'){	
		// images
		$s .= "<div id='img-container'>\n";
		$s .= "<div>\n";
		$s .= $a;
		$s .= "</div>\n";
		$s .= "</div>\n\n";
	}	
	
	return $s;
}



?>