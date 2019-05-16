<?
$arryPeriodFields = $objReport->getPeriodFields($_GET);   
$num=$objReport->numRows();
$pagerLink=$objPager->getPager($arryPeriodFields,$RecordsPerPage,$_GET['curP']);
(count($arryPeriodFields)>0)?($arryPeriodFields=$objPager->getPageRecords()):("");

?>
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="borderall" >
<tr>
      <td  valign="top" class="had">Period Closed List</td>  
  </tr>
 <tr>
      <td >
          <form name="frmSrch" id="frmSrch" action="periodEndSetting.php" method="get" onSubmit="return ValidateSearch();">

	<table id="search_table" cellspacing="0" cellpadding="0" border="0" style="margin:0">
        <tr>
            <td >Module :  </td>
	    <td>
		<select style="width: 90px;" class="textbox" id="PeriodModule" name="PeriodModule">
                    <option value="">All</option>
                    <option value="AR" <?php if($_GET['PeriodModule'] == "AR"){echo "selected";}?>>AR</option>
                     <option value="AP" <?php if($_GET['PeriodModule'] == "AP"){echo "selected";}?>>AP</option>
                      <option value="GL" <?php if($_GET['PeriodModule'] == "GL"){echo "selected";}?>>GL</option>
                     <option value="INV" <?php if($_GET['PeriodModule'] == "INV"){echo "selected";}?>>INV</option>
                 </select>

		 </td>
		 <td>Year : </td>
		<td>
                   <?php
                                $Year_String = '<select name="PeriodYear" id="PeriodYear" class="textbox" style="width: 120px;">';
                                $c_year = date('Y')-2;
                                $start_year = $c_year+3;
                                $Year_String .= '<option value="">All</option>';
                                for($y=$c_year;$y<$start_year;$y++){
                                if($_GET['PeriodYear'] == $y) $y_selected=' Selected'; else $y_selected='';
                                $Year_String .= '<option value="'.$y.'" '.$y_selected.'> '.$y.' </option>';
                                }
                                $Year_String .= ' </select>';
                                echo $Year_String;
                        ?>
		</td>
		<td>Month : </td>
		<td>
                      <select name="PeriodMonth" id="PeriodMonth" class="textbox" style="width: 120px;">
                                                        <option value="">All</option>
                                                          <?php
                                                         for ($m=1; $m<=12; $m++) {
                                                            $month = date('F', mktime(0,0,0,$m, 1, date('Y')));
                                                            if($m < 10) $m = '0'.$m;
                                                            ?>
                                                            
                                                         <option value="<?=$m;?>" <?php if($_GET['PeriodMonth'] == $m){ echo "selected";}?>><?=$month?></option>
                                                         <?php } ?>
                                                        </select>
		</td>

               <td><input type="hidden" name="search" id="search" value="Search">
               <input type="submit" name="sbt" value="Go" class="search_button"></td>

			</tr>
		</table>

            </form>  
      </td>  
  </tr>

<tr>
      <td>
<table <?=$table_bg?>>
   
    <tr align="left"  >
	
		<td width="10%"  align="center" class="head1">Module</td>
		<td width="20%" align="center" class="head1">Year</td>
		<td width="20%" align="center" class="head1">Month</td>
		
		<td width="20%" align="center" class="head1">Status</td>
                <!--td  class="head1" align="center">Action</td-->
    </tr>
   
  <?php if(is_array($arryPeriodFields) && $num>0){
	  	$flag=true;
		$Line=0;
		$invAmnt=0;
  	foreach($arryPeriodFields as $key=>$values){
		$flag=!$flag;
		 
		$Line++;
	       
            $monthNum  = $values['PeriodMonth'];
            $dateObj   = DateTime::createFromFormat('!m', $monthNum);
            $monthName = $dateObj->format('F'); // March
	
  ?>

		
    <tr align="left" >
        <td align="center">

<?
if($PrevPeriodModule!=$values['PeriodModule']) 
	echo '<b>'.$values['PeriodModule'].'</b>';
?>
 </td>
	
      <td align="center"><?=$values['PeriodYear']?></td>
      <td align="center"><?=$monthName;?></td>
     
      <td align="center">

<?php
	if($values['PeriodStatus'] == 'Closed') {
		$statusCls = 'InActive';
		$action = 'open';
	} else {
		$statusCls = 'Active';
		$action = 'close';
	}


echo '<a href="periodEndSetting.php?active_id='.$values["PeriodID"].'&curP='.$_GET["curP"].'" class="'.$statusCls.'" onclick="return confirmAction(this,\'Period '.ucfirst($action).'\',\'Are you sure you want to '.$action.' this period?\' )">' . $values['PeriodStatus'] . '</a>';
?>

</td>
      <!--td align="center">
           <a class="fancybox  fancybox.iframe" href="editPeriodEndSetting.php?edit=<?php echo $values['PeriodID']; ?>&curP=<?php echo $_GET['curP']; ?>" ><?= $edit ?></a>&nbsp;
         <!--<a href="editPeriodEndSetting.php?del_id=<//?php echo $values['PeriodID']; ?>&curP=<//?php echo $_GET['curP']; ?>" onclick="return confDel('Period')" class="Blue" ><//?= $delete ?></a> 
         </td-->
	  

    </tr>
	

	
        <?php 

		$PrevPeriodModule = $values['PeriodModule'];

} // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="5" class="no_record"><?=NO_RECORD?> </td>
    </tr>
    <?php } ?>
  
	 <tr>  <td  colspan="5"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryPeriodFields)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

</td>  
  </tr>
</table>
