<div class="main-container">
  <div class="mid_wraper clearfix">
    <?php include_once("includes/left.php"); ?>
    <div class="right_pen">
      <div class="products_list block">
        <h2>
          <?=$MenuTitle;?>
        </h2>
        <?php if($_GET['mode']=="search"){?>
        <div class="searchbox advancesearch">
          <form action="products.php"  method="get" enctype="multipart/form-data" name="MoreSearch" onsubmit="return MoreSearchValidate(this);">
            <table width="100%" border="0"  cellpadding="0" cellspacing="0">
              <tr>
                <td height="82"  valign="top"><table class="pro_search" width="100%" border="0" align="center" cellpadding="3" cellspacing="3">
                    <tr>
                      <td width="15%" height="30" style="text-align:right" valign="middle" class="txt">Search By</td>
                      <td width="35%" height="30"  valign="middle"><div class="sel-wrap-friont">
                          <select name="search_in" id="search_in">
                            <option value="all" <?php if($_GET['search_in']=="all"){echo "selected";}?>>Product Description</option>
                            <option value="name" <?php if($_GET['search_in']=="name"){echo "selected";}?>>Product Name</option>
                            <option value="id" <?php if($_GET['search_in']=="id"){echo "selected";}?>>Product Sku</option>
                          </select>
                        </div></td>
                      <td width="20%" height="30" style="text-align:right" valign="middle" class="txt"><?= ENTER_KEYWORD_ITEM ?></td>
                      <td width="30%" height="30"  valign="middle"><input name="search_str" id="search_str" type="text" value="<?=$_GET['search_str']?>"  class="txtfield_normal"  maxlength="30"/>
                      </td>
                    </tr>
                    <tr>
                         <td  style="text-align:right"  valign="middle" class="txt">Price From </td>
                      <td  align="left" valign="middle"><input name="priceFrom" id="priceFrom" type="text" onkeyup="keyup(this);" value="<?=$_GET['priceFrom'];?>"  class="txtfield_normal"  maxlength="10"/>
                      </td>  
                     <td style="text-align:right"  valign="middle" class="txt">Price To </td>
                      <td  align="left" valign="middle"><input name="priceTo" id="priceTo" type="text"  onkeyup="keyup(this);" value="<?=$_GET['priceTo'];?>" class="txtfield_normal"  maxlength="10"/>
                      </td>
                   
                    </tr>
                    <tr>
                       <td  height="30" style="text-align:right" valign="middle" class="txt">Manufacturer</td>
                      <td  height="30"  valign="middle"><div class="sel-wrap-friont">
                          <select name="Mfg" class="txtfield_normal" id="Mfg" >
                            <option value="" selected="selected">--- Select ---</option>
                            <? for ($i = 0; $i < sizeof($arryManufacturer); $i++) { ?>
                            <option value="<?= $arryManufacturer[$i]['Mid'] ?>" <? if ($arryManufacturer[$i]['Mid'] == $_GET['Mfg']) {
                                                                        echo "selected";
                                                                    } ?>>
                            <?= stripslashes($arryManufacturer[$i]['Mname']) ?>
                            </option>
                            <? } ?>
                          </select>
                        </div></td>  
                        
                      
                      <td style="text-align:right"  valign="middle" class="txt">Sort By</td>
                      <td  align="left" valign="middle"><div class="sel-wrap-friont">
                          <select name="shortBy" id="shortBy" class="txtfield_normal" >
                            <option value="" selected="selected">--None--</option>
                            <option value="Name">Product Name</option>
                            <option value="lprice">Lowest Price</option>
                            <option value="hprice">Highest Price</option>
                          </select>
                        </div></td>
                    </tr>
                    <tr>
                      <td class="botline" colspan="4"><div class="line"></div></td>
                    </tr>
                    <tr>
                      <td height="50" colspan="4" class="btn" align="center" valign="bottom">
                          <input name="" id="SubmitButton" type="submit" value="Search" class="button advaceSearch" />
                      </td>
                    </tr>
                    <tr>
                      <td class="botline" colspan="4"><div class="line"></div></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
            <input type="hidden" name="mode" value="search">
          </form>
        </div>
        <?php }?>
        <?php
			
         if($num>0 ) { 

            if(!empty($_GET['curP']))
            {
                $curPage = $_GET['curP'];
            }
        else {
            $curPage =1;
        }

	$RecordsPerPage = 9;
	
	// Getting the query string
	
	$arryServerVar=$_SERVER;
	$queryString  = str_replace('curP='.$curPage,'', $arryServerVar['QUERY_STRING']);
	$TotalPage = ceil(($num/ $RecordsPerPage));
		
	$pagerLink=$objPager->getPager($arryProduct,$RecordsPerPage,$curPage);
 	(count($arryProduct)>0)?($arryProduct=$objPager->getPageRecords()):("");


	
?>
        <div class="itempage clearfix">
          <div class="left">
            <?=$num;?>
            item(s) - Page
            <?=$curPage?>
            of
            <?=$TotalPage;?>
          </div>
           <?php if($_GET['mode']!="search"){?>            
          <div class="right">
            <div class="sort">Sort by:</div>
            <div class="sel-wrap-friont">
              <select name="shortprodduct" id="shortprodduct">
                <option value="name" <?php if($_GET['shortBy']=="name"){echo "selected";}?>>Name</option>
                <option value="new" <?php if($_GET['shortBy']=="new"){echo "selected";}?>>New arrivals</option>
                <option value="hprice" <?php if($_GET['shortBy']=="hprice"){echo "selected";}?>>Highest price</option>
                <option value="lprice" <?php if($_GET['shortBy']=="lprice"){echo "selected";}?>>Lowest price</option>
              </select>
            </div>
          </div>
         <?php }?>   
        </div>
        <ul class="listing_prod clearfix">
          <? 
   
	//$arryTotalRanking = $objMember->GetMemberRanking('','Seller');

 
   $i=0;
   
  foreach($arryProduct as $key=>$values){
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
        <? if($num>count($arryProduct)){ ?>
        <div class="pager">
          <?=$pagerLink?>
        </div>
        <?	} ?>
        <? } else{ ?>
        <div class="productnotfound"><? echo NO_PRODUCT_FOUND; ?></div>
        <? } ?>
      </div>
     <?php if(count($arraySubCategoty) > 0) {?>   
     <div class="category_list block products_list">
         <h2><?=$MenuTitle;?> - Sub Category</h2>
             
         <ul class="listing_prod clearfix  sub_category">
           <?php 
		   $j = 1;
		   foreach($arraySubCategoty as $cat) {
              
               
               if($cat['Image'] !='' && file_exists('upload/category/'.$Config['CmpID'].'/'.$cat['Image']) ){  
			$CatImagePath = 'resizeimage.php?img=upload/category/'.$Config['CmpID'].'/'.$cat['Image'].'&w=160&h=160'; 

			$CatImagePath = '<img src="'.$CatImagePath.'"  border="0" />';
			
		}else{
			$CatImagePath = '<img src="../images/no.jpg" height="150" border="0" />';
			//$EnlargeImage = '';
		}
               ?>  
             <li <?php if($j%3==0){?> class="third"<?php }?>>
               
                      <div class="img">
                    <table width="100%" cellspacing="0" cellpadding="0" border="0">
                      <tbody><tr>
                        <td valign="middle" align="center"><a href="products.php?cat=<?=$cat['CategoryID'];?>">
                          <?=$CatImagePath;?>     </a></td>
                      </tr>
                    </tbody></table>
                 </div>
                <div class="name"> <a href="products.php?cat=<?=$cat['CategoryID'];?>">
                  <?=$cat['Name'];?>      </a> 
                </div>
               
             </li> 
             <?php $j++; }?>
         </ul>  
            
     </div> 
     <?php }?>
    </div>
  </div>
</div>
