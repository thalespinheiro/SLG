<?php
require_once ('sql.php');
require_once ('functions.php');
require_once ('sql_functions.php');

$from = $_SERVER['REMOTE_ADDR'];
$idnode = ip2id ($bd, $from);
$input = file_get_contents("php://input");
$idjob = strtok ($input, ";\n");
$aws = strtok("");

$sql  = "INSERT INTO incoming (idjob, resposta, idnode, quando) VALUES (:idjob, :resposta, :idnode, NOW())";

 try
 {
	$query = $bd->prepare($sql);
        $query->bindValue (":idjob", $idjob, PDO::PARAM_INT);
	$query->bindValue (":resposta", $aws, PDO::PARAM_STR);
	// Precisa ser consertado. Atualmente passando o ASN ao invés do ID.
	$query->bindValue (":idnode", $idnode, PDO::PARAM_INT);
	$res = $query->execute();
 } catch (PDOException $e) {

	echo "Erro: " . $e->getMessage();
 }


if ($res)
{
    echo "Resposta enviada ao servidor central com sucesso!";
    //do_delete_job_by_id ($bd, $idjob);
    do_update_status_job ($bd, $idjob, 1);
}



?>
