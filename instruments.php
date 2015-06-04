<?php
	include('icmlm_config.php');
	if ( count($_POST) > 0 ) {
		include('mod_actions.php');
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Instant Composer: Mad-libbed Music</title>
	<meta name="viewport" content="height=device-height, width=device-width, initial-scale=1, user-scalable=no">
	<link rel="stylesheet" href="css/webapp.css" />
	<link rel="stylesheet" href="css/mod_inst.css" />
	<script src="js/jquery-2.1.4.min.js"></script>
	<script src="js/jquery-ui.min.js"></script>
	<script>
	var playing = false;
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
	// setInterval(function(){ 
	// 	if ( playing ) {
	// 		var time = $('#review_length').html();
	// 		var p = time.split(':');
	// 		var secs = ( Number(p[0]) * 60 ) + Number(p[1]);
	// 		secs -= 1;
	// 		$('#review_length').html(secs2Mins(secs));
	// 		if (secs < 1) {
	// 			stopScore($('#playing_id').val());
	// 			playing = false;
	// 		}
	// 	}
	// }, 100);
	</script>
</head>
<body>
	<main>
		<header>
			<h1>Instant Composer Instruments</h1>
			<p><a href="moderate.php">Moderate Scores</a> | Manage Instruments</p>
		</header>

<?php
	if ($_COOKIE['icmlm_auth'] != 'madlibbed229') {
?>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<input type="hidden" name="action" value="authenticate" />
		<input type="hidden" name="path" value="instruments.php" />
		<p>Please enter the password to update the available instruments:</p>
		<input type="password" name="icmlm_pw" />
		<input type="submit" value="Login" />
	</form>
<?php
	}
	else {
?>
		<div id="instruments">
			<h2>Instruments Available</h3>
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<input type="hidden" name="action" value="update_instruments" />
<?php
	// TO DO: list instruments
	$query = 'SELECT * FROM icmlm_instruments ORDER BY name';
	$results = mysql_query($query);
	while( $row = mysql_fetch_array($results) ) {
		$available = '';
		$unavailable = '';
		$$row['status'] = ' selected="true"';
?>
			<label for="new_status" style="display:block;">
				<select name="new_status[<?php echo $row['id']; ?>]">
					<option value="available"<?php echo $available; ?>>Available</option>
					<option value="unavailable"<?php echo $unavailable; ?>>Unavailable</option>
					<option value="delete">Delete</option>
				</select>
				<?php echo ' '.ucwords($row['name']); ?>
			</label>
<?php		
	} // END while
?>
				<p>Add New Instrument: <input type="text" value="" name="new_instrument" autofocus="true" /></p>
				<input type="submit" value="Update" />
<?php 
	echo($message);
?>
			</form>				
		</div>
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
			<p id="nothing">Nothing currently playing.</p>
<?php
		}
?>
		</div>
<?php
	}
?>
	</main>
</body>
</html>