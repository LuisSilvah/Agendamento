<?php
class Dbconfig
{
    private $user;
    private $host;
    private $pass;
    private $db;

    public function __construct()
    {
        $this->user = "root";
        $this->host = "localhost";
        $this->pass = "";
        $this->db = "agenda";
    }

    public function connect()
    {
        $mysql_conn = mysqli_connect($this->host, $this->user, $this->pass, $this->db);

        if ($mysql_conn->connect_error) {
            die("Connection failed: " . $mysql_conn->connect_error);
        }
        return $mysql_conn;
    }
}
