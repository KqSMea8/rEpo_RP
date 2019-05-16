<div class="right-search">
            	<h3><span class="icon"></span>Search</h3>
               
	 <form action="" method="get" class="admin_r_search_form" enctype="multipart/form-data" name="form2" onSubmit="return LoaderSearch();">
               <fieldset>  
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
                     <div class="sel-wrap">



<select name="UsedSerialCheck" id="UsedSerialCheck" class="textbox" ><option <?php if($_GET['UsedSerialCheck']==''){ echo "selected";} ?> value="">Select Status</option><option <?php if($_GET['UsedSerialCheck']=='UnUsed' && $_GET['UsedSerialCheck']!=''){ echo "selected";} ?> value="UnUsed">Available</option><option <?php if($_GET['UsedSerialCheck']=='Used'){ echo "selected";} ?> value="Used">Not Available</option></select>
                  
                         </div>
                      </fieldset>

                     




  <fieldset>  
                     <div class="sel-wrap">



<select name="Condition" id="Condition" class="textbox" ><option value="">Select Condition</option><?=$ConditionSelectedDrop?></select>
                  
                         </div>
                      </fieldset>

                       <fieldset>
                            <label>Keyword:</label>
                          <input type='text' name="key"  id="key" class="inputbox" value="<?= $_GET['key'] ?>"> 
             		</fieldset>
 <fieldset>
                            
                         <a  onclick="multiSearch(1);" href="#">
<h3><span class="icon"></span>Multiple Search</h3>
</a>
             		</fieldset>

	<fieldset>
					<label>From Date: </label>
					<? if($_GET['FromDate']>0) $FromDate = $_GET['FromDate'];  ?>				
					<script type="text/javascript">
					$(function() {
						$('#FromDate').datepicker(
							{
							showOn: "both", dateFormat: 'yy-mm-dd', 
							yearRange: '<?=date("Y")-30?>:<?=date("Y")+30?>', 
							changeMonth: true,
							changeYear: true

							}
						);
						$("#FromDate").on("click", function () { 
								 $(this).val("");
							}
						);
					});
					</script>
					<input id="FromDate" name="FromDate" readonly="" value="<?=$FromDate?>"  type="text" maxlength="10" > 
               </fieldset>

				<fieldset>
					<label>To Date: </label>
					<? if($_GET['ToDate']>0) $ToDate = $_GET['ToDate'];  ?>				
					<script type="text/javascript">
					$(function() {
						$('#ToDate').datepicker(
							{
							showOn: "both", dateFormat: 'yy-mm-dd', 
							yearRange: '<?=date("Y")-30?>:<?=date("Y")+30?>', 
							changeMonth: true,
							changeYear: true

							}
						);
						$("#ToDate").on("click", function () { 
								 $(this).val("");
							}
						);

					});
					</script>
					<input id="ToDate" name="ToDate" readonly="" value="<?=$ToDate?>"  type="text" maxlength="10" > 
               </fieldset>
                     <fieldset>
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
                        
                         <a   href="viewSerial.php?Duplicate=1">
<h3><span class="icon"></span>Duplicate Serial</h3>
</a>
                       
                           
                          <fieldset>
                           <input name="search" type="submit" class="button_btn" value="Search"  />
                            </fieldset>
                 

            </form>
            </div>
