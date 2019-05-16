<?php
global $FormHelper, $errorformdata, $objVali;

if (isset($_POST['Submit'])) {
	$validatedata = array(
        'name' => array(array('rule' => 'notempty', 'message' => 'Please  enter package name.')
	,array('rule' => 'removahtml', 'message' => 'Please remove HTML tags.')

	),
     'planType' => array(array('rule' => 'notempty', 'message' => 'Please select package name.')	
	,array('rule' => 'removahtml', 'message' => 'Please remove HTML tags.')
	),

        /*'allowedDoc' => array(array('rule' => 'empty', 'message' => 'Please enter allowed document.')
	,array('rule' => 'removahtml', 'message' => 'Please remove HTML tags.')
	,array('rule' => 'number', 'message' => 'only number allowed.')
	),
        'overageCostPerDoc' => array(array('rule' => 'empty', 'message' => 'Please enter over cost per document.')
	,array('rule' => 'removahtml', 'message' => 'Please remove HTML tags.')
	, array('rule' => 'float', 'message' => 'Invalid price.')
	),
        'allowedPage' => array(array('rule' => 'empty', 'message' => 'Please enter allowed page.')
	,array('rule' => 'removahtml', 'message' => 'Please remove HTML tags.')
	,array('rule' => 'number', 'message' => 'only number allowed.')
	,array('rule' => 'removahtml', 'message' => 'Please remove HTML tags.')
	),
        'overageCostPerPage' => array(array('rule' => 'empty', 'message' => 'Please enter over cost per page.'),
	array('rule' => 'float', 'message' => 'Invalid price.')
	,array('rule' => 'removahtml', 'message' => 'Please remove HTML tags.')
	),
	'allowedVideo' => array(array('rule' => 'empty', 'message' => 'Please enter allowed video.'),
	array('rule' => 'number', 'message' => 'only number allowed.')
	,array('rule' => 'removahtml', 'message' => 'Please remove HTML tags.')
	),
	'overageCostPerVideo' => array(array('rule' => 'empty', 'message' => 'Please enter over cost per video.'),
	array('rule' => 'float', 'message' => 'Invalid price.')
	,array('rule' => 'removahtml', 'message' => 'Please remove HTML tags.')
	),
	'allowMaxvideoSize' => array(array('rule' => 'empty', 'message' => 'Please enter allowed video size.'),
	array('rule' => 'number', 'message' => 'only number allowed.')
	,array('rule' => 'removahtml', 'message' => 'Please remove HTML tags.')
	),
	'overageCostVideoSize' => array(array('rule' => 'empty', 'message' => 'Please enter over cost per video size.'),
	array('rule' => 'float', 'message' => 'Invalid price.')
	,array('rule' => 'removahtml', 'message' => 'Please remove HTML tags.')
	),
	'allowUser' => array(array('rule' => 'empty', 'message' => 'Please enter allowed user.'),
	array('rule' => 'number', 'message' => 'only number allowed.')
	,array('rule' => 'removahtml', 'message' => 'Please remove HTML tags.')
	),
	'overageCostPerUser' => array(array('rule' => 'empty', 'message' => 'Please enter over cost per user.'),
	array('rule' => 'float', 'message' => 'Invalid price.')
	,array('rule' => 'removahtml', 'message' => 'Please remove HTML tags.')
	),*/
	'amount' => array(array('rule' => 'notempty', 'message' => 'Please enter amount.'),
	array('rule' => 'float', 'message' => 'Invalid allowed user (numbers only)')
	,array('rule' => 'removahtml', 'message' => 'Please remove HTML tags.')
	),
	'timePeriod' => array(array('rule' => 'empty', 'message' => 'Please enter time period.'),
	array('rule' => 'number', 'message' => 'only number allowed.')
	,array('rule' => 'removahtml', 'message' => 'Please remove HTML tags.')
	),
      /* 'allowedStore' => array(array('rule' => 'empty', 'message' => 'Please enter allowed Store.'),
	array('rule' => 'number', 'message' => 'only number allowed.')
	,array('rule' => 'removahtml', 'message' => 'Please remove HTML tags.')
	),
       'allowedSpace' => array(array('rule' => 'empty', 'message' => 'Please enter allowed Space.'),
	array('rule' => 'number', 'message' => 'only number allowed.')
	,array('rule' => 'removahtml', 'message' => 'Please remove HTML tags.')
	),*/

	//'pckg_description' => array(array('rule' => 'notempty', 'message' => 'Please enter description.')),
	);
	$objVali->requestvalue = $_POST;
	$errors = $objVali->validate($validatedata);
	$aa = array();
	if (empty($errors)) {
		$objPackage = new package();

         $storageType= $_POST['storageType'];
        $allowedSpace=  $_POST['allowedSpace'];

   if($storageType==MB){
            $allowedSpace = $allowedSpace / 1024;
            // echo $gb;           
        }
        else if ($storageType==TB){
            $allowedSpace =$allowedSpace *1024;
           //echo $gb;     
        }



		$data = array('packagedata' =>
		array('name' => $_POST['name'],
                'plan_type' => $_POST['planType'], 
		'allowedDoc' => $_POST['allowedDoc'], 
		'allowedPage' => $_POST['allowedPage'], 
		'allowedVideo' => $_POST['allowedVideo'], 
		'allowMaxvideoSize' => $_POST['allowMaxvideoSize'], 
		'allowUser' => $_POST['allowUser'],
		'overageCostPerDoc' => $_POST['overageCostPerDoc'], 
		'overageCostPerPage' => $_POST['overageCostPerPage'], 
		'overageCostPerVideo' => $_POST['overageCostPerVideo'], 
		'overageCostVideoSize' => $_POST['overageCostVideoSize'], 
		'overageCostPerUser' => $_POST['overageCostPerUser'], 
		'amount' => $_POST['amount'], 
		'timePeriod' => $_POST['timePeriod'], 
		'status' => $_POST['status'],
                'alloweLicense' => $_POST['allowedStore'],
                'allowedStorage' => $allowedSpace,
                'periodType' => $_POST['periodType'],
                'storageType' => $storageType

		)
		);
		
		if (!empty($_POST['pckg_id'])) {
			$pckg_id = $_POST['pckg_id'];
			$update_id = $objPackage->UpdatePackage($data, $pckg_id);
			header("Location:" . $RedirectURL);
		} else {

			$pckg_id = $objPackage->AddPackage($data);

			header("Location:" . $RedirectURL); /* Redirect browser */
			/* Make sure that code below does not get executed when we redirect. */
			exit;
		}
	} else {
		$FormHelper->errordata = $errorformdata = $errors;
	}
}
?>
<div><a href="<?= $RedirectURL ?>" class="back">Back</a></div>

<div class="had">Manage Package <span> &raquo; <?php
if (!empty($_GET['edit'])) {
	if ($_GET['tab'] == "package") {
		echo "Edit Package Details";
	}
} else {
	echo "Add " . $ModuleName;
}
?> </span></div>
<?php if (!empty($errors)) { ?>
<div height="2" align="center" class="red"><?php //echo $errors; ?></div>

<?php } ?>
<?php
if (!empty($_SESSION['mess_pckg'])) {
	echo '<div height="2" align="center"  class="redmsg" >' . $_SESSION['mess_pckg'] . '</div>';
	unset($_SESSION['mess_pckg']);
}
?>

<?php
if (!empty($_GET['edit'])) {
	if ($_GET['tab'] == "package") {
		include("includes/html/box/package_form.php");
	}
} else {
	include("includes/html/box/package_form.php");
}
?>


