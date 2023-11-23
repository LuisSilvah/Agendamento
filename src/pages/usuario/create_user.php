<?php

include("./src/config/verifica_usuario.php");
include_once("./src/components/header.php");
include_once("./src/components/sidebar.php");

$URL_ATUAL = "http://$_SERVER[HTTP_HOST]";

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
                        <a href='index.php?menu=usuario' class="btn btn-danger">Voltar</a>
                    </div>

                    <form action="./registration.php" method="post">

                        <!-- Nome do Usuario -->
                        <div class="">
                            <label for="name">Nome do usuário:</label>
                            <div class="input-group mt-2">
                                <input type="text" name="name" class="form-control">
                            </div>
                        </div>

                        <!-- Usuário login -->
                        <div class="">
                            <label for="name">Usuário login:</label>
                            <div class="input-group mt-2">
                                <input type="text" name="username" class="form-control">
                            </div>
                        </div>


                        <!-- Email Usuário -->
                        <div class="">
                            <label for="name">Usuário E-mail:</label>
                            <div class="input-group mt-2">
                                <input type="email" name="email" class="form-control">
                            </div>
                        </div>

                        <!-- Selecione Status -->
                        <div class="col">
                            <label for="sala">Selecione status:</label>
                            <div class="input-group mt-2">
                                <select class="form-select text-capitalize" aria-label="Default select example" name="status">
                                    <option value="" selected>Status</option>
                                    <option class='text-capitalize' value='admin'>Admin</option>
                                    <option class='text-capitalize' value='user'>usuário</option>
                                </select>
                            </div>
                        </div>

                        <!-- Senha do usuário -->
                        <div class="">
                            <label for="name">Senha de login:</label>
                            <div class="input-group mt-2">
                                <input type="Password" name="password" class="form-control">
                            </div>
                        </div>

                        <!-- Botão criar usuário -->
                        <div class="">
                            <div class="input-group mt-2">
                                <button type="submit" class="btn btn-primary">Criar Usuário</button>
                            </div>
                        </div>

                    </form>

                    <span class='nav-link text-black fs-4'>
                        <?php
                        if (isset($_SESSION['mensage'])) {
                            echo $_SESSION['mensage'];
                        }
                        ?>
                    </span>
                </div>
            </div>
        </div>
    </section>

</div>