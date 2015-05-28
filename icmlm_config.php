<?php
    // connect to database
    $dbh = mysql_connect("localhost", "your_db_user", "your_db_password") or die("Connection failed");
    mysql_select_db("your_database");
    // Set timezine
    date_default_timezone_set('America/Chicago');
?>