<?php

include_once("./src/components/header.php");
include_once("./src/config/Dbconfig.php");
include_once("./src/config/verifica_usuario.php");
include_once("./src/config/class_impressora.php");
include_once("./src/components/sidebar.php");

$modelo = $ip = $serie = $setor = $status = "";

$databaseImpressora = new DatabaseImpressora();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $modelo = String_Input($_POST["modelo"]);
    $ip = String_Input($_POST["ip"]);
    $serie = String_Input($_POST["serie"]);
    $setor = String_Input($_POST["setor"]);
    $status = String_Input($_POST["status"]);

    $databaseImpressora->Criar_Impressora($modelo, $ip, $serie, $setor, $status);
    $impressora = $databaseImpressora->Lendo_Dados_Impressora();
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
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border mt-4" align="center">
                        <h3 class="box-title"><b>Impressoras</b></h3>
                    </div>

                    <div align="right">

                        <a href='<?php echo "./index.php?menu=impressora" ?>' class="btn btn-danger">voltar</a>
                    </div>


                    <form action="" method="post">
                        <div class="container">
                            <div class="row gap-2 ">
                                <div class="col p-2">


                                    <div class="container">
                                        <div class="row">
                                            <!-- Modelo Impressora -->
                                            <div class="col">
                                                <label for="modelo">Modelo Impressora:</label>
                                                <div class="input-group mt-2">
                                                    <input name="modelo" type="text" class="form-control" placeholder="Modelo Impressora" aria-label="modelo" aria-describedby="input-modelo" required>
                                                </div>
                                            </div>

                                            <!-- IP da Impressora -->
                                            <div class="col">
                                                <label for="ip">IP Impressora:</label>
                                                <div class="input-group mt-2">
                                                    <input name="ip" type="text" class="form-control" placeholder="IP Impressora" aria-label="ip" aria-describedby="input-ip" required>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row mt-2">
                                            <!-- Setor Impressora -->
                                            <div class="col">
                                                <label for="setor">Selecione o setor:</label>
                                                <div class="input-group mt-2">
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
                                                </div>
                                            </div>

                                            <!-- Número de serie -->
                                            <div class="col">
                                                <label for="serie">Número de Serie:</label>
                                                <div class="input-group mt-2">
                                                    <input name="serie" type="text" class="form-control" placeholder="Número de serie" aria-label="serie" aria-describedby="input-serie" required>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row mt-2">
                                            <!-- Status Impressora -->
                                            <div class="col">
                                                <label for="status">Selecione o status da impressora:</label>
                                                <div class="input-group mt-2">
                                                    <select class="form-select text-capitalize" aria-label="Default select example" name="sala">
                                                        <option value="" selected>status</option>
                                                        <option class='text-capitalize' value='ativado'>Ativada</option>
                                                        <option class='text-capitalize' value='desativada'>Desativada</option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>

                                <button class="btn btn-primary" id="impressora" type="submit" onclick="Criar_Impressora()">Criar Impressora</button>

                            </div>

                        </div>
                    </form>


                </div>