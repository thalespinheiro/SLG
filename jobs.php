<?php

include_once ('sql.php');
include_once ('functions.php');


$ASdestino = ASN_query ($_SERVER['REMOTE_ADDR']);

$sql = "SELECT * FROM jobs WHERE ASDestino=:asd";

 try 
 {
        $query = $bd->prepare ($sql);
        $query->bindValue (":asd", $ASdestino, PDO::PARAM_INT);
	$query->execute();
	$res = $query->fetchAll (PDO::FETCH_BOTH);
 } catch (PDOException $e)
 {
 	echo "Erro: " . $e->getMessage();
 }


 if (count ($res) == 0)
 {
	echo "0";
   	die();
 }

 foreach ($res as $r)
 {
	echo $r['id'] . "," . $r['comando'] . "," . $r['host'] . "\n";
 }


?>
