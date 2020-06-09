$(function () {

    $('.modaltambah').on('click', function () {
        $('#judulmodal').html('Tambah Data Bahan');
        $('.modal-footer button[type=submit]').html('Tambah Data');
        $('#Nama').val('');
        $('.komposisi').show();
    })


    $('.editmodal').on('click', function () {
        $('#judulmodal').html('Ubah Data Bahan');
        $('.modal-footer button[type=submit]').html('Ubah Data');
        $('.modal-body form').attr('action', 'http://localhost/mvckembangteratai/public/Bahan/editdata')
        $('.komposisi').hide();

        const id = $(this).data('id');


        $.ajax({
            url: 'http://localhost/mvckembangteratai/public/Bahan/getubah',
            data: {
                id: id
            },
            method: 'post',
            dataType: 'json',
            success: function (data) {

                $('#Nama').val(data.nama_bahan);

                $('#supplier').val(data.id_supplier).change();

                $('#produk').val(data.id_produk).change();
                $('#oldid').val(data.id_bahan);
            }
        })


    })

    $('.editmodal').on('click', function () {
        $('#judulmodal').html('Ubah Data Bahan');
        $('.modal-footer button[type=submit]').html('Ubah Data');
        $('.modal-body form').attr('action', 'http://localhost/mvckembangteratai/public/Bahan/editdata')
        $('.komposisi').hide();

        const id = $(this).data('id');


        $.ajax({
            url: 'http://localhost/mvckembangteratai/public/Bahan/getubah',
            data: {
                id: id
            },
            method: 'post',
            dataType: 'json',
            success: function (data) {

                $('#Nama').val(data.nama_bahan);

                $('#supplier').val(data.id_supplier).change();

                $('#produk').val(data.id_produk).change();
                $('#oldid').val(data.id_bahan);
            }
        })


    })
})