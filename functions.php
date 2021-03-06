<?php

function ASN_query($ip) {
    $ip_array = explode(".", $ip);
    $reversed_ip = $ip_array[3] . '.' . $ip_array[2] . '.' . $ip_array[1] . '.' . $ip_array[0] . '.origin.asn.cymru.com';
    $output = dns_get_record($reversed_ip);
    $ASN = explode('|',$output[1][txt]);
    return $ASN[0];
}

function ASN_name_query($asn) {
    $output = dns_get_record('AS' . $asn . '.asn.cymru.com');
    $ASN_name = explode('|',$output[0][txt]);
    return $ASN_name[4];
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