<style>
<?php include '../style.css'; ?>
</style>
<?php
include "random_bg.php";
include_once("../validar.php");
require_once("../controller/CheckinDB.php");
require_once("../controller/CervejaDB.php");
require_once("../controller/CervejariaDB.php");
require_once("../controller/UsuarioDB.php");
require_once("../controller/ComentarioDB.php");
require_once("../controller/AmizadeDB.php");
$checkins = CheckinBD::getTodosCheckin();
$usuarioLogado = UsuarioBD::getUsuarioPorLogin($_SESSION['login']);
if (!empty($_POST["action"])) {
    $acao = $_POST["action"];
    switch ($acao) {
        case "Sair":
            $_SESSION['login'] = null;
            $procurar = $_POST["textoProcurar"];
            header("Location: ./login.php");
            break;
        case "Procurar":
            $procurar = $_POST["textoProcurar"];
            header("Location: ./procurar.php?busca=" . $procurar);
            break;
        case "Home":
            header("Location: ./pagina_inicial.php");
            break;
        case "Profile":
            header("Location: ./profile_usuario.php");
            break;
        case "Checkin":
            header("Location: ./cadastrar_checkin.php");
            break;
        case "Comentar":
            $texto = $_POST["textoComentario"];
            $usuario = $_POST["usuario"];
            $checkin = $_POST["checkin"];
            ComentarioBD::addComentario($checkin, $usuario, $texto);
            break;
    }
}
$usuarios = UsuarioBD::getTodosUsuarios();
?>
<main>
    <head>
        <meta charset="UTF-8">
        <title>Página Inicial</title>
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,400,500" rel="stylesheet">
    </head>
    <body class="flex">
        <div class="container">
            <div class="container_inner">
                <?php
                include "navbar.php";
                echo ('<div class="conteudo">');
                foreach ($usuarios as $usuario) {
                    if (AmizadeBD::solicitadoAmizade($usuario->getId(), $usuarioLogado->getId())) {
                        echo ('<h5 class="erro">Você recebeu um pedido de amizade de <a href="profile_usuario.php?usuario=' . $usuario->getId() . '">'
                        . $usuario->getNome() . '</a>, acesse o perfil para aceitar.</h5>');
                    }
                }
                echo ('<div class="flex">');
                echo ('<h1>Feed de Check-ins</h1>');
                echo ('</div>');
                foreach ($checkins as $checkin) :
                    echo ('<div class="checkin">');
                    $cerveja = CervejaDB::getCervejaPorId($checkin->getCerveja());
                    $cervejaria = CervejariaDB::getCervejariaPorId($cerveja->getCervejaria());
                    $usuario = UsuarioBD::getUsuarioPorId($checkin->getConsumidor());
                    $badges = PremiacaoBD::getBadgesPorIdCheckin($checkin->getId());
                    echo ('<p class="noMargin" style="color: #999999; padding-bottom: 12px;">' . $checkin->getData() . '</p>');
                    echo ('<p class="noMargin"><a href="profile_usuario.php?usuario=' . $usuario->getId() . '">' . $usuario->getNome() . '</a>  realizou o checkin da cerveja <a href="profile_cerveja.php?cerveja=' . $cerveja->getId() . '">' .
                    $cerveja->getNome() . '</a> da <a href="profile_cervejaria.php?cervejaria=' . $cerveja->getCervejaria() . '">' . $cervejaria->getNome() . '</a> e deu '
                    . $checkin->getEstrelas() . ' estrelas</p>');
                    foreach ($badges as $badge) :
                        echo ('<img style="padding: 15px 5px 15px 5px;" title="' . $badge->getNome() . '" src="../badges/badge' . $badge->getId() . '.jpg" width="50px" height="50px">');
                    endforeach;
                    $comentarios = ComentarioBD::getComentariosPorIdCheckin($checkin->getId());
                    foreach ($comentarios as $comentario) :
                        echo ('<div class="comentario">');
                        $comentador = UsuarioBD::getUsuarioPorId($comentario->getUsuario());
                        echo ('<p class="noMargin"><a href="profile_usuario.php?usuario=' . $comentador->getId() . '">' . $comentador->getNome() . '</a>: ' .
                        $comentario->getTexto() . '</p>');
                        echo ('</div>');
                    endforeach;
                    if ($usuario->getId() == $usuarioLogado->getId() || AmizadeBD::saoAmigos($usuario->getId(), $usuarioLogado->getId())) {
                        echo ('<form class="comentario_form" action="pagina_inicial.php" method="post">');
                        echo ('<input type="hidden" name="usuario" value="' . $usuarioLogado->getId() . '">');
                        echo ('<input type="hidden" name="checkin" value="' . $checkin->getId() . '">');
                        echo ('<input type="text" name="textoComentario">');
                        echo ('<input type="submit" name="action" value="Comentar">');
                        echo ('</form>');
                    }
                    echo ('</div>');
                endforeach;
                ?>
            </div>
        </div>
        </div>
    </body>
</main>
