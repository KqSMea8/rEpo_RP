<script type="text/javascript">
$(document).ready(function(){ 
						   
	$(function() {
		$("#dashboarddrag ul").sortable({ cancel: ".bgwhite,select",  opacity: 0.6, cursor: 'move', update: function() {
			var order = $(this).sortable("serialize") + '&action=updateBlockListing';
			
			$.post("../ajax.php", order, function(theResponse){
				$("#contentRight").html(theResponse);
			}); 															 
		    }								  
		});




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
				var htt = $(this).height() - 50;
				$('.bgwhite', this).height(htt+'px');
			}
		});



		

	});




});	
</script>

<div class="main-container clearfix">
    <div class="main">
	
      <!--div class="my-dashboard-nav clearfix" style="width:94%"-->
	  <h4 class="had">My Workspace</h4>

<? //include("../includes/html/box/clock.php");
   //include("../includes/html/box/icon.php");


		

$addBlock = '<img src="../images/add.gif" border="0"  onMouseover="ddrivetip(\'<center>Add Block To Dashboard</center>\', 150,\'\')"; onMouseout="hideddrivetip()" >';
?>
    

  
      <!--/div-->
      

<link href="../includes/drag.css" rel="stylesheet" type="text/css">



<div align="center" id="homeload"><img src="../images/load.gif"></div>

<div class="my-dashboard clearfix" style="margin:auto;width: 100%;">

<div class="addBlockIcon"><a class="fancybox add fancybox.iframe" href="addBlock.php">Add Block</a></div>
<div class="cb"></div>


<div id="dashboarddrag" style="display:none2;margin: 0 auto;" >
	<ul class="dragul">
<?
	
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
		$BlockHeading = stripslashes($valueBlock['BlockHeading']);
		echo '<li id="recordsArray_'.$valueBlock['id'].'" class="dragli block'.$valueBlock['BlockID'].'">';
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
  


