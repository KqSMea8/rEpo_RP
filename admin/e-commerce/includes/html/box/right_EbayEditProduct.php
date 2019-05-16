<div class="right-search">
  <h4>
    <? if(isset($arryProduct[0]['Name'])) echo stripslashes($arryProduct[0]['Name']); ?>
  </h4>
<div class="right_box">
    <ul class="rightlink">
      <li <?= ($_GET['tab'] == "ActiveItems") ? ("class='active'") : (""); ?>><a href="<?= $EditUrl ?>ActiveItems"> Active Items</a></li>
      <li <?= ($_GET['tab'] == "UnlistedProduct") ? ("class='active'") : (""); ?>><a href="<?= $EditUrl ?>UnlistedProduct"> Unlisted Product </a></li>
    </ul>
<?php $FiterData = (array) json_decode($fiterSet[0]['Value']); ?>
</div>	
<?php if($_GET['tab']!='SubmissionHistory' && $_GET['tab']!='SendAmazon'){?>
				<br><br>
			<h3><span class="icon"></span>Search</h3>
			<form class="admin_r_search_form" action="" method="get" name="form3" onsubmit="return LoaderSearch();">
					 <fieldset>  
					 	<label>Search By: </label>
			            <div class="sel-wrap">
			                <select name="sortby" id="sortby" class="textbox">
								<option value="All"> All </option>
								<option value="ProductSku" <?=($_GET['sortby']=='ProductSku') ? 'selected' : ''?> >Sku</option>
								<option value="Name" <?=($_GET['sortby']=='Name') ? 'selected' : ''?> >Title</option>
								<option value="ListingPrice" <?=($_GET['sortby']=='ListingPrice') ? 'selected' : ''?> >Lowest Price</option>
								<option value="FeedProcessingStatus" <?=($_GET['sortby']=='FeedProcessingStatus') ? 'selected' : ''?> >Status</option>
								<option value="ItemConditionNote" <?=($_GET['sortby']=='ItemConditionNote') ? 'selected' : ''?> >Condition Note</option>			
							</select>
                         </div>
                      </fieldset>
					  <fieldset>
                            <label>Keyword:</label>
                          <input type="text" name="key" id="key" class="inputbox" value="<?php if(!empty($_GET['key'])) echo $_GET['key']?>" > 
             		</fieldset>
             		<fieldset>
                         <div class="sel-wrap">
                            <select name="asc" id="asc">
								<option value="Asc" <?=($_GET['asc']=='Asc') ? 'selected' : ''?> >Asc</option>
								<option value="Desc" <?=($_GET['asc']=='Desc') ? 'selected' : ''?> >Desc</option>			    
							</select>
                          </div>
                        </fieldset>
				
					<fieldset>
						<input name="s2" type="submit" class="button_btn" value="Search">
                    </fieldset>
				
				</form>



	<br>
			<h3><span class="icon"></span>Filter Listing</h3>
			<form class="admin_r_search_form" action="" method="get" name="form3" onsubmit="return LoaderSearch();">
					 <fieldset>
                        <label>Conditions: </label>
						 <div class="sel-wrap">
						 	<select class="inputbox" id="ItemCondition" name="ItemCondition" title="Condition" >
								<option value="">All Conditions</option>
								<option value="New" <?=($FiterData['ItemCondition']=='New') ? 'selected' : ''?>>New</option>
								<option value="Used" <?=($FiterData['ItemCondition']=='Used') ? 'selected' : ''?>>Used</option>
							</select>
						 </div>
					 </fieldset>
					 <fieldset>
                        <label>Quantity: </label>
							<input type="text" name="QuantityFrom" id="QuantityFrom" class="inputbox" style="width:56px;" placeholder="from" value="<?php if(!empty($FiterData['QuantityTo'])) echo (int)$FiterData['QuantityFrom']?>">
							<input type="text" name="QuantityTo" id="QuantityTo" class="inputbox" style="width:56px;" placeholder="To" value="<?=$FiterData['QuantityTo']?>">
					 </fieldset>
					 <fieldset>
                        <label>Price: </label>
							<input type="text" name="PriceFrom" id="PriceFrom" class="inputbox" style="width:56px;" placeholder="from" value="<?php if(!empty($FiterData['PriceTo'])) echo (int)$FiterData['PriceFrom']?>">
							<input type="text" name="PriceTo" id="PriceTo" class="inputbox" style="width:56px;" placeholder="To" value="<?=$FiterData['PriceTo']?>">
					 </fieldset>
				
					<fieldset>
						<input name="s2" type="submit" class="button_btn" value="Apply Filter">
                    </fieldset>
				
				</form>
<?php }?>
</div>
