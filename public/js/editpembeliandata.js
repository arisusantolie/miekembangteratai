$(document).on("click", "#editpembdata", function () {
    var idpembelian = $(this).data('id');
    var idseq = $(this).data('seq');
    var nama = $(this).data('nama');
    var qty = $(this).data('qty');
    var harga = $(this).data('harga');
    var idbahan = $(this).data('idbahan');
    var oldqty = $(this).data('oldqty');
    $("#modal-edit #idpembelian").val(idpembelian);
    $("#modal-edit #seq").val(idseq);
    $("#modal-edit #bahan").val(nama);
    $("#modal-edit #qty").val(qty);
    $("#modal-edit #harga").val(harga);
    $("#modal-edit #idbahan").val(idbahan);
    $("#modal-edit #oldqty").val(oldqty);
})