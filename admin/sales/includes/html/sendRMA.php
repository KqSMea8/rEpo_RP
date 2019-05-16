<script type="text/javascript" src="../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../js/ewp50.js"></script>
<script type="text/javascript">
	var ew_DHTMLEditors = [];
</script>
<script language="JavaScript1.2" type="text/javascript">
function validateMail(frm){
	if(document.getElementById("ToEmail").value =='Other'){		 
		if(!isEmail(frm.OtherEmail)){
			return false;
		}
	}else{
		if(!ValidateForSelect(document.getElementById("ToEmail"),"Email")){
			return false;
		}	
	}

	if(isEmailOpt(frm.CCEmail)
	){
		document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';
		return true;	
			
	}else{
		return false;	
	}		
}

 function makepdffile(url){
        var tempid=document.getElementById("tempID").value;
        
        var url1=url+'&tempid='+tempid;
        //alert(url1);
            $.ajax({
            url: url1,
//            success: function(data){alert(data);}
        });
    }



 function SetOtherEmail(){
	 if(document.getElementById("ToEmail").value=='Other'){
		 document.getElementById("OtherEmail").style.display = 'inline';
			
	}else {
		document.getElementById("OtherEmail").style.display = 'none';
	}
 }


</script>


		
<? 

if(!empty($ErrorMSG)){
	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}else{


?>
<div id="prv_msg_div" style="display:none;margin-top:50px;"><img src="../images/ajaxloader.gif"></div>

<div id="preview_div">
<div align="center" class="message"><?php

if (!empty($_SESSION['mess_sing']))
    {
    echo $_SESSION['mess_sing'];
    }

unset($_SESSION['mess_sing']); ?></div>		
<div class="had"><?='Send '.$module?> </div>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
	 <td align="left">

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 
 <tr>
	 <td colspan="2" align="left" class="head"><?=$module?> Information</td>
</tr>
 <tr>
 	
        <td  align="right"   class="blackbold" width="20%"> RMA Number  # : </td>
        <td   align="left" ><B><?=stripslashes($arrySale[0]['ReturnID'])?></B></td>
  </tr>
 <tr>
        <td  align="right"   class="blackbold" >Order Date  : </td>
        <td   align="left" >
 <?=($arrySale[0]['OrderDate']>0)?(date($Config['DateFormat'], strtotime($arrySale[0]['OrderDate']))):(NOT_SPECIFIED)?>
		</td>
      </tr>

<tr>
        <td  align="right"   class="blackbold" >Approved  : </td>
        <td   align="left"  >
          <?=($arrySale[0]['Approved'] == 1)?('<span class=green>Yes</span>'):('<span class=red>No</span>')?>
		  
		 </td>
      </tr>

<tr>
        <td  align="right"   class="blackbold" >Sales RMA Status  : </td>
        <td   align="left" >
		 <? 
		 if($arrySale[0]['Status'] == 'Cancelled' || $arrySale[0]['Status'] == 'Rejected'){
			 $StatusCls = 'red';
		 }else if($arrySale[0]['Status'] == 'Completed'){
			 $StatusCls = 'green';
		 }else{
			 $StatusCls = '';
		 }

		echo '<span class="'.$StatusCls.'">'.$arrySale[0]['Status'].'</span>';
		
		 ?>

           </td>
      </tr>


	<tr>
			<td  align="right"   class="blackbold" > Customer: </td>
			<td   align="left" >

<a class="fancybox fancybox.iframe" href="../custInfo.php?view=<?=$arrySale[0]['CustCode']?>" ><?=stripslashes($arrySale[0]['CustomerName'])?></a>		</td>
	</tr>

<tr>
	<td align="right"   class="blackbold">Customer Email  : </td>
	<td  align="left" >
	<?=$MainEmail?>
	</td> </tr>
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
        <td  align="right"   class="blackbold" width="15%" valign="top">To  : </td>
        <td align="left">
     
                <!--input type="text" name="ToEmail" id="ToEmail" value="<?=stripslashes($arrySale[0]['Email'])?>" class="disabled_inputbox" readonly-->

<select class="inputbox" name="ToEmail[]" id="ToEmail" onchange="Javascript: SetOtherEmail();" multiple style="height:100px<?=$ToEmailHide?>" >       
<? foreach($arrayEmail as $Email){ ?>
<option value="<?=$Email?>" <?=($MainEmail==$Email)?('selected'):('')?>><?=$Email?></option> 
<?php } ?>           
<option value="Other"  <?=$OtherSelected?>>Other</option>
</select>
<input type="text" name="OtherEmail" placeholder="Please Enter Email" id="OtherEmail" value="<?php echo $arrySale[0]['Email']  ?>" <?=$OtherEmailHide?> class="inputbox" maxlength="50">
</td>
</tr>
<tr>
        <td  align="right"   class="blackbold" >CC  : </td>
        <td   align="left"  >
         	<input type="text" name="CCEmail" id="CCEmail" value="" class="inputbox" maxlength="80">
         	<a href="../signature.php?ModuleId=<?php echo $_GET['view']?>&ModuleName=<?php echo $ModuleDepName?>&Module=<?php echo $ModuleDepName.$_GET['module']?>" class="fancybox fancybox.iframe" style="font-weight: bold;">Signature</a>
		  
		 </td>
      </tr>

 <?php if(sizeof($GetPFdTempalteNameArray)>0) { ?>
                <tr>
                    
        <td  align="right"   class="blackbold" width="20%">Template : </td>
        <td   align="left" >
            <select class="inputbox" name='tempidd' id="tempID" onchange='makepdffile("../pdfCommonhtml.php?o=<?= $_GET['view'] ?>&module=<?= $_GET['module'] ?>&attachfile=1&ModuleDepName=<?=$ModuleDepName?>")'>
                <?php //Added on 5Apr2018 by chetan for default dynamic temp//
				$dId = '';
				if(!empty($GetDefPFdTempNameArray)){
					$dId = $GetDefPFdTempNameArray[0]['id'];
				}//End//
				?>			                                       
				 <option value="<?=$dId;?>">Default</option>
                <?php foreach($GetPFdTempalteNameArray as $vals){
                    
                     echo '<option value="'.$vals['id'].'">'.$vals['TemplateName'].'</option>';
                }
                ?>
               </select>
<!--            <input type="text" name="tempid" id='tempid' value="3"/>-->
        </td>
            </tr>
            <?php  } ?>


   <tr>
        <td  align="right"   class="blackbold" valign="top">Message  : </td>
        <td   align="left"  >
         	<textarea name="Message" id="Message" class="bigbox" maxlength="500"></textarea>
		 <script type="text/javascript">

var editorName = 'Message';

var editor = new ew_DHTMLEditor(editorName);
//EmailCompose
editor.create = function() {
	var sBasePath = '../FCKeditor/';
	var oFCKeditor = new FCKeditor(editorName, '100%', 200, 'EmailCompose');
	oFCKeditor.BasePath = sBasePath;
	oFCKeditor.ReplaceTextarea();
	this.active = true;
}
ew_DHTMLEditors[ew_DHTMLEditors.length] = editor;

ew_CreateEditor(); 


</script> 
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


