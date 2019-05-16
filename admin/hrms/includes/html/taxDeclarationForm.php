
<SCRIPT LANGUAGE=JAVASCRIPT>

function validate(frm){
		if( ValidateForSimpleBlank(frm.heading, "Document Title")
		    && ValidateOptionalDoc(frm.document, "Document")
		){
				ShowHideLoader(1,'S');

			return true;
		}else{
			return false;	
		}
		
}



</SCRIPT>

<div class="had">
Tax Declaration Form   
</div>

	<div class="message"><? if(!empty($_SESSION['mess_tax'])) {echo $_SESSION['mess_tax']; unset($_SESSION['mess_tax']); }?></div>
	 
		    <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action method="post" onSubmit="return validate(this);" enctype="multipart/form-data">
              
                <tr>
                  <td align="center"  ><table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
                    <tr>
                      <td width="45%" align="right"    class="blackbold">
					   Document Title :<span class="red">*</span> </td>
                      <td  align="left" >
					<input  name="heading" id="heading" value="<?=stripslashes($arryDocument[0]['heading'])?>" type="text" class="inputbox"  maxlength="40" />					    </td>
                    </tr>

                    <tr>
                    <td  class="blackbold" valign="top"   align="right"> Upload Document :</td>
                    <td  align="left"   class="blacknormal" valign="top"><input name="document" type="file" class="inputbox"  id="document"  onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false" />
					
					
 <? 
$document = stripslashes($arryDocument[0]['document']);       
if($document !='' && IsFileExist($Config['DeclarationDir'],$document)){ 
	$OldDocument = $document;
?>			
	<input type="hidden" name="OldDocument" value="<?=$OldDocument?>">			
	<div  id="DocDiv" style="padding:10px 0 10px 0;">	
	<?=$document?>&nbsp;&nbsp;&nbsp;
	<a href="../download.php?file=<?=$document?>&folder=<?=$Config['DeclarationDir']?>" class="download">Download</a> 
		<a href="Javascript:void(0);" onclick="Javascript:RemoveFile('<?=$Config['DeclarationDir']?>','<?=$document?>','DocDiv')">
		<?=$delete?></a>
	</div>			
 <? }?>	
					
					 
                  				</td>
                  </tr>
                 
              
			

			
					
					
                    <tr >
                      <td align="right"   class="blackbold">Publish  :</td>
                      <td align="left" class="blacknormal">
					
        <table width="151" border="0" cellpadding="0" cellspacing="0" style="margin:0">
          <tr>
            <td width="20" align="left" valign="middle"><input name="publish" type="radio" value="1" <?=($publish==1)?"checked":""?> /></td>
            <td width="48" align="left" valign="middle">Yes</td>
            <td width="20" align="left" valign="middle"><input name="publish" type="radio" <?=($publish==0)?"checked":""?> value="0" /></td>
            <td width="63" align="left" valign="middle">No</td>
          </tr>
        </table>                                            </td>
                    </tr>	
								  

                  
                  </table></td>
                </tr>
				 <tr><td align="center">
			  <br>
	 <input name="Submit" type="submit" class="button" value="<? if($_GET['edit'] >0) echo 'Update'; else echo 'Submit' ;?>" />
		
				  
				  </td></tr> 
				
              </form>
          </table>
