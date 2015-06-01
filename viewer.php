<?
	include('icmlm_config.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Instant Composer: Mad-libbed Music</title>
	<meta name="viewport" content="height=device-height, width=device-width, initial-scale=1, user-scalable=no">
	<link rel="stylesheet" href="css/webapp.css" />
	<script src="js/jquery-2.1.4.min.js"></script>
	<script src="js/jquery-ui.min.js"></script>
	<script>
	var playing = false;
	window.onload = function() {
		loadQueued();
	}
	function loadQueued() {
		$.ajax({
			url: 'start_score.php',
         data: { 
				action: 'load'
			},
         type: 'post',                   
         async: 'false',
			dataType: 'json',
            success: function(result) {
            	// alert('result|'+result.status);
            	alert(result);
            },
        });
        return false;	
	}





	}
	function startScore(sid) {
		$.ajax({
			url: 'start_score.php',
         data: { 
				action: 'start', 
				sid: sid
			},
         type: 'post',                   
         async: 'false',
			dataType: 'json',
            success: function(result) {
            	// alert('result|'+result.status);
                if ( result.status == true ) {
                	playing = true;
                	$('#playing_id').val(result.id);
					$('#review_title').html(result.title);
					$('#review_author').html('By '+result.author);
					$('#review_instruments').html(result.instruments);
					$('#review_tonality').html(result.tonality);
					$('#review_tempo').html(result.tempo);
					$('#review_length').html(secs2Mins(result.len));
					$('#review_mood').html(result.mood);
					$('#review_dynamics').html(result.dynamics);
					$('#nothing').html('');
					$('#queued'+result.id).slideToggle(500, function() {
						$('#queued'+result.id).remove(); 
					});
                }
                if (result.status == false ) {
                	$('#nothing').html('This score is still playing. Please wait until it is finished.');
                }
            },
        });
        return false;	
	}
	function stopScore(sid) {
		$.ajax({
			url: 'start_score.php',
            data: { 
            	action: 'stop', 
            	sid: sid
            },
            type: 'post',                   
            async: 'false',
			dataType: 'json',
            success: function(result) {
            	// alert('result|'+result.status);
                if ( result.status == true ) {
                	playing = false;
                	$("#playing_id").val('');
					$("#review_title").html('___________');
					$("#review_author").html('By ___________');
					$("#review_instruments").html('___________');
					$("#review_tonality").html('___________');
					$("#review_tempo").html('___________');
					$("#review_length").html('___________');
					$("#review_mood").html('___________');
					$("#review_dynamics").html('___________');
					$("#nothing").html('Nothing currently playing. Start another piece below.');
                }
            },
        });
        return false;	
	}
	function secs2Mins(e) {
		var m = Math.floor(e / 60);
		var s = e - (m * 60);
		if ( s < 10 ) {
			s = '0' + s;
		}
		var l = m + ':' + s;
		return l;
	}
	setInterval(function(){ 
		if ( playing ) {
			var time = $('#review_length').html();
			var p = time.split(':');
			var secs = ( Number(p[0]) * 60 ) + Number(p[1]);
			secs -= 1;
			$('#review_length').html(secs2Mins(secs));
			if (secs < 1) {
				stopScore($('#playing_id').val());
				playing = false;
			}
		}
	}, 1000);
	</script>
	<style>
	* {
		box-sizing: border-box;
	}
	main, body, html {
		padding: 0;
		margin: 0;
	}
	header {
		padding: 0.25em;
		background-color: #e9e9e9;
	}
	h1 {
		text-align: center;
	}
	button {
		padding: 0.5em !important;
	}
	.bottom {
		border-bottom: 1px solid #ccc;
	}
	#moderation {
		padding: 1em;
		width: 50%;
		float: left;
	}
	#queued {
		padding: 1em;
		width: 50%;
		float: right;
	}
	#playing {
		background-color: #cfc;
		padding: 1em;
		width: 50%;
		float: right;
	}
	#nothing {
		color: #e42328;
	}
	</style>
</head>
<body>
	<main>
		<div id="playing">			
			<h2>Currently Playing</h3>
<?php
		// Load playing score
		$query = "SELECT * FROM icmlm_scores WHERE status = 'playing'";
		$results = mysql_query($query);
		if ( $row = mysql_fetch_array($results) ) {
?>
			<script>playing = true;</script>
			<input type="hidden" id="playing_id" value="<?php echo $row['id']; ?>" />
			<h3><strong id="review_title"><?php echo $row['title']; ?></strong></h2>
			<h4><strong id="review_author">By <?php echo $row['author']; ?></strong></h3>
			<p class="review">Perform a piece for <strong id="review_instruments"><?php echo $row['instruments']; ?></strong>. Play within a tonality of <strong id="review_tonality"><?php echo $row['tonality']; ?></strong>, and within dynamics that (are) <strong id="review_dynamics"><?php echo $row['dynamics']; ?></strong>. Play the composition so that is sets a(n) <strong id="review_mood"><?php echo $row['mood']; ?></strong> mood at a tempo of <strong id="review_tempo"><?php echo $row['tempo']; ?></strong>. This piece will be performed for <strong id="review_length"><?php echo secs2mins($row['length']); ?></strong> minutes.</p>
			<p id="nothing">&nbsp;</p>
<?php			
		}
		else {
?>
			<input type="hidden" id="playing_id" value="" />
			<h3><strong id="review_title">___________</strong></h2>
			<h4><strong id="review_author">By ___________</strong></h3>
			<p class="review">Perform a piece for <strong id="review_instruments">___________</strong>. Play within a tonality of <strong id="review_tonality">___________</strong>, and within dynamics that (are) <strong id="review_dynamics">___________</strong>. Play the composition so that is sets a(n) <strong id="review_mood">___________</strong> mood at a tempo of <strong id="review_tempo">___________</strong>. This piece will be performed for <strong id="review_length">___________</strong> minutes.</p>
			<p id="nothing">Nothing currently playing. Start another piece below.</p>
<?php
		}
?>
		</div>
		<div id="queued">
			<h2>Queued Scores</h3>
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<input type="hidden" name="action" value="moderate" />
<?php
		// Load queued scores
		$query = "SELECT * FROM icmlm_scores WHERE status = 'queued' ORDER BY queue_time ASC LIMIT 5";
		$results = mysql_query($query);
		while( $row = mysql_fetch_array($results) ) {
?>
				<div id="queued<?php echo $row['id'];?>">
					<h3><strong><?php echo $row['title']; ?></strong></h2>
					<h4><strong>By <?php echo $row['author']; ?></strong></h3>
					<p class="review">For <strong><?php echo $row['instruments']; ?></strong>
					<button onclick="startScore(<?php echo $row['id']; ?>);return false;">START!</button>
				</div>
<?php
		}
?>
		</div>
	</main>
</body>
</html>