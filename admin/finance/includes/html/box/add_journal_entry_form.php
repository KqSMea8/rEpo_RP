<script language="JavaScript1.2" type="text/javascript">
function validateJournal(frm){

  	var DataExist=0;  
	var JournalTypeVal = Trim(document.getElementById("JournalType")).value;
	var TotalDebit = Trim(document.getElementById("TotalDebit")).value;
	var TotalCredit = Trim(document.getElementById("TotalCredit")).value;	
	var JournalNo = Trim(document.getElementById("JournalNo")).value;
        var JournalDate = Trim(document.getElementById("JournalDate")).value;
 
	//CODE FOR PERIOD END SETTING
        var BackFlag = 0;
        var CurrentPeriodDate = Trim(document.getElementById("CurrentPeriodDate")).value;
        var CurrentPeriodMsg = Trim(document.getElementById("CurrentPeriodMsg")).value;
        var strBackDate = Trim(document.getElementById("strBackDate")).value;
        var strSplitBackDate = strBackDate.split(",");
        var backDateLength = strSplitBackDate.length;
        
        var spliJournalDate = JournalDate.split("-");
        var StrJournalDate = spliJournalDate[0]+"-"+spliJournalDate[1];
        
        
        for(var bk=0;bk<backDateLength;bk++)
            {
                if(strSplitBackDate[bk] == StrJournalDate)
                    {
                        BackFlag = 1;
                        break;
                    }
               
            }
        
        
        var CurrentPeriodDate = Date.parse(CurrentPeriodDate);
        var JournalDate = Date.parse(JournalDate );
       
	if(document.getElementById("BankTransfer").value != 1){
		if(parseFloat(TotalDebit).toFixed(2) != parseFloat(TotalCredit).toFixed(2)){
			alert("Total Debit Amount Should be Equal to Total Credit Amount.");
			return false;
		}
	}


        if(JournalDate < CurrentPeriodDate && BackFlag == 0) 
            {
                alert("Sorry! You Can Not Enter Back Date Entry.\n"+CurrentPeriodMsg+".");
                document.getElementById("JournalDate").focus();
		return false;
            }
            
          //END PERIOD SETTING  
	
	var NumLine = parseInt($("#NumLine").val());
        
         var AttachmentFl = frm.AttachmentFile.value;

        for(var i =1; i<=6; i++){
             AttachmentFl = AttachmentFl.replace(' ', '_');
        }

		if(JournalNo!=''){

			if(!ValidateMandRange(document.getElementById("JournalNo"), "Journal No",3,20)){
			  return false;
			}
			DataExist = CheckExistingData("isRecordExists.php","&JournalNo="+escape(JournalNo), "JournalNo","Journal No");
			if(DataExist==1)  return false;

		}

	 
		if(JournalTypeVal == "recurring")
		{
			if(!ValidateForSimpleBlank(frm.JournalDateFrom, "Date From")){
				return false;
			}
			/*if(!ValidateForSimpleBlank(frm.JournalDateTo, "Date To")){
				return false;
			}

			if(!ValidateForSimpleBlank(frm.JournalStartDate, "Start Date")){
				return false;
			}*/


		 }

		for(var i=1;i<=NumLine;i++){

			
			var debitAmnt = document.getElementById("DebitAmnt"+i).value;
			var creditAmnt = document.getElementById("CreditAmnt"+i).value;
			  

				//alert(document.getElementById("EntityType"+i).value);
				if(!ValidateForSelect(document.getElementById("AccountID"+i), "Account Name")){
					return false;
				}
				
				if(parseFloat(debitAmnt) <=0 && parseFloat(creditAmnt) <=0 ){
				  	
					alert("Please Enter Debit OR Credit Amount.");
					document.getElementById("DebitAmnt"+i).focus();
					return false;
				} 
				
				/*if(!ValidateForSelect(document.getElementById("EntityType"+i), "Entity Type")){
					return false;
				}
				if(!ValidateForSelect(document.getElementById("EntityID"+i), "Entity Name")){
					return false;
				}*/
                   }	


	   if(document.getElementById("BankTransfer").value != 1){
		if(parseFloat(TotalDebit).toFixed(2) != parseFloat(TotalCredit).toFixed(2)){
			alert("Total Debit Amount Should be Equal to Total Credit Amount.");
			return false;
		}
           }  
                
                
                if(!ValidateOptionalDoc(frm.AttachmentFile, "Document"))
                    {
                        return false;
                        
                    }
		
		/*checkFileName(AttachmentFl,'<?=$_SESSION['CmpID'];?>');
                   return false;*/

		ShowHideLoader('1','S');
	
	if(document.getElementById("BankTransfer").value == 1){
		$("#BankTransfer" ).prop( "disabled", false );
		$("#JournalType" ).prop( "disabled", false );
	}
	
}

var httpObj = false;
		try {
			 httpObj = new XMLHttpRequest();
		} catch (trymicrosoft) {
		  try {
				httpObj = new ActiveXObject("Msxml2.XMLHTTP");
		  } catch (othermicrosoft) {
			try {
			  httpObj = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (failed) {
			  httpObj = false;
			}
	  }

	}
        
        
function checkFileName(AttachmentFl,CmpID){


		var SendUrl = 'ajax.php?action=checkJournalDocFile&AttachmentFl='+AttachmentFl+'&r='+Math.random()+'&CmpID='+CmpID; 
		httpObj.open("GET", SendUrl, true);
		
		httpObj.onreadystatechange = function StateListRecieve(){
			if (httpObj.readyState == 4) {
				
				if(httpObj.responseText != "")
                                    {
                                        alert("This Document Name Already Exists.");
                                         return false; 
                                       
                                    }else{
                                        
                                        document.forms[0].submit();
                                        ShowHideLoader('1','S');
                                    }
                                
			}
		};
		httpObj.send(null);
		  return true; 
	}






</script>

<form name="form1" action=""  method="post" onSubmit="return validateJournal(this);" enctype="multipart/form-data">
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
    <td  align="center" valign="top" >
	
 
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">

<tr>
	<td align="left" class="head" colspan="4">General</td>
	</tr>	
	
	<tr <? if($_SESSION['CmpID']!='733') echo 'style="display:none"';?>>
		<td  align="right"   class="blackbold" valign="top">Journal Type :</td>
		<td  align="left" valign="top">
	<select name="BankTransfer" class="inputbox" id="BankTransfer" style="width:100px;" onchange="Javascript:BankTransferCheck();">
		<option value="0">Journal Entry</option>
		<option value="1">Bank Transfer</option>	 
	</select> 

		</td>
	</tr>
		
	<tr>
		<td  align="right"   class="blackbold" width="20%">Journal Date  :<span class="red">*</span> </td>
		<td   align="left" width="30%">
		<input type="text" name="JournalDate" maxlength="30" class="datebox" id="JournalDate" value="<?=date('Y-m-d')?>">

		<script type="text/javascript">
		$(function() {
			$('#JournalDate').datepicker(
			{
			showOn: "both",
			//yearRange: '<?=date("Y")+10?>:<?=date("Y")?>', 
			//maxDate: "-1D", 
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
			//minDate:'0d'

			}
			);
		});
		</script>
                 
                <input type="hidden" name="CurrentPeriodDate"  class="datebox" id="CurrentPeriodDate" value="<?php echo $CurrentPeriodDate;?>">
                 <input type="hidden" name="CurrentPeriodMsg"  class="datebox" id="CurrentPeriodMsg" value="<?php echo $GLCurrentPeriod;?>">
                 <input type="hidden" name="strBackDate"  class="datebox" id="strBackDate" value="<?php echo $strBackDate;?>">
                &nbsp;&nbsp;<span class="red"><?//=$GLCurrentPeriod;?></span>
		</td>
	 
		<td  align="right"   class="blackbold" width="20%">Journal No  : </td>
		<td   align="left" >
		<input type="text" name="JournalNo" maxlength="30" class="datebox" id="JournalNo"  onKeyPress="Javascript:ClearAvail('MsgSpan_JNO');return isAlphaKey(event);" onBlur="Javascript:RemoveSpecialChars(this);CheckAvailField('MsgSpan_JNO','JournalNo','<?=$_GET['edit']?>');"
 onMouseover="ddrivetip('<?=BLANK_ASSIGN_AUTO_JOURNAL?>', 220,'')"; onMouseout="hideddrivetip()" oncontextmenu="return false" >

		<span id="MsgSpan_JNO"></span>
		</td>
	</tr>	  	
       <tr>
		<td  align="right" class="blackbold">Entry Type  :<span class="red">*</span> </td>
		<td   align="left">
		  <select name="JournalType" class="inputbox" id="JournalType" style="width:100px;">
				 
				<option value="one_time">One Time</option>
				<option value="recurring">Recurring</option>	 
			</select> 
		</td>
	 
	<td  align="right" valign="top"  class="blackbold"> Memo  : </td>
	<td   align="left">
	 <input type="text" name="JournalMemo"  class="inputbox" id="JournalMemo" value="">
	
	</td>
	</tr>	
        
          <tr style="display:none;" id="dInterval">
		<td  align="right" class="blackbold">Interval :</td>
		<td  align="left" class="blacknormal">
                     <select name="JournalInterval" class="inputbox" id="JournalInterval" style="width:100px;">
                            <option value="biweekly">Biweekly</option>
                            <option value="semi_monthly">Semi Monthly</option>
                            <option value="monthly">Monthly</option>
                            <option value="yearly">Yearly</option>	 
			</select> 
		 

		</td>
                 
                <td  align="right"   class="blackbold"><span style="display:none;" id="dStart">Entry Date :</span></td>
		<td   align="left">
		<select name="JournalStartDate" class="inputbox" id="JournalStartDate" style="width:100px;display:none;">
				<?php		
				 for($i=1;$i<=31;$i++){?>
				<?php if($i<10){$prefix = '0';}else{$prefix='';}?>
				<option value="<?=$prefix.$i;?>"><?=$prefix.$i;?></option>
				<?php }?>
			</select> 
		
		</td>
	 
	
	</tr>	
        
         <tr style="display:none;" id="dEvery">
		<td  align="right" class="blackbold">Every :</td>
		<td  align="left" class="blacknormal">
                    <span style="display:none;" id="dEveryField">
                     <select name="JournalMonth" class="inputbox" id="JournalMonth" style="width:100px;">
                        <?php
                        for ($m=1; $m<=12; $m++) {
                           $month = date('F', mktime(0,0,0,$m, 1, date('Y')));
                           if($m < 10) $m = '0'.$m;
                           ?>

                        <option value="<?=$m;?>"><?=$month?></option>
                        <?php } ?>
			</select> 
                    </span>
                    <?php

                    for($i=1;$i<8;$i++)
                    $weekdays [] = date("l",mktime(0,0,0,3,28,2009)+$i * (3600*24));

                    ?>
                  <span style="display:none;" id="dWeeklyField">
                     <select name="EntryWeekly" class="inputbox" id="EntryWeekly" style="width:100px;">
                        <?php
                       foreach($weekdays as $day) {
                           if(!empty($arryRecurr[0]['EntryWeekly'])){
                            $EntryWeek = $arryRecurr[0]['EntryWeekly'];
                           }else{
                               $EntryWeek = "Monday";
                           }
                            
                          
                           ?>

                        <option value="<?=$day;?>" <?php if($EntryWeek == $day){echo "selected";}?>><?=$day?></option>
                        <?php } ?>
			</select> 
		 </span>  
		 

		</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
	</tr>	

    <tr style="display:none;" id="dFrom">
		<td  align="right" class="blackbold">Entry From :<span class="red">*</span></td>
		<td  align="left" class="blacknormal"><input id="JournalDateFrom" name="JournalDateFrom" readonly="" class="datebox" value=""  type="text" >
		<script type="text/javascript">
		$(function() {
		$('#JournalDateFrom').datepicker(
			{
			showOn: "both",
			//yearRange: '<?=date("Y")+10?>:<?=date("Y")?>', 
			//maxDate: "-1D", 
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
			minDate:'0d'

			}
		);
		});
		</script>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<label><input id="Infinite" type="checkbox" value="1" name="Infinite"  checked >&nbsp;Infinite</label> 

		</td>
	
		<td  align="right"   class="blackbold"  id="EntryToLabel">Entry To :</td>
		<td  align="left" class="blacknormal"  id="EntryToVal"><input id="JournalDateTo" name="JournalDateTo" readonly="" class="datebox" value=""  type="text" > 
		<script type="text/javascript">
		$(function() {
		$('#JournalDateTo').datepicker(
			{
			showOn: "both",
			//yearRange: '<?=date("Y")+50?>:<?=date("Y")?>', 
			//maxDate: "-1D", 
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
			minDate:'0d'

			}
			);

			$("#JournalDateTo").on("click", function () { 
					 $(this).val("");
				}
			);

		});
		</script>


</td>
	</tr>	
	
	
	
	
	 <tr id ="CurrencyShowHide"  >

<td  align="right"   class="blackbold" > Currency  : </td>
	<td   align="left" >
<? 
 
if(empty($arryJournal[0]['Currency']))$arryJournal[0]['Currency']= $Config['Currency'];

$arrySelCurrency=array();
if(!empty($arryCompany[0]['AdditionalCurrency'])) $arrySelCurrency  = explode(",",$arryCompany[0]['AdditionalCurrency']);

if(!empty($arryJournal[0]['Currency']) && !in_array($arryJournal[0]['Currency'],$arrySelCurrency)){
	$arrySelCurrency[]=$arryJournal[0]['Currency'];
}

if(!in_array($Config['Currency'],$arrySelCurrency)){
	$arrySelCurrency[] = $Config['Currency'];
}
sort($arrySelCurrency);

if($arryJournal[0]['Currency']==$Config['Currency']){
	$HideRate = 'style="display:none;"';
}
 
?>
<select name="Currency" class="textbox" id="Currency"  style="width:100px;" onChange="Javascript: GetCurrencyRate('<?=$Config['Currency']?>');">

	<? for($i=0;$i<sizeof($arrySelCurrency);$i++) {?>
	<option value="<?=$arrySelCurrency[$i]?>" <?  if($arrySelCurrency[$i]==$arryJournal[0]['Currency']){echo "selected";}?>>
	<?=$arrySelCurrency[$i]?>
	</option>
	<? } ?>
</select>


</td>
<td  align="right"   class="blackbold" id="ConversionRateLabel" <?=$HideRate?>> Conversion Rate  : </td>
	<td   align="left" >
<input type="text" onkeypress="return isDecimalKey(event);" maxlength="20" size="8"  class="textbox"  value="<?=$arryJournal[0]['ConversionRate']?>" id="ConversionRate" name="ConversionRate" <?=$HideRate?>>


</td>
 
      </tr>
	

	<tr>
	<td colspan="4">&nbsp;</td>
	</tr>
	

</table>	
  </td>
 </tr>


	 

	<tr>
	<td align="left" >
	
		<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0"  class="borderall">
		<tr>
			 <td  align="left" class="head" >Details

 

</td>
		</tr>
		 
		<tr>
			<td align="left" >
				<? 	include("includes/html/box/journal_record_row.php");?>
			</td>
		</tr>
		
		</table>
		
	</td>
</tr>

<tr>
	<td align="left" >
	
		<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0"  class="borderall">
		<tr>
			 <td  align="left" class="head" >Attachment</td>
		</tr>
		<tr>
			<td align="left" >
				<? 	include("includes/html/box/journal_attachment.php");?>
			</td>
		</tr>
		
		</table>
		
	</td>
</tr>
  
	<tr>
	<td  align="center">
		<input type="hidden" name="JournalID" id="JournalID" value="" readonly>
		<input name="Submit" type="submit" class="button" id="SubmitButton" value="Submit"  />
 

	</td>
	</tr>
</table>
 </form>

