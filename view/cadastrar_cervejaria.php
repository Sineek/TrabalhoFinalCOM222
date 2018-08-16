<style>
<?php include '../style.css'; ?>
</style>
<?php
include "random_bg.php";
include_once("../validar.php");
require_once("../controller/CervejariaDB.php");
$erro = false;
if (!empty($_POST["action"])) {
    $acao = $_POST["action"];
    if ($acao == "Cadastrar") {
        if (!empty($_POST["nome"]) && !empty($_POST["tipo"]) && !empty($_POST["local"])) {
            CervejariaDB::addCervejaria($_POST["nome"], $_POST["tipo"], $_POST["local"]);
            header("Location: ./cadastrar_cerveja.php");
        } else {
            $erro = true;
            $erroInfo = "Por favor, preencha todas as informações!";
        }
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
						<form action="cadastrar_cervejaria.php" method="post">
							<h2>Para cadastrar uma cervejaria,<br>preencha estas informações:</h2>
							<?php
							if ($erro) {
								echo ('<h5 class="erro">' . $erroInfo . '</h5>');
							}
							?>
							<label>Nome:</label>
							<input type="text" name="nome">
							<br>
							<br>
							<label>Tipo: (Macro, Micro, Artesanal, etc.)</label>
							<input type="text" name="tipo">
							<br>
							<br>
							<label>Local:</label>
							<input type="text" name="local">
							<br>
							<br>
							<label>&nbsp;</label>
							<input type="submit" name="action" value="Cadastrar">
							<br>
						</form>
					</div>
				</div>
			</div>
		</div>
    </body>
</main>
