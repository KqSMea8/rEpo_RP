<div class="right-search">
            	<h3><span class="icon"></span>Search</h3>
               
				<form class="admin_r_search_form" action="<?=$SelfPage?>" method="get" enctype="multipart/form-data" name="form2" onSubmit="return LoaderSearch();">
                    <fieldset>
                        <label>Search By: </label>
                        <div class="sel-wrap">
						<select name="sortby" id="sortby">
								<option value=""> All </option>
								<option value="v.VendorCode" <? if($_GET['sortby']=='v.VendorCode') echo 'selected';?>>Vendor Code</option>
								<option value="v.VendorName" <? if($_GET['sortby']=='v.VendorName') echo 'selected';?>>Vendor Name</option>
								<option value="v.Email" <? if($_GET['sortby']=='v.Email') echo 'selected';?>>Email</option>
								<option value="v.Country" <? if($_GET['sortby']=='v.Country') echo 'selected';?>>Country</option>
								<option value="v.State" <? if($_GET['sortby']=='v.State') echo 'selected';?>>State</option>
								<option value="v.City" <? if($_GET['sortby']=='v.City') echo 'selected';?>>City</option>

							
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