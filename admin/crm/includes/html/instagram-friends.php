<?php 
	
	if(empty($_SESSION['accessToken']))header("location:https://www.eznetcrm.com/erp/admin/crm/instagram.php");
	else
	{
		$Frnd_res=$res=file_get_contents("https://api.instagram.com/v1/users/".$_SESSION['id']."/followed-by?access_token=".$_SESSION['accessToken']);
		$Fres=json_decode($Frnd_res);//print_r($Fres);
	}
?>
<script>
function SaveSocialData(obj,id,full_name,type){
	jQuery('.userid-set').val(id);
        jQuery('.dispalay-name').val(full_name);
	jQuery('.action-type').val(type);
	jQuery('#socialfrom').submit();
	}

</script>
<style>
    .fblogout {margin-top: 0px !important;}
    #fblogut {margin-bottom: 4px; margin-right: 1px; margin-top: 2px;}
	
   .view-profileIns > a {
    background: url("images/instagramAdd.png") no-repeat scroll 0 0 rgba(0, 0, 0, 0) !important;
    display: inline-block;
	background-size: 24px 24px !important;
    height: 24px;
    padding: 3px;
    width: 24px;
}
</style>

<body>
<link href='fullcalendar/facebook-page.css' rel='stylesheet' />
<script type="text/javascript" src="multiSelect/jquery.tokeninput.js"></script>
<link rel="stylesheet" href="multiSelect/token-input.css" type="text/css" />
<link rel="stylesheet" href="multiSelect/token-input-facebook.css" type="text/css" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">

<script>
jQuery(document).ready(function() {
    
$("#opener").click(function() {
	jQuery("#dialog").dialog(opt).dialog("open");
});
});

function addtocrm(iduser) {
	
	var opt = {
        autoOpen: false,
        modal: true,
        width: 415,
        height:150,
        title: 'Add User'
       };
	 
	var divID =  ".adduser_"+iduser;
	jQuery(divID).dialog(opt).dialog("open");
	jQuery(divID).show();
	
}

function addtoexistingcrm(iduser) {
	
	var opt = {
        autoOpen: false,
        modal: true,
        width: 415,
        height:150,
        title: 'Add Existing User'
       };
	var divID =  ".addexistinguser_"+iduser;
	jQuery(divID).dialog(opt).dialog("open");
	jQuery(divID).show();
	   
}	   
</script>



<!--
  Below we include the Login Button social plugin. This button uses
  the JavaScript SDK to present a graphical Login button that triggers
  the FB.login() function when clicked.
-->
<script>
function logout()
		{
			alert(" Logout...")
			$.ajax({
				   type: "GET",
				   dataType: "jsonp",
				   url: "https://instagram.com/accounts/logout/",
				   success:function(result){/*location.reload();*/},
				   error: function(result){/*alert("some error occured, please try again later");*/}});

			$.ajax({
				   type: "GET",
				   url: "getInfo.php",
				   data: "do=logOut",
				   success:function(result){location.reload();},
				   error: function(result){/*alert("some error occured, please try again later");*/}});
		}
</script>

 
<div id="Event" >

<a class="back" href="javascript:void(0)" onClick="window.history.back();">Back</a>

<div id="fblogut">
<div class='had'>Instagram</div>
<!--button onClick="javascript:logout();" class="fblogout" style="" ></button-->
            <a href="javascript:void(0)" id="logout" <?php if(isset($_SESSION['accessToken']))echo ""; else echo "style='display:none;'";?>onClick="logout()"><img src="http://199.227.27.207/erp/admin/crm/images/instagramL.png"/></a>
</div>

<div id="login">
    <div class="had"><?php echo $_SESSION['full_name']; ?></div>
</div>

<div id ="postinfo">
<TABLE WIDTH="100%"   BORDER=0 align="center"  >
  
<tr>
<td align="left" valign="top">

<? if (!empty($_SESSION['mess_social'])) {?>
<div>
<span  align="center"  class="message"  >
	<? if(!empty($_SESSION['mess_social'])) {echo $_SESSION['mess_social']; unset($_SESSION['mess_social']); }?>	
</span>
</div>
<? } ?>   


 <form name="form1" action=""  method="post" id="socialfrom" enctype="multipart/form-data">
<table width="100%"  border="0" cellpadding="0" cellspacing="0">

	
</td>
</tr>
  
		<tr>
		<td>
		<div class="user-container social">
		<?php 
		if(!empty($_SESSION['accessToken']))
		{
			echo "<h2 class='search-result'>Friends List </h2>";
			echo '<ul class="user-list">';
			$i=0;
		
			foreach($Fres->data as $f_res)
			{
				if($f_res->id)
				{
				echo '<li style="height:250px;">';
				echo '<div class="top"><div class="pfname"><a href="http://instagram.com/'.$f_res->username.'" target="_blank">'.$f_res->full_name.'</a></div>
					<div class="image-set" align="center"><span class="pimg"><a href="http://instagram.com/'.$f_res->username.'" target="_blank">
					<img src="'.$f_res->profile_picture.'" height="120px"/></a></span>';
                echo '</span></div>';
				echo '<div class="detail-box" align="center"><div class="pbtn">
                         <span class="view-profileIns"><a href="http://instagram.com/'.$f_res->username.'" target="_blank" title="View Instagram Profile"></a></span>
							<span class="add-profile"><a title="Add New" href="javascript:void(0);" onclick="addtocrm(\''.$i.'\')"></a></span>
			              <span class="exiting-profile"><a title="Add Existing" href="javascript:void(0);" onclick="addtoexistingcrm(\''.$i.'\')"></a></sapn>';				 
				echo '</div></div></div>';
				
				echo '<div class="down"><div class="plable-data">';
					
				echo '<div class="pdata"><div class="plable"><label>User ID</label>
					<span class="pcoln">:</span></div>&nbsp;<div class="presult">'.$f_res->id.'</div></div>';
					
				echo '<div class="pdata"><div class="plable"><div class="plable"><label>User Name</label>
					<span class="pcoln">:</span></div>&nbsp;<div class="presult">'.$f_res->username.'</div></div></div></div>';	
					
					
				# start for Existing			
				echo '<div class="addexistinguser_'.$i.'" style="display:none;"><div style="margin-top: 37px; text-align: center;"">';
        		if(in_array($f_res->id,$contact_result)){	
					echo '<a href="javascript:void(0)" class="btn-social noactive">Already Existing Contact</a>';  
        		} else{ 
					echo '<a href="searchContact.php?type=instagram&sid='.$f_res->id.'" class="fancybox fancybox.iframe btn-social">Existing Contact</a>';
				}
		
				if(in_array($f_res->id,$customer_result)){
					echo '<a href="javascript:void(0)" class="btn-social noactive">Already Existing Customer</a>';  
				}else{	
				echo '<a href="searchCustomer.php?type=instagram&sid='.$f_res->id.'" class="fancybox fancybox.iframe btn-social">Existing Customer</a>';
				}
					echo'</div></div>';
			 
				# start for new 		
				echo '<div class="adduser_'.$i.'" style="display:none; "><div style="margin-top: 37px; text-align: center;">';
				if(in_array($f_res->id,$contact_result)){			  
					echo '<a href="javascript:void(0)" class="btn-social noactive">Already Added Contact</a>';  

				}else{
					echo  '<a href="javascript:void(0)" onclick="SaveSocialData(this,\''.$f_res->id.'\',\''.$f_res->full_name.'\',\'add_contact\')" class="btn-social">Add New Contact</a>';
				}

				if(in_array($f_res->id,$customer_result)){
					echo '<a href="javascript:void(0)" class="btn-social noactive">Already Added Customer</a>';  
				}else{

				echo' <a href="javascript:void(0)" onclick="SaveSocialData(this,\''.$f_res->id.'\',\''.$f_res->full_name.'\',\'add_customer\')" class="btn-social">Add New Customer</a>';
				}		
					
		//echo '<div class="addexistinguser_'.$i.'" style="display:none;"><div style="margin-top: 37px; text-align: center;">';
    //******************
				echo  '</div></div>';
				echo '</li>';
				}//end if
		$i++;
		}//end loop
			echo '</ul>';
			echo '<div class="form-action">
					<input type="hidden" class="userid-set" name="userid[]">
					 <input type="hidden" class="dispalay-name" name="full_name">
					<input type="hidden" class="action-type" name="action-type">
					<input style="display:none;" type="submit" value="Add Contact" style="display:none;"/></div>';
		}//end if
		else 
		{			
			 if(!empty($_GET['q']))
				echo 'No Results Found';
		}
			?>
			</div>
			</td>
		</tr>

		<tr>
			<td  align="center" >
			
			<!--div id="SubmitDiv" style="display:none1">
			<?if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
			<input name="Submit" type="submit" class="button" id="SubmitButton" value="<?//=$ButtonTitle?> "  />
			</div-->
			</td>
		</tr>
   
   
</table></form>
	</td>
    </tr>
 
</table>
</div>
</div>
<!--</div>
</div>-->