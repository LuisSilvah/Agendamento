<?php

include_once("./src/components/header.php");
include_once("./src/config/Dbconfig.php");
include_once("./src/config/verifica_usuario.php");
include_once("./src/config/class_impressora.php");
include_once("./src/components/sidebar.php");

$database = new DatabaseImpressora();

$toner = $database->Lendo_Dados_Toner();
$tonerUsados = $database->Lendo_Dados_Toner_Usados();
$impressora = $database->Lendo_Dados_Impressora();

$option_tab = array(
    array("item_nav" => "Toners", "slug" => "toner"),
    array("item_nav" => "Toners Usados", "slug" => "tonerUsado"),
    array("item_nav" => "Impressoras", "slug" => "impressora"),
);

if (isset($_GET['tab'])) {
    $tab = $_GET['tab'];
} else {
    $tab = "toner";
}

?>

<div class="content-wrapper bg-principal w-100">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border mt-4" align="center">
                        <h3 class="box-title"><b>Impressoras</b></h3>
                    </div>

                    <div align="right">

                        <?php
                        if ($_SESSION['userStatus'] === "admin") {
                            echo "<a href='index.php?menu=criarImpressora' class='btn btn-primary'>Criar Nova Impressora</a>";
                        }
                        ?>

                        <?php
                        if ($_SESSION['userStatus'] === "admin") {
                            echo "<a href='index.php?menu=criarToner' class='btn btn-primary'>Adicionar Toners</a>";
                        }
                        ?>


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
                                                                    } ?>" href="index.php?menu=impressora&tab=<?= $item['slug'] ?>">
                                        <?php echo $item['item_nav'] ?>
                                        <?php
                                        if (mysqli_num_rows($toner) > 0 && $item['slug'] === "toner") {
                                            $quantidade = mysqli_num_rows($toner);
                                            echo "- $quantidade";
                                        }
                                        ?>

                                        <?php
                                        if (mysqli_num_rows($tonerUsados) > 0 && $item['slug'] === "tonerUsado") {
                                            $quantidade = mysqli_num_rows($tonerUsados);
                                            echo "- $quantidade";
                                        }
                                        ?>

                                        <?php
                                        if (mysqli_num_rows($impressora) > 0 && $item['slug'] === "impressora") {
                                            $quantidade = mysqli_num_rows($impressora);
                                            echo "- $quantidade";
                                        }
                                        ?>
                                    </a>
                                </li>

                            <?php endforeach ?>
                        </ul>
                    </div>

                    <div class="table table-responsive <?php if (strval($tab) !== "toner") {
                                                            echo "d-none";
                                                        } ?>">
                        <table class='table table-striped' id="agenda">
                            <thead>
                                <tr>
                                    <th>Modelo</th>
                                    <th>Quantidade</th>
                                    <th>Serie</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>

                                    <form role="" method="POST">
                                        <th>
                                            <input class="form-control" name="search" type="text" id="" autofocus placeholder="Filtro Toner" />
                                        </th>
                                        <th>
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
                                <?php
                                if (mysqli_num_rows($toner) < 1) {
                                    $toner = [];
                                    echo "<tr><th>Adicione Toner!</th></tr>";
                                }
                                ?>
                            </thead>
                            <tbody>
                                <?php foreach ($toner as $row) : ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['modelo']) ?></td>
                                        <td><?= htmlspecialchars($row['quantidade']) ?></td>
                                        <td><?= htmlspecialchars($row['serie']) ?></td>
                                        <td>
                                            <?php
                                            $id = $row['id'];
                                            if ($_SESSION['userStatus'] === "admin" || $_SESSION['userStatus'] === "master") {
                                                echo " <a class='btn btn-primary text-white' href='./index.php?menu=editarToner&id=$id'>Editar</a>";
                                            } else {
                                                echo "";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php

                                            $id = $row['id'];
                                            if ($_SESSION['userStatus'] === "admin" || $_SESSION['userStatus'] === "master") {
                                                echo " <a class='btn btn-danger text-white' href='./index.php?menu=excluirToner&id=$id'>Excluir</a>";
                                            } else {
                                                echo "";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="table table-responsive <?php if (strval($tab) !== "tonerUsado") {
                                                            echo "d-none";
                                                        } ?>">
                        <table class='table table-striped' id="agenda">
                            <thead>
                                <tr>
                                    <th>Modelo</th>
                                    <th>Quantidade</th>
                                    <th>Serie</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>

                                    <form role="" method="POST">
                                        <th>
                                            <input class="form-control" name="search" type="text" id="" autofocus placeholder="Filtro Toners usados" />
                                        </th>
                                        <th>
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
                                <?php
                                if (mysqli_num_rows($tonerUsados) < 1) {
                                    $tonerUsados = [];
                                    echo "<tr><th>Nenhum Toner usado no momento!</th></tr>";
                                }
                                ?>
                            </thead>
                            <tbody>
                                <?php foreach ($tonerUsados as $row) : ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['modelo']) ?></td>
                                        <td><?= htmlspecialchars($row['quantidade']) ?></td>
                                        <td><?= htmlspecialchars($row['serie']) ?></td>
                                        <td>
                                            <?php
                                            $id = $row['id'];
                                            if ($_SESSION['userStatus'] === "admin" || $_SESSION['userStatus'] === "master") {
                                                echo " <a class='btn btn-primary text-white' href='./index.php?menu=editarToner&id=$id'>Editar</a>";
                                            } else {
                                                echo "";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php

                                            $id = $row['id'];
                                            if ($_SESSION['userStatus'] === "admin" || $_SESSION['userStatus'] === "master") {
                                                echo " <a class='btn btn-danger text-white' href='./index.php?menu=excluirToner&id=$id'>Excluir</a>";
                                            } else {
                                                echo "";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="table table-responsive <?php if (strval($tab) !== "impressora") {
                                                            echo "d-none";
                                                        } ?>">
                        <table class='table table-striped' id="agenda">
                            <thead>
                                <tr>
                                    <th>Modelo</th>
                                    <th>Setor</th>
                                    <th>IP</th>
                                    <th>Serie</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>

                                    <form method="POST">
                                        <th>
                                            <input class="form-control" name="search_impressora" type="text" id="" autofocus placeholder="Filtro Impressora" />
                                        </th>
                                        <th>
                                        </th>
                                        <th>
                                        </th>
                                        <th>
                                            <select class="form-select text-capitalize" aria-label="Default select example" name="sala">
                                                <option value="" selected>Setor</option>
                                                <?php

                                                foreach ($option_setor as $row) {
                                                    $value = $row['value'];
                                                    $item = $row['item'];

                                                    echo "<option class='text-capitalize' value='$value'>$item</option>";
                                                }
                                                ?>
                                            </select>
                                        </th>
                                        <th>
                                        </th>
                                        <th>
                                            <button class="btn btn-outline-primary">Filtrar</button>
                                        </th>
                                    </form>
                                </tr>
                                <?php
                                if (mysqli_num_rows($impressora) < 1) {
                                    $impressora = [];
                                    echo "<tr><th>Adicione Impressora!</th></tr>";
                                }
                                ?>
                            </thead>
                            <tbody>
                                <?php foreach ($impressora as $row) : ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['modelo']) ?></td>
                                        <td><?= htmlspecialchars($row['setor']) ?></td>
                                        <td class="">
                                            <div class="d-flex gap-2">
                                                <div><?= htmlspecialchars($row['ip']) ?></div>
                                                <div style="width: 10px; height: 10px" class="rounded-circle"></div>
                                                <?php
                                                $status = $row['status'];

                                                if ($status === "ativado") {
                                                    echo "bg-success";
                                                } else
                                                    echo "bg-danger";
                                                ?>">
                                            </div>
                    </div>
                    </td>
                    <td><?= htmlspecialchars($row['serie']) ?></td>
                    <td>
                        <?php
                                    $id = $row['id'];
                                    if ($_SESSION['userStatus'] === "admin" || $_SESSION['userStatus'] === "master") {
                                        echo " <a class='btn btn-primary text-white' href='./index.php?menu=editarImpressora&id=$id'>Editar</a>";
                                    } else {
                                        echo "";
                                    }
                        ?>
                    </td>
                    <td>
                        <?php

                                    $id = $row['id'];
                                    if ($_SESSION['userStatus'] === "admin" || $_SESSION['userStatus'] === "master") {
                                        echo " <a class='btn btn-danger text-white' href='./index.php?menu=excluirImpressora&id=$id'>Excluir</a>";
                                    } else {
                                        echo "";
                                    }
                        ?>
                    </td>
                    </tr>
                <?php endforeach ?>
                </tbody>
                </table>
                </div>

            </div>
        </div>
</div>
</section>
</div>