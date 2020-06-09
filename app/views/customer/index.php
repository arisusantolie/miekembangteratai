<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Customers</h1>

    <button class="btn btn-primary" data-toggle="modal" data-target="#add_project">Tambahkan Data</button>

    <!-- tes tabel -->
    <!-- DataTales Example -->
    <div class="card shadow mb-4 mt-3">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Customers</h6>
        </div>
        <div class="card-body">
            <div class="table table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>No Hp</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($data["customers"] as $cust) : ?>
                            <tr>
                                <td><?= $i; ?></td>
                                <td><?= $cust["id_customer"] ?></td>
                                <td><?= $cust["nama_customer"] ?></td>
                                <td><?= $cust["alamat"] ?></td>
                                <td><?= $cust["no_hp"] ?></td>
                                <td><a id="editcust" data-toggle="modal" data-target="#edit" data-id="<?= $cust["id_customer"]; ?>" data-nama="<?= $cust["nama_customer"]; ?>" data-alamat="<?= $cust["alamat"]; ?>" data-nohp="<?= $cust["no_hp"]; ?>">
                                        <button class="btn btn-primary fas fa-edit mt-1"> Edit</button>
                                    </a> | <a href="<?= BASEURL . "/Customer/delete/" . $cust["id_customer"]; ?>" onclick="return confirm('Anda yakin ingin menghapus data ini?')"> <button class="btn btn-primary fas fa-trash-alt mt-1">Hapus</button></a></td>
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
<div class="modal fade" id="add_project" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= BASEURL ?>/Customer/tambah" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="Nama" class="col-form-label">Nama</label>
                        <input type="text" class="form-control" id="Nama" name="nama">
                    </div>
                    <div class="form-group">
                        <label for="alamat" class="col-form-label">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat">
                    </div>
                    <div class="form-group">
                        <label for="nohp" class="col-form-label">No Handphone</label>
                        <input type="text" class="form-control" id="nohp" name="nohp">
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
                <h5 class="modal-title" id="exampleModalLabel">Edit Data Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= BASEURL ?>/Customer/edit" method="post">
                <div class="modal-body" id="modal-edit">
                    <input type="hidden" id="idcustomer" name="idcustomer">
                    <div class="form-group">
                        <label for="nama" class="col-form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama">
                    </div>
                    <div class="form-group">
                        <label for="alamat" class="col-form-label">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat">
                    </div>
                    <div class="form-group">
                        <label for="nohp" class="col-form-label">No Handphone</label>
                        <input type="text" class="form-control" id="nohp" name="nohp">
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