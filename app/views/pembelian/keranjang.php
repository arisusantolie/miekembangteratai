<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Tambahkan Keranjang Bahan</h1>

    <button class="btn btn-primary mt-2" data-toggle="modal" data-target="#add_pembelian">Tambah Keranjang Bahan</button>
    <button class="btn btn-success mt-2" data-toggle="modal" data-target="#add_pembelian_produk">Tambah Keranjang Produk</button>

    <!-- tes tabel -->
    <!-- DataTales Example -->
    <div class="card shadow mb-4 mt-3">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Pembelian Bahan</h6>
        </div>
        <div class="card-body">
            <div class="table table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID</th>
                            <th>Nama Bahan</th>
                            <th>ID SEQ</th>
                            <th>Qty</th>
                            <th>Harga Perunit</th>
                            <th>Sub Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>

                        <?php foreach ($data["keranjang"] as $pemb) : ?>
                            <tr>
                                <td><?= $i; ?></td>
                                <td><?= $pemb["id_pembelian"] ?></td>
                                <td><?= $pemb["nama_bahan"] ?></td>
                                <td><?= $pemb["id_Seq"] ?></td>
                                <td><?= $pemb["qty"] ?></td>
                                <td><?= Formatrupiah::rupiah($pemb["harga_perunit"]) ?></td>
                                <td><?= Formatrupiah::rupiah($pemb["sub_total"]) ?></td>
                                <td><a id="editpembdata" data-toggle="modal" data-target="#edit" data-id="<?= $pemb["id_pembelian"]; ?>" data-seq="<?= $pemb["id_Seq"]; ?>" data-nama="<?= $pemb["nama_bahan"]; ?>" data-qty="<?= $pemb["qty"]; ?>" data-harga="<?= $pemb["harga_perunit"]; ?>" data-idbahan="<?= $pemb["id_bahan"]; ?>" data-oldqty="<?= $pemb["qty"]; ?>">
                                        <button class="btn btn-primary fas fa-edit mt-1"> Edit</button>
                                    </a> | <a href="<?= BASEURL ?>/Pembelian/delete/<?= $pemb["id_pembelian"]; ?>/<?= $pemb["id_Seq"] ?>/<?= $pemb["id_bahan"] ?>/<?= $pemb["qty"] ?>" onclick=" return confirm('Anda yakin ingin menghapus data ini?')"> <button class="btn btn-primary fas fa-trash-alt mt-1">Hapus</button></a></td>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    </tbody>
                    <tbody>


                        <?php foreach ($data["keranjangproduk"] as $pemb) : ?>
                            <tr>
                                <td><?= $i; ?></td>
                                <td><?= $pemb["id_pembelian"] ?></td>
                                <td><?= $pemb["nama_produk"] ?></td>
                                <td><?= $pemb["id_Seq"] ?></td>
                                <td><?= $pemb["qty"] ?></td>
                                <td><?= Formatrupiah::rupiah($pemb["harga_perunit"]) ?></td>
                                <td><?= Formatrupiah::rupiah($pemb["sub_total"]) ?></td>
                                <td><a id="editpembdata" data-toggle="modal" data-target="#edit" data-id="<?= $pemb["id_pembelian"]; ?>" data-seq="<?= $pemb["id_Seq"]; ?>" data-nama="<?= $pemb["nama_produk"]; ?>" data-qty="<?= $pemb["qty"]; ?>" data-harga="<?= $pemb["harga_perunit"]; ?>" data-idbahan="<?= $pemb["id_bahan"]; ?>" data-oldqty="<?= $pemb["qty"]; ?>">
                                        <button class="btn btn-primary fas fa-edit mt-1"> Edit</button>
                                    </a> | <a href="<?= BASEURL ?>/Pembelian/delete/<?= $pemb["id_pembelian"]; ?>/<?= $pemb["id_Seq"] ?>/<?= $pemb["id_bahan"] ?>/<?= $pemb["qty"] ?>" onclick=" return confirm('Anda yakin ingin menghapus data ini?')"> <button class="btn btn-primary fas fa-trash-alt mt-1">Hapus</button></a></td>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
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
            <form action="<?= BASEURL ?>/Pembelian/Tambahkeranjang" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="bahan">Bahan</label>
                        <select name="bahan" class="form-control" id="bahan">

                            <?php foreach ($data["listbahansupplier"] as $row) : ?>
                                <option value="<?php echo $row["id_bahan"]; ?>">
                                    <?php echo $row["nama_bahan"]; ?>

                                </option>

                            <?php endforeach; ?>

                        </select>
                    </div>

                    <div class="form-group">
                        <input type="hidden" value="<?= $data["idpembelian"] ?>" name="idpembelian">
                        <label for="qty" class="col-form-label">Qty</label>
                        <input type="text" class="form-control" id="qty" name="qty">
                    </div>
                    <div class="form-group">
                        <label for="harga" class="col-form-label">Harga Per Qty</label>
                        <input type="text" class="form-control" id="harga" name="harga">
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


<!-- Modal Tambahkan -->
<div class="modal fade" id="add_pembelian_produk" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Pembelian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= BASEURL ?>/Pembelian/TambahkeranjangProduk" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="Produk">Produk</label>
                        <select name="produk" class="form-control" id="produk">

                            <?php foreach ($data["produk"] as $row) : ?>
                                <option value="<?php echo $row["id_produk"]; ?>">
                                    <?php echo $row["nama_produk"]; ?>

                                </option>

                            <?php endforeach; ?>

                        </select>
                    </div>

                    <div class="form-group">
                        <input type="hidden" value="<?= $data["idpembelian"] ?>" name="idpembelian">
                        <label for="qty" class="col-form-label">Qty</label>
                        <input type="text" class="form-control" id="qty" name="qty">
                    </div>
                    <div class="form-group">
                        <label for="harga" class="col-form-label">Harga Per Qty</label>
                        <input type="text" class="form-control" id="harga" name="harga">
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
            <form action="<?= BASEURL ?>/Pembelian/editpembeliandata" method="post">
                <div class="modal-body" id="modal-edit">
                    <input type="hidden" id="idpembelian" name="idpembelian">
                    <input type="hidden" id="seq" name="seq">
                    <input type="hidden" id="idbahan" name="idbahan">
                    <input type="hidden" id="oldqty" name="oldqty">
                    <div class="form-group">
                        <label for="bahan" class="col-form-label">Bahan</label>
                        <input type="text" class="form-control" id="bahan" name="bahan" disabled>
                    </div>
                    <div class="form-group">
                        <label for="qty" class="col-form-label">Qty</label>
                        <input type="text" class="form-control" id="qty" name="qty">
                    </div>
                    <div class="form-group">
                        <label for="harga" class="col-form-label">Harga</label>
                        <input type="text" class="form-control" id="harga" name="harga">
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