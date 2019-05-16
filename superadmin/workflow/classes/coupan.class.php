<?php

/* Developer Name: Niraj Gupta
 * Date : 19-06-15
 * 
 * Description: For plane class
 * @param: 
 * @return: 
 */
ob_start();
class coupan extends dbClass { /*
 * Name: Coupan
 * Description: For Superadmin  plan elements
 * @param: 
 * @return: 
 */

  function getPlanelement($arg = array(),$element_id) 
                {
        extract($arg);
        if(isset($element_id)){
           $sql = "SELECT * FROM `flow_coupan` where id='".$element_id."'";  
         return  $this->get_row($sql);
        }
       else {
		       $sql = "SELECT * FROM `flow_coupan`";
		       return $this->get_results($sql);
           }
    
    }
 public function  getPlanpackageElement($userPackageId){
         if(!empty($userPackageId))
            { 
           $sql = "SELECT * FROM `flow_coupan` where package_id='".$userPackageId."'";  
            }
          return  $this->get_results($sql); 
	//print_r($sql);
    }
function AddElement($arryDetails)
		{  
                   $result= $this->insert('flow_coupan',$arryDetails);
			
                    $elementID = $this->insert_id;
                    return $elementID;
		}


function UpdateElement($arryDetails,$element_id)
                {   
			extract($arryDetails);
			if(!empty($element_id)){
			$this->update('flow_coupan',$arryDetails,array('id'=>$element_id));
			}
			return 1;
		}

 function DeleteElement($element_id) {  		    
            if(!empty($element_id))
            { 
            	$result=$this->getPlanelement(array(),$element_id);  
                $sqlpckgelement = "SELECT ele_key FROM `flow_coupan` WHERE ele_key='$result->element_slug'";
                $arryDetails= $this->get_results($sqlpckgelement);             
                if(!empty($arryDetails)){
                	return false;
            		 }
            		 else{ 
            			 $this->delete('flow_coupan',array('id'=>$element_id));
            			return true;
            		 }
            }
            
             return false;
    }
    
 function changeElementStatus($arryDetails,$element_id)
 {   

                        if(!empty($arryDetails)){
					if($arryDetails['status']=='Active')
						$arryDetails['status']='Inactive';
					else
						$arryDetails['status']='Active';
					$this->update('flow_coupan',$arryDetails,array('id'=>$element_id));					
                                 }
			return true;

		}
}
?>
