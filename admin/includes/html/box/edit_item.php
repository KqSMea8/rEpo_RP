<?
require_once($Prefix . "classes/item.class.php");
require_once($Prefix."classes/function.class.php");
$objItem = new items();
$objFunction = new functions();
$RedirectURL = "viewItem.php?curP=".$_GET['curP'];
$ModuleName = "Item";
$Config['UploadPrefix'] = '../inventory/';

//By Chetan20Aug//
require_once($Prefix."classes/field.class.php"); 
$objField = new field();	
$arryHead=$objField->getHead('',$ModuleParentID,1);
//End//

/*********  Multiple Actions To Perform **********/
if (!empty($_GET['multiple_action_id'])) {
    $multiple_action_id = rtrim($_GET['multiple_action_id'], ",");   
    switch ($_GET['multipleAction']) {
        case 'delete':
            $objItem->RemoveMultipleItem($multiple_action_id, 0);
            $_SESSION['mess_item'] = ITEM_REMOVED;
            break;
        case 'active':
            $objItem->MultipleItemStatus($multiple_action_id, 1);
            $_SESSION['mess_item'] = ITEM_STATUS_CHANGED;
            break;
        case 'inactive':
            $objItem->MultipleItemStatus($multiple_action_id, 0);
            $_SESSION['mess_item'] = ITEM_STATUS_CHANGED;
            break;
    }
    header("location: " . $RedirectURL);
    exit;
}

/********  End Multiple Actions **********/

if ($_GET['del_id'] && !empty($_GET['del_id'])) {
    $_SESSION['mess_item'] = ITEM_REMOVED;
    $objItem->RemoveItem($_GET['del_id'], $_GET['CategoryID'], 0);
    header("location: " . $RedirectURL);
    exit;
}

if ($_GET['active_id'] && !empty($_GET['active_id'])) {
    $_SESSION['mess_item'] = ITEM_STATUS_CHANGED;
    $objItem->changeItemStatus($_GET['active_id']);
    header("location: " . $RedirectURL);
    exit;
}



    if ($_POST) {
		CleanPost();
 //For array to string conversion by niraj 10feb16
			array_walk($_POST,function(&$value,$key){$value=is_array($value)?implode(',',$value):$value;});
		      //End array to string conversion by niraj
	$_POST['procurement_method'][0] = $proc; //edited by pk

        if (!empty($_POST['ItemID'])) {            
             $ImageId = $_POST['ItemID'];
             $objItem->UpdateItemOther($_POST);
	     $_SESSION['mess_item'] = ITEM_UPDATED;
        } else {            
            $ImageId = $objItem->addCrmItems($_POST);    //By Chetan 21Aug//
	    $_SESSION['mess_item'] = ITEM_ADDED;
        }
		

        /*****************************/
	/*****************************/
        if ($_FILES['Image']['name'] != '') {
         
	$FileInfoArray['FileType'] = "Image";
	$FileInfoArray['FileDir'] = $Config['Items'];
	$FileInfoArray['FileID'] = $_POST['Sku'];
	$FileInfoArray['OldFile'] = $_POST['OldImage'];
	$FileInfoArray['UpdateStorage'] = '1';
	$ResponseArray = $objFunction->UploadFile($_FILES['Image'], $FileInfoArray);
	//pr($ResponseArray);die;
	if($ResponseArray['Success']=="1"){				 
		$objItem->UpdateImage($ResponseArray['FileName'], $ImageId);			
	}else{
		$ErrorMsg = $ResponseArray['ErrorMsg'];
	}

	if(!empty($ErrorMsg)){
		if(!empty($_SESSION['mess_item'])) $ErrorPrefix = '<br><br>';
		$_SESSION['mess_item'] .= $ErrorPrefix.$ErrorMsg;
	}
      }
      /*****************************/
      /*****************************/

	header("Location:" . $RedirectURL);
        exit;      

       
    }


    if (!empty($_GET['edit'])) {
        $arryItem = $objItem->GetItemById($_GET['edit']); 
        $ItemID = $_GET['edit'];	
    }

    if (!empty($arryItem) && $arryItem[0]['Status'] != '') {
        $ProductStatus = $arryItem[0]['Status'];
    } else {
        $ProductStatus = 1;
    }


?>

<a href="<?=$RedirectURL?>" class="back">Back</a>

<div class="had">
   <?=$MainModuleName?>
    &raquo;
    <span><?
    $MemberTitle = (!empty($_GET['edit'])) ? ("Edit ") : ("Add ");
    echo $MemberTitle . $ModuleName;
    ?></span>

</div>
<table width="100%"   border=0 align="center" cellpadding="0" cellspacing="0">
	<? if (!empty($errMsg)) {?>
  <tr>
    <td height="2" align="center"  class="red" ><?php echo $errMsg;?></td>
    </tr>
  <? } ?>
  
	<tr>
	<td align="left" valign="top">

	<? 
     
	include("../includes/html/box/item_form.php");
	
	
	?>

	
	</td>
    </tr>
 
</table>



