<?php


include_once('./src/config/Dbconfig.php');
include_once('./src/config/class_agenda.php');
include_once('./src/config/class_login.php');

$databaseAgenda = new DatabaseAgenda();
$databaseLogin = new DatabaseLogin();

if (isset($_SESSION['auth'])) {
    $userId = $_SESSION['auth'];

    $databaseLogin->Procura_usuario_validado($userId);
}

$agenda = $databaseAgenda->Lendo_Dados_Agenda();

$option_sala = array("selmi", "renata", "galo", "vinho");
$option_setor = array(
    array("item" => "TI", "value" => "TI"),
    array("item" => "ADM Vendas", "value" => "ADM"),
    array("item" => "RH", "value" => "RH"),
    array("item" => "SAC", "value" => "SAC"),
    array("item" => "Logistica", "value" => "log"),
);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" sizes="180x180" href="https://145.0.2.251/agenda/assests/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="https://145.0.2.251/agenda/assests/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="https://145.0.2.251/agenda/assests/favicon-16x16.png">
    <link rel="manifest" href="https://145.0.2.251/agenda/assests/site.webmanifest">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- jsCalendar v1.4.3 Javascript and CSS from jsdelivr npm cdn -->
<script src="https://cdn.jsdelivr.net/npm/simple-jscalendar@1.4.3/source/jsCalendar.min.js" integrity="sha384-JqNLUzAxpw7zEu6rKS/TNPZ5ayCWPUY601zaig7cUEVfL+pBoLcDiIEkWHjl07Ot" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-jscalendar@1.4.3/source/jsCalendar.min.css" integrity="sha384-+OB2CadpqXIt7AheMhNaVI99xKH8j8b+bHC8P5m2tkpFopGBklD3IRvYjPekeWIJ" crossorigin="anonymous">

    <title>Agenda</title>
</head>

<style>
    body {
        overflow: hidden;
    }

    .bg-principal {
        background-color: #F6F6F6;
        height: 100vh;
        padding: 0 20px;
        overflow: auto;
    }

    .bg-secundario {
        background-color: #FFFFFF;
        height: 100vh;
        padding: 0 20px;
        overflow: auto;
    }
</style>

<script>
    $(document).ready(function() {

        $('#option_cafe_nao').click(function(e) {
            e.preventDefault();
            $('#div_cafe').addClass('d-none');
            $('#coffe_sim').attr('checked', false)
            $('#coffe_nao').attr('checked', true)
        });

        $('#option_cafe_sim').click(function(e) {
            e.preventDefault();
            $('#div_cafe').removeClass('d-none');
            $('#coffe_nao').attr('checked', false)
            $('#coffe_sim').attr('checked', true)
        });

        var textarreaCafe = document.getElementById("input_cafe")

        // var textarreaCafe = $('textarrea_cafe').val()

        if (textarreaCafe.value === "") {
            $('#div_cafe').addClass('d-none');
            $('#coffe_sim').attr('checked', false)
            $('#coffe_nao').attr('checked', true)
        } else {
            $('#div_cafe').removeClass('d-none');
            $('#coffe_nao').attr('checked', false)
            $('#coffe_sim').attr('checked', true)
        }

    });
</script>

<body>