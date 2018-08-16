<style>
<?php include '../style.css'; ?>
</style>
<?php
include "random_bg.php";
require_once("../controller/UsuarioDB.php");
$erro = false;
if (!empty($_POST["action"])) {
    $acao = $_POST["action"];
    if ($acao == "Cadastrar") {
        if (!empty($_POST["nome"]) && !empty($_POST["data"]) && !empty($_POST["login"]) && !empty($_POST["senha"])) {
            $confirmacao = UsuarioBD::addUsuario($_POST["nome"], $_POST["data"], $_POST["login"], $_POST["senha"]);
            if ($confirmacao === "Existe") {
                $nome = $_POST["nome"];
                $data = $_POST["data"];
                $erro = true;
                $erroInfo = "Este login já existe, tente outro!";
            } else {
                header("Location: ./pagina_inicial.php");
            }
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
        <div class="flex-fora">
            <div class="login">
                <form action="cadastrar_usuario.php" method="post">
                    <h2>Para se cadastrar, preencha estas informações:</h2>
                    <?php
                    if ($erro) {
                        echo ('<h5 class="erro">' . $erroInfo . '</h5>');
                    }
                    ?>
                    <label>Nome:</label>
                    <input type="text" name="nome">
                    <br>
                    <br>
                    <label>Data de Nascimento: (No formato aaaa-mm-dd)</label>
                    <input type="text" name="data">
                    <br>
                    <br>
                    <label>Login:</label>
                    <input type="text" name="login">
                    <br>
                    <br>
                    <label>Senha:</label>
                    <input type="password" name="senha">
                    <br>
                    <label>&nbsp;</label>
                    <input type="submit" name="action" value="Cadastrar">
                    <br>
                </form>
            </div>
        </div>
    </body>
</main>
