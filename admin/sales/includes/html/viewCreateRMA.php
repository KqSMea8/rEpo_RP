
<script language="JavaScript1.2" type="text/javascript">

    $(document).ready(function() {
        $("#FlagType").click(function(e) {

            e.preventDefault();

            $.ajax({
                type: "GET",
                url: "ajax.php",
                data: "action=CustCommented&Comment=" + Comment + "&parentID=" + parentID + "&parent=" + parent + "&parent_type=" + parent_type + "&commented_by=" + commented_by + "&commented_id=" + commented_id,
                success: function(data) {
                    //$("#info").html(data);
                    $("#Comment").val('');
                    GetCommentLising();


                }

            });
            return false;

        });

    });


	function ValidateSearch(SearchBy) {
		document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';
	}
	function filterLead(id)
	{
		location.href = "viewLead.php?customview=" + id + "&module=lead&search=Search";
		LoaderSearch();
	}
function SetFlag(LeadID,flag) {

		var SendUrl = "&action=FlagInfo&LeadID=" + escape(LeadID) + "&FlagType=" + flag + "&r=" + Math.random();

		//$("#flaginfo_"+LeadID).show();
		$("#flaginfo_"+LeadID).fadeIn(400).html('<img src ="images/ajax_loader_red_32.gif">');
		$.ajax({
			type: "GET",
			url: "ajax.php",
			data: SendUrl,
			cache: true,
			success: function(result){
//alert(result);

			$("#flaginfo_"+LeadID).html(result);

//<img class="flag_red" title="Flag" alt="Flag" src="images/email_flag.png">

			}  
		});
		return false;

}

$(document).ready(function(){

		$(".to-block").hover(
		function() { 
			$(this).find("a").show(300);
		  },
		  function() {
			 // if($(this).attr('class')!='add-edit-email')
				$(this).find("a").hide();
		
		});
                
                
                $(".flag_white").hide();
                $(".flag_red").show();
                $('.evenbg').hover(function() { 
			$(this).find(".flag_white").show();
                        //$(this).find(".flag_e").css('display','block');
		  },
		  function() {
			 
				$(this).find(".flag_white").hide();
                                //$(this).find(".flag_e").css('display','none');
                });
                $('.oddbg').hover(function() { 
			$(this).find(".flag_white").show();
                        //$(this).find(".flag_e").css('display','block');
		  },
		  function() {
			 
				 $(this).find(".flag_white").hide();
                                 //$(this).find(".flag_e").css('display','none');
                });
                
                
                
             
                
                //End jquery show/hide for Delete, Mark as Read, Mark as Unread buttons
  
     });
</script>

<style>
<!--
.to-block a{
  display: none;
  position: absolute;
  background: #e9e9e9;
  padding: 5px 24px;
    margin-left: -1px;
    margin-top: -5px;
    color:#005dbd;
      border: 1px solid gray;
  border-radius: 5px;
  }
  
  .flag_e:hover{
      cursor:pointer; 
      
  }
  
  
  -->
</style>

<div class="had"><?= $MainModuleName ?></div>
<div class="message" align="center"><? if (!empty($_SESSION['mess_Leadform'])) {
    echo $_SESSION['mess_Leadform'];
    unset($_SESSION['mess_Leadform']);
} ?></div>
<form action="" method="post" name="form1">
    <TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
       



 <tr>  
            <td  valign="top" align="right">


                <a href="RmaForm.php" class="add" >Create RMA Form</a>
                     
<? if ($_GET['key'] != '') { ?>
                    <a class="grey_bt"  href="viewCreateRMA.php">View All</a>
        <? } ?>



            </td>
        </tr>



        <tr>
            <td  valign="top">



                <div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
                <div id="preview_div">

                    <table <?= $table_bg ?>>

                            <tr align="left"  >

                              
                                <td width="30%" class="head1" >Form Title</td>
                                <td width="11%" class="head1">Subtitle  </td>
                                <td  class="head1" > Description</td>
                                <td width="11%" align="center" class="head1" > Created Date</td>
                                <td width="10%"  align="center" class="head1 head1_action" >Action</td>
                             
                            </tr>

                        <?
                       
                        if (is_array($arryLeadForm) && $num > 0) {
                            $flag = true;
                            $Line = 0;

                            $LeadNo = 0;
                            $LeadNo = ($_GET['curP'] - 1) * $RecordsPerPage;

                            foreach ($arryLeadForm as $key => $values) {
                                $flag = !$flag;
                                $bgcolor = ($flag) ? ("#FAFAFA") : ("#FFFFFF");
                                $Line++;
                                $LeadNo++;
	?>
                                <tr align="left"  bgcolor="<?= $bgcolor ?>" <? if(!empty($values['RowColor'])){ echo 'style="background-color:'.$values['RowColor'].'"'; }?>>     
       
                                     
                                       
                                    

                                        <td><?= (!empty($values['FormTitle'])) ? (stripslashes($values['FormTitle'])) : (NOT_SPECIFIED) ?></td>

  <td><?= (!empty($values['Subtitle'])) ? (stripslashes($values['Subtitle'])) : (NOT_SPECIFIED) ?></td>
 <td><?= (!empty($values['Description'])) ? (stripslashes($values['Description'])) : (NOT_SPECIFIED) ?></td>
                                      

                                        <td align="center">
                                        <?= ($values['UpdatedDate'] > 0) ? (date($Config['DateFormat'], strtotime($values['UpdatedDate']))) : (NOT_SPECIFIED) ?>		
                                        </td>
                                   

                                <td  align="center" class="head1_inner">

<!-- code by bhoodev-->

<a href="vCreateForm.php?view=<?php echo $values['formID']; ?>&amp;curP=<?php echo $_GET['curP']; ?>" ><?= $view ?></a>
                                  

                                    <a href="RmaForm.php?del_id=<?php echo $values['formID']; ?>&amp;curP=<?php echo $_GET['curP']; ?>" onclick="return confirmDialog(this, '<?= $ModuleName ?>')"  ><?= $delete ?></a>   </td>
                               


                                </tr>
                                    <?php } // foreach end //?>

<?php } else { ?>
                            <tr align="center" >
                                <td  colspan="11" class="no_record">No record found. </td>
                            </tr>
<?php } ?>

                        <tr >  <td  colspan="11" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryLeadForm) > 0) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}
?></td>
                        </tr>
                    </table>

                </div> 
 

                <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
                <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">

                <input type="hidden" name="NumField" id="NumField" value="<?= sizeof($arryLeadForm) ?>">

            </td>
        </tr>
    </table>
</form>
