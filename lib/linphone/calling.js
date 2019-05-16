// for click tabing
      jQuery(document).ready(function(){
		  jQuery(".header_tab .header-tab-span").click(function(){
			  jQuery('.header-tab-span').removeClass('active-call-tab');
			   jQuery(this).addClass("active-call-tab");
		  });
	  });



$(window).load(function() {
	load();
});

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
       // $(".connect_server").html('<span style="font-size:12px;color:#FF0000">Phone plugin is either outdated or not installed. Please download it by <a href="https://web.linphone.org/" target="_blank" style="font-size:12px;color:#000">clicking here</a>. We preferred to use Firefox or Internet Explorer.</span>');	
	  } else { // The plugin is installed
    	    loadCore();
    	    //updateStatus('plugin',"Plugin : Installed (" + core.pluginVersion + ")");
			setTimeout(function(){
			onRegistration(form_connect);
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
height:235,
title: "Connect to call server"
};
var divID =  "#connect_form";
$(divID).dialog(opt).dialog("open");
$(divID).show();
}

function call_connect(formID, type,  callNo, Cust_id, country_code, country_prefix, commentstype) {

 var call_num = callNo;

 //  set value
 $('#outgoing_timer').html('00:00');
  $("#comments_id").val(Cust_id);
  $("#comments_type").val(commentstype);
  
  
// call_num = call_num.replace("-", "");
 
 
 if(call_num=="" && type=='to'){
   alert("Please enter number");
	return false;

 }
 
 var call_code = country_code;
 //var call_prefix = $('#call_id option:selected').attr('prefixcode');	 
   
 
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
height:320,
title: "Call"+" "+type+" "+num
};


var divID =  "#"+formID;
$(divID).dialog(opt).dialog("open");
$(divID).show();
if(type=="to"){
onCall(callNo, country_code, country_prefix);
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
var core = getCore();

/*Create a new address with the paramaters*/
var address = core.newAddress(addressStr);
if(address !== null) {
	/* Start the call with the contact address*/
	core.inviteAddress(address);
	console.log("Call: " + address.asString());

}
}

function loadCore(){
var core = getCore();
core.init();
	
/* Add callback for registration and call state */
addEvent(core,"callStateChanged",onCallStateChanged);
addEvent(core,"registrationStateChanged",onRegistrationStateChanged);
   
/* Display logs information in the console */
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
}




else{
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
   $(".call_icon").show();
   
		var  UserID  = document.form_connect.username.value;	
		var password = document.form_connect.password.value;
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

//console.log(message);
}

/* Handler function */
function onRegistration(form_connect){

 //alert(document.form_connect.username.value);
  //alert(document.form_connect.password.value);
  //alert(document.form_connect.address.value);
registration(document.form_connect.username.value,document.form_connect.password.value,document.form_connect.address.value);
}

function onCall(dailnum, country_code, country_prefix){

 //var call_num = $("#call").val();
// var num = call_num.replace("-", "");

 var call_code = country_code;	 
   
 
 if(call_code==0){
	var phoneNum ="sip:"+dailnum+"@"+server; 	 
 }else{
	 
	var phoneNum ="sip:"+country_prefix+dailnum+"@"+server; 
	
 }
 
 //console.log(phoneNum);
 
 if(server==""){
   alert("Please enter server address");
	return false;
 }
 
 call(phoneNum);
 //core.setPlayLevel(100);
 //core.getPlayLevel(100);
 //getContactDetails($("#call").val()); 
}

function onCallEnd(){
var core = getCore();
if(core.currentCall){
 core.terminateCall(core.currentCall);
 updateStatus('statusC', 'Call Terminate');

}

}

function play_single_sound(type) {
if(type=="incoming"){
document.getElementById('audiotag1').play();
}else{
document.getElementById('audiotag2').play();		
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
//console.log('number: ' + core.acceptCall(core.currentCall));
$("#call_connect_button").hide();
core.setPlayLevel(100);
core.getPlayLevel(100);

}


}

function MicMuted(){

// var core = getCore();
//	core.init();
// core.micEnabled(true);

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




<!--  end calling script -->	



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



function addCountryCodeInEmployee(id){
var country_id = id.value;
jQuery.ajax({
	url:'ajax.php',
	type:'GET',
	data:{country_id:country_id,action:'addCountryCode'},
	beforeSend:function(){
	//$('#from_comment_button').hide();
	//$('#from_comment_loader').show();
	},success:function(data){
		if(data==1){
		//$('#from_comment_button').show();
	   // $('#from_comment_loader').hide();
		//$('#from_comment_respose').html('<span style="color: steelblue;font-size:12px"> Comment added successfully!</span>') 
		}else{
		//$('.ajax-loader-call-name').hide(); 	 
		//var contactdata =	$.parseJSON(data);
		//var call_name_data =  contactdata.Name+" ("+contactdata.Type+")";

		//$('#comments_type').val(contactdata.Type);
		//$('#comments_id').val(contactdata.ID);
		//$('#call_name').html(call_name_data);
		//$('#call_email').html(contactdata.Email);
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


