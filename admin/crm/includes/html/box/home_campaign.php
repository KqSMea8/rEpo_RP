<div class="second_col" style="<?=$WidthRow2?>">
            <div class="block p_timesheets">
              <h3>Active Campaign</h3>
              <div class="bgwhite">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
 <?php  
$arryCompaign=$objLead->GetDashboardCompaign();
	if(sizeof($arryCompaign)>0){
		$flag=true;
		$Line=0;
		foreach($arryCompaign as $key=>$Compaign){
		$flag=!$flag;
		#$bgcolor=($flag)?("#FDFBFB"):("");
		$Line++;
		?>
                <tr>
                  <td><a href="vCampaign.php?view=<?=$Compaign['campaignID']?>&module=Campaign"><?=substr(stripslashes($Compaign['campaignname']),0,35)?></a></td>
                </tr>
<? }?>

<tr>
                  <td><a href="viewCampaign.php?module=Campaign">More..</a></td>
                </tr>

<?}else{?>
                <tr>
                  <td><font color="darkred" >No Compaign Found.</font></td>
                </tr>
<? }?>
          
                
              </table>

              </div>
            </div>
          </div>
