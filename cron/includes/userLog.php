<? 
$arryData['DeleteBefore'] = date('Y-m-d',strtotime("-1 year"));
$arryData['KeepNumRecord'] = 0;
$arryUserLog = $objUser->RemoveUserLog($arryData);die;

?>
