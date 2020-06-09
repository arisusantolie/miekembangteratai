$(document).on("click", "#editcust", function () {
    var idcustomer = $(this).data('id');
    var nama = $(this).data('nama');
    var alamat = $(this).data('alamat');
    var nohp = $(this).data('nohp');
    $("#modal-edit #idcustomer").val(idcustomer);
    $("#modal-edit #nama").val(nama);
    $("#modal-edit #alamat").val(alamat);
    $("#modal-edit #nohp").val(nohp);
})