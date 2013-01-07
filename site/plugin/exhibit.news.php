<?php if (!defined('SITE')) exit('No direct script access allowed');

$exhibit['exhibit'] = newsContent();

function newsContent()
{
	$OBJ =& get_instance();
	global $rs, $exhibit, $disqus;

	$disqus='deadphotographers';

	$pages = $OBJ->db->fetchArray("SELECT * 
		FROM ".PX."media, ".PX."objects_prefs, ".PX."objects  
		WHERE media_ref_id = '$rs[id]' 
		AND obj_ref_type = 'exhibit' 
		AND obj_ref_type = media_obj_type 
		AND id = '$rs[id]' 
		ORDER BY media_order ASC, media_id ASC");
	

	// ** DON'T FORGET THE TEXT ** //
	
	$s .= '<h2>'.$rs['title'].' - '.$rs['pdate'].'</h2>';
	$s .= '<div class="news">'.$rs['content'].'</div>';

	if($disqus){
	$s .= '
	<div id="disqus_thread" style="width: 500px;"></div>
	<script type="text/javascript">
	    /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
	    var disqus_shortname = \''.$disqus.'\'; // required: replace example with your forum shortname
	
	    // The following are highly recommended additional parameters. Remove the slashes in front to use.
	    var disqus_identifier = \''.$disqus.'\';
	    var disqus_url = \''.BASEURL.$rs['url'].'\';
	
	    /* * * DON\'T EDIT BELOW THIS LINE * * */
	    (function() {
	        var dsq = document.createElement(\'script\'); dsq.type = \'text/javascript\'; dsq.async = true;
	        dsq.src = \'http://\' + disqus_shortname + \'.disqus.com/embed.js\';
	        (document.getElementsByTagName(\'head\')[0] || document.getElementsByTagName(\'body\')[0]).appendChild(dsq);
	    })();
	</script>
	<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
	<a href="http://disqus.com" class="dsq-brlink">blog comments powered by <span class="logo-disqus">Disqus</span></a>';
	}
	$s .= '<div style="margin: 40px 0;"><h3><a href="'.BASEURL.'/news">BACK TO NEWS</a></h3></div>';
	return $s;
}


?>