<?php

class Listpesanan_model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function GetAllPesanan()
    {
        $this->db->query("Select lp.id_list_pesanan,lp.`id_customer`,lp.`id_produk`,`qty`,`deskripsi`,lp.`Tanggal`,c.nama_customer,p.nama_produk,p.harga_produk from listpesanan lp,customers c,produk p where lp.id_customer=c.id_customer and lp.id_produk=p.id_produk and lp.status='PENDING' 
        order by lp.tanggal asc");
        return $this->db->resultSet();
    }

    public function batal($idlistpesanan)
    {
        $this->db->query("UPDATE listpesanan SET status='BATAL' where id_list_pesanan=:idlistpesanan");
        $this->db->bind("idlistpesanan", $idlistpesanan);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function GetProdukData($idproduk)
    {
        $this->db->query("SELECT * FROM produk p,stok_mie s where p.id_produk=s.id_produk and p.id_produk=:idproduk");
        $this->db->bind("idproduk", $idproduk);
        return $this->db->resultSingle();
    }

    public function LastInsertID()
    {
        $this->db->query("SELECT id_penjualan FROM penjualan_header order by id_penjualan desc limit 1");
        return $this->db->resultSingle();
    }

    public function TambahListPesanan($data)
    {

        $this->db->query("INSERT INTO listpesanan VALUES('',:idcustomer,:produk,:qty,:deskripsi,'PENDING',:tanggal)");
        $this->db->bind("idcustomer", $data["customer"]);
        $this->db->bind("tanggal", $data["tanggal"]);
        $this->db->bind("produk", $data["produk"]);
        $this->db->bind("qty", $data["qty"]);
        $this->db->bind("deskripsi", $data["deskripsi"]);
        $this->db->execute();
        return $this->db->rowCount();
    }

    private $qtypesanan;
    private $subtotal;
    public function ApproveSelesai($data)
    {
        $this->db->PDObegin();
        $stok = $data['currentqty'];
        if ($data["qty"] > $data["currentqty"]) {
            echo "<script>
                alert('Stok Yang Anda Masukkan ListPesanan ini, Stok ListPesanan $stok' );
                </script> ";
            return false;
        } elseif ($data["qty"] < $data["currentqty"]) {
            $this->qtypesanan = $data["currentqty"] - $data["qty"];

            $this->db->query("UPDATE listpesanan SET status='SUKSES' where id_list_pesanan=:idlistpesanan");
            $this->db->bind("idlistpesanan", $data["idlistpesanan"]);
            $this->db->execute();
            if ($this->db->rowCount() == 1) {
                $this->db->query("INSERT INTO listpesanan VALUES('',:idcustomer,:idproduk,:qty,:deskripsi,'PENDING',now())");
                $this->db->bind("idcustomer", $data["idcustomer"]);
                $this->db->bind("idproduk", $data["idproduk"]);
                $this->db->bind("qty", $this->qtypesanan);
                $this->db->bind("deskripsi", $data["deskripsi"]);
                $this->db->execute();
            }
        } else {
            $this->db->query("UPDATE listpesanan SET status='SUKSES' where id_list_pesanan=:idlistpesanan");
            $this->db->bind("idlistpesanan", $data["idlistpesanan"]);
            $this->db->execute();
        }

        if ($this->db->rowCount() == 1) {

            $this->db->query("INSERT INTO penjualan_header VALUES ('',:idcustomer,now(),:status_transaksi,'','')");
            $this->db->bind("idcustomer", $data["idcustomer"]);
            $this->db->bind("status_transaksi", $data["status_transaksi"]);
            $this->db->execute();

            if ($this->db->rowCount() == 1) {
                $produkdata = $this->GetProdukData($data["idproduk"]);
                $this->subtotal = $data["qty"] * $produkdata["harga_produk"];
                $lastid = $this->LastInsertID();
                $this->db->query("INSERT INTO penjualan_data VALUES(:idpenjualan,:idproduk,:subtotal,now(),:qty,'')");
                $this->db->bind("idpenjualan", $lastid["id_penjualan"]);
                $this->db->bind("idproduk", $data["idproduk"]);
                $this->db->bind("subtotal", $this->subtotal);
                $this->db->bind("qty", $data["qty"]);
                $this->db->execute();

                if ($this->db->rowCount() == 1) {
                    $stokproduk = $produkdata["stok"];
                    $totalstok = $stokproduk - $data["qty"];
                    if ($stokproduk < $data["qty"]) {
                        echo "<script>
            alert('Stok Produk Kurang Sisa Stok $stokproduk Telah Ada Di Keranjang!!');
            </script> ";
                        $this->db->PDOrollback();
                        return false;
                    } else {
                        $this->db->query("UPDATE stok_mie SET stok=:totalstok where id_produk=:idproduk");
                        $this->db->bind("totalstok", $totalstok);
                        $this->db->bind("idproduk", $data["idproduk"]);
                        $this->db->execute();
                        if ($this->db->rowCount() == 1) {
                            $this->db->PDOcommit();
                            return true;
                        } else {
                            $this->db->PDOrollback();
                            return false;
                        }
                    }
                } else {
                    $this->db->PDOrollback();
                    return false;
                }
            }
        } else {
            $this->db->PDOrollback();
            return false;
        }
    }

    public function EditPesanan($data)
    {
        $this->db->query("UPDATE listpesanan SET id_customer=:idcustomer,id_produk=:idproduk,qty=:qty,deskripsi=:deskripsi,tanggal=:tanggal where id_list_pesanan=:idlistpesanan");
        $this->db->bind("idcustomer", $data["customer"]);
        $this->db->bind("idlistpesanan", $data["idlistpesanan"]);
        $this->db->bind("idproduk", $data["produk"]);
        $this->db->bind("qty", $data["qty"]);
        $this->db->bind("deskripsi", $data["deskripsi"]);
        $this->db->bind("tanggal", $data["tanggal"]);
        $this->db->execute();
        return $this->db->rowCount();
    }
}
