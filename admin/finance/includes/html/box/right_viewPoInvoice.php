<? 
$FPostedDate=$TPostedDate=$FOrderDate=$TOrderDate='';


if(empty($_GET['po'])){?>
<div class="right-search">
            	<h3><span class="icon"></span>Search</h3>
               
				<form class="admin_r_search_form" action="<?=$SelfPage?>" method="get" enctype="multipart/form-data" name="form2" onSubmit="return LoaderSearch();">
                               <? require_once("../includes/html/box/right_custom.php"); ?>
				<fieldset>
				<label>Invoice Date</label>
				<? if(!empty($_GET['FPostedDate'])) $FPostedDate = $_GET['FPostedDate'];  ?>				
				<script type="text/javascript">
				$(function() {
					$('#FPostedDate').datepicker(
						{
						showOn: "both", dateFormat: 'yy-mm-dd', 
						yearRange: '<?=date("Y")-30?>:<?=date("Y")+30?>', 
						changeMonth: true,
						changeYear: true

						}
					);
					$("#FPostedDate").on("click", function () { 
							 $(this).val("");
						}
					);
				});
				</script>
				 <input id="FPostedDate" class="datebox" placeholder="From" name="FPostedDate" readonly="" value="<?=$FPostedDate?>"  type="text" maxlength="10" style="width:125px;"> 
                
				</fieldset>

				<fieldset>
				<? if(!empty($_GET['TPostedDate'])) $TPostedDate = $_GET['TPostedDate'];  ?>				
				<script type="text/javascript">
				$(function() {
					$('#TPostedDate').datepicker(
						{
						showOn: "both", dateFormat: 'yy-mm-dd', 
						yearRange: '<?=date("Y")-30?>:<?=date("Y")+30?>', 
						changeMonth: true,
						changeYear: true

						}
					);
					$("#TPostedDate").on("click", function () { 
							 $(this).val("");
						}
					);
				});
				</script>
				 <input id="TPostedDate" name="TPostedDate" placeholder="To" class="datebox"  readonly="" value="<?=$TPostedDate?>"  type="text" maxlength="10" style="width:125px;"> 

				</fieldset>




				<!--<fieldset>
				 <label>Order Date </label>
				<? if(!empty($_GET['FOrderDate'])) $FOrderDate = $_GET['FOrderDate'];  ?>				
				<script type="text/javascript">
				$(function() {
					$('#FOrderDate').datepicker(
						{
						showOn: "both", dateFormat: 'yy-mm-dd', 
						yearRange: '<?=date("Y")-30?>:<?=date("Y")+30?>', 
						changeMonth: true,
						changeYear: true

						}
					);
					$("#FOrderDate").on("click", function () { 
							 $(this).val("");
						}
					);
				});
				</script>
				<input id="FOrderDate" name="FOrderDate" placeholder="From" class="datebox" readonly="" value="<?=$FOrderDate?>"  type="text" maxlength="10" style="width:125px;"> 
                    </fieldset>

			<fieldset>
				<? if(!empty($_GET['TOrderDate'])) $TOrderDate = $_GET['TOrderDate'];  ?>				
				<script type="text/javascript">
				$(function() {
					$('#TOrderDate').datepicker(
						{
						showOn: "both", dateFormat: 'yy-mm-dd', 
						yearRange: '<?=date("Y")-30?>:<?=date("Y")+30?>', 
						changeMonth: true,
						changeYear: true

						}
					);
					$("#TOrderDate").on("click", function () { 
							 $(this).val("");
						}
					);
				});
				</script>
				 <input id="TOrderDate" placeholder="To" name="TOrderDate" class="datebox"  readonly="" value="<?=$TOrderDate?>"  type="text" maxlength="10" style="width:125px;"> 

				</fieldset>-->




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
<? } ?>
