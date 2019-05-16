<?php


class Validation{
	public $error = array();
	public $errorCode = array();
	private $ruletype = array();
	public $erro = array();
	public $requestvalue = array();
	public $requestdata = array();
	

		function Validation() {
	
	
  		 }	
  
   
   
   function validate($arg){
   	global $wpdb;
   	$error=array();
   	$err='';
   	
	   	if(!empty($arg)){
	   		$this->requestdata=$arg;
                        //echo '<pre>'; print_r($this->requestdata);die;
	   		foreach($arg as $k=>$result){
	   			if(!empty($result) AND is_array($result)){
	   				
	   				foreach($result as $rulevalue){	
                                            
                                            //echo '<pre>'; print_r($rulevalue);die;
	   					switch(trim($rulevalue['rule'])){
		   					case 'notempty':
		   						$err=$this->requriedValidate($this->requestvalue[$k]);
		   						if($err)
		   						$error[$k]=$rulevalue['message'];
		   					break;
		   					case 'email':
		   						$err=$this->emailValidate($this->requestvalue[$k]);
		   						if(!empty($err)){		   							
		   						 $error[$k]=$rulevalue['message'];
		   						}
		   					break;
		   					case 'string':
		   						$err=$this->stringValidate($this->requestvalue[$k]);
		   						if($err)
		   						$error[$k]=$rulevalue['message'];
		   					break;
		   					case 'number':
		   						$err=$this->numberValidate($this->requestvalue[$k]);
		   						if($err)
		   						$error[$k]=$rulevalue['message'];
		   					break;
                                                        case 'float':
		   						$err=$this-> floatValidate($this->requestvalue[$k]);
		   						if($err)
		   						$error[$k]=$rulevalue['message'];
		   					break;
                                                       
		   					case 'alphanumaric':
		   						$err=$this->alphanumaricValidate($this->requestvalue[$k]);
		   						if($err)
		   						$error[$k]=$rulevalue['message'];
		   					break;
		   					case 'currency':
		   						$err=$this->currencyValidate($this->requestvalue[$k]);
		   						if($err)
		   						$error[$k]=$rulevalue['message'];
		   					break;
		   					case 'removahtml':
		   						$err=$this->removahtmlValidate($this->requestvalue[$k]);		   						
		   						if($err)
		   						$error[$k]=$rulevalue['message'];
		   					break;
		   					case 'url':
		   						$err=$this->urlValidate($this->requestvalue[$k]);
		   						if($err)
		   						$error[$k]=$rulevalue['message'];
		   					break;
                                                        case 'limit':
		   						$err=$this->limitValidate($this->requestvalue[$k]);
		   						if($err)
		   						$error[$k]=$rulevalue['message'];
		   					break;
		   					case 'compare':
		   						$err=$this->CompareValue($this->requestvalue[$k]);
		   						if($err)
		   						$error[$k]=$rulevalue['message'];
		   					break;
		   					case 'unique':
		   						$err=$this->UniqueValidate($this->requestvalue[$k],$rulevalue['table'],$rulevalue['column']);
                                                                //echo '<pre>'; print_r($err);die('hello');
		   						if($err)
		   						$error[$k]=$rulevalue['message'];
		   					break;
		   					case 'date':
		   						$err=$this->dateValidate($this->requestvalue[$k]);
		   						if($err)
		   						$error[$k]=$rulevalue['message'];
		   						
		   					break;
		   					
		   					
		   				}
	   				}
	   					
	   			}else{
	   				$error[$k][]='Invalidate Rule';
	   			}
	   		}
	   		
	   	}
   			return $error;	
   	
   }
   
   
   
   Private function RuleType(){
   	return $ruletype=array('requried','email','string','number','alphanumaric','currency','removahtml','limit','url');
   	
   }
   
  
   
   
   private function errorCode(){   	
	   	$this->$errorCode[1]=array(	'message'=>'Invalid Argument','Description'=>'When no value pass to Validate');
	   	$this->$errorCode[2]=array(	'message'=>'Invalid Argument','Description'=>'When no value pass to Validate');
   }
   
   
   function CompareValue($value,$compareValue=''){
     		
   		if($value!=$compareValue){
   			return 'Password Is Not Match';
   		}
   	
   	
   }
   
   private function requriedValidate($value){  
  		if(empty($value) || $value==''){  			
  				return 'Please Fill This Field';
  		}
   	
   }
  private function stringValidate($value){
  		$pattern="/[^A-Za-z\s]+$/";
  		
  		if($value){
		  	if (!preg_match($pattern, $value)) {		
		  			
		  	}else{	 
		  		 		
		  		return 'Plese Fill Alphabet Only';	  			
		  	}	   
  		}	
   }
  private function emailValidate($value){
  	
  		$pattern="/^[^\@]+@.*\.[a-z]{2,6}$/i";
  		if($value){
		  	if (preg_match($pattern, $value)) {		
		  			
		  	}else{	 
		  			
		  		return 'Please Fill Validate Email ID';	  			
		  	}	  
  		} 	
   }
  private function numberValidate($value){
  		$pattern="/^[0-9]+$/";
  		if($value){
		  	if (preg_match($pattern, $value)) {		
		  			
		  	}else{	  		
		  		return 'Please Enter Number Only';	  			
		  	}
  		}	   	
   }
 //************************Amit Singh********************************************
   private function floatValidate($value){
  		$pattern="~^-?[0-9]+(\.[0-9]+)?$~xD";
  		if($value){
		  	if (preg_match($pattern, $value)) {		
		  			
		  	}else{	  		
		  		return 'Please Enter Float Only';	  			
		  	}
  		}	   	
   }
   
   private function limitValidate($value){
  		//echo'<script>alert("if cond");</script>';
  		if($value){
		  	if (strlen($value)==10) {		
		  		
		  	}else{	 
		  		return 'Please Enter 10 Digits';	  			
		  	}
  		}	   	
   }
 //************************ Amit********************************************
  private function alphanumaricValidate($value){
  		$pattern="/[^A-Za-z0-9\s]+$/";
  		if($value){
		  	if (!preg_match($pattern, $value)) {		
		  			
		  	}else{	  		
		  		return 'Plese Fill Alphabet Number Only';	  			
		  	}	
  		}   	
   }
   
   function removahtmlValidate($value){
   	if($value){   	
		   	if((strcmp( $value, strip_tags($value ) ) == 0)){
		   	
		   	}else{
		   			return 'Not Allow Special Tag';	  			
		   	}   	
   	}	
   	
   }
   
   private function dateValidate($value){
   	 	if($value){
	   	if(preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$value)){
	   			
		  	}else{	 
		  				
		  		return 'Please Insert Valid Date Format';	  			
		  	}
   	}	
   }
   
   function UniqueValidate($value,$table,$column){
       include_once 'plan.class.php';
       $t=new plan();
   	//global $wpdb;
   	$res=array();
   	if($value!=''){
	   $sql="SELECT COUNT($column) as c FROM $table where $column='$value'";
           //echo '<pre>';
	    //$res = $wpdb->get_row($sql);
           $res='';
           $res=$t->get_results($sql);//print_r($res);echo $res[0]->c;
	    if($res[0]->c!=0){
	    	//echo '<script>alert("in if conditaion");</script>';
	    	return 'User Name Already Exist';
	    }
   	}
   }
   
   
	
}

$objVali= new Validation();
?>