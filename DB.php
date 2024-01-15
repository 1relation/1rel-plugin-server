<?php
// Connect to the database the old way through mysqli.
$mysqli = new \mysqli(
    DB_SERVER,
    DB_USER,
    DB_PASS,
    DB_DATABASE
);

// Check connection.
if ($mysqli->connect_errno) {
    die('Failed to connect to database: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}