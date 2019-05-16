<?php //By chetan 23Dec//
        $OppFidArr = array('OpportunityName','Amount','Probability','forecast_amount','ContactName','CloseDate','SalesStage','CustID','lead_source');
        foreach($OppFidArr as $fname)
        {
            $OppCusFldArr[] = $objField->GetCustomfieldByFieldName($fname,'*');
        }
        $ContFidArr = array('FirstName','LastName','Email','PersonalEmail');
        foreach($ContFidArr as $fnameContact)
        {
            $ContCusFldArr[] = $objField->GetCustomfieldByFieldName($fnameContact,'*'); 
        }
        $QutFidArr = array('subject','quotestage','validtill');
        foreach($QutFidArr as $fnameQuote)
        {
            $QutCusFldArr[] = $objField->GetCustomfieldByFieldName($fnameQuote,'*'); 
        }

?>
<script>
   //By chetan 23Dec//
$(function(){
    
    
       $("#tpfrm").submit(function(){
         var $div = '';  
        if($("#convert_opp").is(":checked")) {
            $div = '#opp';
        }else if($("#convert_Id").is(":checked"))
        {
            $div = '#cont';
        }else if($("#convert_quote").is(":checked"))
        {
             $div = '#quo';
        }
        
        if($div==""){alert("Select a option to convert the lead");return false;}
        
        var err;
        $('div.red').html('');
        $("#tpfrm "+$div+" :input[data-mand^=\'y\']").each(function(){
            
            $input = ($(this).closest('td').prev().clone().children().remove().end().text()).replace(':','');
            $fldname = $(this).attr('name');
            if($(this).attr('type') == '' || typeof($(this).attr('type')) == 'undefined' || $(this).attr('type') == 'text')
            {
                if( $.trim($(this).val()) == "")
                {
                    if($fldname == "CloseTime"){
                            $input = 'Close Time';
                    }      
                    $("#"+$fldname+"err").html(""+$input+" is mandatory field.");
                          err = 1;
                }
            }else{
                 
                if($('#'+$fldname+':checked').length < 1)
                {
                     $("#"+$fldname+"err").html(""+$input+" is mandatory field.");
                     err = 1;
                }
            }	

              if(  $fldname.toLowerCase().indexOf("email") >= 0 && $(this).val()!= "")
               {    
                    emailID = $(this).val();
                    atpos = emailID.indexOf("@");
                    dotpos = emailID.lastIndexOf(".");
                    if (atpos < 1 || ( dotpos - atpos < 2 )) 
                    {
                        $("#"+$fldname+"err").html("Please enter correct email.");
                        err = 1; 
                    }
               }
               
                if($("#EntryType").val() == "recurring" &&  $div == '#quo')
                {
                    if($("#EntryFrom").val()=='')
                    {
                        err = 1;     
                        $("#EntryFromerr").html("Entry From is mandatory field.");
                    }
                    if($("#EntryTo").val()=='')
                    {
                        err = 1;
                        $("#EntryToerr").html("Entry To is mandatory field.");
                    }

                    if($("#EntryFrom").val()!='' && $("#EntryTo").val()!='' && ($("#EntryTo").val() < $("#EntryFrom").val())){
                        err = 1;
                        $("#EntryToerr").html("End Date Should be Greater Than Start Date.");
                    }

                }
                if($("#CloseDate").val()!='' && $("#TodayDate").val()!='' && ($("#CloseDate").val() <= $("#TodayDate").val())){
			 $("#CloseDateerr").html("Expected Close Date should be greater than Today Date.");
			 err = 1;	
		     }
              
          });
        if(err == 1) return false; else return true;
       });

});

//End//




    $(function() {
        $('#CloseTime').timepicker({'timeFormat': 'H:i:s'});
        $('#timeformatExample2').timepicker({'timeFormat': 'h:i A'});
    });



 $(document).ready(function() { 
$('#convert_opp').change(function(){
  if($(this).prop("checked")) {
    $('#opp').show(1000);
  } else {
    $('#opp').hide(1000);
  }
});


$('#convert_Id').change(function(){
  if($(this).prop("checked")) {
    $('#cont').show(1000);
  } else {
    $('#cont').hide(1000);
  }
});


$('#convert_quote').change(function(){
  if($(this).prop("checked")) {
    $('#quo').show(1000);
  } else {
    $('#quo').hide(1000);
  }
});

});




</script>

<style>
#Convert_div {
     hieght:450px;width: 530px; 
}

h2{
    border-radius: 2px 2px 0 0;
}
 
#Con_div {
    width: 697px;
   
}
</style>

<?php
//By Chetan 25Nov//
 if($HideNavigation ==1){
$displayNone ='';
}else{

$displayNone = 'style="display:none;"';}?>
<div id="Convert_div" <?=$displayNone?> >

        <h2>Convert Lead : <?= $arryLead[0]['FirstName'] ?></h2>
        <div id="info" style="color:red;" align="center"></div>


        <form name="topForm"  id="tpfrm" action="" onsubmit="return validateCob(this);" method="POST">

<div id="Con_div">
            <table width="671" id="oppshow"   border="0" cellpadding="5" cellspacing="0" class="borderall">
		

                <tr>
                    <td colspan="2" class="head"><input name="convert_opp" checked="checked" type="checkbox"  id="convert_opp" value="Opportunity" />Create Opportunity  </td>
                </tr>
            </table>

            <div id="opp"  >
                <table width="671" id ="opptable"  border="0" cellpadding="5" cellspacing="0" class="borderall">


                    <?php
 //Opp custom field display //
 
 $arryOppVal = array_merge($arryLead[0],array('OpportunityName' => $arryLead[0]['company']));
 $arrayvalues = $arryOppVal;
 $arryField = $OppCusFldArr; 
 include("includes/html/box/CustomFieldsNew.php"); 
 ?>


                </table>
 <br />
            <div align="center">
                <input name="Status" id="Status" type="hidden"   value="1"   />
                <!--input name="lead_source" id="lead_source" type="hidden"   value="<?php echo $arryLead[0]['lead_source']; ?>"   /-->
                <input name="LeadID" id="LeadID" type="hidden"   value="<?php echo $_GET['view']; ?>"   /> 
                <input name="OrgName" id="OrgName" type="hidden"   value="<?php echo stripslashes($arryLead[0]['company']); ?>"   />
                <input name="Industry" id="Industry" type="hidden"   value="<?php echo stripslashes($arryLead[0]['Industry']); ?>"   />




<? if($arryLead[0]['GroupID']>0 && $arryLead[0]['AssignType'] == 'Group'){?>
<input name="AssignToGroup" id="AssignToGroup" type="hidden"   value="<?php echo stripslashes($arryLead[0]['AssignTo']).':'.stripslashes($arryLead[0]['GroupID']); ?>"   />
<? }else{?>
<input name="AssignToUser" id="AssignToUser" type="hidden"   value="<?php echo stripslashes($arryLead[0]['AssignTo']);?>"   />
<? }?>

<input name="assign" id="assign" type="hidden"   value="<?php echo stripslashes($arryLead[0]['AssignType']); ?>"   />






            </div>




            </div>
           
      


            <table width="671"   border="0" cellpadding="5" cellspacing="0" class="borderall">
		

                <tr>
                    <td colspan="2" class="head">
<input name="convert_Id" type="checkbox"  id="convert_Id" value="Contact" />Create Contact  </td>
                </tr>
            </table>

            <div id="cont" style="display:none;" >
                <table width="671"   border="0" cellpadding="5" cellspacing="0" class="borderall">


                   <?php
 //Cont custom field display//
 $arryContVal = array_merge($arryLead[0],array('Email' => $arryLead[0]['primary_email']));
 $arrayvalues = $arryContVal;
 $arryField = $ContCusFldArr; 
 include("includes/html/box/CustomFieldsNew.php"); 
 ?>


                </table>
       <br />
           


            </div>
          <table width="671"   border="0" cellpadding="5" cellspacing="0" class="borderall">
		

                <tr>
                    <td colspan="2" class="head">
			<input name="convert_quote" type="checkbox"  id="convert_quote" value="quote" />Create Quote  		    </td>
                </tr>
            </table>

            <div id="quo" style="display:none;" >
               <table width="671" border="0" class="borderall" cellpadding="0" cellspacing="0" >
									   <tbody>


<tr><td colspan="2">
<!---Recurring Start-->
        <?php   
        $arryRecurr = (!empty($arryQuote)) ? $arryQuote : array();
        include("../includes/html/box/recurring_2column_sales.php");?>

        <!--Recurring End-->
</td>
</tr>
 <?php
 // Quote custom field display//
 $arrayvalues = $arryLead[0];
 $arryField = $QutCusFldArr; 
 include("includes/html/box/CustomFieldsNew.php"); 
 ?>
</table>

            </div>
</div>
<div align="center">
                <input name="ContinueButton" type="submit" class="button" id="ContinueButton"  value="Continue &raquo;"   /> <!--a href="" class="button"> Cancel</a--></div>
<!-- End -->
</form>


</div>	


