$(document).on("click", "#tambahproduk", function () {

    $(document).ready(function () {
        //set initial state.
        $('#customCheck').val(this.checked);

        $('#customCheck').change(function () {
            if (this.checked) {
                $("#modal-tambah #produksiqty").val(0);
            } else {
                $("#modal-tambah #produksiqty").val(null);
            }
        });
    });

})