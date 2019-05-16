<script language="JavaScript1.2" type="text/javascript">
function validateAccount(frm){
  var DataExist=0;

	if(ValidateForSelect(frm.AccountType, "Account Type")
           && ValidateForSimpleBlank(frm.GroupName, "Group Name")
	  ){
		var GrpID=(document.getElementById("GroupID").value);
		var GroupName=(document.getElementById("GroupName").value);           
  		var ParentGroupID=(document.getElementById("ParentGroupID").value);
		if(ParentGroupID==GrpID)
                {
                    alert("Please Select Another Parent Group.");return false;
                }
                if(ParentGroupID==''){
                    ParentGroupID=0;
                }
                
		DataExist = CheckExistingData("isRecordExists.php","&GroupName="+escape(GroupName)+"&editID="+GrpID, "GroupName","Group Name");
                if(DataExist==1)return false;
		/**********************/
		
		ShowHideLoader('1','S');
		return true;
		
	}else{
		return false;	
	}

	
}
</script>
<a href="<?=$ListUrl?>" class="back">Back</a>

<div class="had">
<?=$MainModuleName?>    <span>&raquo;
	<? 	echo (!empty($_GET['edit']))?("Edit ".$ModuleName) :("Add ".$ModuleName); ?>
		
		</span>
</div>
 <div class="message"><? if (!empty($_SESSION['mess_bank_account'])) {  echo stripslashes($_SESSION['mess_bank_account']);   unset($_SESSION['mess_bank_account']);} ?></div>
	<? if (!empty($errMsg)) {?>
    <div align="center"  class="red" ><?php echo $errMsg;?></div>
  <?php }
    else{  
        
        
        
  
     ?>  

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<form name="form1" action=""  method="post" onSubmit="return validateAccount(this);" enctype="multipart/form-data">


   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">

	
	<tr>
	<td colspan="2">&nbsp;</td>
	</tr>	

      <tr>
		<td  align="right"   class="blackbold"> Account Type  :<span class="red">*</span> </td>
		<td   align="left" >                   
           
<select name="AccountType" class="inputbox" id="AccountType" onChange="Javascript: AccountList();">
	<option value="">--- Select ---</option>
	<? for($i=0;$i<sizeof($arryAccountType);$i++) {?>
	<option value="<?=$arryAccountType[$i]['AccountTypeID']?>" <? if($arryAccountType[$i]['AccountTypeID']==$arryGroup[0]['AccountType']){echo 'selected';}?>>
	<?=stripslashes($arryAccountType[$i]['AccountType']);?>
	</option>
	<? } ?>
</select> 

		</td>
	</tr>  

     <tr>
		<td  align="right"   class="blackbold" width="45%">Group Name  :<span class="red">*</span> </td>
		<td   align="left" >
		<input type="text" name="GroupName" maxlength="30" class="inputbox" id="GroupName" value="<?=stripslashes($arryGroup[0]['GroupName'])?>">
		</td>
	</tr>
        


    <tr>
		<td  align="right"   class="blackbold">Parent Group :</td>
		<td  align="left" id="ParentGroupIDPlace" class="blacknormal">
                    
                    <select  name="ParentGroupID" class="inputbox" id="ParentGroupID" onchange="Javascript: SetMainGroupAccountId();">
                      <option value="">--- Select ---</option>
                        
                    </select>
                </td>
	</tr>	
		  	
</table>	
  </td>
 </tr>

  <?php
     
  
  ?>
	<tr>
	<td  align="center">
            <?php
            
            if(empty($_GET["edit"])){ $editVal="-1";}else {$editVal=$_GET["edit"];}
            
                    ?>
                 <input type="hidden"  id="GroupID" name="GroupID" value="<?=$editVal?>">
		 <input type="hidden" id="main_ParentAccountID" name="main_ParentAccountID" value="">
                 <input type="hidden" value="<?=$arryGroup[0]['ParentGroupID']?>" id="main_ParentGroupID" name="main_ParentGroupID">
                 <input type="hidden" value="" id="RangeFrom" name="RangeFrom">
                 <input type="hidden" value="" id="RangeTo" name="RangeTo">
		<input name="Submit" type="submit" class="button" id="SubmitButton" value="Submit"  />
	</td>
	</tr>
 </form>
</table>

    
   
<script type="text/javascript">

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


function AccountList(){
		
		ShowHideLoader('1','L');
                var AccountType = $("#AccountType").val();
				
                document.getElementById("ParentGroupIDPlace").innerHTML = '<select name="ParentGroupID" class="inputbox" id="ParentGroupID"><option value="">Loading...</option></select>';
		
                var sendParam='ajax.php?actionn=getAccountTypeGroup&AccountType='+AccountType+'&r='+Math.random()+'&select=1&ParentID='+escape(document.getElementById("main_ParentGroupID").value); 
              
		httpObj.open("GET", sendParam, true);
		
		httpObj.onreadystatechange = function AccountListRecieve(){
			if (httpObj.readyState == 4) {
                             $("#ParentGroupIDPlace").html(httpObj.responseText);
                                                          
				ShowHideLoader('');
			}
		};
		httpObj.send(null);
	}

 function SetMainGroupAccountId(){
        
         
          $("#main_ParentGroupID").val($("#ParentGroupID").val());
        }

</script>

<?php
     if($_GET["edit"] > 0)
     {
     
   ?> 
<SCRIPT LANGUAGE=JAVASCRIPT> 
    AccountList(); 
</SCRIPT>
<?php  
     }

	}	
 ?>

