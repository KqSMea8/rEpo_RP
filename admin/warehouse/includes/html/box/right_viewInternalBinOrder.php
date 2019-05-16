<div class="right-search">
            	<h3><span class="icon"></span>Search</h3>
               
				<form class="admin_r_search_form" action="<?=$SelfPage?>" method="get" enctype="multipart/form-data" name="form2" onSubmit="return LoaderSearch();">
                    <fieldset>
                        <label>Search By: </label>
                        <div class="sel-wrap">
						<select name="sortby" id="sortby">
								<option value=""> All </option>
								<option value="p.RecieveNo" <? if($_GET['sortby']=='p.RecieveNo') echo 'selected';?>>Receive Number</option>
								<option value="a.bin_id" <? if($_GET['sortby']=='a.bin_id') echo 'selected';?>>Bin Location</option>
								<option value="a.warehouse_id" <? if($_GET['sortby']=='a.warehouse_id') echo 'selected';?>>Warehouse Location</option>
								<option value="a.Status" <? if($_GET['sortby']=='a.Status') echo 'selected';?>>Status</option>
								<!--<option value="o.TotalAmount" <? if($_GET['sortby']=='o.TotalAmount') echo 'selected';?>>Amount</option>
								<option value="o.Currency" <? if($_GET['sortby']=='o.Currency') echo 'selected';?>>Currency</option> -->	
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