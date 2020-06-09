<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Pembelian</h1>

    <button class="btn btn-primary" data-toggle="modal" data-target="#add_pembelian">Tambahkan Pembelian</button>

    <!-- tes tabel -->
    <!-- DataTales Example -->
    <div class="card shadow mb-4 mt-3">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Pembelian</h6>
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
                            <th>Tanggal</th>
                            <th>Foto</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($data["pembelian"] as $pemb) : ?>
                            <tr>
                                <td><?= $i; ?></td>
                                <td><?= $pemb["ID"] ?></td>
                                <td><?= $pemb["nama_supplier"] ?></td>
                                <?php if ($pemb["status_transaksi"] == 'BELUM BAYAR') : ?>
                                    <td style="color:red;"><?= $pemb["status_transaksi"] ?></td>
                                <?php else : ?>
                                    <td><?= $pemb["status_transaksi"] ?></td>
                                <?php endif; ?>
                                <td><?= Formatrupiah::rupiah($pemb["Total"])  ?></td>
                                <td><?= $pemb["tanggal_transaksi"] ?></td>
                                <?php if ($pemb["bukti_transaksi"] != null) : ?>
                                    <td><img src="<?= BASEURL ?>/img/<?= $pemb["bukti_transaksi"] ?>" alt="Foto Kosong" style="width:75px;"> </td>
                                <?php else : ?>
                                    <td style="width:75px;">Foto Kosong</td>
                                <?php endif; ?>
                                <td><a id="editpemb" data-toggle="modal" data-target="#edit-edit-event" data-id="<?= $pemb["ID"]; ?>" data-tanggal="<?= $pemb["tanggal_transaksi"]; ?>" data-status="<?= $pemb["status_transaksi"]; ?>">
                                        <button class=" btn btn-primary fas fa-edit mt-1">Edit</button>
                                    </a> | <a href="<?= BASEURL . "/Pembelian/keranjang/" . $pemb["ID"]; ?>" onclick="return confirm('Anda yakin ingin menambahkan data Transaksi ini?')"> <button class="btn btn-primary fas fa-plus-square mt-1">ADD</button></a></td>
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
<div class="modal fade" id="add_pembelian" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Pembelian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= BASEURL ?>/Pembelian/tambah" method="post" enctype="multipart/form-data" id="uploadform">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="suppliers">Supplier</label>
                        <select name="suppliers" class="form-control" id="suppliers">

                            <?php foreach ($data["suppliers"] as $row) : ?>
                                <option value="<?php echo $row["id_supplier"]; ?>">
                                    <?php echo $row["nama_supplier"]; ?>

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
<div class="modal" id="edit-edit-event" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Status Pembelian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= BASEURL ?>/Pembelian/edit" method="post" enctype="multipart/form-data">
                <div class="modal-body" id="modal-edit">
                    <input type="hidden" id="idpembelian" name="idpembelian">
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
                        <label for="tanggal" class="col-form-label">Tanggal Transaksi</label>
                        <input type="text" id="tanggal" class="form-control datepicker" id="tanggal" name="tanggal">
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