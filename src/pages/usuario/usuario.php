<?php

include("./src/config/verifica_usuario.php");
include_once("./src/config/Dbconfig.php");
include_once("./src/config/class_login.php");
include_once("./src/components/header.php");
include_once("./src/components/sidebar.php");

$databaseLogin = new DatabaseLogin();

if (isset($_SESSION['userStatus'])) {
    if ($_SESSION['userStatus'] ===  'user') {
        $id = $_SESSION['auth'];
        $usuarios = $databaseLogin->Lendo_Usuarios_ID($id);
    } else {
        $usuarios = $databaseLogin->Lendo_Usuarios();
    }
}

$URL_ATUAL = "http://$_SERVER[HTTP_HOST]";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $search = String_Input($_POST["search"]);

    $usuarios = $databaseLogin->Filtros_Usuarios($search);
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
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">

                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border mt-4" align="center">
                        <h3 class="box-title"><b>Usuário (operadores do sistema)</b></h3>
                    </div>
                    <div align="right">
                        <?php
                        if ($_SESSION['userStatus'] === "admin") {

                            echo  "<a href='index.php?menu=criarUsuario' class='btn btn-primary'>Criar usuário</a>";
                        }
                        ?>
                        <a href='<?php echo "$URL_ATUAL/" ?>' class="btn btn-danger">Home</a>
                    </div>

                    <div class="table table-responsive <?php if (strval($tab) === "meAgenda") {
                                                            echo "d-none";
                                                        } ?>">
                        <table class='table table-striped' id="agenda">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Login</th>
                                    <th>Área admin</th>
                                    <th>E-mail</th>
                                </tr>
                                <tr <?php
                                    if ($_SESSION['userStatus'] === "admin") {
                                        echo "'";
                                    } else {
                                        echo "class='d-none'";
                                    }
                                    ?>>

                                    <form role="" method="POST">
                                        <th>
                                            <input class="form-control w-60" name="search" type="text" id="" autofocus placeholder="Filtro de usuário" />
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
                                <tr>
                                    <th>
                                        <?php
                                        if (!$usuarios) {
                                            $usuarios = [];
                                            echo "Nenhum Uusário encontrado!";
                                        }
                                        ?>
                                    </th>
                                </tr>
                            </thead>

                            <tbody id="xxxxxxxx">
                                <?php foreach ($usuarios as $row) : ?>
                                    <tr>
                                        <td class="p-3">
                                            <div class='col'>
                                                <div class='row text-capitalize'><?= htmlspecialchars($row['name']) ?></div>
                                            </div>
                                        </td>
                                        <td><?= htmlspecialchars($row['username']) ?></td>
                                        <td>
                                            <?php if ($row['status'] === "admin") {
                                                echo "SIM";
                                            } else {
                                                echo "NÂO";
                                            } ?>
                                        </td>
                                        <td><?= htmlspecialchars($row['email']) ?></td>
                                        <td>

                                            <?php
                                            $id =  $row['id'];
                                            echo " <a class='btn btn-primary text-white' href='./index.php?menu=editarUsuario&id=$id'>Editar</a>";
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $id =  $row['id'];
                                            if ($_SESSION['userStatus'] === "admin") {
                                                if($_SESSION['auth'] !== $id) {
                                                echo " <a class='btn btn-danger text-white' href='./index.php?menu=excluirUsuario&id=$id'>Excluir</a>";
                                            } else echo "";
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