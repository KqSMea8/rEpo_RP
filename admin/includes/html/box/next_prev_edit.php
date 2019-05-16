<?

	if($NextID>0){
		$NextUrl = $NextPrevUrl.'&edit='.$NextID;
		if(!empty($NextCatID)) $NextUrl .= '&CatID='.$NextCatID;
		echo '<a class="next" title="Next '.ucfirst($_GET["module"]).'" href="'.$NextUrl.'" onclick="LoaderSearch();"></a>';
	}
	if($PrevID>0){
		$PrevUrl = $NextPrevUrl.'&edit='.$PrevID;
		if(!empty($PrevCatID)) $PrevUrl .= '&CatID='.$PrevCatID;
		echo '<a class="prev" title="Previous '.ucfirst($_GET["module"]).'" href="'.$PrevUrl.'" onclick="LoaderSearch();"></a>';
	}

?>
