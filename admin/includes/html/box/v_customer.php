<!-- start calling -->
<?php  require_once(_ROOT."/admin/crm/includes/html/callBlock.php"); ?>
<!-- end calling -->


<?php 
$currentdep=$Config['CurrentDepID'];
?>
<style type="text/css">
      
      div#container {
        width: 580px;
        margin: 100px auto 0 auto;
        padding: 20px;
        background: #000;
        border: 1px solid #1a1a1a;
      }
      
      /* HOVER STYLES */
      div.pop-up {
        display: none;
        position: absolute;
        width: 100%;
        min-height: 150px;
        padding: 10px;
        background: #eeeeee;
        color: #000000;
        border: 1px solid #1a1a1a;
        font-size: 90%;
      }
      
      /* HOVER STYLES  facebook*/
      div#pop-upf {
        display: none;
        position: absolute;
        width: 100%;
        min-height: 150px;
        padding: 10px;
        background: #eeeeee;
        color: #000000;
        border: 1px solid #1a1a1a;
        font-size: 90%;
      }
      
      /* HOVER STYLES twitter*/
      div#pop-upt {
        display: none;
        position: absolute;
        width: 100%;
        min-height: 150px;
        padding: 10px;
        background: #eeeeee;
        color: #000000;
        border: 1px solid #1a1a1a;
        font-size: 90%;
      }
      
      /* HOVER STYLES linked*/
      div#pop-upL {
        display: none;
        position: absolute;
        width: 100%;
        min-height: 150px;
        padding: 10px;
        background: #eeeeee;
        color: #000000;
        border: 1px solid #1a1a1a;
        font-size: 90%;
      }
      
      /* HOVER STYLES linked*/
      div#pop-upG {
        display: none;
        position: absolute;
        width: 100%;
        min-height: 150px;
        padding: 10px;
        background: #eeeeee;
        color: #000000;
        border: 1px solid #1a1a1a;
        font-size: 90%;
      }
      /* HOVER STYLES Instagram*/
      div#pop-upI {
        display: none;
        position: absolute;
        width: 100%;
        min-height: 150px;
        padding: 10px;
        background: #eeeeee;
        color: #000000;
        border: 1px solid #1a1a1a;
        font-size: 90%;
      }
      .tdpopup.sremove > a:hover {
    text-decoration: underline;
}
      .fc {
    background: url("../images/close12.png") no-repeat scroll 0 0 rgba(0, 0, 0, 0);
    border-radius: 34px;
    display: inline-block;
    height: 14px;
    margin-left: 29px;
    margin-top: -5px;
    position: absolute;
    width: 14px;
    z-index: 900;
}
    </style>

    <script type="text/javascript">
        function confirmDelete(buttonControl,recordId,type,deprt) {
        if(type==1){
            
            var socialType ='cus_facebookdelete';
        }else if(type==2){
              var socialType ='cus_twitterdelete';
        }else if(type==3){
            
             var socialType ='cus_linkeddelete';
        }
        else if(type==4){
            
            var socialType ='cus_googledelete';
            
        }
        else if(type==5){
            
            var socialType ='cus_instagramdelete';
            
        }
  if (confirm("Delete this record?") == true)
     location.href = "../viewprofile.php?id=" + recordId+"&type="+socialType+"&CurrentDep="+deprt;
  return false;
}
      $(function() {
        var moveLeft = 20;
        var moveDown = 10;
        //facebook
        $('a#triggerf').hover(function(e) {
          $('div#pop-upf').show();
          //.css('top', e.pageY + moveDown)
          //.css('left', e.pageX + moveLeft)
          //.appendTo('body');
        }, function() {
          $('div#pop-upf').hide();
        });
        
        $('a#triggerf').mousemove(function(e) {
          $("div#pop-upf").css('top', e.pageY + moveDown).css('left', e.pageX + moveLeft);
        });
        
        //twitter
        
        $('a#triggert').hover(function(e) {
          $('div#pop-upt').show();
          //.css('top', e.pageY + moveDown)
          //.css('left', e.pageX + moveLeft)
          //.appendTo('body');
        }, function() {
          $('div#pop-upt').hide();
        });
        
        $('a#triggert').mousemove(function(e) {
          $("div#pop-upt").css('top', e.pageY + moveDown).css('left', e.pageX + moveLeft);
        });
        
        //Linkdin
        $('a#triggerL').hover(function(e) {
          $('div#pop-upL').show();
          //.css('top', e.pageY + moveDown)
          //.css('left', e.pageX + moveLeft)
          //.appendTo('body');
        }, function() {
          $('div#pop-upL').hide();
        });
        
        $('a#triggerL').mousemove(function(e) {
          $("div#pop-upL").css('top', e.pageY + moveDown).css('left', e.pageX + moveLeft);
        });
        
        
        
        //Google-plus
        $('a#GoogleP').hover(function(e) {
          $('div#pop-upG').show();
          //.css('top', e.pageY + moveDown)
          //.css('left', e.pageX + moveLeft)
          //.appendTo('body');
        }, function() {
          $('div#pop-upG').hide();
        });
        
        $('a#GoogleP').mousemove(function(e) {
          $("div#pop-upG").css('top', e.pageY + moveDown).css('left', e.pageX + moveLeft);
        });
        
        //Instagram
        $('a#instagram').hover(function(e) {
          $('div#pop-upI').show();
          //.css('top', e.pageY + moveDown)
          //.css('left', e.pageX + moveLeft)
          //.appendTo('body');
        }, function() {
          $('div#pop-upI').hide();
        });
        
        $('a#instagram').mousemove(function(e) {
          $("div#pop-upI").css('top', e.pageY + moveDown).css('left', e.pageX + moveLeft);
        });
      });
      
    </script>
    
    
<?php 

	require_once($Prefix."classes/sales.customer.class.php");
	require_once($Prefix."classes/lead.class.php");
	require_once($Prefix."classes/group.class.php");
	require_once($Prefix."classes/event.class.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/quote.class.php");
        require_once($Prefix."classes/field.class.php"); //By Chetan//
        require_once($Prefix."classes/finance.account.class.php");
        require_once($Prefix."classes/finance.report.class.php");
 
        $objField = new field();	//By Chetan//
        
        $arryHead=$objField->getHead('','2015',1);//By Chetan//
        
        
	$objCustomer=new Customer();  
	$objLead=new lead();
	$objGroup=new group();
	$objActivity=new activity();
	$objSale = new sale();
	$objQuote=new quote();
  	$objBankAccount= new BankAccount();
	$objReport = new report();
 

	$ModuleName = "Customer";
	$RedirectURL = "viewCustomer.php?curP=".$_GET['curP'];
	if(empty($_GET['tab'])) $_GET['tab']="general";

	$EditUrl = "editCustomer.php?edit=".$_GET["view"]."&curP=".$_GET["curP"]."&tab=".$_GET['tab']; 
	$ViewUrl = "vCustomer.php?view=".$_GET["view"]."&curP=".$_GET["curP"]."&tab="; 


	if (!empty($_GET['view'])) {
		$CustID   = $_GET['view'];
		$_GET['CustID'] = $_GET['view'];	
		//$arryCustomer = $objCustomer->GetCustomer($_GET['view'],'','');	
		$arryCustomer = $objCustomer->getCustomerById($_GET['view']);
		$CustCode = $arryCustomer[0]['CustCode'];
                $PageHeading = 'view Customer for: '.stripslashes($arryCustomer[0]['FullName']);
		
                $arryBillShipp = $objCustomer->GetShippingBilling($_GET['view'],$_GET['tab'],null,' Status DESC , AddID DESC');	
		if(empty($arryCustomer[0]['Cid'])){
			$ErrorMSG = CUSTOMER_NOT_EXIST;
		}

	}


	if(empty($arryCustomer[0]['Cid'])) {
		header('location:'.$RedirectURL);
		exit;
	}		
	/*****************/
	if($Config['vAllRecord']!=1){
		if($arryCustomer[0]['AdminID'] == $_SESSION['AdminID'] or $arryCustomer[0]['SalesID'] == $_SESSION['AdminID']){
			//continue
		}else{
			header('location:'.$RedirectURL);
			exit;
		}
	}
	/*****************/



	$HideEdit='';
      
	if($_GET['tab']=='shipping'){
		$SubHeading = 'Shipping Address';
		$IncludePage = 'customer_contacts.php';	
	}else if($_GET['tab']=='billing'){
		$SubHeading = 'Billing Address';	
  	}else if($_GET['tab']=='bank'){
		$SubHeading = 'Bank Details';	
  	}else if($_GET['tab']=='slaesPerson'){
		$SubHeading = 'Sales Person';	
  	}else if($_GET['tab']=='contacts'){
		$SubHeading = 'Contacts'; 
		$IncludePage = 'customer_contacts.php';	
	}else if($_GET['tab']=='ticket'){
		$SubHeading = 'Tickets'; $HideEdit=1; 
		$IncludePage = 'customer_tickets.php';
	}else if($_GET['tab']=='event'){
		$SubHeading = 'Event / Task'; $HideEdit=1; 
		$IncludePage = 'customer_activity.php';
	}else if($_GET['tab']=='document'){
		$SubHeading = 'Documents'; $HideEdit=1; 
		$IncludePage = 'customer_documents.php';
	}else if($_GET['tab']=='quote'){
		$SubHeading = 'Quotes'; $HideEdit=1;
		$IncludePage = 'customer_quote.php';
	}else if($_GET['tab']=='so'){
		$SubHeading = 'Sales Orders'; $HideEdit=1;
		$IncludePage = 'customer_orders.php';
	}else if($_GET['tab']=='deposit'){
		$SubHeading = 'Deposits'; $HideEdit=1;
		$IncludePage = 'customer_deposit.php';
	}else if($_GET['tab']=='sales'){
		$SubHeading = 'Sales History'; $HideSubmit=1;
		$IncludePage = 'customer_sales_history.php';
	}else if($_GET['tab']=='invoice'){
		$SubHeading = 'Invoices'; $HideEdit=1;	
		$IncludePage = 'customer_invoice.php';
	}else if($_GET['tab']=='credit'){
		$SubHeading = 'Credit Memo'; $HideEdit=1;	
		$IncludePage = 'customer_credit_memo.php';
	}else if($_GET['tab']=='purchase'){
		$SubHeading = 'Purchase History'; $HideEdit=1;
		$IncludePage = 'customer_purchases.php';
        }else if($_GET['tab']=='linkvendor'){
		$SubHeading = 'Linked Vendor'; 
	}else if($_GET['tab']=='comment'){
		$_GET['module'] = 'Customer';
		$SubHeading = 'Comments'; $HideEdit=1;
		$IncludeOtherPage = 'includes/html/box/comment_cust.php';
	}else if($_GET['tab']=='Email'){ // this condition is added for showing emails of user
		$SubHeading = 'Email'; 
		$IncludePage = 'combinedEmail.php';
                $EmailForInbox = $arryCustomer[0]['Email'];
	}else if($_GET['tab']=='card'){
		$SubHeading = 'Credit Card'; 
		$IncludePage = 'customer_credit_card.php';
	}else if($_GET['tab']=='ShippingAccount'){
		$SubHeading = 'Shipping Accounts';  	
		$IncludePage = 'customer_shipping_account.php';
	}else{
		$SubHeading = ucfirst($_GET["tab"])." Information";
	}



	/*********************/
	/*********************/
	$_GET["module"] = $ModuleName;
	$FullName = stripslashes($arryCustomer[0]['CustomerName']);
   	$NextID = $objCustomer->NextPrevCustomer($_GET['view'],$FullName,1);
	$PrevID = $objCustomer->NextPrevCustomer($_GET['view'],$FullName,2);
	$NextPrevUrl = "vCustomer.php?tab=general&curP=".$_GET["curP"];
	include("../includes/html/box/next_prev.php");
	/*********************/
	/*********************/
?>


<a class="back" href="<?=$RedirectURL?>">Back</a> 



<?php
if(!empty($ErrorMSG)){
	 echo '<div class="redmsg" align="center">'.$ErrorMSG.'</div>';
}else{
?>

		<? if($HideEdit!=1){?><a href="<?=$EditUrl?>" class="edit">Edit</a><?}?>

<a class="download" style="float:right;" target="_blank" href="pdfCustomerView.php?view=<?=$_GET['view']?>">Download</a>



		<div class="had"><?=$MainModuleName?>  <span> &raquo;	<?php 	echo $SubHeading; ?>	</span>
		</div>




<? 
if(!empty($IncludePage)){
	$Config['vAllRecord']=1;	
	include("../includes/html/box/".$IncludePage);
}else if(!empty($IncludeOtherPage)){
	$Config['vAllRecord']=1;	
	include($IncludeOtherPage);
}else{
?>

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">

				
	<!--By Chetan 27Aug-->							
		<?php if($_GET['tab'] == "general"){?>  
	
        

 <?php      

$head=1;
$arrayVal= $arryCustomer[0];
$callfor = 'Customer';
 for($h=0;$h<sizeof($arryHead);$h++){?>
        <tr>
            <td colspan="8" align="left" class="head"><?=$arryHead[$h]['head_value']?></td>
        </tr>

<?php 

$arryField = $objField->getFormField('',$arryHead[$h]['head_id'],'1'); 

//By 10Jan//
if($arryHead[$h]['head_value'] == 'General Information'){

	if($arryCurrentLocation[0]['country_id']!='106' && $arryCurrentLocation[0]['country_id']!='234'){
	$arryField = array_map(function($arr){
		    if($arr['fieldname'] == 'CST' || $arr['fieldname'] == 'PAN' || $arr['fieldname'] == 'TRN')       
		    {
		        unset($arr);
		    }else{
		        return $arr;
		    }
		},$arryField);	
	
	} 
    
}



//By Chetan 18Aug//
 $Narry = array_map(function($arr){
                if($arr['fieldname'] == 'Image')
                {
                    unset($arr);
                }else{
                    return $arr;
                }
            },$arryField);
$arryField = array_values(array_filter($Narry)); 
//End//
if($arryCustomer[0]['CustomerType']!='Company'){
    $Narry = array_map(function($arr){
                if($arr['fieldname'] == 'Company')
                {
                    unset($arr);
                }else{
                    return $arr;
                }
            },$arryField);
    $arryField = array_values(array_filter($Narry));  
}
include("includes/html/box/viewCustomFieldsNew.php");



if($Config['CurrentDepID']==8){

	 if($arryCustomer[0]['CreditLimit']>0 || $arryCustomer[0]['CreditLimitCurrency']>0){
		echo '<tr id="CreditBalanceTr" style="display:none">
			<td align="right" >Current Credit Balance : </td>
			<td align="left" colspan="3" style="font-weight:bold">
	<input type="hidden" name="CreditLimit" id="CreditLimit" value="'.$arryCustomer[0]['CreditLimit'].'">
	<span name="CreditBalance" id="CreditBalance" /></span>	</td>
		</tr>';


		echo '<tr>		
		<td  colspan="4" ><div id="custOrderDiv" style="display:none;width:900px;"> ';
	$HideSearch=1;
	include("../includes/html/box/customer_orders.php");

	echo   '</div></td>
		</tr>

		<tr>
		<td align="right" >Open Sales Order Amount : </td>
		<td align="left" colspan="3" > 
<a class="fancyorder fancybox" href="#custOrderDiv">'.number_format($TotalOpenAmount,2).'</a>
<input type="hidden" name="TotalOpenAmount" id="TotalOpenAmount" value="'.$TotalOpenAmount.'" readonly>
</td>
	</tr>';
	}

	
	
}






 }
 //End//
?>           
        
<?php }else{?>
        
<tr>
	 <td colspan="4" align="left" class="head"><? echo $SubHeading; ?></td>
	</tr>	

	
<?php }

?>

 <!--End-->
        


	


 
  <?php if($_GET['tab'] == "contact"){ ?>  
                                       
            <tr>
                <td colspan="4" align="left" class="head">Contact Information </td>
            </tr>
           
            <tr>
                <td align="right" valign="top"  class="blackbold"> 
                    First Name :  </td>
                 <td align="left"><?=stripslashes($arryCustomer[0]['FirstName'])?></td>
                
            </tr>

            <tr>
                <td  align="right" valign="top"   class="blackbold"> 
                    Last Name : </td>
                 <td align="left"><?=stripslashes($arryCustomer[0]['LastName'])?></td>
               
            </tr>
             <tr>
                <td  align="right" valign="top"   class="blackbold"> 
                    Gender : </td>
               
                 <td align="left"><?=$arryCustomer[0]['Gender'];?></td>
            </tr>
             <tr>
                <td align="right" valign="top" class="blackbold"> 
                    Email :  </td>
               
                <td align="left"><?=stripslashes($arryCustomer[0]['Email'])?></td>
            </tr>
             <tr>
                <td valign="top" align="right" class="blackbold">Address  :</td>

                 <td align="left"><?=stripslashes($arryCustomer[0]['Address'])?></td>
             </tr>
              <tr>
                <td  align="right"   class="blackbold"> Country : </td>
                <td   align="left" >
                  <?=stripslashes($arryCustomer[0]['CountryName'])?>
                </td>
            </tr>
	<? if(!empty($arryCustomer[0]['StateName'])){ ?>
            <tr>
                <td  align="right" valign="middle"  class="blackbold"> State : </td>
             <td  align="left" class="blacknormal"><?=stripslashes($arryCustomer[0]['StateName'])?></td>
            </tr>
	<? } ?>
            
            <tr>
                <td  align="right" class="blackbold"> City : </td>
                <td  align="left"><?=stripslashes($arryCustomer[0]['CityName'])?></td>
            </tr> 
             
            <tr>
                <td align="right" valign="top" class="blackbold">Zip Code :  </td>
                 
                 <td  align="left"><?=stripslashes($arryCustomer[0]['ZipCode'])?></td>
            </tr>
             <tr>
                <td align="right" valign="top" class="blackbold"> 
                    Mobile :  </td>
                
                 <td  align="left">
 <?php if(!empty($arryCustomer[0]['Mobile'])){ echo stripslashes($arryCustomer[0]['Mobile']); ?>
				 <a href="javascript:void(0);" onclick="call_connect('call_form','to','<?=stripslashes($arryCustomer[0]['Mobile'])?>','<?=$_GET['view']?>','<?=$country_code?>','<?=$country_prefix?>','Customer')" class="call_icon"> <span class="phone_img"></span></a>	
				 <? } else { echo NOT_SPECIFIED; } ?>

</td>
            </tr>
             <tr>
                <td align="right" valign="top"   class="blackbold"> 
                    Landline  : </td>
                <td  align="left"  class="blacknormal">
                    
<?php if(!empty($arryCustomer[0]['Landline'])){ echo stripslashes($arryCustomer[0]['Landline']); ?>
				 <a href="javascript:void(0);" onclick="call_connect('call_form','to','<?=stripslashes($arryCustomer[0]['Landline'])?>','<?=$_GET['view']?>','<?=$country_code?>','<?=$country_prefix?>','Customer')" class="call_icon"> <span class="phone_img"></span></a>	
				 <? } else { echo NOT_SPECIFIED; } ?>

                </td>
            </tr>
                                            
                                      
             <tr>
                <td align="right" valign="top"   class="blackbold"> 
                    Fax :</td>
               <td  align="left">
                <?=(!empty($arryCustomer[0]['Fax']))?(stripslashes($arryCustomer[0]['Fax'])):(NOT_SPECIFIED)?>
               </td>
            </tr>
           
           
            <tr>
                <td align="right" valign="top"   class="blackbold"> 
                    Website :  </td>
               <td  align="left"><?=(!empty($arryCustomer[0]['Website']))?($arryCustomer[0]['Website']):(NOT_SPECIFIED)?></td>
            </tr>
            <?php }?>  

         <?php if($_GET['tab'] == "billing" || $_GET['tab'] == "shipping"){                                          
                                            $BillShipp = ucfirst($_GET["tab"]);
                                            $NumBillShipp = sizeof($arryBillShipp);
                                          
                                            /********Connecting to main database*********/
                                                $Config['DbName'] = $Config['DbMain'];
                                                $objConfig->dbName = $Config['DbName'];
                                                $objConfig->connect();
                                             if(!empty($arryBillShipp) && $arryBillShipp[0]['country_id']>0){
                                                        $arryCountryName = $objRegion->GetCountryName($arryBillShipp[0]['country_id']);
                                                        $CountryName = stripslashes($arryCountryName[0]["name"]);
                                                }

                                                if(!empty($arryBillShipp[0]['state_id'])) {
                                                        $arryState = $objRegion->getStateName($arryBillShipp[0]['state_id']);
                                                        $StateName = stripslashes($arryState[0]["name"]);
                                                }else if(!empty($arryBillShipp[0]['OtherState'])){
                                                         $StateName = stripslashes($arryBillShipp[0]['OtherState']);
                                                }

                                                if(!empty($arryBillShipp[0]['city_id'])) {
                                                        $arryCity = $objRegion->getCityName($arryBillShipp[0]['city_id']);
                                                        $CityName = stripslashes($arryCity[0]["name"]);
                                                }else if(!empty($arryBillShipp[0]['OtherCity'])){
                                                         $CityName = stripslashes($arryBillShipp[0]['OtherCity']);
                                                }
                                            ?>    
                                          
                                            <?php 
                                            
                                            if($NumBillShipp>0){
                                            echo '<tr><td>';
                                            $i=0;
                                            foreach($arryBillShipp as $v){
                                             ?>
                                             <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall <?php echo empty($arryBillShipp[$i]['Status'])?'no-active':'';?>">
                                            <tr>
                                                <td width="45%" align="right" valign="top" class="blackbold"> <?=$BillShipp?> Name : </td>
                                                <td align="left" valign="top">
                                                   <?= stripslashes($arryBillShipp[$i]['FullName']) ?>
                                                </td>
                                            </tr>
                                           <tr>
                                            <td align="right"   class="blackbold"><?=$BillShipp;?> Email  : </td>
                                            <td  align="left" ><?=stripslashes($arryBillShipp[$i]['Email'])?> </td>
                                           </tr> 
                                            <tr>
                                                <td  align="right" valign="top" class="blackbold">  Address : </td>
                                                <td  align="left" valign="top">
                                                   <?=stripslashes($arryBillShipp[$i]['Address']) ?>
                                                </td>
                                            </tr>
                                           

                                            <tr>
                                                <td  align="right"   class="blackbold"> Country : </td>
                                                <td   align="left" >
                                                  <?= stripslashes($arryBillShipp[$i]['CountryName']) ?>
                                                </td>
                                            </tr>

		<? if(!empty($arryBillShipp[$i]['StateName'])){ ?>
                                            <tr>
                                              <td  align="right" valign="middle" nowrap="nowrap"  class="blackbold"> State : </td>
                                             <td  align="left"  class="blacknormal"> <?= stripslashes($arryBillShipp[$i]['StateName']) ?></td>
                                            </tr>
                                           <? } ?>
                                            <tr>
                                                <td  align="right" class="blackbold"> City : </td>
                                                <td  align="left"> <?= stripslashes($arryBillShipp[$i]['CityName']) ?></td>
                                            </tr> 
                                          
                                            <tr>
                                                <td  align="right" valign="top" class="blackbold">Zip Code : </td>
                                                <td   align="left" valign="top">
                                                    <?= stripslashes($arryBillShipp[$i]['ZipCode']) ?>
                                                </td>
                                            </tr>
                                            <tr>
                                            <td align="right"   class="blackbold" >Mobile  :</td>
                                            <td  align="left"  >
<?php if(!empty($arryBillShipp[$i]['Mobile'])){ echo stripslashes($arryBillShipp[$i]['Mobile']); ?>
											<a href="javascript:void(0);" onclick="call_connect('call_form','to','<?=stripslashes($arryBillShipp[$i]['Mobile'])?>','<?=$_GET['view']?>','<?=$country_code?>','<?=$country_prefix?>','Customer')" class="call_icon"> <span class="phone_img"></span></a>	
											<? } else { echo NOT_SPECIFIED; } ?>

                                             </td>
                                          </tr>

                                               <tr>
                                            <td  align="right"   class="blackbold">Landline  :</td>
                                            <td   align="left" >
                                           
 <?php if(!empty($arryBillShipp[$i]['Landline'])){ echo stripslashes($arryBillShipp[$i]['Landline']); ?>
											<a href="javascript:void(0);" onclick="call_connect('call_form','to','<?=stripslashes($arryBillShipp[$i]['Landline'])?>','<?=$_GET['view']?>','<?=$country_code?>','<?=$country_prefix?>','Customer')" class="call_icon"> <span class="phone_img"></span></a>	
											<? } else { echo NOT_SPECIFIED; } ?>


                                             </td>
                                          </tr>

                                          <tr>
                                            <td align="right"   class="blackbold">Fax  : </td>
                                            <td  align="left" > <?=(!empty($arryBillShipp[$i]['Fax']))?($arryBillShipp[$i]['Fax']):(NOT_SPECIFIED)?></td>
                                          </tr> 
                                          </table>
                                          <?php $i++;} echo '</tr></td>';} else{ ?>
                                            <tr>
                                                 <td colspan="4" height="300" align="center"><?=NOT_SPECIFIED?></td>
                                             </tr>
                                            <?php } ?>
                                            

                                         
                                        <?php }?>
										
  <? if($_GET["tab"]=="bank"){ ?>  

			
		 <tr>
				 <td colspan="4">&nbsp;</td>
			</tr>	
			
		<tr>
			<td  align="right"   class="blackbold"  width="45%"> Bank Name : </td>
			<td   align="left" >
			 
			 <?=(!empty($arryCustomer[0]['BankName']))?(stripslashes($arryCustomer[0]['BankName'])):(NOT_SPECIFIED)?>
				</td>
		  </tr>	
		 <tr>
			<td  align="right"   class="blackbold"> Account Name  :</td>
			<td   align="left" >
				
				 <?=(!empty($arryCustomer[0]['AccountName']))?(stripslashes($arryCustomer[0]['AccountName'])):(NOT_SPECIFIED)?>
				 </td>
		  </tr>	  
		  <tr>
			<td  align="right"   class="blackbold"> Account Number  : </td>
			<td   align="left" >
				
				<?=(!empty($arryCustomer[0]['AccountNumber']))?(stripslashes($arryCustomer[0]['AccountNumber'])):(NOT_SPECIFIED)?>
				 </td>
		  </tr>	
		   <tr>
			<td  align="right"   class="blackbold">Routing Number : </td>
			<td   align="left" >
				
				<?=(!empty($arryCustomer[0]['IFSCCode']))?(stripslashes($arryCustomer[0]['IFSCCode'])):(NOT_SPECIFIED)?>
				 </td>
		  </tr>	
		  
		  <tr>
				 <td colspan="4">&nbsp;</td>
			</tr>
			
	  <? } ?>

<? if($_GET["tab"]=="linkvendor"){

	$arryLinkCustVen = $objBankAccount->GetCustomerVendor($CustID,'');
	$SuppID = (!empty($arryLinkCustVen[0]['SuppID']))?($arryLinkCustVen[0]['SuppID']):("");
	if($SuppID>0){
		$arryVendor = $objBankAccount->GetSupplier($SuppID,'','');
		if($CurrentDepID==5){
			$linkPrefix = '../finance/';
		}
	}
	

 ?>
 	
		
	  <tr>
       		 <td colspan="2">&nbsp;</td>
          </tr>	

	<? if(!empty($arryVendor[0]['SuppCode'])){ ?>
	<tr>
	<td align="right" width="45%" class="blackbold" > Vendor Code : </td>
	<td align="left" >

<a class="fancybox fancybox.iframe" href="<?=$linkPrefix?>suppInfo.php?view=<?=$arryVendor[0]['SuppCode'] ?>" ><?=$arryVendor[0]['SuppCode']?></a>

	
	</td>
	</tr>


	<tr>
	<td align="right" class="blackbold" > Company Name : </td>
	<td align="left" >
	<?php echo stripslashes($arryVendor[0]['VendorName']); ?> </td>
	</tr>
	<? }else{  ?>	
		  <tr>
       		 <td colspan="2" align="center" class=red><?=NO_RECORD?></td>
        </tr>
	<? } ?>

	  <tr>
       		 <td colspan="2">&nbsp;</td>
        </tr>
		



  <? } ?>
	   <? if($_GET["tab"]=="slaesPerson"){ ?>  

			
		 <tr>
				 <td colspan="2">&nbsp;</td>
			</tr>	
			
		<tr>
			<td  align="right"   class="blackbold"  width="45%"> Sales Person : </td>
			<td   align="left" >
			 
			 <?php echo stripslashes($arryCustomer[0]['sales_person']); ?>
				</td>
		  </tr>	
		<tr>
				 <td colspan="2">&nbsp;</td>
			</tr>
			
	  <? } ?>
	     <? if($_GET["tab"]=="social"){ ?>
           
		 	<tr align="center">
       		   
          		<td class="tdpopup"> 
                            <?php if(!empty($arryCustomer[0]['FacebookID'])){$socialdata=stripslashes(nl2br($arryCustomer[0]['FacebookID']));
           			$socialdata = unserialize($socialdata);
           			echo '<a href="javascript:void(0)" class="fc" onclick="confirmDelete(this,'.$_GET['view'].',1,'.$currentdep.')"></a>';	
                                echo '<a id="triggerf" href="javascript:void(0)" class="facebookview triggerf v_facebook fancybox fancybox.iframe"></a>';
           			 }else{echo '&nbsp;';}?>                                
                             <div id="pop-upf" style="width: 530px; z-index: 999;">
                               <?php echo '<iframe  src="../viewprofile.php?id='.$arryCustomer[0]['FacebookID'].'&type=facebook" style="min-height:180px; width: 100%;">
</iframe>';?>
                            </div>
                             
           			 
           			  <?php if(!empty($arryCustomer[0]['TwitterID'])){$socialdata=stripslashes(nl2br($arryCustomer[0]['TwitterID']));
           			$socialdata = unserialize($socialdata);
           			echo '<a class="fc" href="javascript:void(0)" onclick="confirmDelete(this,'.$_GET['view'].',2,'.$currentdep.')"></a>';	
                                echo '<a id="triggert" href="javascript:void(0)" class="twitterview triggert v_Twitter fancybox fancybox.iframe"></a>';
           			 }else{echo '&nbsp;';}?>
                            <div id="pop-upt" style="width: 530px; z-index: 999;">
                                <?php echo '<iframe  src="../viewprofile.php?id='.$arryCustomer[0]['TwitterID'].'&type=twitter" style="min-height:180px; width: 100%;">
</iframe>';?>
                            </div>
                        
                        
           			  <?php
		$id='';
           			$t='';

 if(!empty($arryCustomer[0]['LinkedinID'])){$socialdata=stripslashes(nl2br($arryCustomer[0]['LinkedinID']));
           			$socialdata = unserialize($socialdata);
           			
           			if(!empty($arryCustomer[0]['LinkedinID'])){
           			$id=$arryCustomer[0]['LinkedinID'];
           			$t='linkedin';
           			}
           			echo '<a class="fc" href="javascript:void(0)" onclick="confirmDelete(this,'.$_GET['view'].',3,'.$currentdep.')"></a>';	
                                echo '<a id="triggerL" href="javascript:void(0)" class="linkedinview triggerL v_Linkedin fancybox fancybox.iframe"></a>';
           			 }else{echo '&nbsp;';}?>
                        <div id="pop-upL" style="width: 530px; z-index: 999;">
                                <?php echo '<iframe  src="../viewprofile.php?id='.$id.'&type='.$t.'" style="min-height:180px; width: 100%;">
</iframe>';?>
                            </div>
                            
                            
                            <?php if(!empty($arryCustomer[0]['GoogleID'])){$socialdata=stripslashes(nl2br($arryCustomer[0]['GoogleID']));
           			$socialdata = unserialize($socialdata);
           			$id='';
           			$t='';
           			if(!empty($arryCustomer[0]['GoogleID'])){
           			$id=$arryCustomer[0]['GoogleID'];
           			$t='googleplus';
           			}
           			echo '<a class="fc" href="javascript:void(0)" onclick="confirmDelete(this,'.$_GET['view'].',4,'.$currentdep.')"></a>';	
                                echo '<a id="GoogleP" href="javascript:void(0)" class="linkedinview triggerL v_GooglePlus fancybox fancybox.iframe"></a>';
                                        
           			 }else{echo '&nbsp;';}?>
                        <div id="pop-upG" style="width: 530px; z-index: 999;">
                                <?php echo '<iframe  src="../viewprofile.php?id='.$id.'&type='.$t.'" style="min-height:180px; width: 100%;">
</iframe>';?>
                            </div>
                            
                            
                            <?php if(!empty($arryCustomer[0]['InstagramID'])){$socialdata=stripslashes(nl2br($arryCustomer[0]['InstagramID']));
           			$socialdata = unserialize($socialdata);
           			$id='';
           			$t='';
           			if(!empty($arryCustomer[0]['InstagramID'])){
           			$id=$arryCustomer[0]['InstagramID'];
           			$t='instagram';
           			}
           			echo '<a class="fc" href="javascript:void(0)" onclick="confirmDelete(this,'.$_GET['view'].',5,'.$currentdep.')"></a>';	
                                echo '<a id="instagram" href="javascript:void(0)" class="linkedinview triggerL v_instagram fancybox fancybox.iframe"></a>';
                                        
           			 }else{echo '&nbsp;';}?>
                        <div id="pop-upI" style="width: 530px; z-index: 999;">
                                <?php echo '<iframe  src="../viewprofile.php?id='.$id.'&type='.$t.'" style="min-height:180px; width: 100%;">
</iframe>';?>
                            </div>
                        </td>
           		</tr>
           		
		
			
	  <? } ?>
	  
	  
</table>
      
<? 
if($_GET["tab"]=="general" && $Config['CurrentDepID']==8){
	include("../includes/html/box/customer_aging.php");
}
?>
                            
           

<?php } } ?>	  
	
<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function() {
		$(".fancybig").fancybox({
			'width'         : 900
		 });

});

</script>

