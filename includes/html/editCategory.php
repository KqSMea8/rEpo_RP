<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0" width="100%" align="center">
      <tr>
        <td height="32" align="left" valign="middle" class="pagenav">
		
		<? $ModuleTitle = (!empty($_GET['edit']))?(EDIT_CATEGORY) :(ADD_CATEGORY);?>
		
		<span ><?=$Nav_Home?>  <?=$Nav_MemberPortal?>  <a href="viewCategories.php"><?=MANAGE_CATAGORIES?></a> </span> <?=$ModuleTitle?></td>
      </tr>
      <tr>
        <td  align="left" valign="middle" class="heading"><?=$ModuleTitle?></td>
      </tr>
      <tr>
        <td height="15"></td>
      </tr>
      <tr>
        <td height="32"  align="center">
		
		 <form name="productForm" action=""  method="post" onSubmit="return validate(this);" enctype="multipart/form-data">	

		
		<table width="100%" border="0" cellpadding="0" cellspacing="0" >
          <? if(!empty($errMsg)){ ?>
          <tr>
            <td colspan="2" height="30" align="center" valign="top"  class="red12"><?=$errMsg?></td>
          </tr>
          <? } ?>
        
          <tr>
            <td colspan="2" align="right" height="35"  valign="top"  class="skytxt">
			<a href="viewCategories.php"><? echo MANAGE_CATAGORIES; ?></a></td>
          </tr> 
		  
		   <tr>
            <td colspan="2" align="right"  valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="68%">
				
<table width="100%" border="0" cellspacing="0" cellpadding="5" class="generaltxt_inner">
 
 <tr>
            <td width="25%"  valign="top"  ><?=CATEGORY_NEW_TITLE?>
                <span class="bluestar">*</span> </td>
            <td width="75%"  align="left" valign="top"><? if(sizeof($arrayMainCategory)>0) { ?><? } else{ ?>
                <span class="bluestar">
                  <?=NO_CATEGORY_FOUND?>
                  </span>
                <? }?>
                <input type="hidden" name="CategoryID" id="CategoryID" value="<?php echo $CategoryID; ?>" /> 
				           <select name="Category" class="txtfield_contact"  id="Category" onchange="SubCategoryListSend(1);" style="width:185px;">
                    <option value="">--- Select ---</option>
                  <? for($i=0;$i<sizeof($arrayMainCategory);$i++) {?>
                  <option value="<?=$arrayMainCategory[$i]['CategoryID']?>" <?  if($arrayMainCategory[$i]['CategoryID']==$CategoryID){echo "selected";}?>>
                  <?=stripslashes($arrayMainCategory[$i]['Name'])?>
                  </option>
                  <? } ?>
                </select></td>
          </tr>
          <tr>
            <td    id="SubCatTitle" valign="top"></td>
            <td align="left" id="SubCatTd" valign="top"></td>
          </tr>
          <tr>
            <td     valign="top"><?=CATEGORY_NAME?>
                <span class="bluestar">*</span> </td>
            <td   align="left" valign="top">
			
			<input name="Name" id="Name" value="<?=stripslashes($arryStoreCategory[0]['Name'])?>" type="text" class="txtfield_contact"   size="31" maxlength="80" /><?=SUBCATEGORY_SECONDARY?>
						</td>
          </tr>
		 
		  
		  
         
		  
		  
 	  	  
 <tr>
    <td valign="top"><?=STATUS?></td>
    <td align="left" valign="top">
	
      <input type="radio" name="Status" value="1" <? if($CategoryStatus == '1') echo 'checked';?>>Active
      <input type="radio"  name="Status" value="0" <? if($CategoryStatus == '0') echo 'checked';?>>InActive
   
		</td>
  </tr>
          
          <tr>
            <td  valign="middle" >&nbsp;</td>
            <td align="left" valign="middle" ><? 
			
			if($_GET['edit'] >0) $ButtonTitle="update.jpg"; else $ButtonTitle="add.jpg";
			
			$PostedByID  = $arryStoreCategory[0]['PostedByID'];
			if($PostedByID<=1)  $PostedByID = 1;
		
			if(sizeof($arrayMainCategory)<=0)  $DisabledButton = 'disabled';
			
			
			?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="80"><input type="image" name="SubmitButton"  id="SubmitButton" src="images/<?=$ButtonTitle?>" width="72" height="24" value=" "  alt=" <?=$ButtonTitle?> " title=" <?=$ButtonTitle?> " <?=$DisabledButton?>/></td>
                <td ><input type="reset" name="Reset"  width="72" height="24" value=" " class="ResetContact"  <?=$DisabledButton?>/>
				
				
				
                  <input type="hidden" name="StoreCategoryID" id="StoreCategoryID" value="<?php echo $_GET['edit']; ?>" />
                  <input type="hidden" name="PostedByID" id="PostedByID" value="<?php echo $_SESSION['MemberID']?>" />
                 <input type="hidden" name="OldCategoryID" id="OldCategoryID" value="<?php echo $arryStoreCategory[0]['CategoryID']; ?>" />
				 
				  


				  </td>
              </tr>
            </table>              </td>
          </tr>
          <tr>
            <td height="35" colspan="2" align="left" valign="middle" ><span class="bluestar">*</span> Required.</td>
          </tr>
</table>

				
				</td>
               
              </tr>
            </table></td>
          </tr>
         
        </table>
		
	</form>	
		
		
		</td>
      </tr>
    </table></td>
      <td align="right"  valign="top"><? require_once("includes/html/box/right.php"); ?>    </td>

  </tr>
</table>
</td>
  </tr>
</table>
 <SCRIPT LANGUAGE=JAVASCRIPT>
	SubCategoryListSend();
</SCRIPT>