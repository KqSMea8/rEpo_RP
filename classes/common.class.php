<?

class common extends dbClass
{
	 function GetBanner(){
		$strSQLQuery ="SELECT * FROM banner order by rand()";
		return $this->query($strSQLQuery, 1);
	 }

	function GetAdmin(){
		$strSQLQuery ="select * from admin  where AdminID='1' ";
		return $this->query($strSQLQuery, 1);
	 }


}

?>
