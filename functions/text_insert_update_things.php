
<?php	

function text_insert_update_things($sample_name,$field_name){

	include($_SESSION['include_path'].'database_connection.php');

	$query = "SELECT * FROM store_user_things WHERE sample_name = ?";
	$stmt = $dbc->prepare($query);
	$stmt -> bind_param('s',$sample_name);
	if ($stmt->execute()){
	    			
	    if($stmt->fetch()){
	    	$meta = $stmt->result_metadata(); 
   			while ($field = $meta->fetch_field()){ 
        		$params[] = &$row[$field->name]; 
    		} 

    		call_user_func_array(array($stmt, 'bind_result'), $params); 
				
			$stmt->execute();
			while ($stmt->fetch()) {
				#echo $row[$field_name];
				if($field_name == 'sample_num'){//check that returned number is output as 3 digits
					$regrex_check_sn1  = '/^[0-9]$/';
					if (preg_match("$regrex_check_sn1", $row[$field_name])){
						$row[$field_name]= '00'.$row[$field_name];
					}
					else{
						$regrex_check_sn2  = '/^[0-9][0-9]$/';
						if (preg_match("$regrex_check_sn2", $row[$field_name])){
							$row[$field_name] = '0'.$row[$field_name];
						}
					}
				}
				return htmlspecialchars($row[$field_name]); 		
			}		
			$stmt->close();
		} 
	}
}
?>
