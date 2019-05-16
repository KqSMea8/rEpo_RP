var version = '11.1.3';
angular.module("myapp")
.controller('chatController',['$scope','$http','$location','$timeout',function($scope,$http,$location,$timeout){
	var thisObj = this;	
	var file, data;
	thisObj.section=1;
	thisObj.chatwith=[];
	thisObj.ChatDataByRoom={};
	thisObj.activeTab=0;
	thisObj.chatmessagetextarea={};
	thisObj.chatEmails="";
	thisObj.agentlist={};
	thisObj.mailBox=false;
	thisObj.transferPopup=false;
	thisObj.chatTransferData={};
	thisObj.notification=[];

	var supportext=['xls','pdf','xlsx','doc','docx'];
	var serverurl='https://www.eznetchat.com:3000';
	var statusclass={online:'list-group-item-success',busy:'list-group-item-danger',ideal:'list-group-item-info'}
	var  identity	= {};
	var  config		= {};
	identity.myname		=	myinfo.userFname+' '+myinfo.userLname;
	identity.myemail	=	myinfo.userEmail;
	identity.mycontact	=	myinfo.userContacts;
	identity.mycompany	=	myinfo.userCompcode;
	identity.myuserid	=	myinfo.userID;
	identity.mytype		=	myinfo.type;
	identity.host		=	myinfo.host;
	identity.cookies	=  false;
	identity.status	=  getCookie('addCommpanyChatAcceptCookies');
	thisObj.identity=identity;



	/* Socket Connection Start*/
	var socket = io.connect(serverurl);	
	
	socket.on('connect', function(){
	console.log("connected with angular");
		
	console.log(typeof(getCookie('eznetcrmchat'))+'--'+getCookie('eznetcrmchat'));

	
	
		if(getCookie('eznetcrmchat')!='' && getCookie('eznetcrmchat')!=null && getCookie('eznetcrmchat')!='null'){
			identity.cookiesdata		=	jQuery.parseJSON( getCookie('eznetcrmchat') );	
			identity.cookies			=	true;
				for (var ck in identity.cookiesdata){					
					console.log(identity.cookiesdata.data);
					let tmpobj={
					 visitorinfoid:identity.cookiesdata[ck].data.visitorinfoid,
					 email:identity.cookiesdata[ck].data.email,
					 ip:identity.cookiesdata[ck].data.ip,
					 room:identity.cookiesdata[ck].data.room,
					 userid:identity.cookiesdata[ck].userid,
					 name:identity.cookiesdata[ck].data.name,
					 refid:identity.cookiesdata[ck].data.refid,
					 browser:identity.cookiesdata[ck].data.browser,
					 type:identity.cookiesdata[ck].data.type,
					 tags : identity.cookiesdata[ck].data.tags,
					 cookies : true
					}

					 $scope.$apply(function() {
					 	thisObj.ChatDataByRoom[identity.cookiesdata[ck].data.refid]=[];
					 	console.log('tmp obj');
					 	console.log(tmpobj);
					   	thisObj.chatwith.push(tmpobj);	
					   						  	
					   });

					
						/*makeChatBox( {
													email : identity.cookiesdata[ck].data.email,
													room : identity.cookiesdata[ck].data.room,
													userid : identity.cookiesdata[ck].userid,
													name : identity.cookiesdata[ck].data.username,
													refid : identity.cookiesdata[ck].data.refid,
													ip : identity.cookiesdata[ck].data.ip,
													tags : identity.cookiesdata[ck].data.tags,
													browser: identity.cookiesdata[ck].data.browser,
													visitorinfoid:identity.cookiesdata[ck].data.visitorinfoid,
													type:identity.cookiesdata[ck].data.type,
													cookies : true
												});*/
					//console.log(identity.cookiesdata[ck].userid);
					socket.emit('Agent-chat-history',{agentid:identity.cookiesdata[ck].userid,userid:identity.myuserid});
				}
			}

			if(getCookie('eznetcrmchatlogin')){
				 $scope.$apply(function() {
				thisObj.section=2;
				socket.emit('load', identity);
				socket.emit('AgentsList', {company:identity.mycompany});	
				});		
			}
		
			
		
			
	});
		
	thisObj.chatlogin=function(){	
		console.log("login Start");	
		
		socket.emit('config', {company:identity.mycompany});
		console.log('get getCookie');
		thisObj.section=2;
		console.log(thisObj.identity);
		thisObj.identity.status='online';
		socket.emit('load', thisObj.identity);
		socket.emit('AgentsList', {company:identity.mycompany});		
		addLoginCookies(identity);
		
	}

	thisObj.changeChattab=function(index){

		thisObj.activeTab=index;
	}

	thisObj.sendChat=function(keyupevent,index){

		
		if(thisObj.chatmessagetextarea[index]=="")
			return false;

		let tmp={};
		tmp.msg=thisObj.chatmessagetextarea[index];
		tmp.userid=parseInt(identity.myuserid);
		tmp.refid=thisObj.chatwith[index].refid;
		tmp.room=thisObj.chatwith[index].room;
		tmp.agentid=parseInt(thisObj.chatwith[index].userid);
		tmp.time=moment();
		
		
		socket.emit('sendmessage',tmp);

		let messagedata={};

		messagedata.room=thisObj.chatwith[index].room;
		messagedata.refid=thisObj.chatwith[index].refid;
		messagedata.msg=thisObj.chatmessagetextarea[index];
		messagedata.name=identity.myname;
		messagedata.agentid=parseInt(thisObj.chatwith[index].userid);
		messagedata.time=moment();
		messagedata.type="text";
		messagedata.userid=parseInt(identity.myuserid);
		messagedata.url="";
		if(!thisObj.ChatDataByRoom[thisObj.chatwith[index].refid]){
			thisObj.ChatDataByRoom[thisObj.chatwith[index].refid]=[];
		}

		thisObj.ChatDataByRoom[thisObj.chatwith[index].refid].push(messagedata);
		thisObj.chatmessagetextarea[index]="";

		 var objDiv = jQuery(".chat.active .chat-history");
    	 var h = objDiv.get(0).scrollHeight;
    	 objDiv.animate({scrollTop: h});
		console.log(jQuery('.chat.active .chat-history').height());

		//socket.emit('sendmessage',{msg:msg,userid:parseInt(identity.myuserid),refid:refid,room:room,agentid:parseInt(agentid),time:time});
	}

	thisObj.agentChatStart=function(index){
		let agentDetail={};
		console.log(thisObj.agentlist);
		console.log(index);
		agentDetail=thisObj.agentlist[index];
		console.log(agentDetail);
		if(agentDetail.identity==''){
			alert(agentDetail.username+' is not online');
			return false;			
		}

		var name=agentDetail.username;
		var userid=agentDetail.userid;
		
		var agentidentity=agentDetail.identity;		
		if(1==1){	// check already exists 	
			//makeChatBox({room:'',userid:userid,name:name,refid:''});

			 //$scope.$apply(function() {
			//thisObj.ChatDataByRoom[data.room]=[];
			thisObj.chatwith.push({visitorinfoid:userid,email:agentDetail.email,ip:'',room:'',userid:userid,name:name,refid:agentDetail.refid,browser:'',type:'agent'});
					//   });
			socket.emit('Agent-chat-history',{agentid:userid});
			socket.emit('Agent-chat',{agentidentity:agentidentity,agentid:userid});
			
		}else{
			alert('already chat with '+name);
		}
		
	}
	
	thisObj.setMyStatus=function(status){

		thisObj.identity.status=status;
		thisObj.section=1;
		thisObj.chatwith=[];
		thisObj.ChatDataByRoom={};
		thisObj.activeTab=0;
		thisObj.chatmessagetextarea={};
		thisObj.agentlist={};
		clearAllCookiesNotLogin();
		socket.emit('setstatus',{status:status});			
	}
	thisObj.logOff=function(){
	console.log("log off");
	thisObj.section=1;
	thisObj.chatwith=[];
	thisObj.ChatDataByRoom={};
	thisObj.activeTab=0;
	thisObj.chatmessagetextarea={};
	thisObj.agentlist={};	
		clearAllCookies();
	}

	thisObj.chatemail=function(){
		console.log(thisObj.chatEmails);
		console.log(thisObj.activeTab);
		if(thisObj.chatwith[thisObj.activeTab]){
			let refid=thisObj.chatwith[thisObj.activeTab].refid;			
			socket.emit('email-history',{refid:refid,emails:thisObj.chatEmails});
			thisObj.messageLog('Mail has been sent successfully')
		}
		thisObj.mailBox=false;

	}
	thisObj.messageLog=function(msg){

		alert(msg);
	}

	thisObj.mailBoxToggle=function(){
		thisObj.mailBox=(thisObj.mailBox==true)?false:true;
	}

	thisObj.closeVisitorchat=function(index,userid){
			let data={};
			data.chatwithindex=index;
			data.userid=userid;
			CloseChatBox(data);

	}
	thisObj.closepopup=function(name){

		thisObj[name]=false;
	}
	thisObj.transferpopup=function(index){
		thisObj.chatTransferData=thisObj.chatwith[index];
		thisObj.transferPopup=(thisObj.transferPopup==true)?false:true;

	}

	thisObj.transferchat=function(agentid){
	let agentData=thisObj.agentlist[agentid];
	console.log('transferchat');
	console.log(agentData);
	console.log(thisObj.identity);
	console.log(thisObj.chatTransferData);
	 var transferdata={};
	 transferdata.agent_identity =	agentData.identity;
	 transferdata.agent_id		 =	identity.myuserid;
	 transferdata.agent_name	 =	thisObj.identity.myname;
	 transferdata.visitor_id 	 =	thisObj.chatTransferData.userid;
	 transferdata.visitor_name 	 =	thisObj.chatTransferData.name;
	 transferdata.chat_refid	 =	thisObj.chatTransferData.refid;
	 transferdata.chat_room 	 =  thisObj.chatTransferData.room;
	 transferdata.visitorinfoid	 =  thisObj.chatTransferData.visitorinfoid;
	 console.log(transferdata);
		socket.emit('transfer-chat-request',transferdata);
		thisObj.messageLog('Request send');
		thisObj.transferPopup=false;
	//jQuery(this).parents('.transfer-box').removeClass('open');	

	}
	thisObj.acceptTransfer=function(notificationindex){
		let notificationData=thisObj.notification[notificationindex];
		var transferdata={};
		 transferdata.agent_identity =	notificationData.agent_identity; // Pre Agent
		 transferdata.agent_id		 =	notificationData.agent_id;			// Pre Agent
		 transferdata.visitor_id 	 =	notificationData.visitor_id;		
		 transferdata.chat_refid	 =	notificationData.chat_refid;
		 transferdata.chat_room 	 =	notificationData.chat_room;
		 transferdata.visitorinfoid	 =  notificationData.visitorinfoid;
		 transferdata.host	 		 =  identity.host;
		 transferdata.company	 	 =  identity.mycompany;
		 console.log(transferdata);
		 socket.emit('transfer-chat-accept',transferdata);
		thisObj.notification.splice(notificationindex,1);		
		
	}

	thisObj.cancelTransfer=function(){

		
	}

	if(getCookie('addCommpanyChatAcceptCookies')!=undefined && parseInt(getCookie('addCommpanyChatAcceptCookies').length) !=0){		
	
		jQuery('.chat-acceptance-select').val(getCookie('addCommpanyChatAcceptCookies'));
		
	}else{
		
		jQuery('.chat-acceptance-select').val('Accept');
		
	}
	
	socket.on('config',function(data){	
		console.log('Configration');
		console.log(data);
		addCommpanySettingCookies(data);
		config.company=data;		
	});
	socket.on('AgentsList', function(agents){	
		console.log("agents");
		console.log(agents);
		let agentlist={};

		if(agents != undefined && agents.length > 0){			
			for(var a in agents ){

				
				//console.log(agents[a].userid+'--'+identity.myuserid);
				if(agents[a].userid!=identity.myuserid){
					agentlist[agents[a].userid]=agents[a];
				}
			}
		}
		


		 $scope.$apply(function() {

		  thisObj.agentlist=agentlist;

		});

			
	});
	socket.on('setStatus', function(data){		
		console.log("set status");
		console.log(data);
 		$scope.$apply(function() {
 			if(!thisObj.agentlist[data.userid]){
 				thisObj.agentlist[data.userid]={};
 			}
		  thisObj.agentlist[data.userid].status=data.status;
		  thisObj.agentlist[data.userid].identity=data.identity;
		});
		
	});
	
	socket.on('join-agent-chat',function(data){
	console.log('join-agent-chat');		
		if(isChatBox(data.userids)==false){
			//console.log('No Box');
			for(var a in data.userids){
				if(data.userids[a]!=identity.myuserid){	
							
					makeChatBox({room:data.room,userid:data.userids[a],name:jQuery('.list-group .user-id-'+data.userids[a]).find('.name').text(),refid:data.refranceid});
					socket.emit('Agent-chat-history',{agentid:data.userids[a]});
				}
				
			}
		}else{
			for(var a in data.userids){
				if(data.userids[a]!=identity.myuserid){		
					jQuery('.chat-boxs .user-chat-'+data.userids[a]).find('.chat-refid').val(data.refranceid);
					jQuery('.chat-boxs .user-chat-'+data.userids[a]).find('.chat-room').val(data.room);			
					updatecookies(data.userids[a],{refid:data.refranceid,room:data.room});
				}
				
			}
		
			//console.log('Have Box');
		}
	});
	socket.on('Agent-chat-history',function(data){
		console.log('Agent-chat-history');	
		console.log(data);	
		let messageDatalist=[];
		if(data.items.length > 0){
			for (var a in data.items){
				
				let messagedata={};
				messagedata.room=data.items[a].room;
				messagedata.refid=data.items[a].refid;
				messagedata.msg=data.items[a].msg;
				messagedata.name=data.items[a].fromusername;
				messagedata.agentid=parseInt(data.items[a].touserid);
				messagedata.time=moment(data.items[a].date);
				messagedata.type="text";
				messagedata.userid=parseInt(data.items[a].fromuserid);
				messagedata.url="";

				if(!messageDatalist[data.items[a].refid]){
							messageDatalist[data.items[a].refid]=[];
					}
				messageDatalist[data.items[a].refid].push(messagedata);	
				



				/*var html= msghtml({msg:data.items[a].msg,userid:data.items[a].fromuserid,name:data.items[a].fromusername,time:moment()});
				var boxid=data.items[a].fromuserid;
				if(data.items[a].fromuserid==identity.myuserid){
					boxid=data.items[a].touserid;
				}				
				var obj	=	jQuery('.chat-boxs .user-chat-'+boxid);
				obj.find('.chat-window-body .chats').prepend(html);
				var objDiv=obj.find('.chat-window-body .chats');		
				obj.find('.chat-window-body').scrollTop(objDiv.height());*/
			}
			
		}	

		console.log('Message List');
		console.log(messageDatalist);
		for(let a in messageDatalist){
			messageDatalist[a]=messageDatalist[a].reverse();
		}

				$scope.$apply(function() {				
						
		   				thisObj.ChatDataByRoom=messageDatalist;				
				});
	});
	
	socket.on('receive',function(data){
		console.log('receive');
		console.log(data);
		var url=(typeof(data.url)==='undefined')?'':data.url;

		data.url=url;
		data.time=moment();
		data.boxid=data.userid;
		if(!thisObj.ChatDataByRoom[data.refid]){
			thisObj.ChatDataByRoom[data.refid]=[];
		}
		
		 $scope.$apply(function() {
		   thisObj.ChatDataByRoom[data.refid].push(data);

		    var objDiv = jQuery(".chat.active .chat-history");
    	 var h = objDiv.get(0).scrollHeight;
    	 objDiv.animate({scrollTop: h});
		console.log(jQuery('.chat.active .chat-history').height());
		});

	

	/*	var html= msghtml({msg:data.msg,userid:data.userid,name:data.name,time:moment(),type:data.type,url:url});
		var boxid=data.userid;
			if(data.userid==identity.myuserid){
				boxid=data.agentid;
			}		
			if(!jQuery('.visitor.user-chat-'+boxid).hasClass('active')){
				document.getElementById('audiotag1').play();
				if(jQuery('.visitor.user-chat-'+boxid).find('.chat-noti').length==0){
					jQuery('.visitor.user-chat-'+boxid).prepend('<span class="chat-noti badge badge color_2">1</span>');						
				}else{
					var cc=parseInt(jQuery('.visitor.user-chat-'+boxid).find('.chat-noti').text())+1;
					jQuery('.visitor.user-chat-'+boxid).find('.chat-noti').text(cc);
				}				
				
			}
		var obj	= jQuery('.chat-boxs .user-chat-'+boxid);
			obj.find('.chat-window-body .chats').append(html);
			var objDiv=obj.find('.chat-window-body .chats');		
			obj.find('.chat-window-body').scrollTop(objDiv.height());
			makechatFooterNotification({userid:data.userid,message:data.msg});*/
			
	});
	
	socket.on('transfer-chat-request',function(data){
		console.log('Chat Transfer request');
		console.log(data);
		data.type="transfer";
		data.msg='You have chat transfer request from '+data.agent_name+' for '+data.visitor_name;
			$scope.$apply(function() {
					 thisObj.notification.push(data);
			});
			document.getElementById('audiotag1').play();			


		//var noti_count=(jQuery('.noti-count').text()==undefined)?parseInt(0):parseInt(jQuery('.noti-count').text());
		/*var html ='';
			html +=' <li class="mail"><span class="message">You have chat transfer request from '+data.agent_name+' to '+data.visitor_name+'.</span><button href="javascript:void(0)" class="btn btn-success btn-xs accept-transfer fa fa-check"></button><button href="javascript:void(0)" class="btn btn-danger btn-xs cancel-transfer fa fa-times"></button>';
			html +='<input type="hidden" class="refid" value="'+data.chat_refid+'">';
			html +='<input type="hidden" class="visitor_id" value="'+data.visitor_id+'">';
			html +='<input type="hidden" class="visitorinfoid" value="'+data.visitorinfoid+'">';
			html +='<input type="hidden" class="chat-room" value="'+data.chat_room+'">';
			html +='<input type="hidden" class="agent_identity" value="'+data.agent_identity+'">';
			html +='<input type="hidden" class="agent_id" value="'+data.agent_id+'">';
			html +='</li>';
			jQuery('.noti-container').append(html);
			jQuery('.noti-count').html((noti_count+1));
			jQuery('.noti-number-decription').html('You have '+(noti_count+1)+' Notification');*/
			
	
	});
	
	socket.on('transfer-chat-accept',function(data){
		
			console.log('transfer accept');
			console.log(data);	
			data.type='visitor';
			makeChatBox(data);
	
	});
	socket.on('leave-by-transfer',function(data){
		
		console.log('leave-by-transfer');
		console.log(data);	
		data.refid=data.chat_refid;
		CloseChatBox({userid:data.visitor_id});
		

});
	

	
	
	socket.on('userimage', function(m){
//	    $('#imageReceivedMessage').text("> "+m);
		//console.log(m);
	  
	});
	socket.on('visitor-close-chat', function(data){

		console.log('visitor-close-chat');
		console.log(data);	
		console.log(thisObj.chatwith);	
		let chatwithData={};
		for(var a in thisObj.chatwith){

			if(thisObj.chatwith[a].refid==data.refid){

					chatwithData=thisObj.chatwith[a];
					$scope.$apply(function() {
					 	thisObj.chatwith[a].closechat=true;
					   });
					
					break;
			}
		}
		console.log(chatwithData);
		var msg=chatwithData.name+' leave chat';
		let messagedata={};

		messagedata.room='';
		messagedata.refid=data.refid;
		messagedata.msg=msg;
		messagedata.name=chatwithData.name;
		messagedata.agentid=parseInt(thisObj.identity.myuserid);
		messagedata.time=moment();
		messagedata.type="visitor";
		messagedata.userid=parseInt(data.userid);
		messagedata.url="";
		messagedata.isclosemsg=true;
		if(!thisObj.ChatDataByRoom[data.refid]){
			thisObj.ChatDataByRoom[data.refid]=[];
		}
		$scope.$apply(function() {
					 thisObj.ChatDataByRoom[data.refid].push(messagedata);
					   });
		
		
		deletecookies(data.userid);


		/*var url='';
		var visitorname=(jQuery('.window-user-chat-'+data.userid).find('.chat-receiver').val())?jQuery('.window-user-chat-'+data.userid).find('.chat-receiver').val():'Visitor';
		var msg=visitorname+' leave chat';		
		var html= msghtml({msg:msg,userid:data.userid,name:visitorname,time:moment(),type:'visitor',url:url,isclosemsg:true});
		var boxid=data.userid;
		if(data.userid==identity.myuserid){
			boxid=data.agentid;
		}
		//console.log(boxid);
		var obj	=	jQuery('.chat-boxs .user-chat-'+boxid);
		obj.find('.chat-window-body .chats').append(html);
		var objDiv=obj.find('.chat-window-body .chats');		
		obj.find('.chat-window-body').scrollTop(objDiv.height());
		deletecookies(data.userid);
		obj.find('.message-input').attr("disabled", true);;	
		obj.find('.f-upload').addClass('disabled');	*/
		
		
	});
	
	socket.on('chat-view',function(data){
		//console.log('chat-view');
		//console.log(data);
		var userids=[data.userid];
		if(isChatBox(userids)==false){
			//console.log('No Box');
			for(var a in userids){
				if(userids[a]!=identity.myuserid){	
					 $scope.$apply(function() {
					 	thisObj.ChatDataByRoom[data.refid]=[];
					   	thisObj.chatwith.push({visitorinfoid:data.visitorinfoid,email:data.email,ip:data.ip,room:data.room,userid:userids[a],name:data.name,refid:data.refid,browser:data.browser,type:data.type});
					  	addCookies({visitorinfoid:data.visitorinfoid,email:data.email,ip:data.ip,room:data.room,userid:userids[a],name:data.name,refid:data.refid,browser:data.browser,type:data.type});
					   });
				
					//console.log(thisObj.chatwith);
				//	makeChatBox({visitorinfoid:data.visitorinfoid,email:data.email,ip:data.ip,room:data.room,userid:userids[a],name:data.name,refid:data.refid,browser:data.browser,type:data.type});
					//socket.emit('Agent-chat-history',{agentid:data.userids[a]});
					if(jQuery('.footer-chat-notify')){
						makechatFooterNotification({visitorinfoid:data.visitorinfoid,email:data.email,ip:data.ip,room:data.room,userid:userids[a],name:data.name,refid:data.refid,browser:data.browser,type:data.type});
						
					}

						/************** For Greet message **************/
						let setobj={}
						if(isJson(getCookie('eznetcrmcompanysetting'))){
							setobj=JSON.parse(getCookie('eznetcrmcompanysetting'));				
							}
							if(setobj.greeting){
								let tmp={};
								tmp.msg=setobj.greeting;
								tmp.userid=parseInt(identity.myuserid);
								tmp.refid=data.refid;
								tmp.room=data.room;
								tmp.agentid=parseInt(userids[a]);
								tmp.time=moment();								
								socket.emit('sendmessage',tmp);
						}

				}
				
			}
		}else{
			for(var a in userids){
				if(userids[a]!=identity.myuserid){		
					jQuery('.chat-boxs .user-chat-'+data.userids[a]).find('.chat-refid').val(data.refranceid);
					jQuery('.chat-boxs .user-chat-'+data.userids[a]).find('.chat-room').val(data.room);			
					updatecookies(data.userids[a],{refid:data.refranceid,room:data.room});		
					
				}
				
			}
		
			//console.log('Have Box');
		}
		
		//console.log(data);
		/*showScreen('chat-view');
		console.log('chat-view');
		console.log(data);
		identity.myuserid=data.userid;
		identity.myname=data.name;
		 RefId.val(data.refid);
		 UserId.val(data.userid);	
		 RoomId.val(data.room);	*/		
	});
	
	/*Click handler*/
	$('.list-group-item span.name').click(function(){
		if($(this).siblings('.identity').val()==''){
			alert($(this).text()+' is not online');
			return false;
			
		}
		var name=$(this).text();
		var userid=$(this).siblings('.userid').val();
		
		var agentidentity=$(this).siblings('.identity').val();		
		if(jQuery('.visitors-list .user-chat-'+userid).length==0){		
			makeChatBox({room:'',userid:userid,name:name,refid:''});
			socket.emit('Agent-chat-history',{agentid:userid});
			socket.emit('Agent-chat',{agentidentity:agentidentity,agentid:userid});
			
		}else{
			alert('already chat with '+name);
		}
		
	});
	$('body').on('click','.visitor .remove',function(){
		
		
		var userid=jQuery(this).siblings('.chat-userid').val();
		var type=jQuery('.window-user-chat-'+userid).find('.chat-type').val();
		var roomid=jQuery('.window-user-chat-'+userid).find('.chat-room').val();
		CloseChatBox({userid:userid});
		/*jQuery(this).parent('.visitor').removeClass('busy user-chat-'+userid);
		jQuery(this).parent('.visitor').addClass('available');
		jQuery(this).parent('.visitor').html('');
		jQuery('.chat-boxs .window-user-chat-'+userid).remove();*/
		console.log(type);
		if(type=='visitor'){
			socket.emit('leave-chat-visitor',{visitorid:userid,roomid:roomid});			
		}
	});
	$('body').on('click','.close-chat-window',function(){
		var userid=jQuery(this).parents('.chat-window').find('.chat-userid').val();
		var roomid=jQuery(this).parents('.chat-window').find('.chat-room').val();
		var type=jQuery(this).parents('.chat-window').find('.chat-type').val();
		CloseChatBox({userid:userid});		
		console.log(type);
		if(type=='visitor'){
			socket.emit('leave-chat-visitor',{visitorid:userid,roomid:roomid});			
		}
	});
	$('body').on('click','.visitor.busy .visitor-body',function(){
		var userid=jQuery(this).parents('.visitor.busy').find('.chat-userid').val();
		jQuery(this).parents('.visitor.busy').siblings('.visitor.busy.active').removeClass('active');
		jQuery('.chat-window-box').not('.window-user-chat-'+userid).removeClass('active');
		jQuery('.chat-window-box.window-user-chat-'+userid).addClass('active');
		jQuery(this).parents('.visitor.busy').addClass('active');
		jQuery(this).siblings('.chat-noti').remove();
	});
	$('body').on('keydown','.message-input',function(e){			
			if(e.keyCode == 13){
				e.preventDefault();
				SendMessage(this);
			}
	});
	$('body').on('click','.mycookies',function(e){		
		//	console.log(config);
		console.log(getCookie('eznetcrmchat'));
		console.log(getCookie('eznetcrmcompanysetting'));
	});
	$('body').on('click','.chat-tag-action',function(e){
		var $this=jQuery(this);
		var html='';
		var savetag=[];
		$this.parents('.tag-box-wrp').siblings('.chat-tags').find('.tag-box').each(function(){
			savetag.push(jQuery(this).find('.tag-close').attr('data-tag'));
		});
		
		html +='<ul class="chat-tag-list dropdown-menu pull-left list-group tags-list">';
		jQuery('.parents-tags ul li').each(function(){
			var close='';
			if(savetag.indexOf(jQuery(this).find('.tag-id').text()) != -1){
				close=" hide";
			}
			html +='<li class="list-group-item'+close+'"><a href="javascript:void(0)" data-id="'+jQuery(this).find('.tag-id').text()+'" class="save-chat-tag">'+jQuery(this).find('.tagname').text()+'</a></li>';
			
		});
		html +='</ul>';
		if(!$this.parents('.tag-box-wrp').hasClass('open'))
		$this.parents('.tag-box-wrp').addClass('open');
		else{
		$this.parents('.tag-box-wrp').removeClass('open');
		$this.siblings('.chat-tag-list').find('li.no-tag').remove();
		}
		
		if($this.parents('.tag-box-wrp').find('.chat-tag-list').length==0){
		$this.parents('.tag-box-wrp').append(html);
		}
		
	
		if($this.siblings('.chat-tag-list').find('li').length==$this.siblings('.chat-tag-list').find('li.hide').length){
			$this.siblings('.chat-tag-list').append('<li class="no-tag">There is no tag</li>');
		}
	});
	
	
	
	
	$('body').on('click','.transfer-agent-list',function(e){
		var $this=jQuery(this);
		var html='';
		var savetag=[];
		jQuery('.online-user-row ul li.list-group-item-success').each(function(){
			var close='';			
			html +='<li class="'+jQuery(this).attr('class')+'">'+jQuery(this).html()+'</li>';
			
		});
		if(!$this.parents('.transfer-box').hasClass('open'))
		$this.parents('.transfer-box').addClass('open');
		else{
		$this.parents('.transfer-box').removeClass('open');
		$this.siblings('.t-agent-list').find('li.no-tag').remove();
		}
		
		if($this.siblings('.t-agent-list').find('.li').not('.no-tag').length==0){
			$this.siblings('.t-agent-list').html(html);
		}
		
	
		if($this.siblings('.t-agent-list').find('li').length==$this.siblings('.chat-tag-list').find('li.hide').length){
			$this.siblings('.t-agent-list').append('<li class="no-tag">There is no Agent</li>');
		}
	});
	
	
	$('body').on('click','.t-agent-list li .name',function(e){
	var transferdata={};
	 transferdata.agent_identity =	jQuery(this).siblings('.identity').val();
	 transferdata.agent_id		 =	jQuery(this).siblings('.userid').val();
	 transferdata.agent_name	 =	jQuery('.my-profile').find('.name').text();	
	 transferdata.visitor_id 	 =	jQuery(this).parents('.chat-window-box').find('.chat-userid').val();
	 transferdata.visitor_name 	 =	jQuery(this).parents('.chat-window-box').find('.chat-receiver').val();
	 transferdata.chat_refid	 =	jQuery(this).parents('.chat-window-box').find('.chat-refid').val();
	 transferdata.chat_room 	 =	jQuery(this).parents('.chat-window-box').find('.chat-room').val();
	 transferdata.visitorinfoid	 =  jQuery(this).parents('.chat-window-box').find('.chat-visitorinfoid').val();
	socket.emit('transfer-chat-request',transferdata);
	custompopup('Request send');
	jQuery(this).parents('.transfer-box').removeClass('open');	
	
	});
	
	$('body').on('click','.noti-container .accept-transfer',function(e){
		 var transferdata={};
		 transferdata.agent_identity =	jQuery(this).siblings('.agent_identity').val(); // Pre Agent
		 transferdata.agent_id		 =	jQuery(this).siblings('.agent_id').val();			// Pre Agent
		 transferdata.visitor_id 	 =	jQuery(this).siblings('.visitor_id').val();		
		 transferdata.chat_refid	 =	jQuery(this).siblings('.refid').val();
		 transferdata.chat_room 	 =	jQuery(this).siblings('.chat-room').val();
		 transferdata.visitorinfoid	 =  jQuery(this).siblings('.visitorinfoid').val();
		 transferdata.host	 		 =  identity.host;
		 transferdata.company	 	 =  identity.mycompany;
		 console.log(transferdata);
		 socket.emit('transfer-chat-accept',transferdata);
		
		 var noti_count=parseInt(jQuery('.noti-count').text())-1;
		 jQuery('.noti-count').text(noti_count);
		 if( jQuery(this).parents('ul.noti-container').find('li.mail').length<=1){
			 jQuery(this).parents('ul.noti-container').prepend('<li class="no-noti">There is no notification</li>');			 
		 }
		 jQuery(this).parents('li.mail').remove();
		});
	
	
	
	
	
	
	$('body').on('click','.clearcookies',function(){			
		clearAllCookies();
	});
	$('body').on('change','.chat-acceptance-select',function(){	
		console.log(jQuery(this).val());
	
		
		if(jQuery(this).val()=='Accept'){
			socket.emit('setstatus',{status:'online'});			
		}else if(jQuery(this).val()=='notAccept'){			
			socket.emit('setstatus',{status:'offline'});
			jQuery('.visitor.circle.busy').each(function(){				
				jQuery(this).find('.remove').trigger('click');
			});
		}		
		addCommpanyChatAcceptCookies(jQuery(this).val());
	});
	
	
	
	$('body').on('click','.f-upload',function(){
		if(!jQuery(this).hasClass('disabled')){
			jQuery(this).siblings('.uploder').trigger('click');
		}
	});
	$('body').on('click','.footer-chat-notify',function(){
		var w=0;
		var isscrole=0;
		var clickele= jQuery(this);
		if(!jQuery(this).hasClass('open')){
			jQuery(this).prepend('<span class="close-notification"><i class="glyphicon glyphicon-remove"></i></span>');
			jQuery('.chat-notification-count').remove();
			jQuery('.footer-chat-notify .chat-footer-notification').each(function(){
				w +=jQuery(this).width() + 2;
			});
		
			
			
			var maxwidth=((jQuery(window).width()*80)/100);
				if(w>maxwidth){
					w=maxwidth;	
					isscrole=1;
				}
				$('.footer-chat-notify' ).animate({			  
				    width: w
				  }, 500, function() {		
					  if(isscrole==1){
						  clickele.addClass('noti-scrole');
					  }
					  clickele.addClass('open');
				  });
			
				
		}
	});
	$('body').on('click','.close-notification',function(){
		var closeele=jQuery(this);
		  $('.footer-chat-notify' ).animate({			  
			    width: "17"
			  }, 500, function() {
				  closeele.remove();
				  jQuery(this).removeClass('open');
			  });
	});
	
	$('body').on('change', '.uploder',function(){		
		 var refid=jQuery(this).siblings('.chat-refid').val();	
		 var room=jQuery(this).siblings('.chat-room').val();
		 var agentid=jQuery(this).siblings('.chat-userid').val();
		
         var file = e.originalEvent.target.files[0],
        reader = new FileReader();
         
         //console.log(reader);
         var ext=getfileExt(file.name);
         reader.onload = function(evt){
        	 //console.log(evt);
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
	function SendMessage(obj){
		var msg=jQuery(obj).val();	
		if(msg!=''){			
		var refid=jQuery(obj).siblings('.chat-refid').val();	
		var room=jQuery(obj).siblings('.chat-room').val();
		var agentid=jQuery(obj).siblings('.chat-userid').val();
		var html= msghtml({msg:msg,userid:identity.myuserid,name:identity.myname,time:moment()});
			jQuery(obj).parents('.chat-window').find('.chat-window-body .chats').append(html);
			var objDiv=jQuery(obj).parents('.chat-window').find('.chat-window-body .chats');		
			jQuery(obj).parents('.chat-window').find('.chat-window-body').scrollTop(objDiv.height());
			jQuery(obj).val('');
			var time =currentdate();
			console.log({msg:msg,userid:parseInt(identity.myuserid),refid:refid,room:room,agentid:parseInt(agentid),time:time});
			socket.emit('sendmessage',{msg:msg,userid:parseInt(identity.myuserid),refid:refid,room:room,agentid:parseInt(agentid),time:time});
		}else{
			
		}
		jQuery(obj).val('');
		return false;
		
	}
	
	
	function custompopup(data){
		alert(data);		
	}
	function msghtml(data){
		var html='';
		console.log(data);
		var sendtype='you';
		if(identity.myuserid==data.userid){
			sendtype='me';
		}
		if(data.isclosemsg!=undefined && data.isclosemsg==true)
			{
			sendtype +=' close-msg';
			}
		html +='<li class="'+sendtype+'">';
		html +='<p><b></b>';
		html +='<span class="text">';
		//if(data.type=='file' &&  data.url!=undefined){
		//	html +='<a href="'+serverurl+'download/'+data.url+'" class="upload-link" target="_blank"><i class="glyphicon glyphicon-download-alt"></i></a>';
		//}
		html += '</span>';
		
		html +='<i class="timesent" data-time="'+data.time+'">'+data.time.fromNow()+'</i></p></li>';
		
		var hhh=jQuery(html);
		
		hhh.find('p span.text').text(data.msg);
		if(data.type=='file' &&  data.url!=undefined){
			hhh.find('p span.text').append('<a href="'+serverurl+'/download/'+data.url+'" class="upload-link" target="_blank"><i class="glyphicon glyphicon-download-alt"></i></a>');
		}
		hhh.find('p b').text(data.name);
		return hhh;
	}
	
	function InArray(array,value){
		if(array.length==0 || array==undefined){
			return false;
		}
		for(var a in array){
			if(array[a]==value){
			return true;
			}
		}
		return false;
		
	}
	
	function isChatBox(array){
		var res=false
		if(array.length==0 || array==undefined){
			return res;
		}
		for(var a in array){
			if(jQuery('.chat-boxs .user-chat-'+array[a]).length>0){
				return res=true;
			}
		}
		return res;
	}
	
	function makeChatBox(data){
		
		var chatoxdata={};
		//chatoxdata.type=(data.type!=undefined)?data.type:"visitor";
		chatoxdata.name=(data.name!=undefined)?data.name:"Visitor";
		chatoxdata.userid=(data.userid!=undefined)?data.userid:"0";
		chatoxdata.refid=(data.refid!=undefined)?data.refid:"0";
		chatoxdata.room=(data.room!=undefined)?data.room:"0";
		chatoxdata.visitorinfoid=(data.visitorinfoid!=undefined)?data.visitorinfoid:"0";
		chatoxdata.location=(data.location!=undefined)?data.location:"--";
		chatoxdata.email=(data.email!=undefined)?data.email:"--";
		chatoxdata.ip=(data.ip!=undefined)?data.ip:"--";
		chatoxdata.tags=(data.tags!=undefined)?data.tags:"";
		if(data.browser){
		chatoxdata.browser={name:(data.browser.name!=undefined)?data.browser.name:"--",version:(data.browser.version!=undefined)?data.browser.version:"--",os:(data.browser.os!=undefined)?data.browser.os:"--"};
		}else{			
			chatoxdata.browser={name:"",version:'',os:''};
		}
		
		
		
		
	//	console.log('CheckPermission');
		//console.log(getCookie('eznetcrmcompanysetting'));
		var fileshare='';
		if(isJson(getCookie('eznetcrmcompanysetting'))){
			var setobj=JSON.parse(getCookie('eznetcrmcompanysetting'));			
			fileshare=(setobj.fileshare!=undefined)?setobj.fileshare:'';
			
		}
		var activeclass='';
		if($('.busy.active').length==0){
			activeclass='active';			
		}
		var type=(typeof(data.type)==='undefined')?'Agent':data.type;
		if(jQuery('.visitors-list .user-chat-'+chatoxdata.userid).length==0){
		var html	 ='<div class="visitor-body"><h3>'+chatoxdata.name+'</h3>';
			html 	+='<h6>'+type+'</h6></div>';
			html 	+='<input class="chat-userid" type="hidden" value="'+chatoxdata.userid+'">';
			html 	+='<span class="remove"><i class="glyphicon glyphicon-remove"></i></span>';
			var	chathtml	='<div class="col-md-12 chat-window-box window-user-chat-'+chatoxdata.userid+' '+activeclass+'">';
			 	chathtml	+='<div class="col-md-6 chat-window user-chat-'+chatoxdata.userid+' '+activeclass+'">';
			   	chathtml	+=	'<div class="chat-window-header"><span class="title">Chat With '+chatoxdata.name+'</span><span class="close-chat-window "><i class="glyphicon glyphicon-remove"></i></span></div>';
				chathtml	+=	'<div class="chat-window-body"><ul class="chats"></ul></div>';
				chathtml	+=	'<div class="chat-window-footer">';
				chathtml 	+=	'<input class="chat-userid" type="hidden" value="'+chatoxdata.userid+'">';
				chathtml 	+=	'<input class="chat-receiver" type="hidden" value="'+chatoxdata.name+'">';
				chathtml 	+=	'<input class="chat-refid" type="hidden" value="'+chatoxdata.refid+'">';
				chathtml 	+=	'<input class="chat-room" type="hidden" value="'+chatoxdata.room+'">';
				chathtml 	+=	'<input class="chat-type" type="hidden" value="'+type+'">';
				chathtml 	+=	'<input class="chat-visitorinfoid" type="hidden" value="'+((chatoxdata.visitorinfoid!=undefined)?chatoxdata.visitorinfoid:'')+'">';				
				chathtml	+=	'<textarea class="message-input"></textarea>';
				if(fileshare.indexOf("agent")!=-1 ){
					chathtml	+=	'<input type="file" value="" class="uploder">';
					chathtml	+=	'<a class="f-upload"><i class="glyphicon glyphicon-cloud-upload"></i></a>';
				}
				 chathtml	+=	'</div>';
			    chathtml	+=	'</div>';
			    chathtml	+=	'<div class="col-md-6">';
			    chathtml	+=	'<ul class="visitor-info"><li class="visitor-name"><h3>'+chatoxdata.name+'</h3>';
			    if(type!='Agent'){
			    chathtml	+='<div class="transfer-box"><a href="javascript:void(0)" class="transfer-agent-list">Transfer</a><ul class="t-agent-list dropdown-menu"></ul></div></li>';
			    }
			    chathtml	+=	'<li class="visitor-location"><label><strong>Location</strong></label><span>'+((chatoxdata.location!=undefined)?chatoxdata.location:"--")+'</span></li>';
			    chathtml	+=	'<li class="visitor-email"><label><strong>Email</strong></label><span>'+((chatoxdata.email!=undefined)?chatoxdata.email:"No Email")+'</span></li>';
			    chathtml	+=	'<li class="visitor-ip"><label><strong>IP</strong></label><span>'+((chatoxdata.ip!=undefined)?chatoxdata.ip:"--")+'</span></li>';
			    chathtml	+=	'<li class="visitor-bsw"><label><strong>Browser</strong></label>';			 
			    if(chatoxdata.browser && chatoxdata.browser.name!=''){			    	
			    	   chathtml	+=	'<span class="bws '+chatoxdata.browser.name+'"><i class="'+getbwsClass(chatoxdata.browser.name)+'"></i> '+chatoxdata.browser.name+'('+chatoxdata.browser.version+'),  <span class="visitor-os"><i class="'+getosClass(chatoxdata.browser.os)+'"></i>'+chatoxdata.browser.os+'</span></label>';
			    }
			    chathtml	+=	'</li>';
			    chathtml	+=	'</ul>';
			    if(type!='Agent'){
			    chathtml	+=	'<div class="tag-box-wrp"><a href="javascript:void(0)" class="dropdown-toggle chat-tag-action" >Tags <i class="fa fa-tags"></i></a></div>';
			    chathtml	+=	'<div class="chat-tags">';
			   
			    if(chatoxdata.tags!==undefined && chatoxdata.tags.length>0){
			    	for (kt in chatoxdata.tags){			    		
			    	chathtml +='<div class="tag-box btn btn-info btn-xs"><span class="tag-name">'+chatoxdata.tags[kt]+'</span><span data-tag="'+kt+'" class="tag-close"><i class="fa fa-times"></i></span></div>';
					}
			    }
				chathtml	+=	'</div>';
			    }
			    chathtml	+=	'</div>';
			    chathtml	+=	'</div>';
		var abobj=	jQuery('.visitors-list .available:eq(0)');
		abobj.html(html);
		jQuery('.chat-boxs').append(chathtml);
		abobj.removeClass('available');	
		abobj.addClass('busy');
		abobj.addClass(activeclass);
		abobj.addClass('user-chat-'+chatoxdata.userid);	
			if(data.cookies!=true){				
				
				addCookies({username:chatoxdata.name,userid:chatoxdata.userid,refid:chatoxdata.refid,room:chatoxdata.room,type:type,email:chatoxdata.email,ip:chatoxdata.ip,visitorinfoid:chatoxdata.visitorinfoid,browser:{name:chatoxdata.browser.name,version:chatoxdata.browser.version,os:chatoxdata.browser.os}});
			}
		
		}
		
		
	}
	
	
	function makechatFooterNotification(data){
		var	chathtml	='';
		var chatoxdata={};
		
		
		//chatoxdata.type=(data.type!=undefined)?data.type:"visitor";
		chatoxdata.name=(data.name!=undefined)?data.name:"Visitor";
		chatoxdata.userid=(data.userid!=undefined)?data.userid:"0";
		chatoxdata.refid=(data.refid!=undefined)?data.refid:"0";
		chatoxdata.room=(data.room!=undefined)?data.room:"0";
		chatoxdata.visitorinfoid=(data.visitorinfoid!=undefined)?data.visitorinfoid:"0";
		chatoxdata.location=(data.location!=undefined)?data.location:"--";
		chatoxdata.email=(data.email!=undefined)?data.email:"--";
		chatoxdata.ip=(data.ip!=undefined)?data.ip:"--";	
		chatoxdata.message=(data.message!=undefined)?data.message:"Invitation";	
		if(chatoxdata.message.length>20)
			chatoxdata.message=chatoxdata.message.substring(0,20)+'...';
		var type=(typeof(data.type)==='undefined')?'Agent':data.type;
		console.log('.footer-user-chat-'+chatoxdata.userid);
		console.log(jQuery('.footer-user-chat-'+chatoxdata.userid).length);
		if(jQuery('.footer-user-chat-'+chatoxdata.userid).length > 0){
			
			
			jQuery('.footer-user-chat-'+chatoxdata.userid).find('.footer-chat-window-body').html(chatoxdata.message);
			
			
					
		}else{
			chathtml	='<div class="chat-footer-notification footer-user-chat-'+chatoxdata.userid+'">';
		  	chathtml	+=	'<div class="footer-chat-window-header"><span class="title">'+chatoxdata.name+'</span></div>';
		  	chathtml	+=	'<div class="footer-chat-window-body">'+chatoxdata.message+'</div>';	
			chathtml 	+=	'<input class="chat-userid" type="hidden" value="'+chatoxdata.userid+'">';
		//	chathtml 	+=	'<input class="chat-receiver" type="hidden" value="'+chatoxdata.name+'">';
		//	chathtml 	+=	'<input class="chat-refid" type="hidden" value="'+chatoxdata.refid+'">';
		//	chathtml 	+=	'<input class="chat-room" type="hidden" value="'+chatoxdata.room+'">';
		//	chathtml 	+=	'<input class="chat-type" type="hidden" value="'+type+'">';
		//	chathtml 	+=	'<input class="chat-visitorinfoid" type="hidden" value="'+((chatoxdata.visitorinfoid!=undefined)?chatoxdata.visitorinfoid:'')+'">';				
			chathtml	+=	'</div>';
			
			jQuery('.footer-chat-notify').append(chathtml);
		}
		
		if(!jQuery('.footer-chat-notify').hasClass('open')){
				document.getElementById('audiotag1').play();			
			if(jQuery('.footer-chat-notify .chat-notification-count').length<=0){
				jQuery('.footer-chat-notify').prepend('<span class="chat-notification-count">1</span>');
			}else{				
				jQuery('.footer-chat-notify .chat-notification-count').text((parseInt(jQuery('.footer-chat-notify .chat-notification-count').text()) + 1));
			}
			
		}
		
		if(jQuery('.footer-chat-notify').hasClass('hide')){
			jQuery('.footer-chat-notify').removeClass('hide');
		}
		
		
		
	}
	
	function addCookies(data){	
		var totaldata=[];	
		var tmp={};
			if(getCookie('eznetcrmchat')!='undefined' && getCookie('eznetcrmchat')!=''){
				var row=getCookie('eznetcrmchat');
				var d=jQuery.parseJSON( row );
				 totaldata=d;
			}
			 tmp={userid:data.userid,data:data};
			 totaldata.push(tmp);		
			document.cookie="eznetcrmchat="+JSON.stringify(totaldata)+"; path=/"; 	
	}
function addLoginCookies(data){
	document.cookie="eznetcrmchatlogin="+JSON.stringify(data)+"; path=/"; 	

}

	function addCommpanySettingCookies(data){			
			document.cookie="eznetcrmcompanysetting="+JSON.stringify(data)+"; path=/"; 
	}
	function addCommpanyChatAcceptCookies(data){			
		document.cookie="addCommpanyChatAcceptCookies="+data+"; path=/"; 	
	}
	
	function updatecookies(userid,data){
		
		var totaldata=[];	
		var tmp={};
			if(getCookie('eznetcrmchat')!='undefined' && getCookie('eznetcrmchat')!=''){
				var row=getCookie('eznetcrmchat');
				var d=jQuery.parseJSON( row );
				//console.log(d);
				for(var a  in d){
					if(d[a].userid==userid){
						d[a].data.refid=data.refid;
						d[a].data.room=data.room;
					}
					
				}
				document.cookie="eznetcrmchat="+JSON.stringify(d)+"; path=/"; 
				
			}				
		
	}
	
	function clearAllCookies(){		
		document.cookie="eznetcrmchat=;";		
		document.cookie="eznetcrmcompanysetting=;";		
		document.cookie="addCommpanyChatAcceptCookies=;";
		document.cookie="eznetcrmchatlogin=;";
				
	}
	function clearAllCookiesNotLogin(){
		document.cookie="eznetcrmchat=;";		
		document.cookie="eznetcrmcompanysetting=;";		
		document.cookie="addCommpanyChatAcceptCookies=;";

	}
	
	function currentdate(){
		return new Date();
	}
	
	function getfileExt(filename){
		var ext=filename.split('.').pop().toLowerCase();
		return ext;
	}
	setInterval(function(){
		jQuery(".timesent").each(function(){
			var each = moment($(this).data('time'));
			$(this).text(each.fromNow());
		});
	},60000);


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


function getosClass(data){
	var classname='';
	var data =(typeof(data)!=='undefined')?data:'';
	console.log(data);
if(data.toLowerCase().search("linux")!= -1)
	classname='linux';
else if(data.toLowerCase().search("mac") !=-1)
	classname='mac';
else if(data.toLowerCase().search("win") !=-1)
	classname='window';

return classname;
	
}
function getbwsClass(data){
	var data =(typeof(data)!=='undefined')?data:'';
	var classname='';
	switch(data.toLowerCase()){
		case 'firefox':
		case 'mozilla':
		classname='firefox';
		break;
		case 'ie':
		case 'internet explore':
		case 'internetexplore':
		classname='ie';
		break;
		case 'safari':	
		classname='safari';
		break;
		case 'opera':	
			classname='opera';
		break;

	}
return classname;
	
	
}

function removechatTagFromCookies(userid,tagid){
	var totaldata=[];	
	var tmp={};
		if(getCookie('eznetcrmchat')!='undefined' && getCookie('eznetcrmchat')!=''){
			var row=getCookie('eznetcrmchat');
			var d=jQuery.parseJSON( row );
			//console.log(d);
			for(var a  in d){
				if(d[a].userid==userid){
					delete d[a].data.tags[tagid];
				
				}
				
			}
			document.cookie="eznetcrmchat="+JSON.stringify(d)+"; path=/";
			
		}		
	
}

function deletecookies(userid){
	
	var totaldata=[];	
	var tmp={};
		if(getCookie('eznetcrmchat')!='undefined' && getCookie('eznetcrmchat')!=''){
			var row=getCookie('eznetcrmchat');
			var d=jQuery.parseJSON( row );
			console.log(typeof(d));
			for(var a  in d){
				if(d[a].userid==userid){
					 d.splice(a);						
				}
				console.log(d);
				console.log(d.length);
			}
			createCookie('eznetcrmchat',"",-1); // delete
			
			document.cookie="eznetcrmchat="+JSON.stringify(d);
			
		}				
	
}

function createCookie(name,value,days) {
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 *1000));
        var expires = "; expires=" + date.toGMTString();
    } else {
        var expires = "";
    }
    document.cookie = name + "=" + value + expires + "; path=/";
}

function CloseChatBox(data){
	console.log('closeChatBox');
		console.log(data);
	let chatwithindex=data.chatwithindex;
	let refid=thisObj.chatwith[chatwithindex].refid;
		console.log(refid);
//delete thisObj.ChatDataByRoom[refid];

//thisObj.ChatDataByRoom.splice(refid, 1);
thisObj.chatwith.splice(chatwithindex, 1);

	
	delete thisObj.chatwith[chatwithindex];
	deletecookies(data.userid);
	
}



function isJson(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}


	
	
	

	
    
    

}]);
