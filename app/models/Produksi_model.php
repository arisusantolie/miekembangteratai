<?php

class Produksi_model
{
    private $db;


    public function __construct()
    {
        $this->db = new Database;
    }

    public function AllProduksi()
    {
        $this->db->query("Select * from produksi pr,produk p where pr.id_produk=p.id_produk order by waktu_produksi desc");
        return $this->db->resultSet();
    }

    public function GetDataProduk($id)
    {
        $this->db->query("select * from produk p,stok_mie s where p.id_produk=s.id_produk and s.id_produk=:idproduk");
        $this->db->bind("idproduk", $id);
        return $this->db->resultSingle();
    }
    private $laststok;
    private $stok;
    private $perbandinganproduksi;
    public function AddProduksi($data)
    {
        $this->db->PDObegin();
        $this->db->query("INSERT INTO produksi VALUES ('',:idproduk,:tanggalproduksi,:qty)");
        $this->db->bind("idproduk", $data["idproduk"]);
        $this->db->bind("tanggalproduksi", $data["tanggal"]);
        $this->db->bind("qty", $data["qty"]);
        $this->db->execute();

        if ($this->db->rowCount() == 1) {
            $produk = $this->GetDataProduk($data["idproduk"]);


            $this->perbandinganproduksi = $produk["produksi_qty"];
            $this->laststok = $produk["stok"];
            $this->stok = $this->laststok + ($data["qty"] * $this->perbandinganproduksi);

            $this->db->query("UPDATE stok_mie SET last_update=:tanggalproduksi,stok=:stok where id_produk=:idproduk");
            $this->db->bind("tanggalproduksi", $data["tanggal"]);
            $this->db->bind("stok", $this->stok);
            $this->db->bind("idproduk", $data["idproduk"]);

            $this->db->execute();
            if ($this->db->rowCount() == 1) {
                try {
                    if (empty($this->GetDataBahan($data["idproduk"]))) {
                        $this->db->PDOrollback();
                        echo "<script>
                        alert('Produk Ini Tidak Punya Bahan!!');
                        </script> ";
                        return false;
                        exit;
                    } else {
                        foreach ($this->GetDataBahan($data["idproduk"]) as $bah) {
                            $bahanneed = $data["qty"] * $bah["qty"];
                            $namabahan = $bah["nama_bahan"];
                            if ($bahanneed > $bah["total_stok"]) {
                                echo "<script>
                                alert('Bahan ini kurang $namabahan');
                                </script> ";
                                $this->db->PDOrollback();
                                return false;
                            } else {
                                $this->akhirstok = $bah["total_stok"] - ($data["qty"] * $bah["qty"]);
                                $this->db->query("UPDATE stok_bahan SET total_stok=:akhirstok where id_bahan=:idbahan");
                                $this->db->bind("akhirstok", $this->akhirstok);
                                $this->db->bind("idbahan", $bah["id_bahan"]);
                                $this->db->execute();
                            }
                        }
                        $this->db->PDOcommit();
                        return true;
                    }
                } catch (Exception $e) {
                    if ($this->db->PDOintransaction()) {
                        $this->db->PDOrollback();
                    }
                    return false;
                    exit;
                }
            }
        } else {
            $this->db->PDOrollback();
            return false;
        }


        $this->db->PDOcommit();
        return true;
    }


    public function GetDataBahan($idproduk)
    {
        $this->db->query("select * from bahan b,stok_bahan sb where b.id_produk=:idproduk and b.id_bahan=sb.id_bahan");
        $this->db->bind("idproduk", $idproduk);
        return $this->db->resultSet();
    }

    private  $akhirstok;
    public function DeleteProduksi($idproduksi, $idproduk, $qty)
    {

        $this->db->PDObegin();
        $this->db->query("DELETE FROM produksi where id_produksi=:idproduksi");
        $this->db->bind("idproduksi", $idproduksi);
        $this->db->execute();
        if ($this->db->rowCount() == 1) {
            $produk = $this->GetDataProduk($idproduk);


            $this->perbandinganproduksi = $produk["produksi_qty"];
            $this->laststok = $produk["stok"];
            $this->stok = $this->laststok - ($qty * $this->perbandinganproduksi);

            $this->db->query("UPDATE stok_mie SET stok=:stok where id_produk=:idproduk");
            $this->db->bind("idproduk", $idproduk);
            $this->db->bind("stok", $this->stok);
            $this->db->execute();


            if ($this->db->rowCount() == 1) {
                try {
                    if (empty($this->GetDataBahan($idproduk))) {
                        $this->db->PDOrollback();
                        return false;
                        exit;
                    }
                    foreach ($this->GetDataBahan($idproduk) as $bah) {
                        $this->akhirstok = $bah["total_stok"] + ($qty * $bah["qty"]);
                        $this->db->query("UPDATE stok_bahan SET total_stok=:akhirstok where id_bahan=:idbahan");
                        $this->db->bind("akhirstok", $this->akhirstok);
                        $this->db->bind("idbahan", $bah["id_bahan"]);
                        $this->db->execute();
                    }
                    $this->db->PDOcommit();
                    return true;
                } catch (Exception $e) {
                    if ($this->db->PDOintransaction()) {
                        $this->db->PDOrollback();
                    }
                    return false;
                    exit;
                }
            }
        } else {
            $this->db->PDOrollback();
            return false;
        }
    }


    private $totalstok;
    public function EditProduksi($data)
    {
        $this->db->PDObegin();

        $this->db->query("UPDATE produksi set qty_produksi=:qty,waktu_produksi=:tanggal where id_produksi=:idproduksi");
        $this->db->bind("qty", $data["qty"]);
        $this->db->bind("tanggal", $data["tanggal"]);
        $this->db->bind("idproduksi", $data["idproduksi"]);
        $this->db->execute();
        if ($this->db->rowCount() == 1) {
            $getdatastok = $this->GetDataProduk($data["idproduk"]);

            if ($data["oldqty"] > $data["qty"]) {
                $this->totalstok = $getdatastok["stok"] - (($data["oldqty"] - $data["qty"]) * $getdatastok["produksi_qty"]);


                $this->db->query("UPDATE stok_mie set stok=:totalstok where id_produk=:idproduk");
                $this->db->bind("idproduk", $data["idproduk"]);
                $this->db->bind("totalstok", $this->totalstok);
                $this->db->execute();
                if ($this->db->rowCount() == 1) {
                    try {
                        foreach ($this->GetDataBahan($data["idproduk"]) as $bah) {
                            $this->akhirstok = $bah["total_stok"] + (($data["oldqty"] - $data["qty"]) * $bah["qty"]);
                            $this->db->query("UPDATE stok_bahan SET total_stok=:akhirstok where id_bahan=:idbahan");
                            $this->db->bind("akhirstok", $this->akhirstok);
                            $this->db->bind("idbahan", $bah["id_bahan"]);
                            $this->db->execute();
                        }
                        $this->db->PDOcommit();
                        return true;
                    } catch (Exception $e) {
                        if ($this->db->PDOintransaction()) {
                            $this->db->PDOrollback();
                        }
                        return false;
                        exit;
                    }
                } else {
                    $this->db->PDOrollback();
                    return false;
                    exit;
                }
            } else {
                $this->totalstok = $getdatastok["stok"] - (($data["oldqty"] - $data["qty"]) * $getdatastok["produksi_qty"]);
                $this->db->query("UPDATE stok_mie set stok=:totalstok where id_produk=:idproduk");
                $this->db->bind("idproduk", $data["idproduk"]);
                $this->db->bind("totalstok", $this->totalstok);
                $this->db->execute();

                if ($this->db->rowCount() == 1) {
                    try {
                        foreach ($this->GetDataBahan($data["idproduk"]) as $bah) {
                            $this->akhirstok = $bah["total_stok"] - (($data["qty"] - $data["oldqty"]) * $bah["qty"]);
                            $this->db->query("UPDATE stok_bahan SET total_stok=:akhirstok where id_bahan=:idbahan");
                            $this->db->bind("akhirstok", $this->akhirstok);
                            $this->db->bind("idbahan", $bah["id_bahan"]);
                            $this->db->execute();
                        }
                        $this->db->PDOcommit();
                        return true;
                    } catch (Exception $e) {
                        if ($this->db->PDOintransaction()) {
                            $this->db->PDOrollback();
                        }
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
            $this->db->PDOrollback();
            return false;
        }
    }
}
