<SCRIPT LANGUAGE=JAVASCRIPT>
function ValidateForm(frm)
{
	if(document.getElementById("EmpID") != null){
		document.getElementById("MainEmpID").value = document.getElementById("EmpID").value;
	}
	if(document.getElementById("Department") != null){
		if(!ValidateForSelect(frm.Department,"Department")){
			return false;
		}
	}


	if( ValidateForSelect(frm.MainEmpID, "Employee") 
		&& ValidateForSelect(frm.Year, "Year")
		&& ValidateOptionalDoc(frm.document, "Document")
 	){
		
		var Url = "isRecordExists.php?DeclarationEmpID="+escape(document.getElementById("MainEmpID").value)+"&Year="+document.getElementById("Year").value+"&editID="+document.getElementById("decID").value;

		SendExistRequest(Url,"EmpID","Declaration Detail");
		return false;	
	}else{
		return false;	
	}
	
}
</SCRIPT>
  <div><a href="<?=$RedirectUrl?>" class="back">Back</a></div>
<div class="had"><?=$MainModuleName?> &raquo; <span>
<? 
$MemberTitle = (!empty($_GET['edit']))?(" Edit ") :(" Upload ");
echo $MemberTitle.$ModuleName;
?>
</span>
</div>

<? if(!empty($ErrorMsg)){ ?> 
	  <div align="center" id="ErrorMsg" class="redmsg">
	  <br><?=$ErrorMsg?>
	  </div>
<? }else{ ?>  

<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Loading..............</div>
<div id="preview_div" >	
	
<? if($TaxFormExist==1){ ?>			
<div style="text-align:right">	
	<a href="../download.php?file=<?=$document?>&folder=<?=$Config['DeclarationDir']?>" class="download">Download Declaration Template</a> 
	<br /><br />
</div>			
<? }?>	


<table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action method="post" onSubmit="return ValidateForm(this);" enctype="multipart/form-data">
              
                <tr>
                  <td align="center"  >

				  <table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
                   
				   <? 	if($_GET['edit'] >0){	?>
					<tr >
                      <td  align="right" valign="top" class="blackbold" > 
					  Employee : </td>
                      <td   align="left" valign="top">	
							<a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$arryDeclaration[0]['EmpID']?>" ><?=stripslashes($arryDeclaration[0]['UserName'])?></a>   

					 </td>
                    </tr>
					<? }else{ ?>

						<tr>
								<td  align="right"   class="blackbold" valign="top"> Department  :<span class="red">*</span> </td>
								<td   align="left" >

						<select name="Department" class="inputbox" id="Department" onChange="Javascript:EmpListSend('','');">
						  <option value="">--- Select ---</option>
						  <? for($i=0;$i<sizeof($arrySubDepartment);$i++) {?>
						  <option value="<?=$arrySubDepartment[$i]['depID']?>" <?  if($arrySubDepartment[$i]['depID']==$arryDeclaration[0]['Department']){echo "selected";}?>>
						  <?=stripslashes($arrySubDepartment[$i]['Department'])?>
						  </option>
						  <? } ?>
						</select></td>
							  </tr>

				   <tr>
						<td  align="right"  class="blackbold" valign="top"><div id="EmpTitle">Employee  :<span class="red">*</span></div> </td>
						<td  align="left" >
						<div id="EmpValue"></div> 
						<input type="hidden" name="OldEmpID" id="OldEmpID" value="<?=$arryDeclaration[0]['EmpID']?>" />

						<input type="hidden" name="EmpStatus" id="EmpStatus" value="1" />	
						
						<script language="javascript">
						EmpListSend('','');
						</script>
								
						</td>
					  </tr>

					<? } ?>

                   
                    <tr>
                      <td  class="blackbold" valign="top"   align="right" width="45%">Year :<span class="red">*</span></td>
                      <td  align="left"   class="blacknormal" valign="top">
					<?=getFinancialYear($arryDeclaration[0]['Year'],"Year","inputbox")?>
					  
					  </td>
                    </tr>
                    <tr>
                    <td  class="blackbold" valign="top"   align="right"> Upload Document :</td>
                    <td  align="left"   class="blacknormal" valign="top"><input name="document" type="file" class="inputbox"  id="document"  onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false" />
	
					
<? 	 $document = stripslashes($arryDeclaration[0]['document']);         
	 if($document !='' && IsFileExist($Config['DeclarationDir'],$document)){ 
		$OldDocument = $document;
?>			
	<input type="hidden" name="OldDocument" value="<?=$OldDocument?>">		
<div  id="DocDiv" style="padding:10px 0 10px 0;">	
<?=$document?>&nbsp;&nbsp;&nbsp;
<a href="../download.php?file=<?=$document?>&folder=<?=$Config['DeclarationDir']?>" class="download">Download</a> 
	<a href="Javascript:void(0);" onclick="Javascript:RemoveFile('<?=$Config['DeclarationDir']?>','<?=$document?>','DocDiv')">
	<?=$delete?></a></div>			
	 <? }?>       
	</td>
  </tr>	
								  

                  
                  </table></td>
                </tr>
				 <tr><td align="center">
			  <br>
	 <input name="Submit" type="submit" class="button" value="<? if($_GET['edit'] >0) echo 'Update'; else echo 'Submit' ;?>" />
		<input type="hidden" name="decID" id="decID" value="<?=$_GET["edit"]?>" />
						<input type="hidden" name="MainEmpID" id="MainEmpID" value="<?=$arryDeclaration[0]['EmpID']?>" />
				  
				  </td></tr> 
				
              </form>
          </table>





</div>
		
<? } ?>		
	   

