<?php

include_once("./src/config/verifica_usuario.php");

include_once("./src/components/header.php");
include_once("./src/components/sidebar.php");


$usuario = $databaseLogin->Procura_Dados_Usuario($_GET['id']);


$id = $name = $email = $password = $newPassword = $confirmPassword = "";
$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $id = $_GET['id'];
    $userStatus = $_SESSION['userStatus'];
    $status = String_Input($_POST['status']);
    $password = String_Input($_POST['senha_atual']);
    $newPassword = String_Input($_POST['nova_senha']);
    $confirmPassword = String_Input($_POST['confirmar']);

    if ($_SESSION['userStatus'] === "admin") {
        $name = String_Input($_POST['name']);
        $email = String_Input($_POST['email']);
    }

    $databaseLogin->Editar_Usuario($name, $email, $password, $newPassword, $confirmPassword, $userStatus, $status, $id);
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
                    <!-- Header da pagina -->
                    <div class="box-header with-border mt-4" align="center">
                        <h3 class="box-title"><b>Editar Usuario</b></h3>
                    </div>
                    <div align="right">
                        <a href="./index.php?menu=usuario" class="btn btn-danger">Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <form action="" method="post">
        <div class="container">
            <div class="row gap-2 ">
                <div class="">

                    <!-- Editar Nome -->
                    <div class="">
                        <label for="name">Nome do Usuário:</label>
                        <div class="input-group mt-2">
                            <input name="name" value="<?= htmlspecialchars($usuario['name']) ?>" type="text" class="form-control" placeholder="Nome" aria-label="nome" aria-describedby="input-name" <?php
                                                                                                                                                                                                        if ($_SESSION['userStatus'] === "user") {
                                                                                                                                                                                                            echo "disabled";
                                                                                                                                                                                                        } else {
                                                                                                                                                                                                            echo "";
                                                                                                                                                                                                        }
                                                                                                                                                                                                        ?>>
                        </div>
                    </div>

                    <!-- Editar E-mail -->
                    <div class="">
                        <label for="name">Usuário E-mail:</label>
                        <div class="input-group mt-2">
                            <input name="email" value="<?= htmlspecialchars($usuario['email']) ?>" type="email" class="form-control" placeholder="E-mail" aria-label="email" aria-describedby="input-name" <?php
                                                                                                                                                                                                            if ($_SESSION['userStatus'] === "user") {
                                                                                                                                                                                                                echo "disabled";
                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                echo "";
                                                                                                                                                                                                            }
                                                                                                                                                                                                            ?>>
                        </div>
                    </div>

                    <!-- Editar Senha -->
                    <div>
                        <div class="row">

                            <!-- Senha atual -->
                            <div <?php
                                    if ($_SESSION['userStatus'] === "user") {
                                        echo "class='col'";
                                    } else {
                                        echo "class='d-none'";
                                    }
                                    ?>>
                                <label for="name">Senha Atual:</label>
                                <div class="input-group mt-2">
                                    <input name="senha_atual" value="" type="password" class="form-control" placeholder="Senha atual" aria-label="senha atual" aria-describedby="input-name">
                                </div>
                            </div>

                            <!-- Nova senha -->
                            <div class="col">
                                <label for="name">Nova Senha:</label>
                                <div class="input-group mt-2">
                                    <input name="nova_senha" value="" type="password" class="form-control" placeholder="Nova senha" aria-label="nova senha" aria-describedby="input-name">
                                </div>
                            </div>

                            <!-- Confirmar senha -->
                            <div class="col">
                                <label for="name">Confirmar:</label>
                                <div class="input-group mt-2">
                                    <input name="confirmar" value="" type="password" class="form-control" placeholder="Confirmar" aria-label="confirmar" aria-describedby="input-name">
                                </div>
                            </div>


                        </div>
                        <!-- Selecione Status -->
                        <div <?php
                                if ($_SESSION['auth'] === $id) {
                                    echo "class='d-none'";
                                } else {
                                    echo "class=''";
                                }
                                ?>>
                            <div <?php
                                    if ($_SESSION['userStatus'] === "admin") {
                                        echo "class='col mt-2'";
                                    } else {
                                        echo "class='d-none'";
                                    }
                                    ?>>
                                <label for="status">Selecione status:</label>
                                <div class="input-group mt-2">
                                    <select class="form-select text-capitalize" aria-label="Default select example" name="status">
                                        <option value="" selected>Status</option>
                                        <option class='text-capitalize' value='admin'>Admin</option>
                                        <option class='text-capitalize' value='user'>usuário</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-primary mt-4" id="editar-usuario" type="submit" onclick="">Editar Usuário</button>



                </div>

            </div>

        </div>
    </form>
</div>