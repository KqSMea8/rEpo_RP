
<script>
function fun()
{
	var r=confirm("Are you sure you want to delete?");
	if(r==true)
	{
		return true;		
	}
	else
	{
		return false;
	}	
}

</script>
<script>
jQuery(document).ready(function(){
	$(".fancybox").fancybox({'width':395,'height':330,'autoSize' : false,'afterClose':function(){window.location.href="<?php echo $_SERVER['PHP_SELF'];?>";},});	
});

jQuery(document).ready(function(){
	$(".fancygraph").fancybox({'width':395,'height':330,'autoSize' : false});});

jQuery(document).ready(function(){
	$(".fancy").fancybox({'width':900,'height':600,'autoSize' : false});});

$(document).ready(function() {
    $('#SelectAll').click(function(event) {  //on click 
        if(this.checked) { // check select status
            $('.check').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"               
            });
        }else{
            $('.check').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                       
            });         
        }
    });
    
});	
   /* jQuery('#AddKey').click(function(event) {     
         jQuery('#content').toggle('show');
    });
});*/
</script>
<!--a class="back" href="javascript:void(0)" onClick="window.history.back();">Back       class="fancybox fancybox.iframe" </a-->
<a class="back" href="<?php echo _SiteUrl?>admin/crm/twitter_lists.php">Back</a>
<a class="fancybox fancybox.iframe add" href="twitter_alerts_entry.php">Add Alerts</a>
<a class="fancybox fancybox.iframe add" href="twitter_alerts_import.php">Import Excel</a>
 <p style=" font-weight: bold; font-size: 14px;">Alerts</p>

<!--input style=" padding:4px; background-color:rgb(176, 14, 14); color:#FFF; margin-top:10px;" type="button" id="AddKey" name="alertB" value="+Add Alerts"/>
<div  id='content' style=" border:1px; border-style:solid; width:32%; height:195px; margin-top:35px; margin-left: 10%; border-color: rgb(221, 236, 236);-->

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <table align="center"  width="80%">
    <!--caption style=" color:#F00">
	<?php //if(isset($_SESSION['res_msg']))echo $_SESSION['res_msg']; if(isset($note_msg))echo $note_msg;?>
    </caption-->
    <? if (!empty($_SESSION['mess_comp'])) {?>
    <tr>
    <td align="center" class="message" >
    <? if(!empty($_SESSION['mess_comp'])) {echo $_SESSION[mess_comp]; unset($_SESSION[mess_comp]); }?>
    </td>
    </tr>
    <? } ?>
    <tr ><td style=" float:right; vertical-align:bottom;"><input type="submit" name="DeleteButton" class="button" value="Delete" onClick="return fun();"></td></tr>	
    <tr><td>
         <table align="center" cellspacing="1" cellpadding="3" width="100%" align="center" id="list_table">
         <tr><th class="head1">Serial No.</th><th class="head1">Alert</th><th class="head1">Description</th><th class="head1">Action</th>
         <th width="1%"><input type="checkbox" name="SelectAll" id="SelectAll"/></th>
         </tr>
		<?php //print_r($res_alert);
			$i=1;
			if(!empty($res_alert))
			{
       		foreach($res_alert as $rowa)
			{?>
			   <tr bgcolor="#FFFFFF" align="left" class="evenbg"> 
			   <td align="center"><?php echo $i++; ?> </td>
               <td align="center">	<?php if(isset($rowa['alert_name']))echo $rowa['alert_name'];else echo '<span class="red">Not Specified</span>'; ?></td>
               <td align="center" style=""><?php if(isset($rowa['alert_disc'])&& $rowa['alert_disc']!='')echo $rowa['alert_disc'];else echo '<span class="red">Not Specified</span>';?></td>	
			   <td align="center">
               	 <a class="fancygraph fancybox.iframe" title="<?php if(isset($rowa['alert_name']))echo $rowa['alert_name'];else echo "<span class='red'>Not Specified</span>" ?>" 
                 	href="twitter_graph.php?aview_id=<?php echo $rowa['id'];?>"><?= $view ?></a>&nbsp;&nbsp;&nbsp;&nbsp;
				 <a class="fancybox fancybox.iframe" href="twitter_alerts_entry.php?aedi_id=<?php echo $rowa['id'];?>"><?=$edit?></a>&nbsp;&nbsp;&nbsp;&nbsp;
                 <a onClick="return fun();" href="<?php echo $_SERVER['PHP_SELF']; ?>?adel_id=<?php echo $rowa['id'];?>"><?=$delete?></a>&nbsp;&nbsp;&nbsp;&nbsp;
                 <a class="fancy fancybox.iframe" href="twitter_live_play.php?aid_id=<?php echo $rowa['id'];?>&a_name=<?php echo $rowa['alert_name'];?>">Get Tweets</a>
               </td>
               <td width="1%" ><input type="checkbox" name="checkB[]" class="check" value="<?php echo $rowa['id'];?>" /></td>
          		</tr>
         <?php } $_SESSION['res_msg']=NULL;
		 
			}else echo '<tr><th><span class="red">No alerts found</span></th></tr>';?> 
            </table>
            </td></tr></table></form>
