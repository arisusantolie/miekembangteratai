<?php

class LoginCheck
{
    public static function Checklogin()
    {
        if (!isset($_SESSION["login"])) {
            header("Location:" . BASEURL . "/adminlogin");
            exit;
        }
    }
}
