<?	session_start();
$Prefix = "../../";
require_once($Prefix."includes/config.php");
require_once($Prefix."classes/dbClass.php");
require_once($Prefix."includes/function.php");
require_once($Prefix."classes/admin.class.php");



//added by karishma for theme on 26 fb 2016
require_once($Prefix."classes/theme.class.php");
//end by karishma for theme
$objConfig=new admin();

if(empty($_SERVER['HTTP_REFERER'])){
	//echo 'Protected.';exit;
}
/********Connecting to main database*********/
$Config['DbName'] = $_SESSION['CmpDatabase'];
$objConfig->dbName = $Config['DbName'];
$objConfig->connect();
/*******************************************/
CleanGet();
switch($_GET['action']){

	case 'getPage':
		$themeObj=new theme();
		$arryPage = $themeObj->GetPagesByThemeIdAndPageID($_REQUEST['page_id']);
		if ($arryPage[0]['id'] != "")
		{
			$arrayLayout=array('withoutsidebar','leftsidebar','rightsidebar','bothsidebar');
			$AjaxHtml  = '<div class="editor-page-layout">';
			foreach($arrayLayout as $val){
				$AjaxHtml  .= '<div class="layout-field"><input type="radio" name="layout" id="layout" value="'.$val.'" ';
				if($val==$arryPage[0]['layoutType'])
				$AjaxHtml  .= 'checked';

				$AjaxHtml  .= '/>'.$val.'</div>';
			}

			$AjaxHtml  .= '</div><div class="choose-layout"><input type="button" class="button" name="Select" value="Choose Layout" onclick="chooseLayout(\''.$arryPage[0]['id'].'\');"></div>';


		}

		break;

	case 'saveLayout':
		$themeObj=new theme();
		$arryPage = $themeObj->SaveLayout($_REQUEST['page_id'],$_REQUEST['layoutval']);
		$arryPage = $themeObj->GetPagesByThemeIdAndPageID($_REQUEST['page_id']);
		if ($arryPage[0]['id'] != "")
		{

			$AjaxHtml  = $arryPage[0]['setting'];


		}

		break;

	case 'savesetting':
		$themeObj=new theme();
		$arryPage = $themeObj->SaveSetting($_REQUEST['page_id'],$_REQUEST['content']);
		$arryPage = $themeObj->GetPagesByThemeIdAndPageID($_REQUEST['page_id']);
		if ($arryPage[0]['id'] != "")
		{

			$AjaxHtml  = $arryPage[0]['setting'];

		}

		break;

	case 'getSection':
		$themeObj=new theme();
		$type=$_REQUEST['type'];		
		
		$arryTheme = $themeObj->getThemeById($_REQUEST['themeId']);
		if ($arryTheme[0]['id'] != "")
		{
			
			/*$dom = new DOMDocument();
			@$dom->loadHtml($arryTheme[0][$type]);
			$length = $dom->getElementsByTagName('div')->length;

			for($i=0;$i<$length;$i++){
				$id = $dom->getElementsByTagName("div")->item($i)->getAttribute("id");
				if($id!=''){
					
				}
				

			}*/
				
			
			$AjaxHtml  = $arryTheme[0][$type];


		}

		break;

	case 'saveSectionsetting':
		$themeObj=new theme();
		$type=$_REQUEST['type'];
		$arryPage = $themeObj->saveSectionsetting($_REQUEST['themeId'],$_REQUEST['type'],$_REQUEST['content']);
		$arryTheme = $themeObj->getThemeById($_REQUEST['themeId']);
		if ($arryTheme[0]['id'] != "")
		{
			$AjaxHtml  = $arryTheme[0][$type];
				
		}

		break;

	case 'getStyle':
		$themeObj=new theme();
		$arryTheme = $themeObj->getThemeById($_REQUEST['themeId']);
		
		$tempfolder=$arryTheme[0]['themeUploadedName'];
		$filePath=$Prefix.'template/'.$tempfolder.'/css/style.css';
		$file = file_get_contents($filePath, true);

		$AjaxHtml  = '<div class="editor-css">
			<div class="css-area">
			<textarea class="editor-textarea" name="cssstyle" id="cssstyle">'.$file.'</textarea>
			</div>
			';
			
			
		$AjaxHtml  .= '<input type="button" name="Select" class="button" value="Save CSS" onclick="saveStyle(\''.$_REQUEST['themeId'].'\');">
			</div>';



		break;

	case 'saveStyle':
		$themeObj=new theme();
		$arryTheme = $themeObj->getThemeById($_REQUEST['themeId']);
		$tempfolder=$arryTheme[0]['themeUploadedName'];
		$filePath=$Prefix.'template/'.$tempfolder.'/css/style.css';
		//$oldContent = file_get_contents($filePath, true);

		$myfile = \fopen($filePath, "w") or die("Unable to open file!");
		$newContent = $_REQUEST['cssstyle'];
		\fwrite($myfile, $newContent);
		\fclose($myfile);
		$file = file_get_contents($filePath, true);
		$AjaxHtml  = '<div class="editor-css">
			<div class="css-area">
			<textarea class="editor-textarea"  name="cssstyle" id="cssstyle">'.$file.'</textarea>
			</div>
			';
			
			
		$AjaxHtml  .= '<input type="button" name="Select" class="button" value="Select" onclick="saveStyle(\''.$_REQUEST['themeId'].'\');">
			</div>';



		break;



			
}

if(!empty($AjaxHtml)){ echo $AjaxHtml; exit;}

?>
