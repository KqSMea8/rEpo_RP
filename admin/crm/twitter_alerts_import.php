<link rel="stylesheet" type="text/css" href="../../css/admin.css">
<link rel="stylesheet" type="text/css" href="../../css/admin-style.css">
<?php
	include_once("../includes/settings.php");
	require_once($Prefix."classes/socialCrm.class.php");

$ObjectSocial =  new socialcrm();

include "twitter_listening/reader.php";
$excel = new Spreadsheet_Excel_Reader();

$keys=array();
$alert_keys=$ObjectSocial->TwitterSearch("c_twitter_alerts",'alert_name');
foreach($alert_keys as $r)$keys[]=$r['alert_name'];

//print_r($keys);
if(isset($_POST['upload']))
{
	$flag-=0;
	$value1=array();
	$tmp_arr=array();
	$file = $_FILES['inputfile']['tmp_name'];
	$excel->read($file);
	$x=2;
	//echo $excel->sheets[0]['numRows'];die;
			while($x<=$excel->sheets[0]['numRows'])
			{
				
				$v['alert_key']= addslashes(isset($excel->sheets[0]['cells'][$x][1]) ? $excel->sheets[0]['cells'][$x][1] : '');
				$v['alert_disc']= addslashes(isset($excel->sheets[0]['cells'][$x][2]) ? $excel->sheets[0]['cells'][$x][2] : '');
				//echo '<br>'.$value['neg_key'];
				if(in_array($v['alert_key'],$keys) or $v['alert_key']==''){}
				else{//$value[]=array('alert_key'=>$v['alert_key'],'alert_disc'=>$v['alert_disc']);
				if(in_array($v['alert_key'],$tmp_arr)){}
				else{ $tmp_arr[]=$v['alert_key'];
				$value[]="('" .$v['alert_key']. "','" .$v['alert_disc']. "')";}
				}
				 
			  $x++;
			}
			//*******************************
			//echo '<pre>';	print_r($value);die; print_r(array_unique($value));
			/*foreach($value as $v)
			{
				if(in_array($v['alert_key'],$tmp_arr)){continue;}else {$tmp_arr[]=$v['alert_key'];$tmp[]="('" .$v['alert_key']. "','" .$v['alert_disc']. "')";}
			}*/
			//*******************************
			if(empty($value)){$error_msg='Empty file or Alerts already exist';}
			else{//print_r($value);die;
			$field="`alert_name`,`alert_disc`";
			$ObjectSocial->TwitterExlInsert("c_twitter_alerts",$field,array_unique($value));//TwitterExlInsert
	$_SESSION['mess_comp'] = "Alerts imported successfully";
	echo "<script>window.parent.$.fancybox.close();</script>";}
}
?>
<div style="margin-top:65px;">
<?php if(isset($error_msg))echo '<center style=" color:red;">'.$error_msg.'</center>';?>
<div id="content" style=" border:1px; border-style:solid; width: 86%; margin-left: 6%; height: 195px;border-color: rgb(221, 236, 236);">
<form method="post" enctype="multipart/form-data" action="" onSubmit="return ValidateForm(this);">
<center class="head">Import Alerts</center>
         <table  style=" margin-top:20px;" cellspacing="1" cellpadding="3" align="center" border="1" width="100%">
            <tr>
            	<th class="blackbold">Select Excel file:</th>
                <td><input class="inputbox" placeholder="" type="file" name="inputfile" title="Enter sample xls file" required/></td>
            </tr>
             <tr>
             	<th colspan="2"><input style=" margin-top:20px; padding:4px; background-color:rgb(176, 14, 14); color:#FFF;" title="upload xls file" type="submit" name="upload" value="Upload" /></th>
             </tr>
             <tr style=" margin-top:10px;"><td colspan="2" align="center"><a href="twitter_listening/samplealerts.xls" class="mail_dexcel" style="display: block; margin-top:20px;">Sample Excel Download</a></td></tr>
         </table>
</form>
</div></div>


