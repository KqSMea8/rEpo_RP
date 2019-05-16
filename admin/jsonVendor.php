<?php 
include_once("includes/settings.php");
$term = $_GET[ "term" ]; 

if(empty($_SERVER['HTTP_REFERER'])){
	echo 'Protected.';exit;
}

if(!empty($term)){
 
$fetch = "select SuppCode,CompanyName, IF(SuppType = 'Individual' and UserName!='', UserName, CompanyName) as VendorName from p_supplier  where Status='1' and (SuppCode like '%".$term."%' or CompanyName like '%".$term."%' or UserName like '%".$term."%') order by CompanyName Asc";

 


$query=mysql_query($fetch) or mysql_error($fetch);
 
while ($row = mysql_fetch_array($query)) {
    $SuppCode = stripslashes($row['SuppCode']);
    //$CustomerName = str_replace("-"," ",$CustomerName);

    $inv_items[]=array( "label" => $SuppCode."-".$row['VendorName'], "value" => $SuppCode  );
	

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
