<!--<div class="right-search">
            	<h3><span class="icon"></span>Search</h3>
               
				<form class="admin_r_search_form" action="<?=$SelfPage?>" method="get" enctype="multipart/form-data" name="form2" onSubmit="return LoaderSearch();">
                    <fieldset>
                        <label>Search By: </label>
                        <div class="sel-wrap">
		<select name="sortby" id="sortby" class="textbox">
		<option value=""> All </option>
		<option value="s.EmpCode" <? if($_GET['sortby']=='s.EmpCode') echo 'selected';?>>Emp Code</option>
		<option value="e.UserName" <? if($_GET['sortby']=='e.UserName') echo 'selected';?>>Employee Name</option>
		<option value="d.Department" <? if($_GET['sortby']=='d.Department') echo 'selected';?>>Department</option>
		<option value="e.JobTitle" <? if($_GET['sortby']=='e.JobTitle') echo 'selected';?>>Designation</option>
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
                     
						<input name="search" type="submit" class="button_btn" value="Search"  />
                    </fieldset>
                </form>
            </div>-->
