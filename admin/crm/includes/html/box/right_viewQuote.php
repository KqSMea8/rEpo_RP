
<div class="right-search">
            	<h3><span class="icon"></span>Search</h3>
               
				<form class="admin_r_search_form" action="<?=$SelfPage?>" method="get" enctype="multipart/form-data" name="form2" onSubmit="return LoaderSearch();">

<? require_once("../includes/html/box/right_custom.php"); ?>

				<!--By Rajan 20Jan 2016-->
			<?php if($RowColorDropDown){?> 
			<label id="highlight">Search By Color: <label>
	            <?php echo $RowColorDropDown; 
			} ?>
	<!--End--> 
                    <fieldset>
                        <label>Search By: </label>
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
                       <input type='text' name="key"  id="key"  value="<?=$_GET['key']?>" />
                    </fieldset>
                   
                    <fieldset>
                    	 <label>Order By:</label>
                         <div class="sel-wrap">
							<select name="asc" id="asc"  >
							<?
							foreach($arryRightOrder as $valueright){
								$sel = ($_GET['asc']==$valueright)?('selected'):('');
								echo '<option value="'.$valueright.'" '.$sel.'>'.$valueright.'</option>';
							
							}
							?>
							</select>
                    </fieldset>
                    <fieldset>
                      <input name="module" type="hidden"  value="<?=$_GET['module']?>"  />
						<input name="search" type="submit" class="button_btn" value="Search"  />
                    </fieldset>
                </form>
               
            </div>
            
            
