<?php


include_once("./src/config/verifica_usuario.php");

include_once("./src/components/header.php");
include_once("./src/components/sidebar.php");
$databaseAgenda = new DatabaseAgenda();

$agenda = $databaseAgenda->Procura_Dados_Agenda($_GET['id']);



$id = $solName = $solEmail = $horaInicio = $horaFim = $salaReuniao = $obsCafe = $data = $id = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_GET['id'];
    $solName = String_Input($_POST["sol_name"]);
    $solEmail = String_Input($_POST["sol_email"]);
    $horaInicio = String_Input($_POST["hora_inicio"]);
    $horaFim = String_Input($_POST["hora_fechamento"]);
    $salaReuniao = String_Input($_POST["sala"]);
    $obsCafe = String_Input($_POST["textarrea_cafe"]);
    $data = String_Input($_POST["data"]);
    $dataSelecionadaDB = String_Input($_POST["data"]);;

    $databaseAgenda->EditarDados($id, $solName, $solEmail, $horaInicio, $horaFim, $salaReuniao, $obsCafe, $data, $dataSelecionadaDB);
    $agenda = $databaseAgenda->Lendo_Dados_Agenda();
}

function String_Input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>
<div class="content-wrapper w-100 bg-secundario" id="viewAgenda">
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <!-- Header da pagina -->
                    <div class="box-header with-border mt-4" align="center">
                        <h3 class="box-title"><b>Editar Reserva</b></h3>
                    </div>
                    <div align="right">
                        <a href="./" class="btn btn-danger">Voltar</a>
                    </div>

                    <form action="" method="post">
                        <div class="container">
                            <div class="row gap-2 ">

                                <?php foreach ($agenda as $row) : ?>

                                    <div class="col col-lg-7 p-2">

                                        <!-- Editar Solicitante Nome -->
                                        <div class="">
                                            <label for="name">Solicitante Nome:</label>
                                            <div class="input-group mt-2">
                                                <input name="sol_name" value="<?= htmlspecialchars($row['sol_name']) ?>" type="text" class="form-control" placeholder="Solicitante Nome" aria-label="nome" aria-describedby="input-name">
                                            </div>
                                        </div>

                                        <!-- Editar Solicitante Email -->
                                        <div class="mt-2">
                                            <label for="email">Solicitante Email:</label>
                                            <div class="input-group mt-2">
                                                <span class="input-group-text" id="icon-email">@</span>
                                                <input name="sol_email" value="<?= htmlspecialchars($row['sol_email']) ?>" type="text" class="form-control" placeholder="Solicitante Email" aria-label="email" aria-describedby="input-email">
                                            </div>
                                        </div>


                                        <!-- Colunas -->
                                        <div class="container mt-2">
                                            <div class="row">

                                                <!-- Editar Horario de Inicio -->
                                                <div class="col">
                                                    <label for="inicio">Horário Inicio:</label>
                                                    <div class="input-group mt-2">
                                                        <input value="<?= htmlspecialchars($row['hora_ini']) ?>" type="time" class="form-control" id="hora_inicio" name="hora_inicio">
                                                    </div>
                                                </div>

                                                <!-- Editar Horario Fechamento -->
                                                <div class="col">
                                                    <label for="fechamento">Horário Fechamento:</label>
                                                    <div class="input-group mt-2">
                                                        <input value="<?= htmlspecialchars($row['hora_fim']) ?>" type="time" class="form-control" id="hora_fechamento" name="hora_fechamento">
                                                    </div>
                                                </div>

                                                <!-- Editar Sala Selecionada -->
                                                <div class="col">
                                                    <label for="sala">Selecione a sala:</label>
                                                    <div class="input-group mt-2">
                                                        <select class="form-select" aria-label="Default select example" name="sala">
                                                            <option selected><?= $row['sala']; ?> </option>
                                                            <?php

                                                            foreach ($option_sala as $value) {
                                                                if ($row['sala'] !== $value) {
                                                                    echo "<option class='text-capitalize' value='$value'>$value</option>";
                                                                }
                                                            }

                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Editar  observação Café  -->
                                        <fieldset class="col mt-3">
                                            <input class="d-none" type="text" id="input_cafe" value="<?= htmlspecialchars($row['obs_cafe']) ?>">
                                            <legend class="col-form-label pt-0">Deseja solicitar café?</legend>
                                            <div class="col-sm-10">
                                                <div class="d-flex gap-4">
                                                    <div class="form-check" id="option_cafe_sim" for="coffe_sim">
                                                        <input class="form-check-input" type="radio" name="Option Coffe" id="coffe_sim" value="coffe_sim" checked>
                                                        <label class="form-check-label" for="coffe_sim">
                                                            Sim
                                                        </label>
                                                    </div>

                                                    <div class="form-check" id="option_cafe_nao" for="coffe_nao">
                                                        <input class="form-check-input" type="radio" name="Option Coffe" id="coffe_nao" value="coffe_nao">
                                                        <label class="form-check-label" for="coffe_nao">
                                                            Não
                                                        </label>
                                                    </div>
                                                </div>

                                                <!-- Adicionar Observações Sobre o café -->
                                                <div class="col" id="div_cafe">
                                                    <label for="cafe">Observações sobre o café:</label>
                                                    <div class="input-group mt-2">
                                                        <textarea name="textarrea_cafe" id="textarrea_cafe" class="form-control cols=" col="10" rows="2"> <?= $row['obs_cafe'] ?></textarea>
                                                    </div>
                                                </div>


                                            </div>
                                        </fieldset>

                                    </div>

                                    <div class="col">

                                        <!-- Data Selecionada no calendario abaixo -->
                                        <div class="mt-3">
                                            <label for="day">Data Selecionada:</label>
                                            <div class="input-group mt-2">
                                                <button class="input-group-text" id="btn-day">Hoje</button>
                                                <input value="<?= htmlspecialchars(date_format(date_create($row['data']), "d/m/Y")); ?>" type="text" class="form-control" id="data-selecionada" placeholder="Data Selecionada">
                                                <input name="data" value="<?= htmlspecialchars(date_format(date_create($row['data']), "Y-m-d")); ?>" type="text" class="form-control d-none" id="banco-dados-data" placeholder="Data Selecionada">
                                           
                                            </div>
                                        </div>

                                        <!-- Calendário elemento -->
                                        <div class="d-flex flex-column justify-content-center align-items-center">
                                            <div id="calendario" class=""></div>
                                        </div>

                                    </div>

                                <?php endforeach ?>
                                <button class="btn btn-primary" id="salvar-sala" type="submit">Salvar</button>
                            </div>
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