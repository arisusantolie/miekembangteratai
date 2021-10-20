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
    <h1 class="h3 mb-4 text-gray-800">Bahan</h1>

    <button class="btn btn-primary modaltambah" data-toggle="modal" data-target="#formmodal">Tambahkan Data</button>

    <!-- tes tabel -->
    <!-- DataTales Example -->
    <div class="card shadow mb-4 mt-3">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Bahan</h6>
        </div>
        <div class="card-body">
            <div class="table table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Supplier</th>
                            <th>Stok</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($data["bahan"] as $bah) : ?>
                            <tr>
                                <td><?= $i; ?></td>
                                <td><?= $bah["id_bahan"] ?></td>
                                <td><?= $bah["nama_bahan"] ?></td>
                                <td><?= $bah["nama_supplier"] ?></td>
                                <td><?= $bah["total_stok"] ?></td>
                                <td>
                                    <a href="<?= BASEURL . "/Bahan/getubah/" . $bah["id_bahan"] ?>" class="btn btn-primary editmodal btn-sm fas fa-edit mt-1 " data-toggle="modal" data-id="<?= $bah["id_bahan"]  ?>" data-target=" #formmodal"> Edit </a>
                                    | <a href="<?= BASEURL . "/Bahan/deletebahan/" . $bah["id_bahan"]; ?>" onclick="return confirm('Anda yakin ingin menghapus data ini?')"> <button class="btn btn-primary btn-sm fas fa-trash-alt mt-1">Hapus</button></a></td>
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
<div class="modal fade" id="formmodal" tabindex="-1" role="dialog" aria-labelledby="judulmodal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="judulmodal">Tambah Data bahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= BASEURL ?>/Bahan/Addbahan" method="post">

                    <div class="form-group">
                        <input type="hidden" name="oldid" id="oldid">
                        <label for="Nama" class="col-form-label">Nama bahan</label>
                        <input type="text" class="form-control" id="Nama" name="nama">
                    </div>
                    <div class="form-group">
                        <label for="supplier">Supplier</label>
                        <select name="supplier" class="form-control selectpicker" id="supplier" data-live-search="true">
                            <?php foreach ($data["supplier"] as $supplier) : ?>
                                <option value="<?php echo $supplier["id_supplier"]; ?>">
                                    <?php echo $supplier["nama_supplier"]; ?>

                                </option>
                            <?php endforeach; ?>


                        </select>
                    </div>
                    <div class="form-group">
                        <label for="produk">Produk</label>
                        <select name="produk" class="form-control selectpicker" id="produk" data-live-search="true">

                            <?php foreach ($data["produk"] as $pro) : ?>
                                <option value="<?php echo $pro["id_produk"]; ?>">
                                    <?php echo $pro["nama_produk"]; ?>

                                </option>

                            <?php endforeach; ?>


                        </select>
                    </div>
                    <div class="form-group komposisi">
                        <label for="komposisi" class="col-form-label">Komposisi Penggunaan</label>
                        <input type="text" class="form-control" id="komposisi" name="komposisi">
                    </div>
            </div>
            <div class="modal-footer pb-3 pt-3 pr-2">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="simpan">Tambah Data</button>


            </div>
            </form>
        </div>
    </div>
</div>
<!-- Akhir Tambahkan -->