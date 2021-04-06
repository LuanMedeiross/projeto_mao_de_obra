<?php 

require_once "server/db_connect.php";
include_once "show/header.php"; 
include_once "show/navbar.php"; 

if (isset($_GET["pesquisar"]) && !empty($_GET["pesquisar"])) {

	$pesquisa = htmlspecialchars($_GET["pesquisar"]);

	echo "<h2 class=\"mt-3 mb-3 text-center\">Voce pesquisou por: <b>$pesquisa</b></h2>";

	$pesquisa = addslashes($pesquisa);	
	
	$result = $conn->query("
		SELECT * FROM prestador
	 	WHERE area  LIKE '%$pesquisa%'
	 	OR nome LIKE '%$pesquisa%'
	 	OR descricao LIKE '%$pesquisa%'
	 	OR telefone LIKE '%$pesquisa%'
	 ");

	


} else {
	$result = $conn->query("SELECT * FROM prestador ORDER BY id DESC LIMIT 15");
	echo "<h2 class=\"text-center mt-3 mb-3\">Recentes: </h2>";
}


if (!empty($result->num_rows) && !$result->num_rows == 0) {

	while ($row = $result->fetch_assoc()):

		$nome      =  htmlspecialchars($row["nome"]);
		$area      =  htmlspecialchars($row["area"]);
		$email     =  htmlspecialchars($row["email"]);
		$descricao =  htmlspecialchars($row["descricao"]);
		$telefone  =  htmlspecialchars($row["telefone"]);?>

			<div class="d-grid gap-2 col-8 mx-auto">
				<div class="card mb-2">
					<div class="card-body">
						<?php
						echo "Nome: <b> $nome </b><br>";
						echo "Area: <b> $area </b><br>";
						echo "Email para PayPal: <b> $email </b> <br>";
						echo "Sobre: <b> $descricao </b><br>";
						echo "Numero: <b> $telefone </b><br>";
					
						if ($_SESSION["nome"] != $nome) 
							$button_field = "Contratar";
						else 
							$button_field = "Ver mais";
						?>

						<br>
						<form action="servicos/contratar.php" method="POST">
							<input type="hidden" value="<?php echo $nome; ?>" name="nome">
							<input type="hidden" value="<?php echo $area; ?>" name="area">
							<input type="hidden" value="<?php echo $email; ?>" name="email">
							<input type="hidden" value="<?php echo $descricao; ?>" name="descricao">
							<input type="hidden" value="<?php echo $telefone; ?>" name="telefone">
							<button type="submit" class="btn btn-success" name="btn_enviar">
								<?php echo $button_field; ?>
							</button>
						</form>			
					</div>
				</div>
			</div>
		<?php  
	endwhile;
} else {

	echo "
		<div class=\"d-grid gap-2 col-8 mx-auto\">
			<div class=\"card\" style=\"margin-top: 150px\">
				<div class=\"card-body\">
					<h4>Nenhum resultado encontrado</h4>
				</div>
			</div>
		</div>
	";
}

$conn->close();

include_once "show/footer.php";

?>