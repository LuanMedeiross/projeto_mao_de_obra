<?php

if (isset($_POST["finalizar"])) {

	include_once "../server/db_connect.php";

	$provedor  = htmlspecialchars(addslashes($_POST["provedor"]));
	$cliente   = htmlspecialchars(addslashes($_POST["cliente"]));
	$pedido    = htmlspecialchars(addslashes($_POST["pedido"]));
	$contato   = htmlspecialchars(addslashes($_POST["contato"]));

	$conn->query("
		INSERT INTO servicos 
		VALUES (NULL, '$provedor', '$cliente', '$pedido', '$contato', 'Nao', '', 0)
	");

	$conn->close();

	header("Location: ../servicos/contratos.php");

}

?>
