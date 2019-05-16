<?
function get_lat_long($address){
	
   $address = str_replace(" ", "+", $address);

   $json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=$region");
   $json = json_decode($json);

   $lat = $json->results[0]->geometry->location->lat;
   $long = $json->results[0]->geometry->location->lng;
   return $lat.','.$long;
}



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>Google Maps</title>
    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAPDUET0Qt7p2VcSk6JNU1sBRRwPhutbWBmyj82Go_H6JlE7EvFBSKFFFHFePAwvib9UM0geoA3Pgafw" type="text/javascript"></script>
  </head>
  <body >


    <!-- the div where the map will be displayed -->
    <div id="map" style="width: 550px; height: 450px"></div>
    <a href="http://www.econym.demon.co.uk/googlemaps/basic6.htm">Back to the tutorial page</a>
    
    <!-- fail nicely if the browser has no Javascript -->
    <noscript><b>JavaScript must be enabled in order for you to use Google Maps.</b> 
      However, it seems JavaScript is either disabled or not supported by your browser. 
      To view Google Maps, enable JavaScript by changing your browser options, and then 
      try again.
    </noscript>

    <script type="text/javascript">
    //<![CDATA[

    if (GBrowserIsCompatible()) {

      function createMarker(point,html) {
		var MapIcon = new GIcon(G_DEFAULT_ICON, "colour086.png");
       // var marker = new GMarker(point);
        var marker = new GMarker(point,MapIcon);
        GEvent.addListener(marker, "click", function() {
          marker.openInfoWindowHtml(html);
        });
        return marker;
      }

<?
$latlong = get_lat_long('New Delhi, Delhi, India');
$aryLatlng = explode(",",$latlong);
$lat = $aryLatlng[0];
$long = $aryLatlng[1];
?>

      var map = new GMap2(document.getElementById("map"));
      map.addControl(new GLargeMapControl());
      map.addControl(new GMapTypeControl());
      map.setCenter(new GLatLng('<?=$lat?>','<?=$long?>'), 5);
    
      var point = new GLatLng('<?=$lat?>','<?=$long?>');
      var marker = createMarker(point,'Some stuff to display in the<br>First Info Window <br>With a <a href="http://www.econym.demon.co.uk">Link</a> to my home page')
      map.addOverlay(marker);


<?
$latlong = get_lat_long('Agra, Uttar Pradesh, India');
$aryLatlng = explode(",",$latlong);
$lat = $aryLatlng[0];
$long = $aryLatlng[1];
?>
	
      var point = new GLatLng('<?=$lat?>','<?=$long?>');
      var marker = createMarker(point,'Some stuff to display in the<br>Second Info Window with an image<br><img src="image.jpg" width=150 height=100>')
      map.addOverlay(marker);
	

<?
$latlong = get_lat_long('Mumbai, India');
$aryLatlng = explode(",",$latlong);
$lat = $aryLatlng[0];
$long = $aryLatlng[1];
?>
      var point = new GLatLng('<?=$lat?>','<?=$long?>');
      var marker = createMarker(point,'<h3>All the usual html formatting commands work</h3>')
      map.addOverlay(marker);


<?
$latlong = get_lat_long('Jhansi, India');
$aryLatlng = explode(",",$latlong);
$lat = $aryLatlng[0];
$long = $aryLatlng[1];
?>
      var point = new GLatLng('<?=$lat?>','<?=$long?>');
      var marker = createMarker(point,'<div style="background-color:#FFFF88; font-family:cursive; border:solid 3px black;" >You can use a div with<br>style settings.<br>Avoid using width settings<br>when using nowrap</div>')
      map.addOverlay(marker);
	


    }

    
    else {
      alert("Sorry, the Google Maps API is not compatible with this browser");
    }

    // This Javascript is based on code provided by the
    // Blackpool Community Church Javascript Team
    // http://www.commchurch.freeserve.co.uk/   
    // http://www.econym.demon.co.uk/googlemaps/

    //]]>
    </script>
  </body>

</html>




