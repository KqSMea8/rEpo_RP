<SCRIPT LANGUAGE=JAVASCRIPT>
function ValidateForm(frm)
{
	if( ValidateForSelect(frm.Year, "Year")
		&& ValidateOptionalDoc(frm.document, "Document")
 	){
		
		var Url = "isRecordExists.php?DeclarationEmpID="+escape(document.getElementById("EmpID").value)+"&Year="+document.getElementById("Year").value+"&editID="+document.getElementById("decID").value;
	
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
                  <td align="center"  ><table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
                  
                   
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
	 <? }?>                  				</td>
                  </tr>	
								  

                  
                  </table></td>
                </tr>
				 <tr><td align="center">
			  <br>
	 <input name="Submit" type="submit" class="button" value="<? if($_GET['edit'] >0) echo 'Update'; else echo 'Submit' ;?>" />
		<input type="hidden" name="decID" id="decID" value="<?=$_GET["edit"]?>" />
			<input type="hidden" name="EmpID" id="EmpID" value="<?=$_SESSION['AdminID']?>">	  
				  </td></tr> 
				
              </form>
          </table>





</div>
		
<? } ?>		
	   

