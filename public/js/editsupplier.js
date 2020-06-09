$(document).on("click", "#editcust", function () {
    var idsupplier = $(this).data('id');
    var nama = $(this).data('nama');
    var nohp = $(this).data('nohp');
    $("#modal-edit #idsupplier").val(idsupplier);
    $("#modal-edit #nama").val(nama);
    $("#modal-edit #nohp").val(nohp);
})