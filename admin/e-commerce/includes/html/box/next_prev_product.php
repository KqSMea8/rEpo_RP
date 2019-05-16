<?

	if($NextID>0){
		$NextUrl = $NextPrevUrl.'&view='.$NextID.'&CatID='.$NextCatID;
		echo '<a class="next" title="Next '.ucfirst($_GET["tab"]).'" href="'.$NextUrl.'" onclick="LoaderSearch();"></a>';
	}
	if($PrevID>0){
		$PrevUrl = $NextPrevUrl.'&view='.$PrevID.'&CatID='.$PrevCatID;
		echo '<a class="prev" title="Previous '.ucfirst($_GET["tab"]).'" href="'.$PrevUrl.'" onclick="LoaderSearch();"></a>';
	}

?>
