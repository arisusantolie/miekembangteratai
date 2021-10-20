<?php
if ($_SESSION["role"] != "ADMIN") {
    echo "<script>
    window.location.href='" . BASEURL . "/Listpesanan'
    </script>";
    exit;
}
?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Produk</h1>

    <button class="btn btn-primary" id="tambahproduk" data-toggle="modal" data-target="#add_produk">Tambahkan Data</button>

    <!-- tes tabel -->
    <!-- DataTales Example -->
    <div class="card shadow mb-4 mt-3">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Produk</h6>
        </div>
        <div class="card-body">
            <div class="table table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Stok</th>

                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($data["produk"] as $pro) : ?>
                            <tr>
                                <td><?= $i; ?></td>
                                <td><?= $pro["id_produk"] ?></td>
                                <td><?= $pro["nama_produk"] ?></td>
                                <td><?= $pro["harga_produk"] ?></td>
                                <td><?= $pro["stok"] ?></td>

                                <td><a id="editcust" data-toggle="modal" data-target="#edit" data-id="<?= $pro["id_produk"]; ?>" data-nama="<?= $pro["nama_produk"]; ?>" data-harga="<?= $pro["harga_produk"]; ?>" data-prodqty="<?= $pro["produksi_qty"]; ?>">
                                        <button class="btn btn-primary btn-sm fas fa-edit mt-1"> Edit</button>
                                    </a> | <a href="<?= BASEURL . "/Produk/produkdelete/" . $pro["id_produk"]; ?>" onclick="return confirm('Anda yakin ingin menghapus data ini?')"> <button class="btn btn-primary btn-sm fas fa-trash-alt mt-1">Hapus</button></a></td>
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
<div class="modal fade" id="add_produk" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= BASEURL ?>/Produk/ProdukInsert" method="post">
                <div class="modal-body" id="modal-tambah">
                    <div class="form-group">
                        <label for="Nama" class="col-form-label">Nama Produk</label>
                        <input type="text" class="form-control" id="Nama" name="nama">
                    </div>
                    <div class="form-group">
                        <label for="harga" class="col-form-label">Harga</label>
                        <input type="text" class="form-control" id="harga" name="harga">
                    </div>
                    <div class="form-group">
                        <label for="produksiqty" class="col-form-label">Qty Tiap 1 Produksi</label>
                        <input type="text" class="form-control" id="produksiqty" name="produksiqty">
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class=" custom-control-input" id="customCheck" name="tanpaproduksi">
                            <label class="custom-control-label" for="customCheck">Tanpa Produksi</label>
                        </div>
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
                <h5 class="modal-title" id="exampleModalLabel">Edit Data produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= BASEURL ?>/Produk/produkedit" method="post">
                <div class="modal-body" id="modal-edit">
                    <input type="hidden" id="idproduk" name="idproduk">
                    <div class="form-group">
                        <label for="nama" class="col-form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama">
                    </div>
                    <div class="form-group">
                        <label for="harga" class="col-form-label">Harga</label>
                        <input type="text" class="form-control" id="harga" name="harga">
                    </div>
                    <div class="form-group">
                        <label for="produksiqty" class="col-form-label">Qty Tiap 1 Produksi</label>
                        <input type="text" class="form-control" id="produksiqty" name="produksiqty">
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