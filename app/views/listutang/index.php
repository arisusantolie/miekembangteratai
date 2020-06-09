<?php

?>

<div class="col-sm-12">
  <h1>List Utang Pelanggan</h1>

  <?php $no = 1; ?>
  <?php foreach ($data["customers"] as $row) : ?>
    <div class="card mb-1" style="width: 100%">
      <ul class="list-group list-group-flush">
        <a href="<?= BASEURL ?>/Listutang/utang/<?= $row["id_customer"] ?>">
          <li class="list-group-item"><?= $row["nama_customer"] ?></li>
        </a>
      </ul>
    </div>
    <?php $no++ ?>
  <?php endforeach; ?>



</div>