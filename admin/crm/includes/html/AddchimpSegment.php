<body>
<link href='fullcalendar/socialfbtwlin.css' rel='stylesheet' />
<script type="text/javascript" src="multiSelect/jquery.tokeninput.js"></script>
<link rel="stylesheet" href="multiSelect/token-input.css" type="text/css" />
<link rel="stylesheet" href="multiSelect/token-input-facebook.css" type="text/css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" type="text/css" />
<link rel="stylesheet" href="https://cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.css" type="text/css" />
<script type="text/javascript" src="https://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.js"></script>
<style>
    
    a.add_quick {
    background: url("../../admin/images/edit_white.png") no-repeat scroll 5px 7px #535353;
    border: medium none;
    border-radius: 2px;
    color: #ffffff !important;
    cursor: pointer;
    float: right;
    font-size: 12px;
    margin: 0 0 0 5px;
    padding: 4px 5px 2px 20px;
    text-decoration: none !important;
}
    #example_length,#example_info {
    float: left;
}

.disabled {
    background: none !important;
    border: none !important;
    border-radius: 0px !important;
    
    padding: 0 !important;
}
.next {
    
    margin: 0 !important;
    width: auto !important;
}
</style>
<script type="text/javascript">
$(document).ready(function() {
    $('#selecctall').click(function(event) {  //on click
        if(this.checked) { // check select status
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"              
            });
        }else{
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                      
            });        
        }
    });
   
});

</script>
<script>
$(document).ready(function() {
    $('#example').dataTable(
            {
                "ordering":false,
                 stateSave:true,
                 "lengthMenu": [ [10, 25, 50,100, -1], [10, 25, 50,100, "All"] ]
    }
                );
} );
</script>

<a class="back" href="javascript:void(0)" onclick="window.history.back();">Back</a>
<a href="viewchimpSegment.php" class="fancybox add_quick">List Segment</a>
<div class="had">Create Segment </div>

<div>
<TABLE WIDTH="100%"   BORDER=0 align="center"  >
	
  
<tr>
<td align="left" valign="top">
 <form name="form1" action=""  method="post" onSubmit="return validate(this);" enctype="multipart/form-data">
<table width="100%"  border="0" cellpadding="0" cellspacing="0">

			<? if (!empty($_SESSION['message'])) {?>
			<tr>
			<td  align="center"  class="message"  >
			<? if(!empty($_SESSION['message'])) {echo $_SESSION['message']; unset($_SESSION['message']); }?>	
			</td>
			</tr>
			<? } ?>
  
		<tr>
			<td  align="center" valign="top" >
			<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
			<tr>
			<td colspan="2" align="left"  class="head" >Segment Information</td>
			</tr>
                        <tr>
                            <td colspan="2">&nbsp;&nbsp; </td>
			</tr>
			<tr>
			<td  align="right" width="40%"   class="blackbold">Segment Name: </td>
			<td   align="left" >
			<input name="name" type="text" class="inputbox" id="title" value="<?php echo !empty($_POST['name'])?$_POST['name']:'';?>"/></td>
			</tr>
                        <tr>
                            <td colspan="2">&nbsp;&nbsp; </td>
			</tr>
			
			<tr>
			<td  colspan="2" align="left" class="head"> Select User </td>
			</tr>
                        <tr>
                            <td colspan="2">&nbsp;&nbsp; </td>
			</tr>
			<tr>
            <td  valign="top" colspan="2">
                <div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
                <div id="preview_div">
                    <table id="example" class="table table-striped table-bordered" width="100%" cellspacing="0">
                        <thead>
						<tr align="left">
						<th><input type="checkbox" id="selecctall" value=""></th>
						<th>First Name</th>  
						<th>Last Name</th>								
						<th>Email</th> 
						<th>Created Date</th>
						<th>Status</th>
							
						</tr>
                                                </thead>
                                                <tbody>
<?    //echo "<pre>";print_r($ChimpUserList);die;
                        
                            foreach($ChimpUserList as $key => $values) {
                                
                            ?>
							<tr align="left"> 
							<td><input type="checkbox"  value="<? echo $values['euid']; ?>" class="checkbox1" name="check[]"></td> 
							 <td><?= (!empty($values['fname'])) ? (stripslashes($values['fname'])) : (NOT_SPECIFIED) ?> </td>
							 <td><?= (!empty($values['lname'])) ? (stripslashes($values['lname'])) : (NOT_SPECIFIED) ?> </td>
							 <td><?= (!empty($values['email'])) ? (stripslashes($values['email'])) : (NOT_SPECIFIED) ?> </td>		
							<td align="center">
							<?= (!empty($values['create_date'])) ? (date('m-d-Y h:i:s',strtotime(stripslashes($values['create_date'])))) : (NOT_SPECIFIED) ?>		
							</td>
							<td><?= (!empty($values['status'])) ? (stripslashes($values['status'])) : (NOT_SPECIFIED) ?> </td>	
							
							</tr>
                           <?php } // foreach end //?>

                         
                        </tbody>
                    </table>

                </div> 
		

                

            </td>
        </tr>
        
			</table>	
			</td>
		</tr>
		 
                <tr>
                            <td colspan="2">&nbsp;&nbsp; </td>
			</tr>

		<tr>
			<td  align="center" >
			<div id="SubmitDiv" style="display:none1">
			<input name="Submit" type="submit" class="button" id="SubmitButton" value="Submit" />
			</div>
			</td>
		</tr>
   
   
</table></form>
	</td>
    </tr>
 
</table>
</div>
