<link href='fullcalendar/fullcalendar.css' rel='stylesheet' />
<link href='fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
<script src='javascript/lib/jquery-ui.custom.min.js'></script>
<script src='fullcalendar/fullcalendar.min.js'></script>
<script>

	$(document).ready(function() {
 

  var date = new Date();
  var d = date.getDate();
  var m = date.getMonth();
  var y = date.getFullYear();



  var calendar = $('#calendar').fullCalendar({
   editable: true,
   
   
   header: {
    left: 'prevYear,prev,next,nextYear today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay'
   },
   
   //events: "http://localhost:8888/fullcalendar/events.php",
   
   events: "json-events.php",
			
			eventDrop: function(event, delta) {
				alert(event.title + ' was moved ' + delta + ' days\n' +
					'(should probably update your database)');
			},
			
			
   
   // Convert the allDay from string to boolean
   eventRender: function(event, element, view) {
    if (event.allDay === 'true') {
     event.allDay = true;
    } else {
     event.allDay = false;
    }
   },
   selectable: true,
   selectHelper: true,
   select: function(start, end, allDay) {
   
  
   start = $.fullCalendar.formatDate(start, "yyyy-MM-dd HH:mm:ss ");
   end = $.fullCalendar.formatDate(end, "yyyy-MM-dd HH:mm:ss ");
   var startTime = start.split(" ");
    var closeTime = end.split(" ");
   //startTime=$.fullCalendar.formatTime(start,"HH:mm:ss");
 
  
   $('#startDate').val(startTime[0]);
   $('#startTime').val(startTime[1]);
   $('#closeDate').val(closeTime[0]);
   $('#closeTime').val(closeTime[1]);
   
   $("#Event").dialog({
	modal: true,
	border:'none',
	width:500,
	show: {
		effect: "blind",
		duration: 1000
	}
           
   });

	

   var title = $('#subject').val();
   //alert(title);
 // var text = prompt('Type Event text,');
  //var url = prompt('Type Event url,');
   if (title) {
   start = $.fullCalendar.formatDate(start, "yyyy-MM-dd HH:mm:ss");
   
   
   //alert(title);
   end = $.fullCalendar.formatDate(end, "yyyy-MM-dd HH:mm:ss");
   //alert(end);
   $.ajax({
   url: 'ajax.php',
   data: 'action=AjaxEvent&title='+ title+'&start='+ start +'&end='+ end +'&url='+ url ,
   type: "GET",
   success: function(data) {
   
   //alert(json);
   alert('Added Successfully');
   }
   });
   calendar.fullCalendar('renderEvent',
   {
   title: title,
   start: start,
   end: end,
   allDay: allDay
   },
   true // make the event "stick"
   );
   }
   calendar.fullCalendar('unselect');
   },
   
   editable: true,
   eventDrop: function(event, delta) {
   start = $.fullCalendar.formatDate(event.start, "yyyy-MM-dd HH:mm:ss");
   end = $.fullCalendar.formatDate(event.end, "yyyy-MM-dd HH:mm:ss");
  
   $.ajax({
   url: 'ajax.php',
   data: 'action=AjaxEvent&title='+ event.title+'&start='+ start +'&end='+ end +'&id='+ event.id ,
   type: "GET",
   success: function(data) {
   //alert(data);
    alert("Updated Successfully");
   }
   });
   },
   eventResize: function(event) {
   start = $.fullCalendar.formatDate(event.start, "yyyy-MM-dd HH:mm:ss");
   end = $.fullCalendar.formatDate(event.end, "yyyy-MM-dd HH:mm:ss");
     
   $.ajax({
    url: 'ajax.php',
    data: 'action=AjaxEvent&title='+ event.title+'&start='+ start +'&end='+ end +'&id='+ event.id ,
    type: "GET",
    success: function(data) {
     alert("Updated Successfully");
    }
   });

}
   
  });
  
  
  
 });
 
 
  

</script>
<script language="JavaScript1.2" type="text/javascript">
function validateEvent(frm){


	if( ValidateForSimpleBlank(frm.subject, "Subject")
		//&& ValidateForSelect(frm.assignedTo,"Assign To")
		&& ValidateForSelect(frm.status,"Status")
		&& ValidateForSelect(frm.activityType,"Activity Type")
		
		
		//&& ValidateForTextareaMand(frm.street_address,"Street Address",10,300)bs
		//&& isZipCode(frm.ZipCode)
		//&& ValidatePhoneNumber(frm.Mobile,"Mobile Number",10,20)
		
		
		){
			return true;	
				/* var Url = "isRecordExists.php?EventSubject="+escape(document.getElementById("subject").value)+"&editID="+document.getElementById("activityID").value+"&Type="+document.getElementById("activity_type").value;
		 
		 
					SendExistRequest(Url,"subject", "Event Subject");

					return false;*/
					
			}else{
					return false;	
			}	

		
}
function getval(sel) {
 
       //alert(sel.value);
	   document.getElementById("activity_type").value = sel.value;
    }

function CloseEvent(){
	$('.ui-dialog').remove();
}
</script>
<style>
	.ui-dialog-titlebar-close{
		visibility:visible!important;
	}
	.ui-dialog .ui-dialog-titlebar-close{
		right:2.5em!important;
	}	
	#loading {
		position: absolute;
		top: 5px;
		right: 5px;
		}

	#calendar {
		width: 100%;
		margin: 0 auto;
		}
		.fc-event-title{
		 color:#FFFFFF;
		}
		
		.fc-event-inner .fc-event-time{ color:#FFFFFF;}

</style>
<script type="text/javascript" src="multiSelect/jquery.tokeninput.js"></script>

    <link rel="stylesheet" href="multiSelect/token-input.css" type="text/css" />
    <link rel="stylesheet" href="multiSelect/token-input-facebook.css" type="text/css" />
</head>

<div id="Event" title="Create Event" style="width:800px; display:none">
<? if($ModifyLabel==1){?>

<!--a href="Javascript:void(0);" onClick="Javascript:CloseEvent();"><img src="../images/close.gif" border="0" style=
"float:right;" title="Close"></a-->

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">


<form name="form1" action=""  method="post" onSubmit="return validateEvent(this);" enctype="multipart/form-data">

<tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr>
	 <td colspan="2" align="left" class="head"><?=(isset($_GET['mode'])) ? $_GET['mode'] : '';?> Details</td>
</tr>


      <tr>

        <td  align="right"   class="blackbold" width="40%">Subject  :<span class="red">*</span> </td>
         <td   align="left" >
          <input name="subject" type="text" class="inputbox" id="subject" value="<?php echo (isset($arryEvent[0]['subject'])) ? stripslashes($arryEvent[0]['subject']) : ''; ?>"  maxlength="50" />            </td>
      </tr>

	
	
 <tr>
        <td  align="right"   class="blackbold"> Status  :<span class="red">*</span> </td>
        <td   align="left" >
		
              <select name="status" class="inputbox" id="status" >
		<option value="">--- Select ---</option>
		<? for($i=0;$i<sizeof($arryActivityStatus);$i++) {?>
			<option value="<?=$arryActivityStatus[$i]['attribute_value']?>" <? if(!empty($arryActivity) && isset($arryActivityStatus[$i]['attribute_value']) && $arryActivityStatus[$i]['attribute_value']==$arryActivity[0]['status']){echo "selected";}?>>
			<?=$arryActivityStatus[$i]['attribute_value']?>
			</option>
		<? } ?>
			
		</select>
		</td>
      </tr>
	   <tr <?=(isset($none)) ? $none : '';?>>
        <td  align="right" class="blackbold"> Activity Type  :<span class="red">*</span> </td>
        <td   align="left" >		
              <select name="activityType" class="inputbox" onchange="getval(this);" id="activityType" >
		<option value="">--- Select ---</option>
		<? for($i=0;$i<sizeof($arryActivityType);$i++) {?>
			<option value="<?=$arryActivityType[$i]['attribute_value']?>" <?  if(!empty($arryActivity) &&$arryActivityType[$i]['attribute_value']==$arryActivity[0]['activityType']){echo "selected";}?>>
			<?=$arryActivityType[$i]['attribute_value']?>
			</option>
		<? } ?> 
           </select>
		</td>
      </tr>
	


<input id="startDate" name="startDate" readonly=""  size="12" value="" placeholder="Start Date"  type="hidden" />   
<input type="hidden" name="startTime" size="10" class="disabled time" id="startTime"  value="<?php echo (!empty($arryEvent)) ? stripslashes($arryEvent['startTime']) : ''; ?>" placeholder="Start Time"/>
<input id="closeDate" name="closeDate"  value=""  type="hidden" > 
<input type="hidden" name="closeTime"  id="closeTime" value="" />
		  
    <tr>
       		 <td colspan="2" align="left"   class="head">Description</td>
        </tr>

		 <tr>
          <td align="right"   class="blackbold" valign="top">Description :</td>
          <td  align="left" >
            <Textarea name="description" id="description" class="inputbox"  ></Textarea>

<script type="text/javascript">

var editorName = 'description';

var editor = new ew_DHTMLEditor(editorName);

editor.create = function() {
	var sBasePath = '../FCKeditor/';
	var oFCKeditor = new FCKeditor(editorName, '410', 200, 'Basic');
	oFCKeditor.BasePath = sBasePath;
	oFCKeditor.ReplaceTextarea();
	this.active = true;
}
ew_DHTMLEditors[ew_DHTMLEditors.length] = editor;

ew_CreateEditor(); 


</script>			          </td>
        </tr>
         
	
</table>	






	
	  
	
	</td>
   </tr>

   <tr>
	<td align="left" valign="top">&nbsp;
	
</td>
   </tr>

   <tr>
    <td  align="center">
	
	<div id="SubmitDiv" style="display:none1">
	
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />
      <a href="javascript:;" onclick="window.location = 'editActivity.php?module=Activity&mode=Event';" class="red_bt" style="padding: 5px 5px 7px; color:#FFFFFF; !important;"  >Go to Full form</a>



<input type="hidden" name="activityID" id="activityID" value="<?=$_GET['edit']?>" />
<input type="hidden" name="activity_type" id="activity_type" value="Event" />
<input type="hidden" name="created_by" id="created_by"  value="<?=$_SESSION['AdminType']?>" />
<input type="hidden" name="created_id" id="created_id"  value="<?=$_SESSION['AdminID']?>" />



</div>

</td>
   </tr>
   </form>
</table>
<? }else{?>

<div class="redmsg" align="center">Sorry, you are not authorized to access this section.</div>
<? }?>
</div>
<div id='calendar'></div>
<? echo '<script>SetInnerWidth();</script>'; ?>
