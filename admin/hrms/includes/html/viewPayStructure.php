 <script language="javascript">
  	$(document).ready(function() {
		$("#cat").change(function(){
			$("#preview_div").hide();
			$("#add_view").hide();
			$(".message").hide();
		});

		$("#catEmp").change(function(){
			$("#preview_div").hide();
			$("#add_view").hide();
			$(".message").hide();
			$("#cat").val("");
		});

	});
</script>
<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(){	
	if(document.getElementById("catEmp").value==""){
		alert("Please Select Employee Category.");
		document.getElementById("catEmp").focus();
		return false;
	}
	
	if(document.getElementById("cat").value==""){
		alert("Please Select Payroll Category.");
		document.getElementById("cat").focus();
		return false;
	}

	ShowHideLoader(1,'L');
}

function ShowList(){
	ShowHideLoader(1,'L');
	document.topForm.submit();
}
</script>



<div class="had"><?=$MainModuleName?></div>


<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

<tr>
<td>


 <table  border="0" cellpadding="0" cellspacing="0"  id="search_table" style="margin:0"> 
 <form name="topForm" action="viewPayStructure.php" method="get" onSubmit="return ValidateSearch();">	
 <tr>
 
   <td  align="right"   class="blackbold"> Employee Category  :</td>
   <td>
	   <select name="catEmp" class="textbox" id="catEmp" >
		<option value="">--- Select ---</option>
		  <? for($i=0;$i<sizeof($arryEmpCategory);$i++) {?>
		  <option value="<?=$arryEmpCategory[$i]['catID']?>" <?  if($arryEmpCategory[$i]['catID']==$_GET['catEmp']){echo "selected";}?>>
		  <?=$arryEmpCategory[$i]['catName']?>
		  </option>
		  <? } ?>
		 <option value="0" <?  if($_GET['catEmp']=="0"){echo "selected";}?>>Other</option>
		</select>
  </td>
   <td>&nbsp;</td> 
  <td  align="right"   class="blackbold"> Payroll Category  :</td>
<td>
 	<?  if(sizeof($arryPayCategory)>0){ ?>	
<!--<select name="cat" class="textbox" id="cat" onChange="Javascript:ShowList();" >-->
<select name="cat" class="textbox" id="cat" > 
        <option value="">--- Select ---</option>
        <? for($i=0;$i<sizeof($arryPayCategory);$i++) {?>
        <option value="<?=$arryPayCategory[$i]['catID']?>" <?  if($arryPayCategory[$i]['catID']==$_GET['cat']){echo "selected";}?>>
        <?=stripslashes($arryPayCategory[$i]['catName'])?>
        </option>
        <? } ?>
      </select>
      <? } ?> 
   </td> 


<td>
		 <input name="s" type="submit" class="search_button" value="Go"  />
		
		 </td> 
  </tr>
  </form>
</table>

<br>
<div class="message"><? if(!empty($_SESSION['mess_payhead'])) {echo $_SESSION['mess_payhead']; unset($_SESSION['mess_payhead']); }?></div>

</td>
</tr>


<? if($showList==1){ ?>
	<tr>
	  <td>
  <div id="add_view">
  <a href="editPayStructure.php?cat=<?=$_GET['cat']?>&catEmp=<?=$_GET['catEmp']?>" class="add">Add Head</a>
  <? if($_GET['key']!='') {?> <a href="viewPayStructure.php?cat=<?=$_GET['cat']?>&catEmp=<?=$_GET['catEmp']?>" class="grey_bt">View All</a><? }?>
  </div>
	  </td>
	  </tr>
	<? } ?>

	<tr>
	  <td>
	
<form action="" method="post" name="form1">

<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div" >
<? if($showList==1){ ?>

 
<table <?=$table_bg?>>

<tr align="left"  >
	<td  class="head1">Heading</td>
	<td width="25%"  class="head1">Sub Heading</td>
	<td width="25%" class="head1">Type</td>
	<td width="10%"  class="head1">Amount/Percentage</td>
	<td width="10%" align="center" class="head1">Status</td>
	<td width="8%"  align="center" class="head1 head1_action" >Action</td>
</tr>
 

  <?php 
if(is_array($arryHead) && $num>0){
 
  	$flag=true;
  	foreach($arryHead as $key=>$values){
	$flag=!$flag;
	
	
		if($values['HeadType']=="Fixed"){
			$AmountPercentage = $values['Amount'].' '.$Config['Currency'];
		}else if($values['HeadType']=="Percentage"){
			$AmountPercentage = $values['Percentage'].' %';
		}else{
			$AmountPercentage = '';
		}
	
  ?>
  <tr align="left">
    <td height="35" ><?=stripslashes($values['heading'])?></td>
    <td ><?=stripslashes($values['subheading'])?></td>
    <td ><?=$values['HeadType']?></td>

     <td ><?=$AmountPercentage?></td>
     <td align="center" >
      <? 
		 if($values['Status'] ==1){
			  $Status = 'Active'; 
		 }else{
			  $Status = 'InActive'; 
		 }

	 
		if($values['Default'] ==1){
			echo $Status;
		}else{
			echo '<a href="editPayStructure.php?active_id='.$values["headID"].'&cat='.$_GET["cat"].'&catEmp='.$_GET["catEmp"].'" class="'.$Status.'" onclick="Javascript:ShowHideLoader(\'1\',\'P\');">'.$Status.'</a>';
		}
		
	   
	 ?>    </td>
    <td align="center"   class="head1_inner">
	<a href="editPayStructure.php?edit=<?=$values['headID']?>&cat=<?=$_GET['cat']?>&catEmp=<?=$_GET['catEmp']?>"><?=$edit?></a>
	<? if($values['Default'] !=1){?>
	<a href="editPayStructure.php?del_id=<?=$values['headID']?>&cat=<?=$_GET['cat']?>&catEmp=<?=$_GET['catEmp']?>" onClick="return confirmDialog(this, '<?=$ModuleName?>')"><?=$delete?></a>	
	<? } ?>
	</td>
  </tr>
  <?php } // foreach end //?>
 
<tr > 
	<td  colspan="6" id="td_pager">
	Total Record(s) : &nbsp;<?php echo $num;?>  
  </td>
  </tr>
 
  <?php }else{?>
  	<tr align="center" >
  	  <td height="20" colspan="6" class="no_record"><?=NO_RECORD?></td>
  </tr>

  <?php } ?>
    
	<!--
  <tr  >  <td height="20" colspan="5" >
Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryHead)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?>

</td>
  </tr>-->
</table>
<? } ?>
</div>
<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>
</td>
	</tr>
</table>
