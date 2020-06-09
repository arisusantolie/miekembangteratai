$(document).on("click", "#editpenj", function () {
    var idpenjualan = $(this).data('id');
    var tanggal = $(this).data('tanggal');
    var deskripsi = $(this).data('deskripsi');
    var status = $(this).data('status');


    $("#modal-edit #idpenjualan").val(idpenjualan);
    $("#modal-edit #tanggal").val(tanggal);
    $("#modal-edit #deskripsi").val(deskripsi);
    $("#modal-edit #buktistatus").val(status);

})