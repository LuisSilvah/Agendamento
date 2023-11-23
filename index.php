<?php

if (isset($_GET['menu'])) {
    $menu = $_GET['menu'];
} else {
    $menu = "";
}

switch ($menu) {

    case "home";
        include "./src/pages/home/home.php";
        break;

    case "agendamento";
        include "./src/pages/agenda/agendamento.php";
        break;

    case "editarAgendamento";
        include "./src/pages/agenda/view_edit.php";
        break;

    case "excluirAgendamento";
        include "./src/pages/agenda/view_delete.php";
        break;

    case "reservarSala";
        include "./src/pages/agenda/reservar_sala.php";
        break;

    case "usuario";
        include "./src/pages/usuario/usuario.php";
        break;

    case "criarUsuario";
        include "./src/pages/usuario/create_user.php";
        break;

    case "editarUsuario";
        include "./src/pages/usuario/view_edit.php";
        break;

    case "excluirUsuario";
        include "./src/pages/usuario/view_delete.php";
        break;

    case "impressora";
        include "./src/pages/impressora/impressora.php";
        break;

        case "criarImpressora";
        include "./src/pages/impressora/criar_impressora.php";
        break;

    case "logout";
        // header('Location: ./login.php');
        include "./login.php";
        break;

    default:
        include "./src/pages/home/home.php";
}
