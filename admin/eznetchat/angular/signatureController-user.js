var version = '11.1.3';
angular.module("myapp")
.controller('signatureController',['$scope','$http','$location','$timeout','Upload','Cropper',function($scope,$http,$location,$timeout,Upload,Cropper){
	var thisObj = this;	
	var file, data;
	thisObj.tabs = [{
         title: 'Type Signature',
         url: 'typesignature',
         icon:'fa-text-width'
     }, {
         title: 'Draw Signature',
         url: 'drawsingnature',
         icon:'fa-file-image-o'
     }, {
         title: 'Upload Signature',
         url: 'uploadsignature',
         icon:'fa-object-group'
 }, {
     title: 'My Signature',
     url: 'mysignature',
     icon:'fa-object-group'
}];
	thisObj.currentTab='typesignature';
	thisObj.currentdrawTab='drawcontent';
	thisObj.currentdrawbtn='crop';
	thisObj.currentuploadbtn='';

	thisObj.currentuploadtab='uploadcontent';
	thisObj.inputtext=[];
	thisObj.storeimages=[];
	thisObj.mysignature="";
	thisObj.Allmysignature=[];
	if(SignatureObj){
	thisObj.Allmysignature=SignatureObj;
	}
	if(thisObj.Allmysignature.length!=0){
		thisObj.currentTab="mysignature";
		
	}
	
	thisObj.fonts=[8,9,10,11,12,13,14,15,16,17,18,19,20,25,30,35,40,45,50];
	
	thisObj.backgrounds = [{
        title: '1 background',
        url: './background/card/1.jpg'        
    }, {
    	 title: '2 background',
         url: './background/card/2.jpg'
    }, {
    	 title: '3 background',
         url: './background/card/3.jpg'
},
{
	 title: '4 background',
     url: './background/card/4.jpg'
}];
	
	
	thisObj.design={option:{font:11,color:'#000000'}};
	
	
	var signaturename='Sample Signature';
	if(userSessionObj.firstName){
		signaturename =userSessionObj.firstName;
		if(userSessionObj.lastName){
			signaturename += " "+userSessionObj.lastName;
		}
	}
	
	thisObj.inputsignature=signaturename;
	thisObj.currentSignature='';
	
	thisObj.ActiveMySignature='';
	thisObj.onClickTab = function (tab) {
	
		thisObj.currentTab = tab.url;
    }
	thisObj.onClicksignsture = function (sign) {
		
		thisObj.currentSignature = sign;
    }
	
	thisObj.onClickMysignsture = function (id,content) {
		
		thisObj.ActiveMySignature = id;
		thisObj.mysignature=content;
    }
	
	
	
	
	
	thisObj.isSet = function(tabNum){
		
			
	      return thisObj.currentTab  === tabNum;
	    };
	thisObj.isdrawSet = function(tabNum){
			
			
		      return thisObj.currentdrawTab  === tabNum;
	 };
	 
	 thisObj.isuploadSet = function(tabNum){
			
	      return thisObj.currentuploadtab  === tabNum;
	 };
	    
	 thisObj.isActiveTab=function(tabNum){
	    	
	    	  return thisObj.currentTab  === tabNum;
	    	
	    }
	 thisObj.isActiveMySignature=function(id){
	    	
		 return thisObj.ActiveMySignature  === id;
   	
   }
	 
	 thisObj.isActiveSignatureBTN=function(){
	    	if(thisObj.ActiveMySignature > 0){
	    		
	    		return false;
	    	}else{
	    		return true;
	    	}
		
   	
	 }
	 
	 thisObj.isActiveSignature=function(sign){
	    	
   	  return thisObj.currentSignature  === sign;
   	
   }
	    
	thisObj.addNewtextInput=function(){
		
		var lastitem=thisObj.inputtext.length+1;
		thisObj.inputtext.push({'id':'inputtext'+lastitem,'type':'text'});
		
		
	}
	
	thisObj.addNewImageInput=function(url){		
		var lastitem=thisObj.storeimages.length+1;
		thisObj.storeimages.push({'id':'inputimage'+lastitem,'url':url,'type':'image'});	
		
	}
	
	thisObj.removeinputText=function(index){	
				
		thisObj.inputtext.splice(index, 1);
		
	}
	
	thisObj.inputTextFocus=function(index){		
		
	
		thisObj.design.inputtextindex=index;
		thisObj.showtoolstatus=true;
		thisObj.design.option.bold=(thisObj.inputtext[index].bold)?true:false;
		thisObj.design.option.color=thisObj.inputtext[index].color;
		thisObj.design.option.fontstyle=(thisObj.inputtext[index].fontstyle)?true:false;
		thisObj.design.option.textdecoration=(thisObj.inputtext[index].textdecoration)?true:false;
		thisObj.design.option.font=(thisObj.inputtext[index].fontsize)?thisObj.inputtext[index].fontsize:11;
		thisObj.design.option.align=(thisObj.inputtext[index].align)?thisObj.inputtext[index].align:'left';

	}	
	
	thisObj.showtoolbar=function(){
	      return thisObj.showtoolstatus  === true;
    };
    
    thisObj.updateDesignOption=function(){
    		
    		var bold=(thisObj.design.option.bold)?'bold':'';    		
    		var color=(thisObj.design.option.color)?thisObj.design.option.color:'#000000';
    		var fontstyle=(thisObj.design.option.italic)?'italic':'';
    		var textdecoration=(thisObj.design.option.underline)?'underline':'';	
    		var align=(thisObj.design.option.align)?thisObj.design.option.align:'left';
    		
    		thisObj.inputtext[thisObj.design.inputtextindex].bold=bold;
    		thisObj.inputtext[thisObj.design.inputtextindex].color=color;
    		thisObj.inputtext[thisObj.design.inputtextindex].fontstyle=fontstyle;
    		thisObj.inputtext[thisObj.design.inputtextindex].textdecoration=textdecoration;
    		thisObj.inputtext[thisObj.design.inputtextindex].fontsize=thisObj.design.option.font;
    		thisObj.inputtext[thisObj.design.inputtextindex].align=thisObj.design.option.align;
    		thisObj.inputtext[thisObj.design.inputtextindex].style={"font-size":thisObj.design.option.font,'font-weight':bold,
    				'color':color,'font-style':fontstyle,'text-decoration':textdecoration,'text-align':align};   	
    	
    }
    
    
    thisObj.isActivelabel=function(index){
    return thisObj.design.inputtextindex===index;
    }
    
    thisObj.isshowbtn=function(index){
		return thisObj.currentTab==='mysignature';
			
}

thisObj.isshowbtnAdd=function(index){
		return thisObj.currentTab==='typesignature';
			
}

thisObj.isshowbtndraw=function(index){
	return (thisObj.currentTab==='drawsingnature' && thisObj.currentdrawbtn===index);
		
}

thisObj.isshowbtnupload=function(index){
	return (thisObj.currentTab==='uploadsignature' && thisObj.currentuploadbtn===index);
		
}
    thisObj.ismyimage=function(index){
    	
    	if(thisObj.mysignature)
		return true;
    	else
    		return false;
			
    }
 thisObj.isnotmyimage=function(index){
	
		 if(thisObj.Allmysignature.length==0)
		return true;
    	else
    		return false;
			
    }
    
    
    
    
    
    thisObj.keyRelease=function(event,index){
    	
  
    	
    }
    
    
    thisObj.inputblur=function(index){
    	if(index===false){
    	thisObj.design.inputtextindex='';
    	thisObj.showtoolstatus=false;	
    	}
    	
    }
    
    thisObj.eventApi= {
    	    onChange:  function(api, color, $event) {console.log('change');},
    	    onBlur:    function(api, color, $event) {thisObj.updateDesignOption();},
    	    onOpen:    function(api, color, $event) {},
    	    onClose:   function(api, color, $event) { thisObj.updateDesignOption(); },
    	    onClear:   function(api, color, $event) {},
    	    onReset:   function(api, color, $event) {},
    	    onDestroy: function(api, color) {},
    	};
    
    thisObj.setcardBackground=function(imageurl){
    	
    	if(imageurl){    	
    		thisObj.design.style={"background-image":'url('+imageurl+')','background-size':'700px 385px'}
    	}
    	
    	
    	
    }
    
    thisObj.uploadbackground=function(url){ 	
    	
		thisObj.backgrounds.push({ title: '1 background',url:url});
    	
    	
    	
    	
    }
    
    thisObj.setImage=function(url){    	
    	var lastitem=thisObj.inputtext.length+1;
		thisObj.inputtext.push({'id':'inputtext'+lastitem,'type':'image','url':url});
    }
    
    thisObj.CropDrawSignature=function(){ 
    	var c = document.getElementById("canvas");
		var ctx = c.getContext("2d");    
		
		var myCanvas = document.getElementById('resizedrawcanvas');
		var ctx1 = myCanvas.getContext('2d');
		ctx1 .clearRect(0, 0, myCanvas.width,myCanvas.height);
		var img = new Image;
		img.src = ctx.canvas.toDataURL();
		img.onload = function(){
			
			//myCanvas.width=342;
			//myCanvas.height=80;
			ctx1.drawImage(img,0,0,img.width,img.height,0,0,342,80);
		 // ctx1.drawImage(img,0,0); // Or at whatever offset you like
		};
		
		//console.log(ctx1.canvas.toDataURL());
		
		//thisObj.mysignature=
		//thisObj.drawimageurl=ctx.canvas.toDataURL();
		 SaveSignature(ctx.canvas.toDataURL());
//		file = dataURItoBlob(ctx.canvas.toDataURL());
//		thisObj.dataUrl=ctx.canvas.toDataURL();
//		thisObj.currentdrawTab="cropcontent";
//	
//		$timeout(showCropper); 
//		thisObj.currentdrawbtn="add";
		
		
		
		
		
		//thisObj.currentTab = "mysignature";
    	
    }
  
    
    
    
    
    function dataURItoBlob(dataURI) {
    	//console.log(dataURI);
    	  // convert base64 to raw binary data held in a string
    	  // doesn't handle URLEncoded DataURIs - see SO answer #6850276 for code that does this
    	  var byteString = atob(dataURI.split(',')[1]);

    	  // separate out the mime component
    	  var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0]

    	  // write the bytes of the string to an ArrayBuffer
    	  var ab = new ArrayBuffer(byteString.length);

    	  // create a view into the buffer
    	  var ia = new Uint8Array(ab);

    	  // set the bytes of the buffer to the correct values
    	  for (var i = 0; i < byteString.length; i++) {
    	      ia[i] = byteString.charCodeAt(i);
    	  }

    	  // write the ArrayBuffer to a blob, and you're done
    	  var blob = new Blob([ab], {type: mimeString});
    	  return blob;

    	}
    
    
    thisObj.CropAddSignature=function(){
    	
    	
   
    	 Cropper.crop(file, data).then(Cropper.encode).then(function(dataUrl) {
    		 
    		 SaveSignature(dataUrl);
 	    	
// 	     // (thisObj.preview || (thisObj.preview = {})).dataUrl = dataUrl;
	    });
    	
    }
    
    
 thisObj.CropUploadSignature=function(){
	 SaveSignature( thisObj.uploadUrl);
	 /*		file = dataURItoBlob(thisObj.uploaddataUrl);
   
    	 Cropper.crop(file, data).then(Cropper.encode).then(function(dataUrl) {
    		 
    		 SaveSignature(dataUrl);
 	    
 	    	$timeout(updatebuttons); */
 	    	
 	    	
 	    	
// 	     // (thisObj.preview || (thisObj.preview = {})).dataUrl = dataUrl;
	    //});
    	
    }
 
 function updatebuttons(){
	 console.log("updatebutton");
	 $scope.uploaddataUrl="";   
	 $scope.currentuploadbtn="";
 }
 function extractText( str ){
	  var ret = "";

	  if ( /"/.test( str ) ){
	    ret = str.match( /"(.*?)"/ )[1];
	  } else {
	    ret = str;
	  }

	  return ret;
	}
 thisObj.clearDraw=function(){
	 
	   var canvas_buffer = document.getElementById('canvas_buffer');
	      var contextbuffer = canvas_buffer.getContext('2d');
	      var canvas = document.getElementById('canvas');
	      var context = canvas.getContext('2d');
	      
	      context.clearRect(0, 0, canvas.width, canvas.height);
	      contextbuffer.clearRect(0, 0, canvas_buffer.width, canvas_buffer.height);
 }
    
    thisObj.SaveSignature=function(url){    	
    	
    			if(thisObj.currentTab=="typesignature" && jQuery(".signname.active").length==0){
    				alert("Please Select Sign");
    				return false;
    					}else if(thisObj.currentTab=="drawsignature"){
    						
    						
    					}
    			
    			if(thisObj.currentTab=="typesignature"){
    			var h=parseFloat(jQuery(".signname.active").height())+30;
    			var w=parseFloat(jQuery(".signname.active").width())+30;
    			var c=jQuery(".signname.active").attr("data-class");
    			jQuery(".content-inputhide").addClass(c);
    			var fs=jQuery(".signname.active").css("font-size");
    			var ff=jQuery(".signname.active").css("font-family");
    			console.log(ff);
    			ff=extractText(ff);

    		

    			fs=parseFloat(fs);
    			jQuery(".content-inputhide").css("font-size",fs);
    			var ww=parseFloat(jQuery(".content-inputhide").width());
    			var hh=parseFloat(jQuery(".content-inputhide").height());
    		
	    			var rw=(w-ww)/2;
	    			var rh=(h-hh)/2;
    			
    				rh=rh+parseFloat(fs);
    				var c = document.getElementById("drawimage");
    				
    				c.width=ww+16;
    				c.height=hh;
    				var ctx = c.getContext("2d");
    				
    				ctx.clearRect(0, 0, c.width, c.height);
    				ctx.font=fs+"px "+ff;
    				ctx.textBaseline="alphabetic";
    				ctx.strokeStyle= '#0000FF';
    				ctx.fillStyle = '#0000FF';
    				ctx.fillText(jQuery(".inputbox").val(), 8, fs-8);
    				
    				SaveSignature(ctx.canvas.toDataURL());
    				   
    				
    			}
    				//console.log(ctx.canvas.toDataURL());
    		
    }
    thisObj.AddSignature=function(){
    
    	if(!thisObj.ActiveMySignature){
    		alert("Please Select Sign");
    		return false;
    		
    	}
    	
    
    	var pagenumber=jQuery("#signature-modal").attr("data-page"); 
    	var left=jQuery("#signature-modal").attr("data-left");
    	var top=jQuery("#signature-modal").attr("data-top");
    	var code=jQuery("#signature-modal").attr("data-code");
    	var parentwidth=jQuery('#pageContainer'+pagenumber).width();
    	var parentHeight=jQuery('#pageContainer'+pagenumber).height();
    	var isset=jQuery("#signature-modal").attr("data-notset");
    	
    	var leftpx=parentwidth*left/100;
    	var toppx=parentHeight*top/100;
    	var w=211;
    	var h=30;
    	var wp=w*100/parentwidth;
    	var hp=h*100/parentHeight;
    	
    	
    	if(isset=="undefined" || isset!="false"){    	
    	if(jQuery('#pageContainer'+pagenumber).find(".signatureField-box").length==0){
    		
    		jQuery('#pageContainer'+pagenumber).append("<div class='signatureField-box'></div>");
    	}
    	
    	jQuery(".signatureField-box .class-signaturefield-"+code).html("<span class='remove-signature-value'></span><div class='signatureBox-field'><img src='"+thisObj.mysignature+"' alt=''></div>");
    	jQuery(".class-signaturefield-"+code).attr("data-value",thisObj.ActiveMySignature);
    	
    		var imageWidth=jQuery(".class-signaturefield-"+code).find('img').width();
		var imageHeight=jQuery(".class-signaturefield-"+code).find('img').height();		
		var imagewidthP=(imageWidth*100)/parentwidth;
		var imageheightP=(imageHeight*100)/parentHeight;
	
		jQuery(".class-signaturefield-"+code).attr('img-data-w',imagewidthP);
		jQuery(".class-signaturefield-"+code).attr('img-data-h',imageheightP);
		
	}
	
	
    	//return false;  // Tmp Stop Debug
    	jQuery('#signature-modal').modal('hide');    	
    	
    	issigned=1;
    	defaultsignature=thisObj.mysignature;
    	signatureid=thisObj.ActiveMySignature;
    	
    	setDefaultSignature(signatureid);
      
    	if(isset=="undefined" ||  isset!= "false"){
    		saveSignatureFieldValue(code,pagenumber);
    	}
    	
    }
    
      function setDefaultSignature(signatureId){
   		var request=jQuery.ajax({
		    	url:"../../author/setDefaultSignature",
		    	type:"POST",
		    	data:{
		    		signatureId:signatureId, 
		    		uid:userSessionObj.id,
		    		type:'signatureId',
		    	},success:function(data){
		    		signatureid=signatureId;
		    		issigned=1;
    				defaultsignature=thisObj.mysignature;	
    				jQuery("#changeSignature").show();
		    		
		    	}
    		});    
    }
    
    function SaveSignature(imagedata){
    	var request=jQuery.ajax({
    	url:"../../author/saveSignature",
    	type:"POST",
    	data:{
    		imageData:imagedata, 
    		docid:DOCID,
    	},success:function(data){
    		var hh={};
    		var objRes=JSON.parse(data);
    	
    		
    		
    		hh.id=objRes.id;
    		hh.content=imagedata;
    		thisObj.Allmysignature.push(hh);
    		thisObj.onClickTab("mysignature");
    		
    		jQuery('.signature-tab .mysignature a').trigger("click");
			//thisObj.currentTab = "mysignature";
    	}
    		
    		
    	});
    	
    	
    }
    
    
    thisObj.uploadPic = function (file) {
    	 thisObj.formUpload = true;
    	 thisObj.uploadtype='background';
        if (file != null) {
        	 thisObj.upload(file);
        }
      };
      
      
      thisObj.uploadImage = function (file) {
    	  console.log(file);

    	if(file.size>50000){
    		alert("Please Upload Signature less than 500 KB");
      	  return false;
    		
    	}
	  var reader  = new FileReader();
    	  
    	  reader.onload = (function(theFile) {
              return function(e) {
                 // Render thumbnail.
            	//  thisObj.uploaddataUrl=e.target.result;
            	 // 
            	//  thisObj.currentuploadbtn="add";
            	  thisObj.uploadUrl=e.target.result;
            	  $scope.uploadUrl=e.target.result;
            	  $timeout(showCheckUrl); 
            	  $scope.currentuploadbtn="add";
            	  console.log("upload image");
            	  console.log(e.target.result);
            	 // console.log(e.target.result);

            	 // thisObj.currentuploadtab="cropcontent";
                     // $('#imageURL').attr('src',e.target.result);                         
              };
          })(file);
          // Read in the image file as a data URL.
   
    	  if (file) {
    		  			reader.readAsDataURL(file);
    	
   		  }
//    	  
//     	 thisObj.formUpload = true;
//     	 thisObj.uploadtype='image';
//         if (file != null) {
         	// thisObj.upload(file);
         //}
       };
      
       function showCheckUrl() { 
    	 
    	 
    	   thisObj.currentuploadtab="uploadcontent";
    	   thisObj.currentuploadbtn="add";
    	//   $scope.$broadcast($scope.showEvent); 
    	   
       }
      
      thisObj.upload = function (file, resumable) {
    	  thisObj.errorMsg = null;
    	    if (thisObj.howToSend === 1) {
    	      uploadUsingUpload(file, resumable);
    	    } else if (thisObj.howToSend == 2) {
    	      uploadUsing$http(file);
    	    } else {
    	      uploadS3(file);
    	    	
    	    }
    	  };
    	  
    	  
    	  function uploadS3(file) {
    		    file.upload = Upload.upload({
    		      url: 'index.php',
    		      method: 'POST',
    		      data: {
    		        key: file.name,
    		        AWSAccessKeyId: '',
    		        acl: '',
    		        policy: '',
    		        signature: '',
    		        'Content-Type': file.type === null || file.type === '' ? 'application/octet-stream' : file.type,
    		        filename: file.name,
    		        file: file
    		      }
    		    });

    		    file.upload.then(function (response) {
    		      $timeout(function () {    	
    		    
    		    	  
    		    	  if(thisObj.uploadtype=='background'){
    		    	  thisObj.uploadbackground('./images/'+response.data.name);
    		    	  }else{    		    		  
    		    		  thisObj.addNewImageInput('./images/'+response.data.name);
    		    	  }
    		          
    		    	  file.result = response.data;
    		      });
    		    }, function (response) {
    		      if (response.status > 0)
    		    	  thisObj.errorMsg = response.status + ': ' + response.data;
    		    });

    		    file.upload.progress(function (evt) {
    		    
    		        file.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
    		    });
    		    storeS3UploadConfigInLocalStore();
    		  }
    	  
    	  function storeS3UploadConfigInLocalStore() {
    		    if (thisObj.howToSend === 3 && localStorage) {
    		      localStorage.setItem('s3url', '');
    		      localStorage.setItem('AWSAccessKeyId', '');
    		      localStorage.setItem('acl', '');
    		      localStorage.setItem('success_action_redirect', '');
    		      localStorage.setItem('policy', '');
    		      localStorage.setItem('signature','');
    		    }
    		  }
    	  
    	  $timeout(function () {
    		  thisObj.capture = localStorage.getItem('capture' + version) || 'camera';
    		  thisObj.pattern = localStorage.getItem('pattern' + version) || 'image/*,audio/*,video/*';
    		  thisObj.acceptSelect = localStorage.getItem('acceptSelect' + version) || 'image/*,audio/*,video/*';
    		  thisObj.modelOptions = localStorage.getItem('modelOptions' + version) || '{debounce:100}';
    		  thisObj.dragOverClass = localStorage.getItem('dragOverClass' + version) || '{accept:\'dragover\', reject:\'dragover-err\', pattern:\'image/*,audio/*,video/*,text/*\'}';
    		  thisObj.disabled = localStorage.getItem('disabled' + version) == 'true' || false;
    		  thisObj.multiple = localStorage.getItem('multiple' + version) == 'true' || false;
    		  thisObj.allowDir = localStorage.getItem('allowDir' + version) == 'true' || true;
    		  thisObj.validate = localStorage.getItem('validate' + version) || '{size: {max: \'20MB\', min: \'10B\'}, height: {max: 12000}, width: {max: 12000}, duration: {max: \'5m\'}}';
    		  thisObj.keep = localStorage.getItem('keep' + version) == 'true' || false;
    		  thisObj.keepDistinct = localStorage.getItem('keepDistinct' + version) == 'true' || false;
    		  thisObj.orientation = localStorage.getItem('orientation' + version) == 'true' || false;
    		  thisObj.runAllValidations = localStorage.getItem('runAllValidations' + version) == 'true' || false;
    		  thisObj.resize = localStorage.getItem('resize' + version) || "{width: 1000, height: 1000, centerCrop: true}";
    		  thisObj.resizeIf = localStorage.getItem('resizeIf' + version) || "$width > 5000 || $height > 5000";
    		  thisObj.dimensions = localStorage.getItem('dimensions' + version) || "$width < 12000 || $height < 12000";
    		  thisObj.duration = localStorage.getItem('duration' + version) || "$duration < 10000";
    		  thisObj.maxFiles = localStorage.getItem('maxFiles' + version) || "500";
    		  thisObj.ignoreInvalid = localStorage.getItem('ignoreInvalid' + version) || "";
    		 
    		  });
    	  
    	  
    	  
      	

    	  /**
    	   * Method is called every time file input's value changes.
    	   * Because of Angular has not ng-change for file inputs a hack is needed -
    	   * call `angular.element(this).scope().onFile(this.files[0])`
    	   * when input's event is fired.
    	   */
    	  thisObj.onFile = function(blob) {
    	    Cropper.encode((file = blob)).then(function(dataUrl) {
    	    	thisObj.dataUrl = dataUrl;
    	      $timeout(showCropper);  // wait for $digest to set image's src
    	    });
    	  };

    	  /**
    	   * Croppers container object should be created in controller's scope
    	   * for updates by directive via prototypal inheritance.
    	   * Pass a full proxy name to the `ng-cropper-proxy` directive attribute to
    	   * enable proxing.
    	   */
    	  thisObj.cropper = {};
    	  thisObj.cropperProxy = 'cropper.first';

    	  /**
    	   * When there is a cropped image to show encode it to base64 string and
    	   * use as a source for an image element.
    	   */
    	  thisObj.preview = function() {
    	    if (!file || !data) return;
    	    Cropper.crop(file, data).then(Cropper.encode).then(function(dataUrl) {
    	      (thisObj.preview || (thisObj.preview = {})).dataUrl = dataUrl;
    	    });
    	  };

    	  /**
    	   * Use cropper function proxy to call methods of the plugin.
    	   * See https://github.com/fengyuanchen/cropper#methods
    	   */
    	  $scope.clear = function(degrees) {
    	    if (!$scope.cropper.first) return;
    	    thisObj.cropper.first('clear');
    	  };

    	  $scope.scale = function(width) {
    	    Cropper.crop(file, data)
    	      .then(function(blob) {
    	        return Cropper.scale(blob, {width: width});
    	      })
    	      .then(Cropper.encode).then(function(dataUrl) {
    	        (thisObj.preview || (thisObj.preview = {})).dataUrl = dataUrl;
    	      });
    	  }

    	  /**
    	   * Object is used to pass options to initalize a cropper.
    	   * More on options - https://github.com/fengyuanchen/cropper#options
    	   */
    	  $scope.options = {
    	    maximize: true,
    	    aspectRatio: 2 / 1,
    	    crop: function(dataNew) {
    	      data = dataNew;
    	    }
    	  };

    	  /**
    	   * Showing (initializing) and hiding (destroying) of a cropper are started by
    	   * events. The scope of the `ng-cropper` directive is derived from the scope of
    	   * the controller. When initializing the `ng-cropper` directive adds two handlers
    	   * listening to events passed by `ng-cropper-show` & `ng-cropper-hide` attributes.
    	   * To show or hide a cropper `$broadcast` a proper event.
    	   */
    	  $scope.showEvent = 'show';
    	  $scope.hideEvent = 'hide';

    	  function showCropper() { $scope.$broadcast($scope.showEvent); }
    	  function hideCropper() { $scope.$broadcast($scope.hideEvent); }
    
    

}]);
