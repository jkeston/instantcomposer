<?php
	switch($_POST['action']) {
		case 'authenticate':
			if ($_POST['icmlm_pw'] == 'madlibbed229') {
				setcookie('icmlm_auth','madlibbed229');
				header('Location: moderate.php');
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
		default:
			break;
	}
?>