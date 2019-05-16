<?php

if (!empty($_GET['tempid']) && !empty($_GET['o'])) {

    $_GET['id'] = $_GET['tempid'];
    $_GET['ModuleName'] = $ModDepName;
    $_GET['Module'] = $ModDepName . $_GET['module'];
    $_GET['ModuleId'] = $_GET['o'];
    //echo '<pre>';print_r($_GET);die('oop');
    $recordpdftemp = $objConfig->GetSalesPdfTemplate($_GET);
}
//echo '<pre>'; print_r($recordpdftemp);die;
/* * start company tab** */
$logoSize = (!empty($recordpdftemp[0]['LogoSize'])) ? ($recordpdftemp[0]['LogoSize']) : ('100');
//                echo $logoSize;die;
$CompanyAlign = (!empty($recordpdftemp[0]['CompanyFieldAlign'])) ? ($recordpdftemp[0]['CompanyFieldAlign']) : ('left');
$cmpalign = ($CompanyAlign == 'right') ? ("text-align:right") : ("text-align:left");
$CompanyColor = (!empty($recordpdftemp[0]['CompanyColor'])) ? ($recordpdftemp[0]['CompanyColor']) : ('#000;');

$CompanyFieldSize = (!empty($recordpdftemp[0]['CompanyFieldFontSize'])) ? ($recordpdftemp[0]['CompanyFieldFontSize']) : ('12');
$CompanyColorHeading = (!empty($recordpdftemp[0]['CompanyHeadColor'])) ? ($recordpdftemp[0]['CompanyHeadColor']) : ('#000;');

$CompanyHeadingFieldSize = (!empty($recordpdftemp[0]['CompanyHeadingFontSize'])) ? ($recordpdftemp[0]['CompanyHeadingFontSize']) : ('22');
/* * End company tab** */


/* * *Start Title tab ** */
$TitleFontSize = (!empty($recordpdftemp[0]['TitleFontSize'])) ? ($recordpdftemp[0]['TitleFontSize']) : ('20');
$TitleColor = (!empty($recordpdftemp[0]['TitleColor'])) ? ($recordpdftemp[0]['TitleColor']) : ('#000');
$TitleWeight = (!empty($recordpdftemp[0]['Title'])) ? ($recordpdftemp[0]['Title']) : ('');

/* * *END title tab * */
/* * *Start information tab ** */
$informationAlign = (!empty($recordpdftemp[0]['InformationFieldAlign'])) ? ($recordpdftemp[0]['InformationFieldAlign']) : ('right');
$logoAlign = ($CompanyAlign == 'right') ? ('right') : ('left');
//$informationpadding = ($informationAlign == 'left') ? ('5px 0px') : ('5px 10px');
$informationpadding = ($informationAlign == 'left') ? ('5px 10px') : ('5px -16px');
$informationpaddingbl = ($informationAlign == 'left') ? ('5px 10px') : ('5px -11px');
$infoNewAlign=($informationAlign == 'left') ? ('left') : ('right');
$infoNewMargin=($informationAlign == 'left') ? ('0') : ('200');
$informationFontSize = (!empty($recordpdftemp[0]['InformationFieldFontSize'])) ? ($recordpdftemp[0]['InformationFieldFontSize']) : ('12');
$informationFieldColor = (!empty($recordpdftemp[0]['InformationColor'])) ? ($recordpdftemp[0]['InformationColor']) : ('#000');

/* * *End information tab ** */

/* * start Billing Tab*** */
$BillingAlign = (!empty($recordpdftemp[0]['BillAdd_Heading_FieldAlign'])) ? ($recordpdftemp[0]['BillAdd_Heading_FieldAlign']) : ('left');
$BillingFieldFontSize = (!empty($recordpdftemp[0]['BillAdd_Heading_FieldFontSize'])) ? ($recordpdftemp[0]['BillAdd_Heading_FieldFontSize']) : ('12');
$BillingFieldColor = (!empty($recordpdftemp[0]['BillAddColor'])) ? ($recordpdftemp[0]['BillAddColor']) : ('#000');
$BillingHeadingBold = (!empty($recordpdftemp[0]['BillAddHeading'])) ? ($recordpdftemp[0]['BillAddHeading']) : ('normal');
$BillingHeadColor = (!empty($recordpdftemp[0]['BillHeadColor'])) ? ($recordpdftemp[0]['BillHeadColor']) : ('#fff');
$BillingHeadbackColor = (!empty($recordpdftemp[0]['BillHeadbackgroundColor'])) ? ($recordpdftemp[0]['BillHeadbackgroundColor']) : ('#004269');

/* * End Billing Tab*** */

/* * start Shipping Tab** */
$ShippingAlign = (!empty($recordpdftemp[0]['ShippAdd_Heading_FieldAlign'])) ? ($recordpdftemp[0]['ShippAdd_Heading_FieldAlign']) : ('right');
$ShippingFieldFontSize = (!empty($recordpdftemp[0]['ShippAdd_Heading_FieldFontSize'])) ? ($recordpdftemp[0]['ShippAdd_Heading_FieldFontSize']) : ('12');
$ShippingFieldColor = (!empty($recordpdftemp[0]['ShippAddColor'])) ? ($recordpdftemp[0]['ShippAddColor']) : ('#000');
$ShippingHeadingBold = (!empty($recordpdftemp[0]['ShippAddHeading'])) ? ($recordpdftemp[0]['ShippAddHeading']) : ('normal');
$ShippingHeadColor = (!empty($recordpdftemp[0]['ShippHeadColor'])) ? ($recordpdftemp[0]['ShippHeadColor']) : ('#fff');
$ShippingHeadbackColor = (!empty($recordpdftemp[0]['ShippHeadbackgroundColor'])) ? ($recordpdftemp[0]['ShippHeadbackgroundColor']) : ('#004269');
/* * End Shipping Tab** */


/* * Start Line Item Tab* */

$LineItemFontSize = (!empty($recordpdftemp[0]['LineItemHeadingFontSize'])) ? ($recordpdftemp[0]['LineItemHeadingFontSize']) : ('12');
$LineItemFieldColor = (!empty($recordpdftemp[0]['LineColor'])) ? ($recordpdftemp[0]['LineColor']) : ('#000');
$LineItemHeadingBold = (!empty($recordpdftemp[0]['LineHeading'])) ? ($recordpdftemp[0]['LineHeading']) : ('normal');
$LineHeadColor = (!empty($recordpdftemp[0]['LineHeadColor'])) ? ($recordpdftemp[0]['LineHeadColor']) : ('#fff');
$LineHeadbackColor = (!empty($recordpdftemp[0]['LineHeadbackgroundColor'])) ? ($recordpdftemp[0]['LineHeadbackgroundColor']) : ('#004269');

/* * End line Item Tab* */


/* * *start Special Tab*** */
$specialAlign = (!empty($recordpdftemp[0]['SpecialFieldAlign'])) ? ($recordpdftemp[0]['SpecialFieldAlign']) : ('left');
$specialHeadcolor = (!empty($recordpdftemp[0]['SpecialHeadColor'])) ? ($recordpdftemp[0]['SpecialHeadColor']) : ('#fff');
$specialHeadbackColor = (!empty($recordpdftemp[0]['SpecialHeadbackgroundColor'])) ? ($recordpdftemp[0]['SpecialHeadbackgroundColor']) : ('#004269');
$specialFieldFontSize = (!empty($recordpdftemp[0]['SpecialHeadingFontSize'])) ? ($recordpdftemp[0]['SpecialHeadingFontSize']) : ('11');
$specialFieldColor = (!empty($recordpdftemp[0]['SpecialFieldColor'])) ? ($recordpdftemp[0]['SpecialFieldColor']) : ('#000');
$specialHeadFontSize = $specialFieldFontSize + 1;
$thanksFontSize = $specialFieldFontSize + 2;
$specialHeadingBold = (!empty($recordpdftemp[0]['SpecialHeading'])) ? ($recordpdftemp[0]['SpecialHeading']) : ('normal');

/* * *end Special Tab*** */
$FooterContent = (!empty($recordpdftemp[0]['FooterContent'])) ? ($recordpdftemp[0]['FooterContent'] . '<br/><br/>') : ('Demo Footer Content');
/* * *Start Footer Content** */

/* * *End Footer Content** */


/**Start Show Hide Sku item***/
$ConditionDisplay = (!empty($recordpdftemp[0]['ConditionDisplay'])) ? ($recordpdftemp[0]['ConditionDisplay']) : ('show');
$DiscountDisplay = (!empty($recordpdftemp[0]['DiscountDisplay'])) ? ($recordpdftemp[0]['DiscountDisplay']) : ('show');

$LogoDisplay = (!empty($recordpdftemp[0]['LogoDisplay'])) ? ($recordpdftemp[0]['LogoDisplay']) : ('show');
$AddressDisplay = (!empty($recordpdftemp[0]['AddressDisplay'])) ? ($recordpdftemp[0]['AddressDisplay']) : ('show');
/**End Show Hide Sku item**/

/* * *Pdf Comman Header** */
require_once("comman_pdf_header.php");
/* * start code for dynamic pdf Html by sachin* */
?>
