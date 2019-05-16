<div class="right-search">
            	<h3><span class="icon"></span>Search</h3>
               
	 <form action="" method="get" class="admin_r_search_form" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch();">
               <fieldset>  
                     <div class="sel-wrap">
                   <select name="sortby" id="sortby">
                                <option value="">All</option> 
                                <option value="p1.Name" <? if ($_GET['sortby'] == 'p1.Name') echo 'selected'; ?>>Product Name</option>
                                <option value="p1.ProductSku" <? if ($_GET['sortby'] == 'p1.ProductSku') echo 'selected'; ?>>Product Sku</option>
                                <option value="p1.Featured" <? if ($_GET['sortby'] == 'p1.Featured') echo 'selected'; ?>>Featured</option>
                                <option value="p1.Status" <? if ($_GET['sortby'] == 'p1.Status') echo 'selected'; ?>>Status</option>
                            </select>
                         </div><br>
                    <div class="sel-wrap">
                           <select name="CatID" id="CatID">
                                <option value="">Select Category</option> 
                                <?php 
                                                    
                                                       foreach($listAllCategory as $key=>$value){
                                                        
                                                        $arrySubCategory = $objCategory->GetSubCategoryByParent('',$value['CategoryID']);
                                                        
                                                    
                                                             ?>
                                                     <option value="<?php echo $value['CategoryID'];?>" <?php if($_GET['CatID']==$value['CategoryID']){echo "selected";}?>>&nbsp;<?php echo $value['Name'];?></option>
                                                    <?php 
                                                    
                                                     foreach ($arrySubCategory as $key => $value) {
                                                      $arrySubCategory = $objCategory->GetSubCategoryByParent('',$value['CategoryID']);
                                                    ?>
                                                     <option value="<?php echo $value['CategoryID'];?>" <?php if($_GET['CatID']==$value['CategoryID']){echo "selected";}?>>&nbsp;&nbsp;&nbsp;-<?php echo $value['Name'];?></option>
                                                     
                                                     <?php
                                                     foreach ($arrySubCategory as $key => $value) { 
                                                         $arrySubCategory = $objCategory->GetSubCategoryByParent('',$value['CategoryID']); 
                                                         ?>
                                                      <option value="<?php echo $value['CategoryID'];?>" <?php if($_GET['CatID']==$value['CategoryID']){echo "selected";}?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-<?php echo $value['Name'];?></option>
                                                      <?php
                                                     foreach ($arrySubCategory as $key => $value) { ?>
                                                      <option value="<?php echo $value['CategoryID'];?>" <?php if($_GET['ParentID']==$value['CategoryID']){echo "selected";}?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-<?php echo $value['Name'];?></option>
                                                     <?php 
                                                         }
                                                        }
                                                     
                                                      }
                                                    } 
                                                     ?>
                               
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
                       
                           
                          <fieldset>
                           <input name="search" type="submit" class="button_btn" value="Search"  />
                            </fieldset>
                 

            </form>
            </div>