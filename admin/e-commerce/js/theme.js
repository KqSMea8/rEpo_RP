function getPage(id){
	ShowHideLoader('1', 'P');
	if(id>0 ){
		var action = 'getPage';
		
		$.ajax({
			url: 'theme_ajax.php',
			async:false,
			type: 'GET',
			data: {page_id:id,action:action},			
			success:function(data){	
				
				if(data!=''){	
					$('#PageLayout').show();
					$('#PageLayout').html(data);
					 
				}
				
				ShowHideLoader('2', 'P');
			}
		});
	}
}

function chooseLayout(id){
	var layoutval= $('#layout:checked').val();
	ShowHideLoader('1', 'P');
	if(id>0){
		var action = 'saveLayout';
		
		$.ajax({
			url: 'theme_ajax.php',
			async:false,
			type: 'GET',
			data: {page_id:id,layoutval:layoutval,action:action},			
			success:function(data){	
				
				//if(data!=''){	
					$('#PageLayout').show();
					var html='<div id="droppable" class="ui-widget-header"  style="height: 711px; width: 98%"></div><div id="buttondiv"></div>';
					$('#PageLayout').html(html);
					dragdropfunction();
					
					
					$('#droppable').html(data);
					var buttonhtml='<input type="button" name="Select" value="Save" onclick="savesetting('+id+');">';
					$('#buttondiv').html(buttonhtml);
					$('.delete').on('click', function () {
		                $(this).parent().parent('div').remove();
		            });
		            $('.delete').parent().parent('div').dblclick(function () {
		                $(this).remove();
		            });
					$(".remove").draggable({					   
					    cursor: 'move',
					    tolerance: 'fit',
					    revert: true
					});
				//}
				ShowHideLoader('2', 'P');
			}
		});
	}
}

function savesetting(id){
	ShowHideLoader('1', 'P');
	var content = $("#droppable").html();
	if(id>0){
		var action = 'savesetting';
		
		$.ajax({
			url: 'theme_ajax.php',
			async:false,
			type: 'GET',
			data: {page_id:id,content:content,action:action},			
			success:function(data){	
				
				//if(data!=''){	
					$('#PageLayout').show();
					var html='<div id="droppable" class="ui-widget-header"  style="height: 711px; width: 98%;"></div><div id="buttondiv"></div>';
					$('#PageLayout').html(html);
					dragdropfunction();
					
					
					$('#droppable').html(data);
					var buttonhtml='<input type="button" name="Select" value="Save" onclick="savesetting('+id+');">';
					$('#buttondiv').html(buttonhtml);
					$('.delete').on('click', function () {
		                $(this).parent().parent('div').remove();
		            });
		            $('.delete').parent().parent('div').dblclick(function () {
		                $(this).remove();
		            });
					$(".remove").draggable({					   
					    cursor: 'move',
					    tolerance: 'fit',
					    revert: true
					});
					alert('Data has been saved successfully');
				//}
				
				ShowHideLoader('2', 'P');
			}
		});
	}
}

function getSection(id,type){
	ShowHideLoader('1', 'P');
	if(id>0){
		var action = 'getSection';
		
		$.ajax({
			url: 'theme_ajax.php',
			async:false,
			type: 'GET',
			data: {themeId:id,type:type,action:action},			
			success:function(data){	
				
			
					$('#PageLayout').show();
					
					if(type=='header'){
						var html='<div class="editor-heading">Header:</div><div id="droppable" class="ui-widget-header"  style="min-height: 211px; height: auto; width: 100%;"></div><div id="buttondiv"></div>';
					}else if(type=='footer'){
						var html='<div class="editor-heading">Footer:</div><div id="droppable" class="ui-widget-header"  style="min-height: 211px; height: auto; width: 100%;"></div><div id="buttondiv"></div>';
					}
					else if(type=='left'){
						var html='<div class="editor-heading">Left:</div><div id="droppable" class="ui-widget-header"  style="min-height: 711px; height:auto; width: 30%;"></div><div id="buttondiv"></div>';
					}
					else {
						var html='<div class="editor-heading">Right:</div><div id="droppable" class="ui-widget-header right-box"  style="min-height: 711px; height:auto; width: 30%;"></div><div id="buttondiv"></div>';
					}
					
					$('#PageLayout').html(html);
					dragdropfunction();
					
					
					$('#droppable').html(data);
					var buttonhtml='<input type="button" name="Select" value="Save" onclick="saveSectionsetting('+id+',\''+type+'\');">';
					$('#buttondiv').html(buttonhtml);
					$('.delete').on('click', function () {
		                $(this).parent().parent('div').remove();
		            });
		            $('.delete').parent().parent('div').dblclick(function () {
		                $(this).remove();
		            });
					$(".remove").draggable({					   
					    cursor: 'move',
					    tolerance: 'fit',
					    revert: true
					});
					ShowHideLoader('2', 'P');
			}
		});
	}
}

function saveSectionsetting(id,type){
	var content = $("#droppable").html();
	ShowHideLoader('1', 'P');
	if(id>0){
		var action = 'saveSectionsetting';
		
		$.ajax({
			url: 'theme_ajax.php',
			async:false,
			type: 'GET',
			data : {
				themeId : id,
				type:type,content:content,action:action},			
			success:function(data){	
				
				if(data!=''){	
					$('#PageLayout').show();
					if(type=='header'){
						var html='<div class="editor-heading">Header:</div><div id="droppable" class="ui-widget-header"  style="min-height: 211px; height: auto; width: 100%;"></div><div id="buttondiv"></div>';
					}else if(type=='footer'){
						var html='<div class="editor-heading">Footer:</div><div id="droppable" class="ui-widget-header"  style="min-height: 211px; height: auto; width: 100%;"></div><div id="buttondiv"></div>';
					}
					else if(type=='left'){
						var html='<div class="editor-heading">Left:</div><div id="droppable" class="ui-widget-header"  style="min-height: 711px; height: auto; width: 30%;"></div><div id="buttondiv"></div>';
					}
					else {
						var html='<div class="editor-heading">Right:</div><div id="droppable" class="ui-widget-header right-box"  style="min-height: 711px; height: auto; width: 30%;"></div><div id="buttondiv"></div>';
					}
					
					
					$('#PageLayout').html(html);
					dragdropfunction();
					
					
					$('#droppable').html(data);
					var buttonhtml='<input type="button" name="Select" value="Save" onclick="saveSectionsetting('+id+',\''+type+'\');">';
					$('#buttondiv').html(buttonhtml);
					$('.delete').on('click', function () {
		                $(this).parent().parent('div').remove();
		            });
		            $('.delete').parent().parent('div').dblclick(function () {
		                $(this).remove();
		            });
					$(".remove").draggable({					   
					    cursor: 'move',
					    tolerance: 'fit',
					    revert: true
					});
					alert('Data has been saved successfully');
				}
				
				ShowHideLoader('2', 'P');
			}
		});
	}
	
}

function getStyle(id){
	
	if(id>0){
		ShowHideLoader('1', 'P');
		var action = 'getStyle';
		
		$.ajax({
			url: 'theme_ajax.php',
			async:false,
			type: 'GET',
			data: {themeId:id,action:action},			
			success:function(data){	
				
				if(data!=''){	
					$('#PageLayout').show();
					$('#PageLayout').html(data);
					
				}
				
				ShowHideLoader('2', 'P');
			}
		});
	}
}

function saveStyle(id){
	var cssstyle = $("#cssstyle").val();
	ShowHideLoader('1', 'P');
	if(id>0){
		
		var action = 'saveStyle';
		
		$.ajax({
			url: 'theme_ajax.php',
			async:false,
			type: 'GET',
			data : {
				themeId : id,cssstyle:cssstyle,action:action},			
			success:function(data){	
				
				if(data!=''){	
					$('#PageLayout').show();
					$('#PageLayout').html(data);
				}
				alert('Data has been saved successfully');
				ShowHideLoader('2', 'P');
			}
		});
	}
	
}

jQuery(document).ready(function(){
	//alert("hiii");
	/*jQuery("div#menu").hover(function(e) {
        jQuery(this).toggleClass("active");
    });	
	
	
	jQuery(".wrapper").hover(function(e) {
        jQuery("div#menu").removeClass("active");
    });*/
	
	
	
	
	jQuery("div#menu").on({
		mouseenter: function () {
			//alert("Enter");
			jQuery(this).addClass("active");
		},
		mouseleave: function () {
			//alert("out");
			jQuery(this).removeClass("active");
		}
	});
	
	
	
	
});
