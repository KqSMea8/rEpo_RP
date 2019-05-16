
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
		yearRange: '<?=date("Y")-30?>:<?=date("Y")?>', 
		maxDate: "-0D", 
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
                    	 <label>To Date:</label>
                        <? if($_GET['ToDate']>0) $ToDate = $_GET['ToDate'];  ?>				
<script type="text/javascript">
$(function() {
	$('#ToDate').datepicker(
		{
		showOn: "both", dateFormat: 'yy-mm-dd', 
		yearRange: '<?=date("Y")-30?>:<?=date("Y")?>', 
		maxDate: "-0D", 
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
<input id="ToDate" name="ToDate" readonly="" value="<?=$ToDate?>"  type="text" > 
                    </fieldset>




                    <fieldset>
                        <label>Search By: </label>
                        <div class="sel-wrap">
						<select name="sortby" id="sortby">
								<option value=""> All </option>
								<option value="e.EmpCode" <? if($_GET['sortby']=='e.EmpCode') echo 'selected';?>>User Code</option>
								<option value="e.UserName" <? if($_GET['sortby']=='e.UserName') echo 'selected';?>>Name</option>
								<option value="e.JobTitle" <? if($_GET['sortby']=='e.JobTitle') echo 'selected';?>>Designation</option>

								<option value="e.Email" <? if($_GET['sortby']=='e.Email') echo 'selected';?>>Email</option>
								<!--option value="d.Department" <? if($_GET['sortby']=='d.Department') echo 'selected';?>>Department</option-->								
								
								<!--option value="e.Status" <? if($_GET['sortby']=='e.Status') echo 'selected';?>>Status</option-->
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
