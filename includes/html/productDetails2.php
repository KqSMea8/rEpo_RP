<? if($arryProductDetail[0]['Image'] !='' && file_exists('upload/products/'.$arryProductDetail[0]['Image'])){  ?>
<style type="text/css">

.magnifyarea{ /* CSS to add shadow to magnified image. Optional */
box-shadow: 5px 5px 7px #818181;
-webkit-box-shadow: 5px 5px 7px #818181;
-moz-box-shadow: 5px 5px 7px #818181;
filter: progid:DXImageTransform.Microsoft.dropShadow(color=#818181, offX=5, offY=5, positive=true);
background: white;
margin-left:15px;
}

</style>
<script type="text/javascript" src="zoom2/jquery.min.js"></script>
<script type="text/javascript" src="zoom2/featuredimagezoomer.js"></script>


<script type="text/javascript">
var image_name = '<?=$arryProductDetail[0]['Image']?>';

jQuery(document).ready(function($){

	$('#myimage').addimagezoom({
		zoomrange: [3, 10],
		magnifiersize: [300,300],
		magnifierpos: 'right',
		largeimage: 'upload/products/'+image_name //<-- No comma after last option!
	})
	
	$('#image2').addimagezoom({
		zoomrange: [5, 5],
		magnifiersize: [400,400],
		magnifierpos: 'right',
		largeimage: 'zoom2/bigimage04.jpg' //<-- No comma after last option!
	})

	$('#image3').addimagezoom()

})

</script>
<? } ?>


<script type="text/javascript" src="tabber.js"></script>
<link rel="stylesheet" href="example.css" TYPE="text/css" MEDIA="screen">
<script type="text/javascript" src="thumbscroller.js"></script>

<table width="100%" border="0" cellspacing="0" cellpadding="0" >
  <tr>
            <td  class="pagenav" align="right"><?=$Nav_Home?> <?=$MainParentCategory?> <?=$ParentCategory?>
            </td>
          </tr>
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
	  
	   <? if($arryProductDetail[0]['Image'] !='' && file_exists('upload/products/'.$arryProductDetail[0]['Image'])){ 
	   
	   

			list($width_orig, $height_orig) = getimagesize('upload/products/'.$arryProductDetail[0]['Image']);
			
			if($width_orig>=300 || $height_orig>=300){
				$zoom_apend = ' data-zoomsrc="upload/products/'.$arryProductDetail[0]['Image'].'" id="myimage"';

				$TextClickImage = 'Rollover image above to zoom';
			}else{
				$TextClickImage = 'Click image above to enlarge';
			}

			
			$ImagePath = 'resizeimage.php?img=upload/products/'.$arryProductDetail[0]['Image'].'&w=400&h=400'; 


			$ImagePath = '<a href="upload/products/'.$arryProductDetail[0]['Image'].'" rel="lightbox" title="'.stripslashes($arryProductDetail[0]['Name']).'"><img src="'.$ImagePath.'"  border="0"  '.$zoom_apend.'/></a>';

			$EnlargeImage = '<a href="upload/products/'.$arryProductDetail[0]['Image'].'" class="rollover" rel="lightbox" title="'.stripslashes($arryProductDetail[0]['Name']).'">'.$TextClickImage.'</a>';
	   
	   
	   ?>
        <td width="47%" align="center" valign="top">
		<?
		echo '<div id="MainImgDiv">'.$ImagePath.'<br><br>'.$EnlargeImage.'</div><div class="clearfix"></div>';
		
		?>
		

		<? $AlternativeCount = 0;
		for($i=1;$i<=3;$i++){
			$MainImage = $arryProductDetail[0]['Image'.$i];
			$MainPath = 'upload/products/'.$MainImage;
			
			if($MainImage !='' && file_exists($MainPath) ){
				
				$AlternativeCount++;
				
				$zoom_apend = '';
				$TextClickImage = 'Click image above to enlarge';
				/*
				list($width_orig, $height_orig) = getimagesize($MainPath);
				
				if($width_orig>=450 ){
					$zoom_apend = ' data-zoomsrc="'.$MainPath.'" id="myimage"';
	
					$TextClickImage = 'Rollover image above to zoom';
				}*/
				
				
				$ImagePath = 'resizeimage.php?img='.$MainPath.'&w=400&h=400'; 
	
	
				$ImagePath = '<a href="'.$MainPath.'" rel="lightbox" title=""><img src="'.$ImagePath.'"  border="0"  '.$zoom_apend.'/></a>';
	
				$EnlargeImage = '<a href="'.$MainPath.'" class="rollover" rel="lightbox" title="'.stripslashes($arryProductDetail[0]['Name']).'">'.$TextClickImage.'</a>';			
				/***********/				
				
				
				echo '<div id="OtherImgDiv'.$AlternativeCount.'" style="display:none;">
					'.$ImagePath.'
					<br><br>'.$EnlargeImage.'
				</div><div class="clearfix"></div>';			
			}
		}
		?>
				
		
	<table width="440" border="0" cellspacing="0" cellpadding="0">
	
	<tr>
		<td >
		<input type="hidden" name="AlternativeCount" id="AlternativeCount" value="<?=$AlternativeCount?>" />
		</td>
	  </tr>
	
	<tr>
		<td align="center" valign="top">
		
		
		<table  border="0" cellspacing="2" cellpadding="2">
			<tr>
		<? 
		if($AlternativeCount>0){
			$ImagePath = 'resizeimage.php?img=upload/products/'.$arryProductDetail[0]['Image'].'&w=90&h=90'; 

			echo '<td align="center"><a href="Javascript:ShowHideBigImage();" ><img src="'.$ImagePath.'" border="0" /></a></td>';			
		}
		
		$AlternativeCount = 0;
		for($i=1;$i<=3;$i++){
			$MainImage = $arryProductDetail[0]['Image'.$i];
			$MainPath = 'upload/products/'.$MainImage;
			
			if($MainImage !='' && file_exists('upload/products/'.$MainImage) ){
				$AlternativeCount++;
				
				$ImagePath = 'resizeimage.php?img='.$MainPath.'&w=90&h=90'; 
				
				echo '<td align="center"><a href="Javascript:ShowHideBigImage('.$AlternativeCount.');" ><img src="'.$ImagePath.'" border="0" /></a></td>';			
			}
		}
		?>
	  </tr>
 	 </table>
		
		
		
		
		</td>
	  </tr>
	  
	  
 	 </table>
	
		
		</td>
		
		<? } ?>
		
		
        <td width="53%" align="right" valign="top">
		
		 <form name="formQnt" method="get" action="cart.php" onsubmit="return validate(this);" >
		
		<table width="96%" border="0" align="right" cellpadding="0" cellspacing="0">
          <tr>
            <td height="40" align="left" valign="top" class="productname"><?=ucfirst(stripslashes($arryProductDetail[0]['Name']))?></td>
          </tr>
          <tr>
            <td height="40" align="left" valign="top" class="productname" style="font-size:18px;"><?=$PriceHTML?></td>
          </tr>
          <tr>
            <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <? if(!empty($arryProductDetail[0]['ProductNumber'])){ ?>
			  <tr>
                <td height="35"  align="left" ><?=PRODUCT_NUMBER?>: </td>
                <td  height="35" align="left" ><?=$arryProductDetail[0]['ProductNumber']?></td>
              </tr>
			  <? } ?>
			  
			   
			  <!--
              <tr>
                <td height="35" width="23%"  align="left" valign="top">Wholesale Price:</td>
                <td height="35" width="77%" align="left" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#bcbbbb">
                  <tr>
                    <td width="33%" height="30" align="center" valign="middle" bgcolor="#FFFFFF"><strong>Quantity (piece)</strong></td>
                    <td width="34%" height="30" align="center" valign="middle" bgcolor="#FFFFFF"><strong>Price (Per piece)</strong></td>
                    <td width="33%" height="30" align="center" valign="middle" bgcolor="#FFFFFF"><strong>Processing Time</strong></td>
                  </tr>
                  <tr>
                    <td height="30" align="center" valign="middle" bgcolor="#FFFFFF">1 - 3</td>
                    <td height="30" align="center" valign="middle" bgcolor="#FFFFFF">$98.97</td>
                    <td height="30" align="center" valign="middle" bgcolor="#FFFFFF">5 Days</td>
                  </tr>
                  <tr>
                    <td height="30" align="center" valign="middle" bgcolor="#FFFFFF">1 - 3</td>
                    <td height="30" align="center" valign="middle" bgcolor="#FFFFFF">$98.97</td>
                    <td height="30" align="center" valign="middle" bgcolor="#FFFFFF">5 Days</td>
                  </tr>
                  <tr>
                    <td height="30" align="center" valign="middle" bgcolor="#FFFFFF">1 - 3</td>
                    <td height="30" align="center" valign="middle" bgcolor="#FFFFFF">$98.97</td>
                    <td height="30" align="center" valign="middle" bgcolor="#FFFFFF">5 Days</td>
                  </tr>
                  <tr>
                    <td height="30" align="center" valign="middle" bgcolor="#FFFFFF">1 - 3</td>
                    <td height="30" align="center" valign="middle" bgcolor="#FFFFFF">$98.97</td>
                    <td height="30" align="center" valign="middle" bgcolor="#FFFFFF">5 Days</td>
                  </tr>
                </table></td>
              </tr>
			  -->
			
			  <?  if(!empty($arryProductDetail[0]['ProductSize'])){
			  ?>
              <tr>
                <td height="35" align="left" valign="middle">Select Size:</td>
                <td height="35" align="left" valign="middle">
				<?
				
				$ArrySize = explode(',',$arryProductDetail[0]['ProductSize']);
				$SizeHtml = '<select name="Size" class="txtfield_list"><option value="">--select--</option>';
				foreach($ArrySize as $size_temp){
					$Size = trim($size_temp);
					$SizeHtml .= '<option value="'.$Size.'">'.$Size.'</option>';
				}
				$SizeHtml .= '</select>';
				echo $SizeHtml;
				?>				</td>
              </tr>
			 <? } ?> 
              <tr>
                <td height="35" width="23%" align="left" valign="middle">Quantity:</td>
                <td height="35" align="left" valign="middle">
			<input type="text" name="Quantity" id="Quantity"  value="1"  class="txtfield_quantity" maxlength="4" onkeypress="set_tax_price(1);" onchange="set_tax_price(1);" onkeydown="set_tax_price(1);" onkeyup="set_tax_price(1);" onblur="set_tax_price(1);"/>	
			
	<input name="Price" id="Price" type="hidden" value="<?=round($Price,2)?>" />
<input name="ProductID" id="ProductID" type="hidden" value="<?=$arryProductDetail[0]['ProductID']?>" />

<input name="AvailableQuantity"  id="AvailableQuantity" value="<?=$arryProductDetail[0]['Quantity']?>" type="hidden" /> 

<input name="Tax" id="Tax" type="hidden" value="<?=$Tax?>" />
<input name="StoreID" id="StoreID" type="hidden" value="<?=$arryProductDetail[0]['PostedByID']?>" /></td>
              </tr>
              <tr>
                <td height="35" align="left" valign="middle">Shipping Cost:</td>
                <td height="55" align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td height="20" align="left" valign="middle"><a href="#" onclick="OpenNewPopUp('free_shipping.php', 650, 600, 'yes' );" class="freeshippinglink">Free Shipping</a> to</td>
                  </tr>
                  <tr>
                    <td height="20" align="left" valign="middle"><strong>United States Via EMS</strong></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td height="35" align="left" valign="middle">Total Price:</td>
                <td height="35" align="left" valign="middle" id="TotalPriceDiv">
				<?
				$TotalPrice = $Price+$Tax;
				
				echo '<strong>'.display_price($Price,'','',$arryCurrency[0]['symbol_left'],$arryCurrency[0]['symbol_right']).' x 1 + '.display_price($Tax,'','',$arryCurrency[0]['symbol_left'],$arryCurrency[0]['symbol_right']).'</strong> = <span class="redtxt_big">'.display_price($TotalPrice,'','',$arryCurrency[0]['symbol_left'],$arryCurrency[0]['symbol_right']).'</span>';
				
				?>
		</td>
              </tr>
            </table></td>
          </tr>
		   <? if($arryProductDetail[0]['Quantity']>0){ ?>
		  
          <tr>
            <td height="75" align="left" valign="middle"> <input type="image" src="images/addtocart.jpg" alt="Add To Cart" value="Add To Cart"  />
			
			<?=$VisitStore?>
			
			</td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="23%" align="left" valign="top"><img src="images/escrow.jpg" alt="scrow" /></td>
                <td width="77%" align="left" valign="top">Payment is only released to suppliers after you confirm delivery. Escrow is free and easy to use.</td>
              </tr>
            </table></td>
          </tr>
		  <? }else{ ?>
		  <tr>
            <td height="75" align="left" valign="middle"> <div class="redtxt_big"><b>Out of stock</b></div><br> <?=$VisitStore?></td>
          </tr>
		  <? } ?>
				
        </table>
		
		</form>
		
		</td>
      </tr>
    </table></td>
  </tr>
		  <tr>
            <td valign="top" align="left" height="20" >
			</td>
  </tr>
			
			<? if(sizeof($arrySimilarItems)>0){ ?>
		  <tr>
            <td valign="top" class="similaritembg" align="left" >
			
			
			
			
			<table width="400" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="50" align="left" valign="top" class="subtotalbig">Similar Items</td>
              </tr>
              <tr>
                <td><table width="100%" cellpadding="0" cellspacing="0">
                  <tr valign="top">
                    <td width="45" align="left" valign="middle"><a id="isFlowersPreviousButton" href="javascript:isFlowers.scrollReverse();"> <img src="images/largearrow_right.jpg" alt="See previous images" border="0" /></a> </td>
                    <td width="318"><div id="isFlowersFrame" name="isFlowersFrame" style="margin: auto; padding: 0px;
                    position: relative; overflow: hidden;">
                      <div id="isFlowersImageRow" name="isFlowersImageRow" style="position: absolute; top: 0px;
                        left: 0px;">
                        <script type="text/javascript">
							var isFlowers = new ImageScroller("isFlowersFrame", "isFlowersImageRow");
							    //**    [begin] Modify these to change your images  **//
								
	<? foreach($arrySimilarItems as $key=>$values){
								
		if($values['Image'] !='' && file_exists('upload/products/'.$values['Image']) ){  
			$ImagePath = 'resizeimage.php?img=upload/products/'.$values['Image'].'&w=100&h=100'; 
		}else{
			$ImagePath = 'images/no.gif'; 
		} 
		
	    $PrdLink   = 'productDetails.php?id='.$values['ProductID'];
								
    ?>
								isFlowers.addThumbnail('<?=$ImagePath?>','<?=$PrdLink?>','<?=stripslashes($values['Name'])?>','');
								<? } ?>
								//**    [end]   Modify these to change your images  **//								
								isFlowers.setThumbnailHeight(100);
								isFlowers.setThumbnailWidth(100);
								isFlowers.setThumbnailPadding(0);
								isFlowers.setScrollType(0);
								isFlowers.enableThumbBorder(false);
								isFlowers.setClickOpenType(0);
								isFlowers.setThumbsShown(3);
								isFlowers.setNumOfImageToScroll(3);
								isFlowers.renderScroller();
                        </script>
                      </div>
                    </div></td>
                    <td width="45" align="right" valign="middle"><a id="isFlowersNextButton" href="javascript:isFlowers.scrollForward();"> <img src="images/largearrow_left.jpg" alt="See next images"
                        border="0" /></a> </td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
		  <? } ?>
  <tr>
    <td valign="top" align="left"><div class="tabber">
      
	  <div class="tabbertab">
        <h2>Customer Feedback</h2>
        <p></p>
		
		<div class="skytxt" style="height:20px;" align="right"><a href="Javascript:PostFeedback();">Write your comments</a></div>
		
<div style="overflow-y:auto; height:250px;">		
<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <? if(sizeof($arryFeedback)>0){ 
 
  foreach($arryFeedback as $key=>$values){?>
		
  <tr>
    <td class="txt" valign="top" width="10"  style="padding-top:4px;"><img src="images/arrownext.jpg"></td>
	 <td class="txt" valign="top" align="left">
	<?
	echo nl2br(stripslashes($values['Comment']));
	
	?> </td>
  </tr>
  
  <tr>
    <td height="10" colspan="2">
	 </td>
  </tr>
   <tr>
   <td></td>
    <td>
	<?
	echo '<i><strong>Posted by:</strong> '. stripslashes($values['Name']).' on '.date("jS F, Y H:i:s", strtotime($values['feedbackDate'])).'</i>';
	?>
	 </td>
  </tr>
   <tr>
    <td height="20" colspan="2">
	 </td>
  </tr>
  <? }} else{ ?>
    <tr>
    <td align="center" colspan="2" class="redtxt" height="30">No feedback has been posted yet.</td>
  </tr>
  <? } ?>
</table>
</div>	
		
		
		
		<div id="light" class="white_content" style="background:none;border:0px; top:600px;"  >	
		<form id="formFeedback" name="formFeedback" method="post" action=""  onsubmit="return validateFeedbackForm(this);">
		
<table width="420" border="0" cellpadding="0" cellspacing="0"  align="center"   >
  <tr  >
          <td height="11" ><img src="images/top.gif"></td>
        </tr>
		
	  <tr  >
          <td valign="top" bgcolor="#FFFFFF" >
		  		
		 <table width="90%" border="0" cellpadding="0" cellspacing="0"  align="center"   >
		 <tr>
		    <td align="center">
			<div style="float:right"><a href="Javascript:CloseAlert();"><img src="images/delete.png" border="0"></a></div>
			<div id="feedbackMsg" class="redtxt"></div>
			</td >
			</tr>
			</table>
		<div  id="MainFeedbackDiv">
        <table width="90%" border="0" cellpadding="0" cellspacing="0"  align="center"   >
          
		  <tr>
            <td  class="subtotalbig" colspan="2" bgcolor="#FFFFFF">
			 
			Write your comment            </td>
          </tr>  
		  
		  <tr>
		    <td  colspan="2" height="30">&nbsp;</td>
		    </tr>
		  <tr>
            <td align="left" height="30" valign="top" width="30%">Name * </td>
			<td align="left" valign="top">
			  <input type="text" name="Name" id="Name" class="txtfield" style="width:205px;" maxlength="40"/>			</td>
          </tr>
		   <tr>
            <td align="left" height="30" valign="top">Email Address *</td><td align="left" valign="top">
              <input type="text" name="Email" id="Email" class="txtfield" style="width:205px;" maxlength="100"/>
           </td>
          </tr>
		   <tr>
            <td align="left" valign="top" >Comments *</td><td align="left" valign="top">
              <textarea name="Comment" id="Comment" cols="45" rows="4" class="txtfield" style="width:205px;" ></textarea>
           </td>
          </tr>
		   <tr>
		    <td  colspan="2" height="10"></td>
		    </tr>
		   <tr>
            <td align="left" valign="top" >&nbsp;</td>
			<td align="left" valign="top" >
			<input type="submit" name="submit_feedback" value="Send" class="button" />
			<input name="prd_id" id="prd_id" type="hidden" value="<?=$arryProductDetail[0]['ProductID']?>" />			</td>
          </tr>
        </table>
		</div>
		</td>
        </tr>
		
 <tr  >
          <td height="11"><img src="images/bottom.gif"></td>
        </tr>
</table>		
		
		
		</form>
		</div>
        </p>
      </div>
	  <div class="tabbertab">
        <h2>Item Description</h2>
        <p></p>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="45" align="left" valign="top"><?=stripslashes($arryProductDetail[0]['Detail'])?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table>
        </p>
        <div class="clearfix"></div>
      </div>
      <div class="tabbertab">
        <h2><?=DELIVERY_INFO?></h2>
        <p></p>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="45" align="left" valign="top"><?=nl2br(stripslashes($arryProductDetail[0]['DeliveryInfo']))?></td>
          </tr>
          
        </table>
        </p>
      </div>
      <div class="tabbertab">
        <h2><?=PAYMENT_TERMS?></h2>
        <p></p>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="45" align="left" valign="top"><?=nl2br(stripslashes($arryProductDetail[0]['PaymentTerms']))?></td>
          </tr>
         
        </table>
        </p>
      </div>
      <div class="tabbertab">
        <h2><?=SUPPLIER_DETAILS?></h2>
        <p></p>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="45" align="left" valign="top"><?=nl2br(stripslashes($arryProductDetail[0]['SupplierDetails']))?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table>
        </p>
      </div>
      
    </div></td>
  </tr>
</table>

<div id="fade" class="black_overlay"></div>
<script language="javascript1.2" type="text/javascript">


function PostFeedback(){
	document.getElementById("MainFeedbackDiv").style.display = 'inline';
	document.getElementById("feedbackMsg").innerHTML = '';
	document.getElementById("Comment").value = '';

	/************************************/
	
	document.getElementById('fade').style.width = screen.width;
	document.getElementById('fade').style.height = '1500px';

	document.getElementById('light').style.display='block';
	document.getElementById('fade').style.display='block';
}

function ShowHideBigImage(opt){
	var AlternativeCount = document.getElementById('AlternativeCount').value;
	if(opt>0){
		document.getElementById("MainImgDiv").style.display = 'none';
		for(var i=1;i<=AlternativeCount;i++){
			if(opt==i){
				document.getElementById("OtherImgDiv"+i).style.display = 'block';
			}else{
				document.getElementById("OtherImgDiv"+i).style.display = 'none';
			}
		}
	}else{
		document.getElementById("MainImgDiv").style.display = 'block';
		for(var i=1;i<=AlternativeCount;i++){
			document.getElementById("OtherImgDiv"+i).style.display = 'none';
		}
		
	}
}

</script>
