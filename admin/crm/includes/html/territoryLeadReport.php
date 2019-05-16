<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(){	
   
	if(document.getElementById("country").value==""){
		alert("Please Select Country.");
		document.getElementById("country").focus();
		return false;
	}
	
	if(document.getElementById("TerritoryList").value==""){
		alert("Please Select Territory.");
		document.getElementById("TerritoryList").focus();
		return false;
	}
        
        /*if(document.getElementById("ReportType").value==""){
		alert("Please Select Type.");
		document.getElementById("ReportType").focus();
		return false;
	}*/

	ShowHideLoader(1,'L');
}


</script>
<script language="JavaScript1.2" type="text/javascript">
    function ResetSearch() {
        $("#prv_msg_div").show();
        $("#frmSrch").hide();
        $("#preview_div").hide();
    }
    
    
 $(document).ready(function(){
     
     $("#country").change(function(){
         var country = $("#country").val();
         var current_territory = $("#current_territory").val();
         
         var SendParam = 'country=' + country +'&current_territory='+current_territory+'&action=getTerritory&r='+Math.random();
                        $.ajax({
			type: "GET",
			async:false,
			url: 'ajax.php',
			data: SendParam,
			success: function (responseText) {
				
				$("#TerritoryList").html(responseText);
			}
                        
                      });
                   });
                 
                 
           /******************************************************************************************/
           
                var country = $("#country").val();
                var current_territory = $("#current_territory").val();
                
                var SendParam = 'country=' + country +'&current_territory='+current_territory+'&action=getTerritory&r='+Math.random();
                           $.ajax({
                           type: "GET",
                           async:false,
                           url: 'ajax.php',
                           data: SendParam,
                           success: function (responseText) {
                                   
                                   $("#TerritoryList").html(responseText);
                           }

                         });
           
           /***************************************************************************************/
       });
       
    </script>         


<div class="had"><?= $MainModuleName ?></div>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td>
              <form onsubmit="return ValidateSearch();" method="get" action="territoryLeadReport.php" name="topForm">	
                <table cellspacing="0" cellpadding="0" border="0" style="margin:0;" id="search_table"> 
              
                <tbody>
                    <tr>

                        <td align="right" class="blackbold">Select Country  :</td>
                        <td>
                        <select name="country" id="country" class="inputbox">
                                        <option value="">---Select---</option>
                                        <?php  foreach ($arryCountry as $key => $values) {
                                            
                                                if(!empty($_GET['country'])){
                                                    $CountrySelected = $_GET['country'];
                                                }else{
                                                    $CountrySelected = $arryCurrentLocation[0]['country_id'];
                                                }
                                            
                                            ?>
                                            <option value="<?=$values["country_id"]?>" <?php  if($values["country_id"] == $CountrySelected){echo "selected";}?>><?=$values["name"]?></option>
                                        <?php }?>

                                    </select>
                        </td>
                        <td>&nbsp;</td> 
                        <td align="right" class="blackbold">Select Territory  :</td>
                        <td>
                            
                        <select name="TerritoryList" id="TerritoryList" class="inputbox">
                                        <option value="">--- Select---</option>

                                    </select>

                     </td> 
                     <!-- <td>&nbsp;</td> 
                        <td align="right" class="blackbold">Select Type  :</td>
                        <td>
                            
                              <select name="ReportType" id="ReportType" class="inputbox">
                                        <option value="">--- Select---</option>
                                        <option value="customer" <?php  //if($_GET['ReportType'] == "customer"){echo "selected";}?>>Customer</option>
                                        <option value="lead" <?php  //if($_GET['ReportType'] == "lead"){echo "selected";}?>>Lead</option>
                                    </select>

                     </td>-->
                     


                    <td>
                        <input type="hidden" name="current_territory" id="current_territory" value="<?=(isset($_GET['TerritoryList'])) ? $_GET['TerritoryList'] : '';?>">
                         <!--<input type="hidden" name="current_country" id="current_country" value="<?=$_GET['country'];?>">-->
                         <input type="submit" value="Go" class="search_button" name="s">

                         </td> 
                </tr>

                </tbody>
              
                </table>
                  
                    </form>
            <br>
        
           <?php  if($num > 0) { ?>
            <table cellspacing="0" cellpadding="0" border="0" style="margin:0;" width="100%" class="borderall"> 
            <tr>

                <td align="center">
                    <?php
                    function get_lat_long($address){

                       $address = str_replace(" ", "+", $address);

                       $json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=$region");
                       $json = json_decode($json);

                       $lat = $json->results[0]->geometry->location->lat;
                       $long = $json->results[0]->geometry->location->lng;
                       return $lat.','.$long;
                    }


                ?>
                    
       <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAPDUET0Qt7p2VcSk6JNU1sBRRwPhutbWBmyj82Go_H6JlE7EvFBSKFFFHFePAwvib9UM0geoA3Pgafw" type="text/javascript"></script>
        <div id="map" style="width: 100%; height: 450px; "></div> 
            <script type="text/javascript">
    //<![CDATA[

    if (GBrowserIsCompatible()) {

      function createMarker(point,html) {
		var MapIcon = new GIcon(G_DEFAULT_ICON, "<?=$googleMarkup;?>");
       // var marker = new GMarker(point);
        var marker = new GMarker(point,MapIcon);
        GEvent.addListener(marker, "click", function() {
          marker.openInfoWindowHtml(html);
        });
        return marker;
      }

        <?
            $latlong = get_lat_long($PrimaryLocation[0]['CityName'], $PrimaryLocation[0]['StateName'], $PrimaryLocation[0]['CountryName']);
            $aryLatlng = explode(",",$latlong);
            $lat = $aryLatlng[0];
            $long = $aryLatlng[1];
        ?>

      var map = new GMap2(document.getElementById("map"));
      map.addControl(new GLargeMapControl());
      map.addControl(new GMapTypeControl());
      map.setCenter(new GLatLng('<?=$lat?>','<?=$long?>'), 4);
      
      
    <?php
     foreach ($arryLead as $key => $values) {
         
         if($values['CityName'] != '' && $values['StateName'] != ''){
    
            $latlong = get_lat_long($values['CityName'], $values['StateName'], $values['CountryName']);
            $aryLatlng = explode(",",$latlong);
            $lat2 = $aryLatlng[0];
            $long2= $aryLatlng[1];
         ?>
        var point = new GLatLng('<?=$lat2?>','<?=$long2?>');
        var marker = createMarker(point,'<?=$values['CityName']?>, <?=$values['StateName'];?>, <?=$values['CountryName'];?>')
        map.addOverlay(marker);
         <?php }?>
    <?php } // foreach end //?>

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
                  
                </td>
                 </tr>       
            
            </table>
             <br>
            <?php }?> 

        <table <?=$table_bg?>>
   
    <tr align="left">
       
        <td  class="head1" width="10%" >Lead Name</td>
        <td  class="head1" width="8%">Company  </td>
        <td class="head1" width="10%">Phone  </td>
        <td class="head1" width="15%">Primary Email</td>
        <td class="head1" >Sales Person</td>
        <td  class="head1" width="8%">Country </td>
        <td  class="head1" width="8%">State </td>
        <td  class="head1" width="8%">City </td>
        <td  class="head1" width="8%">Status</td>
       
    </tr>
   
    <?php 

	
  if(!empty($arryLead) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryLead as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;
        
	
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
       
       <td><a class="fancybox fancybox.iframe" href="vLead.php?pop=1&view=<?=$values['leadID']?>" ><?=$values['FirstName']?> <?=$values['LastName']?></a></td>
	 
       <td><?= (!empty($values['company'])) ? (stripslashes($values['company'])) : (NOT_SPECIFIED) ?></td>
       <td><?= (!empty($values['LandlineNumber'])) ? (stripslashes($values['LandlineNumber'])) : (NOT_SPECIFIED) ?></td>

       <td><?= (!empty($values['primary_email'])) ? (stripslashes($values['primary_email'])) : (NOT_SPECIFIED) ?></td>


       <td>
       <?
            $assignList = '';
            if(!empty($values['AssignTo'])) {                
                    $arryAssignee = $objLead->GetAssigneeUser($values['AssignTo']);
                    $assignee = $values['AssignTo'];
                    foreach ($arryAssignee as $assign) {
                            $assignList .= "<a class='fancybox fancybox.iframe' href='../userInfo.php?view=".$assign['EmpID']."'>".$assign['UserName']."</a>, ";
                     }                  
                    $assignList = rtrim($assignList,", ");
                    echo $assignList;
            } else {
                    echo NOT_ASSIGNED;
            } ?>
       
       </td>
       <td ><?=$values['CountryName']?>  </td>
       <td ><?=$values['StateName']?>  </td>
       <td ><?=$values['CityName']?>  </td>
       <td><?=stripslashes($values["lead_status"])?></td> 
    

  
    
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="9" class="no_record">No Record Found.</td>
    </tr>
    <?php } ?>
  
	 <tr>  <td  colspan="9"  id="td_pager"></td>
  </tr>
  </table>
             
      
             
        </td>
    </tr>


</table>
