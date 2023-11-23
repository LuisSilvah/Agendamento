<?php

include_once("./src/config/verifica_usuario.php");

include_once('./src/components/header.php');
include_once("./src/components/sidebar.php");


$id = $_GET['id'];

$agenda = $databaseAgenda->Procura_Dados_Agenda($_GET['id']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $databaseAgenda->Deletar_Dados($id);
}
?>

<div class="content-wrapper bg-principal w-100" id="viewAgenda">
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border mt-4" align="center">
                        <h3 class="box-title"><b>Excluir Agendamento</b></h3>
                    </div>
                    <div align="right">
                        <a href="./" class="btn btn-danger">Voltar</a>
                    </div>
                    <form class="form" action="" method="POST">
                        <div class="table table-responsive">
                            <table class='table table-striped' id="agenda">
                                <thead>
                                    <tr>
                                        <th>Solicitante</th>
                                        <th>Hora Inicial</th>
                                        <th>Hora Fechamento</th>
                                        <th>Sala</th>
                                        <th>Data</th>
                                        <th>Observação</th>
                                    </tr>
                                </thead>

                                <tbody id="xxxxxxxx">
                                    <?php foreach ($agenda as $item) : ?>
                                        <tr>
                                            <td class="p-3">
                                                <div class='col'>
                                                    <div class='row text-capitalize'><?= $item['sol_name'] ?></div>
                                                    <div class='row'><?= $item['sol_email'] ?></div>
                                                </div>
                                            </td>

                                            <td><?= $item['hora_ini'] ?></td>
                                            <td><?= $item['hora_fim'] ?></td>
                                            <td class="text-capitalize"><?= $item['sala'] ?></td>
                                            <td>
                                                <?= htmlspecialchars(date_format(date_create($item['data']), "d/m/Y")); ?>
                                            </td>
                                            <td class="text-capitalize"><?= $item['obs_cafe'] ?></td>
                                            <td></td>
                                            <td>
                                                <button class="btn btn-danger text-white" onclick="">Excluir</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-3">
                                                <div class='col'>
                                                    <div class='row'>
                                                        <?php if (array_key_exists('name', $item)) {
                                                            echo "Agendamento criado por:";
                                                        } else {
                                                            echo "Usuário que criou foi deletado!";
                                                        } ?>
                                                    </div>
                                                    <div class='row'>
                                                        <?php if (array_key_exists('name', $item)) {
                                                            echo $item['name'];
                                                        } else {
                                                            echo "";
                                                        } ?>
                                                    </div>
                                                </div>
                                                <div class='row'>
                                                    <?php if (array_key_exists('email', $item)) {
                                                        echo $item['email'];
                                                    } else {
                                                        echo "";
                                                    } ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<?php
include_once("./src/components/footer.php");
?>