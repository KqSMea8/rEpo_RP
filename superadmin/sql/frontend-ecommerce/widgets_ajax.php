<?php
require_once("includes/settings.php");


/********Connecting to main database*********/
$Config['DbName'] = $_SESSION['CmpDatabase'];
$objConfig->dbName = $_SESSION['CmpDatabase'];
$objConfig->connect();
/*******************************************/

switch($_GET['action']){

	case 'getSearchWidget':
		$search_str=$_GET['search_str'];
		$AjaxHtml  ='<div class="search-data" id="adv-search">
					<form action="products.php" class="form-horizontal" id="searchForm" name="searchForm" method="get">
						<input type="text" name="search_str" value="'.$search_str.'" id="search" class="form-control" placeholder="Search " />
						<div class="input-group-btn">
							<div class="btn-group" role="group">
								<div class="dropdown dropdown-lg">
									<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span></button>
									<div class="dropdown-menu dropdown-menu-right" role="menu">
										<div class="form-horizontal" role="form">
										  <div class="form-group searchfilter ">
											<label for="filter">Filter by</label>
											<select name="searchby" class="form-control" onchange="$( \'#searchForm\' ).submit();">
												<option value="0">Search By</option>
												<option value="loh" ';
		if($_GET['searchby']=='loh' ){ $AjaxHtml  .='selected="selected"';	  }
		$AjaxHtml  .='>Low to High Price</option>
												<option value="htl" ';
		if($_GET['searchby']=='htl' ){ $AjaxHtml  .='selected="selected"'; }
		$AjaxHtml  .='>High to Low Price</option>
												<option value="toprated" ';
		if($_GET['searchby']=='toprated' ){ $AjaxHtml  .='selected="selected"'; }
		$AjaxHtml  .='>Top Rated</option>
												<option value="relevant" ';
		if($_GET['searchby']=='relevant' ){ $AjaxHtml  .='selected="selected"'; }
		$AjaxHtml  .='>Most Relevant</option>
											</select>
										  </div>
										 </div>
									</div>
								</div>
								<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
							 <input type="hidden" name="mode" value="search">
							</div>
						</div>
				  </form>
          </div>';


			
		break;

	case 'getLogoWidget':
		if ($arryCompany[0]['Image'] != '' && file_exists($_SERVER['DOCUMENT_ROOT'] . '/erp/upload/company/' . $arryCompany[0]['Image'])) {
			$SiteLogo = 'resizeimage.php?w=116&h=60&img=' . $_SERVER['DOCUMENT_ROOT'] . '/erp/upload/company/' . $arryCompany[0]['Image'];
		} else {
			$SiteLogo = '../img/default_logo.png';
		}
		$AjaxHtml  ='<a class="navbar-brand" href="index.php"><img src="'.$SiteLogo.'" alt="'.$Config['SiteName'].'" title="'.$Config['SiteName'].'" ></a>';


			
		break;
	case 'getCurrencyWidget':
		if(strtolower($settings['EnableCurrency'])=='yes' ){
			$AjaxHtml  ='
				<form>
					<select name="top_currency_id" class="currency" id="top_currency_id" onchange="Javascript:ChangeCurrency();"  >';
			for($i=0;$i<sizeof($arryTopCurrency);$i++) {
				$AjaxHtml  .=' <option value="'.$arryTopCurrency[$i]['currency_id'].'"';
				if($arryTopCurrency[$i]['currency_id']==$_SESSION['currency_id']){$AjaxHtml  .='selected';}
				$AjaxHtml  .='>'.$arryTopCurrency[$i]['name'].'</option>';
			}
			$AjaxHtml  .='</select>
				</form>  
			 ';
		}

			
		break;

	case 'getSignInWidget':

		$AjaxHtml  ='
                                	
                                    <ul class="top-menu">';
		if (!empty($_SESSION['Cid'])) {
			$AjaxHtml  .='<li ><a href="#" onclick="$(\'#userprofilelogin\').toggle();">Hi '. $_SESSION['Name'].'</a>
                                           	
                                           	<ul id="userprofilelogin" style="display:none;" >
                                           	
                                           	
                                             <li><a href="myProfile.php" role="button" class="btn btn-link"><span class="glyphicon glyphicon-lock"></span>My Account</a></li>
                                             <li><a href="logout.php">Logout</a></li>
                                          	</span>
                                            </li>';


		} else {
			$AjaxHtml  .='<li><a href="#mySignin"  role="button" class="btn btn-link" data-toggle="modal" >Sign In</a></li>
                                            <li><a href="#createaccount" role="button" class="btn btn-link" data-toggle="modal" >Create Account</a></li>';


		}

		$AjaxHtml  .=' </ul>
                                ';
		$AjaxHtml  .='<div class="modal fade" id="mySignin" >


    <div class="model-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"> Sign In </h4>
            </div>
           
            <div class="modal-body">
                <form name="form1" class="logForm" action="login.php" method="post"  enctype="multipart/form-data">

                        <div class="form-group">
                            <label>'.EMAIL_ADDRESS.'<span class="red">*</span></label>
                            <input type="text" name="LoginEmail" id="LoginEmail" class="form-control"  placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label>'.PASSWORD .'<span class="red">*</span></label>
                            <input type="password" name="LoginPassword" id="LoginPassword" class="form-control"  placeholder="Password">
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="Remember" value="Yes">
                               '. REMBER_LOGIN .'</label>
                        </div>
                        <div class="form-group">
                            <p>'. LOST_PASSWORD.'</p>
                        </div>
                        <input type="hidden" name="ContinueUrl" id="ContinueUrl" value="'.$_GET['ref'].'" />
                        <input type="submit" name="submit" class="btn btn-primary" id="btnLOgin" value="'.LOGIN.'" />

                    </form>
            </div>
            
        </div>
        
    </div>
 
    
</div>';
			
		$AjaxHtml  .='<div class="modal fade" id="createaccount">
    <div class="model-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"> Create Account </h4>
            </div>
            <!-- end header modal -->
            <div class="modal-body">
            <form name="form1" class="register_form_user" id="register_form" action="register.php"  method="post"  enctype="multipart/form-data">
         
            <div class="form-group">
              <label>'.FIRST_NAME.' : <span class="red">*</span> </label>
              <input type="text"name="FirstName" id="FirstName" value="" />
            </div>
            <div class="form-group">
               <label>'.LAST_NAME.' : <span class="red">*</span></label>
               <input type="text" name="LastName" id="LastName" value="" />
            </div>
            <div class="form-group">
               <label>'.COMPANY_NAME.' :</label>
                        <input type="text" name="Company" id="Company" value="" />
            </div>
            <div class="form-group">
                <label>'.ADDRESS_LINE1.' : <span class="red">*</span></label>
                        <input type="text" name="Address1" id="Address1" value="" />
            </div>
            
             <div class="form-group">
                 <label>'.ADDRESS_LINE2.' :</label>
                        <input type="text" name="Address2" id="Address2" value="" />
            </div>
            
             <div class="form-group">
                <label>'.COUNTRY.' : <span class="red">*</span></label>
                        <div class="sel-wrap-friont">
                            <select name="Country" class="inputbox form-control" id="country_id"  onChange="Javascript: StateListSendR();">
                              <option value="">--- Select ---</option>';

		$CountrySelected = $Config['country_id'];
		for ($i = 0; $i < sizeof($arryCountry); $i++) {
			$AjaxHtml  .='<option value="'.$arryCountry[$i]['country_id'].'" >
                                    '.$arryCountry[$i]['name'].'
                                    </option>';
		}
		$AjaxHtml  .='</select>
                        </div>
            </div>
            
             <div class="form-group" id="State_Div" style="display:none;">
                <label>'.STATE.' : <span class="red">*</span></label>
                        <div class="sel-wrap-friont">
                            <span id="state_tdr"></span>
                        </div>
            </div>
            
            <div class="form-group" id="StateBillOther_Div" style="display:none;">
                <label><div id="StateTitleDiv">'.OTHER_STATE.' : <span class="red">*</span></div></label>
                        <div class="sel-wrap-friont">
                            <div id="StateValueDiv"><input name="OtherState" type="text" class="inputbox" id="OtherState" value="'.$arryEmployee[0]['OtherState'].'"  maxlength="30" /> </div> 
                        </div>
            </div>
            
             <div  class="form-group" id="CityBill_Div" style="display:none;">
                    
                        <label><div id="MainCityTitleDiv">'.CITY.' : <span class="red">*</span></div></label>
                        <div class="sel-wrap-friont">
                            <div id="city_tdr"></div>
                        </div>
                   
                     </div>
                     <div  class="form-group" id="CityBillOther_Div" style="display:none;">
                     
                        <label><div id="CityTitleDiv"> '.OTHER_CITY.' : <span class="red">*</span></div></label>
                        <div class="sel-wrap-friont">
                           <div id="CityValueDiv"><input name="OtherCity" type="text" class="inputbox" id="OtherCity" value="'.$arryEmployee[0]['OtherCity'].'"  maxlength="30" />  </div>
                        </div>
                    
                     </div> 
                     
            <div class="form-group">
                <label>'.ZIP_CODE.' : <span class="red">*</span></label>
                        <input type="text" name="ZipCode" id="ZipCode" value="" />
            </div>
            <div class="form-group">
                 <label>'.PHONE_NUMBER.' : <span class="red">*</span></label>
                        <input type="text" name="Phone" onkeyup="keyup(this);" id="Phone" value="" />
            </div>
            
            <h3>'.ACCOUNT_INFORMATION.'</h3>
            <div class="form-group">
                  <label>'.EMAIL_ADDRESS.' : <span class="red">*</span></label>
                        <input type="text" name="Email" id="Email" value="" />
            </div>
            <div class="form-group">
                 <label>'.PASSWORD.' : <span class="red">*</span></label>
                        <input type="Password" name="Password" id="Password" value="" />
            </div>
            
             <div class="form-group">
                 <label>'.CONFIRM_PASSWORD.' : <span class="red">*</span></label>
                        <input type="Password" name="Confirm_Password" id="Confirm_Password" value="" />
            </div>
            
            <input type="button" name="SaveCustomer" id="SaveCustomer" value="'.REGISTER.'"  class="btn btn-primary"  />
            <input type="hidden" name="ContinueUrl" id="ContinueUrl" value="'.$_GET['ref'].'" />
                      <input type="hidden" value="'.$arryCustomer[0]['State'].'" id="main_state_id" name="main_state_id">		
                      <input type="hidden" name="main_city_id" id="main_city_id"  value="'.$arryCustomer[0]['City'].'" />
                      <input type="hidden" name="billcountry_id" id="billcountry_id"  value="" />
          </form>
            
               
            </div>
            
        </div>
        
    </div>
    
</div>';


			
		break;

	case 'getTopMenuWidget':

		$AjaxHtml  ='<div class="crm-menu">';
		$AjaxHtml  .='
			<ul><li';
		if (curPageName() == "index.php") { $AjaxHtml  .='class="active"';
		} $AjaxHtml  .='><a href="index.php">Home</a></li>';
		if(count($arryTopCategory)>5) {
			$arrayLeftCategory = $arryTopCategory;

			$AjaxHtml  .='<li ><a href="#" >All Products</a>
			  	<div class="crmdrop-submenu">'.getMenu($arrayLeftCategory, 0, sizeof($arrayLeftCategory), $objCategory).'</div>              		
					</li> 
				';
		}
		$arrayLeftCategory = $arryTopCategory;
		if(count($arryTopCategory)<5) $totalCat=count($arryTopCategory);
		else $totalCat=5;
		$AjaxHtml  .=getTopMenu($arrayLeftCategory, 0,$totalCat, $objCategory);

		$AjaxHtml  .='</ul></div>';

			

			
		break;

	case 'getSocialWidget':

		if(count($arrySocialSetting)>0){

			$AjaxHtml  ='<div class="social-icon">
        	<ul>';

			for ($count = 0; $count < count($arrySocialSetting); $count++) {
				$AjaxHtml  .='<li class="'.strtolower($arrySocialSetting[$count]['name']).'" ><a href="' . $arrySocialSetting[$count]['URL'] . '" target="_blank"></a></li>';
			}


			$AjaxHtml  .='</ul></div>';
		}else{
			$AjaxHtml  .='';
		}

			

			
		break;

	case 'getSliderBannerWidget':



		$AjaxHtml  ='<div id="myCarousel" class="carousel slide" data-ride="carousel">
   
    
    <ol class="carousel-indicators">';
		for($count=0; $count<count($arrySlider);$count++){
			$class='class=""';
			if($count==0) $class='class="active"';

			$AjaxHtml  .='<li data-target="#myCarousel" data-slide-to="'.$count.'" '.$class.'></li>';
		}

		$AjaxHtml  .='</ol>
    <div class="carousel-inner" role="listbox">';
		for($count=0; $count<count($arrySlider);$count++){
			if($count==0) $class='class="item active"';
			else $class='class="item"';
			if ($arrySlider[$count]['Slider_image'] != '' && file_exists($_SERVER['DOCUMENT_ROOT'].'/erp/upload/company/' . $Config['CmpID'] . '/slider_image/' . $arrySlider[$count]['Slider_image'])) {
				$ImagePath = $_SERVER['DOCUMENT_ROOT'].'/erp/upload/company/' . $Config['CmpID'] . '/slider_image/' . $arrySlider[$count]['Slider_image'];
				$ImagePath = 'resizeimage.php?w=1000&h=120&bg=f1f1f1&img='.$_SERVER['DOCUMENT_ROOT'].'/erp/upload/company/' . $Config['CmpID'] . '/slider_image/' . $arrySlider[$count]['Slider_image'];
				$Image = '<img  class="first-slide" src="' . $ImagePath . '"  alt="'.$arrySlider[$count]['Name'].'"/>';
					
			}

			$AjaxHtml  .='<div '.$class.'>'.$Image.'
            <div class="container">
                <div class="carousel-caption">
                	'.$arrySlider[$count]['Content'].'                   
                </div>
            </div>
        </div>';
		}

		$AjaxHtml  .='</div>
		<a class="left carousel-control" href="#myCarousel" role="button"
			data-slide="prev"> <span class="glyphicon glyphicon-chevron-left"
			aria-hidden="true"></span> <span class="sr-only">Previous</span> </a>
		<a class="right carousel-control" href="#myCarousel" role="button"
			data-slide="next"> <span class="glyphicon glyphicon-chevron-right"
			aria-hidden="true"></span> <span class="sr-only">Next</span> </a>
		</div>'; 

		break;

	case 'getFeaturedProductsWidget':
		$arryProductFeatured = $objProduct->GetFeaturedProducts($settings);

		$num = $objProduct->numRows();

		$AjaxHtml  ='<div class="container-folio row"> ';

		if ($num > 0) {
			$AjaxHtml  .='<h3 class="col-sm-12">Featured Products</h3>';
			$i = 0;

			foreach ($arryProductFeatured as $key => $values) {
				$i++;


				$Price = ($values['OfferPrice'] > 0) ? ($values['OfferPrice']) : ($values['Price']);
				if (!empty($_SESSION['VatPercentage']) && $values['TaxExempt'] != 1) {
					$Tax = ($Price * $_SESSION['VatPercentage']) / 100;
					$PriceFinal = $Price + $Tax;
				} else {
					$Tax = 0;
					$PriceFinal = $Price;
				}

				$PrdLink = 'productDetails.php?id=' . $values['ProductID'] . $StoreSuffix;
				$CartLink = 'cart.php?ProductID=' . $values['ProductID'] . '&Price=' . round($Price, 2) . '&StoreID=' . $values['PostedByID'] . '&Tax=' . round($Tax, 2);


				if ($values['Image'] != '' && file_exists($_SERVER['DOCUMENT_ROOT'].'/erp/upload/products/images/' . $Config['CmpID'] . '/' . $values['Image'])) {
					$ImagePath = 'resizeimage.php?img='.$_SERVER['DOCUMENT_ROOT'].'/erp/upload/products/images/' . $Config['CmpID'] . '/' . $values['Image'] . '&w=160&h=160';

					$ImagePath = '<img src="' . $ImagePath . '"  border="0" />';

				} else {
					$ImagePath = '<img src="images/no.jpg" height="150" border="0" />';

				}
				$Name=(strlen($values['Name'])>15)?ucfirst(substr(stripslashes($values['Name']),0,15)).'...':ucfirst(stripslashes($values['Name']));
				$ShortDetail= (strlen(strip_tags($values['ShortDetail']))>55)?ucfirst(substr(stripslashes(strip_tags($values['ShortDetail'])),0,55)).'...':ucfirst(stripslashes(strip_tags($values['ShortDetail'])));
				$AjaxHtml  .='<div class="col-xs-6 col-sm-6 col-md-4 col-lg-3">
                    <div class="thumbnail"> 
                        
                        <div style="height:150px;">
                        <a href="'.$PrdLink.'" >'.$ImagePath.'</a>
                        </div>
                       
                        <div class="caption">
                            <h3 class=""><a href="'.$PrdLink.'" title="'.strip_tags($values['Name']).' Description: '.strip_tags($values['ShortDetail']).'">
                            '.$Name.'</a></h3>
                            <p class="desc">'.$ShortDetail.'
                            </p>
                            
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <p class="lead">'.display_price($PriceFinal, '','', $arryCurrency[0]['symbol_left'], $arryCurrency[0]['symbol_right']).'</p>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> <a class="btn btn-success btn-block" href="'.$PrdLink.'">Buy Now</a> </div>
                            </div>
                        </div>
                        
                    </div>
                   
                </div>';




			}
		}



		$AjaxHtml  .='</div>';

		break;

	case 'getBestSellerProductsWidget':

		if($settings['BestsellersAvailable'] == "Yes" && $settings['BestsellersDisplay'] == "left" && count($bestseller_items)>0)
		{
			$AjaxHtml  ='<div class="caption" id="captionright">
                    <h3 class="">Best Seller Items</h3>';
			foreach ($bestseller_items as $bestseller_item ) {
				$i++;


				$Price = ($bestseller_item['OfferPrice'] > 0) ? ($bestseller_item['OfferPrice']) : ($bestseller_item['Price']);
				if (!empty($_SESSION['VatPercentage']) && $values['TaxExempt'] != 1) {
					$Tax = ($Price * $_SESSION['VatPercentage']) / 100;
					$PriceFinal = $Price + $Tax;
				} else {
					$Tax = 0;
					$PriceFinal = $Price;
				}

				$PrdLink = 'productDetails.php?id=' . $bestseller_item['ProductID'] . $StoreSuffix;



				if ($bestseller_item['Image'] != '' && file_exists($_SERVER['DOCUMENT_ROOT'].'/erp/upload/products/images/' . $Config['CmpID'] . '/' . $bestseller_item['Image'])) {
					$ImagePath = 'resizeimage.php?img='.$_SERVER['DOCUMENT_ROOT'].'/erp/upload/products/images/' . $Config['CmpID'] . '/' . $bestseller_item['Image'] . '&w=160&h=160';

					$ImagePath = '<img src="' . $ImagePath . '"  border="0" />';

				} else {
					$ImagePath = '<img src="images/no.jpg" height="150" border="0" />';

				}
				$Name=(strlen($bestseller_item['Name'])>15)?ucfirst(substr(stripslashes($bestseller_item['Name']),0,15)).'...':ucfirst(stripslashes($bestseller_item['Name']));
				$ShortDetail=(strlen(strip_tags($bestseller_item['ShortDetail']))>55)?ucfirst(substr(stripslashes(strip_tags($bestseller_item['ShortDetail'])),0,55)).'...':ucfirst(stripslashes(strip_tags($bestseller_item['ShortDetail'])));
				$AjaxHtml  .='<div class="col-xs-6 col-sm-6 col-md-4 col-lg-3">
<div class="thumbnail">
<div style="height: 150px;"><a href="'.$PrdLink.'">'.$ImagePath.'</a>
</div>

<div class="caption">
<h3 class=""><a href="'.$PrdLink.'"
	title="'.$bestseller_item['Name'].' Description: '.$bestseller_item['ShortDetail'].'">'.$Name.'</a></h3>
<p class="desc">'.$ShortDetail.'</p>
<div class="row">
<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
<p class="lead">'.display_price($PriceFinal, '','', $arryCurrency[0]['symbol_left'], $arryCurrency[0]['symbol_right']).'</p></div>
<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"><a
	class="btn btn-success btn-block" href="'.$PrdLink.'">Buy Now</a></div>
</div>
</div>
</div>
</div>';

			}
			if(count($bestseller_items)>4) {
				$AjaxHtml  .='<div><a href="bestsellermore.php">More</a></div>';
			}
			$AjaxHtml  .='</div>';
		}
		else{
			$AjaxHtml  .='';
		}
		break;

	case 'getSupportWidget':

		$AjaxHtml  ='<div class="col-lg-3  col-md-3 col-sm-4 col-xs-6">
                <h3> Support </h3>';
		if($settings['SupportNumber']!='' || $settings['SupportEmail']!=''){
			$AjaxHtml  .='<ul>
                    <li class="supportLi">
                        <p> Need assistance with any order</p>';
			if($settings['SupportNumber']!=''){
				$AjaxHtml  .='<h4> <a class="inline" href="callto:'.$settings['SupportNumber'].'"> <strong> <i class="fa fa-phone"> </i> '.$settings['SupportNumber'].'</strong> </a> </h4>';
			}
			if($settings['SupportEmail']!=''){
				$AjaxHtml  .='<h4> <a class="inline" href="mailto:'.$settings['SupportEmail'].'"> <i class="fa fa-envelope-o"> </i> '.$settings['SupportEmail'].' </a> </h4>';
			}
			$AjaxHtml  .='</li>
                </ul>';

		}

		$AjaxHtml  .='</div>';
			

			
		break;

	case 'getFooterShopMenuWidget':
		$arrayLeftCategory = $arryTopCategory;

		$AjaxHtml  =' <div class="col-lg-2  col-md-2 col-sm-4 col-xs-6">
                <h3> Shop </h3>
                <ul>
                    <li> <a href="index.php"> Home </a> </li>';

		$footersubmenuHtml='<ul class="dropdown-menu mega-menu">';
			
		for ($i = 0; $i < sizeof($arrayLeftCategory); $i++) {
			$arrySecondSubCategory = $objCategory->GetSubCategoryByParent(1, $arrayLeftCategory[$i]['CategoryID']);
			$catName = stripslashes(ucfirst(strtolower($arrayLeftCategory[$i]['Name'])));
			if($i<9){
				$AjaxHtml  .='<li><a href="products.php?cat='.$arrayLeftCategory[$i]["CategoryID"].'">
                                '.$catName.'</a> </li>';
			}

			if($i==9 && sizeof($arrayLeftCategory)>9){
				$counter=0;
				$AjaxHtml  .='<li id="button" class="dropdown-toggle" data-toggle="dropdown"  >More<b class="caret"></b></li>';
					
			}
			if($i>=9 && sizeof($arrayLeftCategory)>9){

				if($counter%6==0){
					$footersubmenuHtml .=' <li class="mega-menu-column">
			<ul> '; 
				}

				$footersubmenuHtml .='<li> <a href="products.php?cat='.$arrayLeftCategory[$i]["CategoryID"].'">'.$catName.'</a> </li>';
				$counter++;
				if($counter%6==0){
					$footersubmenuHtml .=' </ul>
			</li>'; 
				}


			}


		}
		$footersubmenuHtml .='</ul>';
		$AjaxHtml  .=$footersubmenuHtml;
			

		$AjaxHtml  .='</ul>
            </div>';
			

			
		break;

	case 'getFooterInformationMenuWidget':


		$AjaxHtml  ='<div class="col-lg-2  col-md-2 col-sm-4 col-xs-6">
                <h3> Information </h3>
                <ul>';


		$url = $_GET["url"];
		if (!empty($url)) {
			$urlMd5 = md5($url);
			$arryPageId = $cmsObj->getPageIdByHash($urlMd5);
		}


		if (!empty($arryPageId[0]['PageId'])) {
			$pageId = $arryPageId[0]['PageId'];
		} else {
			$pageId = $_GET['page_id'];
		}

		foreach ($arryPages as $key => $value) {
			$menu_url = $value['UrlCustom'];
			if (!empty($menu_url)) {
				$menu_link = $menu_url . ".html";
			} else {
				$menu_link = "page.php?page_id=" . $value['PageId'];
			}
			if ($value['PageId'] == $pageId) {
				$active = "active";
			} else {
				$active = "";
			}
			if($value['DisplayMenu'] =='Footer' || $value['DisplayMenu'] =='Both'){

				$AjaxHtml  .='<li class="'.$active.'"><a href="'.$menu_link.'">'.$value['Name'].'</a></li>';
			} }
			if ($settings['BestsellersAvailable'] == "Yes" && $settings['BestsellersDisplay'] == "top") {
				$AjaxHtml  .='<li><a href="bestseller.php">Bestseller</a></li>';
			}
			$AjaxHtml  .='</ul>

            </div>';



			break;

	case 'getFooterMyAccountWidget':


		$AjaxHtml  ='<div class="col-lg-2  col-md-2 col-sm-4 col-xs-6">
                    <h3> My Account</h3>
                    <ul>                   
                        <li> <a href="myProfile.php"> My Account </a> </li>
                        <li> <a href="change_password.php">Change Password </a> </li>
                        <li> <a href="addressBook.php"> My Address </a> </li>';
		if ($settings['EnableWishList'] == "Yes") {
			$AjaxHtml  .='<li><a href="myWishlist.php?action=manage_wishlist">Wishlist</a></li>';
		}

		$AjaxHtml  .='<li> <a href="myOrders.php"> Order list </a> </li>
                        <li><a href="newsletter.php">Subscribe / unsubscribe to newsletter</a></li>
                    </ul>
                </div>';
			

			
		break;

	case 'getFooterSubscriberWidget':


		$AjaxHtml  ='<div class="col-lg-3  col-md-3 col-sm-6 col-xs-12 ">
                <h3> Stay in touch </h3>
                <ul>
                    <li>
                        <div class="input-append newsLatterBox text-center">
                             <form name="SubscribeForm" method="post" id="SubscribeForm" action="subscriber.php">
                            <input type="text" class="full text-center" name="Email" id="SubCriberEmail" placeholder="Email ">
                            <button class="btn  bg-gray" type="button" name="btnSubmit" id="btnSubcribe"> Subscribe <i class="fa fa-long-arrow-right"> </i> </button>
                            </form>
                        </div>
                    </li>
                </ul>
              </div>';
			

			
		break;

	case 'getLeftCategoryMenuWidget':

		if($_GET['cat']){
			$catid= $_GET['cat'];
		} else {
			$catid='"'.''.'"';
		}

		$catid=$objCategory->Getparentcat($catid);
		$arraycatemain=$objCategory->GetCategory($catid);

		$arrySecondSubCategory = $objCategory->GetSubCategoryByParent(1, $catid);

		$AjaxHtml  ='<div class="block left-nav" style="border-bottom: 1px solid #ccc; padding-bottom: 15px;">
          <h2><a  href="products.php?cat='.$arraycatemain[0]['CategoryID'].'">';
		if($arraycatemain[0]['Name']!='') $AjaxHtml  .=$arraycatemain[0]['Name']; else $AjaxHtml  .='Category';
		$AjaxHtml  .='</a></h2>
          <div class="content ">
		<ul class="tree treeview">';

		if(count($arrySecondSubCategory)>0) {

			for($j=0;$j<sizeof($arrySecondSubCategory);$j++) {
				$arryThirdSubCategory = $objCategory->GetSubSubCategoryByParent(1,$arrySecondSubCategory[$j]['CategoryID']);

				$AjaxHtml  .='<li>
            <a  href="products.php?cat='.$arrySecondSubCategory[$j]['CategoryID'].'" class=';
				if($arrySecondSubCategory[$j]['CategoryID'] == $_GET['cat']){ $AjaxHtml  .= '"menu-item-current"'; }
				$AjaxHtml  .='>
                <span>'.stripslashes($arrySecondSubCategory[$j]['Name']).'</span>
            </a>';
				if(count($arryThirdSubCategory)>0) {
					$AjaxHtml  .='<ul id="menu_'.$arrySecondSubCategory[$j]['CategoryID'].'_2">';

					for($k=0;$k<sizeof($arryThirdSubCategory);$k++) {
							
						$arryFourthSubCategory = $objCategory->GetSubSubCategoryByParent(1,$arryThirdSubCategory[$k]['CategoryID']);


						$AjaxHtml  .='<li>
                     <a  href="products.php?cat='.$arryThirdSubCategory[$k]['CategoryID'].'" class=';
						if($arryThirdSubCategory[$k]['CategoryID'] == $_GET['cat']){ $AjaxHtml  .='"menu-item-current"'; }
						$AjaxHtml  .='>
                         <span>'.stripslashes($arryThirdSubCategory[$k]['Name']).'</span></a>';
						if(count($arryFourthSubCategory)>0) {
							$AjaxHtml  .='<ul id="menu_'.$arryThirdSubCategory[$k]['CategoryID'].'_3">';

							for($l=0;$l<sizeof($arryFourthSubCategory);$l++) {
								$arryFifthSubCategory = $objCategory->GetSubSubCategoryByParent(1,$arryFourthSubCategory[$l]['CategoryID']);


								$AjaxHtml  .='<li>
                        <a  href="products.php?cat='.$arryFourthSubCategory[$l]['CategoryID'].'" class=';
								if($arryFourthSubCategory[$l]['CategoryID'] == $_GET['cat']){ $AjaxHtml  .=' "menu-item-current"'; }
								$AjaxHtml  .='>
                            <span>'.stripslashes($arryFourthSubCategory[$l]['Name']).'</span></a>';
								if(count($arryFifthSubCategory)>0) {
									$AjaxHtml  .='<ul id="menu_'.$arryFourthSubCategory[$l]['CategoryID'].'_4">';
									for($m=0;$m<sizeof($arryFifthSubCategory);$m++) {
										$AjaxHtml  .='<li';
										if($arryFifthSubCategory[$m]['CategoryID'] == $_GET['cat']){ $AjaxHtml  .='class="drop-down-menu-item-current"';  }
										$AjaxHtml  .='>
                                <a  href="products.php?cat='.$arryFifthSubCategory[$m]['CategoryID'].'" class=';
										if($arryFifthSubCategory[$m]['CategoryID'] == $_GET['cat']){ $AjaxHtml  .=' "menu-item-current"'; }
										$AjaxHtml  .='>
                                    <span>'.stripslashes($arryFifthSubCategory[$m]['Name']).'</span></a></li>';
									}
									$AjaxHtml  .='</ul>';
								}
								$AjaxHtml  .='</li>';
							}
							$AjaxHtml  .='</ul>';
						}
						$AjaxHtml  .='</li>';
					}
					$AjaxHtml  .='</ul>';
				}
				$AjaxHtml  .='</li>';
			}

		} else {

			$AjaxHtml  .=' <li>There is no subcategory </li> ';
		}


		$AjaxHtml  .='</ul>
      
</div>
</div>';



			

			
		break;

	case 'getLeftPriceFilterWidget':


		$AjaxHtml  ='<div class="block left-nav price" style="border-bottom: 1px solid #ccc; padding-bottom: 15px;">
          <h2>'.PRICE.'</h2>
          <div class="content ">
<ul>';

		$pricerange=$objProduct->pricerange();
		$minprice=round($pricerange[0]['minprice']);
		$maxprice=round($pricerange[0]['maxprice']);
		$count=$pricerange[0]['count'];
			
			
		if($maxprice>1000){

			for($m=1000; $m<=$maxprice; $m++){
				if($m==1000){
					$minprice=0;
					$max=1000;
				}else{
					$minprice=$m;
					$max=($m-1)+($minprice-1);
				}
				if($maxprice>=$max){


					$AjaxHtml  .='<li><a href="products.php?cat='.$_GET['cat'].'&min='.$minprice.'&max='.$max.'">';
					if($minprice==0){$AjaxHtml  .='Below'."&nbsp;&nbsp;&nbsp;" . display_price_left($max);}else{
						$AjaxHtml  .= display_price_left($minprice)."&nbsp;&nbsp;&nbsp;". "-"."&nbsp;&nbsp;&nbsp;" . display_price_left($max);}
						$AjaxHtml  .='</a> </li>';
							
				}else{
					$AjaxHtml  .='<li><a href="products.php?cat='.$_GET['cat'].'&min='.$minprice.'&max='.$max.'">'.display_price_left($minprice)."&nbsp;&nbsp;&nbsp;". "-"."&nbsp;&nbsp;&nbsp;" ."Above".'</a> </li>';

					break; }

					$m=$max;

			} }else{
				$minprice=1;

				$AjaxHtml  .='<li><a href="products.php?cat='.$_GET['cat'].'&min='.$minprice.'&max='.$maxprice.'">';
				if($minprice==1){ $AjaxHtml  .='Below'."&nbsp;&nbsp;&nbsp;" .display_price_left($maxprice);}
				else{    $AjaxHtml  .=display_price_left($minprice)."&nbsp;&nbsp;&nbsp;". "-"."&nbsp;&nbsp;&nbsp;" .display_price_left($maxprice);}
				$AjaxHtml  .='</a> </li>';
			}
			$AjaxHtml  .='</ul>
      
</div>
</div>';



			break;

	case 'getLeftManufacturerFilterWidget':


		$AjaxHtml  ='<div class="block left-nav price" style="border-bottom: 1px solid #ccc; padding-bottom: 15px;">
          <h2>'.Manufacturer.'</h2>
          <div class="content ">
<ul>';
		 
		$manufacturer=$objProduct->manufacturer();
		foreach ($manufacturer as $key => $value) {

			 
			$AjaxHtml  .='<li><a href="products.php?cat='.$_GET['cat'].'&manf='.$value['Mid'].'">'.$value['Mname'].'</a> </li>';
			 
		}
		$AjaxHtml  .='</ul>
      
</div>
</div>';
			

			
		break;


} if(!empty($AjaxHtml)){ echo $AjaxHtml; exit;} ?>
