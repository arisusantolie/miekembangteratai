<?php
class Dashboard_model
{
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }

    public function PenjualanMonthly()
    {
        $this->db->query("select SUBSTRING(ph.tanggal_transaksi, 6, 2) as tanggal,sum(sub_total) as total from penjualan_header ph,penjualan_data pd
        where ph.id_penjualan=pd.id_penjualan and SUBSTRING(ph.tanggal_transaksi, 6, 2)=MONTH(CURRENT_DATE())
        group by SUBSTRING(ph.tanggal_transaksi, 6, 2)");
        return $this->db->resultSingle();
    }
    public function PembelianMonthly()
    {
        $this->db->query("select SUBSTRING(ph.tanggal_transaksi, 6, 2) as tanggal,sum(sub_total) as total from pembelian_header ph,pembelian_data pd
        where ph.id_pembelian=pd.id_pembelian and SUBSTRING(ph.tanggal_transaksi, 6, 2)=MONTH(CURRENT_DATE())
        group by SUBSTRING(ph.tanggal_transaksi, 6, 2)");
        return $this->db->resultSingle();
    }

    public function SudahBayar()
    {
        $this->db->query("select SUBSTRING(ph.tanggal_transaksi, 6, 2) as tanggal,sum(sub_total) as total,status_transaksi from penjualan_header ph,penjualan_data pd
        where ph.id_penjualan=pd.id_penjualan and SUBSTRING(ph.tanggal_transaksi, 6, 2)=MONTH(CURRENT_DATE()) and status_transaksi='SUDAH BAYAR'
        group by SUBSTRING(ph.tanggal_transaksi, 6, 2),status_transaksi");
        return $this->db->resultSingle();
    }

    public function BelumBayar()
    {
        $this->db->query("select SUBSTRING(ph.tanggal_transaksi, 6, 2) as tanggal,sum(sub_total) as total,status_transaksi from penjualan_header ph,penjualan_data pd
        where ph.id_penjualan=pd.id_penjualan and SUBSTRING(ph.tanggal_transaksi, 6, 2)=MONTH(CURRENT_DATE()) and status_transaksi='BELUM BAYAR'
        group by SUBSTRING(ph.tanggal_transaksi, 6, 2),status_transaksi");
        return $this->db->resultSingle();
    }

    public function Check()
    {
        $this->db->query("select SUBSTRING(tanggal_transaksi, 6, 2) as tanggal,status_transaksi from penjualan_header where SUBSTRING(tanggal_transaksi, 6, 2)=MONTH(CURRENT_DATE()) and status_transaksi='BELUM BAYAR'");
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function Produksi()
    {
        $this->db->query("select Sum(qty_produksi) as total from produksi where substring(waktu_produksi,1,10)=CURRENT_DATE()");
        $this->db->execute();
        return $this->db->resultSingle();
    }

    public function Produk()
    {
        $this->db->query("select p.id_produk, nama_produk,stok from produk p,stok_mie s where p.id_produk=s.id_produk");
        return $this->db->resultSet();
    }

    public function Bahan()
    {
        $this->db->query("select nama_bahan,total_stok from bahan b,stok_bahan s where b.id_bahan=s.id_bahan");
        return $this->db->resultSet();
    }

    public function overviewpenjualan()
    {
        $this->db->query("select SUBSTRING(ph.tanggal_transaksi, 6, 2) as tanggal ,sum(sub_total) as total from penjualan_header ph,penjualan_data pd
        where ph.id_penjualan=pd.id_penjualan and SUBSTRING(ph.tanggal_transaksi, 1, 4)=YEAR(CURRENT_DATE())
        group by SUBSTRING(ph.tanggal_transaksi, 6, 2)");

        $overviewpenjualan = $this->db->resultSet();
        $test = array();
        for ($i = 0; $i <= 11; $i++) {
            $test[$i] = 0;
        }


        foreach ($overviewpenjualan as $row) {
            $tanggal = (int) $row["tanggal"];
            if ($tanggal == 1) {
                $test[0] = $row["total"];
            }
            if ($tanggal == 2) {
                $test[1] = $row["total"];
            }
            if ($tanggal == 3) {
                $test[2] = $row["total"];
            }
            if ($tanggal == 4) {
                $test[3] = $row["total"];
            }
            if ($tanggal == 5) {
                $test[4] = $row["total"];
            }
            if ($tanggal == 6) {
                $test[5] = $row["total"];
            }
            if ($tanggal == 7) {
                $test[6] = $row["total"];
            }
            if ($tanggal == 8) {
                $test[7] = $row["total"];
            }
            if ($tanggal == 9) {
                $test[8] = $row["total"];
            }
            if ($tanggal == 10) {
                $test[9] = $row["total"];
            }
            if ($tanggal == 11) {
                $test[10] = $row["total"];
            }
            if ($tanggal == 12) {
                $test[11] = $row["total"];
            }
        }
        return $test;
    }
}
