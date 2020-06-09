<div class="row">

    <div class=" col-lg-12">


        <h3 class="ml-4">Daftar Pesanan</h3>
        <button class="mt-2 mb-2 ml-4 btn btn-danger font-weight-bold" data-toggle="modal" data-target="#add_listpesanan">Tambah LIST PESANAN</button>
        <p class="ml-4" style="color:red">No. Nama ->
            Produk ->
            Qty ->
            Catatan
        </p>
        <?php $no = 1; ?>
        <?php foreach ($data["listpesanan"] as $list) : ?>
            <ul class="ml-3 list-group mr-2 mb-2">

                <li class="list-group-item">

                    <p style="color:black"><?= $no . ". "; ?><?= $list["nama_customer"]; ?> ->
                        <?= $list["nama_produk"]; ?> ->
                        <?= $list["qty"]; ?>
                        <?php if ($list["deskripsi"] == null) : ?>

                        <?php else : ?>
                            -> <?= $list["deskripsi"]; ?></p>
                <?php endif; ?>

                </li>
                <li class="list-group-item">
                    <div class="col-lg-12">
                        <?= $list["Tanggal"]; ?>
                    </div>
                    <div class="col-lg-12">
                        <h5><a href="<?= BASEURL ?>/Listpesanan/batal/<?= $list["id_list_pesanan"] ?>" class="badge badge-danger float-right ml-2" onclick="return confirm('Apakah Anda Yakin Membatalkan List ini?');">Batal</a></h5>
                        <h5><a href="#" id="editlistpesanan" data-toggle="modal" data-target="#edit_listpesanan" class="badge badge-warning float-right editmodal" data-customer="<?= $list['id_customer'] ?>" data-produk="<?= $list['id_produk'] ?>" data-qty="<?= $list['qty'] ?>" data-tanggal="<?= $list['Tanggal'] ?>" data-deskripsi="<?= $list['deskripsi'] ?>" data-id="<?= $list['id_list_pesanan'] ?>">Edit</a></h5>
                        <h5><a href="#" id="approvelist" data-toggle="modal" data-target="#add_approve" class="badge badge-primary float-right mr-2" data-id="<?= $list['id_list_pesanan'] ?>" data-qty="<?= $list['qty'] ?>" data-customer="<?= $list['id_customer'] ?>" data-produk="<?= $list['id_produk'] ?>" data-harga="<?= $list['harga_produk'] ?>" data-deskripsi="<?= $list['deskripsi'] ?>">Selesai</a></h5>
                    </div>

                </li>


            </ul>
            <?php $no++ ?>
        <?php endforeach; ?>

    </div>




</div>

<!-- Modal Tambahkan -->
<div class="modal fade" id="add_approve" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Transaksi Penjualan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= BASEURL ?>/Listpesanan/setuju" method="post" enctype="multipart/form-data" id="uploadform">
                <div class="modal-body" id="modal-approve">

                    <div class="form-group">
                        <input type="hidden" name="idcustomer" id="idcustomer">
                        <input type="hidden" name="idproduk" id="idproduk">
                        <input type="hidden" name="harga" id="harga">
                        <input type="hidden" name="idlistpesanan" id="idlistpesanan">
                        <input type="hidden" name="currentqty" id="currentqty">
                        <input type="hidden" name="deskripsi" id="deskripsi">
                        <label for="bukti">Status Transaksi</label>
                        <select name="status_transaksi" class="form-control" id="status">

                            <option value="SUDAH BAYAR">
                                SUDAH BAYAR
                            </option>
                            <option value="BELUM BAYAR">
                                BELUM BAYAR
                            </option>

                        </select>
                    </div>

                    <div class="form-group">

                        <label for="qty" class="col-form-label">Qty</label>
                        <input type="text" class="form-control" id="qty" name="qty">
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class=" custom-control-input" id="customCheck" name="tanpafoto">
                            <label class="custom-control-label" for="customCheck">Semua</label>
                        </div>
                    </div>

                </div>
                <div class="modal-footer pb-3 pt-3 pr-2">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" name="simpan" id="uploadSubmit">
                </div>
            </form>

        </div>
    </div>
</div>
<!-- Akhir Tambahkan -->

<!-- Modal Tambahkan listpesanan-->
<div class="modal fade" id="add_listpesanan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah List Pesanan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= BASEURL ?>/Listpesanan/tambahlistpesanan" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="customer">Customer</label>
                        <select name="customer" class="form-control selectpicker" data-live-search="true" id="customer">

                            <?php foreach ($data["customers"] as $row) : ?>
                                <option value="<?php echo $row["id_customer"]; ?>">
                                    <?php echo $row["nama_customer"]; ?>

                                </option>

                            <?php endforeach; ?>


                        </select>
                    </div>
                    <div class="form-group">
                        <label for="produk">Produk</label>
                        <select name="produk" class="form-control" id="produk">

                            <?php foreach ($data["produk"] as $row) : ?>
                                <option value="<?php echo $row["id_produk"]; ?>">
                                    <?php echo $row["nama_produk"]; ?>

                                </option>

                            <?php endforeach; ?>


                        </select>
                    </div>

                    <div class="form-group">

                        <label for="qty" class="col-form-label">Qty</label>
                        <input type="text" class="form-control" id="qty" name="qty">
                    </div>
                    <div class="form-group">
                        <label for="datepicker" class="col-form-label">Tanggal Transaksi</label>
                        <input type="text" id="datepicker" class="form-control datepicker" id="tanggal" name="tanggal">
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Deskripsi Transaksi (Opsional)</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="deskripsi"></textarea>
                    </div>

                </div>
                <div class="modal-footer pb-3 pt-3 pr-2">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="simpan">Tambahkan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Akhir Tambahkan -->

<!-- Modal Edit listpesanan-->
<div class="modal fade" id="edit_listpesanan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit List Pesanan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= BASEURL ?>/Listpesanan/editlistpesanan" method="post" enctype="multipart/form-data">
                <div class="modal-body" id="modal-edit">
                    <div class="form-group">
                        <label for="customer">Customer</label>
                        <select name="customer" class="form-control selectpicker" data-live-search="true" id="idcustomer">

                            <?php foreach ($data["customers"] as $row) : ?>
                                <option value="<?php echo $row["id_customer"]; ?>">
                                    <?php echo $row["nama_customer"]; ?>

                                </option>

                            <?php endforeach; ?>


                        </select>
                    </div>
                    <div class="form-group">
                        <label for="produk">Produk</label>
                        <select name="produk" class="form-control" id="produk">

                            <?php foreach ($data["produk"] as $row) : ?>
                                <option value="<?php echo $row["id_produk"]; ?>">
                                    <?php echo $row["nama_produk"]; ?>

                                </option>

                            <?php endforeach; ?>


                        </select>
                    </div>

                    <div class="form-group">
                        <input type="hidden" name="idlistpesanan" id="idlistpesanan">
                        <label for="qty" class="col-form-label">Qty</label>
                        <input type="text" class="form-control" id="qty" name="qty">
                    </div>
                    <div class="form-group">
                        <label for="datepicker" class="col-form-label">Tanggal Transaksi</label>
                        <input type="text" class="form-control datepicker" id="tanggaledit" name="tanggal">
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Deskripsi Transaksi (Opsional)</label>
                        <textarea class="form-control" id="deskripsi" rows="3" name="deskripsi"></textarea>
                    </div>

                </div>
                <div class="modal-footer pb-3 pt-3 pr-2">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="simpan">Perbaharui</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Akhir Edit -->