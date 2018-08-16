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
require_once("../controller/AmizadeDB.php");
require_once("../controller/ComentarioDB.php");
$usuarioLogado = UsuarioBD::getUsuarioPorLogin($_SESSION['login']);
if (!empty($_GET["cervejaria"])) {
    $idCervejaria = $_GET['cervejaria'];
    $cervejaria = CervejariaDB::getCervejariaPorId($idCervejaria);
    $cervejas = CervejaDB::getCervejasPorIdCervejaria($idCervejaria);
    $checkins = CheckinBD::getCheckinsPorIdCervejaria($idCervejaria);
    $media = CheckinBD::getMediaEstrelasPorIdCervejaria($idCervejaria);
}
if (!empty($_POST["action"])) {
    $acao = $_POST["action"];
    switch ($acao) {
        case "Comentar":
            ComentarioBD::addComentario($_POST["checkin"], $usuarioLogado->getId(), $_POST["textoComentario"]);
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
    <body class="body">
        <div class="container">
            <div class="container_inner">
                <?php
                include "navbar.php";
                echo('<div class="perfil">');
                echo('<div class="conteudo">');
                echo('<div class="caixa">');
                echo('<p>Nome: ' . $cervejaria->getNome() . '</p>');
                echo('<p>Tipo: ' . $cervejaria->getTipo() . '</p>');
                echo('<p>Local: ' . $cervejaria->getLocal() . '</p>');
                echo('Cervejas:');
                echo('<ol style="width:100%; padding: 0;">');
                foreach ($cervejas as $cerveja) :
                    echo('<li style="list-style-type: none">');
                    echo('<a href="profile_cerveja.php?cerveja=' . $cerveja->getId() . '">' . $cerveja->getNome() . '</a>');
                    echo('</li>');
                endforeach;
                echo('</ol>');
                echo('<p>Média de Estrelas: ' . $media . '</p>');
                echo('<p>Checkins: ' . count($checkins) . '</p>');
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
                        echo ('<form action="profile_cervejaria.php?cervejaria=' . $idCervejaria . '" method="post">');
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
