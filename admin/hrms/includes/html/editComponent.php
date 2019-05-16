<script type="text/javascript" src="../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../js/ewp50.js"></script>
<script type="text/javascript">
	var ew_DHTMLEditors = [];
</script>
<SCRIPT LANGUAGE=JAVASCRIPT>

function validate(frm){
		if( ValidateForSimpleBlank(frm.heading, "Component Title")
		){
			var Url = "isRecordExists.php?ComponentHeading="+escape(document.getElementById("heading").value)+"&editID="+document.getElementById("compID").value;
			SendExistRequest(Url,"heading","Component Title");
			return false;

		}else{
			return false;	
		}
		
}



</SCRIPT>

<a href="<?=$RedirectURL?>" class="back">Back</a>

<div class="had">
Performance Components    <span> &raquo;
	<? 	echo (!empty($_GET['edit']))?("Edit ".$ModuleName) :("Add ".$ModuleName); ?>
		
		</span>
</div>

		 
		    <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action method="post" onSubmit="return validate(this);" enctype="multipart/form-data">
              
                <tr>
                  <td align="center"  ><table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
                    <tr>
                      <td width="20%" align="right"    class="blackbold">
					   Component Title :<span class="red">*</span> </td>
                      <td  align="left" >
					<input  name="heading" id="heading" value="<?=stripslashes($arryComponent[0]['heading'])?>" type="text" class="textbox"  maxlength="50" style="width:350px" />					    </td>
                    </tr>


								
                    <tr>
                      <td  class="blackbold"  valign="top"  align="right">Description :</td>
                      <td  align="left" valign="top" >

<textarea name="detail" id="detail" ><?=htmlentities(stripslashes($arryComponent[0]['detail']))?></textarea>
<script type="text/javascript">

var editorName = 'detail';

var editor = new ew_DHTMLEditor(editorName);

editor.create = function() {
	var sBasePath = '../FCKeditor/';
	var oFCKeditor = new FCKeditor(editorName, '100%', 240, 'Basic');
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
                      <td align="right"   class="blackbold">Status  :</td>
                      <td align="left" class="blacknormal">
				
        <table width="151" border="0" cellpadding="0" cellspacing="0" style="margin:0">
          <tr>
            <td width="20" align="left" ><input name="Status" type="radio" value="1" <?=($Status==1)?"checked":""?> /></td>
            <td width="48" align="left" >Active</td>
            <td width="20" align="left" ><input name="Status" type="radio" <?=($Status==0)?"checked":""?> value="0" /></td>
            <td width="63" align="left" >InActive</td>
          </tr>
        </table>                                            </td>
                    </tr>	
								  

                  
                  </table></td>
                </tr>
				 <tr><td align="center">
			  <br>
			  <input name="Submit" type="submit" class="button" value="<? if($_GET['edit'] >0) echo 'Update'; else echo 'Submit' ;?>" />
			  <input type="hidden" name="compID" id="compID"  value="<?=$_GET['edit']?>" />
		
				  
				  </td></tr> 
				
              </form>
          </table>