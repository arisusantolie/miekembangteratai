<?php

class Penjualan extends Controller
{
    public function index()
    {
        $data["penjualan"] = $this->model("Penjualan_model")->GetAllPenjualan();
        $data["customers"] = $this->model("Customer_model")->AllCustomers();
        $this->view("templates/header");
        $this->view("penjualan/index", $data);
        $this->view("templates/footer");
        $this->js("editpenjualanheader");
    }


    public function tambahheader()
    {
        if ($this->model("Penjualan_model")->TambahPenjualanHeader($_POST) == 1) {
            $lastid = $this->model("Penjualan_model")->LastInsertID();


            echo "<script>
            alert('data penjualan berhasil ditambahkan');
            document.location.href='" . BASEURL . "/Penjualan/keranjang/" . $lastid['id_penjualan'] . "';  
            </script> "; //javascript aler notificat
        } else {
            echo "<script>
            alert('data penjualan gagal ditambahkan');
            document.location.href='" . BASEURL . "/Penjualan/';  
            </script> "; //javascript aler notificat
        }
    }

    public function editheader()
    {
        if ($this->model("Penjualan_model")->EditPenjualanHeader($_POST) == 1) {

            echo "<script>
            alert('data penjualan berhasil Di Edit!');
            document.location.href='" . BASEURL . "/Penjualan';  
            </script> "; //javascript aler notificat
        } else {
            echo "<script>
            alert('data penjualan gagal Di Edit!');
            document.location.href='" . BASEURL . "/Penjualan/';  
            </script> "; //javascript aler notificat
        }
    }

    //keranjang

    public function keranjang($idpenjualan)
    {
        $data["keranjang"] = $this->model("Penjualan_model")->GetAllPenjualanData($idpenjualan);
        $data["customers"] = $this->model("Customer_model")->AllCustomers();
        $data["customer"] = $this->model("Penjualan_model")->CustomerName($idpenjualan);
        $data["produk"] = $this->model("Produk_model")->GetAllDataProduk();
        $data["idpenjualan"] = $idpenjualan;


        $this->view("templates/header");
        $this->view("penjualan/keranjang", $data);
        $this->view("templates/footer");
        $this->js("editpenjualandata");
    }

    public function TambahData()
    {
        if ($this->model("Penjualan_model")->TambahPenjualanData($_POST) == 1) {

            echo "<script>
            alert('data keranjang berhasil ditambahkan');
            document.location.href='" . BASEURL . "/Penjualan/keranjang/" . $_POST["idpenjualan"] . "';  
            </script> "; //javascript aler notificat
        } else {
            echo "<script>
            alert('data keranjang gagal ditambahkan');
            document.location.href='" . BASEURL . "/Penjualan/keranjang/" . $_POST["idpenjualan"] . "'; 
            </script> "; //javascript aler notificat
        }
    }
    public function EditData()
    {
        if ($this->model("Penjualan_model")->EditPenjualanKeranjang($_POST) == true) {

            echo "<script>
            alert('data keranjang berhasil diedit');
            document.location.href='" . BASEURL . "/Penjualan/keranjang/" . $_POST["idpenjualan"] . "';  
            </script> "; //javascript aler notificat
        } else {
            echo "<script>
            alert('data keranjang gagal diedit');
            document.location.href='" . BASEURL . "/Penjualan/keranjang/" . $_POST["idpenjualan"] . "'; 
            </script> "; //javascript aler notificat
        }
    }

    public function DeleteData($idpenjualan = "error", $idseq = "error", $idproduk = "error", $qty = 0)
    {
        LoginCheck::Checklogin();
        if ($this->model("Penjualan_model")->HapusPenjualanData($idpenjualan, $idseq, $idproduk, $qty)) {
            echo "<script>
            alert('data keranjang berhasil dihapus!');
            document.location.href='" . BASEURL . "/Penjualan/keranjang/" . $idpenjualan . "';  
            </script> ";
        } else {
            echo "<script>
            alert('data keranjang berhasil dihapus!');
            document.location.href='" . BASEURL . "/Penjualan/keranjang/" . $idpenjualan . "';  
            </script> ";
        }
    }
}
