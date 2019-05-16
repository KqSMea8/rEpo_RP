<!-- a player skin as usual -->
<link rel="stylesheet" href="http://releases.flowplayer.org/6.0.2/skin/minimalist.css">
<!-- the quality selector stylesheet -->
<link rel="stylesheet" href="http://flowplayer.org/drive/quality-selector.css">
 
<!-- ... -->
<script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
<!-- the Flowplayer script as usual -->
<script src="http://releases.flowplayer.org/6.0.2/flowplayer.min.js"></script>
<!-- the quality selector plugin -->
<script src="http://flowplayer.org/drive/quality-selector-v6.js"></script>
<!-- jQuery Tools -->
<script src="http://cdn.jquerytools.org/1.2.7/all/jquery.tools.min.js"></script>

<script>
//The smallest jQuery Overlay plugin
$.fn.overlay = function() {
 
    var ACTIVE = "is-active";
 
    function toggle(el) {
        $("body").toggleClass("is-overlayed", !!el);
 
        if (el) {
            el.addClass(ACTIVE).trigger("open");
        } else {
            els.filter("." + ACTIVE).removeClass(ACTIVE).trigger("close");
        }
    }
 
    // trigger elements
    var els = this.click(function () {
        toggle($(this));
    });
 
    // esc key
    $(document).keydown(function (e) {
        if (e.which == 27) {
            toggle();
        }
    });
 
    // close
    $(".close", this).click(function (e) {
        toggle();
        e.stopPropagation();Email address eZnet CRM  info@eznetcrm.com
    });
 
    return els;
};
 
// wait until DOM is ready
$(function () {
    // the player will fill the entire overlay
    // so we only need an overlay where inline video is supported
    if (flowplayer.support.inlineVideo) {
 
        // construct overlays
        $(".overlay").overlay().on("close", function() {
 
            // when overlay closes -> unload flowplayer
            flowplayer($(".flowplayer", this)).unload();
 
        });
    }
});
</script>
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
position: relative;
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
</style>
<div id="Help_Desk_info">
<?php 
	$MainDoc=  "../upload/help/document/";
	$MainDirVideo=  "../upload/help/video/";


	$BackUrl =  (!empty($_SERVER['HTTP_REFERER']))?($_SERVER['HTTP_REFERER']):('help.php');



?>
<h2 class="desk-heading"><span><a class="back" href="<?php echo $BackUrl; ?>">Back</a></span></h2>
<div class="wrap_head">
     <div align="left" class="blackbold"><strong><h1>Help Desk</h1></strong></div>
</div>
<h2><?php echo $listContentbyHeading[0]['Heading'];?></h2>
<hr>
<div class="desk-content">

<? if(!empty($listContentbyHeading[0]['VideoUrl'])) { ?>
<div style="float:right"><a href="<?=$listContentbyHeading[0]['VideoUrl']?>"   target="_blank"><img src="images/vid.png" title="Watch Video" width="70" border="0"></a></div>
<? } ?>









<?php echo stripslashes($listContentbyHeading[0]['Content']);?>

</div>

<?

$Config['CmpID'] = $Config['SuperCmpID'];
$document = stripslashes($listContentbyHeading[0]['UploadDoc']);

if(IsFileExist($Config['HelpDoc'],$document) ){

 ?>
<br><br>
<div class="link-dwn"  style="float:left" ><a href="download.php?file=<?=$document?>&folder=<?=$Config['HelpDoc']?>&CmpID=<?=$Config['CmpID']?>" class="download" title="Download Document">Download</a></div>
<? } ?>




<? $Videolink = stripslashes($listContentbyHeading[0]['Videolink']);
 
if(IsFileExist($Config['HelpVedio'],$Videolink) ){

$VideoUrl = GetFileInfo($Config['HelpVedio'],$Videolink);

?>
<br><br><br>
<div align="center">



<a href="<?php echo $VideoUrl[2]; ?>" target="_blank"><img src="images/vid.png" title="Watch Video" width="70" border="0"></a>

<!--div id="overlay1" class="overlay">
 
   <div data-ratio="1"
        class="flowplayer is-splash no-volume no-mute aside-time  functional">
      <span class="close">close</span>
 
   <video>
  <source type="video/mp4" src="<?php echo $videoUrl; ?>">
   </video>
   </div>
</div-->


</div>
<? }

 $Config['CmpID'] = $_SESSION['CmpID'];
 ?>




</div>

<p style="display: none1;" id="back-top">
		<a href="<?php echo $BackUrl; ?>" title="Back"><span id="buttonback"></span><span id="link">Back</span></a>
		<a href="#top" title="Top"><span id="button"></span><span id="link">Back to top</span></a>
		
	</p>




