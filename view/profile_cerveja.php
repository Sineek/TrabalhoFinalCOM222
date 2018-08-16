<style>
<?php include '../style.css'; ?>
</style>
<?php
include "random_bg.php";
include_once("../validar.php");
require_once("../controller/CervejaDB.php");
require_once("../controller/CervejariaDB.php");
require_once("../controller/CheckinDB.php");
require_once("../controller/UsuarioDB.php");
require_once("../controller/ComentarioDB.php");
require_once("../controller/AmizadeDB.php");
if (!empty($_GET["cerveja"])) {
    $cerveja = CervejaDB::getCervejaPorId($_GET['cerveja']);
    $id = $cerveja->getId();
    $checkins = CheckinBD::getCheckinsPorIdCerveja($id);
    $media = CheckinBD::getMediaEstrelasPorIdCerveja($id);
    $cervejaria = CervejariaDB::getCervejariaPorId($cerveja->getCervejaria());
}
$usuarioLogado = UsuarioBD::getUsuarioPorLogin($_SESSION['login']);
?>
<main>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,400,500" rel="stylesheet">
    </head>
    <body class="body">
        <div class="container">
            <div class="container_inner">
                <?php
                include "navbar.php";
                echo('<div class="perfil">');
                echo('<div class="conteudo">');
                echo('<div class="caixa">');
                echo('<p>Nome: ' . $cerveja->getNome() . '</p>');
                echo('<p>Teor Alcoólico: ' . $cerveja->getTeorAlcoolico() . '</p>');
                echo('<p>Tipo: ' . $cerveja->getTipo() . '</p>');
                echo('Cervejaria: <a href="profile_cervejaria.php?cervejaria=' . $cervejaria->getId() . '">' . $cervejaria->getNome() . '</a>');
                echo('<p>Média de Estrelas: ' . $media . '</p>');
                echo('<p>Checkins:' . count($checkins) . '</p>');
                echo('</div>');
                foreach ($checkins as $checkin) :
                    echo('<div class="checkin">');
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
                        echo ('<p class="noMargin"><a href="profile_usuario.php?usuario=' . $comentador->getId() . '">' . $comentador->getNome() . '</a> comentou: ' .
                        $comentario->getTexto() . '</p>');
                        echo ('</div>');
                    endforeach;
                    if ($usuario->getId() == $usuarioLogado->getId() || AmizadeBD::saoAmigos($usuario->getId(), $usuarioLogado->getId())) {
                        echo ('<form action="profile_usuario.php?usuario=' . $usuario->getId() . '" method="post">');
                        echo ('<input type="hidden" name="usuario" value="' . $usuarioLogado->getId() . '">');
                        echo ('<input type="hidden" name="checkin" value="' . $checkin->getId() . '">');
                        echo ('<input type="text" name="textoComentario">');
                        echo ('<input type="submit" name="action" value="Comentar">');
                        echo ('</form>');
                    }
                    echo ('</div>');
                endforeach;
                ?>
                </body>
                </main>
