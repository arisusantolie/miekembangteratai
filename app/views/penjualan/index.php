<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Penjualan Produk</h1>

    <button class="btn btn-primary" data-toggle="modal" data-target="#add_penjualan">Tambahkan Transaksi Penjualan</button>

    <!-- tes tabel -->
    <!-- DataTales Example -->
    <div class="card shadow mb-4 mt-3">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Transaksi Penjualan</h6>
        </div>
        <div class="card-body">
            <div class="table table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Status Transaksi</th>
                            <th>Total</th>
                            <th>Tanggal Transaksi</th>
                            <th>Deskripsi</th>
                            <th>Foto</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($data["penjualan"] as $penj) : ?>
                            <tr>
                                <td><?= $i; ?></td>
                                <td><?= $penj["id_penjualan"] ?></td>
                                <td><?= $penj["nama_customer"] ?></td>
                                <?php if ($penj["status_transaksi"] == 'BELUM BAYAR') : ?>
                                    <td style="color:red;"><?= $penj["status_transaksi"] ?></td>
                                <?php else : ?>
                                    <td><?= $penj["status_transaksi"] ?></td>
                                <?php endif; ?>
                                <td><?= Formatrupiah::rupiah($penj["total"]) ?></td>
                                <td><?= $penj["tanggal_transaksi"] ?></td>
                                <td><?= $penj["deskripsi"] ?></td>
                                <?php if ($penj["bukti_transaksi"] != null) : ?>
                                    <td><img src="<?= BASEURL ?>/img/<?= $penj["bukti_transaksi"] ?>" alt="Foto Kosong" style="width:75px;"> </td>
                                <?php else : ?>
                                    <td style="width:75px;">Foto Kosong</td>
                                <?php endif; ?>
                                <td><a id="editpenj" data-toggle="modal" data-target="#edit" data-id="<?= $penj["id_penjualan"]; ?>" data-tanggal="<?= $penj["tanggal_transaksi"]; ?>" data-deskripsi="<?= $penj["deskripsi"]; ?>" data-status="<?= $penj["status_transaksi"]; ?>">
                                        <button class="btn btn-primary fas fa-edit mt-1">Edit</button>
                                    </a> | <a href="Penjualan/keranjang/<?= $penj["id_penjualan"]; ?>" onclick="return confirm('Anda yakin ingin menambahkan data Transaksi ini?')"> <button class="btn btn-primary fas fa-plus-square mt-1">ADD</button></a></td>
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
                    <input type="submit" class="btn btn-primary" name="simpan" id="uploadSubmit">
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
                <h5 class="modal-title" id="exampleModalLabel">Edit Status Penjualan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= BASEURL ?>/Penjualan/editheader" method="post" enctype="multipart/form-data" id="uploadform">
                <div class="modal-body" id="modal-edit">
                    <input type="hidden" id="idpenjualan" name="idpenjualan">
                    <div class="form-group">
                        <label for="bukti">Status Transaksi</label>
                        <select name="status_transaksi" class="form-control" id="buktistatus">

                            <option value="SUDAH BAYAR">
                                SUDAH BAYAR
                            </option>
                            <option value="BELUM BAYAR">BELUM BAYAR</option>

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="tanggal" class="col-form-label">Tanggal Transaksi</label>
                        <input type="text" id="tanggal" class="form-control datepicker" name="tanggal">
                    </div>

                    <div class="form-group">
                        <label for="deskripsi">Deskripsi Transaksi</label>
                        <textarea class="form-control" id="deskripsi" rows="3" name="deskripsi"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="file" id="gambar" name="gambar">
                    </div>


                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customChecks" name="tanpafoto">
                            <label class="custom-control-label" for="customChecks">Tanpa Foto</label>
                        </div>
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