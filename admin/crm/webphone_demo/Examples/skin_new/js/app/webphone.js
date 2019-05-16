define(["jquery","common","notifications","stringres","global"],function(e,t,n,r,i){function h(){try{u=false;a=null;f=0;l=false;c="true";I.pollstatus=true}catch(e){t.PutToDebugLogException(2,"webphone: Init",e)}}function v(){try{t.PutToDebugLog(2,"EVENT, webphone: CheckWebphonetojs called");setTimeout(function(){t.PutToDebugLog(2,"EVENT, webphone: CheckWebphonetojs starting timer");if(I.pollstatus===true){i.polltimerid=setInterval(function(){if(t.GetParameter("devicetype")===t.DEVICE_WEBPHONE()){webphonetojs(a.API_Poll())}else if(t.GetParameter("devicetype")===t.DEVICE_WIN_SOFTPHONE()){t.WinAPI("API_Poll",function(e){if(!t.isNull(e)&&e.length>0){webphonetojs(e)}else{t.PutToDebugLog(2,"ERROR, API_Poll() windows unknown notification")}})}},p)}},d);setTimeout(function(){t.WinAPI("API_RegisterNoParam",function(){t.PutToDebugLog(2,"ERROR, webphone API_RegisterNoParam called")})},d+1e3)}catch(e){t.PutToDebugLogException(2,"webphone: CheckWebphonetojs",e)}}function m(e,n){try{h();if(!t.isNull(e)){o["username"]=e}if(!t.isNull(n)){o["password"]=n}try{if(!t.isNull(t.settmap)){for(var r in t.settmap){var i=t.settmap[r];if(t.isNull(i)){continue}if(r==="serveraddress_orig"){r="serveraddress"}o[r]=i[t.SETT_VALUE]}}}catch(s){t.PutToDebugLogException(2,"webphone: Start Setting parameters",s)}D();j()}catch(s){t.PutToDebugLogException(2,"webphone: Start",s)}}function g(){t.PutToDebugLog(2,"EVENT, webphone: StartWin called");try{h();var e="";for(var n in o){if(t.isNull(n)||n.length<1){continue}if(e.length>0){e=e+"\r\n"}e=e+n+"="+o[n]}if(!t.isNull(t.settmap)){for(var n in t.settmap){if(t.isNull(n)||n.length<1){continue}if(e.length>0){e=e+"\r\n"}var r=t.settmap[n];e=e+n+"="+r[0]}}e=e+"\r\n"+"dummy=3";t.PutToDebugLog(2,"EVENT, webphone: StartWin: API_SetParameters called");t.WinAPI("API_SetParameters",function(e){if(!e){t.PutToDebugLog(2,"ERROR, webphone: StartWin: API_SetParameters callback: failed to save settings")}t.WinAPI("API_Start",function(e){if(!e){t.PutToDebugLog(2,"ERROR, webphone: StartWin: API_Start callback: failed to start webphone")}});v()},e)}catch(i){t.PutToDebugLogException(2,"webphone: StartWin",i)}}function y(){try{if(I.webphone_started===true){h();var e="";for(var n in o){if(isNull(n)||n.length<1){continue}if(e.length>0){e=e+"\r\n"}e=e+n+"="+o[n]}if(!isNull(t.settmap)){for(var n in t.settmap){if(isNull(n)||n.length<1){continue}if(e.length>0){e=e+"\r\n"}e=e+n+"="+t.settmap[n]}}t.WinAPI("API_SetParameters",function(e){if(e){t.PutToDebugLog(2,"EVENT, webphone: StartWin started successfully");t.WinAPI("API_StartStack",null);v()}else{t.PutToDebugLog(2,"EVENT, webphone: StartWin started successfully")}},e)}else{t.WinAPI("API_Test",function(e){if(e){I.webphone_started=true}setTimeout(function(){g()},300)})}}catch(r){t.PutToDebugLogException(2,"webphone: StartWin",r)}}function b(e,n){try{if(!F()){t.PutToDebugLog(3,"ERROR, webphone: Call(), no applethandle ");return false}return a.API_Call(e,n)}catch(r){t.PutToDebugLogException(2,"webphone: Call",r)}}function w(e){try{if(!F()){t.PutToDebugLog(3,"ERROR, webphone: Hangup(), no applethandle ");return false}return a.API_Hangup(e)}catch(n){t.PutToDebugLogException(2,"webphone: Hangup",n)}}function E(e){try{if(!F()){t.PutToDebugLog(3,"ERROR, webphone: Accept(), no applethandle ");return false}return a.API_Accept(e)}catch(n){t.PutToDebugLogException(2,"webphone: Accept",n)}}function S(e){try{if(!F()){t.PutToDebugLog(3,"ERROR, webphone: Reject(), no applethandle ");return false}return a.API_Reject(e)}catch(n){t.PutToDebugLogException(2,"webphone: Reject",n)}}function x(e,n){try{if(!F()){t.PutToDebugLog(3,"ERROR, webphone: Conference(), no applethandle ");return false}return a.API_Conf(e,n)}catch(r){t.PutToDebugLogException(2,"webphone: Conference",r)}}function T(e,n){try{if(!F()){t.PutToDebugLog(3,"ERROR, webphone: Transfer(), no applethandle ");return false}return a.API_Transfer(e,n)}catch(r){t.PutToDebugLogException(2,"webphone: Transfer",r)}}function N(e,n){try{if(!F()){t.PutToDebugLog(3,"ERROR, webphone: Dtmf(), no applethandle ");return false}return a.API_Dtmf(e,n)}catch(r){t.PutToDebugLogException(2,"webphone: Dtmf",r)}}function C(e,n,r){try{if(!F()){t.PutToDebugLog(3,"ERROR, webphone: MuteEx(), no applethandle ");return false}return a.API_MuteEx(e,n,r)}catch(i){t.PutToDebugLogException(2,"webphone: MuteEx",i)}}function k(e,n){try{if(!F()){t.PutToDebugLog(3,"ERROR, webphone: Hold(), no applethandle ");return false}return a.API_Hold(e,n)}catch(r){t.PutToDebugLogException(2,"webphone: Hold",r)}}function L(e,n,r){try{if(!F()){t.PutToDebugLog(3,"ERROR, webphone: SendChat(), no applethandle ");return false}return a.API_SendChat(e,n,r)}catch(i){t.PutToDebugLogException(2,"webphone: SendChat",i)}}function A(){try{if(!F()){t.PutToDebugLog(3,"ERROR, webphone: AudioDevice(), no applethandle ");return false}return a.API_AudioDevice()}catch(e){t.PutToDebugLogException(2,"webphone: AudioDevice",e)}}function O(e,n){try{if(!F()){t.PutToDebugLog(3,"ERROR, webphone: SetVolume(), no applethandle ");return false}return a.API_SetVolume(e,n)}catch(r){t.PutToDebugLogException(2,"webphone: SetVolume",r)}}function M(e,n){try{if(!F()){t.PutToDebugLog(3,"ERROR, webphone: SetParameter(), no applethandle ");return false}return a.API_SetParameter(e,n)}catch(r){t.PutToDebugLogException(2,"webphone: SetParameter",r)}}function _(){try{if(!F()){t.PutToDebugLog(3,"ERROR, webphone: IsRegistered(), no applethandle ");return false}return a.API_IsRegistered()}catch(e){t.PutToDebugLogException(2,"webphone: IsRegistered",e)}}function D(){try{window.attributes=s;window.parameters=o;mwpdeploy.runApplet(s,o,"1.5");c=t.GetParameter("isfirststart");u=true;return true;var n="none";var r=function(){var e=[];var t=[];var r;for(r in s){if(s.hasOwnProperty(r)){e.push(r+'="'+s[r]+'"')}}for(r in o){t.push("<param name='"+r+"' value='"+o[r]+"'/>")}var i='<div id="javaerrormsg" style="clear:both; padding:5px; display:'+n+'; background:#fff; color:#f00; font-size:14px; font-weight:bold;">You must enable java or install it<br />if not already installed from <a href="http://java.com/en/download/index.jsp" target="_blank">here</a></div>';var u='<b>You must enable java or install from <a href="http://www.java.com/en/download/index.jsp"> here </a></b>';var a=i+"<applet "+e.join(" ")+">"+t.join("")+u+"</applet>";return a};var i=0;var a=0;var f=e("#webphone_bg_container").offset();if(typeof f!=="undefined"&&f!==null){i=f.top+20;a=f.left}t.PutToDebugLog(3,"EVENT, webphone: Loading applet");var l=e("<div/>");l.attr("id","wpappletconatiner").attr("style","z-index:10000; position:absolute; float:left; top:"+i+"px; left:"+a+"px; line-height: 1px; font-size: 1px;").html(r());try{e("body").append(l)}catch(h){console.error(h);alert("Can't start applet: "+h)}}catch(p){t.PutToDebugLogException(2,"webphone: LoadApplet",p)}u=true;return true}function P(n){try{e("body").remove("#wpappletconatiner");var r='<div id="wpappletconatiner" style="z-index:10000; position:absolute; float:left; top:0; left:0; line-height: 1px; font-size: 1px;">'+n+"</div>";e("body").append(r)}catch(i){t.PutToDebugLogException(2,"webphone: InsertApplet",i)}}function j(){if(t.isNull(H)||t.isNull(B)||H<10||B<10){H=t.GetDeviceWidth();B=t.GetDeviceHeight();if(t.isNull(H)||t.isNull(B)||H<50||B<50){H=200;B=300}}f++;l=F();if(l){if(!t.isNull(document.getElementById("javaerrormsg"))){document.getElementById("javaerrormsg").style.display="none"}f=0;t.SaveParameter("isfirststart","false");v()}else{var n=0;if(c==="true"){n=25}else{n=50}if(f>=n){e("#webphone").width(H-1);e("#webphone").height(B-1);if(!t.isNull(document.getElementById("javaerrormsg"))){document.getElementById("javaerrormsg").style.display="block"}}setTimeout(function(){j()},300)}}function F(){if(a===null||typeof a==="undefined"){t.PutToDebugLog(1,r.get("initializing"));try{a=document.getElementById("webphone")}catch(e){}if(a==null){var n=null;try{n=document.applets;if(n.length==0){n=document.getElementsByTagName("object")}if(n.length==0){n=document.getElementsByTagName("applet")}for(var i=0;i<n.length;++i){try{if(typeof n[i].API_Call!="undefined"){a=n[i];break}}catch(e){}}}catch(e){}if(a==null){try{a=document.applets[0]}catch(e){}}if(a==null){t.PutToDebugLog(3,"ERROR, webphone: initcheck(), cannot find applet handle")}}if(a!=null){try{var s=a.getSubApplet();if(s!=null){a=s}}catch(e){}}}var o="";var u=navigator.userAgent.toLowerCase();try{o=a.toString();if(u.indexOf("msie")>0||u.indexOf("trident")>0){for(var f in a){if(f==="contentDocument"){o=a[f].toString();break}}}}catch(e){t.PutToDebugLogException(2,"ERROR, webphone: initcheck",e)}if(o==null||o==""||o.toLowerCase().indexOf("[object")>=0&&o.toLowerCase().indexOf("[object")<5){a=null;return false}else{window.webphone_handle=a;return true}}var s={id:"webphone",code:"webphone.webphone.class",name:"webphone",archive:"lib/webphone.jar",codebase:".",width:1,height:1,MAYSCRIPT:true};var o={serveraddress:"",JAVA_CODEBASE:".",username:"",MAYSCRIPT:true,mayscript:"yes",scriptable:true,jsscriptevent:t.GetParameter("jsscriptevent"),autocfgsave:3,hasincomingcall:false,haschat:1,canopenlogview:false,pluginspage:"http://java.com/download/",permissions:"all-permissions"};var u;var a;var f;var l;var c;var p=300;var d=8e3;var H=0;var B=0;window.webphone_handle=a;var I={StartWin:g,webphone_started:false,pollstatus:true};window.webphone_public=I;return{InsertApplet:P,Start:m,StartWin:g,Call:b,Hangup:w,Accept:E,Reject:S,Conference:x,Transfer:T,Dtmf:N,MuteEx:C,Hold:k,SendChat:L,AudioDevice:A,SetVolume:O,SetParameter:M,IsRegistered:_}})