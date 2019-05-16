jQuery(document).ready(function(){
var socket 			=	 io.connect();
var companykey		=	getCompanycode();
var  identity		= 	{};
var  config			= 	{};
var  host			= 	'localhost';
identity.cookies	=	false;
identity.companykey	=	companykey;
identity.host		=	host;
identity.browser	= getBrowserProperty();
var parentUrl		= document.referrer;
var serverurl		='http://207.201.237.18:3000/';
var supportext		=['xls','pdf','xlsx','doc','docx'];
/**********************************************************/
var loginName	=	jQuery('.login-name');
var loginEmail	=	jQuery('.login-email');
var loginbutton	=	jQuery('.login-btn');
var footer		=	jQuery('footer');
var RefId		=	jQuery('.refid');
var UserId		=	jQuery('.userid');
var RoomId		=	jQuery('.roomid');
var Textarea	=	jQuery('.message-box');
var ChatBox		=	jQuery('.chats');
var ChatView	= 	jQuery('.chat-view');
var ChatViewUl	= 	jQuery('.chat-view ul.chats');
var AgentName	= 	jQuery('.agent-name');
/**********************************************************/
jQuery('.ticket-box').abValidate();
/**********************************************************/
ShowLoader();
/**********************************************************/
	socket.on('connect', function(){	
		socket.emit('visitor-config', {company:companykey});		
		if(getCookie('eznetchat-'+companykey)!=''){
			identity.cookiesdata		=	jQuery.parseJSON( getCookie('eznetchat-'+companykey) );	
			identity.cookies			=	true;
			showScreen('chat-view');
			HideLoader();
		
			identity.myuserid=identity.cookiesdata.userid;
			identity.myname=identity.cookiesdata.name;
			identity.email=(typeof(identity.cookiesdata.email)==='undefined')?'':identity.cookiesdata.email;
			identity.agentid=identity.cookiesdata.agentid;
			identity.refid=identity.cookiesdata.refid;
			identity.companycode=identity.cookiesdata.company;
			identity.room=identity.cookiesdata.room;
			 RefId.val(identity.cookiesdata.refid);
			 UserId.val(identity.cookiesdata.userid);	
			 RoomId.val(identity.cookiesdata.room);		
			}		
		console.log(identity);
			socket.emit('visitorload', identity);			
			//socket.emit('AgentsList', {company:identity.mycompany});
		
	});	
	socket.on('config',function(data){	
		console.log('config');
		console.log(data);		
		config.company=data;	
		if(data && data.fileshare && (data.fileshare.indexOf("visitor")!=-1 )){		
				if(!jQuery('.f-upload').length){
						jQuery('footer').append('<a class="f-upload" href="javascript:void(0)" title="file upload"></a>');}
			//jQuery('.f-upload').removeClass('hide');
		}else{
			
			
		}
	});
	
	socket.on('login-visitor-view',function(data){		
		config.companycode=data.companycode;
		showScreen('login-view');
		HideLoader();
		
		
	});
	socket.on('No-Agent-view',function(data){
		
		config.companycode=data.companycode;
		showScreen('ticket-view');
		HideLoader();
		
	});
	
	socket.on('chat-view',function(data){
		if(data.rescode=='1'){
		showScreen('chat-view');
		console.log('chat-view');
		console.log(data);
		identity.myuserid=data.userid;
		identity.myname=data.name;
		identity.email=(typeof(data.email)==='undefined')?'':data.email;
		identity.agentid=data.agentid;
		 RefId.val(data.refid);
		 UserId.val(data.userid);	
		 RoomId.val(data.room);	
		 if(data.agentname)
		 AgentName.text(data.agentname);
		 
		 addCookies(data);
		}else{
			
			custompopup(data.resmsg);
			
		}
		 HideLoader();
	});
	socket.on('receive',function(data){
		console.log('receive');
		console.log(data);
		var url=(typeof(data.url)==='undefined')?'':data.url
		var html= msghtml({msg:data.msg,userid:data.userid,name:data.name,time:'Now',type:data.type,url:url});
			ChatBox.append(html);			
			ChatBox.scrollTop(ChatBox.height());		
	});
	socket.on('ticket-save',function(data){
		if(data.msg){
			
			var inputs = jQuery('.ticket-box').find('input, select, textarea').not(':button, :submit, :reset');
			inputs.each(function(){				
				var value=jQuery(this).val('');		
				jQuery(this).removeClass('error');
			});
			HideLoader();
			custompopup(data.msg);
			
		}
	});
	
	
	socket.on('agent-close-chat',function(data){
		console.log(data);
		var html='<li class="close-chat"><span class="text">'+data.name+' leave chat</span><a href="javascript:void(0)">Start Again</a></li>';
		ChatBox.append(html);	
	});
	
	socket.on('leave-by-transfer',function(data){
		jQuery('.roomid').val(data.newroom);
	});
	socket.on('chat-comment',function(data){
		console.log(data);
		if(data.res==1){
			updateCookies({comment:jQuery('.comment-box').val()});
			jQuery('.comment-box').val('');			
		}
		custompopup(data.msg);
	});
	socket.on('chat-rate',function(data){
		console.log(data);
		if(data.res==1){
			updateCookies({rate:jQuery('.rating-input.active').val()});				
		}
		custompopup(data.msg);
	});
	
	
	
	loginbutton.click(function(){
		ShowLoader();
		
		var name=loginName.val();
		var email=loginEmail.val();
		
		var name=noscript(name);  // For strip tag		
		var emailrule=/^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
		if(name=='' || email==''){
			custompopup('Please Enter Name and Email');
			HideLoader();
		}else if(!isValidEmail(email)){
			custompopup('Please Enter Valid Email Address');
			HideLoader();
		}else{		
			var logindata={name:name,email:email,companycode:config.companycode,host:host,browser:identity.browser,type:'visitor'};
			if(jQuery('.refid').val()!=''){
				logindata.refid=jQuery('.refid').val();
			}
		
			socket.emit('visitor-login',logindata);
		}
		
	});
	
	
	function noscript(strCode){
		   var html = $(strCode.bold()); 
		   html.find('script').remove();
		 return html.html();
		}

	Textarea.keydown(function(e){			
		if(e.keyCode == 13){
			e.preventDefault();
			SendMessage(this);
		}
	});
	function SendMessage(obj){
		console.log(identity);
		var msg=jQuery(obj).val();	
		if(msg!=''){			
		var refid=RefId.val();	
		var room=RoomId.val();		
		var html= msghtml({msg:msg,userid:identity.myuserid,name:identity.myname,time:'Now'});
			ChatBox.append(html);
			ChatScrollBottom();
			jQuery(obj).val('');
			var time =currentdate();
			socket.emit('sendmessage',{msg:msg,userid:parseInt(identity.myuserid),refid:refid,room:room,agentid:parseInt(identity.agentid),time:time});
		}else{
			
		}
		jQuery(obj).val('');
		return false;
		
	}
	function msghtml(data){
		var html='';
		var sendtype='you';
		if(identity.myuserid==data.userid){
			sendtype='me';
		}
		html +='<li class="'+sendtype+'">';
		html +='<p>';
		html +='<span class="text">';
		//if(data.type=='file' &&  data.url!=undefined){
		//	html +='<a href="'+serverurl+'download/'+data.url+'" class="upload-link" target="_blank"><i class="glyphicon glyphicon-download-alt"></i></a>';
		//}
		html += '</span>';
		html += '<b></b>';
		html +='<i class="timesent" data-time="">'+data.time+'</i></p><li>';
		var hhh=jQuery(html);
		hhh.find('p span.text').text(data.msg);
			if(data.type=='file' &&  data.url!=undefined){
				hhh.find('p span.text').append('<a href="'+serverurl+'download/'+data.url+'" class="upload-link" target="_blank"><i class="glyphicon glyphicon-download-alt"></i></a>');
			}
			hhh.find('p b').text(data.name);
			
		return hhh;
	}

	
	
	function showScreen(view){		
		jQuery('.screen-view').not('.'+view).removeClass('active');
		jQuery('.'+view).addClass('active');
		if(view=='chat-view')
		{
			//console.log('configration');
			//console.log(config.company);
			footer.addClass('active');
			showElement('email');
			showElement('closebutton');
			
			
		}else{
			footer.removeClass('active');
			
		}
		if(view=='close-view')
		{
			footer.removeClass('active');			
		}
		
		if(view=='login-view')
		{
			removeElement('closebutton');
			removeElement('email');
		}
		if(view=='ticket-view')
		{
			removeElement('closebutton');	
			removeElement('email');
		}
		
		
		
	}
	
	function clearAllCookies(){
		
		document.cookie="eznetcrmchat=;";		
	}
	function clearChatCookies(key){
		 document.cookie= "="+key+"=";
	}
	function getCookie(cname) {
		
	    var name = cname + "=";
	    var ca = document.cookie.split(';');
	   
	    for(var i=0; i<ca.length; i++) {
	        var c = ca[i];
	        while (c.charAt(0)==' ') c = c.substring(1);
	        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
	    }
	    return "";
	}
	
	function currentdate(){
		return new Date();
	}
	
	function getfileExt(filename){
		var ext=filename.split('.').pop().toLowerCase();
		return ext;
	}
	function getParameterByName(name) {	
	    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
	    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
	        results = regex.exec(location.search);
	    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
	}
	function getCompanycode() {			
		return location.pathname.replace('/','').trim();	  
	}
	
	function custompopup(msg){	
		jQuery('body').addClass('overlay-body');
		console.log(msg);
		var hh='<div class="popup-header">Eznet Chat</div><div class="popup-body">'+msg+'</div><div class="popup-bottom"><input type="button" class="close-popup" value="close"></div>';
		
		jQuery('#dialog').html(hh);
		jQuery('#dialog').addClass('popup');
		

	}
	function isValidEmail(thatemail) {		
		var re = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		return re.test(thatemail);
	}
	
	function addCommpanySettingCookies(data){			
		//document.cookie="eznetcrmcompanysetting="+JSON.stringify(data);	
	}
	
	function showElement(ele){
		
		if(ele=='email'){
			if(jQuery('.chat-box-email').length>0){				
				jQuery('.chat-box-email').addClass('active');
			}
			
		}
		if(ele=='closebutton'){
			if(jQuery('.chat-box-close').length>0){				
				jQuery('.chat-box-close').addClass('active');
			}
			
		}
	}

	function removeElement(ele){
		
		if(ele=='email'){
			if(jQuery('.chat-box-email').length>0){				
				jQuery('.chat-box-email').removeClass('active');
			}
			
		}
		if(ele=='closebutton'){
			if(jQuery('.chat-box-close').length>0){				
				jQuery('.chat-box-close').removeClass('active');
			}
			
		}
	}
	function ChatScrollBottom(){		
		ChatBox.scrollTop(ChatBox.height());
	}
	function addCookies(data){		
			 var cookiekey='eznetchat-'+companykey;
			document.cookie= "="+cookiekey+"="+JSON.stringify(data);	
			console.log(getCookie('eznetchat-'+companykey));
	}
	
	function updateCookies(data){		
		 var cookiekey='eznetchat-'+companykey;		 
		var mycookie= jQuery.parseJSON( getCookie(cookiekey) );	
		console.log(mycookie);
			for(var k in data){
				mycookie[k]=data[k];
					
			}
			console.log(mycookie);
		document.cookie= "="+cookiekey+"="+JSON.stringify(mycookie);	
		console.log(getCookie('eznetchat-'+companykey));
	}
	
	$('body').on('click','.chat-box-email.active',function(){		
		if(jQuery('.chats li').length>0){
			if(identity.email!=''){
				var refid=RefId.val();
				socket.emit('email-history',{refid:refid,emails:identity.email});
				custompopup('Mail Send Successfully');
			}
			//socket.emit()
			
		}else{
			custompopup('There is no chat');
			
		}
	});
	$('body').on('click','.f-upload',function(){		
		jQuery(this).siblings('.uploder').trigger('click');
	});
	$('body').on('change', '.uploder',function(e){		
		 var refid=RefId.val();
		 var room=RoomId.val();		
		 var agentid=parseInt(identity.agentid);		
         var file = e.originalEvent.target.files[0],
        reader = new FileReader();
         
         console.log(reader);
         var ext=getfileExt(file.name);
         reader.onload = function(evt){
        	 console.log(evt);
        	 if(supportext.indexOf(ext)===-1){
             var jsonObject = {
                 'imageData': evt.target.result,
                 'imageMetaData': file.name,
                 'filetype':ext,
                 'room':room,
                 'agentid':parseInt(agentid),
                 'refid':refid
             }             // send a custom socket message to server  
            
             socket.emit('user image', jsonObject);
        	 }else{
        		 custompopup('invalid');
        	 }
         };
         reader.readAsDataURL(file);
     });
	$('body').on('click','.chat-box-cookies',function(){		
		console.log(document.cookie);
	});
	$('body').on('click','.chat-box-cdelete',function(){	
		 var cookiekey='eznetchat-'+companykey;
		 document.cookie= "="+cookiekey+"=";	
	});
	$('body').on('click', '.ticket-box input[type="button"]',function(e){
		jQuery('.ticket-box').abValidate('validateForm');
	if(jQuery('.ticket-box .error').length==0){		
		ShowLoader();
		var ticketinfo={};
		var inputs = jQuery('.ticket-box').find('input, select, textarea').not(':button, :submit, :reset');
		inputs.each(function(){
			var name=jQuery(this).attr('name');
			var value=jQuery(this).val();
			ticketinfo[name]=value;
		});
		
		socket.emit('ticket-save',{ticketinfo:ticketinfo,companycode:config.companycode,url:parentUrl});
		
		
		
		
	}
		//jQuery('.ticket-box').abValidate();
	});
	$('body').on('click','.chat-box-close',function(){	
		showScreen('close-view');
	});
	$('body').on('click','.close-popup',function(){
		jQuery('#dialog').html('');
		jQuery('#dialog').removeClass('popup');
		jQuery('body').removeClass('overlay-body');
	});
	
	
	$('body').on('click','.cancel-chat-action',function(){	
		showScreen('chat-view');
	});
	$('body').on('click','.close-chat-action',function(){	
		var userid=jQuery('.userid').val(),
		refid=jQuery('.refid').val(),
		roomid=jQuery('.roomid').val();
		jQuery('.userid').val();
		jQuery('.refid').val('');
		jQuery('.roomid').val('');
		showScreen('login-view');
		var cookiekey='eznetchat-'+companykey;	
		clearChatCookies(cookiekey);
		ChatBox.html('');
		socket.emit('visitorclosechat',{refid:refid,roomid:roomid,userid:userid});
		console.log(getCookie('eznetchat-'+companykey));
	});
	$('body').on('click','.close-chat a',function(){	
		showScreen('login-view');
		 var cookiekey='eznetchat-'+companykey;	
			clearChatCookies(cookiekey);
		
		//ChatBox.html('');
	});
	jQuery('.star-rating :radio').click( function(){		
		jQuery(this).siblings('input').removeClass('active');
		jQuery(this).addClass('active');
				socket.emit('chat-rate',{refid:RefId.val(),companycode:config.companycode,rate:this.value});
			  } );
	jQuery('.comment-action ').click( function(){		
		
				socket.emit('chat-comment',{refid:RefId.val(),companycode:config.companycode,comment:jQuery('.comment-box').val()});
			  } );
	
	function ShowLoader(){
		jQuery('body').addClass('overlay-loader');
	}
	
	function HideLoader(){
		jQuery('body').removeClass('overlay-loader');
		
	}
	
});
function getBrowserProperty(){	
	property={};
	    var N= navigator.appName, ua= navigator.userAgent, tem;
	    var M= ua.match(/(opera|chrome|safari|firefox|msie)\/?\s*(\.?\d+(\.\d+)*)/i);
	   // console.log(M);
	    if(M && (tem= ua.match(/version\/([\.\d]+)/i))!= null) M[2]= tem[1];
	    M= M? [M[1], M[2]]: [N, navigator.appVersion,'-?'];
	property.name=M[0];
	property.version=M[1];	
	property.os=window.navigator.platform;
	//property.useragent=window.navigator.userAgent;
	property.useragent='';
	return property;
}


$(window).load(function(){
	
	
});