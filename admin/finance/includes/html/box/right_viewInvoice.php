<?php (empty($_GET['FromDateInv']))?($_GET['FromDateInv']=""):(""); 
(empty($_GET['ToDateInv']))?($_GET['ToDateInv']=""):(""); 
$FromDateInv=$ToDateInv='';
?>
<div class="right-search">
            	<h3><span class="icon"></span>Search</h3>
               
				<form class="admin_r_search_form" action="<?=$SelfPage?>" method="get" enctype="multipart/form-data" name="form2" onSubmit="return LoaderSearch();">
                                 <? require_once("../includes/html/box/right_custom.php"); ?>
				<fieldset>
					<label>From Date: </label>
					<? if($_GET['FromDateInv']>0) $FromDateInv = $_GET['FromDateInv'];  ?>				
					<script type="text/javascript">
					$(function() {
						$('#FromDateInv').datepicker(
							{
							showOn: "both", dateFormat: 'yy-mm-dd', 
							yearRange: '<?=date("Y")-30?>:<?=date("Y")+30?>', 
							changeMonth: true,
							changeYear: true

							}
						);
						$("#FromDateInv").on("click", function () { 
								 $(this).val("");
							}
						);
					});
					</script>
					<input id="FromDateInv" name="FromDateInv" readonly="" value="<?=$FromDateInv?>"  type="text" maxlength="10" > 
               </fieldset>

				<fieldset>
					<label>To Date: </label>
					<? if($_GET['ToDateInv']>0) $ToDateInv = $_GET['ToDateInv'];  ?>				
					<script type="text/javascript">
					$(function() {
						$('#ToDateInv').datepicker(
							{
							showOn: "both", dateFormat: 'yy-mm-dd', 
							yearRange: '<?=date("Y")-30?>:<?=date("Y")+30?>', 
							changeMonth: true,
							changeYear: true

							}
						);
						$("#ToDateInv").on("click", function () { 
								 $(this).val("");
							}
						);

					});
					</script>
					<input id="ToDateInv" name="ToDateInv" readonly="" value="<?=$ToDateInv?>"  type="text" maxlength="10" > 
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
