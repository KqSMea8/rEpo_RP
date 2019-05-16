

<div class="category">

    <div class="container-folio row">  
        <!--<div class="col-xs-12 col-sm-6 col-md-3">
        <?php //include_once("includes/html/box/menu.php");?></div>       -->
        <div class="col-xs-12 col-sm-12 col-md-12">
	
            <?php if(!empty($arrayParent1[0]['Image'])){ ?>
            <div class="product-banner">
                <?php 
                if ($arrayParent1[0]['Image'] != '' && file_exists($_SERVER['DOCUMENT_ROOT'] . '/ecomstandalone/upload/category/' . $Config['CmpID'] . '/' . $arrayParent1[0]['Image'])) {
             
            $ImagePath = 'resizeimage.php?img=' . $_SERVER['DOCUMENT_ROOT'] . '/ecomstandalone/upload/category/' . $Config['CmpID'] . '/' . $arrayParent1[0]['Image']. '&w=700&h=160&bg=f1f1f1';

                    echo '<img src="' . $ImagePath . '"  border="0"  height="250" width="845"/>';
                }
                    ?></div>
            <?php } ?>
            <h2 class="block-title-2"> <?php if($arrayParent1[0]['Name']==""){echo $_REQUEST['search_str'];}else{ echo $arrayParent1[0]['Name'];} ?> </h2>
            <div class="product-list-area row">
        <?php
        if ($num > 0) {

            if (!empty($_GET['curP'])) {
                $curPage = $_GET['curP'];
            } else {
                $curPage = 1;
            }

            $RecordsPerPage = 12;

            // Getting the query string

            $arryServerVar = $_SERVER;
            $queryString = str_replace('curP=' . $curPage, '', $arryServerVar['QUERY_STRING']);
            $TotalPage = ceil(($num / $RecordsPerPage));

            $pagerLink = $objPager->getPager($arryProduct, $RecordsPerPage, $curPage);
            (count($arryProduct) > 0) ? ($arryProduct = $objPager->getPageRecords()) : ("");


            $i = 0;
			
            foreach ($arryProduct as $key => $values) {
                $i++;
				// Added by karishma change for alias on 13 oct 2015
                $ProductName=$values['Name'];
                $ShortDetail=$values['ShortDetail'];
                $PrdLink = 'productDetails.php?id=' . $values['ProductID'];
                if($values['ItemAliasCode']!=''){
                      $ProductName=$values['ItemAliasCode'];
                      $ShortDetail=$values['Aliasdescription'];
                      $PrdLink .= '&AliasID=' . $values['AliasID'];
                } 
                                    
                                    
                $GroupPrice = json_decode($values['GroupPrice'], true);

                $Price = ($GroupPrice[$GroupID] > 0) ? $GroupPrice[$GroupID] : (($values['Price2'] > 0) ? ($values['Price']) : ($values['Price']));
                //$Price = ($values['Price2']>0)?($values['Price']):($values['Price']);
                

                if ($values['Image'] != '' && file_exists($_SERVER['DOCUMENT_ROOT'] . '/ecomstandalone/upload/products/images/' . $Config['CmpID'] . '/' . $values['Image'])) {
                    $ImagePath = 'resizeimage.php?img=' . $_SERVER['DOCUMENT_ROOT'] . '/ecomstandalone/upload/products/images/' . $Config['CmpID'] . '/' . $values['Image'] . '&w=160&h=160';

                    $ImagePath = '<img src="' . $ImagePath . '"  border="0"  width="266" height="166"/>';
                    //$EnlargeImage = '<a onclick="OpenNewPopUp(\'showimage.php?img=upload/products/'.$values['Image'].'\', 150, 100, \'no\' );" href="#" class=skytxt>'.CLICK_TO_ENLARGE.'</a>';
                } else {
                    $ImagePath = '<img src="images/no.jpg" height="150" border="0" width="200" />';
                    //$EnlargeImage = '';
                }
                ?>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4">
                    <div class="thumbnail"> 
						<div style="height:150px;">
                        <a href="<?= $PrdLink; ?>" >
                            <?= $ImagePath ?>
                        </a>
						</div>
                        <div class="caption">
                            <h3 class=""><a href="<?= $PrdLink; ?>" title="<?php echo $values['Name'].' Description: '.(strlen(strip_tags($values['ShortDetail']))>100)?ucfirst(substr(stripslashes(strip_tags($values['ShortDetail'])),0,100)).'...':ucfirst(stripslashes(strip_tags($values['ShortDetail']))) ; ?>">
                                    <?php
                                    
                                    
                                    echo (strlen($ProductName)>15)?ucfirst(substr(stripslashes($ProductName),0,15)).'...':ucfirst(stripslashes($ProductName));
                                    //ucfirst(stripslashes($values['Name']));
                                     ?>
                                </a></h3>
                            <p class="desc"><?php echo (strlen(strip_tags($ShortDetail))>55)?ucfirst(substr(stripslashes(strip_tags($ShortDetail)),0,55)).'...':ucfirst(stripslashes(strip_tags($ShortDetail))); 
                                     //                                     ucfirst(stripslashes($values['Name'])); ?></p>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <p class="lead"> <?= display_price($Price); ?></p>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> <a class="btn btn-success btn-block" href="<?= $PrdLink; ?>">Buy Now</a> </div>
                            </div>
                        </div>
                        <!--END CAPTION --> 
                    </div>
                    <!-- END: THUMBNAIL --> 
                </div>

            <?php }
           
        } else {
            ?>
            <div class="col-sm-12 productnotfound"><?php echo NO_PRODUCT_FOUND; ?></div>
<?php } ?>



   </div> </div></div>
     <?php if ($num > count($arryProduct)) {
                ?>
                <div class="paginationprent">
                <div class="paginationpro">
                <?= $pagerLink ?>
                </div>
                </div>
            <?php } ?>
<?php //if (count($arraySubCategoty) > 0) { ?>   
       <!-- <div class="category_list block products_list">
            <h2><?= $MenuTitle; ?> - Sub Category</h2>


            <?php/*
            $j = 1;
            foreach ($arraySubCategoty as $cat) {


                if ($cat['Image'] != '' && file_exists($_SERVER['DOCUMENT_ROOT'] . '/erp/upload/category/' . $Config['CmpID'] . '/' . $cat['Image'])) {
                    $CatImagePath = 'resizeimage.php?img=' . $_SERVER['DOCUMENT_ROOT'] . '/erp/upload/category/' . $Config['CmpID'] . '/' . $cat['Image'] . '&w=160&h=160';

                    $CatImagePath = '<img src="' . $CatImagePath . '"  border="0" />';
                } else {
                    $CatImagePath = '<img src="../images/no.jpg" height="150" border="0" />';
                    //$EnlargeImage = '';
                }*/
                ?> 

                <div class="col-xs-6 col-sm-6 col-md-4 col-lg-3">
                    <div class="thumbnail"> 
						<div style="height:150px;">
                        <a href="products.php?cat=<?= $cat['CategoryID']; ?>" >
        <?= $CatImagePath; ?>
                        </a>
						</div>
                        <div class="caption">
                            <h3 class=""><a href="products.php?cat=<?= $cat['CategoryID']; ?>">
                          <?php  // echo (strlen($cat['Name'])>15)?ucfirst(substr(stripslashes($cat['Name']),0,15)).'...':ucfirst(stripslashes($cat['Name']));
        // $cat['Name']; ?>
                                </a></h3>

                        </div>
                        <!--END CAPTION 
                    </div>
                    <!-- END: THUMBNAIL 
                </div> 

        <?php $j++;
    //}
    ?>


        </div> --> 
<?php //} ?>
</div>
<div class="clearfix"></div>