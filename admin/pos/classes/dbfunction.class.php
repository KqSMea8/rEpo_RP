<?php
class dbFunction extends dbClass
{ 

	var $tables;
	
	// consturctor 
	function dbFunction(){
		global $configTables;
		$this->tables=$configTables;
		$this->dbClass();
	}
	
	
//********** Prepare Query ******************/
		public function prepare( $query, $args ) {
		if ( is_null( $query ) )
			return;
		$args = func_get_args();
		array_shift( $args );
		
		// If args were passed as an array (as in vsprintf), move them up
		if ( isset( $args[0] ) && is_array($args[0]) )
			$args = $args[0];
		$query = str_replace( "'%s'", '%s', $query ); // in case someone mistakenly already singlequoted it
		$query = str_replace( '"%s"', '%s', $query ); // doublequote unquoting
		$query = preg_replace( '|(?<!%)%f|' , '%F', $query ); // Force floats to be locale unaware
		$query = preg_replace( '|(?<!%)%s|', "'%s'", $query ); // quote the strings, avoiding escaped strings like %%s
		array_walk( $args, array( $this, 'escape_by_ref' ) );
	
		return @vsprintf( $query, $args );
	}
	/*
	 * Insert Query execute
	 *
	 * @$table (string) Tabel Name  
	 * @$data (array) data for save key-value
	 * @return (true Or false)
	 */
	public function insert( $table, $data, $format = null ) {
		return $this->_insert_replace_helper( $table, $data, $format, 'INSERT' );
	}
	/*
	 * Insert Query Make
	 *
	 * @$table (string) Tabel Name  
	 * @$data (array) data for save key-value
	 * @return (true Or false)
	 */
	function _insert_replace_helper( $table, $data, $format = null, $type = 'INSERT' ) {
		if ( ! in_array( strtoupper( $type ), array( 'REPLACE', 'INSERT' ) ) )
			return false;
		$this->insert_id = 0;
		$formats = $format = (array) $format;
		$fields = array_keys( $data );
		$formatted_fields = array();
		foreach ( $fields as $field ) {
			if ( !empty( $format ) )
				$form = ( $form = array_shift( $formats ) ) ? $form : $format[0];
			elseif ( isset( $this->field_types[$field] ) )
				$form = $this->field_types[$field];
			else
				$form = '%s';
			$formatted_fields[] = $form;
		}
		 $sql = "{$type} INTO `$table` (`" . implode( '`,`', $fields ) . "`) VALUES (" . implode( ",", $formatted_fields ) . ")";
	        $this->query( $this->prepare( $sql, $data ));
		return mysql_insert_id();
	}
	/*
	 * Upadate Query execute
	 *
	 * @$table (string) Tabel Name  
	 * @$data (array) data for save key-value
	 * @return (true Or false)
	 */
	public function update( $table, $data, $where, $format = null, $where_format = null ) {
		if ( ! is_array( $data ) || ! is_array( $where ) )
			return false;

		$formats = $format = (array) $format;
		$bits = $wheres = array();
		foreach ( (array) array_keys( $data ) as $field ) {
			if ( !empty( $format ) )
				$form = ( $form = array_shift( $formats ) ) ? $form : $format[0];
			elseif ( isset($this->field_types[$field]) )
				$form = $this->field_types[$field];
			else
				$form = '%s';
			$bits[] = "`$field` = {$form}";
		}

		$where_formats = $where_format = (array) $where_format;
		foreach ( (array) array_keys( $where ) as $field ) {
			if ( !empty( $where_format ) )
				$form = ( $form = array_shift( $where_formats ) ) ? $form : $where_format[0];
			elseif ( isset( $this->field_types[$field] ) )
				$form = $this->field_types[$field];
			else
				$form = '%s';
			$wheres[] = "`$field` = {$form}";
		}

		$sql = "UPDATE `$table` SET " . implode( ', ', $bits ) . ' WHERE ' . implode( ' AND ', $wheres );
		return $this->query( $this->prepare( $sql, array_merge( array_values( $data ), array_values( $where ) ) ) );
	}
	
	public function get_results( $query = null,$output=1,$record=0 ) {
	  	 $result = mysql_query($query);
		   $this->resResult=$result;	// Added by Amit jha date : 22/03/2006 project title : allstate //
		   if(!$result) die('Query failed: ' . mysql_error());
			   if ($output == 1) {
				 $results = array();
				 while($row = mysql_fetch_object($result)) {
				   $results[] = $row;		   
				 }
				 if($record) 
				 {
					 $this->_recordQuery(date("d-m-Y  H:m:s").' : '.$query);
				 }
		   return $results;
		   }
		   else {
			 return 0;
		   }
	}
	public function delete( $table, $where, $where_format = null ) {
		if ( ! is_array( $where ) )
			return false;

		$wheres = array();

		$where_formats = $where_format = (array) $where_format;

		foreach ( array_keys( $where ) as $field ) {
			if ( !empty( $where_format ) ) {
				$form = ( $form = array_shift( $where_formats ) ) ? $form : $where_format[0];
			} elseif ( isset( $this->field_types[ $field ] ) ) {
				$form = $this->field_types[ $field ];
			} else {
				$form = '%s';
			}

			$wheres[] = "$field = $form";
		}

		$sql = "DELETE FROM $table WHERE " . implode( ' AND ', $wheres );
		return $this->query( $this->prepare( $sql, $where ) );
	}
	
}
?>
