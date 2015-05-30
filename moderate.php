<?
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
	<script src="js/jquery-2.1.4.min.js"></script>
	<script src="js/jquery-ui.min.js"></script>
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
	</style>
</head>
<body>
	<main>
		<header>
			<h1>Instant Composer Moderation</h1>
		</header>

<?php
	if ($_COOKIE['icmlm_auth'] != 'madlibbed229') {
?>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<input type="hidden" name="action" value="authenticate" />
		<p>Please enter the password to moderate the scores:</p>
		<input type="password" name="icmlm_pw" />
		<input type="submit" value="Login" />
	</form>
<?php
	}
	else {
?>
		<div id="moderation">
			<h2>Scores in Moderation</h3>
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<input type="hidden" name="action" value="moderate" />
<?php
		// Load pending scores
		$query = "SELECT * FROM icmlm_scores WHERE status = 'pending' ORDER BY queue_time ASC";
		$results = mysql_query($query);
		while( $row = mysql_fetch_array($results) ) {
?>
				<h3><strong id="review_title"><?php echo $row['title']; ?></strong></h2>
				<h4><strong id="review_author">By <?php echo $row['author']; ?></strong></h3>
				<p class="review">Perform a piece for <strong id="review_instruments"><?php echo $row['instruments']; ?></strong>. Play within a tonality of <strong id="review_tonality"><?php echo $row['tonality']; ?></strong>, and within dynamics that (are) <strong id="review_dynamics"><?php echo $row['dynamics']; ?></strong>. Play the composition so that is sets a <strong id="review_mood"><?php echo $row['mood']; ?></strong> mood at a tempo of <strong id="review_tempo"><?php echo $row['tempo']; ?></strong>. This piece will be performed for <strong id="review_length"><?php echo secs2mins($row['length']); ?></strong> minutes.</p>
				<label><input type="radio" name="approval[<?php echo $row['id']; ?>]" value="profane" /> Reject (profane)</label>
				<label><input type="radio" name="approval[<?php echo $row['id']; ?>]" value="nonsense" /> Reject (nonsense)</label>
				<label><input type="radio" name="approval[<?php echo $row['id']; ?>]" value="queued" /> Approve</label>
				<p class="bottom"></p>
<?php
		}
?>
				<input type="submit" value="Moderate Pending" />
			</form>
		</div>
		<div id="queued">
			<h2>Queued Scores</h3>
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<input type="hidden" name="action" value="moderate" />
<?php
		// Load queued scores
		$query = "SELECT * FROM icmlm_scores WHERE status = 'queued' ORDER BY queue_time ASC";
		$results = mysql_query($query);
		while( $row = mysql_fetch_array($results) ) {
?>
				<h3><strong id="review_title"><?php echo $row['title']; ?></strong></h2>
				<h4><strong id="review_author">By <?php echo $row['author']; ?></strong></h3>
				<p class="review">Perform a piece for <strong id="review_instruments"><?php echo $row['instruments']; ?></strong>. Play within a tonality of <strong id="review_tonality"><?php echo $row['tonality']; ?></strong>, and within dynamics that (are) <strong id="review_dynamics"><?php echo $row['dynamics']; ?></strong>. Play the composition so that is sets a <strong id="review_mood"><?php echo $row['mood']; ?></strong> mood at a tempo of <strong id="review_tempo"><?php echo $row['tempo']; ?></strong>. This piece will be performed for <strong id="review_length"><?php echo secs2mins($row['length']); ?></strong> minutes.</p>
				<label><input type="radio" name="approval[<?php echo $row['id']; ?>]" value="profane" /> Reject (profane)</label>
				<label><input type="radio" name="approval[<?php echo $row['id']; ?>]" value="nonsense" /> Reject (nonsense)</label>
				<label><input type="radio" name="approval[<?php echo $row['id']; ?>]" value="pending" /> Unapprove</label>
				<p class="bottom"></p>
<?php
		}
?>
				<input type="submit" value="Modify Queued" />
			</form>
		</div>
<?php
	}
?>
	</main>
</body>
</html>