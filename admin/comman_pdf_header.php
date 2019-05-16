<?php 
//echo $LogoDisplay;
                /***Pdf Comman Header***/
              
        if(IsFileExist($Config['CmpDir'],$arryCompany[0]['Image'])){//cmp logo

		/*$arrayFileInfo = GetFileInfo($Config['CmpDir'],$arryCompany[0]['Image']);
		if($arrayFileInfo[0]>350 || $arrayFileInfo[1]>150){	
			$PreviewArray['Width'] = "150";
			$PreviewArray['Height'] = "150"; 
			$LogoStyle = '';
		} */
		$PreviewArray['Folder'] = $Config['CmpDir'];
		$PreviewArray['FileName'] = $arryCompany[0]['Image']; 
		$PreviewArray['FileTitle'] = stripslashes($Config['SiteName']); 
		$PreviewArray['GetImagePath'] = 1;

		$SiteLogo = PreviewImage($PreviewArray); 

 		
 
                    
        }else if(!empty($_SESSION['CmpLogin'])){
                        $SiteLogo = $Prefix.'images/logo_crm.png';		
        }else{
                $SiteLogo = $Prefix.'images/logo.png';
        }


 	if($_GET['dwntype']=='excel'){
		 $SiteLogo = '../images/1.gif';
	}
	
            
$VATNAME=$CSTNAME=$TRNNAME='';

         if($arryCurrentLocation[0]['country_id']=='106' || $arryCurrentLocation[0]['country_id']=='234'){
		 $VATNAME=(!empty($arryCurrentLocation[0]['VAT']))?('<br/>VAT No : '.$arryCurrentLocation[0]['VAT']):('');
                $CSTNAME=(!empty($arryCurrentLocation[0]['CST']))?('<br/>CST No : '.$arryCurrentLocation[0]['CST']):('');
               $TRNNAME=(!empty($arryCurrentLocation[0]['TRN']))?('<br/>TRN No : '.$arryCurrentLocation[0]['TRN']):('');


                /*$companyInfoShow='<td style="width:50%; margin:0px; padding:0px;'.$cmpalign.';">
                                <h1  style="font-size:'.$CompanyHeadingFieldSize.'px;margin-top:0px; color:'.$CompanyColorHeading.';">'.stripslashes($arryCompany[0]['CompanyName']).'</h1>

                                       <span style="font-size:'.$CompanyFieldSize.'px; display:block; color:'.$CompanyColor.';">'.stripslashes($arryCurrentLocation[0]['Address']).", ".stripslashes($arryCurrentLocation[0]['City']).",<br/>".stripslashes($arryCurrentLocation[0]['State']).", ".stripslashes($arryCurrentLocation[0]['Country'])."-".stripslashes($arryCurrentLocation[0]['ZipCode'])." <br/>".($VATNAME)." ".":".($VAT)." <br/>".($CSTNAME)." ".":".($CST).'</span><br/><br/>

                                    </td>';*/

$companyInfoShow='<td style="width:50%; margin:0px; padding:0px;'.$cmpalign.';">';

                               if($LogoDisplay=='show'){
                               $companyInfoShow.='<h4 style="text-align:'.$logoAlign.';"><img src="'.$SiteLogo.'" style="width:'.$logoSize.'px;"></h4>';}

                                       if($AddressDisplay=='show'){
                                       $companyInfoShow.='<span style="font-size:'.$CompanyFieldSize.'px; display:block; color:'.$CompanyColor.';">'.stripslashes($arryCurrentLocation[0]['Address'])."<br> ".stripslashes($arryCurrentLocation[0]['City']).",".stripslashes($arryCurrentLocation[0]['State'])."-".stripslashes($arryCurrentLocation[0]['ZipCode'])."<br/>".stripslashes($arryCurrentLocation[0]['Country']).$VATNAME.$CSTNAME.$TRNNAME.'</span><br/><br/>';
                                    }

                                    $companyInfoShow.='</td>';


                
        }else{
                $companyInfoShow='<td style="width:50%; margin:0px; padding:0px;'.$cmpalign.';">';
 if($LogoDisplay=='show'){                               
$companyInfoShow.='<h4 style="text-align:'.$logoAlign.';"><img src="'.$SiteLogo.'" style="width:'.$logoSize.'px;"></h4>';
}                                     if($AddressDisplay=='show'){
                                       $companyInfoShow.='<span style="font-size:'.$CompanyFieldSize.'px; display:block; color:'.$CompanyColor.';">'.stripslashes($arryCurrentLocation[0]['Address'])."<br> ".stripslashes($arryCurrentLocation[0]['City']).",".stripslashes($arryCurrentLocation[0]['State'])."-".stripslashes($arryCurrentLocation[0]['ZipCode'])."<br>".stripslashes($arryCurrentLocation[0]['Country']).'</span><br/><br/>';
                                   }

                                    $companyInfoShow.='</td>';
                                }

                //$Cmpanyimg='<h4 style="text-align:'.$logoAlign.';"><img src="'.$SiteLogo.'" style="width:'.$logoSize.'px;"></h4>';


?>
