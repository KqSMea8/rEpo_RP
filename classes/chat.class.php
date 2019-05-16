<?php 

class chat extends dbFunction
{
		//constructor
		var $tables;
		public $server_id;
		function chat()
		{
			global $configTables,$Config;		
			$this->tables='c_chatpermission';
			$this->curlurl='https://www.eznetchat.com:8080/';
			$this->dbClass();
		} 
	/*
	 * get Chat Permission
	 * @return object Result
	 */
	
	function getPermissionByUser($user_id){
	$results=array();
	$sql="SELECT * FROM ".$this->tables." WHERE user_id='$user_id' and type='chat' ";
	$results=$this->get_results($sql);	
	return $results;
	}

	function SavePermission($data,$user_id){
		$check=$this->getPermissionByUser($user_id);		
		if(empty($check)){
			$data['user_id']=$user_id;		
			$this->insert($this->tables,$data);
		}else{		
			$this->update($this->tables,$data,array('user_id'=>$user_id,'type'=>'chat'));	
		}
	
	}
	
	function chatCurl($url,$post){

	
	try{
		$fields_string='';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$this->curlurl.$url);
		curl_setopt($ch, CURLOPT_POST, 1);
	foreach($post as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
		rtrim($fields_string, '&');
	if(!empty($fields_string)){
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
	}
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//	curl_setopt($handle, CURLOPT_VERBOSE, true);
//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);  // Fixed Code
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);  // Fixed Code
	
	$server_output = curl_exec ($ch);
	curl_close ($ch);
		return $server_output;
	}catch (Exception $e){
			return false;
	
	}

	}
	
	
	function getChatLicence($comId=0,$server=false){
	if($server==false){
		$server=$_SERVER['HTTP_HOST'];
	}		
		$licence='';
		$licence=$this->chatCurl('getcompanylicence',array('companyid'=>$comId,'server'=>$server));

		if(!empty($licence))
		{
			$licence=json_decode($licence);
			if($licence->status==1){
				$licence=$licence->licence;
			}else{
				return 0;			
			}
		}
		return $licence;
	}
	
	function getchatrole($userid){
		if(empty($userid))
		return false;
		$sql="Select * FROM c_chatuserroles WHERE user_id='$userid'";
		return $this->get_results($sql);
		
	}
	
	function Savechatrole($chatrole=array(),$chatuid){
	
		if(empty($chatuid))
		return false;
		$prerole=$this->getchatrole($chatuid);
		
		if(empty($prerole)){
			if(!empty($chatrole)){
				foreach($chatrole as $chatro){
				$tmpdata=array('user_id'=>$chatuid,'rolename'=>$chatro,'role_id'=>0);
					$this->insert('c_chatuserroles',$tmpdata);				
				}
			}
		
		}else{
		$tmp=array();
			foreach($prerole as $prero){
			$tmp[]=$prero->rolename;			
			}
			$insertarray=array_diff($chatrole,$tmp);
			$deletearray=array_diff($tmp,$chatrole);			
			if(!empty($insertarray)){			
				foreach($insertarray as $chatro){
					$tmpdata=array('user_id'=>$chatuid,'rolename'=>$chatro,'role_id'=>0);
					$this->insert('c_chatuserroles',$tmpdata);				
				}
			}
			if(!empty($deletearray)){
				foreach($deletearray as $deletear){
					$sql="DELETE FROM c_chatuserroles WHERE user_id='$chatuid' AND rolename='$deletear'";
					$this->query($sql);
				}
			}
			
		
		}
	
	}
	
	function redirect($url){
	header('Location:'.$url);
	exit;
	}
	
	function getIdealTime(){	
		$sql="Select setting_key,setting_value FROM settings WHERE setting_key='Chat_Ideal_Time'";
		$time=$this->get_results($sql);	
		$res=!empty($time[0]->setting_value)?$time[0]->setting_value:5;
		return $res;
		
	}
	function getIdealTimeUpdate($time){
		$data['setting_value']=$time;
	
		$this->update('settings',$data,array('setting_key'=>'Chat_Ideal_Time'));
	
	}
	
}

?>
