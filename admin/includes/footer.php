<?	
 
(empty($PageHeading))?($PageHeading=""):("");
echo '<input type="hidden" name="MainModuleID"  id="MainModuleID" value="'.$MainModuleID.'" readonly>';
		
require_once($MainPrefix."includes/html/box/pop_loader.php");

$SelfPageHtml = 'includes/html/'.$SelfPage;
if(file_exists($SelfPageHtml)){ 
	include($SelfPageHtml);
}

/*if($ModifyLabel!=1){
	echo "<script>DisableModifyOptions();</script>";
}*/

if(!empty($_SESSION['AdminID']) && !empty($arryPermitted[0]['ModuleID'])){
	if($_SESSION['AdminType'] != "admin" && $arryPermitted[0]['FullLabel']!=1) {	
		echo "<script>DisableModifyOptions(".$arryPermitted[0]['AddLabel'].",".$arryPermitted[0]['EditLabel'].",".$arryPermitted[0]['DeleteLabel'].",".$arryPermitted[0]['ApproveLabel'].");</script>";
	
	}
}



$FooterStyle = '';
$SetInnerWidth='';
(empty($SetFullPage))?($SetFullPage=""):("");


if($LoginPage!=1){
		if($InnerPage==1){
				echo '</div>';
				
				$RightFile = 'includes/html/box/right_'.$SelfPage;
				if(file_exists($RightFile)){					 
					include($RightFile);
				}else{	
					$SetInnerWidth=1;
				}
				
				
				if($SetInnerWidth==1){	
					if($SetFullPage==1){
						echo '<script>SetFullPage();</script>';
					}else{		
						echo '<script>SetInnerWidth();</script>';
					}
				}
				
			}

/********************** Multi website By Karishma *****************************/
 if (!empty($_GET['CustomerID'])) {
				echo '</div>';
				
				$RightFile = 'includes/html/box/right_WebsiteManagement.php';
				if(file_exists($RightFile)){
					include($RightFile);
				}else{	
					$SetInnerWidth=1;
				}
				
		  	if($SetInnerWidth==1){	
					if($SetFullPage==1){
						echo '<script>SetFullPage();</script>';
					}else{		
						echo '<script>SetInnerWidth();</script>';
					}
				}
				
			}
/***********************************End**********************************/
		 ?>
	
	</div>
	<div class="clear"></div>
 </div>
<? }else{ $FooterStyle = 'style="background:none"'; } 


//if($_SESSION['CmpID']==606){echo 'footer'; exit;}

?>



	<? if($HideNavigation!=1){ ?>

  <div id="footer" class="footer-container clearfix" <?=$FooterStyle?>>
    	<div class="footer">
        	 <div class="copyright">Copyright &copy; <?=$arrayConfig[0]['SiteName']?>. All Rights Reserved. <br />Powered By: <span><a href="http://www.virtualstacks.com" target="_blank">Virtual Stacks</a></span></div>
        </div>
    </div>

	<? } ?>
<div id="dialog-modal" style="display: none;"></div>
	
</div>


<? 

if(empty($arryCompany[0]['Department']) || in_array("5",$arryCmpDepartment)){
	if(!empty($_SESSION['CmpID']) && !empty($_SESSION['AdminID']) && $HideNavigation!=1){
		require_once($MainPrefix."includes/html/box/pop_crm.php");
	}
}



 ?>

 <?php 
 
 if(!empty($_GET["newchat"]) || 1==1){

 	if(!empty($_GET["newchat"])){

 		//pr($_SESSION['CmpID']);
 	}
	if(!empty($_SESSION['AdminID']) ){

	if($HideNavigation != 1){
		if(empty($arryCompany[0]['Department']) || in_array("5",$arryCmpDepartment)){
				  $chatinfo=$objchat->getPermissionByUser($_SESSION['AdminID']);
		}	         
	}
	/*******************************End ************************************/

	$ChatActive=$objConfig->isChatActive(); 

	if(($_SESSION['AdminType']=='employee' OR $_SESSION['AdminType']=='admin' ) && $HideNavigation != 1 && $ChatActive==1){
		$idealtime=$objchat->getIdealTime();
		if($_SESSION['CmpID']==34){
				$licence='VSTACKzRp1HFaIxQ';

		}else{
			    $licence='ERP'.$_SESSION['DisplayName'];
		}
		
		$designation="";

  		if((empty($arryCompany[0]['Department']) || in_array("1",$arryCmpDepartment)) && $_SESSION['AdminType'] != "admin"){

			$designation=$arryEmployee[0]['JobTitle'];

		}


 	?>
 <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Droid+Sans:400,700">
<link rel="stylesheet" href="<?php echo $Config["WebUrl"];?>erp/admin/eznetchat/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo $Config["WebUrl"];?>erp/admin/eznetchat/css/custom.css">
<div ng-app="myapp" ng-controller="chatController as chatCtrl">
	<div style="display: none;">{{chatCtrl.section}}</div>
<div class="chat-area"  ng-class="(chatCtrl.section==2)?'chat-active':''">
		<div class="chat-header">
			<div class="user-name" ng-if="chatCtrl.section==2 && chatCtrl.chatwith.length > 0">
					{{(chatCtrl.currentchatwith.name)?chatCtrl.currentchatwith.name:'Visitor'}}
				</div>
				<div class="user-name" ng-if="(chatCtrl.section!=2) || chatCtrl.chatwith.length == 0 " >Live Chat</div>
				
			<div class="chat-support">
				<span class="notification-count-header" ng-if="chatCtrl.notificationnumber > 0">{{chatCtrl.notificationnumber}}</span>
				<a href="javascript:void(0);" ng-if="chatCtrl.section !=1 "><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
				<div class="support-chat" ng-if="chatCtrl.section==2">
					<ul>
						<li class="identify-status">
							<a href="javascript:void(0)" ng-class="(chatCtrl.identity.status=='online')?'user-online':'user-offline'" ng-if="chatCtrl.section==2"><i class="fa fa-dot-circle-o" aria-hidden="true"></i> Identify Status</a>
							<ul>
								<li><a href="javascript:void(0)" ng-click="chatCtrl.setMyStatus('away')"><i class="fa fa-circle" aria-hidden="true"></i> Away</a></li>
								<li><a href="javascript:void(0)" ng-click="chatCtrl.logOff()"><i class="fa fa-circle" aria-hidden="true"></i> Log off</a></li>
							</ul>
						</li>
						<li class="mail-box">
							<a href="javascript:;"><i class="fa fa-flag" aria-hidden="true"></i> Mail Support</a>
							<ul>
								<li><a href="javascript:void(0)"><i class="fa fa-circle" aria-hidden="true"></i> Export</a></li>
								<li><a href="javascript:void(0)"><i class="fa fa-circle" aria-hidden="true"></i> Mail</a></li>
							</ul>
						</li>
						<li class="notification">
							<a href="javascript:;"><i class="fa fa-bell" aria-hidden="true"></i> Notification
								<span class="notification-count" ng-if="chatCtrl.notification.length > 0">{{chatCtrl.notification.length}}</span>
							</a>
							<ul ng-repeat="notification in chatCtrl.notification">
								<li ng-repeat="notification in chatCtrl.notification">
									<p>{{notification.msg}}</p>
									<div class="transfer-action" ng-if="notification.type='transfer'">
									<a href="javascript:void(0)" ng-click="chatCtrl.acceptTransfer($index)"> accept</a>
									<a href="javascript:void(0)" ng-click="chatCtrl.cancelTransfer($index)"> cancel</a>
									</div>
								</li>
								<li ng-if="chatCtrl.notification.length == 0 "><p>There is no notification </p></li>
							</ul>
						</li>
						<li class="chat-setting" style="display: none;">
							<a href="javascript:;"><i class="fa fa-cog" aria-hidden="true"></i> Setting</a>
							<ul>
								<li><a href="#"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a></li>
								<li><a href="#"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</a></li>
								<li><a href="#"><i class="fa fa-upload" aria-hidden="true"></i> Update</a></li>
								<li><a href="#"><i class="fa fa-power-off" aria-hidden="true"></i> Logout</a></li>
							</ul>
						</li>
						<li class="chat-setting">
							<a href="javascript:;"><i class="fa fa-cog" aria-hidden="true"></i> Agents</a>
							<ul>
							<li ng-if="agentlist.status=='online'" ng-repeat="(agentid,agentlist) in chatCtrl.agentlist" ng-class="(agentlist.status=='online')?'online':''"><a href="javascript:void(0)" ng-click="chatCtrl.transferchat(agentid)">{{agentlist.username}}</a>
							
							</li>
							<li ng-if="!chatCtrl.agentlist">There is no agent</li>
						</ul>
						</li>

						<li class="chat-setting">
							<a href="javascript:;"><i class="fa fa-cog" aria-hidden="true"></i> Chat With</a>
							<ul>
								<li ng-repeat="chatwith in chatCtrl.chatwith" ng-class="(chatCtrl.activeTab==$index)?'active':''" ><a href="javascript:void(0)" ng-click="chatCtrl.changeChattab($index)">{{chatwith.name}} 
								<span class="unread-chat-count" ng-if="chatCtrl.notificationnumberWithRef[chatwith.refid] > 0">
									{{chatCtrl.notificationnumberWithRef[chatwith.refid]}}
								</span>
								<i class="fa fa-angle-right pull-right" aria-hidden="true"></i></a>
									<ul>
										<li><a href="javascript:void(0)" ng-click="chatCtrl.closeVisitorchat($index,chatwith.userid)">Close</a></li>
										<li><a href="javascript:void(0)" ng-click="chatCtrl.transferpopup($index);">Transfer</a></li>
									</ul>	
								</li>
								<li ng-if="chatCtrl.chatwith.length == 0">
									<p>There is no chat section</p>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>

		<div class="mailbox" ng-if="chatCtrl.mailBox==true" ng-if="chatCtrl.section==2">
			<div class="form-box">
				<span class="popup-close"><a href="javascript:void(0)"  ng-click="chatCtrl.closepopup('mailBox')"><i class="fa fa-close"></i></a></span>
				<label>Email</label>
				<input type="text" ng-model="chatCtrl.chatEmails" class="">
				<a href="javascript:void(0)" class="btn btn-primary btn-sm" ng-click="chatCtrl.chatemail()">Send</a>
				<span class="">Note: For multiple emails use ','</span>
			</div>
		</div>

		<div class="form-login section-box" ng-if="chatCtrl.section==1">
			<form name="login-form" class="login-form">
				<div class="form-field">
					<label class="field-text">Your name:</label>
					<span class="login-value">{{chatCtrl.identity.myname}}</span>
				</div>
				<div class="form-field">
					<label class="field-text">E-mail:</label>
					<span class="login-value">{{chatCtrl.identity.myemail}}</span>
				</div>
			
				
				<div class="form-field">
					<button type="submit" class="submit-button"  ng-click="chatCtrl.chatlogin()">Start chat</button>
				</div>
			</form>
		</div>



		<div class="chat-section" ng-if="chatCtrl.section==2">


   <div class="chat-wrap"  ng-class="(chatCtrl.activeTab==$index)?'active':''" ng-repeat="chatwith in chatCtrl.chatwith; ">
    <div class="chat-box">   
     <div class="chat-field" ng-repeat="ChatDataByRoom in chatCtrl.ChatDataByRoom[chatwith.refid]" ng-class="{'from':(ChatDataByRoom.agentid != chatCtrl.identity.myuserid),'':(ChatDataByRoom.userid == chatCtrl.identity.myuserid),'close-message':(ChatDataByRoom.isclosemsg==true)}" >
      <div class="chat-thumb"><img src="<?php echo $Config["WebUrl"];?>erp/admin/eznetchat/images/thumb-icon.png" /></div>

      <div class="chat-content">
       {{ChatDataByRoom.msg}}
       <small>{{ChatDataByRoom.name}}</small>
        <small class="chat-time">{{ChatDataByRoom.time.format("hh:mm a")}}</small>
      </div>
     
     </div>     
    </div>
    <div class="input-area" ng-if="chatwith.closechat!=true">

     <form autocomplete="off">
      <input type="text" name="input-field" placeholder="Send a message..." ng-model="chatCtrl.chatmessagetextarea[$index]" autofocus class="control-field" ng-keyup="$event.keyCode===13 && chatCtrl.sendChat($event,$index)" >
      <div class="support-field">
       <div class="attachment-area" >

      <input type="file" ng-model="chatCtrl.uploadFile[$index]"  id="uploader-input-{{$index}}" class="uploader-input uploder" />
     
       <a  href="javascript:void(0)" class="uploader-link" ng-click="chatCtrl.clickUploadlink($index)"><img src="<?php echo $Config["WebUrl"];?>erp/admin/eznetchat/images/attachment.png" /></a></div>
       <div class="chat-submit"><a href="javascript:void(0)" ng-click="chatCtrl.sendChat($event,$index)"></a>
       <i class="fa fa-level-down" aria-hidden="true"></i></div>
      </div>
     </form>
    </div>
   </div>
   <div class="ready-chat" ng-if="chatCtrl.chatwith.length == 0"> You are ready for chat</div>

 </div> 

	</div>

	<audio id="audiotag1" src="<?php echo $Config["WebUrl"];?>erp/admin/eznetchat/js/new_message.wav" preload="auto"></audio>
	<div class="chat-icon">
	<span class="notification-count" ng-if="chatCtrl.notificationnumber > 0">{{chatCtrl.notificationnumber}}</span>
	<a href="javascript:void(0)" class="eznetchat-opener"><img src="<?php echo $Config["WebUrl"];?>erp/admin/eznetchat/images/chat-icon.png"></a></div>
	<script type="text/javascript">
	 var myinfo={};
	 myinfo.userID="<?php echo $_SESSION['AdminID'];?>";
	 myinfo.userFname="<?php echo $_SESSION['UserName'];?>";
	 myinfo.userLname="";
	 myinfo.userContacts="0000000000";
	 myinfo.designation="<?php echo $designation;?>";
	 myinfo.userEmail="<?php echo $_SESSION['AdminEmail'];?>";
	 myinfo.username="<?php echo $_SESSION['AdminEmail'];?>";
	 myinfo.userCompcode="<?php echo $licence;?>";
	 myinfo.userRoleID="2";
	 myinfo.type="agent";
	 myinfo.host="localhost";

	   
	</script>
	
	<script src="<?php echo $Config["WebUrl"];?>js/public/js/moment.min.js"></script>
	<!--<script src="https://cdn.socket.io/socket.io-1.3.5.js"></script>-->
	<script src="<?php echo $Config["WebUrl"];?>erp/admin/eznetchat/js/socket.io-1.3.5.js"></script>

<script type="text/javascript" src="<?php echo $Config["WebUrl"];?>erp/admin/eznetchat/angular/angular.min.js"></script>
<script src="<?php echo $Config["WebUrl"];?>erp/admin/eznetchat/angular/app.js"></script>
<script src="<?php echo $Config["WebUrl"];?>erp/admin/eznetchat/angular/angular-cookie.js"></script>
<script src="<?php echo $Config["WebUrl"];?>erp/admin/eznetchat/angular/angular-route-live.js"></script>
<script src="<?php echo $Config["WebUrl"];?>erp/admin/eznetchat/angular/chatController.js?<?php echo time();?>"></script>
<script src="<?php echo $Config["WebUrl"];?>erp/admin/eznetchat/angular/directive.js?<?php echo time();?>"></script>
	
	<script type="text/javascript">
		(function() {

	$('#live-chat header a.toggle-chat').on('click', function() {

		$('.section-box').slideToggle(300, 'swing');
		//jQuery('#live-chat header').toggleClass('active');
		$('.chat-message-counter').fadeToggle(300, 'swing');
		jQuery('#live-chat').toggleClass('active');
	});
	jQuery('.chat-icon a').on('click', function(){
			jQuery('.chat-icon, .chat-area').toggleClass('active');
		});

	}) ();
	</script>
	</div>
	

<?php 
		}
	}
} 
 
/************************** Chat Info By Ravi  ***************************/
if(!empty($_SESSION['AdminID']) ){

	if($HideNavigation != 1){
		if(empty($arryCompany[0]['Department']) || in_array("5",$arryCmpDepartment)){
				  $chatinfo=$objchat->getPermissionByUser($_SESSION['AdminID']);
		}	         
	}
	/*******************************End ************************************/

	$ChatActive=$objConfig->isChatActive(); 
	
	




	/******************** Chat Script By Ravi************************/



if(($_SESSION['AdminType']=='employee' OR $_SESSION['AdminType']=='admin' ) && $HideNavigation != 1 && $ChatActive==1){

$idealtime=$objchat->getIdealTime();



if(!empty($chatinfo[0]->permission) OR $_SESSION['AdminType']=='admin'){
if($_SESSION['AdminType']=='admin'){
$str='internal,external';
}else{
$str=implode(',',unserialize($chatinfo[0]->permission));
}

$licence=$objchat->getChatLicence($_SESSION['CmpID']);

if(!empty($_GET["developmentmode"]) AND $_GET["developmentmode"]=="yes"){
	//	pr($licence);
	//var_dump($licence);
	}
if($licence!==false){

if($licence===0){
			$licence=$objchat->chatCurl('companyregister',array('companyid'=>$_SESSION['CmpID'],'server'=>$_SERVER['HTTP_HOST']));		
			
			if(!empty($_GET["developmentmode"]) AND $_GET["developmentmode"]=="yes"){
				//echo "insert";
				//pr($licence);
			}
			$ldata=json_decode($licence);
		
			if($ldata->licence){
					$licence=$ldata->licence;			
			}else{			
				$licence=$_SESSION['CmpID'].'-'.rand(111,9999);		
			}
	}


	
	

$chatname=$_SESSION['UserName'];
$chatemail=(!empty($_SESSION['EmpEmail']))?($_SESSION['EmpEmail']):("");
$chatID=$_SESSION['AdminID'];
$ptype='Sales';
$chatroles=$objchat->getchatrole($chatID);  



	if(!empty($chatroles)){
	foreach($chatroles as $chatro){
	$t[]=$chatro->rolename;
	}
	$ptype=implode(',',$t);
	}

if($_SESSION['AdminType']=='admin'){
$chatemail=$_SESSION['AdminEmail'];
$chatID='admin-'.$_SESSION['AdminID'];
$ptype='Sales,Support';
}

?>
<div class="isactiveChat"></div>
<script>
var style={};
style.right=150; 
 var chat = {id:"<?php echo $chatID;?>", name:"<?php echo $chatname; ?>", empemail:"<?php echo $chatemail;?>",permission:"<?php echo $str;?>",lis:"<?php echo $licence;?>",ptype:"<?php echo $ptype;?>",idealtime:"<?php echo $idealtime;?>",style:style}; 
 var detail='{"id":"<?php echo $chatID;?>","name":"<?php echo $chatname; ?>","empemail":"<?php echo $chatemail;?>","lis":"MnT2FSAl0U","permission":"<?php echo $str;?>","ptype":"<?php echo $ptype;?>","idealtime":"<?php echo $idealtime;?>"}';
console.log(detail);
 	 (function(){
 	 	 //console.log(chat);
	 // var e = document.createElement('script'); e.type='text/javascript'; e.async = true;
	 // e.src = document.location.protocol + '//66.55.11.23/erp/js/chatjs/myjs.js';
	 // var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(e, s);
	  })(); 
</script>





<?php if(!empty($_GET["testnewchat"]) || 1==2){

?>
<link type="text/css" rel="stylesheet" href="<?php echo $Config["WebUrl"];?>js/public/css/stylesheet.css" />
	<link href="https://fonts.googleapis.com/css?family=Open+Sans%20Condensed:300italic,300,700" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<style>
.rs-chat {
    background: #fff none repeat scroll 0 0;
    bottom: 0;
    display: block;  
    overflow: hidden;
    padding: 0 !important;
    position: fixed;
    right: 9px;
    z-index: 9999999;
    border-radius: 5px 5px 0 0;
    height: 43px;
    position: fixed;
    right: 9px;
    width: 300px;
}

.rs-chat.open .rs-chat-close {
    display: block;
}
.rs-chat-close {
    background: rgba(0, 0, 0, 0) url("images/minimise.png") no-repeat scroll 0 0;
    border-radius: 5px;
    color: #fff;
    cursor: pointer;
    display: none;
    left: 5px;
    padding: 11px 0 7px 11px;
    position: absolute;
    text-indent: -99999px;
    top: 3px;
    width: 27px;
    z-index: 99999993;
}

.rs-chat .rs-chat-open, .rs-chat .rs-chat-titile-box {
   /* display: none;*/
}
.rs-chat-open {
    background: #d33f3e none repeat scroll 0 0;
    color: #fff;
    cursor: pointer;
    font-size: 14px;
    font-weight: bold;
    height: 43px;
    margin-left: 0;
    margin-top: 0;
    padding: 15px;
    position: absolute;
    width: 100%;
}

.chat-ifrm-loader {
    background: rgba(0, 0, 0, 0) url("<?php echo $Config["WebUrl"];?>images/chatloader.gif") repeat scroll 0 0;
    display: inline-block;
    float: right;
    height: 16px;
    margin-right: 54px;
    width: 16px;
}

.iframe-div {
    display: none;
}
.rs-chat.open{
height:397px;
width: 380px;
}


.rs-chat.open .iframe-div{
    display: block;
}

.rs-chat.open .rs-chat-open {
    display: none;
}
.rs-chat.open .iframe-div {
    border: 1px solid;
    display: block;
    height: 397px;
}

.rs-chat #yourEmailDiv {display: inline-block;    width: 150px;
    text-align: left;
    margin-left: 10px;}
.rs-chat #yourNameDiv {display: inline-block;    width: 150px;
    text-align: left;
    margin-left: 10px;}
    
.rs-chat .personinside{
display:none;
}

</style>
<div class="rs-chat" style="right: 9px; position: fixed;" data-usertype="empeznetusr">
	<div class="rs-chat-close">-</div>
	<div class="rs-chat-open">Chat Now <span class="chat-ifrm-loader"></span></div>
	<div class="iframe-div">
	<span class="close-header"><div class="rs-chat-titile-box">Chat Now</div></span>
	<header class="homebanner">
			<h1 class="homebannertext">
				<div class="logo-box">
					<a href="javascript:void(0)" id="logo">Live<span>Chat</span></a>
				</div>
				<div class="top-link-box">
					<a href="javascript:void(0)" id="notification" class="t-open topen top-link-icon">Notification</a>
					<a href="javascript:void(0)" id="onlineuserlink" class="t-open topen top-link-icon">Transfer</a>
					<a href="javascript:void(0)" id="mystatus" class="t-open topen top-link-icon">Status</a>
					 <a href="javascript:void(0)" id="settinglink" class="t-open topen top-link-icon">Download</a>
				</div>
			</h1>
	</header>

	<section class="section-transfer top-link-content">
		
	</section>	
	<section class="section-onlineuser-section top-link-content">
		<!-- <span class="action open"></span>-->
		<div class="section-onlineuser">
				<ul class="onlineuser-box"></ul>
		</div>
	</section>
	 <span class="mystatus"></span>
	<section class="section-mystatus-section top-link-content">
		
		<div class="section-mystatus section-div">
				<ul class="mystatus-box submenu">
					<li><a href="javascript:void(0)" class="away my-status">Away</a></li>
					<li><a href="javascript:void(0)" class="online my-status">Online</a></li>
					
					<li><a href="javascript:void(0)" class="logoff">Log off</a></li>
				</ul>
		</div>
	</section>
	<section class="section-setting-section top-link-content">		
		<div class="section-setting section-div">
				<ul class="setting-box submenu">
					<li><a href="javascript:void(0)" class="setting-export" id="downloadchat">Export</a></li>
					<li><a href="javascript:void(0)" class="setting-email">Email</a></li>				
				</ul>
		</div>
	</section>
	<section class="chat-with"></section>
	 <section style="display:none;">
		<input type="button" value="MyIP" id="myip">
		<input type="button" value="Clear" id="clearcookies">
		<!-- <input type="button" value="download chat" id="downloadchat">-->
	</section>
	<section class="section">

		<!-- These elements are displayed as white info cards in the middle of the screen -->

		<div class="connected">

			<img src="<?php echo $Config["WebUrl"];?>js/public/img/unnamed.jpg" id="creatorImage" />

			<div class="infoConnected">
				<h2>Who are you?</h2>
				<br/>
				<form class="loginForm">
					Email : <div  id="yourEmailDiv"></div><br/>
					Name  :<div  id="yourNameDiv"></div><br/>
					<input type="hidden" id="yourEmail" placeholder="Your email address" /><br/>
					<input type="hidden" id="yourName" placeholder="Your nick name" /><br/>
					
					<input type="submit" id="yourEnter" value="ENTER" />
				</form>

			</div>

		</div>

		<div class="personinside">

			<img src="<?php echo $Config["WebUrl"];?>js/public/img/unnamed.jpg" id="ownerImage" />

			<div class="infoInside">
			<!-- 	<h2>Chat with <span class="nickname-chat"></span></h2>-->
				<form class="loginForm">
					<input type="text" id="hisName" placeholder="Your nick name" class="input" /><br/>
					<input type="text" id="hisEmail" placeholder="Your email address" class="input"/><br/>
					<select style="display:none;" id="hisprefer" class="input"/>
						<option value="Sales">Sales</option>
						<option value="Support">Support</option>					
					</select><br/>
					<input type="submit" id="hisEnter" value="CHAT" />
				</form>

			</div>

		</div>

		<div class="invite-textfield">
			<h2>Now You Are Ready For Chat!</h2>	
			<div class="link" style="display:none">
				<a title="Invite a friend" href="" id="link"></a>
			</div>

		</div>

		<div class="left">

			<img src="<?php echo $Config["WebUrl"];?>js/public/img/unnamed.jpg" id="leftImage" />

			<div class="info">
				<h2><span class="nickname-left"></span> has left this chat.</h2>
				<h5>Invite somebody else by sending them this page.</h5>
			</div>

		</div>

		<div class="toomanypeople">

			<h2>Oops, you can not join this chat!</h2>
			<h5>There are already two people in it. Would you like to create a <a title="New Room" href="/create" id="room">new room</a>?</h5>

		</div>

		<div class="nomessages">

			<img src="<?php echo $Config["WebUrl"];?>js/public/img/unnamed.jpg" id="noMessagesImage" />

			<div class="info">
				<h2>You are chatting with <span class="nickname-chat"></span>.</h2>
				<h5>Send them a message from the form below!</h5>
			</div>

		</div>

		<div class="chatscreen">

			<!-- <ul class="chats">
				<!-- The chat messages will go here 
			</ul>-->

		</div>
		<div class="noempab" style="display:none;">
			<div class="info">
				<h4>Sorry Currently support team is not available!</h4>	
				<h5>Support team will be contact to  you soon</h5>				
			</div>
			<div class="msgform-box">
				<div class="msgform">
					<input type="text" id="msgname" placeholder="Your nick name" class="input"/><br/>
					<input type="text" id="msgemail" placeholder="Your email address" class="input" /><br/>
					<input type="text" id="msgphone" placeholder="Phone" class="input" /><br/>
					<textarea  id="msg" placeholder="Your Message" class="input"/></textarea><br/>
					<input type="hidden" id="msgptype"  />
					<input type="button" id="msgenter" value="Leave Message" class="button" />
				</div>
			</div>

		</div>
		<span class="loader"></span>

	</section>

	<footer>

		<form id="chatform">

			<textarea id="message" placeholder="Write something.."></textarea>
			<input type="submit" id="submit" value="SEND"/>

		</form>

	</footer>
	<div class="dialog-user-action"></div>
	<div class="dialog-message"></div>
	<audio id="audiotag1" src="<?php echo $Config["WebUrl"];?>js/public/js/new_message.wav" preload="auto"></audio>

	<script src="<?php echo $Config["WebUrl"];?>js/public/js/moment.min.js"></script>
	<script src="https://cdn.socket.io/socket.io-1.3.5.js"></script>
	<script src="<?php echo $Config["WebUrl"];?>js/public/js/chat.js"></script>
<!--	  <script src="//code.jquery.com/ui/1.10.1/jquery-ui.js"></script>	  -->
	    <script>
	  jQuery("document").ready(function(){
				jQuery(".rs-chat-open").click(function(){

					console.log("Clickkckck");
					jQuery(".rs-chat").toggleClass("open");
					
				})
				
				jQuery(".rs-chat-close").click(function(){

					console.log("Clickkckck");
					jQuery(".rs-chat").removeClass("open");
					
				})

				
		  })
	  
	  </script>
</div>
</div>
<?php }?>

<?php 
}// false case


}  // permission check
}  // Is active

} // login check
					/**************** End ***************/

 

?>
<?php if(empty($_GET["testnewchat"]) && 1==2){?>
<link rel="stylesheet" href="<?php echo $Prefix;?>css/chatcss/style.css" />
<script type="text/javascript" async="" src="<?php echo $Prefix;?>js/chatjs/myjs.js"></script>
<?php }?>
</body>
</HTML>

<? 
 
(empty($PageUrl))?($PageUrl=""):(""); 
if(!empty($_SESSION['AdminID']) && !empty($_SESSION['loginID'])){
	$PageUrl = $Config['DeptFolder'].'/'.$SelfPage.'?'.$_SERVER['QUERY_STRING'];
	$PageUrl = ltrim($PageUrl,"/");
	$PageUrl = rtrim($PageUrl,"?");	
}

 
?>

<script  type="text/javascript">
$(document).ready(function () {
	$("#ZipCode").on("click", function () { 
		autozipcode();
	});	
	 
	$("#ZipCode").on("blur", function () { 
		SetCountyByZip();		

	});

});

function showChart(obj){
	var arrField = obj.value.split(":");

	$('#'+arrField[0]).show();
	$('#'+arrField[1]).hide();
}

if(document.getElementById("list_table") != null){
	$('#list_table tr:nth-child(even)').addClass('evenbg');
	$('#list_table tr:nth-child(odd)').addClass('oddbg');

	$('#list_table tr:first-child').removeAttr('class');
	$('#list_table tr:last-child').removeAttr('class');

	/***************************/
	/*$('.export_button').attr('title', $('.export_button').val());
	$('.print_button').attr('title', $('.print_button').val());
	$('.add').attr('title', $('.add').html());
	$('.add_quick').attr('title', $('.add_quick').html());
	/***************************/
}








if(document.getElementById("load_div") != null){
	document.getElementById("load_div").style.display = 'none';
	
	var TitleBar = remove_tags($('.had')[0].innerHTML);
		
	window.document.title = TitleBar;
	

	/************************/	
	var MainPrefix = <?php echo json_encode($MainPrefix);?>;	
	var PageUrl = <?php echo json_encode($PageUrl);?>;
	var PageHeading = <?php echo json_encode($PageHeading);?>;
	 
	if(TitleBar!='' && PageUrl!=''){ 
		TitleBar = TitleBar.replace(/[^A-Za-z0-9 _]/g,'');
		
		$.ajax({
			type: "GET",
			async:false,
			url: MainPrefix+"ajax.php",
			data: "&action=PageName&PageName="+escape(TitleBar)+"&PageHeading="+escape(PageHeading)+"&PageUrl="+escape(PageUrl)+"&r"+Math.random(),
			success: function (responseText) {
				//alert(responseText);				
			}
		});		
	}
	/************************/	
	
}
</script>



<? 


 if($Config['CurrentDepID']==5 && $ModuleParentID==2025 && $ViewPage!=1 && $EditPage!=1){?>
<script language="javascript1.2" type="text/javascript">
    
    $(document).ready(function(){
	//auto_ajaxImportEmail();
	window.setTimeout(auto_ajaxImportEmail, 5000);
     	setInterval(auto_ajaxImportEmail, 180000);     
     });
     
     
     function auto_ajaxImportEmail()
    {
         
                //alert('.');return false; 
                sendParam='&action=autoImportEmail&r='+Math.random();  
                $.ajax({
                        type: "GET",
                        async:false,
                        url: 'autoImportEmail.php',
                        data: sendParam,
                        success: function (responseText) {  
                           //alert(responseText);
                        }
          });
        
    }
     
   
</script>
<? } ?>
<? 
/*****************************/	
if(!empty($_SESSION['AdminID']) && $Config['CurrentDepID']==5 && $HideNavigation != 1 && $objConfig->isPhoneActive()){
	$dataArray =  explode("home.php",$_SERVER["REQUEST_URI"]);
	$dataArrayWork =  explode("workspace.php",$_SERVER["REQUEST_URI"]);

	if(count($dataArray)==1 && count($dataArrayWork)==1){
		require_once(_ROOT."/admin/crm/includes/html/callBlock.php"); 
	}  
}
/*****************************/

?>
 
