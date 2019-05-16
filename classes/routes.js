// This file is required by app.js. It sets up event listeners
// for the two main URL endpoints of the application - /create and /chat/:id
// and listens for socket.io messages.
// Use the gravatar module, to turn email addresses into avatar images:
var MongoClient = require('mongodb').MongoClient, assert = require('assert');
//Connection URL 
var url = 'mongodb://127.0.0.1:27017';
var gravatar = require('gravatar');
var chatsession=[];
var nodeExcel = require('excel-export');
var xlsx = require('node-xlsx');
var fs = require('fs');
var nodemailer = require('nodemailer');
// Export a function, so that we can pass 
// the app and io instances from the app.js file:
module.exports = function(app,io){
	
	app.get('/', function(req, res){
		console.log('sdasdas');
		res.render('home');
		
	
	});		
	app.get('/create', function(req,res){			
		// Generate unique id for the room
		var id = Math.round((Math.random() * 1000000));	
		// Redirect to the random room		
		res.redirect('/chat/'+id+'?type='+req.query.type+'&detail='+req.query.detail);		
	});

	app.get('/chat/:id', function(req,res){	
console.log('sdfsfdsdf');	
		res.render('chat');  // Render the chant.html view
		sess= req.session;
		
	});
	app.get('/chat/', function(req,res){	
		sess= req.session;
		
		res.render('chat');	// Render the chant.html view
		
	});
	
	app.get('/download/', function(req,res){	
	
		var refid='';
		refid=req.query.refid;
		MongoClient.connect(url+"/myprojectdb", function(err, db) {
			if(!err) {							 
			    var collection = db.collection('message');
			            // Let's close the db
			    if(refid!='undefined' && refid!=''){
			    	 collection.find( { refid:refid }).toArray(function(err, items) {
			    		 downloadfile(items,res);			          		    	
			    		 db.close();				    		 
			    	 });
			    }
			}				
			});
				
		
		
	});
	function downloadfile(data,res){	
		  var ff='';
		  ff +="Sender"+"\t"+" Message"+"\t"+"Time"+"\n";
		  for( var a in data){
		  ff +=data[a].user+"\t"+data[a].msg+"\t"+data[a].time+"\n";
		  }		
		  res.setHeader('Content-disposition', 'attachment; filename=file.xls');
		  res.setHeader('Content-type', 'application/vnd.ms-excel');
		  res.charset = 'UTF-8';
		  res.write(ff);
		  res.end();
	}


	// Initialize a new socket.io application, named 'chat'
	var chat = io.on('connection', function (socket) {
		sess=socket.handshake.session;	
		// When the client emits the 'load' event, reply with the 
		// number of people in this chat room		
		socket.on('load',function(data){			
			console.log("load datat");
console.log(data);
			var id=data.id;
			
			if(data.rm != undefined &&  data.rm !=''){
				id=data.rm;
			}		
			console.log(data.cookiesdata);
			console.log(data.mydata);
			if(data.cookies==false && data.mydata==false ){
				if(data.type=='empeznetusr'){				
					if(data.cookies==false || data.cookies==undefined){
						socket.emit('peopleinchat', {number: 0});
					}else{
						var room = findClientsSocket(io,data.rm,{lis:data.lis});				
						if(room.length==0){
							socket.emit('peopleinchat', {number: 0});
						}else if(room.length==1){							
							socket.emit('peopleinchat', {number: 0});						
						}else if(room.length>=2){							
							socket.emit('peopleinchat', {number: 0});
						}
						
					}
				}else if(data.type=='visiterexnetusr'){				
					socket.emit('peopleinchat',{mids:data.mid,number: 1} );				
				}
			}else{						// Reload Page 	
		
				if(data.cookiesdata.length>0){
					var cookiesdata=data.cookiesdata;
					var allroom=[];
					var visitors=false;
					for (a in cookiesdata){
						socket.join(cookiesdata[a].rm);
						allroom.push(cookiesdata[a].rm);
						if(cookiesdata[a].ftype=='visiterexnetusr'){
							visitors=true;
						}
					}
					socket.room=allroom;
					socket.username = cookiesdata[0].mname;			
					socket.myroom = id;
					socket.avatar = gravatar.url(cookiesdata[0].memail, {s: '140', r: 'x', d: 'mm'});		
					socket.email = cookiesdata[0].memail;	
					socket.mids = cookiesdata[0].mid;
					socket.type = data.type;
					socket.lis = data.lis;
					if(data.type=='empeznetusr'){
						if(visitors==true)
							{
							socket.onlinestatus='busy';	
							
							}else{
								socket.onlinestatus='online';	
							}
					}
					socket.permission=(typeof(data.epermission)==='undefined')? '':data.epermission;			
					// Tell the person what he should use for an avatar
					socket.emit('img', socket.avatar);
					socket.emit('chatcontinue',cookiesdata );					
					socket.broadcast.emit('setonlinestatus', {uid:socket.mids,email:socket.email,status:socket.onlinestatus,roomid:id,name:socket.username,lis:socket.lis,epermission:socket.permission,ptype:socket.ptype});	
				}else{								// Not Chat but Login emp
						var wroomid	=	'',lis		=	'',			
						wroomid=Math.floor((Math.random() * 1000000) + 1); 
						lis=data.lis;
						socket.username = data.mydata.myname;
						socket.room = [wroomid];
						socket.myroom = wroomid;
						//socket.avatar = gravatar.url(data.mydata.myemail, {s: '140', r: 'x', d: 'mm'});		
						socket.email = data.mydata.myemail;	
						socket.mids = data.mydata.myuid;	
						socket.lis = lis;	
						socket.type = data.type;
						socket.permission=(typeof(data.epermission)==='undefined')? '':data.epermission;			
						// Tell the person what he should use for an avatar
						socket.emit('img', socket.avatar);		
					
						socket.ptype=(typeof(data.ptype)==='undefined')? '':data.ptype;		
						socket.type = data.type;
						socket.join(wroomid);			
						socket.onlinestatus='online';				// First time Employee Login
						//socket.broadcast.emit('setloginscreen', {});	
						socket.broadcast.emit('setonlinestatus', {uid:socket.mids,email:socket.email,status:socket.onlinestatus,roomid:wroomid,name:socket.username,lis:lis,epermission:socket.permission,ptype:socket.ptype});	
						socket.emit('setreloadscreen', {});	
					
					
				}
			}
		});

		// When the client emits 'login', save his name and avatar,
		// and add them to the room
		socket.on('login', function(data) {	
			var wroomid	=	'',lis		=	'',			
			wroomid=Math.round((Math.random() * 1000000));	
			lis=data.lis;
			socket.username = data.user;
			socket.room = [wroomid];
			socket.myroom = wroomid;
			socket.avatar = gravatar.url(data.avatar, {s: '140', r: 'x', d: 'mm'});		
			socket.email = data.email;	
			socket.mids = data.mid;	
			socket.lis = lis;	
			socket.type = data.type;
			socket.permission=(typeof(data.epermission)==='undefined')? '':data.epermission;			
			// Tell the person what he should use for an avatar
			socket.emit('img', socket.avatar);	
			
			if(data.type=='empeznetusr'){ 
				socket.ptype=(typeof(data.ptype)==='undefined')? '':data.ptype;		
				socket.type = data.type;			
				var usernames = [] , avatars = [] , emails = [] , mids = [],type=[];
				socket.join(wroomid);			
				if(data.cookies!=true){						// First time Employee Login
					data.onlinestatus='online';
				}				
				if(data.cookies==true) {				
					// If Cookies True
					data.onlinestatus='busy';
					var room = findClientsSocket(io,wroomid,{lis:lis});				
					if (room.length == 1 ) {							
						usernames.push(room[0].username);
						usernames.push(socket.username);						
						emails.push(room[0].email);
						emails.push(socket.email);						
						avatars.push(room[0].avatar);
						avatars.push(socket.avatar);						
						mids.push(room[0].mids);
						mids.push(socket.mids);
						type.push(room[0].type);
						type.push(socket.type);						
						var refid=data.refid;
						var chatdata={boolean: true,id: wroomid,users: usernames,avatars: avatars,emails:emails,mids:mids,type:type,refid:data.refid,lis:lis}
						chat.in(wroomid).emit('startChat',chatdata );
					}
				}
				socket.onlinestatus=data.onlinestatus;				
				// Add the client to the room	
				//console.log('setonlinestatus');
				//console.log({uid:socket.mids,email:socket.email,status:data.onlinestatus,roomid:data.id,name:socket.username,lis:data.lis,epermission:socket.permission,ptype:socket.ptype});
				socket.broadcast.emit('setonlinestatus', {uid:socket.mids,email:socket.email,status:data.onlinestatus,roomid:wroomid,name:socket.username,lis:lis,epermission:socket.permission,ptype:socket.ptype});
			}else if(data.type='visiterexnetusr' || typeof(data.type)==='undefined'){         // Visitor  Login
				socket.type='visiterexnetusr';
				data.id='';
				var senddata=[];				
				if(data.cookies==true){					
					var empId=getEMpIDbyMID(io,{lis:lis,permisssion:'external',ptype:data.ptype,uid:data.fid});					
				}else{
				var empId=findRunningClientsSocket(io,{lis:lis,permisssion:'external',ptype:data.ptype});		// Find Employee	
				}
				console.log('emmpid');
				console.log(empId);
				
				if(empId!== undefined){											 					// Emp available 
					var emproom=getRoombyId(io,empId);	
					var customroom=Math.floor((Math.random() * 1000000) + 1);				
					updatesatatus(io,empId,'busy');
					wroomid=emproom[0];
					console.log(wroomid);
					
					var room = findClientsSocket(io,wroomid,{lis:lis});	
			
					wroomid=customroom;
					console.log('employer socket');
					console.log(room);
					var totalroom=socket.room;
					totalroom.push(wroomid);					
					socket.room = totalroom;				
					socket.emit('img', socket.avatar);				
					socket.join(wroomid);
					room[0].room.push(wroomid);
					room[0].join(wroomid);
					
					
					if (room.length == 1 ) {
						var usernames = [] , avatars = [] , emails = [] , mids = [],type=[];
						usernames.push(room[0].username);
						usernames.push(socket.username);						
						emails.push(room[0].email);
						emails.push(socket.email);						
						avatars.push(room[0].avatar);
						avatars.push(socket.avatar);						
						mids.push(room[0].mids);
						mids.push(socket.mids);
						type.push(room[0].type);
						type.push(socket.type);
						var refid='';
						if(data.cookies!=true){				
							 var currentdate =currenttime();					
							  data.time=currentdate;	
							  var address = socket.handshake.address;
							  refid = randomString(16, 'aA#');
								MongoClient.connect(url+"/myprojectdb", function(err, db) {
									if(!err) {							
										var talkdata={empid:room[0].mids,visitorid:socket.mids,empname:room[0].username,visitorname:socket.username,empemail:room[0].email,visitoremail:socket.email,roomid:wroomid,ip:address,time:currentdate,refid:refid,lis:lis};
									    var collection = db.collection('talklist');
									    	collection.insert(talkdata, function(err, docs) {
										    		 db.close();										    		
										    		 var chatdata={boolean: true,id: wroomid,users: usernames,avatars: avatars,emails:emails,mids:mids,refid:refid,lis:lis,type:type}
										    		 if(sess.chatdata){										    			
										    			 chatsession=sess.chatdata;
										    		 }										    		 
										    	
										    		 chat.in(wroomid).emit('startChat', chatdata);		
										    			var seconduser={mid:room[0].mids,status:'busy'};				
														senddata.push(seconduser);					
														io.sockets.emit('updateStatus', senddata);
									    	});
										}									
									});
							}else{					
								var chatdata={boolean: true,id: wroomid,users: usernames,avatars: avatars,emails:emails,mids:mids,refid:data.refid,lis:lis}
								chat.in(wroomid).emit('startChat',chatdata );
								var seconduser={mid:room[0].mids,status:'busy'};				
								senddata.push(seconduser);					
								io.sockets.emit('updateStatus', senddata);
							}
					}			
				}else{				// Emp Not available 
					 socket.emit('noemp',{uid:socket.mids,email:socket.email,name:socket.username,lis:lis,epermission:socket.permission,ptype:data.ptype});
				}
			}
		});		
		socket.on('chathistory', function(data) {			
			MongoClient.connect(url+"/myprojectdb", function(err, db) {
				if(!err) {							 
				    var collection = db.collection('message');
				            // Let's close the db
				    if(data.refid!='undefined' && data.refid!=''){
				    	 collection.find( { refid:data.refid }).toArray(function(err, items) {
				    		 data.items=items;
				    		 data.requserid=socket.mids;
				           socket.emit('chathistory', data);				    	
				    		 db.close();				    		 
				    	 });
				    }
				}				
				});
						
		});
		socket.on('chathistoryTransfer', function(data) {
			console.log('chathistoryTransfer');
			console.log(data);
			var condition={};
			console.log(data.email1);
			if(data.email1!=undefined){	
				 data.show=true;
				condition={ $or: [ {$and: [{ "toemail": data.email1}, { "email": data.email2 }]},{ $and: [{ "toemail": data.email2},{ "email": data.email1 }]} ] }
				//condition={$or:[{$and:[{email:data.email1},{toemail:data.email2}]},{$and:[{email:data.email2},{toemail:data.email1}]}]};
			}else if(data.refid != undefined){
				condition={"refid":data.refid};
				 data.show=false;
			}
			console.log(condition);
			MongoClient.connect(url+"/myprojectdb", function(err, db) {
				if(!err) {							 
				    var collection = db.collection('message');
				            // Let's close the db
				    if(data.refid!='undefined' && data.refid!=''){
				    	 collection.find( condition).toArray(function(err, items) {
				    		// console.log(items);
				    		 data.items=items;				    		
				    		 	socket.emit('chathistoryTransfer', data);				    	
				    		 db.close();				    		 
				    	 });
				    }
				}				
				});
						
		});
		socket.on('continuechat', function(data) {	
						
		});
		socket.on('logoff', function(data) {
				
				if(socket.room.length>0){
				for (var ra in socket.room){
					socket.leave(socket.room[ra]);
				}
			}
				
				socket.onlinestatus='logoff';	
				senddata=[];
				var user={mid:socket.mids,lis:socket.lis};				
				senddata.push(user);		
				io.sockets.emit('removeonlineuser', senddata);
		});
				socket.on('myip', function(data) {
				console.log('User'+data.uname);
				console.log(socket.id);
				console.log(socket.room);
				console.log(socket.myroom);
				console.log(socket.onlinestatus);				
				console.log(socket.lis);
				console.log(socket.type);
				console.log(socket.permission);
				
				
				
			
		});
		socket.on('emailchathistory', function(data) {
			var refid=emails='';
			refid=data.refid;
			emails=data.emails;			
			MongoClient.connect(url+"/myprojectdb", function(err, db) {
				if(!err) {							 
				    var collection = db.collection('message');
				            // Let's close the db
				    if(refid!='undefined' && refid!=''){
				    	 collection.find( { refid:refid }).toArray(function(err, items) {
				    		 emailhistory(items,emails);			          		    	
				    		 db.close();				    		 
				    	 });
				    }
				}				
				});
			
		});
		
		function emailhistory(data,emails){			
			 var ff='';
			  ff +="Sender"+"\t"+" Message"+"\t"+"Time"+"\n";
			  for( var a in data){
			  ff +=data[a].user+"\t"+data[a].msg+"\t"+data[a].time+"\n";
			  }		
			var toemail=emails.toString();
			
			var transporter = nodemailer.createTransport();
			transporter.sendMail({
			    from: 'info@virtualstacks.com',
			    to: toemail,
			    subject: 'Chat History',
			    text: 'Please find the chat history attach with it. ',
			    attachments: [
			                  {   // utf-8 string as an attachment
			                      filename: 'chathistory.xls',
			                      content: ff,
			                      contentType: 'application/vnd.ms-excel',
			                    
			                  }]
			},function(err,info){
				
				
			});
			
		}
		
		socket.on('testsocket', function(data) {
		
			socket.emit('jsresult',data);
	});
	
		// Somebody left the chat
		socket.on('disconnect', function() {
			// Notify the other person in the chat room
			// that his partner has left		
			socket.broadcast.to(this.room).emit('leave', {
				boolean: true,
				room: this.room,
				user: this.username,
				avatar: this.avatar,
				mids:this.mids
			});		
			senddata=[];
			var user={mid:socket.mids};				
			senddata.push(user);		
			io.sockets.emit('removeonlineuser', senddata);
			// leave the room
			socket.leave(socket.room);
		});		
		socket.on('clearchat', function(data) {	
			//console.log('clearchat');
		//	console.log(data);
			var chatroom=data.roomid;
			var lis=data.lis;
			var othe=[];
			var room = findClientsSocket(io, chatroom,{lis:lis});
		//	console.log(room.length);					
			if(room.length==1){
				  othe=room[0];
			 // Set busy other employee
			}else if(room.length>1){
				if(room[0].mids==socket.mids)
					{
						othe=room[1];
					}else{
						othe=room[0];
					}
			}else{
				return false;
			}
			var i = socket.room.indexOf(chatroom);
			if(i != -1) {
				socket.room.splice(i, 1);
			}
			var oi=othe.room.indexOf(chatroom);
			if(oi != -1) {
				othe.room.splice(oi, 1);
			}
			chat.in(chatroom).emit('autoclearchat',{id:chatroom,mid:data.mid,type:type,empmid:socket.mids,emproom:socket.myroom,lis:lis} );
			socket.leave(chatroom);			
			//othe.leave(chatroom);
			//chat.in(chatroom).emit('leaveuser',{chatroom:chatroom,type:type,empmid:socket.mids,lis:lis,leave} );
			
			var senddata=[];
			if(data.type=='visiterexnetusr'){			
				//SetVisibleStatus(io,data.mid,'online');
				var userfirst={mid:othe.mids,status:'online'};
				senddata.push(userfirst);
				io.sockets.emit('updateStatus', senddata);
			}else if(data.type=='empeznetusr' && othe.type=='visiterexnetusr'){
				
					socket.onlinestatus='online';							
					var userfirst={mid:othe.mids,status:'online'};
					var type=othe.type;				
				if(type=='empeznetusr'){
					senddata.push(userfirst);
				}
				var seconduser={mid:socket.mids,status:'online'};				
				senddata.push(seconduser);					
				io.sockets.emit('updateStatus', senddata);
			}
			
			
		});
		socket.on('autoclearchat', function(data) {
		
			if(socket.room[0]!=data.id){
				//console.log(typeof(socket.myroom)+'---'+socket.room+'---'+socket.myroom+'--'+socket.type);
				if(socket.myroom!='undefined' && socket.room!=socket.myroom && socket.type=='empeznetusr'){					
					socket.leave(data.room);
					socket.join(socket.myroom);
					socket.room=socket.myroom;
				}else if(socket.type=='visiterexnetusr'){	
					
						socket.leave(data.id);		
						socket.room=[data.newroom];
						socket.join(data.newroom);         
					}
				}else{
					console.log('NO Data');					
				}
		});
		socket.on('updatestatus', function(data) {
			var senddata=[];
			
			var userfirst={mid:data.mids,status:data.status,lis:data.lis};	
			senddata.push(userfirst);	
			socket.onlinestatus=data.status;
			io.sockets.emit('updateStatus', senddata);
		});
		

		// Handle the sending of messages
		socket.on('msg', function(data){			
			 var currentdate =currenttime();			
			 data.time=currentdate;				
				MongoClient.connect(url+"/myprojectdb", function(err, db) {
					if(!err) {							 
					    var collection = db.collection('message');
					    collection.insert(data, function(err, docs) { 					    	
					    	// collection.find( { $or: [ { "toemail": 'mahir@gmail.com'}, { "toemail": 'pankaj@gmail.com' } ] }).toArray(function(err, items) {
					    		 db.close();
					    	 //});
					    });
					}					
					});					
			socket.broadcast.to(data.room).emit('receive', {msg: data.msg, user: data.user, img: data.img,room:data.room});
		});
		
		socket.on('offlinemsg', function(data){
			 var currentdate =currenttime();			
			 data.time=currentdate;	
			 data.status="open";			
				MongoClient.connect(url+"/myprojectdb", function(err, db) {
					if(!err) {							 
					    var collection = db.collection('offlinemessage');
					    collection.insert(data, function(err, docs) { 					    	
					    	socket.emit('offlinemsg',{responce:"<strong>Thank you<strong><br/>Your message has been successfully sent. We will contact you very soon!."} );
					    });
					}					
					});
			socket.broadcast.to(socket.room).emit('receive', {msg: data.msg, user: data.user, img: data.img});
		});
		socket.on('checkonline', function(data){
			var empdata=GetAllAvailabelEmp(io,data.lis);	
			var responce=[];
			var tmpdata=[];
			
			if(empdata!=null && empdata !='' && empdata!=undefined){
				
				for (var id in empdata) {
					if(empdata[id].type=='empeznetusr'){
						tmpdata={username : empdata[id].username, room : empdata[id].room, email : empdata[id].email, mids:empdata[id].mids, type:empdata[id].type,epermission:empdata[id].permission,ptype:empdata[id].ptype }
						responce.push(tmpdata);
					}	
				}
			}
			socket.emit('checkonline',responce );		
		});
		
		socket.on('onlineuser', function(data){
			console.log('onlineuser');
			console.log(data);
			var empdata=GetAllEmp(io,data.lis);	
			var responce=[];
			var tmpdata=[];			
			if(empdata!=null && empdata !='' && empdata!=undefined){				
				for (var id in empdata) {	
					console.log(empdata[id].username);
					if(empdata[id].type=='empeznetusr'  && empdata[id].lis==data.lis){
						tmpdata={username : empdata[id].username, room : empdata[id].room, email : empdata[id].email, mids:empdata[id].mids, type:empdata[id].type,status:empdata[id].onlinestatus,lis:empdata[id].lis,epermission:empdata[id].permission,ptype:empdata[id].ptype  }
						responce.push(tmpdata);
					}	
				}
			}
			socket.emit('onlineuser',responce );			
		});
		
		
		
		socket.on('transferrequest', function(data){			
			var responce=[];
			var tmpdata=[];		
			//console.log('transfer data:');
			//console.log(data);
			var msg='You Have Transfer Request From '+data.empname+'  Talking with '+data.visitorname;
			socket.broadcast.to(data.tUserroomid).emit('receivetransferrequest', {msg: msg, trantoroom:data.tUserroomid,tFromroom: data.myroom,visitorname:data.visitorname,empname:data.empname,vmid:data.vmid,refid:data.refid});
			
			
		});
		socket.on('leaveme', function(data){	
			//console.log('LeaveMe');
			//console.log(data);
			socket.leave(data.roomid);
		});
		
		socket.on('accepttransfer', function(data){		
			var wroomid='',lis='';
			lis=data.lis;	
			var othe=[];
			var usernames = [], avatars = [],emails = [],mids = [], totalroom=[],type=[];
			var customroom=Math.floor((Math.random() * 1000000) + 1); 
			
			wroomid=data.vistorfromroomid;
			
			var room = findClientsSocket(io,wroomid,{lis:lis});		
			
				var empindex=0;
			 if(room.length==1){
					othe=room[0];
					
		    	}else if(room.length==2 ){
		    		if(room[0].mids==data.vmid){
		    		othe=room[0];
		    		//room[0].leave(data.vistorfromroomid);
		    		empindex=1;
		    		}else{
		    			othe=room[1];
			    		//room[0].leave(data.vistorfromroomid);
			    		empindex=0;
		    		}
		    	}else{
		    		return false;
		    	}
			var currentroom=totalroom=socket.room;				
			wroomid=customroom;
			
			var totalroom=socket.room;
			totalroom.push(wroomid);					
			socket.room = totalroom;				
			socket.emit('img', socket.avatar);	
	
			usernames.push(othe.username);
			usernames.push(socket.username);		
			emails.push(othe.email);
			emails.push(socket.email);	
			avatars.push(othe.avatar);
			avatars.push(socket.avatar);
			mids.push(othe.mids);
			mids.push(socket.mids);	
			type.push(othe.type);
			type.push(socket.type);	
		
		socket.join(wroomid);              	// Join Transfer Room 
		othe.room.push(wroomid);
		var i = othe.room.indexOf(data.vistorfromroomid);
		if(i != -1) {
			othe.room.splice(i, 1);
		}
		othe.leave(data.vistorfromroomid);       
		othe.join(wroomid);             // Other User Join
		socket.onlinestatus='busy';
			// Tell the person what he should use for an avatar					
		var currentdate =currenttime();					
		data.time=currentdate;	
		var address = socket.handshake.address;
		var ttt={
				boolean: true,
				id: wroomid,
				users: usernames,
				avatars: avatars,
				emails:emails,
				mids:mids,
				refid:data.refid,
				type:type,
				join:true,
				preroom:data.vistorfromroomid,
				reid:data.reid
			};	
			chat.in(wroomid).emit('transferstartChat', ttt);	
			chat.in(data.vistorfromroomid).emit('cleanchat', {boolean: true,id: data.vistorfromroomid,users: usernames,avatars: avatars,emails:emails,mids:mids,refid:data.refid,join:true});
			room[empindex].leave(data.vistorfromroomid);
			var senddata=[];
			data.refid;
			
			
			var userfirst={mid:room[empindex].mids,status:'online'};	
			senddata.push(userfirst);	
			var second={mid:socket.mids,status:'busy'};
				senddata.push(second);	
			//console.log('Update Transfer status');
			//console.log(senddata);
			io.sockets.emit('updateStatus', senddata);	
			
			
			
			
			
			
			
			
			/*var roomvisitor = findClientsSocket(io, data.vistorfromroomid,{lis:data.lis});
			var vinfo=[];
			if(roomvisitor[0].type=='visiterexnetusr'){
				vinfo=roomvisitor[0];
			}else if(roomvisitor[1].type=='visiterexnetusr'){
				vinfo=roomvisitor[1];
			}
			var visitorinfo={uid:vinfo.mids,email:vinfo.email,username:vinfo.username,avtar:vinfo.avatar,joinroom:data.myroom}
			//console.log('accepttransfer : visitor info');
			//console.log(visitorinfo);
			chat.in(data.vistorfromroomid).emit('visitorautoaccept', visitorinfo);
			*/
		});
	socket.on('visitorautoaccept', function(data){		
		var visitorroomdata=findClientsSocket(io, socket.room,{lis:data.lis});
		var currentroom=socket.room;
		var preemp=[];
		if(visitorroomdata[0].type=='empeznetusr'){
			preemp=visitorroomdata[0];
		}else if(visitorroomdata[1].type=='empeznetusr'){
			preemp=visitorroomdata[1];
		}
		var room = findClientsSocket(io, data.joinroom,{lis:data.lis});
		var usernames = [],
		avatars = [];
	    emails = [];
	    mids = [];
		socket.username = data.name;
		socket.room = data.joinroom;
		socket.avatar = data.avtar;		
		socket.email = data.email;	
		socket.mids = data.uid;	
		socket.type = data.type; 
		// Tell the person what he should use for an avatar
		socket.emit('img', socket.avatar);
		// Add the client to the room
		socket.leave(data.currentroom); // Leave Current Room
		socket.join(data.joinroom);		// Join Transfer Room 
	
		SetVisibleStatus(io,preemp.mids,'online'); // Set online previous emp
		SetVisibleStatus(io,room[0].mids,'busy');
		usernames.push(room[0].username);
		usernames.push(socket.username);		
		emails.push(room[0].email);
		emails.push(socket.email);	
		avatars.push(room[0].avatar);
		avatars.push(socket.avatar);
		mids.push(room[0].mids);
		mids.push(socket.mids);
		type.push(room[0].type);
		type.push(socket.type);
		var ttt={
				boolean: true,
				id: data.joinroom,
				users: usernames,
				avatars: avatars,
				emails:emails,
				mids:mids,
				refid:data.refid,
				type:type,
				join:true
			};	
			chat.in(data.joinroom).emit('transferstartChat', ttt);	
			chat.in(currentroom).emit('cleanchat', ttt);
			var senddata=[];
			var userfirst={mid:preemp.mids,status:'online'};	
			senddata.push(userfirst);	
			var second={mid:room[0].mids,status:'busy'};
				senddata.push(second);	
			//console.log('Update Transfer status');
			//console.log(senddata);
			io.sockets.emit('updateStatus', senddata);
			
		});
	
socket.on('joinchat', function(data){		
			var wroomid='',lis='';
			lis=data.lis;	
			var othe=[];
			var usernames = [], avatars = [],emails = [],mids = [], totalroom=[],type=[];
			var customroom=Math.floor((Math.random() * 1000000) + 1); 
			//   updatesatatus(io,data.reqroomid,'busy');
			wroomid=data.reqroomid;			
			var room = findClientsSocket(io,wroomid,{lis:lis});		
		
			 if(room.length==1){
					othe=room[0];   			
		    	}else{
		    		othe=room[1];
		    	}
			var currentroom=totalroom=socket.room;				
			wroomid=customroom;
			
			var totalroom=socket.room;
			totalroom.push(wroomid);					
			socket.room = totalroom;			
			socket.emit('img', socket.avatar);	
         
		//SetVisibleStatus(io,othe.mids,'busy');
		usernames.push(othe.username);
		usernames.push(socket.username);		
		emails.push(othe.email);
		emails.push(socket.email);	
		avatars.push(othe.avatar);
		avatars.push(socket.avatar);
		mids.push(othe.mids);
		mids.push(socket.mids);	
		type.push(othe.type);
		type.push(socket.type);	
		socket.join(wroomid);              	// Join Transfer Room 
		othe.room.push(wroomid);
		othe.join(wroomid);             // Other User Join
		//socket.onlinestatus='busy';
			// Tell the person what he should use for an avatar					
		var currentdate =currenttime();					
		data.time=currentdate;	
		var address = socket.handshake.address;
		refid = randomString(16, 'aA#');
		MongoClient.connect(url+"/myprojectdb", function(err, db) {
			if(!err) {							
					var talkdata={empid:room[0].mids,visitorid:socket.mids,empname:room[0].username,visitorname:socket.username,empemail:room[0].email,visitoremail:socket.email,roomid:data.id,ip:address,time:currentdate,refid:refid};
					var collection = db.collection('talklist');
					collection.insert(talkdata, function(err, docs) {
						var ttt={boolean: true,id: wroomid,users: usernames,avatars: avatars,emails:emails,mids:mids,refid:refid,join:true,type:type,reid:''};	
						chat.in(wroomid).emit('transferstartChat', ttt);
					
						//	SetVisibleStatus(io,othe.mids,'busy');
						//	SetVisibleStatus(io,socket.mids,'busy');
						//var senddata=[];
						//var userfirst={mid:room[0].mids,status:'busy'};
						//var seconduser={mid:socket.mids,status:'busy'};
						//senddata.push(userfirst);
						//senddata.push(seconduser);
						//io.sockets.emit('updateStatus', senddata);						    		
				});
			}
					
		});
		
	});
	
});
	
};

function findClientsSocket(io,roomId,dynamicdata,namespace) {
	var res = [],
		ns = io.of(namespace ||"/");    // the default namespace is "/"
	 	if (typeof(dynamicdata.lis)==='undefined') dynamicdata.lis = '';
		if (ns) {
		for (var id in ns.connected) {	
			if(roomId) {
				//var index = ns.connected[id].rooms.indexOf(roomId) ; 				
				var index =findelemInobj(ns.connected[id].rooms,roomId);
				/*console.log(ns.connected[id].rooms);
				console.log(ns.connected[id].room);
				console.log(roomId);
				console.log(index);
				console.log(typeof(ns.connected[id].room));
				console.log(typeof(ns.connected[id].rooms));
				console.log('----------------------------');*/
				//|| ns.connected[id].room.indexOf(roomId)!=-1
				if((index != false ) && dynamicdata.lis==ns.connected[id].lis) {
					if(typeof(dynamicdata.permissioncheck)==='undefined'){ 
						res.push(ns.connected[id]);	
					}else if(ns.connected[id].permission.indexOf(dynamicdata.permissioncheck) > -1){
						res.push(ns.connected[id]);	
					}
				}
			}else {
				res.push(ns.connected[id]);
			}
		}
	}

	return res;
}

function findRunningClientsSocket(io, dynamicdata,namespace) {

	var res = [],
	ns = io.of(namespace ||"/");    // the default namespace is "/"	
	 var lis = (typeof(dynamicdata.lis)==='undefined') ? '':dynamicdata.lis;
	 var permisssion = (typeof(dynamicdata.permisssion)==='undefined') ? '':dynamicdata.permisssion;
	 var ptype = (typeof(dynamicdata.ptype)==='undefined') ? '':dynamicdata.ptype;
if (ns) {	
	var abarray = [];
	var allarray = [];
	var roomss = [];
	for (var id in ns.connected) {				
			allarray.push(id);
			if(ns.connected[id].type=='empeznetusr'){
			//	console.log(ns.connected[id].onlinestatus+'----'+ns.connected[id].username);
				if(ns.connected[id].onlinestatus=='online' && lis==ns.connected[id].lis && ns.connected[id].permission.indexOf(permisssion) > -1){
					if(ns.connected[id].ptype.indexOf(ptype) > -1 || ptype=='' || ptype.toLowerCase() =='all'){
						abarray.push(id);
						roomss.push(ns.connected[id].room);
					}
				}
			}else{
			
			}		
	}	

	var rand = abarray[Math.floor(Math.random() * abarray.length)];	
}
return rand;
}

function getEMpIDbyMID(io, dynamicdata,namespace){
	var res = [],
	ns = io.of(namespace ||"/");    // the default namespace is "/"	
	 var lis = (typeof(dynamicdata.lis)==='undefined') ? '':dynamicdata.lis;
	 var permisssion = (typeof(dynamicdata.permisssion)==='undefined') ? '':dynamicdata.permisssion;
	 var ptype = (typeof(dynamicdata.ptype)==='undefined') ? '':dynamicdata.ptype;
	 var uid = (typeof(dynamicdata.uid)==='undefined') ? '':dynamicdata.uid;
if (ns) {	
	var abarray = [];
	var allarray = [];
	var roomss = [];
	for (var id in ns.connected) {				
			allarray.push(id);
			if(ns.connected[id].type=='empeznetusr'){
			//	console.log(ns.connected[id].onlinestatus+'----'+ns.connected[id].username);
				if(lis==ns.connected[id].lis && uid==ns.connected[id].mids ){
						abarray.push(id);
				
				}
			}else{
			
			}		
	}	

	var rand = abarray[Math.floor(Math.random() * abarray.length)];	
}
return rand;
	
}



function GetAllAvailabelEmp(io, lis,namespace) {

	var res = [],
	ns = io.of(namespace ||"/");    // the default namespace is "/"	
if (ns) {	
	var abarray = [];
	var allarray = [];
	var empdata = [];
	for (var id in ns.connected) {				
			allarray.push(id);
			if(ns.connected[id].type=='empeznetusr' && ns.connected[id].lis==lis){
			
				if(ns.connected[id].onlinestatus=='online'){
					abarray.push(id);
					empdata.push(ns.connected[id]);
				}
			}else{
			
			}		
	}	
	res=empdata;
	
}
return res;
}
function GetAllEmp(io, lis,namespace) {

	var res = [],
	ns = io.of(namespace ||"/");    // the default namespace is "/"	
if (ns) {	
	var abarray = [];
	var allarray = [];
	var empdata = [];
	for (var id in ns.connected) {				
			allarray.push(id);
			if(ns.connected[id].type=='empeznetusr' && ns.connected[id].lis==lis){			
					abarray.push(id);
					empdata.push(ns.connected[id]);			
			}else{
			
			}		
	}	
	res=empdata;
	
}
return res;
}

function SetVisibleStatus(io,userid,status, namespace) {
	var res = [],
	ns = io.of(namespace ||"/");    // the default namespace is "/"	
if (ns) {	
	var abarray = [];
	var allarray = [];
	var empdata = [];
	for (var id in ns.connected) {			
			if(ns.connected[id].type=='empeznetusr' && ns.connected[id].mids==userid){
				ns.connected[id].onlinestatus=status;				
			}	
	}	
	
	
}

}


function updatesatatus(io,id,status,namespace){
	ns = io.of(namespace ||"/"); 	
	ns.connected[id].onlinestatus=status;	
}

function getRoombyId(io,id,namespace){
	var roomid='';
	ns = io.of(namespace ||"/"); 	
	roomid= ns.connected[id].room;
	return roomid;
}
 function randomString(length, chars) {
    var mask = '';
    if (chars.indexOf('a') > -1) mask += 'abcdefghijklmnopqrstuvwxyz';
    if (chars.indexOf('A') > -1) mask += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    if (chars.indexOf('#') > -1) mask += '0123456789';
    if (chars.indexOf('!') > -1) mask += '~`!@#$%^&*()_+-={}[]:";\'<>?,./|\\';
    var result = '';
    for (var i = length; i > 0; --i) result += mask[Math.round(Math.random() * (mask.length - 1))];
    return result;
}
 
 function setonlinestatus(io,socket){
	 
	 socket.broadcast.emit('message', "this is a test");
 }
 
 var chatin=function(roomid,emit,data){	 
	 chat.in(roomid).emit(emit, {boolean: true,id: data.id,users: data.usernames,avatars: data.avatars,emails:data.emails,mids:data.mids,refid:data.refid,lis:data.lis});		
 }
 
 var currenttime =function(){
	 var Currenttime= new Date();
	 var cmonth =Currenttime.getUTCMonth() +1;
	 var cdate =Currenttime.getUTCDate();
	 var cyear =Currenttime.getUTCFullYear();
	 var chour =Currenttime.getHours();
	 var cminuts =Currenttime.getMinutes();
	 var cseconds =Currenttime.getSeconds();
	 var currentdate =cyear + "-" + cmonth + "-" + cdate + ' ' + chour + ':' + cminuts + ':' + cseconds;					
	 return currentdate;
	
}
 
function findelemInobj(obj,ele){
for (v in obj) {		
	if(ele==obj[v]){
		return v;
	}
}
return false;

	
}


