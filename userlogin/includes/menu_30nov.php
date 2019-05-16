
<?

$arrayHeaderMenus = $objConfig->GetHeaderMenusUser($_SESSION['UserID'],$CurrentDepID,'',1);	

if(sizeof($arrayHeaderMenus)>0){
//echo '<pre>';print_r($arrayHeaderMenus); exit;
$BgHmClass = ($SelfPage=="home.php")?("active"):("");
?>

<div class="nav-container" id="main_menu">
    <ul>
		  <? 
		  if($CurrentDepID>0)echo '<li class="'.$BgHmClass.'" ><a href="home.php" >Home</a></li>';
		  foreach($arrayHeaderMenus as $key=>$valuesAdmin){ 
				 
				 $BgClass = ($ModuleParentID == $valuesAdmin['ModuleID'])?("active"):("");
				
				 $ArrTopLink =  $objConfig->GetHeaderTopLink($valuesAdmin['ModuleID']);


				 if($valuesAdmin['ModuleID'] == 1){
					 $MainLink = $MainPrefix.$ArrTopLink[0]['Link'];
				 }else{
					 $MainLink = $DeptFolder.$ArrTopLink[0]['Link'];
				 }
				 

		  ?>
		  <li class="<?=$BgClass?>" ><a href="<?=$MainLink?>"><?=$valuesAdmin['Module']?></a></li>
		  <? } ?>
	</ul>
</div>
<? } ?>