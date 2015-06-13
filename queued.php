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
	function secs2Mins(e) {
		var m = Math.floor(e / 60);
		var s = e - (m * 60);
		if ( s < 10 ) {
			s = '0' + s;
		}
		var l = m + ':' + s;
		return l;
	}
	// refresh page every three minutes
	setInterval(function() {
		window.location.reload();
	}, 180000);
	</script>
</head>
<body>
	<main>
		<header>
			<img src="images/icmlm_logo_ALT.png" width="159" height="104" alt="" border="0">
			<h1>Instant Composer Queued Scores</h1>
			<div style="clear:both;"></div>
		</header>
		<div id="playing" style="float:none; width:100%">			
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
		<div id="queued" style="float:none; width:100%">
			<h2>Queued Scores</h3>
<?php
		// Load queued scores
		$query = "SELECT * FROM icmlm_scores WHERE status = 'queued' ORDER BY queue_time ASC";
		$results = mysql_query($query);
		while( $row = mysql_fetch_array($results) ) {
?>
				<div id="queued<?php echo $row['id'];?>">
					<h3><strong><?php echo $row['title']; ?></strong></h2>
					<h4><strong>By <?php echo $row['author']; ?></strong></h3>
					<p class="review">Perform a piece for <strong><?php echo $row['instruments']; ?></strong>. Play within a tonality of <strong><?php echo $row['tonality']; ?></strong>, and within dynamics that (are) <strong><?php echo $row['dynamics']; ?></strong>. Play the composition so that is sets a(n) <strong><?php echo $row['mood']; ?></strong> mood at a tempo of <strong><?php echo $row['tempo']; ?></strong>. This piece will be performed for <strong><?php echo secs2mins($row['length']); ?></strong> minutes.</p>
					<p class="bottom"></p>
				</div>
<?php
		}
?>
			</form>
		</div>
	</main>
</body>
</html>