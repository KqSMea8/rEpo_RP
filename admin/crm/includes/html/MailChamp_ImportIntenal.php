<?php //session_start(); ?>
<body>
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


<SCRIPT LANGUAGE=JAVASCRIPT>
    function ValidateForm(frm)
    {
        if (ValidateMandExcel(frm.excel_file, "Please upload sheet in excel format."))
        {

            ShowHideLoader('1', 'P');
            return true;
        } else {
            return false;
        }

    }





</SCRIPT>
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
<a href="viewchimpUser.php" class="fancybox add_quick">List User</a>


<!--a href="dwn.php?file=<?= $DownloadFile ?>" class="download" style="float:right">Download Template</a--> 

<div class="had">Import User</div>


<div align="center" id="ErrorMsg" class="redmsg"><br><?= $ErrorMsg ?></div>


<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Loading..............</div>
<div id="preview_div">	


    <div>
            <?php if(empty($UserData['data'])){ ?>
            <form name="form1" action method="post" onSubmit="return ValidateForm(this);" enctype="multipart/form-data">
              <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
                  <?php if (!empty($_SESSION['message'])) {?>
			<tr>
			<td  align="center"  class="message"  >
			<? if(!empty($_SESSION['message'])) {echo $_SESSION['message']; unset($_SESSION['message']); }?>	
			</td>
			</tr>
			<?php } ?>
                <tr>
                    <td align="center"  >

                        <table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">                 

                            	

                            <tr align="center">
                                <td  class="blackbold" valign="top" align="center"> User From :<span class="red">*</span>
                                    <?php
                                    echo '<select name="userfrom" id="DuplicayColumn" class="inputbox">';
                                    foreach ($DbUniqueArray as $Key => $Heading) {
                                        $sel = (isset($_SESSION['DuplicayColumn']) && $_SESSION['DuplicayColumn'] == $Key) ? ('selected') : ('');
                                        echo '<option value="' . $Key . '" ' . $sel . '>' . $Heading . '</option>';
                                    }
                                    echo '</select>';
                                    ?>
                                </td>
                            </tr>	




                        </table></td>
                </tr>
                <tr><td align="center">
                        <input name="Submit" type="submit" class="button" value="Upload" style="margin-top: 7px;" />
                </td></tr>
                </table>
            </form></div>
            <?php } else{ ?>
    <div>
            <form name="form2" action method="post" enctype="multipart/form-data">
                <input type="hidden" value="<?php echo $UserData['table']; ?>" name="table">
                <input type="hidden" value="<?php echo $UserData['id']; ?>" name="id">
                <input type="hidden" value="<?php echo $UserData['column']; ?>" name="column">
                
                <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
                  <tr>
                    <td align="center">
                        <table id="example" class="table table-striped table-bordered" width="100%" cellspacing="0">                 
                            	<thead>
                                            <tr align="left">
                                                        <th><input type="checkbox" id="selecctall" value=""></th>
							<th>First Name</th> 
							<th>Last Name</th>							
							<th>Email</th>
                                            </tr>
                                </thead>
                                                
                                              
                                                <tbody> 
                                               <?php 
                                               foreach($UserData['data'] as $values){?>
                                                
                <tr align="left">
                    <td><input type="checkbox" class="checkbox1" name="userCheckbox[]"  value="<?=$values['id'];?>"></td>
                    <td><?= (!empty($values['FirstName'])) ? (htmlentities($values['FirstName'])) : (NOT_SPECIFIED) ?> </td>
                    <td><?= (!empty($values['LastName'])) ? (htmlentities($values['LastName'])) : (NOT_SPECIFIED) ?> </td>
                    <td><?= (!empty($values['Email'])) ? (htmlentities($values['Email'])) : (NOT_SPECIFIED) ?> </td>
               </tr>
                                                <?php } ?>
               </tbody> 
                        </table>
                        
                        </td>
                </tr>
                <tr><td align="center">
                        <input name="save" type="submit" class="button" value="ADD User" style="margin-top: 7px;" />
                    </td></tr>
                </table>
            </form></div>
            
            <?php } ?>
        


</div>	   

