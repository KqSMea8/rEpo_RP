<?php   
	ini_set("display_errors","1"); error_reporting(5);	
	require_once("includes/config.php");	
	require_once("classes/dbClass.php");
	require_once("includes/function.php");
	require_once("classes/MyMailer.php");	
	require_once("classes/admin.class.php");	
	require_once("classes/company.class.php");
	require_once("classes/configure.class.php");
	require_once("classes/lead.class.php");
	require_once("admin/language/english.php");
	require_once($Prefix . "classes/crm.class.php");//added by sanjiv
	require_once($Prefix . "classes/meeting.class.php");//added by sanjiv
        
	$objConfig=new admin();	
    	$objCommon = new common();   
        #$_POST['Cmp'] = 'a5bfc9e07964f8dddeb95fc584cd965d';
         if (session_status() == PHP_SESSION_NONE) {
    	session_start();
	}
	if(!empty($_POST['Cmp'])) { 



	if($_POST['6dcf6b']!='' || $_POST['00cf98']!=''){
		$_POST['6dcf6b'] = $_POST['dcf6b'];
		$_POST['00cf98'] = $_POST['cf98'];
	}
 

						/*if(strtolower($_SESSION['CAPTCHA_CODE'])!=strtolower($_POST['captcha'])){
								header("Location:".$_SERVER['HTTP_REFERER']);
								$_SESSION['CAPTCHA_CODE_ERROR']=1;
								die("Captcha Code Not Match");
							}
							unset($_POST['captcha']);
							unset($_SESSION['CAPTCHA_CODE_ERROR']);
*/

	$response = $_POST["g-recaptcha-response"];
	$url = 'https://www.google.com/recaptcha/api/siteverify';
	$data = array(
		'secret' => $_POST["secret"],//updated on 26Dec2017 by chetan//
		'response' => $_POST["g-recaptcha-response"]
	); 
	$options = array(
		'http' => array (
		'header' => "Content-Type: application/x-www-form-urlencoded\r\n".
                    "Content-Length: ".strlen($query)."\r\n".
                    "User-Agent:MyAgent/1.0\r\n",
			'method' => 'POST',
			'content' => http_build_query($data)
		)
	);
	$context  = stream_context_create($options);
	$verify = file_get_contents($url, false, $context);
	$captcha_success=json_decode($verify);
	/*if ($captcha_success->success==false) {

              echo "<script>
                        alert('You are a bot! Go away!.');
                        location.href='".$_SERVER['HTTP_REFERER']."';
                        </script>";

	}*/ 



            $RefererUrl = $_SERVER['HTTP_REFERER'];
            $arryCompany = $objConfig->GetCompanyBySecuredID($_POST['Cmp']);
            if(empty($arryCompany[0]['DisplayName'])){           
                $ErrorMsg =  ERROR_NO_DB;
            }else{
                
                $CmpDatabase = $Config['DbMain']."_".$arryCompany[0]['DisplayName'];
                $Config['DbName2'] = $CmpDatabase;
                if(!$objConfig->connect_check()){
                        $ErrorMsg = ERROR_NO_DB;
                }else {				
                        $Config['DbName'] = $CmpDatabase;
                        $objConfig->dbName = $Config['DbName'];
                        $objConfig->connect();
                        
                }
                               
                
                
		
            }
    if ($captcha_success->success==false) {
            if(!empty($ErrorMsg)){
                echo $ErrorMsg; exit;
            }else{  
                               
                $Config['SiteName']  = stripslashes($arryCompany[0]['CompanyName']);	
		$Config['SiteTitle'] = stripslashes($arryCompany[0]['CompanyName']);
		$Config['AdminEmail'] = $arryCompany[0]['Email'];			
		$Config['MailFooter'] = '['.stripslashes($arryCompany[0]['CompanyName']).']';
		$Config['CmpDepartment'] = $arryCompany[0]['Department'];		
		$Config['DateFormat'] = $arryCompany[0]['DateFormat'];
		$Config['TodayDate'] = getLocalTime($arryCompany[0]['Timezone']); 
                $Config['EmailTemplateFolder'] = 'admin/'.$Config['EmailTemplateFolder'];
                 // added by sanjiv
				$_POST['IsLeadForm'] = true;
                if(!empty($_POST['RoleGroup'])){
				$_POST['RoleGroup'] = base64_decode($_POST['RoleGroup']);
                $_POST['assign'] = 'Users';
				if(!is_array($_POST['RoleGroup']))
                $_POST['AssignToUser'] = $objCommon->getAllCRMRoleGroupUsers($_POST['RoleGroup']);// added by sanjiv
				}
				unset($_POST['RoleGroup']);
				
				// added new
				if(!empty($_POST['webinar_id'])){
					$objMeeting = new Meeting();
					$result = $objMeeting->registerWebinar($_POST);
					
					if($result->error){
						echo "<script>
                        alert('Failed! ".$result->error->message."');
                        location.href='".$RefererUrl."';
                        </script>";
					}
					
				}
				unset($_POST['webinar_id']);
				unset($_POST["g-recaptcha-response"]);
				unset($_POST["secret"]);//Added on 26Dec2017 by chetan//

unset($_POST['_wpcf7']);
unset($_POST['_wpcf7_version']);
unset($_POST['_wpcf7_locale']);
unset($_POST['_wpcf7_unit_tag']);
unset($_POST['_wpcf7_container_post']);
unset($_POST['_wpcf7_quiz_answer_quiz-862']);
unset($_POST['dcf6b']);
unset($_POST['cf98']);
	unset($_POST['quiz-862']);			
				// end
				// end
                $objLead = new lead();    
		CleanPost($_POST); 

 
            
                $LeadID = $objLead->AddLead($_POST,$arryCompany[0]['CmpID']);    
                if($LeadID>0){
                    echo "<script>
                        alert('Thanks for submitting your query. We will get back to you soon.');
                        location.href='".$RefererUrl."';
                        </script>";
                }
            }

}
        } 



?>


