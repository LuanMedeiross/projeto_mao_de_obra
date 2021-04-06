<?php

require_once "../server/db_connect.php";
include_once "../show/header.php";
include_once "../show/navbar.php";

$result = $conn->query("SELECT 0 FROM prestador WHERE nome='$_SESSION[nome]'");

if (!empty($result->num_rows) && $result->num_rows > 0) 
	header("Location: meus_servicos.php");

if (isset($_POST["tornar-prestador"])) {

	$area = addslashes($_POST["area"]);
	$email = addslashes($_POST["email"]);
	$descricao = addslashes($_POST["descricao"]);
	$telefone = addslashes($_POST["telefone"]);

	$conn->query("
		INSERT INTO prestador VALUES 
		(NULL, '$_SESSION[nome]', '$area', '$email', '$descricao', '$telefone')
	");

	header("Location: meus_servicos.php");
}

$conn->close();

?>

<h4 class="text-center mt-2">Ola <?php echo $_SESSION["nome"] ?>, <br> 
	deseja se tornar um prestador de servicos?<br>
	Preencha as informacoes abaixo
</h4>
<div class="d-grid gap-2 col-8 mx-auto mt-3">
	<div class="card mb-2">
		<div class="card-body">
			<form action="" method="POST">
				<h5>Desejo trabalhar com: </h5>
				<input type="text" name="area" class="form-control mb-2" placeholder="Quero trabalhar com" required="">
				<h5>Sobre mim: </h5>
				<textarea type="text" name="descricao" class="form-control mb-2" placeholder="Sobre mim" required=""></textarea>
				<h5>Email para PayPal</h5>
				<input type="email" name="email" class="form-control mb-3" placeholder="Email">
				<h5>Telefone: </h5>
				<div class="input-group mb-2">
				  	<span class="input-group-text">+55</span>
				  	<input type="number" class="form-control" name="telefone" placeholder="Numero de telefone" required="" maxlength="11">
				</div>
				<br>
				<button type="submit" class="btn btn-success" name="tornar-prestador">Tornar Prestador</button>
			</form>
		</div>
	</div>
</div>

<?php include_once "../show/footer.php"; ?>
