<div class="right-search">
            	<h3><span class="icon"></span>Search</h3>
	
				<form class="admin_r_search_form" action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return LoaderSearch();">


<fieldset>
                    	 <label>From Date: </label>
                       <? if($_GET['FromDate']>0) $FromDate = $_GET['FromDate'];  ?>				
<script type="text/javascript">
$(function() {
	$('#FromDate').datepicker(
		{
		showOn: "both", dateFormat: '<?=$Config["DateFormatJS"]?>', 
		yearRange: '<?=date("Y")-10?>:<?=date("Y")+10?>', 
		changeMonth: true,
		changeYear: true

		}
	);
});
</script>
<input id="FromDate" name="FromDate" readonly=""  size="10" value="<?=$FromDate?>"  type="text" > 
                    </fieldset>
				
				
				 <fieldset>
                    	 <label>To Date:</label>
                        <? if($_GET['ToDate']>0) $ToDate = $_GET['ToDate'];  ?>				
<script type="text/javascript">
$(function() {
	$('#ToDate').datepicker(
		{
		showOn: "both", dateFormat: '<?=$Config["DateFormatJS"]?>', 
		yearRange: '<?=date("Y")-10?>:<?=date("Y")+10?>', 
		changeMonth: true,
		changeYear: true

		}
	);
});
</script>

<input id="ToDate" name="ToDate" readonly=""  size="10" value="<?=$ToDate?>"  type="text" > 
                    </fieldset>




                    <fieldset>
                        <label>Search By: </label>
                        <div class="sel-wrap">

<select name="sortby" id="sortby" class="textbox">
	<option value=""> All </option>
<?
foreach($RightArray as $values){
	$sel = ($_GET['sortby']==$values['value'])?('selected'):('');
	echo '<option value="'.$values['value'].'" '.$sel.'>'.$values['label'].'</option>';

}
?>
</select>



                         </div>
                    </fieldset>
                   
                    
                    <fieldset>
                    	 <label>Keyword:</label>
                        <input type='text' name="key"  id="key" value="<?=$_GET['key']?>" />
                    </fieldset>
                   
                    <fieldset>
                    	 <label>Order By:</label>
                         <div class="sel-wrap">
						 <select name="asc" id="asc"  >
<?
foreach($arryRightOrder as $valueright){
	$sel = ($_GET['asc']==$valueright)?('selected'):('');
	echo '<option value="'.$valueright.'" '.$sel.'>'.$valueright.'</option>';

}
?>
</select> 
                         </div>
                    </fieldset>
                    <fieldset>
						<input name="sc" type="submit" class="button_btn" value="Search"  />
                    </fieldset>
                </form>
            </div>
