<?php 
	if(!empty($_GET['pop']))$HideNavigation = 1;
	$SetFullPage = 1;
	/**************************************************/
	$ThisPageName = 'viewSalesQuoteOrder.php';
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/inv_tax.class.php");
	require_once($Prefix."classes/sales.class.php");
        require_once("../includes/pdf_comman.php");
	$objSale = new sale();
	$objTax = new tax();
	(!$_GET['module'])?($_GET['module']='Quote'):(""); 
	$module = $_GET['module'];
	$ModuleName = "Sale ".$_GET['module'];

	$RedirectURL = "editcustompdf.php?module=".$module."&curP=".$_GET['curP']."&view=".$_GET["view"]."&tempid=".$_GET["tempid"];
	$EditUrl = "editSalesQuoteOrder.php?edit=".$_GET["view"]."&module=".$module."&curP=".$_GET["curP"]; 
	$DownloadUrl = "pdfSO.php?o=".$_GET["view"]."&module=".$module;
        $editsalespdf="editcustompdf.php?module=".$module."&curP=".$_GET['curP']."&view".$_GET["view"];
        $AddredirectURL="vSalesQuoteOrder.php?module=".$module."&curP=".$_GET['curP']."&view=".$_GET["view"];
        $convertUrl = "vSalesQuoteOrder.php?module=".$module."&curP=".$_GET["curP"]."&view=".$_GET["view"]."&convert=1"; 




	if($_GET['module']=='Quote'){	
		$ModuleIDTitle = "Quote Number"; $ModuleID = "QuoteID"; $PrefixPO = "QT";  $NotExist = NOT_EXIST_QUOTE; 
	}else{
		$ModuleIDTitle = "Sales Order Number"; $ModuleID = "SaleID"; $PrefixPO = "PO";  $NotExist = NOT_EXIST_ORDER;
	}
        
        
        /**code by sachin 17-11**/
        //echo '<pre>'; print_r($arryCompany);die;
        if(!empty($_GET['view']) && !empty($_GET['tempid'])){
            $_GET['ModuleName']='Sales';
            $_GET['Module']='Sales'.$_GET['module'];
            $_GET['ModuleId']=$_GET['view'];
            $_GET['id']=$_GET['tempid'];
        $GetPFdTempalteVal=$objSale->GetSalesPdfTemplate($_GET);
        //echo '<pre>'; print_r($GetPFdTempalteVal); die;
        }
        
        if($GetPFdTempalteVal[0]['id'] > 0) 
        {
            if(($_POST['Update']=='Update') && !empty($_GET['view'])){
                
                $_POST['ModuleName']='Sales';
                $objSale->UpdateSalesPdfTempalte($_POST);
                $_SESSION['mess_Sale'] = PDF_TEMPLATE_UPDATED;
                header("Location:".$RedirectURL);
                exit;
                }
            
        }else{
           
            if(($_POST['Save']=='Save') && !empty($_GET['view'])){
                //echo '<pre>'; print_r($_POST);die('add');
                if(!empty($_POST['TemplateName'])){
                $_POST['ModuleName']='Sales';
                $objSale->SaveSalesPdfTempalte($_POST);
                $_SESSION['mess_Sale'] = PDF_TEMPLATE_ADDED;
                header("Location:".$AddredirectURL);
                exit;
                }
                else{
                    
                   $_SESSION['mess_dynamicpdf']="Please Enter Template Name";
                   header("Location:".$RedirectURL);
                   exit;
                }
                }
        }
        
	/**code by sachin 17-11**/
        //code for delete tempname
        if(!empty($_GET['Deltempid']) && !empty($_GET['Deltempid'])){
            $DeleteArray=array();
            $DeleteArray=array('ModuleName'=>'Sales','Module'=>'Sales'.$module, 'ModuleId'=>$_GET['view'],'id'=>$_GET['Deltempid']);
            $objSale->DeleteTemplateName($DeleteArray);
            header("Location:".$AddredirectURL);
            exit;
        }
        
        /**code by sachin 16-11**/
        $col='12';
        $FieldFontSize='Field Font Size :';
        $FieldAlign='Field Align :';
        $TabFontSize='Heading Font Size :';
        $TabAlign='Heading Align :';
        $Tab='Heading :';
        $ItemHeading='Item Heading :';
        $ItemFontSize='Item Font Size :';
        //$FieldSizeArry=array(9,10,11,12,13,14,15,16,17,18,19,20,22);
        $FieldSizeArry=array(9,10,11,12,13,14);
        //$HeadingSizeArry=array(9,10,11,12,13,14,15,16,17,18,19,20,22,24,25,26);
        //$HeadingSizeArry=array(9,10,11,12,13,14,15,16,17,18,19,20,21,22);
        $HeadingSizeArry=array(14,15,16,17,18,19,20,21,22);
        $lineItemHeadFontSize=array(8,9,10,11,12);
        $borderarry=array('Yes'=>'1','No'=>'0');
        $AlignArry=array('Left','Right');
        //$AlignArryTitle=array('left','right','center');
        $AlignArryTitle=array('Left'=>'left','Right'=>'right');
        $Color=array('Red'=>'#ff0000','Blue'=>'#004269','Purple'=>'#800080','Black'=>'#000000','white'=>'#fff','Green'=>'#266A2E','Grey'=>'#d3d3d3','Pink'=>'#C71585','Yellow'=>'#FFFF00');
        $logosize=array(100,150,200);
        $HeadingArry=array('Bold'=>'bold','Normal'=>'normal');
        $FieldFontSizeName='FieldFontSize';
        $FieldAlignName='FieldAlign';
        $HeadingFontSizeName='HeadingFontSize';
        $HeadingAlignName='HeadingAlign';
        $HeadingName='Heading';
        $ItemHeadingName='Heading';
        $ItemFontSizeName='FontSize';
        /**code by sachin 16-11**/
	require_once("../includes/footer.php"); 	 
?>


