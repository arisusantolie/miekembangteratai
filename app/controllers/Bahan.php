<?php

class Bahan extends Controller
{

    public function index()
    {
        $data["supplier"] = $this->model('Bahan_model')->ListSupplier();
        $data["produk"] = $this->model('Bahan_model')->ListProduk();
        $data["bahan"] = $this->model('Bahan_model')->AllBahan();
        $this->view("templates/header");
        $this->view("bahan/index", $data);
        $this->view("templates/footer");
        $this->js("editbahan");
    }

    public function Addbahan()
    {
        if ($this->model('Bahan_model')->AddBahan($_POST) == True) {
            echo "<script>
            alert('data berhasil ditambahkan');
            document.location.href='../Bahan';  
            </script> "; //javascript aler notificat
        } else {
            echo "<script>
        alert('data gagal ditambahkan');
        document.location.href='../Bahan';  
        </script> "; //javascript aler notificat
        }
    }

    public function DeleteBahan($id)
    {
        if ($this->model('Bahan_model')->DeleteBahan($id) == true) {
            echo "<script>
            alert('data berhasil dihapus');
            document.location.href='../../Bahan';  
            </script> "; //javascript aler notificatio
        } else {
            echo "<script>
            alert('data gagal dihapus');
            document.location.href='../../Bahan';  
            </script> "; //javascript aler notificatio
        }
    }

    public function getubah()
    {
        echo json_encode($this->model('Bahan_model')->GetdatabyID($_POST["id"]));
    }

    public function editdata()
    {
        if ($this->model("Bahan_model")->edit($_POST) == 1) {
            echo "<script>
            alert('data berhasil di Edit!');
            document.location.href='../Bahan';  
            </script> "; //javascript aler notificatio
        } else {
            echo "<script>
            alert('data gagal di Edit!');
            document.location.href='../Bahan';  
            </script> "; //javascript aler notificatio
        }
    }
}
