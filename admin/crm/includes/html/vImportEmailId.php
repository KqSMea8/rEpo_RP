
<script language="JavaScript1.2" type="text/javascript">
function SelectAllRecord()
{	
	for(i=1; i<=document.form1.Line.value; i++){
		document.getElementById("Modules"+i).checked=true;
	}

}

function SelectNoneRecords()
{
	for(i=1; i<=document.form1.Line.value; i++){
		document.getElementById("Modules"+i).checked=false;
	}
}

function ShowOther(FieldId){
	if(document.getElementById(FieldId).value=='Other'){
		document.getElementById(FieldId+'Span').style.display = 'inline'; 
	}else{
		document.getElementById(FieldId+'Span').style.display = 'none'; 
	}
}

function ShowPermission(){
	if(document.getElementById("Role").value=='Admin'){
		document.getElementById('PermissionTitle').style.display = 'block'; 
		document.getElementById('PermissionValue').style.display = 'block'; 
	}else{
		document.getElementById('PermissionTitle').style.display = 'none'; 
		document.getElementById('PermissionValue').style.display = 'none'; 
	}
}
</script>

<a href="<?=$RedirectURL?>" class="back">Back</a>
<a href="<?=$EditUrl?>" class="edit">Edit</a> 


<div class="had">
Manage Email Id    <span>&raquo;
	 View Details
		
		</span>
</div>
	<?
         
        if (!empty($errMsg)) {?>
    <div align="center"  class="red" ><?php echo $errMsg;?></div>
  <? } ?>
  

  <?php  
	if (!empty($_GET['view'])) { ?>
		<div class="right_box">
  <table width="100%"  border="0" cellpadding="0" cellspacing="0">
   
      <tr>
        <td  align="center"  class="message"  ><? if(!empty($_SESSION['mess_contact'])) {echo $_SESSION['mess_contact']; unset($_SESSION['mess_contact']); }?>
        </td>
      </tr>
     
      <tr>
        <td  align="center" valign="top" ><table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
            
            <tr>
              <td colspan="4" align="left" class="head">Email Id Information</td>
            </tr>
            
             <tr>
              <td align="right"   class="blackbold">Name  : </td>
              <td  align="left" >
                  <?=$arryEmailInfo[0]['name']?>
              </td>
            </tr>
             <tr>
              <td align="right"   class="blackbold">User Name  : </td>
              <td  align="left" >
                  <?=$arryEmailInfo[0]['usrname']?>
              </td>
            </tr>
            
            <tr>
              <td align="right"   class="blackbold">Email  : </td>
              <td  align="left" >
                  <?=$arryEmailInfo[0]['EmailId']?>
              </td>
            </tr>
            <tr>
              <td  align="right"   class="blackbold"  width="25%"> Password  : </td>
              <td   align="left" width="25%">
                  *********
              </td>
   
            </tr>
            
            
            
            <tr>
              <td  align="right"   class="blackbold"  width="25%"> Email Server  : </td>
              <td   align="left" width="25%">
                   <?=$arryEmailInfo[0]['EmailServer']?>
              </td>
   
            </tr>
            <?php if($arryEmailInfo[0]['EmailServer']=='Other')
            {
                ?>
            
            <tr>
              <td align="right"   class="blackbold">IMAP Url  : </td>
              <td  align="left" >
                  <?=$arryEmailInfo[0]['ImapDetails']?>
              </td>
            </tr>
            <tr>
              <td align="right"   class="blackbold">SMTP Url  : </td>
              <td  align="left" >
                  <?=$arryEmailInfo[0]['SmtpDetails']?>
              </td>
            </tr>
            <?php } ?>
            
            <tr>
              <td  align="right"   class="blackbold"  width="25%"> Status  : </td>
              <td   align="left" width="25%">
                  <?php if($arryEmailInfo[0]['status']==1)
                  {
                      echo "Active";
                  }
                  if($arryEmailInfo[0]['status']==0)
                  {
                      echo "Inactive";
                  }
                      ?>
              </td>
   
            </tr>
            
 
           
          </table></td>
      </tr>
     
  </table>
</div>
	<?php }
	
	
	?>
	
