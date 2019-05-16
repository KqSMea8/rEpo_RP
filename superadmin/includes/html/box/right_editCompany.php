
<? if (!empty($_GET['edit'])) { ?>
<div class="right-search">
	<h4><span class="icon"></span><?=stripslashes($arryCompany[0]['CompanyName'])?></h4>
	<div class="right_box">
               
<div id="imgGal">
		<? /*if($arryCompany[0]['Image'] !='' && file_exists('../upload/company/'.$arryCompany[0]['Image']) ){ ?>
						
			<div  id="ImageDiv" align="center"><a class="fancybox" data-fancybox-group="gallery" href="../upload/company/<?=$arryCompany[0]['Image']?>"  title="<?=stripslashes($arryCompany[0]['CompanyName'])?>"><? echo '<img src="../resizeimage.php?w=120&h=120&img=upload/company/'.$arryCompany[0]['Image'].'" border=0 >';?></a>
			<br />
			
			<!--</h1><a class="fancybox fancybox.iframe" href="includes/iframe/company_img.php">Change Photo</a>-->
			
			<a href="Javascript:void(0);" onclick="Javascript:DeleteFile('../upload/company/<?=$arryCompany[0]['Image']?>','ImageDiv')"><?=$delete?></a>
			
			
				</div>
		<?	}else{ ?>
		
		<div  id="ImageDiv" align="center"><img src="../resizeimage.php?w=120&h=120&img=images/nologo.gif" title="<?=$arryCompany[0]['CompanyName']?>" /></div>
		<? } */?>

	<? 
 unset($_SESSION['ConfigCmpID']);
$Config['CmpID'] = $arryCompany[0]['CmpID'];
$PreviewArray['Folder'] = $Config['CmpDir'];
$PreviewArray['FileName'] = $arryCompany[0]['Image']; 
$PreviewArray['NoImage'] = "../images/nologo.gif";
$PreviewArray['FileTitle'] = stripslashes($arryCompany[0]['CompanyName']);
$PreviewArray['Width'] = "120";
$PreviewArray['Height'] = "120";
$PreviewArray['Link'] = "1";
echo '<div  id="ImageDiv" align="center">'.PreviewImage($PreviewArray).'</div>';
$ImageExist = IsFileExist($Config['CmpDir'],$arryCompany[0]['Image']);
if($ImageExist == 1){
	$_SESSION['ConfigCmpID']=$arryCompany[0]['CmpID'];
	$DeleteSpan = '<span id="DeleteSpan"><a href="Javascript:void(0);" onclick="Javascript:RemoveFileRefresh(\''.$Config['CmpDir'].'\',\''.$arryCompany[0]['Image'].'\', \'DeleteSpan\')">'.$delete.'</a></span>';
	 
	$OldImage = $arryCompany[0]['Image'];
 }
echo '<div id="ImageEditDiv">'.$DeleteSpan.'</div>';

?>

	</div>	
	

	<!--<ul class="rightlink">	
		<li <?=($_GET['tab']=="company")?("class='active'"):("");?>><a href="<?=$EditUrl?>company">Company Details</a></li>
		<li <?=($_GET['tab']=="account")?("class='active'"):("");?>><a href="<?=$EditUrl?>account">Account Details</a></li>
		<li <?=($_GET['tab']=="permission")?("class='active'"):("");?>><a href="<?=$EditUrl?>permission">Permission Details</a></li>
		<li <?=($_GET['tab']=="currency")?("class='active'"):("");?>><a href="<?=$EditUrl?>currency">Currency Details</a></li>
		<li <?=($_GET['tab']=="DateTime")?("class='active'"):("");?>><a href="<?=$EditUrl?>DateTime">DateTime Settings</a></li>
	</ul>-->
	<?
	
	

?>

<div class="rightlink" id="main_menu">
    <ul>
		  <?  
		
		  if(sizeof($arrayHeaderSubMenus)>0)
		  {       	
 foreach($arrayHeaderSubMenus as $key=>$valuesAdmin)
{ 
	//echo $valuesAdmin['Module'];exit;
//$BgClass = ($ThisPageName==$valuesAdmin['Link'])?("active"):("");
$strLink=explode('?',$valuesAdmin['Link']);
$tab=explode('tab=',$strLink[1]);

$BgClass = ($_GET['tab']==$tab[1])?("class='active'"):("");
echo '<li '.$BgClass.'><a href="'.$strLink[0].'?edit='.$_GET['edit'].'&curP='.$_GET['curP'].'&'.$strLink[1].'">'.$valuesAdmin['Module'].'</a></li>';

//$arryLinks1[] =$strLink[0]."?edit=".$_GET[edit]."&curP=".$_GET[curP]."&".$strLink[1];

//print_r($arryLinks1);exit;
		
} 
		  
		   }
		   
		   
		   
		   
		   ?>
	</ul>
</div>
	
				
    </div>          
</div>
<? }else{
	$SetInnerWidth=1;
} ?>


<?
//if($_SESSION['AdminType']=="user")
	//{ 
//print_r($arryLinks1);
	//}
/**
	if($_SESSION['AdminType']=="user")
	{ 

    $NotAllowed=in_array($ThisPageName,$arryLinks);
    
    $Mypage="adminDesktop.php";

	if($NotAllowed ==0 && $ThisPageName!=$Mypage)
		{
			echo '<div align="center" class="redmsg" style="padding-top:200px;">'.ERROR_NOT_AUTH.'</div>';
			exit;
		}
	
			
	}**/

?>
	

