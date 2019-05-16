<?php if(isset($_GET['menu'])!=1){?>
<div class="back"><a class="back"  href="<?=$RedirectURL?>">Back</a></div>
<?php }?>
<div class="had">
View Report   &raquo; <span>

	<?php 	echo  "<b>".stripcslashes($Viewdata['report_name'])."</b>";  ?>

</span>
</div>
<?php  //echo '<pre/>";print_r($reportdata);

$count = count($reportdata["colLabel"]);
$tdwidth = round(78/$count,2);
 ?>
<form name="c_reportform"  action="" method="post" style="display: block;">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
 
<tr>
        <td  align="right">
    <?php 
$url='';
if($_GET['view'])
{

	$url = "editID=".$_GET['view'];
	
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
</table>




<table width="100%"  border="0" cellpadding="0" cellspacing="0" class="borderall">
<tbody>
  <tr> 
        <td class="head" align="left" colspan="8">Report Detail</td>
    </tr>
  <tr>
     <td class="blackbold" width="15%" align="left" valign="top"> Report Name: </td>
     <td align="left" valign="top" style="width:100px" colspan="2"> <?php echo stripcslashes($Viewdata['report_name']);?></td>
  </tr>
  <tr>
     <td class="blackbold" width="15%" align="left" valign="top"> Report Description: </td>
     <td align="left" valign="top" style="width:100px" colspan="2"> <?php echo stripcslashes($Viewdata['report_desc']);?></td>
  </tr>
</tbody>
</table>

<!-- <div style="width: 100%; float: left;overflow: scroll;"> -->
<table width="100%" align="left" <?= $table_bg ?>>
   <tr align="left"  >
                                
      <?php foreach($reportdata['colLabel'] as $label){?>
       <td width="<?php echo $tdwidth;?>" class="head1"><?php echo $label;?></td>
        <?php }?>
   </tr>
	<?php if(!empty($reportdata['res'])) {  ?>	       

      <?php foreach($reportdata['res'] as $key => $value){?>
   <tr align="left">   
      <?php $j=0; foreach($reportdata['colName'] as $colname){
      ?>
       <td  width="<?php echo $tdwidth;?>"><?php if($colname == 'AssignTo' || $colname == 'AssignedTo'  || $colname == 'assignedTo') { 
            
                       if(isset($value['AssignType']) && $value['AssignType']!='Group')
                       {
                            $assignee = $objLead->GetAssigneeUser($value[$colname]);
							if(!empty($assignee)){                            
								$assigneeName = implode(array_map(function($arr){
                                            return $arr['UserName'];
                                        
                                        },$assignee),',');
							}
                       }else{
                           echo (isset($value['GroupID']) && $value['GroupID'] == '1') ? 'General' : 'Marketing';
                       }                
                echo (isset($assigneeName)) ? stripcslashes($assigneeName) : '';
        }elseif($colname == 'CustID'){
           
                $customer = $objCustomer->getCustomerById($value[$colname]);
                echo (!empty($customer)) ? stripcslashes($customer[0]['FullName']) : '';
                
        
        }elseif($colname == 'Status'){        
                
                if($value[$colname] == 1 || $value[$colname] == 'Yes' ){ echo "Active";}elseif($value[$colname] == 0 || $value[$colname] == 'No' ){echo "Inactive";}else{echo $value[$colname];}
        }elseif($colname == 'product'){
            
                $arryProduct=$objItems->GetItems($value[$colname],'',1,'');//23/july/2018//
                echo (!empty($arryProduct)) ? stripcslashes($arryProduct[0]['Sku']) : '';
                
         }elseif($colname == 'country_id'){
        			/********Connecting to main database*********/
				$Config['DbName'] = $Config['DbMain'];
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();
        	
        	   $arrycountry = $objregion->GetCountryName($value[$colname]);
        	   echo (!empty($arrycountry)) ? $arrycountry[0]['name'] : '';
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
        	   echo (!empty($arrystate)) ? $arrystate[0]['name'] : '';
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
        	   echo (!empty($arrycity)) ? $arrycity[0]['name'] : '';
        	   /********Connecting to Company database*********/
				$Config['DbName'] = $_SESSION['CmpDatabase'];
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();
	}elseif($colname == 'CustType' &&  $reportdata['post']['moduleID'] == '108' ){ 	 
		if($value['CustType'] == 'c'){
			echo "Customer";
		}elseif ($value['CustType'] == 'o'){
			echo "Opportunity";
		}	
	}elseif($reportdata['type'][$j] =='date'){
		      
 		echo (($value[$colname] > 0)? date($Config['DateFormat']." ".$Config['TimeFormat'], strtotime($value[$colname])) : '' ); 
                        
        }else{                 
                echo stripcslashes($value[$colname]);
                }  ?> </td>
      <?php $j++; }?>
   </tr>
      <?php }?>

	<?php }else{?>
     <tr class="evenbg" align="center">
		<td class="no_record" colspan="11">No record found. </td>
	</tr>
	  <?php }?>	

      <tr><td></td></tr>
    </table>
   <!-- </div>   --> 
   
   
   
    

   
</form>
