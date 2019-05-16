<?php

/* Developer Name: Niraj Gupta
 * Date : 19-06-15
 * 
 */

class common extends dbClass {
    /*
     * Name: headermenu
     * Description: For Superadmin  header menu
     * @param: 
     * @return: 
     */

    function headermenu($arr = array()) {
        global $Config;
        $strAddQuery = '';
        extract($arr);       
        if(!empty($AdminID))
        {
        $strAddQuery = "SELECT * FROM admin_modules WHERE Status=1  and Parent=0  Order by OrderBy  asc";
        return $this->get_results($strAddQuery);
        }
        return false;
    }
    
    /*
     * Name: GetHdMenuAdmin
     * Description: For Superadmin  header menu
     * @param: 
     * @return: 
     */   
    
    function GetHdMenuAdmin($Parent=0)
	 {
	$strAddQuery ="SELECT M.* FROM admin_modules as M  WHERE M.Parent!=2 and  Parent='".$Parent."' Order by OrderBy  asc"; 
         return $this->get_results($strAddQuery);
	 
	 }

}

?>
