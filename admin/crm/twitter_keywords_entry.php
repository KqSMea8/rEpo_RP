<link rel="stylesheet" type="text/css" href="../../css/admin.css">
<link rel="stylesheet" type="text/css" href="../../css/admin-style.css">
<?php
	include_once("../includes/settings.php");
	require_once($Prefix."classes/socialCrm.class.php");
	ini_set('display_errors',1);
$ObjectSocial =  new socialcrm();

$keys=array();
$bad_keys=$ObjectSocial->TwitterSearch("c_twitter_badkeys",'bad_key');
foreach($bad_keys as $r)$keys[]=$r['bad_key'];


if(isset($_GET['bedi_id']))
{
	$bedi_id=$_GET['bedi_id'];
	$wr="`id`='$bedi_id'";
	$edit_row = $ObjectSocial->TwitterSearch("c_twitter_badkeys","*",$wr);
	
}
if(isset($_POST['Up_badB']))
{
	echo $hid=$_REQUEST['hid'];
	echo $bad_key=addslashes(trim($_REQUEST['bad_key']));
	if(in_array($bad_key,$keys) or $bad_key==''){$error_msg='Negative keyword already exist';}
	else{
	$st="`bad_key`='$bad_key'";
	$ObjectSocial->TwitterUpdate("c_twitter_badkeys",$st,"`id`='$hid'");
	
	$_SESSION['mess_comp']='Keyword updated successfully';
	echo "<script>window.parent.$.fancybox.close();</script>";
	}
	
}
$value=array();
if(isset($_POST['bad_keyB']))
{
	$value['bad_key']=trim(addslashes($_REQUEST['bad_key']));
	if(in_array($value['bad_key'],$keys) or $value['bad_key']=='')$error_msg='Negative keyword already exist';
	else{
	$ObjectSocial->TwitterInsert("c_twitter_badkeys",$value);
	$_SESSION['mess_comp'] = "Keyword added successfully";
	echo "<script>window.parent.$.fancybox.close();</script>";
	}
}

?>
<div style="margin-top:65px;">
<?php if(isset($error_msg))echo '<center style=" color:red;">'.$error_msg.'</center>';?>
<div id="content" style=" border:1px; border-style:solid; width: 86%; margin-left: 6%; height: 164px;border-color: rgb(221, 236, 236);">
 
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<!--style=" font-weight: bold; font-size: 14px;"-->
<center class="head"><?php if(isset($_GET['bedi_id']))echo "Update Keyword"; else echo "Create Keyword";?></center>
         <table  style=" margin-top:20px;" cellspacing="1" cellpadding="3" align="center" border="1" width="100%">
            <tr><th class="blackbold">Negative Keyword</th><td><input class="inputbox" placeholder="" type="text" name="bad_key"
            value="<?php if(isset($_GET['bedi_id']) && isset($edit_row))echo stripslashes($edit_row[0]['bad_key']); ?>" title="Enter negative key" required/></td></tr>
            <input type="hidden" name="hid" value="<?php if(isset($_GET['bedi_id']))echo $edit_row[0]['id']; ?>"/>
             <?php if(isset($_GET['bedi_id'])){?>
             <tr><th colspan="2"><input style=" margin-top:20px; padding:4px; background-color:rgb(176, 14, 14); color:#FFF;" type="submit" name="Up_badB" value="Update Key" /></th></tr>
			<?php }else{?>
            <tr><th colspan="2"><input style=" padding:4px;margin-top: 7%; background-color:rgb(176, 14, 14); color:#FFF;" type="submit" name="bad_keyB" value="Save" /></th></tr><?php }?>
           
         </table>
</form>
</div>
</div>


