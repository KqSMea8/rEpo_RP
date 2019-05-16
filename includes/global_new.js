function ClearTextBox(TextBoxName){
	document.getElementById(TextBoxName).value = '';
}


function OpenForum(PageName){ 
	window.open(PageName,"win1","toolbar=no,directories=no,resizable=yes,menubar=no,location=no,scrollbars=yes,width=1000,height=800,maximize=null,top=20,left=20");

 }


function Trim(p_field){
	fi=0;la=p_field.value.length-1;
	while(fi<p_field.value.length&&p_field.value.charAt(fi)==" "){
		fi++
	};
	if(fi<p_field.value.length){
		while(la>0&&p_field.value.charAt(la)==" "){
			la--;
		};
		p_field.value=p_field.value.substr(fi,((la-fi)+1));
	} else 
		p_field.value="";
	return p_field;
}

function OpenNewPopUp(PageName, Width, Height, ResizableOption ){ 
	window.open(PageName,"win1","toolbar=no,directories=no,resizable="+ResizableOption+",menubar=no,location=no,scrollbars=yes,width="+Width+",height="+Height+",maximize=null,top=70,left=80");

 }

function writeFlash1(id) {
    document.getElementById(id).innerHTML = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="402" height="216"><param name="movie" value="images/map.swf"><param name="quality" value="high"><param name="wmode" value="transparent"><embed src="images/map.swf" width="402" height="216" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" wmode="transparent"></embed></object>';
}


function CreateBookmarkLink() {
	
	title = document.title; 
	url = window.location.href;	


	if (window.sidebar) { // Mozilla Firefox Bookmark
		window.sidebar.addPanel(title, url,"");
	} else if( window.external ) { // IE Favorite
		window.external.AddFavorite( url, title);
	}else if(window.opera) { // Opera Hotlist
		return true; 
	}else{
		alert('Press Ctrl D to add bookmark.');
	}

}


function EmailPage() {
	
	title = document.title; 
	url = window.location.href;	

	window.open(GlobalSiteUrl+"emailPage.php?url="+url,"win1","toolbar=no,directories=no,resize=yes,menubar=no,location=no,scrollbars=yes,width=450,height=340,maximize=null,top=20,left=20");

}



function CompareProducts(Pos){
	var flag=0;
	var prdIDs = '';
	var numPrd = document.getElementById("Num"+Pos+"Product").value;
	
	if(numPrd > 1){
				for(i=1; i<=numPrd; i++)
				{
					if(document.getElementById("CheckProduct"+Pos+i).checked==true)
					{
						flag++;
						prdIDs = prdIDs+document.getElementById("CheckProduct"+Pos+i).value+',';
					}
				}
	}

	if(flag>4){
		alert(SELECT_FOUR_PRODUCTS); 
	}else if(flag>=2){
		document.getElementById("MainResultTable").innerHTML = SENDING_REQUEST;
		location.href = 'compareProducts.php?prdIDs='+prdIDs;
	}else{
		alert(SELECT_TWO_PRODUCTS); 
	}

}



function ViewGallery(){
	var prdIDs = '';
	if(document.getElementById("GalleryProducts").value != ''){
		prdIDs = prdIDs+document.getElementById("GalleryProducts").value;
		document.getElementById("MainResultTable").innerHTML = SENDING_REQUEST;
		location.href = 'gallery.php?prdIDs='+prdIDs;
	}
}


function ShowPopupKeyword(opt){

	if(opt==1){
		var leftPos = FindXPosition(document.getElementById("PopUpImg"));
		var topPos = FindYPosition(document.getElementById("PopUpImg"));

		//leftPos = leftPos - 100;
		//topPos = topPos - 100;

		document.getElementById("PopUpKeywords").style.left = leftPos+'px';
		document.getElementById("PopUpKeywords").style.top = topPos+'px';

		document.getElementById("PopUpKeywords").style.display = 'block';
	}else{
		document.getElementById("PopUpKeywords").style.display = 'none';
	}

}



function ChangePageLink(frm,TotalPage,queryString,PageUrl){
	if(ValidateMandNumField3(frm.Page,"Page number",1,TotalPage)){
		PageUrl = PageUrl+'?curP='+frm.Page.value+'&'+queryString;
		document.getElementById("MainResultTable").innerHTML = SENDING_REQUEST;
		location.href = PageUrl;
	}
	return false;
}

function ChangePageLinkDrop(queryString,PageUrl){
	PageUrl = PageUrl+'?curP='+document.getElementById("PaginDrp").value+'&'+queryString;

	document.getElementById("MainResultTable").innerHTML = SENDING_REQUEST;

	location.href = PageUrl;
}



function ChangePageLinkNextPrev(PageID,queryString,PageUrl){
	PageUrl = PageUrl+'?curP='+PageID+'&'+queryString;

	document.getElementById("MainResultTable").innerHTML = SENDING_REQUEST;

	location.href = PageUrl;
}





function ShowOnlyPhoto(Url,ShowPhoto){
	
	var FinalUrl = '';

	if(document.getElementById(ShowPhoto).checked){
		FinalUrl = Url+'&'+ShowPhoto+'=1';
	}else{
		FinalUrl = Url;
	}

	if(ShowPhoto == 'OnlyPhotoBottom'){
		FinalUrl = FinalUrl+'#BtPrdDv';
	}

	
    document.getElementById("MainResultTable").innerHTML = SENDING_REQUEST;

	location.href = FinalUrl;


}



function StoreLeftSearch(frm){
	Trim(frm.TopKeyword);

	if(frm.TopKeyword.value == 'Search Term'){
		frm.TopKeyword.value = '';
	}


	if(frm.TopKeyword.value==''){
		alert("Please enter a search term.");
		frm.TopKeyword.focus();
		return false;
	}
	
	
	if(CheckSpecialCharactersForSearch(frm.TopKeyword,SPECIAL_CHAR_SEARCH)){
		return false;
	}

	var TopProductLink='';


	TopProductLink += "storeSearch.php?topkey="+escape(frm.TopKeyword.value);
	
	
	location.href = TopProductLink;
	return false;
	

}




function validateLogin(frm)
{	
	if( ValidateForEmail(frm.LoginEmail)
		&& isEmail(frm.LoginEmail)
		&& ValidateForPassword(frm.LoginPassword)
	){
		return true;	
	}else{
		return false;	
	}
}







function ValidateMandNumField3(p_field,p_FieldName,p_min,p_max){
	Trim(p_field);
	if (!p_field.value){
		alert("Please Enter " + p_FieldName + ".");
		p_field.focus();
		return 0;
	}
	else
		if(isNaN(parseInt(p_field.value))){
			alert(p_FieldName + " must be a number.");
			p_field.focus();
			return 0;
		}
		else
			if(parseInt(p_field.value)<parseInt(p_min)){
				alert(p_FieldName + " must be greater than or equal to " + p_min + ".");
				p_field.focus();
				return 0;
			}
			else
				if (parseInt(p_field.value)>parseInt(p_max)){
					alert(p_FieldName + " must be less than or equal to " + p_max + ".");
					p_field.focus();
					return 0;
				}
	if(p_field.value.length!=parseInt(p_field.value).toString().length){
		alert(p_FieldName + " must be a number.");
		p_field.focus();
		return 0;
	}
	return p_field;
}








 /*-------------------------------------*/
 /*-------------------------------------*/

function isLink(formInput) {
	if(Trim(formInput).value == "" ) {
		return 1;
	}else{
	   var reg = /^(http:\/\/|https:\/\/){1}[0-9A-Za-z\.\-]*\.[0-9A-Za-z\.\-]*$/;

	   var address = formInput.value;
	   if(reg.test(address) == false) {
			alert(GLOBAL_URL);            
		  formInput.select();
		  return 0;
	   }
		return 1;

	}

}


function isValidLinkOpt(formInput,p_FieldName){

	if(Trim(formInput).value == "" ) {
		return 1;
	}else{
	   var reg = /^(http:\/\/|https:\/\/){1}[-a-zA-Z0-9@:%_\+.~#?&//=]*\.[-a-zA-Z0-9@:%_\+.~#?&//=]*$/;

	   var address = formInput.value;
	   if(reg.test(address) == false) {
			alert("Please Enter Valid "+p_FieldName+".");            
		  formInput.select();
		  return 0;
	   }
		return 1;

	}

}

function isValidLink(formInput,p_Message){

	if(Trim(formInput).value == "" ) {
		alert(p_Message);            
		formInput.focus();
		return 0;
	}else{
	   var reg = /^(http:\/\/|https:\/\/){1}[-a-zA-Z0-9@:%_\+.~#?&//=]*\.[-a-zA-Z0-9@:%_\+.~#?&//=]*$/;


	   var address = formInput.value;
	   if(reg.test(address) == false) {
			alert(GLOBAL_URL);            
		  formInput.select();
		  return 0;
	   }
		return 1;

	}

}

function isLink2(formInput){
	var aPosition, dotPosition, lastPosition;

	if(Trim(formInput).value == "" ) {
		return 1;
	}else{
		with (formInput)
		{
			aPosition = value.indexOf("http://");
			
			//aPosition = value.indexOf("//");
			dotPosition = value.lastIndexOf(".");
			//alert(dotPosition);return(false);
			//lastPosition = value.length-1;

			if(CheckSpecialCharactersForLink(formInput)){
				return 0;
			}else if (aPosition == -1)
			{
				alert(GLOBAL_URL);            
				formInput.select();
				return 0;
			}else if (dotPosition < 4)
			{
				alert(GLOBAL_URL);            
				formInput.select();
				return 0;
			}
			return 1;
		}

	}

}

function isValidLink2(formInput,p_Message){
	var aPosition, dotPosition, lastPosition;

	if(Trim(formInput).value == "" ) {
		alert(p_Message);            
		formInput.focus();
		return 0;
	}else{
		with (formInput)
		{
			aPosition = value.indexOf("http://");
			
			//aPosition = value.indexOf("//");
			dotPosition = value.lastIndexOf(".");
			//alert(dotPosition);return(false);
			//lastPosition = value.length-1;

			if(CheckSpecialCharactersForLink(formInput)){
				return 0;
			}else if (aPosition == -1)
			{
				alert(GLOBAL_URL);            
				formInput.select();
				return 0;
			}else if (dotPosition < 4)
			{
				alert(GLOBAL_URL);            
				formInput.select();
				return 0;
			}
			return 1;
		}

	}

}


function isEmail(formInput){
	var aPosition, dotPosition, lastPosition;
	with (formInput)
	{
		aPosition = value.indexOf("@");
		dotPosition = value.lastIndexOf(".");
		lastPosition = value.length-1;
		
		if(ValidateRegEmail(formInput)){
			return 0;
		}else
		if(CheckSpecialCharactersForEmail(formInput)){
			return 0;
		}else
		if (aPosition < 1 || dotPosition - aPosition < 2 || lastPosition - dotPosition > 6 || lastPosition - dotPosition < 2)
		{
			alert(VALID_EMAIL);            
			formInput.select();
			return 0;
		}
		return 1;
	}
}


function isEmailOpt(formInput){

	if(Trim(formInput).value != ''){

		var aPosition, dotPosition, lastPosition;
		with (formInput)
		{
			aPosition = value.indexOf("@");
			dotPosition = value.lastIndexOf(".");
			lastPosition = value.length-1;
			
			if(ValidateRegEmail(formInput)){
				return 0;
			}else
			if(CheckSpecialCharactersForEmail(formInput)){
				return 0;
			}else
			if (aPosition < 1 || dotPosition - aPosition < 2 || lastPosition - dotPosition > 6 || lastPosition - dotPosition < 2)
			{
				alert(VALID_EMAIL);            
				formInput.select();
				return 0;
			}
			return 1;
		}

	}else{
			return 1;
	}

}

function ValidateRegEmail(formInput) {
   var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
   var address = formInput.value;
   if(reg.test(address) == false) {
		alert(VALID_EMAIL);            
	  formInput.select();
      return 1;
   }
	return 0;
}
	
function isPostCode(formInput) {
   var reg = /^[A-Za-z0-9_\-\.]+$/;
   var address = formInput.value;

	if(Trim(formInput).value == "" ) {
		alert(BLANK_POSTAL_CODE);            
		formInput.focus();
		return 0;
	}

   if(reg.test(address) == false) {
	  alert(VALID_POSTAL_CODE);  
	  formInput.select();
      return 0;
   }
	return 1;
}

function isPostCodeOpt(formInput) {
   var reg = /^[A-Za-z0-9_\-\.]+$/;
   var address = formInput.value;

	if(Trim(formInput).value == "" ) {
		return 1;
	}

   if(reg.test(address) == false) {
	  alert(VALID_POSTAL_CODE);  
	  formInput.select();
      return 0;
   }
	return 1;
}

function isPassword(formInput) {
   var reg = /^[A-Za-z0-9_\-\.]+$/;

   var address = formInput.value;
   if(reg.test(address) == false) {
	  alert(VALID_PASSWORD);  
	  formInput.select();
      return 0;
   }
	return 1;
}

function isUserName(formInput) {
   var reg = /^[A-Za-z0-9_\-\.]+$/;

   var address = formInput.value;
   if(reg.test(address) == false) {
	  alert(USER_NAME_ALPHA);  
	  formInput.select();
      return 0;
   }
	return 1;
}



function isSkypeAddress(formInput) {
	var p_Min=4;
	var p_Max=40;

	if(Trim(formInput).value == "" ) {
		return 1;
	}else{
	   var reg = /^[A-Za-z0-9_\-\.]+$/;

	   var address = formInput.value;
	   if(reg.test(address) == false) {
		  alert('Please Enter only Alphanumeric characters for Skype Address.');  
		  formInput.select();
		  return 0;
	   }else if(formInput.value.length < p_Min || formInput.value.length > p_Max){
			alert("Skype Address should be from "+p_Min+" to "+p_Max+" characters long .");
			formInput.focus();
			return 0;
		}

		return 1;

	}

}



function isValidCC(formInput){
	var aPosition, dotPosition, lastPosition;
	if(formInput.value != ''){
		with (formInput)
		{
			aPosition = value.indexOf("@");
			dotPosition = value.lastIndexOf(".");
			lastPosition = value.length-1;
			if(CheckSpecialCharactersForCC(formInput)){
				return 0;
			}else
			if (aPosition < 1 || dotPosition - aPosition < 2 || lastPosition - dotPosition > 6 || lastPosition - dotPosition < 2)
			{
				alert(VALID_EMAIL);            
				formInput.select();
				return 0;
			}
			return 1;
		}
	}else {
		return 1;
	}
}


function CheckImageSize(divHidden,WidthMin,HeightMin,WidthMax,HeightMax){
	var imgHidden = 'ImageHidden';
	document.getElementById(divHidden).innerHTML = '<img src="'+document.getElementById("Image").value+'" id="'+imgHidden+'">';	 
	
	   if(document.getElementById(imgHidden).width > WidthMax){    
			alert("Please check image size....\n\nImage width should be smaller than "+WidthMax+" pixels."); 
			return 0;
	   } else if(document.getElementById(imgHidden).height > HeightMax){
			alert("Please check image size....\n\nImage height should be smaller than "+HeightMax+" pixels."); 
			return 0;
	   }  if(document.getElementById(imgHidden).width < WidthMin){    
			alert("Please check image size....\n\nImage width should be bigger than "+WidthMin+" pixels."); 
			return 0;
	   } else if(document.getElementById(imgHidden).height < HeightMin){
			alert("Please check image size....\n\nImage height should be bigger than "+HeightMin+" pixels."); 
			return 0;
	   }  else{
			//alert("Image size is ok, you can upload it now.");
			return 1;
	  	}	
		
}

 /*-------------------------------------*/
 /*-------------------------------------*/

 function ValidateMandUpload(p_Field){
	if(p_Field.value !=''){
		var FileExtension = p_Field.value.substr(p_Field.value.length-3,p_Field.value.length);
		switch(FileExtension.toLowerCase()){
			case 'jpg':
				return 1;
			case 'gif':
				return 1;
			default:
				alert(GLOBAL_IMAGE_TYPE);
				p_Field.select();
				return 0;
		}
	}else{
		alert(GLOBAL_IMAGE_UPLOAD);
		p_Field.select();
		return 0;
	}
}


function ValidateOptionalUpload(p_Field){
	if(p_Field.value !=''){
		var FileExtension = p_Field.value.substr(p_Field.value.length-3,p_Field.value.length);
		switch(FileExtension.toLowerCase()){
			case 'jpg':
				return 1;
			case 'gif':
				return 1;
			default:
				alert(GLOBAL_IMAGE_TYPE);
				p_Field.select();
				return 0;
		}
	}else{
		return 1;
	}
}

function isEmail2(formInput){
	var aPosition, dotPosition, lastPosition;
	with (formInput)
	{
		aPosition = value.indexOf("@");
		dotPosition = value.lastIndexOf(".");
		lastPosition = value.length-1;
		if(CheckSpecialCharactersForEmail(formInput)){
			return 0;
		}else
		if (aPosition < 1 || dotPosition - aPosition < 2 || lastPosition - dotPosition > 6 || lastPosition - dotPosition < 2)
		{
			alert(VALID_EMAIL);            
			formInput.select();
			return 0;
		}
		return 1;
	}
}
 /*-------------------------------------*/
 /*-------------------------------------*/
 function CloseWindow(ReloadOption){
	 if(ReloadOption > 0){
		opener.window.location.reload(); 
	 }
	window.close()
}
 /*-------------------------------------*/
 /*-------------------------------------*/

  function ValidateUploadBlog(p_Field){
	if(p_Field.value !=''){
		var ErrorBlog = 0;
		var FileExtension = p_Field.value.substr(p_Field.value.length-3,p_Field.value.length);
		switch(FileExtension.toLowerCase()){
			case 'pdf':
				return 1;
			case 'doc':
				return 1;
			case 'ppt':
				return 1;
			case 'wmv':
				return 1;
			case 'mp4':
				return 1;
			case 'mp3':
				return 1;
			case 'mov':
				return 1;
			case 'm4a':
				return 1;
			case 'jpg':
				return 1;
			case 'gif':
				return 1;
			case 'xls':
				return 1;
		}


		var FileExtension2 = p_Field.value.substr(p_Field.value.length-4,p_Field.value.length);
		switch(FileExtension2.toLowerCase()){
			case 'docx':
				return 1;
			case 'pptx':
				return 1;
			case 'xlsx':
				return 1;
		}

		
		alert(GLOBAL_BLOG_TYPE);
		p_Field.select();
		return 0;



	}else{
		return 1;

	}


}


 function ValidateMandFlash(p_Field,p_Message){
	if(p_Field.value !=''){
		var FileExtension = p_Field.value.substr(p_Field.value.length-3,p_Field.value.length);
		switch(FileExtension.toLowerCase()){
			case 'swf':
				return 1;
			case 'flv':
				return 1;
			default:
				alert(GLOBAL_FLASH_TYPE);
				p_Field.select();
				return 0;
		}
	}else{
		alert(p_Message);
		p_Field.select();
		return 0;
	}
}

 function ValidateMandImage(p_Field,p_Message){
	if(p_Field.value !=''){
		var FileExtension = p_Field.value.substr(p_Field.value.length-3,p_Field.value.length);
		switch(FileExtension.toLowerCase()){
			case 'jpg':
				return 1;
			case 'gif':
				return 1;
			default:
				alert(GLOBAL_IMAGE_TYPE);
				p_Field.select();
				return 0;
		}
	}else{
		alert(p_Message);
		p_Field.select();
		return 0;
	}
}


function ValidateMandImageUrl(p_Field,p_Message){
	if(p_Field.value !=''){
		
		if(isLink(p_Field) == 0){
			return 0;
		}
		var FileExtension = p_Field.value.substr(p_Field.value.length-3,p_Field.value.length);
		switch(FileExtension.toLowerCase()){
			case 'jpg':
				return 1;
			case 'gif':
				return 1;
			default:
				alert(GLOBAL_IMAGE_TYPE);
				p_Field.select();
				return 0;
		}
	}else{
		alert(p_Message);
		p_Field.focus();
		return 0;
	}
}


function ValidateMandZipFile(p_Field,p_Message){
	if(p_Field.value !=''){
		var FileExtension = p_Field.value.substr(p_Field.value.length-3,p_Field.value.length);
		switch(FileExtension.toLowerCase()){
			case 'zip':
				return 1;
			case 'ZIP':
				return 1;
			default:
				alert(GLOBAL_ZIP_TYPE);
				p_Field.value='';
				return 0;
		}
	}else{
		alert(p_Message);
		p_Field.select();
		return 0;
	}
}


 

 function ValidateMandUploadForAny(p_Field,p_Message){
	if(p_Field.value !=''){
		var FileExtension = p_Field.value.substr(p_Field.value.length-3,p_Field.value.length);
		return 1;
	}else{
		alert(p_Message);
		p_Field.select();
		return 0;
	}
}


function alertUpload()
{
	 alert(GLOBAL_PATH_BROWSE);
	 return(false);

}

function confDel(p_Message){
	if(confirm(p_Message)){
		return true;
	}else{
		return false;
	}
	return false;
}

function confirmDelete(p_Message){
	if(confirm(p_Message)){
		return true;
	}else{
		return false;
	}
	return false;
}

function ConfirmDelRedirect(p_Message,p_Url){
	if(confirm(p_Message)){
		location.href = p_Url;
		return true;
	}else{
		return false;
	}
	return false;
}

 /*-------------------------------------*/
 /*-------------------------------------*/



function ValidateForLink(p_field,p_Message){
	if(Trim(p_field).value == "" ) {
		alert(p_Message);
		p_field.focus();
		return 0;
	}else{
		return 1;
	}
}

function ValidateForSimpleBlank(p_field,p_Message){
	if(Trim(p_field).value == "" ) {
		alert(p_Message);
		p_field.focus();
		return 0;
	}else{
		return 1;
	}
}




function ValidateForBlank(p_field,p_Message,p_Char_Message){
	if(Trim(p_field).value == "" ) {
		alert(p_Message);
		p_field.focus();
		return 0;
	}else if(p_field == 'keyword'){
		if(CheckSpecialCharactersForSearch(p_field,p_Char_Message)){
			return 0;
		}else{
			return 1;
		}
	}else if(CheckSpecialCharacters(p_field,p_Char_Message)){
		return 0;
	}else{
		return 1;
	}
}


function ValidateForBlankOpt(p_field,p_Message,p_Char_Message){
	if(Trim(p_field).value == "" ) {
		return 1;
	}else if(p_field == 'keyword'){
		if(CheckSpecialCharactersForSearch(p_field,p_Char_Message)){
			return 0;
		}else{
			return 1;
		}
	}else if(CheckSpecialCharacters(p_field,p_Char_Message)){
		return 0;
	}else{
		return 1;
	}
}


function ValidateForLanguages(p_field,p_FieldName,p_Min,p_Max){
	if(document.getElementById("NumLanguages").value > 1)
		for(var i=2;i<=document.getElementById("NumLanguages").value;i++){
			if(Trim(document.getElementById(p_field+i)).value != "" ) {
				if(!ValidateForBlank(document.getElementById(p_field+i), p_FieldName+LanguageName[i])){
					return 0;
				}
				if(!ValidateMandRange(document.getElementById(p_field+i), p_FieldName+LanguageName[i],p_Min,p_Max)){
					return 0;
				}
				
		}
	}

	return 1;

}


function ValidateForLanguagesTextarea(p_field,p_FieldName,p_Min,p_Max){
	if(document.getElementById("NumLanguages").value > 1)
		for(var i=2;i<=document.getElementById("NumLanguages").value;i++){
			if(Trim(document.getElementById(p_field+i)).value != "" ) {
				if(!ValidateForTextareaOpt(document.getElementById(p_field+i), p_FieldName+LanguageName[i],p_Min,p_Max)){
					return 0;
				}
				
		}
	}

	return 1;

}


function ValidateForDate(p_field,p_Message){
	if(Trim(p_field).value == "" ) {
		alert(p_Message);
		p_field.focus();
		return 0;
	}else{
		return 1;
	}
}


function isValidPhoneNumber(p_field, p_FieldName){
	var num;
	if(!p_field.value){
		p_field.value = "";
	}else {	
		 for(var i=0; i < p_field.value.length; i++){
			 num = p_field.value.substring(i,i+1);
			 if(parseInt(num) || num=='-' || num==' ' || num=='+' || num=='0' || num==','){
				flag  = true;
			 }else{
				alert("Please Enter Valid "+p_FieldName+".");
				p_field.focus();
				return 0;
				break;
			 }
		 }

	}
	return 1;
}


function ValidateIDNumber(p_field, p_FieldName){
	var num;
	Trim(p_field);
	if(!p_field.value){
			alert("Please Enter "+p_FieldName+".");
			p_field.focus();
			return 0;
	}else if(p_field.value.length < 5 || p_field.value.length >20){
				alert(p_FieldName+" should be 5 to 20 digits long.");
				p_field.focus();
				return 0;
	}else {	
		 for(var i=0; i < p_field.value.length; i++){
			 num = p_field.value.substring(i,i+1);
			 if(parseInt(num) || num=='-' || num=='+' || num=='0'){
				flag  = true;
			 }else{
				alert("Please Enter a Valid "+p_FieldName+".");
				p_field.focus();
				return 0;
				break;
			 }
		 }

	}
	return 1;
}

function ValidateForTextareaMand(p_field,p_FieldName,p_Min,p_Max){
	if(Trim(p_field).value != "" ) {
		if(p_field.value.length < p_Min || p_field.value.length > p_Max){
			alert(p_FieldName+" should be from "+p_Min+" to "+p_Max+" characters long.");
			p_field.focus();
			return 0;
		}else if(CheckSpecialCharactersForTextarea(p_field,p_FieldName)){
			return 0;
		}else{
			return 1;
		}
	}else{
		alert("Please Enter "+p_FieldName+".");            
		p_field.focus();
		return 0;
	}

}
function ValidateForDateOfBirth(month_field,month_field_msg,day_field,day_field_msg,year_field,year_field_msg){
	if( ValidateForSelect(month_field, month_field_msg)
		&& ValidateForSelect(day_field, day_field_msg)
		&& ValidateForSelect(year_field, year_field_msg)){

		if(month_field.value == '02' && day_field.value > 29){
			alert(GLOBAL_DAY_DOB);
			day_field.focus();
			return 0;
		}


		if(month_field.value != '02'){
				
			var rem = (month_field.value)%2;
		
			if(month_field.value < 8 ){
				if(rem == 0 && day_field.value > 30){
					alert(GLOBAL_DAY_DOB);
					day_field.focus();
					return 0;
				}
			}else{
				if(rem == 1 && day_field.value > 30){
					alert(GLOBAL_DAY_DOB);
					day_field.focus();
					return 0;
				}
			}

		}

		return 1;
	}else{
		return 0;
	}

}

function ValidateForSearchFeild(p_field,p_Message,p_Char_Message){
	if(Trim(p_field).value == "" ) {
		alert(p_Message);            
		p_field.focus();
		return 0;
	}else if(CheckSpecialCharactersForSearch(p_field,p_Char_Message)){
		return 0;
	}else{
		return 1;
	}
}

function ValidateForTextarea(p_field,p_Message,p_Char_Message){
	if(Trim(p_field).value == "" ) {
		alert(p_Message);            
		p_field.focus();
		return 0;
	}else if(CheckSpecialCharactersForTextarea(p_field,p_Char_Message)){
		return 0;
	}else{
		return 1;
	}
}

function ValidateForTextareaFlash(p_field,p_Message,p_Char_Message){
	if(Trim(p_field).value == "" ) {
		alert(p_Message);            
		p_field.focus();
		return 0;
	}else if(CheckSpecialCharactersForFlashCode(p_field,p_Char_Message)){
		return 0;
	}else{
		return 1;
	}
}


function ValidateForTextareaOpt(p_field,p_Min,p_Max,p_Message,p_Char_Message){
	if(Trim(p_field).value != "" ) {
		if(p_field.value.length < p_Min || p_field.value.length > p_Max){
			alert(p_Message);            
			p_field.focus();
			return 0;
		}else if(CheckSpecialCharactersForTextarea(p_field,p_Char_Message)){
			return 0;
		}else{
			return 1;
		}
	}else{
		return 1;
	}

}


function ValidateForEmail(p_field){
	if(Trim(p_field).value == "" ) {
		alert(BLANK_EMAIL);            
		p_field.focus();
		return 0;
	}else{
		return 1;
	}
}


function ValidateForEditor(p_field,p_Message){
	if(Trim(p_field).value == "" ) {
		alert(p_Message);            
		//p_field.focus();
		return 0;
	}else{
		return 1;
	}
}


function ValidateForPassword(p_field){
	if(Trim(p_field).value == "" ) {
		alert(BLANK_PASSWORD);            
		p_field.focus();
		return 0;
	}else if(CheckSpecialCharactersPassword(p_field)){
		return 0;
	}else{
		return 1;
	}

}

function ValidateMandRange(p_field,p_Min,p_Max,p_Message,p_RangeMassgae){
	if(Trim(p_field).value == "" ) {
		alert(p_Message);            
		p_field.focus();
		return 0;
	}else if(p_field.value.length < p_Min || p_field.value.length > p_Max){
				alert(p_RangeMassgae);
				p_field.focus();
				return 0;
	}else{
		return 1;
	}
}

function CheckSpecialCharacters(p_field,p_Char_Message){
	 var Character, blankCount=0;
	 for(var i=0; i < p_field.value.length; i++){
		 Character = p_field.value.substring(i,i+1);
		 if(Character=='#' || Character=='^' || Character=='~' || Character=='%' || Character=='"'  || Character=='$' || Character=='(' || Character==')' || Character=='*' || Character=='`' || Character=='&' || Character=='|' || Character=='/'  || Character=='!' || Character=='+' || Character=='@'  || Character=='<'  || Character=='>'  || Character=='{' || Character=='}'  || Character=='['  || Character==']'){
			alert(p_Char_Message);
			p_field.select();
			return 1;	
			break;
		 }
		 if(Character==' '){
			blankCount++;
		 }else{
			 blankCount = 0;
		 }

		 if(blankCount >= 2){
			alert(SPACE_TWO);
			p_field.select();
			return 1;	
			break;
		 }
	 }
	  return 0;
}

function CheckSpecialCharactersForSearch(p_field,p_Char_Message){
	 var Character;
	 for(var i=0; i < p_field.value.length; i++){
		 Character = p_field.value.substring(i,i+1);
		 if(Character=='#' || Character=='^' || Character=='~' || Character=='%' || Character=='"' || Character=='$' || Character=='(' || Character==')' || Character=='*' || Character=='`' || Character=='|' || Character=='!' || Character=='+' || Character=='_'  || Character=='<' || Character=='>' || Character=='{' || Character=='}'  || Character=='['  || Character==']' || Character=='_'){
			alert(p_Char_Message);
			p_field.select();
			return 1;	
			break;
		 }
		
	 }
	  return 0;
}




function CheckSpecialCharactersForFlashCode(p_field,p_Char_Message){
	 var Character;
	 for(var i=0; i < p_field.value.length; i++){
		 Character = p_field.value.substring(i,i+1);
		 if(Character=='^' || Character=='~' || Character=='`'){
			alert(p_Char_Message);
			p_field.focus();
			return 1;	
			break;
		 }
	 }
	  return 0;
}

function CheckSpecialCharactersForTextarea(p_field,p_Char_Message){
	 var Character;
	 for(var i=0; i < p_field.value.length; i++){
		 Character = p_field.value.substring(i,i+1);
		 if(Character=='#' || Character=='^' || Character=='~' || Character=='`' ){
			alert(p_Char_Message);
			p_field.focus();
			return 1;	
			break;
		 }
	 }
	  return 0;
}


function SearchProduct(frm){
	if(CheckSpecialCharacters(frm.keyword,'Search Feild')){
			return false;
	}else{
		location.href = 'searchResult.php?catid='+frm.CategorySearch.value+'&key='+frm.keyword.value;
		return false;
	}
}


function CheckSpecialCharactersPassword(p_field){
	 var Character;
	 for(var i=0; i < p_field.value.length; i++){
		 Character = p_field.value.substring(i,i+1);
		 if(Character=='#' || Character=='~' || Character=='`' || Character=='"' || Character=='<' || Character=='>'){
			alert(SPECIAL_CHAR_PASSWORD);
			p_field.focus();
			return 1;	
			break;
		 }

		 if(Character=="'"){
			alert(SPECIAL_CHAR_PASSWORD);
			p_field.focus();
			return 1;	
			break;
		 }

		 if(Character==' '){
			alert(SPACE);
			p_field.focus();
			return 1;	
			break;
		 }
	 }
	  return 0;
}



function CheckSpecialCharactersForEmail(p_field){
	 var Character;
	 var countAmp = 0; 
	 for(var i=0; i < p_field.value.length; i++){
		 Character = p_field.value.substring(i,i+1);
		 if(Character=='#' || Character=='^' || Character=='~' || Character=='%' || Character=='$' || Character=='(' || Character==')' || Character=='*' || Character=='`' || Character=='|' || Character=='/' || Character=='!' || Character=='+' || Character==':' || Character==';' || Character==',' || Character=='<'  || Character=='>' || Character=='?'  || Character=='&'  || Character=='{' || Character=='}' || Character=='[' || Character==']' || Character=='=' || Character=='"'){
			alert(SPECIAL_CHAR_EMAIL);
			p_field.focus();
			return 1;	
			break;
		 }

		 if(Character=="'"){
			alert(SPECIAL_CHAR_EMAIL);
			p_field.focus();
			return 1;	
			break;
		 }

		 if(Character==' '){
			alert(SPACE_EMAIL);
			p_field.focus();
			return 1;	
			break;
		 }
		 if(Character=='@'){
			 countAmp++;
		 }
	 }

	 if(countAmp==2){
		alert(GLOBAL_BLANK_EMAIL);
		p_field.focus();
		return 1;	
	 }

	  return 0;
}


function CheckSpecialCharactersForCC(p_field){
	 var Character;
	 var countAmp = 0; 
	 for(var i=0; i < p_field.value.length; i++){
		 Character = p_field.value.substring(i,i+1);
		 if(Character=='#' || Character=='^' || Character=='~' || Character=='%' || Character=='$' || Character=='(' || Character==')' || Character=='*' || Character=='`' || Character=='|' || Character=='/' || Character=='!' || Character=='+' || Character==':' || Character==';' || Character=='<'  || Character=='>' || Character=='?'  || Character=='&'  || Character=='{' || Character=='}' || Character=='[' || Character==']' || Character=='=' || Character=='"'){
			alert(SPECIAL_CHAR_EMAIL);
			p_field.focus();
			return 1;	
			break;
		 }

		 if(Character=="'"){
			alert(SPECIAL_CHAR_EMAIL);
			p_field.focus();
			return 1;	
			break;
		 }

		/*
		 if(Character==' '){
			alert("Please do not enter 'space' between characters for Email.");
			p_field.focus();
			return 1;	
			break;
		 }
		 if(Character=='@'){
			 countAmp++;
		 }*/
	 }

	/*
	 if(countAmp==2){
		alert("Please do not enter '@' more than once for Email.");
		p_field.focus();
		return 1;	
	 }*/

	  return 0;
}


///////////////////////


function CheckSpecialCharactersForLink(p_field){
	 var Character;

	 for(var i=0; i < p_field.value.length; i++){
		 Character = p_field.value.substring(i,i+1);
		 if(Character=='#' || Character=='^' || Character=='~' || Character=='%' || Character=='(' || Character==')' || Character=='*' || Character=='`' || Character=='|' || Character=='!' || Character=='+' || Character==';' || Character==',' || Character=='<'  || Character=='>' || Character=='?' || Character=='{' || Character=='}' || Character=='[' || Character==']' || Character=='='){
			alert(SPECIAL_CHAR_URL);
			p_field.focus();
			return 1;	
			break;
		 }

		 if(Character=="'"){
			alert(SPECIAL_CHAR_URL);
			p_field.focus();
			return 1;	
			break;
		 }

		 if(Character==' '){
			alert(SPACE_URL);
			p_field.focus();
			return 1;	
			break;
		 }
	 }

	  return 0;
}

//////////////////////////////
function ValidateForPasswordConfirm(p_Password,p_ConfirmPassword){
	if(Trim(p_ConfirmPassword).value == "" ) {
		alert(CONFIRM_PASSWORD);            
		p_ConfirmPassword.focus();
		return 0;
	}else if(p_ConfirmPassword.value != p_Password.value ) {
		alert(CONFIRM_PASSWORD_NOT_MATCH);            
		p_ConfirmPassword.select();
		return 0;
	}else{
		return 1;
	}
}

function ValidateForVerification(p_verifyText,p_verifyHidden){
	if(Trim(p_verifyText).value == "" ) {
		alert(BLANK_VERIFY);            
		p_verifyText.focus();
		return 0;
	}else if(p_verifyText.value != p_verifyHidden.value ) {
		alert(VERIFY_NOT_MATCH);            
		p_verifyText.select();
		return 0;
	}else{
		return 1;
	}
}
function ValidateCheckBox(p_Field,p_Message){
	if(p_Field.checked == false ) {
		alert(p_Message);    
		p_Field.focus();
		return 0;
	}else{
		return 1;
	}
}


function ValidateForOldPassword(p_OldPassword,p_OldPasswordHidden){
	if(Trim(p_OldPassword).value == "" ) {
		alert(BLANK_OLD_PASSWORD);            
		p_OldPassword.focus();
		return 0;
	}else if(p_OldPassword.value != p_OldPasswordHidden.value ) {
		alert(OLD_PASSWORD_NOT_MATCH);            
		p_OldPassword.select();
		return 0;
	}else{
		return 1;
	}
}

function ValidateForOldPasswordEnc(p_OldPassword,p_OldPasswordHidden){
	if(Trim(p_OldPassword).value == "" ) {
		alert(BLANK_OLD_PASSWORD);            
		p_OldPassword.focus();
		return 0;
	}else if(hex_md5(p_OldPassword.value) != p_OldPasswordHidden.value ) {
		alert(OLD_PASSWORD_NOT_MATCH);            
		p_OldPassword.select();
		return 0;
	}else{
		return 1;
	}
}

function ValidateForSelect(p_field,p_Message){
	if(p_field.value == "" ) {
		alert(p_Message);            
		p_field.focus();
		return 0;
	}else{
		return 1;
	}
}

function search_records(){
	document.getElementById("MsgDiv").innerHTML = "";
	if(  ValidateForSearchFeild(document.frm1.search_key, "Keyword to Search")
		
	){
		SortSearchListing('','');
		return false;	
	}else{
		return false;	
	}
}

function search_keyword(){
	document.getElementById("MsgDiv").innerHTML = "";
	if(  ValidateForBlank(document.frm1.search_key, "Keyword to Search")
	){
		SortSearchListing('','');
		return false;	
	}else{
		return false;	
	}
}

function ValidateProductNumber(formInput, p_FieldName) {
   var reg = /^[A-Za-z0-9_\-\.]+$/;

   var address = formInput.value;

	if(Trim(formInput).value == "" ) {
      return 1;
	}else{

	   if(reg.test(address) == false) {
		  alert("Please Enter Valid "+p_FieldName+".");  
		  formInput.select();
		  return 0;
	   }

	}


	return 1;
}

function ValidateMandNumField2(p_field,p_min,p_max,p_Message,p_Valid,p_Num_Message){
	Trim(p_field);
	if (!p_field.value){
		alert(p_Message);
		p_field.focus();
		return 0;
	}
	else
		if(isNaN(parseInt(p_field.value))){
			alert(p_Valid);
			p_field.focus();
			return 0;
		}
		else
			if(parseInt(p_field.value)<parseInt(p_min)){
				alert(p_Num_Message);
				p_field.focus();
				return 0;
			}
			else
				if (parseInt(p_field.value)>parseInt(p_max)){
					alert(p_Num_Message);
					p_field.focus();
					return 0;
				}
	if(p_field.value.length!=parseInt(p_field.value).toString().length){
		alert(p_Valid);
		p_field.focus();
		return 0;
	}
	return p_field;
}


function ValidateOptNumField2(p_field,p_min,p_max,p_Message,p_Valid,p_Num_Message){
	Trim(p_field);
	if (!p_field.value || p_field.value == 0){
		return 1;
	}
	else
		if(isNaN(parseInt(p_field.value))){
			alert(p_Valid);
			p_field.focus();
			return 0;
		}
		else
			if(parseInt(p_field.value)<parseInt(p_min)){
				alert(p_Num_Message);
				p_field.focus();
				return 0;
			}
			else
				if (parseInt(p_field.value)>parseInt(p_max)){
					alert(p_Num_Message);
					p_field.focus();
					return 0;
				}
	if(p_field.value.length!=parseInt(p_field.value).toString().length){
		alert(p_Valid);
		p_field.focus();
		return 0;
	}
	return p_field;
}


function ValidateOptNumField(p_field, p_FieldName){
	if(!p_field.value)
		p_field.value = "";
	else if(isNaN(parseInt(p_field.value))||p_field.value.length!=parseInt(p_field.value).toString().length){
		alert( p_FieldName + " must be a number.");
		p_field.focus();
		return 0;
	}
	return 1;
}

function ValidateOptPhoneNumber(p_field){
	var num;
	Trim(p_field);
	if(!p_field.value){
		p_field.value = "";
	}else if(p_field.value.length < 8 || p_field.value.length >20){
				alert(NUM_PHONE);
				p_field.focus();
				return 0;
	}else {	
		 for(var i=0; i < p_field.value.length; i++){
			 num = p_field.value.substring(i,i+1);
			 if(parseInt(num) || num=='-' || num=='+' || num=='0'){
				flag  = true;
			 }else{
				alert(VALID_PHONE);
				p_field.focus();
				return 0;
				break;
			 }
		 }

	}
	return 1;
}


function ValidateOptContactNumber(p_field){
	var num;
	Trim(p_field);
	if(!p_field.value){
		p_field.value = "";
	}else if(p_field.value.length < 8 || p_field.value.length >20){
				alert(NUM_CONTACT_NUMBER);
				p_field.focus();
				return 0;
	}else {	
		 for(var i=0; i < p_field.value.length; i++){
			 num = p_field.value.substring(i,i+1);
			 if(parseInt(num) || num=='-' || num=='+' || num=='0'){
				flag  = true;
			 }else{
				alert(VALID_CONTACT_NUMBER);
				p_field.focus();
				return 0;
				break;
			 }
		 }

	}
	return 1;
}


function ValidateMandMobileNumber(p_field){
	var num;
	Trim(p_field);
	if(!p_field.value){
			alert(BLANK_MOBILE_NUMBER);
			p_field.focus();
			return 0;
	}else if(p_field.value.length < 8 || p_field.value.length >20){
				alert(NUM_MOBILE_NUMBER);
				p_field.focus();
				return 0;
	}else {	
		 for(var i=0; i < p_field.value.length; i++){
			 num = p_field.value.substring(i,i+1);
			 if(parseInt(num) || num=='-' || num=='+' || num=='0' || num==' '){
				flag  = true;
			 }else{
				alert(VALID_MOBILE_NUMBER);
				p_field.focus();
				return 0;
				break;
			 }
		 }

	}
	return 1;
}



function ValidateMandContactNumber(p_field){
	var num;
	Trim(p_field);
	if(!p_field.value){
			alert(BLANK_CONTACT_NUMBER);
			p_field.focus();
			return 0;
	}else if(p_field.value.length < 8 || p_field.value.length >20){
				alert(NUM_CONTACT_NUMBER);
				p_field.focus();
				return 0;
	}else {	
		 for(var i=0; i < p_field.value.length; i++){
			 num = p_field.value.substring(i,i+1);
			 if(parseInt(num) || num=='-' || num=='+' || num=='0' || num==' '){
				flag  = true;
			 }else{
				alert(VALID_CONTACT_NUMBER);
				p_field.focus();
				return 0;
				break;
			 }
		 }

	}
	return 1;
}







function ValidateOptFaxNumber(p_field){
	var num;
	Trim(p_field);
	if(!p_field.value){
		p_field.value = "";
	}else if(p_field.value.length < 10 || p_field.value.length >20){
				alert(NUM_FAX);
				p_field.focus();
				return 0;
	}else {	
		 for(var i=0; i < p_field.value.length; i++){
			 num = p_field.value.substring(i,i+1);
			 if(parseInt(num) || num=='-' || num=='+' || num=='0'){
				flag  = true;
			 }else{
				alert(VALID_FAX);
				p_field.focus();
				return 0;
				break;
			 }
		 }

	}
	return 1;
}

function ValidateExistance(p_Field, p_Url){
	var objDoc;
	var httpObj = new ActiveXObject("Microsoft.XMLHTTP");
	httpObj.Open("POST",p_Url, false);
	httpObj.send();

	 if(httpObj.responseText==1) {	 
		alert(p_Field.name +" already exists in database.Please enter another.");
		p_Field.select();  					
		return false;
	} else if(httpObj.responseText==0) {	 
		 return true;
	}else {
		alert("Error occur : " + httpObj.responseText);
		return false;
	}
}

function ValidateMandNumField(p_field, p_Message,p_Valid){
	if (!p_field.value  || p_field.value<1){
		alert(p_Message);
		p_field.focus();
		return 0;
	//}else if(isNaN(parseInt(p_field.value))||p_field.value.length!=parseInt(p_field.value).toString().length){
	}else if(isNaN(parseInt(p_field.value))){
		alert(p_Valid);
		p_field.focus();
		return 0;
	}
	return 1;
}


function ValidateMandDecimalField(p_field, p_Message,p_Valid){
	var dotcount=0;
		Trim(p_field);

	if (p_field.value == ''){
		alert(p_Message);
		p_field.focus();
		return 0;
	}else if(p_field.value == '.'){
		alert(p_Valid);
		p_field.focus();
		return 0;
	}else {
		 for(var i=0; i < p_field.value.length; i++){
			 num = p_field.value.substring(i,i+1);
			 if(dotcount == 1 && num=='.'){
				alert(p_Valid);
				p_field.focus();
				return 0;
				break;
			 } else if(parseInt(num) || num=='.' || num=='0'){
				 if(num=='.')
				 { dotcount++;} 
			 }else{
				alert(p_Valid);
				p_field.focus();
				return 0;
				break;
			 }
		 }
	}
	return 1;
}


function ValidateOptDecimalField(p_field, p_Message,p_Valid){
	var dotcount=0;
		Trim(p_field);

	if (p_field.value < 0.1){
		return 1;
	}else if(p_field.value == '.'){
		alert(p_Valid);
		p_field.focus();
		return 0;
	}else {
		/*
		if(parseFloat(p_field.value)>100){
			alert(p_Message);
			p_field.focus();
			return 0;
		}
		*/

		 for(var i=0; i < p_field.value.length; i++){
			 num = p_field.value.substring(i,i+1);
			 if(dotcount == 1 && num=='.'){
				alert(p_Valid);
				p_field.focus();
				return 0;
				break;
			 } else if(parseInt(num) || num=='.' || num=='0'){
				 if(num=='.')
				 { dotcount++;} 
			 }else{
				alert(p_Valid);
				p_field.focus();
				return 0;
				break;
			 }
		 }
	}
	return 1;
}

function ValidateRadioButtons(p_field, p_Message){
	var len = p_field.length;
	var CheckedFlag = 0;
	if(len > 0){
		for(var i=0; i < len; i++){
			if(p_field[i].checked == true){
				CheckedFlag = 1;
				break;
			}
		}
	}else{
		if(p_field.checked == true){
			CheckedFlag = 1;
		}
	}

	if(CheckedFlag == 0){
		alert(p_Message);
		return 0;
	}
	return 1;
}


function LoginPrompt(){
	alert("Please Log In First.");
	document.getElementById("ContinueUrl").value='checkout.php';
	document.getElementById("LoginEmail").focus();
}
//---------Functions for getting mouseLeft postion----------//
function getPositionX()
	{
		return event.screenX;
	}

//---------Functions for getting mouseTop postion----------//
function getPositionY(e)
{

		var IE = document.all?true:false
		var tempX = 0
		var tempY = 0
		var e = new Object();

		if (IE) { // grab the x-y pos.s if browser is IE
		tempX = event.clientX + document.body.scrollLeft
		tempY = event.clientY + document.body.scrollTop
			var y_postion=tempY;

		return(y_postion);
		} else { // grab the x-y pos.s if browser is NS
		tempX = e.pageX
		tempY = e.pageY
		}
		// catch possible negative values in NS4
		if (tempX < 0){tempX = 0}
		if (tempY < 0){tempY = 0}

		var y_postion=tempY ;
		return(y_postion);

}
function FindXPosition(obj)
  {
    var curleft = 0;
    if(obj.offsetParent)
        while(1) {
          curleft += obj.offsetLeft;
          if(!obj.offsetParent)
            break;
          obj = obj.offsetParent;
        }
    else if(obj.x)
        curleft += obj.x;
    return curleft;
  }
function FindYPosition(obj) {
    var curtop = 0;
    if(obj.offsetParent)
        while(1) {
          curtop += obj.offsetTop;
          if(!obj.offsetParent)
            break;
          obj = obj.offsetParent;
        }
    else if(obj.y){
        curtop += obj.y;
	}
    return curtop;
  }

///////////////////********////////////////

function ShowAfterLoading(EditorDiv){
	document.getElementById("LoadingDiv").style.display = 'none';
	document.getElementById(EditorDiv).style.display = 'inline';
}


function SelectDeselect(num,elementID,opt){
	if(opt == 1){
		var sel= true;
	}else{
		var sel= false;
	}

	for(var i=1;i<=num;i++){
		document.getElementById("DeleteItem"+i).checked = sel;
	}

}
