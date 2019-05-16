<div class="right-search">
            	<h3><span class="icon"></span>Search</h3>
               
				<form class="admin_r_search_form" action="<?=$SelfPage?>" method="get" enctype="multipart/form-data" name="form2" onSubmit="return LoaderSearch();">

				<fieldset>
					<label>From Date: </label>
					<? if($_GET['FromDateRtn']>0) $FromDateRtn = $_GET['FromDateRtn'];  ?>				
					<script type="text/javascript">
					$(function() {
						$('#FromDateRtn').datepicker(
							{
							showOn: "both", dateFormat: 'yy-mm-dd', 
							yearRange: '<?=date("Y")-30?>:<?=date("Y")+30?>', 
							changeMonth: true,
							changeYear: true

							}
						);
						$("#FromDateRtn").on("click", function () { 
								 $(this).val("");
							}
						);
					});
					</script>
					<input id="FromDateRtn" name="FromDateRtn" readonly="" value="<?=$FromDateRtn?>"  type="text" maxlength="10" > 
               </fieldset>

				<fieldset>
					<label>To Date: </label>
					<? if($_GET['ToDateInvRtn']>0) $ToDateInvRtn = $_GET['ToDateInvRtn'];  ?>				
					<script type="text/javascript">
					$(function() {
						$('#ToDateInvRtn').datepicker(
							{
							showOn: "both", dateFormat: 'yy-mm-dd', 
							yearRange: '<?=date("Y")-30?>:<?=date("Y")+30?>', 
							changeMonth: true,
							changeYear: true

							}
						);
						$("#ToDateInvRtn").on("click", function () { 
								 $(this).val("");
							}
						);

					});
					</script>
					<input id="ToDateInvRtn" name="ToDateInvRtn" readonly="" value="<?=$ToDateInvRtn?>"  type="text" maxlength="10" > 
               </fieldset>




                    <fieldset>
                        <label>Search By: </label>
                        <div class="sel-wrap">
						<select name="sortby" id="sortby">
								<option value=""> All </option>
								<option value="o.RecieveID" <? if($_GET['sortby']=='o.RecieveID') echo 'selected';?>>Ship Number</option>
								<option value="o.SaleID" <? if($_GET['sortby']=='o.SaleID') echo 'selected';?>>SO Number</option>
								<option value="o.CustomerName" <? if($_GET['sortby']=='o.CustomerName') echo 'selected';?>>Customer</option>
								<option value="o.TotalAmount" <? if($_GET['sortby']=='o.TotalAmount') echo 'selected';?>>Amount</option>
								<option value="o.CustomerCurrency" <? if($_GET['sortby']=='o.CustomerCurrency') echo 'selected';?>>Currency</option>
								<option value="o.ReturnPaid" <? if($_GET['sortby']=='o.ReturnPaid') echo 'selected';?>>Paid</option>
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