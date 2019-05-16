<div class="right-search">
            	<h3><span class="icon"></span>Search</h3>
               
				<form class="admin_r_search_form" action="<?=$SelfPage?>" method="get" enctype="multipart/form-data" name="form2" onSubmit="return LoaderSearch();">
                    <fieldset>
                        <label>Search By: </label>
                        <div class="sel-wrap">
						<select name="sortby" id="sortby">
								<option value=""> All </option>
								<option value="a.RecieveNo" <? if($_GET['sortby']=='a.RecieveNo') echo 'selected';?>>Receive Number</option>
								<option value="a.asm_code" <? if($_GET['sortby']=='a.asm_code') echo 'selected';?>>Assemble Number</option>
								<option value="p.warehouse_name" <? if($_GET['sortby']=='p.warehouse_name') echo 'selected';?>>Warehouse Location</option>
								<option value="a.Status_Name" <? if($_GET['sortby']=='a.Status_Name') echo 'selected';?>>Status</option>
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