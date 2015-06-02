<?php
	include('icmlm_config.php');
	$sid = $_POST['sid'];

	// $inst = implode(',',$_POST['instruments']);
	if ($_POST['action'] == 'load' ) {
		error_log('load');
		$query = "SELECT * icmlm_scores WHERE status='queued' ORDER BY queue_time ASC LIMIT 5";
		$results = mysql_query($query);
		while( $row = mysql_fetch_array($results) ) {
			$output[] = array(
							'id'				=> $row['id'],
							'title' 	 		=> $row['title'],
							'author' 	 	=> $row['author'],
							'instruments'	=> $row['instruments'],
							'tonality'		=> $row['tonality'],
							'dynamics'		=> $row['dynamics'],
							'mood'			=> $row['mood'],
							'tempo'			=> $row['tempo'],
							'len'				=> $row['length']		
							);
		}
		echo json_encode($output);
	}
	if ($_POST['action'] == 'start' ) {
		$query = "SELECT id FROM icmlm_scores WHERE status='playing'";
		$result = mysql_query($query);
		if ( mysql_num_rows($result) > 0 ) {
			$output = array('status' => false);
	    	echo json_encode($output);
		}
		else {
			$query = "UPDATE icmlm_scores SET status='playing' WHERE id=$sid";
			$result = mysql_query($query);
			if ( $result ) {
				$query = "SELECT * FROM icmlm_scores WHERE id=$sid ";
				$row = mysql_fetch_array(mysql_query($query));
				$output = array('status' 		=> true,
								'id'			=> $row['id'],
								'title' 	 	=> $row['title'],
								'author' 	 	=> $row['author'],
								'instruments'	=> $row['instruments'],
								'tonality'		=> $row['tonality'],
								'dynamics'		=> $row['dynamics'],
								'mood'			=> $row['mood'],
								'tempo'			=> $row['tempo'],
								'len'		=> $row['length']
								);
	    		echo json_encode($output);
			}
		}
	}
	if ($_POST['action'] == 'stop' ) {
		$query = "UPDATE icmlm_scores SET status='played' WHERE id=$sid";
		$result = mysql_query($query);
		$output = array('status'=>true );
		echo json_encode($output);
	}
?>