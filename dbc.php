<?php // Connect to MySQL database

// This file contains the database access information
// This file also establishes a connection to MySQL, selects the database, and sets the encoding

// set the database access information as constants:
DEFINE ('DB_USER', 'ab98812_joey');
DEFINE ('DB_PASSWORD', 'qubert12');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'ab98812_social');

// Make the connection
$dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die ('Could not connect to database');

// Set the encoding
mysqli_set_charset($dbc, 'utf8');