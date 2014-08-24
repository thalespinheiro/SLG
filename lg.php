<?php
require_once ('sql.php');
require_once ('functions.php');
require_once ('sql_functions.php');
if (isset($_POST['submit']))
{
echo "<html><head> <meta http-equiv='content-type' content='text/html;charset=UTF-8' />";
echo "<title>Social Looking Glass</title><link rel='stylesheet' href='fmt.css'></head>";
echo "<body><div id='menu'>Sobre | Como participar | <a href='adesao.php'>Quer ajudar?</a> | FAQ | Contato";
echo "</div><br><hr><div id='conteudo'> ";

	//$buf = "<meta http-equiv=\"content-type\" content=\"text/plain;charset=UTF-8\" />\n<title>Social Looking Glass</title>\n";
    //echo $buf;
	$requests = 0;
	
	$param = validate_param($_POST ['ip']);
	echo "Parametro corrigido: " . $_POST['ip'] . " -> " . ($param ? $param : "Parametro inválido") . "\n";
	echo "<br>\n";
	
	if (!$param)
	   die("Por favor, coloque um parametro válido.");
	   
	   

        // Code para a interação com a base de dados
	$solicitante = trim(ASN_query($_SERVER['REMOTE_ADDR']));
        if (!is_node ($bd, $solicitante))
        {
             echo "Parece que você não faz parte da rede SLG. No entanto, mostraremos alguns resultados (se houver) para consulta.<br>";
	     do_list_job_query ($bd, $_POST['origem'], $_POST['tarefa'], $param);
        }
	else
        {
            echo "Criando tarefa...";
            $urlId = createRandomURLIdentifier (8);
            insert_new_job ($bd, $solicitante, $_POST['origem'], $_POST['tarefa'], $param, 0, $urlId);
        }


echo "</div></body></html>";


/*	if (isset ($_POST['trace']) && isset ($_POST['ping']))
	{
		echo "Traceroute e ping para " . $param . "\n";
    	echo '<pre>';
    	$lines = Array();
    	exec ("mtr --raw -c 1 " . $param, $lines);

		$buf = "<table border=\"1\" cellpadding=\"3\">\n<tr>\n<th> HOP </th><th> IP/HOST </th><th>PING</th>\n</tr>";
		echo $buf;
    	foreach ($lines as $l)
    	{
    		$line =  explode (" ", $l); */
    		/* -- Thales - Isso só irá funcionar se:
    		 * 1) hops estiveram em linhas pares;
    		 * 2) pings estiverem em linhas ímpares;
    		 * 3) o ping correspondente ao hop X vier 
    		 *    sempre imediatamente depois do hop X;
    		 *     (mtr --raw -c 1 assegura isso)
    		 * 
    		 */
    	/*	if ($line[0] == 'h')
    		{
    			echo "<tr>\n<td>" . $line[1] . "</td><td>" . $line[2];
    		}
    		else if ($line[0] == 'p')
    		{
    	  		echo "</td><td>" . $line[2]/1000 . " (ms) </td>\n</tr>";
    		}
    	}
    	echo '</pre>';
	}
	else
	{
	    if (isset ($_POST['trace']))
	    {
	        $requests++;
	        echo "Traçando rota para " . $param . "\n</br>\n";
	        echo '<pre>';
            passthru ("mtr -r " . $param);
	        echo '</pre>';
	    }

	    else if (isset ($_POST['ping']))
	    {
		    $requests++;
		    echo "Pingando destino " . $param . " 10 pacotes (32 bytes de informação)" . "\n</br>\n";
	        echo '<pre>';
		    passthru ("ping -c 10 -s 32 " . $param);
		    echo '</pre>';
	    }
	}*/
	
	die();
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

Sobre | Como participar | <a href="javascript:abrePagina('adesao.php')">Quer ajudar?</a> | FAQ | Contato


</div>
<br><hr>
<div id="conteudo">
<center>
<h2>Social Looking Glass</h2>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" >
<div><label for="ip">IP: </label><input name='ip' type='text'/> </div>
<input type="checkbox" name="trace" value="trace" /> Traceroute
<input type="checkbox" name="ping" value="ping" /> Ping
<input type="checkbox" name="dns" value="dns" /> DNS Query
<input type="checkbox" name="hget" value="hget" /> HTTP GET
<br>
<div><label for="orig">Origem: </label>
<select name="origem" id="origem" > 
<option value="default">Escolha um nó...</option>
<?php 
   $sql = "SELECT * FROM nodes";
    try
        {
             $query = $bd->prepare ($sql);
             $query->execute();
             $res = $query->fetchAll (PDO::FETCH_BOTH);
        } catch (PDOException $e)
        {
             echo "Erro: " . $e->getMessage();
        }
    foreach ($res as $r)
    {
      echo "<option value=" . $r['cod'] . "> AS " . $r['asn'] . " - " . $r['nome'] . "</option>";
    }
?>
</select> 
</div>
<div>Tarefa:
<select name="tarefa" id="tarefa" >
</select>
</div>
<input type="submit" name="submit" value="Requisitar" />
</form>

</center>
</div>
<br><hr>

<h3>Checando suas informações:</h3>
<center>
<table border="1" cellpadding="3">
<tr>
<th> Seu IP </th><th> ASN </th><th>AS Nome</th>
</tr><tr>
<?php 
   require_once ('functions.php');
   $asn_queried = trim(ASN_query($_SERVER['REMOTE_ADDR']));
   $asn_name_queried = trim(ASN_name_query($asn_queried));
   echo '<td>' . $_SERVER['REMOTE_ADDR'] . '</td>';
   echo '<td>' . $asn_queried . '</td>';
   echo '<td>' . $asn_name_queried . '</td>';
?>
</tr>
</table>
</center>
<script src="http://jqueryjs.googlecode.com/files/jquery-1.3.2.js"></script>
<script src="ajax.js"></script>
</body>
</html>
