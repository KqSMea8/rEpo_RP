
<script type="text/javascript" src="../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../js/ewp50.js"></script>
<script type="text/javascript">
    var ew_DHTMLEditors = [];
</script>
<SCRIPT LANGUAGE=JAVASCRIPT>

    function ValidateForm(frm)
    {

        var module_title = 'Condition Name';
        if(document.getElementById("ParentID").value > 0) module_title = 'SubCondition Name';

        if(  ValidateForSimpleBlank(frm.Name, module_title) 
        //&& ValidateMandRange(frm.Name, module_title,3,50)
            
    ){

            var Url = "isRecordExists.php?ConditionName="+escape(document.getElementById("Name").value)+"&ParentID="+document.getElementById("ParentID").value+"&editID="+document.getElementById("ConditionID").value;
            SendExistRequest(Url,"Name", module_title);
            return false;
        }else{
            return false;	
        }
	

	
	
    }

function validateAlfa(){
    var TCode = document.getElementById('Name').value;

    if( /[^a-zA-Z0-9\-\/]/.test( TCode ) ) {
        alert('Input is not alphanumeric');
        return false;
    }

    return true;     
}

</SCRIPT>
<a href="<?= $ListUrl ?>" class="back">Back</a>
<div class="had">


    <?
    if ($ParentID == 0) {
        echo 'Manage Condition';
    } else {
        ?>
        Manage Condition <?= $MainParentCondition ?>  <strong><?= $ParentCondition ?></strong>
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
	                          <td colspan="2" align="left" class="head">Item Condition</td>
                           </tr>

                                <!--tr>
                                    <td align="center" valign="top" ><table width="100%" border="0" cellpadding="5" cellspacing="1" >
                                              <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                               Select Parent Condition <?  if(empty($_GET['edit'])){?><span class="red">*</span> <?}?></td>
                                                <td width="56%"  align="left" valign="top">
													
						           <input  name="ParentID" id="ParentID" value="<?= stripslashes($_GET['ParentID']) ?>" type="hidden" class="inputbox"  size="50" />					
						
                                                    <!--select name="ParentID" id="ParentID" class="inputbox">
													<option value="0">Condition Root</option>
                                                    
                                                       
                                                     <?php  foreach($listAllCondition as $key=>$values){
                                                        $arrySubCategory = $objCondition->GetSubConditionByParent('',$values['ConditionID']);
														if(!empty($values['NumSubcondition'])){
															echo $values['Name'];
														}else{?>
                                                        
                                                     <option value="<?php echo $values['ConditionID'];?>" <?php if($_GET['ParentID']==$values['ConditionID']){echo "selected";}?>>&nbsp;<?php echo $values['Name'];?></option>
                                                    <?php }
                                                     foreach ($arrySubCategory as $key => $value) {
                                                      $arrySubCategory = $objCondition->GetSubConditionByParent('',$value['ConditionID']);
                                                    ?>
                                                     <option value="<?php echo $value['ConditionID'];?>" <?php if($_GET['ParentID']==$value['ConditionID']){echo "selected";}?>>&nbsp;&nbsp;&nbsp;-<?php echo $value['Name'];?></option>
  
                                                    <? } }  ?>
                                                    </select>	

                                                </td>
                                            </tr-->
                                            
                                            <?php if(isset($arryCondition[0]['Name'])){  $arryCondition[0]['Name'] = $arryCondition[0]['Name'];}else{ $arryCondition[0]['Name']='';}
                                            
                                            if(isset($arryCondition[0]['sort_order'])){  $arryCondition[0]['sort_order'] = $arryCondition[0]['sort_order'];}else{ $arryCondition[0]['sort_order']='';}
                                            
                                            
                                            
                                            ?>
                                            <tr>
                                                <td width="30%" align="right" valign="top"  class="blackbold"> 
                                               <?=$ModuleName ?> Name <span class="red">*</span> </td>
                                                <td width="56%"  align="left" valign="top">
                                                    <input  name="Name"  id="Name" value="<?= stripslashes($arryCondition[0]['Name']) ?>" type="text" class="inputbox" onkeypress="return isAlphaKey(event);" onblur="return validateAlfa();"  size="50" />
                                                </td>
                                            </tr>
                                         


					<tr>
					<td  align="right" valign="top"   class="blackbold"> Sort Order </td>
					<td align="left" valign="top">
					    <input  name="sort_order" id="sort_order" value="<?= stripslashes($arryCondition[0]['sort_order']) ?>" type="text" class="inputbox"  size="30" />
					</td>
					</tr>

                                            <tr >
                                                <td align="right" valign="middle"  class="blackbold">Status  </td>
                                                <td align="left" class="blacknormal">
                                                    <table width="151" border="0" cellpadding="0" cellspacing="0" class="margin-left"  class="blacknormal">
                                                        <tr>
                                                            <td width="20" align="left" valign="middle"><input name="Status" type="radio" value="1" <?= ($ConditionStatus == 1) ? "checked" : "" ?> /></td>
                                                            <td width="48" align="left" valign="middle">Active</td>
                                                            <td width="20" align="left" valign="middle"><input name="Status" type="radio" <?= ($ConditionStatus == 0) ? "checked" : "" ?> value="0" /></td>
                                                            <td width="63" align="left" valign="middle">Inactive</td>
                                                        </tr>
                                                    </table>                      
                                                </td>
                                            </tr>
                                             
                                           

                                        </table></td>
                                </tr>


                            </table></td>
                    </tr>
                    <tr>
                        <td align="center" height="135" valign="top"><br>
                           <? if ($_GET['edit'] > 0) $ButtonTitle = 'Update'; else $ButtonTitle = 'Submit'; ?>
                            <input type="hidden" name="ConditionID" id="ConditionID" value="<?php echo $_GET['edit']; ?>">   


                            <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?= $ButtonTitle ?> " />&nbsp;
                            <input type="reset" name="Reset" value="Reset" class="button" /></td>
                    </tr>

                </table></TD>
        </TR>
    </form>
</TABLE>
