 <script type="text/javascript" src="FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="js/ewp50.js"></script>
<script type="text/javascript">
	var ew_DHTMLEditors = [];
</script>

<SCRIPT LANGUAGE=JAVASCRIPT>


function validate(frm){
		if(  ValidateForBlank(frm.Question, "Question")
		&& ValidateMandRange(frm.Question, "Question",5,200)
		){
			
			if (typeof ew_UpdateTextArea == 'function'){
				ew_UpdateTextArea();
			}
			
			if (!ew_ValidateForm(frm,"Answer","Answer")){
				return false;
			}
		
			var Url = "isRecordExists.php?Question="+document.getElementById("Question").value+"&editID="+ document.getElementById("faqID").value;
			SendExistRequest(Url,"Question","Question");
			return false;
			
		}else{
			return false;	
		}
		
}


</SCRIPT>


<div class="had">
  <? 
			$MemberTitle = (!empty($_GET['edit']))?("&nbsp; Edit ") :("&nbsp; Add ");
			echo $MemberTitle.$ModuleName;
			 ?>
</div>
<TABLE WIDTH="650"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<TR>
	  <TD HEIGHT=398 align="center" valign="top"><table width="100%" height="388"  border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td  align="center" valign="middle" >
		  <br><br>
		  <div  align="right"><a href="viewFaqs.php" class="Blue">List FAQs</a>&nbsp;</div><br>
		    <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action="" method="post" onSubmit="return validate(this);">
               
                <tr>
                  <td align="center" valign="top" ><table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
                    <tr>
                      <td align="right" valign="top" =""  class="blackbold">
					  Help Category  <span class="red">*</span>
					  </td>
                      <td align="left">
		  <select name="catID" class="blacknormal" id="catID" style="width: 200px;">
              <? for($i=0;$i<sizeof($arryFaqCategory);$i++) {?>
              <option value="<?=$arryFaqCategory[$i]['catID']?>" <?  if($arryFaqCategory[$i]['catID']==$arryFaq[0]['catID']){echo "selected";}?>>
              <?=$arryFaqCategory[$i]['Name']?>
              </option>
              <? } ?>
            </select> 
					  </td>
                    </tr>
                    <tr>
                      <td width="15%" align="right" valign="top" =""  class="blackbold">  Question  <span class="red">*</span> </td>
                      <td width="85%" align="left">
	 
<input  name="Question" id="Question" value="<?=$Question?>" type="text" class="inputbox"  size="100" maxlength="200" />                       </td>
                    </tr>
                    
                    
									 <tr >
                      <td align="right" valign="top"  class="blackbold" >Answer <span class="red">*</span> </td>
                      <td align="left" class="blacknormal">
	<Div class="red" id="LoadingDiv"><img src="images/loading.gif"> Loading editor...</Div>	
	
<Div class="red" id="EditorDiv" style="display:none">

	<textarea name="Answer" id="Answer" cols="35" rows="4"><?=$Answer?></textarea>
<script type="text/javascript">

var editorName = 'Answer';

var editor = new ew_DHTMLEditor(editorName);

editor.create = function() {
	var sBasePath = 'FCKeditor/';
	var oFCKeditor = new FCKeditor(editorName, '100%', 280, 'custom');
	oFCKeditor.BasePath = sBasePath;
	oFCKeditor.ReplaceTextarea();
	this.active = true;
}
ew_DHTMLEditors[ew_DHTMLEditors.length] = editor;

ew_CreateEditor();  // Create DHTML editor(s)

//-->
</script>				  
</Div>
	

</td>
                    </tr>

<tr >
                      <td align="right" valign="middle"  class="blackbold">Status  </td>
                      <td align="left" class="blacknormal">
        <table width="151" border="0" cellpadding="0" cellspacing="0"  class="blacknormal">
          <tr>
            <td width="20" align="left" valign="middle"><input name="Status" type="radio" value="1" <?=($Status==1)?"checked":""?> /></td>
            <td width="48" align="left" valign="middle">Active</td>
            <td width="20" align="left" valign="middle"><input name="Status" type="radio" <?=($Status==0)?"checked":""?> value="0" /></td>
            <td width="63" align="left" valign="middle">Inactive</td>
          </tr>
        </table>                                            </td>
                    </tr>	


                   
                  </table></td>
                </tr>
				
				
				 <tr>
                   <td align="center" valign="middle" height="40">
					  <input name="Submit" type="submit" class="button" value="<? if($_GET['edit'] >0) echo 'Update'; else echo 'Submit'; ?>" />
                          <input type="hidden" name="faqID" id="faqID"  value="<?=$_GET['edit']?>" />        
					   <input type="reset" name="Reset" value="Reset" class="button" /></td>
                    </tr>
				
				
              </form>
          </table></td>
        </tr>
      </table></TD>
  </TR>
	
</TABLE>
<script language="javascript1.2">
	ShowAfterLoading('EditorDiv');
</script>