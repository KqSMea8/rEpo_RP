<?php

class cms extends dbClass {
 
   function addPage($data) {
	   if(!empty($data)){
	   $this->insert('pages',$data);
           $_SESSION['msg'] = "Cms page has been add successfully. ";
	    return  $this->insert_id;
      
	   }
	return false;   
	   }

 
   function getPages($arg = array()){
	  
        $where='WHERE 1=1';
            if(!empty($arg['userRoleID']))
                    $where .=' AND userRoleID="'.$arg['userRoleID'].'"';
            $offset=$arg['offset'];
            $limit=$arg['limit'];
         
            if(isset($limit) AND isset($offset))
                $limitval="LIMIT $offset , $limit";
             $sql = "SELECT * , (Select Count(*) FROM pages  $where) as c FROM `pages` $where $limitval";   
                               
                return $this->get_results($sql);
   }
  
   
   function get_page($id){
      $sql = "SELECT * FROM  pages WHERE id='".$id."'";
      $rr=$this->get_row($sql);
		return $rr;
   }
   
   function delete_page($id){
        $_SESSION['msg'] = "Cms page has been delete successfully. ";
	 return  $this->delete('pages',array('id'=>$id));
   }
   
   function update_page($data,$id){
     $_SESSION['msg'] = "Cms page has been update successfully. ";
       return $this->update('pages',$data,array('id'=>$id));
      
   }
   
   function change_Status($arryDetails,$id)
   {   
     if(!empty($arryDetails)){
     if($arryDetails['status']==1)
      $arryDetails['status']=0;
     else
      $arryDetails['status']=1;
     $this->update('pages',$arryDetails,array('id'=>$id));     
                 $_SESSION['msg'] = "Cms page status has been change successfully. ";                 }
   return true;

    }
   
   function checkSlug($slug){
   	 $sql="Select count(page_slug) as c FROM pages where page_slug='$slug'";
   	$res=$this->get_row($sql);
   	if($res->c==0){
   	return true;
   	}
   	return false;
   }
  
  
   
}

?>
	


