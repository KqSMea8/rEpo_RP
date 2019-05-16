console.log('JMD');
var head = document.head, link = document.createElement('link');
link.type = 'text/css'; link.rel = 'stylesheet'; link.href = 'http://localhost/chatdesign/css/externalbox.css'; head.appendChild(link);
var ccconf={};

//console.log(ccconf);
var styleright='9px';
var styleposition='fixed';
if(chat.style!=undefined){
	if(chat.style.right!=undefined){
		styleright=chat.style.right+'px';
	}
}
//var resrrs=load('http://199.227.27.208:3000/api/config/06c2153ae199082b6009f65e1b11cd8c');
//console.log(resrrs);
var initializationText="<div class='chat-icon'><a href='javascript:void(0)' class='eznetchat-opener'><img src='images/chat-icon.png'></a></div>";
var d=document.createElement('div');
d.className="eznetchat-box eznetchat-close-box";
//d.style.right=styleright;
d.style.position=styleposition;
var cd = document.createElement('div');
cd.className="eznetchat-minimize";
cd.innerHTML="--";
d.appendChild(cd);
var ctb = document.createElement('div');
ctb.className="eznetchat-initialization";
ctb.innerHTML=initializationText;
d.appendChild(ctb);
var ifr = document.createElement('iframe');
//ifr.src = 'https://eznetchat.com:3000/'+chat.companycode;
ifr.src = 'http://localhost/chatdesign/index1.html';
ifr.className='eznetchat-iframe scrollback-stream scrollback-toast';
d.appendChild(ifr);


cd.addEventListener('click', function(e,v) {	
	var div = document.querySelector('.eznetchat-box');
	div.classList.add('eznetchat-close-box');	
  div.classList.remove('active');  
	   
}, false);
ctb.addEventListener('click', function() { 
 var div = document.querySelector('.eznetchat-box');
 div.classList.remove('eznetchat-close-box');
 div.classList.add('active');
}, false);
 
console.log(d);

function removeClass(el, cls) {
	  var reg = new RegExp("(\\s|^)" + cls + "(\\s|$)");
	  el.className = el.className.replace(reg, " ").replace(/(^\s*)|(\s*$)/g,"");
	}
function createCORSRequest(method, url) {
    var xhr = new XMLHttpRequest();
    if ("withCredentials" in xhr) {
      // XHR for Chrome/Firefox/Opera/Safari.
      xhr.open(method, url, true);
    } else if (typeof XDomainRequest != "undefined") {
      // XDomainRequest for IE.
      xhr = new XDomainRequest();
      xhr.open(method, url);
    } else {
      // CORS not supported.
      xhr = null;
    }
    return xhr;
  }

  // Helper method to parse the title tag from the response.
  function getTitle(text) {
    return text.match('<title>(.*)?</title>')[1];
  }

  // Make the actual CORS request.
  function makeCorsRequest() {
    // All HTML5 Rocks properties support CORS.
    var url = 'https://www.eznetchat.com/setting/getwindowconfig?c='+chat.companycode;
    var xhr = createCORSRequest('GET', url);
    //xhr.withCredentials = true;
    
    if (!xhr) {
      //alert('CORS not supported');
      return;
    }

    // Response handlers.
    xhr.onload = function() {
      var text = xhr.responseText;
      var obj = JSON.parse(text);
      ccconf=obj.position;
   
      parseccconf=JSON.parse(ccconf);  
     // console.log(parseccconf.position);
      if(parseccconf.position=='left'){
    	// console.log(parseccconf.distance);
    	  d.style.left=parseccconf.distance+'px';
      }else{
    	  d.style.right=parseccconf.distance+'px';    	  
      }
      document.body.appendChild(d);
    //  var title = getTitle(text);
      //alert('Response from CORS request to ' + url + ': ' + title);
    };

    xhr.onerror = function() {
     // alert('Woops, there was an error making the request.');
    };

    xhr.send();
  }
  makeCorsRequest();
