<?php

function ASN_query($ip) {
    $ip_array = explode(".", $ip);
    $reversed_ip = $ip_array[3] . '.' . $ip_array[2] . '.' . $ip_array[1] . '.' . $ip_array[0] . '.origin.asn.cymru.com';
    $output = dns_get_record($reversed_ip);
    if (count ($output) > 0 )
    {
    	$ASN = explode('|',$output[1]['txt']);
    	return $ASN[0];
    }
    return 0;
}

function ASN_name_query($asn) {
    $output = dns_get_record('AS' . $asn . '.asn.cymru.com');
    if (count ($output) > 0 )
    {
       $ASN_name = explode('|',$output[0]['txt']);
       return $ASN_name[4];
    }
    return "Sem informação";
}


function validate_param ($str)
{
	/* -- Thales - alguém tentando passar mais de um parametro? */
	$res = strtok ($str, " ");
	if ($res !== false)
	{
		if ($res[0] == '-')
		   return NULL;
		/* -- Thales - descarta os demais e devolve só o primeiro */   
		return $res;
	}
	
	if ($str[0] == '-')
	   return NULL;
	   
	return $str;  
}

function is_node ($bd, $asn)
{

	$sql = "SELECT * FROM nodes WHERE asn=:asn";
        try
        {
             $query = $bd->prepare ($sql);
             $query->bindValue (":asn", $asn, PDO::PARAM_INT);
             $query->execute();
             $res = $query->fetchAll (PDO::FETCH_BOTH);
        } catch (PDOException $e)
        {
             echo "Erro: " . $e->getMessage();
        }
        return (count ($res) != 0);
}


function createRandomURLIdentifier($tamanho = 8, $maiusculas = true, $numeros = true)
{
  $lmin = 'abcdefghijklmnopqrstuvwxyz';
  $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $num = '1234567890';
  $retorno = '';
  $caracteres = '';

  $caracteres .= $lmin;
  if ($maiusculas) $caracteres .= $lmai;
  if ($numeros) $caracteres .= $num;

  $len = strlen($caracteres);
  for ($n = 1; $n <= $tamanho; $n++) 
  {
     $rand = mt_rand(1, $len);
     $retorno .= $caracteres[$rand-1];
  }
  return $retorno;
}

#$asn_queried = trim(ASN_query(209.85.250.248));
#$asn_name_queried = trim(ASN_name_query($asn_queried));
#echo $asn_queried;
#echo 'Seu IP é: ' . $_SERVER[REMOTE_ADDR];
#echo '<br />';
#echo 'Seu ASN é: AS' . $asn_queried . ' (' . $asn_name_queried . ')';
#echo '<br />';
#$x = trimASN_query(209.85.250.248));
#echo $x;
?>
