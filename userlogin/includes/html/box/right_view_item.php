<div class="right-search">
            	<h3><span class="icon"></span>Search</h3>
               
	 <form action="" method="get" class="admin_r_search_form" enctype="multipart/form-data" name="form2" onSubmit="return LoaderSearch();">
               <fieldset>  
			 <label>Search By: </label>
                     <div class="sel-wrap">
                   <select name="sortby" id="sortby">
                                <option value="">All</option> 
                                
<option value="p1.Sku" <? if ($_GET['sortby'] == 'p1.Sku') echo 'selected'; ?>>SKU</option>

<option value="p1.description" <? if ($_GET['sortby'] == 'p1.description') echo 'selected'; ?>>Item Name</option>
<option value="p1.sell_price" <? if ($_GET['sortby'] == 'p1.sell_price') echo 'selected'; ?>>Price</option>
<option value="p1.qty_on_hand" <? if ($_GET['sortby'] == 'p1.qty_on_hand') echo 'selected'; ?>> 	Qty on Hand</option>
<option value="p1.Status" <? if ($_GET['sortby'] == 'p1.Status') echo 'selected'; ?>>Status</option>
                            </select>
                         </div>
			
                   
                      </fieldset>
                       <fieldset>
                            <label>Keyword:</label>
                          <input type='text' name="key"  id="key" class="inputbox" value="<?= $_GET['key'] ?>"> 
             		</fieldset>
                     <fieldset>
			 <label>Order By:</label>
                         <div class="sel-wrap">
                            <select name="asc" id="asc" >
                                <option value="Desc" <? if ($_GET['asc'] == 'Desc') echo 'selected'; ?>>Desc</option>
                                <option value="Asc" <? if ($_GET['asc'] == 'Asc') echo 'selected'; ?>>Asc</option>
                            </select>
                             </div>
                        </fieldset>
                       
                           
                          <fieldset>
                           <input name="search" type="submit" class="button_btn" value="Search"  />
                            </fieldset>
                 

            </form>
            </div>
