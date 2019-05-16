<?php 
include_once("includes/settings.php");
$term = $_GET[ "term" ]; 

if(empty($_SERVER['HTTP_REFERER'])){
	echo 'Protected.';exit;
}

if(!empty($term)){
 
$fetch = "select p.SuppCode,p.CompanyName, IF(p.SuppType = 'Individual' and p.UserName!='', p.UserName, CompanyName) as VendorName from p_supplier p inner join h_commission c on (c.SuppID=p.SuppID and c.SuppID>0 and c.CommType='Spiff' and c.SpiffOn='1')  where p.Status='1' and (p.SuppCode like '%".$term."%' or p.CompanyName like '%".$term."%' or p.UserName like '%".$term."%') order by VendorName Asc";

 


$query=mysql_query($fetch) or mysql_error($fetch);
 
while ($row = mysql_fetch_array($query)) {
    $VendorName = stripslashes(trim($row['VendorName']));
    $VendorName = str_replace("-"," ",$VendorName);

    $SuppCode = stripslashes($row['SuppCode']);
    //$CustomerName = str_replace("-"," ",$CustomerName);

    $inv_items[]=array( "label" => $row['VendorName']."-".$SuppCode, "value" => $row['VendorName']."-".$SuppCode  );
	

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
