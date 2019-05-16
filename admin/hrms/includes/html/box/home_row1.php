<? 
	$arryNews = $objCommon->getActiveNews(20); 
?>
<div class="rows clearfix">
          <div class="first_col" style="<?=$WidthRow1?>">
            <div class="block information">
              <h3>My Information</h3>
			  <div class="bgwhite">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <? if($ShowEmp==1){ ?>
				<tr class="odd">
                  <td width="40%">Emp  Code:</td>
                  <td class="darkcolor"><?=$arryEmployee[0]['EmpCode']?></td>
                </tr>
                <tr class="even">
                  <td>Name:</td>
                  <td class="darkcolor"><?=stripslashes($arryEmployee[0]['UserName'])?>	</td>
                </tr>
                <tr class="odd">
                  <td>Email:</td>
                  <td class="darkcolor"><?=$arryEmployee[0]['Email']?></td>
                </tr>
                <tr class="even">
                  <td>Designation:</td>
                  <td class="darkcolor"><?=stripslashes($arryEmployee[0]['JobTitle'])?></td>
                </tr>
                <tr class="odd">
                  <td>Department:</td>
                  <td class="darkcolor"><?=$arryEmployee[0]['DepartmentName']?>
<?  if($arryEmployee[0]['DeptHead']>0){echo "&nbsp;&nbsp;<b>[Departmental Head]</b>";}?></td>
                </tr>
                <tr class="even">
                  <td>User Type:</td>
                  <td class="darkcolor"><?=stripslashes($arryEmployee[0]['catName'])?></td>
                </tr>
                <tr class="odd bord_none">
                  <td>Joining Date:</td>
                  <td class="darkcolor">	<? if($arryEmployee[0]['JoiningDate']>0) echo date($Config['DateFormat'], strtotime($arryEmployee[0]['JoiningDate'])); ?></td>
                </tr> 
				 <? }else{ ?>
				 <tr class="odd">
                  <td width="40%">User Type:</td>
                  <td class="darkcolor">System Administrator</td>
                </tr>
                <tr class="even">
                  <td>User Name:</td>
                  <td class="darkcolor"><?=stripslashes($arryCompany[0]['DisplayName'])?>	</td>
                </tr>
                <tr class="odd">
                  <td>Email:</td>
                  <td class="darkcolor"><?=$arryCompany[0]['Email']?></td>
                </tr>
				 <tr class="even">
                  <td>Company:</td>
                  <td class="darkcolor"><?=stripslashes($arryCompany[0]['CompanyName'])?>	</td>
                </tr>
				 <? } ?>

				 <? if(!empty($LastLoginTime555)){ ?>
				 <tr class="even">
                  <td>Last Login:</td>
                  <td class="darkcolor"><?=date($Config['DateFormat'].' H:i:s', strtotime($LastLoginTime))?>	</td>
                </tr>
				<? } ?>
				 
              </table></div>
			
            </div>
          </div>
		  
		  
	<? if( $Config['FullPermission']==1){?>  
          <div class="second_col" style="<?=$WidthRow2?>">
            <div class="block alerts">
	      <? if($ShowEmp==5555){ 
		$TodayDate =  $Config['TodayDate']; 
		$arryTime = explode(" ",$TodayDate);		
	    ?>
		<h3>Attendance in <?=date("F, Y",strtotime($arryTime[0]))?></h3>
		<div style="border: 1px solid #E1E1E1;padding:10px;width:360px;background:#fff;"><img src="barAtt.php" ></div>
	     <?	}else{	?>			
              <h3>Employees By Department</h3>
			<div class="chartdiv">
			<select name="event" id="event" class="chartselect" onchange="Javascript:showChart(this);" >
				<option value="pDepartment:bDepartment">Pie Chart</option>
				<option value="bDepartment:pDepartment">Bar Chart</option>
			</select>				
			<img src="barD.php" id="bDepartment" style="display:none">
			<img src="pieD.php" id="pDepartment" style="padding:10px;">
		</div>
	    <? } ?>
            </div>
          </div>
	  <? } ?>	  
		  
		  
          <div class="third_col" style="display:none3;<?=$WidthRow3?>">
            <div class="block status_updates">
              <h3>Announcements</h3>
              <div class="bgwhite" style="height:270px;overflow-y:auto;">
			  	
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <? if(sizeof($arryNews)>0){
					foreach($arryNews as $key=>$values){
				?>
				<tr>
                  <td ><a href="vNews.php?view=<?=$values['newsID']?>" class="fancybox fancybox.iframe"><img src="../images/right_dot.jpg" border="0">&nbsp;<?=substr(stripslashes($values['heading']),0,30)?>...</a></td>
                </tr>  
				<? }}else{ ?>
				 <tr>
                  <td><?=NO_NEWS?></td>
                </tr>
				<? } ?>
              </table>
			
              </div>
            </div>
          </div>
		  
		  
</div>
