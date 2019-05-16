<!--a class="back" href="<?=$RedirectUrl?>">Back</a--> 
<?
if(!empty($ErrorMSG)){
	 echo '<div class="redmsg" align="center">'.$ErrorMSG.'</div>';
}else{ ?>

<div class="had"><?=$ModuleName?> Detail</div>

<table width="100%"  border="0" cellpadding="0" cellspacing="0">

   <tr>
    <td  align="center" valign="top" height="300" >


		<?	include("includes/html/box/request_view.php"); ?>
	
	</td>
   </tr>
</table>

 <? } ?>

