<?php
	include('icmlm_config.php');

	// $action = $_POST['action']; 
	// Decode JSON object into readable PHP object
	// $f = json_decode($_POST['formData']);

	parse_str($_POST['formData'], $f);
	// error_log("a|".print_r($f,true)."|");
	// error_log("b|".print_r($_POST,true)."|");
	// error_log("c|".$_POST['formData']."|");

	// $inst = implode(',',$_POST['instruments']);
	$query = "SELECT title FROM icmlm_scores WHERE title='".$f['title']."'";
	$result = mysql_query($query);
	if ( mysql_num_rows($result) > 0 ) {
		$output = array('status' => false);
		// error_log("DUPLICATE|".print_r($output,true)."|".$query."|".mysql_num_rows($result));
    	echo json_encode($output);
	}
	else {
		if (empty($f['author'])) {
			$f['author'] = 'Anonymous';
		}
		$query = "INSERT INTO icmlm_scores (
			title,		
			author,
			email,
			notify,
			instruments,
			tonality,	
			dynamics,	
			mood,		
			tempo,		
			length,		
			queue_time )
			VALUES ( '".
			$f['title']."','".
			$f['author']."','".
			$f['email']."','".
			$f['notify']."','".
			$f['inst_joined']."','".
			$f['tonality']."','".
			$f['dynamics']."','".
			$f['mood']."','".
			$f['tempo']."',".	
			$f['length'].",".
			'NOW() )';
		if ( mysql_query($query) ) {
			$q = "SELECT COUNT(*) FROM icmlm_scores WHERE status='queued' OR status='pending' ";
			$t = mysql_fetch_row(mysql_query($q));
			$output = array('status' => true,'queued_pending' => $t[0]);
			// error_log("ENTERED|".print_r($output,true)."|");
    		echo json_encode($output);
		}
	}
?>