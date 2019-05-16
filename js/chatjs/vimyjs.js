function removeClass(e, t) {
	var s = new RegExp("(\\s|^)" + t + "(\\s|$)");
	e.className = e.className.replace(s, " ").replace(/(^\s*)|(\s*$)/g, "")
}
var head = document.head, link = document.createElement("link");
link.type = "text/css", link.rel = "stylesheet",
		link.href = "https://www.eznetcrm.com/erp/css/chatcss/style.css", head
				.appendChild(link);
var styleright = "9px", styleposition = "fixed";
void 0 != chat.style && void 0 != chat.style.right
		&& (styleright = chat.style.right + "px");
var d = document.createElement("div");
d.className = "rs-chat close", d.style.right = styleright,
		d.style.position = styleposition;
var od = document.createElement("div");
od.className = "rs-chat-open", od.innerHTML = "Open";
var cd = document.createElement("div");
cd.className = "rs-chat-close", cd.innerHTML = "-", d.appendChild(cd);
var ctb = document.createElement("div");
ctb.className = "rs-chat-open",
		ctb.innerHTML = "Chat Now <span class='chat-ifrm-loader hide'></span>",
		d.appendChild(ctb);
var ifr = document.createElement("iframe");
		ifr.src = "https://www.eznetchat.com:8080/create/?type=visiterexnetusr&detail="
				+ encodeURIComponent(JSON.stringify(chat)),
		ifr.className = "scrollback-stream scrollback-toast crm-iframe",
		document.body.appendChild(d),
		cd.addEventListener("click", function(e, t) {
			document.getElementsByClassName("crm-iframe").length > 0
					&& ctb.classList.add("hide");
			var s = document.querySelector(".rs-chat");
			s.classList.add("close")
		}, !1),
		ctb
				.addEventListener(
						"click",
						function() {
							if (0 == document
									.getElementsByClassName("crm-iframe").length) {
								document
										.getElementsByClassName("chat-ifrm-loader")[0].classList
										.remove("hide");
								var e = document.createElement("iframe");
										e.src = "https://www.eznetchat.com:8080/create/?type=visiterexnetusr&detail="
												+ encodeURIComponent(JSON
														.stringify(chat)),
										e.className = "scrollback-stream scrollback-toast crm-iframe";
								var t = document
										.getElementsByClassName("rs-chat")[0];
								t.appendChild(e), $(e).load(function() {
									var e = document.querySelector(".rs-chat");
									e.classList.remove("close")
								})
							} else {
								var s = document.querySelector(".rs-chat");
								s.classList.remove("close")
							}
						}, !1);
