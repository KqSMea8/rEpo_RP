<script type="text/javascript" src="../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../js/ewp50.js"></script>
<script type="text/javascript">
	var ew_DHTMLEditors = [];
</script>

<SCRIPT LANGUAGE=JAVASCRIPT>

function validate(frm)
{
		if( ValidateForSimpleBlank(frm.Heading, "Benefit Heading")
		&& ValidateMandRange(frm.Heading, "Benefit Heading",5,100)	
		&& ValidateOptionalDoc(frm.Document, "Document")
		)
        {
			
			var Url = "isRecordExists.php?BenefitDocument="+escape(document.getElementById("Heading").value)+"&editID="+escape(document.getElementById("Bid").value);
			SendExistRequest(Url,"Heading","Document Heading");
			
			return false;
			
		}else{
			return false;	
		}
		
}

</SCRIPT>
<a href="<?=$RedirectUrl?>" class="back">Back</a>


<div class="had"><?=$MainModuleName?> <span> &raquo;
<? 
$MemberTitle = (!empty($_GET['edit']))?(" Edit ") :(" Add ");
echo $MemberTitle.$ModuleName;
?>
</span>
</div>
		    <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action method="post" onSubmit="return validate(this);" enctype="multipart/form-data">
              
                <tr>
                  <td align="center" valign="top" ><table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
                    <tr>
                      <td width="20%" align="right" valign="top"   class="blackbold">
					   Benefit Heading :<span class="red">*</span> </td>
                      <td align="left" valign="top">
					<input  name="Heading" id="Heading" value="<?=stripslashes($arryBenefit[0]['Heading'])?>" type="text" class="textbox"  size="80" maxlength="100" />  
					    </td>
                    </tr>
                  
					
	<tr>
    <td  align="right" valign="top"   class="blackbold">Upload Document  : </td>
    <td  align="left" valign="top" >
	<input name="Document" type="file" class="inputbox" id="Document"  size="19"   onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false"><br>
<? 
 
if($arryBenefit[0]['Document'] !='' && IsFileExist($Config['BenefitDir'],$arryBenefit[0]['Document'])){ 
	$OldDocument = $arryBenefit[0]['Document'];

?>
	<input type="hidden" name="OldDocument" value="<?=$OldDocument?>" />			
	<div  id="DocumentDiv">
<a href="../download.php?file=<?=$arryBenefit[0]['Document']?>&folder=<?=$Config['BenefitDir']?>" class="download">Download</a>	


	
	&nbsp;<a href="Javascript:void(0);" onclick="Javascript:RemoveFile('<?=$Config['BenefitDir']?>','<?=$arryBenefit[0]['Document']?>','DocumentDiv')"><?=$delete?></a>	</div>
<?	} ?>
	

	 	</td>
  </tr>
		
					
					
					
       <tr >
                      <td align="right" valign="top"  class="blackbold" >Description : </td>
                      <td align="left" valign="top">

<textarea name="Detail" id="Detail" ><?=htmlentities(stripslashes($arryBenefit[0]['Detail']))?></textarea>
<script type="text/javascript">

var editorName = 'Detail';

var editor = new ew_DHTMLEditor(editorName);

editor.create = function() {
	var sBasePath = '../FCKeditor/';
	var oFCKeditor = new FCKeditor(editorName, '100%', 380, 'custom');
	oFCKeditor.BasePath = sBasePath;
	oFCKeditor.ReplaceTextarea();
	this.active = true;
}
ew_DHTMLEditors[ew_DHTMLEditors.length] = editor;

ew_CreateEditor();  // Create DHTML editor(s)

//-->
</script>	
					  
					  </td>
                    </tr>


		  <tr >
                      <td align="right" valign="top"  class="blackbold">Status : </td>
                      <td align="left" >
        <table width="151" border="0" cellpadding="0" cellspacing="0" style="margin:0">
          <tr>
            <td width="20" align="left" valign="middle"><input name="Status" type="radio" value="1" <?=($Status==1)?"checked":""?> /></td>
            <td width="48" align="left" valign="middle">Active</td>
            <td width="20" align="left" valign="middle"><input name="Status" type="radio" <?=($Status==0)?"checked":""?> value="0" /></td>
            <td width="63" align="left" valign="middle">Inactive</td>
          </tr>
        </table>                                            </td>
                    </tr>

			
                    <tr >
                      <td align="right"   class="blackbold">Apply to all  :</td>
                      <td align="left" class="blacknormal">
					  <? $ApplyAll = $arryBenefit[0]['ApplyAll']; ?>
        <table width="151" border="0" cellpadding="0" cellspacing="0" style="margin:0">
          <tr>
            <td width="20" align="left" valign="middle"><input name="ApplyAll" type="radio" value="1" <?=($ApplyAll==1)?"checked":""?> /></td>
            <td width="48" align="left" valign="middle">Yes</td>
            <td width="20" align="left" valign="middle"><input name="ApplyAll" type="radio" <?=($ApplyAll==0)?"checked":""?> value="0" /></td>
            <td width="63" align="left" valign="middle">No</td>
          </tr>
        </table>                                            </td>
                    </tr>	
                 
                  </table></td>
                </tr>
				
		
				
				
				
				 <tr><td align="center">
			  <br>
			  <input name="Submit" type="submit" class="button" value="<? if($_GET['edit'] >0) echo 'Update'; else echo 'Submit' ;?>" />
			  <input type="hidden" name="Bid" id="Bid"  value="<?=$_GET['edit']?>" />
				  
				  </td></tr> 
				
              </form>
          </table>
