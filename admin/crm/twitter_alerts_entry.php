
<link rel="stylesheet" type="text/css" href="../../css/admin.css">
<link rel="stylesheet" type="text/css" href="../../css/admin-style.css">
<?php


	include_once("../includes/settings.php");
require_once($Prefix."classes/socialCrm.class.php");

$ObjectSocial =  new socialcrm();

$keys=array();
$alert_keys=$ObjectSocial->TwitterSearch("c_twitter_alerts",'alert_name');
foreach($alert_keys as $r)$keys[]=$r['alert_name'];

if(isset($_GET['aedi_id']))
{
	$aedi_id=$_GET['aedi_id'];
	$wr="`id`='$aedi_id'";
	$edit_row = $ObjectSocial->TwitterSearch("c_twitter_alerts","*",$wr);
	//print_r($edit_row);
	//echo $edit_row[0]['alert_name'];
}
if(isset($_REQUEST['Up_alertB']))
{
	
	$hid=$_REQUEST['hid'];
	$alert_name=addslashes(trim($_REQUEST['alert_name']));
	$alert_disc=addslashes(trim($_REQUEST['alert_disc']));
	if(in_array($alert_name,$keys) or $alert_name==''){$error_msg='Alert already exist';}
	else{
	$st="`alert_name`='$alert_name',`alert_disc`='$alert_disc'";
	$ObjectSocial->TwitterUpdate("c_twitter_alerts",$st,"`id`='$hid'");
	//$query="update `c_twitter_alerts` set `alert_name`='$alert_name', `alert_disc`='$alert_disc' where id='$hid'";
	$_SESSION['mess_comp'] = "Alert updated successfully";
	echo "<script>window.parent.$.fancybox.close();</script>";
	}
	
}

if(isset($_REQUEST['alertB']))
{
	$value=array();
	$value['alert_name']=trim(addslashes($_REQUEST['alert_name']));
	$value['alert_disc']=trim(addslashes($_REQUEST['alert_disc']));
	if(in_array($value['alert_name'],$keys) or $value['alert_name']==''){$error_msg='Alert already exist';}
	else{
	$ObjectSocial->TwitterInsert("c_twitter_alerts",$value);
	$_SESSION['mess_comp'] = "Alert added successfully";
	//echo '<script type="text/javascript">window.opener.location.reload(true);<script>';
	//echo "<script> window.onunload = refreshParent;function refreshParent() {window.opener.location.reload(); }<script>";
	echo "<script>window.parent.$.fancybox.close();</script>";
	}
	
}
//require_once("../includes/footer.php"); 
?>
<div style="margin-top:65px;">
<?php if(isset($error_msg))echo '<center style=" color:red;">'.$error_msg.'</center>';?>
<div id="content" style=" border:1px; border-style:solid; width: 86%; margin-left: 6%; height: 241px;border-color: rgb(221, 236, 236);">
<!--style=" font-weight: bold; font-size: 14px;"-->
<center class="head"><?php if(isset($_GET['aedi_id']) && isset($edit_row))echo "Update Alert";else echo "Create Alert";?></center>
 <table  style=" margin-top:20px;" cellspacing="1" cellpadding="3" align="center" border="1" width="100%"><caption style=" color:#81bd82;"><?php if(isset($res_msg))echo "*".$res_msg."*";?></caption>
      <tr><td>
      	<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
         <table width="100%">
            
            <tr><th class="blackbold" align="left">Alert Name</th><td>
                <input class="inputbox" type="text" name="alert_name" placeholder="" title="Enter alert name" 
                value="<?php if(isset($_GET['aedi_id']) && isset($edit_row))echo stripslashes($edit_row[0]['alert_name']); ?>" required/>
            </td></tr>
            <tr><th class="blackbold">Alert Description</th>
            <td><textarea class="inputbox" name="alert_disc" rows="4" cols="22" title="Alert Description" style="text-align:left"/><?php if(isset($_GET['aedi_id']) && isset($edit_row))echo $edit_row[0]['alert_disc']; ?></textarea></td></tr>
            <input type="hidden" name="hid" value="<?php echo $edit_row[0]['id'];?>">
            <tr><th colspan="2">
            <?php if(isset($_GET['aedi_id']) && isset($edit_row)){?>
            <input  style=" margin-top:20px; padding:4px; background-color:rgb(176, 14, 14); color:#FFF;" type="submit" name="Up_alertB" value="Update Alert" />
			<?php }else{?>
            <input style=" margin-top:20px; padding:4px; background-color:rgb(176, 14, 14); color:#FFF;" type="submit" name="alertB" value="Create Alert" /><?php }?></th></tr>
         </table>
         </form></td>
       </tr>
 </table>
</div>




