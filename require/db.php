<?php
class Mysql {
    private $conn;

    function __construct() {
        $this->conn = $this->getConn();
    }

    function getConn() {
        $conn = mysqli_connect('localhost', 'root', 'root') or die("Cannot connect to server" . mysqli_connect_error());
        mysqli_select_db($conn, "foodorder_db") or die("Cannot use this Database");
        mysqli_query($conn, "set names gbk");
        return $conn;
    }

    function fetch($result) {
        $row = mysqli_fetch_array($result);
        return $row;
    }

    function query($sql) {
        $res = mysqli_query($this->conn, $sql) or die(mysqli_error($this->conn));
        return $res;
    }
}

$mysql = new Mysql();
?>
