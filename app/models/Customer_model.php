<?php

class Customer_model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function AllCustomers()
    {
        $this->db->query("Select * from customers");
        return $this->db->resultSet();
    }


    public function customer($idcustomer)
    {
        $this->db->query("Select * from customers where id_customer=:idcust");
        $this->db->bind("idcust", $idcustomer);
        return $this->db->resultSingle();
    }
    public function AddCustomer($data)
    {
        $this->db->query("INSERT INTO customers VALUES('',:nama,:alamat,:nohp)");
        $this->db->bind("nama", $data["nama"]);
        $this->db->bind("alamat", $data["alamat"]);
        $this->db->bind("nohp", $data["nohp"]);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function EditCustomer($data)
    {
        $this->db->query("UPDATE customers set nama_customer=:nama,alamat=:alamat,
        no_hp=:nohp where id_customer=:id");
        $this->db->bind("nama", $data["nama"]);
        $this->db->bind("alamat", $data["alamat"]);
        $this->db->bind("nohp", $data["nohp"]);
        $this->db->bind("id", $data["idcustomer"]);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function delete($id)
    {
        $this->db->query("DELETE FROM customers WHERE id_customer=:id");
        $this->db->bind("id", $id);
        $this->db->execute();
        return $this->db->rowCount();
    }
}
