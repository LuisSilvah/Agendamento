<?php


include_once("./src/config/verifica_usuario.php");
include_once('./src/config/Dbconfig.php');
include_once('./src/config/class_agenda.php');

$databaseAgenda = new DatabaseAgenda();

include_once("./src/components/header.php");
include_once("./src/components/sidebar.php");

$solName = $solEmail = $horaInicio = $horaFim = $salaReuniao = $obsCafe = $data = $id = "";

$usuarioId = $_SESSION['auth'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $solName = String_Input($_POST["sol_name"]);
    $solEmail = String_Input($_POST["sol_email"]);
    $horaInicio = String_Input($_POST["hora_inicio"]);
    $horaFim = String_Input($_POST["hora_fechamento"]);
    $salaReuniao = String_Input($_POST["sala"]);
    $obsCafe = String_Input($_POST["textarrea_cafe"]);
    $data = String_Input($_POST["data"]);

    $databaseAgenda->Inserir_Dados($solName, $solEmail, $horaInicio, $horaFim, $salaReuniao, $obsCafe, $data, $usuarioId);
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

<!-- View Reservar sala -->
<div class="content-wrapper w-100 bg-secundario">
    <section class="content">
        <div class="row">
            <!-- Header da pagina -->
            <div class="box box-primary">
                <div class="box-header with-border mt-4" align="center">
                    <h3 class="box-title"><b>Salas de Reunião</b></h3>
                </div>
                <div align="right">
                    <a href="./" class="btn btn-danger">Voltar</a>
                    <!-- <a href="http://localhost/dashboard" class="btn btn-danger">Sair</a> -->
                </div>

                <form action="" method="post">
                    <div class="container">
                        <div class="row gap-2 ">
                            <div class="col col-lg-7 p-2">

                                <!-- Solicitante Nome -->
                                <div class="">
                                    <label for="name">Solicitante Nome:</label>
                                    <label class="fw-bolder">
                                        <?php echo $solName; ?>
                                    </label>
                                    <div class="input-group mt-2">
                                        <!-- <span class="input-group-text" id="basic-addon1">@</span> -->
                                        <input name="sol_name" type="text" class="form-control" placeholder="Solicitante Nome" aria-label="nome" aria-describedby="input-name" required>
                                    </div>
                                </div>

                                <!-- Solicitante Email -->
                                <div class="mt-2">
                                    <label for="email">Solicitante Email:</label>
                                    <label class="fw-bolder">
                                        <?php echo $solEmail; ?>
                                    </label>
                                    <div class="input-group mt-2">
                                        <span class="input-group-text" id="icon-email">@</span>
                                        <input name="sol_email" type="email" class="form-control" placeholder="Solicitante Email" aria-label="email" aria-describedby="input-email" required>
                                    </div>
                                </div>


                                <!-- Colunas -->
                                <div class="container mt-2">
                                    <div class="row">

                                        <!-- Horario de Inicio -->
                                        <div class="col">
                                            <label for="inicio">Horário Inicio:</label>
                                            <div class="input-group mt-2">
                                                <input type="time" class="form-control" id="hora_inicio" name="hora_inicio" required>
                                            </div>
                                            <label class="fw-bolder">
                                                <?php echo $horaInicio; ?>
                                            </label>
                                        </div>

                                        <!-- Horario Fechamento -->
                                        <div class="col">
                                            <label for="fechamento">Horário Fechamento:</label>
                                            <div class="input-group mt-2">
                                                <input type="time" class="form-control" id="hora_fechamento" name="hora_fechamento" required>
                                            </div>
                                            <label class="fw-bolder">
                                                <?php echo $horaFim; ?>
                                            </label>
                                        </div>

                                        <!-- Selecione Sala -->
                                        <div class="col">
                                            <label for="sala">Selecione a sala:</label>
                                            <label class="fw-bolder">
                                                <?php echo $salaReuniao; ?>
                                            </label>
                                            <div class="input-group mt-2">
                                                <select class="form-select text-capitalize" aria-label="Default select example" name="sala">
                                                    <option value="" selected>Sala</option>
                                                    <?php

                                                    foreach ($option_sala as $value) {
                                                        echo "<option class='text-capitalize' value='$value'>$value</option>";
                                                    }

                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Solicitar Café  -->
                                <fieldset class="col mt-3">
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
                                            <label class="fw-bolder">
                                                <?php echo $obsCafe; ?>
                                            </label>
                                            <div class="input-group mt-2">
                                                <textarea name="textarrea_cafe" id="textarrea_cafe" class="form-control cols=" col="10" rows="2"></textarea>
                                            </div>
                                        </div>


                                    </div>
                                </fieldset>

                            </div>

                            <div class="col">

                                <!-- Data Selecionada no calendario abaixo -->
                                <div class="mt-3">
                                    <label for="day">Data Selecionada:</label>
                                    <label class="fw-bolder">
                                        <?php
                                        $dataFormat = date_format(date_create($data), "d/m/Y");

                                        echo $dataFormat;
                                        ?>
                                    </label>
                                    <div class="input-group mt-2">
                                        <button class="input-group-text" id="btn-day">Hoje</button>
                                        <input type="text" class="form-control" id="data-selecionada" placeholder="Data Selecionada">
                                        <input name="data" type="text" class="form-control d-none" id="banco-dados-data" placeholder="Data Selecionada">
                                    </div>
                                </div>

                                <!-- Calendário elemento -->
                                <div class="d-flex flex-column justify-content-center align-items-center">
                                    <div id="calendario" class=""></div>
                                </div>

                            </div>

                            <button class="btn btn-primary" id="reservar-sala" type="submit" onclick="Criar_Agendamento()">Resevar</button>

                        </div>
                </form>
            </div>
        </div>
    </section>
</div>

<?php
include_once("./src/components/footer.php");
?>