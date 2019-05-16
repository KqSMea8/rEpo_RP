<?	require_once($Prefix."classes/item.class.php");
	

	//By Chetan20Aug//
        require_once($Prefix."classes/field.class.php"); 
        $objField = new field();	
        $arryHead=$objField->getHead('',$ModuleParentID,1);
        //End//

	$RedirectURL = "viewItem.php?curP=".$_GET['curP'];	
	$ModuleName  = "Item";	
	$objItem=new items();              
        $Config['UploadPrefix'] = '../inventory/';

        $EditUrl = "editItem.php?edit=".$_GET["view"]."&curP=".$_GET["curP"]; 
   
	if (!empty($_GET['view'])) {
		$arryItem = $objItem->GetItemById($_GET['view']); 
		$ItemID = $_GET['edit'];	
		
	}else{
		header('location:'.$RedirectURL);
		exit;
	}
	

?>


<div><a href="<?=$RedirectURL?>" class="back">Back</a> <a href="<?=$EditUrl?>" class="edit">Edit</a> </div>

<div class="had">
     <?=$MainModuleName?>   &raquo; <span>View Item</span>
    
   

</div>
<table width="100%"   border=0 align="center" cellpadding="0" cellspacing="0">
	<? if (!empty($errMsg)) {?>
  <tr>
    <td height="2" align="center"  class="red" ><?php echo $errMsg;?></td>
    </tr>
  <? } ?>
  
	<tr>
	<td align="left" valign="top">

	<?php  include("../includes/html/box/item_view.php");?>

	
	</td>
    </tr>
 
</table>
