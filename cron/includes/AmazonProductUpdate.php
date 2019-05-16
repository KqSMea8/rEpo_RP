<?php 
$arryProduct = $objProduct->GetProductEdit($parameters['ProductID']);
$productAmazonData = $objProduct->getAmazonData($parameters['ProductID'],'amazon');
$MaxProductImageArr = $objProduct->GetAlternativeImage($parameters['ProductID']); 
$ProductSku = $arryProduct[0]['ProductSku'];
$Amazonservice = $objProduct->AmazonSettings($Prefix, false, $productAmazonData[0]['AmazonAccountID']);

			     
/******************************* Add/Update Image ******************************************/
$Imagefeed = '<?xml version="1.0" encoding="utf-8" ?>
<AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="amzn-
envelope.xsd">
<Header>
	<DocumentVersion>1.01</DocumentVersion>
	<MerchantIdentifier>'.$objProduct->MERCHANT_ID.'</MerchantIdentifier>
</Header>
<MessageType>ProductImage</MessageType>';
if($arryProduct[0]['Image']){
$Imagefeed .= '<Message>
	<MessageID>1</MessageID>
	<OperationType>Update</OperationType>
	<ProductImage>
		<SKU>'.$ProductSku.'</SKU>
		<ImageType>Main</ImageType>
		<ImageLocation>https://wallpaperscraft.com/image/tree_leaves_fog_light_purple_autumn_94147_1600x1200.jpg</ImageLocation>
	</ProductImage>
</Message>
<Message>';
}
if(!empty($MaxProductImageArr)){
	$i=1;
	foreach($MaxProductImageArr as $ImageArr){
		$i++;
	  $Imagefeed .='<MessageID>'.$i.'</MessageID> 
	  <OperationType>Update</OperationType> 
	  <ProductImage>
		  <SKU>'.$ProductSku.'</SKU> 
		  <ImageType>PT'.($i-1).'</ImageType> 
		  <ImageLocation>http://199.227.27.197/erp/upload/products/images/secondary/37/LN-T4665F_4.jpg</ImageLocation> 
	  </ProductImage>
	</Message>';
	}
}	
$Imagefeed .='</AmazonEnvelope>';		
if($Amazonservice)
$objProduct->CreateAmazonProduct($Imagefeed, $Amazonservice, '_POST_PRODUCT_IMAGE_DATA_','update');	
echo '1-->';

/********************************UPDATE/ADD INVENTORY *****************************************/
$Invfeed = '<?xml version="1.0" encoding="utf-8" ?>
<AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="amzn-
envelope.xsd">
<Header>
	<DocumentVersion>1.01</DocumentVersion>
	<MerchantIdentifier>'.$objProduct->MERCHANT_ID.'</MerchantIdentifier>
</Header>
<MessageType>Inventory</MessageType>
<Message>
  <MessageID>1</MessageID> 
  <OperationType>Update</OperationType>
  <Inventory>
	  <SKU>'.$ProductSku.'</SKU>  
	  <Quantity>'.$productAmazonData[0]['Quantity'].'</Quantity> 
	  <FulfillmentLatency>1</FulfillmentLatency> 
  </Inventory>
</Message>
</AmazonEnvelope>';

if($Amazonservice)
$objProduct->CreateAmazonProduct($Invfeed, $Amazonservice, '_POST_INVENTORY_AVAILABILITY_DATA_','update');
echo '2-->';
/********************************UPDATE/ADD PRICE *****************************************/
$Pricefeed = '<?xml version="1.0" encoding="utf-8" ?>
<AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="amzn-envelope.xsd">
<Header>
	<DocumentVersion>1.01</DocumentVersion>
	<MerchantIdentifier>'.$objProduct->MERCHANT_ID.'</MerchantIdentifier>
</Header>
<MessageType>Price</MessageType>
<Message>
  <MessageID>1</MessageID> 
  <Price>
	<SKU>'.$ProductSku.'</SKU>
	<StandardPrice currency="'.$Config['Currency'].'">'.$productAmazonData[0]['Price'].'</StandardPrice>
  </Price>
</Message>
</AmazonEnvelope>';

$objProduct->AccountID=$productAmazonData[0]['AmazonAccountID'];
if($Amazonservice)
$objProduct->CreateAmazonProduct($Pricefeed, $Amazonservice, '_POST_PRODUCT_PRICING_DATA_','update');
echo '3';

/*
 <Sale>
 <StartDate>'.$productAmazonData[0]['SaleStartDate'].'T00:00:01</StartDate>
 <EndDate>'.$productAmazonData[0]['SaleEndDate'].'T00:00:01</EndDate>
 <SalePrice currency="'.$Config['Currency'].'">'.$productAmazonData[0]['Price2'].'</SalePrice>
 </Sale>
 */
?>
