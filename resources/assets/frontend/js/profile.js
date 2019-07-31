if ($('#profile').length) {
    $(function () {
        $('.btn-auto-setting').on('click', function () {
            let productId = $(this).data('target-id');
            $('#modal-auto-setting input[name=target_id]').val(productId);
            // console.log('ahihihi', productId);
        });
        $('#modal-auto-setting .btn-primary').on('click', function () {
            if (!$('#target_id').val() || !$('#refresh_times').val()) {
                return false;
            }
            let productId = $('#target_id').val();
            let refresh_times = $('#refresh_times').val();
            axios
                .post('/product/' + productId + '/set_auto', {
                    auto_refresh: refresh_times
                })
                .then(resp => {
                    if (resp.data.status) {
                        window.location.reload(true);
                    } else {
                        alert(resp.data.message);
                    }
                })
                .catch(err => {
                    alert("Số lần làm mới tự động không hợp lệ.");
                });
            return false;
        });
        $('#refresh_times').on('keyup change click', function () {
            let times = $('#refresh_times').val();
            let totalMoney = 0;
            if ($.isNumeric(times) && times > 0) {
                totalMoney = times * 5000;
            } else {
                alert('Vui lòng chọn số lần làm mới hợp lệ.');
                $('#refresh_times').val(0);
            }
            $('#modal-auto-setting .totalRefreshPrice').html($.number(totalMoney, 0));
        });
    });
}
$('.btn-use-gift-code').on('click', function () {
    $('#modal-gift-code .error').html('');
});
$('#modal-gift-code .btn-primary').on('click', function () {
   let giftCode = $('#modal-gift-code input[name=gift_code]').val();
   if (!giftCode) {
       $('#modal-gift-code .error').html('Bạn chưa nhập code.');
       return false;
   } else {
       $('#modal-gift-code .error').html('');
   }
    axios
        .post('/valid-code', {
            giftCode: giftCode
        })
        .then(resp => {
            if (resp.data.status) {
                window.location.reload(true);
            } else {
                // alert(resp.data.message);
                $('#modal-gift-code .error').html(resp.data.message);
            }
        })
        .catch(err => {
            $('#modal-gift-code .error').html('Có lỗi xảy ra. Vui lòng kiểm tra lại.');
        });
    return false;
});