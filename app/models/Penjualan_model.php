<?php

class Penjualan_model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function GetAllPenjualan()
    {
        $this->db->query("select ph.id_penjualan,nama_customer, ph.tanggal_transaksi,sum(sub_total) as total,status_transaksi,deskripsi,bukti_transaksi from penjualan_header ph,penjualan_data pd,customers c
        where ph.id_penjualan=pd.id_penjualan and ph.id_customer=c.id_customer
        group by ph.id_penjualan, ph.tanggal_transaksi,status_transaksi,Nama_customer,bukti_transaksi  
        ORDER BY `ph`.`tanggal_transaksi` desc");
        return $this->db->resultSet();
    }

    public function LastInsertID()
    {
        $this->db->query("SELECT id_penjualan FROM penjualan_header order by id_penjualan desc limit 1");
        return $this->db->resultSingle();
    }

    public function TambahPenjualanHeader($data)
    {
        if (isset($data["tanpafoto"])) {
            $this->db->query("INSERT INTO penjualan_header VALUES ('',:idcustomer,:tanggal,:status_transaksi,:deskripsi,'')");
            $this->db->bind("idcustomer", $data["customer"]);
            $this->db->bind("tanggal", $data["tanggal"]);
            $this->db->bind("status_transaksi", $data["status_transaksi"]);
            $this->db->bind("deskripsi", $data["deskripsi"]);
            $this->db->execute();
        } else {
            $gambar = UploadImage::Upload($_FILES);
            if (!$gambar) {
                return false;
                exit;
            }
            $this->db->query("INSERT INTO penjualan_header VALUES ('',:idcustomer,:tanggal,:status_transaksi,:deskripsi,:gambar)");
            $this->db->bind("idcustomer", $data["customer"]);
            $this->db->bind("tanggal", $data["tanggal"]);
            $this->db->bind("status_transaksi", $data["status_transaksi"]);
            $this->db->bind("deskripsi", $data["deskripsi"]);
            $this->db->bind("gambar", $gambar);
            $this->db->execute();
        }
        return $this->db->rowCount();
    }

    public function EditPenjualanHeader($data)
    {
        if (isset($data["tanpafoto"])) {
            $this->db->query("UPDATE penjualan_header SET status_transaksi=:status_transaksi,tanggal_transaksi=:tanggal,
            deskripsi=:deskripsi where id_penjualan=:idpenjualan");
            $this->db->bind("idpenjualan", $data["idpenjualan"]);
            $this->db->bind("tanggal", $data["tanggal"]);
            $this->db->bind("status_transaksi", $data["status_transaksi"]);
            $this->db->bind("deskripsi", $data["deskripsi"]);
            $this->db->execute();
        } else {
            $gambar = UploadImage::Upload($_FILES);
            if (!$gambar) {
                return false;
                exit;
            }
            $this->db->query("UPDATE penjualan_header SET status_transaksi=:status_transaksi,tanggal_transaksi=:tanggal,
            deskripsi=:deskripsi,bukti_transaksi=:gambar where id_penjualan=:idpenjualan");
            $this->db->bind("idpenjualan", $data["idpenjualan"]);
            $this->db->bind("tanggal", $data["tanggal"]);
            $this->db->bind("status_transaksi", $data["status_transaksi"]);
            $this->db->bind("deskripsi", $data["deskripsi"]);
            $this->db->bind("gambar", $gambar);
            $this->db->execute();
        }
        return $this->db->rowCount();
    }



    //keranjang

    public function CustomerName($idpenjualan)
    {
        $this->db->query("select nama_customer from penjualan_header ph,customers c
        where ph.id_customer=c.id_customer and ph.id_penjualan=:idpenjualan");
        $this->db->bind("idpenjualan", $idpenjualan);
        return $this->db->resultSingle();
    }
    public function GetAllPenjualanData($idpenjualan)
    {
        $this->db->query("select * from penjualan_data pd ,produk p where pd.id_produk=p.id_produk and pd.id_penjualan =:idpenjualan");
        $this->db->bind("idpenjualan", $idpenjualan);
        return $this->db->resultSet();
    }

    public function GetProdukData($idproduk)
    {
        $this->db->query("SELECT * FROM produk p,stok_mie s where p.id_produk=s.id_produk and p.id_produk=:idproduk");
        $this->db->bind("idproduk", $idproduk);
        return $this->db->resultSingle();
    }

    private $subtotal;
    public function TambahPenjualanData($data)
    {
        $this->db->PDObegin();
        $produkdata = $this->GetProdukData($data["produk"]);
        $this->subtotal = $data["qty"] * $produkdata["harga_produk"];

        $this->db->query("INSERT INTO penjualan_data VALUES(:idpenjualan,:idproduk,:subtotal,:tanggal,:qty,'')");
        $this->db->bind("idpenjualan", $data["idpenjualan"]);
        $this->db->bind("idproduk", $data["produk"]);
        $this->db->bind("subtotal", $this->subtotal);
        $this->db->bind("tanggal", $data["tanggal"]);
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
                $this->db->bind("idproduk", $data["produk"]);
                $this->db->execute();
                if ($this->db->rowCount() == 1) {
                    $this->db->query("UPDATE penjualan_header set tanggal_transaksi=now() where id_penjualan=:idpenjualan");
                    $this->db->bind("idpenjualan", $data["idpenjualan"]);
                    $this->db->execute();
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

    private $totalstok;
    public function EditPenjualanKeranjang($data)
    {
        $this->db->PDObegin();
        $produkdata = $this->GetProdukData($data["idproduk"]);
        $oldqty = $data["oldqty"];
        $qty = $data["qty"];

        if ($oldqty > $qty) {
            $this->totalstok = $produkdata["stok"] + ($oldqty - $qty);
            $this->db->query("UPDATE stok_mie set stok=:totalstok where id_produk=:idproduk");
            $this->db->bind("totalstok", $this->totalstok);
            $this->db->bind("idproduk", $data["idproduk"]);
            $this->db->execute();
        } else {
            $this->totalstok = $produkdata["stok"] - ($qty - $oldqty);
            $this->db->query("UPDATE stok_mie set stok=:totalstok where id_produk=:idproduk");
            $this->db->bind("totalstok", $this->totalstok);
            $this->db->bind("idproduk", $data["idproduk"]);
            $this->db->execute();
        }
        if ($this->db->rowCount() == 1) {
            $this->subtotal = $produkdata["harga_produk"] * $qty;
            $this->db->query("UPDATE penjualan_data SET qty=:qty,tanggal_transaksi=:tanggal,sub_total=:subtotal where id_penjualan=:idpenjualan and id_seq=:seq");
            $this->db->bind("qty", $qty);
            $this->db->bind("tanggal", $data["tanggal"]);
            $this->db->bind("subtotal", $this->subtotal);
            $this->db->bind("idpenjualan", $data["idpenjualan"]);
            $this->db->bind("seq", $data["seq"]);
            $this->db->execute();
            if ($this->db->rowCount() == 1) {
                $this->db->PDOcommit();
                return true;
            } else {
                $this->db->PDOrollback();
                return false;
            }
        } else {
            $this->db->PDOrollback();
            return false;
        }
    }

    public function HapusPenjualanData($idpenjualan, $idseq, $idproduk, $qty)
    {
        $this->db->PDObegin();
        $produkdata = $this->GetProdukData($idproduk);
        $stok = $produkdata["stok"];
        $this->totalstok = $stok + $qty;

        $this->db->query("UPDATE stok_mie SET stok=:totalstok where id_produk=:idproduk");
        $this->db->bind("totalstok", $this->totalstok);
        $this->db->bind("idproduk", $idproduk);
        $this->db->execute();

        if ($this->db->rowCount() == 1) {
            $this->db->query("DELETE FROM penjualan_data WHERE id_penjualan=:idpenjualan and id_seq=:idseq");
            $this->db->bind("idpenjualan", $idpenjualan);
            $this->db->bind("idseq", $idseq);
            $this->db->execute();
            if ($this->db->rowCount() == 1) {
                $this->db->PDOcommit();
                return true;
            } else {
                $this->db->PDOrollback();
            }
        } else {
            $this->db->PDOrollback();
            return false;
        }
    }
}
