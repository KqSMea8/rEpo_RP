<script language="JavaScript1.2" type="text/javascript">

    function ValidateSearch(SearchBy) {
        document.getElementById("prv_msg_div").style.display = 'block';
        document.getElementById("preview_div").style.display = 'none';

    }
    function filterLead(id)
    {
        location.href = "viewTwitterContact.php?customview=" + id + "&search=Search";
        LoaderSearch();
    }
</script>
<link href='fullcalendar/fullcalendar.css' rel='stylesheet' />
<link href='fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
<style>		
	#loading {
		position: absolute;
		top: 5px;
		
		right: 5px;
		}

	#calendar {
		width: 100%;
		margin: 0 auto;
		}
		.fc-event-title{
		 color:#FFFFFF;
		}
		
		.fc-event-inner .fc-event-time{ color:#FFFFFF;}

</style>
<script type="text/javascript" src="multiSelect/jquery.tokeninput.js"></script>
    <link rel="stylesheet" href="multiSelect/token-input.css" type="text/css" />
    <link rel="stylesheet" href="multiSelect/token-input-facebook.css" type="text/css" />
</head>
<div class="had"><?= $MainModuleName ?> Post List</div>
<div class="message" align="center"><? if (!empty($_SESSION['mess_lead'])) {
    echo $_SESSION['mess_lead'];
    unset($_SESSION['mess_lead']);
} ?></div>
<form action="" method="post" name="form1">
    <TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
    <tr>
 
        <td align="right">	
          <a class="back" href="javascript:void(0)" onclick="window.history.back();">Back</a>
         
          <a class="add" href="viewFacebookContact.php" style="display: none;">Contact List</a>		    
	       <a href="postFacbook.php" class="add">Create Post</a>	
	    
	      
	 	 </td>
	</tr>
        <tr>  
            <td  valign="top" align="right">

                <!-- <input type="button" class="export_button"  name="imp" value="Import Lead" onclick="Javascript:window.location = 'importLead.php';" />-->
                <? if ($num > 0) { ?>

                    <!-- <input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location = 'export_lead.php?<?= $QueryString ?>';" />
                    <input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>-->
                <? } ?>
             
           

<? if ($_GET['key'] != '') { ?>
                    <a class="grey_bt"  href="viewLead.php?module=<?= $_GET['module'] ?>">View All</a>
        <? } ?>
            </td>
        </tr>

<? if ($num > 0) { ?>
          <!--   <tr>
                <td align="right" height="40" valign="bottom">
                    <input type="submit" name="DeleteButton" class="button" value="Delete" onclick="javascript: return ValidateMultiple('lead', 'delete', 'NumField', 'leadID');">
                </td>
            </tr>-->
<? } ?>


        <tr>
            <td  valign="top">



                <div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
                <div id="preview_div">

                    <table <?= $table_bg ?>>
		
                            <tr align="left"  >
                                <!--td width="8%"  class="head1" >Lead No</td-->                                
                                <td width="11%" class="head1">Post </td>                              
                                <td width="9%" class="head1">Media  </td> 
                                 <td width="9%" class="head1">Name  </td>  
                                  <td width="9%" class="head1">Caption  </td>  
                                   <td width="9%" class="head1">description  </td>                                                           
                                <td width="11%" align="center" class="head1" >Created Date</td>
                                   <!-- <td width="11%" align="center" class="head1" >Likes</td>-->
                                <td width="10%"  align="center" class="head1 head1_action" >Action</td>
                               <!--  <td width="1%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll', 'leadID', '<?= sizeof($arrySocial) ?>');" /></td>-->
                            </tr>
<? 
                        if (is_array($arrySocial) && $num > 0) {
                            $flag = true;
                            $Line = 0;

                            $LeadNo = 0;
                            $LeadNo = ($_GET['curP'] - 1) * $RecordsPerPage;

                            foreach ($arrySocial as $key => $values) {
                                $flag = !$flag;
                                $bgcolor = ($flag) ? ("#FAFAFA") : ("#FFFFFF");
                                $Line++;
                                $LeadNo++;

                                //if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
                                ?>
                                <tr align="left"  bgcolor="<?= $bgcolor ?>">  
                                   <td><?= (!empty($values['post'])) ? (stripslashes($values['post'])) : (NOT_SPECIFIED) ?></td>
                            	   <td><?php
                            	   $mediahtml='';  
                            	   if(!empty($values['media'])){
                            	   $medias=explode('~~@!~',stripslashes($values['media']));
                            	   if(!empty($medias)){
                            		$i=0;
                            	   foreach ($medias as $medialink){                            	
	                            	   if($i==1)
	                            	   break;
                            	 	  $mediahtml.='<img src="'.$medialink.'" alt="'.stripslashes($values['post']).'" style="width: 100px;"> ';
                            	 	  $i++;
                            	 	  }
                            	 	  if(count($medias)>2)
                            	 	  $mediahtml.='  more ...';
                            	 	  echo $mediahtml;
                            	   }
                            	   }else{
                            	   echo (NOT_SPECIFIED);
                            	   
                            	   }
                            	   
                            	   (!empty($values['media'])) ? (stripslashes($values['media'])) : (NOT_SPECIFIED) ?></td>
								 <td width="9%" class=""><?= (!empty($values['name'])) ? (stripslashes($values['name'])) : (NOT_SPECIFIED) ?>  </td>  
                                  <td width="9%" class=""><?= (!empty($values['caption'])) ? (stripslashes($values['caption'])) : (NOT_SPECIFIED) ?>   </td>  
                                   <td width="9%" class=""><?= (!empty($values['description'])) ? (stripslashes($values['description'])) : (NOT_SPECIFIED) ?>   </td>     
									<td align="center">
                                            <?= (!empty($values['date'])) ? (date('m-d-Y h:i:s',strtotime(stripslashes($values['date'])))) : (NOT_SPECIFIED) ?>		
                                    </td>
                                    <!-- <td>0</td>-->
                                    <?php $post_id=explode('_',$values['post_id']);?>
							 <td  align="center" class="head1_inner"><a href="https://www.facebook.com/<?php echo $post_id[0]; ?>/posts/<?php echo $post_id[1];?>" target="_blank" ><?= $view ?></a>
                                    

                                    <a href="viewFacebookPost.php?del_id=<?php echo $values['id']; ?>&amp;curP=<?php echo $_GET['curP']; ?>" onclick="return confirmDialog(this, '<?= $ModuleName ?>')"  ><?= $delete ?></a>   </td>
                                <!-- <td><input type="checkbox" name="socialID[]" id="socialID<?= $Line ?>" value="<?= $values['id'] ?>" /></td>-->
                                </tr>
                                    <?php } // foreach end //?>

<?php } else { ?>
                            <tr align="center" >
                                <td  colspan="11" class="no_record">No record found. </td>
                            </tr>
<?php } ?>

                        <tr >  <td  colspan="11" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arrySocial) > 0) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}
?></td>
                        </tr>
                    </table>

                </div> 
		<? if (sizeof($arrySocial)) { ?>
                    <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
                        <tr align="center" > 
                            <td height="30" align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'delete', '<?= $Line ?>', 'leadID', 'editLead.php?curP=<?= $_GET[curP] ?>&opt=<?= $_GET[opt] ?>');">
                                <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'active', '<?= $Line ?>', 'leadID', 'editLead.php?curP=<?= $_GET[curP] ?>&opt=<?= $_GET[opt] ?>');" />
                                <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'inactive', '<?= $Line ?>', 'leadID', 'editLead.php?curP=<?= $_GET[curP] ?>&opt=<?= $_GET[opt] ?>');" /></td>
                        </tr>
                    </table>
			<? } ?>  

                <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
                <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">

                <input type="hidden" name="NumField" id="NumField" value="<?= sizeof($arrySocial) ?>">

            </td>
        </tr>
    </table>
</form>