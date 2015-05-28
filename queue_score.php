<?php
	include('icmlm_config.php');
	// $inst = implode(',',$_POST['instruments']);
	$query = "INSERT INTO icmlm_scores (
		title,		
		author,		
		instruments,
		tonality,	
		dynamics,	
		mood,		
		tempo,		
		length,		
		queue_time )
		VALUES ( '".
		$_POST['title']."','".		
		$_POST['author']."','".		
		$_POST['inst_joined']."','".
		$_POST['tonality']."','".
		$_POST['dynamics']."','".
		$_POST['mood']."','".
		$_POST['tempo']."',".	
		$_POST['length'].",".
		'NOW() )';
	mysql_query($query);
	header("Location: thanks.html");
?>