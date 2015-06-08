<?php
    // connect to database
    $dbh = mysql_connect("localhost", "unearthe_icmlm", "madlibbed229") or die("Connection failed");
    mysql_select_db("unearthe_icmlm");
    // Set timezine
    date_default_timezone_set('America/Chicago');

    function secs2Mins($e) {
		$m = floor($e / 60);
		$s = $e - ($m * 60);
		if ( $s < 10 ) {
			$s = '0' . $s;
		}
		$l = $m . ':' . $s;
		return $l;
	}
?>
