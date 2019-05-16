$(document).ready(function() {	
	getSearchWidget();
	getLogoWidget();
	getCurrencyWidget();
	getSignInWidget();
	getTopMenuWidget();
	getSocialWidget();
	getSliderBannerWidget();
	getFeaturedProductsWidget();
	getBestSellerProductsWidget();
	getSupportWidget();
	getFooterShopMenuWidget();
	getFooterInformationMenuWidget();
	getFooterMyAccountWidget();
	getFooterSubscriberWidget();
	getLeftCategoryMenuWidget();
	getLeftPriceFilterWidget();
	getLeftManufacturerFilterWidget();
	
});

function getSearchWidget(){	
	
		var action = 'getSearchWidget';
		
		$.ajax({
			url: 'widgets_ajax.php',
			async:false,
			type: 'GET',
			data: {action:action},			
			success:function(data){	
				
				if(data!=''){	
					$('.search_widget').html(data).removeAttr( 'style' ).removeAttr( 'class' );
					
				}
			}
		});
	
}

function getLogoWidget(){	
	
	var action = 'getLogoWidget';
	
	$.ajax({
		url: 'widgets_ajax.php',
		async:false,
		type: 'GET',
		data: {action:action},			
		success:function(data){	
			
			if(data!=''){	
				$('.logo_widget').html(data).removeAttr( 'style' ).removeAttr( 'class' );
				
			}
		}
	});

}
function getCurrencyWidget(){	
	
	var action = 'getCurrencyWidget';
	
	$.ajax({
		url: 'widgets_ajax.php',
		async:false,
		type: 'GET',
		data: {action:action},			
		success:function(data){	
			
			if(data!=''){	
				$('.currency_widget').html(data).removeAttr( 'style' ).removeAttr( 'class' );
				
			}
		}
	});

}
function getSignInWidget(){	
	
	var action = 'getSignInWidget';
	
	$.ajax({
		url: 'widgets_ajax.php',
		async:false,
		type: 'GET',
		data: {action:action},			
		success:function(data){	
			
			if(data!=''){	
				$('.signin_widget').html(data).removeAttr( 'style' ).removeAttr( 'class' );
				
			}
		}
	});

}
function getTopMenuWidget(){	
	
	var action = 'getTopMenuWidget';
	
	$.ajax({
		url: 'widgets_ajax.php',
		async:false,
		type: 'GET',
		data: {action:action},			
		success:function(data){	
			
			if(data!=''){	
				$('.topmenu_widget').html(data).removeAttr( 'style' ).removeAttr( 'class' );
				
			}
		}
	});

}

function getSocialWidget(){	
	
	var action = 'getSocialWidget';
	
	$.ajax({
		url: 'widgets_ajax.php',
		async:false,
		type: 'GET',
		data: {action:action},			
		success:function(data){	
			
			//if(data!=''){	
				$('.social_widget').html(data).removeAttr( 'style' ).removeAttr( 'class' );
				
			//}
		}
	});

}
function getSliderBannerWidget(){	
	
	var action = 'getSliderBannerWidget';
	
	$.ajax({
		url: 'widgets_ajax.php',
		async:false,
		type: 'GET',
		data: {action:action},			
		success:function(data){	
			
			if(data!=''){	
				$('.slider_banner_widget').html(data).removeAttr( 'style' ).removeAttr( 'class' );
				
			}
		}
	});

}
function getFeaturedProductsWidget(){	
	
	var action = 'getFeaturedProductsWidget';
	
	$.ajax({
		url: 'widgets_ajax.php',
		async:false,
		type: 'GET',
		data: {action:action},			
		success:function(data){	
			
			if(data!=''){	
				$('.featured_products_widget').html(data).removeAttr( 'style' ).removeAttr( 'class' );
				
			}
		}
	});

}
function getBestSellerProductsWidget(){	
	
	var action = 'getBestSellerProductsWidget';
	
	$.ajax({
		url: 'widgets_ajax.php',
		async:false,
		type: 'GET',
		data: {action:action},			
		success:function(data){	
			
			//if(data!=''){	
				$('.best_seller_products_widget').html(data).removeAttr( 'style' ).removeAttr( 'class' );
				
			//}
		}
	});

}
function getSupportWidget(){	
	
	var action = 'getSupportWidget';
	
	$.ajax({
		url: 'widgets_ajax.php',
		async:false,
		type: 'GET',
		data: {action:action},			
		success:function(data){	
			
			if(data!=''){	
				$('.support_widget').html(data).removeAttr( 'style' ).removeAttr( 'class' );
				
			}
		}
	});

}

function getFooterShopMenuWidget(){	
	
	var action = 'getFooterShopMenuWidget';
	
	$.ajax({
		url: 'widgets_ajax.php',
		async:false,
		type: 'GET',
		data: {action:action},			
		success:function(data){	
			
			if(data!=''){	
				$('.footer_shop_menu_widget').html(data).removeAttr( 'style' ).removeAttr( 'class' );
				
			}
		}
	});

}

function getFooterInformationMenuWidget(){	
	
	var action = 'getFooterInformationMenuWidget';
	
	$.ajax({
		url: 'widgets_ajax.php',
		async:false,
		type: 'GET',
		data: {action:action},			
		success:function(data){	
			
			if(data!=''){	
				$('.footer_information_menu_widget').html(data).removeAttr( 'style' ).removeAttr( 'class' );
				
			}
		}
	});

}
function getFooterMyAccountWidget(){	
	
	var action = 'getFooterMyAccountWidget';
	
	$.ajax({
		url: 'widgets_ajax.php',
		async:false,
		type: 'GET',
		data: {action:action},			
		success:function(data){	
			
			if(data!=''){	
				$('.footer_my_account_widget').html(data).removeAttr( 'style' ).removeAttr( 'class' );
				
			}
		}
	});

}
function getFooterSubscriberWidget(){	
	
	var action = 'getFooterSubscriberWidget';
	
	$.ajax({
		url: 'widgets_ajax.php',
		async:false,
		type: 'GET',
		data: {action:action},			
		success:function(data){	
			
			if(data!=''){	
				$('.footer_subscriber_widget').html(data).removeAttr( 'style' ).removeAttr( 'class' );
				
			}
		}
	});

}

function getLeftCategoryMenuWidget(){	
	
	var action = 'getLeftCategoryMenuWidget';
	var CatID=$('#CatID').val();
	
	$.ajax({
		url: 'widgets_ajax.php',
		async:false,
		type: 'GET',
		data: {action:action,cat:CatID},			
		success:function(data){	
			
			if(data!=''){	
				$('.left_category_menu_widget').html(data).removeAttr( 'style' ).removeAttr( 'class' );
				
			}
		}
	});
	
	
	(function($) {
	    if (!$.setCookie) {
	        $.extend({
	            setCookie: function(c_name, value, exdays) {
	                try {
	                    if (!c_name) return false;
	                    var exdate = new Date();
	                    exdate.setDate(exdate.getDate() + exdays);
	                    var c_value = escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
	                    document.cookie = c_name + "=" + c_value;
	                }
	                catch(err) {
	                    return false;
	                };
	                return true;
	            }
	        });
	    };
	    if (!$.getCookie) {
	        $.extend({
	            getCookie: function(c_name) {
	                try {
	                    var i, x, y,
	                        ARRcookies = document.cookie.split(";");
	                    for (i = 0; i < ARRcookies.length; i++) {
	                        x = ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
	                        y = ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
	                        x = x.replace(/^\s+|\s+$/g,"");
	                        if (x == c_name) return unescape(y);
	                    };
	                }
	                catch(err) {
	                    return false;
	                };
	                return false;
	            }
	        });
	    };
	})(jQuery);
	    $(document).ready(function(){

	     
	        $(".tree").treeview({
	            collapsed:true,
	            animated:"medium",
	            persist:"location"
	        });
	        
	        var CatID=$('#CatID').val();
	        
	       if(CatID!=''){
	        $(".tree a").click(function() {
	            $.setCookie("catMenu", $(this).parent("li").parent("ul").attr("id"),1);
	        });
	        
	        
	        
	        varActiveMenu = $.getCookie("catMenu");
	        
	        $("#" + varActiveMenu).parentsUntil(".tree").show();
	        $("#" + varActiveMenu).show();
	        
	        $("#" + varActiveMenu).parentsUntil(".tree").removeClass('expandable');
	        $("#" + varActiveMenu).parentsUntil(".tree").removeClass('lastExpandable');
	        
	        $("#" + varActiveMenu).parentsUntil(".tree").find("div").removeClass('expandable-hitarea');
	        $("#" + varActiveMenu).parentsUntil(".tree").find("div").removeClass('lastExpandable-hitarea'); 

	        $("#" + varActiveMenu).parentsUntil(".tree").find("div").addClass('collapsable-hitarea');
	        $("#" + varActiveMenu).parentsUntil(".tree").find("div").addClass('lastCollapsable-hitarea'); 
	        
	        
	        $("#" + varActiveMenu).parentsUntil(".tree").addClass('collapsable');
	        $("#" + varActiveMenu).parentsUntil(".tree").addClass('lastCollapsable');
	        
	        
	        
	         } else {
	        $.removeCookie("catMenu");
	         }

	   }); 

}

function getLeftPriceFilterWidget(){	
	
	var action = 'getLeftPriceFilterWidget';
	var CatID=$('#CatID').val();
	$.ajax({
		url: 'widgets_ajax.php',
		async:false,
		type: 'GET',
		data: {action:action,cat:CatID},			
		success:function(data){	
			
			if(data!=''){	
				$('.left_price_filter_widget').html(data).removeAttr( 'style' ).removeAttr( 'class' );
				
			}
		}
	});

}

function getLeftManufacturerFilterWidget(){	
	
	var action = 'getLeftManufacturerFilterWidget';
	var CatID=$('#CatID').val();
	$.ajax({
		url: 'widgets_ajax.php',
		async:false,
		type: 'GET',
		data: {action:action,cat:CatID},			
		success:function(data){	
			
			if(data!=''){	
				$('.left_manufacturer_filter_widget').html(data).removeAttr( 'style' ).removeAttr( 'class' );
				
			}
		}
	});

}
