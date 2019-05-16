 
    <button id="authorize-button" style="visibility: hidden">Authorize</button>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script type="text/javascript">

      var clientId = '1033284819293-fsl46hlht0ekj7rh9f7cb54ekvkh9lr3.apps.googleusercontent.com';
      var LOGOUT      =   'http://accounts.google.com/Logout';

      var apiKey = 'ldw8w0mrA4oHH6HzXcCIV1gy';

      var scopes = 'https://www.googleapis.com/auth/plus.me';

      function handleClientLoad() {
		  
		 
        // Step 2: Reference the API key
        gapi.client.setApiKey(apiKey);
        window.setTimeout(checkAuth,1);
      }

      function checkAuth() {
        gapi.auth.authorize({client_id: clientId, scope: scopes, immediate: true}, handleAuthResult);
      }

      function handleAuthResult(authResult) {
        var authorizeButton = document.getElementById('authorize-button');
        if (authResult && !authResult.error) {
			
          authorizeButton.style.visibility = 'hidden';
          makeApiCall();
		  var acToken=  authResult.access_token;
		  getUserInfo(acToken);
		  console.log(authResult);
		  
                  $("#logoutText").show();
                  $(".Gdata").show();
                  
                  
        } else {
		
			
                        $("#logoutText").hide();
                        $(".Gdata").hide();
                        
          authorizeButton.style.visibility = '';
          authorizeButton.onclick = handleAuthClick;
        }
      }

      function handleAuthClick(event) {
        // Step 3: get authorization to use private data
        gapi.auth.authorize({client_id: clientId, scope: scopes, immediate: false}, handleAuthResult);
        return false;
      }

      // Load the API and make an API call.  Display the results on the screen.
      function makeApiCall() {
        // Step 4: Load the Google+ API
        gapi.client.load('plus', 'v1').then(function() {
          // Step 5: Assemble the API request
          var request = gapi.client.plus.people.get({
            'userId': 'me'
          });
          // Step 6: Execute the API request
          request.then(function(resp) {
            var heading = document.createElement('h4');
            var image = document.createElement('img');
            image.src = resp.result.image.url;
            heading.appendChild(image);
            heading.appendChild(document.createTextNode(resp.result.displayName));

            document.getElementById('content').appendChild(heading);
          }, function(reason) {
            console.log('Error: ' + reason.result.error.message);
          });
        });
      }
	  
	  
	   function getUserInfo(acToken) {
            $.ajax({
                url: 'https://www.googleapis.com/oauth2/v1/userinfo?access_token=' + acToken,
                data: null,
                success: function(resp) {
                    user    =   resp;
                    
                    console.log(user);
                    $('#uName').text('Welcome ' + user.name);
                    $('#imgHolder').attr('src', user.picture);
                },
                dataType: "jsonp"
            });
        }
		
		
		 //function startLogoutPolling() {
			 //alert("asdfasdfs");
           //gapi.auth.signOut();
           //window.location.reload;
        //}
        function startLogoutPolling() {
            $('#authorize-button').show();
            $(".Gdata").hide();
            $("#authorize-button").css("visibility", "visible");
            $('#logoutText').hide();
            $('#uName').text('Welcome ');
            $('#imgHolder').attr('src', 'none.jpg');
        }
        
         
    </script>
 
    <script src="https://apis.google.com/js/client.js?onload=handleClientLoad"></script>
    <div class="Gdata">
    <div id='uName'>Welcome</div>
    <img style="width: 100px;" src='' id='imgHolder'/>
    </div>
    <a href="#" id="logoutText" target='myIFrame' onclick="myIFrame.location='https://www.google.com/accounts/Logout'; startLogoutPolling();return false;">logout</a>
    <iframe name='myIFrame' id="myIFrame" style='display:none'></iframe>