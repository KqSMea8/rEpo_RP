<?php
/** 
 *  PHP Version 5
 *
 *  @category    Amazon
 *  @package     MarketplaceWebService
 *  @copyright   Copyright 2009 Amazon Technologies, Inc.
 *  @link        http://aws.amazon.com
 *  @license     http://aws.amazon.com/apache2.0  Apache License, Version 2.0
 *  @version     2009-01-01
 */
/******************************************************************************* 

 *  Marketplace Web Service PHP5 Library
 *  Generated: Thu May 07 13:07:36 PDT 2009
 * 
 */

/**
 * Submit Feed  Sample
 */
//echo phpinfo();
//echo ini_set('display_errors','1');
include_once ('.config.inc.php'); 

/*$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://mws.amazonservices.ca');
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$data = curl_exec($ch);
curl_close($ch); 
print_r($data);die;*/
/************************************************************************
* Uncomment to configure the client instance. Configuration settings
* are:
*
* - MWS endpoint URL
* - Proxy host and port.
* - MaxErrorRetry.
***********************************************************************/
// IMPORTANT: Uncomment the approiate line for the country you wish to
// sell in:
// United States:
//$serviceUrl = "https://mws.amazonservices.com";
// United Kingdom
//$serviceUrl = "https://mws.amazonservices.co.uk";
// Germany
//$serviceUrl = "https://mws.amazonservices.de";
// France
//$serviceUrl = "https://mws.amazonservices.fr";
// Italy
//$serviceUrl = "https://mws.amazonservices.it";
// Japan
//$serviceUrl = "https://mws.amazonservices.jp";
// China
//$serviceUrl = "https://mws.amazonservices.com.cn";
// Canada
$serviceUrl = "https://mws.amazonservices.ca";
// India
//$serviceUrl = "https://mws.amazonservices.in";

$config = array (
  'ServiceURL' => $serviceUrl,
  'ProxyHost' => null,
  'ProxyPort' => -1,
  'MaxErrorRetry' => 3,
);

/************************************************************************
 * Instantiate Implementation of MarketplaceWebService
 * 
 * AWS_ACCESS_KEY_ID and AWS_SECRET_ACCESS_KEY constants 
 * are defined in the .config.inc.php located in the same 
 * directory as this sample
 ***********************************************************************/
 $service = new MarketplaceWebService_Client(
     AWS_ACCESS_KEY_ID, 
     AWS_SECRET_ACCESS_KEY, 
     $config,
     APPLICATION_NAME,
     APPLICATION_VERSION);
 
/************************************************************************
 * Uncomment to try out Mock Service that simulates MarketplaceWebService
 * responses without calling MarketplaceWebService service.
 *
 * Responses are loaded from local XML files. You can tweak XML files to
 * experiment with various outputs during development
 *
 * XML files available under MarketplaceWebService/Mock tree
 *
 ***********************************************************************/
  //$service = new MarketplaceWebService_Mock();

/************************************************************************
 * Setup request parameters and uncomment invoke to try out 
 * sample for Submit Feed Action
 ***********************************************************************/
 // @TODO: set request. Action can be passed as MarketplaceWebService_Model_SubmitFeedRequest
 // object or array of parameters

// Note that PHP memory streams have a default limit of 2M before switching to disk. While you
// can set the limit higher to accomidate your feed in memory, it's recommended that you store
// your feed on disk and use traditional file streams to submit your feeds. For conciseness, this
// examples uses a memory stream.

     
/* foreach loop php 
<<<EOD
<?xml version="1.0"?>
<AmazonEnvelope xsi:noNamespaceSchemaLocation="amzn-envelope.xsd" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
  <Header>
    <DocumentVersion>1.01</DocumentVersion>
    <MerchantIdentifier>XXMYMERCHANTXX</MerchantIdentifier>
  </Header>
  <MessageType>Product</MessageType>
EOD;
foreach($skus as $k => $v) {
$feed = $feed . <<<EOD

  <Message>
    <MessageID>$count</MessageID>
    <OperationType>Delete</OperationType>
    <Product>
      <SKU>$k</SKU>
    </Product>
  </Message>
EOD;
$count++;
}
$feed = $feed . <<<EOD
</AmazonEnvelope>
EOD;
*/


$feed = <<<EOD
<?xml version="1.0" ?>
<AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="amzn-envelope.xsd">
<Header>
<DocumentVersion>1.01</DocumentVersion>
<MerchantIdentifier>A1480XNN341KYN</MerchantIdentifier>
</Header>
<MessageType>Product</MessageType>
<PurgeAndReplace>false</PurgeAndReplace>
<Message>
<MessageID>1</MessageID>
<OperationType>Update</OperationType>
<Product><SKU>AAAAA</SKU>
<StandardProductID><Type>ASIN</Type>
<Value>B00BJ7EFMW</Value></StandardProductID>
<ProductTaxCode>A_GEN_TAX</ProductTaxCode>
<LaunchDate>2013-04-02T00:00:01</LaunchDate>
<DescriptionData>
<Title>West Paw Design Bumper Dog Stuffed Couch Bed - Extra Small, Slate / Monaco</Title>
<Brand>West Paw Design</Brand>
<Description>Presenting the most popular Bumper Dog Bed This popular dog bed provides the comfort and cushion that your dog deserves while providing you with the versatility to find the color combination which fits your home decor. Simply select from among the 7 colors for the outer bumper (bolster), then determine which color you need for the inside center cushion. You might pick the same color for a traditional solid color look - or change things up and provide your pet bed some energy with the addition of another color, a stripe, or perhaps a pattern. Need assistance selecting the best color combination - see our designer top choices. An ideal mixture of country living and city dwelling. Wherever your pet calls home, they're going to have an ideal night's rest or perhaps an enjoyable mid-day nap when laying on the memory foam Bumper Bed. Each dog bed is stuffed with our thick denier 100% recycled IntelliLoft polyfill, making the bed a paradise of cushions that won't bunch or flatten from substantial use. Our twill fabric was carefully selected because of its sturdiness and it is brushed for additional gentleness. Zippered opening and machine washable cover means easy maintenance. Made in the USA.</Description><BulletPoint>For Dogs 10 lbs and Under. Outside Dimensions: 18" x 16" x 6".</BulletPoint><BulletPoint>Inside Dimensions: 11" x 8". Poly/Cotton blend.</BulletPoint><BulletPoint>Diagonal ridges for texture and Strength.</BulletPoint><BulletPoint>Softly brushed for added softness.</BulletPoint><BulletPoint>Machine wash cool / Tumble dry on low.</BulletPoint><ItemDimensions>
<Length unitOfMeasure="IN">8</Length>
<Width unitOfMeasure="IN">12</Width>
<Height unitOfMeasure="IN">17</Height>
<Weight unitOfMeasure="LB">3.00</Weight>
</ItemDimensions><PackageDimensions>
<Length unitOfMeasure="IN">9</Length>
<Width unitOfMeasure="IN">13</Width>
<Height unitOfMeasure="IN">18</Height>
</PackageDimensions> <PackageWeight unitOfMeasure="LB">4.00</PackageWeight> <ShippingWeight unitOfMeasure="LB">4.00</ShippingWeight><Manufacturer>West Paw Design</Manufacturer>
<MfrPartNumber>WPD-K0915SLTMNC</MfrPartNumber>
<SearchTerms>large dog bed, dog bed large, dog toys</SearchTerms>
<SearchTerms>pet supplies, dog couch, dog cot, pet couch</SearchTerms>
<SearchTerms>dog bed covers, dog loungers, dog sofas, pet beds</SearchTerms>
<SearchTerms>dog supplies, dog furniture, dog pillows</SearchTerms>
<SearchTerms>doggie beds, dog mattress, dog beds</SearchTerms>
<UsedFor>Suitable for Young pets</UsedFor>
<UsedFor>Suitable for Adult pets</UsedFor>
<UsedFor>Daily Use</UsedFor>
<UsedFor>Indoor</UsedFor>
<ItemType>Beds</ItemType>
<OtherItemAttributes>Beds</OtherItemAttributes>
<OtherItemAttributes>Portable</OtherItemAttributes>
<OtherItemAttributes>Furniture</OtherItemAttributes>
<OtherItemAttributes>Home</OtherItemAttributes>
<TargetAudience>dog</TargetAudience>
<TargetAudience>Pets</TargetAudience>
<SubjectContent>Pet Bed</SubjectContent>
<SubjectContent>Pet Supplies</SubjectContent>
<SubjectContent>Cushion Bed</SubjectContent>
<SubjectContent>Bumper Dog Bed</SubjectContent></DescriptionData>
<ProductData><PetSupplies>
<ProductType>
<PetSuppliesMisc><ColorSpecification><Color>brown</Color><ColorMap>Black</ColorMap></ColorSpecification><Size>Extra Small</Size><SizeMap>XL</SizeMap>
<SpecialFeatures>easy to clean</SpecialFeatures></PetSuppliesMisc>
</ProductType>
</PetSupplies>
</ProductData></Product>
</Message>
</AmazonEnvelope>
EOD;

     
// for delete product
/*$feed = <<<EOD
<?xml version="1.0"?>
<AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="amzn-envelope.xsd">
<Header>
<DocumentVersion>1.01</DocumentVersion>
<MerchantIdentifier>A1480XNN341KYN</MerchantIdentifier>
</Header>
<MessageType>Product</MessageType>
<Message>
<MessageID>1</MessageID>
<OperationType>Delete</OperationType>
<Product>
<SKU>AAAAA</SKU>
</Product>
</Message>
</AmazonEnvelope>
EOD;
*/

// Constructing the MarketplaceId array which will be passed in as the the MarketplaceIdList 
// parameter to the SubmitFeedRequest object.
$marketplaceIdArray = array("Id" => array('A2EUQ1WTGCTBG2'));
     
 // MWS request objects can be constructed two ways: either passing an array containing the 
 // required request parameters into the request constructor, or by individually setting the request
 // parameters via setter methods.
 // Uncomment one of the methods below.
 
/********* Begin Comment Block *********/

/*$feedHandle = @fopen('php://temp', 'rw+');
fwrite($feedHandle, $feed);
rewind($feedHandle);
$parameters = array (
  'Merchant' => MERCHANT_ID,
  'MarketplaceIdList' => $marketplaceIdArray,
  'FeedType' => '_POST_ORDER_FULFILLMENT_DATA_',
  'FeedContent' => $feedHandle,
  'PurgeAndReplace' => false,
  'ContentMd5' => base64_encode(md5(stream_get_contents($feedHandle), true)),
  'MWSAuthToken' => 'amzn.mws.aca9678e-6579-d68c-bbeb-03f2c5747d00', // Optional
);

rewind($feedHandle);

$request = new MarketplaceWebService_Model_SubmitFeedRequest($parameters);*/
/********* End Comment Block *********/

/********* Begin Comment Block *********/
$feedHandle = @fopen('php://memory', 'rw+');
fwrite($feedHandle, $feed);
rewind($feedHandle);

$request = new MarketplaceWebService_Model_SubmitFeedRequest();
$request->setMerchant(MERCHANT_ID);
$request->setMarketplaceIdList($marketplaceIdArray);
$request->setFeedType('_POST_PRODUCT_DATA_');
$request->setContentMd5(base64_encode(md5(stream_get_contents($feedHandle), true)));
rewind($feedHandle);
$request->setPurgeAndReplace(false);
$request->setFeedContent($feedHandle);
$request->setMWSAuthToken('amzn.mws.aca9678e-6579-d68c-bbeb-03f2c5747d00'); // Optional

rewind($feedHandle);
/********* End Comment Block *********/
echo "<pre>";
//print_r($request);die;
invokeSubmitFeed($service, $request);

@fclose($feedHandle);
                                        
/**
  * Submit Feed Action Sample
  * Uploads a file for processing together with the necessary
  * metadata to process the file, such as which type of feed it is.
  * PurgeAndReplace if true means that your existing e.g. inventory is
  * wiped out and replace with the contents of this feed - use with
  * caution (the default is false).
  *   
  * @param MarketplaceWebService_Interface $service instance of MarketplaceWebService_Interface
  * @param mixed $request MarketplaceWebService_Model_SubmitFeed or array of parameters
  */
  function invokeSubmitFeed(MarketplaceWebService_Interface $service, $request) 
  {
  	 $response = $service->submitFeed($request);
  	//print_r($response);die;
      try {
              $response = $service->submitFeed($request);
              
                echo ("Service Response\n");
                echo ("=============================================================================\n");

                echo("        SubmitFeedResponse\n");
                if ($response->isSetSubmitFeedResult()) { 
                    echo("            SubmitFeedResult\n");
                    $submitFeedResult = $response->getSubmitFeedResult();
                    if ($submitFeedResult->isSetFeedSubmissionInfo()) { 
                        echo("                FeedSubmissionInfo\n");
                        $feedSubmissionInfo = $submitFeedResult->getFeedSubmissionInfo();
                        if ($feedSubmissionInfo->isSetFeedSubmissionId()) 
                        {
                            echo("                    FeedSubmissionId\n");
                            echo("                        " . $feedSubmissionInfo->getFeedSubmissionId() . "\n");
                        }
                        if ($feedSubmissionInfo->isSetFeedType()) 
                        {
                            echo("                    FeedType\n");
                            echo("                        " . $feedSubmissionInfo->getFeedType() . "\n");
                        }
                        if ($feedSubmissionInfo->isSetSubmittedDate()) 
                        {
                            echo("                    SubmittedDate\n");
                            echo("                        " . $feedSubmissionInfo->getSubmittedDate()->format(DATE_FORMAT) . "\n");
                        }
                        if ($feedSubmissionInfo->isSetFeedProcessingStatus()) 
                        {
                            echo("                    FeedProcessingStatus\n");
                            echo("                        " . $feedSubmissionInfo->getFeedProcessingStatus() . "\n");
                        }
                        if ($feedSubmissionInfo->isSetStartedProcessingDate()) 
                        {
                            echo("                    StartedProcessingDate\n");
                            echo("                        " . $feedSubmissionInfo->getStartedProcessingDate()->format(DATE_FORMAT) . "\n");
                        }
                        if ($feedSubmissionInfo->isSetCompletedProcessingDate()) 
                        {
                            echo("                    CompletedProcessingDate\n");
                            echo("                        " . $feedSubmissionInfo->getCompletedProcessingDate()->format(DATE_FORMAT) . "\n");
                        }
                    } 
                } 
                if ($response->isSetResponseMetadata()) { 
                    echo("            ResponseMetadata\n");
                    $responseMetadata = $response->getResponseMetadata();
                    if ($responseMetadata->isSetRequestId()) 
                    {
                        echo("                RequestId\n");
                        echo("                    " . $responseMetadata->getRequestId() . "\n");
                    }
                } 

                echo("            ResponseHeaderMetadata: " . $response->getResponseHeaderMetadata() . "\n");
     } catch (MarketplaceWebService_Exception $ex) {
         echo("Caught Exception: " . $ex->getMessage() . "\n");
         echo("Response Status Code: " . $ex->getStatusCode() . "\n");
         echo("Error Code: " . $ex->getErrorCode() . "\n");
         echo("Error Type: " . $ex->getErrorType() . "\n");
         echo("Request ID: " . $ex->getRequestId() . "\n");
         echo("XML: " . $ex->getXML() . "\n");
         echo("ResponseHeaderMetadata: " . $ex->getResponseHeaderMetadata() . "\n");
     }
 }
                                                                
