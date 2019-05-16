
<a href="<?= $RedirectURL ?>" class="back">Back</a>

<div class="had">
    <?= $MainModuleName ?>    <span>&raquo;
        <? echo (!empty($_GET['edit'])) ? ("Edit " . $ModuleName) : ("Add " . $ModuleName); ?>

    </span>
</div>
<? if (!empty($errMsg)) { ?>
    <div align="center"  class="red" ><?php echo $errMsg; ?></div>
<?
}



if (!empty($ErrorMSG)) {
    echo '<div class="message" align="center">' . $ErrorMSG . '</div>';
} else {
    #include("includes/html/box/po_form.php");
    ?>


    <script language="JavaScript1.2" type="text/javascript">
        function validateForm(frm) {
            var NumLine = parseInt($("#NumLine").val());

            var TerritoryID = document.getElementById("TerritoryID").value;
            
            var AlrExist = 0;
             var SendParam = 'TerritoryID=' + TerritoryID +'&action=checkTerritory&r='+Math.random(); 
             
                        $.ajax({
			type: "GET",
			async:false,
			url: 'ajax.php',
			data: SendParam,
			success: function (responseText) {
                            AlrExist = responseText;
                            
				
			}
                        
                      });	
         
            if (!ValidateForSelect(frm.TerritoryID, "Territory Name")) {
                    
                    return false;
            
            }
            
            if(AlrExist == 1){
                    alert("Territory rule has been already defined for selected territory.");
                    return false;
                 }
            
            /*if(!ValidateForSelect(frm.SalesPerson, "Territory Manager")){
                return false;
            
               
            }*/
                

                for (var i = 1; i <= NumLine; i++) {
                    if (document.getElementById("country" + i) != null) {
                        if (!ValidateForSelect(document.getElementById("country" + i), "Country")) {
                            return false;
                        }
                        /*if (!ValidateForSelect(document.getElementById("state_id" + i), "State")) {
                            return false;
                        }
                        if (!ValidateForSelect(document.getElementById("city_id" + i), "City")) {
                            return false;
                        }*/
                       

                    }
                }

                ShowHideLoader('1', 'S');
                return true;
 

           

        }
    </script>

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
                                        <td align="right"   class="blackbold" > Territory Name:  <span class="red">*</span> </td>
                                        <td  align="left">
                                             <select name="TerritoryID" id="TerritoryID" class="inputbox">
                                                <option value="">Select Territory</option>
                                                  <?php $objTerritory->getTerritoryOption(0,0,$_GET['ParentID']);?>
                                                </select> 

                                        </td>
                                    </tr>

                                   <!-- <tr>
                                        <td align="right"   class="blackbold">Territory Manager: </td>
                                         <td   align="left" >
                                            <input name="SalesPerson" type="text" class="disabled" style="width:140px;"  id="SalesPerson" value="<?php echo stripslashes($arrySale[0]['SalesPerson']); ?>"  maxlength="40" readonly />
                                            <input name="SalesPersonID" id="SalesPersonID" value="<?php echo stripslashes($arrySale[0]['SalesPersonID']); ?>" type="hidden">
                                            <a class="fancybox fancybox.iframe" href="../sales/EmpList.php?dv=7"  ><?=$search?></a>
				

                                    </td>
                                    </tr>-->


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
                                 <? include("includes/html/box/add_location_form.php"); ?>
                            </td>
                        </tr>

                    </table>	


                </td>
            </tr>


            <tr>
                <td  align="center">
                <input name="Submit" type="submit" class="button" id="SubmitButton" value="Submit"  />
                </td>
            </tr>

        </table>

    </form>


<? } ?>


<? #echo '<script>SetInnerWidth();</script>';  ?>


