<?php

class DatabaseLogin extends Dbconfig
{

    public function Valida_usuario($username, $password)
    {

        $mysql_conn = $this->connect();

        $sql = "SELECT * FROM agenda.users where username='$username'";

        $query = mysqli_query($mysql_conn, $sql);

        if (mysqli_num_rows($query) > 0) {

            foreach ($query as $valor) {
                if (password_verify($password, $valor['password'])) {
                    $_SESSION['username'] = $username;
                    $_SESSION['mensage'] = "";
                    header('Location: https://145.0.2.251/agenda/');
                } else {
                    $_SESSION['mensage'] = "Usuário login incorreto";
                    header('Location: https://145.0.2.251/agenda/login.php');
                }
            }
        } else {
            $_SESSION['mensage'] = "Não existe nenhum usuário";
            header('Location: login.php');
        }
    }

    public function Procura_usuario_validado($id)
    {

        $mysql_conn = $this->connect();

        $sql = "SELECT * FROM agenda.users WHERE id='$id'";

        $query = $mysql_conn->query($sql);

        if (mysqli_num_rows($query) > 0) {
            foreach ($query as $valor) {
                $_SESSION['userStatus'] = $valor['status'];
                $_SESSION['username'] = $valor['name'];
                $_SESSION['setor'] = $valor['setor'];
                // echo "<pre>";
                // print_r($valor);
                // echo "</pre>";
            }
        }
    }

    public function Lendo_Usuarios()
    {

        $mysql_conn = $this->connect();

        $sql = "SELECT * FROM agenda.users ";

        $query = $mysql_conn->query($sql);

        if (mysqli_num_rows($query) > 0) {
            return $query;
        }

        $mysql_conn->close();
    }

    public function Lendo_Usuarios_ID($id)
    {
        $mysql_conn = $this->connect();

        $sql = "SELECT * FROM agenda.users  WHERE users.id = '$id'";

        $query = $mysql_conn->query($sql);

        if (mysqli_num_rows($query) > 0) {
            return $query;
        }

        $mysql_conn->close();
    }

    public function Procura_Dados_Usuario($id)
    {
        $mysql_conn = $this->connect();

        $id = $mysql_conn->escape_string($id);

        $sql = "SELECT * FROM users WHERE users.id = ?";

        $stmt = $mysql_conn->stmt_init();

        if (!$stmt->prepare($sql))
            exit('SQL error');

        $stmt->bind_param('i', $id);
        $stmt->execute();

        $findUsuario = mysqli_fetch_assoc($stmt->get_result());

        mysqli_close($mysql_conn);
        return $findUsuario;
    }

    public function Filtros_Usuarios($name)
    {

        $mysql_conn = $this->connect();

        $sql = "SELECT * FROM agenda.users WHERE name LIKE '%$name%'";

        $query = $mysql_conn->query($sql);

        if (mysqli_num_rows($query) > 0) {
            return $query;
        }

        $mysql_conn->close();
    }

    public function Editar_Usuario($name, $email, $password, $newPassword, $confirmPassword, $userStatus, $status, $id)
    {
        $mysql_conn = $this->connect();

        if ($name !== "" || $email !== "") {
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
        }


        if ($userStatus === "admin") {

            if ($newPassword && $confirmPassword && $newPassword === $confirmPassword) {

                $_SESSION['name'] = $name;
                $_SESSION['email'] = $email;

                $hash_Password = password_hash($confirmPassword, PASSWORD_DEFAULT);

                if ($status === "") {
                    $sql = "UPDATE users SET 
                name = '$name', email = '$email', password = '$hash_Password'
                    WHERE id = '$id'
                ";
                } else {

                    $sql = "UPDATE users SET 
                    name = '$name', email = '$email', password = '$hash_Password', status = '$status'
                        WHERE id = '$id'
                    ";
                }

                $mysql_conn->query($sql);

                echo "<script>
          window.alert('Usuario editado com sucesso!');
          window.location.href='./index.php?menu=usuario'
      </script>";
            } else {

                $_SESSION['name'] = $name;
                $_SESSION['email'] = $email;

                if ($status === "") {
                    $sql = "UPDATE users SET 
                name = '$name', email = '$email'
                    WHERE id = '$id'
                ";
                } else {

                    $sql = "UPDATE users SET 
                name = '$name', email = '$email', status = '$status'
                    WHERE id = '$id'
                ";
                }

                $mysql_conn->query($sql);



                echo "<script>
          window.alert('Usuario editado com sucesso!');
          window.location.href='./index.php?menu=usuario'
      </script>";
            }
        } else {
            $mysql_conn = $this->connect();

            $id = $mysql_conn->escape_string($id);
            $sqlVerifica = "SELECT users.password FROM users WHERE users.id = ?";
            $stmt = $mysql_conn->stmt_init();
            if (!$stmt->prepare($sqlVerifica))
                exit('SQL error');

            $stmt->bind_param('i', $id);
            $stmt->execute();

            $findPasswordUsuario = mysqli_fetch_assoc($stmt->get_result());

            if ($newPassword && $confirmPassword && $newPassword === $confirmPassword) {
                if ($password) {
                    if (password_verify($password, $findPasswordUsuario['password'])) {
                        $_SESSION['newPassword'] = $newPassword;

                        $hash_Password = password_hash($confirmPassword, PASSWORD_DEFAULT);
                        $sql_updatePass = "UPDATE users SET 
                password = '$hash_Password', status = '$userStatus'
                    WHERE id = '$id'
                ";

                        $mysql_conn->query($sql_updatePass);

                        echo "<script>
                            window.alert('As senhas foram alteradas com sucesso!');
                            window.location.href='./index.php?menu=usuario'
                        </script>";
                    } else {
                        $_SESSION['newPassword'] = $newPassword;
                        $_SESSION['confirmPassword'] = $confirmPassword;
                        echo "<script>
                            window.alert('As senhas digitadas não conferem!');
                        </script>";
                    }
                }
            } else {
                $_SESSION['newPassword'] = $newPassword;
                $_SESSION['confirmPassword'] = $confirmPassword;
                echo "<script>
                    window.alert('As senhas digitadas não conferem!');
                </script>";
            }
        }
    }

    public function Deletar_Usuario($id)
    {
        $mysql_conn = $this->connect();

        if ($id) {

            $sql = "DELETE FROM agenda.users WHERE id=$id";

            if ($mysql_conn->query($sql) === TRUE) {
                echo "<script>
          window.alert('Usuario deletado com Sucesso!');
          window.location.href='./';
                </script>";
            } else {
                echo "<script>alert('Erro ao deletar usuario!')</script>";
            }
        }

        $mysql_conn->close();
    }
}
