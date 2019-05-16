<?php 
include_once("includes/settings.php");
$term = $_GET[ "term" ]; 

if(empty($_SERVER['HTTP_REFERER'])){
	echo 'Protected.';exit;
}

if(!empty($term)){

$fetch = "select f.BankAccountID,f.AccountName,f.AccountNumber from f_account f where f.Status='Yes' and LCASE(f.AccountName) like '".strtolower(trim($term))."%' order by f.AccountName Asc";
$query=mysql_query($fetch) or mysql_error($fetch);
 
while ($row = mysql_fetch_array($query)) {
    
    $AccountVal = ucwords($row['AccountName']).' ['.$row['AccountNumber'].']';

    $inv_items[]=array( "label" => $AccountVal, "value" => $AccountVal );
	

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
