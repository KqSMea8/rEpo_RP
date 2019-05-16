<script language="JavaScript1.2" type="text/javascript">
    function ValidateSearch() {
        ShowHideLoader('1');
        document.getElementById("prv_msg_div").style.display = 'block';
        document.getElementById("preview_div").style.display = 'none';
    }

 $(function() {
        $("#DATABASE").click(function(e) {
        	
        	var number_of_checked_checkbox = $(".database:checked").length;
        	
        	var DeleteBefore= $("#DeleteBefore").val();
             if (number_of_checked_checkbox == 0) {
                alert("Please select atleast one Company.");
                return false;
            } else if(DeleteBefore==''){
           	 alert("Please select Date.");
             return false;
             }else {
		   ShowHideLoader('1','P');
                return true;
            }

        });
    })


function SelectCheck(MainID,ToSelect)
{	
	var flag,i;
	var Num = document.getElementById("CountCheck").value;
	if(document.getElementById(MainID).checked){
		flag = true;
	}else{
		flag = false;
	}
	
	for(i=1; i<=Num; i++){
		document.getElementById(ToSelect+i).checked=flag;
	}
	//ChangePostToGlDate();
}

</script>

<div class="had">Select Company</div>
<div class="message" align="center"><?php if(!empty($_SESSION['mess_Database'])) {echo $_SESSION['mess_Database']; unset($_SESSION['mess_Database']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
	<td align="right" valign="bottom">
    
</div>

	<form name="frmSrch" id="frmSrch" action="cmpListingdatabase.php" method="get" onSubmit="return ResetSearch();">
	<input type="text" name="key" id="key" placeholder="<?=SEARCH_KEYWORD?>" class="textbox" size="20" maxlength="30" value="<?=$_GET['key']?>">&nbsp;<input type="submit" name="sbt" value="Go" class="search_button">
	<input type="hidden" name="link" id="link" value="<?=$_GET['link']?>">
	
	</form>



	</td>
	</tr>
	
		 


	<tr>
	  <td  valign="top">
	  
	
<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="images/ajaxloader.gif"></div>
<div id="preview_div">
<? if (!empty($_GET['search'])) { ?>
                <a href="<?= $RedirectURL ?>" class="grey_bt">View All</a>
<? } ?>

<table   border="0" align="left" cellpadding="0" cellspacing="0">
<tr>
        <td  align="left"> Delete Database Before :<span class="red">*</span>  </td>
        <td   align="left" >
<script>
$(function() {
$( "#DeleteBefore" ).datepicker({ 
		showOn: "both",
	yearRange: '<?=date("Y")-10?>:<?=date("Y")?>', 
        maxDate: "-1M", 
	dateFormat: 'yy-mm-dd',
	changeMonth: true,
	changeYear: true
	});

	$("#expNone").on("click", function () { 
		$("#DeleteBefore").val("");
	}
	);	

});
</script>
<input id="DeleteBefore" name="DeleteBefore" readonly="" class="datebox" value="<?=$DeleteBefore?>"  type="text" > 
</td>
</tr> 
	 <tr>
          <td align="right"   class="blackbold" valign="top">Keep Last Records for Company  :</td>
          <td  align="left" >
           
<select name="KeepNumRecord" id="KeepNumRecord" class="textbox" style="width:100px;" >
	<?
	for($i=0;$i<=100;$i=$i+10){
		$sel = ($i==10)?('selected'):('');	
		echo '<option value="'.$i.'" '.$sel.'>'.$i.'</option>';
	} 
	?>
</select> 


		 </td>
        </tr>	

        </table>
<tr>
	  <td  valign="top" align="left">
 <input type="submit" class="button" name="DATABASE" id="DATABASE" value="Delete Database" style="font-weight: normal; height: 22px;">


	</td>
      </tr>
<table <?=$table_bg?>>
   
    <tr align="left"  >
    <td width="10%" align="center" class="head1">
<input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheck('SelectAll', 'database');" /></td>
      <td width="25%"  class="head1" >Company Name</td>
      <td width="12%"  class="head1" >Company ID</td>
       <td width="15%" class="head1" >Display Name</td>
     <td width="20%" class="head1" >Email</td>
 
    </tr>
   
    <?php 

$deleteCmp = '<img src="'.$Config['Url'].'admin/images/delete.png" border="0"  onMouseover="ddrivetip(\'<center>Confirm Delete</center>\', 90,\'\')"; onMouseout="hideddrivetip()" >';
$Line=$CountCheck=0;
  if(is_array($arryCompany) && $num>0){
  	$flag=true;
	
  	foreach($arryCompany as $key=>$values){
	$flag=!$flag;
	$Line++;
	
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
    
	<td align="center">
    
	<?php $CountCheck++; ?>
    <input type="checkbox" name="database[]" id="database<?=$CountCheck?>"  class="database" value="<?php echo $values['DisplayName']; ?>">

	</td>
     
	<td><?=stripslashes($values["CompanyName"])?></td>
	<td><?=$values["CmpID"]?></td>
	<td><?=$values["DisplayName"]?></td>   
	<td><?=$values["Email"]?></td>

    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="9" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="9" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryCompany)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

  </div> 
  
    <input type="hidden" name="CountCheck" id="CountCheck" value="<?php echo $CountCheck; ?>">
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
   <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
</form>
</td>
	</tr>
</table>
<script language="JavaScript1.2" type="text/javascript">

    $(document).ready(function() {
        $(".po").fancybox({
            'width': 900
        });

    });

</script>
