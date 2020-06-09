<?php

class Produk extends Controller
{
    public function index()
    {
        $data["judul"] = "Produk";
        $data["produk"] = $this->model("Produk_model")->GetAllDataProduk();
        $this->view("templates/header", $data);
        $this->view("produk/index", $data);
        $this->view("templates/footer");
        $this->js("editproduk");
        $this->js('tambahproduk');
    }

    public function ProdukInsert()
    {
        if ($this->model('Produk_model')->InsertProduk($_POST) == true) {
            echo "<script>
        alert('data berhasil ditambahkan');
            document.location.href='../Produk';  
        </script> "; //javascript aler notificat
            exit;
        } else {

            echo "<script>
            alert('data gagal ditambahkan');
                document.location.href='../Produk';  
            </script> ";
            exit;
        }
    }

    public function produkdelete($id)
    {
        if ($this->model("Produk_model")->Delete($id) == true) {
            echo "<script>
            alert('data berhasil dihapus');
            document.location.href='../../Produk';  
            </script> "; //javascript aler notificat
            exit;
        } else {

            echo "<script>
            alert('data gagal dihapus');
            document.location.href='../Produk';  
            </script> ";
            exit;
        }
    }

    public function ProdukEdit()
    {
        if ($this->model("Produk_model")->EditProduk($_POST) == 1) {
            echo "<script>
            alert('data Produk berhasil Di EDIT!');
            document.location.href='../Produk';  
            </script> "; //javascript aler notificat
        } else {
            echo "<script>
            alert('data Produk GAGAL Di EDIT!');
            document.location.href='../Produk';  
            </script> "; //javascript aler notificat
        }
    }
}
