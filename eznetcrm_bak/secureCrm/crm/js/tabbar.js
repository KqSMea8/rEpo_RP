/*$(document).ready(function(){
  $('#accordion > li > a').click(function(){
    if ($(this).attr('class') != 'active'){
      $('#accordion li ul').slideUp();
      $(this).next().slideToggle();
      $('#accordion li a').removeClass('active');
      $(this).addClass('active');
    }
  });
});*/


$(document).ready(function(){
  $('#accordion > li ul').click(function(event){
  event.stopPropagation();
  
  })
  .filter(' :not(:first)')
  .hide();
  
 $('#accordion > li,#accordion > li > ul > li,#accordion > li > ul > li ul > li,#accordion > li > ul > li ul > li ul > li').click(function(){
  var selfClick=$(this).find('url:first').is('visible');
  if(!selfClick){
     $(this).parent().find('> li ul:visible').slideToggle();
  }
    $(this).find('ul:first').stop(true,true).slideToggle();
  });
  
 /* $("ul.tabs li").click(function() {
		$("ul.tabs li").removeClass("active"); //Remove any "active" class
		$(this).addClass("active"); //Add "active" class to selected tab
		$(".tab_content").css("top","-999999px"); //Hide all tab content
		var activeTab = $(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
		$(activeTab).css("top","44px"); //Fade in the active content
		return false;
	});*/
  
        
        $('.jqzoom').jqzoom({
            zoomType: 'standard',
            lens:true,
            preloadImages: false,
            alwaysOn:false
        });
  

});



function st2(t) {
    var toggle = document.getElementById('toggle');
    var as = toggle.getElementsByTagName('a');
    for(j = 1; j <= as.length; j++) {
        ts = document.getElementById('tt'+j);
        tr = document.getElementById('dd'+j);
        ta = document.getElementById('aa'+j);
       
        if(t==j) {
            ts.className="navigation";
            ta.className="active";
            tr.style["display"]="block";
            tr.style["visibility"]="visible";
        } else {
            ts.className="navigation";
            ta.className="navigation";
            tr.style["display"]="none";
            tr.style["visibility"]="hidden";
        }
    }
}


 