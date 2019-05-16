var styleright='9px';
var styleposition='fixed';
if(chat.style!=undefined){
	if(chat.style.right!=undefined){
		styleright=chat.style.right+'px';
	}
}
//var head = document.head, link = document.createElement('link');
//link.type = 'text/css'; link.rel = 'stylesheet'; link.href = 'http://66.55.11.23/erp/css/chatcss/style.css'; head.appendChild(link);

if(document.getElementsByClassName('isactiveChat').length>0){
var d=document.createElement('div');
d.className="rs-chat close";
d.style.right=styleright;
d.style.position=styleposition;
var od = document.createElement('div');
od.className="rs-chat-open";
od.innerHTML="Open";
//d.appendChild(od);
var cd = document.createElement('div');
cd.className="rs-chat-close";
cd.innerHTML="X";
d.appendChild(cd);
var ctb = document.createElement('div');
ctb.className="rs-chat-titile-box rs-chat-open";
ctb.innerHTML="Chat Now <span class='chat-ifrm-loader hide'></span>";
d.appendChild(ctb);

var ctbh = document.createElement('div');
ctbh.className="rs-chat-header-box";
ctbh.innerHTML="Live Chat";
d.appendChild(ctbh);

var ifr = document.createElement('iframe');
ifr.src = 'http://66.55.11.23:8080/create/?type=empeznetusr&detail='+encodeURIComponent(JSON.stringify(chat));
ifr.className='scrollback-stream scrollback-toast';
//d.appendChild(ifr);
document.body.appendChild(d);
}
cd.addEventListener('click', function() {
	
	if(document.getElementsByClassName('crm-iframe').length>0){
		ctb.classList.add('hide');	
	}
	
	var div = document.querySelector('.rs-chat');
	div.classList.add('close');	 
}, false);
ctb.addEventListener('click', function() {
	if(document.getElementsByClassName('crm-iframe').length==0){
		document.getElementsByClassName('chat-ifrm-loader')[0].classList.remove('hide');
	var ifr = document.createElement('iframe');
	ifr.src = 'http://66.55.11.23:8080/create/?type=empeznetusr&detail='+encodeURIComponent(JSON.stringify(chat));
	ifr.className='scrollback-stream scrollback-toast crm-iframe';
	//console.log(ifr);
	var wrapper = document.getElementsByClassName('rs-chat')[0];
		wrapper.appendChild(ifr);
		$(ifr).load(function() {var div = document.querySelector('.rs-chat');
		 div.classList.remove('close');});
	//d.appendChild(ifr);
	}else{
		var div = document.querySelector('.rs-chat');
		 div.classList.remove('close');
		
	}
	
	 
}, false);

function removeClass(el, cls) {
	  var reg = new RegExp("(\\s|^)" + cls + "(\\s|$)");
	  el.className = el.className.replace(reg, " ").replace(/(^\s*)|(\s*$)/g,"");
	}

