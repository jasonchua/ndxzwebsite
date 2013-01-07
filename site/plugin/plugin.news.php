<?php if (!defined('SITE')) exit('No direct script access allowed');
/**
* include_subpages
*
* Plugin
* 
* @version" 2.0
* @author: James Dodd
*
* @revision notes: now with the ability to specify picture sizes, order, display titles, text, 
*
*
**/

function news($cat=false, $imgs=false	)
{
		$OBJ =& get_instance();
		global $rs;
		
		$exhibits = $OBJ->db->fetchArray($query="SELECT * 
			FROM ".PX."objects
			WHERE section_id=".$cat."
			AND status=1 
			ORDER BY ord ASC");


		if (!$exhibits) return $s;
		$i=0;
		foreach ($exhibits as $go)
		{
			$pictures = $OBJ->db->fetchArray($query="
			SELECT * 
			FROM ".PX."media
			WHERE media_ref_id = ".$go['id']."
			AND media_obj_type = 'exhibit' 
			ORDER BY media_order ASC, media_id ASC
			LIMIT 1");
			
						
			if($i & 1){
				$oe='even';					
			}
			else{
				$oe='odd';
			}

			if($imgs){$pic='<div class="pic"><a href="'.BASEURL.GIMGS.'/'.$pictures[0]['media_file'].'" class="thickbox" rel="gallery-testimonials"><img src="'.BASEURL.GIMGS.'/'.'th-'.$pictures[0]['media_file'].'"/></a></div>';}

			$a .= '
			<div class="news '.$oe.'">
				<div class="by"><h3><a href="'.BASEURL.$go['url'].'">'.$go['title'].' - '.$go['pdate'].'</a></h3></div>
				'.$pic.'
				<div class="quote">'.word_limit($go, 30).'</div>
			</div>';
						
			$i++;
		}
		
		return $a;	
	

}

function word_limit($go, $limit=40){
	$words=explode(' ', $go['content']);
	for($i=0; $i<$limit; $i++){
		$return[]=$words[$i];	
	}
	$return[]='...';
	return closetags(implode($return, ' ')). '<a href="'.BASEURL.$go['url'].'">READ THE REST</a>';
}


function closetags ( $html )
{
    #put all opened tags into an array
    preg_match_all ( "#<([a-z]+)( .*)?(?!/)>#iU", $html, $result );
    $openedtags = $result[1];
 
    #put all closed tags into an array
    preg_match_all ( "#</([a-z]+)>#iU", $html, $result );
    $closedtags = $result[1];
    $len_opened = count ( $openedtags );
    # all tags are closed
    if( count ( $closedtags ) == $len_opened )
    {
        return $html;
    }
    $openedtags = array_reverse ( $openedtags );
    # close tags
    for( $i = 0; $i < $len_opened; $i++ )
    {
        if ( !in_array ( $openedtags[$i], $closedtags ) )
        {
            $html .= "</" . $openedtags[$i] . ">";
        }
        else
        {
            unset ( $closedtags[array_search ( $openedtags[$i], $closedtags)] );
        }
    }
    return $html;
}

?>