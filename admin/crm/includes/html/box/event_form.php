
<script type="text/javascript" src="javascript/jquery.timepicker.js"></script>

<link rel="stylesheet" type="text/css" href="javascript/jquery.timepicker.css" />
<script language="JavaScript1.2" type="text/javascript">
function validateLead(frm){

	if(document.getElementById("state_id") != null){
		document.getElementById("main_state_id").value = document.getElementById("state_id").value;
	}
	if(document.getElementById("city_id") != null){
		document.getElementById("main_city_id").value = document.getElementById("city_id").value;
	}

	if( ValidateForSimpleBlank(frm.subject, "Subject")
		&& ValidateForSelect(frm.AssignTo,"Assign To")
		&& ValidateForSimpleBlank(frm.startDate, " Event Start Date")		
		&& ValidateForSimpleBlank(frm.startTime, " Event Start time")
		&& ValidateForSimpleBlank(frm.closeDate, " Event Close Date")
		&& ValidateForSimpleBlank(frm.closeTime, " Event Close time")
		&& ValidateForSelect(frm.event_status,"Event Status")
		&& ValidateForSelect(frm.activityType,"Activity Type")
		
		
		//&& ValidateForTextareaMand(frm.street_address,"Street Address",10,300)bs
		//&& isZipCode(frm.ZipCode)
		//&& ValidatePhoneNumber(frm.Mobile,"Mobile Number",10,20)
		
		
		){
		
				if(Trim(frm.Landline1).value == '' && Trim(frm.Landline2).value == '' && Trim(frm.Landline3).value == ''){
										//alert("ok");
					}else if(Trim(frm.Landline1).value == '' || Trim(frm.Landline2).value == '' || Trim(frm.Landline3).value == ''){
						alert("Please Enter Complete Landline Number.");
						return false;
					}
		
					
				

					
					return true;	
					
			}else{
					return false;	
			}	

		
}

 $(function() {
			$('#startTime').timepicker({ 'timeFormat': 'H:i:s' });
			$('#closeTime').timepicker({ 'timeFormat': 'H:i:s' });
		  });




</script>
<script language="JavaScript1.2" type="text/javascript">

   $(document).ready(function() {    
     $("#RelatedType").click(function(e) {
		 e.preventDefault();
		
      var RelatedType=$("#RelatedType").val();

	  //alert( RelatedType);
     
	 
	  //var AdminID='<?=$Admin?>';

      $.ajax({
          type:"GET",
          url:"ajax.php",
          data:"action="+RelatedType+"&module="+RelatedType,
          success:function(data){
             $("#info").html(data);
			 //$("#Contact").val(1);
			 
			 
          }

      });
      return false;

   });

$(function () {
   
                var $listParent = $("#ddfilter"),
                    $list = $listParent.children("option"),
                    arrText = $list.filter(function (index, obj) {
                        return $(obj).html();
                    }),
                    $relatedTo = $("#relatedTo").val("");

                //removing duplicate strings from array, if exists
                var makeArrayUnique = function (origArr) {
                    var newArr = [],
                        origLen = origArr.length,
                        found, x, y;

                    for (x = 0; x < origLen; x++) {
                        found = undefined;
                        for (y = 0; y < newArr.length; y++) {
                            if (origArr[x] === newArr[y]) {
                                found = true;
                                break;
                            }
                        }
                        if (!found) {
                            newArr.push(origArr[x]);
                        }
                    }
                    return newArr;
                };

                //searching in array and return whole list of items that match criteria
                var searchInList = function (list, toSearch) {

                    var filteredList = [];
                    list.each(function (index, obj) {
                        var listVal = $(obj).html();
                        if (listVal.toLowerCase().indexOf(toSearch.toLowerCase()) > -1) {
                            filteredList.push(listVal);
                        }
                    });

                    return makeArrayUnique(filteredList);
                };

                //rendering/refreshing list
                var renderList = function (list) {
                    $listParent.children("option").remove();                    
                    $.each(list, function (index, obj) {
                        if (obj instanceof Object) {
                            obj = $(obj).html();
							//alert(obj);
                        }
                        $listParent.append("<option>" + obj + "</option>");
                    });
                };                               
               
                // on keydown on text box
                $relatedTo.on("keyup", function (e) {                   
                    var txt = $(this).val().toLowerCase();

                    //for backspace
                    if (e.which == 8) {
                        if (txt.length > 0) {
                            renderList(arrText);
                        }
                    }
                    
                    if (txt.length >= 1) {
                        var filterList = searchInList(arrText, txt);
                        if (filterList.length > 0) {
							
                            renderList(filterList);
                        } else {
                            console.log("Not Found");
                            //renderList(arrText);
                        }
                    }                     
                });
				});

/* $("#relatedTo").keypress(function(e) {
		 //e.preventDefault();

		// var key = e.charCode||e.keyCode||0;
		 var txt = $(this).val().toLowerCase();
      var relatedTo=$("#relatedTo").val();
      var RelatedType=$("#RelatedType").val();
	  //alert( RelatedType);
     //alert(relatedTo);
	 
	  //var AdminID='<?=$Admin?>';

	//alert(relatedTo);
      $.ajax({
          type:"GET",
          url:"ajax.php",
          data:"action=relatedTo&module="+RelatedType+"&RelatedType"+relatedTo,
          success:function(data){
             //$("#relatedTo").html(data);
			$("#relatedTo").val(data);
			 
			 
          }


      });
      return false;

   });*/
 
/*jQuery('#relatedTo').keyup(function() {
    var url="ajax.php?action=relatedTo";
    jQuery('#search-output').html('');
    var search_query = jQuery('#relatedTo').val();
    var search_query_regex = new RegExp(".*"+search_query+".*", "g");
    $.getJSON(url,function(data){
    jQuery.each(data.members, function(k, v) {
        if(v['email'].match(search_query_regex) ||
           v['sex'].match(search_query_regex) ||
           v['location'].match(search_query_regex)) {
               jQuery('#search-output').append('<li>Search results found in: '+'{ name: "'+v['email']+'", id: "'+v['sex']+'", location: "'+v['location']+'" } </li>');
        }
    });
    });*/
});
   /* $txtInput.on("keyup", function (e) {                   
     var txt = $(this).val().toLowerCase();

       //for backspace
          if (e.which == 8) {
             if (txt.length == 0) {
                  renderList(arrText);
             }
          }

       if (txt.length >= 1) {
         var filterList = searchInList(arrText, txt);
         if (filterList.length > 0) {
              renderList(filterList);
          } else {
             console.log("Not Found");
             renderList(arrText);
          }
      }                     
  });
   
});
*/

</script>
<style>
.icon-remove-sign {
  background-position: -48px -96px !important;
}
[class^="icon-"], [class*=" icon-"] {
  background-image: url("images/icons.png");
  background-position: 14px 14px;
  background-repeat: no-repeat;
  display: inline-block;
  height: 14px;
  line-height: 14px;
  vertical-align: text-top;
  width: 14px;
}
.row-fluid > [class*="span"] {
  float: left;
}
.select2-container-multi .select2-choices .select2-search-field input {
 background: none repeat scroll 0 0 transparent !important;
border: 1px solid #D1D1D1;
border-radius: 0 0 0 0;
box-shadow: none;
color: #73787C;
font-family: sans-serif;

font-size: 12px;
outline: 0 none;
padding: 6px 6px 5px;
width: 200px;
}
.input-prepend .add-on, .input-append .add-on {
  background-color: #F5F5F5;
  border: 1px solid #CCCCCC;
  border-radius: 0;
  color: #999999;
  display: block;
  float: left;
  font-weight: normal;
  height: 10px;
  line-height: 18px;
  margin-right: -1px;
  min-width: 16px;
  padding: 4px 5px;
  text-align: center;
  text-shadow: 0 1px 0 #FFFFFF;
  width: auto;
}.icon-search {
  background-position: -48px 0;
}
.icon-plus {
  background-position: -408px -96px;
}
.select2-choices{ list-style: none outside none;
margin: 0;
border:0;
padding: 0;
width: 190px;


}




  

     .select2-choices  option {
            list-style-type:none;
            margin:0px;
            margin-top:2px;
            padding:10px;
            left:0;
            background:#f2f2f2;
            width:150px;
            border:1px solid #ccc;
            border-radius:4px;
        }

</style>

<table width="97%"  border="0" align="center" cellpadding="0" cellspacing="0">
<form name="form1" action=""  method="post" onSubmit="return validateEvent(this);" enctype="multipart/form-data">
<tr>
    <td  align="center" valign="top" >
	

<table width="80%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr>
	 <td colspan="2" align="left" class="head">Event Details</td>
</tr>

<!--<tr>
        <td  align="right"   class="blackbold"> Type  :<span class="red">*</span> </td>
        <td   align="left" >
		 <select name="type" class="inputbox" id="type" >
		<option value="">--- Select ---</option>
		
			<option value="Individual" <?  if($arryEvent[0]['type']=='Individual'){echo "selected";}?>>Individual</option>
			<option value="Company" <?  if($arryEvent[0]['type']=='Company'){echo "selected";}?>>Company</option>
	

		 </select>
           </td>
      </tr>-->
      <tr>

        <td  align="right"   class="blackbold">Subject  :<span class="red">*</span> </td>
         <td   align="left" >
          <input name="subject" type="text" class="inputbox" id="subject" value="<?php echo stripslashes($arryEvent[0]['subject']); ?>"  maxlength="50" />            </td>
      </tr>

	
	   <tr>
        <td  align="right"   class="blackbold">  Assigned To  :<span class="red">*</span> </td>
        <td   align="left" >
		
      <? if($HideSibmit!=1){?>
               <select name="AssignTo" class="inputbox" id="AssignTo" >
						<option value="">--- Select ---</option>
						<? for($i=0;$i<sizeof($arryEmployee);$i++) {?>
							<option value="<?=$arryEmployee[$i]['EmpID']?>" <?  if($arryEmployee[$i]['EmpID']==$arryEvent[0]['AssignTo']){echo "selected";}?>>
							<?=stripslashes($arryEmployee[$i]['UserName']);?> (<?=stripslashes($arryEmployee[$i]['Department']);?>)
							</option>
						<? } ?>
					</select>
					
					<? }else{ 
						$HideSibmit = 1;
					?>
					<div class="redmsg">No employee exist.</div>
					<? } ?>


            </td>
      </tr>
 <tr>
        <td  align="right"   class="blackbold"> Start Date & Time  : <span class="red">*</span></td>
        <td   align="left" >
		<script type="text/javascript">
$(function() {
	$('#startDate').datepicker(
		{
		dateFormat: 'yy-mm-dd', 
		yearRange: '2013:<?=date("Y")?>', 
        changeMonth: true,
       changeYear: true
		}
	);
});
</script>


<input id="startDate" name="startDate" readonly="" class="disabled" size="12" value="" placeholder="Start Date"  type="text" />   
<input type="text" name="startTime" size="10" class="disabled" id="startTime" class="time" value="<?php echo stripslashes($arryEvent['startTime']); ?>" placeholder="Start Time"/>
		  
             </td>
      </tr>
	  
 <tr>

 <tr>
        <td  align="right"   class="blackbold"> End Date & Time  : <span class="red">*</span></td>
        <td   align="left" >

		
<script type="text/javascript">
$(function() {
	$('#closeDate').datepicker(
		{
		dateFormat: 'yy-mm-dd', 
		yearRange: '2013:<?=date("Y")?>', 
        changeMonth: true,
       changeYear: true
		}
	);
});
</script>


<input id="closeDate" name="closeDate" readonly="" class="disabled" size="12" value="<?php echo stripslashes($arryEvent['closeDate']); ?>" placeholder="Close Date"  type="text" > 
<input type="text" name="closeTime" size="10" class="disabled" id="closeTime" class="time" value="<?php echo stripslashes($arryEvent['closeTime']); ?>" placeholder="Close Time"/>
		  
             </td>
      </tr>
	  
 <tr>


 <tr>
        <td  align="right"   class="blackbold"> Event Status  :<span class="red">*</span> </td>
        <td   align="left" >
		
              <select name="event_status" class="inputbox" id="event_status" >
		<option value="">--- Select ---</option>
		<? for($i=0;$i<sizeof($arryEventStatus);$i++) {?>
			<option value="<?=$arryEventStatus[$i]['attribute_value']?>" <?  if($arryEventStatus[$i]['attribute_value']==$arryEvent[0]['event_status']){echo "selected";}?>>
			<?=$arryLeadSource[$i]['attribute_value']?>
			</option>
		<? } ?></select>
		</td>
      </tr>
	   <tr>
        <td  align="right"   class="blackbold"> Activity Type  :<span class="red">*</span> </td>
        <td   align="left" >
		
              <select name="activityType" class="inputbox" id="activityType" >
		<option value="">--- Select ---</option>
		<? for($i=0;$i<sizeof($arryActivityType);$i++) {?>
			<option value="<?=$arryActivityType[$i]['attribute_value']?>" <?  if($arryActivityType[$i]['attribute_value']==$arryEvent[0]['activityType']){echo "selected";}?>>
			<?=$arryActivityType[$i]['attribute_value']?>
			</option>
		<? } ?></select>
		</td>
      </tr>
	  <tr>
        <td  align="right"   class="blackbold"> Send Notification  : </td>
        <td   align="left" >
		
<input id="Notification" name="Notification" <? if($arryEvent['Notification']==1){ echo "Checked"; }?>  size="15" value="1"  type="checkbox" > 
		  
             </td>
      </tr>
	  

	  <tr>
        <td  align="right"   class="blackbold"> Location  : </td>
        <td   align="left" >
		
<input id="location" name="location"   size="15" value="<?=$arryEvent['location']?>" class="inputbox"  type="text" > 
		  
             </td>
      </tr>  

 <tr>
        <td  align="right"   class="blackbold"> Priority  : </td>
        <td   align="left" >
		
              <select name="priority" class="inputbox" id="priority" >
		<option value="">--- Select ---</option>
		<? for($i=0;$i<sizeof($arryEventPriority);$i++) {?>
			<option value="<?=$arryEventPriority[$i]['attribute_value']?>" <?  if($arryEventPriority[$i]['attribute_value']==$arryEvent[0]['priority']){echo "selected";}?>>
			<?=$arryEventPriority[$i]['attribute_value']?>
			</option>
		<? } ?></select>
		</td>
      </tr>
	     
 <tr>
        <td  align="right"   class="blackbold"> Visibility  : </td>
        <td   align="left" >
		<select name="visibility" class="inputbox" id="visibility" >
			<option value="">--- Select ---</option>		
			<option value="Private" <?  if($arryEvent['visibility']=="Private"){echo "selected";}?>>Private</option>
			<option value="Private" <?  if($arryEvent['visibility']=="Public"){echo "selected";}?>>Public</option>
		</select>
		</td>
      </tr>

         <tr>
       		 <td colspan="2" align="left"   class="head">Reminder Details</td>
        </tr>
	   <tr>
        <td  align="right"   class="blackbold"> Send Reminder  : </td>
        <td   align="left" >
		
<input id="reminder" name="reminder" <? if($arryEvent['reminder']==1){ echo "Checked"; }?>  size="15" value="1"  type="checkbox" > 
		  
             </td>
      </tr>

	   <!-- <tr>
       		 <td colspan="2" align="left"   class="head">Related To</td>
        </tr>

 <tr>
       
        <td   align="left" >
		<select name="RelatedType" class="inputbox" id="RelatedType" >
			<option value="">--- Select ---</option>	
			<option value="Lead" <?  if($arryEvent['RelatedType']=="Lead"){echo "selected";}?>>Lead</option>
			<option value="Opportunity" <?  if($arryEvent['RelatedType']=="Opportunity"){echo "selected";}?>>Opportunity</option>
			<option value="Ticket" <?  if($arryEvent['RelatedType']=="Ticket"){echo "selected";}?>>Ticket</option>
			<option value="Campaigns" <?  if($arryEvent['RelatedType']=="Campaigns"){echo "selected";}?>>Campaigns</option>
			
		</select>
		</td>
		   <td   align="" >
					<div class="row-fluid input-prepend input-append">
					<span class="add-on clearReferenceSelection cursorPointer">
						<i title="Clear" class="icon-remove-sign" onclick="javascript:document.getElementById('relatedTo').value='';"></i>
					</span>	
					<div class="select2-container select2-container-multi  span7 marginLeftZero autoComplete" id="s2id_contact_id_display"> 
					<input type="text" name="relatedTo" id="relatedTo" class="select2-input inputbox select2-default" placeholder="type tosearch" >

					<div style="width:170px; overflow:hidden;">
						<select id="ddfilter"  class="select2-choices" name ="list" >  
                          <option ="" selected ></option>
						<? $arrySerch=$objLead->ListLead($id=0,$SearchKey,$SortBy,$AscDesc);
						
						 for($i=0;$i<sizeof($arrySerch);$i++) {
							 
							echo '<option class="select-'.$i.'">'. $arrySerch[$i]['FirstName'].'</option>'; 
						 }
							 ?>
							
						</select>
                     </div>	
					</div>	
					<span class="add-on relatedPopup cursorPointer">
						<a href="" title="Select" class="icon-search relatedPopup"></a>
					</span>
					<span class="add-on cursorPointer createReferenceRecord">
						<a href="" title="Create" class="icon-plus"></a>
					</span>
					</div>




   

		</td>
      </tr>-->



           <tr>
       		 <td colspan="2" align="left"   class="head">Description</td>
        </tr>

		 <tr>
          <td align="right"   class="blackbold" valign="top">Description :<span class="red">*</span></td>
          <td  align="left" >
            <Textarea name="description" id="description" class="inputbox"  ><? echo stripslashes($arryProduct[0]['description']); ?></Textarea>

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
  

<script type="text/javascript">
$('#piGal table').bxGallery({
  maxwidth: 300,
  maxheight: 200,
  thumbwidth: 75,
  thumbcontainer: 300,
  load_image: 'ext/jquery/bxGallery/spinner.gif'
});
</script>


<script type="text/javascript">
$("#piGal a[rel^='fancybox']").fancybox({
  cyclic: true
});
</script>



	
	  
	
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


<input type="hidden" name="EventID" id="EventID" value="<?=$_GET['edit']?>" />



</div>

</td>
   </tr>
   </form>
</table>


<SCRIPT LANGUAGE=JAVASCRIPT>
	
	ShowPermission();

</SCRIPT>




