$(document).on("click", "#approvelist", function () {
    var idlistpesanan = $(this).data('id');
    var qty = $(this).data('qty');
    var idcustomer = $(this).data('customer');
    var idproduk = $(this).data('produk');
    var harga = $(this).data('harga');
    var deskripsi = $(this).data('deskripsi');


    $("#modal-approve #idproduk").val(idproduk);
    $("#modal-approve #idcustomer").val(idcustomer);
    $("#modal-approve #deskripsi").val(deskripsi);

    $("#modal-approve #currentqty").val(qty);
    $("#modal-approve #idlistpesanan").val(idlistpesanan);
    $("#modal-approve #harga").val(harga);

    $(document).ready(function () {
        //set initial state.
        $('#customCheck').val(this.checked);

        $('#customCheck').change(function () {
            if (this.checked) {
                $("#modal-approve #qty").val(qty);
            } else {
                $("#modal-approve #qty").val(null);
            }
        });
    });




})