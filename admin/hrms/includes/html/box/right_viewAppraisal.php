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
                    	 <label>To Date:</label>
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
<input id="ToDate" name="ToDate" readonly="" value="<?=$ToDate?>"  type="text" > 
                    </fieldset>



				 <fieldset>
                    	 <label>Department:</label>
               <div class="sel-wrap">           
			<select name="depID" id="depID">
			  <option value=""> All </option>
			  <? for($i=0;$i<sizeof($arrySubDepartment);$i++) {?>
			  <option value="<?=$arrySubDepartment[$i]['depID']?>" <?  if($arrySubDepartment[$i]['depID']==$_GET['depID']){echo "selected";}?>>
			  <?=stripslashes($arrySubDepartment[$i]['Department'])?>
			  </option>
			  <? } ?>
			</select>
			</div>
                    </fieldset>





                    <fieldset>
                        <label>Search By: </label>
                        <div class="sel-wrap">
		<select name="sortby" id="sortby" class="textbox">
		<option value=""> All </option>
		<option value="e.EmpCode" <? if($_GET['sortby']=='e.EmpCode') echo 'selected';?>>Emp Code</option>
		<option value="e.UserName" <? if($_GET['sortby']=='e.UserName') echo 'selected';?>>Employee Name</option>
	</select>
                         </div>
                    </fieldset>
                   
                    
                    <fieldset>
                    	 <label>Keyword:</label>
                        <input type='text' name="key"  id="key" value="<?=$_GET['key']?>" />
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
                     
						<input name="sc" type="submit" class="button_btn" value="Search"  />
                    </fieldset>
                </form>
            </div>