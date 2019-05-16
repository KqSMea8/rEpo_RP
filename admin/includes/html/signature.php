<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
<script type="text/javascript" src="FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="js/ewp50.js"></script>
<script type="text/javascript">
	var ew_DHTMLEditors = [];
	$(document).ready(function(){
    $('input[type="checkbox"]').click(function(){
        if($(this).prop("checked") == true){
            $("#setDefautTemID").val('1');

                // alert("Checkbox is checked.");

            }
              else if($(this).prop("checked") == false){
                $("#setDefautTemID").val('0');
            }
        });

        // alert($("#setDefautTemID").val());

        /*if($("#setDefautTemID").val()==1){$("#setDefautTemID").attr("checked","checked");}
        else{$("#setDefautTemID").removeAttr("checked");}*/
    });
</script>

<div id="prv_msg_div" style="display:none;margin-top:50px;"><img src="../images/ajaxloader.gif"></div>
<div id="preview_div">	


<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td>
<form name="formMail" action=""  method="post" onSubmit="return validateMail(this);" enctype="multipart/form-data">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="borderall">
		<tr>
			 <td colspan="2" align="left" class="head" >Add Signature</td>
		</tr>
		 <tr>
        <td  align="right"   class="blackbold" >Title  : </td>
        <td   align="left"  >
         	<input type="text" name="Title" id="Title" value="<?php echo $listSignatureArry[0]['Title']?>" class="inputbox" maxlength="80">
		  
		 </td>
      </tr>
      <!--<tr> <td align="right"   class="blackbold"> Make as DefaultTemp : <span class="red">* </span>
      </td> 
        <td   align="left"  >
       <input type="checkbox" value="0" name="setDefautTem" id="setDefautTemID" class="checkbox" ></td></tr>-->
         <tr>
        <td  align="right"   class="blackbold" valign="top">Body  : </td>
        <td   align="left"  >
         	<textarea name="empSignature" id="empSignature" class="bigbox" maxlength="500"><?php echo stripslashes($listSignatureArry[0]['Content'])?></textarea>
		 <script type="text/javascript">

var editorName = 'empSignature';

var editor = new ew_DHTMLEditor(editorName);
//EmailCompose
editor.create = function() {
	var sBasePath = 'FCKeditor/';
	var oFCKeditor = new FCKeditor(editorName, '100%', 200, 'EmailCompose');
	//var oFCKeditor = new FCKeditor(editorName, '100%', 200, 'Basic');
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
        <?php if($listSignatureArry[0]['id']>0){ ?>
        	<input type="submit" name="butt" id="butt" class="button" value="Update">
        	<input type="hidden" name="id" id="id" class="button" value="<?php echo $listSignatureArry[0]['id'] ?>">
        	<?php } else { ?>
         	<input type="submit" name="butt" id="butt" class="button" value="Submit">
         	<?php } ?>
         	<!-- <input type="button" value="Save & Close Window" class="submit" onclick="validateRow(this.form);"> -->


		  
		 </td>
</tr>
</table>
</form>
</td>
</tr>
</table>
</div>