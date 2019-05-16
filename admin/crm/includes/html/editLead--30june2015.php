<script type="text/javascript" src="multiSelect/jquery.tokeninput.js"></script>
<link rel="stylesheet" href="multiSelect/token-input.css" type="text/css" />
<link rel="stylesheet" href="multiSelect/token-input-facebook.css" type="text/css" />
<script type="text/javascript" src="../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../js/ewp50.js"></script>
<script type="text/javascript">
	var ew_DHTMLEditors = [];
</script>
<script language="JavaScript1.2" type="text/javascript">
    //By chetan//
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
    }); 
    
  //End//  
    
$(function(){
       $("#form1").submit(function(){
        var err;
        $('div.red').html('');
        $("#form1  :input[data-mand^=\'y\']").each(function(){
              if( $.trim($(this).val()) == "")
              {
             
                if(($(this).attr('name') == "OtherState" && $('#state_id').val()!='') || 
                    ($(this).attr('name') == "OtherCity" && $('#city_id').val()!='')  ||
                    ($(this).attr('name') == "company" && $('#type').val()!='')
                    ){}else{
                    $("#"+$(this).attr('name')+"err").html(""+$(this).attr('name')+" is mandatory field.");
                    err = 1;
                }    
              }
              if($(this).attr('name') == "PrimaryEmail" && $(this).val()!= "")
               {    
                    emailID = $(this).val();
                    atpos = emailID.indexOf("@");
                    dotpos = emailID.lastIndexOf(".");
                    if (atpos < 1 || ( dotpos - atpos < 2 )) 
                    {
                        $("#"+$(this).attr('name')+"err").html("Please enter correct email.");
                        err = 1; 
                    }
               }
              
          });
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
      
      
      
      
   }); 

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

	
