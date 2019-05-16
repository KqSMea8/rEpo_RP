<script type="text/javascript" src="../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../js/ewp50.js"></script>
<script type="text/javascript">
	var ew_DHTMLEditors = [];
</script>
<script language="JavaScript1.2" type="text/javascript">
function selModule() {
        var option = document.getElementById("RelatedType").value;

	document.getElementById("Opportunity").style.display = "none";
	document.getElementById("Lead").style.display = "none";
	document.getElementById("Campaign").style.display = "none";
	document.getElementById("Ticket").style.display = "none";
	 document.getElementById("Quote").style.display = "none";

        if(option == "Opportunity"){
            document.getElementById("Opportunity").style.display = "block";
        }else if (option == "Lead"){
            document.getElementById("Lead").style.display = "block";
 	}else if (option == "Campaign"){
            document.getElementById("Campaign").style.display = "block";
	}else if (option == "Ticket"){
            document.getElementById("Ticket").style.display = "block";
	}else if (option == "Quote"){
            document.getElementById("Quote").style.display = "block";
        }



    }
    

    //By Chetan3Aug//
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
       $("#form1").submit(function(){
        var err;
        $('div.red').html('');
        $("#form1  :input[data-mand^=\'y\']").each(function(){
            
             $fldname = $(this).attr('name');
							$fldname = $fldname.replace('[]',''); //by niraj for multicheckbox
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

                   /* if($('#'+$fldname+':checked').length < 1)
                    {
                         $("#"+$fldname+"err").html(""+$input+" is mandatory field.");
                         err = 1;
                    }*/

										//by niraj for checkbox 11feb16
										if($('input[name^="'+$fldname+'"]').length == 1)
												{ 
														if($('#'+$fldname+':checked').length < 1)
															{
																$("#"+$fldname+"err").html(""+$input+" is mandatory field.");
																err = 1;
															}
										}else{
												if($('input[name^="'+$fldname+'"]:checked').length < 1)
												{  
													$("#"+$fldname+"err").html(""+$input+" is mandatory field.");
													err = 1;
												}

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
        if($("#EntryType").val() == "recurring")
        {
            if($("#EntryFrom").val()=='')
            {
                err = 1;     
                $("#EntryFromerr").html("Entry From is mandatory field.");
            }
            if($("#EntryTo").val()=='')
            {
                err = 1;
                $("#EntryToerr").html("Entry To is mandatory field.");
            }

            if($("#EntryFrom").val()!='' && $("#EntryTo").val()!='' && ($("#EntryTo").val() < $("#EntryFrom").val())){
                err = 1;
                $("#EntryToerr").html("End Date Should be Greater Than Start Date.");
            }
            	
        }
        
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
   
   
   
$(function() {
        $('#startTime').timepicker({'timeFormat': 'H:i:s'});
        $('#closeTime').timepicker({'timeFormat': 'H:i:s'});
    });


    function activity2(ref) {


        if (ref == 'Task') {
            window.location.href = "editActivity.php?module=Activity&mode=" + ref;
        } else {
            window.location.href = "editActivity.php?module=Activity&mode=" + ref;
            ;
        }

    }   
</script>




<a class="back" href="<?=$RedirectURL?>">Back</a>

<? if($_GET['edit']>0){ ?>
<a href="outlookEvent.php?activityID=<?=$_GET['edit']?>" class="download" style="float:right;margin-left:5px;">Save to outlook</a>
<?} ?>

<div class="had">
Manage Event   &raquo; <span>
	<? if($_GET["tab"]=="Summary"){?>
<? 	echo (!empty($_GET['edit']))?(" ".ucfirst($_GET["tab"])." Details") :("Add ".$ModuleName); ?>
<?} else{?>

	<? 	echo (!empty($_GET['edit']))?("Edit ".ucfirst($ModuleName)." Details") :("Add ".$ModuleName); ?>
	<? }?>
		
		
		</span>
</div>

<div class="message" align="center"><?php
    if (!empty($_SESSION['mess_activity'])) {
        echo $_SESSION['mess_activity'];
        unset($_SESSION['mess_activity']);
    }
    if (!empty($_SESSION['EventLastInsertId'])) { //echo "<pre>"; print_r($OutlookFileData[0]);
	
	$OutlookFileData = $objActivity->GetActivity($_SESSION['EventLastInsertId'],'');

        $startDate = $OutlookFileData[0]["startDate"];
        $startDateStr = date_format(date_create($startDate), 'd M');
        $closeDate = $OutlookFileData[0]['closeDate'];
        $closeDateStr = date_format(date_create($closeDate), 'd M');
        $startTime = $OutlookFileData[0]['startTime'];
        $closeTime = $OutlookFileData[0]['closeTime'];
        $location = $OutlookFileData[0]['location'];
        
        $subject = $OutlookFileData[0]['subject']." - ".$OutlookFileData[0]['activityType']." [".$startDateStr."-".$closeDateStr."]";   
        $description = strip_tags($OutlookFileData[0]['description']);        
        echo "<br/><a id='msg' href='outlook.php?startDate=$startDate&closeDate=$closeDate&startTime=$startTime&closeTime=$closeTime&location=$location&subject=$subject&description=$description'>Save event to outlook</a>";
        unset($_SESSION['EventLastInsertId']);
    }else{ echo "<span id='msg' style='display:none;' ></span>"; }
    ?></div>




	<? 
	if (!empty($_GET['edit'])) {
		include("includes/html/box/activity_edit.php");
	}else{
		include("includes/html/box/activity_form.php");
	}
	
	
	?>

 
