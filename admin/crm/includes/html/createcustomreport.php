<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
<script src="../js/jquery.dragtable.js"></script>
<link rel="stylesheet" type="text/css" href="../js/dragtable.css" />
<script type="text/javascript">
 $(document).ready(function() {
   
$( ".dragtable" ).dragtable({
  persistState: function(table) {      
                    var selVal = [];
                    table.el.find('th').each(function(i) { 
                                selVal.push(this.id.replace(/[^0-9\.]/g, ''));
                                                      });  
                   selValStr = selVal.join(',');//console.log($('#selectclms').val('aefdwe')); 
                   $('input[name="selectclms"]').val(selValStr);                                          
    }
});

});

</script>
<div class="had">
Manage Report   &raquo; <span>

	<?php 	echo  "Generated Report" ; ?>

</span>
</div>
<?php  //echo "<pre/>";print_r($reportdata); ?>
<form name="c_reportform"  action="" method="post">
<table width="100%" border="0" cellpadding="5" cellspacing="0">
 
<tr>
        <td  align="right">
    <?php 
$url='';
if(!empty($_GET['editID']))
{

	$url = "editID=".$_GET['editID'];
	
}?>      
<ul class="export_menu">
<li><a class="hide" href="#">Export Report</a>
<ul>
<li class="excel"><a href="export_customreport.php?flage=1<?php echo ($url) ? '&'.$url :'';?>" ><?=EXPORT_EXCEL?></a></li>
<!--<li class="pdf" ><a href="pdfCustomReport.php<?php echo ($url) ? '?'.$url :'';?>" ><?=EXPORT_PDF?></a></li>-->
<li class="csv" ><a href="export_customreport.php?flage=2<?php echo ($url) ? '&'.$url :'';?>" ><?=EXPORT_CSV?></a></li>	
<!--<li class="doc" ><a href="export_todoc_customreport.php<?php echo ($url) ? '?'.$url :'';?>" ><?=EXPORT_DOC?></a></li>	-->
</ul>
</li>
</ul>
  <input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
           
        </td>
    </tr>


<tr>
    <td  align="center" valign="top" >

<table width="100%"  border="0" cellpadding="5" cellspacing="0" class="borderall">
<tbody>
  <tr> 
        <td class="head" align="left" colspan="8">Report Detail</td>
    </tr>
  <tr>
     <td class="blackbold" width="15%" align="left" valign="top"> Report Name: </td>
     <td align="left" valign="top" style="width:100px" colspan="2"> <?php  if(isset($reportdata['post']['report_name'])) echo stripslashes($reportdata['post']['report_name']);?></td>
  </tr>
  <tr>
     <td class="blackbold" width="15%" align="left" valign="top"> Report Description: </td>
     <td align="left" valign="top" style="width:100px" colspan="2"> <?php if(isset($reportdata['post']['report_desc'])) echo stripslashes($reportdata['post']['report_desc']);?></td>
  </tr>
 </tbody>
</table>
         
<table class="dragtable" <?= $table_bg ?>>
  <tbody>
    <tr align="left">
                                
      <?php
	$count=0;
	$tdwidth=$colIDs='';
	if(!empty($reportdata["colLabel"])){
		$count = count($reportdata["colLabel"]);
		$tdwidth = round(78/$count,2);
	}
	if(!empty($reportdata['post']['selectclms'])){
      		$colIDs = explode(',',$reportdata['post']['selectclms']);
	}
      $i=0;
      if(!empty($reportdata['colLabel'])){
      foreach($reportdata['colLabel'] as $label){?>
        <th width="<?php echo $tdwidth;?>" class="head1" id="th<?php echo $colIDs[$i]?>" ><?php echo $label;?></th>
        <?php $i++;}
	}
	?>
   </tr>
  
	<?php if(!empty($reportdata['res'])) {  ?>	 

      <?php foreach($reportdata['res'] as $key => $value){?>
   <tr align="left" style="background-color:#FFF">   
      <?php $j=0;foreach($reportdata['colName'] as $colname){
      ?>
        <td width="<?php echo $tdwidth;?>" ><?php if($colname == 'AssignTo' || $colname == 'AssignedTo'  || $colname == 'assignedTo') { 
            
                       if($value['AssignType']!='Group')
                       {
                            $assignee = $objLead->GetAssigneeUser($value[$colname]);
                            $assigneeName = implode(array_map(function($arr){
                                            return $arr['UserName'];
                                        
                                        },$assignee),',');
                       }else{
                           echo ($value['GroupID'] == '1') ? 'General' : 'Marketing';
                       }                
                echo $assigneeName;
        }elseif($colname == 'CustID'){
            
                $customer = $objCustomer->getCustomerById($value[$colname]);
                echo stripcslashes($customer[0]['FullName']);
                
        
        }elseif($colname == 'Status'){        
                
                if($value[$colname] == 1 || $value[$colname] == 'Yes' ){ echo "Active";}elseif($value[$colname] == 0 || $value[$colname] == 'No' ){echo "Inactive";}else{echo $value[$colname];}
        }elseif($colname == 'product'){
            
                $arryProduct=$objItems->GetItems($value[$colname],'',1);
                echo stripcslashes($arryProduct[0]['Sku']);
                
        }elseif($colname == 'country_id'){
        			/********Connecting to main database*********/
				$Config['DbName'] = $Config['DbMain'];
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();
        	
        	   $arrycountry = $objregion->GetCountryName($value[$colname]);
        	   echo $arrycountry[0]['name'];
        	   /********Connecting to Company database*********/
				$Config['DbName'] = $_SESSION['CmpDatabase'];
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();
	}elseif($colname == 'state_id'){
        			/********Connecting to main database*********/
				$Config['DbName'] = $Config['DbMain'];
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();
        	
        	   $arrystate = $objregion->getStateName($value[$colname]);
        	   echo $arrystate[0]['name'];
        	   /********Connecting to Company database*********/
				$Config['DbName'] = $_SESSION['CmpDatabase'];
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();
				
	}elseif($colname == 'city_id'){
        			/********Connecting to main database*********/
				$Config['DbName'] = $Config['DbMain'];
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();
        	
        	   $arrycity = $objregion->getCityName($value[$colname]);
        	   echo $arrycity[0]['name'];
        	   /********Connecting to Company database*********/
				$Config['DbName'] = $_SESSION['CmpDatabase'];
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();
		
	}elseif($colname == 'CustType' &&  $reportdata['post']['moduleID'] == '108' ){ 	 
		if($value['CustType'] == 'c') {
			echo "Customer";
		}elseif ($value['CustType'] == 'o') {
			echo "Opportunity";
		}		

  	}elseif($reportdata['type'][$j] =='date'){
		      
		echo (($value[$colname] > 0)? date($Config['DateFormat']." ".$Config['TimeFormat'], strtotime($value[$colname])) : '' ); 

        }else{                 
                echo stripcslashes($value[$colname]);
        }  ?> </td>
      <?php $j++;}?>
   </tr>
      <?php }?>
      
	 <?php }else{?>
     <tr class="evenbg" align="center">
		<td class="no_record" colspan="11">No record found. </td>
	</tr>
	  <?php }?>

   </tbody>  
    </table>
        
   
   
   
   
    
    </td>
</tr>
   <tr>
    <td  align="center">
	
	<input name="report_name" type="hidden" class="inputbox" id="reportname " value="<?php if(isset($reportdata['post']['report_name'])) echo $reportdata['post']['report_name']; ?>" />
	<input name="report_desc" type="hidden" class="inputbox" id="description" value="<?php if(isset($reportdata['post']['report_desc'])) echo $reportdata['post']['report_desc']; ?>" />
	<input name="moduleID"    type="hidden" class="inputbox" id="moduleID "   value="<?php if(isset($reportdata['post']['moduleID'])) echo $reportdata['post']['moduleID']; ?>" />
	<input name="selectclms"  type="hidden" class="inputbox" id="selectclms"  value="<?php if(isset($reportdata['post']['selectclms'])) echo $reportdata['post']['selectclms']; ?>" />
	<input name="groupby"     type="hidden" class="inputbox" id="groupby "    value="<?php if(isset($reportdata['post']['groupby'])) echo $reportdata['post']['groupby'] ;?>" />
	<input name="sortcol"     type="hidden" class="inputbox" id="sortcol"     value="<?php if(isset($reportdata['post']['sortcol'])) echo $reportdata['post']['sortcol']; ?>" />
	<input name="order"       type="hidden" class="inputbox" id="order"       value="<?php if(isset($reportdata['post']['order'])) echo $reportdata['post']['order']; ?>" />

	<input name="fcol"        type="hidden" class="inputbox" id="fcol "       value="<?php if(isset($reportdata['post']['fcol'])) echo implode($reportdata['post']['fcol'],',');?>" />
	<input name="fop" 	  type="hidden" class="inputbox" id="fop"         value="<?php if(isset($reportdata['post']['fop'])) echo implode($reportdata['post']['fop'],',');?>" />
	<input name="fval"        type="hidden" class="inputbox" id="fval "       value="<?php if(isset($reportdata['post']['fval'])) echo implode($reportdata['post']['fval'],',');?>" />
	
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
        <input name="Save" type="submit" class="button" id="SubmitButton" value="Save"  />
        <input name="Cancel" type="button" class="button" onclick="window.location.href='viewCustomReports.php?curP=1'" value="Cancel"  />
        <input type="hidden" name="report_ID" id="report_ID" value="<?php if(isset($reportdata['post']['report_ID'])) echo $reportdata['post']['report_ID']?>" />


</td>

   </tr>
</table>
   
</form>
