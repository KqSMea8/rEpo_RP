<?php 
include_once("includes/settings.php");
  $term = $_GET[ "term" ];

if(empty($_SERVER['HTTP_REFERER'])){
	//echo 'Protected.';exit;
}

if(!empty($term)){

   $fetch = "select InvoiceID from s_order  where Module='Invoice' and InvoiceID != '' and ReturnID = '' and InvoiceID like '%".$term."%'   order by InvoiceID Asc";


$query=mysql_query($fetch) or mysql_error($fetch);
 
 
 
while ($row = mysql_fetch_array($query)) {
    $InvoiceID = stripslashes(trim($row['InvoiceID']));
   
    $inv_items[]=array( "label" => $InvoiceID, "value" => $InvoiceID);
	 

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
