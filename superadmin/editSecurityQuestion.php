<?php 
	/**************************************************/
	$ThisPageName = 'viewSecurityQuestion.php'; $EditPage = 1; 
	/**************************************************/

	include_once("includes/header.php");
        require_once("../classes/question.class.php");
	 
        $questionObj=new question();
        
 
	$_GET['edit'] = (int)$_GET['edit'];
  	$QuestionID = (int)$_GET['edit'];
	$_GET['active_id'] = (int)$_GET['active_id'];
	$_GET['del_id'] = (int)$_GET['del_id'];
	$ModuleName = 'Question';
	
	
	$ListUrl    = "viewSecurityQuestion.php?curP=".$_GET['curP'];

  	if(!empty($_GET['active_id'])){
		$_SESSION['mess_question'] = QUESTION_STATUS_CHANGED;
		$questionObj->changeQuestionStatus($_GET['active_id']);
		header("location:".$ListUrl);
		exit;
	 }
	

	 if(!empty($_GET['del_id'])){             
                $_SESSION['mess_question'] = QUESTION_REMOVED;
                $questionObj->deleteQuestion($_GET['del_id']);
                header("location:".$ListUrl);
                exit;
	}


		 
		 if (!empty($_POST)) {
		 CleanPost();  
                        if (!empty($QuestionID)) {
                                                     $_SESSION['mess_question'] = QUESTION_UPDATED;
                                                    $questionObj->updateQuestion($_POST);
                                                    header("location:".$ListUrl);
                                            } else {
                                            	
							   
                                                    $_SESSION['mess_question'] = QUESTION_ADDED;
                                                    $lastShipId = $questionObj->AddQuestion($_POST);	
                                                   header("location:".$ListUrl);
                                            }

                                            exit;

		}
	

	$QuestionStatus = "1";

	if (!empty($QuestionID)){
		$arryeditQuestion = $questionObj->getQuestionById($QuestionID);

		if($arryeditQuestion[0]['Status'] == "0"){
			$QuestionStatus = "0";
		}else{
			$QuestionStatus = "1";
		}   
		
	}
		
	
	                        

	
		
	require_once("includes/footer.php"); 	 
?>


