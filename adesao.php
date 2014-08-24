<?php
?>

<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<title>Social Looking Glass - Adesão</title>
<link rel="stylesheet" href="fmt.css">
</head>
<body>
<h3> Formulário de adesão </h3>
<div id="adesao">
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" >
Autonomous System/ISP: <input type="text" name="AS"/><br>
ASN: [<a href="" onmouseover="Tip('Em caso de não ter número de AS próprio, favor colocar do seu upstream provider', WIDTH, 300, FADEIN, 500, FADEOUT, 500, BGCOLOR, '#FFFFFF', OPACITY, 90, STICKY, true, CLICKCLOSE, true)" onmouseout="UnTip()">?</a>] <input type="text" name="ASN" /><br>
IP Cliente [<a href="" onmouseover="Tip('Neste campo, deverá ser colocado o IP ou bloco de IPs que o cliente terá atribuido. De notar que, caso seja utilizado um bloco de IPs, colocar na formatação CIDR ex: 1.1.1.0/24. Muito <b>cuidado</b> ao definir este campo porque esta é uma das formas de autenticação do cliente.', WIDTH, 300, FADEIN, 500, FADEOUT, 500, BGCOLOR, '#FFFFFF', OPACITY, 90, STICKY, true, CLICKCLOSE, true)" onmouseout="UnTip()">?</a>]: <input type="text" name="ip" /><br>
Responsável: <input type="text" name="resp" value="Fulano da Silva" /><br> 
E-mail: <input type="text" name="email" value="admin@isp.net.br" /><br> 

<input type="submit" name="submit" value="Requisitar" />
<input type="reset" name="reset" value="Limpar" />
</form>
</div>

<div id="geolocation">

</div>

<script src="tooltip.js"></script>
</body>

 
