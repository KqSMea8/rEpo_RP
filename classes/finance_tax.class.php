<?php
class tax extends dbClass {

    var $tables;

    // consturctor 
    function tax() {
        global $configTables;
        $this->tables = $configTables;
        $this->dbClass();
    }


                 
                      function addTax($arryDetails) {
                            @extract($arryDetails);

                            $UserLevel = $arryDetails['user_level'][0] . "," . $arryDetails['user_level'][1];
                            $UserLevel = rtrim($UserLevel);

                            $sql = "INSERT INTO f_tax SET locationID = '" . $_SESSION['locationID'] . "',TaxRate ='" . $TaxRate . "',  TaxName = '" . $TaxName . "', Status='" . $Status . "'";
                            $this->query($sql, 0);
                        }

                        function getTaxes() {
                            $sql = "SELECT * from f_tax  where locationID='".$_SESSION['locationID']."' ORDER BY TaxID DESC";
                            return $this->query($sql, 1);
                        }

                       

                        function getTaxById($id) {
                            $sql = "SELECT * from f_tax WHERE locationID='".$_SESSION['locationID']."' and  TaxID = '" . $id . "'";
                            return $this->query($sql, 1);
                        }

                        function updateTax($arryDetails) {
                            @extract($arryDetails);

                            $UserLevel = $arryDetails['user_level'][0] . "," . $arryDetails['user_level'][1];
                            $UserLevel = rtrim($UserLevel);

                            $sql = "UPDATE  f_tax SET locationID = '" . $_SESSION['locationID'] . "',TaxRate ='" . $TaxRate . "',TaxName = '".$TaxName."', Status='" . $Status . "' WHERE TaxID='" . $TaxID."'";
                            $this->query($sql, 0);
                        }

                        function deleteTax($id) {

                            $sql = "DELETE from f_tax where locationID='".$_SESSION['locationID']."' and TaxID = '" . $id."'";
                            $rs = $this->query($sql, 0);

                            if (sizeof($rs))
                                return true;
                            else
                                return false;
                     }

                        function changeTaxStatus($id) {
                            $sql = "select * from f_tax where locationID='".$_SESSION['locationID']."' And TaxID='" . $id."'";
                            $rs = $this->query($sql);
                            if (sizeof($rs)) {
                                if ($rs[0]['Status'] == 'Yes')
                                    $Status = 'No';
                                else
                                    $Status = 'Yes';

                                $sql = "update f_tax set Status='" . $Status . "' where TaxID='" . $id."'";
                                $this->query($sql, 0);
                                return true;
                            }
                        }

				  function GetTaxRate()
						{

							$strSQLFeaturedQuery = " where Status='Yes' and locationID='".$_SESSION['locationID']."'";
							$OrderSql = " order by TaxID asc";
							$strSQLQuery = "select * from f_tax ".$strSQLFeaturedQuery.$OrderSql;
							return $this->query($strSQLQuery, 1);
							}

              
                                    
					function isTaxNameExists($Name,$ClassID,$TaxID=0)
					{

						$strSQLQuery ="select TaxID from f_tax where LCASE(RateDescription)='".strtolower(trim($Name))."'";

						$strSQLQuery .= ($TaxID>0)?(" and TaxID != '".$TaxID."'"):("");
						$strSQLQuery .= (!empty($ClassID))?(" and ClassId = '".$ClassID."' "):("");



						$arryRow = $this->query($strSQLQuery, 1);
						if (!empty($arryRow[0]['TaxID'])) {
						return true;
						} else {
						return false;
						}
					}

   
 }

?>
