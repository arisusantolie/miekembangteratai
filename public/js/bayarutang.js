$(document).on("click", "#bayarutang", function () {
    var idcustomer = $(this).data('id');
    console.log(idcustomer);
    $("#modal-bayar #idcustomer").val(idcustomer);

})