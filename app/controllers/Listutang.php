<?php
class Listutang extends Controller
{

    public function index()
    {
        $data["customers"] = $this->model("Listutang_model")->GetListNama();

        $this->view("templates/header");
        $this->view("listutang/index", $data);
        $this->view("templates/footer");
    }

    public function utang($idcustomer = "error")
    {
        if ($idcustomer == "error") {
            header('Location:' . BASEURL . "/listutang");
        }
        $data["utangcustomer"] = $this->model("Listutang_model")->GetAllListUtang($idcustomer);
        $data["bayarcustomer"] = $this->model("Listutang_model")->GetListBayar($idcustomer);
        $data["namacustomer"] = $this->model("Customer_model")->customer($idcustomer);
        $this->view("templates/header");
        $this->view("listutang/utang", $data);
        $this->view("templates/footer");
        $this->js("bayarutang");
    }

    public function bayar()
    {

        if ($this->model("Listutang_model")->AddPembayaran($_POST) == 1) {
            echo "<script>
            alert('data Pembayaran Berhasil ditambahkan');
            document.location.href='" . BASEURL . "/Listutang/utang/" . $_POST["idcustomer"] . "';  
            </script> "; //javascript aler notificat
        } else {
            echo "<script>
            alert('data Pembayaran Gagal ditambahkan!');
            document.location.href='" . BASEURL . "/Listutang/utang/" . $_POST["idcustomer"] . "';  
            </script> "; //javascript aler notificat
        }
    }
}
