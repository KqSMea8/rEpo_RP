<script language="JavaScript1.2" type="text/javascript">
function ResetSearch(){	
	$("#prv_msg_div").show();
	$("#frmSrch").hide();
	$("#preview_div").hide();
}

function ShowEmpListing(){
	ResetSearch();
	location.href = "addTerritoryManager.php?d="+document.getElementById("Department").value+"&id="+$("#SelID").val();
}


function SetEmployee(EmpID,UserName,JobTitle){	
	ResetSearch();
	var SelID = $("#SelID").val();
        var TRID = $("#TRID").val();
      
        var SendUrl = "&action=assignTerritoryManager&TRID="+TRID+"&SalesPersonID="+EmpID+"&SalesPerson="+UserName+"&r="+Math.random(); 
         
	$.ajax({
		type: "GET",
		url: "ajax.php",
		data: SendUrl,
		success: function (responseText) {
			 
			if(responseText == 1){
                            
                            window.parent.location.reload();
                            
                            parent.jQuery.fancybox.close();
                            
                            ShowHideLoader('1','P');
                            
                        }
		}
	});

	//window.parent.document.getElementById("SalesPersonID").value=EmpID;
	//window.parent.document.getElementById("SalesPerson").value=UserName;
        
	

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
<form name="frmSrch" id="frmSrch" action="addTerritoryManager.php" method="get" onSubmit="return ResetSearch();">

<select name="Department" class="textbox" id="Department" <? if($_GET["d"]>0){ echo 'disabled';}?> >
  <option value="">--- All Department ---</option>
  <? for($i=0;$i<sizeof($arryInDepartment);$i++) {?>
  <option value="<?=$arryInDepartment[$i]['depID']?>" <?=($_GET["Department"]==$arryInDepartment[$i]['depID'])?("selected"):("")?> >
  <?=$arryInDepartment[$i]['Department']?>
  </option>
  <? } ?>
</select>

<input name="ptname" id="ptname" value="<?php echo $_GET['ptname']; ?>" type="hidden">
<input name="tname" id="tname" value="<?php echo $_GET['tname']; ?>" type="hidden">
<input type="hidden" name="TRID"  value="<?=$_GET["TRID"]?>">
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
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;
	
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
    <td>
	<a href="Javascript:void(0)" onclick="Javascript:SetEmployee('<?=$values["EmpID"]?>','<?=stripslashes($values["UserName"])?>','<?=stripslashes($values["JobTitle"])?>');"><?=stripslashes($values["UserName"])?></a>
	</td>
    <td><?=$values["EmpCode"]?></td> 
    <td><?=stripslashes($values["JobTitle"])?></td> 
    <td><?=stripslashes($values["Department"])?></td> 
    <td><?=stripslashes($values["Email"])?></td>
      
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="5" class="no_record"><?=NO_RECORD?></td>
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
<input type="hidden" name="TRID" id="TRID" value="<?=$_GET["TRID"]?>">
<? } ?>

