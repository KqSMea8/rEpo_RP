<?

	if(!empty($NextID[0]['OrderID'])){
		$ShippedID = (!empty($NextID[0]['ShippedID']))?($NextID[0]['ShippedID']):('');
		$NextUrl = $NextPrevUrl.'&view='.$NextID[0]['OrderID'].'&ship='.$ShippedID;
		//if($Ie == 'yes') {  $NextUrl = $NextUrl.'&IE='.$NextID[0]['InvoiceEntry']; }
		echo '<a class="next" title="Next '.ucfirst($_GET["module"]).'" href="'.$NextUrl.'" onclick="LoaderSearch();"></a>';
	}
	if(!empty($PrevID[0]['OrderID'])){
		$ShippedID = (!empty($PrevID[0]['ShippedID']))?($PrevID[0]['ShippedID']):('');
		$PrevUrl = $NextPrevUrl.'&view='.$PrevID[0]['OrderID'].'&ship='.$ShippedID;
		//if($Ie == 'yes') {  $PrevUrl = $PrevUrl.'&IE='.$PrevID[0]['InvoiceEntry']; }
		echo '<a class="prev" title="Previous '.ucfirst($_GET["module"]).'" href="'.$PrevUrl.'" onclick="LoaderSearch();"></a>';
	}

?>
