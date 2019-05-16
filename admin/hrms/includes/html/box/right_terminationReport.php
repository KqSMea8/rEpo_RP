<div class="right-search">
            	<h3><span class="icon"></span>Search</h3>
               
				<form class="admin_r_search_form" action="<?=$SelfPage?>" method="get" enctype="multipart/form-data" name="form2" onSubmit="return LoaderSearch();">
                   
					<fieldset>
                        <label>Year: </label>
                        <div class="sel-wrap">
							<?=getYears($_GET['Year'],"Year","")?>
                         </div>
                    </fieldset>
					
					<fieldset>
                        <label>Search By: </label>
                        <div class="sel-wrap">
						<select name="sortby" id="sortby">
								<option value=""> All </option>
								<option value="e.EmpCode" <? if($_GET['sortby']=='e.EmpCode') echo 'selected';?>>Emp Code</option>
								<option value="e.UserName" <? if($_GET['sortby']=='e.UserName') echo 'selected';?>> Name</option>
								<option value="d.Department" <? if($_GET['sortby']=='d.Department') echo 'selected';?>>Department</option>
							<option value="e.ExitType" <? if($_GET['sortby']=='e.ExitType') echo 'selected';?>>Exit Type</option>
							<option value="e.ExitReason" <? if($_GET['sortby']=='e.ExitReason') echo 'selected';?>>Reason</option>
							<option value="e.FullFinal" <? if($_GET['sortby']=='e.FullFinal') echo 'selected';?>>Full & Final</option>
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
                     
						<input name="s" type="submit" class="button_btn" value="Search"  />
                    </fieldset>
                </form>
            </div>