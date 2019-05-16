<?php

/* Developer Name: Rajan
 * Date : 25-06-15
 * 
 */
class cms extends dbClass { /*
 * Name: cms
 * Description: For Superadmin chat  CMS
 * @param: 
 * @return: 
 */
   function addPage($data) {
	   /*$data=array(
	     $id = '',
		 $Name      =  $_POST['Name'],
		 $Title     =  $_POST['Title'],
		 $Priority  =  $_POST['Priority'],
		 $page_slug =  $_POST['page_slug'],
		 $MetaTitle =  $_POST['MetaTitle'],
		 $MetaKeywords =  $_POST['MetaKeywords'],
		 $MetaDescription =  $_POST['MetaDescription'],
		 $page_content =  $_POST['page_content'],
		 $Template  =  $_POST['Template'],
		 $Status    =  $_POST['Status'],
		 );
		 print_r($data);*/
	   if(!empty($data)){
	   $this->insert('ecompages',$data);
	    return  $this->insert_id;
	   }
	return false;   
	   }

   /*function getPages(){
	  $sql = "SELECT * FROM  pages ";
	    $rr=$this->get_results($sql);//echo "<pre>";print_r($rr);
		return $rr;
   }
   /***********************************Amit Singh*******************************************/
   function getPages($arg = array()){
	  
        $where='WHERE 1';
            if(!empty($arg['userRoleID']))
                    $where .=' AND userRoleID="'.$arg['userRoleID'].'"';
            $offset=$arg['offset'];
            $limit=$arg['limit'];
         
            if(isset($limit) AND isset($offset))
                $limitval="LIMIT $offset , $limit";
             $sql = "SELECT * , (Select Count(*) FROM ecompages  $where) as c FROM `ecompages` $where $limitval";   
                               
                return $this->get_results($sql);
   }
   /******************************************************************************/
   
   function get_page($id){
      $sql = "SELECT * FROM  ecompages WHERE id='".$id."'";
    $rr=$this->get_row($sql);//echo "<pre>";print_r($rr);
		return $rr;
   }
   
   function delete_page($id){
	  // $sql = "DELETE FROM ecompages WHERE id=$id";
	 return  $this->delete('ecompages',array('id'=>$id));
   }
   
   function update_page($data,$id){
       return $this->update('ecompages',$data,array('id'=>$id));
   }
   
   function change_Status($arryDetails,$id)
   {   
     if(!empty($arryDetails)){
     if($arryDetails['status']==1)
      $arryDetails['status']=0;
     else
      $arryDetails['status']=1;
     $this->update('ecompages',$arryDetails,array('id'=>$id));     
                                 }
   return true;

    }
   
   function checkSlug($slug){
   	 $sql="Select count(page_slug) as c FROM ecompages where page_slug='$slug'";
   	$res=$this->get_row($sql);
   	if($res->c==0){
   	return true;
   	}
   	return false;
   }
  
  
   
}

?>
	


