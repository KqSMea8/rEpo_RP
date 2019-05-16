<? if (!empty($_GET['view'])) { ?>

<div class="right-search">
  <h4><span class="icon"></span>
    <?php echo stripslashes($arryOpportunity[0]['OpportunityName']); ?> 
  </h4>
  <div class="right_box">
   
	<ul class="rightlink">	
    
    <li <?=($_GET['tab']=="Opportunity")?("class='active'"):("");?>><a href="<?=$ViewUrl?>Opportunity"><b>Opportunity Details</b></a></li>
    <li <?=($_GET['tab']=="Lead")?("class='active'"):("");?>><a onclick="return LoaderSearch();" href="<?=$ViewUrl?>Lead"><b>Lead</b></a></li>	
         <?if(in_array('104',$arryMainMenu)){?>  
        <li <?=($_GET['tab']=="Ticket")?("class='active'"):("");?>><a onclick="return LoaderSearch();" href="<?=$ViewUrl?>Ticket"><b>Ticket</b></a></li>
	<? } ?>
	 <?if(in_array('106',$arryMainMenu)){?>
         <li <?=($_GET['tab']=="Campaign")?("class='active'"):("");?>><a onclick="return LoaderSearch();" href="<?=$ViewUrl?>Campaign"><b>Campaign</b></a></li>  
	<? } ?>
         <li <?=($_GET['tab']=="Comments ")?("class='active'"):("");?>><a onclick="return LoaderSearch();" href="<?=$ViewUrl?>Comments "><b>Comments</b></a></li> 
	
	 <?if(in_array('105',$arryMainMenu)){?>
	<li <?=($_GET['tab']=="Document")?("class='active'"):("");?>><a onclick="return LoaderSearch();" href="<?=$ViewUrl?>Document "><b>Document</b></a></li>
	<?}?>
	<?if(in_array('136',$arryMainMenu)){?>	
           <li <?=($_GET['tab']=="Event")?("class='active'"):("");?>><a onclick="return LoaderSearch();" href="<?=$ViewUrl?>Event"><b>Schedule Event</b></a></li>
  	<? }?>
	<li><a href="javascript:ConvertConfirm();"><b>Convert To customer</b></a></li><!--By chetan 4DEc-->
	</ul>
  </div>
</div>
<? }else{
	$SetInnerWidth=1;
} ?>
