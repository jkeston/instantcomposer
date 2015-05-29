<?php
	if ($_POST['icmlm_pw'] == 'madlibbed229') {
		setcookie('icmlm_auth','madlibbed229');
		header('Location: moderate.php');
	}
?>