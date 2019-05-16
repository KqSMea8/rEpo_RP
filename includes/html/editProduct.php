 <script type="text/javascript" src="admin/FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="admin/js/ewp50.js"></script>
<script type="text/javascript">
	var ew_DHTMLEditors = [];
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"  width="100%" valign="top">
		<? $ModuleTitle = (!empty($_GET['edit']))?(EDIT_PRODUCT) :(ADD_NEW_PRODUCT);?>
	<table cellspacing="0" cellpadding="0" width="100%" align="center">
      
	   <tr>
        <td  align="left" valign="middle" class="heading"><?=$ModuleTitle?></td>
      </tr>
	  <tr>
        <td  align="left" valign="middle" class="pagenav">
		
	
		
		<span ><?=$Nav_Home?>  <?=$Nav_MemberPortal?>  <a href="viewProducts.php"><?=MY_PRODUCTS?></a> </span> <?=$ModuleTitle?></td>
      </tr>
     
     
	   <tr>
          <td height="35"><strong>Category :</strong> <?=$MainParentCategory?> <?=$ParentCategory?></td>
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
<a href="viewProducts.php" class="skytxt">Choose another category</a>			  
<br> <br>				
			<a href="<?=$RedirectURL?>">Back</a>
            </td>
          </tr> 
		  <tr>
            <td colspan="2" align="right" height="15">

            </td>
          </tr>  
		   <tr>
            <td colspan="2" align="right"  valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td >
				
<table width="100%" border="0" cellspacing="0" cellpadding="5" class="generaltxt_inner">
 <tr style="display:none">
            <td   valign="top"  >Category <span class="bluestar">*</span>                 </td>
            <td  align="left" valign="top"><? if(sizeof($arrayMainCategory)>0) { ?>
                <select name="Category" class="txtfield"  id="Category" onchange="SubCategoryListSend(1);" style="width:185px;">
                  <option value="">--- Select ---</option>
                  <? for($i=0;$i<sizeof($arrayMainCategory);$i++) {?>
                  <option value="<?=$arrayMainCategory[$i]['CategoryID']?>" <?  if($arrayMainCategory[$i]['CategoryID']==$CategoryID){echo "selected";}?>>
                  <?=stripslashes($arrayMainCategory[$i]['Name'])?>
                  </option>
                  <? } ?>
                </select>
                <? } else{ ?>
                <span class="bluestar">
                  <?=NO_CATEGORY_FOUND?>
                  </span>
                <? }?>                           </td>
          </tr>
          <tr style="display:none">
            <td    id="SubCatTitle" valign="top"></td>
            <td align="left" id="SubCatTd" valign="top"></td>
          </tr>
		  <tr style="display:none">
            <td id="StoreCatTitle" valign="top"></td>
            <td align="left" id="StoreCatTd" valign="top"></td>
          </tr>
	  
           <tr>
             <td    valign="top">Brand </td>
             <td   align="left"><select name="brandID" class="txtfield" id="brandID" style="width:190px;">
               <option value="">--- Select ---</option>
               <? for($i=0;$i<sizeof($arryBrand);$i++) {?>
               <option value="<?=$arryBrand[$i]['brandID']?>" <?  if($arryBrand[$i]['brandID']==$arryProduct[0]['brandID']){echo "selected";}?>>
               <?=stripslashes($arryBrand[$i]['heading'])?>
               </option>
               <? } ?>
             </select></td>
           </tr>
           <tr>
            <td  width="15%"     valign="top">Product Name
                <span class="bluestar">*</span> </td>
            <td   align="left">
			
			<input name="Name" id="Name" value="<?=stripslashes($arryProduct[0]['Name'])?>" type="text" class="txtfield"   size="31" maxlength="80" />	<input type="hidden" name="CategoryID" id="CategoryID" value="<?php echo $CategoryID; ?>" /> 		</td>
          </tr>
		   <tr>
            <td valign="top">Product Code               </td>
            <td align="left">
			<input name="ProductNumber" id="ProductNumber" value="<?=stripslashes($arryProduct[0]['ProductNumber'])?>" type="text" class="txtfield" size="31" maxlength="40" />					</td>
          </tr>
		  
		  <tr>
            <td valign="top">Product Size                </td>
            <td align="left">
			<input name="ProductSize" id="ProductSize" value="<?=stripslashes($arryProduct[0]['ProductSize'])?>" type="text" class="txtfield" size="31" maxlength="100" />	
             <br><?=SEPARATE_ENTRIES_COMMAS?>					</td>
          </tr>
		  
          <tr>
            <td valign="top">Size Description</td>
            <td  align="left"><textarea name="SizeMeaning" id="SizeMeaning" class="txtfield"  ><?=stripslashes($arryProduct[0]['SizeMeaning'])?></textarea>
			
<script type="text/javascript">

var editorName = 'SizeMeaning';

var editor = new ew_DHTMLEditor(editorName);

editor.create = function() {
	var sBasePath = 'admin/FCKeditor/';
	var oFCKeditor = new FCKeditor(editorName, '350', 200, 'Basic');
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
    <td valign="top">Product Style </td>
    <td  align="left"><input  name="ProductStyle" id="ProductStyle" value="<?=stripslashes($arryProduct[0]['ProductStyle'])?>" class="txtfield"  size="31" maxlength="40" /> </td>
  </tr>   

		
		  <tr>
            <td  valign="top"  >Item Description</td>
            <td   align="left">
<textarea name="Detail" id="Detail" class="txtfield"   ><?=stripslashes($arryProduct[0]['Detail'])?></textarea>	

<script type="text/javascript">

var editorName = 'Detail';

var editor = new ew_DHTMLEditor(editorName);

editor.create = function() {
	var sBasePath = 'admin/FCKeditor/';
	var oFCKeditor = new FCKeditor(editorName, '350', 200, 'Basic');
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
            <td  valign="top"  ><?=DELIVERY_INFO?></td>
            <td   align="left">
<textarea name="DeliveryInfo" id="DeliveryInfo" class="txtfield"   ><?=stripslashes($arryProduct[0]['DeliveryInfo'])?></textarea>

<script type="text/javascript">

var editorName = 'DeliveryInfo';

var editor = new ew_DHTMLEditor(editorName);

editor.create = function() {
	var sBasePath = 'admin/FCKeditor/';
	var oFCKeditor = new FCKeditor(editorName, '350', 200, 'Basic');
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
    <td  valign="top" ><?=PAYMENT_TERMS?>  </td>
    <td  align="left" valign="top">
<Textarea name="PaymentTerms" id="PaymentTerms" class="txtfield"   ><? echo stripslashes($arryProduct[0]['PaymentTerms']); ?></Textarea>


<script type="text/javascript">

var editorName = 'PaymentTerms';

var editor = new ew_DHTMLEditor(editorName);

editor.create = function() {
	var sBasePath = 'admin/FCKeditor/';
	var oFCKeditor = new FCKeditor(editorName, '350', 200, 'Basic');
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
    <td   valign="top"  ><?=SUPPLIER_DETAILS?>  </td>
    <td  align="left" valign="top">
<Textarea name="SupplierDetails" id="SupplierDetails" class="txtfield"  ><? echo stripslashes($arryProduct[0]['SupplierDetails']); ?></Textarea>

<script type="text/javascript">

var editorName = 'SupplierDetails';

var editor = new ew_DHTMLEditor(editorName);

editor.create = function() {
	var sBasePath = 'admin/FCKeditor/';
	var oFCKeditor = new FCKeditor(editorName, '350', 200, 'Basic');
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
            <td    valign="top"><?=SEARCH_TAGS?>            </td>
            <td  align="left"><input name="SearchTag" type="text" class="txtfield"  id="SearchTag" value="<?php echo stripslashes($arryProduct[0]['SearchTag']); ?>" size="31" maxlength="50" />
               
                  <br><?=SEPARATE_ENTRIES_COMMAS?>               </td>
          </tr>
          <tr>
            <td   valign="top"  ><?=IMAGE?>            </td>
            <td align="left" height="50" valign="top"><input name="Image" type="file" class="txtfield"  id="Image" size="17"  onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false" />
             
             
                  <br><?=SUPPORTED_IMAGE_TYPES?>				 		   </td>
          </tr>
         
        
		  
	
<? for($i=1;$i<=$MaxProductImage;$i++){ ?>	
		 
		<tr> 
                        <td  height="80"  valign="top" nowrap> 
                          Alternative Image-<?=$i?> : </td>
                        <td  height="80" align="left" valign="top" > 
	
						
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="40%" valign="top"><input name="Image<?=$i?>" type="file" class="txtfield" id="Image<?=$i?>" size="17"  onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false"> </td>
    
<? 
$ImageName = $arryProduct[0]['Image'.$i];
if($ImageName !='' && file_exists('upload/products/'.$ImageName) ){
	$ImagePath = 'resizeimage.php?img=upload/products/'.$ImageName.'&w=60&h=60'; 
	echo '<td width="80" valign="top" align="right"  ><Div style="width:65px;height:65px;"><a href="upload/products/'.$ImageName.'" rel="lightbox" title=""><img src="'.$ImagePath.'" border=0 align=left></a></div><div></td><td valign="top" class="txt"><input type="checkbox" name="DelImage'.$i.'" value="upload/products/'.$ImageName.'">Delete</div></td>';
}

 ?>	
  </tr>
</table>		</td>
	  </tr>	
            
 <? }  ?>   	
		  

  
     <tr>
          <td  height="30" valign="top"  >Product Weight  <span class="bluestar">*</span></td>
          <td valign="top" align="left"><input name="Weight" type="text" class="txtfield"  id="Weight" value="<?php echo $arryProduct[0]['Weight']; ?>" size="10" maxlength="5" />  
          <span>LBS</span></td>
        </tr>

  
     <tr>
          <td  height="30" valign="top"  >Product Volume </td>
          <td valign="top" align="left"><input name="Volume" type="text" class="txtfield"  id="Volume" value="<?php echo $arryProduct[0]['Volume']; ?>" size="10" maxlength="5" />  
       </td>
        </tr>

   <tr>
          <td  height="30" valign="top"  ><?=PRICE?> <span class="bluestar">*</span></td>
          <td valign="top" align="left"><input name="Price" type="text" class="txtfield"  id="Price" value="<?php echo $arryProduct[0]['Price']; ?>" size="10" maxlength="10" />  <span><?=$StoreCurrency?><? //echo '<br>'.$VatPriceMsg; ?> </span></td>
        </tr>
		<tr>
          <td  height="30" valign="top"  ><?=TAX_EXEMPT?> </td>
          <td  valign="top" align="left">
            <input type="checkbox" name="TaxExempt" id="TaxExempt" value="1" <? if($arryProduct[0]['TaxExempt']=='1') echo 'checked'; ?>>         </td>
        </tr>
 		 <tr>
            <td><?=QUANTITY?>
                <span class="bluestar">*</span></td>
            <td  align="left"><input name="Quantity" type="text" class="txtfield"  id="Quantity" value="<?php echo $arryProduct[0]['Quantity']; ?>" size="10" maxlength="10" />            </td>
          </tr>	
	  
		  
		  
		  
		  
		  
		  
          <? if($_GET['edit'] > 0){ 	   	
					 ?>
          <tr>
            <td   ><?=STATUS?>            </td>
            <td  align="left" >
		<? 
		 if($arryProduct[0]['Status'] ==1){
			  $status = '<span class="greentxt">Active</span>';
		 }else{
			  $status = '<span class="red12">InActive</span>';
		 }
		echo $status;
	 ?></td>
          </tr>
		  
		  
 <tr>
            <td   ><?=FEATURED?>            </td>
            <td  align="left" >
		<?  if($arryProduct[0]['Featured'] =='Yes'){
			  $status = '<span class="greentxt">Yes</span>';
		 }else{
			  $status = '<span class="red12">No</span>';
		 }
		echo $status;
	   ?>	 </td>
          </tr>	
	
	
  <? if($arryProduct[0]['Featured'] == 'Yes' && !empty($arryProduct[0]['FeaturedType'])){ ?>
<tr>
<td valign="top" ><?=FEATURED_TYPE?>            </td>
<td  align="left" valign="top" >
<? echo $arryProduct[0]['FeaturedType'].'<br>';
	if($arryProduct[0]['FeaturedType'] =='Duration'){
		echo ' ('.$arryProduct[0]['FeaturedStart'].' to '.$arryProduct[0]['FeaturedEnd'].')';
	}else{
		echo  '(Total Impressions:'.$arryProduct[0]['Impression'].', Impressions Shown: '.$arryProduct[0]['ImpressionCount'].')' ;
	}

?></td>
</tr>	

<? } ?>


 <tr style="display:none">
            <td   ><?=SPONSERED_ITEM?>            </td>
            <td  align="left" >
		<?  if($arryProduct[0]['Sponser'] =='Yes'){
			  $status = '<span class="greentxt">Yes</span>';
		 }else{
			  $status = '<span class="red12">No</span>';
		 }
		echo $status;
	   ?>	 </td>
          </tr>	
	
	
  <? if($arryProduct[0]['Sponser'] == 'Yes' && !empty($arryProduct[0]['SponserType'])){ ?>
 <tr style="display:none">
<td valign="top" ><?=SPONSERED_TYPE?>            </td>
<td  align="left" valign="top" >
<? echo $arryProduct[0]['SponserType'].'<br>';
	if($arryProduct[0]['SponserType'] == 'Duration'){
		echo ' ('.$arryProduct[0]['SponserStart'].' to '.$arryProduct[0]['SponserEnd'].')';
	}else{
		echo  '(Total Impressions:'.$arryProduct[0]['SponserImpression'].', Impressions Shown: '.$arryProduct[0]['SponserImpressionCount'].')' ;
	}

?></td>
</tr>
		  
<? } ?>		

  
<? } ?>		  	  
 <tr>
    <td valign="top">Recommended</td>
    <td align="left" valign="top">&nbsp;<select name="Special" id="Special" class="txtfield" >
      <option value="No" <? if($arryProduct[0]['Special'] == 'No') echo 'selected';?>>No</option>
      <option value="Yes" <? if($arryProduct[0]['Special'] == 'Yes') echo 'selected';?>>Yes</option>
    </select>	 	</td>
  </tr>
          
          <tr>
            <td  valign="middle" >&nbsp;</td>
            <td align="left" valign="middle" ><? 
			
			if($_GET['edit'] >0) $ButtonTitle="Update"; else $ButtonTitle="Submit";
			
			$PostedByID  = $arryProduct[0]['PostedByID'];
			if($PostedByID<=1)  $PostedByID = 1;
		
			if(sizeof($arrayMainCategory)<=0)  $DisabledButton = 'disabled';
			
			if($LimitCrossed==1)  $DisabledButton = 'disabled';
			
			?>
              <table  border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td ><input type="submit"  class="button" name="SubmitButton"  id="SubmitButton"  value="<?=$ButtonTitle?>" alt=" <?=$ButtonTitle?> " title=" <?=$ButtonTitle?> " <?=$DisabledButton?>/></td>
				<td>&nbsp;</td>
                <td ><input type="reset" name="Reset" value="Reset" class="button"  <?=$DisabledButton?>/>
				
				
				<input type="hidden" name="MaxProductImage" id="MaxProductImage" value="<? echo $MaxProductImage; ?>" />
				
                  <input type="hidden" name="ProductID" id="ProductID" value="<?php echo $_GET['edit']; ?>" />
                  <input type="hidden" name="PostedByID" id="PostedByID" value="<?php echo $_SESSION['MemberID']?>" />
                  <input type="hidden" name="OldCategoryID" id="OldCategoryID" value="<?php echo $arryProduct[0]['CategoryID']; ?>" />
                  <input type="hidden" name="OldStoreCategoryID" id="OldStoreCategoryID" value="<?php echo $arryProduct[0]['StoreCategoryID']; ?>" />
				   <input type="hidden" name="MainStoreCategoryID" id="MainStoreCategoryID" value="<?php echo $arryProduct[0]['StoreCategoryID']; ?>" />
				  <input  type="hidden" name="Status" id="Status" value="<?=$ProductStatus?>" />
                  <input  type="hidden" name="Featured" id="Featured" value="<?=$arryProduct[0]['Featured']?>" />
				  
                  <input  type="hidden" name="FeaturedType" id="FeaturedType" value="<?=$arryProduct[0]['FeaturedType']?>" />
                  <input  type="hidden" name="Impression" id="Impression" value="<?=$arryProduct[0]['Impression']?>" />
                  <input  type="hidden" name="ImpressionCount" id="ImpressionCount" value="<?=$arryProduct[0]['ImpressionCount']?>" />
                  <input  type="hidden" name="FeaturedStart" id="FeaturedStart" value="<?=$arryProduct[0]['FeaturedStart']?>" />
                  <input  type="hidden" name="FeaturedEnd" id="FeaturedEnd" value="<?=$arryProduct[0]['FeaturedEnd']?>" />
				  
				  
<input  type="hidden" name="Sponser" id="Sponser" value="<?=$arryProduct[0]['Sponser']?>" />
<input  type="hidden" name="SponserAmount" id="SponserAmount" value="<?=$arryProduct[0]['SponserAmount']?>" />
<input  type="hidden" name="SponserImpression" id="SponserImpression" value="<?=$arryProduct[0]['SponserImpression']?>" />
<input  type="hidden" name="SponserImpressionCount" id="SponserImpressionCount" value="<?=$arryProduct[0]['SponserImpressionCount']?>" />
<input  type="hidden" name="SponserStart" id="SponserStart" value="<?=$arryProduct[0]['SponserStart']?>" />
<input  type="hidden" name="SponserEnd" id="SponserEnd" value="<?=$arryProduct[0]['SponserEnd']?>" />
<input  type="hidden" name="SponserType" id="SponserType" value="<?=$arryProduct[0]['SponserType']?>" />				  </td>
              </tr>
            </table>              </td>
          </tr>
</table>

				
				</td>
                <td valign="top" align="right" style="padding-left:5px;" >
 		<? if($arryProduct[0]['Image'] !='' && file_exists('upload/products/'.$arryProduct[0]['Image']) ){ 
			$ImagePath = 'resizeimage.php?img=upload/products/'.$arryProduct[0]['Image'].'&w=200&h=200'; 

			$ImagePath = '<a href="upload/products/'.$arryProduct[0]['Image'].'" rel="lightbox" title="'.stripslashes($arryProduct[0]['Name']).'"><img src="'.$ImagePath.'"  border="0" class="imgborder_prd"/></a>';
			echo $ImagePath;
			
		}
		   ?>
                        
                       		
				
				
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

 <SCRIPT LANGUAGE=JAVASCRIPT>
	//SubCategoryListSend();
</SCRIPT>