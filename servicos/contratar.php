<?php 

require_once "../show/header.php";
require_once "../show/navbar.php";

if (isset($_POST["btn_enviar"])):

	$nome = htmlspecialchars($_POST["nome"]);
	$area = htmlspecialchars($_POST["area"]);
	$email = htmlspecialchars($_POST["email"]); 
	$descricao = htmlspecialchars($_POST["descricao"]);
	$telefone = htmlspecialchars($_POST["telefone"]);

	?>

	<h3 class="text-center mt-3">Contratar servico de <?php echo $nome ?></h3>
	<div class="d-grid gap-2 col-10 mx-auto mt-2">
		<div class="card mb-2">
			<div class="card-body">

				<?php
				echo "Area de $nome: <br> <b> $area </b><br><br>
					Sobre $nome: <br> <b> $descricao</b><br><br>
					Email para Paypal: <br> <b> $email </b><br><br>
					Numero de $nome: <br> <b> $telefone </b><br><br>";
				
				if ($_SESSION["nome"] != $nome): ?>

				Deseja contrata-lo?
				<button class="btn btn-success" id="btnmodal">Sim</button>
				<div class="modal" tabindex="-1" id="modal">
				  	<div class="modal-dialog">
				    	<div class="modal-content">
				      		<div class="modal-header">
				        		<h5 class="modal-title">Fechar contrato</h5>
				      		</div>
				      		<form action="../actions/contratar.php" method="POST">
					      		<div class="modal-body">
				        			<h5>Pedido</h5>
				        			<textarea type="text" name="pedido" class="form-control" maxlength="300" required=""></textarea>
				        			<input type="hidden" name="provedor" value="<?php echo $nome; ?>">
				        			<input type="hidden" name="cliente" value="<?php echo $_SESSION["nome"]; ?>">
				        			<input type="hidden" name="contato" value="<?php echo $telefone; ?>">
				        			<br>
				        			<p>
					      				<b>
					      					Aviso, se voce efetuar o pagamento voce nao podera cancela-lo mais,
					      					voce devera conversar diretamente com o prestador de servico caso
					      					queira voltar atras
					      					<br><br>
					      					Use o PayPal para pagar o prestador e logo em seguida clique em finalizar
					      				</b>
					      			</p>
					      		</div>
					      		<div class="modal-footer">
					      			<div id="paypal-payment-button"></div>
					        		<button type="button" class="btn btn-danger" id="btnclose" >Cancelar</button>
					        		<button type="submit" class="btn btn-success" id="btnfinalizar" name="finalizar">Finalizar</button>
					      		</div>
				      		</form>
				    	</div>
				  	</div>
				</div>ou<button class="btn btn-danger" onclick="window.location = '../' ">Nao</button> 
				<?php endif; ?>
			</div>
		</div>
	</div>

	<?php

	$resultado = $conn->query("
		SELECT cliente,pedido,comentarios,estrelas
		FROM servicos 
		WHERE provedor='$nome' 
		AND concluido='Sim' 
		AND comentarios!=''
	");

	echo "<h3 class=\"text-center mt-3 mb-2\">Avaliacoes</h3>";

	if (!empty($resultado->num_rows) && $resultado->num_rows > 0):

		while ($row = $resultado->fetch_assoc()):
			$cliente = $row["cliente"];
			$pedido = $row["pedido"];
			$comentarios = $row["comentarios"];
			$estrelas = $row["estrelas"];
			?>

			<div class="d-grid gap-2 col-10 mx-auto mb-2">
				<div class="card mb-2">
					<div class="card-body">
						<h5>Informacoes</h5>
						Cliente: <b> <?php echo $cliente ?> </b> <br>
						Pedido: <b> <?php echo $pedido ?> </b> <br> <br>
						<h5>Avaliacoes</h5>
						Comentarios <b> <?php echo $comentarios ?> </b> <br>
						Estrelas: 
						<span style="color: yellow">

						<?php
						for ($e = 0; $e < $estrelas; ++$e) {
							echo "&#9733";
						}
						?>

						</span>
					</div>
				</div>
			</div>
		<?php 
		endwhile;
	else:
		echo "<h3 class=\"text-center mt-3\">";
		echo $_SESSION["nome"] == $nome ? "Seu" : "Este";
		echo " perfil nao tem avaliacoes</h3>";

	endif;
endif;

$conn->close(); 

?>

	<script src="https://www.paypal.com/sdk/js?client-id=ATqJoT8uledW83BN2RvdA4o9tptMnGw4EUVlV1na6YHhKgqXEHcJXE8t0EZLGsDr4mybfMJ5nXxL10vQ&disable-funding=credit,card"></script>

	<script src="../paypal.js"></script>


<?php require_once "../show/footer.php"; ?>


