<? if (!empty($_GET['view'])) { ?>

<div class="right-search">
  <h4><span class="icon"></span>
   <font color="darkred"> Campaign [<?=$arryCampaign[0]['campaignID']?>] : <?php echo stripslashes($arryCampaign[0]['campaignname']); ?> </font>  
  </h4>
  <div class="right_box">
   <ul class="rightlink">	
      	<?//if(in_array('136',$arryMainMenu)){?>	
        <!--li <?=($_GET['tab']=="Event")?("class='active'"):("");?>><a onclick="return LoaderSearch();" href="<?=$ViewUrl?>Event"><b>Schedule Event</b></a></li-->
       <?//}?>
        <li <?=($_GET['tab']=="Campaign")?("class='active'"):("");?>><a onclick="return LoaderSearch();" href="<?=$ViewUrl?>Campaign"><b>Campaign Detail</b></a></li>
 <li <?=($_GET['tab']=="MCampaign")?("class='active'"):("");?>><a onclick="return LoaderSearch();" href="<?=$ViewUrl?>MCampaign"><b>Mass Mail Campaign</b></a></li>
         <?if(in_array('105',$arryMainMenu)){?>
       
        <li <?=($_GET['tab']=="Document")?("class='active'"):("");?>><a onclick="return LoaderSearch();" href="<?=$ViewUrl?>Document"><b>Document</b></a></li>
	<?}?>
	</ul>
  </div>

<h4> <font color="darkred" style="font-size:11px;">

    
    					
<?php echo "Created By : ".$createdEMP[0]['UserName']."   on ".date($Config['DateFormat'],strtotime($arryCampaign[0]['created_time'])).""; ?>
								
							
    
    </font><h4>
  
  
</div>


<? }else{
	$SetInnerWidth=1;
}
 ?>
