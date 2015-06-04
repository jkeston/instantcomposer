<!DOCTYPE html>
<html>
<head>
	<title>Instant Composer: Mad-libbed Music</title>
	<meta name="viewport" content="height=device-height, width=device-width, initial-scale=1, user-scalable=no">
	<link rel="stylesheet" href="css/viewer.css" />
	<script src="js/jquery-2.1.4.min.js"></script>
	<script src="js/viewer.js"></script>
	<script src="js/p5.min.js"></script>
	<script src="js/p5.sound.js"></script>
	<script src="js/p5.icmlm.js"></script>
</head>
<body>
	<div id="visuals"></div>
	<main>
		<div id="playing">
			<header></header>
			<input type="hidden" id="playing_id" value="" />
			<div id="view_score">
				<h3><strong id="review_title">___________</strong></h3>
				<h4><strong id="review_author">By ___________</strong></h4>
				<p class="review">Perform a piece for <strong id="review_instruments">___________</strong>. Play within a tonality of <strong id="review_tonality">___________</strong>, and within dynamics that (are) <strong id="review_dynamics">___________</strong>. Play the composition so that is sets a(n) <strong id="review_mood">___________</strong> mood at a tempo of <strong id="review_tempo">___________</strong>. This piece will be performed for <strong id="review_length">___________</strong> minutes.</p>
			</div>
		</div>
		<div id="queued">
			<h2>Coming Up</h2>
			<div id="qlist">
			</div>
		</div>
	</main>
</body>
</html>