<?php
class Validation{
	public $error = array();
	public $errorCode = array();
	private $ruletype = array();
	public $erro = array();
	

	function Validation() {
		## do something here
   }
   
   function NewValidate($arg){
   	global $wpdb;
   	$error=array();
   	$err='';
	   	if(!empty($arg)){
	   		foreach($arg as $k=>$result){	   			
	   			if(!empty($result['rule']) AND is_array($result['rule'])){
	   				foreach($result['rule'] as $rulevalue){
	   					$result['value']=trim($result['value']);
	   					switch($rulevalue){
		   					case 'requried':
		   						$err=$this->requriedValidate($result);
		   						if($err)
		   						$error[$k][]=$err;
		   					break;
		   					case 'email':
		   						$err=$this->emailValidate($result);
		   						if($err)
		   						$error[$k][]=$err;
		   					break;
		   					case 'string':
		   						$err=$this->stringValidate($result);
		   						if($err)
		   						$error[$k][]=$err;
		   					break;
		   					case 'number':
		   						$err=$this->numberValidate($result);
		   						if($err)
		   						$error[$k][]=$err;
		   					break;
		   					case 'phone':
		   						$err=$this->phone($result);
		   						if($err)
		   						$error[$k]['phone']=$err;
		   					break;
		   					case 'alphanumaric':
		   						$err=$this->alphanumaricValidate($result);
		   						if($err)
		   						$error[$k][]=$err;
		   					break;
		   					case 'currency':
		   						$err=$this->currencyValidate($result);
		   						if($err)
		   						$error[$k][]=$err;
		   					break;
		   					case 'removahtml':
		   						$err=$this->removahtmlValidate($result);
		   						if($err)
		   						$error[$k][]=$err;
		   					break;
		   					case 'url':
		   						$err=$this->urlValidate($result);
		   						if($err)
		   						$error[$k][]=$err;
		   					break;
		   					case 'limit':
		   						$err=$this->limitValidate($result['value']);
		   						if($err)
		   						$error[$k][]=$err;
		   					break;
		   					case 'compare':
		   						$err=$this->CompareValue($result['value'],$result['compareValue'],$result);
		   						if($err)
		   						$error[$k][]=$err;
		   					break;
		   					
		   					case 'date':
		   						$err=$this->dateValidate($result);
		   						if($err)
		   						$error[$k][]=$err;
		   						
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
   
   private function RuleType(){
   		return $ruletype=array('requried','email','string','number','alphanumaric','currency','removahtml','limit','url','phone');
   }
  
   private function errorCode(){   	
	   	$this->$errorCode[1]=array(	'message'=>'Invalid Argument','Description'=>'When no value pass to Validate');
	   	$this->$errorCode[2]=array(	'message'=>'Invalid Argument','Description'=>'When no value pass to Validate');
   }
   
   
   function CompareValue($value,$compareValue='',$result=array()){		
   		if($value!=$compareValue){
   			return $result['message'];
   		}
   }
   
   private function requriedValidate($value){
  		if(empty($value['value']) || $value['value']==''){  			
  				return $value['message'];
  		}
   }
   
   private function stringValidate($value){
  		$pattern="/[^A-Za-z\s]+$/";
  		
  		if(!empty($value['value'])){
		  	if (!preg_match($pattern, $value['value'])) {		
		  			
		  	}else{	 
		  		 		
		  		return $value['message'];	  			
		  	}	   
  		}	
   }
   
   private function emailValidate($value){
  		$pattern="/^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+.([a-zA-Z]{2,4})$/";
  		if(!empty($value['value'])){
		  	if (preg_match($pattern, $value['value'])) {		
		  			
		  	}else{	 
		  			
		  		return $value['message'];	  			
		  	}	  
  		} 	
   }
  private function numberValidate($value){
  		$pattern="/^[0-9]+$/";
  		if(!empty($value['value'])){
		  	if (preg_match($pattern, $value['value'])) {		
		  			
		  	}else{	  		
		  		return $value['message'];	  			
		  	}
  		}	   	
   }
  private function alphanumaricValidate($value){
  		$pattern="/[^A-Za-z0-9\s]+$/";
  		if(!empty($value['value'])){
		  	if (!preg_match($pattern, $value['value'])) {		
		  			
		  	}else{	  		
		  		return $value['message'];	  			
		  	}	
  		}   	
   }
   
   function removahtmlValidate($value){
		if(!empty($value['value'])){
			if(preg_match("/<(.*)>.*<$1>/", $value['value'])){	
			}else{	 		
				return $value['message'];	  			
			}
		}	
   }
   
   private function dateValidate($value){
   	 	if($value['value']){
			if(preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/",$value['value']) && ($value['value']!='01/01/1970')){
			}else{	 		
				return $value['message'];	  			
			}
   		}
   }
   
   function UniqueValidate($value,$table,$column){
		global $wpdb;
		$res=array();
		if($value!=''){
			$sql="SELECT COUNT($column) as c FROM $table where $column='$value'";
			$res = $wpdb->get_row($sql);	    
			if($res->c!=0){
				return $value['message'];
			}
		}
   }
   
	private function phone($value) {
		// includes all NANPA members.
		// see http://en.wikipedia.org/wiki/North_American_Numbering_Plan#List_of_NANPA_countries_and_territories
		$regex = '/^(?:(?:\+?1\s*(?:[.-]\s*)?)?';

		// Area code 555, X11 is not allowed.
		$areaCode = '(?![2-9]11)(?!555)([2-9][0-8][0-9])';
		$regex .= '(?:\(\s*' . $areaCode . '\s*\)|' . $areaCode . ')';
		$regex .= '\s*(?:[.-]\s*)?)';

		// Exchange and 555-XXXX numbers
		$regex .= '(?!(555(?:\s*(?:[.\-\s]\s*))(01([0-9][0-9])|1212)))';
		$regex .= '(?!(555(01([0-9][0-9])|1212)))';
		$regex .= '([2-9]1[02-9]|[2-9]1[02-9]|[2-9][02-9]1|[2-9][02-9]{2})\s*(?:[.-]\s*)';

		// Local number and extension
		$regex .= '?([0-9]{4})';
		$regex .= '(?:\s*(?:#|x\.?|ext\.?|extension)\s*(\d+))?$/';

		## general validation for telephone number.
		$regex = '/(?:\(?\+\d{2}\)?\s*)?\d+(?:[ -]*\d+)*$$/';

		if(empty($value['value']) || preg_match($regex, $value['value'])){	
		}else{	 		
			return $value['message'];			
		}
	} 
   
}

$objVali= new Validation();
?>
