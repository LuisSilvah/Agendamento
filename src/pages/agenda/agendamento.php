<?php

include_once("./src/components/header.php");
include_once("./src/config/verifica_usuario.php");
include_once("./src/components/sidebar.php");
include_once("./src/config/class_login.php");

$URL_ATUAL = "http://$_SERVER[HTTP_HOST]";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $search = String_Input($_POST["search"]);
    $sala = String_Input($_POST["sala"]);

    $agenda = $databaseAgenda->Filtros_Agenda($search, $sala);
}

function String_Input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$option_tab = array(
    array("item_nav" => "Agendamentos", "slug" => "agendamentos"),
    array("item_nav" => "Ultimos agendamentos", "slug" => "historyAgenda"),
);

if (isset($_GET['tab'])) {
    $tab = $_GET['tab'];
} else {
    $tab = "agendamentos";
}

?>

<!-- View Agenda -->
<div class="content-wrapper bg-principal w-100" id="viewAgenda">
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border mt-4" align="center">
                        <h3 class="box-title"><b>Salas de Reunião</b></h3>
                    </div>

                    <div align="right">
                        <a href="index.php?menu=reservarSala" class="btn btn-primary">Reservar Sala</a>
                        <a href='<?php echo "$URL_ATUAL/" ?>' class="btn btn-danger">Home</a>
                    </div>
                    <div class="nav nav-tabs">
                        <ul class="nav nav-tabs">
                            <?php foreach ($option_tab as $item) : ?>
                                <li class="nav-item">
                                    <a class="nav-link text-black <?php
                                                                    if (strval($item['slug']) === strval($tab)) {
                                                                        echo "active";
                                                                    } else {
                                                                        echo "text-black";
                                                                    } ?>" href="index.php?menu=agendamento&tab=<?= $item['slug'] ?>">
                                        <?php echo $item['item_nav'] ?>
                                    </a>
                                </li>

                            <?php endforeach ?>
                        </ul>
                    </div>

                    <div class="table table-responsive <?php if (strval($tab) === "historyAgenda") {
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
                                <tr <?php
                                    if (!$agenda) {
                                        echo "";
                                    } else echo "class='d-none'";
                                    ?>>
                                <tr>
                                    <th>
                                        <?php
                                        if (!$agenda) {
                                            $agenda = [];
                                            echo "Sem Agendamento!";
                                        }
                                        ?>
                                    </th>
                                </tr>
                            </thead>

                            <tbody id="xxxxxxxx">
                                <?php foreach ($agenda as $row) : ?>
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

                    <div class="table table-responsive <?php if (strval($tab) === "agendamentos") {
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
                                <tr <?php
                                    if (!$agenda) {
                                        echo "";
                                    } else echo "class='d-none'";
                                    ?>>
                                    <th>
                                        <?php
                                        if (!$agenda) {
                                            $agenda = [];
                                            echo "Sem Agendamento!";
                                        }
                                        ?>
                                    </th>
                                </tr>
                            </thead>

                            <tbody id="xxxxxxxx">
                                <?php foreach ($agenda as $row) : ?>
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
            </div>
        </div>
    </section>
</div>


<?php
include_once("./src/components/footer.php");
?>