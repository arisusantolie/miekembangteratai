<?php

class Bahan_model
{
    private $db;
    public function __construct()
    {
        $this->db = new database;
    }

    public function ListSupplier()
    {
        $this->db->query("select * from suppliers");
        return $this->db->resultSet();
    }

    public function ListProduk()
    {
        $this->db->query("select * from produk");
        return $this->db->resultSet();
    }


    public function ListBahanSupplier($idsupplier)
    {
        $this->db->query("select nama_bahan,id_bahan from bahan where id_supplier=:idsupplier");
        $this->db->bind("idsupplier", $idsupplier);
        return $this->db->resultSet();
    }

    public function AllBahan()
    {
        $this->db->query("select b.id_bahan,nama_bahan,nama_supplier,total_stok from bahan b,stok_bahan sb,suppliers s where b.id_supplier=s.id_supplier and b.id_bahan=sb.id_bahan");
        return $this->db->resultSet();
    }

    public function LastIDBahan()
    {
        $this->db->query("SELECT id_bahan FROM bahan ORDER BY tanggal DESC LIMIT 1");
        return $this->db->resultSingle();
    }


    public function AddBahan($data)
    {
        date_default_timezone_set("Asia/Jakarta");
        try {
            $this->db->PDObegin();
            $this->db->query("INSERT INTO bahan VALUES ('',:nama,:idsupplier,:idproduk,:tanggal)");
            $this->db->bind("nama", $data["nama"]);
            $this->db->bind("idsupplier", $data["supplier"]);
            $this->db->bind("idproduk", $data["produk"]);
            $this->db->bind("tanggal", date('Y-m-d H:i:s'));

            $this->db->execute();

            $komposisiqty = $data["komposisi"];
            if (!is_numeric($komposisiqty)) {
                $this->db->PDOrollback();

                return false;
            }
            $lastId = $this->LastIDBahan();

            $this->db->query("insert into stok_bahan values (:idbahan,:tanggal2,0,:komposisiqty)");
            $this->db->bind("idbahan", $lastId["id_bahan"]);
            $this->db->bind("tanggal2", date('Y-m-d'));
            $this->db->bind("komposisiqty", $komposisiqty);
            $this->db->execute();

            $this->db->PDOcommit();
            return true;
        } catch (Exception $e) {

            if ($this->db->PDOintransaction()) {
                $this->db->PDOrollback();
            }
            return false;
        }
    }

    public function DeleteBahan($id)
    {

        try {
            $this->db->PDObegin();
            $this->db->query("DELETE FROM bahan WHERE id_bahan=:id");
            $this->db->bind("id", $id);
            $this->db->execute();

            $this->db->query("DELETE FROM stok_bahan WHERE id_bahan=:id");
            $this->db->bind("id", $id);
            $this->db->execute();
            $this->db->PDOcommit();

            return true;
        } catch (Exception $e) {
            if ($this->db->PDOintransaction()) {
                $this->db->PDOrollback();
            }
            return false;
        }
    }

    public function GetdatabyID($id)
    {
        $this->db->query("SELECT * FROM bahan b,suppliers s, produk p where b.id_supplier=s.id_supplier and b.id_produk=p.id_produk and b.id_bahan=:id");
        $this->db->bind("id", $id);
        return $this->db->resultSingle();
    }

    public function edit($data)
    {
        $this->db->query("UPDATE bahan Set nama_bahan=:nama,id_supplier=:supplier,
        id_produk=:produk where id_bahan=:oldid");

        $this->db->bind("nama", $data["nama"]);
        $this->db->bind("supplier", $data["supplier"]);
        $this->db->bind("produk", $data["produk"]);
        $this->db->bind("oldid", $data["oldid"]);
        $this->db->execute();

        return $this->db->rowCount();
    }
}
