<?php

class Database
{
    private $statement;
    private $dbHandler;
    private $errorHandler;

    public function __construct() {
        $conn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        try {
            $this->dbHandler = new PDO($conn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            $this->errorHandler = $e->getMessage();
            echo $this->errorHandler;
        }
    }

    public function query($sql) {
        $this->statement = $this->dbHandler->prepare($sql);
    }

    public function bind($param, $val, $type = null) {
        switch (is_null($type)) {
            case is_int($val):
                $type = PDO::PARAM_INT;
                break;
            case is_bool($val):
                $type = PDO::PARAM_BOOL;
                break;
            case is_null($val):
                $type = PDO::PARAM_NULL;
                break;
            default:
                $type = PDO::PARAM_STR;
        }

        $this->statement->bindValue($param, $val, $type);
    }

    public function executeQuery() {
        return $this->statement->execute();
    }

    public function resultSet() {
        $this->executeQuery();
        return $this->statement->fetchAll(PDO::FETCH_OBJ);
    }

    public function getRow() {
        $this->executeQuery()->fetch(PDO::FETCH_OBJ);
    }

    public function countRows() {
        return $this->statement->countRows();
    }
}


?>