<?

class webcms extends dbClass
{

	
	/*************************Front end function**********************************/

	function  GetGlobalSetting()
	{
		$sql = "SELECT Setting.* FROM e_template AS Setting ";
		return $this->query($sql, 1);
	}

	function  GetTemplate($TemplateId='')
	{
		global $Config;	
			
			$objConfig=new admin();		
			/********Connecting to main database*********/
			$Config['DbName'] = $Config['DbMain'];
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();
			/*******************************************/	
			if($TemplateId=='' || $TemplateId==0){
				$sql = "SELECT * from templates where  TemplateType='e' ORDER BY TemplateId DESC limit 1 ";
				$templates= $this->query($sql, 1);
			}else{
			$sql = "SELECT * from templates where  TemplateId='".addslashes($TemplateId)."' ORDER BY TemplateId DESC ";
			$templates= $this->query($sql, 1);
			}
			/********Connecting to Cmp database*********/
			$Config['DbName'] = $_SESSION['CmpDatabase'];
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();
			/*******************************************/
			return $templates;
	}
	

	function scantemplate($templatepath){

		if ($handle = opendir($templatepath)) {
			while (false !== ($entry = readdir($handle))) {
				if ($entry != "." && $entry != "..") {
						
					if(is_dir($templatepath.'/'.$entry) && $entry=='css'){

						return $this->scantemplate($templatepath.'/'.$entry);
					}
					elseif(is_file($templatepath.'/'.$entry)){

						$Extension = GetExtension($entry);
						if($Extension=='css'){
							$cssArray[]=str_replace($_SERVER['DOCUMENT_ROOT'], "", $templatepath.'/'.$entry);
							
							//$cssArray[]=$templatepath.'/'.$entry;
						}

					}
				}
			}
			closedir($handle);
		}

		return $cssArray;
	}
}

?>
