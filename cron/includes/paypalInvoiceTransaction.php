<? 
require_once($Prefix."classes/paypal.invoice.class.php");
$objpaypalInvoice=new paypalInvoice();

require_once($Prefix."classes/card.class.php");
$objCard = new card();

//var_dump($objpaypalInvoice->isActivePaypalInvoice());
//echo ($objpaypalInvoice->isActivePaypalInvoice())?($values['DisplayName']):'';
//var_dump($objhostbill->isActiveHostbill());

if(!empty($_GET['testmode'])){
//$Config['AdminID']=="37"
//if($objpaypalInvoice->isActivePaypalInvoice()==1){
if($Config['AdminID']==$_GET['cid']){
	try
		{
				 $PaymentProviderData=$objpaypalInvoice->GetPaymentProvider(1);	
				if(!empty($PaymentProviderData[0]['PaypalToken'])){

				echo $values['CompanyName'];
				
						
						
								$paypalUsername=$PaymentProviderData[0]['paypalUsername'];
								 $PaypalToken=$PaymentProviderData[0]['PaypalToken'];
								require($Prefix."admin/includes/html/box/savePaypalTransaction.php");
						
				}

		}
				catch (Exception $e){

				//	continue;

		}
	//}

		echo $Config['AdminID'].'_done'; die;
	}

}else{

try
	{
			 $PaymentProviderData=$objpaypalInvoice->GetPaymentProvider(1);	
			if(!empty($PaymentProviderData[0]['PaypalToken'])){

			echo $values['CompanyName'];
			
					
					
							$paypalUsername=$PaymentProviderData[0]['paypalUsername'];
							 $PaypalToken=$PaymentProviderData[0]['PaypalToken'];
							require($Prefix."admin/includes/html/box/savePaypalTransaction.php");
					
			}

	}
			catch (Exception $e){

			//	continue;

	}

}

?>
