<? 	ob_start();
	session_start();
 


    require_once("includes/config.php");
    require_once("includes/language.php");
    require_once("includes/ecom_function.php");
 
    require_once("classes/dbClass.php");
    require_once("classes/admin.class.php");	
  
    require_once("classes/company.class.php");
     
    require_once("classes/MyMailer.php");
    include_once("classes/paging.class.php");
   
    require_once("classes/region.class.php");
    require_once("classes/payment.class.php");
    require_once("language/english.php");
 
    require_once("classes/category.class.php");	 //include ecom classes
   
    require_once("classes/product.class.php");
    require_once("classes/manufacturer.class.php");
    require_once("classes/customer.class.php");
    require_once("classes/orders.class.php");
    require_once("classes/cms.class.php");	
    require_once("classes/recent.class.php");
    require_once("classes/cartsettings.class.php");
     require_once("classes/discount.class.php");
    

  
 
	////////////////////////////////////////////////////////////
	(empty($_GET['curP']))?($_GET['curP']=1):(""); 
	
	$objPager = new pager();
          
	$objConfig = new admin();	
        
	$objCompany = new company(); 
	$objRegion = new region();
        $objRecent = new RecentItems();
         
	$arrayConfig = $objConfig->GetSiteSettings(1);	         
	$arrayAdmin = $objConfig->GetAdmin(1);
	//$arraySignature = $objConfig->GetSignature(10,1);
	$arryCountry = $objRegion->getCountry('','');
	$RecordsPerPage = $arrayConfig[0]['RecordsPerPage'];
	
	//if(!empty($arraySignature[0]['PageContent'])) $Config['MailFooter'] = stripslashes($arraySignature[0]['PageContent']);


	/**** Currency Area ****/
            $arryTopCurrency = $objRegion->getCurrency('',1);
            $arryCurrency = $objRegion->getUpdatedCurrency($_SESSION['currency_id'],'');

	//$Config['CurrencyValue'] = $arryCurrency[0]['currency_value'];
	/************************************************/



	/************************************/
	//Company Database Connection Start
	/************************************/
      
                
	if(!empty($_GET["c"])){
		$arryCompany = $objCompany->GetCompanyByDisplay($_GET["c"]);
                
                if(empty($arryCompany[0]['Department'])) $arryCompany[0]['Department']=2;
   
		if(empty($arryCompany[0]["CmpID"]) || substr_count($arryCompany[0]['Department'],2)==0){
			$ErrorMsg = ERROR_INACTIVE_PAGE;
			$WebUrl = $Config['Url']."eznetcrm/404-error";
			header("location:".$WebUrl);
			exit;
		}else{
			$Config['DisplayName'] = $arryCompany[0]["DisplayName"];
			$Config['TodayDate'] = getLocalTime($arryCompany[0]['Timezone']);

			$Config['homeCompleteUrl'] = $Config['Url'].$Config['DisplayName'];
			$Config['DateFormat'] = $arryCompany[0]['DateFormat'];

			$Config['SiteName']  = stripslashes($arryCompany[0]['DisplayName']);        
			$Config['SiteTitle'] = stripslashes($arryCompany[0]['CompanyName']);
			$Config['CmpID'] = stripslashes($arryCompany[0]['CmpID']);

			$Config['CompanyEmail'] = $arryCompany[0]["Email"];;
			$Config['PaypalID'] = $arryCompany[0]['PaypalID'];
			$Config['country_id'] = $arryCompany[0]['country_id'];
			$Config['MailFooter'] = '['.stripslashes($arryCompany[0]['CompanyName']).']';
                                                
			/******************************/
                         
                          
		if(!empty($_GET['curr_id'])){
			$_SESSION['currency_id']=$_GET['curr_id'];
		}else if(empty($_SESSION['currency_id'])){
			$_SESSION['currency_id']=$arryCompany[0]['currency_id'];

		}

		if($arryCompany[0]['currency_id']>0){
		$arryDbCurrency = $objRegion->getCurrency($arryCompany[0]['currency_id'],'');

		}
                         
			if($_SESSION['currency_id']>0){
				$arrySelCurrency = $objRegion->getCurrency($_SESSION['currency_id'],'');
				$Config['Currency'] = $arrySelCurrency[0]['code'];
				$Config['CurrencySymbol'] = $arrySelCurrency[0]['symbol_left'];
				$Config['CurrencySymbolRight'] = $arrySelCurrency[0]['symbol_right'];
                                $Config['CurrencyCompanyVal'] = $arrySelCurrency[0]['currency_value'];
                                
			       $Config['CurrencyValue'] = $arrySelCurrency[0]['currency_value']/$arryDbCurrency[0]['currency_value'];
			}
			/******************************/
			$Config['DbName2'] = $Config['DbName']."_".$arryCompany[0]["DisplayName"];
                       
			if(!$objConfig->connect_check()){
				$ErrorMsg = ERROR_NO_DB;
			}else{
				$Config['DbName'] = $Config['DbName2'];
                                $_SESSION['CmpDatabase'] = $Config['DbName'];
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();
			}
		}
	}else{
		$ErrorMsg = ERROR_INACTIVE_PAGE;
	}
	/************************************/
	//Company Database Connection End
	/************************************/

        

	if(empty($ErrorMsg)){
		$ThisPage = GetPage(); 
		$SelfPage = $ThisPage;
		
		$objCategory = new category();
		$objProduct = new product();
		$cmsObj = new cms();	
		$objCustomer= new Customer();
		$objOrder= new orders();
                $objManufacturer= new manufacturer();
                $objcartsettings = new Cartsettings();
                $objPayment = new payment();
                $objDiscount = new discount();
		
		$arryTopCategory=$objCategory->GetParentCategories(1);
                
                /****************************/
                  
                    $arryManufacturer = $objManufacturer->getManufacturer('',1,'','','');
                    $numManufacturer = sizeof($arryManufacturer);
	          /****************************/	
                    
                  /************************************************/
                    $arryPages=$cmsObj->getPagesforFront();
                   
                  /*************************************************/  
                
             
		
	}
       else{
                   echo '<div style="text-align: center; padding: 100px;">'.$ErrorMsg.'</div>';exit;
       }
       
        /****************************************Code For Get Title,Meta Keywords ,Meta Description(SEO URLS)*****************************************************************/
        $pageName = basename($_SERVER['PHP_SELF']); // Get script filename without any path information
        $pageName = str_replace( array( '.php', '.htm', '.html' ), '', $pageName ); // Remove extensions
        $pageName = str_replace( array('-', '_'), ' ', $pageName); // Change underscores/hyphens to spaces
        $pageName = ucwords( $pageName ); // uppercase first letter of every word

      
           $url = $_GET["url"];
            if(!empty($url)){
                $urlMd5 = md5($url);
                $arryPageId=$cmsObj->getPageIdByHash($urlMd5);
            }


           if(!empty($arryPageId[0]['PageId'])){$pageId = $arryPageId[0]['PageId'];}else{$pageId = $_GET['page_id'];}

            if(!empty($pageId))
            {
              $arryPage=$cmsObj->getPageById($pageId);
              $num=$cmsObj->numRows();
            }
            
            //Get Title,Meta Keywords , Meta Description Form Category And Products
            
           if(!empty($_GET['cat']))
           {
               $arrayCategory = $objCategory->GetCategory($_GET['cat'],0);
               $MetaTitleCat = !empty($arrayCategory[0]['MetaTitle'])?$arrayCategory[0]['MetaTitle']:$arrayCategory[0]['Name'];
               $MetaKeywordCat = !empty($arrayCategory[0]['MetaKeyword'])?$arrayCategory[0]['MetaKeyword']:$MetaTitleCat;
               $MetaDescriptionCat = !empty($arrayCategory[0]['MetaDescription'])?$arrayCategory[0]['MetaDescription']:"";
           }
           
         
            
           if(!empty($_GET['id']))
           {
               $arrayProduct = $objProduct->GetProductById($_GET['id']);
               $MetaTitleProd = !empty($arrayProduct[0]['MetaTitle'])?$arrayProduct[0]['MetaTitle']:$arrayProduct[0]['Name'];
               $MetaKeywordProd = !empty($arrayProduct[0]['MetaKeywords'])?$arrayProduct[0]['MetaKeywords']:$MetaTitleProd;
               $MetaDescriptionProd = !empty($arrayProduct[0]['MetaDescription'])?$arrayProduct[0]['MetaDescription']:"";
           }
            
          
        //For Title    
        if(!empty($arryPage[0]['MetaTitle'])){
                $MetaTitle = stripslashes($arryPage[0]['MetaTitle']);
        }else if (!empty($_GET['cat'])){
             $MetaTitle = stripslashes($MetaTitleCat);
        }else if (!empty($_GET['id'])){
             $MetaTitle = stripslashes($MetaTitleProd);
        }else{
              if($pageName != "Index")
                $MetaTitle = $pageName;
                else
                 $MetaTitle = $Config['SiteTitle'];
        }       
            
            
        
        //For Description
        if(!empty($arryPage[0]['MetaDescription'])){
                $MetaDescription = '<meta name="description" content="'.stripslashes($arryPage[0]['MetaDescription']).'" />';
        }else if (!empty($_GET['cat'])){
              $MetaDescription = '<meta name="description" content="'.stripslashes($MetaDescriptionCat).'" />';
        }else if (!empty($_GET['id'])){
              $MetaDescription = '<meta name="description" content="'.stripslashes($MetaDescriptionProd).'" />';
        }else{
                $MetaDescription = '';
        }
        
        //For Keywords
        if(!empty($arryPage[0]['MetaKeywords'])){
                $MetaKeywords = '<meta name="keywords" content="'.stripslashes($arryPage[0]['MetaKeywords']).'" />';
        }else if (!empty($_GET['cat'])){
             $MetaKeywords = '<meta name="keywords" content="'.stripslashes($MetaKeywordCat).'" />';
        }else if (!empty($_GET['id'])){
             $MetaKeywords = '<meta name="keywords" content="'.stripslashes($MetaKeywordProd).'" />';
        }else{
                $MetaKeywords = '';
        }
        
      /*********************************************End Code************************************************************************************/
        
        
        //Get Recent Items
          $recent_items = $objRecent->getRecentItems();
        //end code
          
        
          
          //Get Cart Settings
           $arryCartSetting = $objcartsettings->getCartsettings();
           $settings = array();
           
           foreach($arryCartSetting as $field)
           {
              $settings[$field["Name"]] = $field["Value"];
           }
          
           $Config['StoreName'] =  $settings['StoreName'];
           $Config['CompanyEmail'] =  $settings['CompanyEmail'];
           $Config['NotificationEmail'] =  $settings['NotificationEmail'];
           
                               
            if(!empty($settings['paypalipn_Currency_Code'])){
               $paypalipn_Currency_Code = $settings['paypalipn_Currency_Code'];
           }else{
               $paypalipn_Currency_Code = "USD";
           }
           $Config['paypalipn_Currency_Code'] =  $paypalipn_Currency_Code;
           
         
            
           
            if($settings['StoreClosed'] == "Yes")
            {
                if(!empty($settings['StoreClosedMessage'])){
                 $ErrorMsg = $settings['StoreClosedMessage'];
                }else{
                    $ErrorMsg = ERROR_INACTIVE_PAGE;
                }
                echo '<div style="text-align: center; padding: 100px; font-size:18px;">'.$ErrorMsg.'</div>';exit;

             }
           //echo "=>".$FacebookLikeButton;exit;
          //Get Best Seller Items
           $bestseller_items = $objProduct->getItemsBestSellers($settings);
         
	$SelfPageUrl = $ThisPage;
	
	$QueryString  = str_replace("curr_id=".$_SESSION['currency_id'],"",$_SERVER['QUERY_STRING']);
	$QueryString  = str_replace("&&","",$QueryString);
	
	if($QueryString != ''){
		$SelfPageUrl .= '?'.$QueryString;
		$CurrActionUrl = $SelfPageUrl.'&';
	}else{
		$CurrActionUrl = $SelfPageUrl.'?';
	}
	
	$CurrActionUrl  = str_replace("&&","&",$CurrActionUrl);
        
        /**************************************************/
         if(empty($_SESSION["guestId"])){
         $Cid = (!empty($_SESSION['Cid']))?($_SESSION['Cid']):(session_id());
        }else{
            $Cid = isset($_SESSION["guestId"])?$_SESSION["guestId"]:"";
        }
           	
           $arryNumCart = $objOrder->GetNumItemCart($Cid);
           $TotalCartPrice = $arryNumCart[0]['TotalCartPrice']+$arryNumCart[0]['TotalCartTax'];
       /**************************************************/
      
?>
