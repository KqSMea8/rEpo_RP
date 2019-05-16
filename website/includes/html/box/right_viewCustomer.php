<div class="right-search">
            	<h3><span class="icon"></span>Search</h3>
               
	 <form action="" method="get" class="admin_r_search_form" enctype="multipart/form-data" name="form2" onSubmit="return LoaderSearch();">
               <fieldset>  
                     <div class="sel-wrap">
                      <select name="sortby" id="sortby">
                        <option value="">All</option> 
                        <option value="c1.FirstName" <? if ($_GET['sortby'] == 'c1.FirstName') echo 'selected'; ?>>First Name</option>
                        <option value="c1.LastName" <? if ($_GET['sortby'] == 'c1.LastName') echo 'selected'; ?>>Last Name</option>
                        <option value="c1.Email" <? if ($_GET['sortby'] == 'c1.Email') echo 'selected'; ?>>Email</option>
                        <option value="c1.GroupID" <? if ($_GET['sortby'] == 'c1.GroupID') echo 'selected'; ?>>Group</option>
                        <option value="c1.Status" <? if ($_GET['sortby'] == 'c1.Status') echo 'selected'; ?>>Status</option>
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