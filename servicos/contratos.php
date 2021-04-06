<?php

include_once "../server/db_connect.php";
include_once "../show/header.php";
include_once "../show/navbar.php";

if (isset($_POST["cancelar"])) { 
	$id = addslashes($_POST["id"]);
	$conn->query("DELETE FROM servicos WHERE id='$id'");
} 

$result = $conn->query("SELECT * FROM servicos WHERE cliente='$_SESSION[nome]' ORDER BY id DESC");

echo "<h3 class=\"text-center m-2\">Meus contratos</h3>";

if ($result->num_rows !== false && $result->num_rows > 0) {

	while ($row = $result->fetch_assoc()):

		$id          = $row["id"];
		$provedor    = $row["provedor"];
		$cliente     = $row["cliente"];
		$pedido      = $row["pedido"];
		$contato     = $row["contato"];
		$concluido   = $row["concluido"];
		$estrelas    = $row["estrelas"];
		$comentarios = $row["comentarios"];

		?>

		<div class="d-grid gap-2 col-8 mx-auto mt-3">
			<div class="card mb-2">
				<div class="card-body">
					<h4> Informacoes </h4>
					Nome do provedor: <b> <?php echo $provedor ?></b> <br>
					Pedido: <b><?php echo $pedido ?></b> <br>
					Numero do provedor: <b><?php echo $contato?></b> <br>
					Concluido? <b> <?php echo $concluido ?> </b> <br> <br>
					<h4> Avaliacao </h4>

					<?php 

					if ($estrelas == 0) {

						if ($concluido == "Nao") {
							echo "<button id=\"btnmodal\" name=\"finalizar\" class=\"btn btn-success\">
									Avaliar
								</button>";
						} else if ($concluido == "Sim" && $estrelas == 0) {
							echo "<br> <button id=\"btnmodal\" name=\"finalizar\" class=\"btn btn-success\">
									Avaliar
								</button>";
						} 

						?> 

						<div class="modal" tabindex="-1" id="modal">
						  	<div class="modal-dialog">
						    	<div class="modal-content">
						      		<div class="modal-header">
						        		<h5 class="modal-title">Avaliacoes</h5>
						      		</div>
						      		<form action="../actions/avaliar.php" method="POST">
							      		<div class="modal-body">
											<select class="form-select mb-2" name="estrelas">
											    <option value="1">1 Estrelas</option>
											    <option value="2">2 Estrelas</option>
											    <option value="3">3 Estrelas</option>
											    <option value="4">4 Estrelas</option>
											    <option value="5">5 Estrelas</option>
											</select> 
											<br>
											<h5>Comentario</h5>
											<textarea class="form-control" name="comentarios" required=""></textarea>
						        		</div>
							      		<div class="modal-footer">
							      			<button type="button" class="btn btn-danger" id="btnclose">Cancelar</button>
							      			<input type="hidden" value="<?php echo $provedor ?>" name="provedor">
						        			<input type="hidden" value="<?php echo $id ?>" name="id">
						        			<button type="submit" class="btn btn-success" name="avaliar">Avaliar</button>
							      		</div>
						      		</form>
						    	</div>
						  	</div>
						</div> 

					<?php

					} else {
						echo "Estrelas: <span style=\"color: yellow\">";
						for ($e = 0; $e < $estrelas; $e++) { 
							echo "&#9733";
						} echo "</span><br>";
						echo "Seu comentario: <b> $comentarios </b> <br>";
					} 

					?>
				</div>
			</div>
		</div>

	<?php
	
	endwhile;

} else {

	echo "
	<div class=\"d-grid gap-2 col-8 mx-auto mt-3\">
		<div class=\"card mb-2\">
			<div class=\"card-body\">
				<h5>
					Voce nao tem nenhum contrato
				</h5>
			</div>
		</div>
	</div>";
}

$conn->close();

include_once "../show/footer.php"; 

?>
