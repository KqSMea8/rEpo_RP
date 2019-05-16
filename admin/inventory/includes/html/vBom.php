<? if($_GET['pop']!=1){ ?>




<?
	/*********************/
	/*********************/
   	$NextID = $objBom->NextPrevBom($_GET['view'],1);
	$PrevID = $objBom->NextPrevBom($_GET['view'],2);
	$NextPrevUrl = "vBom.php?curP=".$_GET['curP'];
	include("../includes/html/box/next_prev.php");
	/*********************/
	/*********************/
?>



	<a href="<?=$RedirectURL?>" class="back">Back</a>


<? if($_GET['view']>0){?>
<a href="editBOM.php" onclick="return LoaderSearch();" class="add">Add New BOM</a>
<?}?>


	<? if(empty($ErrorMSG)){?>
        <a class="pdf" style="float:right;margin-left:5px;" target="_blank" href="pdfBOM.php?bom=<?=$_GET['view']?>">Download</a>
	<input type="button" class="print_button"  name="exp" style="float:right" value="Print" onclick="Javascript:window.print();"/>
        
       <? if($arryBOM[0]['AsmCount'] ==0 && $arryBOM[0]['DsmCount'] ==0){ ?>
	<a href="<?=$EditUrl?>" class="edit">Edit</a>
       <? }
       
       
       } ?>

	<div class="had">
	<?=$MainModuleName?>    <span>&raquo;
		<?=$ModuleName.' Detail'?>
			
			</span>
	</div>
		<? if (!empty($errMsg)) {?>
		<div align="center"  class="red" ><?php echo $errMsg;?></div>
	  <? } 

}	


if(!empty($ErrorMSG)){
	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}else{
	#include("includes/html/box/po_view.php");



?>
	
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
    <td  align="center" valign="top" >
	




<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">

<tr>
	 <td colspan="2" align="left" class="head">BOM Information</td>
</tr>

<tr>
	 <td colspan="2" align="left">

<table width="100%" border="0" cellpadding="5" cellspacing="0">	 
 
	
	<tr>
		<td align="right" width="45%"   class="blackbold" > Bill Number : </td>
		<td  height="30" align="left">
		<?=$arryBOM[0]['Sku']?>


</td>
	</tr>


   <tr style="display:none">
                        <td align="right"   class="blackbold" > Condition : </td>
                        <td  height="30" align="left">
                            
                      
                         <?=stripslashes($arryBOM[0]['bomCondition'])?>

</td>
                    </tr>
                    <tr>
                        <td align="right"   class="blackbold" > Description : </td>
                        <td  height="30" align="left">
                            
                      
                         <?=stripslashes($arryBOM[0]['description'])?>

</td>
                    </tr>


<tr>
		<td  align="right"   class="blackbold" > Bill With Option :</td>
		<td  height="30" align="left">
		
<?=($arryBOM[0]['bill_option'] == 'Yes')?("Yes"):("No")?>



		</td>
	</tr>
</table>
	</td>
	</tr>
  


<? if( $arryBOM[0]['bill_option'] =='Yes'){?>
	<tr>
		<td colspan="2" width="45%" align="left">
		  <div id="opt_cat" >
			<table width="100%" cellspacing="1" cellpadding="3" align="center" >
			<tbody>
                        
     <tr>
        <td >
  
                
<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">
                <table <?= $table_bg ?>>


                    <tr align="left">
			

	<td class="head1">Option Code</td>			
	

			


			</tr>
		<?php
		if (is_array($arryOption)) {
			$flag = true;
			$Line = 0;
			foreach ($arryOption as $key => $values) {
				$flag=!$flag;
				$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
				$Line++;
	
		?>
                            <!--By Chetan 26Aug--->
		    <tr align="left" valign="middle" bgcolor="<?= $bgcolor ?>">
		        <td><span><?=$values['option_code']?></span>
		       
		            <table width="100%" id="myTable" style="margin-top: 5px"    cellpadding="0" cellspacing="1">
		                
		                    <tr>
		                        <td align="left"   class="heading">Sku</td>
		                        <td align="left"   class="heading">Description</td>
		                        <td align="left"   class="heading">Qty</td>
		                    <tr>
		                     
		                    <?php 
		                        $resArr = $objBom->GetOptionStock($arryBOM[0]['bomID'], $values['optionID']);
		                        if(count($resArr)>0 ) {  
		                        
		                            foreach($resArr as $res){?>
		                            
		                                <tr>
		                                    <td align="left"><?php echo $res['sku'];?></td>
		                                    <td align="left"><?php echo $res['description'];?></td>
		                                    <td align="left"><?php echo $res['bom_qty'];?></td>
		                                <tr>
		                    <?php   }
		                        }
		                    ?>
		               </table>
		       
		       </td>





		   </tr>
           <!--End--->
<?}  } else{?>
<tr>
<td  class="no_record" colspan ="2">No Records Found.</td>
</tr>
<? }?>			
</table>
</div>		
	</td>
	</tr>


	</tbody>
			</table>
		  </div>
		</td>
	</tr>





</table>

	 </td>
</tr>
<? }else{?>

<tr>
	 <td colspan="2" align="left" class="head" >Component Item</td>
</tr>

<tr>
	<td align="left" colspan="2">
		<? 	include("includes/html/box/bom_item_view.php");?>
	</td>
</tr>

</table>	
    
	
	</td>
   <Bill Number/tr>
<? }?>
  

  
</table>



<? } ?>


