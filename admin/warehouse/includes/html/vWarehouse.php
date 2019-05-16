<? if($_GET['pop']!=1){?>
<a class="back" href="<?=$RedirectURL?>">Back</a> <a href="<?=$EditUrl?>" class="edit">Edit</a> 


<div class="had">
     <?=$MainModuleName?>   &raquo; <span>View Details</span>

</div>

<? }?>

<h2><font color="darkred"> Warehouse [<?=$arryWarehouse[0]['warehouse_code']?>] : <?php echo stripslashes($arryWarehouse[0]['warehouse_name']); ?>          </h2>
<h4> <font color="light" style="font-size:11px;">
    <?  if($arryWarehouse[0]['created_by']=='admin'){ ?>
    
    					
								<?php echo "Created By : Administrator on ".date($Config['DateFormat'],strtotime($arryWarehouse[0]['CreateDate'])).""; ?>
								
							
    <? } else{
	 echo "Created By : ".$createdEMP[0]['UserName']." [".$createdEMP[0]['Department']."] on ".date($Config['DateFormat'],strtotime($arryWarehouse[0]['CreateDate'])).""; 
	/*echo "<pre>";
	print_r($arryLead);*/
	}?>
    </font><h4>


  
<? 
if (!empty($_GET['view'])) {
	include("includes/html/box/warehouse_view.php");
}

?>
