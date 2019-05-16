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
      // $('#assign').click(function() {
        //         $('#user').hide();
          //      $('#group').show();
                
        //});
//8july//
   $('#lead_status').change(function(){
      
       if($(this).val()=='Not Contacted')
       {
           $('#LastContactDate').val('');
           $('#LastContactDate').closest('td').hide().prev().hide();
       }else{
           $('#LastContactDate').closest('td').show().prev().show();
       }
       
   });
      //End//
    }); 
    
  //End//  

 
    
$(function(){
       $("#form1").submit(function(){
        var err;
        $('div.red').html('');
	var stateDisplay = $("#state_td").css('display');
        $("#form1  :input[data-mand^=\'y\']").each(function(){
            
            $input = ($(this).closest('td').prev().clone().children().remove().end().text()).replace(':','');
            $fldname = $(this).attr('name');
            $fldname = $fldname.replace('[]',''); //by niraj for multicheckbox
            if($(this).attr('type') == '' || typeof($(this).attr('type')) == 'undefined' || $(this).attr('type') == 'text')
            {
              if( $.trim($(this).val()) == "")
              {

                if(($fldname == "OtherState" && ($('#state_id').val()!='' && typeof($('#state_id').val())!="undefined")) || 
                    ($fldname == "OtherCity" && ($('#city_id').val()!='' &&  typeof($('#city_id').val())!="undefined"))  ||
                     ($fldname == "company" && $('#type').val()!='' && $('#type').val()!='Company')
                    ){}else{
                        
                        if($fldname == "OtherState" || $fldname == "OtherCity")
                        {
                            $input = ($(this).closest('td').prev('td').clone().children().remove().text()).replace(':*','');
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
else{//by niraj for checkbox 11feb16
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



               if($fldname == "primary_email" && $(this).val()!= "")
               {    
                    emailID = $(this).val();
              /*      atpos = emailID.indexOf("@"); By Rajan 08 feb 2016
                    dotpos = emailID.lastIndexOf(".");
                    if (atpos < 1 || ( dotpos - atpos < 2 )) */
		  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		  if(regex.test(emailID) == false)
                    {
                        $("#"+$fldname+"err").html("Please enter correct email.");
                        err = 1; 
                    }
               }
              
          });

// BY Rajan 08 feb 2016
	
		if( $("#primary_email").attr('data-mand') == 'n' && $("#primary_email").val()!="" )
		{
			  emailID =  $("#primary_email").val();
			  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			  if(regex.test(emailID) == false)
	          {
	        	  $("#primary_email"+"err").html("Please enter correct email.");
	              err = 1; 
			  }
		}
// End by Rajan 08 feb 2016


        if(err == 1) return false; else return true;
       });
      
      $('#type').change(function(){
          
          check($(this).val());
      })
      
      check($('#type').val());
      
      function check(val)
      {
          if(val== 'Individual')
          {
              $('#company').closest('td').hide();	
              $('#company').closest('td').prev().hide();
          }else{
              $('#company').closest('td').show();
              $('#company').closest('td').prev().show();
          }
      }
      
      $farr = ['ZipCode','LandlineNumber','Mobile'];
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




<div class="back"><a class="back" href="<?=$RedirectURL?>">Back</a></div>


<div class="had">
Manage Lead   &raquo; <span>
	<?php if($_GET["tab"]=="Summary"){?>
<?php 	echo (!empty($_GET['edit']))?(" ".ucfirst($_GET["tab"])." Details") :("Add ".$ModuleName); ?>
<?php } else{ ?>

	<?php 	echo (!empty($_GET['edit']))?("Edit ".ucfirst($ModuleName)." Details") :("Add ".$ModuleName); ?>
	<?php }?>
		
		
		</span>
</div>

	<?php if(!empty($errMsg)) {?>
  
    <div  align="center"  class="red" ><?php echo $errMsg;?></div>
    
  <?php } ?>
   


	<?php 
	if (!empty($_GET['edit'])) {
		include("includes/html/box/lead_edit.php");
	}else{
		include("includes/html/box/lead_form.php");
	}
	
	
	?>

	
