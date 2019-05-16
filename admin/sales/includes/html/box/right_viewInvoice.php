<div class="right-search">
            	<h3><span class="icon"></span>Search</h3>
               
				<form class="admin_r_search_form" action="<?=$SelfPage?>" method="get" enctype="multipart/form-data" name="form2" onSubmit="return LoaderSearch();">

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
						<select name="sortby" id="sortby">
								<option value=""> All </option>
								<option value="o.<?=$ModuleID?>" <? if($_GET['sortby']=='o.'.$ModuleID) echo 'selected';?>><?=$ModuleIDTitle?></option>
								<option value="o.SaleID" <? if($_GET['sortby']=='o.SaleID') echo 'selected';?>>SO Number</option>
								<option value="o.CustomerName" <? if($_GET['sortby']=='o.CustomerName') echo 'selected';?>>Customer</option>
								<option value="o.TotalAmount" <? if($_GET['sortby']=='o.TotalAmount') echo 'selected';?>>Amount</option>
								<option value="o.CustomerCurrency" <? if($_GET['sortby']=='o.CustomerCurrency') echo 'selected';?>>Currency</option>
								<option value="o.InvoicePaid" <? if($_GET['sortby']=='o.InvoicePaid') echo 'selected';?>>Status</option>
								<!--option value="o.Approved" <? if($_GET['sortby']=='o.Approved') echo 'selected';?>>Approved</option-->
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
						
						<input name="search" type="submit" class="button_btn" value="Search"  />




                    </fieldset>
                </form>
            </div>
