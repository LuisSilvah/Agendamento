<?php

include("./src/config/verifica_usuario.php");
include_once("./src/components/header.php");
include_once("./src/components/sidebar.php");

$URL_ATUAL = "http://$_SERVER[HTTP_HOST]";

$id = $_GET['id'];

$usuario = $databaseLogin->Procura_Dados_Usuario($id);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $databaseLogin->Deletar_Usuario($id);
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
                        <h3 class="box-title"><b>Excluir Usuário</b></h3>
                    </div>
                    <div align="right">
                        <a href="./" class="btn btn-danger">Voltar</a>
                    </div>
                </div>

                <form class="form" action="" method="POST">
                    <div class="table table-responsive">
                        <table class='table table-striped' id="usuario">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Login</th>
                                    <th>Área admin</th>
                                    <th>E-mail</th>
                                </tr>
                            </thead>

                            <tbody id="xxxxxxxx">
                                <tr>
                                    <td><?= $usuario['name'] ?></td>
                                    <td><?= $usuario['username'] ?></td>
                                    <td><?= $usuario['status'] ?></td>
                                    <td><?= $usuario['email'] ?></td>
                                    <td>
                                        <button class="btn btn-danger text-white" onclick="">Excluir</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>

            </div>
    </section>
</div>