<?php
session_start();

function getDB() 
{
	$dbhost='Hostname';
	$dbuser='DatabaseUser';
	$dbpass='DatabasePassword';
	$dbname='DatabaseName';
	try {
	$dbConnection = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);	
	$dbConnection->exec("set names utf8");
	$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $dbConnection;
    }
    catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
	}

}
?>