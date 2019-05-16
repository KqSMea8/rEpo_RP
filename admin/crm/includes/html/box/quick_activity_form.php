 <script type="text/javascript" src="../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../js/ewp50.js"></script>
<script type="text/javascript">
	var ew_DHTMLEditors = [];
</script>
<script type="text/javascript" src="multiSelect/jquery.tokeninput.js"></script>

<link rel="stylesheet" href="multiSelect/token-input.css" type="text/css" />
<link rel="stylesheet" href="multiSelect/token-input-facebook.css" type="text/css" />
<script language="JavaScript1.2" type="text/javascript">

    function SendEventExistRequest(Url) {
        var SendUrl = Url + "&r=" + Math.random();
        httpObj.open("GET", SendUrl, true);
        httpObj.onreadystatechange = function RecieveEventRequest() {
            if (httpObj.readyState == 4) {


                if (httpObj.responseText == 1) {
                    alert("Subject already exists in database. Please enter another.");
                    document.getElementById("subject").select();
                    return false;
                } else if (httpObj.responseText == 2) {
                    alert("event date already exists in database. Please enter another.");
                    return false;
                } else if (httpObj.responseText == 0) {
                    document.forms[0].submit();
                } else {
                    alert("Error occur : " + httpObj.responseText);
                    return false;
                }
            }
        };
        httpObj.send(null);
    }


//By Chetan24Nov//
$(document).ready(function() {
         $( "input[name$='assign']" ).click(function() { 
            if(this.value=='Users') //By Chetan//
            {
                $('#group').hide();
                $('#user').show();
            }else{
                $('#user').hide();
                $('#group').show();
            }   

        });
    });
    
  //By Chetan//  
$(function(){
       $("#activityform").submit(function(){
        var err;
        $('div.red').html('');
        $("#activityform  :input[data-mand^=\'y\']").each(function(){
            
             $fldname = $(this).attr('name');
             $input = ($(this).closest('td').prev().clone().children().remove().end().text()).replace(':','');
            if($(this).closest('td').is(':visible') == true)
            {
                if($(this).attr('type') == '' || typeof($(this).attr('type')) == 'undefined' || $(this).attr('type') == 'text')
                {
                    if( $.trim($(this).val()) == "")
                    {
                        if($fldname == 'startTime' || $fldname == 'startDate')
                        {
                            $fldname = 'startDate';
                        }else if($fldname == 'closeTime' || $fldname == 'closeDate')
                        {
                            $fldname = 'closeDate';
                        }

                        $("#"+$fldname+"err").html(""+$input+" is mandatory field.");
                        err = 1;
                    }
                 }else{

                    if($('#'+$fldname+':checked').length < 1)
                    {
                         $("#"+$fldname+"err").html(""+$input+" is mandatory field.");
                         err = 1;
                    }
                } 
                 if($fldname == 'assign')
                  { 
                        if($("#assign:checked").val()=='Users' && $("#AssignToUser").val()=='')
                        {
                            $("#"+$fldname+"err").html("Please Enter Assign User Name.");
                            err = 1;	
                        }else if($("#assign:checked").val()=='Group' && $("#AssignToGroup").val()==''){

                            $("#"+$fldname+"err").html("Please Select Assign Group.");
                            err = 1;
                        }
                  }
            }      
        });
                
        if($("#closeDate").val()!='' && $("#startDate").val()!='' && ($("#closeDate").val() < $("#startDate").val())){
                 $("#closeDateerr").html("Close Date should be greater than Start Date.");
                 err = 1;	
        }
             
        if(err == 1) return false; else return true;
       });
      
      
      
      
      
      
      //By Chetan 16July//
      if($('#form1 input:checkbox').length>0){
         
        $('#form1 input:checkbox').click(function(){
            
          fldname = $(this).attr('name');
          if(!$(this).is(':checked'))
          { 
                $('<input>').attr({
                        type: 'hidden',
                        id: fldname,
                        name: fldname,
                        value:''
                }).appendTo('#form1');
          }else{
                $('input[name="'+fldname+'"][type="hidden"]').remove();
          }
            
        });
          
      }
      
      //End//
      
      
   });       
   
//End//


    $(function() {
        $('#startTime').timepicker({'timeFormat': 'H:i:s'});
        $('#closeTime').timepicker({'timeFormat': 'H:i:s'});
    });


    function activity2(ref) {

        //alert("aaaaaaaaaa");
 var parent_type = document.getElementById("parent_type").value;
var parentID = document.getElementById("parentID").value;

        if (ref == 'Task') {
            window.location.href = "addActivity.php?mode=" + ref+"&parentID="+parentID+"&parent_type="+parent_type;
        } else {
            window.location.href = "addActivity.php?mode=" + ref+"&parentID="+parentID+"&parent_type="+parent_type;
            ;
        }




        //document.getElementById("Task").style.display = "bolck";



    }
    


</script>

<SCRIPT LANGUAGE=JAVASCRIPT>

    function SelectAllRecord()
    {
        for (i = 1; i <= document.form1.Line.value; i++) {
            document.getElementById("EmpID" + i).checked = true;
        }

    }

    function SelectNoneRecords()
    {
        for (i = 1; i <= document.form1.Line.value; i++) {
            document.getElementById("EmpID" + i).checked = false;
        }
    }

    function getval(sel) {

        //alert(sel.value);
        document.getElementById("activity_type").value = sel.value;
    }
</SCRIPT>

<?
if (isset($_GET['mode']) && $_GET['mode'] == "Task") {

    $detail_head = $_GET['mode'];

    $none = "style='display:none';";
} else {
    $detail_head = "Event";
    $none = "";
}
?>
<!--div><a href="javascript:;" style="color:#FFFFFF;" class="button" onclick="activity2('Event');">Event</a> &nbsp;&nbsp;&nbsp;<a style="color:#FFFFFF;" href="javascript:;" class="button" onclick="activity2('Task');">Task</a></div-->

<div id="Event">
<form name="activityform" id="activityform" action=""  method="post" enctype="multipart/form-data">

    <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">


        

            <tr>
                <td  align="center" valign="top" >


                    <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
                        <?php
//By Chetan24Nov//

$Narry = array_map(function($arr){

       if($arr['head_value'] == 'Related To')
       {
           unset($arr);
       }else{
          return $arr;
       }
}, $arryHead);
$arryHead = array_values(array_filter($Narry));


 
 $arrayvalues = (!empty($arryActivity)) ? $arryActivity[0] : '';
 for($h=0;$h<sizeof($arryHead);$h++){
 if($h==0 && $arryHead[$h]['head_value'] == 'Details'){
     ?>
                        

                        <tr>
                            <td colspan="4" align="left" class="head"><?= isset($_GET['mode']) ? $_GET['mode'] : '';?> <?=$arryHead[$h]['head_value']?></td>
                        </tr>
                        <tr>

                            <td  width="25%"  align="right" valign="top"   class="blackbold" >Related Type  :</td>
                            <td  width="25%" align="left" valign="top" > <?=ucfirst($_GET['parent_type'])?>          </td>
                        </tr>
                        
                        
                        
 <?php }else{?>       
                    <tr>
                        <td colspan="4" align="left" class="head"><?=$arryHead[$h]['head_value']?></td>
                    </tr>

 <?php } $arryField = $objField->getFormField('',$arryHead[$h]['head_id'],'1'); 


include("includes/html/box/CustomFieldsNew.php"); 

 }
//head close?>           
	
</table>	






	
	  
	
	</td>
   </tr>


   <tr>
    <td  align="center">
	
	<div id="SubmitDiv" style="display:none1">
	
<? if ($_GET['edit'] > 0)
    $ButtonTitle = 'Update ';
else
    $ButtonTitle = ' Submit ';
?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?= $ButtonTitle ?> "  />


<input type="hidden" name="activityID" id="activityID" value="<?= $_GET['edit'] ?>" />
<input type="hidden" name="activity_type" id="activity_type" value="<?= isset($_GET['mode']) ? $_GET['mode'] : '';?>" />
<input type="hidden" name="created_by" id="created_by"  value="<?= $_SESSION['AdminType'] ?>" />
<input type="hidden" name="created_id" id="created_id"  value="<?= $_SESSION['AdminID'] ?>" />
<input type="hidden" name="parent_type" id="parent_type"  value="<?=isset($_GET['parent_type']) ? $_GET['parent_type'] : ''; ?>" />
<input type="hidden" name="parentID" id="parentID"  value="<?=isset($_GET['parentID']) ? $_GET['parentID'] : ''; ?>" />



</div>

</td>
   </tr>
   
</table></form>
</div>

  

  
  





