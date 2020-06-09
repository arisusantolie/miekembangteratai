<?php

class Customer extends Controller
{

    public function index()
    {
        $data["customers"] = $this->model("Customer_model")->AllCustomers();
        $this->view("templates/header");
        $this->view("customer/index", $data);
        $this->view("templates/footer");
        $this->js("editcustomer");
    }

    public function tambah()
    {
        if ($this->model("Customer_model")->AddCustomer($_POST) > 0) {
            echo "<script>
        alert('data Pelanggan berhasil ditambahkan');
        document.location.href='../Customer';  
        </script> "; //javascript aler notificat
        } else {
            echo "<script>
            alert('data Pelanggan berhasil ditambahkan');
            document.location.href='../Customer';  
            </script> "; //javascript aler notificat
        }
    }

    public function edit()
    {
        if ($this->model("Customer_model")->EditCustomer($_POST) > 0) {
            echo "<script>
        alert('data Pelanggan berhasil di UBAH');
        document.location.href='../Customer';  
        </script> "; //javascript aler notificat
        } else {
            echo "<script>
            alert('data Pelanggan berhasil Di Ubah');
            document.location.href='../Customer';  
            </script> "; //javascript aler notificat
        }
    }

    public function delete($id)
    {
        if ($this->model("Customer_model")->delete($id) == 1) {
            echo "<script>
        alert('data Pelanggan berhasil di Hapus');
        document.location.href='../../Customer';  
        </script> "; //javascript aler notificat
        } else {
            echo "<script>
            alert('data Pelanggan berhasil di Hapus');
            document.location.href='../../Customer';  
            </script> "; //javascript aler notificat
        }
    }
}
