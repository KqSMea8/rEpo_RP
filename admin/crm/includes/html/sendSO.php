<?php $MainDir1 = "upload/Document/".$_SESSION['CmpID']."/"; ?>
<script language="JavaScript1.2" type="text/javascript">
function validateMail(frm){
    
                       
	if(ValidateForSelect(frm.ToEmail, "To Email")
	&& isEmail(frm.ToEmail)
	&& isEmailOpt(frm.CCEmail)
	&& ValidateOptionalDoc(frm.document, "Document")
	){
               var moreFilesCount= document.getElementsByName("documentss[]").length;
               var truecount=0
               var falsecount=0
               for(var i=1;i <= moreFilesCount; i++)
               {
                   
                   var DocId=document.getElementById('documents'+i);
                   if(ValidateOptionalDoc(DocId, "Document"))
                    {

                     //document.getElementById("prv_msg_div").style.display = 'block';
                     //document.getElementById("preview_div").style.display = 'none';
                     //return true;
                     truecount=truecount+1;
                   }
                   else {
                      falsecount=falsecount+1;
                   }
                   
             }
             
             if(falsecount > 0)
             {
                 return false;
             }else{
                     document.getElementById("prv_msg_div").style.display = 'block';
                     document.getElementById("preview_div").style.display = 'none';
                     return true;
             }
             
			
	}else{
		return false;	
	}	
		
}
</script>

<script language="JavaScript1.2" type="text/javascript">

	$(document).ready(function () {
	var counter = 2;
	var TaxRateOption = $("#TaxRateOption").val();

	$("#addrow").on("click", function () { 
		/*var counter = $('#myTable tr').length - 2;*/

		counter = Number($("#NumLine").val()) + 1;

		var newRow = $("<tr class='attbg'>");
		var cols = "";

        cols += '<td align="left" colspan="2"><img src="../images/delete.png" id="ibtnDel" title="Delete">&nbsp;<input name="documentss[]" type="file" class="inputbox"  id="documents' + counter + '"  onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false" />	</td>';



		newRow.append(cols);
		//if (counter == 4) $('#addrow').attr('disabled', true).prop('value', "You've reached the limit");
		$("table.order-list").append(newRow);
		$("#NumLine").val(counter);
		counter++;
	});

	
	

	$("table.order-list").on("click", "#ibtnDel", function (event) {

		/********Edited by pk **********/
		var row = $(this).closest("tr");
		var id = row.find('input[name^="id"]').val(); 
		if(id>0){
			var DelItemVal = $("#DelItem").val();
			if(DelItemVal!='') DelItemVal = DelItemVal+',';
			$("#DelItem").val(DelItemVal+id);
		}
		/*****************************/
		$(this).closest("tr").remove();
		//calculateGrandTotal();

	});
        $("table.order-list").on("click", "#attcremove", function (event) {

		$(this).closest("tr").remove();
		//calculateGrandTotal();

	});
});
        
        
       	

</script>




		
<? 

if(!empty($ErrorMSG)){
	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}else{
// added by sanjiv
	$leadID='';
if($arrySale[0]['CustType']=='c' && $arrySale[0]['CustID']>0){
		$customers = $objCustomer->GetCustomer($arrySale[0]['CustID'],'','');
	}elseif($arrySale[0]['CustType']=='o' && $arrySale[0]['OpportunityID']>0){
		$arryOpp = $objLead->GetOpportunity($arrySale[0]['OpportunityID'],'');
		$leadID = $arryOpp[0]['LeadID'];
	}

?>
<div id="prv_msg_div" style="display:none;margin-top:50px;"><img src="../images/ajaxloader.gif"></div>
<div id="preview_div">	
<div class="had"><?='Send '.$module?> </div>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" id="order-list-t">
<tr>
	 <td align="left">

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall" >	 
 <tr>
	 <td colspan="2" align="left" class="head"><?=$module?> Information</td>
</tr>
 <tr>
        <td  align="right"   class="blackbold" width="20%"> <?=$ModuleIDTitle?> # : </td>
        <td   align="left" ><B><?=stripslashes($arrySale[0][$ModuleID])?></B></td>
  </tr>
	<tr>
			<td  align="right"   class="blackbold" > Subject  : </td>
			<td   align="left" >
<?=stripslashes($arrySale[0]['subject'])?>	</td>
	</tr>

 <tr>
        <td  align="right"   class="blackbold" >Quote Date  : </td>
        <td   align="left" >
 <?=($arrySale[0]['PostedDate']>0)?(date($Config['DateFormat'], strtotime($arrySale[0]['PostedDate']))):(NOT_SPECIFIED)?>
		</td>
      </tr>

 




	<!--tr>
			<td  align="right"   class="blackbold" > Customer  : </td>
			<td   align="left" >
<? //echo stripslashes($arrySale[0]['CustomerName']);?>	</td>
	</tr>

<tr>
			<td align="right"   class="blackbold">Customer Email  : </td>
			<td  align="left" ><? //echo stripslashes($arrySale[0]['CustomerEmail']);?></td>
		  </tr-->


</table>

</td>
</tr>





<tr>
    <td  align="center" valign="top" >

<form name="formMail" action=""  method="post" onSubmit="return validateMail(this);" enctype="multipart/form-data">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="borderall">
		<tr>
			 <td colspan="2" align="left" class="head" >Send Email</td>
		</tr>
   <tr>
        <td  align="right"   class="blackbold" width="20%">To  : <span class="red">*</span></td>
        <td   align="left"  >
	<? if(!empty($arryCustomer)){ ?>
		
	<select name="ToEmail" id="ToEmail" class="textbox" >
		<option value="">--- Select ---</option>
		<? for($i=0;$i<sizeof($arryCustomer);$i++) {?>
			<option value="<?=$arryCustomer[$i]['primary_email']?>" <?php if($leadID==$arryCustomer[$i]['leadID']) echo "selected"; ?> >
			<?=stripslashes($arryCustomer[$i]['FirstName']).' '.stripslashes($arryCustomer[$i]['LastName']).' ['.$arryCustomer[$i]['primary_email'].']'?>
			</option>
		<? } 
			if(!empty($customers)){ ?>
		<option value="<?=$customers[0]['Email']?>" selected="selected">
			<?=stripslashes($customers[0]['FirstName']).' '.stripslashes($customers[0]['LastName']).' ['.$customers[0]['Email'].']'?>
			</option>
		<? } ?>

		 </select>
		&nbsp;&nbsp; Or <a href="<?php echo $_SERVER['REQUEST_URI']?>&newEmail=1">&nbsp;&nbsp; Add New </a>
	<? }else{ ?>
         	<input type="text" name="ToEmail" id="ToEmail" value="<? if(!empty($arrySale[0]['CustomerEmail'])) echo stripslashes($arrySale[0]['CustomerEmail']); ?>" class="inputbox" >
	<? } ?>	  
		 </td>
      </tr>
   <tr>
        <td  align="right"   class="blackbold" >CC  : </td>
        <td   align="left"  >
         	<input type="text" name="CCEmail" id="CCEmail" value="" class="inputbox" maxlength="80">
		  
		 </td>
      </tr>

      <tr class="more-doc">
        <td  align="right"   class="blackbold" >Attach Document  : </td>
        <td   align="left"  >
         <input name="document" type="file" class="inputbox"  id="document"  onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false" />	
	</td>
</tr>

  
    
    <tr class='attbg'>
        <td  align="right"   class="blackbold" > &nbsp; </td>
        <td align="left" colspan="">
            
<table width="100%" id="myTable---" class="order-list"  cellpadding="0" cellspacing="1">
<tfoot>
    
    <tr class='attcfileplace' id="attcfileplace">
        <td colspan="2" align="left">&nbsp;</td>
    </tr>
    <tr class='attbg'>
        <td colspan="2" align="left">

		 <a href="Javascript:void(0);"  id="addrow" class="add_row" style="float:left">Add More</a>
                 
         <input type="hidden" name="NumLine" id="NumLine" value="<?php //echo $NumLine?>" readonly maxlength="20"  />
         <input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />


		
        </td>
    </tr>
    <tr>
        <td  align="left" colspan="2"><span style="margin-left: 8px;">or</span></td>
        
    </tr>
    <tr>
       
        <td  align="left" colspan="2">
            <a href="listAttachDocument.php?module=Document"  id="addrow" class="add_row fancybox fancybox.iframe" style="float:left">Attach From Document</a>
        </td>
    </tr>
</tfoot>
</table>
           
        </td>
        
    </tr>      


	<!--temp code by sachin added by saiyed on 8May2018-->
                        <?php if (sizeof($GetPFdTempalteNameArray) > 0) { ?>
                            <tr>

                                <td  align="right"   class="blackbold" width="20%">Template : </td>
                                <td   align="left" >
                                    <select class="inputbox" name='tempidd' id="tempID" onchange='makepdffile("../pdfCommonhtml.php?o=<?=$_GET["view"]?>&module=<?=$ModuleName?>&attachfile=1&ModuleDepName=<?= $ModuleDepName ?>")'>
                                        
					<?php //Added on 5Apr2018 by chetan for default dynamic temp//
					$dId = '';
					if(!empty($GetDefPFdTempNameArray)){
						$dId = $GetDefPFdTempNameArray[0]['id'];
					}//End//
					?>			
					<option value="<?=$dId;?>">Default</option>

                                        <?php
                                        foreach ($GetPFdTempalteNameArray as $vals) {

                                            echo '<option value="' . $vals['id'] . '">' . $vals['TemplateName'] . '</option>';
                                        }
                                        ?>
                                    </select>
                     <!--            <input type="text" name="tempid" id='tempid' value="3"/>-->
                                </td>
                            </tr>
                        <?php } ?>
                        <!--temp code by sachin -->



   <tr>
        <td  align="right"   class="blackbold" valign="top">Message  : </td>
        <td   align="left"  >
         	<textarea name="Message" id="Message" class="bigbox" maxlength="500"></textarea>
		  
		 </td>
      </tr>
<tr>
        <td  align="right"   class="blackbold" ></td>
        <td   align="left"  >
         	<input type="submit" name="butt" id="butt" class="button" value="Send">
		  
		 </td>
      </tr>
		</table>	
    </form>
	
	</td>
   </tr>

  

  
</table>
</div>


<? } ?>





