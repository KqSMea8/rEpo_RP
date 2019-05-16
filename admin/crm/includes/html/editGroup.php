
<script type="text/javascript" src="../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../js/ewp50.js"></script>
 
<script type="text/javascript" src="multiSelect/jquery.tokeninput.js"></script>

    <link rel="stylesheet" href="multiSelect/token-input.css" type="text/css" />
    <link rel="stylesheet" href="multiSelect/token-input-facebook.css" type="text/css" />
<script type="text/javascript">
	var ew_DHTMLEditors = [];
</script>
<script language="JavaScript1.2" type="text/javascript">



function validate(frm){
		if( ValidateForSimpleBlank(frm.group_name, "Group Name")
		&& ValidateForSimpleBlank(frm.group_user,"Users")
		    
		){
		
			var Url = "isRecordExists.php?GroupName="+escape(document.getElementById("group_name").value)+"&editID="+document.getElementById("GroupID").value;
			SendExistRequest(Url,"group_name","Group Name");
			return false;
		}else{
			return false;	
		}
		
}
</script>



<a class="back" href="<?=$RedirectURL?>">Back</a>


<div class="had">
Manage  Group   <span> &raquo; 
	<? 	echo (!empty($_GET['edit']))?("Edit ".$ModuleName." Details") :("Add  ".$ModuleName); ?></span>
		
		
</div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<? if (!empty($errMsg)) {?>
  <tr>
    <td height="2" align="center"  class="red" ><?php echo $errMsg;?></td>
    </tr>
  <? } ?>
  
	<tr>
	<td align="left" valign="top">
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
<form name="form1" action="<?=$ActionUrl?>"  method="post" onSubmit="return validate(this);" enctype="multipart/form-data">
  
  <? if (!empty($_SESSION['mess_group'])) {?>
<tr>
<td  align="center"  class="message"  >
	<? if(!empty($_SESSION['mess_group'])) {echo $_SESSION['mess_group']; unset($_SESSION['mess_group']); }?>	
</td>
</tr>
<? } ?>
  
   <tr>
    <td  align="center" valign="top" >


<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">


  


<tr>
	 <td colspan="2" align="left"  class="head" >Group</td>
     
</tr>
<tr>
        <td  align="right" width="40%"   class="blackbold"> Group Name  :<span class="red">*</span> </td>
        <td   align="left" >
<input name="group_name" type="text" class="inputbox" id="group_name" value="<?php echo (isset($arryGroup[0]['group_name'])) ? stripslashes($arryGroup[0]['group_name']) : ''; ?>"  maxlength="50" />            </td>
</tr>

 

	 
<tr >
  <td  align="right"   class="blackbold" valign="top"> Users :<span class="red">*</span> </td>
        <td   align="left" >
        
         <div>
        <input type="text" class="bigbox" id="group_user" name="group_user" />
       <? if($_GET['edit']>0 && $json_response2!=''){ ?>
        <script type="text/javascript">
         $(document).ready(function() {
            $("#group_user").tokenInput("multiSelectAll.php", {
                theme: "facebook",
		preventDuplicates: true,
		prePopulate: <?=$json_response2?>,
				
			propertyToSearch: "name",
              resultsFormatter: function(item){ return "<li>" + "<img src='" + item.url + "' title='" + item.name + " " + item.name + "' height='25px' width='25px' />" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.name + " (" + item.designation + ")</div></div></li>" },
              //tokenFormatter: function(item) { return "<li><p>" + item.name + " <b style='color: red'>" + item.designation + "</b></p></li>" }
			  tokenFormatter: function(item){ return "<li><p>" + "<img src='" + item.url + "' title='" + item.name + " ' height='25px' width='25px' />" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.name + " (" + item.designation + ")</div></div></li>" },

				
            });
        });
        </script>
        <? }else{?>
         <script type="text/javascript">
        $(document).ready(function() {
            $("#group_user").tokenInput("multiSelectAll.php", {
                theme: "facebook",
		preventDuplicates: true,		
		propertyToSearch: "name",
              resultsFormatter: function(item){ return "<li>" + "<img src='" + item.url + "' title='" + item.name + " " + item.name + "' height='25px' width='25px' />" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.name + " (" + item.designation + ")</div></div></li>" },
              //tokenFormatter: function(item) { return "<li><p>" + item.name + " <b style='color: red'>" + item.designation + "</b></p></li>" }
			  tokenFormatter: function(item){ return "<li><p>" + "<img src='" + item.url + "' title='" + item.name + " " + item.name + "' height='25px' width='25px' />" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.name + " (" + item.designation + ")</div></div></li>" },

				
            });
        });
        </script>
         <? }?>
        </div>
		
          </td>
      </tr>

	  <tr>

	     <td align="right"  class="blackbold">Status :</td>
                      <td align="left" class="blacknormal">
       <input name="Status" type="radio" value="1" <?=($GroupStatus==1)?"checked":""?> />Active &nbsp;&nbsp;&nbsp;&nbsp;<input name="Status" type="radio" <?=($GroupStatus==0)?"checked":""?> value="0" />Inactive</td>
       
	  </tr>
      
 <tr>

<td  align="right"   class="blackbold"  valign="top" > Description :</td>
<td   align="left" > <Textarea name="description" id="description" class="bigbox"  ><? echo (isset($arryGroup[0]['description'])) ? trim(stripslashes($arryGroup[0]['description'])) : ''; ?></Textarea>
	
           </td>
           </tr>	

   </td>
      </tr>
 

</table>	
  


	
	  
	
	</td>
   </tr>

   

   <tr>
    <td  align="center" >
	<br />
	<div id="SubmitDiv" style="display:none1">
	
<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
  <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />

</div>
<input type="hidden" name="GroupID" id="GroupID" value="<?=$_GET['edit']?>" />



</td>
   </tr>
   </form>
</table>

	
	</td>
    </tr>
 
</table>
