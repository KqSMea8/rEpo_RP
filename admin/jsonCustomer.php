<?php 
include_once("includes/settings.php");
$term = $_GET[ "term" ]; 

if(empty($_SERVER['HTTP_REFERER'])){
	echo 'Protected.';exit;
}

if(!empty($term)){
 $strAddQuery = '';

$strAddQuery .= ($_SESSION['vAllRecord']!=1)?(" and (c.AdminType='".$_SESSION['AdminType']."' and c.AdminID='".$_SESSION['AdminID']."') or c.SalesID='".$_SESSION['AdminID']."' "):(""); 

$fetch = "select c.CustCode,IF(c.CustomerType = 'Company' and c.Company!='', c.Company, c.FullName) as CustomerName, customerHold from s_customers c where c.Status='Yes' ".$strAddQuery." and 
CASE WHEN c.CustomerType = 'Company' and c.Company!='' THEN  LCASE(c.Company) like '".strtolower(trim($term))."%'  WHEN c.FullName!='' THEN LCASE(c.FullName) like '".strtolower(trim($term))."%'  ELSE 1 END = 1 having CustomerName!=''  order by CustomerName Asc";

 


$query=mysql_query($fetch) or mysql_error($fetch);
 
while ($row = mysql_fetch_array($query)) {
    $CustomerName = stripslashes(trim($row['CustomerName']));
    $CustomerName = str_replace("-"," ",$CustomerName);
    $inv_items[]=array( "label" => $CustomerName."-".$row['CustCode'], "value" => $CustomerName."-".$row['CustCode'],"hold"=>$row['customerHold'] );
	//

}


$result = array();
if(count($inv_items)> 0){
    foreach ($inv_items as $item_data) {
            $itemLabel = $item_data[ "label" ];

                    array_push( $result, $item_data );

    }
}else {
  // $result= array( "label" => "No Record");
}

//print_r($result);
echo json_encode( $result );
}

?>
