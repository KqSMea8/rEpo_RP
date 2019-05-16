<?php
ob_start();
class plan extends dbClass { 

  function getPlanelement($arg = array(),$element_id,$wherecon=array()) 
                {
        extract($arg);
        if(!empty($element_id)){
           $sql = "SELECT * FROM `plan_elements` where element_id='".$element_id."'";  
         return  $this->get_row($sql);
        }
       else {
       $where='WHERE 1=1 ';
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
           $sql = "SELECT * FROM `plan_package` id='".$userPackageId."'";  
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
            	$result=$this->getPlanelement(array(),$element_id);  
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

    
    function getPackageElement($userPackageId)
    {
        if(!empty($userPackageId))
                { 
               $sql = "SELECT * FROM `plan_package` where id='".$userPackageId."'";  
                }
              return  $this->get_results($sql); 
    }

    function getPlanPackage($compcod,$status)
    {
        if(!empty($compcod))
                { 
             $sql = "SELECT * FROM `payment_history` where company_code='" .$compcod ."' && status='".$status."'";
               //$sql = "SELECT * FROM `plan_package` where id='".$userPackageId."'";  
                }
              return  $this->get_results($sql); 
    }
}
?>
