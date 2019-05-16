<?

	if(!empty($NextID)){
		$NextUrl = $NextPrevUrl.'&view='.$NextID[0]['OrderID'];
		echo '<a class="next" title="Next '.ucfirst($_GET["module"]).'" href="'.$NextUrl.'" onclick="LoaderSearch();"></a>';
	}
	if(!empty($PrevID)){
		$PrevUrl = $NextPrevUrl.'&view='.$PrevID[0]['OrderID'];
		echo '<a class="prev" title="Previous '.ucfirst($_GET["module"]).'" href="'.$PrevUrl.'" onclick="LoaderSearch();"></a>';
	}

?>
