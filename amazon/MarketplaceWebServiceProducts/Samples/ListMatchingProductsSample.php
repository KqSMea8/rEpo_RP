<?php
/*******************************************************************************
 * Copyright 2009-2016 Amazon Services. All Rights Reserved.
 * Licensed under the Apache License, Version 2.0 (the "License"); 
 *
 * You may not use this file except in compliance with the License. 
 * You may obtain a copy of the License at: http://aws.amazon.com/apache2.0
 * This file is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR 
 * CONDITIONS OF ANY KIND, either express or implied. See the License for the 
 * specific language governing permissions and limitations under the License.
 *******************************************************************************
 * PHP Version 5
 * @category Amazon
 * @package  Marketplace Web Service Products
 * @version  2011-10-01
 * Library Version: 2015-09-01
 * Generated: Thu Mar 10 07:30:00 PST 2016
 */

/**
 * List Matching Products Sample
 */

require_once('.config.inc.php');

/************************************************************************
 * Instantiate Implementation of MarketplaceWebServiceProducts
 *
 * AWS_ACCESS_KEY_ID and AWS_SECRET_ACCESS_KEY constants
 * are defined in the .config.inc.php located in the same
 * directory as this sample
 ***********************************************************************/
// More endpoints are listed in the MWS Developer Guide
// North America:
//$serviceUrl = "https://mws.amazonservices.com/Products/2011-10-01";
// Europe
//$serviceUrl = "https://mws-eu.amazonservices.com/Products/2011-10-01";
// Japan
//$serviceUrl = "https://mws.amazonservices.jp/Products/2011-10-01";
// China
//$serviceUrl = "https://mws.amazonservices.com.cn/Products/2011-10-01";
$serviceUrl = "https://mws.amazonservices.ca/Products/2011-10-01";

 $config = array (
   'ServiceURL' => $serviceUrl,
   'ProxyHost' => null,
   'ProxyPort' => -1,
   'ProxyUsername' => null,
   'ProxyPassword' => null,
   'MaxErrorRetry' => 3,
 );

 $service = new MarketplaceWebServiceProducts_Client(
        AWS_ACCESS_KEY_ID,
        AWS_SECRET_ACCESS_KEY,
        APPLICATION_NAME,
        APPLICATION_VERSION,
        $config);

/************************************************************************
 * Uncomment to try out Mock Service that simulates MarketplaceWebServiceProducts
 * responses without calling MarketplaceWebServiceProducts service.
 *
 * Responses are loaded from local XML files. You can tweak XML files to
 * experiment with various outputs during development
 *
 * XML files available under MarketplaceWebServiceProducts/Mock tree
 *
 ***********************************************************************/
 // $service = new MarketplaceWebServiceProducts_Mock();

/************************************************************************
 * Setup request parameters and uncomment invoke to try out
 * sample for List Matching Products Action
 ***********************************************************************/
 // @TODO: set request. Action can be passed as MarketplaceWebServiceProducts_Model_ListMatchingProducts
 $request = new MarketplaceWebServiceProducts_Model_ListMatchingProductsRequest();
 $request->setSellerId(MERCHANT_ID);
 $request->setMarketplaceId(MARKETPLACE_ID);
 $request->setMWSAuthToken('amzn.mws.fca9b105-f4a4-d608-efd5-757773b54738');
 $request->setQuery('shirt');
 // object or array of parameters
 invokeListMatchingProducts($service, $request);

/**
  * Get List Matching Products Action Sample
  * Gets competitive pricing and related information for a product identified by
  * the MarketplaceId and ASIN.
  *
  * @param MarketplaceWebServiceProducts_Interface $service instance of MarketplaceWebServiceProducts_Interface
  * @param mixed $request MarketplaceWebServiceProducts_Model_ListMatchingProducts or array of parameters
  */

  function invokeListMatchingProducts(MarketplaceWebServiceProducts_Interface $service, $request)
  {
  
      try {
              $response = $service->listMatchingProducts($request);
              echo "<pre>";
                echo ("Service Response\n");
                echo ("=============================================================================\n");
                echo("        ListMatchingProductsResponse\n");
                if ($response->isSetListMatchingProductsResult()) { 
                    echo("            ListMatchingProductsResult\n");
                    $listMatchingProductsResult = $response->getListMatchingProductsResult();
                    if ($listMatchingProductsResult->isSetProducts()) { 
                        echo("                Products\n");
                        $products = $listMatchingProductsResult->getProducts();
                        $productList = $products->getProduct();
                        foreach ($productList as $product) {
                            echo("                    Product\n");
                            if ($product->isSetIdentifiers()) { 
                                echo("                        Identifiers\n");
                                $identifiers = $product->getIdentifiers();
                                if ($identifiers->isSetMarketplaceASIN()) { 
                                    echo("                            MarketplaceASIN\n");
                                    $marketplaceASIN = $identifiers->getMarketplaceASIN();
                                    if ($marketplaceASIN->isSetMarketplaceId()) 
                                    {
                                        echo("                                MarketplaceId\n");
                                        echo("                                    " . $marketplaceASIN->getMarketplaceId() . "\n");
                                    }
                                    if ($marketplaceASIN->isSetASIN()) 
                                    {
                                        echo("                                ASIN\n");
                                        echo("                                    " . $marketplaceASIN->getASIN() . "\n");
                                    }
                                } 
                                if ($identifiers->isSetSKUIdentifier()) { 
                                    echo("                            SKUIdentifier\n");
                                    $SKUIdentifier = $identifiers->getSKUIdentifier();
                                    if ($SKUIdentifier->isSetMarketplaceId()) 
                                    {
                                        echo("                                MarketplaceId\n");
                                        echo("                                    " . $SKUIdentifier->getMarketplaceId() . "\n");
                                    }
                                    if ($SKUIdentifier->isSetSellerId()) 
                                    {
                                        echo("                                SellerId\n");
                                        echo("                                    " . $SKUIdentifier->getSellerId() . "\n");
                                    }
                                    if ($SKUIdentifier->isSetSellerSKU()) 
                                    {
                                        echo("                                SellerSKU\n");
                                        echo("                                    " . $SKUIdentifier->getSellerSKU() . "\n");
                                    }
                                } 
                            } 
                            if ($product->isSetAttributeSets()) {
                                echo("  AttributeSets\n");                                
                                $attributeSets = $product->getAttributeSets();
                                if ($attributeSets->isSetAny()){
                                    $nodeList = $attributeSets->getAny();
                                    print_r($nodeList);
                                    //echo(prettyPrint($nodeList));                                      
                                }
                            }
                            if ($product->isSetRelationships()) {
                                echo("  Relationships\n");
                                $relationships = $product->getRelationships();
                                if ($relationships->isSetAny()){
                                    $nodeList = $relationships->getAny();
                                    echo(prettyPrint($nodeList));
                                   // print_r($nodeList);
                                }
                            }
                            
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
     } catch (MarketplaceWebServiceProducts_Exception $ex) {
         echo("Caught Exception: " . $ex->getMessage() . "\n");
         echo("Response Status Code: " . $ex->getStatusCode() . "\n");
         echo("Error Code: " . $ex->getErrorCode() . "\n");
         echo("Error Type: " . $ex->getErrorType() . "\n");
         echo("Request ID: " . $ex->getRequestId() . "\n");
         echo("XML: " . $ex->getXML() . "\n");
         echo("ResponseHeaderMetadata: " . $ex->getResponseHeaderMetadata() . "\n");
     }
 }
 
 function prettyPrint($nodeList)
 { $i=0;
 	foreach ($nodeList as $domNode){ $i++;
 		$domDocument =  new DOMDocument();
 		$domDocument->preserveWhiteSpace = false;
 		$domDocument->formatOutput = true;
 		$nodeStr = $domDocument->saveXML($domDocument->importNode($domNode,true));
 		echo($nodeStr."".$i);
 		//echo "fg";
 	}
 }
