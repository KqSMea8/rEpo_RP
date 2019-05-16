
<table width="100%" id="myTable" class="order-list"  cellpadding="0" cellspacing="1">
    <thead>
        <tr align="left"  >
            <td  class="heading">Country</td>
             <td  class="heading">State</td>
             <td  class="heading">City</td>
           
           
        </tr>
    </thead>
    <tbody>
        <?
       
        for ($Line = 1; $Line <= $NumLine; $Line++) {
            $Count = $Line - 1;
            	$stateName=$cityName='';
                /********Connecting to main database*********/
                    $Config['DbName'] = $Config['DbMain'];
                    $objConfig->dbName = $Config['DbName'];
                    $objConfig->connect();
                /*******************************************/
            if($arryTerritoryRuleLocation[$Count]["country"] > 0){        
               $countryName =  $objRegion->GetCountryName($arryTerritoryRuleLocation[$Count]["country"]);
            }
            
             if(!empty($arryTerritoryRuleLocation[$Count]["state"])){
               
                    $stateName =  $objRegion->getAllStateName($arryTerritoryRuleLocation[$Count]["state"]);
              
            }
            
             if(!empty($arryTerritoryRuleLocation[$Count]["city"])){
               
                    $cityName =  $objRegion->getAllCityName($arryTerritoryRuleLocation[$Count]["city"]);
              
            }
            
         
            
           
            
            ?>
            <tr class="itembg">
                <td width="20%"> <?=$countryName[0]['name'];?> </td>
                 <td width="20%"> <?=$stateName?> </td>
                  <td width="20%"> <?=$cityName?> </td>
            </tr>
        <?php } ?>
    </tbody>
    
</table>


<script>

 $(document).ready(function() {


        $(".slnoclass").fancybox({
            'width': 300
        });
        
         $(".cityclass").fancybox({
            'width': 300
        });



    });

</script>
