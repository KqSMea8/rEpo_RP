<script type="text/javascript" src="js/theme.js?<?php echo time();?>"></script>
<link rel="stylesheet" type="text/css" href="<?=$Prefix;?>css/main-style.css?<?php echo time(); ?>">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<style>
.col{float:left;margin:5px;padding:5px;}
#col1{width:200px;height:auto;border:1px solid black;}
img.drag{width:40px;height:40px;position:relative;}
#droppable{width:350px;height:340px;border:1px solid black;}
.right{float:right;}
.left{float:left;}
.clear{clear:both;}
ul li{list-style:none;}
.drag-list img{width:80px;vertical-align:middle;cursor:move;}
.drag-list ul{margin:0;padding:0;}
.drag-list li{margin-bottom:5px;}
.remove-drag-hover{background-color:#ED4949!important;}
.drop-area{background-color:#afd1b2;}
.xicon{margin-top:-1px;position:absolute;margin-left:4px;color:red !important;font:message-box;text-decoration:none;}
.xicon:hover{background-color:#fff;color:#000;width:13px;height:20px;text-align:center;}
.tip{font-size:12px;clear:both;}


.menu .toggle {
    background: #34495e none repeat scroll 0 0;
    box-shadow: 5px 0 0 rgba(0, 0, 0, 0.1);
    color: #eee;
    height: 50px;
    line-height: 50px;
    position: absolute;
    right: -50px;
    text-align: center;
    top: 0;
    width: 50px;
}
a {
    color: #16a085;
    text-decoration: none;
    transition: all 0.25s ease 0s;
}

</style>
<div id="menu" class="menu-box">
	<div class="menu-area">	
        <h3><i class="fa fa-th-large"></i>CSS Section</h3>
        <ul>
        <li style="cursor:pointer" onclick="getStyle('<?php echo $arryTheme[0]['id'];?>');">CSS</li>
        
        
        
        </ul>
        <hr>
        <h3><i class="fa fa-bars"></i>Blocks</h3>
        
        
        <?php
        $count=1;
        $WidgetsStyleArray=array();        
        foreach($WidgetsArray as $list){
        $WidgetsStyleArray[$list['widgets_identity']]=$list['style'];
            echo '<div id="'.$list['widgets_identity'].'" class="drag"><span>'.$list['widgets_name'].'</span></div>';
            $count++;}?>
            
            
        
        
        <a class="toggle" href="#"><span class="fui-gear"></span></a>
        
        <hr>
        <h3><i class="fa fa-th-large"></i>Section</h3>
        <ul>
        <li style="cursor:pointer" onclick="getSection('<?php echo $arryTheme[0]['id'];?>','header');">Header</li>
        <li style="cursor:pointer" onclick="getSection('<?php echo $arryTheme[0]['id'];?>','footer');">Footer</li>
        <li style="cursor:pointer" onclick="getSection('<?php echo $arryTheme[0]['id'];?>','left');">Left</li>
        <li style="cursor:pointer" onclick="getSection('<?php echo $arryTheme[0]['id'];?>','right');">Right</li>
        
        
        </ul>
        <hr>
        <h3><i class="fa fa-file-o"></i>Pages</h3>
        
        <ul id="pages">
        <?php foreach($PagesArray as $list){
        	$page=$list['pageDisplayName'];
        	if($page=='') $page=$list['page'];
            echo '<li style="cursor:pointer" onclick="getPage(\''.$list['id'].'\');">'.$page.'</li>';
        }?>
        
        
        </ul>
        
         </div> 
        <a href="javascript:;" class="toggle"><i class="fa fa-cog"></i></a>
        <div class="overlay"></div>
      
</div>

<div class="backend-area">
	<div class="container">
        <div class="sidebar-box">
            <div class="had"><?=$MainModuleName?> <span>&raquo; <? 	echo (!empty($_GET['edit']))?("Edit ".$SubHeading) :("Add ".$ModuleName); ?>
            
            </span></div>
            <div> Theme Name: <?php echo $arryTheme[0]['themeName'];?></div>
            <div><a target="_new" href="<?php echo 'http://'.$_SERVER['SERVER_NAME'].'/ecom_latest/'.$_SESSION['DisplayName'].'/';?>">Preview</a></div>
        </div>
        
        <?php /*?> <a class="toggle" href="#" id="mian-menu"onover="$('#menu').toggleClass('active');">Click</a><?php */?>
        <!-- /.main -->
        
        <div class="editor-box" id="PageLayout">Loading....</div>
            </div>
            </div>
	
	

<script>
$( document ).ready(function() {
	getSection('<?php echo $arryTheme[0]['id'];?>','header');

});

function dragdropfunction(){
	
	var x = null;
	//Make element draggable
	$(".drag").draggable({
	    helper: 'clone',
	    cursor: 'move',
	    tolerance: 'fit',
	    revert: true
	});

	$("#droppable").droppable({
	    accept: '.drag',
	    activeClass: "drop-area",
	    drop: function (e, ui) {
	        if ($(ui.draggable)[0].id != "") {
				
		  var stylesetting=<?php echo json_encode($WidgetsStyleArray, JSON_PRETTY_PRINT) ?>; 
		  var obj = jQuery.parseJSON( stylesetting[$(ui.draggable)[0].id] );
		  
	            x = ui.helper.clone();
	            ui.helper.remove();
	            x.draggable({
	                helper: 'original',
	                cursor: 'move',
	                containment: '#droppable',
	                tolerance: 'fit',
	                drop: function (event, ui) {
	                    $(ui.draggable).remove();
	                }
	            });

	           
	            x.addClass('remove');
	            x.addClass($(ui.draggable)[0].id);
	            x.attr('id', $(ui.draggable)[0].id);
	            var s= "width:"+obj.width +"height:"+obj.height +" display:inline-block; ";
	            x.attr("style", s);
	            var el = $("<span><a title='Remove' class='xicon delete' href='Javascript:void(0)'>X</a></span>");
				//console.log($(x.first('span')).length);
				
				//$(el).insertAfter($(x.find('span')));
				//var elems =$( "div.search_widget span:nth-child(2)" ).toArray();
				
				//alert([0]);
				$(el).insertAfter($(x).children().eq(0));
	            x.appendTo('#droppable');
	            $('.delete').on('click', function () {
	                $(this).parent().parent('div').remove();
	            });
	            $('.delete').parent().parent('div').dblclick(function () {
	                $(this).remove();
	            });
	        }
	    }
	});

	$("#remove-drag").droppable({
	    drop: function (event, ui) {
	        $(ui.draggable).remove();
	    },
	    hoverClass: "remove-drag-hover",
	    accept: '.remove'
	});
}

	

</script>
