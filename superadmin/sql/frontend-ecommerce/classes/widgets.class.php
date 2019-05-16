<?php

class widgets extends dbClass
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

	

}

?>
