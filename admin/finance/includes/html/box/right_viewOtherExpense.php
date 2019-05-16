<div class="right-search">
            <h3><span class="icon"></span>Search</h3>
               
			<form class="admin_r_search_form" action="<?=$SelfPage?>" method="get" enctype="multipart/form-data" name="form2" onSubmit="return LoaderSearch();">

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
                        <label>Search By: </label>
                        <div class="sel-wrap">
						<select name="sortby" id="sortby">
								<option value=""> All </option>
								<option value="f.ReferenceNo" <? if($_GET['sortby']=='f.ReferenceNo') echo 'selected';?>>ReferenceNo</option>
								<option value="s.CompanyName" <? if($_GET['sortby']=='c.CompanyName') echo 'selected';?>>Vendor</option>
								<option value="f.TotalAmount" <? if($_GET['sortby']=='f.TotalAmount') echo 'selected';?>>Amount</option>
								
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
