<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	<div class="container-fluid">

		<a class="navbar-brand" href="http://localhost/projeto_mao_de_obra/home.php">Home</a>

		<div class="collapse navbar-collapse" id="navbarScroll">
      		<ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
            <li class="nav-item">
                <a class="nav-link active" href="http://localhost/projeto_mao_de_obra/servicos/minha_conta.php">Minha conta</a>
            </li>
            <li class="nav-item">
          			<a class="nav-link active" href="http://localhost/projeto_mao_de_obra/servicos/contratos.php">Contratos</a>
        		</li>
            
            <?php

            session_start();

            if (!isset($_SESSION["nome"]))
              header("Location: ../index.php");

            $arquivo = basename($_SERVER["PHP_SELF"]);

            if ($arquivo == "home.php" || $arquivo == "index.php") 
              require_once "server/db_connect.php";
            else 
              require_once "../server/db_connect.php";

            $result = $conn->query("SELECT nome FROM prestador WHERE nome='$_SESSION[nome]'");

            if (empty($result->num_rows) && $result->num_rows <= 0) {

              echo "
                <li class=\"nav-item\">
                  <a class=\"nav-link active\" href=\"http://localhost/projeto_mao_de_obra/servicos/prestador.php\">Seja um prestador</a>
                </li>
              ";

            } else {
              echo "
                <li class=\"nav-item\">
                  <a class=\"nav-link active\" href=\"http://localhost/projeto_mao_de_obra/servicos/meus_servicos.php\">Meus servicos</a>
                </li>
              ";
            }
            
            ?>

        		<li class="nav-item">
          			<a class="nav-link active" href="http://localhost/projeto_mao_de_obra/actions/logout.php">Logout</a>
        		</li>
     		</ul>
	     	<form class="d-flex" method="GET" action="http://localhost/projeto_mao_de_obra/home.php">
	        	<input class="form-control me-2" type="search" placeholder="Pesquisar" name="pesquisar">
	        	<button class="btn btn-outline-success" type="submit">Pesquisar</button>
	      </form>
		</div>
	</div>
</nav>