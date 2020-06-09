<?php

class Pembelian extends Controller
{

    public function index()
    {
        $data["pembelian"] = $this->model("Pembelian_model")->GetAllDataPembelian();
        $data["suppliers"] = $this->model("Supplier_model")->AllSupplier();
        $this->view("templates/header");
        $this->view("pembelian/index", $data);
        $this->view("templates/footer");
        $this->js("editpembelian");
    }

    public function Tambah()
    {

        if ($this->model("Pembelian_model")->TambahPembelian($_POST) == 1) {
            $lastid = $this->model("Pembelian_model")->LastInsertID();

            echo "<script>
            alert('data pembelian berhasil ditambahkan');
            document.location.href='" . BASEURL . "/Pembelian/keranjang/" . $lastid['id_pembelian'] . "';  
            </script> "; //javascript aler notificat
        } else {
            echo "<script>
            alert('data pembelian gagal ditambahkan');
            document.location.href='" . BASEURL . "/Pembelian/';  
            </script> "; //javascript aler notificat
        }
    }

    public function edit()
    {
        if ($this->model("Pembelian_model")->EditPembelian($_POST) == 1) {
            echo "<script>
            alert('data pembelian berhasil di Perbaharui');
            document.location.href='" . BASEURL . "/Pembelian';  
            </script> "; //javascript aler notificat
        } else {
            echo "<script>
            alert('data pembelian gagal di perbaharui!!');
            document.location.href='" . BASEURL . "/Pembelian';  
            </script> "; //javascript aler notificat
        }
    }
    //pembelian data
    public function keranjang($idpembelian)
    {
        $data["keranjang"] = $this->model("Pembelian_model")->GetSingleKeranjang($idpembelian);
        $data["keranjangproduk"] = $this->model("Pembelian_model")->GetSingleKeranjangProduk($idpembelian);

        $data["supplier"] = $this->model("Pembelian_model")->GetSingleKeranjangSupplier($idpembelian);
        $data["listbahansupplier"] = $this->model("Bahan_model")->ListBahanSupplier($data["supplier"]["id_supplier"]);
        $data["idpembelian"] = $idpembelian;
        $data["produk"] = $this->model("Produk_model")->GetDataNonProduksiProduk();
        $this->view("templates/header");
        $this->view("pembelian/keranjang", $data);
        $this->view("templates/footer");
        $this->js("editpembeliandata");
    }

    public function Tambahkeranjang()
    {
        if ($this->model("Pembelian_model")->TambahPembelianData($_POST) == true) {
            echo "<script>
            alert('Keranjang Berhasil ditambahkan');
            document.location.href='" . BASEURL . "/Pembelian/keranjang/" . $_POST["idpembelian"] . "';  
            </script> "; //javascript aler notificat
        } else {
            echo "<script>
            alert('Keranjang Gagal ditambahkan');
            document.location.href='" . BASEURL . "/Pembelian/keranjang/" . $_POST["idpembelian"] . "';  
            </script> "; //javascript aler notificat
        }
    }

    public function TambahkeranjangProduk()
    {
        if ($this->model("Pembelian_model")->TambahPembelianDataProduk($_POST) == true) {
            echo "<script>
            alert('Keranjang Berhasil ditambahkan');
            document.location.href='" . BASEURL . "/Pembelian/keranjang/" . $_POST["idpembelian"] . "';  
            </script> "; //javascript aler notificat
        } else {
            echo "<script>
            alert('Keranjang Gagal ditambahkan');
            document.location.href='" . BASEURL . "/Pembelian/keranjang/" . $_POST["idpembelian"] . "';  
            </script> "; //javascript aler notificat
        }
    }

    public function editpembeliandata()
    {
        if ($this->model("Pembelian_model")->EditPembelianData($_POST) == true) {
            echo "<script>
            alert('Keranjang Berhasil diedit');
            document.location.href='" . BASEURL . "/Pembelian/keranjang/" . $_POST["idpembelian"] . "';  
            </script> "; //javascript aler notificat
        } else {
            echo "<script>
            alert('Keranjang Gagal diedit!');
            document.location.href='" . BASEURL . "/Pembelian/keranjang/" . $_POST["idpembelian"] . "';  
            </script> "; //javascript aler notificat
        }
    }

    public function Delete($idpembelian = "error", $idseq = "error", $idbahan = "error", $qty = 0)
    {
        if ($this->model("Pembelian_model")->DeleteData($idpembelian, $idseq, $idbahan, $qty) == true) {
            echo "<script>
            alert('Keranjang Berhasil dihapus');
            document.location.href='" . BASEURL . "/Pembelian/keranjang/" . $idpembelian . "';  
            </script> "; //javascript aler notificat
        } else {
            echo "<script>
            alert('Keranjang Gagal dihapus!');
            document.location.href='" . BASEURL . "/Pembelian/keranjang/" . $idpembelian . "';  
            </script> "; //javascript aler notificat
        }
    }
}
