<?php
/*
private static $host = 'localhost'; 
private static $user = 'root';
private static $password = 'pcnay2003';
private static $db_name = 'ordenservicios';
*/
$conexion = new mysqli( 'localhost','servicios','pcnay2003','ordenservicios');
if (!$conexion)
{
	echo "Error en la conexion";
}
else
{
	echo "Conexion exitosa";
}
	
?>