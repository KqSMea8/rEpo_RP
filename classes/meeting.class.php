<?php
class Meeting extends dbClass
{

	/*The API Key, Secret, & URL will be used in every function.*/
	private $api_key = '6JChgkFUTWGXsNf5NskaDg';
	private $api_secret = 'OxoNWBZk5oJESs72NLbRdJ7MA7Kqfr4FM1mN';
	private $api_token = 'N8KrLAGHvA6yRuqVkLdyfcCj6EAKJ3GU5ZL0';
	private $api_url = 'https://api.zoom.us/v1/';
	public $groupID  = 0;
	public $track_id = 0;
	public $timezone = '';
	public $ABS_PATH = '/var/www/html/erp/admin/crm/'; 
	var $type = 2;
	private $password = '';
	public $enable_webinar = false;
	public $approval_type = 2;
	public $registration_type = 0;
	//public $ABS_PATH = '/opt/lampp/htdocs/erp_dec/admin/crm/';
	
	/*Function to send HTTP POST Requests*/
	/*Used by every function below to make HTTP POST call*/
	function sendRequest($calledFunction, $data){
		/*Creates the endpoint URL*/
		$request_url = $this->api_url.$calledFunction;
	
		/*Adds the Key, Secret, & Datatype to the passed array*/
		$data['api_key'] = $this->api_key;
		$data['api_secret'] = $this->api_secret;
		$data['data_type'] = 'JSON';
	
		$postFields = http_build_query($data);
		/*Check to see queried fields*/
		/*Used for troubleshooting/debugging*/
		//echo $postFields;
	
		/*Preparing Query...*/
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_URL, $request_url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$response = curl_exec($ch);
	
		/*Check for any errors*/
		//$errorMessage = curl_exec($ch);
		//echo $errorMessage;
		//curl_clost($ch);
	
		/*Will print back the response from the call*/
		/*Used for troubleshooting/debugging		*/
		
		//echo $request_url;
		//var_dump($data);
		//var_dump($response);
		if(!$response){
			return false;
		}
		/*Return the data in JSON format*/
		return json_decode($response);
	}
	/*Functions for management of users*/
	
	function createGroup($displayName){ 
		$createImGroup = array();
		$createImGroup['name'] = 'eznetCRM_'.$displayName;
		$createImGroup['type'] = 'Restricted';
		return $this->sendRequest('group/create', $createImGroup);
	}
	
	function checkWebinarAvailability($data){
		$count = 0;
		if(!empty($data) && !empty($data['webinar_company_list'])){
			$webinars = explode(",", $data['webinar_company_list']);
			$count = count($webinars);
		}
		
		if($this->isZoomWebinarActive()){
			$available_webinar = $data['available_webinar']-$count;
			if($available_webinar>0){
				$this->updateWebinarStatus($data);
				return 1;
			}
			else{
				return -1;
			}
		}else{
			return 0;
		}
	}
	
	function custcreateAdminUser($data){
		$this->password = substr(md5(rand(100,10000)),0,8);
		$this->groupID = 0;
		$displayName = (!empty($_SESSION['DisplayName'])) ? $_SESSION['DisplayName'] : $data['first_name'];
		$Group = $this->createGroup($displayName);
		$this->groupID = $Group->group_id;
		if(!empty($this->groupID)){
			$ds = $this->getSuperadminZoomSettings(); //Default settings
			
			$this->enable_webinar = $this->checkWebinarAvailability($ds); //new added
			if($this->enable_webinar==-1){
				$std = new stdClass;
				$std->error = new stdClass;
				$std->error->message = 'Webinar Licence is not available right now. Please contact to administrator.';
				return $std;
			}
			
			$createAdminUserArray = array();
			$createAdminUserArray['email'] = $data['email'];
			$createAdminUserArray['type'] = $this->type; //pro user //1=basic user
			$createAdminUserArray['dept'] = 'CRM';
			$createAdminUserArray['first_name'] = $data['first_name'];
			//$createAdminUserArray['last_name'] = $data['last_name'];
			$createAdminUserArray['password'] = $this->password;
			$createAdminUserArray['disable_recording'] = true;
			$createAdminUserArray['enable_large'] = 'true';
			$createAdminUserArray['large_capacity'] = '100';
			$createAdminUserArray['group_id'] = $this->groupID;
			$createAdminUserArray['enable_silent_mode'] = ($ds['enable_silent_mode'])?true:false;
			$createAdminUserArray['enable_breakout_room'] = ($ds['enable_breakout_room'])?true:false;
			$createAdminUserArray['enable_annotation'] = ($ds['enable_annotation'])?true:false;
			$createAdminUserArray['disable_chat'] = ($ds['disable_chat'])?true:false;
			$createAdminUserArray['disable_private_chat'] = ($ds['disable_private_chat'])?true:false;
			$createAdminUserArray['enable_cmr'] = ($ds['enable_cmr'])?true:false;
			$createAdminUserArray['enable_cloud_auto_recording'] = ($ds['enable_cloud_auto_recording'])?true:false;;
			$createAdminUserArray['enable_auto_saving_chats'] = ($ds['enable_auto_saving_chats'])?true:false;
			$createAdminUserArray['enable_file_transfer'] = ($ds['enable_file_transfer'])?true:false;
			$createAdminUserArray['enable_share_dual_camera'] = ($ds['enable_share_dual_camera'])?true:false;
			$createAdminUserArray['enable_far_end_camera_control'] = ($ds['enable_far_end_camera_control'])?true:false;
			
			if($this->enable_webinar){
				$createAdminUserArray['enable_webinar'] = ($this->enable_webinar)?'true':'false';
				$createAdminUserArray['enable_share_dual_camera'] = 100;
			}
			
			$result = $this->sendRequest('user/autocreate2', $createAdminUserArray);
			
			if(!empty($result->email) && $this->enable_webinar){
				$data = array();
				$data['enable_webinar'] = $ds['enable_webinar'];
				$data['CmpID'] = $_SESSION['AdminID'];
				$data['webinar_company_list'] = $ds['webinar_company_list'];
				$this->updateWebinarStatus($data);
			}
			
			return $result;
		}else{
			return $Group;
		}
	}
	
	function custcreateUser($data){ 
		$this->password = substr(md5(rand(100,10000)),0,8);
		$adminData = $this->findMeetingUserByAdmin();
		$this->enable_webinar = (!empty($data['enable_webinar'])) ? true : false ; //new added
		$this->track_id = $adminData[0]['id'];
		$this->groupID = $adminData[0]['group_id'];
		$this->timezone = $adminData[0]['timezone'];
		if(!empty($adminData)){
			$createUserArray = array();
			$createUserArray['email'] = $data['email'];
			$createUserArray['type'] = $this->type; 
			$createUserArray['dept'] = 'CRM';
			$createUserArray['first_name'] = $data['first_name'];
			$createUserArray['last_name'] = $data['last_name'];
			$createUserArray['password'] = $this->password;
			$createUserArray['enable_large'] = 'true';
			$createUserArray['large_capacity'] = '100';
			$createUserArray['enable_silent_mode'] = ($adminData[0]['enable_silent_mode'])?true:false;
			$createUserArray['enable_breakout_room'] = ($adminData[0]['enable_breakout_room'])?true:false;
			$createUserArray['enable_annotation'] = ($adminData[0]['enable_annotation'])?true:false;
			$createUserArray['group_id'] = $adminData[0]['group_id'];
			$createUserArray['track_id'] = $adminData[0]['id'];
			$createUserArray['disable_recording'] = true;
			$createUserArray['disable_chat'] = ($adminData[0]['disable_chat'])?true:false;
			$createUserArray['disable_private_chat'] = ($adminData[0]['disable_private_chat'])?true:false;
			$createUserArray['enable_cmr'] = ($adminData[0]['enable_cmr'])?true:false;
			$createUserArray['enable_cloud_auto_recording'] = ($adminData[0]['enable_cloud_auto_recording'])?true:false;
			$createUserArray['enable_auto_saving_chats'] = ($adminData[0]['enable_auto_saving_chats'])?true:false;
			$createUserArray['enable_file_transfer'] = ($adminData[0]['enable_file_transfer'])?true:false;
			$createUserArray['enable_share_dual_camera'] = ($adminData[0]['enable_share_dual_camera'])?true:false;
			$createUserArray['enable_far_end_camera_control'] = ($adminData[0]['enable_far_end_camera_control'])?true:false;

		   return $this->sendRequest('user/autocreate2', $createUserArray);
		}else{
			return false;
		}
	}
	
	function updateUserInfo($data){
		$updateUserInfoArray = array();
		$updateUserInfoArray['id'] = $data['id'];
		$updateUserInfoArray['type'] = $this->type;
		$updateUserInfoArray['disable_recording'] = true;
		$updateUserInfoArray['enable_silent_mode'] = ($data['enable_silent_mode'])?true:false;
		$updateUserInfoArray['enable_breakout_room'] = ($data['enable_breakout_room'])?true:false;
		$updateUserInfoArray['enable_annotation'] = ($data['enable_annotation'])?true:false;
		$updateUserInfoArray['disable_chat'] = ($data['disable_chat'])?true:false;
		$updateUserInfoArray['disable_private_chat'] = ($data['disable_private_chat'])?true:false;
		$updateUserInfoArray['enable_cmr'] = ($data['enable_cmr'])?true:false;
		$updateUserInfoArray['enable_cloud_auto_recording'] = ($data['enable_cloud_auto_recording'])?true:false;
		$updateUserInfoArray['enable_auto_saving_chats'] = ($data['enable_auto_saving_chats'])?true:false;
		$updateUserInfoArray['enable_file_transfer'] = ($data['enable_file_transfer'])?true:false;
		$updateUserInfoArray['enable_share_dual_camera'] = ($data['enable_share_dual_camera'])?true:false;
		$updateUserInfoArray['enable_far_end_camera_control'] = ($data['enable_far_end_camera_control'])?true:false;
		//pr($updateUserInfoArray,1);
		return $this->sendRequest('user/update',$updateUserInfoArray);
	}
	
	function updateUserPassword($data){
		$updateUserPasswordArray = array();
		$updateUserPasswordArray['id'] = $data['id'];
		$updateUserPasswordArray['password'] = $data['userNewPassword'];
		return $this->sendRequest('user/updatepassword', $updateUserPasswordArray);
	}
	
	function meetigUTCtime($datetime,$timezone){
		$datetime = date('Y-m-d H:i:s',strtotime($datetime));
		$tz_from = $timezone;
		$tz_to = 'UTC';
		$format = 'Y-m-d H:i:s';
		
		$dt = new DateTime($datetime, new DateTimeZone($tz_from));
		$dt->setTimeZone(new DateTimeZone($tz_to));
		$tm = $dt->format($format);
		return date('Y-m-d',strtotime($tm)).'T'.date("G:i", strtotime($tm));
	}
	
	function getMeetingLocalTime($time, $Timezone){
		date_default_timezone_set("UTC");
		$arryZone = explode(":",$Timezone);
		list($hour, $minute, $second) = $arryZone;
		$minute = ($minute*100)/60;
		$hourMinute = ($hour.'.'.$minute)*3600;
	
		//$CurrenTime = gmdate("Y-m-d H:i:s");
		$CurrenTime = date("Y-m-d H:i:s", strtotime($time));
	
		$GMT = strtotime($CurrenTime)+$hourMinute;
		$DateTime = date("Y-m-d H:i:s",$GMT);
		return $DateTime;
	}
	
	function getOriginalLocalTime($time, $Timezone){
		date_default_timezone_set("UTC");
		$arryZone = explode(":",$Timezone);
		list($hour, $minute, $second) = $arryZone;
		$minute = ($minute*100)/60;
		$hourMinute = ($hour.'.'.$minute)*3600;
	
		//$CurrenTime = gmdate("Y-m-d H:i:s");
		$CurrenTime = date("Y-m-d H:i:s", strtotime($time));
	
		$GMT = strtotime($CurrenTime)-$hourMinute;
		$DateTime = date("Y-m-d H:i:s",$GMT);
		return $DateTime;
	}
	
	function getUserInfoByEmail($data){
		$getUserInfoByEmailArray = array();
		$getUserInfoByEmailArray['email'] = $data['email'];
		$getUserInfoByEmailArray['login_type'] = 100;
		return $this->sendRequest('user/getbyemail',$getUserInfoByEmailArray);
	}
	
	function checkZpkByEmail($zpk){
		$checkZpkArray = array();
		$checkZpkArray['zpk'] = $zpk;
		return $this->sendRequest('user/checkzpk',$checkZpkArray);
	}
	
	function getUserInfo($user_id){
		$getUserInfoArray = array();
		$getUserInfoArray['id'] = $user_id;
		return $this->sendRequest('user/get',$getUserInfoArray);
	}
	
	/*Functions for management of meetings*/
	function createAMeeting($data){
		
		if($data['password_check']){
			if (strlen($data['password']) >= '11') {
				$passwordErr = "Your password cannot contain more than 10 characters !";
			} else if( ! preg_match("/^[a-zA-Z0-9@_*-]+$/", $data['password'] ) ) {
				$passwordErr = "Your password field can only contain a-z, A-Z, 0-9, @ - _ *";
			} else if(empty($data['password'])) {
				$passwordErr = "Password is blank!";
			}
			if(!empty($passwordErr)){
				$passworObj = new stdClass;
				$passworObj->error->message = $passwordErr;
				return $passworObj;
			}
		}
		
		$data['duration'] = ($data['hour'] * 60) + $data['minute']  ;
		$data['start_time'] = $data['start_date'].'T'. date("G:i", strtotime($data['start_time1'].' '. $data['start_half']));
		
		$data['start_time'] = $this->meetigUTCtime($data['start_time'],$data['timezone']);
		/* $timeZone = $this->meetingTimeZone();
		$GMT = $timeZone[$data['timezone']];
		$data['timezone'] = substr($GMT,(strpos($GMT, "(")+1),strpos($GMT, ")")-(strpos($GMT, "(")+1)); */
		
		$createAMeetingArray = array();
		$createAMeetingArray['host_id'] = $data['user_id'];
		$createAMeetingArray['topic'] = $data['topic'];
		$createAMeetingArray['type'] = $data['type'];
		if($createAMeetingArray['type']!=1){
			$createAMeetingArray['start_time'] = $data['start_time'].':00Z';
			$createAMeetingArray['duration'] = $data['duration'];
			//$createAMeetingArray['timezone'] = $this->getGmtFromTimeZone($data['timezone']);
			$createAMeetingArray['timezone'] = $data['timezone'];
		}
		$createAMeetingArray['option_audio'] = $data['option_audio'];
		$createAMeetingArray['option_host_video'] = ($data['option_host_video'])?true:false;
		$createAMeetingArray['option_participants_video'] = ($data['option_participants_video'])?true:false;
		$createAMeetingArray['option_jbh'] = ($data['option_jbh'])?true:false;
		$createAMeetingArray['password'] = (!empty($data['password']) && $data['password_check'])?$data['password']:'';
		
		//pr($createAMeetingArray,1);
		//if($updateMeetingInfoArray['type']!=1) $createAMeetingArray['timezone'] = $data['timezone'];
		
		return $this->sendRequest('meeting/create', $createAMeetingArray);
	}
	
	function deleteAMeeting($meeting_id,$user_id){
		$deleteAMeetingArray = array();
		$deleteAMeetingArray['id'] = $meeting_id;
		$deleteAMeetingArray['host_id'] = $user_id;
		return $this->sendRequest('meeting/delete', $deleteAMeetingArray);
	}
	
	function updateMeetingInfo($data, $arryCurrentLocation){
		
		if($data['password_check']){
			if (strlen($data['password']) >= '11') {
				$passwordErr = "Your password cannot contain more than 10 characters !";
			} else if( ! preg_match("/^[a-zA-Z0-9@_*-]+$/", $data['password'] ) ) {
				$passwordErr = "Your password field can only contain a-z, A-Z, 0-9, @ - _ *";
			} else if(empty($data['password'])) {
				$passwordErr = "Password is blank!";
			}
			if(!empty($passwordErr)){
				$passworObj = new stdClass;
				$passworObj->error->message = $passwordErr;
				return $passworObj;
			}
		}
		
		$data['duration'] = ($data['hour'] * 60) + $data['minute']  ;
		$data['start_time'] = $data['start_date'].'T'. date("G:i", strtotime($data['start_time1'].' '. $data['start_half']));
		
		$data['start_time'] = $this->meetigUTCtime($data['start_time'],$data['timezone']);
		
		$updateMeetingInfoArray = array();
		$updateMeetingInfoArray['id'] = $data['meeting_id'];
		$updateMeetingInfoArray['host_id'] = $data['user_id'];
		$updateMeetingInfoArray['topic'] = $data['topic'];
		$updateMeetingInfoArray['type'] = $data['type'];
		if($updateMeetingInfoArray['type']!=1){
			$updateMeetingInfoArray['start_time'] = $data['start_time'].':00Z';
			$updateMeetingInfoArray['duration'] = $data['duration'];
			//$updateMeetingInfoArray['timezone'] = $this->getGmtFromTimeZone($data['timezone']);
			$updateMeetingInfoArray['timezone'] = $data['timezone'];
		}
		$updateMeetingInfoArray['option_audio'] = $data['option_audio'];
		$updateMeetingInfoArray['option_host_video'] = ($data['option_host_video'])?true:false;
		$updateMeetingInfoArray['option_participants_video'] = ($data['option_participants_video'])?true:false;
		$updateMeetingInfoArray['option_jbh'] = ($data['option_jbh'])?true:false;
		$updateMeetingInfoArray['password'] = (!empty($data['password']) && $data['password_check'])?$data['password']:'';
		//pr($updateMeetingInfoArray,1);
		$result = $this->sendRequest('meeting/update', $updateMeetingInfoArray);
		
		$updateMeetingInfoArray['password_check'] = $data['password_check'];
		$updateMeetingInfoArray['start_time'] = $this->getMeetingLocalTime($updateMeetingInfoArray['start_time'],$arryCurrentLocation[0]['Timezone']);
		//if($updateMeetingInfoArray['type']!=1) $updateMeetingInfoArray['timezone'] = $data['timezone'];
		
		if($result->id)
		$this->updateMeeting($updateMeetingInfoArray);
		
		return $result;
		
	}
	
	function getGmtFromTimeZone($loc){
		$timeZone = $this->meetingTimeZone();
		$GMT = $timeZone[$loc];
		$result = substr($GMT,(strpos($GMT, "(")+1),strpos($GMT, ")")-(strpos($GMT, "(")+1));
		return $result = (!empty($result)) ? $result : $loc;
	}
	
	function listMeetings($user_id){
		$listMeetingsArray = array();
		$listMeetingsArray['host_id'] = $user_id;
		return $this->sendRequest('meeting/list',$listMeetingsArray);
	}
	
	function endAMeeting(){
		$endAMeetingArray = array();
		$endAMeetingArray['id'] = $_POST['meetingId'];
		$endAMeetingArray['host_id'] = $_POST['userId'];
		return $this->sendRequest('meeting/end', $endAMeetingArray);
	}
	
	function listDashboardMeetings(){
		global $Config;
		$listDashboardMeetingsArray = array();
		$listDashboardMeetingsArray['type'] = 2;
		$listDashboardMeetingsArray['from'] = date('Y-m-d',strtotime("-1 days"));
		$listDashboardMeetingsArray['to'] = date('Y-m-d',strtotime("+1 days"));
		//pr($listDashboardMeetingsArray,1);
		return $this->sendRequest('metrics/meetings',$listDashboardMeetingsArray);
	}
	
	function listDashboardWebinars(){
		global $Config;
		$listDashboardWebinarsArray = array();
		$listDashboardWebinarsArray['type'] = 2;
		$listDashboardWebinarsArray['from'] = date('Y-m-d',strtotime("-1 days"));
		$listDashboardWebinarsArray['to'] = date('Y-m-d',strtotime("+1 days"));
		//pr($listDashboardMeetingsArray,1);
		return $this->sendRequest('metrics/webinars',$listDashboardWebinarsArray);
	}
	
	/*Functions for management of Reordings*/
	
	function userRecordingList($data){
		$userRecordingListArray = array();
		$userRecordingListArray['host_id'] = $data['user_id'];
		if(!empty($data['meeting_id'])) $userRecordingListArray['meeting_number'] = $data['meeting_id'];
		//$userRecordingListArray['from'] = $data['meeting_from'];
		//$userRecordingListArray['to'] = $data['meeting_to'];
		return $this->sendRequest('recording/list', $userRecordingListArray);
	}

	function userCloudDeleteRecording($data){
		$userRecordingdeleteArray = array();
		$userRecordingdeleteArray['meeting_id'] = $data['meeting_id'];
		$userRecordingdeleteArray['file_id'] = $data['file_id'];
		return $this->sendRequest('recording/delete', $userRecordingdeleteArray);
	}

/************************************************************************************/	
	
	function autoCreateAUser(){
		$autoCreateAUserArray = array();
		$autoCreateAUserArray['email'] = $_POST['userEmail'];
		$autoCreateAUserArray['type'] = $_POST['userType'];
		$autoCreateAUserArray['password'] = $_POST['userPassword'];
		return $this->sendRequest('user/autocreate', $autoCreateAUserArray);
	}
	
	function custCreateAUser(){
		$custCreateAUserArray = array();
		$custCreateAUserArray['email'] = $_POST['userEmail'];
		$custCreateAUserArray['type'] = $_POST['userType'];
		return $this->sendRequest('user/custcreate', $custCreateAUserArray);
	}
	
	function deleteUserPermanently(){
		$deleteUserPermanentlyArray = array();
		$deleteUserPermanentlyArray['id'] = $_POST['userId'];
		return $this->sendRequest('user/permanentdelete', $deleteUserPermanentlyArray);
	}
	
	function deleteAUser(){
		$deleteAUserArray = array();
		$deleteAUserArray['id'] = $_POST['userId'];
		return $this->sendRequest('user/delete', $deleteAUserArray);
	}
	
	function listUsers(){
		$listUsersArray = array();
		return $this->sendRequest('user/list', $listUsersArray);
	}
	
	function listPendingUsers(){
		$listPendingUsersArray = array();
		return $this->sendRequest('user/pending', $listPendingUsersArray);
	}
	
	
	function setUserAssistant(){
		$setUserAssistantArray = array();
		$setUserAssistantArray['id'] = $_POST['userId'];
		$setUserAssistantArray['host_email'] = $_POST['userEmail'];
		$setUserAssistantArray['assistant_email'] = $_POST['assistantEmail'];
		return $this->sendRequest('user/assistant/set', $setUserAssistantArray);
	}
	
	function deleteUserAssistant(){
		$deleteUserAssistantArray = array();
		$deleteUserAssistantArray['id'] = $_POST['userId'];
		$deleteUserAssistantArray['host_email'] = $_POST['userEmail'];
		$deleteUserAssistantArray['assistant_email'] = $_POST['assistantEmail'];
		return $this->sendRequest('user/assistant/delete',$deleteUserAssistantArray);
	}
	
	function revokeSSOToken(){
		$revokeSSOTokenArray = array();
		$revokeSSOTokenArray['id'] = $_POST['userId'];
		$revokeSSOTokenArray['email'] = $_POST['userEmail'];
		return $this->sendRequest('user/revoketoken', $revokeSSOTokenArray);
	}
	
	
	/*Functions for management of meetings*/
	
	function getMeetingInfo(){
		$getMeetingInfoArray = array();
		$getMeetingInfoArray['id'] = $_POST['meetingId'];
		$getMeetingInfoArray['host_id'] = $_POST['userId'];
		return $this->sendRequest('meeting/get', $getMeetingInfoArray);
	}
	
	
	function listRecording(){
		$listRecordingArray = array();
		$listRecordingArray['host_id'] = $_POST['userId'];
		return $this->sendRequest('recording/list', $listRecordingArray);
	}
	
	
	/*Functions for management of reports*/
	function getDailyReport(){
		$getDailyReportArray = array();
		$getDailyReportArray['year'] = $_POST['year'];
		$getDailyReportArray['month'] = $_POST['month'];
		return $this->sendRequest('report/getdailyreport', $getDailyReportArray);
	}
	
	function getAccountReport(){
		$getAccountReportArray = array();
		$getAccountReportArray['from'] = $_POST['from'];
		$getAccountReportArray['to'] = $_POST['to'];
		return $this->sendRequest('report/getaccountreport', $getAccountReportArray);
	}
	
	function getUserReport(){
		$getUserReportArray = array();
		$getUserReportArray['user_id'] = $_POST['userId'];
		$getUserReportArray['from'] = $_POST['from'];
		$getUserReportArray['to'] = $_POST['to'];
		return $this->sendRequest('report/getuserreport', $getUserReportArray);
	}
	
	
	/*Functions for management of webinars*/
	
	function listWebinars(){
		$listWebinarsArray = array();
		$listWebinarsArray['host_id'] = $_POST['userId'];
		return $this->sendRequest('webinar/list',$listWebinarsArray);
	}
	
	function getWebinarInfo(){
		$getWebinarInfoArray = array();
		$getWebinarInfoArray['id'] = $_POST['webinarId'];
		$getWebinarInfoArray['host_id'] = $_POST['userId'];
		return $this->sendRequest('webinar/get',$getWebinarInfoArray);
	}
	
	function endAWebinar(){
		$endAWebinarArray = array();
		$endAWebinarArray['id'] = $_POST['webinarId'];
		$endAWebinarArray['host_id'] = $_POST['userId'];
		return $this->sendRequest('webinar/end',$endAWebinarArray);
	}
	

/******************* User Functions *************************************/
	public function convertIsoDateToSql( $iso_date ) {
		$search = array( 'T', '.000Z', 'Z' );
		$replace = array( ' ', '' );
		$sql_date = str_replace( $search, $replace, $iso_date );
		return $sql_date;
	}
	
	public function findMeetingUserByEmail($email){
		$sql = "select * from meeting_users where email='".$email."'";
		return $this->query($sql,1);
	}
	
	public function findMeetingUserColumn($column, $value){
		$sql = "select * from meeting_users where $column='".$value."'";
		return $this->query($sql,1);
	}
	
	public function findMeetingUserByAdmin(){
		$sql = "select * from meeting_users where account_type='admin'";
		return $this->query($sql,1);
	}
	
	public function findMeetingAllUsers(){
		$sql = "select * from meeting_users order by account_type DESC";
		return $this->query($sql,1);
	}
	
	public function getMeetingUserList($type){
		$where = 'where 1 ';
		if($type!='admin'){
			$where .= " and email='".$_SESSION['EmpEmail']."' ";
		}
		$sql = "select * from meeting_users $where order by created_at DESC";
		return $this->query($sql,1);
	}
	
	public function getCustomerList($custID){
		/*$where = 'where 1 ';
		if(!empty($custID)){
			$where .= " and email='".$_SESSION['AdminEmail']."' ";
		}*/
        $strSQLQuery = "Select c.Cid as custID,IF(c.CustomerType = 'Company', Company, FullName) as CustomerName,c.CustomerType, Email, FirstName, LastName from  s_customers c where c.Status = 'Yes' having CustomerName!='' ORDER BY CustomerName ASC";
        return $this->query($strSQLQuery, 1);
	}
	
	function  ListEmployee($arryDetails)
	{
		extract($arryDetails);
	
		$strAddQuery = '';
		$SearchKey   = strtolower(trim($key));
		$strAddQuery .= (!empty($id))?(" where e.EmpID='".mysql_real_escape_string($id)."'"):(" where e.locationID=".$_SESSION['locationID']);
		$strAddQuery .= (!empty($FromDate))?(" and e.JoiningDate>='".$FromDate."'"):("");
		$strAddQuery .= (!empty($ToDate))?(" and e.JoiningDate<='".$ToDate."'"):("");
	
		$strAddQuery .= (!empty($Division))?(" and e.Division in (".$Division.")"):("");
	
		if($SearchKey=='active' && ($sortby=='e.Status' || $sortby=='') ){
			$strAddQuery .= " and e.Status=1";
		}else if($SearchKey=='inactive' && ($sortby=='e.Status' || $sortby=='') ){
			$strAddQuery .= " and e.Status=0";
		}else if($sortby != ''){
			$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
		}else{
			$strAddQuery .= (!empty($SearchKey))?(" and (e.EmpCode like '%".$SearchKey."%'  or e.UserName like '%".$SearchKey."%'  or e.Email like '%".$SearchKey."%' or e.EmpID like '%".$SearchKey."%'  or d.Department like '%".$SearchKey."%' or e.JobTitle like '%".$SearchKey."%'  ) " ):("");
		}
	
		$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by e.UserName ");
		$strAddQuery .= (!empty($asc))?($asc):(" Asc");
	
		$strSQLQuery = "select e.EmpID,e.UserID,e.EmpCode,e.Status,e.UserName,e.JobTitle, e.Email,e.FirstName,e.LastName,e.JoiningDate,e.Image,e.ExistingEmployee,d.Department,e2.UserName as SupervisorName from h_employee e left outer join  h_department d on e.Department=d.depID left outer join  h_employee e2 on e.Supervisor=e2.EmpID ".$strAddQuery;
	
	
		return $this->query($strSQLQuery, 1);
	
	}
	
	public function saveUser($arryDetails){
		
		if(is_object($arryDetails)) $arryDetails = (array) $arryDetails;
		
		$email = $this->findMeetingUserByEmail($arryDetails['email']);
		if(!empty($email[0]['email'])){
			 $_SESSION['mess_meeting'] = "$email this user is already exist!";
			 return;
		}
		
		if(!empty($this->groupID))
		$arryDetails['group_id'] = $this->groupID;
		
		if(!empty($this->track_id))
		$arryDetails['track_id'] = $this->track_id;
		
		if(!empty($this->password))
		$arryDetails['password'] = $this->password;
			
		$strSQLQuery = "insert into meeting_users SET 
						id = '".$arryDetails['id']."',
						email = '".$arryDetails['email']."',
						created_at = '".$arryDetails['created_at']."',
						first_name = '".$arryDetails['first_name']."',
						last_name = '".$arryDetails['last_name']."',
						password = '".$arryDetails['password']."',
						type = '".$this->type."',
						dept = '".$arryDetails['dept']."',
						enable_cmr = '".$arryDetails['enable_cmr']."',
						enable_large = '".$arryDetails['enable_large']."',
						enable_silent_mode = '".$arryDetails['enable_silent_mode']."',
						enable_breakout_room = '".$arryDetails['enable_breakout_room']."',
						enable_cloud_auto_recording = '".$arryDetails['enable_cloud_auto_recording']."',
						disable_chat = '".$arryDetails['disable_chat']."',
						disable_private_chat = '".$arryDetails['disable_private_chat']."',
						disable_jbh_reminder = '".$arryDetails['disable_jbh_reminder']."',
						enable_annotation = '".$arryDetails['enable_annotation']."',
						enable_auto_saving_chats = '".$arryDetails['enable_auto_saving_chats']."',
						enable_file_transfer = '".$arryDetails['enable_file_transfer']."',
						enable_share_dual_camera = '".$arryDetails['enable_share_dual_camera']."',
						enable_far_end_camera_control = '".$arryDetails['enable_far_end_camera_control']."',
						pmi = '".$arryDetails['pmi']."',
						zpk = '".$arryDetails['zpk']."',
						timezone = '".$this->timezone."',
						account_type = '".$arryDetails['account_type']."',
						group_id = '".$arryDetails['group_id']."',
						track_id = '".$arryDetails['track_id']."',
						cust_id = '".$arryDetails['cust_id']."',
						enable_webinar = '".$this->enable_webinar."'
					   ";
		$this->query($strSQLQuery, 0);
		
		if($arryDetails['account_type']=='admin'){
			$this->addAttribute();	
		}
	}
	
	function addAttribute()
	{
		$sql = "select * from c_attribute_value where attribute_value='Zoom Meeting' order by value_id asc" ;
		$exist = $this->query($sql, 1);
		if(empty($exist)){
			$sql = "insert into c_attribute_value (attribute_value,attribute_id,Status,locationID) values('Zoom Meeting','19','1','".$_SESSION['locationID']."')";
			$this->query($sql,0);
		}
	}
	
	public function deleteUserByID($id){
		$sql = "delete from meeting_users where id='".$id."'";
		$this->query($sql);
	}
	
	function updateUserStatus($id,$status){
		$sql = "update meeting_users set  status='".$status."' where user_id='".$id."'";
		return $this->query($sql);
	}
	
	function updateUserInfoTable($id,$data){
		extract($data);
		$sql = "update meeting_users set 
				type='".$type."', 
				enable_cmr='".$enable_cmr."', 
				enable_silent_mode='".$enable_silent_mode."', 
				enable_breakout_room='".$enable_breakout_room."', 
				enable_annotation='".$enable_annotation."', 
				enable_cloud_auto_recording='".$enable_cloud_auto_recording."', 
				enable_auto_saving_chats='".$enable_auto_saving_chats."', 
				disable_chat='".$disable_chat."', 
				disable_private_chat='".$disable_private_chat."', 
				enable_file_transfer='".$enable_file_transfer."', 
				enable_share_dual_camera='".$enable_share_dual_camera."', 
				enable_far_end_camera_control='".$enable_far_end_camera_control."'
				where id='".$id."'";
		return $this->query($sql);
	}
	
	function updateUserTimeZone($data){
		extract($data);
		$sql = "update meeting_users set timezone='".$timezone."' where id='".$id."'";
		return $this->query($sql);
	}
	
	function updateTableUserPassword($data){
		extract($data);
		$sql = "update meeting_users set password='".$userNewPassword."' where id='".$id."'";
		return $this->query($sql);
	}
	
	public function updateMeetingUserByZPK($zpk, $email){
		$sql = "update meeting_users set zpk = '".$zpk."' where email='".$email."'";
		return $this->query($sql);
	}
	/**************** Meeting Functions  *********************/
	
	public function saveMeeting($arryDetails){
		
		if(is_object($arryDetails)) $arryDetails = (array) $arryDetails;
	
		$meetingID = $this->findMeetingByMeetingsColumn('meeting_id',$arryDetails['id'], $arryDetails['host_id']);
		if(!empty($meetingID[0]['id'])){
			$_SESSION['mess_meeting'] = "this meeting is already exist. Please try again!";
			return;
		}
		
		$arryDetails['user_id'] = $arryDetails['host_id'];
		$arryDetails['meeting_id'] = $arryDetails['id'];
		$arryDetails['password_check'] = (!empty($arryDetails['password'])) ? true : false ;
		
		/* unset($arryDetails['host_id']);
		unset($arryDetails['id']);
		unset($arryDetails['h323_password']);
		unset($arryDetails['option_cn_meeting']);
		unset($arryDetails['option_enforce_login_domains']);
		unset($arryDetails['option_alternative_hosts']);
	
		$fields = join(',',array_keys($arryDetails));
		$values = join("','",array_values($arryDetails));
	
		$strSQLQuery = "insert into meeting_meetings ($fields)  values('" .$values."')";
		$this->query($strSQLQuery, 0); */
		
		$strSQLQuery = "insert into meeting_meetings SET
						uuid = '".$arryDetails['uuid']."',
						meeting_id = '".$arryDetails['meeting_id']."',
						user_id = '".$arryDetails['user_id']."',
						topic = '".$arryDetails['topic']."',
						password_check = '".$arryDetails['password_check']."',
						password = '".$arryDetails['password']."',
						status = '".$arryDetails['status']."',
						option_jbh = '".$arryDetails['option_jbh']."',
						option_start_type = '".$arryDetails['option_start_type']."',
						option_host_video = '".$arryDetails['option_host_video']."',
						option_participants_video = '".$arryDetails['option_participants_video']."',
						option_enforce_login = '".$arryDetails['option_enforce_login']."',
						option_in_meeting = '".$arryDetails['option_in_meeting']."',
						option_audio = '".$arryDetails['option_audio']."',
						type = '".$arryDetails['type']."',
						start_time = '".$arryDetails['start_time']."',
						duration = '".$arryDetails['duration']."',
						timezone = '".$arryDetails['timezone']."',
						start_url = '".$arryDetails['start_url']."',
						join_url = '".$arryDetails['join_url']."',
						created_at = '".$arryDetails['created_at']."'
					   ";
		$this->query($strSQLQuery, 0);
	}
	
	function updateMeeting($arryDetails){
		
		$sql = "update meeting_meetings set 
				topic='".$arryDetails['topic']."',
				password_check='".$arryDetails['password_check']."',
				password='".$arryDetails['password']."',
				option_jbh='".$arryDetails['option_jbh']."',
				option_host_video='".$arryDetails['option_host_video']."',
				option_participants_video='".$arryDetails['option_participants_video']."',
				option_audio='".$arryDetails['option_audio']."',
				type='".$arryDetails['type']."',
				start_time='".$arryDetails['start_time']."',
				duration='".$arryDetails['duration']."',
				timezone='".$arryDetails['timezone']."'
				where meeting_id='".$arryDetails['id']."' and  user_id='".$arryDetails['host_id']."'";
		return $this->query($sql);
	}
	
	public function deleteAMeetingFromTable($meeting_id, $del_id){
		$sql = "delete from meeting_meetings where meeting_id='".$meeting_id."' and  user_id='".$del_id."'";
		$this->query($sql);
	}
	
	public function findMeetingByUserID($user_id, $viewAll){ 
		global $Config;
		
		$where = 'where 1 ';
		 if($_SESSION['AdminType']!='admin' && !$viewAll){
		 	$where .= " and user_id='".$user_id."' ";
		 } 
		
		if($_GET['MeetingType']=='Previous') $where .= "and start_time < '".$Config['TodayDate']."'";
		else $where .= "and start_time >= '".$Config['TodayDate']."'";
		
		$sql = "select * from meeting_meetings $where ";
		return $this->query($sql,1);
	}
	
	public function findMeetingByMeetingsColumn($column, $value){
		$sql = "select * from meeting_meetings where $column='".$value."'";
		return $this->query($sql,1);
	}
	
	/********************** Recording functions *************************************/
	function syncrecordings($cmpID, $resentMeetings){ 
		//$userRecordarr['user_id'] = '_2qQbv5KSAG68VfkwgNCmw';
		//$userRecordarr['meeting_id'] = '799606309';
		//$this->saveUserRecordingList($userRecordarr, $cmpID);
		 //$resentMeetings = $this->listDashboardMeetings();
		$flag = false;
		if(!empty($resentMeetings->meetings)){ 
			foreach ($resentMeetings->meetings as $meeting){ 
				
				$userRecordarr = array();
				$userData = $this->findMeetingUserByEmail($meeting->email);
				$meetingData = $this->findMeetingByMeetingsColumn('meeting_id', $meeting->id);
				
				 /*if($cmpID==34){
					pr($meeting);
					pr($userData);
					pr($meetingData,1);
				} */
				
				if((!empty($meetingData) && $meeting->recording>0)){ 
					$flag = true;
					$userRecordarr['user_id'] = $meetingData[0]['user_id'];
					$userRecordarr['meeting_id'] = $meetingData[0]['meeting_id'];
					$this->saveUserRecordingList($userRecordarr, $cmpID);
					
				}else if(!empty($userData[0]['pmi']) && $meeting->id==$userData[0]['pmi'] && $meeting->recording>0){
					$flag = true;
					$userRecordarr['user_id'] = $userData[0]['id'];
					$userRecordarr['meeting_id'] = $userData[0]['pmi'];
					$this->saveUserRecordingList($userRecordarr, $cmpID);
					
				}

			 	if($flag == true) break;	

			}
		} 
	}
	
	function syncWebinarRecordings($cmpID, $resentMeetings){
		//$resentMeetings = $this->listDashboardWebinars();
		//pr($resentMeetings);
		if(!empty($resentMeetings->meetings)){
			foreach ($resentMeetings->meetings as $meeting){
	
				$userRecordarr = array();
				$meetingData = $this->findWebinarByWebinarsColumn('webinar_id', $meeting->id);
				
				if((!empty($meetingData) && $meeting->recording>0)){ 
					$userRecordarr['user_id'] = $meetingData[0]['user_id'];
					$userRecordarr['meeting_id'] = $meetingData[0]['webinar_id'];
					$this->saveUserRecordingList($userRecordarr, $cmpID);
					break;
				}
			}
		}
	}
	
	function saveUserRecordingList($data, $cmpID){
		//$resentMeetings = $this->listDashboardWebinars();
		//pr($resentMeetings,1);
		$result = $this->userRecordingList($data);
		
		if($result->error) return $_SESSION['mess_meeting'] = $result->error->message;
		
		if(!empty($result->meetings)){
			
			foreach ($result->meetings as $recording){
				
				if(!$this->getRecordingByUUID($recording->uuid) && !empty($recording->recording_files)){
					
					$this->saveMeetingRecordings($recording);
					
					foreach ($recording->recording_files as $recordingFiles){
						$filename = false;
						if($filename = $this->serverToServerFileTransfer($recordingFiles, $recording->meeting_number, $cmpID)){
							$recordingFiles->file_name = $filename;
							$this->saveMeetingRecordingFiles($recordingFiles);
							$this->meetingUpdateStorage($recordingFiles->file_size);
							$data = array();
							$data['meeting_id'] = $recordingFiles->meeting_id;
							$data['file_id'] = $recordingFiles->id;
							$this->userCloudDeleteRecording($data);
						}else{
							$this->deleteRecordingAndRecordingDetail($recording->uuid);
						}
					}
					
				}
				//$this->updateMeetingForRecording($recording->meeting_number,$recording->host_id);
			} // end meeting foreach
			
		} // end meeting
		
		if(!$result->error)
		return $_SESSION['mess_meeting'] = "process Completed Successfully!";
	}
	
	function saveMeetingRecordings($recording){ 
		$sql = "insert into meeting_recordings set
				uuid = 			 '".$recording->uuid."',
				meeting_number = '".$recording->meeting_number."',
				host_id = 		 '".$recording->host_id."',
				topic = 		 '".addslashes($recording->topic)."',
				start_time = 	 '".$recording->start_time."',
				timezone = 		 '".$recording->timezone."',
				duration = 		 '".$recording->duration."',
				total_size = 	 '".$recording->total_size."',
				recording_count ='".$recording->recording_count."'
				";
		$this->query($sql);
		return true;
	}
	
	function saveMeetingRecordingFiles($recordingFile){
		$sql = "insert into meeting_recording_files set
				file_id = 			 '".$recordingFile->id."',
				recording_uuid_id = '".$recordingFile->meeting_id."',
				recording_start = 	'".$recordingFile->recording_start."',
				recording_end = 	'".$recordingFile->recording_end."',
				file_type = 	    '".$recordingFile->file_type."',
				file_size = 		'".$recordingFile->file_size."',
				play_url =          '".$recordingFile->file_name."',
				download_url =      '',
				original_play_url = '".$recordingFile->play_url."',
				original_download_url ='".$recordingFile->download_url."'
				";
		$this->query($sql);
		return true;
	}
	
	function getRecordingByUUID($uuid){
		$sql = "select uuid from meeting_recordings where uuid='".$uuid."'";
		$result = $this->query($sql,1);
		if($result[0]['uuid']){
			return true;
		}else{
			return false;
		}
	}
	
	function getRecordingFilesByUUID($uuid){
		$sql = "select recording_uuid_id from meeting_recording_files where recording_uuid_id='".$uuid."'";
		$result = $this->query($sql,1);
		if($result[0]['recording_uuid_id']){
			return true;
		}else{
			return false;
		}
	}
	
	function getRecordingsByUserType($type, $user_id, $viewAll){
		$where = 'where 1 ';
		
		 if($type!='admin' && !$viewAll){
			$where .= " and mr.host_id='".$user_id."' ";
		} 
		
		if(!empty($_GET['meeting_id'])){
			$where .= " and mr.meeting_number='".(int)$_GET['meeting_id']."' ";
		}
		
		$sql = "select mr.*, mu.email from meeting_recordings mr left join meeting_users mu on(mr.host_id=mu.id) $where order by mr.start_time DESC";
		return $this->query($sql,1);
	}
	
	function getRecordingFilesDetail($uuid){
		$sql = "select * from meeting_recording_files where recording_uuid_id='".$uuid."'";
		return $this->query($sql,1);
	}
	
	function getRecordingFileByFileID($fileID){
		$sql = "select * from meeting_recording_files where file_id='".$fileID."'";
		return $this->query($sql,1);
	}
	
	function getRecordingDetail($uuid){
		$sql = "select * from meeting_recordings where uuid='".$uuid."'";
		return $this->query($sql,1);
	}
	
	function deleteRecording($uuid){
		$sql = "delete from meeting_recordings where uuid='".$uuid."'";
		$this->query($sql);
		return true;
	}
	
	function deleteRecordingAndRecordingDetail($uuid){
		$sql = "delete from meeting_recordings where uuid='".$uuid."'";
		$this->query($sql);
		$sql1 = "delete from meeting_recording_files where recording_uuid_id='".$uuid."'";
		$this->query($sql1);
		return true;
	}
	
	function deleteRecordingFileByFileID($fileID){
		$sql = "delete from meeting_recording_files where file_id='".$fileID."'";
		return $this->query($sql,1);
	}
	
	function deleteFullRecording($uuid){
		$rFileDetail = $this->getRecordingFilesDetail($uuid);
		if(!empty($rFileDetail)){
			foreach ($rFileDetail as $file){
				$cmpid = explode("_", $file['play_url']);
				$filename = $this->ABS_PATH.'upload/zoomMeeting/'.$cmpid[1].'/'.$file['play_url'];
				unlink($filename);
			}
			$rDetail = $this->getRecordingDetail($uuid);
			$this->meetingUpdateStorage('',$rDetail[0]['total_size'],true);
		}
		
		$this->deleteRecordingAndRecordingDetail($uuid);
	}
	
	function deleteSingleRecording($fileID){
		$rFileDetail = $this->getRecordingFileByFileID($fileID);
		if(!empty($rFileDetail)){
			
			$cmpid = explode("_", $rFileDetail[0]['play_url']);
			$filename = $this->ABS_PATH.'upload/zoomMeeting/'.$cmpid[1].'/'.$rFileDetail[0]['play_url'];
			unlink($filename);
			
			$this->meetingUpdateStorage('',$rFileDetail[0]['file_size'],true);
			$this->deleteRecordingFileByFileID($fileID);
			
			$sql = "update meeting_recordings set recording_count =recording_count-1, total_size = total_size - '".$rFileDetail[0]['file_size']."' where uuid='".$rFileDetail[0]['recording_uuid_id']."' ";
			$this->query($sql);
		}
	}
	
	function updateMeetingForRecording($meetingID,$userID){
		global $Config;
		$sql = "update meeting_meetings set is_file_moved=1, moved_time = '".$Config['TodayDate']."' where meeting_id='".$meetingID."' and user_id='".$userID."' ";
		$this->query($sql);
		return true;
	}
	
	function serverToServerFileTransfer($recordingFile, $meetingID, $cmpID){
		set_time_limit(0); //Unlimited max execution time
		if($recordingFile->file_type=='CHAT') $recordingFile->file_type = 'TXT';
		$fileName = $meetingID.'_'.$cmpID.'_'.time().'ERP_'.$recordingFile->file_size.'.'.strtolower($recordingFile->file_type);
		$MainDir = $this->ABS_PATH."upload/zoomMeeting/".$cmpID."/";
		if (!is_dir($MainDir)) {
			mkdir($MainDir);
			chmod($MainDir,0777);
		}
		
		//$path = $this->ABS_PATH;
		$url = $recordingFile->download_url;
		$newfname = $MainDir.$fileName;

		$file = fopen ($url, "rb");
		if($file) {
			$newf = fopen ($newfname, "wb");
			if($newf)
				while(!feof($file)) {
					fwrite($newf, fread($file, 1024 * 8 ), 1024 * 8 );
					//echo '1 MB File Chunk Written!<br>';
				}
		}
		if($file) {
			fclose($file);
		}
		if($newf) {
			fclose($newf);
		}
		chmod($newfname,0777);
		
		if(filesize($newfname)==$recordingFile->file_size) return $fileName;
		else return false;
	}
	
	function StorageSize($UsedStorage){
		$UsedStorage = $UsedStorage/1024;
		if($UsedStorage>0){
			if($UsedStorage<1024){
				$StorageUsed = round($UsedStorage).' KB';
			}else if($UsedStorage<1024*1024){
				$StorageUsed = round($UsedStorage/1024,2).' MB';
			}else if($UsedStorage<1024*1024*1024){
				$StorageUsed = round(($UsedStorage/(1024*1024)),2).' GB';
			}else{
				$StorageUsed = round(($UsedStorage/(1024*1024*1024)),2).' TB';
			}
		}else{
			$StorageUsed= '0';
		}
		return $StorageUsed;
	}
	
	function meetingUpdateStorage($newFilesize,$OldFileSize,$DeleteFlag)
	{
		global $Config;
		
		$AdminID = (!empty($_SESSION['CmpID'])) ? $_SESSION['CmpID'] : $Config['AdminID'] ;
		$objConfig=new admin();
		/********Connecting to main database*********/
		$objConfig->dbName = $Config['DbMain'];
		$objConfig->connect();
		/*******************************************/
		$sql = "select Storage from company where CmpID='".$AdminID."'";
		$arryRow = $this->query($sql, 1);
	
		//$FileSize = (filesize($FileDestination)/1024); //KB
		if($DeleteFlag==1 && $OldFileSize>0){ 
			$OldFileSize = $OldFileSize/1024;
			$NewStorage = $arryRow[0]['Storage'] - $OldFileSize;
		}else if($newFilesize>0){
			$newFilesize = $newFilesize/1024;
			$NewStorage = ($arryRow[0]['Storage'] + $newFilesize);
		}

		if($NewStorage>0){
			$NewStorage = round($NewStorage,2);
			$sql = "update company set Storage='".$NewStorage."' where CmpID='".$AdminID."'";
			$this->query($sql,0);
		}
		/********Connecting to Cmp database*********/
		$objConfig->dbName = $Config['DbName'];
		$objConfig->connect();
		/*******************************************/
	
		return true;
	}

/******************USER Meeting permission Settings******************************/
	
	function getPermissionByUser($user_id){
		$sql="SELECT * FROM c_chatpermission WHERE user_id='$user_id' and type = 'zoom' ";
		return $this->query($sql,1);
	}
	
	function SavePermission($data,$user_id){
		$check=$this->getPermissionByUser($user_id);
		$MeetingUser = $this->findMeetingUserByEmail($_POST['Email']);
		
		/**********************************/
		if(is_array($_POST['zoompermission']) && (in_array('createMeeting', $_POST['zoompermission']) || in_array('viewAll', $_POST['zoompermission'])) && empty($MeetingUser)){
			$userdata = array();
			$userdata['email'] = $_POST['Email'];
			$userdata['first_name'] = $_POST['FirstName'];
			$userdata['last_name'] = $_POST['LastName'];
			$result = $this->custcreateUser($userdata);
			if(!empty($result->email)){
				$result->created_at  = $this->convertIsoDateToSql($result->created_at);
				$result->cust_id = $user_id;
				$this->saveUser($result);
			}else if($result->error){
				$_SESSION['mess_employee'] = $result->error->message;
				return false;
			}else{
				$_SESSION['mess_employee'] = 'Something went wrong. Contact to Administrator!';
				return false;
			}
		}
		/**********************************/
		
		if(empty($check)){ 
			$data['user_id']=$user_id;
			$data['user_type']= 'employee';
			$this->permissionInsert($data);
			return true;
		}else{
			$this->permissionupdate($data,$user_id);
			return true;
		}
	
	}
	
	function permissionInsert($data){ 
		$sql="insert into c_chatpermission (user_id,permission,type, user_type) values ('".$data['user_id']."', '".$data['permission']."', 'zoom','".$data['user_type']."') ";
		$this->query($sql);
	}
	
	function permissionupdate($data,$user_id){
		$sql="update c_chatpermission set permission='".$data['permission']."' WHERE user_id='$user_id' and type = 'zoom' ";
		$this->query($sql);
	}
	
	function getSuperadminZoomSettings(){
		global $Config;
		
		/***********************/
		$objConfig=new admin();
		$dbName = $Config['DbName'];
		$Config['DbName'] = $Config['DbMain'];
		$objConfig->dbName = $Config['DbName'];
		$objConfig->connect();
		
		$sql = "select * from settings where Module = 'Zoom' and Status =1";
		$zoom = $objConfig->query($sql,1);
		$zoomArr = array();
		foreach ($zoom as $field => $val){
			$zoomArr[$val['S_Key']] = $val['S_Value'];
		}
		
		$Config['DbName'] = (!empty($_SESSION['CmpDatabase']))? $_SESSION['CmpDatabase'] : $dbName;
		$objConfig->dbName = $Config['DbName'];
		$objConfig->connect();
		return $zoomArr;
		
	}
	
	function createUserFromRolePermission(){
		//$adminData = $this->findMeetingUserByAdmin();
		$defaultSettings = $this->getSuperadminZoomSettings();
		$data = array();
		
		
	}
	
	function zoomMeetngActiveInactive($status){
		$status = ($status) ? 1 : 0 ;
		$strSQLQuery = "update `admin_modules` set Status='".$status."' WHERE `ModuleID` = 184";
		$this->query($strSQLQuery);
	}

	function isZoomMeetngActive(){
		$strSQLQuery = "SELECT ModuleID FROM `admin_modules` WHERE `ModuleID` = 184 and Status=1";
		$arryRow = $this->query($strSQLQuery, 1);
		if (!empty($arryRow[0]['ModuleID'])) {
			return true;
		} else {
			return false;
		}
	
	}
	/******************Meeting permision ******************************/
	
/****************** Webinar ******************************/
	function createAWebinar($data){
		
		if($data['password_check']){
			if (strlen($data['password']) >= '11') {
				$passwordErr = "Your password cannot contain more than 10 characters !";
			} else if( ! preg_match("/^[a-zA-Z0-9@_*-]+$/", $data['password'] ) ) {
				$passwordErr = "Your password field can only contain a-z, A-Z, 0-9, @ - _ *";
			} else if(empty($data['password'])) {
				$passwordErr = "Password is blank!";
			}
			if(!empty($passwordErr)){
				$passworObj = new stdClass;
				$passworObj->error->message = $passwordErr;
				return $passworObj;
			}
		}
		
		if($data['approval_type']=='0') $this->approval_type = 0; //new added

		$data['duration'] = ($data['hour'] * 60) + $data['minute']  ;
		$data['start_time'] = $data['start_date'].'T'. date("G:i", strtotime($data['start_time1'].' '. $data['start_half']));
		
		$data['start_time'] = $this->meetigUTCtime($data['start_time'],$data['timezone']);
		
		$createAWebinarArray = array();
		$createAWebinarArray['host_id'] = $data['user_id'];
		$createAWebinarArray['topic'] = $data['topic'];
		$createAWebinarArray['agenda'] = $data['agenda'];
		$createAWebinarArray['panelists'] = $data['panelists'];
		$createAWebinarArray['type'] = 5;
		if($createAWebinarArray['type']!=1){
			$createAWebinarArray['start_time'] = $data['start_time'].':00Z';
			$createAWebinarArray['duration'] = $data['duration'];
			$createAWebinarArray['timezone'] = $data['timezone'];
		}
		$createAWebinarArray['option_audio'] = $data['option_audio'];
		$createAWebinarArray['option_host_video'] = ($data['option_host_video'])?true:false;
		$createAWebinarArray['option_panelist_video'] = ($data['option_panelist_video'])?true:false;
		$createAWebinarArray['approval_type'] = $this->approval_type;
		$createAWebinarArray['registration_type'] = $this->registration_type;
		$createAWebinarArray['option_enforce_login'] = ($data['option_enforce_login'])?true:false;
		$createAWebinarArray['option_practice_session'] = ($data['option_practice_session'])?true:false;
		$createAWebinarArray['password'] = (!empty($data['password']) && $data['password_check'])?$data['password']:'';
		//pr($createAWebinarArray,1);
		return $this->sendRequest('webinar/create', $createAWebinarArray);
	}
	
	function deleteAWebinar($webinar_id,$user_id){
		$deleteAWebinarArray = array();
		$deleteAWebinarArray['id'] = $webinar_id;
		$deleteAWebinarArray['host_id'] = $user_id;
		return $this->sendRequest('webinar/delete',$deleteAWebinarArray);
	}
	
	function updateWebinarInfo($data, $arryCurrentLocation){
		if($data['password_check']){
			if (strlen($data['password']) >= '11') {
				$passwordErr = "Your password cannot contain more than 10 characters !";
			} else if( ! preg_match("/^[a-zA-Z0-9@_*-]+$/", $data['password'] ) ) {
				$passwordErr = "Your password field can only contain a-z, A-Z, 0-9, @ - _ *";
			} else if(empty($data['password'])) {
				$passwordErr = "Password is blank!";
			}
			if(!empty($passwordErr)){
				$passworObj = new stdClass;
				$passworObj->error->message = $passwordErr;
				return $passworObj;
			}
		}
		
		if($data['approval_type']=='0') $this->approval_type = 0; //new added		
		
		$data['duration'] = ($data['hour'] * 60) + $data['minute']  ;
		$data['start_time'] = $orignal_start_time = $data['start_date'].'T'. date("G:i", strtotime($data['start_time1'].' '. $data['start_half']));
	
		$data['start_time'] = $this->meetigUTCtime($data['start_time'],$data['timezone']);
	
		$updateWebinarInfoArray = array();
		$updateWebinarInfoArray['id'] = $data['webinar_id'];
		$updateWebinarInfoArray['host_id'] = $data['user_id'];
		$updateWebinarInfoArray['topic'] = $data['topic'];
		$updateWebinarInfoArray['agenda'] = $data['agenda'];
		$updateWebinarInfoArray['panelists'] = $data['panelists'];
		$updateWebinarInfoArray['type'] = 5;
		if($updateWebinarInfoArray['type']!=1){
			$updateWebinarInfoArray['start_time'] = $data['start_time'].':00Z';
			$updateWebinarInfoArray['duration'] = $data['duration'];
			$updateWebinarInfoArray['timezone'] = $data['timezone'];
		}
		$updateWebinarInfoArray['option_audio'] = $data['option_audio'];
		$updateWebinarInfoArray['option_host_video'] = ($data['option_host_video'])?true:false;
		$updateWebinarInfoArray['option_panelist_video'] = ($data['option_panelist_video'])?true:false;
		$updateWebinarInfoArray['approval_type'] = $this->approval_type;
		$updateWebinarInfoArray['registration_type'] = $this->registration_type;
		$updateWebinarInfoArray['option_enforce_login'] = ($data['option_enforce_login'])?true:false;
		$updateWebinarInfoArray['option_practice_session'] = ($data['option_practice_session'])?true:false;
		$updateWebinarInfoArray['password'] = (!empty($data['password']) && $data['password_check'])?$data['password']:'';
		//pr($updateWebinarInfoArray,1);
		$result = $this->sendRequest('webinar/update',$updateWebinarInfoArray);
	
		$updateWebinarInfoArray['start_time'] = $this->getMeetingLocalTime($updateWebinarInfoArray['start_time'],$arryCurrentLocation[0]['Timezone']);
		$updateWebinarInfoArray['password_check'] = $data['password_check'];
		$updateWebinarInfoArray['original_start_time'] =  $orignal_start_time;
		if($result->id)
			$this->updateWebinar($updateWebinarInfoArray);
	
		return $result;
	}
	
	function flipWebinar($user_id, $isWebinar){
		$updateUserInfoArray = array();
		$updateUserInfoArray['id'] = $user_id;
		$updateUserInfoArray['enable_webinar'] = ($isWebinar) ? 'true' : 'false';  
		$updateUserInfoArray['webinar_capacity'] = ($isWebinar) ? '100' : '0';
		return $this->sendRequest('user/update',$updateUserInfoArray);
	}

		function registerWebinar($data){
		$registerWebinarArray = array();
		$registerWebinarArray['id'] = $data['webinar_id'];
		$registerWebinarArray['email'] = $data['primary_email'];
		$registerWebinarArray['first_name'] = $data['FirstName'];
		$registerWebinarArray['last_name'] = (!empty($data['LastName'])) ? $data['LastName'] : $data['FirstName'];
		$registerWebinarArray['phone'] = $data['LandlineNumber'];
		return $this->sendRequest('webinar/register',$registerWebinarArray);
	}
	
	function getWebinarRegisterInfo($data){ 
		$getWebinarRegisterInfoArray = array();
		$getWebinarRegisterInfoArray['id'] = $data['webinar_id'];
		$getWebinarRegisterInfoArray['host_id'] = $data['user_id'];
		$getWebinarRegisterInfoArray['page_size'] = 100;
		return $this->sendRequest('webinar/registration',$getWebinarRegisterInfoArray);
	}

	# webinar DB function
	public function saveWebinar($arryDetails){
	
		if(is_object($arryDetails)) $arryDetails = (array) $arryDetails;
	
		$meetingID = $this->findWebinarByWebinarsColumn('webinar_id',$arryDetails['id'], $arryDetails['host_id']);
		if(!empty($meetingID[0]['id'])){
			$_SESSION['mess_meeting'] = "this webinar is already exist. Please try new!";
			return;
		}
	
		$arryDetails['user_id'] = $arryDetails['host_id'];
		$arryDetails['webinar_id'] = $arryDetails['id'];
		$arryDetails['password_check'] = (!empty($arryDetails['password'])) ? true : false ;
	
		$strSQLQuery = "insert into meeting_webinars SET
						uuid = '".$arryDetails['uuid']."',
						webinar_id = '".$arryDetails['webinar_id']."',
						user_id = '".$arryDetails['user_id']."',
						topic = '".$arryDetails['topic']."',
						agenda = '".$arryDetails['agenda']."',
						panelists = '".$arryDetails['panelists']."',
						password_check = '".$arryDetails['password_check']."',
						password = '".$arryDetails['password']."',
						status = '".$arryDetails['status']."',
						option_start_type = '".$arryDetails['option_start_type']."',
						option_host_video = '".$arryDetails['option_host_video']."',
						approval_type = '".$this->approval_type."',
						registration_type = '".$this->registration_type."',
						option_panelist_video = '".$arryDetails['option_panelist_video']."',
						option_enforce_login = '".$arryDetails['option_enforce_login']."',
						option_practice_session = '".$arryDetails['option_practice_session']."',
						option_audio = '".$arryDetails['option_audio']."',
						type = '".$arryDetails['type']."',
						start_time = '".$arryDetails['start_time']."',
						duration = '".$arryDetails['duration']."',
						timezone = '".$arryDetails['timezone']."',
						start_url = '".$arryDetails['start_url']."',
						join_url = '".$arryDetails['join_url']."',
						created_at = '".$arryDetails['created_at']."',
						original_start_time = '".$arryDetails['original_start_time']."'
					   ";
		$this->query($strSQLQuery, 0);
	}
	
	function updateWebinar($arryDetails){
	
		echo $sql = "update meeting_webinars set
				topic='".$arryDetails['topic']."',
				agenda = '".$arryDetails['agenda']."',
				panelists = '".$arryDetails['panelists']."',
				password_check='".$arryDetails['password_check']."',
				password='".$arryDetails['password']."',
				option_start_type = '".$arryDetails['option_start_type']."',
				option_host_video = '".$arryDetails['option_host_video']."',
				approval_type = '".$this->approval_type."',
				registration_type = '".$this->registration_type."',
				option_panelist_video = '".$arryDetails['option_panelist_video']."',
				option_enforce_login = '".$arryDetails['option_enforce_login']."',
				option_practice_session = '".$arryDetails['option_practice_session']."',
				option_audio = '".$arryDetails['option_audio']."',
				type='".$arryDetails['type']."',
				start_time='".$arryDetails['start_time']."',
				duration='".$arryDetails['duration']."',
				timezone='".$arryDetails['timezone']."',
				original_start_time = '".$arryDetails['original_start_time']."'
				where webinar_id='".$arryDetails['id']."' and  user_id='".$arryDetails['host_id']."'";
		return $this->query($sql);
	}
	
	public function deleteAWebinarFromTable($webinar_id, $del_id){
		$sql = "delete from meeting_webinars where webinar_id='".$webinar_id."' and  user_id='".$del_id."'";
		$this->query($sql);
	}
	
	public function findWebinarByUserID($user_id, $viewAll){
		global $Config;
	
		$where = 'where 1 ';
		if($_SESSION['AdminType']!='admin' && !$viewAll){
			$where .= " and user_id='".$user_id."' ";
		}
	
		if($_GET['WebinarType']=='Previous') $where .= "and start_time < '".$Config['TodayDate']."'";
		else $where .= "and start_time >= '".$Config['TodayDate']."'";
	
		$sql = "select * from meeting_webinars $where ";
		return $this->query($sql,1);
	}
	
	public function findWebinarByWebinarsColumn($column, $value){
		$sql = "select * from meeting_webinars where $column='".$value."'";
		return $this->query($sql,1);
	}
	
	public function updateWebinarStatus($data){
		
		$isWebinar = $data['enable_webinar'];
		$CmpID = $data['CmpID'];
		$company_list = $data['webinar_company_list'];
		
		if($isWebinar){
			$sql = "update meeting_users set enable_webinar = '1' where account_type='admin' ";
		}else{
			$sql = "update meeting_users set enable_webinar = '0' ";
		}
		$this->query($sql);
		
		$this->zoomWebinarActiveInactive($isWebinar);
		$this->updateWebinarLicence($CmpID, $company_list, $isWebinar);
		
		$sql1 = "update c_attribute_value set Status = '".$isWebinar."' where value_id='225' ";
		return $this->query($sql1);
		
	}
	
	function getWebinarLicenceCount(){
		$objConfig=new admin();
		$result = array();
		$sql = "select * from settings where S_Key='webinar_company_list' ";
		$zoom = $objConfig->query($sql,1);
	
		if($zoom)$count = explode(",", $zoom[0]['S_Value']);
	
		$result['count'] = count($count);
		$result['companyList'] = $zoom[0]['S_Value'];
	
		return $result;
	}
	
	function updateWebinarLicence($cmpID, $totalCmp, $eweb){
		//echo $totalCmp.'--'.$cmpID.'--'.$eweb;
		global $Config ;
		/***********************/
		$objConfig=new admin();
		$dbName = $Config['DbName'];
		$Config['DbName'] = $Config['DbMain'];
		$objConfig->dbName = $Config['DbName'];
		$objConfig->connect();
		
		if(empty($totalCmp)) $totalCmp = array();
		else
		$totalCmp = explode(",", $totalCmp);
		
		if($eweb){
			array_push($totalCmp, $cmpID);
		}else{
			foreach ($totalCmp as $Ckey => $Cvalue) if($Cvalue==$cmpID) unset($totalCmp[$Ckey]);
		}
		
		$totalCmp = array_unique($totalCmp);
		
		$totalCmp = implode(",", $totalCmp);
		
		$sql = "update settings set S_Value='".$totalCmp."' where S_Key='webinar_company_list' ";
		$objConfig->query($sql);
		
		$Config['DbName'] = (!empty($_SESSION['CmpDatabase']))? $_SESSION['CmpDatabase'] : $dbName;
		$objConfig->dbName = $Config['DbName'];
		$objConfig->connect();
	
	}
	
	public function getEnabledWebinarUser($user_id){
		
		$MeetingUser = $this->findMeetingUserByEmail($_POST['Email']);
		
		if($_POST['enable_webinar']){
			$user = $this->findMeetingUserColumn('enable_webinar',1);
			if(!empty($user)) $this->flipWebinar($user[0]['id'], false);
			
			if(empty($MeetingUser)){
				$userdata = array();
				$userdata['email'] = $_POST['Email'];
				$userdata['first_name'] = $_POST['FirstName'];
				$userdata['last_name'] = $_POST['LastName'];
				$result = $this->custcreateUser($userdata);
				if(!empty($result->email)){
					$result->created_at  = $this->convertIsoDateToSql($result->created_at);
					$result->cust_id = $user_id;
					$this->saveUser($result);
					$this->flipWebinar($result->id, true);
					$updateID = $result->id;
				}else if($result->error){
					$_SESSION['mess_employee'] = $result->error->message;
					if(!empty($user)) $this->flipWebinar($user[0]['id'], true); // new added
					return false;
				}else{
					$_SESSION['mess_employee'] = 'Something went wrong. Contact to Administrator!';
					if(!empty($user)) $this->flipWebinar($user[0]['id'], true); // new added
					return false;
				}
			}else{
				$this->flipWebinar($MeetingUser[0]['id'], true);
				$updateID = $MeetingUser[0]['id'];
			}
		}else{
			
			if($MeetingUser[0]['enable_webinar']) $this->flipWebinar($MeetingUser[0]['id'], false);
			
			$admin = $this->findMeetingUserByAdmin();
			if(!empty($admin)){
				$this->flipWebinar($admin[0]['id'], true);
				$updateID = $admin[0]['id'];
			}
			
		}
		
		if(!empty($updateID)){
			$sql = "update meeting_users set enable_webinar = '0' ";
			$this->query($sql);
			
			$sql1 = "update meeting_users set enable_webinar = '1' where id = '".$updateID."' ";
			$this->query($sql1);
		}
		
		return true;
	}
	
	function zoomWebinarActiveInactive($status){
		$status = ($status) ? 1 : 0 ;
		$strSQLQuery = "update `settings` set setting_value	='".$status."' WHERE `setting_key` = 'ZOOM_WEBINAR' ";
		$this->query($strSQLQuery);
	}
	
	function isZoomWebinarActive(){
		$strSQLQuery = "SELECT group_name FROM `settings` WHERE `setting_key` = 'ZOOM_WEBINAR' and setting_value=1";
		$arryRow = $this->query($strSQLQuery, 1);
		if (!empty($arryRow[0]['group_name'])) {
			return true;
		} else {
			return false;
		}
	
	}

	
	
/****************** End of Webinar ***********************/
	
	
/******************************* TimeZone *********************************************************/
	
	function meetingTimeZone_old(){
		return $timezones = array(
				'Pacific/Midway'       => "(GMT-11:00) Midway Island, Samoa",
				'US/Samoa'             => "(GMT-11:00) Samoa",
				'US/Hawaii'            => "(GMT-10:00) Hawaii",
				'US/Alaska'            => "(GMT-09:00) Alaska",
				'America/Los_Angeles'  => "(GMT-08:00) Pacific Time (US &amp; Canada)",
				'America/Tijuana'      => "(GMT-08:00) Tijuana",
				'US/Arizona'           => "(GMT-07:00) Arizona",
				'US/Mountain'          => "(GMT-07:00) Mountain Time (US &amp; Canada)",
				'America/Chihuahua'    => "(GMT-07:00) Chihuahua",
				'America/Mazatlan'     => "(GMT-07:00) Mazatlan",
				'America/Mexico_City'  => "(GMT-06:00) Mexico City",
				'America/Monterrey'    => "(GMT-06:00) Monterrey",
				'Canada/Saskatchewan'  => "(GMT-06:00) Saskatchewan",
				'US/Central'           => "(GMT-06:00) Central Time (US &amp; Canada)",
				'US/Eastern'           => "(GMT-05:00) Eastern Time (US &amp; Canada)",
				'US/East-Indiana'      => "(GMT-05:00) Indiana (East)",
				'America/Bogota'       => "(GMT-05:00) Bogota",
				'America/Lima'         => "(GMT-05:00) Lima",
				'America/Caracas'      => "(GMT-04:30) Caracas",
				'Canada/Atlantic'      => "(GMT-04:00) Atlantic Time (Canada)",
				'America/La_Paz'       => "(GMT-04:00) La Paz",
				'America/Santiago'     => "(GMT-04:00) Santiago",
				'Canada/Newfoundland'  => "(GMT-03:30) Newfoundland",
				'America/Buenos_Aires' => "(GMT-03:00) Buenos Aires",
				'Greenland'            => "(GMT-03:00) Greenland",
				'Atlantic/Stanley'     => "(GMT-02:00) Stanley",
				'Atlantic/Azores'      => "(GMT-01:00) Azores",
				'Atlantic/Cape_Verde'  => "(GMT-01:00) Cape Verde Is.",
				'Africa/Casablanca'    => "(GMT) Casablanca",
				'Europe/Dublin'        => "(GMT) Dublin",
				'Europe/Lisbon'        => "(GMT) Lisbon",
				'Europe/London'        => "(GMT) London",
				'Africa/Monrovia'      => "(GMT) Monrovia",
				'Europe/Amsterdam'     => "(GMT+01:00) Amsterdam",
				'Europe/Belgrade'      => "(GMT+01:00) Belgrade",
				'Europe/Berlin'        => "(GMT+01:00) Berlin",
				'Europe/Bratislava'    => "(GMT+01:00) Bratislava",
				'Europe/Brussels'      => "(GMT+01:00) Brussels",
				'Europe/Budapest'      => "(GMT+01:00) Budapest",
				'Europe/Copenhagen'    => "(GMT+01:00) Copenhagen",
				'Europe/Ljubljana'     => "(GMT+01:00) Ljubljana",
				'Europe/Madrid'        => "(GMT+01:00) Madrid",
				'Europe/Paris'         => "(GMT+01:00) Paris",
				'Europe/Prague'        => "(GMT+01:00) Prague",
				'Europe/Rome'          => "(GMT+01:00) Rome",
				'Europe/Sarajevo'      => "(GMT+01:00) Sarajevo",
				'Europe/Skopje'        => "(GMT+01:00) Skopje",
				'Europe/Stockholm'     => "(GMT+01:00) Stockholm",
				'Europe/Vienna'        => "(GMT+01:00) Vienna",
				'Europe/Warsaw'        => "(GMT+01:00) Warsaw",
				'Europe/Zagreb'        => "(GMT+01:00) Zagreb",
				'Europe/Athens'        => "(GMT+02:00) Athens",
				'Europe/Bucharest'     => "(GMT+02:00) Bucharest",
				'Africa/Cairo'         => "(GMT+02:00) Cairo",
				'Africa/Harare'        => "(GMT+02:00) Harare",
				'Europe/Helsinki'      => "(GMT+02:00) Helsinki",
				'Europe/Istanbul'      => "(GMT+02:00) Istanbul",
				'Asia/Jerusalem'       => "(GMT+02:00) Jerusalem",
				'Europe/Kiev'          => "(GMT+02:00) Kyiv",
				'Europe/Minsk'         => "(GMT+02:00) Minsk",
				'Europe/Riga'          => "(GMT+02:00) Riga",
				'Europe/Sofia'         => "(GMT+02:00) Sofia",
				'Europe/Tallinn'       => "(GMT+02:00) Tallinn",
				'Europe/Vilnius'       => "(GMT+02:00) Vilnius",
				'Asia/Baghdad'         => "(GMT+03:00) Baghdad",
				'Asia/Kuwait'          => "(GMT+03:00) Kuwait",
				'Africa/Nairobi'       => "(GMT+03:00) Nairobi",
				'Asia/Riyadh'          => "(GMT+03:00) Riyadh",
				'Europe/Moscow'        => "(GMT+03:00) Moscow",
				'Asia/Tehran'          => "(GMT+03:30) Tehran",
				'Asia/Baku'            => "(GMT+04:00) Baku",
				'Europe/Volgograd'     => "(GMT+04:00) Volgograd",
				'Asia/Muscat'          => "(GMT+04:00) Muscat",
				'Asia/Tbilisi'         => "(GMT+04:00) Tbilisi",
				'Asia/Yerevan'         => "(GMT+04:00) Yerevan",
				'Asia/Kabul'           => "(GMT+04:30) Kabul",
				'Asia/Karachi'         => "(GMT+05:00) Karachi",
				'Asia/Tashkent'        => "(GMT+05:00) Tashkent",
				'Asia/Kolkata'         => "(GMT+05:30) Kolkata",
				'Asia/Kathmandu'       => "(GMT+05:45) Kathmandu",
				'Asia/Yekaterinburg'   => "(GMT+06:00) Ekaterinburg",
				'Asia/Almaty'          => "(GMT+06:00) Almaty",
				'Asia/Dhaka'           => "(GMT+06:00) Dhaka",
				'Asia/Novosibirsk'     => "(GMT+07:00) Novosibirsk",
				'Asia/Bangkok'         => "(GMT+07:00) Bangkok",
				'Asia/Jakarta'         => "(GMT+07:00) Jakarta",
				'Asia/Krasnoyarsk'     => "(GMT+08:00) Krasnoyarsk",
				'Asia/Chongqing'       => "(GMT+08:00) Chongqing",
				'Asia/Hong_Kong'       => "(GMT+08:00) Hong Kong",
				'Asia/Kuala_Lumpur'    => "(GMT+08:00) Kuala Lumpur",
				'Australia/Perth'      => "(GMT+08:00) Perth",
				'Asia/Singapore'       => "(GMT+08:00) Singapore",
				'Asia/Taipei'          => "(GMT+08:00) Taipei",
				'Asia/Ulaanbaatar'     => "(GMT+08:00) Ulaan Bataar",
				'Asia/Urumqi'          => "(GMT+08:00) Urumqi",
				'Asia/Irkutsk'         => "(GMT+09:00) Irkutsk",
				'Asia/Seoul'           => "(GMT+09:00) Seoul",
				'Asia/Tokyo'           => "(GMT+09:00) Tokyo",
				'Australia/Adelaide'   => "(GMT+09:30) Adelaide",
				'Australia/Darwin'     => "(GMT+09:30) Darwin",
				'Asia/Yakutsk'         => "(GMT+10:00) Yakutsk",
				'Australia/Brisbane'   => "(GMT+10:00) Brisbane",
				'Australia/Canberra'   => "(GMT+10:00) Canberra",
				'Pacific/Guam'         => "(GMT+10:00) Guam",
				'Australia/Hobart'     => "(GMT+10:00) Hobart",
				'Australia/Melbourne'  => "(GMT+10:00) Melbourne",
				'Pacific/Port_Moresby' => "(GMT+10:00) Port Moresby",
				'Australia/Sydney'     => "(GMT+10:00) Sydney",
				'Asia/Vladivostok'     => "(GMT+11:00) Vladivostok",
				'Asia/Magadan'         => "(GMT+12:00) Magadan",
				'Pacific/Auckland'     => "(GMT+12:00) Auckland",
				'Pacific/Fiji'         => "(GMT+12:00) Fiji",
		);
	}
	
	
	function meetingTimeZone(){
		return $timezones = array(
			"Pacific/Midway"=>"(GMT-11:00) Midway Island, Samoa",
			"Pacific/Pago_Pago"=>"(GMT-11:00) Pago Pago",
			"Pacific/Honolulu"=>"(GMT-10:00) Hawaii",
			"America/Anchorage"=>"(GMT-8:00) Alaska",
			"America/Vancouver"=>"(GMT-7:00)Vancouver",
			"America/Los_Angeles"=>"(GMT-7:00) Pacific Time (US and Canada)",
			"America/Tijuana"=>"(GMT-7:00) Tijuana",
			"America/Denver"=>"(GMT-6:00) Mountain Time (US and Canada)",
			"America/Phoenix"=>"(GMT-7:00) Arizona",
			"America/Mazatlan"=>"(GMT-7:00) Mazatlan",
			"America/Edmonton"=>"(GMT-6:00) Edmonton",
			"America/Winnipeg"=>"(GMT-6:00) Winnipeg",
			"America/Regina"=>"(GMT-6:00) Saskatchewan",
			"America/Chicago"=>"(GMT-5:00) Central Time (US and Canada)",
			"America/Mexico_City"=>"(GMT-6:00) Mexico City",
			"America/Guatemala"=>"(GMT-6:00) Guatemala",
			"America/El_Salvador"=>"(GMT-6:00) El Salvador",
			"America/Managua"=>"(GMT-6:00) Managua",
			"America/Costa_Rica"=>"(GMT-6:00) Costa Rica",
			"America/Montreal"=>"(GMT-4:00) Montreal",
			"America/New_York"=>"(GMT-4:00) Eastern Time (US and Canada)",
			"America/Indianapolis"=>"(GMT-4:00) Indiana (East)",
			"America/Panama"=>"(GMT-5:00) Panama",
			"America/Bogota"=>"(GMT-5:00) Bogota",
			"America/Lima"=>"(GMT-5:00) Lima",
			"America/Halifax"=>"(GMT-3:00) Halifax",
			"America/Puerto_Rico"=>"(GMT-4:00) Puerto Rico",
			"America/Caracas"=>"(GMT-4:00) Caracas",
			"America/Santiago"=>"(GMT-3:00) Santiago",
			"America/St_Johns"=>"(GMT-2:30) Newfoundland and Labrador",
			"America/Montevideo"=>"(GMT-3:00) Montevideo",
			"America/Araguaina"=>"(GMT-3:00) Brasilia",
			"America/Argentina/Buenos_Aires"=>"(GMT-3:00) Buenos Aires, Georgetown",
			"America/Godthab"=>"(GMT-3:00) Greenland",
			"America/Sao_Paulo"=>"(GMT-3:00) Sao Paulo",
			"Atlantic/Azores"=>"(GMT-1:00) Azores",
			"Canada/Atlantic"=>"(GMT-3:00) Atlantic Time (Canada)",
			"Atlantic/Cape_Verde"=>"(GMT-1:00) Cape Verde Islands",
			"UTC"=>"(GMT+0:00) Universal Time UTC",
			"Etc/Greenwich"=>"(GMT+0:00) Greenwich Mean Time",
			"Europe/Belgrade"=>"(GMT+1:00) Belgrade, Bratislava, Ljubljana",
			"CET"=>"(GMT+1:00) Sarajevo, Skopje, Zagreb",
			"Atlantic/Reykjavik"=>"(GMT+0:00) Reykjavik",
			"Europe/Dublin"=>"(GMT+0:00) Dublin",
			"Europe/London"=>"(GMT+0:00) London",
			"Europe/Lisbon"=>"(GMT+0:00) Lisbon",
			"Africa/Casablanca"=>"(GMT+0:00) Casablanca",
			"Africa/Nouakchott"=>"(GMT+0:00) Nouakchott",
			"Europe/Oslo"=>"(GMT+1:00) Oslo",
			"Europe/Copenhagen"=>"(GMT+1:00) Copenhagen",
			"Europe/Brussels"=>"(GMT+1:00) Brussels",
			"Europe/Berlin"=>"(GMT+1:00) Amsterdam, Berlin, Rome, Stockholm, Vienna",
			"Europe/Helsinki"=>"(GMT+2:00) Helsinki",
			"Europe/Amsterdam"=>"(GMT+1:00) Amsterdam",
			"Europe/Rome"=>"(GMT+1:00) Rome",
			"Europe/Stockholm"=>"(GMT+1:00) Stockholm",
			"Europe/Vienna"=>"(GMT+1:00) Vienna",
			"Europe/Luxembourg"=>"(GMT+1:00) Luxembourg",
			"Europe/Paris"=>"(GMT+1:00) Paris",
			"Europe/Zurich"=>"(GMT+1:00) Zurich",
			"Europe/Madrid"=>"(GMT+1:00) Madrid",
			"Africa/Bangui"=>"(GMT+1:00) West Central Africa",
			"Africa/Algiers"=>"(GMT+1:00) Algiers",
			"Africa/Tunis"=>"(GMT+1:00) Tunis",
			"Africa/Harare"=>"(GMT+2:00) Harare, Pretoria",
			"Africa/Nairobi"=>"(GMT+3:00) Nairobi",
			"Europe/Warsaw"=>"(GMT+1:00) Warsaw",
			"Europe/Prague"=>"(GMT+1:00) Prague Bratislava",
			"Europe/Budapest"=>"(GMT+1:00) Budapest",
			"Europe/Sofia"=>"(GMT+2:00) Sofia",
			"Europe/Istanbul"=>"(GMT+3:00) Istanbul",
			"Europe/Athens"=>"(GMT+2:00) Athens",
			"Europe/Bucharest"=>"(GMT+2:00) Bucharest",
			"Asia/Nicosia"=>"(GMT+2:00) Nicosia",
			"Asia/Beirut"=>"(GMT+2:00) Beirut",
			"Asia/Damascus"=>"(GMT+2:00) Damascus",
			"Asia/Jerusalem"=>"(GMT+2:00) Jerusalem",
			"Asia/Amman"=>"(GMT+2:00) Amman",
			"Africa/Tripoli"=>"(GMT+2:00) Tripoli",
			"Africa/Cairo"=>"(GMT+2:00) Cairo",
			"Africa/Johannesburg"=>"(GMT+2:00) Johannesburg",
			"Europe/Moscow"=>"(GMT+3:00) Moscow",
			"Asia/Baghdad"=>"(GMT+3:00) Baghdad",
			"Asia/Kuwait"=>"(GMT+3:00) Kuwait",
			"Asia/Riyadh"=>"(GMT+3:00) Riyadh",
			"Asia/Bahrain"=>"(GMT+3:00) Bahrain",
			"Asia/Qatar"=>"(GMT+3:00) Qatar",
			"Asia/Aden"=>"(GMT+3:00) Aden",
			"Asia/Tehran"=>"(GMT+3:30) Tehran",
			"Africa/Khartoum"=>"(GMT+3:00) Khartoum",
			"Africa/Djibouti"=>"(GMT+3:00) Djibouti",
			"Africa/Mogadishu"=>"(GMT+3:00) Mogadishu",
			"Asia/Dubai"=>"(GMT+4:00) Dubai",
			"Asia/Muscat"=>"(GMT+4:00) Muscat",
			"Asia/Baku"=>"(GMT+4:00) Baku, Tbilisi, Yerevan",
			"Asia/Kabul"=>"(GMT+4:30) Kabul",
			"Asia/Yekaterinburg"=>"(GMT+5:00) Yekaterinburg",
			"Asia/Tashkent"=>"(GMT+5:00) Islamabad, Karachi, Tashkent",
			"Asia/Calcutta"=>"(GMT+5:30) India",
			"Asia/Kathmandu"=>"(GMT+5:45) Kathmandu",
			"Asia/Novosibirsk"=>"(GMT+7:00) Novosibirsk",
			"Asia/Almaty"=>"(GMT+6:00) Almaty",
			"Asia/Dacca"=>"(GMT+6:00) Dacca",
			"Asia/Krasnoyarsk"=>"(GMT+7:00) Krasnoyarsk",
			"Asia/Dhaka"=>"(GMT+6:00) Astana, Dhaka",
			"Asia/Bangkok"=>"(GMT+7:00) Bangkok",
			"Asia/Saigon"=>"(GMT+7:00) Vietnam",
			"Asia/Jakarta"=>"(GMT+7:00) Jakarta",
			"Asia/Irkutsk"=>"(GMT+8:00) Irkutsk, Ulaanbaatar",
			"Asia/Shanghai"=>"(GMT+8:00) Beijing, Shanghai",
			"Asia/Hong_Kong"=>"(GMT+8:00) Hong Kong",
			"Asia/Taipei"=>"(GMT+8:00) Taipei",
			"Asia/Kuala_Lumpur"=>"(GMT+8:00) Kuala Lumpur",
			"Asia/Singapore"=>"(GMT+8:00) Singapore",
			"Australia/Perth"=>"(GMT+8:00) Perth",
			"Asia/Yakutsk"=>"(GMT+9:00) Yakutsk",
			"Asia/Seoul"=>"(GMT+9:00) Seoul",
			"Asia/Tokyo"=>"(GMT+9:00) Osaka, Sapporo, Tokyo",
			"Australia/Darwin"=>"(GMT+9:30) Darwin",
			"Australia/Adelaide"=>"(GMT+10:30) Adelaide",
			"Asia/Vladivostok"=>"(GMT+10:00) Vladivostok",
			"Pacific/Port_Moresby"=>"(GMT+10:00) Guam, Port Moresby",
			"Australia/Brisbane"=>"(GMT+10:00) Brisbane",
			"Australia/Sydney"=>"(GMT+11:00) Canberra, Melbourne, Sydney",
			"Australia/Hobart"=>"(GMT+11:00) Hobart",
			"Asia/Magadan"=>"(GMT+11:00) Magadan",
			"SST"=>"(GMT+11:00) Solomon Islands",
			"Pacific/Noumea"=>"(GMT+11:00) New Caledonia",
			"Asia/Kamchatka"=>"(GMT+12:00) Kamchatka",
			"Pacific/Fiji"=>"(GMT+12:00) Fiji Islands, Marshall Islands",
			"Pacific/Auckland"=>"(GMT+13:00) Auckland, Wellington",
			"Asia/Kolkata"=>"(GMT+5:30) Mumbai, Kolkata, New Delhi",
			"Europe/Kiev"=>"(GMT+2:00) Kiev",
			"America/Tegucigalpa"=>"(GMT+6:00) Tegucigalpa",
			"Pacific/Apia"=>"(GMT+14:00) Independent State of Samoa"
		);
	}
}
