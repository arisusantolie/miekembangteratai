$(document).on("click", "#editpemb", function () {
    var idpembelian = $(this).data('id');
    var tanggal = $(this).data('tanggal');
    var status = $(this).data('status');

    $("#modal-edit #idpembelian").val(idpembelian);
    $("#modal-edit #tanggal").val(tanggal);
    $("#modal-edit #bukti").val(status);


})