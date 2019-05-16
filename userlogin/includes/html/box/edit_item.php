<?
require_once($Prefix . "classes/item.class.php");
require_once($Prefix."classes/function.class.php");
$objItem = new items();
$objFunction = new functions();
$RedirectURL = "viewItem.php?curP=".$_GET['curP'];
$ModuleName = "Item";
$Config['UploadPrefix'] = '../inventory/';

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

	$_POST['procurement_method'][0] = $proc; //edited by pk

        if (!empty($_POST['ItemID'])) {            
             $ImageId = $_POST['ItemID'];
             $objItem->UpdateItemOther($_POST);
	     $_SESSION['mess_item'] = ITEM_UPDATED;
        } else {            
            $ImageId = $objItem->AddItem($_POST);
	    $_SESSION['mess_item'] = ITEM_ADDED;
        }
		

        /*****************************/
	/*****************************/
        if ($_FILES['Image']['name'] != '') {
         $FileArray = $objFunction->CheckUploadedFile($_FILES['Image'],"Image");
          if(empty($FileArray['ErrorMsg'])){
            $ImageExtension = GetExtension($_FILES['Image']['name']);
            $imageName = $_POST['Sku'] . "." . $ImageExtension;
            	
		$MainDir = $Config['UploadPrefix']."upload/items/images/".$_SESSION['CmpID']."/";						
		if (!is_dir($MainDir)) {
			mkdir($MainDir);
			chmod($MainDir,0777);
		}
		 $ImageDestination = $MainDir.$imageName;        

		if(!empty($_POST['OldImage']) && file_exists($_POST['OldImage'])){
			$OldImageSize = filesize($_POST['OldImage'])/1024; //KB
			unlink($_POST['OldImage']);		
		}

    
            if (@move_uploaded_file($_FILES['Image']['tmp_name'],$ImageDestination)) {
                $objItem->UpdateImage($imageName, $ImageId);
		$objConfigure->UpdateStorage($ImageDestination,$OldImageSize,0);
            }
      }else{
	 $ErrorMsg = $FileArray['ErrorMsg'];
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

    if ($arryItem[0]['Status'] != '') {
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



