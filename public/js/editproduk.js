$(document).on("click", "#editcust", function () {
    var idproduk = $(this).data('id');
    var nama = $(this).data('nama');
    var harga = $(this).data('harga');
    var produksiqty = $(this).data('prodqty');
    $("#modal-edit #idproduk").val(idproduk);
    $("#modal-edit #nama").val(nama);
    $("#modal-edit #harga").val(harga);
    $("#modal-edit #produksiqty").val(produksiqty);
})