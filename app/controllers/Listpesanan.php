<?php
class Listpesanan extends Controller
{

    public function index()
    {
        $data["listpesanan"] = $this->model("Listpesanan_model")->GetAllPesanan();
        $data["customers"] = $this->model("Customer_model")->AllCustomers();
        $data["produk"] = $this->model("Dashboard_model")->Produk();
        $this->view("templates/header");
        $this->view("listpesanan/index", $data);
        $this->view("templates/footer");
        $this->js("listpesanansetuju");
        $this->js("editlistpesanan");
    }

    public function batal($idlistpesanan = "error")
    {
        LoginCheck::Checklogin();
        if ($this->model("Listpesanan_model")->batal($idlistpesanan) == 1) {
            echo "<script>
            alert('List Pesanan Berhasil Di Batalkan');
            document.location.href='" . BASEURL . "/Listpesanan';  
            </script> "; //javascript aler notificat
        } else {
            echo "<script>
            alert('List Pesanan Gagal Di Batalkan');
            document.location.href='" . BASEURL . "/Listpesanan';  
            </script> "; //javascript aler notificat
        }
    }

    public function setuju()
    {
        if ($this->model("Listpesanan_model")->ApproveSelesai($_POST) == 1) {
            echo "<script>
            alert('List Pesanan Berhasil Di Setujui');
            document.location.href='" . BASEURL . "/Listpesanan';  
            </script> "; //javascript aler notificat
        } else {
            echo "<script>
            alert('List Pesanan Gagal Di Setujui');
            document.location.href='" . BASEURL . "/Listpesanan';  
            </script> "; //javascript aler notificat
        }
    }

    public function tambahlistpesanan()
    {
        if ($this->model("Listpesanan_model")->TambahListPesanan($_POST) == 1) {
            echo "<script>
            alert('List Pesanan Berhasil Di Tambahkan');
            document.location.href='" . BASEURL . "/Listpesanan';  
            </script> "; //javascript aler notificat
        } else {
            echo "<script>
            alert('List Pesanan Gagal Di Tambahkan');
            document.location.href='" . BASEURL . "/Listpesanan';  
            </script> "; //javascript aler notificat
        }
    }

    public function editlistpesanan()
    {
        if ($this->model("Listpesanan_model")->EditPesanan($_POST) == 1) {
            echo "<script>
            alert('List Pesanan Berhasil Di Perbaharui');
            document.location.href='" . BASEURL . "/Listpesanan';  
            </script> "; //javascript aler notificat
        } else {
            echo "<script>
            alert('List Pesanan Gagal Di Perbaharui');
            document.location.href='" . BASEURL . "/Listpesanan;  
            </script> "; //javascript aler notificat
        }
    }
}
