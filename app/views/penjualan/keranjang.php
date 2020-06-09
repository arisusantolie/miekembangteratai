<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Tambahkan Keranjang Penjualan</h1>

    <button class="mt-2 btn btn-primary " data-toggle="modal" data-target="#add_penjualan">Tambahkan Keranjang</button>
    <button class="mt-2 btn btn-danger font-weight-bold" data-toggle="modal" data-target="#add_newpenjualan">Tambahkan Penjualan Baru</button>
    <!-- tes tabel -->
    <!-- DataTales Example -->
    <div class="card shadow mb-4 mt-3">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-danger">Keranjang Belanja <?= $data["customer"]["nama_customer"] ?></h4>
        </div>
        <div class="card-body">
            <div class="table table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID</th>
                            <th>ID SEQ</th>
                            <th>Nama Produk</th>
                            <th>Qty</th>
                            <th>Harga Perunit</th>
                            <th>Sub Total</th>
                            <th>Tanggal</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($data["keranjang"] as $penj) : ?>
                            <tr>
                                <td><?= $i; ?></td>
                                <td><?= $penj["id_penjualan"] ?></td>
                                <td><?= $penj["id_seq"] ?></td>
                                <td><?= $penj["nama_produk"] ?></td>
                                <td><?= $penj["qty"] ?></td>
                                <td><?= Formatrupiah::rupiah($penj["harga_produk"]) ?></td>
                                <td><?= Formatrupiah::rupiah($penj["sub_total"]) ?></td>
                                <td><?= $penj["tanggal_transaksi"] ?></td>
                                <td><a id="editpenjdata" data-toggle="modal" data-target="#edit" data-id="<?= $penj["id_penjualan"]; ?>" data-produk="<?= $penj["nama_produk"]; ?>" data-tanggal="<?= $penj["tanggal_transaksi"]; ?>" data-seq="<?= $penj["id_seq"]; ?>" data-idproduk="<?= $penj["id_produk"]; ?>" data-qty="<?= $penj["qty"]; ?>" data-oldqty="<?= $penj["qty"]; ?>">
                                        <button class="btn btn-primary fas fa-edit mt-1"> Edit</button>
                                    </a> | <a href="<?= BASEURL ?>/Penjualan/DeleteData/<?= $penj["id_penjualan"]; ?>/<?= $penj["id_seq"] ?>/<?= $penj["id_produk"] ?>/<?= $penj["qty"] ?>" onclick=" return confirm('Anda yakin ingin menghapus data ini?')"> <button class="btn btn-primary fas fa-trash-alt mt-1">Hapus</button></a></td>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    </tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<!-- Modal Tambahkan -->
<div class="modal fade" id="add_penjualan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Pembelian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= BASEURL ?>/Penjualan/TambahData" method="post" enctype="multipart/form-data">
                <div class="modal-body">
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
                        <input type="hidden" value="<?= $data["idpenjualan"] ?>" name="idpenjualan">
                        <label for="qty" class="col-form-label">Qty</label>
                        <input type="text" class="form-control" id="qty" name="qty">
                    </div>
                    <div class="form-group">
                        <label for="datepicker" class="col-form-label">Tanggal Transaksi</label>
                        <input type="text" id="datepicker" class="form-control datepicker" id="tanggal" name="tanggal">
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

<!-- Edit Modal -->
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= BASEURL ?>/Penjualan/EditData" method="post">
                <div class="modal-body" id="modal-edit">
                    <input type="hidden" id="idpenjualan" name="idpenjualan">
                    <input type="hidden" id="seq" name="seq">
                    <input type="hidden" id="idproduk" name="idproduk">
                    <input type="hidden" id="oldqty" name="oldqty">
                    <div class="form-group">
                        <label for="produk" class="col-form-label">Produk</label>
                        <input type="text" class="form-control" id="produk" name="produk" disabled>
                    </div>
                    <div class="form-group">
                        <label for="qty" class="col-form-label">Qty</label>
                        <input type="text" class="form-control" id="qty" name="qty">
                    </div>
                    <div class="form-group">
                        <label for="tanggal" class="col-form-label">Tanggal Transaksi</label>
                        <input type="text" id="tanggal" class="form-control datepicker" name="tanggal">

                    </div>
                </div>
                <div class="modal-footer pb-3 pt-3 pr-2">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="edit">Update</button>


                </div>
            </form>
        </div>
    </div>
</div>
<!-- Akhir Edit Modal -->

<!-- Modal Add New Transaksi -->

<!-- Modal Tambahkan -->
<div class="modal fade" id="add_newpenjualan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Transaksi Penjualan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= BASEURL ?>/Penjualan/tambahheader" method="post" enctype="multipart/form-data" id="uploadform">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="customer">Customer</label>
                        <select name="customer" class="form-control selectpicker" data-live-search="true">
                            ?>
                            <?php foreach ($data["customers"] as $row) : ?>
                                <option value="<?php echo $row["id_customer"]; ?>">

                                    <?php echo $row["nama_customer"]; ?>
                                </option>
                            <?php endforeach; ?>


                        </select>


                    </div>
                    <div class="form-group">
                        <label for="datepicker" class="col-form-label">Tanggal Transaksi</label>
                        <input type="text" id="datepicker" class="form-control datepicker" id="tanggal" name="tanggal">
                    </div>
                    <div class="form-group">
                        <label for="bukti">Status Transaksi</label>
                        <select name="status_transaksi" class="form-control" id="bukti">

                            <option value="SUDAH BAYAR">
                                SUDAH BAYAR
                            </option>
                            <option value="BELUM BAYAR">
                                BELUM BAYAR
                            </option>

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Deskripsi Transaksi</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="deskripsi"></textarea>
                    </div>

                    <div class="form-group">
                        <input type="file" id="gambar" name="gambar">
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck" name="tanpafoto">
                            <label class="custom-control-label" for="customCheck">Tanpa Foto</label>
                        </div>
                    </div>

                </div>
                <div class="modal-footer pb-3 pt-3 pr-2">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" name="simpantransaksibaru" id="uploadSubmit">
                </div>
            </form>

        </div>
    </div>
</div>
<!-- Akhir Tambahkan -->