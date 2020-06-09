<?php

class Formatrupiah
{
    public static function rupiah($angka)
    {

        $hasil_rupiah = number_format($angka, 0, ',', '.');
        return $hasil_rupiah;
    }
}
