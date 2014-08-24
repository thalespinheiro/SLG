<?php

function do_list_job_query ($bd, $origem, $tarefa, $host)
{
   echo "$origem, $tarefa, $host";
   $sql = "SELECT jobs.host, incoming.quando, nodes.nome, jobs.page FROM incoming, jobs, nodes WHERE nodes.cod=:origem AND ";
   $sql .= "nodes.id=incoming.idnode AND jobs.comando=:tarefa AND incoming.idjob=jobs.id AND jobs.host=:host and jobs.status=1";
   try
   {
       $query = $bd->prepare($sql);
       $query->bindValue(":tarefa", $tarefa, PDO::PARAM_STR);
       $query->bindValue(":origem", $origem, PDO::PARAM_STR);
       $query->bindValue(":host", $host, PDO::PARAM_STR);
       $query->execute();
       $res = $query->fetchAll(PDO::FETCH_BOTH);
   } catch (PDOException $e)
   {
       echo "Erro: " . $e->getMessage();
   }

   if (count($res) == 0)
       echo "Não foram encontradas nenhuma tarefa relaciona a sua consulta.";
   else
   {
     echo "<ul>";
     foreach ($res as $r)
     {
         echo "<li>A partir de: " . $r['nome'] . " para " . $r['host'] . " em " . $r['quando'] . " <a href='resultados.php?job=" . $r['page'] . "'>Ver!</a></li>";
     }
     echo "</ul>";
   }
}

function insert_new_job ($bd, $ASOrigem, $ASDestino, $tarefa, $host, $status, $urlId)
{
   $_ASDestino = -1;
   // Obtendo o ASN do nó a processar o pedido...
   $sql = "SELECT asn FROM nodes WHERE cod=:cod";
   try
   {
       $query = $bd->prepare($sql);
       $query->bindValue (":cod", $ASDestino, PDO::PARAM_STR);
       $query->execute();
       $res = $query->fetch(PDO::FETCH_BOTH);
   } catch (PDOException $e)
   {
       echo "Erro: " . $e->getMessage();
   }

   $_ASDestino = $res[0];


   // Inserindo na tabela...
   $sql = "INSERT INTO jobs (comando, host, ts, ASOrigem, ASDestino, status, page) VALUES (:tarefa, :host, NOW(), :ASOrigem, :ASDestino, :status, :page)";
   try
   {
       $query = $bd->prepare($sql);
       $query->bindValue(":tarefa", $tarefa, PDO::PARAM_STR);
       $query->bindValue(":ASOrigem", $ASOrigem, PDO::PARAM_INT);
       $query->bindValue(":ASDestino", $_ASDestino, PDO::PARAM_INT);
       $query->bindValue(":status", $status, PDO::PARAM_INT);
       $query->bindValue(":host", $host, PDO::PARAM_STR);
       $query->bindValue(":page", $urlId, PDO::PARAM_STR);
       $sucesso = $query->execute();
   } catch (PDOException $e)
   {
       echo "Erro: " . $e->getMessage();
   }

   if ($sucesso)
   {
     echo "Tarefa criada corretamente. Espere o resultado do processamento (Geralmente, entre 1 a 5 minutos). <br>";
     echo "<p>Você deverá consultar o resultado da tarefa acessando esta página: <a href='resultados.php?job=" . $urlId . "'>http://" . $_SERVER['SERVER_NAME'] . "/resultados.php?job=" . $urlId . "</a></p>";
   }
   else
     Echo "Um erro foi encontrado e a tarefa não foi criada. Tente novamente mais tarde.";
}


function ip2id ($bd, $ip)
{

   $sql = "SELECT id FROM nodes WHERE ip=:ip";
   try
   {
       $query = $bd->prepare($sql);
       $query->bindValue (":ip", $ip, PDO::PARAM_STR);
       $query->execute();
       $res = $query->fetch(PDO::FETCH_BOTH);
   } catch (PDOException $e)
   {
       echo "Erro: " . $e->getMessage();
   }


   return $res[0];

}


function do_delete_job_by_id ($bd, $idjob)
{
    $sql = "DELETE FROM jobs WHERE id=:idjob";
    try
    {
        $query = $bd->prepare($sql);
        $query->bindValue (":idjob", $idjob, PDO::PARAM_INT);
        $query->execute();
    } catch (PDOException $e) {

        echo "Erro: " . $e->getMessage();
    }
}

function do_update_status_job ($bd, $idjob, $status)
{
    $sql = "UPDATE jobs SET status=:status WHERE id=:idjob";
    try
    {
        $query = $bd->prepare($sql);
        $query->bindValue (":idjob", $idjob, PDO::PARAM_INT);
        $query->bindValue (":status", $status, PDO::PARAM_INT);
        $query->execute();
    } catch (PDOException $e) {

        echo "Erro: " . $e->getMessage();
    }

}

function page_is_ready ($bd, $page)
{
   $sql = "SELECT status FROM jobs WHERE page=:page";
    try
    {
        $query = $bd->prepare($sql);
        $query->bindValue (":page", $page, PDO::PARAM_STR);
        $query->execute();
        $res = $query->fetch (PDO::FETCH_BOTH);
    } catch (PDOException $e) {

        echo "Erro: " . $e->getMessage();
    }
    if ($res)
       if ($res[0] == 0)
           return 0;
       else if ($res[0] == 1)
          return 1;

    return -1;
}
?>
