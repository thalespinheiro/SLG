<?php
require_once ('sql.php');
require_once ('functions.php');
require_once ('sql_functions.php');



$page = $_GET['job'];
$rdy = page_is_ready ($bd, $page);

if ($rdy == -1)
   $r = "Esta tarefa não existe.";
else if ($rdy == 0)
   $r = "A tarefa ainda está na fila de pedidos para ser processada. Aguarde mais um pouco e tente novamente.";
else if ($rdy == 1)
{
    $sql = "SELECT incoming.resposta FROM incoming, jobs WHERE jobs.page=:page AND jobs.id=incoming.idjob";
    try
    {
	$query = $bd->prepare($sql);
	$query->bindValue(":page", $page, PDO::PARAM_STR);
        $query->execute();
        $res = $query->fetch(PDO::FETCH_BOTH);
    } catch (PDOException $e)
    {
       echo "Erro: " . $e->getMessage();
    }
    $r = $res[0];

}

?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<title>Social Looking Glass</title>
<link rel="stylesheet" href="fmt.css">
</head>
<body>
<div id="menu">

Sobre | Como participar | <a href="adesao.php">Quer ajudar?</a> | FAQ | Contato


</div>
<br><hr>
<div id="conteudo">
<pre>
<?php echo $r; ?>
</pre>
</div>
</body>
</html>
