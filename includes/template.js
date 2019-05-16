

function UploadImage(PageName, Width, Height, ResizableOption ){ 
	window.open(PageName,"win1","toolbar=no,directories=no,resize="+ResizableOption+",menubar=no,location=no,scrollbars=yes,width="+Width+",height="+Height+",maximize=null,top=70,left=80");

 }

function ShowHideDiv(div_id){ 
	if(document.getElementById(div_id).style.visibility!='hidden'){
		document.getElementById(div_id).style.visibility='hidden';
	}else{
		document.getElementById(div_id).style.visibility='visible';

	}
}


function SetHeaderTextAlign(val){ 
	document.getElementById("HeaderTextAlign").value = val;
	if(val=='left'){
		document.getElementById("HeaderImgLeft").className = 'ImgTemplateSel';
		document.getElementById("HeaderImgCenter").className = 'ImgTemplateNone';
		document.getElementById("HeaderImgRight").className = 'ImgTemplateNone';

	}
	if(val=='center'){
		document.getElementById("HeaderImgCenter").className = 'ImgTemplateSel';
		document.getElementById("HeaderImgLeft").className = 'ImgTemplateNone';
		document.getElementById("HeaderImgRight").className = 'ImgTemplateNone';
	}
	if(val=='right'){
		document.getElementById("HeaderImgRight").className = 'ImgTemplateSel';
		document.getElementById("HeaderImgLeft").className = 'ImgTemplateNone';
		document.getElementById("HeaderImgCenter").className = 'ImgTemplateNone';
	}
 }



function SetLogoAlign(val){ 
	document.getElementById("LogoAlign").value = val;
	if(val=='left'){
		document.getElementById("LogoImgLeft").className = 'ImgTemplateSel';
		document.getElementById("LogoImgCenter").className = 'ImgTemplateNone';
		document.getElementById("LogoImgRight").className = 'ImgTemplateNone';

	}
	if(val=='center'){
		document.getElementById("LogoImgCenter").className = 'ImgTemplateSel';
		document.getElementById("LogoImgLeft").className = 'ImgTemplateNone';
		document.getElementById("LogoImgRight").className = 'ImgTemplateNone';
	}
	if(val=='right'){
		document.getElementById("LogoImgRight").className = 'ImgTemplateSel';
		document.getElementById("LogoImgLeft").className = 'ImgTemplateNone';
		document.getElementById("LogoImgCenter").className = 'ImgTemplateNone';
	}
 }


function SetBannerTextAlign(val){ 
	document.getElementById("BannerTextAlign").value = val;
	if(val=='left'){
		document.getElementById("BannerImgLeft").className = 'ImgTemplateSel';
		document.getElementById("BannerImgCenter").className = 'ImgTemplateNone';
		document.getElementById("BannerImgRight").className = 'ImgTemplateNone';

	}
	if(val=='center'){
		document.getElementById("BannerImgCenter").className = 'ImgTemplateSel';
		document.getElementById("BannerImgLeft").className = 'ImgTemplateNone';
		document.getElementById("BannerImgRight").className = 'ImgTemplateNone';
	}
	if(val=='right'){
		document.getElementById("BannerImgRight").className = 'ImgTemplateSel';
		document.getElementById("BannerImgLeft").className = 'ImgTemplateNone';
		document.getElementById("BannerImgCenter").className = 'ImgTemplateNone';
	}
 }

function WatchPreview(){ 	

	var ErrorFound = 0;
	var mmspobj=document.getElementById("StoreIframe");

	if(document.getElementById("WebsiteStoreOption").value=='w'){
		var StoreUrl = 'home.php?Store='+document.getElementById("UserName").value+'&action=edit&preview=1';
	}else{
		var StoreUrl = 'store.php?Store='+document.getElementById("UserName").value+'&action=edit&preview=1';
	}

	

	/*
	if(document.getElementById("BodyWidth").value != ''){

		if(!ValidateMandNumField2(document.getElementById("BodyWidth"),700,1000, BLANK_BODY_WIDTH,VALID_BODY_WIDTH,NUM_BODY_WIDTH)){
			ErrorFound = 1;

		}

		StoreUrl += '&BodyWidth='+document.getElementById("BodyWidth").value;
	}*/


	if(document.getElementById("BodyBgOption1").checked == true){
		if(document.getElementById("BodyBgColor").value != ''){
			var BodyBgColor = document.getElementById("BodyBgColor").value.replace("#","");
			StoreUrl += '&BodyBgColor='+BodyBgColor+'&BodyBgOption=color';
		}
	}else if(document.getElementById("BodyBgOption2").checked == true){

		if(document.getElementById("BodyBgImage").value != ''){
			StoreUrl += '&BodyBgImage='+document.getElementById("BodyBgImage").value+'&BodyBgOption=image';
		}
		if(document.getElementById("BodyImageRepeate").checked){
			StoreUrl += '&BodyImageRepeate=1';
		}
	}


	if(document.getElementById("HeaderBgOption1").checked == true){
		if(document.getElementById("HeaderBgColor").value != ''){
			var HeaderBgColor = document.getElementById("HeaderBgColor").value.replace("#","");
			StoreUrl += '&HeaderBgColor='+HeaderBgColor+'&HeaderBgOption=color';
		}
	}else if(document.getElementById("HeaderBgOption2").checked == true){

		if(document.getElementById("HeaderBgImage").value != ''){
			StoreUrl += '&HeaderBgImage='+document.getElementById("HeaderBgImage").value+'&HeaderBgOption=image';
		}

		if(document.getElementById("HeaderBgRepeate").checked){
			StoreUrl += '&HeaderBgRepeate=1';
		}

	}


	StoreUrl += '&TemplatePanel='+document.getElementById("TemplatePanel").value;


	/*********  Header Title Section *********/
		
	if(document.getElementById("HeaderTitleOption").checked){

			StoreUrl += '&HeaderTitleOption=1';

			if(document.getElementById("HeaderTitle").value != ''){
				StoreUrl += '&HeaderTitle='+escape(document.getElementById("HeaderTitle").value);

				if(document.getElementById("HeaderFontType").value != ''){
					StoreUrl += '&HeaderFontType='+document.getElementById("HeaderFontType").value;
				}

				if(document.getElementById("HeaderFontType").value != ''){
					StoreUrl += '&HeaderFontType='+document.getElementById("HeaderFontType").value;
				}

				if(document.getElementById("HeaderFontColor").value != ''){
					var HeaderFontColor = document.getElementById("HeaderFontColor").value.replace("#","");
					StoreUrl += '&HeaderFontColor='+HeaderFontColor;
				}

				if(document.getElementById("HeaderFontSize").value != ''){
					StoreUrl += '&HeaderFontSize='+document.getElementById("HeaderFontSize").value;
				}
				
				if(document.getElementById("HeaderTextAlign").value != ''){
					StoreUrl += '&HeaderTextAlign='+document.getElementById("HeaderTextAlign").value;
				}

			}


	}


	/*********  Header Logo Section *********/


	if(document.getElementById("HeaderLogoOption").checked){

			StoreUrl += '&HeaderLogoOption=1';

			if(document.getElementById("HeaderLogo").value != ''){
				StoreUrl += '&HeaderLogo='+document.getElementById("HeaderLogo").value;

				if(document.getElementById("LogoAlign").value != ''){
					StoreUrl += '&LogoAlign='+document.getElementById("LogoAlign").value;
				}


				if(document.getElementById("LogoWidth").value != ''){
					StoreUrl += '&LogoWidth='+document.getElementById("LogoWidth").value;
				}
				if(document.getElementById("LogoHeight").value != ''){
					StoreUrl += '&LogoHeight='+document.getElementById("LogoHeight").value;
				}

				if(!ValidateMandNumField3(document.getElementById("LogoWidth"),"Logo width",30,900)){
					ErrorFound = 1;
				}

				if(!ValidateMandNumField3(document.getElementById("LogoHeight"),"Logo height",30,120)){
					ErrorFound = 1;
				}

			}else{
				alert("Please Upload the Logo.");
				ErrorFound = 1;
			}

	}

	/*********  Banner Section *********/
	if(document.getElementById("BannerOption").checked){
			StoreUrl += '&BannerOption=1';
			if(document.getElementById("BannerBgImage").value != ''){
				StoreUrl += '&BannerBgImage='+document.getElementById("BannerBgImage").value;
					if(document.getElementById("BannerBgRepeate").checked){
						StoreUrl += '&BannerBgRepeate=1';
					}

					if(document.getElementById("BannerWidth").value != ''){
						StoreUrl += '&BannerWidth='+document.getElementById("BannerWidth").value;
					}

					if(document.getElementById("BannerHeight").value != ''){
						StoreUrl += '&BannerHeight='+document.getElementById("BannerHeight").value;
					}

					if(!ValidateMandNumField3(document.getElementById("BannerWidth"),"Banner width",30,650)){
						ErrorFound = 1;
					}

					if(!ValidateMandNumField3(document.getElementById("BannerHeight"),"Banner height",30,140)){
						ErrorFound = 1;
					}

					if(!isValidLinkOpt(document.getElementById("BannerLink"),'Banner Link')){
						ErrorFound = 1;
					}

					if(document.getElementById("BannerLink").value != ''){
						StoreUrl += '&BannerLink='+escape(document.getElementById("BannerLink").value);
					}

						if(document.getElementById("BannerTextOption").checked){
							StoreUrl += '&BannerTextOption=1';
							if(document.getElementById("BannerText").value != ''){
								StoreUrl += '&BannerText='+escape(document.getElementById("BannerText").value);
							}

							if(document.getElementById("BannerFontColor").value != ''){
								var BannerFontColor = document.getElementById("BannerFontColor").value.replace("#","");
								StoreUrl += '&BannerFontColor='+BannerFontColor;
							}
							if(document.getElementById("BannerFontSize").value != ''){
								StoreUrl += '&BannerFontSize='+document.getElementById("BannerFontSize").value;
							}

							if(document.getElementById("BannerFontType").value != ''){
								StoreUrl += '&BannerFontType='+document.getElementById("BannerFontType").value;
							}

							if(document.getElementById("BannerTextAlign").value != ''){
								StoreUrl += '&BannerTextAlign='+document.getElementById("BannerTextAlign").value;
							}
							

						}

			}else{
				alert("Please Upload the Banner.");
				ErrorFound = 1;

			}


	}








	if (mmspobj.tagName=='IFRAME' && ErrorFound==0){
	
		document.getElementById("IframeDiv").style.display = 'none'; 
		document.getElementById("LoadingDiv").style.display = 'inline'; 


		document.getElementById("IframeDiv").style.display = 'inline'; 
		mmspobj.src = StoreUrl+"&r="+Math.random(); 
		document.getElementById("LoadingDiv").style.display = 'none'; 
	}


 }



function validateTemplate(frm){

	if(document.getElementById("HeaderLogoOption").checked){

		if(!ValidateMandNumField3(frm.LogoWidth,"Logo width",30,900)){
			return false;
		}

		if(!ValidateMandNumField3(frm.LogoHeight,"Logo height",30,120)){
			return false;
		}


		if(document.getElementById("HeaderLogo").value == ''){
			alert("Please Upload the Logo.");
			return false;
		}
	}


	if(document.getElementById("BannerOption").checked){

		if(!ValidateMandNumField3(frm.BannerWidth,"Banner width",30,650)){
			return false;
		}

		if(!ValidateMandNumField3(frm.BannerHeight,"Banner height",30,140)){
			return false;
		}

		if(!isValidLinkOpt(frm.BannerLink,'Banner Link')){
			return false;
		}

		if(document.getElementById("BannerBgImage").value == ''){
			alert("Please Upload the Banner.");
			return false;
		}
	}




}