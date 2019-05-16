
<div class="recommend_products_list block">  
        <?php if($num>0 ) {  ?>
       
        <ul class="listing_prod clearfix">
          <? 
                $i=0;
               foreach($arryProductRecommended as $key=>$values){
                $i++;
   
    		
		$Price = ($values['Price2']>0)?($values['Price']):($values['Price']);
		$PrdLink   = 'productDetails.php?id='.$values['ProductID'];
		
		if($values['Image'] !='' && file_exists('upload/products/images/'.$Config['CmpID'].'/'.$values['Image']) ){  
			$ImagePath = 'resizeimage.php?img=upload/products/images/'.$Config['CmpID'].'/'.$values['Image'].'&w=160&h=160'; 

			$ImagePath = '<img src="'.$ImagePath.'"  border="0" />';
			//$EnlargeImage = '<a onclick="OpenNewPopUp(\'showimage.php?img=upload/products/'.$values['Image'].'\', 150, 100, \'no\' );" href="#" class=skytxt>'.CLICK_TO_ENLARGE.'</a>';
		}else{
			$ImagePath = '<img src="../images/no.jpg" height="150" border="0" />';
			//$EnlargeImage = '';
		}
		?>
          <li <?php if($i%3==0){?> class="third"<?php }?>>
            <div class="img">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td valign="middle" align="center"><a href="<?=$PrdLink;?>" >
                    <?=$ImagePath?>
                    </a></td>
                </tr>
              </table>
            </div>
            <div class="name"> <a href="<?=$PrdLink;?>">
              <?=ucfirst(stripslashes($values['Name']));?>
              </a> </div>
            <div class="price">
              <?=display_price($Price);?>
            </div>
            <div class="details">
                <a href="<?=$PrdLink;?>"><input type="submit" value="Details" name=""></a>
            </div>
          </li>
          <?php } 
	 
	 ?>
        </ul>
     
        <? } else{ ?>
        <div class="productnotfound"><? echo "No Recommended Product Found"; ?></div>
        <? } ?>

</div>
