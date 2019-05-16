define(["jquery","common","stringres","global"],function(c,i,h,o){function p(t){try{i.PutToDebugLog(4,"_messagelist: onCreate");c("#messagelist_list").on("click","li",function(u){b(c(this).attr("id"))});c(window).resize(function(){if(c.mobile.activePage.attr("id")==="page_messagelist"){g()}});c("#messagelist_menu_ul").on("click","li",function(u){a(c(this).attr("id"))});c("#btn_messagelist_menu").on("click",function(){e("#messagelist_menu_ul")});c("#btn_messagelist_menu").attr("title",h.get("hint_menu"));c("#msglist_btnback").attr("title",h.get("hint_btnback"));c("#btn_newmessage").on("click",function(){r()})}catch(s){i.PutToDebugLogException(2,"_messagelist: onCreate",s)}}function q(t){try{i.PutToDebugLog(4,"_messagelist: onStart");o.isMessagelistStarted=true;c("#btn_newmessage").html(h.get("btn_new_message"));c(".separator_line_thick").css("background-color",i.HoverCalc(i.getBgColor("#page_messagelist"),-30));if(!i.isNull(document.getElementById("msglist_title"))){document.getElementById("msglist_title").innerHTML=h.get("msglist_title")}if(!i.isNull(document.getElementById("msglist_btnback"))){document.getElementById("msglist_btnback").innerHTML="<span>&LT;</span>&nbsp;"+h.get("go_back_btn_txt")}g();i.HideMessageNotifications();if(i.IsIeVersion(10)){c("#messagelist_list").children().css("line-height","normal")}j()}catch(s){i.PutToDebugLogException(2,"_messagelist: onStart",s)}}function g(){try{var v=i.GetDeviceWidth()-c("#messagelist_additional_header_left").width()-c("#messagelist_additional_header_right").width();var u=i.StrToIntPx(c("#messagelist_additional_header_left").css("margin-left"));if(i.isNull(u)||u===0){u=10}u=Math.ceil(u*6);v=Math.floor(v-u)-20;var s=i.GetDeviceHeight()-c("#messagelist_header").height()-c("#btn_newmessage_container").height();s=Math.floor(s-3);c("#messagelist_list").height(s)}catch(t){i.PutToDebugLogException(2,"_messagelist: MeasureMessagelist",t)}}function m(){try{j()}catch(s){i.PutToDebugLogException(2,"_messagelist: LoadMessages",s)}}function j(){try{if(i.isNull(document.getElementById("messagelist_list"))){i.PutToDebugLog(2,"ERROR, _messagelist: PopulateList listelement is null");return}c("#messagelist_list").html("");var v=i.GetParameter("messagefiles");if(i.isNull(v)||v.length<3){i.PutToDebugLog(3,"EVENT, _messagelist: PopulateList no message files");return}i.PutToDebugLog(2,"EVENT, _messagelist Starting populate list");var s=[];if(!i.isNull(v)&&v.length>0){s=v.split(",")}var B="";for(var A=0;A<s.length;A++){if(i.isNull(s[A])||s[A].length<3){continue}var y=s[A].substring(s[A].lastIndexOf("_")+1);var D=s[A].substring(0,s[A].indexOf("_"));var w="";var u=0;var E=y.indexOf("[#");if(E>0){var z=y.substring(E+2,y.length);y=y.substring(0,E);try{u=i.StrToInt(i.Trim(z))}catch(F){}}var t=i.GetContactNameFromNumber(y);if(!i.isNull(u)&&u>0){w='<span class="ui-li-count">'+u+"</span>"}if(i.isNull(t)||t.length<1){t=y}var C='<li id="msgitem_'+A+'"><a class="msg_anchor" data-transition="slide"><div class="msg_item_container"><div class="msg_name">'+t+' - <span id="msgitemnumber_'+A+'">'+y+"</span>"+w+'</div><div id="msgtype_'+A+'" class="msg_type">'+h.get(D)+"</div></div></a></li>";B=B+C}c("#messagelist_list").html("");c("#messagelist_list").append(B).listview("refresh")}catch(x){i.PutToDebugLogException(2,"_messagelist: PopulateList",x)}}function b(y){try{if(i.isNull(y)||y.length<1){i.PutToDebugLog(2,"ERROR, _messagelist OnListItemClick id is NULL");return}var u="";var x=y.indexOf("_");if(x<2){i.PutToDebugLog(2,"ERROR, _messagelist OnListItemClick invalid id");return}u=i.Trim(y.substring(x+1));var w=c("#msgitemnumber_"+u).html();if(i.isNull(w)){w=""}else{w=i.Trim(w)}var s=c("#msgtype_"+u).html();if(i.isNull(s)){s=h.get("chat")}else{s=i.Trim(s)}var v="";if(s===h.get("chat")){v="chat"}else{if(s===h.get("sms")){v="sms"}}o.intentmsg[0]="action="+v;o.intentmsg[1]="to="+w;o.intentmsg[2]="message=";if(i.GetParameter("devicetype")===i.DEVICE_WIN_SOFTPHONE()){c.mobile.changePage("#page_message",{transition:"none",role:"page"})}else{c.mobile.changePage("#page_message",{transition:"slide",role:"page"})}}catch(t){i.PutToDebugLogException(2,"_messagelist: OnListItemClick",t)}}function r(){try{i.StartMsg("","","_messagelist")}catch(s){i.PutToDebugLogException(2,"_messagelist: NewMessage",s)}}var n="#menuitem_messagelist_newmessage";var k="#menuitem_messagelist_delete";function e(t){try{if(i.GetParameter("devicetype")===i.DEVICE_WIN_SOFTPHONE()){c("#btn_messagelist_menu").removeAttr("data-transition")}if(i.isNull(t)||t.lenght<1){i.PutToDebugLog(2,"ERROR, _messagelist: CreateOptionsMenu menuid null");return}if(c(t).length<=0){i.PutToDebugLog(2,"ERROR, _messagelist: CreateOptionsMenu can't get reference to Menu");return}if(t.charAt(0)!=="#"){t="#"+t}c(t).html("");c(t).append('<li id="'+n+'"><a data-rel="back">'+h.get("btn_new_message")+"</a></li>").listview("refresh");c(t).append('<li id="'+k+'"><a data-rel="back">'+h.get("delete_text")+"</a></li>").listview("refresh");return true}catch(s){i.PutToDebugLogException(2,"_messagelist: CreateOptionsMenu",s)}return false}function a(t){try{if(i.isNull(t)||t.length<1){return}c("#messagelist_menu").on("popupafterclose",function(u){c("#messagelist_menu").off("popupafterclose");switch(t){case n:r();break;case k:l();break}})}catch(s){i.PutToDebugLogException(2,"_messagelist: MenuItemSelected",s)}}function l(s){try{var v=i.GetParameter("messagefiles");if(i.isNull(v)||v.length<3){i.ShowToast(h.get("err_msg_7"));return}var w=i.GetDeviceWidth();if(!i.isNull(w)&&i.IsNumber(w)&&w>100){w=Math.floor(w/1.2)}else{w=220}var t='<div data-role="popup" class="ui-content messagePopup" data-overlay-theme="a" data-theme="a" style="max-width:'+w+'px;"><div data-role="header" data-theme="b"><a href="#" data-role="button" data-icon="delete" data-iconpos="notext" class="ui-btn-right closePopup">Close</a><h1 class="adialog_title">'+h.get("delete_text")+'</h1></div><div role="main" class="ui-content adialog_content adialog_alert"><span> '+h.get("delete_all_msg_alert")+' </span></div><div data-role="footer" data-theme="b" class="adialog_footer"><a href="#" id="btn_adialog_ok" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-btn-b adialog_2button" data-rel="back" data-transition="flow">'+h.get("btn_ok")+'</a><a href="#" id="adialog_negative" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-btn-b adialog_2button" data-rel="back">'+h.get("btn_cancel")+"</a></div></div>";s=s?s:function(){};c.mobile.activePage.append(t).trigger("create");c.mobile.activePage.find(".closePopup").bind("tap",function(x){c.mobile.activePage.find(".messagePopup").popup("close")});c.mobile.activePage.find(".messagePopup").bind({popupbeforeposition:function(){c(this).unbind("popupbeforeposition");var x=Math.floor(i.GetDeviceHeight()*0.6);if(c(this).height()>x){c(".messagePopup .ui-content").height(x)}}});c.mobile.activePage.find(".messagePopup").popup().popup("open").bind({popupafterclose:function(){c(this).unbind("popupafterclose").remove();c("#btn_adialog_ok").off("click");s()}});c("#btn_adialog_ok").on("click",function(){var y=v.split(",");for(var x=0;x<y.length;x++){if(i.isNull(y[x])||y[x].length<3){continue}var z=y[x].indexOf("[#");if(z>0){y[x]=y[x].substring(0,z)}o.File.DeleteFile(y[x],function(A){i.PutToDebugLog(3,"EVENT, _messagelist: ClearAllHistory DeleteFile: "+y[x]+" status: "+A.toString())})}i.SaveParameter("messagefiles","");j()})}catch(u){i.PutToDebugLogException(2,"_messagelist: ClearAllHistory",u)}}function f(t){try{i.PutToDebugLog(4,"_messagelist: onStop");o.isMessagelistStarted=false}catch(s){i.PutToDebugLogException(2,"_messagelist: onStop",s)}}function d(t){try{i.PutToDebugLog(4,"_messagelist: onDestroy");o.isMessagelistStarted=false}catch(s){i.PutToDebugLogException(2,"_messagelist: onDestroy",s)}}return{onCreate:p,onStart:q,onStop:f,onDestroy:d}});