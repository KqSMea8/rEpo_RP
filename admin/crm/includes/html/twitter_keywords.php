<head><title>Tweets Keywords</title></head>
<script>
jQuery(document).ready(function(){
	$(".fancybox").fancybox({'width':395,'height':330,'autoSize':false,'afterClose':function(){window.location.href="<?php echo $_SERVER['PHP_SELF'];?>";},});	
});

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

<style>
#add{background: url('../images/plus.gif') no-repeat scroll 5px 5px #535353;
 background-color:rgb(176, 14, 14);
 border: medium none;color: #FFFFFF;
  border-radius: 2px 2px 2px 2px;
  cursor: pointer;
  float: right;
  font-size: 12px;  margin: 0 0 0 5px;
  padding: 3px 5px 4px 20px;
  line-height: normal;}
</style>
<a class="back" href="<?php echo _SiteUrl?>admin/crm/twitter_lists.php">Back</a>
<a class="fancybox fancybox.iframe" id="add" href="twitter_keywords_entry.php">  Add Keywords</a>
<a class="fancybox fancybox.iframe" id="add" href="twitter_keywords_import.php">Import Excel</a>
<p style="font-weight: bold; font-size: 14px;">Negative Keywords</p>
<?php 
/**/
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<table align="center"  width="80%">

<? if (!empty($_SESSION['mess_comp'])) {?>
    <tr>
    <td align="center" class="message" >
    <? if(!empty($_SESSION['mess_comp'])) {echo $_SESSION[mess_comp]; unset($_SESSION[mess_comp]); }?>
    </td>
    </tr>
    <? } ?>
<tr ><td style=" float:right; vertical-align:bottom;"><input type="submit" name="DeleteButton" class="button" value="Delete" onClick="return fun();"></td></tr><tr><td>
<table align="center" cellspacing="1" cellpadding="3" width="100%" align="center" id="list_table">
    <tr><th class="head1" width="23px">Serial No.</th><th class="head1" style=" width:120px;">Negative Keywords</th><th class="head1" style="width:25px;">Action</th>
    <th width="1%"><input type="checkbox" name="SelectAll" id="SelectAll"/></th>
    </tr>
        <?php $i=1;
		if(!empty($res_badkey))
		{
		foreach($res_badkey as $rowb){?>
        	<tr bgcolor="#FFFFFF" align="left" class="evenbg">
                <td align="center"><?php echo $i++;?></td>
                <td align="center" style=" width:120px;"><?php  echo $rowb['bad_key'];?></td>
                <td align="center">
                <a class="fancybox fancybox.iframe" href="twitter_keywords_entry.php?bedi_id=<?php echo $rowb['id'];?>"><?=$edit?></a>&nbsp;&nbsp;&nbsp;&nbsp;
                <a onClick="return fun();" href="<?php echo $_SERVER['PHP_SELF']; ?>?bdel_id=<?php echo $rowb['id'];?>"> <?=$delete?></a></td>
                <td width="1%" ><input type="checkbox" name="checkB[]" class="check" value="<?php echo $rowb['id'];?>" /></td>
                </tr>
         <?php } }else echo '<tr><th><span class="red">No alerts found</span></th></tr>';?> 
</table></td></tr></table>  </form>