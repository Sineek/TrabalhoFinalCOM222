<style>
<?php include '../style.css'; ?>
</style>	
<?php
include "random_bg.php";
session_start();
require_once("../controller/UsuarioDB.php");
$erro = false;
if (!empty($_POST["action"])) {
    $acao = $_POST["action"];
    if ($acao == "Login") {
        if (!empty($_POST["login"]) && !empty($_POST["senha"])) {
            $confirmacao = UsuarioBD::getConfirmacao($_POST["login"], $_POST["senha"]);
            if ($confirmacao == true) {
                $_SESSION["login"] = $_POST["login"];
                header("Location: ./pagina_inicial.php");
            } else {
                $erro = true;
                $erroInfo = "Usuário e/ou senha incorreto! Tente novamente!";
            }
        }
    } else {
        header("Location: ./cadastrar_usuario.php");
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
                <form action="login.php" method="post">
                    <div class="flex">
                        <h2>Faça seu login</h2>
                    </div>
                    <?php
                    if ($erro) {
                        echo ('<h5 class="erro">' . $erroInfo . '</h5>');
                    }
                    ?>
                    <label>Login:</label>
                    <input type="text" name="login">
                    <label>Senha:</label>
                    <input type="password" name="senha">
                    <label>&nbsp;</label>
                    <input type="submit" name="action" value="Login">
                </form>
                <form action="login.php" method="post">
                    <h3>Novo por aqui? Cadastre-se, é rapidinho!</h3>
                    <input type="submit" name="action" value="Cadastrar">
                </form>
            </div>
        </div>
    </body>
</main>
