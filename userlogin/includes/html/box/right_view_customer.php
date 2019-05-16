<div class="right-search">
            	<h3><span class="icon"></span>Search</h3>
               
	 <form action="" method="get" class="admin_r_search_form" enctype="multipart/form-data" name="form2" onSubmit="return LoaderSearch();">
             <? require_once("../includes/html/box/right_custom.php"); ?>
               <fieldset>  
                     <div class="sel-wrap">
                      <select name="sortby" id="sortby">
                        <option value="">All</option>
						<option value="c1.CustCode" <? if ($_GET['sortby'] == 'c1.CustCode') echo 'selected'; ?>>Customer Code</option>						
                        <option value="c1.FullName" <? if ($_GET['sortby'] == 'c1.FullName') echo 'selected'; ?>>Customer Name</option>
                      
                        <option value="c1.Email" <? if ($_GET['sortby'] == 'c1.Email') echo 'selected'; ?>>Email Address</option>

 <option value="c1.Landline" <? if ($_GET['sortby'] == 'c1.Landline') echo 'selected'; ?>>Phone</option>
 <option value="ab.CountryName" <? if ($_GET['sortby'] == 'ab.CountryName') echo 'selected'; ?>>Country</option>
  <option value="ab.StateName" <? if ($_GET['sortby'] == 'ab.StateName') echo 'selected'; ?>>State</option>
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
