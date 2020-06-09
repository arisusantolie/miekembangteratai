<?php

class Flashlogin
{
    public static function setflashlogin($error)
    {
        $_SESSION["error"] = $error;
    }

    public static function showflashlogin()
    {
        if (isset($_SESSION["error"])) {
            echo '<h3 style="color:red;">Username / Password Salah!</h3>';
            unset($_SESSION["error"]);
        }
    }
}
