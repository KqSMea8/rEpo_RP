<?php 




$objItem=new items();


$arryProduct=$objItem->GetItemsView($_GET);
$num=$objItem->numRows();

$pagerLink=$objPager->getPager($arryProduct,$RecordsPerPage,$_GET['curP']);
(count($arryProduct)>0)?($arryProduct=$objPager->getPageRecords()):(""); 

?>
<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(){	
	document.getElementById("prv_msg_div").style.display = 'block';
	document.getElementById("preview_div").style.display = 'none';
}
</script>






<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

   
<? if (!empty($_SESSION['mess_product'])) {?>	
    <tr>
        <td  >
            <div class="message"><? echo $_SESSION['mess_product']; unset($_SESSION['mess_product']); ?>
            </div>
        </td>
    </tr>		
<? } ?>
   <tr>
	  <td  valign="top">
	  
<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch(this);">
	 <table  border="0" cellpadding="3" cellspacing="0"  id="search_table" style="margin:0" >

		<tr>

		<td valign="bottom">
		  Search :<br> 
		  <input type="text" class="textbox" name="key" value="<?php echo $_GET['key']?>"/>
		 
		</td>
	   <td>&nbsp;</td>


		
	 



	  <td align="right" valign="bottom">  
 <input name="tab" type="hidden" value="<?=$_GET['tab']?>"  />
 <input name="search" type="submit" class="search_button" value="Go"  />	  
	  
	  
	  </td> 
 </tr>


</table>
 	</form>



	
	</td>
      </tr>
    <tr>
        <td id="ProductsListing">

            
                
                <div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">
                <table <?= $table_bg ?>>


                    <tr align="left">
                      <td class="head1"> Image </td>
                      <td width="30%" class="head1" >Product Sku</td>
                      <td  class="head1" >Product Description</td>
                      <td  class="head1" >Price</td>
                      
                         
                      
                      <!--<td width="8%"  align="center" class="head1 head1_action" >Action</td>
                  --></tr>

                    <?php
                    if (is_array($arryProduct) && $num > 0) {
                        $flag = true;
                        $Line = 0;
                        foreach ($arryProduct as $key => $values) {
                            $flag = !$flag;
                             $bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
                            $Line++;

                            //if($values['Status']<=0){ $bgcolor="#000000"; }
                            ?>
                            <tr align="left" valign="middle" bgcolor="<?= $bgcolor ?>">
                                 <td  align="left" valign="top" >



	
<? 
$MainDir = "../admin/inventory/upload/items/images/".$_SESSION['CmpID']."/";

if($values['Image'] != '' && file_exists($MainDir.$values['Image'])) {
	
?>

<span id="DeleteSpan">
<a class="fancybox" href="<?=$MainDir.$values['Image']?>" title="<?=stripslashes($values['description']);?>" data-fancybox-group="gallery">

<? echo '<img src="resizeimage.php?w=120&h=120&img='.$MainDir.$values['Image'].'" border=0 id="ImageV">';?></a>


</span>

<? }else{ echo NOT_UPLOADED; } ?>
	

</td>
                                <td>  
                                  <a href="vItem.php?view=<?=$values['ItemID']?>&curP=<?=$_GET['curP']?>&CatID=<?=  $values["CategoryID"] ?>&tab=basic"  <? if($values['itemType'] == 'Kit'){?> onmouseout="hideddrivetip()" onmouseover="ddrivetip('<center>Avg Cost - <? echo $values['average_cost'];?></center>', 90,'')"  <? } ?>><?= stripslashes($values['Sku']); ?></a>
                                </td>
                                <td><?= stripslashes($values['description']);?></td>
								<td> <?php echo $values['sell_price'];?>  <?=$Config['Currency']?> </td>
                               
                              
                               
                                   
                                <!--<td  align="center" class="head1_inner"  >
                                      <a  href="vItem.php?view=<?=$values['ItemID']?>&curP=<?=$_GET['curP']?>&CatID=<?=  $values["CategoryID"] ?>&tab=basic" ><?=$view?></a>
                               </td>     
                            --></tr>
                        <?php } // foreach end // ?>



                    <?php } else { ?>
                        <tr >
                            <td  colspan="8" class="no_record">No Inventory Items found.</td>
                        </tr>

                    <?php } ?>



                    <tr >  <td  colspan="8" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryProduct) > 0) { ?>
                                &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
                    }
                    ?></td>
                    </tr>
                </table>
</div>
                

                <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">

			

           
        </td>
    </tr>

</table>

