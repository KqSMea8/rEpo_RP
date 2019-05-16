<?php
class pager{
	var $intNumPerPage,
		$intTotalNumRecords,
		$intCurrentPage,
		$intTotalNumPage,
		$strShowPaging,
		$arryRecords,
		$arryPageRecords,
		$intLoopStartPoint,
		$intLoopEndPoint,
		$intPagePerScreen,
		$arryServerVar,
		$indexReturn,
		$strURL;
	function pager(){
		global $_SERVER;
		$this->arryServerVar=$_SERVER;
		$queryString=$this->arryServerVar['QUERY_STRING'];
		$queryString=explode("&",$queryString);
		#echo '<pre>'; print_r($queryString);exit;

		foreach($queryString as $key => $values){
			//if(eregi('curP*',$values)){
			if (preg_match('/curP/i', $values)){
			unset($queryString[$key]);
			}
		}
		$this->strURL=implode("&",$queryString);
		
	}
	function setNumPerPage($num){
		$this->intNumPerPage=$num;
	}
	function setTotalNumRecords($num){
		$this->intTotalNumRecords=$num;
	}
	function setCurrentPage($num){
		$this->intCurrentPage=$num;
	}
	function setTotalNumPage(){
		$this->intTotalNumPage=ceil($this->intTotalNumRecords/$this->intNumPerPage);
	}
	function setPagePerScreen($num=5){
		if($this->intTotalNumPage>$num){
			$this->intPagePerScreen=$num;
		}else{
			$this->intPagePerScreen=$this->intTotalNumPage;
		}
		
	}
	function setLoopStartEnd(){
		$this->intLoopStartPoint = 1;
		$this->intLoopEndPoint	 = $this->intPagePerScreen;
		if(($this->intCurrentPage) > ($this->intPagePerScreen)){
			$this->intLoopStartPoint = $this->intCurrentPage - $this->intPagePerScreen + 1;
			if (($this->intLoopStartPoint + $this->intPagePerScreen) <= ($this->intTotalNumPage)) {
				$this->intLoopEndPoint=$this->intLoopStartPoint + $this->intPagePerScreen - 1;
			} else {
				$this->intLoopEndPoint = $this->intTotalNumPage;
			}
		} 
		
	}	
	

	function setPaging($module){  
			
						
			if (($this->intTotalNumPage > $this->intPagePerScreen) && ($this->intCurrentPage != 1)) {
			
			$this->strShowPaging.="<a href=\"Javascript:GetPagingData(1,'".$module."');\" class=\"pagenumber\">First</a> ";							
			}
			if ($this->intLoopStartPoint > 1) {
				$intPreviousPage=$this->intCurrentPage - 1;
				
				$this->strShowPaging.="<a href=\"Javascript:GetPagingData(".$intPreviousPage.",'".$module."');\" class=\"edit22\"> &lt;&lt; </a> ";			
			}				
		for($i=$this->intLoopStartPoint;$i<=$this->intLoopEndPoint;$i++){
			if ($this->intCurrentPage==$i) {
						
			$this->strShowPaging.= '<span class="pagenumber"><b>'.$i.'</b></span> ';
			
			} else {
			
			$this->strShowPaging.="<a href=\"Javascript:GetPagingData(".$i.",'".$module."');\"  class=\"pagenumber\">".$i."</a> ";
			}
			if ($i!=$this->intLoopEndPoint) {
				$this->strShowPaging.=" ";
			}
		}
		
		if ($this->intLoopEndPoint < $this->intTotalNumPage) {
			$intNextPage=$this->intCurrentPage+1;
			
			$this->strShowPaging.="<a href=\"Javascript:GetPagingData(".$intNextPage.",'".$module."');\"  class=\"pagenumber\"> &gt;&gt; </a> ";
		}
		if (($this->intTotalNumPage > $this->intPagePerScreen) && ($this->intCurrentPage != $this->intTotalNumPage)) {
				
			$this->strShowPaging.="<a href=\"Javascript:GetPagingData(".$this->intTotalNumPage.",'".$module."');\"  class=\"pagenumber\">Last</a> ";		
		}
		return $this->strShowPaging;			
	}

	function getPaging($TotalRecords, $intNumPerPage=10,$intCurrentPage=1,$module){
		$this->setNumPerPage($intNumPerPage);
		$this->setTotalNumRecords($TotalRecords);
		$this->setTotalNumPage();
		$this->setCurrentPage($intCurrentPage);
		$this->setPagePerScreen(5);
		$this->setLoopStartEnd();
		
		return $this->setPaging($module);
	}

	function getPager($arryTotalRecords, $intNumPerPage=12,$intCurrentPage=1){
		$this->setRecords($arryTotalRecords);
		$this->setNumPerPage($intNumPerPage);
		$this->setTotalNumRecords(count($arryTotalRecords));
		$this->setTotalNumPage();
		$this->setCurrentPage($intCurrentPage);
		$this->setPagePerScreen(5);
		$this->setLoopStartEnd();
		
		return $this->setPager();
	}
	function setRecords($arryRecords){
		$this->arryRecords=$arryRecords;
	}
	function getPageRecords(){
		$this->indexReturn=$this->intCurrentPage-1;
		if ($this->arryRecords) {
			$this->arryPageRecords=array_chunk($this->arryRecords,$this->intNumPerPage);
			if (array_key_exists($this->indexReturn, $this->arryPageRecords)) {
				return $this->arryPageRecords[$this->indexReturn];
			} else {
				$this->indexReturn = $this->indexReturn-1;
				return $this->arryPageRecords[$this->indexReturn];
			}
		}
		
	}
}



?>
