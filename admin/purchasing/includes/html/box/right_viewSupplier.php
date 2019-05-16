<div class="right-search">
            	<h3><span class="icon"></span>Search</h3>
               
				<form class="admin_r_search_form" action="<?=$SelfPage?>" method="get" enctype="multipart/form-data" name="form2" onSubmit="return LoaderSearch();">
                    <fieldset>
                        <label>Search By: </label>
                        <div class="sel-wrap">
						<select name="sortby" id="sortby">
								<option value=""> All </option>
								<option value="s.SuppCode" <? if($_GET['sortby']=='s.SuppCode') echo 'selected';?>>Vendor Code</option>
								<option value="s.CompanyName" <? if($_GET['sortby']=='s.CompanyName') echo 'selected';?>>Company Name</option>
								<option value="ab.Country" <? if($_GET['sortby']=='ab.Country') echo 'selected';?>>Country</option>
								<option value="ab.State" <? if($_GET['sortby']=='ab.State') echo 'selected';?>>State</option>
								<option value="ab.City" <? if($_GET['sortby']=='ab.City') echo 'selected';?>>City</option>

								<option value="s.Currency" <? if($_GET['sortby']=='s.Currency') echo 'selected';?>>Currency</option>
								
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
