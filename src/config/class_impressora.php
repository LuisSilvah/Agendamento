<?php

class DatabaseImpressora extends Dbconfig
{

    public function Lendo_Dados_Toner()
    {
        $mysql_conn = $this->connect();

        $sql = "SELECT id, quantidade, modelo, serie FROM agenda.toner WHERE status != 'usado' ORDER BY quantidade DESC";

        $toner = $mysql_conn->query($sql);

        mysqli_close($mysql_conn);

        return $toner;
    }

    public function Lendo_Dados_Toner_Usados()
    {
        $mysql_conn = $this->connect();

        $sql = "SELECT id, quantidade, modelo, serie, status FROM agenda.toner WHERE status = 'usado' ORDER BY quantidade DESC";

        $tonerUsados = $mysql_conn->query($sql);

        mysqli_close($mysql_conn);

        return $tonerUsados;
    }

    public function Lendo_Dados_Impressora()
    {
        $mysql_conn = $this->connect();

        $sql = "SELECT id, modelo, ip, setor, serie, status status FROM agenda.impressora ORDER BY ip ASC";

        $impressora = $mysql_conn->query($sql);

        mysqli_close($mysql_conn);

        return $impressora;
    }

    public function Criar_Impressora($modelo, $ip, $serie, $setor, $status)
    {

        $mysql_conn = $this->connect();

        if ($modelo && $ip && $serie && $setor !== "" && $status !== "") {
            $sql = "INSERT INTO agenda.impressora (modelo, ip, serie, setor, status)
             VALUES 
             ('$modelo', '$ip', '$serie', '$setor', '$status')";

            $resultado = $mysql_conn->query($sql);

            if ($resultado === TRUE) {
                echo "<script>
                window.alert('Impressora criada com Sucesso!');
                window.location.href='./index.php?menu=impressora';
                      </script>";
            } else {
                echo "<script>
                window.alert('Erro ao criar Impressora!');
                window.location.href='./index.php?menu=criarImpressora';
                      </script>";
            }
        } else {
            echo "<script>
            window.alert('Erro ao criar Impressora!');
            window.location.href='./index.php?menu=criarImpressora';
                  </script>";
        }
    }
}
