<div class="col-sm-12">
    <h2>Daftar Utang</h2>
    <h2 style="color:blue"><?= $data["namacustomer"]["nama_customer"] ?></h2>

    <div class="table-responsive-sm">

        <table class="table table-dark">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Produk</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Total</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php $total = 0;
                $no = 1; ?>

                <?php foreach ($data["utangcustomer"] as $row) : ?>
                    <tr>
                        <th scope="row"><?= $no ?></th>
                        <td><?= $row["nama_produk"] ?></td>
                        <td><?= $row["tanggal_transaksi"] ?></td>
                        <td><?= "Rp. " . Formatrupiah::rupiah($row["total"])  ?></td>
                        <td><?= $row["status_transaksi"] ?></td>
                    </tr>
                    <?php $total += $row["total"];
                    $no++; ?>
                <?php endforeach; ?>

            </tbody>
        </table>


        <div class="col-lg-10 col-sm-2 text-right">
            <h5 style="color:black">Total Utang : <?= "Rp. " . Formatrupiah::rupiah($total)  ?></h5>
        </div>
    </div>


    <div class="table-responsive-sm">

        <table class="table table-dark">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nominal</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Status</th>
                    <th scope="col">Diterima</th>
                </tr>
            </thead>
            <tbody>
                <?php $totalbayar = 0;
                $urut = 1; ?>
                <?php foreach ($data["bayarcustomer"] as $row) : ?>
                    <tr>
                        <th scope="row"><?= $urut ?></th>
                        <td><?= $row["nominal"] ?></td>
                        <td><?= $row["tanggal"] ?></td>
                        <td><?= $row["status"] ?></td>
                        <td><?= $row["penerima"] ?></td>
                    </tr>
                    <?php $totalbayar += $row["nominal"];
                    $urut++; ?>
                <?php endforeach; ?>

            </tbody>
        </table>


        <div class="col-lg-10 col-sm-2 text-right">
            <h5 style="color:black">Total Bayar : Rp. <?= Formatrupiah::rupiah($totalbayar) ?></h5>
        </div>
    </div>
    <div class="col-lg-10 col-sm-2 text-right">
        <h5 style="color:red">Sisa Utang : Rp. <?= Formatrupiah::rupiah($total - $totalbayar) ?></h5>
    </div>
    <div class="text-center mb-3 mt-3">
        <button type="button" id="bayarutang" data-toggle="modal" data-target="#add_pembayaran" data-id="<?= $data["utangcustomer"][0]["id_customer"] ?>" class="btn btn-success">Tambah Pembayaran</button>
    </div>
</div>


<!-- Modal Tambahkan -->
<div class="modal fade" id="add_pembayaran" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Transaksi Penjualan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= BASEURL ?>/Listutang/bayar" method="post" enctype="multipart/form-data" id="uploadform" name="form1">
                <div class="modal-body" id="modal-bayar">

                    <div class="form-group">
                        <label for="datepicker" class="col-form-label">Tanggal Transaksi</label>
                        <input type="text" id="datepicker" class="form-control datepicker" id="tanggal" name="tanggal">
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="idcustomer" id="idcustomer">
                        <label for="nominal" class="col-form-label">Nominal</label>
                        <input type="text" class="form-control" id="nominal" name="nominal">
                    </div>

                </div>
                <div class="modal-footer pb-3 pt-3 pr-2">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" name="simpan" id="uploadSubmit" onclick="return confirm('Anda yakin ingin Menambah Pembayaran Rp. '.concat(document.form1.nominal.value))">
                </div>
            </form>

        </div>
    </div>
</div>
<!-- Akhir Tambahkan -->