<style>
<?php include '../style.css'; ?>
</style>
<?php
include "random_bg.php";
include_once("../validar.php");
require_once("../controller/CervejaDB.php");
require_once("../controller/UsuarioDB.php");
require_once("../controller/CheckinDB.php");
$cervejas = CervejaDB::getTodasCervejas();
$erro = false;
if (!empty($_POST["action"])) {
    $acao = $_POST["action"];
    switch ($acao) {
        case "Cadastrar Checkin":
            $nome = $_POST['nome'];
            $cerveja = CervejaDB::getCervejaPorNome($nome);
            $usuarioLogado = UsuarioBD::getUsuarioPorLogin($_SESSION['login']);
            if ($cerveja->getNome() === $nome) {
                CheckinBD::addCheckin($_POST['estrelas'], $usuarioLogado->getId(), $cerveja->getId());
                header("Location: ./pagina_inicial.php");
                break;
            } else {
                $erro = true;
                $erroInfo = "Esta cerveja não está cadastrada!";
            }
            break;
        case "Cadastrar Cerveja":
            header("Location: ./cadastrar_cerveja.php");
            break;
    }
}
?>
<main>
    <head>
        <meta charset="UTF-8">
        <title></title>
		<link href="https://fonts.googleapis.com/css?family=Roboto:100,400,500" rel="stylesheet">
    </head>
    <body>
		<div class="container">
			<div class="container_inner">
				<?php
					include "navbar.php";
				?>
				<div class="flex-fora conteudo2">
					<div class="login">
						<form action="cadastrar_checkin.php" method="post">
							<h2>Uau! Faça seu novo checkin:</h2>
							<?php
							if ($erro) {
								echo ('<h5 class="erro">' . $erroInfo . '</h5>');
							}
							?>
							<label>Nome da Cerveja:</label>
							<input type="text" list="lista" name="nome">
							<br>
							<br>
							<label>Sua nota para ela:</label>
							<select name="estrelas">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
							</select> 
							<br>
							<label>&nbsp;</label>
							<input type="submit" name="action" value="Cadastrar Checkin">
							<br>
						</form>
						<form action="cadastrar_checkin.php" method="post">
							<h3>Não encontrou sua cerveja? Cadastre ela aqui:</h3>
							<label>&nbsp;</label>
							<input type="submit" name="action" value="Cadastrar Cerveja">
						</form>
					</div>
				</div>
			</div>
		</div>
        <?php
        echo ('<datalist id="lista">');
        foreach ($cervejas as $cerveja) {
            echo ('<option value="' . $cerveja->getNome() . '"/>');
        }
        echo ("</datalist>");
        ?>
    </body>
</main>
