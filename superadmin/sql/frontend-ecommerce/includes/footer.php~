<?php  require_once("includes/html/box/pop_loader.php");  ?>	
<?php require_once("includes/html/" . $SelfPage); ?>
<?php
if($arryPageTemplate[0]['layoutType']=='rightsidebar' || $arryPageTemplate[0]['layoutType']=='bothsidebar') { ?>
	<div class="ecomm-themeRightbar"><?php echo $arryPageTemplate[0]['right']?></div>
<?php }?>

            </div>
        </div>
    </div>
</div>



<div class="float-clear"></div>

<div class="footer" id="footer">
	<div class="container">
    	<div class="row">
	        <div class="col-sm-12">
				<?php echo $arryPageTemplate[0]['footer']; ?>
            </div>    
        </div>
    </div>
</div>


<input type="hidden" name="Cid" id="Cid" value="<?= $_SESSION['Cid']; ?>">
<input type="hidden" name="CatID" id="CatID" value="<?= $_GET['cat']; ?>">
<input type="hidden" name="shortBy" id="shortBy" value="<?= $_GET['shortBy']; ?>">
<input type="hidden" name="Mfg" id="Mfg" value="<?= $_GET['Mfg']; ?>">
<input type="hidden" name="search_str" id="search_str" value="<?= $_GET['search_str']; ?>">
<input type="hidden" name="homeCompleteUrl" id="homeCompleteUrl" value="<?= $Config['homeCompleteUrl']; ?>">
 <input type="hidden" name="CurrActionUrl" id="CurrActionUrl" value="<?=$CurrActionUrl;?>">


</body>
</html>

