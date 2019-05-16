
<link href='fullcalendar/fullcalendar.css' rel='stylesheet' />
<link href='fullcalendar/socialfbtwlin.css' rel='stylesheet' />
<link href='fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
<style>

		
	#loading {
		position: absolute;
		top: 5px;
		
		right: 5px;
		}

	#calendar {
		width: 100%;
		margin: 0 auto;
		}
		.fc-event-title{
		 color:#FFFFFF;
		}
		
		.fc-event-inner .fc-event-time{ color:#FFFFFF;}
                
                a.Send{background: #81bd82;border: medium none;border-radius: 2px 2px 2px 2px;color: #FFFFFF;cursor: pointer; font-size: 12px;line-height: normal;padding: 1px 9px 2px 9px;}
    a.Unsend{background: #d40503;border: medium none;border-radius: 2px 2px 2px 2px;color: #FFFFFF;cursor: pointer; font-size: 12px;line-height: normal;padding: 1px 3px 2px 3px;}

    
*, *::before, *::after {
    box-sizing: border-box;
}
*, *::before, *::after {
    box-sizing: border-box;
}
    .sub-section::after {
    clear: both;
}
.sub-section::before, .sub-section::after {
    content: " ";
    display: table;
}
.sub-section {
    margin-bottom: 30px;
}
    
    .unit {

        background-clip: padding-box !important;
        float: left;
        overflow: hidden;
        width: 48%;
    }

    .meter-data {
        vertical-align: bottom;
    }
    .full-width {
        max-width: 100% !important;
        width: 100%;
    }
    .alignr {
        text-align: right;
    }
    .nomargin {
        margin: 0 !important;
    }
    .meter {
        background: none repeat scroll 0 0 #e0e0e0;
        border-radius: 2px;
        height: 13px;
        margin: 7px 0 30px;
        overflow: hidden;
        position: relative;

    }

    .meter > span {
        -moz-border-bottom-colors: none;
        -moz-border-left-colors: none;
        -moz-border-right-colors: none;
        -moz-border-top-colors: none;
        border-color: -moz-use-text-color -moz-use-text-color #95d1c4;
        border-image: none;
        border-style: none none solid;
        border-width: medium medium 13px;
        display: block;
        height: 100%;
        overflow: hidden;
        position: relative;
        border-color: #95d1c4;
    }

    .lastUnit, .lastGroup {
        float: right;
        width: 48%;
    }

    .p.fwb.float-left.nomargin {
        float: left;
    }
    .stat-block:first-child {
        border-left: 1px solid #d9d9d9;
        border-radius: 6px 0 0 6px;
    }
    .stat-block {
        -moz-border-bottom-colors: none;
        -moz-border-left-colors: none;
        -moz-border-right-colors: none;
        -moz-border-top-colors: none;
        border-color: #d9d9d9 #d9d9d9 #d9d9d9 -moz-use-text-color;
        border-image: none;
        border-style: solid solid solid none;
        border-width: 1px 1px 1px 0;
        padding-bottom: 1.8125em;
        padding-top: 1.8125em;
    }
    .size1of4 {
        width: 25%;
    }
   .stat-block:last-child {
    border-radius: 0 6px 6px 0;
}
.unit {
    padding-left: 15px;
    padding-right: 15px;
}
.size1of1 {
    width: 100%;
}

.fwb {
    float: right;
}
.leaders li {
background: url("images/mass_bg_leaders.png") repeat-x scroll 0 17px transparent;
line-height: 1.6em;
    margin-bottom: 0.8em;
}
.leaders li > span {
    background-color: #fff;
    font-size: 16px;
}
.leaders li > span:first-child {
    padding-right: 12px;
}

.fwb > a {
    font-size: 16px;
    color:#000;
}


</style>

<script type="text/javascript" src="multiSelect/jquery.tokeninput.js"></script>
<link rel="stylesheet" href="multiSelect/token-input.css" type="text/css" />
<link rel="stylesheet" href="multiSelect/token-input-facebook.css" type="text/css" />
</head>
<body>
<div id="Event" >
<? if($ModifyLabel==1){?>
<form name="form1" action=""  method="post" onSubmit="return validate(this);" enctype="multipart/form-data">
	<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">

	  <?php if(!empty($MailchimSetting)) { ?>
		<tr>
		<td align="right">
                <a class="fancybox add_quick" href="ViewchimpCampaign.php">Campaign</a>
                <a class="fancybox add_quick" href="viewchimpTemplate.php">Template</a>
		<a class="fancybox add_quick" href="viewchimpSegment.php">Segment</a>
		<a class="fancybox add_quick" href="viewchimpUser.php">User</a>
		</td>
		</tr>
	  <?php } ?>
	  
	    <tr>
		<td  align="center"  class="message" colspan="2" >
		<? if(!empty($_SESSION['mess_mass'])) {echo $_SESSION['mess_mass']; unset($_SESSION['mess_mass']); }?>	
		</td>
		</tr>
                <?php if(!empty($LastRentCmpID[0]['campaign_id']) && !empty($viewsummer)){ ?>
	<tr>
            <td  valign="top">
                <div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
                <div id="preview_div">
                    <h1>Recently sent campaign</h1>
                    <h2><?php echo $GetcampaignSummery[0]['title']; ?></h2>
                    <h3><?php echo 'Subject:&nbsp;' . $GetcampaignSummery[0]['subject']; ?></h3>
                    <h4><?php echo $viewsummer['emails_sent'] . '&nbsp;Recipients'; ?></h4>

                    <div class="sub-section"> 
                        <div class="unit size1of2 maintain-width"> 
                            <div class="meter-data full-width selfclear nomargin alignr"> 
                                <span class="p fwb float-left nomargin">Open rate</span> <span class="h3 fsn nomargin">
                                    <a title="View" href="#"><?php echo $Openrate; ?></a>
                                </span> 
                            </div> 
                            <div class="meter"> 
                                <span style="width: <?php echo $OpenrateWidth; ?>; height: auto;">
                                </span> 
                            </div> 
                            <!--<ul class="leaders">
                                <li> <span>List average</span> <span class="fwb">35.7%</span> </li> 
                                <li> <span>Industry average (<a href="/account/details">Software and Web App</a>)</span> <span class="fwb">15.4%</span> </li> 
                            </ul> -->
                        </div> 
                        <div class="lastUnit size1of2"> 
                            <div class="meter-data full-width selfclear nomargin alignr"> 
                                <span class="p fwb float-left nomargin">Click rate</span> 
                                <span class="h3 fsn nomargin">
                                    <?php echo $viewsummer['clicks']; ?> 
                                </span> 
                            </div> 
                            <div class="meter"> 
                                <span style="width:0%"></span> 
                            </div> 
                            <!--<ul class="leaders"> 
                                <li> <span>List average</span> <span class="fwb">0.0%</span> </li> 
                                <li> <span>Industry average (<a href="/account/details">Software and Web App</a>)</span> <span class="fwb">1.2%</span> </li> 
                            </ul>--> 
                        </div> 
                    </div>
                    <div class="sub-section"> 
                        <div class="size1of1"> 
                            <div class="stat-block alignc unit size1of4"> 
                                <h3 class="fsn nomargin">
                                    <?php echo $viewsummer['unique_opens']; ?> 
                                </h3> <p>Unique Opened</p>  
                            </div> 
                            <div class="stat-block alignc unit size1of4"> 
                                <h3 class="fsn nomargin">
                                    <?php echo $viewsummer['clicks']; ?>
                                </h3> <p>Clicked</p>  </div> 
                            <div class="stat-block alignc unit size1of4"> 
                                <h3 class="fsn nomargin">
                                    <?php echo $viewsummer['soft_bounces']+$viewsummer['hard_bounces']; ?>
                                </h3> <p>Bounced</p> 
                            </div> 
                            <div class="stat-block alignc unit size1of4"> 
                                <h3 class="fsn nomargin">
                                    <?php echo $viewsummer['unsubscribes']; ?>
                                </h3> <p>Unsubscribed</p> 
                            </div> 
                        </div> 
                    </div>
                    <div class="sub-section"> 
                        <div class="unit size1of2"> 
                            <ul class="leaders"> 
                                <li> <span>Successful deliveries</span> 
                                    <span class="fwb"><?php echo $viewsummer['emails_sent']; ?></span> 
                                </li> 
                                <li> <span>Total opens</span> 
                                    <span class="fwb">
                                      <a title="View" href="#"><?php echo $viewsummer['opens']; ?></a> 
                                    </span>  </li> 
                                <li> <span>Last opened</span> <span class="fwb"><?php //echo strtotime($viewsummer['last_open']);
                                if(!empty($viewsummer['last_open'])){
                                echo date('D, j-M-y, h:i:s A', strtotime($viewsummer['last_open']));
                                  } else {
                                      echo '<span class="red">Not specified.</span>';
                                  }
                                
                                ?></span> </li> 
                                <li> <span>Forwarded</span> <span class="fwb"><?php echo $viewsummer['forwards']; ?></span> </li>  
                            </ul> 
                        </div> 
                        <div class="lastUnit size1of2"> 
                            <ul class="leaders"> 
                                <li> <span>Clicks per unique opens</span> <span class="fwb">
                                                  <?php echo $viewsummer['unique_clicks']; ?> 
                                            </span>  
                                </li> 
                                <li> <span>Total clicks</span> <span class="fwb">
                                                    <?php echo $viewsummer['clicks']; ?> 
                                            </span>  
                                </li>  
                                <li> <span>Abuse reports</span> 
                                    <span class="fwb"><?php echo $viewsummer['abuse_reports']; ?> </span>  
                                </li> 
                            </ul> 
                        </div> 
                    </div>
                </div> 
            </td>
        </tr>
                <?php } ?>
	   <!--  start Create Account in MailChim -->
	   <?php if(empty($MailchimSetting)) { ?>
	
		<tr>
		  <td colspan="2" align="left"  class="head" >Create Account in MailChimp</td>
		</tr>

		<tr>
		<td  align="right" width="40%"   class="blackbold"> Name : </td>
		<td   align="left" >
		<input name="name" type="text" class="inputbox" id="name">
		</td>
		</tr>
	 
	  <tr>
		<td align="center" colspan="2" >
		<input name="Submit" type="submit" class="button" id="SubmitButton" value="Submit" />
		</td>
	 </tr>
	 
	 <!--  end Create Account in MailChim -->
	   <?php } ?>
	</table>
	</form>
<? }else{?>

<div class="redmsg" align="center">Sorry, you are not authorized to access this section.</div>
<? }?>
</div>




