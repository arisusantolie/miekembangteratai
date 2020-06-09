<?php

class Supplier_model
{
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }

    public function AllSupplier()
    {
        $this->db->query("SELECT * FROM suppliers");
        return $this->db->resultSet();
    }

    public function AddSupplier($data)
    {
        $this->db->query("INSERT INTO suppliers VALUES ('',:nama,:nohp)");
        $this->db->bind("nama", $data["nama"]);
        $this->db->bind("nohp", $data["nohp"]);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function Delete($id)
    {
        $this->db->query("DELETE FROM suppliers WHERE id_supplier=:id");
        $this->db->bind("id", $id);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function EditSupplier($data)
    {
        $this->db->query("UPDATE suppliers SET nama_supplier=:nama,no_hp=:nohp where id_supplier=:id");
        $this->db->bind("nama", $data["nama"]);
        $this->db->bind("nohp", $data["nohp"]);
        $this->db->bind("id", $data["idsupplier"]);

        $this->db->execute();
        return $this->db->rowCount();
    }
}
