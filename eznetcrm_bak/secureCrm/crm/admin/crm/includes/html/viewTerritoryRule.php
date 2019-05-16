<div class="had">Manage <?= $MainModuleName ?></div>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td ><br>
            <div class="message"><?
if (!empty($_SESSION['mess_territory'])) {
    echo stripslashes($_SESSION['mess_territory']);
    unset($_SESSION['mess_territory']);
}
?></div>
            <table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                    <td width="61%" height="32">&nbsp;</td>
                    <td width="39%" align="right">
                       
                            <a href="editTerritoryRule.php?curP=<?php echo $_GET['curP']; ?>" class="add">Add <?= $MainModuleName ?></a>
                       
                    </td>
                </tr>

            </table>

            <table <?= $table_bg ?> class="view-Territory">
                <tr align="left"> 
			<td width="15%"  class="head1">Sub <?= $ModuleName ?> Name</td>                   
                    <td width="15%" height="20"  class="head1"><?=$ModuleName?> Name</td>
                    
                    <td class="head1"><?= $ModuleName ?> Manager [Sales Person]</td>
                    <td width="5%" align="center" class="head1">Action&nbsp;&nbsp;</td>
                </tr>
                <?php

  
                (count($arryTerritoryRule)>0)?($arryTerritoryRule=$objPager->getPageRecords()):("");
                 if(is_array($arryTerritoryRule) && $num>0){
                       $flag=true;
                       foreach($arryTerritoryRule as $key=>$values){
                       $flag=!$flag;
                       
                    $TerritoryID =  $objTerritory->getParentTerritoryParentID($values['TerritoryID']);
                    $TerritoryName =  $objTerritory->getParentTerritoryName($TerritoryID);
                    
                   
		    $arryTerritoryManager = $objTerritory->GetTerritoryManager($values['TerritoryID'],''); 
		    $arrySalesPerson = $objTerritory->GetSalesPerson($values['TerritoryID'],'');
			
                      
                 ?>
                <tr align="left" valign="top" >
			 <td><?=stripslashes($values['Name'])?></td>
                  <td height="20"><?=stripslashes($TerritoryName)?></td>
                 
                  <td valign="top">

<? 
unset($arryOtherPerson); unset($arryAssignedAlready);
foreach($arryTerritoryManager as $keym=>$value_man){ 
	#$arrySalesPerson = $objTerritory->GetSalesPerson($values['TerritoryID'],$value_man['AssignTo']); 
      
?>
	<img src="../images/manager.png" border="0" title="Manager">&nbsp;<a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?=$value_man['AssignTo']?>" ><b><?=stripslashes($value_man['UserName'])?></b></a> <br>

	<? foreach($arrySalesPerson as $key_sales=>$value_sales){ 

		if($value_sales['ManagerID']==$value_man['AssignTo']){
			$arryAssignedAlready[] = $value_sales['AssignTo'];	
	?>
		- <a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?=$value_sales['AssignTo']?>" ><?=stripslashes($value_sales['UserName'])?></a>&nbsp; &nbsp; &nbsp; &nbsp;
	<? 
		}

	} ?>

	<br>
<? } //end foreach 

$OtherCount=0;

foreach($arrySalesPerson as $key_sales=>$value_sales){ 
	
	if(!in_array($value_sales['AssignTo'], $arryAssignedAlready)){	

		if($OtherCount==0) echo 'Other Sales Person';		
	?>
		- <a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?=$value_sales['AssignTo']?>" ><?=stripslashes($value_sales['UserName'])?></a>&nbsp; &nbsp; &nbsp; &nbsp;
	<? 
		$OtherCount++;
	 }
	
}


?>




                      <?php //if(!empty($values["SalesPerson"])) {?>
                       <!--div class="head1_inner" ><a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?= $values['EmpID'] ?>" ><?=stripslashes($values['SalesPerson'])?></a>
                           <a class="fancybox fancybox.iframe" href="addTerritoryManager.php?dv=7&TRID=<?= $values['TRID']; ?>&ptname=<?=$TerritoryName?>&tname=<?=$values['Name'];?>"><?=$edit?></a></div-->
                      
                      <?php //} else {?>
                         
                         <!--div class="head1_inner" >N.A.<a class="fancybox fancybox.iframe" href="addTerritoryManager.php?dv=7&TRID=<?= $values['TRID']; ?>&ptname=<?=$TerritoryName?>&tname=<?=$values['Name'];?>"><?=$edit?></a></div-->
                         
                      <?php //}?>
                   
                  </td>

              
    
                    <td align="center">
                        <a href="vTerritoryRule.php?view=<?=$values['TRID']?>"><?=$view?></a>
                        <a href="editTerritoryRule.php?del_id=<?=$values['TRID']?>&curP=<?=$_GET['curP']?>" onClick="return confirmDialog(this, 'Territory Rule')"><?=$delete?></a>	
                    </td>
                  </tr>
        <?php } // foreach end //?>
 


        <?php }else{?>
              <tr align="center" >
                <td height="20" colspan="4" class="no_record"><?=NO_RECORD?></td>
        </tr>

  <?php } ?>
    
  <tr>  <td height="20" colspan="4"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryTerritoryRule)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
            </table>
        </td>
    </tr>


</table>
<script>

 $(document).ready(function() {


        $(".trmclass").fancybox({
            'width': 300
        });
        
        


    });

</script>
