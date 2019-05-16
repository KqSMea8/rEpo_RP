<div class="right-search">
            	<h3><span class="icon"></span>Search</h3>
               
				<form class="admin_r_search_form" action="<?=$SelfPage?>" method="get" enctype="multipart/form-data" name="form2" onSubmit="return LoaderSearch();">
 <? require_once("../includes/html/box/right_custom.php"); ?>
              
                  <fieldset style="display:none;">
                    	 <label>From Date: </label>
                       <? if($_GET['FromDate']>0) $FromDate = $_GET['FromDate'];  ?>				
<script type="text/javascript">
$(function() {
	$('#FromDate').datepicker(
		{
		showOn: "both", dateFormat: '<?=$Config["DateFormatJS"]?>', 
		yearRange: '<?=date("Y")-30?>:<?=date("Y")+30?>', 
		changeMonth: true,
		changeYear: true

		}
	);
});
</script>
<input id="FromDate" name="FromDate" readonly=""  size="10" value="<?=$FromDate?>"  type="text" > 
                    </fieldset>
				
				
				 <fieldset>
                    	 <label>Close Date:</label>
                        <? if($_GET['closingdate']>0) $closingdate = $_GET['closingdate']; 

 	
 ?>				
<script type="text/javascript">
$(function() {
	$('#closingdate').datepicker(
		{
		showOn: "both", dateFormat: '<?=$Config["DateFormatJS"]?>', 
		yearRange: '<?=date("Y")-30?>:<?=date("Y")+30?>', 
		changeMonth: true,
		changeYear: true

		}
	);
	$("#closingdate").on("click", function () { 
			 $(this).val("");
		}
	);
});
</script>
<input id="closingdate" name="closingdate" readonly=""  size="10" value="<?=$closingdate?>"  type="text" > 
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

<? if($search_Status=='Active'){ $key='';}else{ $key = $_GET['key'];}?>
                       <input type='text' name="key"  id="key"  value="<?=$key?>" />
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
                      <input name="module" type="hidden"  value="<?=$_GET['module']?>"  />
						<input name="search" type="submit" class="button_btn" value="Search"  />
                    </fieldset>
                </form>
               
            </div>
            
            
