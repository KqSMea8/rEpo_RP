<?php 
        //print_r($_POST);
        $FancyBox = 1;
        $ThisPageName = 'managevariant.php';
        $EditPage = 1;
	include_once("../includes/header.php");
	require_once($Prefix."classes/inv.class.php");
        require_once($Prefix."classes/variant.class.php");
        $objvariant=new varient();
	$objCommon=new common();
        //echo '<pre>'; print_r($Config);
	$ModuleName = 'Variant';
        
        
        $variantType=$objvariant->GetVariantType();
        if(!empty($_GET['editVId'])){
            
            //echo 'dd';die;
            $GetVariantEditList=$objvariant->GetVariant($_GET['editVId']);
            $GetMultipleEditVariantOption=$objvariant->GetMultipleVariantOption($_GET['editVId']);
            
            //echo '<pre>';print_r($GetMultipleEditVariantOption);die;
            if(!empty($_POST)){
            //echo '<pre>'; print_r($_POST);die;
                $neweditarray=array('id'=>$_GET['editVId'],"variant_name"=>$_POST['variant_name'],"variant_type_id"=>$_POST['variant_type_id'],"required"=>$_POST['required']);
                $updateID=$objvariant->UpdateVariant($neweditarray);
                $VariantOption=array("variant_name_id"=>$_GET['editVId'],"option_value"=>$_POST['mytext'],"id"=>$_POST['mytextId']);
                $objvariant->UpdateMultipleVariantOption($VariantOption);
                //$_SESSION['mess_var']='<div class="success">Variant updated successfully.</div>';
$_SESSION['mess_var']=VARIANT_UPDATED;
                header("location:managevariant.php");
                exit;
                //echo $updateID;die;
            }
        }
        else{
            //echo 'hello';
            if(!empty($_POST)){
            if(!empty($_POST['variant_name'])){
                //if(preg_match("/^[A-Z][a-zA-Z -]+$/", $_POST["variant_name"]) === 0){
                    //echo 'hello';
                    
                //}
               
                
                $GetVariantchekList=$objvariant->GetVariant();
                $Gval1=array();
                foreach($GetVariantchekList as $Gval)
                {
                    $Gval1[]=$Gval['variant_name'];
                    
                }
                //echo '<pre>';print_r($Gval1);
                if ($objvariant->in_array_case_insensitive($_POST['variant_name'], $Gval1))
                //if(in_array($_POST['variant_name'], $Gval1))
                { 
                    
                    //$_SESSION['mess_var']='<div class="error">Variant name already exist</div>';
$_SESSION['mess_var']=EXIST_VARIANT;
                    header("location:addvariant.php");
                    exit;
                    
                    
                }
                else {
                    
                    $resultsID=$objvariant->AddVariant($_POST);
                
                //echo '<pre>';print_r($results);die;
                if(!empty($resultsID)){
                    $VariantOption=array("variant_name_id"=>$resultsID,"option_value"=>$_POST['mytext']);
                    $objvariant->AddMultipleVariantOption($VariantOption);
                    $_SESSION['mess_var']= ADD_VARIANT;
                    header("location:managevariant.php");
                    exit;
                    
                }
                }
                
            
                
            }
            else{
                //$_SESSION['mess_var']='<div class="error">Please enter the variant name</div>';
		$_SESSION['mess_var']=ERROR_VARIANT;
                
            }
            }
            
        }
        if(!empty($_GET['del_vid'])){
            
            $objvariant->DeleteVariant($_GET['del_vid']);
            $objvariant->deleteVariantOptionAll($_GET['del_vid']);
            $quotevariant=$objvariant->QuoteVariantInfoDelete('',$_GET['del_vid'],'');
            $quotevariantOption=$objvariant->QuoteVariantOptionInfoDelete('',$_GET['del_vid'],'');
            $_SESSION['mess_var']=VARIANT_REMOVED;
            header("location:managevariant.php");
                exit;
                    
        }
        
	require_once("../includes/footer.php");
?>

