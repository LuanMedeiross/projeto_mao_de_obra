<?php

if (isset($_POST["avaliar"])) {

	include_once "../server/db_connect.php";

	$id = addslashes($_POST["id"]);
	$comentarios = htmlspecialchars(addslashes($_POST["comentarios"]));
	$estrelas = addslashes($_POST["estrelas"]);

	$conn->query("
		UPDATE servicos SET 
		concluido='Sim',
		comentarios='$comentarios',
		estrelas='$estrelas' 
		WHERE id='$id'
	");

	$conn->close();

	header("Location: ../servicos/contratos.php");
}