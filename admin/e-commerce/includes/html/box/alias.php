<? /*********************************/?>




<tr><td colspan="2">

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right">
       
        <a href="editAlias.php?item_id=<?=$_GET['edit']?>&Sku=<?=$arryProduct[0]['ProductSku']?>" class="fancybox fancybox.iframe add" id="editGnBtn" >Add  Alias</a>
       
      
        </td>
      </tr>
	<tr>
	  <td  >

<table id="myTable" cellspacing="1" cellpadding="10" width="100%" align="center">
   
	<tr align="left"  >
	
		<td width="20%"  class="head1" >Alias Name</td>
		<!--td width="14%" class="head1" > Type</td-->
		
		<td  class="head1" >Short Description</td>
		<td width="20%"  class="head1" >Manufacture</td>
		<td width="20%"  align="center" class="head1 head1_action" >Action</td>
	</tr>
   
<?php 
if(is_array($arryAlias) && $AliasNum >0 ){
	$flag=true;
	$Line=0;
		foreach($arryAlias as $key=>$values){
		$flag=!$flag;
		$class=($flag)?("oddbg"):("evenbg");
		$Line++;

?>
    <tr align="left" class="<?=$class?>">
    
      <td ><?=$values["ItemAliasCode"]?></td>
      <!--td > 
	  <? echo stripslashes($values['AliasType']);?>		       </td-->
        <!--td> 
<a class="fancybox fancybox.iframe" href="../purchasing/suppInfo.php?view=<?=$values['VendorCode']?>"><? echo $values['VendorCode'];?></a>
</td-->
     
	  <td><?=stripslashes($values['description'])?></td>
        <td><?=stripslashes($values['Manufacture'])?></td>
   
      <td  align="center"  >
	  <a class="fancybox fancybox.iframe" href="editAlias.php?edit=<?=$values['AliasID']?>&item_id=<?=$_GET['edit']?>&CatID=<?=$_GET['CatID']?>&amp;curP=<?php echo $_GET['curP'];?>&tab=<?=$_GET['tab']?>"   ><?=$edit?></a>
	&nbsp;&nbsp;<a href="editProduct.php?edit=<?=$_GET["edit"]?>&CatID=<?=$_GET["CatID"]?>&del_alias=<?php echo $values['AliasID'];?>&amp;curP=<?php echo $_GET['curP'];?>&tab=<?=$_GET['tab']?>" onclick="return confirmDialog(this, 'Alias')"  ><?=$delete?></a> &nbsp;&nbsp;
	<a href="<?="editProduct.php?edit=".$_GET['edit']."&curP=".$_GET['curP']."&tab=SendAmazon&AliasID=".$values['AliasID']?>">Amazon</a>&nbsp;&nbsp;
	<a href="<?="editProduct.php?edit=".$_GET['edit']."&curP=".$_GET['curP']."&tab=SendEbay&AliasID=".$values['AliasID']?>">Ebay</a>
 </td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="4" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="4" >Total Record(s) : &nbsp;<?php echo $AliasNum;?>      </td>
  </tr>
  </table>
  </td>
  </tr>
</TABLE>
</td>
  </tr>

