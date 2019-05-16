<?
$Prefix = "../../";
require_once("../includes/settings.php");

if(empty($_SERVER['HTTP_REFERER'])){
	echo 'Protected.';exit;
}
if(empty($_SESSION['CmpID'])){
	echo SESSION_EXPIRED;exit;
} 
(empty($_POST['selectId']))?($_POST['selectId']=""):("");

 
/* * ******Connecting to main database******** */
$Config['DbName'] = $Config['DbMain'];
$objConfig->dbName = $Config['DbName'];
$objConfig->connect();
/* * **************************************** */

if(!empty($_POST["country_id"])){
    //Fetch all state data
$objRegion = new region();
    $arryState = $objRegion->getStateByCountry($_POST['country_id']);
		 	
    //Count total number of rows
   $rowCount = sizeof($arryState);
    
    //State option list
    if($rowCount > 0){
        echo '<option value="">Select state</option>';
       for($i=0;$i<sizeof($arryState);$i++) {
				
					$Selected = ($_POST['selectId'] == $arryState[$i]['state_id'])?(" Selected"):("");

					
					echo  '<option value="'.$arryState[$i]['state_id'].'" '.$Selected.'>'.stripslashes($arryState[$i]['name']).'</option>';
					
				}
				 echo '<option value="0">Other</option>';
    }else{
        echo '<option value="">State not available</option>';
    }
}else if(!empty($_POST["state_id"]) || $_POST['countryID']==2 ){
$objRegion = new region();
    //Fetch all city data
    $arryCity = $objRegion->getCityList($_POST["state_id"], $_POST['countryID']);
    
    //Count total number of rows
    $rowCount = sizeof($arryCity);
    
    //City option list
    if($rowCount > 0){
 echo '<option value="">Select city</option>';
for($i=0;$i<sizeof($arryCity);$i++) {
				
					$Selected = ($_POST['selectId'] == $arryCity[$i]['city_id'])?(" Selected"):("");
					
					echo  '<option value="'.$arryCity[$i]['city_id'].'" '.$Selected.'>'.htmlentities($arryCity[$i]['name'], ENT_IGNORE).'</option>';
					
				}




       
       
    }else{
        echo '<option value="">City not available</option>';
    }
}


















 

?>
