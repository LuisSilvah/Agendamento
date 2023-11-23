<?php

include_once("./src/config/verifica_usuario.php");
include_once("./src/config/Dbconfig.php");
include_once("./src/config/class_agenda.php");
include_once("./src/components/header.php");
include_once("./src/components/sidebar.php");

$database = new DatabaseAgenda();

$option_tab = array(
    array("item_nav" => "Agendamentos", "slug" => "nextAgenda"),
    array("item_nav" => "Seus agendamentos", "slug" => "meAgenda"),
    array("item_nav" => "Ultimos agendamentos", "slug" => "historyAgenda"),
);

if (isset($_GET['tab'])) {
    $tab = $_GET['tab'];
} else {
    $tab = "nextAgenda";
}

$search_active = "";

$Agenda = $database->Lendo_Dados_Agenda();
$meAgenda = $database->Procura_Agenda_Id($_SESSION['auth']);
$historyAgenda = $database->Lendo_Dados_Agenda();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $search = String_Input($_POST["search"]);
    $sala = String_Input($_POST["sala"]);

    $Agenda = $databaseAgenda->Filtros_Agenda($search, $sala);
    $historyAgenda = $databaseAgenda->Filtros_Agenda($search, $sala);
    $search_active = "active";
}

function String_Input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


?>

<div class="content-wrapper bg-principal w-100">
    <div class="box-header with-border mt-4" align="center">

        <?php foreach ($option_tab as $item) : ?>
            <h3 class="box-title">
                <b>
                    <?php
                    if (strval($item['slug']) === strval($tab)) {
                        echo $item['item_nav'];
                        if (strval($tab) === "nextAgenda" && $search_active === "") {
                            echo  " - " . date('d/m/Y');
                        }
                    } ?>
                </b>
            </h3>
        <?php endforeach ?>
    </div>
    <div align="right">
        <a href='<?php echo "$URL_ATUAL/agenda/src/config/logout.php" ?>' class="btn btn-danger">Sair</a>
    </div>
    <ul class="nav nav-tabs">
        <?php foreach ($option_tab as $item) : ?>
            <li class="nav-item">
                <a class="nav-link text-black <?php
                                                if (strval($item['slug']) === strval($tab)) {
                                                    echo "active";
                                                } else {
                                                    echo "text-black";
                                                } ?>" href="index.php?menu=home&tab=<?= $item['slug'] ?>">
                    <?php echo $item['item_nav'] ?>
                </a>
            </li>
        <?php endforeach ?>
    </ul>

    <div class="table table-responsive <?php if (strval($tab) === "meAgenda" || strval($tab) === "historyAgenda") {
                                            echo "d-none";
                                        } ?>">
        <table class='table table-striped' id="agenda">
            <thead>
                <tr>
                    <th>Solicitante</th>
                    <th>Hora Inicial</th>
                    <th>Hora Fechamento</th>
                    <th>Sala</th>
                    <th>Data</th>
                    <th>Observação do café</th>
                </tr>
                <tr>

                    <form role="" method="POST">
                        <th>
                            <input class="form-control" name="search" type="text" id="" autofocus placeholder="Filtro de agendamento" />
                        </th>
                        <th>
                        </th>
                        <th>
                        </th>
                        <th>
                            <select class="form-select text-capitalize" aria-label="Default select example" name="sala">
                                <option value="" selected>Sala</option>
                                <?php

                                foreach ($option_sala as $value) {
                                    echo "<option class='text-capitalize' value='$value'>$value</option>";
                                }
                                ?>
                            </select>
                        </th>
                        <th>
                        </th>
                        <th>
                        </th>
                        <th>
                            <button class="btn btn-outline-primary">Filtrar</button>
                        </th>
                    </form>
                </tr>
                <tr>
                    <th>
                        <?php
                        if (!$Agenda) {
                            $Agenda = [];
                            echo "Sem Agendamento!";
                        }
                        ?>
                    </th>
                </tr>
            </thead>

            <tbody id="xxxxxxxx">
                <?php foreach ($Agenda as $row) : ?>
                    <tr <?php
                        date_default_timezone_set('America/Sao_Paulo');
                        $data_de_hoje = date('Y-m-d');

                        if ($data_de_hoje <= $row['data']) {
                            echo "class=''";
                        } else {
                            echo "class='d-none'";
                        }
                        ?>>
                        <td class="p-3">
                            <div class='col'>
                                <div class='row text-capitalize'><?= htmlspecialchars($row['sol_name']) ?></div>
                                <div class='row'><?= htmlspecialchars($row['sol_email']) ?></div>
                            </div>
                        </td>
                        <td><?= htmlspecialchars($row['hora_ini']) ?></td>
                        <td><?= htmlspecialchars($row['hora_fim']) ?></td>
                        <td class="text-capitalize"><?= htmlspecialchars($row['sala']) ?></td>
                        <td>
                            <?=
                            htmlspecialchars(date_format(date_create($row['data']), "d/m/Y"));
                            ?>
                        </td>
                        <td class="text-capitalize"><?= htmlspecialchars($row['obs_cafe']) ?></td>
                        <td>
                            <?php
                            $id = $row['id'];
                            if ($_SESSION['userStatus'] === "admin" || $_SESSION['auth'] === $row['usuarioId']) {
                                echo " <a class='btn btn-primary text-white' href='./index.php?menu=editarAgendamento&id=$id'>Edit</a>";
                            } else {
                                echo "";
                            }
                            ?>
                        </td>
                        <td>
                            <?php

                            $id = $row['id'];
                            if ($_SESSION['userStatus'] === "admin" || $_SESSION['auth'] === $row['usuarioId']) {
                                echo " <a class='btn btn-danger text-white' href='./index.php?menu=excluirAgendamento&id=$id'>Excluir</a>";
                            } else {
                                echo "";
                            }
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>

    <div class="table table-responsive <?php if (strval($tab) === "nextAgenda" || strval($tab) === "historyAgenda") {
                                            echo "d-none";
                                        } ?>">
        <table class='table table-striped' id="agenda">
            <thead>
                <tr>
                    <th>Solicitante</th>
                    <th>Hora Inicial</th>
                    <th>Hora Fechamento</th>
                    <th>Sala</th>
                    <th>Data</th>
                    <th>Observação do café</th>
                </tr>
                <tr>
                    <th>
                        <?php
                        if (!$meAgenda) {
                            $meAgenda = [];
                            echo "Sem agendamento criado!";
                        }
                        ?>
                    </th>
                </tr>
            </thead>

            <tbody id="xxxxxxxx">
                <?php foreach ($meAgenda as $row) : ?>
                    <?php
                    // Resulta da busca de agendas
                    // echo "<pre>";
                    // print_r($row);
                    // echo "</pre>";
                    ?>
                    <tr <?php
                        $data_de_hoje = date('Y-m-d');
                        if ($data_de_hoje > $row['data']) {
                            echo "class='d-none'";
                        } else {
                            echo "class=''";
                        }
                        ?>>
                        <td class="p-3">
                            <div class='col'>
                                <div class='row text-capitalize'><?= htmlspecialchars($row['sol_name']) ?></div>
                                <div class='row'><?= htmlspecialchars($row['sol_email']) ?></div>
                            </div>
                        </td>
                        <td><?= htmlspecialchars($row['hora_ini']) ?></td>
                        <td><?= htmlspecialchars($row['hora_fim']) ?></td>
                        <td class="text-capitalize"><?= htmlspecialchars($row['sala']) ?></td>
                        <td>
                            <?=
                            htmlspecialchars(date_format(date_create($row['data']), "d/m/Y"));
                            ?>
                        </td>
                        <td class="text-capitalize"><?= htmlspecialchars($row['obs_cafe']) ?></td>
                        <td>
                            <?php
                            $id = $row['id'];
                            if ($_SESSION['userStatus'] === "admin" || $_SESSION['auth'] === $row['usuarioId']) {
                                echo " <a class='btn btn-primary text-white' href='./index.php?menu=editarAgendamento&id=$id'>Edit</a>";
                            } else {
                                echo "";
                            }
                            ?>
                        </td>
                        <td>
                            <?php

                            $id = $row['id'];
                            if ($_SESSION['userStatus'] === "admin" || $_SESSION['auth'] === $row['usuarioId']) {
                                echo " <a class='btn btn-danger text-white' href='./index.php?menu=excluirAgendamento&id=$id'>Excluir</a>";
                            } else {
                                echo "";
                            }
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>

    <div class="table table-responsive <?php if (strval($tab) === "nextAgenda" || strval($tab) === "meAgenda") {
                                            echo "d-none";
                                        } ?>">
        <table class='table table-striped' id="agenda">
            <thead>
                <tr>
                    <th>Solicitante</th>
                    <th>Hora Inicial</th>
                    <th>Hora Fechamento</th>
                    <th>Sala</th>
                    <th>Data</th>
                    <th>Observação do café</th>
                </tr>

                <tr>

                    <form role="" method="POST">
                        <th>
                            <input class="form-control" name="search" type="text" id="" autofocus placeholder="Filtro de agendamento" />
                        </th>
                        <th>
                        </th>
                        <th>
                        </th>
                        <th>
                            <select class="form-select text-capitalize" aria-label="Default select example" name="sala">
                                <option value="" selected>Sala</option>
                                <?php

                                foreach ($option_sala as $value) {
                                    echo "<option class='text-capitalize' value='$value'>$value</option>";
                                }
                                ?>
                            </select>
                        </th>
                        <th>
                        </th>
                        <th>
                        </th>
                        <th>
                            <button class="btn btn-outline-primary">Filtrar</button>
                        </th>
                    </form>
                </tr>
                <tr>
                    <th>
                        <?php
                        if (!$historyAgenda) {
                            $historyAgenda = [];
                            echo "Sem agendamento criado!";
                        }
                        ?>
                    </th>
                </tr>
            </thead>

            <tbody id="xxxxxxxx">
                <?php foreach ($historyAgenda as $row) : ?>
                    <tr <?php
                        $data_de_hoje = date('Y-m-d');
                        if ($data_de_hoje > $row['data']) {
                            echo "class=''";
                        } else {
                            echo "class='d-none'";
                        }
                        ?>>
                        <td class="p-3">
                            <div class='col'>
                                <div class='row text-capitalize'><?= htmlspecialchars($row['sol_name']) ?></div>
                                <div class='row'><?= htmlspecialchars($row['sol_email']) ?></div>
                            </div>
                        </td>
                        <td><?= htmlspecialchars($row['hora_ini']) ?></td>
                        <td><?= htmlspecialchars($row['hora_fim']) ?></td>
                        <td class="text-capitalize"><?= htmlspecialchars($row['sala']) ?></td>
                        <td>
                            <?=
                            htmlspecialchars(date_format(date_create($row['data']), "d/m/Y"));
                            ?>
                        </td>
                        <td class="text-capitalize"><?= htmlspecialchars($row['obs_cafe']) ?></td>
                        <td>
                        </td>
                        <td>
                            <?php
                            $id = $row['id'];
                            if ($_SESSION['userStatus'] === "admin" || $_SESSION['auth'] === $row['usuarioId']) {
                                echo " <a class='btn btn-danger text-white' href='./index.php?menu=excluirAgendamento&id=$id'>Excluir</a>";
                            } else {
                                echo "";
                            }
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>

</div>