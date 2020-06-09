<?php

class Database
{
    private $host = DB_HOST;
    private $user = DB_USERNAME;
    private $pass = DB_PASS;
    private $db_name = DB_NAME;

    private $dbh; //database handler
    private $stmt; //database statement

    public function __construct()
    {
        //dsn = datasourcename

        $dsn = "mysql::host=" . $this->host . ";dbname=" . $this->db_name;

        $option = [
            PDO::ATTR_PERSISTENT => TRUE,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];
        //untuk optimasi

        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $option);
        } catch (PDOException $ex) {
            die($ex->getMessage());
        }
    }

    public function query($query)
    {
        $this->stmt = $this->dbh->prepare($query);
    }

    public function bind($paramater, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($paramater, $value, $type);
        // untuk kondisi menggunakan parameter seperti where
        // untuk menghindari sql injection seperti mysqli_real escape dll
    }

    public function execute()
    {
        $this->stmt->execute();
    }

    public function resultSet()
    {
        $this->execute();
        return $this->stmt->fetchALL(PDO::FETCH_ASSOC);
    }
    public function resultSingle()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function rowCount()
    {
        return $this->stmt->rowCount();
    }

    public function PDObegin()
    {
        $this->dbh->beginTransaction();
    }

    public function PDOcommit()
    {
        $this->dbh->commit();
    }

    public function PDOrollback()
    {
        $this->dbh->rollBack();
    }

    public function PDOintransaction()
    {
        $this->dbh->inTransaction();
    }
    public function PDOerror()
    {
        $this->dbh->errorInfo();
    }
}
