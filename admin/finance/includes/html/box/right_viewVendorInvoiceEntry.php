
<div class="right-search">
            	<h3><span class="icon"></span>Search</h3>
               
				<form class="admin_r_search_form" action="<?=$SelfPage?>" method="get" enctype="multipart/form-data" name="form2" onSubmit="return LoaderSearch();">
                               <? // require_once("../includes/html/box/right_custom.php"); ?>
				<fieldset>
				<label>Invoice Date</label>
				<? if($_GET['FPostedDate']>0) $FPostedDate = $_GET['FPostedDate'];  ?>				
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
				<? if($_GET['TPostedDate']>0) $TPostedDate = $_GET['TPostedDate'];  ?>				
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
						<input name="module" type="hidden" value="<?=$module?>"  />
                     
						<input name="search" type="submit" class="button_btn" value="Search"  />
                    </fieldset>
                </form>
            </div>

