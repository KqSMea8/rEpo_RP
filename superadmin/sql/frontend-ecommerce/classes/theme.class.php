<?php

class theme extends dbClass
{

	function  GetTemplate($TemplateId='1',$page='home')
	{
			
		$sql = "SELECT a.*,b.header,b.footer,b.left,b.right from theme_pages as a
			left join theme_theme b on b.id=a.themeId
			where a.themeId='" . addslashes($TemplateId) . "' 
			and a.page='" . addslashes($page) . "' ";
		$templates= $this->query($sql, 1);
			
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
