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
					<? if($_GET['ToDateRtn']>0) $ToDateRtn = $_GET['ToDateRtn'];  ?>				
					<script type="text/javascript">
					$(function() {
						$('#ToDateRtn').datepicker(
							{
							showOn: "both", dateFormat: 'yy-mm-dd', 
							yearRange: '<?=date("Y")-30?>:<?=date("Y")+30?>', 
							changeMonth: true,
							changeYear: true

							}
						);
						$("#ToDateRtn").on("click", function () { 
								 $(this).val("");
							}
						);

					});
					</script>
					<input id="ToDateRtn" name="ToDateRtn" readonly="" value="<?=$ToDateRtn?>"  type="text" maxlength="10" > 
               </fieldset>
                
                    <fieldset>
                    	 <label>Keyword:</label>
                        <input type='text' readonly="" class="disable" name="key"  id="key" value="<?=$_GET['key']?>"  />
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