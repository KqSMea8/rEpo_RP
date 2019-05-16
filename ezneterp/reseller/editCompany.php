<?php

/* * *********************************************** */
$ThisPageName = 'viewCompany.php';
if (empty($_GET["edit"]))
    $EditPage = 1;
/* * *********************************************** */
include ('includes/function.php');
//	ValidateCrmSession();
include ('includes/header.php');
require_once($Prefix . "classes/company.class.php");
require_once($Prefix . "classes/region.class.php");
require_once($Prefix . "classes/configure.class.php");
require_once($Prefix . "classes/dbfunction.class.php");
require_once($Prefix . "classes/phone.class.php");
require_once($Prefix . "classes/function.class.php");

$objphone = new phone();
$objConfigure = new configure();
$objFunction = new functions();
$ModuleName = "Company";
$RedirectURL = "viewCompany.php?curP=" . $_GET['curP'];
if (empty($_GET['tab']))
    $_GET['tab'] = "company";

$EditUrl = "editCompany.php?edit=" . $_GET["edit"] . "&curP=" . $_GET["curP"] . "&tab=";
$ActionUrl = $EditUrl . $_GET["tab"];


$objCompany = new company();
$objRegion = new region();

if ($_GET['active_id'] && !empty($_GET['active_id'])) {
    $_SESSION['mess_company'] = COMPANY_STATUS_CHANGED;
    $objCompany->changeCompanyStatus($_REQUEST['active_id']);
    header("Location:" . $RedirectURL);
}



if ($_POST) {
    CleanPost();

    //$_POST['Department'] = implode(",",$_POST['Department']);
    $_POST['Department'] = 5;

    if (empty($_POST['Email']) && empty($_POST['CmpID'])) {
        $errMsg = ENTER_EMAIL;
    } else {
        if (!empty($_POST['CmpID'])) {
            $ImageId = $_POST['CmpID'];
            /*
              $objCompany->UpdateCompany($_POST);
              $_SESSION['mess_company'] = COMPANY_UPDATED;
             */
            /*             * ************************ */
            switch ($_GET['tab']) {
                case 'company':
                    $objCompany->UpdateCompanyProfile($_POST);
                    $_SESSION['mess_company'] = COMPANY_PROFILE_UPDATED;
                    break;
                case 'account':
                    $objCompany->UpdateAccount($_POST);
                    $objCompany->defaultCompanyUpdate($_POST['CmpID'], $_POST['DefaultCompany']);
                    $_SESSION['mess_company'] = ACCOUNT_UPDATED;
                    break;
                case 'permission':
                    $objCompany->UpdatePermission($_POST);
                    //$UpdateAdminMenu = 1;
                    $_SESSION['mess_company'] = PERMISSION_UPDATED;
                    break;
                case 'currency':
                    $ArrayCompany = $objCompany->GetCompany($_POST['CmpID'], 1);
                    $DbName2 = $Config['DbName'] . "_" . $ArrayCompany[0]['DisplayName'];
                    $objCompany->UpdateCurrency($_POST);
                    $objConfig->dbName = $DbName2;
                    $objConfig->connect();
                    $objConfigure->UpdateLocationCurrency($_POST);
                    $_SESSION['mess_company'] = CURRENCY_UPDATED;
                    break;
                case 'DateTime':
                    $objCompany->UpdateDateTime($_POST);
                    $UpdateAdminDateTime = 1;
                    $_SESSION['mess_company'] = DATETIME_UPDATED;
                    break;
                /* case 'default':
                  $objCompany->defaultCompanyUpdate($_POST['CmpID'],$_POST['DefaultCompany']);
                  break; */


                case 'Call':


                    if (!empty($_POST['server'])) {


                        #delete data of call_country_code
                        $objphone->delete('call_country_code', array('company_id' => $_POST['CmpID']));


                        #insert data in call_country_code tbl
                        foreach ($_POST['country_code'] as $code) {
                            $objphone->insert('call_country_code', array('company_id' => $_POST['CmpID'], 'country_id' => $code));
                        }


                        if (empty($DbName)) {
                            $comdata = $objCompany->GetCompanyDisplayName($_POST['CmpID']);
                            $DbName = $Config['DbName'] . "_" . $comdata[0]['DisplayName'];
                        }
                        $Config['DbName'] = $DbName;
                        $objConfig->dbName = $Config['DbName'];
                        $objConfig->connect();
                        $name = $comdata[0]['DisplayName'];



                        if (empty($_POST['call_setting_id'])) {

                            $responce = $objphone->CreateGroup($name, $_POST['server']);

                            if (!empty($responce['error'])) {
                                $_SESSION['mess_company'] = $responce['error'];
                            } else {
                                $_SESSION['mess_company'] = $responce['success'];
                                header("Location:editCompany.php?edit=" . $_GET['edit'] . "&curP=" . $_GET['curP'] . "&tab=" . $_GET['tab']);
                            }
                        } else {



                            $_POST['old_server'];
                            if ($_POST['old_server'] != $_POST['server']) {

                                $parm = "acl_group.php?action=groupadd&group=" . $name . "&description=" . $name;
                                $data = $this->api($parm, array(), $_POST['server']);
                                if (!empty($data->id)) {
                                    $_POST['old_server'];
                                    $parm = "acl_group.php?action=groupdelete&group_id=" . $_POST['old_group_id'];
                                    $res = $this->api($parm, array(), $_POST['server']);
                                    $objphone->update('c_call_setting', array('server_id' => $_POST['server'], 'group_id' => $data->id), array('id' => $_POST['call_setting_id']));
                                    $_SESSION['mess_company'] = 'Update SUccessfully';
                                    header("Location:editCompany.php?edit=" . $_GET['edit'] . "&curP=" . $_GET['curP'] . "&tab=" . $_GET['tab']);
                                } else {
                                    $_SESSION['mess_company'] = $data->error;
                                }
                            }
                        }
                    }
                    break;
            }
            /*             * ************************ */
        } else {
            if ($objConfig->isCmpEmailExists($_POST['Email'], '')) {
                $_SESSION['mess_company'] = EMAIL_ALREADY_REGISTERED;
            } else if ($objCompany->isDisplayNameExists($_POST['DisplayName'], '')) {
                $_SESSION['mess_company'] = DISPLAY_ALREADY_REGISTERED;
            } else {

                $_POST['RsID'] = $_SESSION['CrmRsID'];

                $ImageId = $objCompany->AddCompany($_POST);
                $_SESSION['mess_company'] = COMPANY_ADDED;
                $AddDatabase = 1;
                $UpdateAdminMenu = 1;
            }
        }

        $_POST['CmpID'] = $ImageId;

        /*         * **********************
          if($_FILES['Image']['name'] != ''){
          $ImageExtension = GetExtension($_FILES['Image']['name']);
          $imageName = $ImageId.".".$ImageExtension;
          $ImageDestination = $Prefix."upload/company/".$imageName;
          if(@move_uploaded_file($_FILES['Image']['tmp_name'], $ImageDestination)){
          $objCompany->UpdateImage($imageName,$ImageId);
          }
          }
          /*********************************** */
        if ($_FILES['Image']['name'] != '') {
            $FileArray = $objFunction->CheckUploadedFile($_FILES['Image'], "Image");

            if (empty($FileArray['ErrorMsg'])) {
                $ImageExtension = GetExtension($_FILES['Image']['name']);
                $imageName = $ImageId . "." . $ImageExtension;
                $ImageDestination = $Prefix . "upload/company/" . $imageName;

                if (!empty($_POST['OldImage']) && file_exists($_POST['OldImage'])) {
                    unlink($_POST['OldImage']);
                }

                if (@move_uploaded_file($_FILES['Image']['tmp_name'], $ImageDestination)) {
                    $objCompany->UpdateImage($imageName, $ImageId);
                }
            } else {
                $ErrorMsg = $FileArray['ErrorMsg'];
            }

            if (!empty($ErrorMsg)) {
                if (!empty($_SESSION['mess_company']))
                    $ErrorPrefix = '<br><br>';
                $_SESSION['mess_company'] .= $ErrorPrefix . $ErrorMsg;
            }
        }



        /*         * ********************************* */
        /*         * ********************* */
        if ($AddDatabase == 1) {
            $DbName = $objCompany->AddDatabse($_POST['DisplayName']);
            if (!empty($DbName)) {
                ImportDatabase($Config['DbHost'], $DbName, $Config['DbUser'], $Config['DbPassword'], $Prefix . 'superadmin/sql/erp_company.sql');
            }
        }

        /*         * ********************* */
        if ($UpdateAdminMenu == 1) {
            if (empty($DbName)) {
                $arryCmp = $objCompany->GetCompanyDisplayName($_POST['CmpID']);

                $DbName = $Config['DbName'] . "_" . $arryCmp[0]['DisplayName'];
            }
            $Config['DbName'] = $DbName;
            $objConfig->dbName = $Config['DbName'];
            $objConfig->connect();

            $objCompany->UpdateAdminModules($_POST['CmpID'], $_POST['Department']);


            #$objCompany->UpdateAdminSubModules($_POST['CmpID'],$_POST['Department'],$PaymentPlan);	//Temporary For CRM Frontend Integration


            $objCompany->UpdateInventoryModules($_POST['CmpID'], $_POST['TrackInventory']);
        }
        /*         * ********************* */

        /*         * ********************* */
        if ($UpdateAdminDateTime == 1) {
            if (empty($DbName)) {
                $arryCmp = $objCompany->GetCompanyDisplayName($_POST['CmpID']);

                $DbName = $Config['DbName'] . "_" . $arryCmp[0]['DisplayName'];
            }
            $Config['DbName'] = $DbName;
            $objConfig->dbName = $Config['DbName'];
            $objConfig->connect();

            $objCompany->UpdateLocationDateTime($_POST);
        }
        /*         * ********************* */






        if (!empty($_GET['edit'])) {
            header("Location:" . $ActionUrl);
            exit;
        } else {
            header("Location:" . $RedirectURL);
            exit;
        }
    }
}


if (!empty($_GET['edit'])) {
    $arryCompany = $objCompany->GetCompany($_GET['edit'], '');
    $CmpID = $_REQUEST['edit'];


    /*     * ************ */
    if (empty($arryCompany[0]['CmpID'])) {
        header("Location:" . $RedirectURL);
        exit;
    }

    if ($_SESSION['CrmRsID'] != $arryCompany[0]['RsID']) {
        header("Location:" . $RedirectURL);
        exit;
    }

    /*     * ************ */
}

if ($arryCompany[0]['Status'] != '') {
    $CompanyStatus = $arryCompany[0]['Status'];
} else {
    $CompanyStatus = 1;
}

$arrayDateFormat = $objConfig->GetDateFormat();
$arryDepartment = $objConfig->GetDepartment();
$arryCountry = $objRegion->getCountry('', '');
$arryCurrency = $objRegion->getCurrency('', 1);

//$HideModule = 'Style="display:none"';
$HideRow = 'Style="display:none"';
include ('includes/footer.php');
?>