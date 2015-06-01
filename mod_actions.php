<?php
	switch($_POST['action']) {
		case 'authenticate':
			if ($_POST['icmlm_pw'] == 'password') {
				setcookie('icmlm_auth','password');
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
		default:
			break;
	}
?>