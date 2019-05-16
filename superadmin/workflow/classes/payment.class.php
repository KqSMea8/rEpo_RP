<?php

/* Developer Name: Niraj Gupta
 * Date : 19-06-15
 * 
 * Description: For plane class
 * @param: 
 * @return: 
 */
ob_start();
class payment extends dbClass { /*
 * Name: Coupan
 * Description: For Superadmin  plan elements
 * @param: 
 * @return: 
 */

  function getPlanelement($arg = array(),$element_id) 
                {
        extract($arg);
        if(isset($element_id)){
           $sql = "SELECT d.name, o.id, o.total_amount, o.discount_amount, o.pay_amount, o.allow_users, o.plan_duration, o.date FROM flow_compnay AS d RIGHT JOIN `flow_order_history` as o on d.cmp_id=o.cmp_id where id='".$element_id."'";  
         return  $this->get_row($sql);
        }
       else {
		       $offset=$arg['offset'];
           		$limit=$arg['limit'];
			if(isset($limit) AND isset($offset))
		        $limitval="LIMIT $offset , $limit";
		
		       $sql = "SELECT d.name, o.id, o.total_amount, o.discount_amount, o.pay_amount, o.allow_users, o.plan_duration, o.date, (SELECT count(*) FROM `flow_order_history` ) as d FROM flow_compnay AS d RIGHT JOIN `flow_order_history` as o on d.cmp_id=o.cmp_id    $limitval";
			//print_r($sql);
		       return $this->get_results($sql);
			//print_r($sql);
		//echo $sql;

           }
    
    }
 public function  getPlanpackageElement($userPackageId){
         if(!empty($userPackageId))
            { 
           $sql = "SELECT * FROM `flow_order_history` where package_id='".$userPackageId."'";  
            }
          return  $this->get_results($sql); 
	print_r($sql);
    }
function AddElement($arryDetails)
		{  
                   $result= $this->insert('flow_order_history',$arryDetails);
                    $elementID = $this->insert_id;
                    return $elementID;
		}


function UpdateElement($arryDetails,$element_id)
                {   
			extract($arryDetails);
			if(!empty($element_id)){
			$this->update('flow_order_history',$arryDetails,array('id'=>$element_id));
			}
			return 1;
		}

 function DeleteElement($element_id) {  		    
            if(!empty($element_id))
            { 
            	$result=$this->getPlanelement(array(),$element_id);  
                $sqlpckgelement = "SELECT ele_key FROM `flow_order_history` WHERE ele_key='$result->element_slug'";
                $arryDetails= $this->get_results($sqlpckgelement);             
                if(!empty($arryDetails)){
                	return false;
            		 }
            		 else{ 
            			 $this->delete('flow_order_history',array('id'=>$element_id));
            			return true;
            		 }
            }
            
             return false;
    }
    
 function changeElementStatus($arryDetails,$element_id)
 {   

                        if(!empty($arryDetails)){
					if($arryDetails['status']=='Active')
						$arryDetails['status']='Inactive';
					else
						$arryDetails['status']='Active';
					$this->update('flow_order_history',$arryDetails,array('id'=>$element_id));					
                                 }
			return true;

		}



/*****************************Pagination( Ravi Solanki) edited Amit Singh**************************************************/
function pagingChat($page,$limit,$offset,$num,$totalrecords){
        
        $intLoopStartPoint = 1;
        $intLoopEndPoint= $totalrecords;
         $strURL='';
        
        if(($page) > ($totalrecords)){
            $intLoopStartPoint = $page - $num + 1;
            if (($intLoopStartPoint + $limit) <= ($num)) {
                    $intLoopEndPoint=$intLoopStartPoint + $limit - 1;
            } else {
                    $intLoopEndPoint = $totalrecords;
            }
        } 
        
        if (($num > $limit) && ($page != 1)) {
            $pageslink.="<a href=\"".basename($_SERVER['PHP_SELF'])."?curP=1&".$strURL."\" class=\"pagenumber\"><<</a> ";							
        }
        
        if ($intLoopStartPoint > 1) {
            $intPreviousPage=$page - 1;
            $pageslink.="<a href=\"".basename($_SERVER['PHP_SELF'])."?curP=".$intPreviousPage."&".$strURL."\" class=\"edit22\"> &lt;&lt; </a> ";			
        }	
        
        for($i=$intLoopStartPoint;$i<=$intLoopEndPoint;$i++){
            if ($page==$i) {
            //$this->strShowPaging.="<a href=\"".basename($_SERVER['PHP_SELF'])."?curP=".$i."&".$this->strURL."\" class=\"pagenumber\"><b>".$i."</b></a> ";
                $pageslink.= '<span class="pagenumber"><b>'.$i.'</b></span> ';
            } else {
                $pageslink.="<a href=\"".basename($_SERVER['PHP_SELF'])."?curP=".$i."&".$strURL."\" class=\"pagenumber\">".$i."</a> ";
            }
            if ($i!=$intLoopEndPoint) {
                    $pageslink.=" ";
            }
        }
			
        if ($intLoopEndPoint < $intTotalNumPage) {
                $intNextPage=$page+1;
                $pageslink.="<a href=\"".basename($_SERVER['PHP_SELF'])."?curP=".$intNextPage."&".$strURL."\" class=\"edit22\"> &gt;&gt; </a> ";
        }
        
        if (($totalrecords > $limit) && ($page != $totalrecords)) {
        $pageslink.="<a href=\"".basename($_SERVER['PHP_SELF'])."?curP=".$totalrecords."&".$strURL."\" class=\"pagenumber\">>></a>";			
        }
        //echo $pageslink;
        return $pageslink;
    }

/*****************************end Pagination**************************************************/
}
?>
