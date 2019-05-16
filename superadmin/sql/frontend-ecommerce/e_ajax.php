<?php	
require_once("includes/settings.php");

/********Connecting to main database*********/
$Config['DbName'] = $_SESSION['CmpDatabase'];
$Config['DbName'] = $Config['DbName'];
$objConfig->dbName = $Config['DbName'];
$objConfig->connect();
/*******************************************/
$objOrder=new orders();
$objCustomer=new Customer();
$objProduct=new product();
$objDiscount = new discount();

$action = isset($_REQUEST['action'])?$_REQUEST['action']:"";
$Cid = isset($_REQUEST['Cid'])?$_REQUEST['Cid']:"";
$Productid = isset($_REQUEST['ProductId'])?$_REQUEST['ProductId']:"";
$CartID = isset($_REQUEST['CartID'])?$_REQUEST['CartID']:"";
$Emailid = isset($_REQUEST['Email'])?$_REQUEST['Email']:"";
$WishlistName = isset($_REQUEST['Name'])?$_REQUEST['Name']:"";
$Wlid = isset($_REQUEST['Wlid'])?$_REQUEST['Wlid']:"";
$OptionId = isset($_REQUEST['OptionId'])?$_REQUEST['OptionId']:"";
$Price = isset($_REQUEST['Price'])?$_REQUEST['Price']:"";
$Weight = isset($_REQUEST['Weight'])?$_REQUEST['Weight']:"";

$promo_code = isset($_REQUEST['promo_code'])?$_REQUEST['promo_code']:"";
$cartSubTotal = isset($_REQUEST['cartSubTotal'])?$_REQUEST['cartSubTotal']:"";


// added by karishma for alias
$AliasId = isset($_REQUEST['AliasId'])?$_REQUEST['AliasId']:"";


switch($action){
	case 'deleteProductFromCart':
		$checkDelete = $objOrder->deleteProductFromCart($Cid,$Productid,$CartID);
		$ActionUrl = "cart.php";
		$numCart = isset($_REQUEST['numCart'])?$_REQUEST['numCart']:"";
		if(isset($checkDelete))
		{
			if($numCart > 1)
			{
				$_SESSION['successMsg'] = CART_UPDATED;
			}

			echo $ActionUrl;
		}
		break;
		exit;

	case 'checkPromoCode':
		$promo_result = $objDiscount->checkPromoCode($cartSubTotal,$promo_code,$Cid);

		$ActionUrl = "cart.php";
			
		if(count($promo_result) > 0)
		{
			$_SESSION['promo_discount_amount'] = $promo_result['promo_discount_amount'];
			$_SESSION['promo_campaign_id'] = $promo_result['promo_campaign_id'];
			$_SESSION['promo_type'] = $promo_result['promo_type'];
			$_SESSION['promo_code'] = $promo_code;
			$_SESSION['successMsg'] = VALID_PROMO;
			echo $ActionUrl;
		}
		else{
			$_SESSION['promo_discount_amount'] = "";
			$_SESSION['promo_campaign_id'] = "";
			$_SESSION['promo_type'] = "";
			$_SESSION['promo_code'] = $promo_code;
			$_SESSION['errorMsg'] = WRONG_PROMO;
			echo $ActionUrl;
		}

		break;
		exit;

	case 'checkEmail':
		$checkEmail = $objCustomer->checkCustomerEmail($Emailid);
			
		if(isset($checkEmail[0]['Cid']))
		{
			echo "1";
		}
		else
		{
			echo "0";
		}
		break;
		exit;
	case 'addwishlist':
		$checkWishlist = $objProduct->checkWishlistName($Cid,$WishlistName);
			
		if(isset($checkWishlist[0]['Name']))
		{
			echo "1";
		}
		else
		{
			echo "0";
			$_SESSION['successMsg'] = ADD_WISHLIST_PRODUCT_MSG;
		}
		break;
		exit;

	case 'checkProductInWishlist':
		$checkWishlistProduct = $objProduct->checkWishlistProduct($Wlid,$Productid,$AliasId);
			
		if(isset($checkWishlistProduct[0]['Wlpid']))
		{
			echo "1";
		}
		else
		{
			echo "0";
			$_SESSION['successMsg'] = ADD_WISHLIST_PRODUCT_MSG;
		}
		break;
		exit;

	case 'checkSubcribeEmail':
		$checkEmail = $objCustomer->checkSubcribeEmail($Emailid);
			
		if(isset($checkEmail[0]['EmailId']))
		{
			echo "1";
		}
		else
		{

			echo "0";
		}
		break;
		exit;

	case 'shippstate': 
	/********Connecting to main database*********/
	$Config['DbName'] = $Config['DbMain'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	/*******************************************/
	$objRegion=new region();

	$arryState = $objRegion->getStateByCountry($_GET['country_id']);
		
	$AjaxHtml  = '<select name="state_id_shipp" class="inputbox form-control" id="state_id_shipp"  onchange="Javascript: SetMainStateIdCheckout();">';

	if($_GET['select']==1){
		$AjaxHtml  .= '<option value="">--- Select ---</option>';
	}

	$StateSelected = (!empty($_GET['current_state']))?($_GET['current_state']):($arryState[0]['state_id_shipp']);

	for($i=0;$i<sizeof($arryState);$i++) {

		$Selected = ($_GET['current_state'] == $arryState[$i]['state_id'])?(" Selected"):("");

		$AjaxHtml  .= '<option value="'.$arryState[$i]['state_id'].'" '.$Selected.'>'.stripslashes($arryState[$i]['name']).'</option>';

	}

	$Selected = ($_GET['current_state'] == '0')?(" Selected"):("");
		
	if($_GET['other']==1){
		$AjaxHtml  .= '<option value="0" '.$Selected.'>Other</option>';
	}else if(sizeof($arryState)<=0){
		$AjaxHtml  .= '<option value="">No state found.</option>';
	}

	$AjaxHtml  .= '</select>';
		
		

	$AjaxHtml  .= '<input type="hidden" name="ajax_state_id_shipp" id="ajax_state_id_shipp" value="'.$StateSelected.'">';
		
	break;
		
		
	case 'shippcity':
		/********Connecting to main database*********/
		$Config['DbName'] = $Config['DbMain'];
		$objConfig->dbName = $Config['DbName'];
		$objConfig->connect();
		/*******************************************/
		$objRegion=new region();
		$arryCity = $objRegion->getCityByState($_GET['state_id_shipp']);

		$AjaxHtml  = '<select name="city_id_shipp" class="inputbox  form-control" id="city_id_shipp" onchange="Javascript: SetMainCityIdCheckout();">';

		if($_GET['select']==1){
			$AjaxHtml  .= '<option value="">--- Select ---</option>';
		}


		$CitySelected = (!empty($_GET['current_city']))?($_GET['current_city']):($arryCity[0]['city_id_shipp']);

		for($i=0;$i<sizeof($arryCity);$i++) {

			$Selected = ($_GET['current_city'] == $arryCity[$i]['city_id'])?(" Selected"):("");

			$AjaxHtml  .= '<option value="'.$arryCity[$i]['city_id'].'" '.$Selected.'>'.$arryCity[$i]['name'].'</option>';

		}

		$Selected = ($_GET['current_city'] == '0')?(" Selected"):("");
		if($_GET['other']==1){
			$AjaxHtml  .= '<option value="0" '.$Selected.'>Other</option>';
		}else if(sizeof($arryCity)<=0){
			$AjaxHtml  .= '<option value="">No city found.</option>';
		}

		$AjaxHtml  .= '</select>';
			

		$AjaxHtml  .= '<input type="hidden" name="ajax_city_id_shipp" id="ajax_city_id_shipp" value="'.$CitySelected.'">';
			
		break;

	case 'checkAttribute':
		$res = $objProduct->GetOptionVal($OptionId);
			
		if($res)
		{
			if(strtolower($res[0]['PriceType']) == 'percentage'){
					
				$option_modifier = ($res[0]['Price'] > 0 ? "+" : "-") . "" . ($Price * $res[0]['Price'] * ($res[0]['Price'] > 0 ? 1 : -1))/100;
				$updatedPrice=$option_modifier;
					
			}else{

				$option_modifier = ($res[0]['Price'] > 0 ? "+" : "-") . "" . $res[0]['Price'] * ($res[0]['Price'] > 0 ? 1 : -1);
				$updatedPrice=$option_modifier;
					
					
			}

			$weight_modifier = ($res[0]['Weight'] > 0 ? "+" : "-") . "" . $res[0]['Weight'] * ($res[0]['Weight'] > 0 ? 1 : -1);
			$updatedWeight=$weight_modifier;

			$arr['updatedPrice']=$updatedPrice;
			$arr['weight']=$updatedWeight;
			$arr['status']='1';


		}
		else
		{
			$arr['status']='0';

		}
		echo json_encode($arr);
		break;
		exit;


			
}

if(!empty($AjaxHtml)){ echo $AjaxHtml; exit;}

?>