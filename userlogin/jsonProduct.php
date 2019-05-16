<?php 
include_once("includes/settings.php");

$term=$CustomerID='';
if(!empty($_GET[ "term" ])){
	$term = $_GET[ "term" ]; 
}

if(!empty($_SESSION['UserData']['Cid']))  $CustomerID=$_SESSION['UserData']['Cid'];

if(empty($_SERVER['HTTP_REFERER'])){
	echo 'Protected.';exit;
}

if(!empty($term)){
$strAddQuery=$custJoin='';
/*
$fetch="select p1.*,m.bill_option from inv_items as p1 left outer join inv_bill_of_material as m on m.item_id = p1.ItemID where 1 and p1.Status=1 and (p1.description like '%".$term."%' or p1.Sku like '%".$term."%' or p1.non_inventory like '%".$term."%' or p1.evaluationType like '%".$term."%' or p1.itemType like '%".$term."%' or p1.qty_on_hand like '%".$term."%' ) order by p1.ItemID Desc";*/
if(isset($_SESSION['is_exclusive']) && $_SESSION['is_exclusive']=='No')
		$strAddQuery .= (!empty($CustomerID)) ? (" and (c2.CustomerID='" . $CustomerID . "' or c2.CustomerID is null) a") : ("");
		else $strAddQuery .= (!empty($CustomerID)) ? (" and c2.CustomerID='" . $CustomerID . "' ") : ("");
	if(!empty($CustomerID)){
			$custJoin=" left join inv_customer_items c2 on c2.ItemID=p1.ItemID ";
		}
$fetch = "select Sku from inv_items as p1  ".$custJoin." where Status='1' and LCASE(Sku) like '".strtolower(trim($term))."%' ".$strAddQuery." order by Sku Asc";
$query=mysql_query($fetch) or mysql_error($fetch);
 
while ($row = mysql_fetch_array($query)) {
    
    
    $inv_items[]=array( "label" => $row['Sku'], "value" => trim($row['Sku']) );
	

}


$result = array();
if(!empty($inv_items)){
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
