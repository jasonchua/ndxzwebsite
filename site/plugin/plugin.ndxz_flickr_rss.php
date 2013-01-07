<?php if (!defined('SITE')) exit('No direct script access allowed');

/**
* Flickr rss Plugin
*
* <plug:ndxz_flickr_rss id='YourFlickrID', size='0-4', tag='', caption='0-1', limit='1-20' />
* 
* Size, Tag, Caption and Limit are optional
* -----------------------------------------------------------------------------------------
* Size defaults to medium image size: 500px width
* Square: 0 / Thumb: 1 / Small: 2 / Medium: 3 / Large: 4
* -----------------------------------------------------------------------------------------
* If you want to pull only images with a certain tag then simply set the tag variable.
* Otherwise you'll get the whole stream of your public images.
* -----------------------------------------------------------------------------------------
* If want your image title to show up as a caption underneath the image set caption to 1
* By default it is set to false / no caption
* -----------------------------------------------------------------------------------------
* If you want to limit the output simply set the number of images you want to display
* It defaults to the 20 images the flickr rss feed offers.
* -----------------------------------------------------------------------------------------
* To style the output each image got a surrounding div with the class flickr_photo
* -----------------------------------------------------------------------------------------
* IMPORTANT: THIS PLUGIN WORKS WITH PHP-5 ONLY !!!
* 
* @version 0.5
* @author Oliver / beauty is selfless / www.beautyisselfless.net
* 
* based on this script: http://ennuidesign.com/blog/tag/simplexml/
*
*/


function ndxz_flickr_rss($id, $size=3, $tag=false, $caption=false, $limit=20) {
	//echo "ID: " . $id . "Size: " . $size . "Tag: " . $tag . "Caption: " . $caption . "Limit: " . $limit . "\n";
	$s = array(
        '_s.jpg', // square
        '_t.jpg', // thumb
        '_m.jpg', // small
        '.jpg',   // medium
        '_b.jpg'  // large
		);
	
	$tag=$_GET['tag'];//added to get tag from url
	
	$output = "";
	$count = 0;
	
	$feed = 'http://api.flickr.com/services/feeds/photos_public.gne?lang=de-de&format=rss_200&id=' . $id;
	if($tag) { $feed = $feed . '&tags=' . $tag; }
	$rss = simplexml_load_file($feed);
		
	foreach ($rss->channel->item as $item) {
		$count++;
		$link = $item->link; 							// Link to this photo 
		$title = $item->title; 							// Title of this photo 
      	$media = $item->children('http://search.yahoo.com/mrss/'); 
      	$thumb = $media->thumbnail->attributes(); 

      	$url = $thumb['url']; 							// URL of the thumbnail 
      	$url = str_replace('_s.jpg', $s[$size], $url);
		
		if($caption) {
		$output .= " 
				  <div class='flickr_photo' style='float: left;'>
					<a href='$link'> 
					  <img src='$url' title='$title' alt='$title' /> 
					</a>
					<p>$title</p>
				  </div>";
		} else {
		
		$output .= " 
				  <div class='flickr_photo' style='float: left; margin-right: 10px;'>
					  <img src='$url' title='$title' alt='$title' style='max-height:334px; max-width:500px'/> 
				  </div>";
		}
		if($count >= $limit) { break; }
	}	

	return '<div style="width:'.(510*$count).'px">'.$output.'</div>';
}

?>