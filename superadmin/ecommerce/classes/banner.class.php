
<?php 
class banner extends dbClass { 

function addbanner($arr)
   	{
 
      $this->insert('ecombanner',$arr);
   
		
    }
   
    function getbanner($arg){
       
        $where='WHERE 1';
            if(!empty($arg['userRoleID']))
                    $where .=' AND userRoleID="'.$arg['userRoleID'].'"';
  $limitval=''; 
if(isset($arg['limit']) AND isset($arg['offset'])){
		  $offset=$arg['offset'];
            	$limit=$arg['limit'];
                $limitval="LIMIT $offset , $limit";
	   }

        
            $sql = "SELECT * , (Select Count(*) FROM ecombanner  $where) as c FROM `ecombanner` $where $limitval";   
                               
                return $this->get_results($sql);
   }
   
   
    function get_banner($id){
      $sql = "SELECT * FROM  ecombanner WHERE id='".$id."'";
    $rr=$this->get_row($sql);//echo "<pre>";print_r($rr);
		return $rr;
   }
   
   function delete_banner($id){
       
	  // $sql = "DELETE FROM pages WHERE id=$id";
	 return  $this->delete('ecombanner',array('id'=>$id));
   }
   
   function update_banner($arr,$id){
    
    
       return $this->update('ecombanner',$arr,array('id'=>$id));
   }
   
   function change_Status($arr,$id)
   {   
     if(!empty($arr)){
     if($arr['status']==1)
      $arr['status']=0;
     else
      $arr['status']=1;
     $this->update('ecombanner',$arr,array('id'=>$id));     
                                 }
   return true;

    }
   
    
    
}

?>
