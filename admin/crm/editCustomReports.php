<?php

/* * *********************************************** */
$ThisPageName = 'viewCustomReports.php';
$EditPage = 1;
/* * *********************************************** */

require_once("../includes/header.php");
require_once($Prefix . "classes/custom_reports.class.php");
require_once($Prefix . "classes/field.class.php");


$ModuleName = "CustomReports";
$RedirectURL = "viewCustomReports.php?curP=" . $_GET['curP'];

$creport = new customreports();
$field   = new field();

if($_GET['edit'])
{
            CleanGet();
      if ( strval($_GET['edit']) != strval(intval($_GET['edit'])) ) {
	      header('location:viewCustomReports.php');
     }else{
            $editData =  $creport->GetReportLists($_GET['edit']);
            $editData =  $editData[0];
            $colSel = array();
            $Slctcolms = explode(',',$editData['columns']);
            foreach($Slctcolms as $FID)
            {   if($FID == 'c_1' || $FID == "s_1")
            	{
	            	if($FID == 'c_1'){	
                          array_push($colSel,array('ID' => $FID, 'name' => 'City'));
                    }else{ 
                          array_push($colSel,array('ID' => $FID, 'name' => 'State'));
	            	}
            	}else{
                	array_push($colSel,array('ID' => $FID, 'name' => $field->GetCustomfieldByFieldId($FID, 'fieldlabel')));
            	}	
            } 
            $fop = array();
            $fval= array();
            $fcol = array();
            $sortby = '';
            if($editData['filters']!="")
            {
                if(strstr($editData['filters'],'#'))
                {
                        $arr = explode("#",$editData['filters']);
                        if(count($arr))
                        {
                                foreach($arr as $Arr)
                                {
                                        $resArr = explode(",",$Arr);
                                        array_push($fcol,$resArr[0]);
                                        array_push($fop,$resArr[1]);
                                        array_push($fval,$resArr[2]);
                                }
                        }
                }else{

                                        $resArr = explode(",",$editData['filters']);
                                        array_push($fcol,$resArr[0]);
                                        array_push($fop,$resArr[1]);
                                        array_push($fval,$resArr[2]);
                        }
            }
            
            $fop    = json_encode($fop);
            $fval   = json_encode($fval);
            $fcol   = json_encode($fcol);
            
            
            if($editData['sortby']!="")
            {
                if(strstr($editData['sortby'],' '))
                {
                        $arr = explode(" ",$editData['sortby']);

                        $sortcol = $arr[0];
                        $order = $arr[1];
                }
            }
            
            
     }       
            
    //echo "<pre/>";print_r($fcol);
}







require_once("../includes/footer.php");

?>
