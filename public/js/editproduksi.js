$(document).on("click", "#editpro", function () {
    var idproduksi = $(this).data('id');
    var idproduk = $(this).data('idproduk');
    var nama = $(this).data('nama');
    var tanggal = $(this).data('tanggal');
    var qty = $(this).data('qty');
    var oldqty = $(this).data('qty');
    $("#modal-edit #idproduksi").val(idproduksi);
    $("#modal-edit #idproduk").val(idproduk);
    $("#modal-edit #produk").val(nama);
    $("#modal-edit #tanggal").val(tanggal);
    $("#modal-edit #qty").val(qty);
    $("#modal-edit #oldqty").val(oldqty);
})