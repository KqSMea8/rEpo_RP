<?php 
include_once("includes/settings.php");
$term = $_GET[ "term" ]; 

if(empty($_SERVER['HTTP_REFERER'])){
	echo 'Protected.';exit;
}

if(!empty($term)){

$warehouse_id = $_GET['WID'];
/*
$fetch="select p1.*,m.bill_option from inv_items as p1 left outer join inv_bill_of_material as m on m.item_id = p1.ItemID where 1 and p1.Status=1 and (p1.description like '%".$term."%' or p1.Sku like '%".$term."%' or p1.non_inventory like '%".$term."%' or p1.evaluationType like '%".$term."%' or p1.itemType like '%".$term."%' or p1.qty_on_hand like '%".$term."%' ) order by p1.ItemID Desc";*/
//$strAddQuery .= ' where 1 and s.binlocation_name like '%".$term."%'';
         $strAddQuery = (!empty($warehouse_id)) ? (" and s.warehouse_id='" . $warehouse_id . "'") : ("");
  $strSQLQuery = "select s.*,c.warehouse_name as wName,c.warehouse_code as wCode from w_binlocation s inner join w_warehouse c on s.warehouse_id=c.WID where  s.binlocation_name like '%".$term."%' " . $strAddQuery . " ";
        $query=mysql_query($strSQLQuery) or mysql_error($strSQLQuery);
 
while ($row = mysql_fetch_array($query)) {
    
    
    $inv_items[]=array( "label" => $row['binlocation_name'], "id" => trim($row['binid']) );
	

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
