
	tinyMCE.init({
		theme : "advanced",
		mode : "exact",
		elements : "detail,content",
		save_callback : "customSave",
		content_css : "example_advanced.css",
		extended_valid_elements : "a[href|target|name]",
		theme_advanced_buttons2_add_before: "cut,copy,paste,pastetext,pasteword,separator,search,replace,separator",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		file_browser_callback : "fileBrowserCallBack",
		width : "890px;",
		plugins : "table",
		theme_advanced_buttons3_add_before : "tablecontrols,separator",
		theme_advanced_buttons1_add : "fontselect,fontsizeselect",
		//invalid_elements : "a",
		theme_advanced_styles : "Header 1=header1;Header 2=header2;Header 3=header3;Table Row=tableRow1", // Theme specific setting CSS classes
		//execcommand_callback : "myCustomExecCommandHandler",
		debug : false
	});

	// Custom event handler
	function myCustomExecCommandHandler(editor_id, elm, command, user_interface, value) {
		var linkElm, imageElm, inst;

		switch (command) {
			case "mceLink":
				inst = tinyMCE.getInstanceById(editor_id);
				linkElm = tinyMCE.getParentElement(inst.selection.getFocusElement(), "a");

				if (linkElm)
					alert("Link dialog has been overriden. Found link href: " + tinyMCE.getAttrib(linkElm, "href"));
				else
					alert("Link dialog has been overriden.");

				return true;

			case "mceImage":
				inst = tinyMCE.getInstanceById(editor_id);
				imageElm = tinyMCE.getParentElement(inst.selection.getFocusElement(), "img");

				if (imageElm)
					alert("Image dialog has been overriden. Found image src: " + tinyMCE.getAttrib(imageElm, "src"));
				else
					alert("Image dialog has been overriden.");

				return true;
		}

		return false; // Pass to next handler in chain
	}

	// Custom save callback, gets called when the contents is to be submitted
	function customSave(id, content) {
		//alert(id + "=" + content);
	}
	function fileBrowserCallBack(field_name, url, type, win) {
		// This is where you insert your custom filebrowser logic
		//alert("Example of filebrowser callback: field_name: " + field_name + ", url: " + url + ", type: " + type);

		// Insert new URL, this would normaly be done in a popup
		win.document.forms[0].elements[field_name].value = "someurl.htm";
	}


<!-- /tinyMCE -->