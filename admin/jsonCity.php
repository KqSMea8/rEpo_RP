<?php 
include_once("includes/settings.php");
$term = $_GET[ "term" ]; 


if(empty($_SERVER['HTTP_REFERER'])){
	echo 'Protected.';exit;
}

if(!empty($term)){
/*
$fetch="select p1.*,m.bill_option from inv_items as p1 left outer join inv_bill_of_material as m on m.item_id = p1.ItemID where 1 and p1.Status=1 and (p1.description like '%".$term."%' or p1.Sku like '%".$term."%' or p1.non_inventory like '%".$term."%' or p1.evaluationType like '%".$term."%' or p1.itemType like '%".$term."%' or p1.qty_on_hand like '%".$term."%' ) order by p1.ItemID Desc";*/
if(!empty($_GET[ "country_id" ])) { $qry = " and country_id='".$_GET['country_id']."' ";}else{ $qry ="";}
if(!empty($_GET[ "state_id" ])) { $qry .= " and state_id='".$_GET['state_id']."' ";}
   $fetch = "select * from ".$Config['DbMain'].".city where  LCASE(name) like '".strtolower(trim($term))."%'  ".$qry." order by name Asc"; 
$query=mysql_query($fetch) or mysql_error($fetch);
}

 
while ($row = mysql_fetch_array($query)) {
    
    
    $inv_items[]=array( "label" => $row['name'], "value" => trim(stripslashes($row['name'])),"id" => $row['city_id'] );
	

}


$result = array();
if(count($inv_items)> 0){
    foreach ($inv_items as $item_data) {
            $itemLabel = $item_data[ "label" ];

                    array_push( $result, $item_data );

    }
}else {
  $result= array( "error" => "No Record");
}

//print_r($result);
echo json_encode( $result );


?>
