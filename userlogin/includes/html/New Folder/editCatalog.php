 <script type="text/javascript" src="FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="js/ewp50.js"></script>
<script type="text/javascript">
	var ew_DHTMLEditors = [];
</script>

<SCRIPT LANGUAGE=JAVASCRIPT>

function validate(frm){
		if(  ValidateForBlank(frm.heading, "Catalog Heading")
		&& ValidateMandRange(frm.heading, "Catalog Heading",5,200)
		//&& ValidateForBlank(frm.catalogDate, "Catalog Date")
		&& ValidateOptionalUpload(frm.Image, "Image")
		){
			

		
			var Url = "isRecordExists.php?CatalogHeading="+escape(document.getElementById("heading").value)+"&editID="+document.getElementById("catalogID").value;
			SendExistRequest(Url,"heading","Catalog Heading");
			
			
			return false;
			
		}else{
			return false;	
		}
		
}



</SCRIPT>


<div class="had"> <? 
			$MemberTitle = (!empty($_GET['edit']))?("Edit ") :("Add ");
			echo $MemberTitle.$ModuleName;
			 ?></div>

<TABLE WIDTH="98%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<TR>
	  <TD  align="center" valign="top"><table width="100%"   border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td  align="center" valign="middle" >
	
		  <div  align="right"><a href="viewCatalog.php" class="Blue">List <?=$ModuleName?>s</a>&nbsp;</div><br>
		    <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action="" method="post" onSubmit="return validate(this);" enctype="multipart/form-data">
              
                <tr>
                  <td align="center" valign="top" ><table width="98%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
                    <tr>
                      <td width="43%" align="right" valign="top" =""  class="blackbold">
					   Catalog Heading <span class="red">*</span> </td>
                      <td  align="left" valign="top">
					<input  name="heading" id="heading" value="<?=stripslashes($arryCatalog[0]['heading'])?>" type="text" class="inputbox"  size="40" maxlength="100" />  
					    </td>
                    </tr>
					<!--
                    <tr >
                      <td align="right" valign="middle"  class="blackbold">Catalog Date <span class="red">*</span></td>
                      <td align="left" class="blacknormal"><span class="green-normaltext">
                        <? if($catalogDate < 1) $catalogDate = ''; echo date_picker($catalogDate,'catalogDate');?>
                      </span></td>
                    </tr>-->
					
	<tr>
    <td  align="right" valign="top"   class="blackbold"> Image  </td>
    <td  align="left" valign="top" class="blacknormal">
	<input name="Image" type="file" class="inputbox" id="Image" size="19" onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false"><br>
	<?=$MSG[201]?> 	</td>
  </tr>
<?php if($arryCatalog[0]['Image'] !='' && file_exists('../upload/catalog/'.$arryCatalog[0]['Image']) ){ 
	
	
	?>
<tr>
  <td  align="right"   class="blackbold">Current Image </td>
    <td  align="left">
	<a href="#" onclick="OpenNewPopUp('../showimage.php?img=upload/catalog/<?php echo $arryCatalog[0][Image];?>', 150, 100, 'yes' );"><?php echo '<img src="../resizeimage.php?w=200&h=200&img=upload/catalog/'.$arryCatalog[0]['Image'].'" border=0 >';
				?></a>  </td>
  </tr>  
<?
	}
?>				
					
					
					
                    <tr >
                      <td align="right" valign="top"  class="blackbold">Status  </td>
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
				
				 <!--
				 <tr >
                      <td align="right" valign="top"  class="blackbold" >Catalog Detail  </td>
                      <td align="left" class="blacknormal"  valign="top">
		
<Div class="red" id="LoadingDiv"><img src="images/loading.gif"> Loading editor...</Div>
<Div class="red" id="EditorDiv" style="display:none">

<textarea name="detail" id="detail" cols="35" rows="4"><?=htmlentities(stripslashes($arryCatalog[0]['detail']))?></textarea>
<script type="text/javascript">

var editorName = 'detail';

var editor = new ew_DHTMLEditor(editorName);

editor.create = function() {
	var sBasePath = 'FCKeditor/';
	var oFCKeditor = new FCKeditor(editorName, '100%', 380, 'custom');
	oFCKeditor.BasePath = sBasePath;
	oFCKeditor.ReplaceTextarea();
	this.active = true;
}
ew_DHTMLEditors[ew_DHTMLEditors.length] = editor;

ew_CreateEditor();  // Create DHTML editor(s)


</script>	
</Div>				  
					  
					  </td>
                    </tr>
					-->

                 
                  </table></td>
                </tr>
				 <tr><td align="center">
			  <br>
			  <input name="Submit" type="submit" class="button" value="<? if($_GET['edit'] >0) echo 'Update'; else echo 'Submit'; ?>" />
			  <input type="hidden" name="catalogID" id="catalogID"  value="<?=$_GET['edit']?>" />
			  <input type="reset" name="Reset" value="Reset" class="button" />
				    <br>  <br>  <br>
				  
				  </td></tr> 
				
              </form>
          </table></td>
        </tr>
      </table></TD>
  </TR>
	
</TABLE>