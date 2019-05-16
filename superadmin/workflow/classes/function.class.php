<?php
class functions 
{
	
	 /**************************/
	 function CheckUploadedFile($File,$FileType){
		global $Config;

		$arr_t = explode(".",$File["name"]);
		$Extension = strtolower(end($arr_t)); 
		
		switch($FileType){
			case 'Image':
				$AllowedExtension = array("jpg","gif","png");
				break;
			case 'Scan':
				$AllowedExtension = array("pdf","jpg","gif","png");
				break;
			case 'Document':
				$AllowedExtension = array("pdf","doc","docx", "ppt","pptx", "xls","xlsx","rtf","txt");
				break;
			case 'Resume':
				$AllowedExtension = array("pdf","doc","docx","rtf","txt");
				break;
			case 'Video':
				$AllowedExtension = array("swf","flv");
				break;
			case 'Excel':
				$AllowedExtension = array("xls","csv");
				break;
			case 'Pdf':
				$AllowedExtension = array("pdf");
				break;
			case 'Banner':
				$AllowedExtension = array("jpg","gif","png","swf");
				break;
			case 'Zip':
				$AllowedExtension = array("zip");
				break;
			case 'Flash':
				$AllowedExtension = array("swf","flv");
				break;
		}


		if(!empty($Config['StorageLimitError'])){
			$ErrorMsg = $Config['StorageLimitError'];
		}else if(!in_array($Extension,$AllowedExtension)){
			$ErrorMsg = UPLOAD_ERROR_EXT;
		}else if($File["error"]>0){
			$ErrorMsg = $this->ErrorMessage($File["error"]); 
		}else{
			$ErrorMsg = '';
		}

		$FileArray['ErrorMsg'] = $ErrorMsg;
		$FileArray['Extension'] = $Extension;
		return $FileArray;
	 }

	/**************************/

	function ErrorMessage($code)
	{
		switch ($code) {
			case UPLOAD_ERR_INI_SIZE:
				$message = "The uploaded file exceeds the maximum upload limit.";
				break;
			case UPLOAD_ERR_FORM_SIZE:
				$message = "The uploaded file exceeds the maximum file size directive that was specified in the form.";
				break;
			case UPLOAD_ERR_PARTIAL:
				$message = "The uploaded file was only partially uploaded.";
				break;
			case UPLOAD_ERR_NO_FILE:
				$message = "No file was uploaded.";
				break;
			case UPLOAD_ERR_NO_TMP_DIR:
				$message = "Missing a temporary folder.";
				break;
			case UPLOAD_ERR_CANT_WRITE:
				$message = "Failed to write file to disk.";
				break;
			case UPLOAD_ERR_EXTENSION:
				$message = "File upload stopped by extension.";
				break;

			default:
				$message = "Unknown upload error.";
				break;
		}


		return $message;
	} 





}

?>
