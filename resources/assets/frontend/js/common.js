import Axios from 'axios';

// var subscribeCaptchaID;

// window.recaptchaApiLoaded = function() {
    // subscribeCaptchaID = grecaptcha.render(document.getElementById('subscribe-recaptcha'), {
    //     callback: window.subscribeCaptchaCallback,
    //     'expired-callback': window.subscribeCaptchaErrorCallback
    // });
    // var recaptchas = document.querySelectorAll('div[class=g-recaptcha]');
    //
    // for(let i = 0; i < recaptchas.length; i++) {
    //     // console.log($('#' + recaptchas[i].id).data('sitekey'), i);
    //     grecaptcha.render( recaptchas[i].id, {
    //         callback: window.subscribeCaptchaCallback,
    //         'expired-callback': window.subscribeCaptchaErrorCallback,
    //         'sitekey': $('#' + recaptchas[i].id).data('sitekey')
    //     });
    // }
// };
// window.resetSubscribeCaptcha = function() {
    // grecaptcha.reset(subscribeCaptchaID);
// };

// window.subscribeCaptchaCallback = function(token) {
//     window.subscribe_recaptcha_token = token;
// };
// window.subscribeCaptchaErrorCallback = function() {
//     window.subscribe_recaptcha_token = '';
// };

window.cityLatLngs = {"BG":[21.333333,106.333333],"BK":[22.166667,105.833333],"CB":[22.6665,106.2586],"HG":[22.75,105],"LS":[21.75,106.5],"PT":[21.333333,105.166667],"QNI":[21.2523,107.3323],"TN":[21.666667,105.833333],"TQ":[21.666667,105.833333],"LCA":[22.333333,104],"YB":[21.5,104.666667],"DDB":[21.383333,103.016667],"HB":[20.333333,105.25],"LCH":[22,103],"SL":[21.166667,104],"BN":[21.083333,106.166667],"HNA":[20.583333,106],"HD":[20.916667,106.333333],"HY":[20.833333,106.083333],"ND":[20.25,106.25],"NB":[20.25,105.833333],"TB":[20.5,106.333333],"VP":[21.3,105.6],"HN":[21.028472,105.854167],"HP":[20.8614,106.6525],"HT":[18.333333,105.9],"NA":[19.333333,104.833333],"QB":[17.5,106.333333],"QT":[16.75,107],"TH":[20,105.5],"TTH":[16.333333,107.583333],"DDL":[12.666667,108.05],"DNO":[11.983333,107.7],"GL":[13.75,108.25],"KT":[14.75,107.916667],"LDD":[11.95,108.433333],"BDD":[14.166667,109],"BTH":[10.933333,108.1],"KH":[12.25,109.2],"NT":[11.75,108.833333],"PY":[13.166667,109.166667],"QNA":[15.583333,107.916667],"QNG":[15,108.666667],"DDN":[16.066667,108.233333],"VT":[10.583333,107.25],"BD":[11.166667,106.666667],"BP":[11.75,106.916667],"DNA":[11.116667,107.183333],"TNI":[11.333333,106.166667],"SG":[10.7753,106.7020],"AG":[10.5,105.166667],"BL":[9.25,105.75],"BTR":[10.166667,106.5],"CM":[9.083333,105.083333],"DDT":[10.666667,105.666667],"HGI":[9.783333,105.466667],"KG":[10,105.166667],"LA":[10.666667,106.166667],"ST":[9.666667,105.833333],"TG":[10.416667,106.166667],"TV":[9.833333,106.25],"VL":[10.166667,106],"CT":[10.033333,105.783333]};
var modalVerifyPhone = $('#modal-verify-phone');

// Sticky navbar
// =========================
$(document).ready(function() {
    // Custom function which toggles between sticky class (is-sticky)
    var stickyToggle = function(sticky, stickyWrapper, scrollElement) {
        var stickyHeight = sticky.outerHeight();
        var stickyTop = stickyWrapper.offset().top;
        if (scrollElement.scrollTop() >= stickyTop) {
            stickyWrapper.height(stickyHeight);
            sticky.addClass('is-sticky');
        } else {
            sticky.removeClass('is-sticky');
            stickyWrapper.height('auto');
        }
    };

    // Find all data-toggle="sticky-onscroll" elements
    $('[data-toggle="sticky-onscroll"]').each(function() {
        var sticky = $(this);
        var stickyWrapper = $('<div>').addClass('sticky-wrapper'); // insert hidden element to maintain actual top offset on page
        sticky.before(stickyWrapper);
        sticky.addClass('sticky');

        // Scroll & resize events
        $(window).on('scroll.sticky-onscroll resize.sticky-onscroll', function() {
            stickyToggle(sticky, stickyWrapper, $(this));
        });

        // On page load
        stickyToggle(sticky, stickyWrapper, $(window));
    });
    var bannerLeft = $('.banner-slide.left');
    var bannerRight = $('.banner-slide.right');
    let offsetTop = 211;
    $(window).on('scroll.sticky-onscroll resize.sticky-onscroll', function() {
        let scrollTop = $(window).scrollTop();
        if (scrollTop >= offsetTop) {
            bannerLeft.addClass('fixed');
            bannerRight.addClass('fixed');
            bannerLeft.css({ left: $('#main > .container').offset().left - $('.banner-slide.left').width() + 11 + 'px' });
            var r = $(window).width() - $('#main > .container').offset().left - $('#main > .container').width() - 178;
            bannerRight.css({ right: r + 11 + 'px' });
        } else {
            bannerLeft.removeClass('fixed');
            bannerLeft.css({ left: '-137px' });
            bannerRight.removeClass('fixed');
            bannerRight.css({ right: '-137px' });
        }
    });

    var formSearch = $('.form-search');

    $('.product-filter form .form-control').change(function() {
        var name = $(this).attr('name');
        var value = $(this).val();
        formSearch.find('[name=' + name + ']').val(value);
        formSearch.submit();
    });

    $('.product-filter form .form-check-input[name=has_image], .product-filter form .form-check-input[name=has_video]').change(function() {
        var name = $(this).attr('name');
        if ($(this).prop('checked')) {
            formSearch.find('[name=' + name + ']').val('yes');
        } else {
            formSearch.find('[name=' + name + ']').val('');
        }

        formSearch.submit();
    });

    $('.show-modal-subscribe').click(function(event) {
        event.preventDefault();
        $('#modal-subscribe').modal('show');
        window.resetSubscribeCaptcha();
        $('#modal-subscribe input[name=email]').val('');
    });

    $('#modal-subscribe form').submit(function(event) {
        // event.preventDefault();

        var email = $('#modal-subscribe input[name=email]')
            .first()
            .val();

        if (window.subscribe_recaptcha_token == '') {
            return;
        }

        // var captcha_token = window.subscribe_recaptcha_token;

        axios
            .post('/subscription', { email })
            .then(response => {
                window.subscribe_recaptcha_token = '';
                if (response.data.status) {
                    alert('Đăng ký nhận tin thành công.');
                    $('#subscribe-bar form input').val('');
                    $('#modal-subscribe').modal('hide');
                } else {
                    alert('Đã có lỗi xảy ra, vui lòng thử lại.');
                }
            })
            .catch(err => {
                window.subscribe_recaptcha_token = '';
                if (err.response.data.errors) {
                    alert('Vui lòng điền đầy đủ email.');
                    $('#modal-subscribe').modal('hide');
                    // window.resetSubscribeCaptcha();
                }
            });
    });

    // $('#subscribe-bar form').submit(function(event) {
    //     event.preventDefault();
    //     var email = $('#subscribe-bar form input')
    //         .first()
    //         .val();

    //     axios
    //         .post('/subscription', { email })
    //         .then(response => {
    //             if (response.data.status) {
    //                 alert('Đăng ký nhận tin thành công.');
    //                 $('#subscribe-bar form input').val('');
    //             } else {
    //                 alert('Đã có lỗi xảy ra, vui lòng thử lại.');
    //             }
    //         })
    //         .catch(err => {
    //             console.log(err);
    //             alert('Đã có lỗi xảy ra, vui lòng thử lại');
    //         });
    // });
    // Send message to author
    $('.product-detail .btn-send-message').on('click', function() {
        let to_user = $(this).data('to-user');
        let from_product = $(this).data('from-product');

        $('#modal-send-message .alert.alert-danger').removeClass('alert-danger');
        $('#modal-send-message .alert.alert-success').removeClass('alert-success');
        $('#modal-send-message .alert').html('');
        $('#modal-send-message input[name=to_user]').val(to_user);
        $('#modal-send-message input[name=from_product]').val(from_product);
        $('#modal-send-message textarea').val('');
    });
    $('#modal-send-message button[type=submit]').on('click', function() {
        axios
            .post('/send-message', $('#modal-send-message form').serialize())
            .then(response => {
                if (response.data.status) {
                    $('#modal-send-message .alert.alert-danger').removeClass('alert-danger');
                    $('#modal-send-message .alert').addClass('alert-success');
                    $('#modal-send-message .alert').html('Gửi tin thành công.');
                    $('#modal-send-message input[name=to_user]').val('');
                    $('#modal-send-message textarea').val('');
                    setTimeout(function() {
                        $('#modal-send-message').modal('hide');
                    }, 500);
                } else {
                    $('#modal-send-message .alert.alert-success').removeClass('alert-success');
                    $('#modal-send-message .alert').addClass('alert-danger');
                    $('#modal-send-message .alert').html('Đã có lỗi xảy ra, vui lòng thử lại.');
                }
            })
            .catch(err => {
                if (err.response.data.errors) {
                    $('#modal-send-message .alert.alert-success').removeClass('alert-success');
                    $('#modal-send-message .alert').addClass('alert-danger');
                    $('#modal-send-message .alert').html('Vui lòng điền nội dung tin nhắn.');
                }
            });
        return false;
    });

    $('#message-box-page').on('click', '.btn-load-message', function() {
        $('#reply_content').val('');
        let fromId = $(this).data('from-id');
        $('.btn-load-message.active').removeClass('active_chat');
        $('#reply_to_id').val(fromId);
        $(this).addClass('active_chat');
        axios
            .post('/message/content', {
                from: fromId
            })
            .then(response => {
                $('#message-content-list').html(response.data);
                $('#reply_content').focus();
                $('#message-content-list').animate(
                    {
                        scrollTop: $('.msg-item:last-child').offset().top
                    },
                    2000
                );
            })
            .catch(err => {
                // console.log('Cannot load content');
            });
    });
    $('#reply_content').keyup(function(e) {
        if (e.keyCode == 13) {
            $('#btn-reply-message').click();
        }
    });
    $('#btn-reply-message').on('click', function() {
        if (!$('#reply_content').val() || !$('#reply_to_id').val()) {
            return false;
        }
        axios
            .post('/send-message', {
                to_user: $('#reply_to_id').val(),
                message_content: $('#reply_content')
                    .val()
                    .trim()
            })
            .then(response => {
                if (response.data.status) {
                    setTimeout(function() {
                        $('.btn-load-message.active_chat').click();
                        $('#reply_content').val('');
                    }, 500);
                } else {
                    //
                }
            })
            .catch(err => {
                //
            });
    });
});
