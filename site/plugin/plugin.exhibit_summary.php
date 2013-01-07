<?php if (!defined('SITE')) exit('No direct script access allowed');
/**
* exhibit summary
*
* Plugin
* 
* @version" 2.1
* @author: James Dodd
*
* @revision notes: now with the ability to specify picture sizes, order, display titles, text, 
*
*
**/

function exhibit_summary($cat=false, $pics=5, $picsize='', $title='true', $text='true', $order='ord ASC', $pic_order='false', $limit='false', $exclude='false', $showonly='false', $ran='false', $title_ad='false', $titlewrap='h2')
{

		
		$OBJ =& get_instance();
		global $rs;
		
		$ttl=$a=$querycriteria='';
		
		if(!$order || $order='false'){$order='ord ASC';}
		if($pic_order=='false'){$pic_order='media_order ASC, media_id ASC';}

		if($exclude!='false'){
			$exclude=explode('%', $exclude);
			$querycriteria.=' AND id NOT IN ('.implode(',', $exclude).')';	
		}
		if($showonly!='false'){
			$querycriteria.=' AND id = '.$showonly;	
		}		
		if($title_ad=='false'){
			$title_ad='';
		}
		if($limit!='false'){
			$limit='';
		}
		else{
			$limit='LIMIT BY '.$limit;	
		}
				
		$exhibits = $OBJ->db->fetchArray($query="SELECT * 
			FROM ".PX."objects
			WHERE section_id=".$cat."
			AND status=1 
			$querycriteria
			ORDER BY $order
			$limit");
		
		if($ran!='false'){
			if($exhibits){
				foreach($exhibits as $go){
					$ids[]=$go['id'];	
				}	
				$ran=$ids[rand(0, count($ids)-1)];
			}
		}


		if (!$exhibits) return false;
		$i=0;
		foreach ($exhibits as $go)
		{
			if($ran==$go['id'] || $ran=='false'){
				$pictures = $OBJ->db->fetchArray($query="
				SELECT * 
				FROM ".PX."media
				WHERE media_ref_id = ".$go['id']."
				AND media_obj_type = 'exhibit' 
				ORDER BY $pic_order
				LIMIT $pics");

				$p='';
				if(!MODREWRITE){$mod_rew='/index.php?';}
								
				if($pictures){
					foreach($pictures as $pic){
						$p.='<img class="'.$picsize.'" src="'.BASEURL.GIMGS.'/'.$picsize.$pic['media_file'].'" alt="'.$pic['media_caption'].'"/>';	
					}
				}
				
				if($text=='true'){$tx=substr($go['content'], 0, 150).'...';}
				if($title=='true'){$ttl='<'.$titlewrap.'>'.$title_ad.$go['title'].'</'.$titlewrap.'>';}
				
				
				if($i & 1){
					$oe='even';					
				}
				else{
					$oe='odd';
				}
				
				$a .= '
				<div class="gallery_summary one-box content '.$oe.' set'.($i+1).'">
					'.$ttl.'
					<div><a href="'.BASEURL.$mod_rew.$go['url'].'"  title="click to view '.$go['title'].'">'.$p.'</a></div>
					<p>'.$tx.'</p>
					<p><a href="'.BASEURL.$mod_rew.$go['url'].'"  title="click to view '.$go['title'].'">View: '.$go['title'].'</a></p>
				</div>';
			}
			$i++;
		}
		
		
		return $a;	
	

}


?>