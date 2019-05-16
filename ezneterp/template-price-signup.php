<div class="top-cont1"></div>

<div class="main-content">
<div class="werp">
<div class="banner"><img src="img/Pricing.png" /></div>
</div>
</div>

<div class="inner-cont-text">
<div class="werp">
<div class="bradecrumb"><nav> <a href="#">Home</a> <a href="#">Pricing &
Signup</a> </nav></div>
</div>
</div>

<section id="mainContent">

<div class="InfoText">
<div class="wrap clearfix"><article id="leftPart">
<div class="detailedContent">
<div id="content" class="column">
<div class="section">
<h1 class="title" id="page-title">eZnet ERP Pricing &amp; Signup</h1>
<div class="tabs">&nbsp;</div>
<div class="redmsg" align="center"><?php echo $_SESSION["PricingMsg"] ; unset($_SESSION["PricingMsg"]);?>
</div>
<div id="banner">
<div class="region region-slider">
<div id="block-views-inner-slider-block" class="block block-views">
<div class="content">
<div
	class="view view-inner-slider view-id-inner_slider view-display-id-block view-dom-id-5a5b298d5c2896f876c2f50db1084d66">
<div class="view-content">
<div
	class="views-row views-row-1 views-row-odd views-row-first views-row-last">
<div class="views-field views-field-field-inner-slider-image">
<div class="field-content">&nbsp;</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="region region-content">
<div id="block-system-main" class="block block-system">
<div class="content">
<div id="node-71" class="node node-page clearfix"
	about="/pricing-signup" typeof="foaf:Document">
<div class="content clearfix"><?php echo $datah['Content'];?>

<div
	class="field field-name-body field-type-text-with-summary field-label-hidden">
<div class="field-items">
<div class="field-item even" property="content:encoded"><!--amit div class="toptitle">

                                <?php if(empty($_SESSION['CrmDisplayName'])){ ?>

                                <div class="tryNow" align="center"> Get a 30 Day Free Trial! No Credit Card Required. <br><br>
                                    <a href="register" title="Free Trail">Try Standard Package</a>
                                </div>
                                <?php } ?>
                                </div-->


<div class="planWrap clearfix" style="margin: auto !important"><!--.....plan-03 start......-->
                                <?php $pricePackage=getPackAndPriceById();
                                //echo "<pre>";print_r($pricePackage);
                                //die;

                                if(!empty($pricePackage)){
                                	foreach($pricePackage as $pricePackg){?>
<div class="plan">
<div class="head">
<h3><?php echo $pricePackg['name'];?></h3>
<p><?php echo $pricePackg['short_description'];?></p>
</div>
<div class="price">US <span>$<?php echo $pricePackg['price'];?> </span>
<p><?php echo $pricePackg['duration'];?></p>
</div>
<div class="feature"><?php echo $pricePackg['edition_features'];?> <span>plus</span></div>



<div class="des"><?php 

$arryDepart = unserialize($pricePackg['features']);

//echo "<pre>";print_r($arryDepart);die;


for($i=0;$i<sizeof($arryDepart);$i++){
	
	//echo strlen($arryDepart[$i]);

	if(strlen($arryDepart[$i])>1){
		$depId=6;

	}else{
		$depId=$arryDepart[$i];
	}

	$depName=getDepartNameById($depId);?>


<p align="left"><?php echo $depName;?></p>


<? 
if($depId==6){?>
	
<p align="left"><? echo "Warehouse";?></p>
<p align="left"><? echo "Purchasing";?></p>
<p align="left"><? echo "Sales";?></p>
<p align="left"><? echo "Finance";?></p>
<? } 


?>

	<? } ?></div>


	<?php
	if($pricePackg['id']==14){?>
<div class="more"><a href="#"></a></div>

<div class="tryNow"><a href="privateCloud" title="Buy Now">Buy Now</a></div>
	<?php } else { ?>

<div class="more"><a href="erp-comparison" title="Plan Details">Plan
Details</a></div>

<div class="tryNow"><?php if(!empty($_SESSION['CrmDisplayName'])){?> <a
	href="index.php?slug=upgrade&pack_id=<?php echo $pricePackg['id'];?>"
	title="Upgrage Now">Upgrage Now</a> <?php } else{ ?> <a
	href="index.php?slug=upgradeWTS&pack_id=<?php echo $pricePackg['id'];?>"
	title="Buy Now"> Buy Now</a> <?php } ?></div>
	<?php }?></div>
<!--end of class plan--> <?php } //end foreach loop
                                }
                                ?></div>


</div>

<div class="get-quote"><a href="price-quote" title="Get Quote">GET QUOTE</a>
</div>

</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</article></div>
</div>
</section>
<!--/div-->
