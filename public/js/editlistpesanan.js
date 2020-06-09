$(document).on("click", "#editlistpesanan", function () {
    var idcustomer = $(this).data('customer');
    var idlistpesanan = $(this).data('id');
    var idproduk = $(this).data('produk');
    var qty = $(this).data('qty');
    var tanggal = $(this).data('tanggal');
    var deskripsi = $(this).data('deskripsi');

    console.log(tanggal);
    $("#modal-edit #idcustomer").val(idcustomer).change();
    $("#modal-edit #produk").val(idproduk);
    $("#modal-edit #idlistpesanan").val(idlistpesanan);
    $("#modal-edit #qty").val(qty);
    $("#modal-edit #tanggaledit").val(tanggal);
    $("#modal-edit #deskripsi").val(deskripsi);


})