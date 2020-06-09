<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Produksi</h1>

    <button class="btn btn-primary" data-toggle="modal" data-target="#add_produksi">Tambahkan Produksi</button>

    <!-- tes tabel -->
    <!-- DataTales Example -->
    <div class="card shadow mb-4 mt-3">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Produksi</h6>
        </div>
        <div class="card-body">
            <div class="table table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Tanggal</th>
                            <th>Qty</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($data["produksi"] as $pro) : ?>
                            <tr>
                                <td><?= $i; ?></td>
                                <td><?= $pro["id_produksi"] ?></td>
                                <td><?= $pro["nama_produk"] ?></td>
                                <td><?= $pro["waktu_produksi"] ?></td>
                                <td><?= $pro["qty_produksi"] ?></td>
                                <td><a id="editpro" data-toggle="modal" data-target="#edit" data-id="<?= $pro["id_produksi"]; ?>" data-idproduk="<?= $pro["id_produk"]; ?>" data-nama="<?= $pro["nama_produk"]; ?>" data-tanggal="<?= $pro["waktu_produksi"]; ?>" data-qty="<?= $pro["qty_produksi"]; ?>">
                                        <button class="btn btn-primary fas fa-edit mt-1"> Edit</button>
                                    </a> | <a href="<?= BASEURL . "/Produksi/delete/" . $pro["id_produksi"] . "/" . $pro["id_produk"] . "/" . $pro["qty_produksi"] ?> " onclick="return confirm('Anda yakin ingin menghapus data ini?')"> <button class="btn btn-primary fas fa-trash-alt mt-1">Hapus</button></a></td>
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
<div class="modal fade" id="add_produksi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Produksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= BASEURL ?>/Produksi/tambah" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <select name="idproduk" class="form-control">

                            <?php foreach ($data["produk"] as $row) : ?>
                                <option value="<?php echo $row["id_produk"]; ?>">
                                    <?php echo $row["nama_produk"]; ?>

                                </option>
                            <?php endforeach; ?>

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="datepicker" class="col-form-label">Tanggal Produksi</label>
                        <input type="text" id="datepicker" class="form-control datepicker" id="tanggal" name="tanggal">
                    </div>
                    <div class="form-group">
                        <label for="qty" class="col-form-label">Qty Produksi</label>
                        <input type="number" class="form-control" id="qty" name="qty">
                    </div>
                </div>
                <div class="modal-footer pb-3 pt-3 pr-2">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" name="simpan">

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
                <h5 class="modal-title" id="exampleModalLabel">Edit Data Produksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= BASEURL ?>/Produksi/edit" method="post">
                <div class="modal-body" id="modal-edit">
                    <input type="hidden" id="idproduksi" name="idproduksi">
                    <input type="hidden" id="oldqty" name="oldqty">
                    <input type="hidden" id="idproduk" name="idproduk">
                    <div class="form-group">
                        <label for="produk" class="col-form-label">Produk</label>
                        <input type="text" class="form-control" id="produk" name="produk" disabled>
                    </div>
                    <div class="form-group">
                        <label for="qty" class="col-form-label">Qty</label>
                        <input type="text" class="form-control" id="qty" name="qty">
                    </div>
                    <div class="form-group">
                        <label for="tanggal" class="col-form-label">Tanggal</label>
                        <input type="text" class="form-control datepicker" id="tanggal" name="tanggal">
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