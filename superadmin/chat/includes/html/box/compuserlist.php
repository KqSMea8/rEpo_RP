 
 	<div class="message" align="center"><? if(!empty($_SESSION['mess_company'])) {echo $_SESSION['mess_company']; unset($_SESSION['mess_user']); }?></div>
<!--<div><a href="#" class="back">Back</a></div>
--><TABLE WIDTH="100%" BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0>
	<tr>
		<td valign="top">
		<form action="" method="post" name="form1">
		<div id="prv_msg_div" style="display: none"><img
			src="images/loading.gif">&nbsp;Searching..............</div>
		<div id="preview_div">
 <!----------------------------    search ------------------- -->
 
 <div class="search">
 <!--  <h3><span class="icon"></span>Search</h3>-->
 <form class="admin_r_search_form" action="" method="Post" enctype="multipart/form-data" name="form2" onSubmit="return LoaderSearch();">
<fieldset>
  <label><strong>Search :</strong> </label>
<input type="text" name="find" class="inputbox"/>            
<input type="submit" name="submit"  value="Submit" class="button" />
</fieldset>
 </form>
 </div>
 <!-------------------------- end Search  ------------------------------>
		<table <?=$table_bg?>>

			<tr align="left">
				<td width="15%" class="head1">UserName</td>
				<td width="15%" class="head1">UserContacts</td>
				<td class="head1" width="8%">Email</td>
				<td width="6%" align="center" class="head1">Company Code</td>
			</tr>

			<?php

			if(!empty($arrycompUser)){
				$num =0;
				foreach($arrycompUser as $key=>$values){
					$num++;
					?>
					
			<tr align="left" bgcolor="<?=$bgcolor?>">
				<td height="50"><strong><?=stripslashes($values->userFname);?></strong></td>
				<td><?=$values->userContacts;?></td>
				<td><?  echo '<a href="mailto:'.$values->userEmail.'">'.$values->userEmail.'</a>'; ?></td>
				<td><?=$values->userCompcode;?></td>
				
			</tr>
			<?php } // foreach end //?>

			<?php }else{?>
			<tr align="center">
				<td colspan="9" class="no_record">No record found.</td>
			</tr>
			<?php } ?>

			<tr>
				<td colspan="9">Total Record(s) : &nbsp;<?php echo $num;?> </td>
			</tr>
		</table>

		</div>
		  <input type="hidden" name="CurrentPage" id="CurrentPage"
			value="<?php echo $_GET['curP']; ?>"> <input type="hidden" name="opt"
			id="opt" value="<?php echo $ModuleName; ?>"></form>
		</td>
	</tr>
</table>

