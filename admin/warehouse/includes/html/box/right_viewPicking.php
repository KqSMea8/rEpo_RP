<?
$FromDateShip = $ToDateShip = '';
(empty($_GET['FromDateShip']))?($_GET['FromDateShip']=""):(""); 
(empty($_GET['ToDateShip']))?($_GET['ToDateShip']=""):(""); 
?>
<div class="right-search">
            	<h3><span class="icon"></span>Search</h3>
               
				<form class="admin_r_search_form" action="<?=$SelfPage?>" method="get" enctype="multipart/form-data" name="form2" onSubmit="return LoaderSearch();">

				<fieldset>
					<label>From Date: </label>
					<? if($_GET['FromDateShip']>0) $FromDateShip = $_GET['FromDateShip'];  ?>				
					<script type="text/javascript">
					$(function() {
						$('#FromDateShip').datepicker(
							{
							showOn: "both", dateFormat: 'yy-mm-dd', 
							yearRange: '<?=date("Y")-30?>:<?=date("Y")+30?>', 
							changeMonth: true,
							changeYear: true

							}
						);
						$("#FromDateShip").on("click", function () { 
								 $(this).val("");
							}
						);
					});
					</script>
					<input id="FromDateShip" name="FromDateShip" readonly="" value="<?=$FromDateShip?>"  type="text" maxlength="10" > 
               </fieldset>

				<fieldset>
					<label>To Date: </label>
					<? if($_GET['ToDateShip']>0) $ToDateShip = $_GET['ToDateShip'];  ?>				
					<script type="text/javascript">
					$(function() {
						$('#ToDateShip').datepicker(
							{
							showOn: "both", dateFormat: 'yy-mm-dd', 
							yearRange: '<?=date("Y")-30?>:<?=date("Y")+30?>', 
							changeMonth: true,
							changeYear: true

							}
						);
						$("#ToDateShip").on("click", function () { 
								 $(this).val("");
							}
						);

					});
					</script>
					<input id="ToDateShip" name="ToDateShip" readonly="" value="<?=$ToDateShip?>"  type="text" maxlength="10" > 
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
                        <input type='text' name="key"  id="key" value="<?=$_GET['key']?>"  />
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
						
						<input name="search" type="submit" class="button_btn" value="Search"  />




                    </fieldset>
                </form>
            </div>
