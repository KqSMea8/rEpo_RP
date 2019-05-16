<?php
/**

This SDK is deprecated.  Please use the new SDK found here: https://github.com/facebook/facebook-php-sdk-v4

*/
/**
 * Copyright 2011 Facebook, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may
 * not use this file except in compliance with the License. You may obtain
 * a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

require '../src/facebook.php';

// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
  'appId'  => '211257059004768',
  'secret' => '665bfd2c2b00202414ee26933d839756',
));

// Get User ID
$user = $facebook->getUser();

// We may or may not have this data based on whether the user is logged in.
//
// If we have a $user id here, it means we know the user is logged into
// Facebook, but we don't know if the access token is valid. An access
// token is invalid if the user logged out of Facebook.


if ($user) {
  try {
    $privacy = array(
        'value' => 'CUSTOM',
        'friends' => 'NO_FRIENDS',
        'allow' => '100001679804091' // Change this to your friends ids
    );
    $params = array();
    $params['privacy'] = json_encode($privacy);
    $params['message'] = "Hello testing";
    $post_id = $facebook->api('/me/feed', 'POST', $params);
    var_dump($post_id);
  } catch (FacebookApiException $e) {
    print_r($e);
    $user = null;
  }
}












if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}

// Login or logout url will be needed depending on current user state.
if ($user) {
  $logoutUrl = $facebook->getLogoutUrl();
    $facebook->destroySession();
} else {
  $loginUrl = $facebook->getLoginUrl();
}


// get access login
$access_token = $facebook->getAccessToken();




/*
// define your POST parameters (replace with your own values)
$params = array(
  "access_token" => $access_token, // see: https://developers.facebook.com/docs/facebook-login/access-tokens/
  "message" => "Here is a blog post about auto posting on Facebook using PHP #php #facebook",
  "link" => "http://stackoverflow.com/questions/9133170/post-on-someones-wall-using-facebook-api-php",
  //"picture" => "http://i.imgur.com/lHkOsiH.png",
  "name" => "How to Auto Post on Facebook with PHP",
  "caption" => "www.pontikis.net",
  "description" => "Automatically post on Facebook with PHP using Facebook PHP SDK. How to create a Facebook app. Obtain and extend Facebook access tokens. Cron automation.",
  "privacy"=>array('value' => 'CUSTOM','friends'=>'NO_FRIENDS','allow'=>'100001679804091')
);

    $privacy = array(
        'value' => 'CUSTOM',
        'friends' => 'SOME_FRIENDS',
        'allow' => '100001679804091' // Change this to your friends ids
    );
    $params = array();
    $params['privacy'] = json_encode($privacy);
    $params['message'] = "Special for TWO friends";
 
// post to Facebook
// see: https://developers.facebook.com/docs/reference/php/facebook-api/
try {
 // $ret = $facebook->api('/100000551541052/feed/allow/100001679804091', 'POST', $params);
  $ret = $facebook->api('/100000551541052/feed/', 'POST', $params);
  echo 'Successfully posted to Facebook';
} catch(Exception $e) {
  echo $e->getMessage();
}

*/

// This call will always work since we are fetching public data.
$search_user = $facebook->api('/100000364186244');

?>
<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
    <title>php-sdk</title>
    <style>
      body {
        font-family: 'Lucida Grande', Verdana, Arial, sans-serif;
      }
      h1 a {
        text-decoration: none;
        color: #3b5998;
      }
      h1 a:hover {
        text-decoration: underline;
      }
    </style>
  </head>
  <body>
    <h1>php-sdk</h1>

    <?php if ($user){ ?>
      <a href="<?php echo $logoutUrl; ?>">Logout</a>
    <?php }else{ ?>
      <div>
        <a href="<?php echo $loginUrl; ?>">Login with Facebook</a>
      </div>
    <?php } ?>

    <h3>PHP Session</h3>
    <pre><?php print_r($_SESSION); ?></pre>

    <?php if ($user): ?>
      <h3>You</h3>
      <img src="https://graph.facebook.com/<?php echo $user; ?>/picture">

      <h3>Your User Object (/me)</h3>
      <pre><?php print_r($user_profile); ?></pre>
    <?php else: ?>
      <strong><em>You are not Connected.</em></strong>
    <?php endif ?>

    <h3>Public profile of search user</h3>
    <?php echo "<pre>";print_r($search_user); ?>
  </body>
</html>
