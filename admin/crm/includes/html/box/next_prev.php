<?

	if($NextID>0){
		$NextUrl = $NextPrevUrl.'&view='.$NextID;
		echo '<a class="next" title="Next '.ucfirst($_GET["module"]).'" href="'.$NextUrl.'" onclick="LoaderSearch();"></a>';
	}
	if($PrevID>0){
		$PrevUrl = $NextPrevUrl.'&view='.$PrevID;
		echo '<a class="prev" title="Previous '.ucfirst($_GET["module"]).'" href="'.$PrevUrl.'" onclick="LoaderSearch();"></a>';
	}

?>
