<?php

class Supplier extends Controller
{
    public function index()
    {
        $data["suppliers"] = $this->model("Supplier_model")->AllSupplier();
        $this->view("templates/header");
        $this->view("supplier/index", $data);
        $this->view("templates/footer");
        $this->js("editsupplier");
    }

    public function tambah()
    {
        if ($this->model('Supplier_model')->AddSupplier($_POST) > 0) {
            echo "<script>
            alert('data Supplier Berhasil ditambahkan');
            document.location.href='../Supplier';  
            </script> "; //javascript aler notificat
        } else {
            echo "<script>
            alert('data Supplier Gagal ditambahkan');
            document.location.href='../Supplier';  
            </script> "; //javascript aler notificat
        }
    }

    public function delete($id)
    {
        if ($this->model('Supplier_model')->Delete($id) == 1) {
            echo "<script>
        alert('data berhasil dihapus');
        document.location.href='../../Supplier';  
        </script> "; //javascript aler notification
        } else {
            echo "<script>
            alert('data gagal dihapus');
            document.location.href='../../Supplier';  
            </script> "; //javascript aler notification
        }
    }

    public function Edit()
    {
        if ($this->model('Supplier_model')->EditSupplier($_POST) == 1) {
            echo "<script>
        alert('data Supplier berhasil Di EDIT!');
        document.location.href='../Supplier';  
        </script> "; //javascript aler notificat
        } else {
            echo "<script>
            alert('data Supplier Gagal Di EDIT!');
            document.location.href='../Supplier';  
            </script> ";
        }
    }
}
