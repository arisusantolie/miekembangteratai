<?php
class Listutang_model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function GetListNama()
    {
        $this->db->query("select * from customers c,penjualan_header ph,penjualan_data pd where c.id_customer=ph.id_customer and ph.id_penjualan=pd.id_penjualan and ph.status_transaksi='BELUM BAYAR' group by c.id_customer");
        return  $this->db->resultSet();
    }

    public function GetAllListUtang($idcustomer)
    {
        $this->db->query("Select ph.id_penjualan,p.nama_produk,c.nama_customer,c.id_customer,ph.status_transaksi,ph.tanggal_transaksi ,sum(sub_total) as total from penjualan_header ph, customers c, penjualan_data pd,produk p where ph.id_customer=c.id_customer and ph.id_penjualan=pd.id_penjualan and pd.id_produk=p.id_produk and c.id_customer=:id_customer and status_transaksi='BELUM BAYAR'  GROUP by ph.id_penjualan,c.id_customer order by total");
        $this->db->bind("id_customer", $idcustomer);
        return  $this->db->resultSet();
    }

    public function GetListBayar($idcustomer)
    {
        $this->db->query("Select * from utang where id_customer=:idcustomer and status='BAYAR'");
        $this->db->bind("idcustomer", $idcustomer);
        return $this->db->resultSet();
    }

    public function LastInsert($idcustomer)
    {
        $this->db->query("SELECT nominal FROM `utang` WHERE id_customer=:idcust order by tanggal desc limit 0,1");
        $this->db->bind("idcust", $idcustomer);
        $this->db->execute();
        return $this->db->resultSingle();
    }
    public function AddPembayaran($data)
    {
        $this->db->PDObegin();
        $list = $this->GetAllListUtang($data["idcustomer"]);

        $bayareksis = $this->GetListBayar($data["idcustomer"]);
        $bayar = $data["nominal"];
        if ($bayareksis) {
            $totalbayareksis = 0;
            foreach ($bayareksis as $row) {

                $totalbayareksis += $row["nominal"];
            }
            $bayar = $bayar + $totalbayareksis;
        } else {
            $totalbayareksis = 0;
            $bayar = $data["nominal"];
        }
        $listotal = 0;
        foreach ($list as $lis) {

            if ($bayar > $lis["total"]) {
                $deskripsi = "Bayar : " . $data["tanggal"];
                $this->db->query("UPDATE penjualan_header SET status_transaksi='SUDAH BAYAR',deskripsi=:deskripsi where id_penjualan=:idpenjualan");
                $this->db->bind("idpenjualan", $lis["id_penjualan"]);
                $this->db->bind("deskripsi", $deskripsi);
                $this->db->execute();

                if ($this->db->RowCount() == 1) {
                    foreach ($bayareksis as $listeksis) {
                        $this->db->query("UPDATE utang SET status='SELESAI' where id_customer=:idcustomer and id_list_utang=:idutang");
                        $this->db->bind("idcustomer", $data["idcustomer"]);
                        $this->db->bind("idutang", $listeksis["id_list_utang"]);
                        $this->db->execute();
                    }

                    $iii = $lis["total"] - $totalbayareksis;

                    $this->db->query("INSERT INTO utang VALUES('',:idcustomer,:nominal,:tanggal,'SELESAI',:penerima)");
                    $this->db->bind("idcustomer", $data["idcustomer"]);
                    $this->db->bind("nominal", $iii);
                    $this->db->bind("tanggal", $data["tanggal"]);
                    $this->db->bind("penerima", $_SESSION["username"]);
                    $this->db->execute();
                    $totalbayareksis = 0;;
                } else {
                    $this->db->PDOrollback();
                    return false;
                }
                $lastinsert = $this->LastInsert($data["idcustomer"]);
                $listotal = $lastinsert["nominal"];
                $bayar = $bayar - $lis["total"];
            } else if ($bayar == $lis["total"]) {
                $deskripsi = "Bayar : " . $data["tanggal"];
                $this->db->query("UPDATE penjualan_header SET status_transaksi='SUDAH BAYAR',deskripsi=:deskripsi where id_penjualan=:idpenjualan");
                $this->db->bind("idpenjualan", $lis["id_penjualan"]);
                $this->db->bind("deskripsi", $deskripsi);
                $this->db->execute();
                if ($this->db->RowCount() == 1) {
                    foreach ($bayareksis as $listeksis) {
                        $this->db->query("UPDATE utang SET status='SELESAI' where id_customer=:idcustomer and id_list_utang=:idutang");
                        $this->db->bind("idcustomer", $data["idcustomer"]);
                        $this->db->bind("idutang", $listeksis["id_list_utang"]);
                        $this->db->execute();
                    }
                } else {
                    $this->db->PDOrollback();
                    return false;
                }
                $aaa = $bayar - $totalbayareksis;
                if ($bayar != 0) {

                    $this->db->query("INSERT INTO utang VALUES('',:idcustomer,:nominal,:tanggal,'SELESAI',:penerima)");
                    $this->db->bind("idcustomer", $data["idcustomer"]);
                    $this->db->bind("nominal", $aaa);
                    $this->db->bind("tanggal", $data["tanggal"]);
                    $this->db->bind("penerima", $_SESSION["username"]);
                    $this->db->execute();
                    $this->db->PDOcommit();
                    return true;
                    exit;
                }
            } else {
                $bayar = $data["nominal"] - $listotal;
            }
        }

        if ($bayar != 0) {

            $this->db->query("INSERT INTO utang VALUES('',:idcustomer,:nominal,:tanggal,'BAYAR',:penerima)");
            $this->db->bind("idcustomer", $data["idcustomer"]);
            $this->db->bind("nominal", $bayar);
            $this->db->bind("tanggal", $data["tanggal"]);
            $this->db->bind("penerima", $_SESSION["username"]);
            $this->db->execute();
        }
        if ($this->db->rowCount() == 1) {
            $this->db->PDOcommit();
            return true;
        } else {
            $this->db->PDOrollback();
            return false;
        }
    }
}
