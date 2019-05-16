<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(SearchBy){	
		document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';

	}
</script>
<div class="had">Manage Email</div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_email'])) {echo $_SESSION['mess_email']; unset($_SESSION['mess_email']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right" >
		
		<? if($_GET['key']!='') {?>
		  <input type="button" class="view_button"  name="view" value="View All" onclick="Javascript:window.location='EmailList.php';" />
		<? }?>
</td>
      </tr>
	<tr>
	  <td  valign="top">
	  
	
<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">

<table <?=$table_bg?>>
   
    <tr align="left"  >
      
       <td width="15%"  class="head1">Email</td>
       <td width="15%"  class="head1">User TYpe</td>
       <td width="15%"  class="head1">Company Name</td>
       <td width="15%"  class="head1">Company ID</td> 
       <td width="15%"  class="head1"> Display Name</td>    
      <!--td width="5%"  align="center" class="head1 head1_action" >Action</td-->
     
    </tr>
   
    <?php 

//echo "<pre>";print_r($emaillist);

  if(is_array($emaillisting) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($emaillisting as $key=>$values){
	$flag=!$flag;
	$rowclass=($flag)?("evenbg"):("oddbg");
	$Line++;
	
?>
    <tr align="left"  class="<?=$rowclass?>" bgcolor="<?=$bgcolor?>">
    <td><?=$values['Email'];?></td>
    <?php if($values['RefID']=='0') {?>
    <td><?php echo ucfirst("admin");?></td>
    <?php }elseif($values['RefID']=='customer') {?>
    <td><?php echo ucfirst("customer");?></td>
    <?php }elseif($values['RefID']=='vendor') {?>
    <td><?php echo ucfirst("vendor");?></td>
    <?php }else{?>	
    <td><? echo ucfirst("user");?></td>
    <?php }?>
	<td><?=$values['CompanyName'];?></td>
	<td><?=$values['CmpID'];?></td>
	<td><?=$values['DisplayName'];?></td>
	<?php if($values['RefID']=='0'){?>

	<!--td><?php echo "";?></td-->
	<?php }else{?>
	<!--td align="center"><a href="EmailList.php?email=<?php echo $values['Email'];?>&amp;type=<?php echo $values['RefID'];?>&amp;curP=<?php echo $_GET['curP'];?>"  onclick="return confDel('Email')"  ><?=$delete?></a>   </td-->
    <?php }?>
    </tr>
    <?php } // foreach end //?>
    <?php }else{?>
    <tr align="center" >
      <td  colspan="9" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
	<tr >  <td  colspan="9" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($emaillisting)>0){?>
	&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
	}?></td>
	</tr>
  </table>
 </div> 
 
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
   <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
</form>
</td>
	</tr>
</table>
