<?php

class DatabaseAgenda  extends Dbconfig
{
    public function Inserir_Dados($solName, $solEmail, $horaInicio, $horaFim, $salaReuniao, $obsCafe, $data, $id)
    {
        $mysql_conn = $this->connect();

        if ($solName && $solEmail && $horaInicio && $horaFim && $salaReuniao && $data) {

            $sqlVerifica = "SELECT * FROM agenda.salas WHERE data = '$data' AND sala = '$salaReuniao';";

            $sqlQueryVerifica = $mysql_conn->query($sqlVerifica);

            $resultado_veficacao = array();

            if ($horaFim > $horaInicio) {
                date_default_timezone_set('America/Sao_Paulo');
                $horaAtual = date('H:i');
                $data_de_hoje = date('Y-m-d');

                if ($data_de_hoje === $data) {
                    if ($horaInicio < $horaAtual) {
                        array_push($resultado_veficacao, "não criar");
                        echo "<script>
                    window.alert('Erro nos horarios do agendamento!');
                    window.location.href='./index.php?menu=agendamento';
                          </script>";
                    } else {
                        if (mysqli_num_rows($sqlQueryVerifica) > 0) {

                            foreach ($sqlQueryVerifica as $valor) {
                                $max = 5;
                                $valorInicioTamanho = strlen($valor['hora_ini']);
                                $valorFimTamanho = strlen($valor['hora_fim']);

                                $valorInicio = substr($valor['hora_ini'], 0, $max - $valorInicioTamanho);
                                $valorFim = substr($valor['hora_fim'], 0, $max - $valorFimTamanho);

                                if ($horaInicio > $valorFim && $horaFim > $valorFim) {
                                    array_push($resultado_veficacao, "criar");
                                } else if ($horaInicio < $valorInicio && $horaFim < $valorInicio) {
                                    array_push($resultado_veficacao, "criar");
                                } else if ($horaInicio < $valorInicio && $horaFim > $valorInicio) {
                                    array_push($resultado_veficacao, "não criar");
                                } else {
                                    array_push($resultado_veficacao, "não criar");
                                }
                            }
                        } else {
                            array_push($resultado_veficacao, "criar");
                        }
                    }
                } else {

                    if (mysqli_num_rows($sqlQueryVerifica) > 0) {

                        foreach ($sqlQueryVerifica as $valor) {
                            $max = 5;
                            $valorInicioTamanho = strlen($valor['hora_ini']);
                            $valorFimTamanho = strlen($valor['hora_fim']);

                            $valorInicio = substr($valor['hora_ini'], 0, $max - $valorInicioTamanho);
                            $valorFim = substr($valor['hora_fim'], 0, $max - $valorFimTamanho);

                            if ($horaInicio > $valorFim && $horaFim > $valorFim) {
                                array_push($resultado_veficacao, "criar");
                            } else if ($horaInicio < $valorInicio && $horaFim < $valorInicio) {
                                array_push($resultado_veficacao, "criar");
                            } else if ($horaInicio < $valorInicio && $horaFim > $valorInicio) {
                                array_push($resultado_veficacao, "não criar");
                            } else {
                                array_push($resultado_veficacao, "não criar");
                            }
                        }
                    } else {
                        array_push($resultado_veficacao, "criar");
                    }
                }
            } else {
                array_push($resultado_veficacao, "não criar");
                echo "<script>
            window.alert('Erro ao criar agendamento!');
            window.location.href='./index.php?menu=agendamento';
                  </script>";
            }

            if (in_array("não criar", $resultado_veficacao)) {
                echo "<script>
                    window.alert('Já existe um agendamento!');
                          </script>";
            } else {
                $obsCafe = $obsCafe ? $obsCafe : "";

                $sql =  "INSERT INTO
                   agenda.salas (sol_name, sol_email, hora_ini, hora_fim, sala, obs_cafe, data, usuarioId)
                      VALUES 
                      ('$solName', '$solEmail','$horaInicio', '$horaFim', '$salaReuniao', '$obsCafe', '$data', '$id')";

                if ($mysql_conn->query($sql) === TRUE) {
                    $resultado_veficacao = "";
                    echo "<script>
                     window.alert('Agendamento criado com Sucesso!');
                     window.location.href='./index.php?menu=agendamento';
                           </script>";
                } else {
                    echo "<script>
                    window.alert('Erro ao criar agendamento!');
                    window.location.href='./index.php?menu=agendamento';
                          </script>";
                }
            }
        } else {
            echo "<script>
                window.alert('Erro ao criar agendamento!');
                window.location.href='./index.php?menu=agendamento';
                      </script>";
        }
    }

    public function Lendo_Dados_Agenda()
    {
        $mysql_conn = $this->connect();

        $sql = "SELECT id, sol_name, sol_email, hora_ini, hora_fim, sala, obs_cafe, data, usuarioId  FROM salas ORDER BY data DESC";

        $agenda = $mysql_conn->query($sql);

        mysqli_close($mysql_conn);


        // echo "<pre>";
        // var_dump($agenda);
        // echo "</pre>";

        return $agenda;
    }

    public function Procura_Dados_Agenda($id)
    {
        $mysql_conn = $this->connect();

        // $id = $mysql_conn->escape_string($id);

        $sqlFindAgenda = "SELECT salas.*, users.name, users.email FROM salas INNER JOIN users
        ON agenda.salas.usuarioId = agenda.users.id WHERE salas.id = ?";

        $sql = "SELECT salas.*, users.name, users.email FROM salas INNER JOIN users
ON agenda.salas.usuarioId = agenda.users.id WHERE salas.id = '$id'";

        $findAgenda = $mysql_conn->query($sql);

        // $stmt = $mysql_conn->stmt_init();

        // if (!$stmt->prepare($sql))
        //     exit('SQL error');

        // $stmt->bind_param('i', $id);
        // $stmt->execute();

        // $findAgenda = mysqli_fetch_assoc($stmt->get_result());

        if (mysqli_num_rows($findAgenda) > 0) {
            return $findAgenda;
        } else {

            $sql = "SELECT id, sol_name, sol_email, hora_ini, hora_fim, sala, obs_cafe, data FROM salas WHERE id= '$id'";

            $agenda = $mysql_conn->query($sql);

            return $agenda;
        }

        mysqli_close($mysql_conn);
    }
    

    public function Procura_Agenda_Data($data)
    {

        $mysql_conn = $this->connect();


        $sql = "SELECT * FROM salas WHERE data = '$data'";

        $findAgenda = $mysql_conn->query($sql);


        if (mysqli_num_rows($findAgenda) > 0) {
            return $findAgenda;
        }
        mysqli_close($mysql_conn);
    }

    public function Procura_Agenda_Id($user)
    {

        $mysql_conn = $this->connect();


        $sql = "SELECT * FROM salas WHERE usuarioId = '$user' ORDER BY data DESC";

        $findAgenda = $mysql_conn->query($sql);


        if (mysqli_num_rows($findAgenda) > 0) {
            return $findAgenda;
        }
        mysqli_close($mysql_conn);
    }

    public function Filtros_Agenda($solicitante, $sala)
    {
        $mysql_conn = $this->connect();

        if ($sala) {
            $sql = "SELECT * FROM salas WHERE sol_name LIKE '%$solicitante%' AND sala = '$sala'";
        } else {
            $sql = "SELECT * FROM salas WHERE sol_name LIKE '%$solicitante%'";
        }


        $findAgenda = $mysql_conn->query($sql);

        if (mysqli_num_rows($findAgenda) > 0) {
            return $findAgenda;
        }

        mysqli_close($mysql_conn);
    }

    public function EditarDados($id, $solName, $solEmail, $horaInicio, $horaFim, $salaReuniao, $obsCafe, $data, $dataSelecionadaDB)
    {

        $mysql_conn = $this->connect();

        $updateData = $data ? $data : $dataSelecionadaDB;

        $sql = "UPDATE salas SET 
        sol_name='" . $solName . "', sol_email='" . $solEmail . "', hora_ini='" . $horaInicio . "', 
        hora_fim='" . $horaFim . "', sala='" . $salaReuniao . "', obs_cafe='" . $obsCafe . "' , data='" . $updateData . "'
        WHERE id=$id";

        $sqlVerifica = "SELECT * FROM agenda.salas WHERE data = '$updateData' AND sala = '$salaReuniao' AND NOT id = '$id';";
        $sqlQueryVerifica = $mysql_conn->query($sqlVerifica);

        $resultado_veficacao = array();

        if ($horaFim > $horaInicio) {
            if (mysqli_num_rows($sqlQueryVerifica) > 0) {
                foreach ($sqlQueryVerifica as $valor) {
                    $max = 5;
                    $valorInicioTamanho = strlen($valor['hora_ini']);
                    $valorFimTamanho = strlen($valor['hora_fim']);

                    $valorInicio = substr($valor['hora_ini'], 0, $max - $valorInicioTamanho);
                    $valorFim = substr($valor['hora_fim'], 0, $max - $valorFimTamanho);

                    if ($horaInicio > $valorFim && $horaFim > $valorFim) {
                        array_push($resultado_veficacao, "editar");
                    } else if ($horaInicio < $valorInicio && $horaFim < $valorInicio) {
                        array_push($resultado_veficacao, "editar");
                    } else if ($horaInicio < $valorInicio && $horaFim > $valorInicio) {
                        array_push($resultado_veficacao, "não editar");
                    } else {
                        array_push($resultado_veficacao, "não editar");
                    }
                }
            } else {
                array_push($resultado_veficacao, "editar");
            }
        } else {
            array_push($resultado_veficacao, "não editar");
            echo "<script>
        window.alert('Erro nos horarios do agendamento!');
        window.location.href='./';
              </script>";
        }

        if (in_array("não editar", $resultado_veficacao)) {
            echo "<script>
                window.alert('Já existe um agendamento!');
                window.location.href='./index.php?menu=agendamento';
                      </script>";
        } else {

            if ($mysql_conn->query($sql) === TRUE) {
                echo "<script>
                 window.alert('Agendamento editado com Sucesso!');
                 window.location.href='./';
                       </script>";
            } else {
                echo "<script>
                window.alert('Erro ao editar agendamento!');
                window.location.href='./';
                      </script>";
            }
        }

        $mysql_conn->close();
    }

    public function Deletar_Dados($id)
    {

        $mysql_conn = $this->connect();

        if ($id) {

            $sql = "DELETE FROM agenda.salas WHERE id=$id";

            if ($mysql_conn->query($sql) === TRUE) {
                echo "<script>
          window.alert('Agendamento removido com Sucesso!');
          window.location.href='./';
                </script>";
            } else {
                echo "<script>alert('Erro ao remover agendamento!')</script>";
            }
        }

        $mysql_conn->close();
    }
};
