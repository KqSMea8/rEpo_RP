<?php

	 class USPS
	{
		private $user_id = null;
 		private $post_url = "http://production.shippingapis.com/ShippingAPI.dll";
                
 		function __construct( $uid )
 		{
 			$this->user_id = $uid;
 		}

 		

		/**************************************************************************************
			Track Package

			ex.

			$usps->TrackPackage("12345678908776543221"); // Tracking number

		**************************************************************************************/

		function TrackPackage($trackingnum)
 		{
 			$tracking_num = $trackingnum;
			 $returnArray = array();
 			$detailsArray = array();

 			// create xml
 			$xml = self::CreateTrackingXML($tracking_num);

 			// send to usps
 			$post_response = self::SendToUSPS($xml);
                       // echo "<pre>";print_r($post_response);exit;
 			// convert xml

                       
                       $xml_response = self::xml_to_array($post_response);

 			//$xml_response = self::ConvertXMLToArray($post_response);
                       //echo "<pre>";print_r($xml_response);exit;
 			/*foreach($xml_response as $index)
 			{
 				if($index["tag"] == "TRACKSUMMARY")
 				{
 					$returnArray["TRACKSUMMARY"] = $index["value"];
				 }

                                 if($index["tag"] == "EVENTCODE")
 				{
 					$returnArray["EVENTCODE"] = $index["value"];
				 }

 				if($index["tag"] == "TRACKDETAIL")
 				{
					 array_push($detailsArray, $index["value"]);
 				}
			 }

 			$returnArray["details"] = $detailsArray;*/

			return $xml_response;

 		}


		private function xml_to_array($post_response,$main_heading = '') 
		{
		    $deXml = simplexml_load_string($post_response);
		    $deJson = json_encode($deXml);
		    $xml_array = json_decode($deJson,TRUE);
		    if (! empty($main_heading)) {
			$returned = $xml_array[$main_heading];
			return $returned;
		    } else {
			return $xml_array;
		    }
		}


 		private function CreateTrackingXML($tracking_num)
		 {
                        
 			$xml = 'API=TrackV2&XML=<TrackFieldRequest USERID="'.$this->user_id.'">
                        <Revision>1</Revision>
                        <ClientIp>127.0.0.1</ClientIp>
                        <SourceId>Rajeev</SourceId>
 			<TrackID ID="'.$tracking_num.'"></TrackID>
                       
 			</TrackFieldRequest>';

			//$xml = "API=TrackV2&XML=&lt;TrackRequest USERID="'.$this->user_id.'"&gt;&lt;TrackID ID="'.$tracking_num.'"&gt;&lt;/TrackID&gt;&lt;/TrackRequest&gt;";

 			return $xml;
 		}

 		private function SendToUSPS($xml)
 		{ 
 			$request = curl_init( $this->post_url );
			
			//echo "PRINT XML -> ".$xml."<br><br>";

 			curl_setopt( $request, CURLOPT_HEADER, 0 );
 			curl_setopt( $request, CURLOPT_RETURNTRANSFER, 1 );
 			curl_setopt( $request, CURLOPT_POSTFIELDS, $xml );
 			curl_setopt( $request, CURLOPT_SSL_VERIFYPEER, FALSE ); 

 			$post_response = curl_exec( $request ); 

 			curl_close ($request);

 			return $post_response;
 		}

 		
 	}

?>
