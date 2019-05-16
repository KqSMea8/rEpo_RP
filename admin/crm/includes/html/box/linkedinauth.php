<script type="text/javascript" src="http://platform.linkedin.com/in.js">
  api_key: 75pnp6i91ecr8l
  authorize: true
  onLoad: onLinkedInLoad
</script>
 <script type="text/javascript">
    
    // Setup an event listener to make an API call once auth is complete
    function onLinkedInLoad() {
    	  $('a[id*=li_ui_li_gen_]').css({marginBottom:'20px'}) 
          .html('<img src="http://eznetcrm.com/erp/admin/crm/images/lin-sign.png" border="0" />'); 
          IN.Event.on(IN, "auth", getProfileData);
    }

    // Handle the successful return from the API call
    function onSuccess(linedindata) {
       jQuery('.linkedin-login-view').fadeIn(200);
    }

    // Handle an error response from the API call
    function onError(error) {
        console.log(error);
    }

    // Use the API call wrapper to request the member's basic profile data
    function getProfileData() {
        var profiledata=IN.API.Raw("/people/~").result(onSuccess).error(onError);		   
         jQuery('.logout-button').html('<a href="javascript:void(0)" onclick="linkedinlogout()"><img src="http://eznetcrm.com/erp/admin/crm/images/lin-logout.png" alt="logout"></a>')
    }

    function linkedinlogout(){      
        	IN.User.logout(onLogout);
        }

   	function onLogout(){	
   		jQuery('.linkedin-login-view').fadeOut(200);
		window.location="";
        }
    function liAuth(){
    	   IN.User.authorize(function(){
    	       callback();
    	   });
    	}

</script>