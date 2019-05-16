<?php
ini_set('display_errors', true);
ini_set('error_reporting', E_ALL);
ini_set('display_errors',1);
// Load the iContact library
//require_once('lib/iContactApi.php');
require_once('lib_test/iContactApi.php');

// Give the API your information  //'sDqhxUQk0iUOtHS8qX38ivkHr0HBqedD', //'vstacks94550',  //'amit'
/*iContactApi::getInstance()->setConfig(array(
	'appId'       => 'YEMbSa1bPpUxJ0k6Lz5LKTqohJIPynrp',
	'apiPassword' => 'Vstacks@321', 
	'apiUsername' => 'chimpvstacks99@gmail.com'
));*/
iContactApi::getInstance()->setConfig(array(
	'appId'       => 'Z6gVNB8mfJrdQcScaPxwy0e6nmspayVK',
	'apiPassword' => 'vstacks@12345', 
	'apiUsername' => 'vstacks.opcinfotech@gmail.com'
));

// Store the singleton
$oiContact = iContactApi::getInstance();var_dump($oiContact);
// Try to make the call(s)
try {
	//  are examples on how to call the  iContact PHP API class
        echo "<pre>";
        
        //Grab Subscription
        //var_dump($oiContact->getSubscribtions());
        /*Grab a Subscription
        var_dump($oiContact->getSubscribtion(27718_29066693)); not worked*/
	// Grab all contacts
            //var_dump($oiContact->getContacts());
	// Grab a contact
	
	var_dump($oiContact->getContact(25182000));//42094396 contactId
	/*$res=$oiContact->getContact(2815185);
        if(!$res)addError('Wrong Function');*/
	// Delete Contact
            //var_dump($oiContact->deleteContact(28150799));
        // Create a contact
		//var_dump($oiContact->addContact('HelloDemo@gmail.com', null, null, 'Joe', 'Shmoe', null, '123 Somewhere Ln', 'Apt 12', 'Somewhere', 'NW', '201007', '9026234694', null, null));
	
        // Get messages
		//var_dump($oiContact->getMessages());
        // Create message  addMessage(subject,campaignId,text body,message name,html body, listId,message_type='normal'etc)  4543
		//var_dump($res=$oiContact->addMessage('Today 20th Amit Singh',18060,null, 'MessageName For Cool 20', '<h1>An Example Message By Amit Singh 20th</h1>Hello Sir its imnform all of you that its cool now i want to inform u all that there is a funciont which should be atend by all of u'));
	// Schedule send        schedule time= ,mktime(12, 0, 0, 1, 1, 2015)
                //var_dump($res->messageId);array(28303,27718),,$res->messageId,null, null, null, mktime(12, 0, 0, 1, 1, 2012)
		//var_dump($oiContact->sendMessage(array(28303,27718), 78419,null, null, 4635));
         
	//Get all Lists
		//var_dump($oiContact->getLists()); 
        // Get a Lists
		//var_dump($oiContact->getList(28303));// 
        // Create a list             addList(name,notification(emailOwnerOnChange(1/0)),welcomeOnManualAdd(1/0),$bWelcomeOnSignupAdd(1/0),description,msg ID,public listName)
		//var_dump($oiContact->addList('AmitSingh2 16', true, true, true, 'creted at 16-7-15'));//, 68834));

/**************************************************************************************/	
	// Create Segment
		//var_dump($oiContact->addSegment('TestSachin','Just an example list', '28282'));	
	// get a SEGMENT
                //var_dump($oiContact->getSegment(4543));
	// Grab all segment
		//var_dump($oiContact->getSegments());
        // Update Segment
                //var_dump($oiContact->updateSegment('TestSachinAmit','Re edited an example list','4555'));
/*******************************************************************************************/	
	// Create a list
		//var_dump($oiContact->addList('HelooList', 1698, true, false, false, 'Just an example list', 'testList'));
	// Subscribe contact to list					(current-icontactID,iListID,istatus)
                //$l=array('28303','28282','28278');
		//var_dump($oiContact->subscribeContactToList(30487206,$l,'normal'));
        
        // Grab a campaign
		//print_r($oiContact->getCampaign(18060));
        // Grab all campaigns
		//var_dump($oiContact->getCampaigns());
                //
        // Create Campaign
               //print_r($oiContact->addCampaign('sakhya','sakhyaits a name','sakhyaFrom','sakhya@its.edu.in','0','1','0','0','0'));
               //print_r($oiContact->addCampaign("Amit New Today","abcd","Anew Today","AnewToday@gmail.com","0","1","0","0","1","road street","Noida City","UP","201007","India"));
        // Update Campaign
                //print_r($oiContact->updateCampaign("18060","Amit Singh Now","abcd","Anew Today"," amitsingh.as@its.edu.in ","1","1","1","1","1"));
        // Upload data by sending a filename (execute a PUT based on file contents)
		//var_dump($oiContact->uploadData('/path/to/file.csv', 179962));
                //var_dump($oiContact->uploadData('iContact_ImportUser.xls', 28282));
	// Upload data by sending a string of file contents
		//$sFileData = file_get_contents('iContact_ImportUser.xls');  // Read the file
		//var_dump($oiContact->uploadData($sFileData, 28282)); // Send the data to the API
} catch (Exception $oException) { // Catch any exceptions
	// Dump errors
	var_dump($oiContact->getErrors());
	//self create// 
        //var_dump($oiContact->addError());
	// Grab the last raw request data
	var_dump($oiContact->getLastRequest());
	// Grab the last raw response data
	var_dump($oiContact->getLastResponse());
}
