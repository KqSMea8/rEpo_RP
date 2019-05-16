<?
	if(empty($CallDashboardInc)){
		$CallDashboardInc = "includes/html/box/call_dashboard.php";
		include($CallDashboardInc);
	}

 ?>


<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
<script type="text/javascript" src="multiSelect/jquery.tokeninput.js"></script>
<script type="text/javascript" src="<?php echo $Config['Url']; ?>/lib/linphone/utils.js"></script>
<link rel="stylesheet" href="<?php echo $Config['Url']; ?>/lib/linphone/calling.css">


<object id="core" type="application/x-linphone-web" width="0" height="0">
<param name="onload" value='loadCore'>
</object>

<div class="second_col" style="<?=$WidthRow2?>">
             <div class="block p_l_request">   
             <h3>Phone</h3>
              <div class="bgwhite">
      <div class="quota-emp">        
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
			   
			     <!--  connect user -->
				<tr>
					<td class="connect_server"> 
					<div style="display:none" class="connect_server">
					<label style="margin-left: 30px; display: inline-block; float: left;">Connect to Call Server</label>
					<span style="margin-bottom: 15px; padding-left: 0px; float: left; margin-left: 5px;">
					<a onclick="connect()" style="" href="javascript:void(0);"><img border="0" style="padding-left: 0px; margin-top: -3px;width: 28px;" src="/erp/admin/images/phone_settings.png" onmouseover="ddrivetip('&lt;center&gt;Connect&lt;/center&gt;', 45,'')" ;="" onmouseout="hideddrivetip()"></a>				
					</span>
					</div>
					<div align="center" id="ajax-loader-call-connect"><img src="../images/loading.gif">&nbsp;Loading.......</div>
					</td>
				</tr>
				
				 <!-- end connect user -->
				 <!--  connect to call  -->
				<tr style="display:none;" id="connect_call">
					<td>
					
					<!-- <label style="width: 27px; display:inline-block;">Call </label>:  -->
					<select name="call_id" style="width: 72px; height: 23px;" id="call_id" onchange =  "addCountryCodeInEmployee(this);">
					   <option value="0">Select Code</option>
					   <?php foreach($area_code as $code){ ?>					   
					   <option value="<?php echo $code->isd_code; ?>" prefixCode="<?php echo $code->isd_prefix; ?>"  <?php if($CountryCodeEmp==$code->isd_code){ echo "selected";  }    ?>><?php echo $code->name."(".$code->isd_code.")"; ?></option>
					   <?php  } ?>
					</select>
					<input type="text" name="call" class="inputbox customfield" style="width: 114px;" id="call" maxlength="10" onkeypress="return isNumberKey(event);">
					<span style="margin-bottom: 15px; float: right;">
					<a href="javascript:void(0);" style="margin-top: 6px;" onclick="call_connect('call_form','to')"><img border="0" onmouseout="hideddrivetip()" onmouseover="ddrivetip('&lt;center&gt;Call&lt;/center&gt;', 40,'')" src="/erp/admin/images/Call.png" style="float: left; margin-top: -3px; margin-right: 1px;"></a>				
					<a href="CallContactList.php" class="fancybox fancybox.iframe"><img border="0" onmouseout="hideddrivetip()" ;="" onmouseover="ddrivetip('&lt;center&gt;Search&lt;/center&gt;', 40,'')" src="/erp/admin/images/search.png"></a>
					
					<img border="0" src="/erp/admin/images/block-16.png" onclick="onUnregistration()"onmouseout="hideddrivetip()" onmouseover="ddrivetip('&lt;center&gt;Unregister on Phone&lt;/center&gt;', 80,'')" style="cursor:pointer;" ></a>
					
					</span></td>
				</tr>
			    <!--  end to call  -->
				<tr>
				<td  align="left">
				<label style="width:71px; display:inline-block;">From Date </label>:
					<script>
					$(function() {
					$( "#fromCall" ).datepicker({					
					onClose: function( selectedDate ) {
					$( "#toCall" ).datepicker( "option", "minDate", selectedDate );
					}
					});
					$( "#toCall" ).datepicker({					
					onClose: function( selectedDate ) {
					$( "#fromCall" ).datepicker( "option", "maxDate", selectedDate );
					}
					});
					});
					</script>	
				 <input id="fromCall" name="fromCall" readonly="" class="datebox" value="<?php echo date('m/d/Y');?>"  type="text" >
				     <?php echo '<input type="button" value="Go" onclick="GetCallResponce('.$_SESSION['AdminID'].');" class="button">';?>
				</td>
	
				<tr style="display:none;">				
				<td>
				<label style="width:71px; display:inline-block;">To Date</label>: <input id="toCall" name="toCall" readonly="" class="datebox" value="<?php echo date('m/d/Y');?>"  type="text" > 
				</td>
				</tr>
				
				<tr>	             
				<td>
				<form action="#CallForm" method="get" id="CallForm">
				<?php echo '<script>jQuery(document).ready(function(){GetCallResponce('.$_SESSION['AdminID'].');});</script>';?>
				<div align="center" id="ajax-loader-call" style="display: none;"><img src="../images/loading.gif">&nbsp;Loading.......</div>
				<div class="call-detail">
				</div>
				</form>
				</td>
				</tr>				
				</table>
 </div>
           

<div class="chart" style="padding-top:15px">
 </div>

 </div>


            </div>
          </div>
		  
<!--  call user form -->		  
<div id="call_form" class="callform" style="display:none;max-height: none; min-height: 0px;">
<form class ="form" name="call_form2">
      <audio id="audiotag2" src="/erp/lib/linphone/tring_tring_tring.mp3" preload="auto"></audio>
       
		<div class="header_tab">
		<!--
		<span style="padding-right: 66px;" id ="from_pause" ><img onclick="pauseCallUser('from')" title="Pause" style="cursor: pointer; margin-top: 0px; position: absolute; width: 31px; top: 5px;" src="/erp/admin/images/pause.png"></span>
		<span style="padding-right: 66px;display:none;" id ="from_resume"><img onclick="resume()" title="Resume" style="cursor: pointer; margin-top: 0px; position: absolute; width: 31px; top: 5px;" src="/erp/admin/images/resum.png"></span>
		
		<span><img onmouseout="hideddrivetip()" onmouseover="ddrivetip('&lt;center&gt;Mute&lt;/center&gt;', 40,'')" src="/erp/admin/images/mute.png" style="cursor: pointer;" title="Mute" onclick="MicMuted()"></span>
		
		<span>
		<img onmouseout="hideddrivetip()" onmouseover="ddrivetip('&lt;center&gt;Speaker&lt;/Speaker&gt;', 40,'')" src="/erp/admin/images/speaker.png" style="width: 24px; margin-left: 115px;cursor: pointer;" title="Speaker"></span>
		 -->
		 
		 <span class="header-tab-span active-call-tab"><img onmouseout="hideddrivetip()" onmouseover="ddrivetip('Home', 40,'')" src="../images/call_home.png" title="Home" onclick="backComment()"></span>
		 <span class="header-tab-span"><img onmouseout="hideddrivetip()" onmouseover="ddrivetip('Events', 40,'')" src="../images/event-icon.png" title="Events" onclick="callevent();"></span>
		 
		 <span class="header-tab-span"><img onmouseout="hideddrivetip()" onmouseover="ddrivetip('Notes', 40,'')" src="../images/note.png"  title="Notes" onclick="callnote();"></span>
		
		
		<span class="header-tab-span"><img onmouseout="hideddrivetip()" onmouseover="ddrivetip('Dialer', 40,'')" src="../images/dailer.png"  title="Dialer" OnClick="ondialer()"></span>
		 
		<span class="header-tab-span"><img onmouseout="hideddrivetip()"  onmouseover="ddrivetip('Hungup', 40,'')" src="../images/hungup.png"  title="Hung up" OnClick="onCallEnd()"></span>
		
		<span>
		<p id="outgoing_timer" >00:00</p>
		</span>
		<span class="extra"></span>
		
		
		</div>
		
		<div class="comment_section">
					<div style="padding-top: 11px;">
					<div class="from_address_call">
					<div style="margin-bottom: 5px;">
					<span class="lable">Name</span> <span class="col">:</span> 
					<span id="call_name" class="fontbox">
					   <span class="ajax-loader-call-name"><img src="../images/loading.gif">&nbsp;Loading...</span>
					</span>  
					</div>
					
					<div style="margin-bottom: 5px;">
					<span class="lable">Email</span> <span class="col">:</span>
					<span id="call_email" class="fontbox"> 
					  <span class="ajax-loader-call-name"><img src="../images/loading.gif">&nbsp;Loading...</span>
					</span>
					</div>
					</div>
					<!--
					<div>
					<span class="lable">Comments</span> <span class="col">:</span> 
					<textarea name="Comments" type="text" class="textarea fontbox1" id="from_comments"></textarea>
					</div>
					-->
					</div>
					
					<div style="padding-bottom: 5px;"><span class="lable"> &nbsp;</span> <span class="col">&nbsp;</span> <span class="statusC" style="font-size: 14px">No call</span></div>
					
					<div style="margin-left: 114px;">
					<input type="button" class="button" onclick="popupClose('call_form')" value="Close">
					<!--
					<input type="hidden" name="comments_type" id="comments_type" value="">
					<input type="hidden" name="comments_id" id="comments_id" value="">
					<span id="from_comment_button">
					<input type="button" class="button" value="Save" onclick="addComments('call_to')">
					</span>
					<span id="from_comment_loader" style="display:none;">
					<img src="../images/loading.gif">
					</span>
					-->
					</div>
		</div>
		
		<div class="dailer_section" style="display:none; margin-top: -13px;">
		     <div id="numberDisplay"> <input type="tel" name="numberDisplay" id="numberDisplaydata" style="margin-top: 12px;"></div>
			 <div id="dialpad" class="button-3">
			  <ul>
				<li class="first">1</li>
				<li>2</li>
				<li class="last">3</li>
				<li class="first">4</li>
				<li>5</li>
				<li class="last">6</li>
				<li class="first">7</li>
				<li>8</li>
				<li class="last">9</li>
				<li class="first">*</li>
				<li>0</li>
				<li class="last">#</li>
			  </ul>
			</div>
			<div id="actions" class="button-3 deactive">
			  <ul>
				<li href="" class="call ready" onclick="dailNumberDisplay()">Call</li>
				<li href="" class="clear ready">Clear</li>
				<li href="" class="skip" onclick="popupClose('call_form')">Close</li>
				<!--<li href="" class="skip" onclick="backComment()">Back</li>  -->
				
			  </ul>
			</div>		
		</div>
		
		<!-- start outgoing note -->
		
		<div class="callnote_section" style="display:none; margin-top: -13px;">
		   <div style="padding-top: 24px; padding-left: 13px;">
		        <span id="from_comment_respose" style="text-align: center; top: 44px; padding-left: 108px; position: absolute; display: none;">&nbsp;</span>
		   
		       <div style="padding-top: 8px;">
					<span class="lable">Comments</span> <span class="col">:</span> 
					<textarea name="Comments" type="text" class="textarea fontbox1" id="from_comments"></textarea>
			   </div>
		       <div style="margin-left: 114px;">
					<input type="button" class="button" onclick="popupClose('call_form')" value="Close">
					
					<input type="hidden" name="comments_type" id="comments_type" value="">
					<input type="hidden" name="comments_id" id="comments_id" value="">
					<span id="from_comment_button">
					<input type="button" class="button" value="Save" onclick="addComments('call_to')">
					</span>
					<span id="from_comment_loader" style="display:none;">
					<img src="../images/loading.gif">
					</span>
				</div>
		   </div>
		
		</div>
		
		<!--  start event   -->
		<div class="callevent_section" style="display:none; margin-top: -13px;">
		     	<div style="padding-top: 24px; padding-left: 13px;">
				<span id="callevent_respose" style="text-align: center; top: 41px; padding-left: 115px; position: absolute; display: none;">&nbsp;</span>
						<div style="margin-bottom: 5px;">
							<span class="lable">Activity Type</span> <span class="col">:</span> 
							<span class="fontbox">
							   <select name="activityType" class="inputbox fontbox1" id="activityType" >
							   <option value="">--- Select ---</option>
							   <option value="Call">Call</option>
							   <option value="Medium">Meeting</option>
							   <option value="Internal Game">Internal Game</option>
							   </select>
							</span>  
						</div>	
						
						<div style="margin-bottom: 5px;">
							<span class="lable" style="width: 97px;">Subject</span> <span class="col">:</span> 
							<span  class="fontbox">
							   <input type="text" class="inputbox fontbox1" style="width: 190px;" name="call_subject" id="call_subject">
							</span>  
						</div>
						<div style="margin-bottom: 5px;">
							<span class="lable">Start Date </span> <span class="col">:</span> 
							<span class="fontbox"><input type="text" class="inputbox fontbox1" style="width: 117px;" id="callfromevent_date" name="callfromevent_date" placeholder="Start Date"  readonly=""><input type="text" name="callfromevent_time" id="callfromevent_time" placeholder="Start Time" style="width: 66px; border-left: medium none;" class="inputbox fontbox1"> 
							</span>  
						</div>
						
						<div style="margin-bottom: 5px;">
							<span class="lable">End Date </span> <span class="col">:</span> 
							<span class="fontbox"><input type="text" class="inputbox fontbox1" style="width: 117px;" id="callendevent_date" name="callendevent_date" placeholder="Close Date" readonly=""><input type="text" name="callendevent_time" id="callendevent_time" style="width: 66px; border-left: medium none;" class="inputbox fontbox1" placeholder="Close Time"> 
							</span>  
						</div>
						
						
						<div style="margin-bottom: 5px;">
							<span class="lable">Priority </span> <span class="col">:</span> 
							<span class="fontbox">
							   <select name="call_priority" class="inputbox fontbox1" id="call_priority" >
							   <option value="">--- Select ---</option>
							   <option value="High">High</option>
							   <option value="Medium">Medium</option>
							   <option value="Low">Low</option>
							   </select>
							</span>  
						</div>	
						
					    <div style="margin-bottom: 5px; text-align: center; margin-left: -33px;">
						   <input type="button" class="button" onclick="popupClose('call_form')" value="Close">
						   <input type="button" onclick="addcallevent()" value="Add Event" class="button">
						</div>					
					
				</div>
		</div>
		
		
		
	</form>
</div>

<!--  call user incoming -->		  
<div id="incomingcall_form" style="display:none;margin-left: -11px; ">

<audio id="audiotag1" src="/erp/lib/linphone/humtum-plt4o1qm-7874-7884.mp3" preload="auto"></audio>
<form class ="form" name="call_form2">
       
		<div class="header_tab">
		<span class="header-tab-span active-call-tab" style="width:14%"><img onmouseout="hideddrivetip()" onmouseover="ddrivetip('Home', 40,'')" src="../images/call_home.png" title="Home" onclick="backComment()"></span>
		 <span class="header-tab-span" style="width:14%"><img onmouseout="hideddrivetip()" onmouseover="ddrivetip('Notes', 40,'')" src="../images/note.png"  title="Notes" onclick="callIncomingNote();"></span>
		<span style="width:14%" class="header-tab-span"><img onmouseout="hideddrivetip()"  onmouseover="ddrivetip('Hung up', 40,'')" src="../images/hungup.png"  title="Hung up" OnClick="onCallEnd()"></span>
		<span style="width:15%">
		<a href="javascript:void(0);" style="margin-top: 6px;" onclick="onCurrentCall()"><img border="0" onmouseout="hideddrivetip()" onmouseover="ddrivetip('Call', 40,'')" src="../images/Call.png" id="call_connect_button"></a></span>
		
		<span style="width:15%">
		<p id="incoming_timer"></p>
		</span>
		<span class="extra" style="width:15%"></span>
		</div>
	<!-- start incoming home -->
	<div class="incoming_call_home">
	<div class="from_address_call">
        <div style="padding-top: 11px;">
		<div style="margin-bottom: 5px;">
		<span class="lable">Name</span> <span class="col">:</span> 
		<span id="incoming_call_name" class="fontbox">
		   <span class="ajax-loader-call-name"><img src="../images/loading.gif">&nbsp;Loading...</span>
		</span>  
		</div>
		
		<div style="margin-bottom: 5px;">
		<span class="lable">Email</span> <span class="col">:</span>
		<span id="incoming_call_email" class="fontbox"> 
		  <span class="ajax-loader-call-name"><img src="../images/loading.gif">&nbsp;Loading...</span>
		</span>
		</div>
		</div>
	</div>
	
	   <div style="padding-bottom: 5px;"><span class="lable">&nbsp;</span> <span class="col">&nbsp;</span> <span class="statusC" style="font-size: 14px">No call</span></div>
		<div style="margin-left: 114px;">
		<input type="button" class="button" onclick="popupClose('incomingcall_form')" value="Close">
		</div>
	</div>
		
		<!-- start incoming note -->
		<div class="callnote_IncomingSection" style="display:none; margin-top: -13px;">
		   <div style="padding-top: 24px; padding-left: 13px;">
		        <span id="incoming_comment_respose" style="text-align: center; top: 44px; padding-left: 108px; position: absolute; display: none;">&nbsp;</span>
		   
		       <div style="padding-top: 8px;">
					<span class="lable">Comments</span> <span class="col">:</span> 
					<textarea name="incoming_comments" type="text" class="textarea fontbox1" id="incoming_comments"></textarea>
			   </div>
			<div style="margin-left: 114px;">
			<input type="button" class="button" onclick="popupClose('incomingcall_form')" value="Close">
			<input type="hidden" name="incoming_comments_type" id="incoming_comments_type" value="">
			<input type="hidden" name="incoming_comments_id" id="incoming_comments_id" value="">
			<span id="incoming_comment_button">
			<input type="button" class="button" value="Save" onclick="addComments('incoming_form')">
			</span>
			<span id="incoming_comment_loader" style="display:none;">
			<img src="../images/loading.gif">
			</span>
			</div>
		   </div>
		
		</div>
		
		
		
		
	</form>
</div>



<!--  connect user form -->
<div id="connect_form" style="display:none;">
	<form name="call_form1">
	<div class="cannect_call">
		<span class="lable">Username</span> <span class="col" style="">: </span>
		<input style="margin-left: 1px;" id="username" type="text" value="<?php if(isset($calldetail[0]->agent_id)){ echo  $calldetail[0]->agent_id; }  ?>" class="inputbox" readonly/>
	</div>
	
	<div class="cannect_call" style="display:none;">
		<span class="lable">Password</span> <span class="col">:</span> 
		<input id="password" type="password" value="<?php if(isset($calldetail[0]->password)){ echo $calldetail[0]->password; }  ?>" class="inputbox" readonly/>
	</div>
	
	<div class="cannect_call">
		<span class="lable">Server</span> <span class="col">:</span> 
		<input id="address" type="text" value="<?php if(isset($server_data[0]->server_ip)){ echo $server_data[0]->server_ip; }  ?>"  class="inputbox"/>
	</div>
	
	
	
	<div class="cannect_call">
		<span class="lable">&nbsp;</span> <span class="col">&nbsp;</span> 
		<span class="statusR">No Connection</span>
	</div>
	<div style="margin-left: 111px;">
		<input type="button" class="button" onclick="popupClose('connect_form')" value="Close">
		<input type="button" class="button" onclick="onRegistration('call_form1')" value="Connect">
	</div>
	</form>
</div>


<!--  start calling script -->	

 <script type="text/JavaScript">
 
		$(function() {
			$('#callfromevent_time').timepicker({ 'timeFormat': 'H:i:s' });
			$('#callendevent_time').timepicker({ 'timeFormat': 'H:i:s' });
		});
		
		
		$('#callfromevent_date').datepicker(
			{
			dateFormat: 'yy-mm-dd', 
			yearRange: '2013:<?=date("Y")?>', 
			changeMonth: true,
			changeYear: true
			}
		);
		
		$('#callendevent_date').datepicker(
			{
			dateFormat: 'yy-mm-dd', 
			yearRange: '2013:<?=date("Y")?>', 
			changeMonth: true,
			changeYear: true
			}
		);
 
 
 
 
   // for clcik tabing
      jQuery(document).ready(function(){		 
		  jQuery(".header_tab .header-tab-span").click(function(){
			  jQuery('.header-tab-span').removeClass('active-call-tab');
			   jQuery(this).addClass("active-call-tab");
		  });
	  });
 
 
 
		$(window).load(function() {
		load();
		});

		// start global variable 
		var IncomingNum;
		var IncomingNumSub;
		var server = '<?php if(isset($server_data[0]->server_ip)){ echo $server_data[0]->server_ip; }  ?>';
		var agentId  =  '<?php if(isset($calldetail[0]->agent_id)){ echo  $calldetail[0]->agent_id; }  ?>';
		var IncomingNum_1 = "SIP:UNKNOWN@"+server;
		var IncomingNum_2 = "SIP:"+agentId+"@"+server;
        // end global variable 
		
		function dailNumberDisplay(){
			 var dailnum =  $("#numberDisplaydata").val();
			 if(dailnum!=""){
			   var dial = "sip:"+dailnum+"@"+server;
			// var dial = dailnum;
			 
			 call(dial);
			 }
         }

 /* Main function https://github.com/dometec/test-linphone-web/blob/master/plugin.html*/
    function load(){
	//alert("test");
      var config = getConfig();
      var browserDetection;
      var core;
      
      navigator.plugins.refresh(false);
      
      /* Detection of the system information : OS/Architecture/Browser */
      browserDetection = browserDetect();
     // updateStatus('browser',"OS : " + browserDetection.os + " / Browser : " + browserDetection.browser );
      // Find the correct plugin file
      setPluginLink(config,browserDetection);
      core = getCore();
      // Detection of the plugin
      var ret = detect(config, core);
      
      if(ret === 0){ // The plugin is not installed or outdated
        //updateStatus('plugin',"Plugin : Not installed or outdated");
        // Donwload the plugin
       // window.open(config.file.description, '_self'); 
        $(".connect_server").html('<span style="font-size:12px;color:#FF0000">Phone plugin is either outdated or not installed. Please download it by <a href="https://web.linphone.org/" target="_blank" style="font-size:12px;color:#000">clicking here</a>. We preferred to use Firefox or Internet Explorer.</span>');	
	  } else { // The plugin is installed
    	    loadCore();
    	    //updateStatus('plugin',"Plugin : Installed (" + core.pluginVersion + ")");
			setTimeout(function(){
			onRegistration(call_form1);
			$('#ajax-loader-call-connect').hide();
			}, 2000);
		  
      }
    }

		
		
		
 function connect(){
	 var opt = {
		closeOnEscape: false,
        autoOpen: false,
        modal: true,
        width: 415,
        height:275,
		my: "center",
        at: "center",
        of: window
       };
	var divID =  "#connect_form";
	$(divID).dialog(opt).dialog("open");
	$(divID).show();
	
 }
 

 
 
  function onUnregistration() {
    	  var core = getCore();
    	  core.clearProxyConfig();
		  $("#connect_call").fadeOut();
      }


   function call_connect(formID,type) {
	   
	        
		     var call_num = $("#call").val();
			 if(call_num=="" && type=='to'){
			   alert("Please enter number");
			    return false;
		     }
			 
			 var call_code = $('#call_id').val();
			 var call_prefix = $('#call_id option:selected').attr('prefixcode');	 
			 if(call_code==0){
				var num  =  call_num;	 
			 }else{
				var num  = call_code+call_num;	 
			 }
	
		if(type=="from"){
		 num = IncomingNumber;
		 type = 'from';
		 getContactDetails(IncomingNumberSub,type); 
		}
   
	var opt = {
		closeOnEscape: false,
        autoOpen: false,
        modal: true,
        width: 415,
        height:350,
        title: "Call"+" "+type+" "+num
       };
	     
	  var divID =  "#"+formID;
	 $(divID).dialog(opt).dialog("open");
	 $(divID).show();
	if(type=="to"){
		onCall();
	}
	
}

function popupClose(closeID){
	var num  =  $("#call").val();
	var divID =  "#"+closeID;
	$("#comments").val('');
	$(divID).dialog('close');
	// reset tab 
	backComment();
    $('.header-tab-span').removeClass('active-call-tab');
    $('.header_tab > span:nth-child(1)').addClass("active-call-tab");
	
	
	
	// disconnect call if user click on the connect button
  	  onCallEnd();
      if(closeID=="call_form"){
	  $("#call_name").html('<span class="ajax-loader-call-name"><img src="../images/loading.gif">&nbsp;Loading...</span>');
	  $("#call_email").html('<span class="ajax-loader-call-name"><img src="../images/loading.gif">&nbsp;Loading...</span>');
	  $('#from_comments').val('');
      $('#from_comment_respose').html('');
      $('#from_comment_respose').html('');
	  StopTimer();
	  }else{
	  $("#incoming_call_name").html('<span class="ajax-loader-call-name"><img src="../images/loading.gif">&nbsp;Loading...</span>');
	  $("#incoming_call_email").html('<span class="ajax-loader-call-name"><img src="../images/loading.gif">&nbsp;Loading...</span>');  
	  }
}


 
 
    	/* return the core object */
        function getCore(){
            return document.getElementById('core');
        }
        
        /* Registration */
        function registration(username,password,server){
        	 
			  var core = getCore();			
						/*create proxy config*/        	
						var proxy = core.newProxyConfig();
						
						/*create authentication structure from identity*/
						var authinfo = core.newAuthInfo(username, null,password,null,null);
						
						/*add authentication info to LinphoneCore*/
						
						core.addAuthInfo(authinfo);
						
						/*configure proxy entries*/
						proxy.identity = 'sip:'+username+'@'+server; /*set identity with user name and domain*/
						proxy.serverAddr = 'sip:'+server; /* we assume domain = proxy server address*/
						proxy.registerEnabled = 3600; /*activate registration for this proxy config*/
						core.addProxyConfig(proxy); /*add proxy config to linphone core*/
						core.defaultProxy = proxy; /*set to default proxy*/
						$('#ajax-loader-call-connect').hide();
			
        }
        /* Basic call */
        function call(addressStr){
			
			console.log("Call: " + addressStr);
        	var core = getCore();
        	
        	/*Create a new address with the paramaters*/
			var address = core.newAddress(addressStr);
			if(address !== null) {
				/* Start the call with the contact address*/
				core.inviteAddress(address);
				
			}
        }
	       
		   
		function loadCore(){
			var core = getCore();
			core.init();
				
	       // Add callback for registration and call state 
	        addEvent(core,"callStateChanged",onCallStateChanged);
	        addEvent(core,"registrationStateChanged",onRegistrationStateChanged);
	           
	       // Display logs information in the console 
	        core.logHandler = function(level, message) {
				
				var  sHTML = $.parseHTML( message );
				var sName;
				$.each(sHTML, function (i, el) { 
				sName = el.nodeName;
				});
				 if(sName=='#text' || sName==IncomingNum_1 || sName==IncomingNum_2){
                 }else{
				  var getIncomingNumber = 	sName.split('SIP:');
				  var IncomNumber = getIncomingNumber[1].split('@');
				     IncomingNumber = IncomNumber[0];
					 IncomingNumberSub = IncomNumber[0].substr(IncomNumber[0].length - 10);
					 
					 
					
				 }
				
	        }
		
			
	        /* Start main loop for receiving notifications and doing background linphonecore work */
	        core.iterateEnabled = true;
		}
	        
		/* Callback that display call states */
		function onCallStateChanged(event, call, state, message){
		
			var core = getCore();
			updateStatus('statusC',message);
			if(message=="Incoming call"){
				
				
			 //var addressfrom = core.newAddress();
				//console.log("Pankaj: " + addressfrom.getDomain()); 
				play_single_sound('incoming');
				$("#call_connect_button").show();
				$("#incoming_timer").html('00:00');
				 count=0;
				 min = 0;
				 hr = 0; 
				 call_connect('incomingcall_form','from');
			     updateStatus('statusC','Incoming call...');
			}
			else if(message=="Remote ringing"){
				$("#outgoing_timer").html('00:00');
				 count=0;
				 min = 0;
				 hr = 0;
			   play_single_sound('outgoing'); 
			   updateStatus('statusC','Connecting...');
			   
			}
			else if(message=="Connected (streams running)"){
			    start('incoming_timer');  // start timer
				updateStatus('statusC','Connected');
			}
			else if(message=="Streams running"){
			    start('outgoing_timer');  // start timer
				updateStatus('statusC','Connected');
			}else if(message=="Call released"){
				StopTimer();  // stop timer
				stop_single_sound('incoming');
				stop_single_sound('outgoing');
				updateStatus('statusC','Call Disconnect');
			}else if(message=="Call paused"){
				// call paused
				//console.log(event);
			
			}else if(message=="Pausing call"){
				// call paused
			}else if(message=="Early media"){
				
				updateStatus('statusC','Connecting...');
			}else if(message=="Remote ringing"){
				
				updateStatus('statusC','Conecting...');
			}else if(message=="Outgoing call in progress"){
				updateStatus('statusC','Connecting...');
			}else{
				StopTimer();  // stop timer	
				stop_single_sound('incoming');
				stop_single_sound('outgoing');
			}
			

		}
		function onRegistrationStateChanged(event, proxy, state, message){
		    
			if(message=="Registration successful"){
               updateStatus('statusR','Connected successful');
               $(".connect_server").hide();
               $("#connect_call").show();
			        var  UserID  = '<?php if(isset($calldetail[0]->id)){ echo $calldetail[0]->id; }  ?>';	
					var password = document.call_form1.password.value;
					$.ajax({
					    url:'ajax.php',
					    type:'GET',
						data:{
						CallUserId:UserID,Password:password,
						action:'CallCredential'
						},
					
					beforeSend:function(){
					//$('#ajax-loader-call').show();
				},success:function(data){
				            	
					}
					});
                   updateStatus('statusR','Connected successful');
			   
             }else{
               updateStatus('statusR',message);
			    $(".connect_server").show();
             }			 
        }
        
        /* Handler function */
        function onRegistration(call_form1){
			registration(document.call_form1.username.value,document.call_form1.password.value,document.call_form1.address.value);
		}
		
		function onCall(){
		     var server = '<?php if(isset($server_data[0]->server_ip)){ echo $server_data[0]->server_ip; }  ?>';
			 var call_num = $("#call").val();
			// var num = call_num.replace("-", "");
			
			 var call_code = $('#call_id').val();
			 var call_prefix = $('#call_id option:selected').attr('prefixcode');	 

			 if(call_code==0){
				var phoneNum ="sip:"+call_num+"@"+server; 	 
			 }else{
				var phoneNum ="sip:"+call_prefix+call_num+"@"+server; 
				
			 }
			 if(server==""){
			   alert("Please enter server address");
				return false;
			 }
			 call(phoneNum);
	         getContactDetails($("#call").val(),'to'); 
		}
		
		function onCallEnd(){
			var core = getCore();
			if(core.currentCall){
        	 core.terminateCall(core.currentCall);
			 updateStatus('statusC', 'Call Terminate');
			  backComment();
			}	
		}
	
	function play_single_sound(type) {
		if(type=="incoming"){
		//document.getElementById('audiotag1').play();
		}else{
		// document.getElementById('audiotag2').play();		
		}
	}
	
	
	function stop_single_sound(type){
		if(type=="incoming"){
	   document.getElementById('audiotag1').pause();
		}else{
	   document.getElementById('audiotag2').pause();	
		}
	}
	
	function onCurrentCall(){
	       var core = getCore();
		  if(core.currentCall){
	       var num = core.acceptCall(core.currentCall);
		   console.log('number: ' + core.acceptCall(core.currentCall));
		   
		
		   $("#call_connect_button").hide();
		   core.setPlayLevel(100);
		   core.getPlayLevel(100);
	       
		  }
	}
	
	function MicMuted(){
		  var core = getCore();
          core.pauseCall(core.currentCall);
		
	}
	
	
	function pauseCallUser(type_id){
		    var core = getCore();
			core.init();
		   if(core.currentCall){
           core.pauseCall(core.currentCall);
		    var pauseID = "#"+type_id+"_pause";
		    var resumeID = "#"+type_id+"_resume";
				$(pauseID).hide();
				$(resumeID).show();
		   }
	}
	
	function resume() {
			alert('working..');
          var core = getCore();
		  console.log("pankaj:"+core.config);
          core.resumeCall();
        }
	
	/*
	function resume(type_id){
		    var core = getCore();
		       core.init();
			   
		   if(core.pauseCall){
		    
			 core.resumeCall(Resume.s.ocall);
		    var pauseID = "#"+type_id+"_pause";
		    var resumeID = "#"+type_id+"_resume";
			
			$(resumeID).hide();
		    $(pauseID).show();
		   
		   }
	}
	
	*/
	

    </script> 
	
<!--  end calling script -->	

<!--  start timer  -->
<script>
var count=0;
var min = 0;
var hr = 0; 
counter = 0;

function start(type){  
   counter =  setInterval(function(){ timer(type); }, 1000);
}

function timer(type)
{
  count=count+1;
  if(count==60) {
         min=min+1;
         count = 0;
          if(min==60){
		      hr=hr+1;
		       min = 0;
		}
   }
    
       if(hr>0){
            document.getElementById(type).innerHTML= leftPad(hr,2) + ":" + leftPad(min,2) + ":" + leftPad(count,2);
        }else{
		   document.getElementById(type).innerHTML= leftPad(min,2)+":"+leftPad(count,2); 
		}
		
		return;
  }

function StopTimer()
{
  clearInterval(counter);
  
}

function leftPad(number, targetLength) {
    var output = number + '';
    while (output.length < targetLength) {
        output = '0' + output;
    }
    return output;
}

/* end  start timer */
</script>

<script>



function addCountryCodeInEmployee(id){
	var country_id = id.value;
	jQuery.ajax({
				url:'ajax.php',
				type:'GET',
				data:{country_id:country_id,action:'addCountryCode'},
				beforeSend:function(){
				},success:function(data){
					if(data==1){
					}else{
					}
				}
		});
	
	
}

function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
	
	if(charCode == 08  || charCode == 127){
		return true;
	}
	
	/*
    var numbers = 	$("#call").val();
	var num;
         var n = numbers.length;
		  if(n==3){
			  num = numbers+ "-";
			  $("#call").val(num);
		   }
		   
		  if(n==7){
			  
			 num = numbers+ "-"; 
			 $("#call").val(num);
		  } 
	   
	   */
	
    return true;
}

function formatPhone(obj) {
    var numbers = obj.value.replace(/\D/g, ''),
        char = {0:'',3:' - ',6:' - '};
    obj.value = '';
    for (var i = 0; i < numbers.length; i++) {
        obj.value += (char[i]||'') + numbers[i];
    }
}

 function addComments(call_type){
	 
	 // call_to is outgoing call 
	    if(call_type=="call_to"){
			
			     var comments_type =  $('#comments_type').val();
			     var comments_id = $('#comments_id').val();
			     var from_comments = $('#from_comments').val();
				 
				jQuery.ajax({
				url:'ajax.php',
				type:'POST',
				data:{comments_type:comments_type,comments_id:comments_id,from_comments:from_comments,action:'addComments'},
				beforeSend:function(){
				$('#from_comment_button').hide();
				$('#from_comment_loader').show();
				},success:function(data){
					if(data==1){
					$('#from_comments').val('');	
					$('#from_comment_button').show();
				    $('#from_comment_loader').hide();
				    $('#from_comment_respose').show();
					$('#from_comment_respose').html('<span style="color: steelblue;font-size:12px"> Comment added successfully!</span>')
                    $("#from_comment_respose").fadeOut(3000);
					
					}else{
					}
				}
				});	 
		}  else {
			
	 var comments_type =  $('#incoming_comments_type').val();
	 var comments_id = $('#incoming_comments_id').val();
	 var from_comments = $('#incoming_comments').val();
	 
	jQuery.ajax({
	url:'ajax.php',
	type:'POST',
	data:{comments_type:comments_type,comments_id:comments_id,from_comments:from_comments,action:'addComments'},
	beforeSend:function(){
	$('#incoming_comment_button').hide();
	$('#incoming_comment_loader').show();
	},success:function(data){
		if(data==1){
		$('#incoming_comments').val('');	
		$('#incoming_comment_respose').show();
		$('#incoming_comment_button').show();
		$('#incoming_comment_loader').hide();
		$('#incoming_comment_respose').html('<span style="color: steelblue;font-size:12px"> Comment added successfully!</span>');
		$('#incoming_comment_respose').fadeOut(3000);
		}else{
		}
	}
	});	 
			
			
			
			
		}
  }


  function addcallevent(){
	  
	   var activityType =  $("#activityType").val();
	    var call_subject =  $("#call_subject").val();
	    var callfromevent_date =  $("#callfromevent_date").val();
	    var callfromevent_time =  $("#callfromevent_time").val();
	    var callendevent_date =  $("#callendevent_date").val();
	    var callendevent_time =  $("#callendevent_time").val();
	    var call_priority =  $("#call_priority").val();
	   
	  
	    if(call_subject==""  || call_priority=="" || activityType==""){
			$('#callevent_respose').html('<span style="color: steelblue;font-size:12px"> Please fill all required field.</span>');
			$('#callevent_respose').show();
			$('#callevent_respose').fadeOut(3000);
			return false;
			
		}
	  
	  
		jQuery.ajax({
			url:'ajax.php',
			type:'GET',
			data:{subject:call_subject,startDate:callfromevent_date,startTime:callfromevent_time,closeDate:callendevent_date,closeTime:callendevent_time,priority:call_priority,activityType:activityType, action:'addCallEvent'},
			beforeSend:function(){
			$('#callevent_respose').html('<span style="color: steelblue;font-size:12px"> Please wait...</span>');
			$('#callevent_respose').show();
			//$('#callevent_respose').fadeOut(3000);
			},success:function(data){
			if(data==1){
             $("#call_subject").val('');
	         $("#callfromevent_date").val('');
	         $("#callfromevent_time").val('');
	         $("#callendevent_date").val('');
	         $("#callendevent_time").val('');
	         $("#call_priority").val('');	
			 $("#activityType").val('');

			$('#callevent_respose').html('<span style="color: steelblue;font-size:12px"> Event added successfully!</span>');
			$('#callevent_respose').show();
			$('#callevent_respose').fadeOut(3000);
			}
			}
		});
	  
  }

  function getContactDetails(num,call_type){
	  
		jQuery.ajax({
			url:'ajax.php',
			type:'GET',
			data:{phone:num,action:'ContactDetail'},
			beforeSend:function(){
			//$('#ajax-loader-call').show();
			},success:function(data){
				
				if(call_type=='to'){
						 if(data==0){
								$('.ajax-loader-call-name').hide(); 
								$('#call_name').html('--');
								$('#call_email').html('--');
								$('.from_address_call').hide();	
								$('#comments_type').val('');
								$('#comments_id').val('');
							 
						  }else{
							  $('.ajax-loader-call-name').hide(); 
							  $('.from_address_call').show();				  
							  var contactdata =	$.parseJSON(data);
							  var call_name_data =  contactdata.Name+" ("+contactdata.Type+")";
							  $('#comments_type').val(contactdata.Type);
							  $('#comments_id').val(contactdata.ID);
							  $('#call_name').html(call_name_data);
							  $('#call_email').html(contactdata.Email);
						 }
			 }else{
				
				       if(data==0){
								$('.ajax-loader-call-name').hide(); 
								$('#incoming_call_name').html('--');
								$('#incoming_call_email').html('--');
								$('.from_address_call').hide();	
								$('#incoming_comments_type').val('');
								$('#incoming_comments_id').val('');
							 
						  }else{
							  $('.ajax-loader-call-name').hide(); 
							  $('.from_address_call').show();				  
							  var contactdata =	$.parseJSON(data);
							  var call_name_data =  contactdata.Name+" ("+contactdata.Type+")";
							  $('#incoming_comments_type').val(contactdata.Type);
							  $('#incoming_comments_id').val(contactdata.ID);
							  $('#incoming_call_name').html(call_name_data);
							  $('#incoming_call_email').html(contactdata.Email);
						 }
			 }
				 
				 
			}
		});	  
	
  }

  function CallFormSubmit(obj){
		if(jQuery(obj).val()!=''){
			GetCallResponce(jQuery(obj).val());
		}else{
			$('.callrow .call-detail').html('');
			$('.callrow .chart').html('');
			
			}
	  }

	function GetCallResponce(empid){

	var fromdate =  $("#fromCall").val();
	var todate =    $("#toCall").val();

	var request=jQuery.ajax({
	url:'ajax.php',
	type:'GET',
	data:{
	empId:empid, fromdate:fromdate, todate:todate, AdminType:'user',
	action:'calldetail'
	},beforeSend:function(){
		$('#ajax-loader-call').show();
		},success:function(data){
		var jsonobj =	$.parseJSON(data );
		var bwidth=$('.callrow .bgwhite').width();

		if(!$('.callrow .bgwhite').hasClass('active')){
			$('.callrow .bgwhite .quota-emp').css({'width':bwidth,'float':'left'});
			$('.callrow .call-detail').html(jsonobj.quota);

			$('.callrow .chart').html(jsonobj.chart);

		}

		$('#ajax-loader-call').hide();
		}
		});
	}
  </script>	
  
<script>




function ondialer(){
$(".comment_section").hide();
$(".callevent_section").hide();
$(".callnote_section").hide();
$(".dailer_section").show();


}

function backComment(){
	$(".dailer_section").hide();
	$(".callevent_section").hide();
	$(".callnote_section").hide();
	$(".comment_section").show();
	
	$(".callnote_IncomingSection").hide();
	$(".incoming_call_home").show();
	

}

function callevent(){
	$(".dailer_section").hide();
	$(".comment_section").hide();
	$(".callnote_section").hide();
	$(".callevent_section").show();
}

function callnote(){
	$(".dailer_section").hide();
	$(".comment_section").hide();
	$(".callevent_section").hide();
	$(".callnote_section").show();
	
	
}

function callIncomingNote(){
	$(".incoming_call_home").hide();
	$(".callnote_IncomingSection").show();
	
}

(function ($){
  window.numberArray = [],
  window.phoneNumber = '',
  window.updateDisplay,
  window.numberDisplayEl,
  window.inCallModeActive,
  window.dialpadButton = $('div#dialpad li'),
  window.dialpadCase = $('div#dialpad'),
  window.clearButton = $('#actions .clear'),
  window.callButton = $('#actions .call'),
  window.actionButtons = $('#actions'),
  window.skipButton = $('#actions .skip'),
  window.numberDisplayEl = $('#numberDisplay input');

  function compilePhoneNumber(numberArray){
    if (window.numberArray.length > 1){ 
      window.phoneNumber = window.numberArray.join('');
    } else {
      window.phoneNumber = window.numberArray
    }
    return this.phoneNumber;
  };

  function updateDisplay(phoneNumber){
    window.numberDisplayEl.val(window.phoneNumber);
  };

  function clearPhoneNumber(){
    window.numberDisplayEl.val('');
    window.phoneNumber = '';
    window.numberArray = [];
  };

  function callNumber(){
    //window.numberDisplayEl.val('Calling...');
   // activateInCallInterface();
    // Need timer interval to animate . . .
    // Trigger  "Hangup"
    // Trigger  "Call timer"
  };

  function holdNumber(){
   // window.numberDisplayEl.val('On Hold.');
   // changeHoldIntoUnhold();
  };

  function changeHoldIntoUnhold(){
    //window.skipButton.html('Unhold');
   /// window.skipButton.addClass('ready');
  };

  function changeUnholdIntoHold(){
    //window.skipButton.html('Hold');
  };

  function activateInCallInterface(){
    changeClearIntoHangUp();
    changeSkipIntoHold();
    disableCallButton();
    disableDialButton();
    removeReadyFromCall();
    enableReadOnlyInput();
    window.inCallModeActive = true;
  };

  function disableInCallInterface(){
    removeReadOnlyInput();
    enableCallButton();
    changeHoldIntoSkip();
    window.inCallModeActive = false;
  }

  function disableCallButton(){
    //window.callButton.addClass('deactive');
  };

  function enableCallButton(){
    //window.callButton.removeClass('deactive');
  };

  function enableDialButton(){
   // window.dialpadCase.removeClass('deactive');
  };

  function disableDialButton(){
   // window.dialpadCase.addClass('deactive');
  };

  function changeSkipIntoHold(){
   // window.skipButton.html('Hold');
  };

  function changeHoldIntoSkip(){
    //window.skipButton.html('Skip');
  };

  function changeClearIntoHangUp(){
   // window.clearButton.html('Hang Up');
    //window.clearButton.addClass('hangup');
  };

  function changeHangUpIntoClear(){
    if( window.clearButton.html('Hang Up') ){
      window.clearButton.html('Clear');
      window.clearButton.removeClass('hangup');
    }
  };

  function enableReadOnlyInput(){
    window.numberDisplayEl.attr('readonly','readonly');
  }

  function removeReadOnlyInput(){
    window.numberDisplayEl.removeAttr('readonly');
  }

  function refreshInputArray(){
    this.numberDisplayElContent = window.numberDisplayEl.val(); 
    window.numberArray = this.numberDisplayElContent.split('');
  };

  window.dialpadButton.click(function(){
    if( !$(dialpadCase).hasClass('deactive') ){
      var content = $(this).html();
      refreshInputArray();
      window.numberArray.push(content);
      compilePhoneNumber();
      updateDisplay();
      checkDisplayEl();
      saveNumberDisplayEl();
    }
  });

  window.skipButton.click(function(){
    if (window.inCallModeActive == true){
      holdNumber();
    }
  });

  function checkDisplayEl(){
    if( window.numberDisplayEl.val() != "" ){
      addReadyToClear();
      addReadyToCall();
      enableActionButtons();
    } else if ( window.numberDisplayEl.val() == "" ) {
      removeReadyFromClear();
      removeReadyFromCall();
      disableActionButtons();
    }
  }

  function disableActionButtons(){
    window.actionButtons.addClass('deactive');
  }

  function enableActionButtons(){
    window.actionButtons.removeClass('deactive');
  }

  function addReadyToCall(){
    window.callButton.addClass('ready');
  }

  function removeReadyFromCall(){
    window.callButton.removeClass('ready');
  }

  function addReadyToClear(){
    window.clearButton.addClass('ready');
  }

  function removeReadyFromClear(){
    window.clearButton.removeClass('ready');
  }

  function saveNumberDisplayEl(){
    lastNumberDisplayEl = window.numberDisplayEl.val()
  }

  function displayLastSavedNumberDisplayEl(){
    console.log('Last displayed element value: ' + lastNumberDisplayEl);
  }

  $('div#actions li.clear').click(function(){
    //enableCallButton();
    enableDialButton();
    clearPhoneNumber();
    removeReadOnlyInput();
    changeHangUpIntoClear();
    updateDisplay();
    checkDisplayEl();
    disableInCallInterface();
  });

  $('div#actions li.call').click(function(){
    callNumber();
  });

})(jQuery);
</script>  
  
