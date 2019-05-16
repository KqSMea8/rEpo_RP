
<script type="text/javascript" src="../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../js/ewp50.js"></script>
<script type="text/javascript">
    var ew_DHTMLEditors = [];
</script>
<SCRIPT LANGUAGE=JAVASCRIPT>

    function ValidateForm(frm)
    {

        var module_title = 'Territory Name';
        if(document.getElementById("ParentID").value > 0) module_title = 'SubTerritory Name';

        if(  ValidateForSimpleBlank(frm.Name, module_title) 
        //&& ValidateMandRange(frm.Name, module_title,3,50)
            //&& ValidateOptionalUpload(frm.Image, "Image")
    ){

            var Url = "isRecordExists.php?TerritoryName="+escape(document.getElementById("Name").value)+"&ParentID="+document.getElementById("ParentID").value+"&editID="+document.getElementById("TerritoryID").value;
            SendExistRequest(Url,"Name", module_title);
            return false;
        }else{
            return false;	
        }
	

	
	
    }

</SCRIPT>
<a href="<?= $ListUrl ?>" class="back">Back</a>
<div class="had">


    <?
    if ($ParentID == '') {
        echo 'Manage Territory';
    } else {
        ?>
        Manage Territory <?= $MainParentTerritory ?>  <strong><?= $ParentTerritory ?></strong>
    <? } ?>
        <span> &raquo;
    <?
    $MemberTitle = (!empty($_GET['edit'])) ? (" Edit ") : (" Add ");
    echo $MemberTitle . $ModuleName;
    ?></span>
</div>
<TABLE WIDTH=100%   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
    <form name="form1" action="" method="post" onSubmit="return ValidateForm(this);" enctype="multipart/form-data"><TR>
            <TD align="center" valign="top">
			<table width="100%"  border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center" valign="middle" >
                            <table width="100%"  border="0" cellpadding="0" cellspacing="0" class="borderall">

                          <tr>
	                          <td colspan="2" align="left" class="head"> Territory</td>
                           </tr>

                                <tr>
                                    <td align="center" valign="top" ><table width="100%" border="0" cellpadding="5" cellspacing="1" >
                                              <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                               Select Parent Territory: </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <select name="ParentID" id="ParentID" class="inputbox">
			                            <option value="0">Territory Root</option>
 <?php foreach($listAllTerritory as $key=>$value){
           $arrySubTerritory = $objTerritory->GetSubTerritoryByParent('',$value['TerritoryID']);
           ?>
   <option value="<?php echo $value['TerritoryID'];?>" <?php if($_GET['ParentID']==$value['TerritoryID']){echo "selected";}?>>&nbsp;<?php echo $value['Name'];?></option>
 <?php foreach($arrySubTerritory as $key_sub=>$value_sub){ ?>
		<option value="<?php echo $value_sub['TerritoryID'];?>" <?php if($_GET['ParentID']==$value_sub['TerritoryID']){echo "selected";}?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $value_sub['Name'];?></option>
                                                      
 <?php } }  ?>
                                                    </select>	
                                                    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                               <?= $ModuleName ?> Name : <span class="red">*</span> </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="Name" id="Name" value="<?=(isset($arryTerritory[0]['Name'])) ? stripslashes($arryTerritory[0]['Name']) : '';?>" type="text" class="inputbox"  size="50" />
                                                </td>
                                            </tr>
                                         


                                       


                                            <tr >
                                                <td align="right" valign="middle"  class="blackbold">Status :  </td>
                                                <td align="left" class="blacknormal">
                                                    <table width="151" border="0" cellpadding="0" cellspacing="0" class="margin-left"  class="blacknormal">
                                                        <tr>
                                                            <td width="20" align="left" valign="middle"><input name="Status" type="radio" value="1" <?= ($TerritoryStatus == 1) ? "checked" : "" ?> /></td>
                                                            <td width="48" align="left" valign="middle">Active</td>
                                                            <td width="20" align="left" valign="middle"><input name="Status" type="radio" <?= ($TerritoryStatus == 0) ? "checked" : "" ?> value="0" /></td>
                                                            <td width="63" align="left" valign="middle">Inactive</td>
                                                        </tr>
                                                    </table>                      
                                                </td>
                                            </tr>
                                              <tr style="display:none;">
                                                <td  align="right" valign="top"   class="blackbold"> Sort Order : </td>
                                                <td align="left" valign="top">
                                                    <input  name="sort_order" id="sort_order" value="<?=(isset($arryTerritory[0]['sort_order'])) ? stripslashes($arryTerritory[0]['sort_order']) : ''; ?>" type="text" class="inputbox"  size="30" />
                                                </td>
                                            </tr>
                                            <tr style="display:none;">
                                                <td  align="right" valign="top"   class="blackbold"> Description : </td>
                                                <td align="left" valign="top">
                                                    <Textarea name="TerritoryDescription" id="TerritoryDescription" class="inputbox"  ><?=(isset($arryTerritory[0]['TerritoryDescription'])) ? stripslashes($arryTerritory[0]['TerritoryDescription']) : ''; ?></Textarea>
                                                           <script type="text/javascript">

                                                        var editorName = 'TerritoryDescription';

                                                        var editor = new ew_DHTMLEditor(editorName);

                                                        editor.create = function() {
                                                            var sBasePath = '../FCKeditor/';
                                                            var oFCKeditor = new FCKeditor(editorName, '410', 200, 'Basic');
                                                            oFCKeditor.BasePath = sBasePath;
                                                            oFCKeditor.ReplaceTextarea();
                                                            this.active = true;
                                                        }
                                                        ew_DHTMLEditors[ew_DHTMLEditors.length] = editor;

                                                        ew_CreateEditor(); 


                                                    </script>

                                                 </td>
                                              </tr>

                                        </table></td>
                                </tr>


                            </table></td>
                    </tr>
                    <tr>
                        <td align="center" height="135" valign="top"><br>
                           <? if ($_GET['edit'] > 0) $ButtonTitle = 'Update'; else $ButtonTitle = 'Submit'; ?>
                            <input type="hidden" name="TerritoryID" id="TerritoryID" value="<?php echo $_GET['edit']; ?>">   


                            <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?= $ButtonTitle ?> " />&nbsp;
                            <input type="reset" name="Reset" value="Reset" class="button" /></td>
                    </tr>

                </table></TD>
        </TR>
    </form>
</TABLE>
