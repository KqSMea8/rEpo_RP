<?php

/* Developer Name: Karishma
 * Date : 04-Jan-16
 * 
 */
class template extends dbClass { 
 
/*********************start of template uploader**********************/
		function ListTemplates()
		{
			
			global $Config;
			
			$sql = "select * from templates order by TemplateDisplayName asc" ; 
			return $this->get_results($sql);		
	    }
		function getTemplateById($Id)
		{
			global $Config;
			$sql = "select * from templates where TemplateId ='".addslashes($Id)."' order by TemplateDisplayName asc" ; 
			return $this->get_results($sql);		
	    }
	    
		function addTemplate($arryDetails) {
                        global $Config;
			@extract($arryDetails);
			
                        unset($arryDetails['TemplateId']);
                        unset($arryDetails['Submit']);
                        
			$response=$this->uploadfile($_FILES);
                        
			if($response=='success'){
				$filename = $_FILES["template"]["name"];
				$name = explode(".", $filename);
				$TemplateName=$name[0];
				$Prefix = $_SERVER['DOCUMENT_ROOT'].'/'.$Config['ecomfolder'];
				$dir = $Prefix."/template/".$TemplateName;  
				
				$files = scandir($dir, 1);
				
				$Thumbnail=$files[0];
                                
                                $arryDetails['TemplateName']=$TemplateName;
                                $arryDetails['Thumbnail']=$Thumbnail;
                                $arryDetails['Status']='1';
				
                                $result= $this->insert('templates',$arryDetails); 
				
                               /* $sql = "INSERT INTO  templates SET TemplateName='" . addslashes($TemplateName) . "',
				TemplateDisplayName='" . addslashes($TemplateDisplayName) . "', 
				TemplateType='" . addslashes($TemplateType) . "', 
				Thumbnail='" . addslashes($Thumbnail) . "', 
				Status='1' ".$sqltemp." ";
				$this->query($sql, 0);*/
				
			
			}
			return $response;
	
			
		}

		function updateTemplate($arryDetails) {  
			@extract($arryDetails);
			
			if(!empty($TemplateId)){
				
				$TemplateId=$arryDetails['TemplateId'];
				unset($arryDetails['Submit']);
				unset($arryDetails['TemplateId']);
				
			$this->update('templates',$arryDetails,array('TemplateId'=>$TemplateId));
			}
			/*$sql = "UPDATE  templates SET TemplateDisplayName='" . addslashes($TemplateDisplayName) . "',TemplateType='" . addslashes($TemplateType) . "' 
			 WHERE TemplateId =" . $TemplateId; 
			$this->query($sql, 0);*/
		}
		
		function uploadfile($file){
			 global $Config;
			
			if($file["template"]["name"]) {
				$filename = $file["template"]["name"];
				$source = $file["template"]["tmp_name"];
				$type = $file["template"]["type"];
				
				$name = explode(".", $filename);
				$accepted_types = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');
				foreach($accepted_types as $mime_type) {
					if($mime_type == $type) {
						$okay = true;
						break;
					} 
				}
				
				$continue = strtolower($name[1]) == 'zip' ? true : false;
				if(!$continue) {
					$message = ADD_TEMPLATE_ONLY_ZIP;
					return $message;
				}
				
				$Prefix = $_SERVER['DOCUMENT_ROOT'].'/'.$Config['ecomfolder']; 
				//$Prefix ='../../'.$Config['ecomfolder'];   
				 $MainDir = $Prefix."/template/";                        
								if (!is_dir($MainDir)) {
									mkdir($MainDir);
									chmod($MainDir,0777);
								}
								
				$filename = $_FILES['template']['name'];
							
				$target_path = $MainDir.$filename; 
				
				
				
				if (is_dir($MainDir.$name[0])) {
							$continue=false;
				} 
				if(!$continue) {
					$message = ADD_TEMPLATE_ALREADY_EXIT;
					return $message;
				}				
				
				if(move_uploaded_file($source, $target_path)) {
					
					$zip = new ZipArchive();
					$x = $zip->open($target_path); 
					if ($x === true) { 
						$zip->extractTo($MainDir); 
						$zip->close();
				
						unlink($target_path);
					}
					$message = "success";
				} else {
                                    
					$message = ADD_TEMPLATE_FAIL;
				}
			}
			
			return $message;
		}
  
  
   
}

?>
	


