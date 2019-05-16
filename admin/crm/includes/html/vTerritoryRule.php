<? if($HideNavigation!=1){ ?>
<a href="<?= $RedirectURL ?>" class="back">Back</a>

<div class="had">
    <?= $MainModuleName ?>    <span>&raquo;
        <? echo (!empty($_GET['edit'])) ? ("Edit " . $ModuleName) : ("View " . $ModuleName); ?>

    </span>
</div>

<? 
}

if (!empty($errMsg)) { ?>
    <div align="center"  class="red" ><?php echo $errMsg; ?></div>
<?
}

if (!empty($ErrorMSG)) {
    echo '<div class="message" align="center">' . $ErrorMSG . '</div>';
} else {
    #include("includes/html/box/po_form.php");
    ?>

    <form name="form1" action=""  method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">
        <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td  align="center" valign="top" >


                    <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
                        <tr>
                            <td colspan="2" align="left" class="head">Territory Information</td>
                        </tr>

                        <tr>
                            <td colspan="2" align="left">

                                <table width="100%" border="0" cellpadding="5" cellspacing="0">	

									 <tr>
                                        <td align="right"   class="blackbold" >Sub Territory Name :</td>
                                        <td  align="left"><?=$arryTerritoryRule[0]['Name'];?></td>
                                    </tr>
								
                                     <tr>
                                        <td align="right" class="blackbold" width="45%"> Territory Name :</td>
                                        <td  align="left">
    
                                       
									
									<?
$TerritoryName=$Sep=$ParentTerritoryName='';

									 
									$arryTerritory =  $objTerritory->getParentIDTerritory($arryTerritoryRule[0]['TerritoryID']);
									if($arryTerritory[0]['ParentID']>0){
										$TerritoryName =  $objTerritory->getParentTerritoryName($arryTerritory[0]['ParentID']);
										$arryParentTerritory =  $objTerritory->getParentIDTerritory($arryTerritory[0]['ParentID']);
										if($arryParentTerritory[0]['ParentID']>0){
											 $ParentTerritoryName =  $objTerritory->getParentTerritoryName($arryParentTerritory[0]['ParentID']);
											 $Sep = ' >> ';
										}

									}
									
									echo stripslashes($ParentTerritoryName).$Sep.stripslashes($TerritoryName);
									?>
									
									
									
									</td>
                                    </tr>
                                   

                                    <tr>
                                        <td align="right" valign="top"  class="blackbold">Territory Manager :</td>
                                         <td align="left">
<!--a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?= $arryTerritoryRule[0]['EmpID'] ?>" ><?=$arryTerritoryRule[0]['SalesPerson'];?></a-->


<?
 $arryTerritoryManager = $objTerritory->GetTerritoryManager($arryTerritoryRule[0]['TerritoryID'],''); 
 $arrySalesPerson = $objTerritory->GetSalesPerson($arryTerritoryRule[0]['TerritoryID'],'');

$arryOtherPerson = $arryAssignedAlready =array();

foreach($arryTerritoryManager as $keym=>$value_man){ 
	
      
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













</td>
                                    </tr>


                                </table>

                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" align="right">
     	 
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" align="left" class="head" >Location</td>
                        </tr>

                        <tr>
                            <td align="left" colspan="2">
                                 <? include("includes/html/box/add_location_view.php"); ?>
                            </td>
                        </tr>

                    </table>	


                </td>
            </tr>


        </table>

    </form>


<? } ?>


<? #echo '<script>SetInnerWidth();</script>';  ?>


