
<a href="<?= $RedirectURL ?>" class="back">Back</a>
 <?php if ($arryWorkOrder[0]['Status'] == 2) {
if( empty($qty) && empty($arryWorkOrder[0]['asmID'])){
?>
<a href="createOrder.php?woID=<?=$_GET['view']?>&type=Assembly" class="add">Create Assembly</a>
<? } 
if((!empty($qty) && $qty>0) && empty($arryWorkOrder[0]['DsmID'])){
?>
<a href="createOrder.php?woID=<?=$_GET['view']?>&type=Dassembly" class="add">Create Dassembly</a>
<?} }?>
<div class="had">
    <?= $MainModuleName ?>    <span>&raquo;
        <? echo (!empty($_GET['edit'])) ? ("Edit " . $ModuleName) : ("View " . $ModuleName); ?>

    </span>
</div>


 <div class="message"><? if (!empty($_SESSION['mess_asm'])) {
                echo $_SESSION['mess_asm'];
                unset($_SESSION['mess_asm']);
            } ?>
            </div>



    <form name="form1" action=""  method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">

        <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">


            <tr>
                <td  align="center" valign="top" >


                    <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
                        <tr>
                            <td colspan="2" align="left" class="head">
                                Work Order Information</td>
                        </tr>

                        <tr>
                            <td colspan="2" align="left">

                                <table width="100%" border="0" cellpadding="5" cellspacing="0">	 


<tr>

 <td  align="right"   class="blackbold" > Work Order From:   </td>
                                        <td  align="left"> <? if ($arryWorkOrder[0]['OrderType']) { echo $arryWorkOrder[0]['OrderType']; } ?></td>
</tr>
<?php if(($arryWorkOrder[0]['SaleID']!='' && !empty($arryWorkOrder[0]['SaleID'])) || $arryWorkOrder[0]['OrderType']=='Order'){?>
                                 <tr id="sale" >

                                        <td  align="right"   class="blackbold" > Sales Order:   </td>
                                        <td  align="left">
                                      <?= $arryWorkOrder[0]['SaleID'] ?>
                                        

                   </td>

                                   
                                        <td  align="right"   class="blackbold" > Customer:   </td>
                                        <td  align="left">
                                            <?= $arryWorkOrder[0]['CustomerName'] ?>
                                        
                                          
                                           

                                        </td>
                                    </tr> 
<? }?>


                                    <tr>
                                        <td  align="right"   class="blackbold" > Work Order Number:   </td>
                                        <td  align="left">
                                            <?=($arryWorkOrder[0]['WON']!='')?($arryWorkOrder[0]['WON']):($NextModuleID)?> 
</td>
                   
  <td  align="right"   class="blackbold" > Date:   </td>
                                        <td  align="left">
																					<?=($arryWorkOrder[0]['SchDate']>0)?($arryWorkOrder[0]['SchDate']):(date('Y-m-d'));?>
                                      
                                    </tr>

 <tr>

 <td  align="right"   class="blackbold" > BOM:   </td>
                                        <td  align="left">
                                            <?= $arryWorkOrder[0]['BOM'] ?>
</td>
  <td  align="right"   class="blackbold" > Description:   </td>
                                        <td align="left">
                                            <?= stripslashes($arryWorkOrder[0]['description']) ?>
                                        </td>
</tr>

 <tr>
                                       
																																								
                       <td  align="right"   class="blackbold" > Condition:   </td>
                                        <td  align="left">
<?=($arryWorkOrder[0]['woCondition']!='')?($arryWorkOrder[0]['woCondition']):('');?>
                                           
                                           

                                        </td>          
                                   



                                        <td  align="right"   class="blackbold" > WO Quantity:   </td>
                                        <td  align="left">
<?=($arryWorkOrder[0]['WoQty']!='')?($arryWorkOrder[0]['WoQty']):('');?>
                                            
                                           

                                        </td>


 
                                    </tr>

 
                                    <tr>
                                     <td  align="right"   class="blackbold" > Warehouse Location:   </td>
                                        <td  align="left">
                                        <?=($arryWorkOrder[0]['WID']!='')?($arryWorkOrder[0]['warehouse_name']):('');?>
                                           

                   </td>  
                               <td  align="right"   class="blackbold" > Priority:   </td>
                                        <td align="left">
<?=($arryWorkOrder[0]['Priroty']!='')?($arryWorkOrder[0]['Priroty']):('');?>

                                            
                                        </td>         

</tr>
                                   
 



                                    <tr>

  
<td  align="right"   class="blackbold" >Status  : </td>
                                        <td   align="left" >
                                           
                                               
                                                <?
                                                if ($arryWorkOrder[0]['Status'] == 2) {
                                                    echo "Completed";
                                                }
                                                ?>
                                                 <?
                                                if ($arryWorkOrder[0]['Status'] == 0) {
                                                    echo "Parked";
                                                }
                                                ?>
                                            
                                        </td>

                                    </tr>



                                </table>

                            </td>
                        </tr>






                      
                       
                            <tr>
                                <td colspan="2" align="left" class="head" >Component</td>
                            </tr>
                       
                        
                            <tr>
                                <td align="left" colspan="2">

                                    <?
                                    //require_once("includes/html/box/wo_bom_form.php");
 require_once("includes/html/box/wo_bom_view.php");

                                    ?>
                                   
                                </td>
                            </tr>
                    

                    </table>	


                </td>
            </tr>
          
        </table>

    </form>





