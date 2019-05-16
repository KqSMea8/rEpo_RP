
<?
$arryTopOpp=$objLead->GetDashboardOpportunity();

$arryTopOppCount =$objLead->GetDashboardOpportunityCount();

?>
<div class="second_col" style="<?=$WidthRow2?>">
 <div class="block p_l_request">   

  
  
  <h3>Top Opportunities</h3>
  <div class="bgwhite">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <thead>
        <tr class="head"> 	
          <td class="darkcolor">Opportunity Name</td>
          <td class="darkcolor">Amount</td>
        </tr>
      </thead>
      <?php 
      if(sizeof($arryTopOpp)>0){
        $flag=true;
        $Line=0;
        $count=0;
        



        foreach($arryTopOpp as $key=>$opportunity){
          $flag=!$flag;
						#$bgcolor=($flag)?("#FDFBFB"):("");
          $Line++;


          
          $dtA = date("Y-m-d");
          if($opportunity['view_status'] != 1){
            $count++;
            $image= '<img style="width: 37px;" src="../images/new-ani.gif" class="close_call"> ';
          }else {
            $image='';
          }
          ?>
          <tbody>
           <? echo '<tr class="even">
           <td>'.$image.'<a href="vOpportunity.php?view='.$opportunity['OpportunityID'].'&module=Opportunity&curP=1">'.substr(stripslashes($opportunity['OpportunityName']),0,20).' </a></td>
           <td ><a href="vOpportunity.php?view='.$opportunity['OpportunityID'].'&module=Opportunity&curP=1">'.$Config['Currency'].' '.$opportunity['AmountVal'].'</a></td>
         </tr>'; ?>
         
         <? } ?>
         <tr>

           <?php $totalCount = $arryTopOppCount[0]['OppCount']- $count ;

           if($totalCount){
            ?>

          <td  colspan="2">
       <span style="color:red; ">  <?php echo $totalCount; ?> </span> <a href="viewOpportunity.php?module=Opportunity">More..</a>
         </td>

         <?php  } ?>
       </tr>
       <? } else{?>
       <tr>
        <td  colspan="2">
         <font color="darkred" >No Data Found.</font>
       </td>
     </tr>
     <? }?>
     
   </table>
 </div>


</div>
</div>
