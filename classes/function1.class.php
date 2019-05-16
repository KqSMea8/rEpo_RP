<?
class functions 
{
	
	 /**************************/
	 function CheckUploadedFile($File,$FileType){
		global $Config;
		$FileSize = ($File["size"] / (1024 * 1000));  //MB

		$arr_t = explode(".",$File["name"]);
		$Extension = strtolower(end($arr_t)); 
		
		switch($FileType){
			case 'Image':
				$AllowedExtension = array("jpg","gif","png");
				$MaxFileSize = '2'; //MB
				break;
			case 'Document':
				$AllowedExtension = array("pdf","doc","docx", "ppt","pptx", "xls","xlsx","rtf","txt");
				$MaxFileSize = '2'; //MB
				break;
			case 'Resume':
				$AllowedExtension = array("pdf","doc","docx","rtf","txt");
				$MaxFileSize = '2'; //MB
				break;
			case 'Video':
				$AllowedExtension = array("swf","flv");
				$MaxFileSize = '2'; //MB
				break;
			case 'Excel':
				$AllowedExtension = array("xls");
				$MaxFileSize = '2'; //MB
				break;
			case 'Pdf':
				$AllowedExtension = array("pdf");
				$MaxFileSize = '2'; //MB
				break;
			case 'Banner':
				$AllowedExtension = array("jpg","gif","png","swf");
				$MaxFileSize = '2'; //MB
				break;
			case 'Zip':
				$AllowedExtension = array("zip");
				$MaxFileSize = '2'; //MB
				break;
			case 'Flash':
				$AllowedExtension = array("swf","flv");
				$MaxFileSize = '2'; //MB
				break;
		}



		if(!in_array($Extension,$AllowedExtension)){
			$ErrorMsg = UPLOAD_ERROR_EXT;
		}else if($FileSize > $MaxFileSize){
			$ErrorMsg = UPLOAD_ERROR_SIZE;
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
				$message = "The uploaded file exceeds the upload_max_filesize directive in php.ini";
				break;
			case UPLOAD_ERR_FORM_SIZE:
				$message = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
				break;
			case UPLOAD_ERR_PARTIAL:
				$message = "The uploaded file was only partially uploaded";
				break;
			case UPLOAD_ERR_NO_FILE:
				$message = "No file was uploaded";
				break;
			case UPLOAD_ERR_NO_TMP_DIR:
				$message = "Missing a temporary folder";
				break;
			case UPLOAD_ERR_CANT_WRITE:
				$message = "Failed to write file to disk";
				break;
			case UPLOAD_ERR_EXTENSION:
				$message = "File upload stopped by extension";
				break;

			default:
				$message = "Unknown upload error";
				break;
		}


		//echo $message; exit;

		return $message;
	} 






}

?>