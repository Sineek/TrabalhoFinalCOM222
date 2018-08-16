<style>
<?php include '../style.css'; ?>
</style>
<?php
include "random_bg.php";
include_once("../validar.php");
require_once("../controller/UsuarioDB.php");
require_once("../controller/CheckinDB.php");
require_once("../controller/CervejaDB.php");
require_once("../controller/CervejariaDB.php");
require_once("../controller/PremiacaoDB.php");
require_once("../controller/ComentarioDB.php");
require_once("../controller/AmizadeDB.php");
if (!empty($_GET["usuario"])) {
    $usuario = UsuarioBD::getUsuarioPorId($_GET["usuario"]);
    $usuarioLogado = UsuarioBD::getUsuarioPorLogin($_SESSION['login']);
} else {
    $usuario = UsuarioBD::getUsuarioPorLogin($_SESSION['login']);
    $usuarioLogado = $usuario;
}
if (!empty($_POST["action"])) {
    $acao = $_POST["action"];
    switch ($acao) {
        case "Comentar":
            $texto = $_POST["textoComentario"];
            $idComentador = $_POST["usuario"];
            $checkin = $_POST["checkin"];
            ComentarioBD::addComentario($checkin, $idComentador, $texto);
            break;
        case "Adicionar":
            AmizadeBD::solicitarAmizade($usuarioLogado->getId(), $_POST["amigo"]);
            header("Location: ./profile_usuario.php?usuario=" . $_POST["amigo"]);
            break;
        case "Aceitar":
            AmizadeBD::aceitarAmizade($usuarioLogado->getId(), $_POST["amigo"]);
            header("Location: ./profile_usuario.php?usuario=" . $_POST["amigo"]);
            break;
    }
}
$nome = $usuario->getNome();
$data = $usuario->getDataNascimento();
$id = $usuario->getId();
$checkins = CheckinBD::getCheckinsPorIdUsuario($id);
$checkinsUnicos = CheckinBD::getQntCheckinsUnicoPorIdUsuario($id);
$badges = PremiacaoBD::getBadgesPorIdUsuario($id);
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
                <div class="perfil">
                    <div class="conteudo">
                        <img src="../imagens/user.png" width="180px" height="180px">
                        <?php
                        $add = false;
                        $enviado = false;
                        $solicitado = false;
                        if ($usuario != $usuarioLogado && !AmizadeBD::saoAmigos($usuario->getId(), $usuarioLogado->getId())) {
                            if (!AmizadeBD::solicitadoAmizade($usuarioLogado->getId(), $usuario->getId()) && !AmizadeBD::solicitadoAmizade($usuario->getId(), $usuarioLogado->getId())) {
                                $add = true;
                            } else {
                                if (AmizadeBD::solicitadoAmizade($usuario->getId(), $usuarioLogado->getId())) {
                                    $solicitado = true;
                                } else {
                                    if (AmizadeBD::solicitadoAmizade($usuarioLogado->getId(), $usuario->getId())) {
                                        $enviado = true;
                                    }
                                }
                            }
                        }
                        echo('<div class="caixa">');
                        echo('<h1>' . $nome . '</h1>');
                        if ($add) {
                            echo('<form action="profile_usuario.php" method="post">');
                            echo('<input type="hidden" name="amigo" value="' . $usuario->getId() . '">');
                            echo('<button type="submit" name="action" value="Adicionar" style="background-color: white;border: none;">');
                            echo('    <img src="../imagens/iconmonstr-plus-6-72.png">');
                            echo('</button>');
                            echo('</form>');
                        }
                        if ($solicitado) {
                            echo ('<form action="profile_usuario.php?usuario=' . $id . '" method="post">');
                            echo ('<h5 class="erro">Recebi um pedido de amizade de ' . $usuario->getNome() . '</h5>');
                            echo ('<input type="hidden" name="amigo" value="' . $id . '">');
                            echo ('<input type="submit" name="action" value="Aceitar">');
                            echo ('</form>');
                        }
                        if ($enviado) {
                            echo ('<h5 class="erro">Pedido de amizade já enviado!!</h5>');
                        }
                        echo('<p><b>Data de Nascimento:</b> ' . $data . '</p>');
                        echo('<p><b>Checkins Totais:</b> ' . count($checkins) . '</p>');
                        echo('<p><b>Checkins Únicos:</b> ' . $checkinsUnicos . '</p>');
                        echo('<p><b>Badges:</b></p> ');
                        foreach ($badges as $badge) :
                            echo ('<img style="padding: 5px;" title="' . $badge->getNome() . '" src="../badges/badge' . $badge->getId() . '.jpg" width="100px" height="100px">');
                        endforeach;
                        echo('</div>');
                        echo('<div class="flex"><p><b>Check-ins:</b></p></div>');
                        foreach ($checkins as $checkin) :
                            echo('<div class="checkin">');
                            $cerveja = CervejaDB::getCervejaPorId($checkin->getCerveja());
                            $cervejaria = CervejariaDB::getCervejariaPorId($cerveja->getCervejaria());
                            $badges = PremiacaoBD::getBadgesPorIdCheckin($checkin->getId());
                            echo ('<p class="noMargin" style="color: #999999; padding-bottom: 12px;">' . $checkin->getData() . '</p>');
                            echo ('<p class="noMargin"><a href="profile_usuario.php?usuario=' . $usuario->getId() . '">' . $usuario->getNome() .
                            '</a>  realizou o checkin da cerveja <a href="profile_cerveja.php?cerveja=' . $cerveja->getId() . '">' .
                            $cerveja->getNome() . '</a> da <a href="profile_cervejaria.php?cervejaria=' . $cerveja->getCervejaria() . '">' . $cervejaria->getNome() . '</a> e deu '
                            . $checkin->getEstrelas() . ' estrelas</p>');
                            foreach ($badges as $badge) :
                                echo ('<img style="padding: 15px 5px 15px 5px;" title="' . $badge->getNome() . '" src="../badges/badge' . $badge->getId() . '.jpg" width="50px" height="50px">');
                            endforeach;
                            echo ('</p>');
                            $comentarios = ComentarioBD::getComentariosPorIdCheckin($checkin->getId());
                            foreach ($comentarios as $comentario) :
                                echo ('<div class="comentario">');
                                $comentador = UsuarioBD::getUsuarioPorId($comentario->getUsuario());
                                echo ('<p class="noMargin"><a href="profile_usuario.php?usuario=' . $comentador->getId() . '">' . $comentador->getNome() . '</a> comentou: ' .
                                $comentario->getTexto() . '</p>');
                                echo ('</div>');
                            endforeach;
                            if ($usuario->getId() == $usuarioLogado->getId() || AmizadeBD::saoAmigos($usuario->getId(), $usuarioLogado->getId())) {
                                echo ('<form action="profile_usuario.php?usuario=' . $id . '" method="post">');
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
        </div>
    </body>
</main>
