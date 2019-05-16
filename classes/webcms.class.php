<?

class webcms extends dbClass
{

	/****************************************************************************8/
		/*Article Function Area*/
	function getMenutype() {
		$sql = "SELECT * from web_menutype  ORDER BY MenuTypeId ASC ";
		return $this->query($sql, 1);
	}

	/***********************************************************************************/
	/*Menu Function Area*/
	function addMenu($arryDetails) {
		@extract($arryDetails);
		if($CustomerID=='') $CustomerID='0';
		$sql = "INSERT INTO  web_menus SET Name='" . addslashes($Name) . "', Alias = '" . addslashes($Alias) . "',
		Priority = '".$Priority."',Link = '".$Link."',MetaKeywords='".addslashes($MetaKeywords)."',
		MetaTitle='".addslashes($MetaTitle)."',MetaDescription='".addslashes($MetaDescription)."',
		Status='" . $Status . "',ParentId='".addslashes($ParentId)."' ,MenuTypeId='".addslashes($MenuTypeId)."', 
		CustomerID='".addslashes($CustomerID)."'";
		$this->query($sql, 0);
	}

	function getMenus($CustomerID=0) {
		$sql = "SELECT Menu.*, Menutype.`MenuType` FROM web_menus AS Menu
					LEFT JOIN web_menutype Menutype ON Menutype.`MenuTypeId`=Menu.`MenuTypeId`
					where CustomerID='" . addslashes($CustomerID) . "' ORDER BY MenuId DESC ";
		return $this->query($sql, 1);
	}



	function getParentMenus($parentid,$num,$selected=0,$CustomerID=0) {
		$sql="select * from web_menus  where ParentId= '".$parentid."' And CustomerID='" . addslashes($CustomerID) . "' ";
		$rs=mysql_query($sql);
		if(mysql_num_rows($rs)>0) {
			$num=$num+3;
			while($row=mysql_fetch_array($rs)) {
				if($selected==$row['MenuId']) {
					$str="<option value='".$row['MenuId']."' selected>".str_repeat("&nbsp;",$num).$row['Name']."</option>";
				}
				else {
					$str="<option value='".$row['MenuId']."'>".str_repeat("&nbsp;",$num).$row['Name']."</option>";
				}
					
				echo $str;

				$this->getParentMenus($row['MenuId'],$num,$selected,$CustomerID);


			}
		}
			
	}

	function getMenuById($id) {
		$sql = "SELECT * from web_menus WHERE MenuId = '" . $id . "'";
		return $this->query($sql, 1);
	}

	function updateMenu($arryDetails) {
		@extract($arryDetails);
		if($CustomerID=='') $CustomerID='0';
		$sql = "UPDATE  web_menus SET Name='" . addslashes($Name) . "', Alias = '" . addslashes($Alias) . "',
		Priority = '".$Priority."',Link = '".$Link."',MetaKeywords='".addslashes($MetaKeywords)."',
		MetaTitle='".addslashes($MetaTitle)."',MetaDescription='".addslashes($MetaDescription)."',
		Status='" . $Status . "',ParentId='".addslashes($ParentId)."',MenuTypeId='".addslashes($MenuTypeId)."', 
		CustomerID='".addslashes($CustomerID)."'
		WHERE MenuId ='" . $MenuId."'";
		$this->query($sql, 0);
	}

	function deleteMenu($id) {

		$sql = "DELETE from web_menus where MenuId = '" . $id."'";
		$rs = $this->query($sql, 0);

		if (sizeof($rs))
		return true;
		else
		return false;
	}

	function changeMenuStatus($id) {
		$sql = "select * from web_menus where MenuId='" . $id."'";
		$rs = $this->query($sql);
		if (sizeof($rs)) {
			if ($rs[0]['Status'] == 'Yes')
			$Status = 'No';
			else
			$Status = 'Yes';

			$sql = "update web_menus set Status='" . $Status . "' where MenuId='" . $id."'";
			$this->query($sql, 0);
			return true;
		}
	}

	function getPagesforFront() {
		$sql = "SELECT * from web_menus WHERE Status = 'Yes' ORDER BY Priority ASC ";
		return $this->query($sql, 1);
	}


	function validateAlias($arryDetails){
		@extract($arryDetails);
		if($CustomerID=='') $CustomerID='0';

		$sql = "SELECT count(*) as total from web_menus  where Alias = '" . addslashes(trim($Alias)) . "'
		and CustomerID='".addslashes($CustomerID)."' and MenuId!='".addslashes($MenuId)."' ";
		$res=$this->query($sql, 1);
			
		if ($res[0]['total'] >0){
			return false;
		}
		return true;
			
	}

	/***************************************************/
	/*Category Function Area*/

	function getCategories() {
		$sql = "SELECT * from web_categories  ORDER BY CatId DESC ";
		return $this->query($sql, 1);
	}
	function getCategoryById($id) {
		$sql = "SELECT * from web_categories WHERE CatId = '" . $id . "'";
		return $this->query($sql, 1);
	}

	function changeCategoryStatus($id) {
		$sql = "select * from web_categories where CatId='" . $id."'";
		$rs = $this->query($sql);
		if (sizeof($rs)) {
			if ($rs[0]['Status'] == 'Yes')
			$Status = 'No';
			else
			$Status = 'Yes';

			$sql = "update web_categories set Status='" . $Status . "' where CatId='" . $id."'";
			$this->query($sql, 0);
			return true;
		}
	}

	function deleteCategory($id) {

		$sql = "DELETE from web_categories where CatId = '" . $id."'";
		$rs = $this->query($sql, 0);

		if (sizeof($rs))
		return true;
		else
		return false;
	}
	function addCategory($arryDetails) {
		@extract($arryDetails);
		$Added_date=date('Y-m-d H:i:s');
		$sql = "INSERT INTO  web_categories SET Name='" . addslashes($Name) . "',Status='" . $Status . "',Added_date='" . addslashes($Added_date) . "' ";
		$this->query($sql, 0);
	}

	function updateCategory($arryDetails) {
		@extract($arryDetails);
			
		$sql = "UPDATE  web_categories SET Name='" . addslashes($Name) . "',Status='" . $Status . "' WHERE CatId ='" . $CatId."'";
		$this->query($sql, 0);
	}



	/****************************************************************************8/
		/*Article Function Area*/
	function getArticles($CustomerID=0) {
		$sql = "SELECT Article.*,Category.`Name` FROM web_articles AS Article
					LEFT JOIN web_categories Category ON Category.`CatId`=Article.`CatId`
   					where Article.CustomerID='" . addslashes($CustomerID) . "' ORDER BY ArticleId DESC ";
		return $this->query($sql, 1);
	}
	function getArticleById($id) {
		$sql = "SELECT * from web_articles WHERE ArticleId = '" . $id . "'";
		return $this->query($sql, 1);
	}

	function changeArticleStatus($id) {
		$sql = "select * from web_articles where ArticleId='" . $id."'";
		$rs = $this->query($sql);
		if (sizeof($rs)) {
			if ($rs[0]['Status'] == 'Yes')
			$Status = 'No';
			else
			$Status = 'Yes';

			$sql = "update web_articles set Status='" . $Status . "' where ArticleId='" . $id."'";
			$this->query($sql, 0);
			return true;
		}
	}

	function deleteArticle($id) {

		$sql = "DELETE from web_articles where ArticleId = '" . $id."'";
		$rs = $this->query($sql, 0);

		if (sizeof($rs))
		return true;
		else
		return false;
	}
	function addArticle($arryDetails) {
		@extract($arryDetails);
		$Added_date=date('Y-m-d H:i:s');
		$sql = "INSERT INTO  web_articles SET Title='" . addslashes($Title) . "',Introtext='" . addslashes(substr($Fulltext,0,30)) . "',`Fulltext`='" . addslashes($Fulltext) . "',Status='" . $Status . "',Priority='" . $Priority . "',
		Added_date='" . addslashes($Added_date) . "' ,FormId='" . $FormId . "' , CustomerID='" . addslashes($CustomerID) . "'";
		$this->query($sql, 0);
	}

	function updateArticle($arryDetails) {
		@extract($arryDetails);
		if($CustomerID=='') $CustomerID=0;
		$sql = "UPDATE  web_articles SET Title='" . addslashes($Title) . "',Introtext='" . addslashes(substr($Fulltext,0,30)) . "',`Fulltext`='" . addslashes($Fulltext) . "',Status='" . $Status . "',Priority='" . $Priority . "',FormId='" . $FormId . "', CustomerID='" . addslashes($CustomerID) . "' WHERE ArticleId ='" . $ArticleId."'";
		$this->query($sql, 0);
	}


	/***********************************************************************************/
	/*Template Function Area*/
	function getTemplatesold() {
		$sql = "SELECT * from web_templates  ORDER BY TemplateId DESC ";
		return $this->query($sql, 1);
	}

	function getTemplates($TemplateType) {
		global $Config;
			$CmpID=$_SESSION['CmpID'];
		$objConfig=new admin();
		/********Connecting to main database*********/
		$Config['DbName'] = $Config['DbMain'];
		$objConfig->dbName = $Config['DbName'];
		$objConfig->connect();
		/*******************************************/
		$sql = "SELECT * from templates where TemplateType='" . addslashes($TemplateType) . "' and (CmpID = '".$CmpID."' or TemplateDis='Public')   ORDER BY TemplateId DESC ";
		$templates= $this->query($sql, 1);
			
		/********Connecting to Cmp database*********/
		$Config['DbName'] = $_SESSION['CmpDatabase'];
		$objConfig->dbName = $Config['DbName'];
		$objConfig->connect();
		/*******************************************/
		return $templates;
	}
	function updateTemplate($arryDetails) {
		@extract($arryDetails);
			
			
		$sql = "SELECT count(*) as total from web_setting where CustomerID ='" . addslashes($CustomerID) . "'";
		$res=$this->query($sql, 1);
			
		if($res[0]['total']==0){
			$sql = "INSERT INTO  web_setting SET TemplateId='" . addslashes($TemplateId) . "',CustomerID ='" . addslashes($CustomerID) . "'";
			$this->query($sql, 0);
		}else{
			$sql = "UPDATE  web_setting SET TemplateId='" . addslashes($TemplateId) . "' WHERE Id ='".$Id."' and CustomerID ='" . addslashes($CustomerID) . "'";
			$this->query($sql, 0);
		}
	}

	/***********************************************************************************/
	/*Setting Function Area*/
	function getSetting($CustomerID=0) {
		$sql = "SELECT * from web_setting where CustomerID ='" . addslashes($CustomerID) . "' ";
		return $this->query($sql, 1);
	}

	function updateSetting($arryDetails) {
		@extract($arryDetails);
		
		if($CustomerID=='') $CustomerID='0'; 	
			
		$sql = "SELECT count(*) as total,Id from web_setting where CustomerID ='" . addslashes($CustomerID) . "'";
		
		$res=$this->query($sql, 1);
		if($Id=='') $Id=$res[0]['Id'];
			
		if(empty($Header)) $Header='No';
		if(empty($Footer)) $Footer='No';
		if(empty($Left)) $Left='No';
		if(empty($Right)) $Right='No';
			
		if(empty($Facebook))   {$Facebook='No'; $FacebookLink='';}
		if(empty($Twitter))    {$Twitter='No'; $TwitterLink='';}
		if(empty($LinkedIn))   {$LinkedIn='No'; $LinkedInLink='';}
		if(empty($GooglePlus)) {$GooglePlus='No'; $GooglePlusLink='';}
			
		if($res[0]['total']==0){
			 $sql = "INSERT INTO  web_setting SET Header='1',Footer='" . addslashes($Footer) . "',
				`Left`='" . addslashes($Left) . "',`Right`='" . addslashes($Right) . "'  ,
				copyright='" . addslashes($copyright) . "' ,Sitename='" . addslashes($Sitename) . "',
				Facebook='" . addslashes($Facebook) . "' ,FacebookLink='" . addslashes($FacebookLink) . "',
				Twitter='" . addslashes($Twitter) . "' ,TwitterLink='" . addslashes($TwitterLink) . "',
				LinkedIn='" . addslashes($LinkedIn) . "' ,LinkedInLink='" . addslashes($LinkedInLink) . "',
				GooglePlus='" . addslashes($GooglePlus) . "' ,GooglePlusLink='" . addslashes($GooglePlusLink) . "',
				GoogleAnalytics='" . addslashes($GoogleAnalytics) . "' , CustomerID ='" . addslashes($CustomerID) . "',
				DRedirect='" . addslashes($DRedirect) . "' ";  
			$this->query($sql, 0);
		}else{
			 $sql = "UPDATE  web_setting SET Header='1',Footer='" . addslashes($Footer) . "',
				`Left`='" . addslashes($Left) . "',`Right`='" . addslashes($Right) . "' ,
				copyright='" . addslashes($copyright) . "',Sitename='" . addslashes($Sitename) . "' ,				
				Facebook='" . addslashes($Facebook) . "' ,FacebookLink='" . addslashes($FacebookLink) . "',
				Twitter='" . addslashes($Twitter) . "' ,TwitterLink='" . addslashes($TwitterLink) . "',
				LinkedIn='" . addslashes($LinkedIn) . "' ,LinkedInLink='" . addslashes($LinkedInLink) . "',
				GooglePlus='" . addslashes($GooglePlus) . "' ,GooglePlusLink='" . addslashes($GooglePlusLink) . "',
				GoogleAnalytics='" . addslashes($GoogleAnalytics) . "',DRedirect='" . addslashes($DRedirect) . "',
				HomeContent='" . addslashes($HomeContent) . "'
				WHERE Id ='".$Id."' and CustomerID ='" . addslashes($CustomerID) . "' "; 
			$this->query($sql, 0);
		}
		
		
	}

	function UpdateImage($imageName,$CustomerID=0)
	{
			
		$sql = "SELECT count(*) as total,Id from web_setting where CustomerID ='" . addslashes($CustomerID) . "' ";
		$res=$this->query($sql, 1);
			
		if($res[0]['total']==0){
			$sql = "INSERT INTO  web_setting SET Logo='".$imageName."',CustomerID ='" . addslashes($CustomerID) . "' ";
			return $this->query($sql, 0);
		}else{
			$sql = "UPDATE  web_setting SET Logo='".$imageName."' WHERE CustomerID ='" . addslashes($CustomerID) . "' And Id ='" . $res[0]['Id']."'";

			return $this->query($sql, 0);
		}

	}

	function UpdateLogo(){
		$sql = "SELECT count(*) as total,Id from web_setting ";
		$res=$this->query($sql, 1);
			
		$sql = "UPDATE  web_setting SET Logo='' WHERE Id ='" . $res[0]['Id']."'";
		return $this->query($sql, 0);
			
	}


	/*************************Form Function Area**********************************/

	function getForms($CustomerID=0) {
		$sql = "SELECT * from web_forms	where CustomerID='" . addslashes($CustomerID) . "' ORDER BY FormId DESC ";
		return $this->query($sql, 1);
	}

	function addForm($arryDetails) {
		@extract($arryDetails);
		if($CustomerID=='') $CustomerID='0';
		$Added_date=date('Y-m-d H:i:s');
			
		if(empty($Status)) $Status='No';
			
			
		$sql = "INSERT INTO  web_forms SET FormName='" . addslashes($FormName) . "',
			Added_Date='" . addslashes($Added_date) . "',CustomerID='" . addslashes($CustomerID) . "',	Status='" . $Status . "' ";
		$this->query($sql, 0);
	}
	function getFormById($id) {
		$sql = "SELECT * from web_forms WHERE FormId = '" . $id . "'";
		return $this->query($sql, 1);
	}

	function updateForm($arryDetails) {
		@extract($arryDetails);
		if($CustomerID=='') $CustomerID='0';
		if(empty($Status)) $Status='No';
			
		$sql = "UPDATE  web_forms SET FormName='" . addslashes($FormName) . "',CustomerID='" . addslashes($CustomerID) . "', Status='" . $Status . "'
			WHERE FormId ='" . $FormId."'"; 
		$this->query($sql, 0);
	}

	function deleteForm($id) {

		$sql = "DELETE from web_forms where FormId = '" . $id."'";
		$rs = $this->query($sql, 0);

		if (sizeof($rs))
		return true;
		else
		return false;
	}

	function changeFormStatus($id) {
		$sql = "select * from web_forms where FormId='" . $id."'";
		$rs = $this->query($sql);
		if (sizeof($rs)) {
			if ($rs[0]['Status'] == 'Yes')
			$Status = 'No';
			else
			$Status = 'Yes';

			$sql = "update web_forms set Status='" . $Status . "' where FormId='" . $id."'";
			$this->query($sql, 0);
			return true;
		}
	}

	/*************************Form Field Function Area**********************************/

	function getFormFields($CustomerID=0) {
		$sql = "select FormField.*,Forms.FormName from web_forms_fields as FormField
			inner join web_forms Forms on Forms.FormId=FormField.FormId
			Where FormField.CustomerID='" . addslashes($CustomerID) . "'
			ORDER BY FieldId DESC ";
		return $this->query($sql, 1);
	}

	function addFormField($arryDetails) {
		@extract($arryDetails);
			
			
		if(empty($Status)) $Status='No';
		if(empty($Manadatory)) $Manadatory='No';

		if($CustomerID=='') $CustomerID='0';
			
		$FieldName=str_replace(" ","_",strtolower(trim($FieldName)));
		$sql = "INSERT INTO  web_forms_fields SET FormId='" . addslashes($FormId) . "',
			FieldType='" . addslashes($FieldType) . "', FieldName='" . addslashes($FieldName) . "', 
			Fieldlabel='" . addslashes($Fieldlabel) . "', Fieldvalues='" . addslashes($Fieldvalues) . "', 
			Priority='" . addslashes($Priority) . "', Manadatory='" . addslashes($Manadatory) . "',Status='" . $Status . "',
			CustomerID='" . addslashes($CustomerID) . "' ";
		$this->query($sql, 0);
	}
	function getFormFieldById($id) {
		$sql = "SELECT * from web_forms_fields WHERE FieldId = '" . $id . "'";
		return $this->query($sql, 1);
	}

	function updateFormField($arryDetails) {
		@extract($arryDetails);
			
		if(empty($Status)) $Status='No';
		if(empty($Manadatory)) $Manadatory='No';
		if($CustomerID=='') $CustomerID=0;
		$sql = "UPDATE  web_forms_fields SET FormId='" . addslashes($FormId) . "',
			FieldType='" . addslashes($FieldType) . "', FieldName='" . addslashes($FieldName) . "', 
			Fieldlabel='" . addslashes($Fieldlabel) . "', Fieldvalues='" . addslashes($Fieldvalues) . "', 
			Priority='" . addslashes($Priority) . "', Manadatory='" . addslashes($Manadatory) . "', Status='" . $Status . "',CustomerID='" . addslashes($CustomerID) . "'
			WHERE FieldId ='" . $FieldId."'"; 
		$this->query($sql, 0);
	}

	function deleteFormField($id) {

		$sql = "DELETE from web_forms_fields where FieldId = '" . $id."'";
		$rs = $this->query($sql, 0);

		if (sizeof($rs))
		return true;
		else
		return false;
	}

	function changeFormFieldStatus($id) {
		$sql = "select * from web_forms_fields where FieldId='" . $id."'";
		$rs = $this->query($sql);
		if (sizeof($rs)) {
			if ($rs[0]['Status'] == 'Yes')
			$Status = 'No';
			else
			$Status = 'Yes';

			$sql = "update web_forms_fields set Status='" . $Status . "' where FieldId='" . $id."'";
			$this->query($sql, 0);
			return true;
		}
	}
	/*************************Front Data function**********************************/

	function getFormData($CustomerID=0) {
		$sql = "SELECT Fdata.*,Form.FormName FROM web_form_data as Fdata
		inner join web_forms Form on Form.FormId=Fdata.FormId
		where Fdata.CustomerID='".addslashes($CustomerID) ."' group by Added_no order by Added_date ASC";
		return $this->query($sql, 1);
	}

	function getFormFieldData($formId){
		$sql = "select FormField.*,Forms.FormName from web_forms_fields as FormField
			inner join web_forms Forms on Forms.FormId=FormField.FormId
			where FormField.FormId='".addslashes($formId)."' and FormField.Status='Yes'
			ORDER BY FormField.Priority ASC ";
		return $this->query($sql, 1);
	}

	function getFormDataByAddedNoFormIDFieldId($Added_no,$formId,$FieldId) {
		$sql = "SELECT Fdata.*,Form.FormName FROM web_form_data as Fdata
		inner join web_forms Form on Form.FormId=Fdata.FormId
		where Fdata.Added_no='".addslashes($Added_no) ."' and Fdata.FormId='".addslashes($formId) ."' 
		and Fdata.FieldId='".addslashes($FieldId) ."'
		group by Added_no order by Added_date ASC";
		return $this->query($sql, 1);
	}

	function deleteFormData($Added_no,$formId) {

		$sql = "DELETE from web_form_data where Added_no = '".addslashes($Added_no) ."' and FormId='".addslashes($formId) ."' " ;
		$rs = $this->query($sql, 0);

		if (sizeof($rs))
		return true;
		else
		return false;
	}

	function createFormData($formfield,$selecteddata){

		$submitvalue=$selecteddata[0]['FieldValue'];

		$Fieldvalues=explode(',',trim($formfield['Fieldvalues']));

		$required=($formfield['Manadatory']=='Yes')? " required" : "";
		$span=($formfield['Manadatory']=='Yes')? "<span class='red'>*</span>" : "";


		$str='<tr>';
		$str .='<td width="30%" align="right" valign="top" class="blackbold">'.$formfield['Fieldlabel'].' : '.$span.'</td>';
		$str .='<td width="56%" align="left" valign="top">';


		switch(strtolower($formfield['FieldType']) ){
			case textbox:
				$str .='<input type="text" readonly="readonly" name="'.$formfield['FieldName'].'" class="inputbox '.$required.'" size="50" value="'.$submitvalue.'" />';
				break;
			case dropdown:
				$str .='<select name="'.$formfield['FieldName'].'"  class="inputbox '.$required.' " disabled="true"/>';
				foreach($Fieldvalues as $value){
					$str .='<option value="'.$value.'" ';
					if($value==$submitvalue) $str .='selected="selected" ';
					$str .='>'.$value.'</option>';
				}
				$str .='</select>';
				break;
			case checkbox:
				$submitvalueArray=explode(',',$submitvalue);
				foreach($Fieldvalues as $value){
					$str .='<input type="checkbox" disabled="disabled" name="'.$formfield['FieldName'].'[]" class="'.$required.'" value="'.$value.'"';
					if(in_array($value, $submitvalueArray)) $str .='checked="checked" ';
					$str .='/>'.$value;
				}
				break;
			case textarea:
				$str .='<textarea style="width:60%; height: 85px;" readonly="readonly" name="'.$formfield['FieldName'].'" class="inputbox '.$required.'">'.$submitvalue.'</textarea>';
				break;
			case radio:
				$submitvalueArray=explode(',',$submitvalue);
				foreach($Fieldvalues as $value){
					$str .='<input type="radio" disabled="disabled"  class="'.$required.'" name="'.$formfield['FieldName'].'" value="'.$value.'" ';
					if(in_array($value, $submitvalueArray)) $str .='checked="checked" ';
					$str .='/>'.$value;
				}

				break;
			case email:
				$str .='<input type="text" readonly="readonly"  name="'.$formfield['FieldName'].'" class="inputbox email '.$required.'" size="50" value="'.$submitvalue.'" />';
				break;
			case file:
				if($submitvalue!=''){
					$str .='<a href="/web/upload/'.$submitvalue.'" target="_new">Download File</a>';
				}
				break;
			default:
				$str .='<input type="text" readonly="readonly"  name="'.$formfield['FieldName'].'" class="inputbox '.$required.'" value="'.$submitvalue.'"  size="50" />';
		}

		$str .='</td>';

		$str .='</tr>';
		return $str;

	}

	/*************************Front end function**********************************/

	function  GetGlobalSetting()
	{
		$sql = "SELECT Setting.*,Template.`TemplateName` FROM web_setting AS Setting
			LEFT JOIN `web_templates` Template ON Template.`TemplateId`=Setting.`TemplateId`";
		return $this->query($sql, 1);
	}


	function GetFrontMenus($MenuType='1') {
		$sql = "SELECT Menu.* FROM web_menus AS Menu
			WHERE Menu.`MenuTypeId`='" . addslashes($MenuType) . "' AND Menu.`Status`='Yes' AND Menu.`ParentId`='0' ORDER BY Menu.Priority ASC ";
		return $this->query($sql, 1);
	}
	function GetFrontMenusById($id) {
		$sql = "SELECT Menu.*,Articles.`Fulltext` FROM web_menus AS Menu
			LEFT JOIN `web_articles` Articles ON Articles.`ArticleId`=Menu.`Link`
			WHERE Menu.`MenuId`='" . addslashes($id) . "' AND Menu.`Status`='Yes' ORDER BY Menu.Priority ASC ";
		return $this->query($sql, 1);
	}

	function GetFrontMenusByAlias($Alias) {
		$sql = "SELECT Menu.*,Articles.`Fulltext` FROM web_menus AS Menu
			LEFT JOIN `web_articles` Articles ON Articles.`ArticleId`=Menu.`Link`
			WHERE Menu.`Alias`='" . addslashes($Alias) . "' AND Menu.`Status`='Yes' ORDER BY Menu.Priority ASC ";
		return $this->query($sql, 1);
	}

	function getFrontMenusTmpl($MenuType,$parentid,$selected=0,$is_repeat=0) {
		$sql = "SELECT Menu.* FROM web_menus AS Menu
			WHERE Menu.`MenuTypeId`='" . addslashes($MenuType) . "' AND Menu.`ParentId`='".$parentid."' AND Menu.`Status`='Yes' ORDER BY Menu.Priority ASC "; 
			
			
		$rs=mysql_query($sql);
		if(mysql_num_rows($rs)>0) {
			if($is_repeat>0)
			$is_repeat=$is_repeat+3;

			echo '<ul>';
			while($row=mysql_fetch_array($rs)) {
					
				$menu_link = "menu.php?menu_id=".$row['MenuId'];
				if($selected==$row['MenuId']) {
					//$str="<option value='".$row['MenuId']."' selected>".str_repeat("&nbsp;",$num).$row['Name']."</option>";
					echo ' <li class="active"><a href="'.$menu_link.'">'.str_repeat("&nbsp;",$is_repeat).$row['Name'].'</a>';


				}
				else {
					echo ' <li class=""><a href="'.$menu_link.'">'.str_repeat("&nbsp;",$is_repeat).$row['Name'].'</a>';


					//$str="<option value='".$row['MenuId']."'>".str_repeat("&nbsp;",$num).$row['Name']."</option>";
				}
				$this->getFrontMenusTmpl($MenuType,$row['MenuId'],$selected,$is_repeat);
				echo '</li>';

					


			}
			echo '</ul>';
		}
			
	}


	/*Setting Function Area*/
	function getecomSetting() {
		$sql = "SELECT * from e_template  ";
		return $this->query($sql, 1);
	}

	function updateecomTemplate($arryDetails) {
		@extract($arryDetails);
			
			
		$sql = "SELECT count(*) as total from e_template ";
		$res=$this->query($sql, 1);
			
		if($res[0]['total']==0){
			$sql = "INSERT INTO  e_template SET TemplateId='" . addslashes($TemplateId) . "'";
			$this->query($sql, 0);
		}else{
			$sql = "UPDATE  e_template SET TemplateId='" . addslashes($TemplateId) . "' WHERE Id =" . $Id;
			$this->query($sql, 0);
		}
	}


	// Function for multi sites

	function totalAllowedSites(){
		$CmpID=$_SESSION['CmpID'];
		$sql = "SELECT MultiSite FROM erp.company WHERE CmpID='" . addslashes($CmpID). "'  ";
			
		$arrayRow =  $this->query($sql, 1);
		return $arrayRow[0]['MultiSite'];
	}

	function totalAssignedSites(){

		$sql = "SELECT count(*) as total from web_assign_customer ";
		$res=$this->query($sql, 1);
		return $res[0]['total'];
	}

	function totalAssignedSitesByCustomer($CustId){

		$sql = "SELECT count(*) as total from web_assign_customer where  CustomerId!= '" . addslashes($CustId). "'  ";
		$res=$this->query($sql, 1);
		return $res[0]['total'];
	}

	function getWebAssignCustomer() {
		$sql = "SELECT a . *,IF(b.FullName != '',b.FullName,IF(b.Company != '', b.Company, 'Owned')) as FullName,c.Sitename FROM `web_assign_customer` as a left join s_customers b ON b.Cid = a.CustomerId left join web_setting c ON c.CustomerID = a.CustomerId ";
 
		return $this->query($sql, 1);
	}



	function getCustomers()
	{
		$CmpID=$_SESSION['CmpID'];
		$sql="Select id,permission,ref_id FROM erp.`company_user` WHERE 1 AND comId='" . addslashes($CmpID). "'  AND user_type='customer '";
		$res=$this->query($sql, 1);

		$SqlCustomer = "select * from web_assign_customer WHERE CustomerId='0' AND IsCompany='1'  ";
		$result=$this->query($SqlCustomer, 1);

		if($result[0]['Id']!=''){
			$customerArray=array();
		}else{
			$customerArray[]=array('Cid'=>'0','FullName'=>'Owned');
		}

		foreach($res as $val){

			$SqlCustomer = "select c1.Cid, c1.Company, IF(c1.CustomerType = 'Company' and c1.Company!='', c1.Company, c1.FullName) as FullName, b.* from s_customers c1
			left join web_assign_customer b on b.CustomerId=c1.Cid
			WHERE c1.Cid='" . addslashes($val['ref_id']). "' ";
			$result=$this->query($SqlCustomer, 1);

			$CustomerName=$result[0]['FullName'];
			if($result[0]['FullName']=='') $CustomerName=$result[0]['Company'];

			if(!empty($result[0]['Cid']) && !empty($CustomerName)  && $CustomerName!='' && ($result[0]['Id']=='0' || $result[0]['Id']==''))
			$customerArray[]=array('Cid'=>$result[0]['Cid'],'FullName'=>stripslashes($CustomerName));
		}
		return $customerArray;
			

	}

	function assignCustomer($arryDetails){
		@extract($arryDetails);
		$CmpID=$_SESSION['CmpID'];
			
		$sql = "SELECT count(*) as total from web_assign_customer where CustomerId='" . addslashes($CustId). "' ";
		$res=$this->query($sql, 1);
		if($res[0]['total']==0){
			$sql="Select FirstName,LastName,Company FROM s_customers WHERE  Cid='" . addslashes($CustId). "' ";
			$custdetails=$this->query($sql, 1);
				
				
			$sitename=strtolower($custdetails[0]['FirstName']).strtolower($custdetails[0]['LastName']);
			if($sitename==''){
				$sitename=strtolower($custdetails[0]['Company']);
			}
			
			$is_exist=$this->isSitenameExists($sitename,$CustId);

			if($is_exist){

				$sitename=$this->generateSitename(1,$sitename,$CustId);
			}
			$array['CustomerID']=$CustId;
			$array['Sitename']=$sitename;
			
			$this->updateSetting($array);
			
				
			if($CustId!=0){
				$sql="Select id,permission FROM erp.`company_user` WHERE 1 AND comId='" . addslashes($CmpID). "' AND ref_id='" . addslashes($CustId). "' AND user_type='customer '";
				$result=$this->query($sql, 1);
				$id=$result[0]['id'];

				$permissionArray=unserialize($result[0]['permission']);
				if(!in_array('website', $permissionArray)){
					array_push($permissionArray, 'website');
				}
				$permission= serialize($permissionArray);
			 $sql = "UPDATE  erp.`company_user` SET permission='" . addslashes($permission) . "' WHERE id ='" . $id."'";
				$this->query($sql, 0);
			}

			$IsCompany='0';
			if($CustId=='0') $IsCompany='1';

			$sql = "INSERT INTO  web_assign_customer SET CustomerId='" . addslashes($CustId). "',
			IsCompany='" . addslashes($IsCompany). "' ";
			$this->query($sql, 0);
				
				



		}
	}

	function generateSitename($length,$sitename,$CustId) {
		$randsitename = $sitename;
		if($sitename==''){
			$length=8;
			$randsitename = '';
		}
		$possibleChars = "abcdefghijklmnopqrstuvwxyz123456789";
		

		for($i = 0; $i < $length; $i++) {
			$rand = rand(0, strlen($possibleChars) - 1);
			$randsitename .= substr($possibleChars, $rand, 1);
		}
		
		$is_exist=$this->isSitenameExists($randsitename,$CustId);
			if(!$is_exist){
				return $randsitename;
			}else{
				$this->generateSitename(1,$sitename,$CustId);
			}
			

		
	}

	function unassignCustomer($Assignid,$CustomerId) {
		$CmpID=$_SESSION['CmpID'];
		if($CustomerId!=0){
			$sql="Select id,permission FROM erp.`company_user` WHERE 1 AND comId='" . addslashes($CmpID). "' AND ref_id='" . addslashes($CustomerId). "' AND user_type='customer'"; 
			$result=$this->query($sql, 1);
			$id=$result[0]['id'];
			if($id!=''){
				$permissionArray=unserialize($result[0]['permission']);
				$permissionArray = explode(",",$permissionArray);
				$key = array_search('website', $permissionArray);
				if (false !== $key){
					unset($permissionArray[$key]);
				}
				$permissionArray=array_values($permissionArray);
				$permission= serialize($permissionArray);
				$sql = "UPDATE  erp.`company_user` SET permission='" . addslashes($permission) . "' WHERE id ='" . $id."'";
				$this->query($sql, 0);
			}
			
		}

		$sql = "DELETE from web_assign_customer where Id = '" . addslashes($Assignid). "' AND  CustomerId = '" . addslashes($CustomerId). "'";
		$rs = $this->query($sql, 0);

		if (sizeof($rs))
		return true;
		else
		return false;
	}

	function unassignCustomerFromCRM($CustomerId) {
		$sql = "DELETE from web_assign_customer where  CustomerId = '" . addslashes($CustomerId). "'";
		$rs = $this->query($sql, 0);

		if (sizeof($rs))
		return true;
		else
		return false;
	}


	function isSitenameExists($Sitename,$CustomerID=0)
	{

		$strSQLQuery = "SELECT Id FROM web_setting WHERE LCASE(Sitename)='".strtolower(trim($Sitename))."' and CustomerId != '" . addslashes($CustomerID). "'";
		$arryRow = $this->query($strSQLQuery, 1);

		if (!empty($arryRow[0]['Id'])) {
			return true;
		} else {
			return false;
		}
	}

	function  GetCustomerIDBySiteName($SiteName)
	{
		$sql = "SELECT Setting.* FROM web_setting AS Setting where SiteName='" . addslashes($SiteName) . "'";
		return $this->query($sql, 1);
	}
}

?>
