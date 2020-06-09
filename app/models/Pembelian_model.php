<?php

class Pembelian_model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function GetAllDataPembelian()
    {
        $this->db->query("SELECT p.id_pembelian as ID,nama_supplier,status_transaksi,sum(sub_total) as Total,tanggal_transaksi,bukti_transaksi from pembelian_header p,pembelian_data pd,suppliers s where p.id_supplier=s.id_supplier and p.id_pembelian=pd.id_pembelian 
        group by p.id_pembelian, p.id_supplier, s.nama_supplier, status_transaksi, tanggal_transaksi, bukti_transaksi order by tanggal_transaksi desc");
        $this->db->execute();
        return $this->db->resultSet();
    }

    public function LastInsertID()
    {
        $this->db->query("SELECT id_pembelian FROM pembelian_header order by id_pembelian desc limit 1");
        return $this->db->resultSingle();
    }
    public function TambahPembelian($data)
    {
        if (isset($data["tanpafoto"])) {
            $this->db->query("INSERT INTO pembelian_header VALUES ('',:idsupplier,:tanggal,:status_transaksi,'')");
            $this->db->bind("idsupplier", $data["suppliers"]);
            $this->db->bind("tanggal", $data["tanggal"]);
            $this->db->bind("status_transaksi", $data["status_transaksi"]);
            $this->db->execute();
        } else {
            $gambar = UploadImage::Upload($_FILES);

            if (!$gambar) {
                return false;
            }
            $this->db->query("INSERT INTO pembelian_header VALUES ('',:idsupplier,:tanggal,:status_transaksi,:gambar)");
            $this->db->bind("idsupplier", $data["suppliers"]);
            $this->db->bind("tanggal", $data["tanggal"]);
            $this->db->bind("status_transaksi", $data["status_transaksi"]);
            $this->db->bind("gambar", $gambar);
            $this->db->execute();
        }
        return $this->db->rowCount();
    }

    public function EditPembelian($data)
    {
        if (isset($data["tanpafoto"])) {
            $this->db->query("UPDATE pembelian_header SET status_transaksi=:status_transaksi,tanggal_transaksi=:tanggal where id_pembelian=:idpembelian");
            $this->db->bind("idpembelian", $data["idpembelian"]);
            $this->db->bind("tanggal", $data["tanggal"]);
            $this->db->bind("status_transaksi", $data["status_transaksi"]);
            $this->db->execute();
        } else {
            $gambar = UploadImage::Upload($_FILES);

            if (!$gambar) {
                return false;
            }
            $this->db->query("UPDATE pembelian_header SET status_transaksi=:status_transaksi,tanggal_transaksi=:tanggal ,bukti_transaksi=:gambar where id_pembelian=:idpembelian");
            $this->db->bind("idpembelian", $data["idpembelian"]);
            $this->db->bind("tanggal", $data["tanggal"]);
            $this->db->bind("status_transaksi", $data["status_transaksi"]);
            $this->db->bind("gambar", $gambar);
            $this->db->execute();
        }
        return $this->db->rowCount();
    }



    //Pembelian_data


    public function GetSingleKeranjang($idpembelian)
    {
        $this->db->query("select * from pembelian_data p ,bahan b where p.id_bahan=b.id_bahan and id_pembelian =:idpembelian");
        $this->db->bind("idpembelian", $idpembelian);
        return $this->db->resultSet();
    }

    public function GetSingleKeranjangProduk($idpembelian)
    {
        $this->db->query("select * from pembelian_data p ,produk b where p.id_bahan=b.id_produk and id_pembelian =:idpembelian");
        $this->db->bind("idpembelian", $idpembelian);
        return $this->db->resultSet();
    }

    public function GetSingleKeranjangSupplier($idpembelian)
    {
        $this->db->query("select * from pembelian_header where id_pembelian=:idpembelian");
        $this->db->bind("idpembelian", $idpembelian);
        return $this->db->resultSingle();
    }
    public function Getdatabahan($idbahan)
    {
        $this->db->query("select total_stok from stok_bahan where id_bahan=:idbahan");
        $this->db->bind("idbahan", $idbahan);
        return $this->db->resultSingle();
    }

    public function Getdataproduk($idproduk)
    {
        $this->db->query("select stok from stok_mie where id_produk=:idproduk");
        $this->db->bind("idproduk", $idproduk);
        return $this->db->resultSingle();
    }

    private $subtotal;
    private $totalstok;
    public function pembelianexist($idpembelian)
    {
        $this->db->query("select p.id_bahan,nama_bahan from pembelian_data p,bahan b where p.id_bahan=b.id_bahan and id_pembelian=:idpembelian");
        $this->db->bind("idpembelian", $idpembelian);
        return $this->db->resultSet();
    }
    public function pembelianexistproduk($idpembelian)
    {
        $this->db->query("select p.id_bahan,nama_produk from pembelian_data p,produk b where p.id_bahan=b.id_produk and id_pembelian=:idpembelian");
        $this->db->bind("idpembelian", $idpembelian);
        return $this->db->resultSet();
    }
    public function TambahPembelianData($data)
    {
        $this->db->query("select * from pembelian_data where id_pembelian=:idpembelian");
        $this->db->bind("idpembelian", $data["idpembelian"]);
        $this->db->execute();

        if ($this->db->rowCount() > 0) {
            $pembelianexist = $this->pembelianexist($data["idpembelian"])[0];

            if ($pembelianexist["id_bahan"] == $data["bahan"]) {
                echo "<script>
                    alert('Produk " . $pembelianexist['nama_bahan'] . " Telah Ada Di Keranjang!!');
                    </script> ";
            } else {

                $this->subtotal = $data["harga"] * $data["qty"];
                $this->db->PDObegin();

                $this->db->query("INSERT INTO pembelian_data VALUES(:idpembelian,:idbahan,'',:qty,:harga,:subtotal)");
                $this->db->bind("idpembelian", $data["idpembelian"]);
                $this->db->bind("idbahan", $data["bahan"]);
                $this->db->bind("qty", $data["qty"]);
                $this->db->bind("harga", $data["harga"]);
                $this->db->bind("subtotal", $this->subtotal);
                $this->db->execute();

                if ($this->db->rowCount() == 1) {
                    $databahan = $this->Getdatabahan($data["bahan"]);

                    $this->totalstok = $databahan["total_stok"] + $data["qty"];

                    $this->db->query("UPDATE stok_bahan SET total_stok=:totalstok where id_bahan=:idbahan");
                    $this->db->bind("totalstok", $this->totalstok);
                    $this->db->bind("idbahan", $data["bahan"]);
                    $this->db->execute();
                    if ($this->db->rowCount() == 1) {
                        $this->db->PDOcommit();
                        return true;
                    } else {
                        $this->db->PDOrollback();
                        return false;
                        exit;
                    }
                } else {
                    $this->db->PDOrollback();
                    return false;
                    exit;
                }
            }
        } else {

            $this->subtotal = $data["harga"] * $data["qty"];
            $this->db->PDObegin();

            $this->db->query("INSERT INTO pembelian_data VALUES(:idpembelian,:idbahan,'',:qty,:harga,:subtotal)");
            $this->db->bind("idpembelian", $data["idpembelian"]);
            $this->db->bind("idbahan", $data["bahan"]);
            $this->db->bind("qty", $data["qty"]);
            $this->db->bind("harga", $data["harga"]);
            $this->db->bind("subtotal", $this->subtotal);
            $this->db->execute();

            if ($this->db->rowCount() == 1) {
                $databahan = $this->Getdatabahan($data["bahan"]);

                $this->totalstok = $databahan["total_stok"] + $data["qty"];

                $this->db->query("UPDATE stok_bahan SET total_stok=:totalstok where id_bahan=:idbahan");
                $this->db->bind("totalstok", $this->totalstok);
                $this->db->bind("idbahan", $data["bahan"]);
                $this->db->execute();
                if ($this->db->rowCount() == 1) {
                    $this->db->PDOcommit();
                    return true;
                } else {
                    $this->db->PDOrollback();
                    return false;
                    exit;
                }
            } else {
                $this->db->PDOrollback();
                return false;
                exit;
            }
        }
    }

    public function TambahPembelianDataProduk($data)
    {
        $this->db->query("select * from pembelian_data where id_pembelian=:idpembelian");
        $this->db->bind("idpembelian", $data["idpembelian"]);
        $this->db->execute();

        if ($this->db->rowCount() > 0) {
            $pembelianexist = $this->pembelianexistproduk($data["idpembelian"])[0];

            if ($pembelianexist["id_produk"] == $data["produk"]) {
                echo "<script>
                    alert('Produk " . $pembelianexist['nama_produk'] . " Telah Ada Di Keranjang!!');
                    </script> ";
            } else {

                $this->subtotal = $data["harga"] * $data["qty"];
                $this->db->PDObegin();

                $this->db->query("INSERT INTO pembelian_data VALUES(:idpembelian,:idproduk,'',:qty,:harga,:subtotal)");
                $this->db->bind("idpembelian", $data["idpembelian"]);
                $this->db->bind("idproduk", $data["produk"]);
                $this->db->bind("qty", $data["qty"]);
                $this->db->bind("harga", $data["harga"]);
                $this->db->bind("subtotal", $this->subtotal);
                $this->db->execute();

                if ($this->db->rowCount() == 1) {
                    $dataproduk = $this->Getdataproduk($data["produk"]);

                    $this->totalstok = $dataproduk["stok"] + $data["qty"];

                    $this->db->query("UPDATE stok_mie SET stok=:totalstok where id_produk=:idproduk");
                    $this->db->bind("totalstok", $this->totalstok);
                    $this->db->bind("idproduk", $data["produk"]);
                    $this->db->execute();
                    if ($this->db->rowCount() == 1) {
                        $this->db->PDOcommit();
                        return true;
                    } else {
                        $this->db->PDOrollback();
                        return false;
                        exit;
                    }
                } else {
                    $this->db->PDOrollback();
                    return false;
                    exit;
                }
            }
        } else {

            $this->subtotal = $data["harga"] * $data["qty"];
            $this->db->PDObegin();

            $this->db->query("INSERT INTO pembelian_data VALUES(:idpembelian,:idproduk,'',:qty,:harga,:subtotal)");
            $this->db->bind("idpembelian", $data["idpembelian"]);
            $this->db->bind("idproduk", $data["produk"]);
            $this->db->bind("qty", $data["qty"]);
            $this->db->bind("harga", $data["harga"]);
            $this->db->bind("subtotal", $this->subtotal);
            $this->db->execute();

            if ($this->db->rowCount() == 1) {
                $dataproduk = $this->Getdataproduk($data["produk"]);

                $this->totalstok = $dataproduk["stok"] + $data["qty"];

                $this->db->query("UPDATE stok_mie SET stok=:totalstok where id_produk=:idproduk");
                $this->db->bind("totalstok", $this->totalstok);
                $this->db->bind("idproduk", $data["produk"]);
                $this->db->execute();
                if ($this->db->rowCount() == 1) {
                    $this->db->PDOcommit();
                    return true;
                } else {
                    $this->db->PDOrollback();
                    return false;
                    exit;
                }
            } else {
                $this->db->PDOrollback();
                return false;
                exit;
            }
        }
    }


    public function EditPembelianData($data)
    {

        $this->db->PDObegin();
        $this->subtotal = $data["qty"] * $data["harga"];

        $this->db->query("UPDATE pembelian_data set qty=:qty,harga_perunit=:harga,sub_total=:subtotal where id_pembelian=:idpembelian and id_Seq=:idseq");
        $this->db->bind("qty", $data["qty"]);
        $this->db->bind("harga", $data["harga"]);
        $this->db->bind("subtotal", $this->subtotal);
        $this->db->bind("idpembelian", $data["idpembelian"]);
        $this->db->bind("idseq", $data["seq"]);
        $this->db->execute();



        if ($this->db->rowCount() == 1) {
            $idsubstr = substr($data["idbahan"], 0, 3);
            if ($idsubstr == 'PRO') {
                $dtproduk = $this->Getdataproduk($data["idbahan"]);
                if ($data["qty"] < $data["oldqty"]) {
                    $this->totalstok = $dtproduk["stok"] - ($data["oldqty"] - $data["qty"]);
                    $this->db->query("UPDATE stok_mie SET stok=:totalstok where id_produk=:idproduk");
                    $this->db->bind("totalstok", $this->totalstok);
                    $this->db->bind("idproduk", $data["idbahan"]);
                    $this->db->execute();
                    if ($this->db->rowCount() == 1) {
                        $this->db->PDOcommit();
                        return true;
                    } else {
                        $this->db->PDOrollback();
                        return false;
                        exit;
                    }
                } else {
                    $this->totalstok = $dtproduk["stok"] + ($data["qty"] - $data["oldqty"]);
                    $this->db->query("UPDATE stok_mie SET stok=:totalstok where id_produk=:idproduk");
                    $this->db->bind("totalstok", $this->totalstok);
                    $this->db->bind("idproduk", $data["idbahan"]);
                    $this->db->execute();
                    if ($this->db->rowCount() == 1) {
                        $this->db->PDOcommit();
                        return true;
                    } else {
                        $this->db->PDOrollback();
                        return false;
                        exit;
                    }
                }
            } else {


                $databahan = $this->Getdatabahan($data["idbahan"]);


                if ($data["qty"] < $data["oldqty"]) {
                    $this->totalstok = $databahan["total_stok"] - ($data["oldqty"] - $data["qty"]);
                    $this->db->query("UPDATE stok_bahan SET total_stok=:totalstok where id_bahan=:idbahan");
                    $this->db->bind("totalstok", $this->totalstok);
                    $this->db->bind("idbahan", $data["idbahan"]);
                    $this->db->execute();
                    if ($this->db->rowCount() == 1) {
                        $this->db->PDOcommit();
                        return true;
                    } else {
                        $this->db->PDOrollback();
                        return false;
                        exit;
                    }
                } else {
                    $this->totalstok = $databahan["total_stok"] + ($data["qty"] - $data["oldqty"]);
                    $this->db->query("UPDATE stok_bahan SET total_stok=:totalstok where id_bahan=:idbahan");
                    $this->db->bind("totalstok", $this->totalstok);
                    $this->db->bind("idbahan", $data["idbahan"]);
                    $this->db->execute();
                    if ($this->db->rowCount() == 1) {
                        $this->db->PDOcommit();
                        return true;
                    } else {
                        $this->db->PDOrollback();
                        return false;
                        exit;
                    }
                }
            }
        } else {
            $this->db->PDOrollback();
            return false;
            exit;
        }
    }

    public function DeleteData($idpembelian, $idseq, $idbahan, $qty)
    {
        LoginCheck::Checklogin();
        $this->db->PDObegin();
        $databahan = $this->Getdatabahan($idbahan);
        $this->totalstok = $databahan["total_stok"] - $qty;

        $this->db->query("UPDATE stok_bahan SET total_stok=:total_stok where id_bahan=:idbahan");
        $this->db->bind("total_stok", $this->totalstok);
        $this->db->bind("idbahan", $idbahan);
        $this->db->execute();

        if ($this->db->rowCount() == 1) {
            $this->db->query("DELETE FROM pembelian_data WHERE id_pembelian=:idpembelian and id_Seq=:idseq");
            $this->db->bind("idpembelian", $idpembelian);
            $this->db->bind("idseq", $idseq);
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
}
