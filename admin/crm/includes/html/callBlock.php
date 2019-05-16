<?php

	/* -- start call -- */
	require_once($Prefix."classes/dbfunction.class.php");
	require_once($Prefix."classes/phone.class.php");
    $objphone = new phone();
	
	 $getcallsetting=$objphone->GetcallSetting();



if(!empty($getcallsetting[0]->server_id)){ //start server id



	 $calldetail = $objphone->getCallUserDetail($getcallsetting[0]->server_id, $_SESSION['AdminID'],$_SESSION['AdminType']);
	 $server_data=$objphone->getServerUrl($getcallsetting[0]->server_id);
	 
	$CountryCodePrx  = $objphone->CountryCodePrxbyEmp($_SESSION['AdminID']);
	if(count($CountryCodePrx)>0){
		$country_code =   $CountryCodePrx[0]->isd_code;
		$country_prefix = $CountryCodePrx[0]->isd_prefix;
	}else{
		$country_code =  0;
		$country_prefix = 0;
	}
	/* -- end call -- */



?>

<!-- start calling -->
<object id="core" type="application/x-linphone-web" width="0" height="0">
<param name="onload" value='loadCore'>
</object>

<script type="text/javascript" src="<?php  echo $Config['Url']; ?>/lib/linphone/utils.js"></script>
<script type="text/javascript" src="<?php echo $Config['Url']; ?>/lib/linphone/calling.js"></script>
<link rel="stylesheet" href="<?php echo $Config['Url']; ?>/lib/linphone/calling.css">


<!--  call user form -->		  
<div id="call_form" class="callform" style="display:none;max-height: none; min-height: 0px;">
<form class ="form" name="call_form2">
      <audio id="audiotag2" src="/erp/lib/linphone/tring_tring_tring.mp3" preload="auto"></audio>
       
		<div class="header_tab">

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
					<div style="padding-bottom: 5px;"><span class="lable"> &nbsp;</span> <span class="col">&nbsp;</span> <span class="statusC" style="font-size: 14px">No call</span></div>
					<div style="margin-left: 114px;">
					<input type="button" class="button" onclick="popupClose('call_form')" value="Close">
					
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
				
			  </ul>
			</div>		
		</div>
		
		<!-- start note -->
		
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
	<form name="form_connect">
	<div class="cannect_call">
		<span class="lable">Username</span> <span class="col" style="">: </span>
		<input style="margin-left: 1px;" id="username" type="text" value="<?php if(isset($calldetail[0]->agent_id)){ echo  $calldetail[0]->agent_id; } ?>" class="inputbox"/>
	</div>
	
	<div class="cannect_call">
		<span class="lable">Password</span> <span class="col">:</span> 
		<input id="password" type="password" value="<?php if(isset($calldetail[0]->password)){ echo  $calldetail[0]->password;} ?>" class="inputbox"/>
	</div>
	
	<div class="cannect_call">
		<span class="lable">Server</span> <span class="col">:</span> 
		<input id="address" type="text" value="<?php if(isset($calldetail[0]->server_ip)){  echo $server_data[0]->server_ip; } ?>"  class="inputbox"/>
	</div>
	
	<div class="cannect_call">
		<span class="lable">&nbsp;</span> <span class="col">&nbsp;</span> 
		<span class="statusR">No Connection</span>
	</div>
	<div style="margin-left: 111px;">
		<input type="button" class="button" onclick="popupClose('connect_form')" value="Close">
		<input type="button" class="button" onclick="onRegistration('form_connect')" value="Connect">
	</div>
	</form>
</div>
<!-- end calling -->

<script>

// start event calender
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

// end event calender




// start global variable 
var IncomingNum;
var IncomingNumberSub
var server = '<?php if(isset($server_data[0]->server_ip)){ echo $server_data[0]->server_ip; }  ?>';
var agentId  =  '<?php if(isset($calldetail[0]->agent_id)){ echo  $calldetail[0]->agent_id; }  ?>';
var IncomingNum_1 = "SIP:UNKNOWN@"+server;
var IncomingNum_2 = "SIP:"+agentId+"@"+server;
// end global variable 

function dailNumberDisplay(){
var dailnum =  $("#numberDisplaydata").val();
var server = '<?php if(isset($server_data[0]->server_ip)){ echo $server_data[0]->server_ip; }  ?>';
if(dailnum!=""){
var dial = "sip:"+dailnum+"@"+server;
call(dial);
}

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
<? } //end server id?>
