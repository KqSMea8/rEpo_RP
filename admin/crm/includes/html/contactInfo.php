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

<div class="had">
Contact Details
</div>

  

  <? 
	if (!empty($_GET['view'])) {?>
	
	<style type="text/css">
    
      /* HOVER STYLES  facebook*/
      div#pop-upf {
        display: none;
        position: absolute;
        width: 100%;
        min-height: 150px;
        padding: 10px;
        background: #eeeeee;
        color: #000000;
        border: 1px solid #1a1a1a;
        font-size: 90%;
      }
      
      /* HOVER STYLES twitter*/
      div#pop-upt {
        display: none;
        position: absolute;
        width: 100%;
        min-height: 150px;
        padding: 10px;
        background: #eeeeee;
        color: #000000;
        border: 1px solid #1a1a1a;
        font-size: 90%;
      }
      
      /* HOVER STYLES linked*/
      div#pop-upL {
        display: none;
        position: absolute;
        width: 100%;
        min-height: 150px;
        padding: 10px;
        background: #eeeeee;
        color: #000000;
        border: 1px solid #1a1a1a;
        font-size: 90%;
      }
    </style>
<script type="text/javascript">
      $(function() {
        var moveLeft = 20;
        var moveDown = -210;
        //facebook
        $('a#triggerf').hover(function(e) {
          $('div#pop-upf').show();
          //.css('top', e.pageY + moveDown)
          //.css('left', e.pageX + moveLeft)
          //.appendTo('body');
        }, function() {
          $('div#pop-upf').hide();
        });
        
        $('a#triggerf').mousemove(function(e) {
          $("div#pop-upf").css('top', e.pageY + moveDown).css('left', e.pageX + moveLeft);
        });
        
        //twitter
        
        $('a#triggert').hover(function(e) {
          $('div#pop-upt').show();
          //.css('top', e.pageY + moveDown)
          //.css('left', e.pageX + moveLeft)
          //.appendTo('body');
        }, function() {
          $('div#pop-upt').hide();
        });
        
        $('a#triggert').mousemove(function(e) {
          $("div#pop-upt").css('top', e.pageY + moveDown).css('left', e.pageX + moveLeft);
        });
        
        //Linkdin
        $('a#triggerL').hover(function(e) {
          $('div#pop-upL').show();
          //.css('top', e.pageY + moveDown)
          //.css('left', e.pageX + moveLeft)
          //.appendTo('body');
        }, function() {
          $('div#pop-upL').hide();
        });
        
        $('a#triggerL').mousemove(function(e) {
          $("div#pop-upL").css('top', e.pageY + moveDown).css('left', e.pageX + moveLeft);
        });
        
      });
      
    </script>
<? if($_GET['tab']="contact"){?>

<div class="right_box">
  <table width="100%"  border="0" cellpadding="0" cellspacing="0">
    <form name="form1" action="<?=$ActionUrl?>"  method="post" onSubmit="return validate_<?=$_GET['tab']?>(this);" enctype="multipart/form-data">
   
      <tr>
        <td  align="center" valign="top" >
        <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
 
            <tr>
              <td  align="right"   class="blackbold"  width="25%"> First Name  : </td>
              <td   align="left" width="25%"><?php echo stripslashes($arryContact[0]['FirstName']); ?>
              </td>
            
              <td  align="right"   class="blackbold" width="25%"> Last Name  : </td>
              <td   align="left" ><?php echo stripslashes($arryContact[0]['LastName']); ?>
              </td>
            </tr>
            <tr>
              <td align="right"   class="blackbold">Email  : </td>
              <td  align="left" ><?php echo stripslashes($arryContact[0]['Email']); ?>
              </td>
          
              <td align="right"   class="blackbold">Personal Email  :</td>
              <td  align="left" >
<?=(!empty($arryContact[0]['PersonalEmail']))?($arryContact[0]['PersonalEmail']):(NOT_SPECIFIED)?>




              </td>
            </tr>
           
            <tr style="display:none;">
              <td align="right"   class="blackbold">Organization  : </td>
              <td  align="left" >
<?php if(!empty($arryContact[0]['Organization'])) echo stripslashes($arryContact[0]['Organization']); ?>
              </td>
            </tr>
            <tr>
              <td align="right"   class="blackbold">Title  : </td>
              <td  align="left" >

<? if(!empty($arryContact[0]['Title'])){  echo stripslashes($arryContact[0]['Title']); } else { echo NOT_SPECIFIED;?> <? }?>

              </td>
           
              <td align="right"   class="blackbold">Department  : </td>
              <td  align="left" >
<? if(!empty($arryContact[0]['Department'])){  echo $arryContact[0]['Department']; } else { echo NOT_SPECIFIED;?> <? }?>


              </td>
            </tr>
          
           
            <tr>
              <td  align="right"   class="blackbold"> Lead Source  : </td>
              <td   align="left" ><? if(!empty($arryContact[0]['LeadSource'])){  echo $arryContact[0]['LeadSource']; } else { echo NOT_SPECIFIED;?> <? }?>


              </td>
          
              <td  align="right"   class="blackbold"> Assigned To  : </td>
              <td   align="left" >
<? 


if(!empty($arryEmployee[0]['EmpID'])){?><a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?=$arryEmployee[0]['EmpID']?>"><?=(stripslashes($arryEmployee[0]['UserName']))?></a> <?} else { echo NOT_ASSIGNED;?> <? }?>
              </td>
            </tr>


  <tr>
              <td align="right"   class="blackbold">Reference  : </td>
              <td  align="left" > <?php if($arryContact[0]['Reference']=="Yes"){ echo"Yes";}else{ echo "No";} ?>
              </td>
           
              <td align="right"   class="blackbold">Do Not Call  : </td>
              <td  align="left" ><?php if($arryContact[0]['DoNotCall']=="Yes"){ echo"Yes";}else{ echo"No"; }?>
              </td>
            </tr>
            <tr>
              <td align="right"   class="blackbold">Notify Owner  : </td>
              <td  align="left" > <?php if($arryContact[0]['NotifyOwner']=="Yes"){ echo"Yes";}else{ echo"No"; }?>
			  
              </td>
           
              <td align="right"   class="blackbold">Email Opt Out : </td>
              <td  align="left" ><?php if($arryContact[0]['EmailOptOut']=="Yes"){ echo"Yes";}else{ echo"No"; }?>
              
             
              </td>
            </tr>
            
        
 			<tr>
        <td  align="right"   class="blackbold">  Customer : </td>
        <td   align="left" >
<? if(!empty($arryCustomer[0]['FullName'])){?><a class="fancybox fancybox.iframe" href="../custInfo.php?view=<?=$arryCustomer[0]['CustCode']?>"><?=(stripslashes($arryCustomer[0]['FullName']))?> </a> <?} else { echo NOT_SPECIFIED;?> <? }?>	    

            </td>

<td  align="right"   class="blackbold" 
		>Status  : </td>
        <td   align="left"  >
         
 <?  echo ($arryContact[0]['Status'] == 1)?("Active"):(" InActive");
		  ?>

</td>
           </tr>
    

          </table>
          </td>
      </tr>
     
    </form>
  </table><? }?>



</div>


<SCRIPT LANGUAGE=JAVASCRIPT>
<? if($_GET["tab"]=="contact"){ ?>
	StateListSend();
<? } ?>
<? if($_GET["tab"]=="account"){ ?>
	ShowPermission();
<? } ?>
</SCRIPT>
	
	
		
	<? } ?>
	




