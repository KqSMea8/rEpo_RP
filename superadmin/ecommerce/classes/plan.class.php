<?php

 
ob_start();
class plan extends dbClass { /*
 * Name: plan
 * Description: For Superadmin  plan elements
 * @param: 
 * @return: 
 */

  function getPlanelement($arg = array(),$element_id,$wherecon=array()) 
                {
       
        if(!empty($element_id)){
           $sql = "SELECT * FROM `plan_elements` where element_id='".$element_id."'";  
         return  $this->get_row($sql);
        }
       else {
		 if(!empty($arg)) extract($arg);

       $where='WHERE 1 ';
       if(!empty($wherecon['status'])){
          $where .="AND status='".$wherecon['status']."'";
       
       }
		       $sql = "SELECT * FROM `plan_elements` $where";
		       return $this->get_results($sql);
           }
    
    }
 public function  getPlanpackageElement($userPackageId){
         if(!empty($userPackageId))
            { 
           $sql = "SELECT * FROM `plan_package_element` where package_id='".$userPackageId."'";  
            }
          return  $this->get_results($sql); 
    }
function AddElement($arryDetails)
		{  
                   $result= $this->insert('plan_elements',$arryDetails);
                    $elementID = $this->insert_id;
                    return $elementID;
		}


function UpdateElement($arryDetails,$element_id)
                {   
			extract($arryDetails);
			if(!empty($element_id)){
			$this->update('plan_elements',$arryDetails,array('element_id'=>$element_id));
			}
			return 1;
		}

 function DeleteElement($element_id) {  		    
            if(!empty($element_id))
            { 
            	$result=$this->getPlanelement(array(),$element_id,'');  
                $sqlpckgelement = "SELECT ele_key FROM `plan_package_element` WHERE ele_key='$result->element_slug'";
                $arryDetails= $this->get_results($sqlpckgelement);             
                if(!empty($arryDetails)){
                	return false;
            		 }
            		 else{ 
            			 $this->delete('plan_elements',array('element_id'=>$element_id));
            			return true;
            		 }
            }
            
             return false;
    }
    
    function changeElementStatus($arryDetails,$element_id)
    {   

        if(!empty($arryDetails)){
                        if($arryDetails['status']==1)
                                $arryDetails['status']=0;
                        else
                                $arryDetails['status']=1;
                        $this->update('plan_elements',$arryDetails,array('element_id'=>$element_id));					
                 }
        return true;

   }

    /****************************Amit Singh*******************************/
    // Get plan package element and  serilised it by package id and inner join to get element name(plan eliment) by(plan_package_element- ele_key) as defined in mail of ravi sir
    function getPackageElement($userPackageId)
    {
        if(!empty($userPackageId))
                { 
               $sql = "SELECT * FROM `plan_package_element` inner JOIN plan_elements ON plan_elements.element_slug=plan_package_element.ele_key where package_id='".$userPackageId."'";  
                }
              return  $this->get_results($sql); 
    }

    function getPlanPackage($userPackageId)
    {
        if(!empty($userPackageId))
                { 
               $sql = "SELECT * FROM `plan_package` where pckg_id='".$userPackageId."'";  
                }
              return  $this->get_results($sql); 
    }
}
?>
