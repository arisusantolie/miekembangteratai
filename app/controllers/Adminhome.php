<?php


class Adminhome extends Controller
{

    public function index()
    {

        $data["penjualanmonthly"] = $this->model("Dashboard_model")->PenjualanMonthly();
        $data["pembelianmonthly"] = $this->model("Dashboard_model")->PembelianMonthly();
        $data["sudahbayar"] = $this->model("Dashboard_model")->SudahBayar();
        $data["belumbayar"] = $this->model("Dashboard_model")->BelumBayar();
        $data["check"] = $this->model("Dashboard_model")->Check();
        $data["produksi"] = $this->model("Dashboard_model")->Produksi();
        $data["produk"] = $this->model("Dashboard_model")->Produk();
        $data["bahan"] = $this->model("Dashboard_model")->Bahan();
        $data["test"] = $this->model("Dashboard_model")->overviewpenjualan();
        $data["customers"] = $this->model("Customer_model")->AllCustomers();

        $data["judul"] = "Halaman Administrator";
        $this->view("templates/header", $data);
        $this->view("admindashboard/index", $data);
        $this->view("templates/footer");
        $this->view("admindashboard/Dashboardchart", $data);
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
            document.location.href='" . BASEURL . "';  
            </script> "; //javascript aler notificat
        }
    }
}
