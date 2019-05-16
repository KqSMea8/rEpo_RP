<link href="<?=$Prefix?>css/select2.min.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?=$Prefix?>js/select2.min.js"></script>
<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(frm){	
	ShowHideLoader(1,'F');
	return true;	

}
</script>
<div class="had"><?=$MainModuleName?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

<tr>
	  <td  valign="top">
	  
<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch(this);">
	 <table  border="0" cellpadding="3" cellspacing="0"  id="search_table" style="margin:0" >

		<tr>
		
		<td >
		<select id="Tax" class="inputbox" name="Tax">
			   <option value="">---All Taxes---</option>
			     <?php foreach($arryTax as $tax){
 
?>
				 <option value="<?=$tax?>" <?php if($_GET['Tax'] == $tax){echo "selected";}?>><?php echo $tax; ?></option>
				<?php }?>
			</select>
		</td>

	  <td align="right"  >   <input name="search" type="submit" class="search_button" value="Go"  />	  
	
	  
	  </td> 
 </tr>


</table>
 	</form>

<script>
$("#Tax").select2();
</script> 

	
	</td>
      </tr>	
	<tr>
        <td align="right" valign="top">
		
	 <? if($num>0){?>
	      <input type="button" class="print_button"  name="exp" style="float:right" value="Print" onclick="Javascript:window.print();"/>

	     <input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_cust_bytax.php?<?=$QueryString?>&module=Invoice';" />

	    <? } ?>


		</td>
      </tr>
	 	
<tr>
	  <td  valign="top"> 
    <? include_once("includes/html/box/cust_bytax.php"); ?>
	  
	</td>
	</tr>

  


</table><input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
		<input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">

<script language="JavaScript1.2" type="text/javascript">

    $(document).ready(function() {
        $(".fancybig").fancybox({
            'width': 400
        });

    });

</script>

