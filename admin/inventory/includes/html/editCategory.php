<?php 
if($arryCategory[0]['Spiff'] == 1){

$hideShow = '';
}else{
$hideShow = 'style="display:none;"';
}


if($arryCategory[0]['spiffType'] == 'A'){

$hidePerShow = 'style="display:none;"';

}else{

$hidePerShow = '';
}

if($arryCategory[0]['OverrideItem'] == 1) {
$overrideDisplay ='';
}else{

$overrideDisplay ='style="display:none;"';

}

?>
<script type="text/javascript" src="../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../js/ewp50.js"></script>
<script type="text/javascript">
    var ew_DHTMLEditors = [];
</script>
<SCRIPT LANGUAGE=JAVASCRIPT>

    function ValidateForm(frm)
    {

        var module_title = 'Category Name';
        if(document.getElementById("ParentID").value > 0) module_title = 'SubCategory Name';

        if(  ValidateForSimpleBlank(frm.Name, module_title) 
        //&& ValidateMandRange(frm.Name, module_title,3,50)
		 //&& ValidateMandRange(frm.valuationType, 'Valuation Type') //Added by chetan 26Feb//
            && ValidateOptionalUpload(frm.Image, "Image")
    ){
    
    
    
    if(document.getElementById("CategoryID").value==document.getElementById("ParentID").value){
       alert("Parent Category and Category should not same.");
       return false;
    }
    
    

if(document.getElementById('Overrideyes').checked) {
 
  var success = 0;
for (i = 0; i < frm.elements['ItemID[]'].length; i++)
{
	
	    if (frm.elements['ItemID[]'][i].checked){
	
	    success = 1;
	
	    }
	}


if(success ==0){
 
 alert("Please select override items");
return false;
 }
 
 
 
 
 }


            var Url = "isRecordExists.php?CategoryName="+escape(document.getElementById("Name").value)+"&ParentID="+document.getElementById("ParentID").value+"&editID="+document.getElementById("CategoryID").value;
            SendExistRequest(Url,"Name", module_title);
            return false;
        }else{
            return false;	
        }
	

	
	
    }
    
    
   
function yesnoCheck() {

document.getElementById('spiffType').style.value = '';
        document.getElementById('spiffAmt').style.value = '';

    if(document.getElementById('yescheck').checked) {
        document.getElementById('typespiff').style.display = '';
        document.getElementById('overitm').style.display = '';
        
         if(document.getElementById('spiffType').value=='P'){
        document.getElementById('Disspiff').style.display = '';
        document.getElementById('perc').style.display = '';
        
        }else{
        document.getElementById('Disspiff').style.display = '';
        document.getElementById('perc').style.display = 'none';
        }
        OverrideYesNo();
        
    }else{ 
     
        document.getElementById('typespiff').style.display = 'none';
        document.getElementById('Disspiff').style.display = 'none';
        document.getElementById('overitm').style.display = 'none';
         document.getElementById('OverrideDis').style.display = 'none';
        document.getElementById('OverrideDisamt').style.display = 'none';
        
    }

}


function OverrideYesNo() {

document.getElementById('OverrideDis').style.display = '';
        document.getElementById('OverrideDisamt').style.display = '';

    if(document.getElementById('Overrideyes').checked) {
       document.getElementById('OverrideDis').style.display = '';
        document.getElementById('OverrideDisamt').style.display = '';
        
       
        
        
        
    }else{ 
     
        document.getElementById('OverrideDis').style.display = 'none';
        document.getElementById('OverrideDisamt').style.display = 'none';
        
    }

}



  $( document ).ready(function() {  
 $('#spiffAmt').keyup(function(){
 
 var SpiffType =$('#spifftype').val()
 if(SpiffType == 'P'){
    if ($(this).val() > 100){
      alert("No numbers above 100");
      $(this).val(0);
    } 
 }
 });

 
 
 $('#spiffType').on('change', function() {
  // alert( this.value ); // or $(this).val()
  if(this.value == "A") {
    $('#Disspiff').show();
   $('#percen').hide();
   $('#perc').hide();
   
  } else {
    //$('#ic').hide();
    $('#Disspiff').show();
    $('#perc').show();
     $('#percen').show();
  }
});
 });
 
 
 function SelectAllRecord()
{	
	for(i=1; i<=document.form1.Line.value; i++){
		document.getElementById("ItemID"+i).checked=true;
	}

}

function SelectNoneRecords()
{
	for(i=1; i<=document.form1.Line.value; i++){
		document.getElementById("ItemID"+i).checked=false;
	}
}





 
 
 
 
</SCRIPT>
<a href="<?= $ListUrl ?>" class="back">Back</a>
<div class="had">


    <?
    if ($ParentID == 0) {
        echo 'Manage Categories';
    } else {
        ?>
        Manage Categories <?= $MainParentCategory ?>  <strong><?= $ParentCategory ?></strong>
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
	                          <td colspan="2" align="left" class="head">Item Category</td>
                           </tr>

  <tr>
      <td align="center" valign="top" >
           <table width="100%" border="0" cellpadding="5" cellspacing="1" >
                <tr>
                  <td width="30%" align="right" valign="top"  class="blackbold"> 
                 Select Parent Category <span class="red">*</span> </td>
                  <td width="56%"  align="left" valign="top">
                      <select name="ParentID" id="ParentID" class="inputbox">
 <option value="0">Category Root</option>
                      <?php 
                         foreach($listAllCategory as $key=>$value){
                          $arrySubCategory = $objCategory->GetSubCategoryByParent('',$value['CategoryID']);          
                       ?>
                       <option value="<?php echo $value['CategoryID'];?>" <?php if($_GET['ParentID']==$value['CategoryID']){echo "selected";}?>>&nbsp;<?php echo $value['Name'];?></option>
                      <?php 
                      //By chetan 11Feb//
                      	echo $objCategory->getCategories($value['CategoryID'],'',$_GET['ParentID']);
                      } 
                       ?>
                      </select>	
                      
                  </td>
              </tr>
             <tr>
                 <td width="30%" align="right" valign="top"  class="blackbold"> 
                <?= $ModuleName ?> Name <span class="red">*</span> </td>
                 <td width="56%"  align="left" valign="top">
                     <input  name="Name" id="Name" value="<?= stripslashes($arryCategory[0]['Name']) ?>" type="text" class="inputbox"  size="50" />
                 </td>
             </tr>
           <? if($_SESSION['SelectOneItem'] != 1){?>
           <tr>
	                 <td  align="right"   class="blackbold" >Valuation Method    </td>
	                 <td  align="left">

	                 <select name="valuationType" id="valuationType" class="inputbox">
	                 <option value="">Select Valuation</option>
	                 <? for ($i = 0; $i < sizeof($arryEvaluationType); $i++) { 
                 //if($arryEvaluationType[$i]['attribute_value']!='Serialized Average') {?>
	                 <option value="<?= $arryEvaluationType[$i]['attribute_value'] ?>" <? if ($arryEvaluationType[$i]['attribute_value'] == $arryCategory[0]['valuationType']) {
	                 echo "selected";
	                 } //}?>>
	                 <?= $arryEvaluationType[$i]['attribute_value'] ?>
	                 </option>
	                 <? } ?>
	                 </select>
	                 </td>
	           </tr>
	           <? }?>
           <tr>
             <td align="right" valign="middle"  class="blackbold">Spiff  </td>
             <td align="left" class="blacknormal">
                 <table width="151" border="0" cellpadding="0" cellspacing="0" class="margin-left"  class="blacknormal">
                     <tr>
                         <td width="20" align="left" valign="middle"><input name="Spiff" type="radio" value="1" <?= ($arryCategory[0]['Spiff'] == 1) ? "checked" : ""   ?> id="yescheck"  onclick="javascript:yesnoCheck();" /></td>
                         <td width="48" align="left" valign="middle">Yes</td>
                         <td width="20" align="left" onclick="javascript:yesnoCheck();"  valign="middle"><input name="Spiff" type="radio" <?= ($arryCategory[0]['Spiff'] == 0) ? "checked" : "" ?> id="nocheck" value="0" /></td>
                         <td width="63" align="left" valign="middle">No</td>
                     </tr>
                 </table>                      
             </td>
           </tr>
                                            
            <tr id="typespiff" <?=$hideShow?>>
               <td  align="right" valign="top"   class="blackbold"> Spiff Type </td>
               <td align="left" valign="top">
                   <select name="spiffType" id="spiffType" class="inputbox">
                   
                   <option value="A" <?= ($arryCategory[0]['spiffType'] == 'A') ? "selected" : "" ?>>Amount</option>
                   <option value="P" <?= ($arryCategory[0]['spiffType'] == 'P') ? "selected" : "" ?>>Percentage</option>
                   </select>
               </td>
           </tr>                                
           <tr id="Disspiff" <?=$hideShow?> >
              <td  align="right" valign="top"   class="blackbold"> Spiff Amount <span id="perc" <?=$hidePerShow?>>%</span> </td>
              <td align="left" valign="top">
                  <input name="spiffAmt" id="spiffAmt"  class="inputbox" value="<?=$arryCategory[0]['spiffAmt']?>" >
              </td>
          </tr>
                                            
        <tr id="overitm" <?=$hideShow?>>
            <td align="right" valign="middle"  class="blackbold">Override Items  </td>
            <td align="left" class="blacknormal">
                <table width="151" border="0" cellpadding="0" cellspacing="0" class="margin-left"  class="blacknormal">
                    <tr>
                        <td width="20" align="left" valign="middle"><input name="OverrideItem" type="radio" value="1" <?= ($arryCategory[0]['OverrideItem'] == 1) ? "checked" : ""   ?> id="Overrideyes"  onclick="javascript:OverrideYesNo();" /></td>
                        <td width="48" align="left" valign="middle">Yes</td>
                        <td width="20" align="left"   valign="middle"><input name="OverrideItem" type="radio" <?= ($arryCategory[0]['OverrideItem'] == 0) ? "checked" : "" ?> id="OverrideNo" value="0" onclick="javascript:OverrideYesNo();" /></td>
                        <td width="63" align="left" valign="middle">No</td>
                    </tr>
                </table>                      
            </td>
        </tr>
                                            
   <tr id="OverrideDis" <?=$overrideDisplay?>>
   <td  align="right" valign="top" class="blackbold"> 
   Items :<span class="red">*</span> </td>
   <td   align="left" valign="top">

   <? 	/*if($_GET['edit'] >0){*/ 	?>
           
           
   <? /* }else */  ?> <? if(sizeof($arryItem)>0){ 

           if(sizeof($arryItem)>1) { $DivStyle = 'style="height:20px;overflow-y:auto "';} 
           ?>

           <div id="PermissionValue" style="width:580px; height:180px; overflow:auto">  
           <table width="100%"  border="0" cellspacing=0 cellpadding=2>
           <tr> 
           <?   
           $flag = 0;
           if(sizeof($arryItem)>0) {					   
           for($i=0;$i<sizeof($arryItem);$i++) { 

           if ($flag % 2 == 0) {
           echo "</tr><tr>";
           }

           $Line = $flag+1;
           ?>

           <td align="left"  valign="top" width="320" height="20">
           <input type="checkbox" name="ItemID[]" id="ItemID<?=$Line?>" <? if($arryItem[$i]['OverrideItem']==1){ echo "checked";}?> value="<?=$arryItem[$i]['ItemID'];?>">&nbsp;

           <?=stripslashes($arryItem[$i]['Sku']);?> [<?=stripslashes($arryItem[$i]['OverspiffAmt']);?>] <br> [<?=stripslashes($arryItem[$i]['description']);?>]							</td>
           <?
           $flag++;
           } 
           ?>
           </tr>

           <? }  ?>

           </table>
           <input type="hidden" name="Line" id="Line" value="<? echo sizeof($arryItem);?>">
           </Div>	
           <?  if(sizeof($arryItem)>1) {	?>
           <div align="right">
           <a href="javascript:SelectAllRecord();">Select All</a> | <a href="javascript:SelectNoneRecords();" >Select None</a>
           </div>	
           <? } ?>					



   <? }else{ 
   $HideSibmit = 1;
   echo NO_EMPLOYEE_EXIST;
   } ?>
   </td>
   </tr>

                                               <tr id="OverrideDisamt" <?=$overrideDisplay?>>
                                                <td  align="right" valign="top"   class="blackbold"> Override Amount <span id="percen" <?=$hidePerShow?>>%</span> </td>
                                                <td align="left" valign="top">
                                                    <input name="OverspiffAmt" id="OverspiffAmt"  class="inputbox" value="<?=$arryCategory[0]['OverspiffAmt']?>" >
                                                 </td>
                                              </tr>


                                            <tr> 
                                                <td   align="right" valign="top"    class="blackbold"> 
                                                    Image : </td>
                                                <td  height="50" align="left" valign="top" class="blacknormal"> 
                                                    <input name="Image" type="file" class="inputbox" id="Image" size="19"  onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false">
                                                    <br>
                                                    (Note : Supported file types for image are: jpg, gif.) </td>
                                            </tr>
                                            <?php


				
			if(IsFileExist($Config['ItemCategory'],$arryCategory[0]['Image'])){ 
			$OldImage =  $arryCategory[0]['Image'];

			$ImageExist = 1;
                                               
                                                ?>
                                                <tr > 
                                                    <td  align="right"  class="blackbold" valign="top"> </td>
                                                    <td  height="30" align="left" valign="top"> 
<span id="DeleteSpan">
<input type="hidden" name="OldImage" value="<?=$OldImage?>">
<?php
	$PreviewArray['Folder'] = $Config['ItemCategory'];
	$PreviewArray['FileName'] = $arryCategory[0]['Image']; 
	$PreviewArray['NoImage'] = $Prefix."images/no.jpg";
	$PreviewArray['FileTitle'] = stripslashes($arryCategory[0]['Name']);
	$PreviewArray['Width'] = "200";
	$PreviewArray['Height'] = "200";
	$PreviewArray['Link'] = "1";
	echo '<br><br><div id="ImageDiv">'.PreviewImage($PreviewArray).'
	&nbsp;<a href="Javascript:void(0);" onclick="Javascript:RemoveFile(\''.$Config['ItemCategory'].'\',\''.$arryCategory[0]['Image'].'\',\'ImageDiv\')">'.$delete.'</a><input type="hidden" name="OldImage" value="'.$OldImage.'"></div>';

?>
                                                       

</span>
                                                    </td>
                                                </tr>
                                               <? } ?>



                                            <tr >
                                                <td align="right" valign="middle"  class="blackbold">Status  </td>
                                                <td align="left" class="blacknormal">
                                                    <table width="151" border="0" cellpadding="0" cellspacing="0" class="margin-left"  class="blacknormal">
                                                        <tr>
                                                            <td width="20" align="left" valign="middle"><input name="Status" type="radio" value="1" <?= ($CategoryStatus == 1) ? "checked" : "" ?> /></td>
                                                            <td width="48" align="left" valign="middle">Active</td>
                                                            <td width="20" align="left" valign="middle"><input name="Status" type="radio" <?= ($CategoryStatus == 0) ? "checked" : "" ?> value="0" /></td>
                                                            <td width="63" align="left" valign="middle">Inactive</td>
                                                        </tr>
                                                    </table>                      
                                                </td>
                                            </tr>
                                              <tr>
                                                <td  align="right" valign="top"   class="blackbold"> Sort Order </td>
                                                <td align="left" valign="top">
                                                    <input  name="sort_order" id="sort_order" value="<?= stripslashes($arryCategory[0]['sort_order']) ?>" type="text" class="inputbox"  size="30" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td  align="right" valign="top"   class="blackbold"> Description </td>
                                                <td align="left" valign="top">
                                                    <Textarea name="CategoryDescription" id="CategoryDescription" class="inputbox"  ><? echo stripslashes($arryCategory[0]['CategoryDescription']); ?></Textarea>
                                                           <script type="text/javascript">

                                                        var editorName = 'CategoryDescription';

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
                            <input type="hidden" name="CategoryID" id="CategoryID" value="<?php echo $_GET['edit']; ?>">   


                            <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?= $ButtonTitle ?> " />&nbsp;
                            <input type="reset" name="Reset" value="Reset" class="button" /></td>
                    </tr>

                </table></TD>
        </TR>
    </form>
</TABLE>
