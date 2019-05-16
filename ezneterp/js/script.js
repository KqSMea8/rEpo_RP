// JavaScript Document

jQuery(document).ready(function() {
    jQuery('.simplenews-subscribe #edit-mail ').attr('placeholder','Your Email');
    jQuery('.simplenews-subscribe #edit-mail--2').attr('placeholder','Your Email');
	//var search = "Enter your email";
	//jQuery('#edit-mail').val(search);
	//jQuery('#edit-mail').focus(function(){
	//	if(jQuery(this).val()==search)jQuery(this).val('');
	//});
	jQuery('#edit-mail').blur(function(){
		if(jQuery(this).val()==''){
			jQuery(this).val(search);
		}
	});
	
	jQuery(".product-tab .show-hide").click(function(){
    jQuery(".product-tab ul").slideToggle("normal");
});
	
	jQuery(".product-tab .show-hide-1").click(function(){
    jQuery(".product-tab ul.one").slideToggle("normal");
});
	
	jQuery(".product-tab .show-hide-2").click(function(){
    jQuery(".product-tab ul.two").slideToggle("normal");
});
	
	jQuery(".product-tab .show-hide-3").click(function(){
    jQuery(".product-tab ul.three").slideToggle("normal");
});
	
	jQuery(".product-tab .show-hide-4").click(function(){
    jQuery(".product-tab ul.four").slideToggle("normal");
});

});


