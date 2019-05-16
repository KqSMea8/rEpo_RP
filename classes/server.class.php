<?php
class server extends dbClass
{
	
		//constructor
		function company()
		{
			$this->dbClass();
		} 
		
		function  ListServer($id='')
		{	
			global $Config;
			if(!empty($id)){
				$whereQuery = " AND id = '".$id."'";
			}
			$strSQLQuery = "SELECT SQL_CALC_FOUND_ROWS * FROM ";
			$strSQLQuery .= "(SELECT id,name,ip,DECODE(username,'". $Config['EncryptKey']."') as username,DECODE(password,'". $Config['EncryptKey']."') as password,DECODE(port,'". $Config['EncryptKey']."') as port,status,deleted,ServerType,url,Fixed FROM `server_detail` where deleted='0' $whereQuery ) vt1,";
			$strSQLQuery .= "(SELECT FOUND_ROWS() AS 'TOTAL_RECORD') vt2 ";
			/*if($Config['RecordsPerPage']>0){
					$strSQLQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
					
			}*/
			
			return $this->query($strSQLQuery, 1);		
				
		}	
		

		public function save($postData){
			
			//echo "<pre>";print_r($postData);die;
			$name = !empty($postData['name'])?$postData['name']:'';
			$ip = !empty($postData['ip'])?$postData['ip']:'';
			$port = !empty($postData['port'])?$postData['port']:'';
			$username = !empty($postData['username'])?$postData['username']:'';
			$password = !empty($postData['password'])?$postData['password']:'';
			$status = !empty($postData['status'])?$postData['status']:'';
			$ServerType = !empty($postData['ServerType'])?$postData['ServerType']:'';
			$url = !empty($postData['url'])?$postData['url']:'';
			$Fixed = !empty($postData['Fixed'])?$postData['Fixed']:'';
			
			if(empty($postData['id'] )){
				
				$strSQLQuery = "insert into server_detail (ip,port,username,password,status,name,ServerType,url,Fixed) values('$ip',ENCODE('".$port."','".$Config['EncryptKey']."'),ENCODE('".$username."','".$Config['EncryptKey']."'),ENCODE('".$password."','".$Config['EncryptKey']."'),'$status','$name','$ServerType','$url','$Fixed')";
				$this->query($strSQLQuery, 0);
				
				if(!empty($this->lastInsertId())){
					return array('error'=>0,'msg'=>"Server added successfully");
				}
			}else{
				$strSQLQuery = "update server_detail set ip = '$ip',port = ENCODE('".$port."','".$Config['EncryptKey']."'),username=ENCODE('".$username."','".$Config['EncryptKey']."'),password=ENCODE('".$password."','".$Config['EncryptKey']."'),status='$status',name='$name',ServerType='".$ServerType."',url='".$url."',Fixed='".$Fixed."' where id = '".$postData['id']."'";
				$this->query($strSQLQuery, 0);
				return array('error'=>0,'msg'=>"Server updated successfully");
			}
			return array('error'=>1,'msg'=>"Something went wrong");
		}
		
		
		public function delete($id){
			$strSQLQuery = "update server_detail set deleted='1' where id = '".$id."'";
		
			$this->query($strSQLQuery, 0);
		}
		
		
	function GetFileSize($filepath){
	     $FileSize = filesize($filepath)/1024; //KB

	     $UsedStorage = $FileSize; //kb
	     if($UsedStorage>0){
		 if($UsedStorage<1024){
		     $StorageUsed = round($UsedStorage,2).' KB';			
		 }else if($UsedStorage<1024*1024){
		     $StorageUsed = round($UsedStorage/1024,2).' MB';
		 }else if($UsedStorage<1024*1024*1024){
		     $StorageUsed = round(($UsedStorage/(1024*1024)),8).' GB';
		 }else{
		     $StorageUsed = round(($UsedStorage/(1024*1024*1024)),8).' TB';
		 }
	     }else{
		 $StorageUsed= '0';
	     }


	     return $StorageUsed;
	}
		

	function  Listfiles($file,$arryDetails)
			{ 
			global $Config;
			extract($arryDetails);	

				$strAddQuery = '';
				$SearchKey   = strtolower(trim($key));
				foreach($file as $key=>$values){
				     $path_parts = pathinfo($values);
				     $aa = date ("F d Y H:i:s", filemtime($values));
				   //  echo $path_parts['filename'].'<br>';			 
		       //  echo "Modified Date :  " . date ("F d Y H:i:s.", filemtime($values)).'<br>';						
				if($SearchKey==$path_parts['filename'] && ($sortby=='filename' || $sortby=='') ){  
				
				}else if($SearchKey==$aa && ($sortby=='datefile' || $sortby=='') ){ 
					$strAddQuery .= " and r.Status=0";
				}
			
				//return $this->query($strSQLQuery, 1);						
			}	
		}
		
		
}
?>
