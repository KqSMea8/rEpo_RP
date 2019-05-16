<div class="right-search">
            	<h3><span class="icon"></span>Search</h3>
               
				<form class="admin_r_search_form" action="<?=$SelfPage?>" method="get" enctype="multipart/form-data" name="form2" onSubmit="return LoaderSearch();">


				<fieldset>
				<label>Year</label>
				 <div class="sel-wrap">
                 <?=getYears($_GET["y"],"y","textbox")?>
				 </div>
				</fieldset>




				<fieldset>
				<label>Month</label>
				 <div class="sel-wrap">
				<?=getMonths($_GET["m"],"m","textbox")?>
				 </div>
				</fieldset>



				




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
                        <input type='text' name="key"  id="key" value="<?=$_GET['key']?>" />
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
                         </div>
                    </fieldset>
                    <fieldset>
                     
						<input name="sc" type="submit" class="button_btn" value="Search"  />
                    </fieldset>
                </form>
            </div>
