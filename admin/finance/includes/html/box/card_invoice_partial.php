<?
if($CreditCardFlag==1 && !empty($ProviderName) && $arrySale[0]['PostToGL'] != "1" ){ 
	if($AmountToCharge>0){
		$card_process_link = '<a href="payINV.php?OrderID='.$OrderID.'&Action=PCard"  class="fancybox authcard grey_bt fancybox.iframe"   >Authorize Credit Card for '.number_format($AmountToCharge,2).' '.$arrySale[0]['CustomerCurrency'].'</a>';
		echo '<div style="float:right">'.$card_process_link.'</div>';

	} 		 
}
?>
<script language="JavaScript1.2" type="text/javascript">
    $(document).ready(function() {
        $(".authcard").fancybox({
            'width': 500
        });
    });
</script>
