<? if(empty($ErrorMsg) && $CmpID>0){?>
<div class="right-search">
            	<h3><span class="icon"></span>Search</h3>
               
				<form class="admin_r_search_form" action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return LoaderSearch();">
                    <fieldset>
                        <label>Search By: </label>
                        <div class="sel-wrap">
					<select name="sortby" id="sortby" class="textbox">
						<option value=""> All </option>
						<option value="e.UserName" <? if($_GET['sortby']=='e.UserName') echo 'selected';?>>User Name</option>
						<option value="e.Email" <? if($_GET['sortby']=='e.Email') echo 'selected';?>>Email</option>
						<option value="u.LoginIP" <? if($_GET['sortby']=='u.LoginIP') echo 'selected';?>>IP Address</option>
						
						
						
					</select>
                         </div>
                    </fieldset>
                   
                    
                    <fieldset>
                    	 <label>Keyword:</label>
                        <input type='text' name="key"  id="key" value="<?=$_GET['key']?>" />
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
                     <input name="cmp" type="hidden" value="<?=$CmpID?>"  />
						<input name="search" type="submit" class="button_btn" value="Search"  />
                    </fieldset>
                </form>
            </div>
<? } ?>
