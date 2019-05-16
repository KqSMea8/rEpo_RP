<? if(empty($_GET['po'])){?>
<div class="right-search">
            	<h3><span class="icon"></span>Search</h3>
               
				<form class="admin_r_search_form" action="<?=$SelfPage?>" method="get" enctype="multipart/form-data" name="form2" onSubmit="return LoaderSearch();">

				<fieldset>
				<label>Receive Date</label>
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
				<input id="FPostedDate" placeholder="From" class="datebox" name="FPostedDate" readonly="" value="<?=$FPostedDate?>"  type="text" maxlength="10" style="width:125px;"> 
                
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
				<input id="TPostedDate" placeholder="To" name="TPostedDate" class="datebox"  readonly="" value="<?=$TPostedDate?>"  type="text" maxlength="10" style="width:125px;"> 

				</fieldset>




				<fieldset>
				 <label>Order Date </label>
				<? if($_GET['FOrderDate']>0) $FOrderDate = $_GET['FOrderDate'];  ?>				
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
			 <input id="FOrderDate" placeholder="From" name="FOrderDate" class="datebox" readonly="" value="<?=$FOrderDate?>"  type="text" maxlength="10" style="width:125px;"> 
                    </fieldset>

			<fieldset>
				<? if($_GET['TOrderDate']>0) $TOrderDate = $_GET['TOrderDate'];  ?>				
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

				</fieldset>



                    <fieldset>
                        <label>Search By: </label>
                        <div class="sel-wrap">
						<select name="sortby" id="sortby">
								<option value=""> All </option>
								<option value="o.RecieveID" <? if($_GET['sortby']=='o.RecieveID') echo 'selected';?>>Receive Number</option>
								<option value="o.PurchaseID" <? if($_GET['sortby']=='o.PurchaseID') echo 'selected';?>>PO Number</option>
								<option value="o.SuppCompany" <? if($_GET['sortby']=='o.SuppCompany') echo 'selected';?>>Vendor</option>
								<option value="o.TotalAmount" <? if($_GET['sortby']=='o.TotalAmount') echo 'selected';?>>Amount</option>
								<option value="o.Currency" <? if($_GET['sortby']=='o.Currency') echo 'selected';?>>Currency</option>
								
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
							<option value="Desc" <? if($_GET['asc']=='Desc') echo 'selected';?>>Desc</option>
							<option value="Asc" <? if($_GET['asc']=='Asc') echo 'selected';?>>Asc</option>
						  </select>  
                         </div>
                    </fieldset>
                    <fieldset>
						<input name="module" type="hidden" value="<?=$module?>"  />
                     
						<input name="search" type="submit" class="button_btn" value="Search"  />
                    </fieldset>
                </form>
            </div>
<? } ?>