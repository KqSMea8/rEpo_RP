
    <link href='fullcalendar/fullcalendar.css' rel='stylesheet' />
<link href='fullcalendar/facebook-page.css' rel='stylesheet' />
<link href='fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
<link href="fullcalendar/search-box.css" type="text/css" rel="stylesheet" media="screen" />
<style>
    #searchbox
{
background: rgba(117,207,240,0.97);
background: -moz-linear-gradient(top, rgba(117,207,240,0.97) 0%, rgba(117,207,240,0.99) 0%, rgba(117,207,240,1) 99%, rgba(117,207,240,1) 100%);
background: -webkit-gradient(left top, left bottom, color-stop(0%, rgba(117,207,240,0.97)), color-stop(0%, rgba(117,207,240,0.99)), color-stop(99%, rgba(117,207,240,1)), color-stop(100%, rgba(117,207,240,1)));
background: -webkit-linear-gradient(top, rgba(117,207,240,0.97) 0%, rgba(117,207,240,0.99) 0%, rgba(117,207,240,1) 99%, rgba(117,207,240,1) 100%);
background: -o-linear-gradient(top, rgba(117,207,240,0.97) 0%, rgba(117,207,240,0.99) 0%, rgba(117,207,240,1) 99%, rgba(117,207,240,1) 100%);
background: -ms-linear-gradient(top, rgba(117,207,240,0.97) 0%, rgba(117,207,240,0.99) 0%, rgba(117,207,240,1) 99%, rgba(117,207,240,1) 100%);
background: linear-gradient(to bottom, rgba(117,207,240,0.97) 0%, rgba(117,207,240,0.99) 0%, rgba(117,207,240,1) 99%, rgba(117,207,240,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#75cff0', endColorstr='#75cff0', GradientType=0 );

    border-radius: 35px;    
    border-width: 1px;
    border-style: solid;
    border-color: #c4d9df #a4c3ca #83afb7;            
    width: 500px;
    height: 35px;
    padding: 10px;
    margin-top: 20px;
   /* margin: 100px auto 50px;*/
    overflow: hidden; /* Clear floats */
}
/*
Below you can see the current result:

Form wrapper styles
Inputs styles
*/
#search, 
#submit {
    float: left;
}

#search {
    padding: 5px 9px;
    height: 23px;
    width: 380px;
    border: 1px solid #a4c3ca;
    font: normal 13px 'trebuchet MS', arial, helvetica;
    background: #fff;
    border-radius: 50px 3px 3px 50px;
    /*box-shadow: 0 1px 3px rgba(0, 0, 0, 0.25) inset, 0 1px 0 rgba(255, 255, 255, 1);*/            
}

/* ----------------------- */

#submit
{       

background: rgba(241,109,34,1);
background: -moz-linear-gradient(top, rgba(241,109,34,1) 0%, rgba(245,144,31,1) 0%, rgba(248,80,50,1) 100%);
background: -webkit-gradient(left top, left bottom, color-stop(0%, rgba(241,109,34,1)), color-stop(0%, rgba(245,144,31,1)), color-stop(100%, rgba(248,80,50,1)));
background: -webkit-linear-gradient(top, rgba(241,109,34,1) 0%, rgba(245,144,31,1) 0%, rgba(248,80,50,1) 100%);
background: -o-linear-gradient(top, rgba(241,109,34,1) 0%, rgba(245,144,31,1) 0%, rgba(248,80,50,1) 100%);
background: -ms-linear-gradient(top, rgba(241,109,34,1) 0%, rgba(245,144,31,1) 0%, rgba(248,80,50,1) 100%);
background: linear-gradient(to bottom, rgba(241,109,34,1) 0%, rgba(245,144,31,1) 0%, rgba(248,80,50,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f16d22', endColorstr='#f85032', GradientType=0 );

    border-radius: 3px 50px 50px 3px;    
    border-width: 1px;
    border-style: solid;
    /*border-color: #7eba7c #578e57 #447d43;*/
    border-color: #d68356 #f16e22 #f05c23;
    box-shadow: 0 0 1px rgba(0, 0, 0, 0.3), 
                0 1px 0 rgba(255, 255, 255, 0.3) inset;
    height: 35px;
    margin: 0 0 0 10px;
    padding: 0;
    width: 90px;
    cursor: pointer;
    font: bold 14px Arial, Helvetica;
    color: #fff;    
    text-shadow: 0 1px 0 rgba(255,255,255,0.5);
}

#submit:hover {       
    
background: rgba(240,47,23,1);
background: -moz-linear-gradient(top, rgba(240,47,23,1) 0%, rgba(241,111,92,1) 0%, rgba(248,80,50,1) 0%, rgba(245,144,31,1) 100%);
background: -webkit-gradient(left top, left bottom, color-stop(0%, rgba(240,47,23,1)), color-stop(0%, rgba(241,111,92,1)), color-stop(0%, rgba(248,80,50,1)), color-stop(100%, rgba(245,144,31,1)));
background: -webkit-linear-gradient(top, rgba(240,47,23,1) 0%, rgba(241,111,92,1) 0%, rgba(248,80,50,1) 0%, rgba(245,144,31,1) 100%);
background: -o-linear-gradient(top, rgba(240,47,23,1) 0%, rgba(241,111,92,1) 0%, rgba(248,80,50,1) 0%, rgba(245,144,31,1) 100%);
background: -ms-linear-gradient(top, rgba(240,47,23,1) 0%, rgba(241,111,92,1) 0%, rgba(248,80,50,1) 0%, rgba(245,144,31,1) 100%);
background: linear-gradient(to bottom, rgba(240,47,23,1) 0%, rgba(241,111,92,1) 0%, rgba(248,80,50,1) 0%, rgba(245,144,31,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f02f17', endColorstr='#f5901f', GradientType=0 );
}   

#submit:active {       
    /*background: #95d788;*/
    background: rgba(241,109,34,1);
    outline: none;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.5) inset;        
}

#submit::-moz-focus-inner {
       border: 0;  /* Small centering fix for Firefox */
}
#search::-webkit-input-placeholder {
   color: #9c9c9c;
   font-style: italic;
}

#search:-moz-placeholder {
   color: #9c9c9c;
   font-style: italic;
}  

#search:-ms-placeholder {
   color: #9c9c9c;
   font-style: italic;
}

input[type="text"] {
                                                    
    margin-left: 0px !important;
    margin-top: 0px !important;
    text-align: left !important;
}

.view-profileIns > a {
    background: url("images/instagramAdd.png") no-repeat scroll 0 0 rgba(0, 0, 0, 0) !important;
    display: inline-block;
	background-size: 24px 24px !important;
    height: 24px;
    padding: 3px;
    width: 24px;}

</style>


<script type="text/javascript" src="multiSelect/jquery.tokeninput.js"></script>
<link rel="stylesheet" href="multiSelect/token-input.css" type="text/css" />
<link rel="stylesheet" href="multiSelect/token-input-facebook.css" type="text/css" />
    
	<script src="jquery-1.10.2.js" type="text/javascript"></script>
<script>
function funG()
{
	var r=confirm("Are you sure you want to mark this tweet as Good?");
	if(r==true)
	{
		return true;		
	}
	else
	{
		return false;
	}	
}
function funB()
{
	var r=confirm("Are you sure you want to mark this tweet as Bad?");
	if(r==true)
	{
		return true;		
	}
	else
	{
		return false;
	}	
}
</script>

<script type="text/javascript">
$(document).ready(function() {
    $("#btnreset").click(function(){
       $(".inputbox").val("");
	   
    }); 
});

</script>

<a class="back" href="<?php echo _SiteUrl?>admin/crm/social_listening.php">Back</a>
<div class="had">Tweets List	
    <a class="fancybox add_quick fblogut" href="twitter_keywords.php" style="float: right;">Keywords</a>
    <a class="fancybox add_quick fblogut" href="twitter_alerts.php" style="float: right;">Alerts</a>
    </div>
    
   <?php $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";?>
	<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
    <? if (!empty($_SESSION['mess_comp'])) {?>
    <tr>
    <td align="center" class="message" >
    <? if(!empty($_SESSION['mess_comp'])) {echo $_SESSION[mess_comp]; unset($_SESSION[mess_comp]); }?>
    </td>
    </tr>
    <? } ?>
	<tr><td>	
    </td></tr>
 	
    <!--tr>	<td align="center"><form action="" method="get"><select name="stype" style=" height:30px">
    <?php //if(isset($_REQUEST['submit'])){?>
    <option value="<?php //echo $_REQUEST['stype'];?>">
	<?php //echo $_REQUEST['stype'];?></option><?php //}?>
    <option value="all">all</option><option value="good">good</option><option value="bad">bad</option></select>
    <input class="inputbox" type="text" placeholder="Search key.." name="s_key" value="<?php //if(isset($_REQUEST['submit']))echo $_REQUEST['s_key'];?>" required/>
    <input type="submit" name="submit" value="Search" style=" padding:4px; background-color:rgb(176, 14, 14); color:#FFF; font-size:13px; cursor:pointer;"> 
     <a href="twitter_lists.php"><input name="reset" type="button" id="btnreset" style=" padding:4px; background-color:rgb(176, 14, 14); color:#FFF; font-size:13px; cursor:pointer;" value="Clear"/></a>
    </form></td>	</tr-->
    
    <tr>	<td align="center" valign="top" id="searchfbbox"></td></tr>
	</table>
 <!--**************************************************-->
 
  <table cellspacing="1" cellpadding="3" width="100%" align="center" id="list_table">
      <tbody>
          <tr align="left">
          <!--td width="1%" class="head1"><a title="Click to sort by ID" href="<?php//echo $_SERVER['PHP_SELF'];?>?page=<?php//echo $page;?>&sort_element=id&sort_type=<?php//echo ($_REQUEST["sort_element"] == "id"  && $_REQUEST["sort_type"] == "asc") ? "desc" : "asc"; ?>">ID</a></td-->  
          <td width="5%" align="center" class="head1">Name</td>	<td width="20%" align="center" class="head1">Tweets</td>
          <td width="3%" align="center" class="head1 head1_action">Location</td>
          <td width="3%" align="center" class="head1 head1_action">Tweet Type</td>
          <td width="5%" align="center" class="head1 head1_action">Action</td>
      	</tr>
		<?php 
		if(!empty($list_row))
		{
        foreach($list_row as $row)//while($row = mysqli_fetch_assoc($q))
        {?>
           <tr bgcolor="#FFFFFF" align="left" class="evenbg"> 
           <!--td><?php//echo $row['id']; ?> </td-->
           <td align="center">	<?php if(isset($row['name']))echo $row['name'];else echo '<span class="red">Not Specified</span>';?></td>	
           <td align="center"><?php if(isset($row['tweet_text']))echo $row['tweet_text'];else echo '<span class="red">Not Specified</span>'; ?> </td>	
            
            <td align="center" class="head1_inner">	<span ><?php if(isset($row['location']))echo $row['location'];else echo '<span class="red">Not Specified</span>';?></span> </td>
            <td align="center" class="head1_inner">	
			<?php if($row['tweet_type']=='good')echo '<span style="color:green; text-transform:capitalize;">';else echo '<span style="color:red; text-transform:capitalize;">';?><?php echo $row['tweet_type'].'</span>'; ?>
			</td>
           	<td align="center" class="head1_inner">
            <?php if($row['tweet_type']=='good'){?> <a onClick="return funB();" style=" color:#ffffff;background: #d40503; border: medium none; border-radius: 2px 2px 2px 2px; padding:4px; font-weight:bold;" href='<?php echo $_SERVER['PHP_SELF'];?>?page=<?php echo $page;?>&Gid=<?php echo $row['id'];?>'>Mark as Bad</a>
			<?php }
		   else {?><a onClick="return funG();" style=" color:#ffffff; background-color:#81bd82; border: medium none;
  border-radius: 2px 2px 2px 2px; padding:4px; font-weight:bold;" href='<?php echo $_SERVER['PHP_SELF'];?>?page=<?php echo $page;?>&Bid=<?php echo $row['id'];?>'>Mark as Good</a>		
  			<?php 		
		   	}?>
           </td>
           </tr>
         <?php }}else{?>   
         <tr bgcolor="#FFFFFF" align="left" class="evenbg"><td colspan="6"> <span class="red">No tweets found..</span></td></tr>
		 <?php }?>                    
           <tr> 
	 		<td  colspan="11" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($list_row) > 0) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;}?>
		 	</td>
       	  </tr>
       </tbody></table>