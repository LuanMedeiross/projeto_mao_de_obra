<?php

if (isset($_POST["cadastrar"])) {

	$infos = array(
		$_POST["nome"],
		$_POST["login"], 
		$_POST["estado"], 
		$_POST["cidade"], 
		$_POST["endereco"],
		$_POST["cep"],
		$_POST["numero"],
		$_POST["senha"],
		$_POST["rsenha"]
	);

	function tudoPreenchido($vetor) {

		foreach ($vetor as $key => $info) {
			if (!isset($info)) 
				return False;
		} return True;

	}

	function somenteCaracteres($vetor) {

		foreach ($vetor as $key => $info) {
			if ($key == 7) 
				break;
			if (!preg_match('/[a-zA-Z0-9 ]/', $info))
				return False;
		} return True;
	}

	if (tudoPreenchido($infos)) {
	
		if (somenteCaracteres($infos)) {

			if ($_POST["estado"] != "Estado") {

				if ($_POST["senha"] == $_POST["rsenha"]) {

					require_once "../server/db_connect.php";

					$login = $_POST["login"];

					$result = $conn->query("SELECT 0 FROM usuarios WHERE login='$login'");

					if (empty($result->num_rows) && $result->num_rows <= 0) { 

						$nome     =   $_POST["nome"];
						$senha    =   hash("sha256", $login.$_POST["senha"]);
						$estado   =   $_POST["estado"];
						$cidade   =   $_POST["cidade"];
						$endereco =   $_POST["endereco"];
						$cep      =   $_POST["cep"];
						$numero   =   $_POST["numero"];

						$conn->query("INSERT INTO usuarios VALUES (
							NULL,
							'$nome', 
							'$login',
							'$senha',
							'$estado',
							'$cidade',
							'$endereco',
							'$cep',
							'$numero'
						)");

						$conn->close();

						header("Location: ../index.php");

					} else 
						$msg_fail = "<div class=\"alert alert-danger\">Este login ja existe!</div>";
					
				} else 
					$msg_fail = "<div class=\"alert alert-danger\">Senhas nao conferem</div>";
				
			} else 
				$msg_fail = "<div class=\"alert alert-danger\">Insira um estado!</div>";
			
		} else 
			$msg_fail = "<div class=\"alert alert-danger\">Apenas caracteres</div>";
		
	} else 
		$msg_fail = "<div class=\"alert alert-danger\">Preencha todos os campos</div>";
}

?>

<!DOCTYPE html>

<html>

	<head>
		<meta charset="utf-8">
		<title>Projeto mao de obra</title>
		<link rel="stylesheet" type="text/css" href="../styles/css/bootstrap.css">
	</head>

	<body class="text-center">
		<?php if (isset($msg_fail)) { echo $msg_fail; } ?>
		<div class="container mt-5">
			<form action="" method="POST">
				<div class="d-grid gap-2 col-6 mx-auto">
					<div class="input-group mb-2">
					 	<input type="text" class="form-control" name="nome" placeholder="Nome Completo"required="">
					</div>

					<div class="input-group mb-2">
					  	<input type="text" class="form-control" name="login" placeholder="Login" required="">
					</div>

					<select class="form-select mb-2" name="estado">
					    <option value="Estado" selected>Estado</option>
					    <option value="Acre">Acre (AC)</option>
					    <option value="Alagoas">Alagoas (AL)</option>
					    <option value="Amapa">Amapá (AP)</option>
					    <option value="Amazona">Amazonas (AM)</option>
					    <option value="Bahia">Bahia (BA)</option>
					    <option value="Ceara">Ceará (CE)</option>
					    <option value="Ditrito Federal">Distrito Federal (DF)</option>
					    <option value="Espirito Santo">Espírito Santo (ES)</option>
					    <option value="Goias">Goiás (GO)</option>
					    <option value="Maranhao">Maranhão (MA)</option>
					    <option value="Mato Grosso">Mato Grosso (MT)</option>
					    <option value="Mato Grosso do Sul">Mato Grosso do Sul (MS)</option>
					    <option value="Minas Gerais">Minas Gerais (MG)</option>
					    <option value="Para">Pará (PA)</option>
					    <option value="Paraiba">Paraíba (PB)</option>
					    <option value="Parana">Paraná (PR)</option>
					    <option value="Pernambuco">Pernambuco (PE)</option>
					    <option value="Piaui">Piauí (PI)</option>
					    <option value="Rio de Janeiro">Rio de Janeiro (RJ)</option>
					    <option value="Rio Grande do Norte">Rio Grande do Norte (RN)</option>
					    <option value="Rio Grande do Sul">Rio Grande do Sul (RS)</option>
					    <option value="Rondonia">Rondônia (RO)</option>
					    <option value="Roraima">Roraima (RR)</option>
					    <option value="Santa Catarina">Santa Catarina (SC)</option>
					    <option value="Sao Paulo">São Paulo (SP)</option>
					    <option value="Sergipe">Sergipe (SE)</option>
					    <option value="Tocantins">Tocantins (TO)</option>
					</select> 

					<div class="input-group mb-2">
					  	<input type="text" class="form-control" name="cidade" placeholder="Cidade" required="">
					</div>

					<div class="input-group mb-2">
					  	<input type="text" class="form-control" name="endereco" placeholder="Endereco" required="">
					</div>

					<div class="input-group mb-2">
					  	<input type="number" class="form-control" name="cep" placeholder="CEP" required="">
					</div>

					<div class="input-group mb-2">
					  	<span class="input-group-text">+55</span>
					  	<input type="number" class="form-control" name="numero" placeholder="Numero de telefone" required="" maxlength="11">
					</div>

					<div class="input-group mb-2">
					  	<input type="password" class="form-control" name="senha" placeholder="Digite a senha" required="">
					  	<span class="input-group-text"></span>
					  	<input type="password" class="form-control" name="rsenha" placeholder="Redigite a senha" required="">
					</div>
					<button name="cadastrar" type="submit" class="btn btn-success">Cadastrar</button>
				</div>
			</form>
		</div>
	</body>

	<script type="text/javascript" src="../styles/js/bootstrap.js"></script>

</html>
