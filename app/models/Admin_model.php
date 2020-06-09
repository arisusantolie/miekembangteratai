<?php

class Admin_model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function login($data)
    {
        $this->db->query("SELECT * FROM users WHERE username=:username");
        $this->db->bind('username', $data["username"]);
        $check = $this->db->resultSingle();

        if ($this->db->rowCount() == 1) {

            if (password_verify($data["password"], $check["password"])) {
                $_SESSION["login"] = true;
                $_SESSION["username"] = $data["username"];
                return true;
                exit;
            };
        } else {
            return false;
        }
    }
}
