<!DOCTYPE html>
<html>
<head>
	<title>fancyBox - Fancy jQuery Lightbox Alternative | Demonstration</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

	<script type="text/javascript" src="fancybox/lib/jquery-1.10.1.min.js"></script>
	<script type="text/javascript" src="fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
	<link rel="stylesheet" type="text/css" href="fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />


	<script type="text/javascript">
		$(document).ready(function() {
			$('.fancybox').fancybox();
		});
	</script>
	
</head>
<body>

	<a class="fancybox" href="images/nouser.jpg" data-fancybox-group="gallery" title="Lorem ipsum dolor sit amet"><img src="images/nouser.jpg" alt="" /></a>
	<a class="fancybox" href="images/closelabel.gif" data-fancybox-group="gallery" title="Etiam quis mi eu elit temp"><img src="images/closelabel.gif" alt="" /></a>

<a class="fancybox fancybox.iframe" href="iframe.html">Iframe</a>

	

</body>
</html>