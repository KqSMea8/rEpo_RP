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
        
	

        if (!empty($pckg_id)) {
           $sql = "SELECT * FROM `plan_package` where id='" . $pckg_id . "'";
            return $this->get_row($sql);
        } else {
        	extract($arg);
            $limitval='';
           
            if(isset($arg['limit']) AND isset($arg['offset'])){
		 $offset=$arg['offset'];
            	$limit=$arg['limit'];
                $limitval="LIMIT $offset , $limit";
	    }
            $where ="where deleted=0";
          $sql = "SELECT * , (Select Count(*) FROM `plan_package`  $where) as c FROM `plan_package` $where $limitval";
           
            
            //$sql = "SELECT * FROM `plan_package`";
            return $this->get_results($sql);
        }
    }

   
    
    function AddPackage($arryDetails) {
        extract($arryDetails);
        $result = $this->insert('plan_package', $arryDetails['packagedata']);
        $pckgID = $this->insert_id;        
        return $pckgID;
    }

    
    function UpdatePackage($arryDetails, $pckg_id) {
    	// echo '<pre>';
       //print_r($arryDetails); die;
        extract($arryDetails);
       
        $result = $this->update('plan_package', $arryDetails['packagedata'], array('id' => $pckg_id));
       
        return 1;
    }
     
    function DeletePackage($pckg_id) {
        //$strSQLQuery = "delete from plan_elements where element_id='" .$element_id . "'";
        //$this->delete('plan_package', array('id' => $pckg_id));
        $arryDetails['deleted'] = 1;
        $this->update('plan_package', $arryDetails, array('id' => $pckg_id));
        return 1;
    }

    
    function changePackageStatus($arryDetails, $pckg_id) {

        if (!empty($arryDetails)) {
            if ($arryDetails['status'] == 1)
                $arryDetails['status'] = 0;
            else
                $arryDetails['status'] = 1;
            $this->update('plan_package', $arryDetails, array('id' => $pckg_id));
        }
        return true;
    }

}

?>

