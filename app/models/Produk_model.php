<?php

class Produk_model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function GetAllDataProduk()
    {
        $this->db->query("select * from produk p ,stok_mie s where p.id_produk=s.id_produk");
        return $this->db->resultSet();
    }


    public function GetDataNonProduksiProduk()
    {
        $this->db->query("select * from produk p ,stok_mie s where p.id_produk=s.id_produk and produksi_qty=0");
        return $this->db->resultSet();
    }

    public function GetLastInsertID()
    {
        $this->db->query("SELECT * FROM produk ORDER BY tanggal DESC LIMIT 1");
        return $this->db->resultSingle();
    }


    public function InsertProduk($data)
    {
        //     global $conn;
        // date_default_timezone_set("Asia/Jakarta");
        // $nama = validationinput($data["nama"]);
        // $harga = validationinput($data["harga"]);
        // $produksiqty = validationinput($data["produksiqty"]);

        // mysqli_autocommit($conn, false);
        // $status = true;
        // $tanggal = date('Y-m-d H:i:s');

        // $query1 = "INSERT INTO produk VALUES ('','$nama','$harga','$tanggal','$produksiqty')";
        // $result = mysqli_query($conn, $query1);

        // if (!$result) {
        //     $status = false;
        // }

        // $getid = mysqli_query($conn, "SELECT id_produk FROM produk ORDER BY tanggal DESC LIMIT 1");

        // $idproduk = mysqli_fetch_array($getid)[0];
        // $tanggal2 = date('Y-m-d');
        // $query2 = "INSERT INTO stok_mie VALUES ('$idproduk','$tanggal',0)";
        // $result = mysqli_query($conn, $query2);

        // if (!$result) {
        //     $status = false;
        // }

        // if ($status) {
        //     mysqli_commit($conn);
        // } else {
        //     mysqli_rollback($conn);
        // }



        // return $status;
        date_default_timezone_set("Asia/Jakarta");

        try {
            $this->db->PDObegin();
            $this->db->query("INSERT INTO produk VALUES ('',:nama,:harga,:tanggal,:produksiqty)");
            $this->db->bind('nama', $data["nama"]);
            $this->db->bind('harga', $data["harga"]);
            $this->db->bind('produksiqty', $data["produksiqty"]);
            $this->db->bind('tanggal', date('Y-m-d H:i:s'));
            $this->db->execute();

            $this->GetLastInsertID();
            $data["lastid"] = $this->GetLastInsertID();
            $this->db->query("INSERT INTO stok_mie VALUES (:idproduk,:tanggal2,0)");

            $this->db->bind('idproduk', $data["lastid"]["id_produk"]);
            $this->db->bind('tanggal2', date('Y-m-d'));
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

    public function Delete($id)
    {
        try {
            $this->db->PDObegin();
            $this->db->query("DELETE FROM produk WHERE id_produk=:idproduk");
            $this->db->bind("idproduk", $id);
            $this->db->execute();

            $this->db->query("DELETE FROM stok_mie WHERE id_produk=:idproduk");
            $this->db->bind("idproduk", $id);
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

    public function EditProduk($data)
    {
        $this->db->query("UPDATE produk SET nama_produk=:nama,harga_produk=:harga,produksi_qty=:produksiqty where id_produk=:id");
        $this->db->bind("nama", $data["nama"]);
        $this->db->bind("harga", $data["harga"]);
        $this->db->bind("produksiqty", $data["produksiqty"]);
        $this->db->bind("id", $data["idproduk"]);
        $this->db->execute();

        return $this->db->rowCount();
    }
}
