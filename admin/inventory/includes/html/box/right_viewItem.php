<div class="right-search">
            	<h3><span class="icon"></span>Search</h3>
               
	 <form action="" method="get" class="admin_r_search_form" enctype="multipart/form-data" name="form2" onSubmit="return LoaderSearch();">
               <fieldset>  
	 <label>Category:</label>
                    <div class="sel-wrap">

                           <select name="CatID" id="CatID">
                                <option value="">All</option> 
                                <?php foreach($listAllCategory as $key=>$value){
                                     $arrySubCategory = $objCategory->GetSubCategoryByParent('',$value['CategoryID']);?>
                                                     <option value="<?php echo $value['CategoryID'];?>" <?php if($_GET['CatID']==$value['CategoryID']){echo "selected";}?>>&nbsp;<?php echo $value['Name'];?></option>
                                                    <?php foreach ($arrySubCategory as $key => $value) {
                                                      $arrySubCategory = $objCategory->GetSubCategoryByParent('',$value['CategoryID']);?>
                                                     <option value="<?php echo $value['CategoryID'];?>" <?php if($_GET['CatID']==$value['CategoryID']){echo "selected";}?>>&nbsp;&nbsp;&nbsp;-<?php echo $value['Name'];?></option>
                                                     
                                                     <?php foreach ($arrySubCategory as $key => $value) { 
                                                         $arrySubCategory = $objCategory->GetSubCategoryByParent('',$value['CategoryID']); ?>
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
<br />
 
<?php  
//By chetan 14Sept. 2016//
 
if($_GET['module'] == 'exclusive'){?>
 
<label>Customers:</label>
                    <div class="sel-wrap">
 
                           <select name="CustID" id="CustID">
                                <option value="">-- Select --</option>  
                                <?php foreach($arryItemsCustomers as $key=>$value){ ?>
                                                     <option value="<?php echo $value['CustomerID'];?>" <?php if($_GET['CustID']==$value['CustomerID']){echo "selected";}?>>&nbsp;<?php echo $value['FullName'];?></option>
                                                    
                                <? } ?>
                                
                            </select>
                         </div>
 
 
 
<? }
//End//
 ?>
<label>Search By:</label>
                     <div class="sel-wrap">

<select name="sortby" id="sortby" class="textbox">
	<option value=""> All </option>
<?
foreach($RightArray as $values){
	$sel = ($_GET['sortby']==$values['value'])?('selected'):('');
	echo '<option value="'.$values['value'].'" '.$sel.'>'.$values['label'].'</option>';

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
                       <select name="asc" id="asc"  >
<?
foreach($arryRightOrder as $valueright){
	$sel = ($_GET['asc']==$valueright)?('selected'):('');
	echo '<option value="'.$valueright.'" '.$sel.'>'.$valueright.'</option>';

}
?>
</select>
                             </div>
                        </fieldset>
                       
                           
                          <fieldset>
<input type='hidden' name="module"  id="module" class="inputbox" value="<?= $_GET['module'] ?>"> 
             		
                           <input name="search" type="submit" class="button_btn" value="Search"  />
                            </fieldset>
                 

            </form>
            </div>
