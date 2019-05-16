<script type="text/javascript" src="../../admin/FCKeditor/fckeditor.js"></script>
<script
	type="text/javascript" src="../../admin/js/ewp50.js"></script>

<script type="text/javascript">
    var ew_DHTMLEditors = [];
</script>
<style>
.input.radio .inputbox {
    margin: 0 7px;
    width: auto;
}
</style>
<?php
/* Developer Name: Niraj Gupta
 * Date : 19-06-15
 * Description: For addElement.php
 */
global $FormHelper, $errorformdata, $objVali;

if (isset($_POST['Submit'])) {
    $validatedata = array(
        'pckg_name' => array(array('rule' => 'notempty', 'message' => 'Please enter package name.')
            ,array('rule' => 'removahtml', 'message' => 'Please Remove Html tags.')
            ,array('rule' => 'string', 'message' => 'Please enter only alphabet.')
            ),
        'pckg_tagline' => array(array('rule' => 'notempty', 'message' => 'Please enter tagline.'),array('rule' => 'removahtml', 'message' => 'Please Remove Html tags.')),
        'pckg_price' => array(array('rule' => 'notempty', 'message' => 'Please enter price.')
            ,array('rule' => 'removahtml', 'message' => 'Please Remove Html tags.')
            ,array('rule' => 'float', 'message' => 'Please enter valid price.')
            ),
        'pckg_description' => array(array('rule' => 'notempty', 'message' => 'Please enter description.')),
    	'package_time' => array(array('rule' => 'notempty', 'message' => 'Please enter duration.'),array('rule' => 'number', 'message' => 'Please enter Number only.')),
    );
    $objVali->requestvalue = $_POST;
    $errors = $objVali->validate($validatedata);  
    $aa = array();

 

    if (empty($errors)) {
        $objPackage = new package();
        $data = array('packagedata' =>
            array('package_time'=>$_POST['package_time'],'pckg_name' => $_POST['pckg_name'], 'pckg_tagline' => $_POST['pckg_tagline'], 'pckg_price' => $_POST['pckg_price'], 'pckg_description' => $_POST['pckg_description'], 'status' => $_POST['status']), 'elementdata' => $_POST['element']);
       
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


