<?
(empty($Ie))?($Ie=""):("");
	if(!empty($NextID)){
		$NextUrl = $NextPrevUrl.'&view='.$NextID[0]['OrderID'];
		if($Ie == 'yes') {  $NextUrl = $NextUrl.'&IE='.$NextID[0]['InvoiceEntry']; }
		echo '<a class="next" title="Next '.ucfirst($_GET["module"]).'" href="'.$NextUrl.'" onclick="LoaderSearch();"></a>';
	}
	if(!empty($PrevID)){
		$PrevUrl = $NextPrevUrl.'&view='.$PrevID[0]['OrderID'];
		if($Ie == 'yes') {  $PrevUrl = $PrevUrl.'&IE='.$PrevID[0]['InvoiceEntry']; }
		echo '<a class="prev" title="Previous '.ucfirst($_GET["module"]).'" href="'.$PrevUrl.'" onclick="LoaderSearch();"></a>';
	}

?>
