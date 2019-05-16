<?php

/****************Header*********************************************/

function create_ISA($X12info)
{

	$segTer = ":~";
	$compEleSep = "*";

	$ISA     =  array();

	$ISA[0] = "ISA";

	$ISA[1] = "03";  //Additional Data Identification

	$ISA[2] = str_pad($X12info['USPPI'], 10);  //USPPI

	$ISA[3] = "01";  //Security Information Qualifier

	$ISA[4] = str_pad("", 10, " ");  //Security Information

	$ISA[5] = "01"; //Interchange ID Qualifier

	$ISA[6] = str_pad($X12info['USPPI'], 15, " "); //Interchange ID Qualifier

	$ISA[7] = "ZZ"; //Interchange ID Qualifier

	$ISA[8] = str_pad("USCSAESTEST", 15, " "); //Interchange Receiver ID

	$ISA[9] = str_pad($X12info['InterchangeDate'], 6, " ");       // Interchange Date (YYMMDD)

	$ISA[10] = str_pad(date('Hi'), 4, " ");       // Interchange Time (HHMM)

	$ISA[11] = "^"; //Transmission time

	$ISA[12] = $X12info['Version']; //Interchange Control Version Number

	$ISA[13] = $X12info['InterchangeControlNumber']; //Interchange Control Number

	$ISA[14] = "0"; //Acknowledgment Requested

	$ISA[15] = "T"; //Interchange Usage Indicator

	$ISA['Created'] = implode('*', $ISA);       // Data Element Separator

	$ISA['Created'] = $ISA['Created'];

	$ISA['Created'] = $ISA ['Created'] . $compEleSep . $segTer;

	return trim($ISA['Created']);
}

function create_GS($X12info)
{
	$segTer = "~";
	$compEleSep = "*";

	$GS    = array();

	$GS[0] = "GS";                      // Functional Group Header Segment ID

	$GS[1] = "SE"; 						// SE Shipper's Export Declaration (601)

	$GS[2] =  $X12info['USPPI'];              // Application Sender's Code ISA06.

	$GS[3] =  "USCSAESTEST";              // Application Receiver's ID

	$GS[4] = $X12info['Date'];               // Date [CCYYMMDD]

	$GS[5] = str_pad(date('His'), 7);       // Time [HHMM] Group Creation Time

	$GS[6] = $X12info['GroupControl'];                       // Group Control Number No zeros for 5010

	$GS[7] = "X";                   // Responsible Agency Code Accredited Standards Committee X12 ]

	$GS[8] = $X12info['Version'];            // Version Release / Industry[ Identifier Code Query 005010X279A1

	$GS['Created'] = implode('*', $GS);         // Data Element Separator

	$GS['Created'] = $GS ['Created'] . $segTer;  // change the information in the tag or change the tag

	return trim($GS['Created']);
}


function create_ST($X12info)
{

	$segTer = "~";
	$compEleSep = "*";

	$ST    =    array();

	$ST[0] = "ST";                              // Transaction Set Header Segment ID

	$ST[1] = "601";                   //601 Customs & Border Protection (CBP) Export Shipment Information.

	$ST[2] = $X12info['SESTTransactionSet'];   // Transaction Set Control Number - Must match SE's

	$ST['Created'] = implode('*', $ST);             // Data Element Separator

	$ST['Created'] = $ST ['Created'] . $segTer;

	return trim($ST['Created']);
}


function create_BA1($X12info)
{

	//BA1
	$segTer = "~";

	$BA1    =   array();

	$BA1[0] = "BA1";                        // Beginning of Hierarchical Transaction Segment ID

	$BA1[1] = $X12info['CompanyIndication']; //Related Company Indication Code

	$BA1[2] = $X12info['ActionCode'];   //Action Code
	 
	$BA1[3] = $X12info['TransportationMethod']; //Transportation Method/Type Code

	$BA1[4] = $X12info['CountryDestinationCode'];//Country Code

	$BA1[5] = $X12info['ShipmentReferenceNo'];//Reference Identification

	$BA1[6] = $X12info['ZipCodeOfOrigin'];//Postal Code

	$BA1[7] = $X12info['CountryCodeOfOrigin'];//Country Code

	$BA1[8] = $X12info['StateCodeOfOrigin'];//$BA1[8] = "ABCD";//State or Province Code

	$BA1[9] = $X12info['Authority'];//Authority

	$BA1[10] = $X12info['CarrierAlphaCode'];//Standard Carrier Alpha Code

	$BA1[11] = $X12info['LocationIdentifier'];//Location Identifier

	$BA1[12] = strtoupper($X12info['ExportingCareer']);//Vessel Name

	$BA1['Created'] = implode('*', $BA1);           // Data Element Separator

	$BA1['Created'] = $BA1 ['Created'] . $segTer;

	return trim($BA1['Created']);
}



function create_YNQ1($X12info)
{
	//YNQ Yes/No Question
	$segTer = "~";

	$YNQ1    =   array();

	$YNQ1[0] = "YNQ";                        // Beginning of Hierarchical Transaction Segment ID

	$YNQ1[1] = strtoupper($X12info['HAZMAT1']); //HAZARDOUS MATERIAL INDICATOR (HAZMAT) RZ QQ RX R3P R3F B

	$YNQ1[2] = strtoupper($X12info['HAZMATResponseCode1']); //Yes/No Condition or Response Code

	$YNQ1['Created'] = implode('*', $YNQ1);           // Data Element Separator

	$YNQ1['Created'] = $YNQ1 ['Created'] . $segTer;

	return trim($YNQ1['Created']);
}


function create_YNQ2($X12info)
{
	//YNQ Yes/No Question
	$segTer = "~";

	$YNQ1    =   array();

	$YNQ1[0] = "YNQ";                        // Beginning of Hierarchical Transaction Segment ID

	$YNQ1[1] = strtoupper($X12info['HAZMAT2']); //HAZARDOUS MATERIAL INDICATOR (HAZMAT) RZ QQ RX R3P R3F B

	$YNQ1[2] = strtoupper($X12info['HAZMATResponseCode2']); //Yes/No Condition or Response Code

	$YNQ1['Created'] = implode('*', $YNQ1);           // Data Element Separator

	$YNQ1['Created'] = $YNQ1 ['Created'] . $segTer;

	return trim($YNQ1['Created']);
}

function create_DTM($X12info)
{
		
	//DTM Date/Time Reference
	$segTer = "~";

	$DTM    =   array();

	$DTM[0] = "DTM";                        // Beginning of Hierarchical Transaction Segment ID

	$DTM[1] = $X12info['RequestedDepartureDate']; //Requested Departure Date

	$DTM[2] = str_pad($X12info['Date'], 6, " "); //Date

	$DTM['Created'] = implode('*', $DTM);           // Data Element Separator

	$DTM['Created'] = $DTM ['Created'] . $segTer;

	return trim($DTM['Created']);
}


function create_P5($X12info)
{

	//P5 Port Function
	$segTer = "~";

	$P5    =   array();

	$P5[0] = "P5";                        // Beginning of Hierarchical Transaction Segment ID

	$P5[1] = $X12info['PortFunctionCode']; //Port or Terminal Function Code

	$P5[2] = $X12info['LocationQualifie']; //Location Qualifier

	$P5[3] = $X12info['LocationIdentifierCode']; //Location Identifier

	$P5['Created'] = implode('*', $P5);           // Data Element Separator

	$P5['Created'] = $P5 ['Created'] . $segTer;

	return trim($P5['Created']);
}

function create_REF($X12info)
{

	//REF Reference Information
	$segTer = "~";

	$P5    =   array();

	$P5[0] = "REF";                        // Beginning of Hierarchical Transaction Segment ID

	$P5[1] = $X12info['ReferenceIdQualifier']; //Reference Identification Qualifier

	$P5[2] = $X12info['ReferenceIdentifier']; //Reference Identification Qualifier

	$P5[3] = $X12info['ReferenceDescription'];

	$P5[4] = $X12info['ReferenceIdentifier'];

	$P5[5] = $X12info['ReferenceIdentifier'];

	$P5[6] = $X12info['ReferenceIdentifier'];

	$P5['Created'] = implode('*', $P5);           // Data Element Separator

	$P5['Created'] = $P5 ['Created'] . $segTer;

	return trim($P5['Created']);
}

function create_M12($X12info)
{


	//M12 In-bond Identifying Information
	$segTer = "~";

	$P5    =   array();

	$P5[0] = "M12";                        // Beginning of Hierarchical Transaction Segment ID

	$P5[1] = $X12info['CBPEntryType'];//Customs and Border Protection (CBP) Entry Type

	$P5[2] = $X12info['CBPEntryNumber']; //Customs and Border Protection (CBP) Entry Number

	$P5[3] = $X12info['LocationIdentifierM']; //ROUTED EXPORT TRANSACTION INDICATOR

	$P5[4] = $X12info['ROUTEDEXPORTRANSACTION']; //ROUTED EXPORT TRANSACTION INDICATOR

	$P5['Created'] = implode('*', $P5);           // Data Element Separator

	$P5['Created'] = $P5 ['Created'] . $segTer;

	return trim($P5['Created']);
}

function create_shiping_N1($X12info)
{

	$segTer = "~";

	$SN1    =   array();

	$SN1[0] = "N1";                        // Beginning of Hierarchical Transaction Segment ID

	$SN1[1] = strtoupper($X12info['UltimateConsignee']); //Entity Identifier Code

	$SN1[2] =  str_pad(strtoupper('W.W. ACE'), 9, " ");  // PARTY NAME and USPPI NAME

	$SN1[3] = $X12info['EIN'];//Identification Code Qualifier

	$SN1[4] =  '12345678900';//$X12info['USPPI'];//Identification Code Qualifier

	$SN1['Created'] = implode('*', $SN1);           // Data Element Separator

	$SN1['Created'] = $SN1 ['Created'] . $segTer;

	return trim($SN1['Created']);

}

function create_shiping_N2($X12info)
{

	$segTer = "~";

	$SN2    =   array();

	$SN2[0] = "N2"; // Beginning of Hierarchical Transaction Segment ID

	$SN2[1] = strtoupper($X12info['CompanyFrom']);//Company contact title and/or first name, and last name.

	$SN2[2] = str_pad($X12info['PhoneFrom'], 13, " ");// CONTACT PHONE NUMBER

	$SN2['Created'] = implode('*', $SN2);           // Data Element Separator

	$SN2['Created'] = $SN2 ['Created'] . $segTer;

	return trim($SN2['Created']);

}


function create_shiping_N3($X12info)
{
		
	$segTer = "~";

	$SN3    =   array();

	$SN3[0] = "N3";                        // Beginning of Hierarchical Transaction Segment ID

	$SN3[1] = strtoupper($X12info['Address1From']); //Address Information ADDRESS LINE 1

	$SN3['Created'] = implode('*', $SN3);           // Data Element Separator

	$SN3['Created'] = $SN3 ['Created'] . $segTer;

	return trim($SN3['Created']);

}


function create_shiping_N4($X12info)
{

	$segTer = "~";

	$SN4    =   array();

	$SN4[0] = "N4";                        // Beginning of Hierarchical Transaction Segment ID

	$SN4[1] = strtoupper($X12info['CityFrom']); //City Name

	$SN4[2] = strtoupper($X12info['StateFrom']); //State or Province Code

	$SN4[3] = strtoupper($X12info['ZipFrom']); //Postal Code

	$SN4[4] = strtoupper($X12info['CountryFrom']); //Country Code

	$SN4['Created'] = implode('*', $SN4);           // Data Element Separator

	$SN4['Created'] = $SN4 ['Created'] . $segTer;

	return trim($SN4['Created']);

}


/**********************Ultimate Co*************************/
function create_UC_N1($X12info)
{

	//Party Identification

	$segTer = "~";

	$BN1    =   array();

	$BN1[0] = "N1";                        // Beginning of Hierarchical Transaction Segment ID
	 
	$BN1[1] = strtoupper($X12info['UlConsignee']); //Entity Identifier Code
	 
	$BN1[2] = strtoupper($X12info['UlConsigneeName']); // PARTY NAME and USPPI NAME
	 
	$BN1[3] = ''; //Identification Code Qualifier
	 
	$BN1[4] = ''; //Identification Code identifying a party or other code
	 
	$BN1[5] = '01'; //Entity Relationship Code.
	 
	$BN1[6] = strtoupper($X12info['UlConsigneeType']); //Entity Identifier Code

	$BN1['Created'] = implode('*', $BN1);           // Data Element Separator

	$BN1['Created'] = $BN1 ['Created'] . $segTer;

	return trim($BN1['Created']);

}


function create_UC_N3($X12info)
{

	$segTer = "~";

	$SN3    =   array();

	$SN3[0] = "N3";                        // Beginning of Hierarchical Transaction Segment ID
	 
	$SN3[1] = strtoupper($X12info['UlConsigneeAddress']); //Address Information ADDRESS LINE 1

	$SN3['Created'] = implode('*', $SN3);           // Data Element Separator

	$SN3['Created'] = $SN3 ['Created'] . $segTer;

	return trim($SN3['Created']);

}

function create_UC_N4($X12info)
{
	$segTer = "~";

	$SN4    =   array();

	$SN4[0] = "N4";                        // Beginning of Hierarchical Transaction Segment ID
	 
	$SN4[1] = strtoupper($X12info['UlConsigneeCity']); //City Name

	$SN4[2] = strtoupper($X12info['UlConsigneeState']); //State or Province Code
	 
	$SN4[3] = strtoupper($X12info['UlConsigneeZip']); //Postal Code
	 
	$SN4[4] = strtoupper($X12info['UlConsigneeCountry']); //Country Code

	$SN4['Created'] = implode('*', $SN4);           // Data Element Separator

	$SN4['Created'] = $SN4 ['Created'] . $segTer;

	return trim($SN4['Created']);

}





/**********************Ultimate Co*************************/

/**********************Intermediate Consignee *************************/
function create_IC_N1($X12info)
{

	//Party Identification

	$segTer = "~";

	$BN1    =   array();

	$BN1[0] = "N1";                        // Beginning of Hierarchical Transaction Segment ID
	 
	$BN1[1] = strtoupper($X12info['InConsignee']); //Entity Identifier Code
	 
	$BN1[2] = strtoupper($X12info['InConsigneeName']); // PARTY NAME and USPPI NAME

	$BN1['Created'] = implode('*', $BN1);           // Data Element Separator

	$BN1['Created'] = $BN1 ['Created'] . $segTer;

	return trim($BN1['Created']);

}


function create_IC_N3($X12info)
{

	$segTer = "~";

	$SN3    =   array();

	$SN3[0] = "N3";                        // Beginning of Hierarchical Transaction Segment ID
	 
	$SN3[1] = strtoupper($X12info['InConsigneeAddress']); //Address Information ADDRESS LINE 1

	$SN3['Created'] = implode('*', $SN3);           // Data Element Separator

	$SN3['Created'] = $SN3 ['Created'] . $segTer;

	return trim($SN3['Created']);

}

function create_IC_N4($X12info)
{
	$segTer = "~";

	$SN4    =   array();

	$SN4[0] = "N4";                        // Beginning of Hierarchical Transaction Segment ID
	 
	$SN4[1] = strtoupper($X12info['InConsigneeCity']); //City Name

	$SN4[2] = strtoupper($X12info['InConsigneeState']); //State or Province Code
	 
	$SN4[3] = strtoupper($X12info['InConsigneeZip']); //Postal Code
	 
	$SN4[4] = strtoupper($X12info['InConsigneeCountry']); //Country Code

	$SN4['Created'] = implode('*', $SN4);           // Data Element Separator

	$SN4['Created'] = $SN4 ['Created'] . $segTer;

	return trim($SN4['Created']);

}

/**********************Intermediate End*************************/



function create_X1($X12info,$arrySaleItem)
{

	//X1 Export License
	//$X1 = "X1**NLR*1****C33**D*****0**EAR99~";
	$segTer = "~";

	$X1    =   array();

	$X1[0] = "X1";                        // Beginning of Hierarchical Transaction Segment ID

	$X1[1] = '';//Code For Licensing, Certification, Registration

	$X1[2] = 'NLR';//Export License Number

	$X1[3] = '1';//International/Domestic Code

	$X1[4] = '';

	$X1[5] = '';

	$X1[6] = '';

	$X1[7] = 'C33';

	$X1[8] = '';

	$X1[9] = 'D';

	$X1[10] = '';

	$X1[11] = '';

	$X1[12] = '';

	$X1[13] = '';

	$X1[14] = '0';

	$X1[15] = '';

	$X1[16] = 'EAR99';


	$X1['Created'] = implode('*', $X1);           // Data Element Separator

	$X1['Created'] = $X1 ['Created'] . $segTer;

	return trim($X1['Created']);

}


function create_L13($X12info,$arrySaleItem)
{
	//L13 Commodity Details
	$segTer = "~";

	$L13    =   array();

	$L13[0] = "L13";                        // Beginning of Hierarchical Transaction Segment ID
	 
	$L13[1] = $X12info['HTSCode'];//Commodity Code Qualifier

	$L13[2] = $X12info['HTSNumber'];//Commodity Code
	 
	$L13[3] = $X12info['Unit'];//Unit or Basis for Measurement Code
	 
	$L13[4] = $X12info['Quantity']; //$X12info['Quantity'];//Quantity
	 
	$L13[5] = $X12info['ShippingAmount'];//$X12info['ShippingAmount'];//Amount Qualifier Code
	 
	$L13[6] = $X12info['ShippingMonetaryAmount']; //$X12info['ShippingMonetaryAmount'];//Monetary Amount
	 
	$L13[7] =  $X12info['LINENUMBER'];//$X12info['LINENUMBER'];//Assigned Number

	$L13[8] =  '*';
	 
	$L13[9] = $X12info['WeightUnitCode'];//Unit or Basis for Measurement Code
	 
	$L13[10] = $X12info['Weight'];//Quantity
	 
	$L13[11] = strtoupper($X12info['COMMODITYDESCRIPTION']); //$X12info['COMMODITYDESCRIPTION'];//EXPORT INFORMATION CODE COMMODITY DESCRIPTION
	 
	$L13[12] = strtoupper($X12info['EXPORTINFORMATIONCODE']);//EXPORT INFORMATION CODE
	 
	$L13[13] = strtoupper($X12info['LINEITEMACTION']);//LINE ITEM FILING ACTION REQUEST INDICATOR 3
	 
	$L13['Created'] = implode('*', $L13);           // Data Element Separator

	$L13['Created'] = $L13 ['Created'] . $segTer;

	return trim($L13['Created']);

}



function create_L13_2($X12info)
{

	//L13 Commodity Details
	$segTer = "~";

	$L13    =   array();

	$L13[0] = "L13";                        // Beginning of Hierarchical Transaction Segment ID
	 
	$L13[1] = $X12info['HTSCode'];//Commodity Code Qualifier

	$L13[2] = '3824405000';//$X12info['HTSNumber'];//Commodity Code
	 
	$L13[3] = $X12info['Unit'];//Unit or Basis for Measurement Code
	 
	$L13[4] = '1000'; //$X12info['Quantity'];//Quantity
	 
	$L13[5] = '10';//$X12info['ShippingAmount'];//Amount Qualifier Code
	 
	$L13[6] = '463'; //$X12info['ShippingMonetaryAmount'];//Monetary Amount
	 
	$L13[7] =  '2';//$X12info['LINENUMBER'];//Assigned Number

	$L13[8] =  '*';
	 
	$L13[9] = $X12info['WeightUnitCode'];//Unit or Basis for Measurement Code
	 
	$L13[10] = '1039';//Quantity
	 
	$L13[11] = strtoupper('HP PROLIANT DL380 G9 HIGH PERFORMANCE FAN'); //$X12info['COMMODITYDESCRIPTION'];//EXPORT INFORMATION CODE COMMODITY DESCRIPTION
	 
	$L13[12] = strtoupper($X12info['EXPORTINFORMATIONCODE']);//EXPORT INFORMATION CODE
	 
	$L13[13] = strtoupper($X12info['LINEITEMACTION']);//LINE ITEM FILING ACTION REQUEST INDICATOR 3
	 
	$L13['Created'] = implode('*', $L13);           // Data Element Separator

	$L13['Created'] = $L13 ['Created'] . $segTer;

	return trim($L13['Created']);

}




function create_SE($X12info)
{
	$segTer = "~";
	$compEleSep = "*";

	//SE Transaction Set Trailer
	$SE     =   array();

	$SE[0] = "SE";                              // Transaction Set Trailer Segment ID

	$SE[1] = 23;                     // Number of Included Segments

	$SE[2] = $X12info['SESTTransactionSet'];  // Transaction Set Control Number - Must match ST's

	$SE['Created'] = implode('*', $SE);             // Data Element Separator

	$SE['Created'] = $SE['Created'] . $segTer;

	return trim($SE['Created']);
}


function create_GE($X12info)
{

	$segTer = "~";
	$compEleSep = "*";

	//GE Functional Group Trailer
	$GE     =   array();

	$GE[0]  = "GE";                             // Functional Group Trailer Segment ID

	$GE[1]  = $X12info['GroupControl'];                          // Number of included Transaction Sets

	$GE[2]  = $X12info['GroupControl'];                          // Group Control Number

	$GE['Created'] = implode('*', $GE);     // Data Element Separator

	$GE['Created'] = $GE['Created'] . $segTer;

	return trim($GE['Created']);
}


function create_IEA($X12info)
{
	$segTer = "~";
	$compEleSep = "*";

	//IEA Interchange Control Trailer
	$IEA    =   array();

	$IEA[0] = "IEA";                        // Interchange Control Trailer Segment ID

	$IEA[1] = $X12info['GroupControl'];                          // Number of Included Functional Groups

	$IEA[2] = $X12info['InterchangeControlNumber'];                  // Interchange Control Number

	$IEA['Created'] = implode('*', $IEA);

	$IEA['Created'] = $IEA['Created'] .  $segTer;

	return trim($IEA['Created']);
}

/**********************************************************************/



function print_elig($X12info,$arrySaleItem)
{
	//$segmentcount = sizeof($arrySaleItem);
	$segmentcount = 2;
	// For Header Segment
	$PATEDI    = create_ISA($X12info). PHP_EOL;
	$PATEDI   .= create_GS($X12info). PHP_EOL;
	$PATEDI   .= create_ST($X12info). PHP_EOL;

	$PATEDI   .= create_BA1($X12info). PHP_EOL;
	$PATEDI   .= create_YNQ1($X12info). PHP_EOL;
	$PATEDI   .= create_YNQ2($X12info). PHP_EOL;

	$PATEDI   .= create_DTM($X12info). PHP_EOL;
	$PATEDI   .= create_P5($X12info). PHP_EOL;
	$PATEDI   .= create_REF($X12info). PHP_EOL;
	$PATEDI   .= create_M12($X12info). PHP_EOL;

	// shipping
	$PATEDI   .= create_shiping_N1($X12info). PHP_EOL;
	$PATEDI   .= create_shiping_N2($X12info). PHP_EOL;
	$PATEDI   .= create_shiping_N3($X12info). PHP_EOL;
	$PATEDI   .= create_shiping_N4($X12info). PHP_EOL;
	// Ultimate
	$PATEDI   .= create_UC_N1($X12info). PHP_EOL;
	$PATEDI   .= create_UC_N3($X12info). PHP_EOL;
	$PATEDI   .= create_UC_N4($X12info). PHP_EOL;

	//Intermediate
	$PATEDI   .= create_IC_N1($X12info). PHP_EOL;
	$PATEDI   .= create_IC_N3($X12info). PHP_EOL;
	$PATEDI   .= create_IC_N4($X12info). PHP_EOL;


	//Line Item

	/* for($i=0;$i<$segmentcount;$i++){
		$PATEDI   .= create_L13($X12info,$arrySaleItem[$i]). PHP_EOL;
		$PATEDI   .= create_X1($X12info,$arrySaleItem[$i]). PHP_EOL;
	}
	*/
	
	$PATEDI   .= create_L13($X12info). PHP_EOL;
    $PATEDI   .= create_X1($X12info). PHP_EOL;
    $PATEDI   .= create_L13_2($X12info). PHP_EOL;
	$PATEDI   .= create_X1($X12info). PHP_EOL;
		
	// For Footer Segment
	$PATEDI   .= create_SE($X12info). PHP_EOL;
	$PATEDI   .= create_GE($X12info). PHP_EOL;
	$PATEDI   .= create_IEA($X12info). PHP_EOL;

	return $PATEDI;
}



?>