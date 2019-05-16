<?
$arryTicket=$objLead->GetDashboardTicket();
?>
<div class="second_col" style="<?=$WidthRow2?>">
            <div class="block p_l_request">

              <h3>Open and In progress Ticket</h3>
              <div class="bgwhite">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
	 <?php  
	if(sizeof($arryTicket)>0){
		$flag=true;
		$Line=0;
		foreach($arryTicket as $key=>$Ticket){
		$flag=!$flag;
		#$bgcolor=($flag)?("#FDFBFB"):("");
		$Line++;
		?>
                <tr>
                  <td ><a href="vTicket.php?module=Ticket&view=<?=$Ticket['TicketID']?>"><?=substr(stripslashes($Ticket['title']),0,35)?></a></td>
                </tr>
<? } ?>

<tr>
                  <td><font color="darkred" ><a href="viewTicket.php?module=Ticket">More..</a></font></td>
                </tr>

<? } else{?>
                <tr>
                  <td><font color="darkred" >No Ticket Found</font></td>
                </tr>

<? }?>
                
                
              </table>

              </div>
		

            </div>
		
          </div>
