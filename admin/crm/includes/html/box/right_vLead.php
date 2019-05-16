<? if (!empty($_GET['view'])) { ?>

<div class="right-search">
  <h4><span class="icon"></span>
    <? 
if(empty($arryLead[0]['company'])) {
	echo stripslashes($arryLead[0]['FirstName'])." ".stripslashes($arryLead[0]['LastName']);
}else{
	echo stripslashes($arryLead[0]['company']);
}

?>

  </h4>
  <div class="right_box">
    <? if($ModifyLabel==1){?>
    <ul class="rightlink">
      <li <?=($_GET['tab']=="Lead")?("class='active'"):("");?>><a onclick="return LoaderSearch();" href="<?=$ViewUrl?>Lead"><b>Lead Details</b></a></li>
	<?if(in_array('136',$arryMainMenu)){?>
      <li <?=($_GET['tab']=="Event")?("class='active'"):("");?>><a onclick="return LoaderSearch();" href="<?=$ViewUrl?>Event"><b>Schedule Event</b></a></li>
	<?}?>
      <!--<li <?=($_GET['tab']=="Task")?("class='active'"):("");?>><a href="<?=$ViewUrl?>Task"><b>Task</b></a></li>-->
      <!--<li <?=($_GET['tab']=="Ticket")?("class='active'"):("");?>><a href="<?=$ViewUrl?>Ticket"><b>Ticket</b></a></li>-->

      <?if(in_array('106',$arryMainMenu)){?>
      <li <?=($_GET['tab']=="Campaign")?("class='active'"):("");?>><a onclick="return LoaderSearch();" href="<?=$ViewUrl?>Campaign"><b>Campaign</b></a></li>
     <? }?>
      <li <?=($_GET['tab']=="Comments")?("class='active'"):("");?>><a onclick="return LoaderSearch();" href="<?=$ViewUrl?>Comments "><b>Comment </b></a></li>
      <li <?=($_GET['tab']=="ConvertLead")?("class='active'"):("");?>><a  class="fancybox" href="#Convert_div"><b>Convert Lead</b></a></li>
      <?if(in_array('105',$arryMainMenu)){?>
<li <?=($_GET['tab']=="Document")?("class='active'"):("");?>><a onclick="return LoaderSearch();" href="<?=$ViewUrl?>Document "><b> Document</b></a></li>
	<?}?>
	 <?if(in_array('2025',$arryMainMenu) && !empty($arryLead[0]['primary_email'])){
	$EmailUrl="vLead.php?view=".$_GET['view']."&module=".$_GET["module"]."&tab=Email";

?>
<li <?=($_GET['tab']=="Email")?("class='active'"):("");?>><a onclick="return LoaderSearch();" href="<?=$EmailUrl?>"><b> Email</b></a></li>
 
	<?}?>
<li <?=($_GET['tab']=="call")?("class='active'"):("");?>><a onclick="return LoaderSearch();" href="<?=$ViewUrl?>call"><b>Call Details</b></a></li>
    </ul>
    <? } else{?>
    <ul class="rightlink">
      <li <?=($_GET['tab']=="Lead")?("class='active'"):("");?>><a href="<?=$ViewUrl?>Lead"><b>Lead Details</b></a></li>
      <!-- <li <?=($_GET['tab']=="Event")?("class='active'"):("");?>><a href="<?=$ViewUrl?>Event"><b>Event</b></a></li>-->
      <!--<li <?=($_GET['tab']=="Task")?("class='active'"):("");?>><a href="<?=$ViewUrl?>Task"><b>Task</b></a></li>-->
      <!--<li <?=($_GET['tab']=="Ticket")?("class='active'"):("");?>><a href="<?=$ViewUrl?>Ticket"><b>Ticket</b></a></li>-->
      <li <?=($_GET['tab']=="Campaign")?("class='active'"):("");?>><a class="fancybox" href="#alert_div"><b>Campaigns</b></a></li>
      <li <?=($_GET['tab']=="Comments")?("class='active'"):("");?>><a class="fancybox" href="#alert_div"><b>Comments</b></a></li>
      <li <?=($_GET['tab']=="ConvertLead")?("class='active'"):("");?>><a class="fancybox" href="#alert_div"><b>Convert Lead</b></a></li>
      <li <?=($_GET['tab']=="Document")?("class='active'"):("");?>><a class="fancybox" href="#alert_div"><b> Document</b></a></li>
<li <?=($_GET['tab']=="call")?("class='active'"):("");?>><a class="fancybox" href="#alert_div"><b> Call Details</b></a></li>
    </ul>
    <? }	?>
  </div>
  <h4>
  <font color="darkred" style="font-size:11px;">
  <?  if($arryLead[0]['created_by']=='admin'){ ?>
  <?php echo "Created By : Administrator on ".date($Config['DateFormat'],strtotime($arryLead[0]['UpdatedDate'])).""; ?>
  <? } else{
	 echo "Created By : ".$createdEMP[0]['UserName']." on ".date($Config['DateFormat'],strtotime($arryLead[0]['UpdatedDate'])).""; 
	/*echo "<pre>";
	print_r($arryLead);*/
	}?>
  </font>
  </h4>
</div>
<? }else{
	$SetInnerWidth=1;
} ?>
