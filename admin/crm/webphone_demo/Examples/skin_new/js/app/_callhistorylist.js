define(["jquery","common","stringres","global"],function(c,k,j,o){function q(z){try{k.PutToDebugLog(4,"_callhistorylist: onCreate");c("#nav_ch_dialpad").on("click",function(){c.mobile.changePage("#page_dialpad",{transition:"none",role:"page",reverse:"true"})});c("#nav_ch_contacts").on("click",function(){c.mobile.changePage("#page_contactslist",{transition:"none",role:"page",reverse:"true"})});c("#nav_ch_dialpad").attr("title",j.get("hint_dialpad"));c("#nav_ch_contacts").attr("title",j.get("hint_contacts"));c("#nav_ch_callhistory").attr("title",j.get("hint_callhistory"));c("#status_callhistorylist").attr("title",j.get("hint_status"));c("#curr_user_callhistorylist").attr("title",j.get("hint_curr_user"));c(window).resize(function(){if(c.mobile.activePage.attr("id")==="page_callhistorylist"){p()}});c("#callhistorylist_list").on("click","li",function(A){b(c(this).attr("id"))});c("#callhistorylist_list").on("taphold","li",function(A){n(c(this).attr("id"))});c("#callhistorylist_menu_ul").on("click","li",function(A){a(c(this).attr("id"))});c("#btn_callhistorylist_menu").on("click",function(){i("#callhistorylist_menu_ul")});c("#btn_callhistorylist_menu").attr("title",j.get("hint_menu"))}catch(y){k.PutToDebugLogException(2,"_callhistorylist: onCreate",y)}}function t(z){try{k.PutToDebugLog(4,"_callhistorylist: onStart");o.isCallhistorylistStarted=true;if(k.GetParameter("devicetype")!==k.DEVICE_WIN_SOFTPHONE()){document.getElementById("app_name_callhistorylist").innerHTML=j.get("app_name")}c(".separator_line_thick").css("background-color",k.HoverCalc(k.getBgColor("#page_callhistorylist"),-30));if(!k.isNull(document.getElementById("chlist_title"))){document.getElementById("chlist_title").innerHTML=j.get("chlist_title")}var A=k.GetParameter("sipusername");if(!k.isNull(A)&&A.length>0){c("#curr_user_callhistorylist").html(A)}k.HideCallNotifications();p();if(k.IsIeVersion(10)){c("#callhistorylist_list").children().css("line-height","normal")}x()}catch(y){k.PutToDebugLogException(2,"_callhistorylist: onStart",y)}}function p(){try{var A=k.GetDeviceWidth()-c("#callhistorylist_additional_header_left").width()-c("#callhistorylist_additional_header_right").width();var z=k.StrToIntPx(c("#callhistorylist_additional_header_left").css("margin-left"));if(k.isNull(z)||z===0){z=10}z=Math.ceil(z*6);A=Math.floor(A-z)-20;c("#callhistorylist_notification").width(A);c("#callhistorylist_notification").height(Math.floor(c("#callhistorylist_additional_header_left").height()));c("#callhistorylist_list").height(k.GetDeviceHeight()-c("#callhistorylist_header").height()-3)}catch(y){k.PutToDebugLogException(2,"_callhistorylist: MeasureCallhistorylist",y)}}function x(){try{if(o.isdebugversionakos){if(k.isNull(o.chlist)||o.chlist.length<1){o.chlist=[];var B=["0","Ambrus Akos","8888","1401783666621","50",""];var A=["1","Ambrus Tunde","134567915","1401783646621","18",""];var z=["2","46987979797","46987979797","1401783662621","85",""];var y=["3","Bela Missedcall","46987979797","1401783662621","850",""];o.chlist.push(B);o.chlist.push(A);o.chlist.push(z);o.chlist.push(y)}}if(k.isNull(o.chlist)||o.chlist.length<1){k.ReadCallhistoryFile(function(D){if(!D){k.PutToDebugLog(2,"ERROR, _callhistorylist: Load call history failed")}l()})}else{l()}}catch(C){k.PutToDebugLogException(2,"_callhistorylist: LoadHistory",C)}}var v=new Array();v[0]="Jan";v[1]="Feb";v[2]="Mar";v[3]="Apr";v[4]="May";v[5]="Jun";v[6]="Jul";v[7]="Aug";v[8]="Sep";v[9]="Oct";v[10]="Nov";v[11]="Dec";function l(){try{if(k.isNull(document.getElementById("callhistorylist_list"))){k.PutToDebugLog(2,"ERROR, _callhistorylist: PopulateList listelement is null");return}if(k.isNull(o.chlist)||o.chlist.length<1){c("#callhistorylist_list").html('<span style="text-shadow:0 0 0;">'+j.get("no_history")+"</span>");k.PutToDebugLog(2,"EVENT, _callhistorylist: PopulateList no history");return}k.PutToDebugLog(2,"EVENT, _callhistorylist Starting populate list");var R='<li id="chitem_[CHID]" data-theme="b"><a [MISSED_NEW] class="ch_anchor" data-transition="slide"><div class="item_container"><div class="ch_type"><img src="images/[ICON_CALLTYPE].png" /></div><div class="ch_data"><div class="ch_name">[NAME]</div><div class="ch_number">[NUMBER]</div><div class="ch_duration">[DURATION]</div></div><div class="ch_date">[DATE]</div></div></a></li>';var P="";for(var K=0;K<o.chlist.length;K++){var N=o.chlist[K];if(k.isNull(N)||N.length<1){continue}var L="icon_call_missed";var y="";if(N[k.CH_TYPE]==="0"){L="icon_call_outgoing"}if(N[k.CH_TYPE]==="1"){L="icon_call_incoming"}if(N[k.CH_TYPE]==="2"){y='style="background: #ff7500;"';N[k.CH_TYPE]="3";o.chlist[K]=N}var F=0;try{F=k.StrToInt(k.Trim(N[k.CH_DATE]))}catch(z){k.PutToDebugLogException(2,"_callhistorylist: PopulateList convert duration",z)}var B=0;try{B=k.StrToInt(k.Trim(N[k.CH_DURATION]))}catch(z){k.PutToDebugLogException(2,"_callhistorylist: PopulateList convert duration",z)}var G=new Date(F);var I=G.getMinutes();if(I<10){I="0"+I}var J=G.getDate();if(J<10){J="0"+J}var E=v[G.getMonth()]+", "+J+"&nbsp;&nbsp;"+G.getFullYear()+"&nbsp;&nbsp;"+G.getHours()+":"+I;var M=j.get("duration")+" ";var Q=B%60;var O=Math.floor(B/60);var H=O%60;var D=Math.floor(O/60);if(D>0){M+=D+":"}if(H<10){M+="0"}M+=H+":";if(Q<10){M+="0"}M+=Q;var A=R.replace("[CHID]",K);A=A.replace("[ICON_CALLTYPE]",L);A=A.replace("[MISSED_NEW]",y);A=A.replace("[NAME]",N[k.CH_NAME]);A=A.replace("[NUMBER]",N[k.CH_NUMBER]);A=A.replace("[DURATION]",M);A=A.replace("[DATE]",E);P=P+A}c("#callhistorylist_list").html("");c("#callhistorylist_list").append(P).listview("refresh")}catch(C){k.PutToDebugLogException(2,"_callhistorylist: PopulateList",C)}}function b(B){try{if(k.isNull(B)||B.length<1){k.PutToDebugLog(2,"ERROR, _callhistorylist OnListItemClick id is NULL");return}var z="";var A=B.indexOf("_");if(A<2){k.PutToDebugLog(2,"ERROR, _callhistorylist OnListItemClick invalid id");return}z=k.Trim(B.substring(A+1));o.intentchdetails[0]="ctid="+z;c.mobile.changePage("#page_callhistorydetails",{transition:"none",role:"page"})}catch(y){k.PutToDebugLogException(2,"_callhistorylist: OnListItemClick",y)}}function n(B){try{if(k.isNull(B)||B.length<1){k.PutToDebugLog(2,"ERROR, _callhistorylist OnListItemLongClick id is NULL");return}var y="";var A=B.indexOf("_");if(A<2){k.PutToDebugLog(2,"ERROR, _callhistorylist OnListItemLongClick invalid id 1");return}y=k.Trim(B.substring(A+1));if(k.isNull(y)||y.length<1||!k.IsNumber(y)){return;k.PutToDebugLog(2,"ERROR, _callhistorylist OnListItemLongClick invalid id 2: "+y)}d(y)}catch(z){k.PutToDebugLogException(2,"_callhistorylist: OnListItemLongClick",z)}}function d(F,D){try{var z=o.chlist[F];var B=k.GetDeviceWidth();if(!k.isNull(B)&&k.IsNumber(B)&&B>100){B=Math.floor(B/1.2)}else{B=220}var A="";var G='<li id="[ITEMID]"><a data-rel="back">[ITEMTITLE]</a></li>';var C="";if(z[k.CH_NAME]===z[k.CH_NUMBER]){C=G.replace("[ITEMID]","#item_create_contact");C=C.replace("[ITEMTITLE]",j.get("menu_createcontact"));A=A+C;C=""}else{C=G.replace("[ITEMID]","#item_edit_contact");C=C.replace("[ITEMTITLE]",j.get("menu_editcontact"));A=A+C;C=""}C=G.replace("[ITEMID]","#item_delete");C=C.replace("[ITEMTITLE]",j.get("ch_delete"));A=A+C;C="";var E='<div id="ch_contextmenu" data-role="popup" class="ui-content messagePopup" data-overlay-theme="a" data-theme="a" style="max-width:'+B+"px; min-width: "+Math.floor(B*0.6)+'px;"><div data-role="header" data-theme="b"><a href="#" data-role="button" data-icon="delete" data-iconpos="notext" class="ui-btn-right closePopup">Close</a><h1 class="adialog_title">'+z[k.CH_NAME]+'</h1></div><div role="main" class="ui-content adialog_content" style="padding: 0; margin: 0;"><ul id="ch_contextmenu_ul" data-role="listview" data-inset="true" data-icon="false" style="margin: 0;">'+A+'</ul></div><div data-role="footer" data-theme="b" class="adialog_footer"><a href="#" style="width: 98%;" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-btn-b adialog_2button" data-rel="back" data-transition="flow">'+j.get("btn_close")+"</a></div></div>";D=D?D:function(){};c.mobile.activePage.append(E).trigger("create");c.mobile.activePage.find(".closePopup").bind("tap",function(H){c.mobile.activePage.find(".messagePopup").popup("close")});c.mobile.activePage.find(".messagePopup").popup().popup("open").bind({popupafterclose:function(){c(this).unbind("popupafterclose").remove();c("#ch_contextmenu_ul").off("click","li");D()}});c("#ch_contextmenu_ul").on("click","li",function(H){var I=c(this).attr("id");if(I==="#item_delete"){o.chlist.splice(F,1);o.wasChModified=true;l()}else{if(I==="#item_create_contact"){m(F)}else{if(I==="#item_edit_contact"){r(F)}}}})}catch(y){k.PutToDebugLogException(2,"_callhistorylist: CreateContextmenu",y)}}function m(y){try{c("#ch_contextmenu").on("popupafterclose",function(A){c("#ch_contextmenu").off("popupafterclose");var B=o.chlist[y];o.intentaddeditct[0]="action=add";o.intentaddeditct[1]="numbertoadd="+B[k.CH_NUMBER];c.mobile.changePage("#page_addeditcontact",{transition:"pop",role:"page"})})}catch(z){k.PutToDebugLogException(2,"_callhistorylist: CreateContact",z)}}function r(y){try{var B=o.chlist[y];var A=k.GetContactIdFromNumber(B[k.CH_NUMBER]);if(A<0){m(y);return}c("#ch_contextmenu").on("popupafterclose",function(C){c("#ch_contextmenu").off("popupafterclose");o.intentaddeditct[0]="action=edit";o.intentaddeditct[1]="ctid="+A;c.mobile.changePage("#page_addeditcontact",{transition:"pop",role:"page"})})}catch(z){k.PutToDebugLogException(2,"_callhistorylist: EditContact",z)}}var w="#menuitem_callhistorylist_clear";var e="#menuitem_callhistorylist_settings";var u="#menuitem_callhistorylist_help";var s="#menuitem_callhistorylist_exit";function i(z){try{if(k.GetParameter("devicetype")===k.DEVICE_WIN_SOFTPHONE()){c("#btn_callhistorylist_menu").removeAttr("data-transition")}if(k.isNull(z)||z.lenght<1){k.PutToDebugLog(2,"ERROR, _callhistorylist: CreateOptionsMenu menuid null");return}if(c(z).length<=0){k.PutToDebugLog(2,"ERROR, _callhistorylist: CreateOptionsMenu can't get reference to Menu");return}if(z.charAt(0)!=="#"){z="#"+z}c(z).html("");c(z).append('<li id="'+w+'"><a data-rel="back">'+j.get("clear_callhistory")+"</a></li>").listview("refresh");c(z).append('<li id="'+e+'"><a data-rel="back">'+j.get("settings_title")+"</a></li>").listview("refresh");c(z).append('<li id="'+u+'"><a data-rel="back">'+j.get("menu_help")+"</a></li>").listview("refresh");if(k.GetParameter("devicetype")===k.DEVICE_WIN_SOFTPHONE()){c(z).append('<li id="'+s+'"><a data-rel="back">'+j.get("menu_exit")+"</a></li>").listview("refresh")}return true}catch(y){k.PutToDebugLogException(2,"_callhistorylist: CreateOptionsMenu",y)}return false}function a(z){try{if(k.isNull(z)||z.length<1){return}c("#callhistorylist_menu").on("popupafterclose",function(A){c("#callhistorylist_menu").off("popupafterclose");switch(z){case w:g();break;case e:k.OpenSettings();break;case u:k.HelpWindow("callhistorylist");break;case s:k.Exit();break}})}catch(y){k.PutToDebugLogException(2,"_callhistorylist: MenuItemSelected",y)}}function g(y){try{var B=k.GetDeviceWidth();if(!k.isNull(B)&&k.IsNumber(B)&&B>100){B=Math.floor(B/1.2)}else{B=220}var z='<div id="adialog_clearcallhistory" data-role="popup" class="ui-content messagePopup" data-overlay-theme="a" data-theme="a" style="max-width:'+B+'px;"><div data-role="header" data-theme="b"><a href="#" data-role="button" data-icon="delete" data-iconpos="notext" class="ui-btn-right closePopup">Close</a><h1 class="adialog_title">'+j.get("clear_callhistory")+'</h1></div><div role="main" class="ui-content adialog_content adialog_alert"><span> '+j.get("clear_callhistory_msg")+' </span></div><div data-role="footer" data-theme="b" class="adialog_footer"><a href="#" id="btn_adialog_ok" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-btn-b adialog_2button" data-rel="back" data-transition="flow">'+j.get("btn_ok")+'</a><a href="#" id="adialog_negative" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-btn-b adialog_2button" data-rel="back">'+j.get("btn_cancel")+"</a></div></div>";y=y?y:function(){};c.mobile.activePage.append(z).trigger("create");c.mobile.activePage.find(".closePopup").bind("tap",function(D){c.mobile.activePage.find(".messagePopup").popup("close")});c.mobile.activePage.find(".messagePopup").bind({popupbeforeposition:function(){c(this).unbind("popupbeforeposition");var D=Math.floor(k.GetDeviceHeight()*0.6);if(c(this).height()>D){c(".messagePopup .ui-content").height(D)}}});c.mobile.activePage.find(".messagePopup").popup().popup("open").bind({popupafterclose:function(){c(this).unbind("popupafterclose").remove();c("#btn_adialog_ok").off("click");y()}});var C=0;c("#adialog_clearcallhistory").keypress(function(D){C++;if(D.which===13&&C<2){D.preventDefault();c("#btn_adialog_ok").click()}else{return}});c("#btn_adialog_ok").on("click",function(){o.chlist.splice(0,o.chlist.length);o.wasChModified=true;k.SaveCallhistoryFile(function(D){k.PutToDebugLog(4,"EVENT, _callhistorylist: ClearCallhistory SaveCallhistoryFile: "+D.toString());l()})})}catch(A){k.PutToDebugLogException(2,"_callhistorylist: ClearCallhistory",A)}}function h(z){try{k.PutToDebugLog(4,"_callhistorylist: onStop");o.isCallhistorylistStarted=false}catch(y){k.PutToDebugLogException(2,"_callhistorylist: onStop",y)}}function f(z){try{k.PutToDebugLog(4,"_callhistorylist: onDestroy");o.isCallhistoryListStarted=false}catch(y){k.PutToDebugLogException(2,"_callhistorylist: onDestroy",y)}}return{onCreate:q,onStart:t,onStop:h,onDestroy:f}});