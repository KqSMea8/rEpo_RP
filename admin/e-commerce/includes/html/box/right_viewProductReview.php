<div class="right-search">
            	<h3><span class="icon"></span>Search</h3>
               
	 <form action="" method="get" class="admin_r_search_form" enctype="multipart/form-data" name="form2" onSubmit="return LoaderSearch();">
               <fieldset>  
                     <div class="sel-wrap">
                      <select name="sortby" id="sortby">
                        <option value="">All</option> 
                        <option value="pr.ReviewTitle" <? if ($_GET['sortby'] == 'pr.ReviewTitle') echo 'selected'; ?>>Title</option>
                        <option value="c.Email" <? if ($_GET['sortby'] == 'c.Email') echo 'selected'; ?>>Email</option>
                        <option value="p.ProductSku" <? if ($_GET['sortby'] == 'p.ProductSku') echo 'selected'; ?>>Product Sku</option>
                        <option value="pr.Status" <? if ($_GET['sortby'] == 'pr.Status') echo 'selected'; ?>>Status</option>
                      </select>
                         </div>
                      </fieldset>
                       <fieldset>
                            <label>Keyword:</label>
                          <input type='text' name="key"  id="key" class="inputbox" value="<?= $_GET['key'] ?>"> 
             		</fieldset>
                     <fieldset>
                         <div class="sel-wrap">
                            <select name="asc" id="asc" >
                                <option value="Desc" <? if ($_GET['asc'] == 'Desc') echo 'selected'; ?>>Desc</option>
                                <option value="Asc" <? if ($_GET['asc'] == 'Asc') echo 'selected'; ?>>Asc</option>
                            </select>
                             </div>
                        </fieldset>
                       
                            <input type="hidden" name="CatID" id="CatID" value="<?= $_GET['CatID'] ?>">  
                          <fieldset>
                           <input name="search" type="submit" class="button_btn" value="Search"  />
                            </fieldset>
                 

            </form>
            </div>