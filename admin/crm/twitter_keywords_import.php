<link rel="stylesheet" type="text/css" href="../../css/admin.css">
<link rel="stylesheet" type="text/css" href="../../css/admin-style.css">
<?php
	include_once("../includes/settings.php");
	require_once($Prefix."classes/socialCrm.class.php");

$ObjectSocial =  new socialcrm();
//echo 'helloo';
//echo "its running";
include "twitter_listening/reader.php";
$excel = new Spreadsheet_Excel_Reader();

$keys=array();
$bad_keys=$ObjectSocial->TwitterSearch("c_twitter_badkeys",'bad_key');
foreach($bad_keys as $r)$keys[]=$r['bad_key'];

//print_r($keys);
if(isset($_POST['upload']))
{
	$flag-=0;
	$value1=array();
	//echo 'heloo';
	$file = $_FILES['inputfile']['tmp_name'];
	$excel->read($file);
	$x=2;
	//echo $excel->sheets[0]['numRows'];die;
			while($x<=$excel->sheets[0]['numRows'])
			{
				
				$bad_key= addslashes(isset($excel->sheets[0]['cells'][$x][1]) ? $excel->sheets[0]['cells'][$x][1] : '');
				//echo '<br>'.$value['neg_key'];
				if(in_array($bad_key,$keys) or $bad_key==''){}
				else{ $value[]="('".$bad_key."')";
				//if($value['bad_key']=='')$flag=1;
				//$ObjectSocial->TwitterInsert("c_twitter_badkeys",$value);
				}
				//$job = isset($excel->sheets[0]['cells'][$x][2]) ? $excel->sheets[0]['cells'][$x][2] : '';
				//$email = isset($excel->sheets[0]['cells'][$x][3]) ? $excel->sheets[0]['cells'][$x][3] : '';
				
				// Save details
				//$sql_insert="INSERT INTO csv (id,name,job,email) VALUES ('','$name','$job','$email')";
				//$sql_insert="INSERT INTO csv (keywords) VALUES ('','$name')";
				//$result_insert = mysql_query($sql_insert) or die(mysql_error()); 
				 
			  $x++;
			}
			//print_r($value);die;
			if(empty($value)){$error_msg='Empty file or Keywords already exist';}
			else{//print_r($value);die;
			$field="`bad_key`";
			$ObjectSocial->TwitterExlInsert("c_twitter_badkeys",$field,array_unique($value));//TwitterExlInsert
	$_SESSION['mess_comp'] = "Keywords imported successfully ";
	echo "<script>window.parent.$.fancybox.close();</script>";}
}
?>
<div style="margin-top:65px;">
<?php if(isset($error_msg))echo '<center style=" color:red;">'.$error_msg.'</center>';?>
<div id="content" style=" border:1px; border-style:solid; width: 86%; margin-left: 6%; height: 195px;border-color: rgb(221, 236, 236);">
<form method="post" enctype="multipart/form-data" action="" onSubmit="return ValidateForm(this);">
<center class="head">Import Keywords</center>
         <table  style=" margin-top:20px;" cellspacing="1" cellpadding="3" align="center" border="1" width="100%">
            <tr>
            	<th class="blackbold">Select Excel file:</th>
                <td><input class="inputbox" placeholder="" type="file" name="inputfile" title="Enter sample xls file" required/></td>
            </tr>
             <tr>
             	<th colspan="2"><input style=" margin-top:20px; padding:4px; background-color:rgb(176, 14, 14); color:#FFF;" title="upload xls file" type="submit" name="upload" value="Upload" /></th>
             </tr>
             <tr style=" margin-top:10px;"><td colspan="2" align="center"><a href="twitter_listening/sample_negative_keys.xls" class="mail_dexcel" style="display: block; margin-top:20px;">Sample Excel Download</a></td></tr>
         </table>
</form>
</div></div>


