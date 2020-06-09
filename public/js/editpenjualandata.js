$(document).on("click", "#editpenjdata", function () {
    var idpenjualan = $(this).data('id');
    var idseq = $(this).data('seq');
    var idproduk = $(this).data('idproduk');
    var tanggal = $(this).data('tanggal');
    var produk = $(this).data('produk');
    var qty = $(this).data('qty');
    var oldqty = $(this).data('oldqty');
    $("#modal-edit #idpenjualan").val(idpenjualan);
    $("#modal-edit #seq").val(idseq);
    $("#modal-edit #idproduk").val(idproduk);
    $("#modal-edit #produk").val(produk);
    $("#modal-edit #tanggal").val(tanggal);
    $("#modal-edit #qty").val(qty);
    $("#modal-edit #oldqty").val(oldqty);
})