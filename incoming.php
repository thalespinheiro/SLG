<?php
include_once ('conn.php');
include_once ('functions.php');


$from = $_SERVER['REMOTE_ADDR'];
$sql  = "INSERT INTO awnsers (idjob, aws, as, when, traced_by) VALUES (:idjob, :aws, :asn, :when, :from);

 try
 {
	$query = $bd->prepare($sql);
        $query->bindValue (":idjob", $idjob, PDO::PARAM_INT);
	$query->bindValue (":aws", $aws, PDO::PARAM_STR);
	$query->bindValue (":asn", ASN_query($from), PDO::PARAM_INT);
	$query->bindValue (":when", $when, PDO::PARAM_STR);
	$query->bindValue (":from", $from, PDO::PARAM_STR);
	$query->execute();
 } catch (PDOException $e) {

	echo "Erro: " . $e->getMessage();
 }







?>
