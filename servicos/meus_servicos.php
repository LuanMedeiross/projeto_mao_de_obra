<?php

include_once "../show/header.php";
include_once "../show/navbar.php";
require_once "../server/db_connect.php";

echo "<h3 class=\"text-center mt-2\">Meus servicos</h3>";

if (isset($_POST["concluir"]))
	$conn->query("UPDATE servicos SET concluido='Sim' WHERE id='$_POST[id]'");

$result = $conn->query("SELECT * FROM servicos WHERE provedor='$_SESSION[nome]' ORDER BY id DESC");

if (!empty($result->num_rows) && $result->num_rows > 0): 

	while ($row = $result->fetch_assoc()):

		$id          = $row["id"];
		$cliente     = htmlspecialchars($row["cliente"]);
		$pedido 	 = htmlspecialchars($row["pedido"]);
		$concluido   = htmlspecialchars($row["concluido"]);
		$comentarios = htmlspecialchars($row["comentarios"]);
		$estrelas 	 = htmlspecialchars($row["estrelas"]); 

		$client_query = $conn->query("SELECT * FROM usuarios WHERE nome_completo='$cliente'");
		
		$dados = $client_query->fetch_assoc();
		$estado_cliente = htmlspecialchars($dados["estado"]);
		$cidade_cliente = htmlspecialchars($dados["cidade"]);
		$endereco_cliente = htmlspecialchars($dados["endereco"]);
		$cep = htmlspecialchars($dados["cep"]);
		$telefone_cliente = htmlspecialchars($dados["numero"]);

		?>

		<div class="d-grid gap-2 col-8 mx-auto mt-3">
			<div class="card mb-2">
				<div class="card-body">
					<?php 
					echo "<h4> Informacoes </h4>
						Nome do Cliente:    <b> $cliente          </b> <br>
						Estado:    		    <b> $estado_cliente   </b> <br>
						Cidade:             <b> $cidade_cliente   </b> <br>
						Endereco: 		    <b> $endereco_cliente </b> <br>
						CEP: 			    <b> $cep 			  </b> <br>
						Numero de Telefone: <b> $telefone_cliente </b> <br>
						Pedido:             <b> $pedido           </b> <br>
						Concluido?          <b> $concluido        </b> <br>
						<br>
						<h4> Avaliacao </h4> ";

					if ($concluido == "Sim" && !empty($comentarios)) {

						echo "Comentario: <b> $comentarios </b> <br>
							Estrelhas: <span style=\"color: yellow\">";

						for ($e = 0; $e < $estrelas; $e++) {
							echo "&#9733";
						} echo "</span>"; 

					} else if ($concluido == "Sim" && empty($comentarios)) {
						echo "<p>Aguardando comentarios</p>";
					} else { 
						echo "Nao ha avaliacoes pois o servico ainda nao foi concluido <br><br>
						<form action=\"\" method=\"POST\">
							<input type=\"hidden\" name=\"id\" value=\"$id\">
							<button type=\"submit\" class=\"btn btn-success\" name=\"concluir\">
								Concluir
							</button>
						</form>
						";
					} ?>
				</div>
			</div>
		</div>

<?php endwhile; else: ?>

<div class="d-grid gap-2 col-8 mx-auto mt-3">
	<div class="card mb-2">
		<div class="card-body">
			<h5>
				Voce nao tem nenhum servico
			</h5>
		</div>
	</div>
</div>

<?php

endif; 

$conn->close();

include_once "../show/footer.php";

?>
