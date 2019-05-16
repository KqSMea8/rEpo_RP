<?
	$HideNavigation = 1;
	include_once("includes/header.php");
	require_once($Prefix."classes/sales.customer.class.php");
	$objCustomer=new Customer();
	(empty($_GET['CustID']))?($_GET['CustID']=""):("");
	(empty($_GET['type']))?($_GET['type']=""):("");

?>
<input type="hidden" name="CrdType" id="CrdType" value="<?=$_GET['type']?>" class="textbox">

<script language="JavaScript1.2" type="text/javascript">

function SetCard(CardID,CustID){	    
	var CrdType =  $("#CrdType").val();  
		
	var SendUrl = "&action=CustomerCardInfo&CardID="+escape(CardID)+"&CustID="+escape(CustID)+"&r="+Math.random();

   	$.ajax({
	type: "GET",
	url: "ajax.php",
	data: SendUrl,
	dataType : "JSON",
	success: function (responseText)
	 {			
		parent.$("#CreditCardInfo"+CrdType).show();	 

		parent.$("#CreditCardID"+CrdType).val(responseText["CardID"]);	 
		parent.$("#CreditCardType"+CrdType).val(responseText["CardType"]);	 
 		parent.$("#CreditCardNumber"+CrdType).val(responseText["CardNumber"]);
		parent.$("#CreditCardNumberTemp"+CrdType).val(responseText["CardNumberTemp"]);
		parent.$("#CreditExpiryMonth"+CrdType).val(responseText["ExpiryMonth"]);	 
		parent.$("#CreditExpiryYear"+CrdType).val(responseText["ExpiryYear"]);	 
 		parent.$("#CreditSecurityCode"+CrdType).val(responseText["SecurityCode"]);
		parent.$("#CreditCardHolderName"+CrdType).val(responseText["CardHolderName"]);

		parent.$("#CreditAddress"+CrdType).val(responseText["Address"]);
		parent.$("#CreditCountry"+CrdType).val(responseText["CountryCode"]);
		parent.$("#CreditState"+CrdType).val(responseText["State"]);
		parent.$("#CreditCity"+CrdType).val(responseText["City"]);
		parent.$("#CreditZipCode"+CrdType).val(responseText["ZipCode"]);

		parent.jQuery.fancybox.close();
		ShowHideLoader('1','P');
			   
	}

   });				


}

</script>

<?
	(empty($_GET['SaveSelect']))?($_GET['SaveSelect']=""):("");
	
 	  
	if(!empty($_POST['CustID'])) {
		CleanPost(); 
		if(!empty($_POST['CardNumber'])) {
			if(!empty($_POST['CardID'])) {
				$_SESSION['mess_cust'] = CARD_UPDATED;
				$CardID = $_POST['CardID'];

				$objCustomer->UpdateCardOnSale($_POST);	 /* if card has been modified */

				$objCustomer->UpdateCard($_POST);
				
			}else{
				$_SESSION['mess_cust'] = CARD_ADDED;
				
				$CardID = $objCustomer->addCard($_POST);
			
			}	

			if(empty($_GET['SaveSelect'])){
				$objCustomer->UpdateOnlyCardOnSale($_POST,$CardID); //Single card	
			}




			$CustID = $_POST['CustID'] ;

			if(!empty($_GET['SaveSelect'])){
				echo '<script>SetCard('.$CardID.','.$CustID.');</script>';
				exit;
			}else{
				$objCustomer->UnDefaultCard($CardID,$_POST['CustID']);
				$RedirectURL = $_POST['CurrentDivision']."/editCustomer.php?edit=".$_POST['CustID'].'&tab=card'; 
				echo '<script>window.parent.location.href="'.$RedirectURL.'";</script>';
				exit;
			}
		}
	}



	$_GET['CustID'] = (int)$_GET['CustID'];

	$ErrorExist=0;

	if(!empty($_GET['CustID'])) {
		$arryCustomer = $objCustomer->GetCustomer($_GET['CustID'],'','');
				
		if($arryCustomer[0]['Cid']<=0){
			$ErrorExist=1;
			echo '<div class="redmsg" align="center">'.CUSTOMER_NOT_EXIST.'</div>';
		}
	}else{
		$ErrorExist=1;
		echo '<div class="redmsg" align="center">'.INVALID_REQUEST.'</div>';
		
	}
	/*************************/
	/*************************/

	if(empty($ErrorExist)){ 
		if(!empty($_GET['edit'])) {
			$arryCard = $objCustomer->GetCard($_GET['edit'],$_GET['CustID'],'');
			
			$PageAction = 'Edit';
			$ButtonAction = 'Update';
		}else{
			$PageAction = 'Add';
			$ButtonAction = 'Submit';
			$arryCard = $objConfigure->GetDefaultArrayValue('s_customer_card');
			$arryCard[0]['OtherState']='';
			$arryCard[0]['OtherCity']='';
		}

	}


 
	$HideRow='';
	if($_GET['SaveSelect']==1){
		$HideRow = 'Style="display:none"';
	}

	require_once("includes/footer.php");  

?>
