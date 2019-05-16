<script type="text/javascript" src="../js/scroll_to_top.js"></script>
<link href="../css/scroll_to_top.css" rel="stylesheet" type="text/css">
<style type="text/css">

.wrap_head {
    border-bottom: 1px solid #f4af1a;
    margin-bottom: 10px;
}
.desk-heading {
    margin: 0;
}

/* an overlayed element */
.overlay {
  width: 680px;
  display: inline-block;
  background: none repeat scroll 0 0 #000;
  cursor: pointer;
  margin: 0 1% 2% 0;
  -webkit-border-radius: 3px;
  -moz-border-radius: 3px;
  border-radius: 3px;
}
.overlay .close,
.overlay.is-fullscreen .close {
  display: none;
  position: absolute;
  top: 0;
  right: -4em;
  margin: 3px;
  color: #eee !important;
  font-weight: bold;
  cursor: pointer;
}
.overlay .is-splash .fp-ui {
  -webkit-background-size: 25%;
  -moz-background-size: 25%;
  background-size: 25%;
}
.overlay.is-active {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  text-align: center;
  z-index: 100;
  background-color: rgba(0,0,0,0.8);
  background: -webkit-radial-gradient(50% 50%, ellipse closest-corner, rgba(0,0,0,0.5) 1%, rgba(0,0,0,0.8) 100%);
  background: -moz-radial-gradient(50% 50%, ellipse closest-corner, rgba(0,0,0,0.5) 1%, rgba(0,0,0,0.8) 100%);
  background: -ms-radial-gradient(50% 50%, ellipse closest-corner, rgba(0,0,0,0.5) 1%, rgba(0,0,0,0.8) 100%);
  cursor: default;
}
.overlay.is-active .flowplayer {
  margin-top: 100px;
  width: 50%;
  background-color: #111;
  -webkit-box-shadow: 0 0 30px #000;
  -moz-box-shadow: 0 0 30px #000;
  box-shadow: 0 0 30px #000;
}
.overlay.is-active .close {
  display: block;
}
.overlay.is-active .close:hover {
  text-decoration: underline;
}
#overlay1 {
      background-position: -1px -1px;
    display: table;
    margin-top: 10px;
}
.fp-ratio {
    padding-top: 55% !important;
}
body.is-overlayed {
  overflow: hidden;
}
#Help_Desk_info {
    background: none repeat scroll 0 0 #fff;
   height:500px;
    border-radius: 6px;
    display: table;
    padding: 20px;
    width: 94.5%;
}
hr {
   
    margin: 16.8269px 0;
    border:1px solid #dcdcdc;
}
.link-dwn .download {
    vertical-align: top;
}
.link-dwn {
    border: 1px solid #535353;
    border-radius: 6px;
    float: right;
    margin: 0 0 0 10px;
    padding: 10px;
    text-align: center;
}
#notification_detail_right {
    margin: -10px 0 0 0;
	float:right;
}
</style>
<div id="Help_Desk_info">
  <h2 class="desk-heading"><span><a class="back" href="allNotificationList.php">Back</a></span></h2>
<!--div class="wrap_head">
     <div align="left" class="blackbold"><strong><h1>Notification Detail</h1></strong></div>
</div-->
<h2><?php echo stripslashes($arryvnotification[0]['Heading']);?></h2>

<hr>
    <div align="left" class="blackbold" id="notification_detail_left"><h5><?=($arryvnotification[0]['Date']>0)?(date($Config['DateFormat'], strtotime($arryvnotification[0]['Date']))):('')?></h5></div>
    <div  id="notification_detail_right"><? 
 	 $Config['CmpID'] = $Config['SuperCmpID'];
	 if(IsFileExist($Config['NotificationDir'],$arryvnotification[0]['Image'])){   
		$PreviewArray['Folder'] = $Config['NotificationDir'];
		$PreviewArray['FileName'] = $arryvnotification[0]['Image'];
		$PreviewArray['FileTitle'] = stripslashes($arryvnotification[0]['Heading']);
		$PreviewArray['Width'] = "80";
		$PreviewArray['Height'] = "80"; 
		$PreviewArray['Link'] = "1"; 
		echo PreviewImage($PreviewArray); 			
	}
	$Config['CmpID'] = $_SESSION['CmpID'];

			?></div>
<div class="desk-content">
<br><br>
<?php echo stripslashes($arryvnotification[0]['Detail']); ?>
 <input type="hidden" name="notificationId" id="notificationId" value="<?php echo $arryvnotification[0]['NotificationId']?>">


</div>

</div>

<p style="display: none1;" id="back-top">
		<a href="#top" title="Top"><span id="button"></span><span id="link">Back to top</span></a>
		
	</p>


