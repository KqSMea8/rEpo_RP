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
        e.stopPropagation();
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


function getDepartmentByids(){
ShowHideLoader('1','L');
	var dep = $("#Department").val();
	   
	  window.parent.location.href = "?depID="+dep;
	
}
</script>

<style type="text/css">
/* an overlayed element */
.overlay {
  width: 165px;
  display: inline-block;
  background: #fff url("/media/img/demos/playlist/thumbs.jpg") no-repeat;
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
}
#overlay2 {
  background-position: -197px -1px;
}
#overlay3 {
  background-position: -393px -1px;
}
#overlay4 {
  background-position: -589px -1px;
}
.fp-ratio {
    padding-top: 56% !important;
}
body.is-overlayed {
  overflow: hidden;
}
</style>



<div class="had">Manage Help</div>

<div class="drop-dep">
	 <select name="Department" class="inputbox" method="get" id="Department" onchange="getDepartmentByids();">
	  <option value=""> --- Select Department ---</option>
			 <?php foreach($arrayDepartment as $Departmentvalues) { ?> 
			 <option value="<?=$Departmentvalues['depID']?>" <? if($Departmentvalues['depID']==$_GET['depID']){ echo "selected='selected'";}?>><?php echo stripslashes($Departmentvalues['Department']);?> </option>  
		     <?php } ?>
    
   </select>
</div>


<div class="message" align="center"><? if(!empty($_SESSION['mess_help'])) {echo $_SESSION['mess_help']; unset($_SESSION['mess_help']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

	<tr>
        <td align="right" >
	

			

		</td>
      </tr>

	<tr>
        <td align="right" >
		
		<? if($_GET['key']!='') {?>
		  <input type="button" class="view_button"  name="view" value="View All" onclick="Javascript:window.location='viewHelp.php';" />
		<? }?>		

		<a href="editHelp.php?depID=<?=$_GET['depID']?>" class="add">Add Help</a>
		</td>
      </tr>
	<tr>
	  <td  valign="top">
	  
	
<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">

<table <?=$table_bg?>>
   
    <tr align="left"  >
     <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','WsID','<?=sizeof($arryHelp)?>');" /></td>-->
       <td width="15%"  class="head1" >Heading</td>
      <td width="10%"  class="head1" >Category</td>
       <td width="15%" class="head1" align="center">Document</td>
        <td width="15%" class="head1" align="center" >Video Link</td>
      <td width="6%"  align="center" class="head1" >Status</td>
      <td width="6%"  align="center" class="head1" >Action</td>
    </tr>
   
    <?php 
///echo "<pre>";print_r($arryHelp);

  if(is_array($arryHelp) && $num>0){
  	$flag=true;
	$Line=0;
	//$MainDirVideo = "../upload/help/video/";
	//$MainDir = "../upload/help/document/";	
  	foreach($arryHelp as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?("#FDFBFB"):("");
	$Line++;
	
	//echo "<pre>";print_r($values);

  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
          
      <td height="50" >
	  <a href="editHelp.php?edit=<?=$values['WsID']?>&curP=<?=$_GET['curP']?>" ><strong><?=stripslashes($values["Heading"])?></strong></a> 

	 </td>
		  

<td><?=$values["CategoryName"]?></td>
<td align="center">

<?
if(IsFileExist($Config['HelpDoc'],$values['UploadDoc']) ){ ?>
	 
<a href="download.php?file=<?=$values['UploadDoc']?>&folder=<?=$Config['HelpDoc']?>" title="<?=$values['UploadDoc']?>" class="download">Download</a>

<? } else {	
	 
	echo NOT_UPLOADED;
}

?>

 
</td>  
<td align="center">

<? /*if($values['Videolink'] !='' && file_exists($MainDirVideo.$values['Videolink']) ){
	$DocExist=1;
	?>
	<div id="overlay1" class="overlay">
   <!-- splash setup required because player must be unloaded on hide -->
   <div data-ratio="1"
        class="flowplayer is-splash no-volume no-mute aside-time  functional">
      <span class="close">close</span>
 
   <video>
    <source type="video/mp4" src="<?php echo $MainDirVideo.$values['Videolink']?>">
   </video>
   </div>
</div>
	
    <? } else {	
	$DocExist=0;
	echo NOT_UPLOADED;
	}*/
 
if(IsFileExist($Config['HelpVedio'],$values['Videolink']) ){ 
$VideoUrl = GetFileInfo($Config['HelpVedio'],$values['Videolink']);
?>
 

<a href="<?php echo $VideoUrl[2];?>" title="<?=$values['UploadDoc']?>" target="_blank"><img src="../admin/images/vid.png" width="40" border="0"></a>

<!--div id="overlay1" class="overlay">
 
   <div data-ratio="1"
        class="flowplayer is-splash no-volume no-mute aside-time  functional">
      <span class="close">close</span>
 
   <video>
    <source type="video/mp4" src="<?php echo $Config['FileUploadUrl'].$Config['HelpVedio'].$values['Videolink'];?>">
   </video>
   </div>
</div-->



<? } else {	
	 
	echo NOT_UPLOADED;
}

?>


</td> 

    <td align="center"><? 
		 if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }
	
	 

	echo '<a href="editHelp.php?active_id='.$values["WsID"].'&depID='.$_GET["depID"].'" class="'.$status.'">'.$status.'</a>';
		
	 ?></td>
      <td  align="center"  class="head1_inner"><a href="editHelp.php?edit=<?=$values['WsID']?>&curP=<?=$_GET['curP']?>" ><?=$edit?></a>
	  
	<a href="editHelp.php?del_id=<?php echo $values['WsID'];?>&amp;depID=<?php echo $_GET['depID'];?>" onclick="return confDel('Help')"   ><?=$delete?></a>   



</td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="9" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="9" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryHelp)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

  </div> 
 
  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
   <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
</form>
</td>
	</tr>
</table>

