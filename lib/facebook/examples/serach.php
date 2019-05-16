<?php 
require '../src/facebookSearcher.class.php';
require '../src/facebook.php';

// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
  'appId'  => '211257059004768',
  'secret' => '665bfd2c2b00202414ee26933d839756',
));





// Get User ID
$user = $facebook->getUser();


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
  //$loginUrl = $facebook->getLoginUrl();
  $loginUrl = $facebook->getLoginUrl(array('scope' => 'public_profile,email'));
}


// get access login
//$access_token = $facebook->getAccessToken();
$access_token = "CAADAIx31UWABAGPtS6N71XNuWKLU4WsuY19q96gkS9vMODfi12XBV4A5JHkH0vyIIdJlcbEXCg9JuQXZAZBC1iyvy7sh8hDwK4go0Kcrwf0IZBZC3O0PZCnLBP6kU0lMVIqeg3OXBzti9BP97V7xkJNymojiS4LDQ4F67XIZB2avZCEHSkdxXctmttYnshynPbgiuP6TKXrDuVDhq9kBOMo";

// Get the application access token
//$access_token = $facebook->getApplicationAccessToken();



$vars = $_POST;





?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
      xmlns:og="http://ogp.me/ns#"
      xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Facebook Search Example</title>
    <style>
        table, td{ border: solid thin grey; }
        form { margin: 10px; border: 2px dotted blue; width: 400px;}
    </style>
</head>
<body>
 <?php if ($user){ ?>
      <a href="<?php echo $logoutUrl; ?>">Logout</a>
    <?php }else{ ?>
      <div>
        <a href="<?php echo $loginUrl; ?>">Login with Facebook</a>
      </div>
    <?php } ?>
<h1>Facebook Search</h2>

</div>
<form action="" method="post">
    <input type="text" name="q" value="<?=$vars['q']?>"></input>
    <select name="type">
        <option value="post">Post</option>
        <option value="event">Event</option>
        <option value="place">place</option>
        <option value="page">page</option>
        <option value="group">group</option>
        <option value="checkin">checkin</option>
		<option value="user">user</option>
    </select>
    <input type="submit" value="search"></input>
</form>

<?

if(isset($_POST['q'])){
    
    $searcher = new facebookSearcher();
	$searcher->setAccessToken($access_token);
	
    $searcher->setQuery($vars['q'])
                ->setType($vars['type'])
                ->setLimit(15);
    $graph_res = $searcher->fetchResults();
    
    /** Show Results **/
    echo "<h2>Search {$vars['type']}s For : {$vars['q']}</h2>";
    if(count($graph_res->data) == 0)  exit("No Results");
    if($vars['type'] == 'post'){
        //post
        foreach($graph_res->data as $post){
            $row[] = "<img src='{$post->icon}' />".$post->type;
            $row[] = $post->from->name;
            $row[] = $post->message;
            $row[] = "<a href='{$post->link}' target='_blank'>{$post->link}</a>";
            $row[] = $post->likes->count." Likes";
            $table[] = $row;
            unset($row);
        }
    }elseif($vars['type'] == 'event'){
        foreach($graph_res->data as $post){
            $row[] = $post->name;
            $row[] = "At ".$post->location;
            $row[] = "From ".$post->start_time." To ".$post->end_time;
            $table[] = $row;
            unset($row);
        }
    }elseif($vars['type'] == 'place'){
        foreach($graph_res->data as $post){
            $row[] = $post->name;
            $row[] = $post->category;
            $row[] = $post->location->street.", ".$post->location->city.", ".$post->location->country;
            $table[] = $row;
            unset($row);
        }
    }else{
        echo "New Type: <br /><pre>".print_r($graph_res,true)."</pre>";
    }
echo <<<HTML
    <table>
HTML;
        foreach ($table as $row){
            echo "<tr>";
            foreach ($row as $cell){
                echo "<td>{$cell}</td>";
            }
            echo "</tr>";
        }
        ?>
    </table>
<a href="<?=$searcher->getPreviousPage()?>">Preivous Search Results URL</a> | <a href="<?=$searcher->getNextPage()?>">Next Search Results URL</a>
<?}?>

</body>
</html> 

<div id="fb-root"></div>

