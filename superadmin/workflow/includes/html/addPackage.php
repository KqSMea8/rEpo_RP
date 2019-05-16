<?php
/* Developer Name: Niraj Gupta
 * Date : 19-06-15
 * Description: For addElement.php
 */

global $FormHelper, $errorformdata, $objVali;

if (isset($_POST['Submit'])) {
/*$data = array('packagedata' =>
            array('pckg_name' => $_POST['pckg_name'], 'pckg_tagline' => $_POST['pckg_tagline'], 'pckg_price' => $_POST['pckg_price'], 'pckg_description' => $_POST['pckg_description'], 'status' => $_POST['status']), 'elementdata' => $_POST['element']);
print_r($data);*/
    $validatedata = array(
        'pckg_name' => array(array('rule' => 'notempty', 'message' => 'Please enter tagline.')),
	'pckg_duration' => array(array('rule' => 'notempty', 'message' => 'Please enter tagline.')),
        'pckg_tagline' => array(array('rule' => 'notempty', 'message' => 'Please enter tagline.')),
        'pckg_price' => array(array('rule' => 'notempty', 'message' => 'Please enter price.')),
        'pckg_description' => array(array('rule' => 'notempty', 'message' => 'Please enter description.')),
    );
    $objVali->requestvalue = $_POST;
    $errors = $objVali->validate($validatedata);
    $aa = array();
    if (empty($errors)) {
        $objPackage = new package();
        $data = array('packagedata' =>
            array('pckg_name' => $_POST['pckg_name'], 'plan_title' => $_POST['pckg_title'], 'package_feature' => $_POST['pckg_tagline'], 'pckg_price' => $_POST['pckg_price'], 'pckg_description' => $_POST['pckg_description'], 'package_time' => $_POST['pckg_duration'], 'status' => $_POST['status']), 'elementdata' => $_POST['element']);
print_r($data);
      // echo'11111';
        if (!empty($_POST['pckg_id'])) {
//print_r($data);
//echo'2222';
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

<div class="had">
    Manage Package    <span> &raquo;
        <?php
        if (!empty($_GET['edit'])) {
            if ($_GET['tab'] == "package") {
                echo "Edit Package Details";
            }
        } else {
            echo "Add " . $ModuleName;
        }
        ?>
    </span>
</div>
<?php if (!empty($errors)) { ?>
    <div height="2" align="center"  class="red" ><?php //echo $errors; ?></div>

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


