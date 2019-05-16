<script type="text/javascript">
$(document).ready(function(){ 
						   
	$(function() {
		/*
		$("#dashboarddrag ul").sortable({ cancel: ".bgwhite,select",  opacity: 0.6, cursor: 'move', update: function() {
			var order = $(this).sortable("serialize") + '&action=updateBlockListing';
			
			$.post("../ajax.php", order, function(theResponse){
				$("#contentRight").html(theResponse);
			}); 															 
		    }								  
		});
		*/



		$(".blockclose").on("click", function () { 
			var row = $(this).closest("li");
			var id = row.attr('id');
			row.hide(800);

			var sendParam = 'id='+id+'&action=removeBlock';
			$.post("../ajax.php", sendParam, function(theResponse){
				//alert(theResponse);
			});		  
		});



	
		$('#dashboarddrag .dragul .dragli').resizable({			
			stop: function(e, ui) {
				var id = $(this).attr('id');
				var liwidth = $(this).width();
				var liheight = $(this).height();
				var htt = liheight - 50;
				$('.bgwhite', this).height(htt+'px');
				var sendParam = 'id='+id+'&Width='+liwidth+'&Height='+liheight+'&action=resizeBlock';
				$.post("../ajax.php", sendParam, function(theResponse){
					//alert(theResponse);
				});
			}
		});



		/********************/
		$('#dashboarddrag .dragul .dragli').draggable({			
			stop: function(e, ui) {
				var id = $(this).attr('id');

				var litop = parseInt($(this).css('top')); 
				var lileft = parseInt($(this).css('left')); 	
			
				var sendParam = 'id='+id+'&Top='+litop+'&Left='+lileft+'&action=dragBlock';
				//alert(sendParam);
				$.post("../ajax.php", sendParam, function(theResponse){
					//alert(theResponse);
				});
			}
		});
		/********************/

		

	});




});




function UpdateUserscreen(){
	var sendParam = '&action=AddDefaultScreen';

	$('.redmsg').html("Processing....");

		
        $.post("../ajax.php", sendParam, function(theResponse){
		
		var msg = ''; var btntitle = '';
		if(theResponse==1){
			msg = 'You have successfully selected workspace as default screen.';
			btntitle = 'Change to Default View';
			
		}else{
			msg = 'You have successfully changed to default view.';
			btntitle = 'Make as Default Screen';
		}

		$('.redmsg').html(msg);
		//$('#SubmitDf').val(btntitle);
		$('#SubmitDf').html(btntitle);
	}); 	
	
			
}
	
</script>

<div class="main-container clearfix">
    <div class="main">
	
      <!--div class="my-dashboard-nav clearfix" style="width:94%"-->
	

<? //include("../includes/html/box/clock.php");
   //include("../includes/html/box/icon.php");

$arryDefaultScreen = $objConfig->getDefaultScreen();
if($arryDefaultScreen[0]['Status']==1){
	$ButtonTitle="Change to Default View";
}else{
	$ButtonTitle="Make as Default Screen";	
}
		

$addBlock = '<img src="../images/add.gif" border="0"  onMouseover="ddrivetip(\'<center>Add Block To Dashboard</center>\', 150,\'\')"; onMouseout="hideddrivetip()" >';
?>
    

  
      <!--/div-->
      

<link href="../includes/drag.css" rel="stylesheet" type="text/css">

<div align="center" class="redmsg" ></div>

<div align="center" id="homeload"><img src="../images/load.gif"></div>

<div class="my-dashboard clearfix" style="margin:auto;width: 100%;">

<div class="addBlockIcon"><a class="fancybox add fancybox.iframe" href="addBlock.php">Add Block</a>

<a onclick="javascript:UpdateUserscreen();" class="btn" href="javascript:void(0);" name="SubmitDf" id="SubmitDf"><?=$ButtonTitle?></a>

<!--input name="SubmitDf" id="SubmitDf" onclick="javascript:UpdateUserscreen();" type="button" class="button" value="<?=$ButtonTitle?>" -->


</div>


  <h4 class="had" style="height:30px;">My Workspace</h4>


<div id="dashboarddrag" style="display:none2;margin: 0 auto;" >
	<ul class="dragul">
<?php
$scrollStyle='';
/*****************************/
$numBlock = $objConfig->countBlockRows();
if($numBlock<=0){
	$objConfig->moveDefaultBlocks();
}
$arryBlock = $objConfig->getBlockRows(1);
/****************************/
foreach($arryBlock as $keyBlock=>$valueBlock){ 
	include("includes/html/box/block_condition.php");
	/**************/
	if($ShowBlock==1){

		$liStyle = ''; $scrollStyle = '';
		if($valueBlock['Left']!=''){
			 $liStyle .= 'Left:'.$valueBlock['Left'].'px;'; 
			 
		}
		if($valueBlock['Top']!=''){
			 $liStyle .= 'Top:'.$valueBlock['Top'].'px;'; 
			 
		}
		if(!empty($valueBlock['Width'])){
			 $liStyle .= 'width:'.$valueBlock['Width'].'px;'; 
			 
		}
		if(!empty($valueBlock['Height'])){ 
			$liStyle .= 'height:'.$valueBlock['Height'].'px;'; 
			$scrollStyle .= 'height:'.($valueBlock['Height']-50).'px;'; 
		}

		$BlockHeading = stripslashes($valueBlock['BlockHeading']);
		echo '<li id="recordsArray_'.$valueBlock['id'].'" class="dragli block'.$valueBlock['BlockID'].'" style="'.$liStyle.'">';
		echo '<img src="../images/cross.png" border="0" class="blockclose" title="Remove">';
		 $BlockInc = $BlockPrefix."includes/html/box/".$valueBlock['Block'];
		include($BlockInc);
		echo '</li>';
	}
	/**************/
}


 ?>

	</ul>
</div>

        
      
</div>




    </div>
  </div>

<script language="javascript1.2" type="text/javascript">
$(document).ready(function(){
	$('#dashboarddrag').show();
	$('#homeload').hide();
	$('.block h3').attr('title', 'Drag to move position');

	
	$(".add").fancybox({
		'width'         : 900
	});

});
</script>
  


