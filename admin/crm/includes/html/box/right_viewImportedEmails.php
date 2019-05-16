<div id="main_table_list" class="main-container clearfix">
    <div id="mid" class="main">
<div class="right-search">
            	<h3><span class="icon"></span>Search</h3>
               
				<form class="admin_r_search_form" action="<?=$SelfPage?>" method="get" enctype="multipart/form-data" name="form2" onSubmit="return LoaderSearch();">

                                    <fieldset>
                        <label>Search By: </label>
                        <div class="sel-wrap">
                      <select name="sortby" id="sortby" class="textbox">
                        <option value=""> All </option>
                        <!--option value="c.ContactID" <? if($_GET['sortby']=='c.ContactID') echo 'selected';?>>Contact ID</option-->
                        <option value="email">Email</option>
                        <option value="subject">Subject</option>
                        <option value="content">Email Content </option>
                        
		 
                    </select>
                         </div>
                    </fieldset>
                   
                    
                    <fieldset>
                    	 <label>Keyword:</label>
                       <input type='text' name="key"  id="key"  value="<?=$_GET['key']?>" />
                    </fieldset>
                    <fieldset>
                      <input name="module" type="hidden"  value="<?=$_GET['module']?>"  />
						<input name="search" type="submit" class="button_btn" value="Search"  />
                    </fieldset>
                </form>
               
            </div>
        </div>         
            
  </div>  