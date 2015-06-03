<?php
	$message = '';
	switch($_POST['action']) {
		case 'authenticate':
			if ($_POST['icmlm_pw'] == 'madlibbed229') {
				setcookie('icmlm_auth','madlibbed229');
				header('Location: '.$_POST['path']);
				exit;
			}
			break;
		case 'moderate':
			foreach ( $_POST['approval'] as $key => $value ) {
				$query = "UPDATE icmlm_scores SET status = '$value' WHERE id = $key";
				// error_log($query);
				mysql_query($query);
			}
			break;
		case 'set_status':
			header('Location: moderate.php?score_status='.$_POST['new_status']);
			break;
		case 'update_instruments':
			foreach( $_POST['new_status'] as $k => $v ) {
				
				if ( $v == 'delete' ) {
					$query = "DELETE FROM icmlm_instruments WHERE id=$k";
				}
				else {
					$query = "UPDATE icmlm_instruments SET status = '$v' WHERE id=$k";
				}
				error_log($query);
				$result = mysql_query($query);
			}
			if (!empty($_POST['new_instrument'])) {
				$new_inst = strtolower($_POST['new_instrument']);
				$query = "SELECT id FROM icmlm_instruments WHERE name = '".$new_inst."'";
				$result = mysql_query($query);
				if ( mysql_num_rows($result) > 0 ) {
					$message = '				<p id="nothing">That instrument is already listed</p>'."\n";
					error_log($message);
					break;
				}
				$query = "INSERT INTO icmlm_instruments (name) VALUES ('".$new_inst."')";
				// error_log($query);
				mysql_query($query);

			}
		default:
			break;
	}
?>