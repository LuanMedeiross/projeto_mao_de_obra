<?php 

require_once "../server/db_connect.php";
include_once "../show/header.php";
include_once "../show/navbar.php";

$result = $conn->query("SELECT * FROM usuarios WHERE nome_completo='$_SESSION[nome]'");

$dados = $result->fetch_assoc();

$id = $dados["id"];
$nome = htmlspecialchars($dados["nome_completo"]);
$login = htmlspecialchars($dados["login"]);
$senha = htmlspecialchars($dados["senha"]);
$estado = htmlspecialchars($dados["estado"]);
$cidade = htmlspecialchars($dados["cidade"]);
$endereco = htmlspecialchars($dados["endereco"]);
$cep = htmlspecialchars($dados["cep"]);
$numero = htmlspecialchars($dados["numero"]);

$visualizar = "
	Nome: <b> $nome </b> <br>
	Login: <b> $login </b> <br>
	Estado: <b> $estado </b> <br>
	Cidade: <b> $cidade </b> <br>
	Endereco: <b> $endereco </b> <br>
	Cep: <b> $cep </b> <br>
	Numero: <b> $numero </b> <br> <br>

	<form action=\"\" method=\"POST\">
		<button type=\"submit\" name=\"deletar\" class=\"btn btn-danger\">Deletar Conta</button>
		<button type=\"submit\" name=\"editar\" class=\"btn btn-success\">Editar</button>
	</form>

";

if (isset($_POST["deletar"])) {

	$conn->query("DELETE FROM usuarios WHERE id=$id");
	$conn->query("DELETE FROM servicos WHERE provedor='$nome'");
	$conn->query("DELETE FROM servicos WHERE cliente='$nome'");
	$conn->query("DELETE FROM prestador WHERE nome='$nome'"); 

	session_unset();
	session_destroy();

	header("Location: ../index.php");

} else if (isset($_POST["editar"])) {
	$visualizar = '
		<form action="" method="POST">
			<div class="d-grid gap-2 col-6 mx-auto">
				<div class="input-group mb-2">
				 	<input type="text" class="form-control" value="'.$nome.'" name="nome" placeholder="Nome Completo" required="">
				</div>

				<select class="form-select mb-2" name="estado">
				    <option value="'.$estado.'" selected>'.$estado.'</option>
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
				  	<input type="text" class="form-control" name="cidade" value="'.$cidade.'" placeholder="Cidade" required="">
				</div>

				<div class="input-group mb-2">
				  	<input type="text" class="form-control" name="endereco" value="'.$endereco.'" placeholder="Endereco" required="">
				</div>

				<div class="input-group mb-2">
				  	<input type="number" class="form-control" name="cep" value="'.$cep.'" placeholder="CEP" required="">
				</div>

				<div class="input-group mb-2">
				  	<span class="input-group-text">+55</span>
				  	<input type="number" class="form-control" name="numero" value="'.$numero.'" placeholder="Numero de telefone" required="" maxlength="11">
				</div>

				<div class="input-group mb-2">
				  	<input type="password" class="form-control" name="senha" placeholder="Nova a senha" required="">
				  	<span class="input-group-text"></span>
				  	<input type="password" class="form-control" name="rsenha" placeholder="Redigite a nova senha" required="">
				</div>
				<button name="salvar" type="submit" class="btn btn-success">Salvar</button>
			</div>
		</form>
	';
}

if (isset($_POST["salvar"])) {

	$infos = array(
		$_POST["nome"], 
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

					$nome     =  $_POST["nome"];
					$senha    =  hash("sha256", $login.$_POST["senha"]);
					$estado   =  $_POST["estado"];
					$cidade   =  $_POST["cidade"];
					$endereco =  $_POST["endereco"];
					$cep      =  $_POST["cep"];
					$numero   =  $_POST["numero"];

					$conn->query("
						UPDATE usuarios SET
						nome_completo='$nome',
						senha='$senha',
						estado='$estado',
						cidade='$cidade',
						endereco='$endereco',
						cep='$cep',
						numero='$numero'
						WHERE id='$id'
					");

					$_SESSION["nome"] = $nome;

					header("Location: ../servicos/minha_conta.php");

					
				} else 
					$msg_fail = "<div class=\"alert alert-danger\">Senhas nao conferem</div>";
				
			} else 
				$msg_fail = "<div class=\"alert alert-danger\">Insira um estado!</div>";
			
		} else 
			$msg_fail = "<div class=\"alert alert-danger\">Apenas caracteres</div>";
		
	} else 
		$msg_fail = "<div class=\"alert alert-danger\">Preencha todos os campos</div>";
}

$conn->close();

?>

<h3 class="text-center mt-2 mb-2">Minha conta</h3>

<div class="d-grid gap-2 col-8 mx-auto mt-3">
	<?php if (isset($msg_fail)) { echo $msg_fail; } ?>
	<div class="card mb-2">
		<div class="card-body">
			<?php echo $visualizar; ?>
		</div>
	</div>
</div>

<?php include_once "../show/footer.php"; ?>
