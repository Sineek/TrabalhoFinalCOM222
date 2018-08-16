<style>
<?php include '../style.css'; ?>
</style>
<?php
include "random_bg.php";
include_once("../validar.php");
require_once("../controller/CervejaDB.php");
require_once("../controller/CervejariaDB.php");
$tipos = CervejaDB::getTiposCerveja();
$cervejarias = CervejariaDB::getTodasCervejarias();
$erro = false;
if (!empty($_POST["action"])) {
    $acao = $_POST["action"];
    switch ($acao) {
        case "Cadastrar Cerveja":
            $nomeCervejaria = $_POST['cervejaria'];
            $cervejaria = CervejariaDB::getCervejariaPorNome($nomeCervejaria);
            if ($cervejaria->getNome() === $nomeCervejaria) {
                CervejaDB::addCerveja($_POST['nome'], floatval($_POST['teor']), $_POST['tipo'], $cervejaria->getId());
                header("Location: ./cadastrar_checkin.php");
            } else {
                $erro = true;
                $erroInfo = "Esta cervejaria não está cadastrada!";
            }
            break;
        case "Cadastrar Cervejaria":
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
						<form action="cadastrar_cerveja.php" method="post">
							<h2>Adicione a cerveja e ajude a<br>comunidade a crescer!</h2>
							<?php
							if ($erro) {
								echo ('<h5 class="erro">' . $erroInfo . '</h5>');
							}
							?>
							<label>Nome da Cerveja:</label>
							<input type="text" name="nome">
							<br>
							<br>
							<label>Teor Alcoólico:</label>
							<input type="text" name="teor">
							<br>
							<br>
							<label>Tipo:</label>
							<input type="text" list="tipo" name="tipo">
							<br>
							<br>
							<label>Cervejaria:</label>
							<input type="text" list="cervejaria" name="cervejaria">
							<br>
							<br>
							<label>&nbsp;</label>
							<input type="submit" name="action" value="Cadastrar Cerveja">
							<br>
						</form>
						<form action="cadastrar_cervejaria.php" method="post">
							<h3>Não encontrou a cervejaria? Cadastre ela aqui:</h3>
							<label>&nbsp;</label>
							<input type="submit" name="action" value="Cadastrar Cervejaria">
						</form>
					</div>
				</div>
			</div>
		</div>
		<?php
		echo ('<datalist id="tipo">');
		foreach ($tipos as $tipo) {
			echo ('<option value="' . $tipo->getTipo() . '"/>');
		}
		echo ("</datalist>");
		echo ('<datalist id="cervejaria">');
		foreach ($cervejarias as $cervejaria) {
			echo ('<option value="' . $cervejaria->getNome() . '"/>');
		}
		echo ("</datalist>");
		?>
    </body>
</main>
