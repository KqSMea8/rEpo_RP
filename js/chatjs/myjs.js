function removeClass(e, t) {
	var a = new RegExp("(\\s|^)" + t + "(\\s|$)");
	e.className = e.className.replace(a, " ").replace(/(^\s*)|(\s*$)/g, "")
}
var styleright = "9px", styleposition = "fixed";
if (void 0 != chat.style && void 0 != chat.style.right
		&& (styleright = chat.style.right + "px"), document
		.getElementsByClassName("isactiveChat").length > 0) {
	var d = document.createElement("div");
	d.className = "rs-chat close", d.style.right = styleright,
			d.style.position = styleposition;
	var od = document.createElement("div");
	od.className = "rs-chat-open", od.innerHTML = "Open";
	var cd = document.createElement("div");
	cd.className = "rs-chat-close", cd.innerHTML = "X", d.appendChild(cd);
	var ctb = document.createElement("div");
			ctb.className = "rs-chat-titile-box rs-chat-open",
			ctb.innerHTML = "Chat Now <span class='chat-ifrm-loader hide'></span>",
			d.appendChild(ctb);
	var ctbh = document.createElement("div");
	ctbh.className = "rs-chat-header-box", ctbh.innerHTML = "Live Chat", d
			.appendChild(ctbh);
	var ifr = document.createElement("iframe");
	ifr.src = "https://www.eznetcrm.com:8080/create/?type=empeznetusr&detail="
			+ encodeURIComponent(JSON.stringify(chat)),
			ifr.className = "scrollback-stream scrollback-toast", document.body
					.appendChild(d)

cd.addEventListener("click", function() {
	document.getElementsByClassName("crm-iframe").length > 0
			&& ctb.classList.add("hide");
	var e = document.querySelector(".rs-chat");
	e.classList.add("close")
}, !1), ctb.addEventListener("click", function() {
	if (0 == document.getElementsByClassName("crm-iframe").length) {
		document.getElementsByClassName("chat-ifrm-loader")[0].classList
				.remove("hide");
		var e = document.createElement("iframe");
		e.src = "https://www.eznetcrm.com:8080/create/?type=empeznetusr&detail="
				+ encodeURIComponent(JSON.stringify(chat)),
				e.className = "scrollback-stream scrollback-toast crm-iframe";
		var t = document.getElementsByClassName("rs-chat")[0];
		t.appendChild(e), $(e).load(function() {
			var e = document.querySelector(".rs-chat");
			e.classList.remove("close")
		})
	} else {
		var a = document.querySelector(".rs-chat");
		a.classList.remove("close")
	}
}, !1);
}