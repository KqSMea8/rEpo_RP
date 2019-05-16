<script language="JavaScript1.2" type="text/javascript">
function ResetSearch(){	
	$("#prv_msg_div").show();
	$("#frmSrch").hide();
	$("#preview_div").hide();
}

function ShowEmpListing(){
	ResetSearch();
	location.href = "AssetEmpList.php?d="+document.getElementById("Department").value;
}


function SetEmployee(EmpID,UserName,JobTitle){	
	ResetSearch();
	window.parent.document.getElementById("EmpID").value=EmpID;
	window.parent.document.getElementById("EmployeeName").value=UserName+' ['+JobTitle+']';

	parent.jQuery.fancybox.close();
	ShowHideLoader('1','P');

}

</script>
<div class="had"><?=$PageHeading?></div>

<? 
if(!empty($ErrorMSG)){
	echo '<div class="message" align="center"><br>'.$ErrorMSG.'</div>';
}else{

?>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 height="500">

	  
	 
	  <tr>
        <td align="right" valign="bottom" height="30">
 <? //if($_GET["d"]>0){?>
<form name="frmSrch" id="frmSrch" action="AssetEmpList.php" method="get" onSubmit="return ResetSearch();">

<select name="Department" class="textbox" id="Department" <? if($_GET["d"]>0){ echo 'disabled';}?> >
  <option value="">--- All Department ---</option>
  <? for($i=0;$i<sizeof($arryInDepartment);$i++) {?>
  <option value="<?=$arryInDepartment[$i]['depID']?>" <?=($_GET["Department"]==$arryInDepartment[$i]['depID'])?("selected"):("")?> >
  <?=$arryInDepartment[$i]['Department']?>
  </option>
  <? } ?>
</select>


	<input type="text" name="key" id="key" placeholder="<?=SEARCH_KEYWORD?>" class="textbox" size="20" maxlength="30" value="<?=$_GET['key']?>"><input type="hidden" name="d" id="d" value="<?=$_GET['d']?>" readonly><input type="hidden" name="id" value="<?=$_GET['id']?>" readonly><input type="hidden" name="dv" id="dv" value="<?=$_GET['dv']?>" readonly>&nbsp;<input type="submit" name="sbt" value="Go" class="search_button">
</form>
  <? //} ?>


		</td>
      </tr>
	 
	<tr>
	  <td  valign="top" >
	

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="../images/ajaxloader.gif"></div>
<div id="preview_div">
 <? //if($_GET["d"]>0){?>
<table <?=$table_bg?>>
    <tr align="left"  >
       <td width="22%" class="head1" >Employee Name</td>
		<td width="13%"  class="head1" >Emp Code</td>
       <td width="20%" class="head1" >Designation</td>
       <td width="20%" class="head1" >Department</td>
      <td  class="head1" >Email</td>
    </tr>
   
    <?php 
  if(is_array($arryEmployee) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryEmployee as $key=>$values){
	$flag=!$flag;
	$Line++;
	
  ?>
    <tr align="left" >
    <td>
	<a href="Javascript:void(0)" onclick="Javascript:SetEmployee('<?=$values["EmpID"]?>','<?=stripslashes($values["UserName"])?>','<?=stripslashes($values["JobTitle"])?>');" onMouseover="ddrivetip('<?=CLICK_TO_SELECT?>', '','')"; onMouseout="hideddrivetip()"><?=stripslashes($values["UserName"])?></a>
	</td>
    <td><?=$values["EmpCode"]?></td> 
    <td><?=stripslashes($values["JobTitle"])?></td> 
    <td><?=stripslashes($values["Department"])?></td> 
    <td><?=stripslashes($values["Email"])?></td>
      
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="5" class="no_record"><?=NO_EMPLOYEE?></td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="5"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryEmployee)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>
	<? //} ?>
  </div> 
  
</form>
</td>
	</tr>

	

</table>
<input type="hidden" name="SelID" id="SelID" value="<?=$_GET["id"]?>">
<? } ?>

