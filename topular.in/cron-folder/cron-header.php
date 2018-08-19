<?php
// Set time zone
date_default_timezone_set('America/New_York');

// Make unlimited execution time
//ini_set('max_execution_time', 0);
//ini_set('memory_limit', '2056M');
//ini_set('mysql_connect_timeout', 300);
//ini_set('default_socket_timeout', 300);

// Start counting time for the page load
$starttime = explode(' ', microtime());
$starttime = $starttime[1] + $starttime[0];

// Make the connection
$dbc = @mysqli_connect ('mysql.dashboard.topular.in', 'topular', 'Sword.Base.1', 'topular') or die ('Could not connect to MySQL server');

// Set the encoding
mysqli_set_charset($dbc, 'utf8');