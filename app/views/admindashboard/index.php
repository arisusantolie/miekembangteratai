       <!-- Begin Page Content -->
       <div class="container-fluid">

           <!-- Page Heading -->
           <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>


           <button class="mt-2 mb-2 btn btn-danger font-weight-bold" data-toggle="modal" data-target="#add_listpesanan">Tambah LIST PESANAN</button>

           <div class="row">

               <!-- Earnings (Monthly) Card Example -->
               <div class="col-xl-3 col-md-6 mb-4">
                   <div class="card border-left-primary shadow h-100 py-2">
                       <div class="card-body">
                           <div class="row no-gutters align-items-center">
                               <div class="col mr-2">
                                   <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">PENJUALAN (BULAN)</div>
                                   <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <?= formatrupiah::rupiah($data["penjualanmonthly"]["total"]); ?></div>
                               </div>
                               <div class="col-auto">
                                   <i class="fas fa-calendar fa-2x text-gray-300"></i>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>

               <!-- PEMBELIAN (Monthly) Card Example -->
               <div class="col-xl-3 col-md-6 mb-4">
                   <div class="card border-left-success shadow h-100 py-2">
                       <div class="card-body">
                           <div class="row no-gutters align-items-center">
                               <div class="col mr-2">
                                   <div class="text-xs font-weight-bold text-success text-uppercase mb-1">PEMBELIAN (BULAN)</div>
                                   <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <?= formatrupiah::rupiah($data["pembelianmonthly"]["total"])  ?></div>
                               </div>
                               <div class="col-auto">
                                   <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>


               <!-- SUDAH BAYAR DALAM 1 Bulan Card Example -->
               <div class="col-xl-3 col-md-6 mb-4">
                   <div class="card border-left-primary shadow h-100 py-2">
                       <div class="card-body">
                           <div class="row no-gutters align-items-center">
                               <div class="col mr-2">
                                   <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">SUDAH BAYAR (BULAN)</div>
                                   <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <?= formatrupiah::rupiah($data["sudahbayar"]["total"])  ?></div>
                               </div>
                               <div class="col-auto">
                                   <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>

               <!-- BELUM BAYAR DALAM 1 Bulan Card Example -->
               <div class="col-xl-3 col-md-6 mb-4">
                   <div class="card border-left-danger shadow h-100 py-2">
                       <div class="card-body">
                           <div class="row no-gutters align-items-center">
                               <div class="col mr-2">
                                   <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">BELUM BAYAR (BULAN)</div>
                                   <?php if ($data["check"] > 0) : ?>
                                       <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <?= formatrupiah::rupiah($data["belumbayar"]["total"])  ?></div>
                                   <?php else : ?>
                                       <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. 0</div>
                                   <?php endif; ?>



                               </div>
                               <div class="col-auto">
                                   <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>

           </div>

           <div class="row">

               <!-- Area Chart -->
               <div class="col-xl-8 col-lg-7">
                   <div class="card shadow mb-4">
                       <!-- Card Header - Dropdown -->
                       <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                           <h6 class="m-0 font-weight-bold text-primary">Grafik Penjualan</h6>
                       </div>
                       <!-- Card Body -->
                       <div class="card-body">
                           <div class="chart-area">
                               <canvas id="myAreaChart"></canvas>
                           </div>
                       </div>
                   </div>
               </div>


               <!-- BELUM BAYAR DALAM 1 Bulan Card Example -->
               <div class="col-xl-4 col-md-6 mb-4">
                   <div class="card border-left-success shadow h-100 py-2">
                       <div class="card-body">
                           <div class="row no-gutters align-items-center">

                               <div class="col mr-2">
                                   <!-- produksi -->
                                   <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Produksi (Hari)</div>
                                   <?php if ($data["produksi"]["total"] != null) : ?>
                                       <div class="h5 mb-0 font-weight-bold text-gray-800">Total : <?= $data["produksi"]["total"] ?></div>
                                   <?php else : ?>
                                       <div class="h5 mb-0 font-weight-bold text-gray-800">Total : 0</div>
                                   <?php endif; ?>


                                   <!-- produk -->
                                   <div class="text-xs font-weight-bold text-success text-uppercase mb-1 mt-3">Produk</div>
                                   <?php foreach ($data["produk"] as $pro) : ?>
                                       <div class="p mb-0 font-weight-bold-200 text-gray-800">Nama : <?= $pro["nama_produk"] ?></div>
                                       <div class="p mb-0 font-weight-bold text-gray-800">Total : <?= $pro["stok"] ?></div>
                                   <?php endforeach; ?>

                                   <!-- bahan -->
                                   <div class="text-xs font-weight-bold text-success text-uppercase mb-1 mt-3">Bahan</div>
                                   <?php foreach ($data["bahan"] as $bah) : ?>
                                       <div class="p mb-0 font-weight-bold-200 text-gray-800">Nama : <?= $bah["nama_bahan"] ?></div>
                                       <div class="p mb-0 font-weight-bold text-gray-800">Total : <?= $bah["total_stok"] ?></div>
                                   <?php endforeach; ?>
                               </div>

                           </div>
                       </div>
                   </div>
               </div>


           </div>

           <!-- /.container-fluid -->
       </div>
       <!-- End of Main Content -->

       <!-- Modal Tambahkan -->
       <div class="modal fade" id="add_listpesanan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
           <div class="modal-dialog" role="document">
               <div class="modal-content">
                   <div class="modal-header">
                       <h5 class="modal-title" id="exampleModalLabel">Tambah List Pesanan</h5>
                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                       </button>
                   </div>
                   <form action="<?= BASEURL ?>/Adminhome/tambahlistpesanan" method="post" enctype="multipart/form-data">
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