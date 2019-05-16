<div class="right-search">
            	<h3><span class="icon"></span>Search</h3>
               
				<form class="admin_r_search_form" action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return LoaderSearch();">
                    <fieldset>
                        <label>Reseller: </label>
                        <div class="sel-wrap">
<select name="rs" id="rs" class="textbox">
	<option value=""> All </option>
<?
foreach($arryReseller as $keyr=>$values_rs){
	$selr = ($_GET['rs']==$values_rs['RsID'])?('selected'):('');
	echo '<option value="'.$values_rs['RsID'].'" '.$selr.'>'.stripslashes($values_rs['CompanyName']).'</option>';

}
?>
</select>
                         </div>
                    </fieldset>

<br><br>

		 <fieldset>
                        <label>Expired: </label>
                        <div class="sel-wrap">
<select name="exp" id="exp" class="textbox">
	<option value=""> None </option>
  	<option value="Yes" <?=($_GET['exp']=='Yes')?('selected'):('')?> > Yes </option>
	<option value="No" <?=($_GET['exp']=='No')?('selected'):('')?>  > No </option>
</select>
                         </div>
                    </fieldset>

<br><br>


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
                     
						<input name="search" type="submit" class="button_btn" value="Search"  />
                    </fieldset>
                </form>
            </div>
