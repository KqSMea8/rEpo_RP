<div class="right-search">
            	<h3><span class="icon"></span>Search</h3>
               
				<form class="admin_r_search_form" action="<?=$SelfPage?>" method="get" enctype="multipart/form-data" name="form2" onSubmit="return LoaderSearch();">
                    <? require_once("../includes/html/box/right_custom.php"); ?>
                                    
                                    <fieldset>
                        <label>Search By: </label>
                        <div class="sel-wrap">
                      <select name="sortby" id="sortby" class="textbox">
                        <option value=""> All </option>
                        <!--option value="c.ContactID" <? if($_GET['sortby']=='c.ContactID') echo 'selected';?>>Contact ID</option-->
                        <option value="c.FirstName" <? if($_GET['sortby']=='c.FirstName') echo 'selected';?>>First Name</option>
                        <option value="c.LastName" <? if($_GET['sortby']=='c.LastName') echo 'selected';?>>Last Name</option>
                        
                        <option value="c.Email" <? if($_GET['sortby']=='c.Email') echo 'selected';?>>Email</option>
		 <option value="c.Title" <? if($_GET['sortby']=='c.Title') echo 'selected';?>>Title</option>
                  <option value="e.UserName" <? if($_GET['sortby']=='e.UserName') echo 'selected';?>>Assign To </option>      


                        <option value="c.Status" <? if($_GET['sortby']=='c.Status') echo 'selected';?>>Status</option>
                    </select>
                         </div>
                    </fieldset>
                   
                    
                    <fieldset>
                    	 <label>Keyword:</label>
                       <input type='text' name="key"  id="key"  value="<?=$_GET['key']?>" />
                    </fieldset>
                   
                    <fieldset>
                    	 <label>Order By:</label>
                         <div class="sel-wrap">
						   <select name="asc" id="asc" >
                            <option value="Desc" <? if($_GET['asc']=='Desc') echo 'selected';?>>Desc</option>
                            <option value="Asc" <? if($_GET['asc']=='Asc') echo 'selected';?>>Asc</option>
                          </select> 
                         </div>
                    </fieldset>
                    <fieldset>
                      <input name="module" type="hidden"  value="<?=$_GET['module']?>"  />
						<input name="search" type="submit" class="button_btn" value="Search"  />
                    </fieldset>
                </form>
               
            </div>
            
            
