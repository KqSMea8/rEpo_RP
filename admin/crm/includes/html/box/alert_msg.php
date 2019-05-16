<!--By Chetan 4Dec-->
<script type="text/javascript" src="javascript/jquery.timepicker.js"></script>
<link rel="stylesheet" type="text/css" href="javascript/jquery.timepicker.css" />
<script language="JavaScript1.2" type="text/javascript">
$(function(){
    
    $('.AddRemd').click(function(){
        $('#popup1').fadeIn("slow");               
    })
    
    $(".js-modal-close").click(function() {
        $(".modal-box").fadeOut(500);
    });

})

$(function() {
    $("#startDate").datepicker({
        showOn: "both",
        yearRange: '<?= date("Y") - 20 ?>:<?= date("Y") +20?>',
        dateFormat: 'yy-mm-dd',
        maxDate: "",
        changeMonth: true,
        changeYear: true
    });
     $("#closeDate").datepicker({
        showOn: "both",
        yearRange: '<?= date("Y") - 20 ?>:<?= date("Y")+20 ?>',
        dateFormat: 'yy-mm-dd',
        maxDate: "",
        changeMonth: true,
        changeYear: true
    });
});
           
$(function() {
    $('#closeTime').timepicker({ 'timeFormat': 'H:i:s' });
    $('#startTime').timepicker({ 'timeFormat': 'H:i:s' });
});

</script>



<div id="popup1" class="modal-box">
  <header> <a href="#" class="btn btn-small js-modal-close">Close</a> 
      <h3>Add Reminder</h3>
  </header>
 <form name="quickremdform" id="quickremdform" action=""  method="post" enctype="multipart/form-data">

  <div class="modal-body">
      <div class="popuprem">
          <span class="blackbold datecol" >Start Date :</span>
          <span>
              <input style=""  name="startDate" class="datebox" id="startDate" value="" type="text" readonly="readonly"  />
              <input type="text" name="startTime" id="startTime" size="10" class="disabled time" id="startTime"  value="" placeholder="Start Time"/>
          </span>
          
      </div>
      <div class="popuprem">
          <span class="blackbold datecol" >Close Date :</span>
          <span>
              <input  name="closeDate" class="datebox" id="closeDate" value=""  readonly="readonly" size="10"/>
              <input type="text" name="closeTime" id="closeTime" size="10" class="disabled time" id="startTime"  value="" placeholder="Close Time"/>

          </span>
          
      </div>
      <div class="popuprem" style="width: 100%; text-align: center;">
     <input type="submit" value="Submit" id="SubmitButton" class="button" name="AddRemd">
     <input type="hidden" name="LeadID" id="LeadID" value="<?= $_GET['view'] ?>" />
     <input type="hidden" name="created_by" id="created_by"  value="<?= $_SESSION['AdminType'] ?>" />
     <input type="hidden" name="created_id" id="created_id"  value="<?= $_SESSION['AdminID'] ?>" />
     
      </div>

</div>
 </form>

</div>






<!--End--->










<div id="alert_div" style="display:none;  height: 50px;" >

   
    <div class="redmsg" align="center">Sorry, you are not authorized to access this section.</div>
 
	
</div>	


