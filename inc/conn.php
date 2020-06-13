<?php

$dbhost="anatodtest.c75o4mima6rb.us-east-1.rds.amazonaws.com";
$dbport="";
$dbname="test_anatod";

$user="test";
$pass="test5678";

$strCnx = "mysql:dbname=$dbname;host=$dbhost";

$db ="";

try {
	$db = new PDO($strCnx, $user, $pass);
	
	$db->setAttribute(PDO::ATTR_CASE,PDO::CASE_LOWER);
	$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
	
} catch (PDOException $e) {
    print "Error: no se pudo ingresar a la base de datos  " . $e->getMessage() . "<br/>";
    die();
}

?>