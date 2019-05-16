<?  ob_start();
	session_start();

	$ImagePath = $_GET['img']; 

	if($_GET['LastHeaderBg']>0){
		$ImagePath = "templates/temp/".$_SESSION['LastHeaderBg'];
	}

	if($_GET['LastHeaderLogo']>0){
		$ImagePath = "templates/temp/".$_SESSION['LastHeaderLogo'];
	}
	if($_GET['LastBodyBg']>0){
		$ImagePath = "templates/temp/".$_SESSION['LastBodyBgImage'];
	}
	if($_GET['LastBanner']>0){
		$ImagePath = "templates/temp/".$_SESSION['LastBanner'];
	}  
  ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Larger View</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="javascript"><!--
var i=0;
function resize() {
  if (navigator.appName == 'Netscape') i=40;
  if (document.images[0]) window.resizeTo(document.images[0].width +100, document.images[0].height+130-i);
  self.focus();
}
//--></script>
<script language="JavaScript" type="text/javascript">
window.focus();

    //window.moveTo( 0, 0 );
    //var width  = window.screen.availWidth;
    //var height = window.screen.availHeight;
   // window.resizeTo( width, height );

</script>
</head>

<body onload="resize();">
<img src='<? echo $ImagePath;?>'>
</body>
</html>
