<?php
require_once ('functions.php');
if (isset($_POST['submit']))
{
	$buf = "<meta http-equiv=\"content-type\" content=\"text/plain;charset=UTF-8\" />\n<title>Social Looking Glass</title>\n";
    echo $buf;
	$requests = 0;
	
	$param = validate_param($_POST ['ip']);
	echo "Parametro corrigido: " . $_POST['ip'] . " -> " . ($param ? $param : "Parametro inválido") . "\n";
	echo "<br>\n";
	
	if (!$param)
	   die("Não seja estúpido, coloque um parametro válido.");
	   
	   
	if (isset ($_POST['trace']) && isset ($_POST['ping']))
	{
		echo "Traceroute e ping para " . $param . "\n";
    	echo '<pre>';
    	$lines = Array();
    	exec ("mtr --raw -c 1 " . $param, $lines);

		$buf = "<table border=\"1\" cellpadding=\"3\">\n<tr>\n<th> HOP </th><th> IP/HOST </th><th>PING</th>\n</tr>";
		echo $buf;
    	foreach ($lines as $l)
    	{
    		$line =  explode (" ", $l);
    		/* -- Thales - Isso só irá funcionar se:
    		 * 1) hops estiveram em linhas pares;
    		 * 2) pings estiverem em linhas ímpares;
    		 * 3) o ping correspondente ao hop X vier 
    		 *    sempre imediatamente depois do hop X;
    		 *     (mtr --raw -c 1 assegura isso)
    		 * 
    		 */
    		if ($line[0] == 'h')
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
            passthru ("traceroute " . $param);
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
	}
	
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

Sobre | Como participar | Quer ajudar? | FAQ | Contato


</div>
<br><hr>

<center>
<h2>Social Looking Glass</h2>

<form action="<?php echo $_PHP['SELF']; ?>" method="post" >
<div><label for="ip">IP: </label><input name='ip' type='text'/> </div>
<input type="checkbox" name="trace" value="trace" /> Traceroute
<input type="checkbox" name="ping" value="ping" /> Ping
<input type="checkbox" name="dns" value="dns" /> DNS Query
<input type="checkbox" name="hget" value="hget" /> HTTP GET
<br>
<div><label for="orig">Origem: </label>
<select name="origem" > 
  <option value="gvt">AS 18881 - Global Village Telecom</option>
  <option value="telemar">AS 7738 - Telemar Norte Leste</option>
</select> 
</div>

<input type="submit" name="submit" value="Requisitar" />
</form>

</center>

<br><hr>

<h3>Checando suas informações:</h3>
<center>
<table border="1" cellpadding="3">
<tr>
<th> Seu IP </th><th> ASN </th><th>AS Nome</th>
</tr><tr>
<?php 
   require_once ('functions.php');
   $asn_queried = trim(ASN_query($_SERVER[REMOTE_ADDR]));
   $asn_name_queried = trim(ASN_name_query($asn_queried));
   echo '<td>' . $_SERVER[REMOTE_ADDR] . '</td>';
   echo '<td>' . $asn_queried . '</td>';
   echo '<td>' . $asn_name_queried . '</td>';
?>
</tr>
</table>
</center>
</body>
</html>
