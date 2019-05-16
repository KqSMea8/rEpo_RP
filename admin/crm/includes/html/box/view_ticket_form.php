<script language="JavaScript1.2" type="text/javascript">
 function validateLeadForm(frm){
   
    var listbox = document.getElementById("columnTo");
    
    var len = listbox.options.length;
    if(len>0){
        for(var count=0; count < len; count++) {
                listbox.options[count].selected = true;
        }
    }else{
        alert('Please Move Fields to Lead Form Fields.');
         return false;
    }
    
    if(!ValidateForSimpleBlank(frm.FormTitle, "Form Title")) {
        return false;
    }
    if(!ValidateForSimpleBlank(frm.Subtitle, "Subtitle")) {
        return false;
    }
    /*if(!ValidateForSimpleBlank(frm.ActionUrl, "Form Action Url")) {
        return false;
    }*/
    
   ShowHideLoader('1', 'S');
   return true;
        
}
   
function MoveFields() {
     $("#first_div").hide();
     $("#add_all_div").hide();
     $("#move_div").show();
     $("#cancel").show();
     $("#submit").show();
     $("#other_info").show();
     $("#entry_all").val("0");
 }

</script>

 <script type="text/javascript">  
  $().ready(function() { 
      
   $('#fromall').click(function() { 
    return !$('#columnFrom option').remove().appendTo('#columnTo');  
   });  
   $('#add').click(function() { 
    return !$('#columnFrom option:selected').remove().appendTo('#columnTo');  
   });  
   $('#remove').click(function() {  
    return !$('#columnTo option:selected').remove().appendTo('#columnFrom');  
   });  
   $('#removeall').click(function() { 
    return !$('#columnTo option').remove().appendTo('#columnFrom');  
   });
  });  
 </script> 




<div id="preview_div">
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
    
 <?  if($arryLeadForm[0]['formID']>0){ ?>
   
    <tr>
       <td align="right" >
    <a href="vTicketForm.php?formid=<?=$_GET['view']?>&opt=preview" class="fancybox grey_bt fancybox.iframe">View Preview</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="vTicketForm.php?formid=<?=$_GET['view']?>&opt=code" class="fancybox grey_bt  fancybox.iframe">View HTML Code</a>
       </td>
       
</tr> 
    
    
<? }?>

 

 <tr>
       <td align="right" >
   <a href="leadForm.php">Back to Create Ticket Form</a>
       </td>
       
</tr> 

   <tr>
       <td align="left" class="head">
    HTML Code for Ticket Form
       </td>
       
</tr>
    <tr>
       <td align="center" ><br>
     <textarea name="Description" type="text" class="textarea" id="Description" style="width:90%;height:800px;" readonly  ><?php echo htmlentities(stripslashes($arryLeadForm[0]['HtmlForm'])) ?></textarea>    
      
       <br>
       </td>
       
</tr>
    
 

</table>
</div>

