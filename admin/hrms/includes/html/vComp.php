<? if($_GET['pop']!=1){ ?>
<a class="back" href="<?=$RedirectUrl?>">Back</a> 
<? } ?>
<?
if(!empty($ErrorMSG)){
	 echo '<div class="redmsg" align="center">'.$ErrorMSG.'</div>';
}else{ ?>

<div class="had">
<? if($_GET['pop']!=1){ ?>
<?=$MainModuleName?>   <span> &raquo; <?=$ModuleName?> Detail </span>
<? }else{ ?>
<?=$ModuleName?> Detail
<? }?>
</div>

<table width="100%"  border="0" cellpadding="0" cellspacing="0">

   <tr>
    <td  align="center" valign="top" >


		<?	include("includes/html/box/comp_view.php"); ?>
	
	</td>
   </tr>
</table>

 <? } ?>

