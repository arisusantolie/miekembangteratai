<?php

class Adminlogin extends Controller
{
    public function index()
    {
        if (isset($_SESSION["login"])) {
            header("Location:" . BASEURL);
            exit;
        };
        $data["judul"] = "Panel Login";
        $this->view("login/index", $data);
    }

    public function masuk()
    {
        if ($this->model("Admin_model")->login($_POST) === true) {
            header("Location:" . BASEURL . "/Adminhome");
            exit;
        } else {
            Flashlogin::setflashlogin(TRUE);
            header("Location:" . BASEURL . "/Adminlogin");
            exit;
        }
    }

    public function logout()
    {

        session_start();
        session_unset();
        session_destroy();

        header("Location:" . BASEURL . "/Adminlogin");
        exit;
    }
}
