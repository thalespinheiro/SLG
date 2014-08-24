<?php
include_once ('sql.php');
include_once ('functions.php');

$node = $_GET['node'];

$sql = "SELECT tarefa.nome, tarefa.cod FROM nodes, tarefa, node_tarefas_suportadas AS nts WHERE nodes.cod=:cod ";
$sql .= "AND nts.idnode=nodes.id AND nts.idtarefa=tarefa.id";

try
{
   $query = $bd->prepare($sql);
   $query->bindValue(":cod", $node, PDO::PARAM_STR);
   $query->execute();
   $res = $query->fetchAll(PDO::FETCH_BOTH);
} catch (PDOException $e)
{
   echo "Erro: " . $e->getMessage();
}

foreach ($res as $r)
{
    echo "<option value='" . $r['cod'] . "'>" . $r['nome'] . "</option>";
}

?>
