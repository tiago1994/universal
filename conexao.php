<?
$local_serve = "localhost"; 	 
$usuario_serve = "root";		 
$senha_serve = "";		 
$banco_de_dados = "universal"; 	 


$conn = mysql_connect($local_serve,$usuario_serve,$senha_serve) or die ("O servidor não responde!");
$db = mysql_select_db($banco_de_dados) 
	or die ("Não foi possivel conectar-se ao banco de dados!");
?>