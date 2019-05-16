<?php 
                if(!empty($_GET['tempid']) && !empty($_GET['o'])){
//                    die('www');
		$_GET['id']=$_GET['tempid'];
		$_GET['ModuleName']='Sales';
            	$_GET['Module']='Sales'.$_GET['module'];
            	$_GET['ModuleId']=$_GET['o'];
            	$recordpdftemp=$objSale->GetSalesPdfTemplate($_GET);
                }
                //echo '<pre>'; print_r($recordpdftemp);die;
                /**start company tab***/
                $logoSize=(!empty($recordpdftemp[0]['LogoSize']))?($recordpdftemp[0]['LogoSize']):('100');
//                echo $logoSize;die;
                $CompanyAlign=(!empty($recordpdftemp[0]['CompanyFieldAlign']))?($recordpdftemp[0]['CompanyFieldAlign']):('left');
                $cmpalign=($CompanyAlign=='right')?("text-align:right"):("text-align:left");
                $CompanyColor=(!empty($recordpdftemp[0]['CompanyColor']))?($recordpdftemp[0]['CompanyColor']):('#000;');
                
                $CompanyFieldSize=(!empty($recordpdftemp[0]['CompanyFieldFontSize']))?($recordpdftemp[0]['CompanyFieldFontSize']):('12');
                $CompanyColorHeading=(!empty($recordpdftemp[0]['CompanyHeadColor']))?($recordpdftemp[0]['CompanyHeadColor']):('#000;');
                
                $CompanyHeadingFieldSize=(!empty($recordpdftemp[0]['CompanyHeadingFontSize']))?($recordpdftemp[0]['CompanyHeadingFontSize']):('22');
                /**End company tab***/
                
                
                /***Start Title tab ***/
                $TitleFontSize=(!empty($recordpdftemp[0]['TitleFontSize']))?($recordpdftemp[0]['TitleFontSize']):('20');
                $TitleColor=(!empty($recordpdftemp[0]['TitleColor']))?($recordpdftemp[0]['TitleColor']):('#000');
                $TitleWeight=(!empty($recordpdftemp[0]['Title']))?($recordpdftemp[0]['Title']):('bold');
                
                /***END title tab **/
                /***Start information tab ***/
                $informationAlign=(!empty($recordpdftemp[0]['InformationFieldAlign']))?($recordpdftemp[0]['InformationFieldAlign']):('right');
                $logoAlign=($CompanyAlign=='right')?('right'):('left');
                $informationpadding=($informationAlign=='left')?('5px 0px'):('5px 10px');
                $informationFontSize=(!empty($recordpdftemp[0]['InformationFieldFontSize']))?($recordpdftemp[0]['InformationFieldFontSize']):('12');
                $informationFieldColor=(!empty($recordpdftemp[0]['InformationColor']))?($recordpdftemp[0]['InformationColor']):('#000');
                
                 /***End information tab ***/
                
                /**start Billing Tab****/
                $BillingAlign=(!empty($recordpdftemp[0]['BillAdd_Heading_FieldAlign']))?($recordpdftemp[0]['BillAdd_Heading_FieldAlign']):('left');
                $BillingFieldFontSize=(!empty($recordpdftemp[0]['BillAdd_Heading_FieldFontSize']))?($recordpdftemp[0]['BillAdd_Heading_FieldFontSize']):('12');
                $BillingFieldColor=(!empty($recordpdftemp[0]['BillAddColor']))?($recordpdftemp[0]['BillAddColor']):('#000');
                $BillingHeadingBold=(!empty($recordpdftemp[0]['BillAddHeading']))?($recordpdftemp[0]['BillAddHeading']):('normal');
                $BillingHeadColor=(!empty($recordpdftemp[0]['BillHeadColor']))?($recordpdftemp[0]['BillHeadColor']):('#fff');
                $BillingHeadbackColor=(!empty($recordpdftemp[0]['BillHeadbackgroundColor']))?($recordpdftemp[0]['BillHeadbackgroundColor']):('#004269');
                
                /**End Billing Tab****/
                
                /**start Shipping Tab***/
                $ShippingAlign=(!empty($recordpdftemp[0]['ShippAdd_Heading_FieldAlign']))?($recordpdftemp[0]['ShippAdd_Heading_FieldAlign']):('right');
                $ShippingFieldFontSize=(!empty($recordpdftemp[0]['ShippAdd_Heading_FieldFontSize']))?($recordpdftemp[0]['ShippAdd_Heading_FieldFontSize']):('12');
                $ShippingFieldColor=(!empty($recordpdftemp[0]['ShippAddColor']))?($recordpdftemp[0]['ShippAddColor']):('#000');
                $ShippingHeadingBold=(!empty($recordpdftemp[0]['ShippAddHeading']))?($recordpdftemp[0]['ShippAddHeading']):('normal');
                $ShippingHeadColor=(!empty($recordpdftemp[0]['ShippHeadColor']))?($recordpdftemp[0]['ShippHeadColor']):('#fff');
                $ShippingHeadbackColor=(!empty($recordpdftemp[0]['ShippHeadbackgroundColor']))?($recordpdftemp[0]['ShippHeadbackgroundColor']):('#004269');
                /**End Shipping Tab***/
                
                
                /**Start Line Item Tab**/
                
                $LineItemFontSize=(!empty($recordpdftemp[0]['LineItemHeadingFontSize']))?($recordpdftemp[0]['LineItemHeadingFontSize']):('12');
                $LineItemFieldColor=(!empty($recordpdftemp[0]['LineColor']))?($recordpdftemp[0]['LineColor']):('#000');
                $LineItemHeadingBold=(!empty($recordpdftemp[0]['LineHeading']))?($recordpdftemp[0]['LineHeading']):('normal');
                $LineHeadColor=(!empty($recordpdftemp[0]['LineHeadColor']))?($recordpdftemp[0]['LineHeadColor']):('#fff');
                $LineHeadbackColor=(!empty($recordpdftemp[0]['LineHeadbackgroundColor']))?($recordpdftemp[0]['LineHeadbackgroundColor']):('#004269');
                
                /**End line Item Tab**/
                
                
                /***start Special Tab****/
                $specialAlign=(!empty($recordpdftemp[0]['SpecialFieldAlign']))?($recordpdftemp[0]['SpecialFieldAlign']):('left');
                $specialHeadcolor=(!empty($recordpdftemp[0]['SpecialHeadColor']))?($recordpdftemp[0]['SpecialHeadColor']):('#fff');
                $specialHeadbackColor=(!empty($recordpdftemp[0]['SpecialHeadbackgroundColor']))?($recordpdftemp[0]['SpecialHeadbackgroundColor']):('#004269');
                $specialFieldFontSize=(!empty($recordpdftemp[0]['SpecialHeadingFontSize']))?($recordpdftemp[0]['SpecialHeadingFontSize']):('11');
                $specialFieldColor=(!empty($recordpdftemp[0]['SpecialFieldColor']))?($recordpdftemp[0]['SpecialFieldColor']):('#000');
                $specialHeadFontSize=$specialFieldFontSize+1;
                $thanksFontSize=$specialFieldFontSize+2;
                $specialHeadingBold=(!empty($recordpdftemp[0]['SpecialHeading']))?($recordpdftemp[0]['SpecialHeading']):('normal');
                
                /***end Special Tab****/
                
                
                /**start sales Pdf content**/
                
                //billing address
                $Address = (!empty($arrySale[0]['Address']))?(str_replace("\n"," ",stripslashes($arrySale[0]['Address']))):(NOT_MENTIONED);
                $BillCustomerCompany=(!empty($arrySale[0]['CustomerCompany']))?(stripslashes($arrySale[0]['CustomerCompany'])):(NOT_MENTIONED);
                $Billcity=(!empty($arrySale[0]['City']))?(stripslashes($arrySale[0]['City'])):(NOT_MENTIONED);
                $BillState=(!empty($arrySale[0]['State']))?(stripslashes($arrySale[0]['State'])):(NOT_MENTIONED);
                $BillCountry=(!empty($arrySale[0]['Country']))?(stripslashes($arrySale[0]['Country'])):(NOT_MENTIONED);
                $BillZipCode=(!empty($arrySale[0]['ZipCode']))?(stripslashes($arrySale[0]['ZipCode'])):(NOT_MENTIONED);
                $BillMobile=(!empty($arrySale[0]['Mobile']))?(stripslashes($arrySale[0]['Mobile'])):(NOT_MENTIONED);
                $BillLandline=(!empty($arrySale[0]['Landline']))?(stripslashes($arrySale[0]['Landline'])):(NOT_MENTIONED);
                $BillEmail=(!empty($arrySale[0]['Email']))?(stripslashes($arrySale[0]['Email'])):(NOT_MENTIONED);
                $BillCurrency=(!empty($arrySale[0]['CustomerCurrency']))?(stripslashes($arrySale[0]['CustomerCurrency'])):(NOT_MENTIONED);
                
                
                //shipping address
                $ShippingAddress = (!empty($arrySale[0]['ShippingAddress']))?(str_replace("\n"," ",stripslashes($arrySale[0]['ShippingAddress']))):(NOT_MENTIONED);
                $ShippCustomerCompany=(!empty($arrySale[0]['ShippingCompany']))?(stripslashes($arrySale[0]['ShippingCompany'])):(NOT_MENTIONED);
                $Shippcity=(!empty($arrySale[0]['ShippingCity']))?(stripslashes($arrySale[0]['ShippingCity'])):(NOT_MENTIONED);
                $ShippState=(!empty($arrySale[0]['ShippingState']))?(stripslashes($arrySale[0]['ShippingState'])):(NOT_MENTIONED);
                $ShippCountry=(!empty($arrySale[0]['ShippingCountry']))?(stripslashes($arrySale[0]['ShippingCountry'])):(NOT_MENTIONED);
                $ShippZipCode=(!empty($arrySale[0]['ShippingZipCode']))?(stripslashes($arrySale[0]['ShippingZipCode'])):(NOT_MENTIONED);
                $ShippMobile=(!empty($arrySale[0]['ShippingMobile']))?(stripslashes($arrySale[0]['ShippingMobile'])):(NOT_MENTIONED);
                $ShippLandline=(!empty($arrySale[0]['ShippingLandline']))?(stripslashes($arrySale[0]['ShippingLandline'])):(NOT_MENTIONED);
                $ShippEmail=(!empty($arrySale[0]['ShippingEmail']))?(stripslashes($arrySale[0]['ShippingEmail'])):(NOT_MENTIONED);
                $ShippCurrency=(!empty($arrySale[0]['CustomerCurrency']))?(stripslashes($arrySale[0]['CustomerCurrency'])):(NOT_MENTIONED);
                
                
                
                /**end sales Pdf content**/


?>
