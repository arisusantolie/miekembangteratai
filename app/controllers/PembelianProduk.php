<?php
class PembelianProduk extends Controller
{
    public function index()
    {

        $this->view('templates/header');
        $this->view('pembelianproduk/index');
        $this->view('templates/footer');
    }
}
