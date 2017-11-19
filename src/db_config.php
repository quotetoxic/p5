<?php

$server = "eu-cdbr-west-01.cleardb.com";
$username = "b659907fb385a0";
$password = "c51da59f";
$db = "heroku_babdef676994c01";

$db = new mysqli($server, $username, $password, $db) or die ("There is a problem with database connection");
$db->query("SET NAMES utf8");
?>