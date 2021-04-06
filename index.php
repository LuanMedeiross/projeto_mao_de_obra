<?php

session_start();

if (isset($_SESSION["nome"]))
	header("Location: home.php");

if (isset($_POST["enviar"])) {

	if (!empty($_POST["login"]) && !empty($_POST["senha"])) {
	
		if (strlen($_POST["login"]) <= 100 || strlen($_POST["senha"]) <= 200) {
		
			if (preg_match('/[a-zA-Z0-9 ]/', $_POST["login"]) && preg_match('/[a-zA-Z0-9 ]/', $_POST["senha"])) {

				require_once "./server/db_connect.php";

				$login = $_POST["login"];

				$result = $conn->query("SELECT * FROM usuarios WHERE login='$login'");

				if ($result->num_rows > 0) {

					$senha = hash("sha256", $login.$_POST["senha"]);

					$result = $conn->query("SELECT * FROM usuarios WHERE login='$login' AND senha='$senha'");

					if ($result->num_rows > 0) {
						
						$dados = $result->fetch_assoc();

						$_SESSION["nome"] = $dados["nome_completo"];

						$conn->close();

						header("Location: home.php");

					} else 
						$msg_fail = "<div class=\"alert alert-danger\">Senha incorreta</div>";

				} else 
					$msg_fail = "<div class=\"alert alert-danger\">Usuario nao encontrado</div>";
			
			} else 
				$msg_fail = "<div class=\"alert alert-danger\">Apenas letras!</div>";

		} else 
			$msg_fail = "<div class=\"alert alert-danger\">Limite de tamanho ultrapassado</div>";

	} else 
		$msg_fail = "<div class=\"alert alert-danger\">Preencha todos os campos</div>";
}

require_once "show/header.php";

?>

<body class="text-center">
	<?php if (isset($msg_fail)) { echo $msg_fail; } ?>
	<div class="container mt-5"><br><br>
		<form action="" method="POST">
			<div class="d-grid gap-2 col-6 mx-auto">
				<input type="text" name="login" class="form-control mb-4" placeholder="Login" maxlength="100" required>
				<input type="password" name="senha" class="form-control mb-4" placeholder="Senha" maxlength="200" required>
				<button class="btn btn-success" type="submit" name="enviar">Entrar</button>
				<a href="actions/cadastrar.php" class="card-link" style="margin-top: 10px">Nao tem uma conta? cadastre-se!</a>
			</div>
		</form>
	</div>
</body>

<?php require_once "show/footer.php"; ?>
