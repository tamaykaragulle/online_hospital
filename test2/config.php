<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '#B!je?651*rK');
define('DB_NAME', 'online_hospital_db');

$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($link === false)
{
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
