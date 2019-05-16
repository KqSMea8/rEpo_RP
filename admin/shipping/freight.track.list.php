<?php
$HideNavigation = 1;
/**************************************************/
$ThisPageName = 'editReturn.php';
/**************************************************/
include_once("../includes/header.php");

    require_once 'fedex.settings.php';
    require_once 'classes/class.fedex.php';
    require_once 'classes/class.fedex.track.php';
    if(isset($_POST['Submit'])){
    	
     $objTrack = new fedexTrack();
    $objTrack->requestType("track");
    $objTrack->wsdl_root_path = "wsdl-test/";
    $client = new SoapClient($objTrack->wsdl_root_path.$objTrack->wsdl_path, array('trace' => 1));
    $request = $objTrack->trackRequest("781117275082");

    try 
    {
        if($objTrack->setEndpoint('changeEndpoint'))
        {
            $newLocation = $client->__setLocation(setEndpoint('endpoint'));
        }

        $response = $client->track($request);

        if ($response->HighestSeverity != 'FAILURE' && $response->HighestSeverity != 'ERROR') 
        {
            //success
            
            echo $response->TrackDetails->StatusDescription;
            
            echo "<pre>";
           print_r($response);
            echo "</pre>";
        } 
        else 
        {
            echo $objTrack->showResponseMessage($response);
            
            echo "<pre>";
            print_r($response);
            echo "</pre>";
        }

    } 
    catch (SoapFault $exception) 
    {
        echo $objTrack->requestError($exception, $client);

        echo "<pre>";
        print_r($response);
        echo "</pre>";
    }
    	
    	
    	
    }
    
echo $response->HighestSeverity.'hhh';
  
require_once("../includes/footer.php");
?>


