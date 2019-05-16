<? if (!empty($_GET['edit'])) { ?>
<div class="right-search">
	<h4><span class="icon"></span><?=stripslashes($arryReseller[0]['FullName'])?></h4>
	<div class="right_box">
               
<div id="imgGal">
 
<? 
$PreviewArray['Folder'] = $Config['ResellerDir'];
$PreviewArray['FileName'] = $arryReseller[0]['Image']; 
$PreviewArray['NoImage'] = "../images/no.jpg";
$PreviewArray['FileTitle'] = stripslashes($arryReseller[0]['FullName']);
$PreviewArray['Width'] = "120";
$PreviewArray['Height'] = "120";
$PreviewArray['Link'] = "1";
echo '<div  id="ImageDiv" align="center">'.PreviewImage($PreviewArray).'</div>';
$ImageExist = IsFileExist($Config['ResellerDir'],$arryReseller[0]['Image']);
if($ImageExist == 1){ 
	$DeleteSpan = '<span id="DeleteSpan"><a href="Javascript:void(0);" onclick="Javascript:DeleteFileRefresh(\''.$Config['ResellerDir'].'\',\''.$arryReseller[0]['Image'].'\', \'DeleteSpan\')">'.$delete.'</a></span>';
	 
 }
echo '<div id="ImageEditDiv">'.$DeleteSpan.'</div>';

?>




	</div>	
	

	<ul class="rightlink">	

<li <?=($_GET['tab']=="personal")?("class='active'"):("");?>><a href="<?=$EditUrl?>personal">Personal Details</a></li>
<li <?=($_GET['tab']=="login")?("class='active'"):("");?>><a href="<?=$EditUrl?>login">Login Details</a></li>
<li <?=($_GET['tab']=="discount")?("class='active'"):("");?>><a href="<?=$EditUrl?>discount">Package Discount</a></li>		
<li <?=($_GET['tab']=="term")?("class='active'"):("");?>><a href="<?=$EditUrl?>term">Payment Term</a></li>	
<li <?=($_GET['tab']=="comm")?("class='active'"):("");?>><a href="<?=$EditUrl?>comm">Commission Structure</a></li>
<!--li <?=($_GET['tab']=="sales")?("class='active'"):("");?>><a href="<?=$EditUrl?>sales">Sales Report</a></li>
<li <?=($_GET['tab']=="report")?("class='active'"):("");?>><a href="<?=$EditUrl?>report">Commission Report</a></li-->

	</ul>
	<?
	
	

?>

				
    </div>          
</div>
<? }else{
	$SetInnerWidth=1;
} ?>


	

