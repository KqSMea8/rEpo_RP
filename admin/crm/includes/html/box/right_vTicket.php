<? if (!empty($_GET['view'])) { ?>

<div class="right-search">
  <h4><span class="icon"></span>
   <font color="darkred"> Ticket [<?=$arryTicket[0]['TicketID']?>] : <?php echo stripslashes($arryTicket[0]['title']); ?> </font>  
  </h4>
  <div class="right_box">
   <ul class="rightlink">	
      	<?if(in_array('136',$arryMainMenu)){?>	
        <li <?=($_GET['tab']=="Event")?("class='active'"):("");?>><a onclick="return LoaderSearch();" href="<?=$ViewUrl?>Event"><b>Schedule Event</b></a></li>
       <?}?>
         <?if(in_array('105',$arryMainMenu)){?>
        <li <?=($_GET['tab']=="Document")?("class='active'"):("");?>><a onclick="return LoaderSearch();" href="<?=$ViewUrl?>Document"><b>Document</b></a></li>
	<?}?>
	</ul>
  </div>

<h4> <font color="darkred" style="font-size:11px;">
    <?  

if($arryTicket[0]['created_by']=='admin'){ ?>
    
    					
<?php echo "Created By : Administrator on ".date($Config['DateFormat'],strtotime($arryTicket[0]['ticketDate'])).""; ?>
								
							
    <? } else{


	 echo "Created By : ".$createdEMP[0]['UserName']." on ".date($Config['DateFormat'],strtotime($arryTicket[0]['ticketDate'])).""; 
	/*echo "<pre>";
	print_r($arryLead);*/
	}?>
    </font><h4>
  
  
</div>


<? }else{
	$SetInnerWidth=1;
} ?>
