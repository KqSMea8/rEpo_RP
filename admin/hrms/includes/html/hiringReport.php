<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(frm){	
	if( ValidateForSelect(frm.f, "From Date") 
		&& ValidateForSelect(frm.t, "To Date") 
	){
			var FromDate = document.getElementById("f").value;
			var ToDate = document.getElementById("t").value;

			if(ToDate!='' && FromDate!=''){
				FromDate = DefaultDateFormat(FromDate);
				ToDate = DefaultDateFormat(ToDate); 	
		
				if(ToDate < FromDate){
					alert("From Date should not be greater than To Date.");
					return false;	
				}
			}

			ShowHideLoader(1,'L');
			return true;	
	}else{
		return false;	
	}
	
}
</script>




<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_employee'])) {echo $_SESSION['mess_employee']; unset($_SESSION['mess_employee']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >


	<tr>
	  <td  valign="top">
	  
<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch(this);">
	 <table  border="0" cellpadding="3" cellspacing="0"  id="search_table" style="margin:0" >

		<tr>
		 <td>Department :</td>
		<td align="left" >
		<select name="d" class="textbox" id="d">
		  <option value="">--- All ---</option>
		  <? for($i=0;$i<sizeof($arrySubDepartment);$i++) {?>
		  <option value="<?=$arrySubDepartment[$i]['depID']?>" <?  if($arrySubDepartment[$i]['depID']==$_GET['d']){echo "selected";}?>>
		  <?=stripslashes($arrySubDepartment[$i]['Department'])?>
		  </option>
		  <? } ?>
		</select>		
		</td>
		 <td>&nbsp;</td> 
		
		 <td>From Date :</td> 

		 <td><? if($_GET['f']>0) $FromDate = $_GET['f'];  ?>				
<script type="text/javascript">
$(function() {
	$('#f').datepicker(
		{
		showOn: "both",dateFormat: '<?=$Config["DateFormatJS"]?>', 
		yearRange: '<?=date("Y")-20?>:<?=date("Y")?>', 
		maxDate: "+0D", 
		changeMonth: true,
		changeYear: true

		}
	);
});
</script>
<input id="f" name="f" readonly="" class="datebox" value="<?=$FromDate?>"  type="text" > </td> 


		 <td>



<td>&nbsp;</td> 
		
		 <td>To Date :</td> 

		 <td><? if($_GET['t']>0) $ToDate = $_GET['t'];  ?>				
<script type="text/javascript">
$(function() {
	$('#t').datepicker(
		{
		showOn: "both", dateFormat: '<?=$Config["DateFormatJS"]?>', 
		yearRange: '<?=date("Y")-20?>:<?=date("Y")?>', 
		maxDate: "+0D", 
		changeMonth: true,
		changeYear: true

		}
	);
});
</script>
<input id="t" name="t" readonly="" class="datebox" value="<?=$ToDate?>"  type="text" > </td> 


		 <td>



			 
		 <input name="s" type="submit" class="search_button" value="Go"  />
		 
		 </td> 
		  
        </tr>
</table>
 	</form>



	
	</td>
      </tr>
	
 	<tr>
	  <td align="right">
  <? if($num>0){?>
<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_hired.php?<?=$QueryString?>';" />
<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
	  <? } ?>
	  </td>
	</tr>
	 
	<tr>
	  <td  valign="top">
	

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">
<? if(!empty($_GET['f']) && !empty($_GET['t'])){ ?>
<table <?=$table_bg?>>
   
    <tr align="left"  >
       <td width="18%"  class="head1" >Name</td>
    <td width="12%"  class="head1" >Emp Code</td>
      <td  class="head1" >Email</td>
       <td width="15%" class="head1" >Department</td>
       <td width="15%" class="head1" >Designation</td>
    <td width="18%" class="head1" >Hired Date</td>
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
	<td height="30" >
		<a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$values['EmpID']?>" ><?=stripslashes($values['UserName'])?></a>	
	</td>
 	<td><?=$values["EmpCode"]?></td>
 	<td><?=stripslashes($values["Email"])?></td>
	<td><?=stripslashes($values["Department"])?></td>
	<td><?=stripslashes($values["JobTitle"])?></td>
	<td><? if($values["JoiningDate"]>0) echo date($Config['DateFormat'], strtotime($values["JoiningDate"])); ?></td>
     
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="7" class="no_record"><?=NO_RECORD?> </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="7"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryEmployee)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>
<? }  ?>
  </div> 
  
  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
   <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
</form>
</td>
	</tr>
</table>

