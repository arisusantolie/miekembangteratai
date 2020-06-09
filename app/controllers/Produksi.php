<?php

declare(strict_types=1);
class Produksi extends Controller
{

    public function index()
    {
        $data["produksi"] = $this->model('Produksi_model')->AllProduksi();
        $data["produk"] = $this->model('Produk_model')->GetAllDataProduk();
        $this->view("templates/header");
        $this->view("produksi/index", $data);
        $this->view("templates/footer");
        $this->js("editproduksi");
    }

    public function tambah()
    {
        if ($this->model("Produksi_model")->AddProduksi($_POST) == true) {
            echo "<script>
            alert('data produksi berhasil ditambahkan');
            document.location.href='" . BASEURL . "/Produksi';  
            </script> "; //javascript aler notificat
        } else {
            echo "<script>
            alert('data produksi Gagal ditambahkan');
            document.location.href='" . BASEURL . "/Produksi';  
            </script> "; //javascript aler notificat
        }
    }

    public function edit()
    {
        if ($this->model("Produksi_model")->EditProduksi($_POST) == true) {
            echo "<script>
            alert('data produksi berhasil diedit');
            document.location.href='" . BASEURL . "/Produksi';  
            </script> "; //javascript aler notificat
        } else {
            echo "<script>
            alert('data produksi Gagal diedit');
            document.location.href='" . BASEURL . "/Produksi';  
            </script> "; //javascript aler notificat
        }
    }

    public function delete($idproduksi = "error", $idproduk = "error", $qty = "error")
    {
        LoginCheck::Checklogin();
        if ($this->model("Produksi_model")->DeleteProduksi($idproduksi, $idproduk, $qty) == true) {
            echo "<script>
                alert('data produksi berhasil dihapus');
                document.location.href='" . BASEURL . "/Produksi';  
                </script> "; //javascript aler notificat
        } else {
            echo "<script>
                alert('data produksi Gagal dihapus');
                document.location.href='" . BASEURL . "/Produksi';  
                </script> "; //javascript aler notificat
        }
    }
}
