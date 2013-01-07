
 
 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
 
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='en' lang='en'> 
<head> 
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'/> 
 
<title>Jason Chua</title> 
 
<link rel='stylesheet' href='<%baseurl%><%basename%>/site/<%obj_theme%>/style.css' type='text/css' /> 
<!--[if lte IE 6]>
<link rel='stylesheet' href='<%baseurl%><%basename%>/site/<%obj_theme%>/style.css' type='text/css' />
<![endif]--> 
 
<style type='text/css'> 
.backgrounded { margin-right: 1px; }
	.backgrounded a { border: none; }
	.backgrounded a img { border: 3px solid #fff; height: 25px; width: 25px; }
	.backgrounded-text { margin-top: 9px; }
</style> 
 
<script type='text/javascript' src='<%baseurl%><%basename%>/site/js/jquery.js'></script> 
<script type='text/javascript' src='<%baseurl%><%basename%>/site/js/cookie.js'></script> 
<script type='text/javascript' src='<%baseurl%><%basename%>/site/js/expandingMenus.js'></script> 
<script type="text/javascript" src='<%baseurl%><%basename%>/site/js/full_background.js'></script>
 
 
<script type='text/javascript'> 
path = '<%baseurl%>/files/gimgs/';
 
$(document).ready(function()
{
setTimeout('move_up()', 1);
 
initializeAllMenus();
 
 
});
 
</script> 
<script type='text/javascript'> 
function swapImg(a, image)
	{
		var the_path = '<%baseurl%>/files/gimgs/' + image;
		show = new Image;
		show.src = the_path;
		$('body').css({ backgroundImage: 'url(' + show.src + ')', backgroundPosition: '215px 0'  });
 
		var title = $('#img' + a).attr('title');
		var caption = $('#img' + a).attr('alt');
		
		if (title != 'N/A') 
		{
			caption = (caption != 'N/A') ? ': ' + caption : '';
			$('#backgrounded-text').html('<span style="background: white; line-height: 24px;">' + title + caption + '</span>');
		}
		else
		{
			$('#backgrounded-text').html('');
		}
	}
</script> 
 
 
<!-- call Full-Screen-Background... --> 
<script type='text/javascript' src='<%baseurl%>/ndxz-studio/site/js/full_background.js'></script> 
</head> 
 
 
<body class='section-1'> 
<!-- this div is needed for Full-Screen-Background. It points to the images.. -->	
<div id='the-background'><img src='<%baseurl%>/files/backgroundimg/treeflag.jpg' width='' height='' alt=''/> 
</div><!-- for a custom folder, change "bgbig" to whatever folder url you want to use! --> 
<div id='wrapper'> 
<div id='menu'> 
<div class='container'> 
 
 
<p> </p> 

<style type='text/css'>
#img-container p { margin-bottom: 18px; }
#img-container p span { line-height: 18px; }
</style>

<script type='text/javascript' src='http://www.kjetildjuve.com/ndxz-studio/site/js/jquery.js'></script>
<script type='text/javascript' src='http://www.kjetildjuve.com/ndxz-studio/site/js/cookie.js'></script> 
<script type='text/javascript' src='http://www.kjetildjuve.com/ndxz-studio/site/js/css_switch.js'></script>
<script type='text/javascript' src='http://www.kjetildjuve.com/ndxz-studio/site/js/full_background.js'></script>
<script type='text/javascript' src='http://www.kjetildjuve.com/ndxz-studio/site/js/expandingMenus.js'></script>

<script type='text/javascript'>
path = 'http://www.kjetildjuve.com/files/gimgs/';

$(document).ready(function()
{
    setTimeout('move_up()', 1);
    expandingMenu(0);
    expandingMenu(1);
    expandingMenu(2);
    expandingMenu(3);
    expandingMenu(4);
    expandingMenu(5);
    expandingMenu(6);
    expandingMenu(7);
    expandingMenu(8);
    expandingMenu(9);
});
</script>



</head>

<body class='section-1'>
<div id="wrapper">
<div id='menu'>
<div class='container'>

<div class="logo"><a href="http://www.kjetildjuve.com" class="logoswitch"><span class="hidethis">This is a button</span></a></div>
<ul>

</head> 
 
<body class='section-<%section_id%>'>
<div id='menu'>
<div class='container'>

<%obj_itop%>
<plug:front_index />
<%obj_ibot%>

</div>	
</div>	

<div id='content'>
<div class='container'>

<!-- text and image -->
<plug:front_exhibit />
<!-- end text and image -->

</div>
</div>

 
<p><a href='http://www.jchua.com'>*switch background image*</a></p> 
 
</div>	
</div>	
 
<div id='content'> 
<div class='container'> 
 
<!-- text and image --> 
 
<div class='cl'><!-- --></div> 
 
<!-- end text and image --> 
 
</div> 
</div> 
</div> 
//<div id='footer'> 
   ©<a href='mailto:jason@gjchua.com'> Jason Chua</a> 201  | Built with  <a href='http://www.indexhibit.org/'>Indexhibit</a>
   </div> 
</div> 
 
</body> 
</html> 