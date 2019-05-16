<? if (!empty($_GET['view'])) { ?>

<div class="right-search">
  <h4><span class="icon"></span>
    <?=stripslashes($arryQuote[0]['subject'])?> 
  </h4>
  <div class="right_box">
   <ul class="rightlink">	
       <li <?=($_GET['tab']=="Quote")?("class='active'"):("");?>><a onclick="return LoaderSearch();" href="<?=$ViewUrl?>"><b>Quote Details</b></a></li>
        
         <?if(in_array('104',$arryMainMenu)){?>  
        <li <?=($_GET['tab']=="Ticket")?("class='active'"):("");?>><a onclick="return LoaderSearch();" href="<?=$ViewUrl?>Ticket"><b>Ticket</b></a></li>
	<? }?>

	<?if(in_array('106',$arryMainMenu)){?>
         <li <?=($_GET['tab']=="Campaign")?("class='active'"):("");?>><a onclick="return LoaderSearch();" href="<?=$ViewUrl?>Campaign"><b>Campaign</b></a></li>  
         <?}?>
        <?if(in_array('105',$arryMainMenu)){?>
        <li <?=($_GET['tab']=="Document")?("class='active'"):("");?>><a onclick="return LoaderSearch();" href="<?=$ViewUrl?>Document"><b>Document</b></a></li>
	<? } ?>
	<?if(in_array('136',$arryMainMenu)){?>	
<li <?=($_GET['tab']=="Event")?("class='active'"):("");?>><a onclick="return LoaderSearch();" href="<?=$ViewUrl?>Event"><b>Schedule Event</b></a></li>
	<?}?>
	
	</ul>
  </div>
	


</div>
<? }else{
	$SetInnerWidth=1;
} ?>
