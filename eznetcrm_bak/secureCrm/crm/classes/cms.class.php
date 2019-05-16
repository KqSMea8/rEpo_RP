<?

class cms extends dbClass
{

		 /*     * **********************************************************START FUNCTIONS FOR PAGES**************************************************************************** */

                    function addPage($arryDetails) {
                        @extract($arryDetails);
                        $sql = "INSERT INTO  e_pages SET Name='" . addslashes($Name) . "', Title = '" . addslashes($Title) . "',Priority = '".$Priority."',UrlCustom = '".$UrlCustom."',UrlHash=MD5('".$UrlCustom."'),MetaKeywords='".addslashes($MetaKeywords)."',MetaTitle='".addslashes($MetaTitle)."',MetaDescription='".addslashes($MetaDescription)."',Status='" . $Status . "',Content='".addslashes($page_content)."'";
                        $this->query($sql, 0);
                    }

                    function getPages() {
                        $sql = "SELECT * from e_pages  ORDER BY PageId DESC ";
                        return $this->query($sql, 1);
                    }

                   

                    function getPageById($id) {
                        $sql = "SELECT * from e_pages WHERE PageId = " . $id . "";
                        return $this->query($sql, 1);
                    }

                    function updatePage($arryDetails) {
                        @extract($arryDetails);
                        $sql = "UPDATE  e_pages SET Name='" . addslashes($Name) . "', Title = '" . addslashes($Title) . "',Priority = '".$Priority."',UrlCustom = '".$UrlCustom."',UrlHash=MD5('".$UrlCustom."'),MetaKeywords='".addslashes($MetaKeywords)."',MetaTitle='".addslashes($MetaTitle)."',MetaDescription='".addslashes($MetaDescription)."',Status='" . $Status . "',Content='".addslashes($page_content)."' WHERE PageId =" . $PageId;
                        $this->query($sql, 0);
                    }

                    function deletePage($id) {

                        $sql = "DELETE from e_pages where PageId = " . $id;
                        $rs = $this->query($sql, 0);

                        if (sizeof($rs))
                            return true;
                        else
                            return false;
                    }

                    function changePageStatus($id) {
                        $sql = "select * from e_pages where PageId=" . $id;
                        $rs = $this->query($sql);
                        if (sizeof($rs)) {
                            if ($rs[0]['Status'] == 'Yes')
                                $Status = 'No';
                            else
                                $Status = 'Yes';

                            $sql = "update e_pages set Status='" . $Status . "' where PageId=" . $id;
                            $this->query($sql, 0);
                            return true;
                        }
                    }
                    
                function getPagesforFront() {
                        $sql = "SELECT * from e_pages WHERE Status = 'Yes' ORDER BY Priority ASC ";
                        return $this->query($sql, 1);
                    }    

                 function getPageIdByHash($urlhash) {
                        $sql = "SELECT PageId FROM e_pages WHERE UrlHash='".$urlhash."'";
                        return $this->query($sql, 1);
                    }    
    /*     * ****************************************************END FUNCTIONS FOR PAGES*************************************************************************** */
		
}

?>