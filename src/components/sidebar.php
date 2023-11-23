<?php

$URL_ATUAL = "http://$_SERVER[HTTP_HOST]";

$option_menu = array(
    array("item_menu" => "Home", "slug" => "home", "categoria" => "home"),
    array("item_menu" => "Agendamento", "slug" => "agendamento", "categoria" => "agendamento"),
);

$option_title = array(
    array("item_menu" => "Home", "slug" => "home"),
    array("item_menu" => "Agendamento", "slug" => "agendamento"),
    array("item_menu" => "Editar sala", "slug" => "editarAgendamento"),
    array("item_menu" => "Deletar sala", "slug" => "excluirAgendamento"),
    array("item_menu" => "Reservar sala", "slug" => "reservarSala"),
    array("item_menu" => "Criar usuário", "slug" => "criarUsuario"),
    array("item_menu" => "Usuario", "slug" => "usuario"),
    array("item_menu" => "Editar Usuario", "slug" => "editarUsuario"),
    array("item_menu" => "Impressoras", "slug" => "impressora"),

    array("item_menu" => "Adicionar Impressora", "slug" => "criarImpressora"),
    array("item_menu" => "Editar Impressora", "slug" => "editarImpressora"),
    array("item_menu" => "Deletar Impressora", "slug" => "excluirImpressora"),

    array("item_menu" => "Adicionar Toner", "slug" => "criarToner"),
    array("item_menu" => "Deletar Toner", "slug" => "excluirToner"),
    array("item_menu" => "Editar Toner", "slug" => "editarToner"),
);

if (isset($_GET['menu'])) {
    $menu = $_GET['menu'];
} else {
    $menu = "home";
}

?>

<div class="d-flex">
    <div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark " style="width: 280px;">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <img src="./assests/selmi_logo.png" height="60px" alt="" srcset="">

            <?php foreach ($option_title as $item) : ?>
                <?php
                if ($item['slug'] === $menu) {
                    echo "<span  class='nav-link text-white text-capitalize fs-4'>" . $item['item_menu'] . "</span>";
                }
                ?>
            <?php endforeach ?>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto flex-nowrap " style="overflow-y: auto; max-height: 400px">
            <?php foreach ($option_menu as $item) : ?>
                <li class="nav-item">
                    <a href="index.php?menu=<?= $item['slug'] ?>" class="nav-link <?php
                                                                                    if ($item['slug'] === $menu) {
                                                                                        echo "active";
                                                                                    } else {
                                                                                        echo "text-white";
                                                                                    } ?>" aria-current="page">
                        <svg class="bi pe-none me-2" width="16" height="16">
                            <use xlink:href="#home" />
                        </svg>
                        <?= htmlspecialchars($item['item_menu']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
            <li class="nav-item">
                <a href="index.php?menu=impressora" class="nav-link <?php
                                                                    if ($menu  === "impressora") {
                                                                        echo "active";
                                                                    } else {
                                                                        echo "text-white";
                                                                    }
                                                                    if ($_SESSION['setor'] === "TI" || $_SESSION['setor'] === "dev") {
                                                                        echo "";
                                                                    } else {
                                                                        echo "text-white d-none";
                                                                    } ?>" aria-current="page">
                    <svg class="bi pe-none me-2" width="16" height="16">
                        <use xlink:href="#home" />
                    </svg>
                    Impressoras
                </a>
            </li>
            <li class="nav-item">
                <a href="index.php?menu=usuario" class="nav-link <?php
                                                                    if ($menu  === "usuario") {
                                                                        echo "active";
                                                                    } else {
                                                                        echo "text-white";
                                                                    } ?>" aria-current="page">
                    <svg class="bi pe-none me-2" width="16" height="16">
                        <use xlink:href="#home" />
                    </svg>
                    Usuario
                </a>
            </li>
            <li>
                <a href='<?php echo "$URL_ATUAL/agenda/src/config/logout.php" ?>' class="nav-link  <?php
                                                                                                    if ($menu === "logout") {
                                                                                                        echo "active";
                                                                                                    } else {
                                                                                                        echo "text-white";
                                                                                                    }
                                                                                                    ?>">
                    <svg class="bi pe-none me-2" width="16" height="16">
                        <use xlink:href="#speedometer2" />
                    </svg>
                    Logout
                </a>
            </li>
        </ul>
        <hr>
        <div class="d-flex align-items-center justify-content-center">
            <span class='nav-link text-white text-capitalize  fs-4'>
                <?php
                if (isset($_SESSION['username'])) {
                    echo $_SESSION['username'];
                }
                ?>
            </span>
        </div>
    </div>