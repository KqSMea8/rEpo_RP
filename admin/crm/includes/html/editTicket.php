<script type="text/javascript">
	function selModule() {
		
		var option = document.getElementById("RelatedType").value;
	
		document.getElementById("Opportunity").style.display = "none";
		document.getElementById("Lead").style.display = "none";
		document.getElementById("Campaign").style.display = "none";
		document.getElementById("Quote").style.display = "none";
		//alert();

		//alert(option);return false;
		if(option == "Opportunity"){
			document.getElementById("Opportunity").style.display = "block";
		}else if (option == "Lead"){
			document.getElementById("Lead").style.display = "block";
		}else if (option == "Campaign"){
			document.getElementById("Campaign").style.display = "block";
		}else if (option == "Quote"){
			document.getElementById("Quote").style.display = "block";
		}
	}
</script>
<script type="text/javascript" src="multiSelect/jquery.tokeninput.js"></script>

    <link rel="stylesheet" href="multiSelect/token-input.css" type="text/css" />
    <link rel="stylesheet" href="multiSelect/token-input-facebook.css" type="text/css" />
 <script>

       
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
        $("#form1  :input[data-mand^=\'y\']:not('#sendnotification')").each(function(){               
               $fldname = $(this).attr('name');
								$fldname = $fldname.replace('[]',''); //by niraj for multicheckbox
               $input = ($(this).closest('td').prev().clone().children().remove().end().text()).replace(':','');
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
              
              
          });
           //23July//
        if($('#sendnotification').is(':checked'))
        {
            if($('#notifications').val()==''){$('#notificationserr').html('Notifications is mandatory field');err = 1;}
        }
        
        if($('#sendnotification').attr('data-mand') == 'y' && $('#sendnotification').is(':visible') && $('#sendnotification:checked').length < 1)
        {
            $name = $('#sendnotification').prev().text().replace(':*',''); 
            $("#sendnotificationerr").html(""+$name+" is mandatory field.");
            err = 1;
        }
        
        
        //End//
        if(err == 1){ return false; }else{ 
        
            var Url = "isRecordExists.php?TicketTitle="+escape(document.getElementById("title").value)+"&editID="+document.getElementById("TicketID").value+"&Type=Ticket";
            SendExistRequest(Url,"title", "Ticket Title");
            return false;
        }    
       });
      
      
      
    //By Chetan 31July//
      if($('#form1 input:checkbox').length>0){
         
        $(document).on('click','#form1 input:checkbox',function(){
            
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
      
      //23July//
      //To drag Notifications dropdown and drop after sendnotification tr//
      $(document).on('click','#sendnotification',function(){
        if($(this).is(':checked'))
        {
             setTimeout(function(){ $('tr #notifi').show(); }, 100);
        }else{
            $('tr #notifi').hide();
            $('#notifications option:first').attr('selected',true);
        } 
      })
      //End//
      //31july//
        $sn = $('#sendnotification');
        $('#sendnotification').closest('td').addBack().hide().prev().hide();
        $fl = $sn.closest('td').prev().clone().end().html();
        $("tr #CustID").css('float','left');
        $("tr #CustID").after('<div style="float:left; margin-left:5px; display:none;">'+$fl+'</div>');
        $("tr #CustID").next().after(($sn.nextAll().addBack()).clone().css('margin-left','1px'));
        $sn.parent().prev().addBack().remove();
        $("#CustIDerr").css({"width":"100%","float":"left"});
        $("#sendnotificationerr").css({"clear": "left","float": "right","margin-right": "10px","margin-top": "-11px"});
        
        $sn.is(':checked') ? $('#sendnotification').prev().addBack().show() :false;

        $('#CustID').change(function(){
            if($(this).val()!='')
            {
              $('#sendnotification').prev().addBack().show();
            }else{
              $('#sendnotification').prev().addBack().hide();
              $("#sendnotificationerr").text('');
              $("#notificationserr").text('');
              $('tr #notifi').hide();
              $('#sendnotification').attr('checked',false);
              $('#notifications option:first').attr('selected',true);
            }    

        })
        //End//
      

//by chetan on 23Aug2017//
$('#CustID').change(function(){
	custid = $(this).val();
	showAddcont(custid);
})

$(document).on('change', '#contact_id', function(){
	contid = $(this).val();
	$('#contact_no').val('');	
	SendUrl = 'action=getNofor&CONTID='+contid;	
	$.ajax({
		type : "POST",
		url : "ajax.php",
		data : SendUrl,
	}).done(function(msg){
		if(msg){
			$('#contact_no').val(msg);	
		}
			
	})
})
//End//

});  


//by chetan on 18Aug2017//  
function showAddcont(custid)
{
	SendUrl = 'action=getAddforCusticket&CUSTID='+custid;	
	$.ajax({
		type : "POST",
		url : "ajax.php",
		data : SendUrl,
		dataType : "JSON",		
	}).done(function(msg){
		if(msg.Email){
			if($('#Email').length){$('#Email').val(msg.Email);$('#Email').attr('readonly',true);}
		}
		$('#CustAddinfo').remove();
		if(msg.Add){							
			$('#CustID').closest('tr').after(msg.Add);			
		}
	})
	
}
$(window).load(function(){
	custid = $('#CustID option:selected').val();
	showAddcont(custid);
});
//End//

//End"width":"100%","margin-left":"-87px","float":"left"//


    </script>

<div class="back"><a class="back" href="<?=$RedirectURL?>">Back</a></div>


<div class="had">
Manage <?= (isset($_GET['parent_type'])) ? $_GET['parent_type'] : '';?> Ticket   <span> &raquo; 
	<? 	echo (!empty($_GET['edit']))?("Edit ".ucfirst($_GET["tab"])." Details") :("Add ".((isset($_GET['parent_type'])) ? $_GET['parent_type'] : '')." ".$ModuleName); ?>
	</span>	
		
</div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<? if (!empty($errMsg)) {?>
  <tr>
    <td height="2" align="center"  class="red" ><?php echo $errMsg;?></td>
    </tr>
  <? } ?>
  
	<tr>
	<td align="left" valign="top">

	<? 
	if (!empty($_GET['edit'])) {
		include("includes/html/box/ticket_edit.php");
	}else{
		include("includes/html/box/ticket_form.php");
	}
	
	
	?>

	
	</td>
    </tr>
 
</table>
