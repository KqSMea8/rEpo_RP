<?	
print_r($_REQUEST);exit;
		if($_FILES['Image']['name'] != ''){
			$ImageExtension = GetExtension($_FILES['Image']['name']); 
			$imageName = $EmpID.".".$ImageExtension;	
			$ImageDestination = "upload/employee/".$imageName;
			if(@move_uploaded_file($_FILES['Image']['tmp_name'], $ImageDestination)){
				$objEmployee->UpdateImage($imageName,$EmpID);
			}
		}

?>