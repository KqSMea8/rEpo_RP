<?php

/* Developer Name: Niraj Gupta
 * Date : 19-06-15
 * 
 * Description: For plan class
 * @param: 
 * @return: 
 */

class package extends dbClass { 
/*
 * Name: plan
 * Description: For Superadmin  plan elements
 * @param: 
 * @return: 
 */

    function getPackage($arg = array(), $pckg_id) {
        extract($arg);
        if (!empty($pckg_id)) {
            $sql = "SELECT * FROM `pos_plan_package` where pckg_id='" . $pckg_id . "'";
            return $this->get_row($sql);
        } else {
            $sql = "SELECT * FROM `pos_plan_package`";
            return $this->get_results($sql);
        }
    }

     function getPackageelement($arg = array(), $pckg_id) {
           extract($arg);
            $sql = "SELECT * FROM `pos_plan_package_element` where package_id='" . $pckg_id . "'";
            return $this->get_results($sql);
       
    }
    
    function getPlanelement($arg = array()) {
        extract($arg);
        $sql = "SELECT * FROM `pos_plan_elements`";
        return $this->get_results($sql);
    }

    
    function AddPackage($arryDetails) {
        extract($arryDetails);
        $result = $this->insert('pos_plan_package', $arryDetails['packagedata']);
        $pckgID = $this->insert_id;
        if (!empty($arryDetails['elementdata'])) {
            foreach ($arryDetails['elementdata'] as $keyelemnt => $valueelement) {
                if ($keyelemnt == 'checkbox')
                    $valueelement = implode(',', $valueelement);
                $tempdata = array('package_id' => $pckgID, 'ele_key' => $keyelemnt, 'ele_value' => strip_tags($valueelement));
                $this->insert('pos_plan_package_element', $tempdata);
            }
        }
        return $pckgID;
    }

    
    function UpdatePackage($arryDetails, $pckg_id) {
    	// echo '<pre>';
       // print_r($arryDetails); die;
        extract($arryDetails);
       
        $result = $this->update('pos_plan_package', $arryDetails['packagedata'], array('pckg_id' => $pckg_id));
        if (!empty($pckg_id)) {
            $elementresult=  $this->getPackageelement($arryDetails['elementdata'],$pckg_id);
            $dbarray=array();
            foreach ($elementresult as $keyelemnt => $valueelement) {
            	if(array_key_exists($valueelement->ele_key,$arryDetails['elementdata'])){
            		 $value=$arryDetails['elementdata'][$valueelement->ele_key];
            		 if(is_array($value)){
            		 	$value=implode(',',$value);
            		 }
            		
            		 $this->update('pos_plan_package_element', array('ele_value'=>strip_tags($value)), array('package_id' => $pckg_id,'ele_key'=>$valueelement->ele_key));
            	}
            	$dbarray[$valueelement->ele_key]=$valueelement->ele_value   ;         	
            }
           
           
        }
        return 1;
    }
     
    function DeletePackage($pckg_id) {
        //$strSQLQuery = "delete from plan_elements where element_id='" .$element_id . "'";
        $this->delete('pos_plan_package', array('pckg_id' => $pckg_id));
        if(!empty($pckg_id)){
        $this->delete('pos_plan_package_element', array('package_id' => $pckg_id));
        
        }
        return 1;
    }

    
    function changePackageStatus($arryDetails, $pckg_id) {

        if (!empty($arryDetails)) {
            if ($arryDetails['status'] == 1)
                $arryDetails['status'] = 0;
            else
                $arryDetails['status'] = 1;
            $this->update('pos_plan_package', $arryDetails, array('pckg_id' => $pckg_id));
        }
        return true;
    }

}

?>

