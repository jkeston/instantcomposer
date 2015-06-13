<?php
	include('icmlm_config.php');
	$query = "SELECT * FROM icmlm_instruments WHERE status='available' ORDER BY name";
	// error_log($query);
	$results = mysql_query($query);
	$options = '<option value="">Choose the Instruments</option>'."\n";
	$inst_count = 0;
	while( $row = mysql_fetch_array($results) ) {
		++$inst_count;
		$options .= '<option value="'.$row['name'].'">'.ucwords($row['name'])."</option>\n";
	}
	if ($inst_count > 0) {
		$values = array('status' => true,'options' => $options);
		// error_log("ENTERED|".print_r($output,true)."|");
		// error_log($options);
		echo json_encode($values);
	}
	else {
		$values = array('status' => false);
		// error_log("ENTERED|".print_r($output,true)."|");
		echo json_encode($values);
	}
?>