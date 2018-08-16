<style>
<?php include '../style.css'; ?>
</style>
<?php
include "random_bg.php";
include_once("../validar.php");
require_once("../controller/UsuarioDB.php");
require_once("../controller/CervejaDB.php");
require_once("../controller/CervejariaDB.php");

if (!empty($_GET["busca"])) {
    $busca = $_GET["busca"];
    $usuarios = UsuarioBD::getUsuariosPorNome($busca);
    $cervejas = CervejaDB::getCervejasPorNome($busca);
    $cervejarias = CervejariaDB::getCervejariasPorNome($busca);
} else {
    $usuarios = UsuarioBD::getUsuariosPorNome("%");
    $cervejas = CervejaDB::getCervejasPorNome("%");
    $cervejarias = CervejariaDB::getCervejariasPorNome("%");
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
                echo ('<div class="busca">');
                echo ('<div class="conteudo">');
                echo ('Cervejarias:');
                echo ('<ol>');
                foreach ($cervejarias as $cervejaria) :
                    echo ('<li>');
                    echo ('<a href="profile_cervejaria.php?cervejaria=' . $cervejaria->getId() . '">' . $cervejaria->getNome() . '</a>');
                    echo ('</li>');
                endforeach;
                echo ('</ol>');
                echo ('Cervejas:');
                echo ('<ol>');
                foreach ($cervejas as $cerveja) :
                    echo ('<li>');
                    echo ('<a href="profile_cerveja.php?cerveja=' . $cerveja->getId() . '">' . $cerveja->getNome() . '</a> ');
                    echo ('</li>');
                endforeach;
                echo ('</ol>');
                echo ('Usuários:');
                echo ('<ol>');
                foreach ($usuarios as $usuario) :
                    echo ('<li>');
                    echo ('<a href="profile_usuario.php?usuario=' . $usuario->getId() . '">' . $usuario->getNome() . '</a>');
                    echo ('</li>');
                endforeach;
                echo ('</ol>');
                echo ('</div>');
                echo ('</div>');
                ?>
            </div>
        </div>
    </body>
</main>
