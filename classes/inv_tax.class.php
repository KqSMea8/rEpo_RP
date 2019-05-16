<?

class tax extends dbClass {

    var $tables;

    // consturctor 
    function tax() {
        global $configTables;
        $this->tables = $configTables;
        $this->dbClass();
    }

             
    /****Functions For Tax*******/

                        function addTaxClass($arryDetails) {
                            @extract($arryDetails);
                            $sql = "INSERT INTO  inv_tax_classes SET ClassName='" .mysql_real_escape_string($ClassName). "', ClassDescription = '".mysql_real_escape_string($ClassDescription)."',Status='".mysql_real_escape_string($Status)."'";
                            $this->query($sql, 0);
                        }

                        function getTaxClasses() {
                            $sql = "SELECT * from inv_tax_classes where 1  ORDER BY ClassId DESC ";
                            return $this->query($sql, 1);
                        }

                        function getClasses() {
                            $sql = "SELECT * from inv_tax_classes WHERE Status = '1' ORDER BY ClassId DESC ";
                            return $this->query($sql, 1);
                        }

                        function getTaxClassById($id) {
                            $sql = "SELECT * from inv_tax_classes WHERE ClassId = '".$id. "'";
                            return $this->query($sql, 1);
                        }

                        function updateTaxClass($arryDetails) {
                            @extract($arryDetails);
                            $sql = "UPDATE  inv_tax_classes SET ClassName='".mysql_real_escape_string($ClassName). "', ClassDescription = '" .mysql_real_escape_string($ClassDescription)."',Status='" .mysql_real_escape_string($Status). "' WHERE ClassId ='".mysql_real_escape_string($taxclassId)."'";
                            $this->query($sql, 0);
                        }

                        function deleteTaxClass($id) {

                            $sql = "DELETE from inv_tax_classes where ClassId = '".$id."'";
                            $rs = $this->query($sql, 0);

                            if (sizeof($rs))
                                return true;
                            else
                                return false;
                        }

                        function changeTaxClassStatus($id) {
                            $sql = "select * from inv_tax_classes where ClassId='" . $id."'";
                            $rs = $this->query($sql);
                            if (sizeof($rs)) {
                                if ($rs[0]['Status'] == 'Yes')
                                    $Status = 'No';
                                else
                                    $Status = 'Yes';

                                $sql = "update inv_tax_classes set Status='" . $Status . "' where ClassId='" . $id."'";
                                $this->query($sql, 0);
                                return true;
                            }
                        }

                        function addTax($arryDetails) {
  @extract($arryDetails);
/*                           
echo $ClassId2; 
if($ClassId2 !='' || $ClassId1 !=''){
for($i=1;$i<=2;$i++){

}*/

$ClassId = implode(",",$ClassId);


                            $sql = "INSERT INTO inv_tax_rates SET ClassId='".mysql_real_escape_string($ClassId)."',Coid ='".mysql_real_escape_string($country_id)."', Stid ='".mysql_real_escape_string($main_state_id)."', locationID = '".$_SESSION['locationID']."',TaxRate ='".mysql_real_escape_string($TaxRate)."',  RateDescription = '".mysql_real_escape_string($RateDescription)."',FreightTax = '" .mysql_real_escape_string($FreightTax). "', Status='".mysql_real_escape_string($Status)."'";
                            $this->query($sql, 0);
                        }

                        function getTaxes() {
				global $Config; 
				$addsql ='';
				if($Config['CurrentDepID']==5){
					$addsql = " and ClassId like '%Sales%' ";
				}

                             $sql = "SELECT * from inv_tax_rates  where 1 ".$addsql." ORDER BY  Coid Desc";
                            return $this->query($sql, 1);
                        }

                        function getTaxClassName($classID) {
                           $sql = "select * from inv_tax_classes where ClassId IN (".$classID.")"; 
                            return $this->query($sql, 1);
                        }

                        function getTaxById($id) {
                            $sql = "SELECT * from inv_tax_rates WHERE  RateId = '" . $id . "'";
                            return $this->query($sql, 1);
                        }

                        function updateTax($arryDetails) {
                            @extract($arryDetails);

                            $ClassId = implode(",",$ClassId);

                            $sql = "UPDATE  inv_tax_rates SET ClassId='" .mysql_real_escape_string($ClassId). "', Coid = '" . mysql_real_escape_string($country_id). "', Stid ='" .mysql_real_escape_string($main_state_id). "', locationID = '" .$_SESSION['locationID'] . "',TaxRate ='" .mysql_real_escape_string($TaxRate). "',RateDescription = '" .mysql_real_escape_string($RateDescription). "', Status='" . mysql_real_escape_string($Status) . "',FreightTax = '" .mysql_real_escape_string($FreightTax). "' WHERE RateId='".$taxId."'";
                            $this->query($sql, 0);
                        }

                        function deleteTax($id) {

                            $sql = "DELETE from inv_tax_rates where  RateId = '" . $id."'";
                            $rs = $this->query($sql, 0);

                            if (sizeof($rs))
                                return true;
                            else
                                return false;
                     }

                        function changeTaxStatus($id) {
                            $sql = "select * from inv_tax_rates where RateId='" . $id."'";
                            $rs = $this->query($sql);
                            if (sizeof($rs)) {
                                if ($rs[0]['Status'] == 'Yes')
                                    $Status = 'No';
                                else
                                    $Status = 'Yes';

                                $sql = "update inv_tax_rates set Status='" . $Status . "' where RateId='" . $id."'";
                                $this->query($sql, 0);
                                return true;
                            }
                        }


			function GetTaxRate($ClassId)
			{


if($ClassId==2) $ClassName='Purchase';
				else if($ClassId==1) $ClassName='Sales';
				$strSQLFeaturedQuery = (!empty($ClassId))?(" where ClassId like '%".$ClassName."%' and Status='Yes' "):(" where locationID='".$_SESSION['locationID']."'");

				$OrderSql = " order by ClassId asc";

				$strSQLQuery = "select * from inv_tax_rates ".$strSQLFeaturedQuery.$OrderSql;


			        return $this->query($strSQLQuery, 1);
			}

			function GetTaxByLocation($ClassId,$country_id,$state_id)
			{ 	
				if($ClassId==2) $ClassName='Purchase';
				else if($ClassId==1) $ClassName='Sales';

				$strAddQuery = (!empty($ClassId))?(" and ClassId like '%".$ClassName."%' "):("");
				$sql = "select * from inv_tax_rates where Status='Yes' ".$strAddQuery." and ((Coid='".$country_id."' and Stid='".$state_id."') OR (Coid='".$country_id."' and Stid='0') OR (Coid='0' and Stid='0')) order by ClassId asc";
				return $this->query($sql, 1);
			}

                 
			function GetTaxAll($ClassId,$country_id='',$state_id='')
			{ 	
				if($ClassId==2) $ClassName='Purchase';
				else if($ClassId==1) $ClassName='Sales';

				$strAddQuery='';

				$strAddQuery .= (!empty($ClassId))?(" and ClassId like '%".$ClassName."%' "):("");
				$sql = "select * from inv_tax_rates where Status='Yes' ".$strAddQuery." order by ClassId asc";
				return $this->query($sql, 1);
			}


                   
              function isTaxNameExists($Name,$ClassID,$country,$state,$RateId=0)
		{

			$strSQLQuery ="select RateId from inv_tax_rates where LCASE(RateDescription)='".strtolower(trim($Name))."'";

			$strSQLQuery .= ($RateId>0)?(" and RateId != '".$RateId."'"):("");
			$strSQLQuery .= (!empty($ClassID))?(" and ClassId = '".$ClassID."' "):("");
                         $strSQLQuery .= (!empty($country))?(" and Coid = '".$country."'"):("");
			$strSQLQuery .= ($state>0)?(" and Stid = '".$state."' "):("");
                        
                       #echo $strSQLQuery; exit;

			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['RateId'])) {
				return true;
			} else {
				return false;
			}
		}

    /*     * ***************************************************************End Functions For Taxes****************************************************************** */

   
 }

?>
