<script language="JavaScript1.2" type="text/javascript">
function SelectAllRecord()
{	
	for(i=1; i<=document.form1.Line.value; i++){
		document.getElementById("Modules"+i).checked=true;
	}

}

function SelectNoneRecords()
{
	for(i=1; i<=document.form1.Line.value; i++){
		document.getElementById("Modules"+i).checked=false;
	}
}

function ShowOther(FieldId){
	if(document.getElementById(FieldId).value=='Other'){
		document.getElementById(FieldId+'Span').style.display = 'inline'; 
	}else{
		document.getElementById(FieldId+'Span').style.display = 'none'; 
	}
}

function ShowPermission(){
	if(document.getElementById("Role").value=='Admin'){
		document.getElementById('PermissionTitle').style.display = 'block'; 
		document.getElementById('PermissionValue').style.display = 'block'; 
	}else{
		document.getElementById('PermissionTitle').style.display = 'none'; 
		document.getElementById('PermissionValue').style.display = 'none'; 
	}
}





//By Chetan3Aug//

$(function(){
       $("#form1").submit(function(){
        var err;
        $('div.red').html('');
        $("#form1  :input[data-mand^=\'y\']").each(function(){
            
            $input = ($(this).closest('td').prev().clone().children().remove().end().text()).replace(':','');
            $fldname = $(this).attr('name');
						$fldname = $fldname.replace('[]',''); //by niraj for multicheckbox
            if($(this).attr('type') == '' || typeof($(this).attr('type')) == 'undefined' || $(this).attr('type') == 'text')
            {
              if( $.trim($(this).val()) == "")
              {
                        $("#"+$fldname+"err").html(""+$input+" is mandatory field.");
                        err = 1;
              }
              
             }/*else{
                 
                if($('#'+$fldname+':checked').length < 1)
                {
                     $("#"+$fldname+"err").html(""+$input+" is mandatory field.");
                     err = 1;
                }
            } */
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
            
          });
          
        /*if($('#campaigntype').val() == 'MassEmailCampaign') 
        {
            if($('#MassEmailCampaigntype').val() == ''){$('#MassEmailCampaigntypeerr').html('Mass Email Campaign is mandatory field');err=1;}else{
            if($('#MassEmailCampaigntype').val() != ''){if($('#MailChimpcampaigntype').val() == '' || $('#MailChimpcampaigntype').val() == null){$('#mailerr').html('Mail Chimp is mandatory field');err=1;}
            } 
        }
            
        }    */
          
          
        if(err == 1) return false; else return true;
       });
      
      
      $farr = ['budgetcost','actualcost','expectedrevenue','expectedroi','actualroi','expectedsalescount','actualsalescount','expectedresponsecount','actualresponsecount'];
      $('input').keypress(function(e){
          
         if($.inArray($(this).attr('name'),$farr ) != -1)
         {
             return isNumberKey(e);
         }
      });
      
      
      
      
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
      
      
      
      
     
    //To drag MassEmailCampaign dropdown and drop after compaigntype tr// 
   $(':input[name="campaigntype"]').closest('tr').after($('tr #sdrop').remove().clone());
      
  
  
  $('#CloseTime').timepicker({ 'timeFormat': 'H:i:s' });
			$('#timeformatExample2').timepicker({ 'timeFormat': 'h:i A' });
		
    
    $('#campaigntype').change(function(){

          if ($(this).val() == "MassEmailCampaign") {
                document.getElementById('com').style.display = 'block';
                document.getElementById('com_title').style.display = 'block';
            } else {
                document.getElementById('com').style.display = 'none';
                document.getElementById('com_title').style.display = 'none';

                document.getElementById('mailchimp_com').style.display = 'none';
                document.getElementById('mailchimp_title').style.display = 'none';
                document.getElementById('IContact_com').style.display = 'none';
                document.getElementById('IContact_title').style.display = 'none';
                document.getElementById('ConstantContant_com').style.display = 'none';
                document.getElementById('ConstantContant_title').style.display = 'none';
                //document.getElementById('company').value = '';
            }

    })
  
  
  
      
   });






$(window).load(function(){ $('#sdrop').show();})

    
function lMtype() {
    
    var optm = document.getElementById('MassEmailCampaigntype').value;
    if (optm=="MCampaign"){
        document.getElementById('mailchimp_com').style.display = 'block';
        document.getElementById('mailchimp_title').style.display = 'block';
        document.getElementById('ConstantContant_com').style.display = 'none';
        document.getElementById('ConstantContant_title').style.display = 'none';
        document.getElementById('IContact_com').style.display = 'none';
        document.getElementById('IContact_title').style.display = 'none';
        
    }
    else if(optm=="IContact"){
        
        document.getElementById('IContact_com').style.display = 'block';
        document.getElementById('IContact_title').style.display = 'block';
        document.getElementById('mailchimp_com').style.display = 'none';
        document.getElementById('mailchimp_title').style.display = 'none';
        document.getElementById('ConstantContant_com').style.display = 'none';
        document.getElementById('ConstantContant_title').style.display = 'none';
    }
    else if(optm=="ConstantContant"){
        
        document.getElementById('ConstantContant_com').style.display = 'block';
        document.getElementById('ConstantContant_title').style.display = 'block';
        document.getElementById('mailchimp_com').style.display = 'none';
        document.getElementById('mailchimp_title').style.display = 'none';
        document.getElementById('IContact_com').style.display = 'none';
        document.getElementById('IContact_title').style.display = 'none';
    }
}
//End//
</script>






<div class="back"><a class="back"  href="<?=$RedirectURL?>">Back</a></div>


<div class="had">
Manage Campaign   &raquo; <span>
<? if($_GET["tab"]=="Summary"){?>
<? 	echo (!empty($_GET['edit']))?(" ".ucfirst($_GET["tab"])." Details") :("Add ".$ModuleName); ?>
<?} else{?>

	<? 	echo (!empty($_GET['edit']))?("Edit ".ucfirst($ModuleName)." Details") :("Add ".$ModuleName); ?>
	<? }?>
		
		</span>
</div>

	
  <? if (!empty($errMsg)) {?>
    <div align="center"  class="red" ><?php echo $errMsg;?></div>
  <? } ?>
  
	
	<? 
	if (!empty($_GET['edit'])) {
		include("includes/html/box/campaign_edit.php");
	}else{
		include("includes/html/box/campaign_form.php");
	}
	
	
	?>

	
	
 

