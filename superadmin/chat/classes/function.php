<?php	

	 function CleanPost() {  
        foreach($_POST as $key => $values){        	
         	 if(!is_array($values)){
	                $temp = mysql_real_escape_string(strip_tags(trim($values)));
                 	$_POST[$key] = str_replace('\r\n',"\n", $temp);		
	            }        	
        } 
              
              
    }
    
    function CleanRequest() {  
             
		$avoidCleanRequest = array("description","Comment",'TemplateContent','mailcontent','Address');
        foreach($_REQUEST as $key => $values){
        	if(!in_array($key, $avoidCleanRequest)){
	            if(!is_array($values)){
	               $temp = mysql_real_escape_string(strip_tags($values));
                 	$_REQUEST[$key] = str_replace('\r\n',"\n", $temp);		
	            }
        	}
        } 
              
              
    }

    function CleanGet() { 
        foreach($_GET as $key => $values){
        		$_GET[$key] = mysql_real_escape_string(strip_tags($values)); 
        }
    }

    function CleanPostID() { 
        foreach($_POST as $key => $values){
            if(is_array($values)){
                unset($_POST[$key]);
                foreach($values as $key2 => $values2){
                    $_POST[$key][] = (int)$values2;
                }
            }else if(is_string($values)){
                $_POST[$key] = (int)$values;
            }
        } 
    }

	function clean($string) {
	   $string = str_replace(' ', '-', $string);
	   $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);
	
	   return preg_replace('/-+/', '-', $string);
	}

	function htmlDecodes($sting){
    	foreach($_POST as $key => $values){
    		$key = htmlentities($key);
    		$_POST[$key] = htmlentities($values);
    	}
    }




	function escapeSpecial($Heading){		
		$Heading = str_replace(" ","_",$Heading);
		$Heading = preg_replace('/[.,~:>-]/', '_', $Heading);
		return $Heading;
	}




?>
