<script type="text/javascript" src="multiSelect/jquery.tokeninput.js"></script>
<link rel="stylesheet" href="multiSelect/token-input.css" type="text/css" />
<link rel="stylesheet" href="multiSelect/token-input-facebook.css" type="text/css" />
<script type="text/javascript" src="../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../js/ewp50.js"></script>
<script type="text/javascript">
	var ew_DHTMLEditors = [];
</script>
<script language="JavaScript1.2" type="text/javascript">
  //By chetan 30june//  
 /*$(document).ready(function() {
        $('#assign1').click(function() {
                $('#group').hide();
                $('#user').show();

        });
       $('#assign2').click(function() {
                 $('#user').hide();
                $('#group').show();
                
        });
    }); */
    
 $(function(){
     
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
     
     
     
     
       $("#form1").submit(function(){
        var err;
        $('div.red').html('');
	var stateDisplay = $("#state_td").css('display');
        $("#form1  :input[data-mand^=\'y\']").each(function(){
           $fldname = $(this).attr('name');
						$fldname = $fldname.replace('[]',''); //by niraj for multicheckbox
             $input = ($(this).closest('td').prev().clone().children().remove().end().text()).replace(':','');
            if($(this).attr('type') == '' || typeof($(this).attr('type')) == 'undefined' || $(this).attr('type') == 'text')
            {
              if( $.trim($(this).val()) == "")
              {
                  
                if(($fldname == "OtherState" && ($('#state_id').val()!='' && typeof($('#state_id').val())!="undefined")) || 
                    ($fldname == "OtherCity" && ($('#city_id').val()!='' &&  typeof($('#city_id').val())!="undefined"))  )
                    {}else{
                        
                        if($fldname == "OtherState" || $fldname == "OtherCity")
                        {
                            $input = ($(this).closest('td').prev('td').clone().children().remove().text()).replace(':*','');
                        }else if($fldname == "CloseTime"){
                            $input = 'Close Time';
                        }
                
			if($fldname == "OtherState" && stateDisplay=='none'){
				//alert('hi');
			}else{
		                $("#"+$fldname+"err").html(""+$input+" is mandatory field.");
		                err = 1;
			}
                }    
              }
              
            }/*else{
                 
                if($('#'+$fldname+':checked').length < 1)
                {
                     $("#"+$fldname+"err").html(""+$input+" is mandatory field.");
                     err = 1;
                }
            }*/
else{ //by niraj for checkbox 11feb16
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
                  if($('#assign:checked').length < 1)
                  {
                    $input = ($(this).closest('td').prev().clone().children().remove().end().text()).replace(':','');
                    $("#"+$fldname+"err").html(""+$input+" is mandatory field.");
                    err = 1;
                  }else{
                           
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
              
              
              if($fldname == "primary_email" && $(this).val()!= "")
               {    
                    emailID = $(this).val();
                    atpos = emailID.indexOf("@");
                    dotpos = emailID.lastIndexOf(".");
                    if (atpos < 1 || ( dotpos - atpos < 2 )) 
                    {
                        $("#"+$fldname+"err").html("Please enter correct email.");
                        err = 1; 
                    }
               }
            });
          
		if($("#CloseDate").val()!='' && $("#TodayDate").val()!='' && ($("#CloseDate").val() <= $("#TodayDate").val())){
			 $("#CloseDateerr").html("Expected Close Date should be greater than Today Date.");
			 err = 1;	
		     }
		     
		if(err == 1){ return false; }else{ 

		    var Url = "isRecordExists.php?OpportunityName="+escape(document.getElementById("OpportunityName").value)+"&editID="+document.getElementById("OpportunityID").value+"&Type=Opportunity";
		    SendExistRequest(Url,"OpportunityName", "Opportunity Name");
		    return false;
		}
       });
      
      
      $farr = ['Amount','Probability','forecast_amount'];
      $('input').keypress(function(e){
          
         if($.inArray($(this).attr('name'),$farr ) != -1)
         {
             return isDecimalKey(e);
         }
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

//End//
   });   
    
//End//

</script>


<div class="back"><a class="back"  href="<?=$RedirectURL?>">Back</a></div>


<div class="had">
Manage Opportunity   <span> &raquo; 

<? 
	if($_GET["tab"]=="Summary"){

	      echo (!empty($_GET['edit']))?(" ".ucfirst($_GET["tab"])." Details") :("Add ".$ModuleName); 

	} else{ 
	
              echo (!empty($_GET['edit']))?("Edit ".ucfirst($ModuleName)." Details") :("Add ".$ModuleName); 
	}
?>
		
	</span>	
</div>

	
  <? if (!empty($errMsg)) {?>
    <div align="center"  class="red" ><?php echo $errMsg;?></div>
  <? } ?>
  
	
	<? 
	if (!empty($_GET['edit'])) {
		include("includes/html/box/opportunity_edit.php");
	}else{
		include("includes/html/box/opportunity_form.php");
	}
	
	
	?>

	
	
 

