// register
var modalRegister = $('#modal-register');
var modalRegisterErr = modalRegister.find('.alert-danger').first();
var modalLogin = $('#modal-login');
var modalLoginErr = modalLogin.find('.alert-danger').first();
var modalActiveCode = $('#modal-active-account');
var modalActiveErr = modalActiveCode.find('.alert-danger').first();
var modalActiveInfo = modalActiveCode.find('.alert-info').first();

var showAlert = (s, content) => {
    s.find('.content').text(content);
    s.removeClass('d-none').addClass('show');
};
var hideAlert = s => {
    s.removeClass('show').addClass('d-none');
};

var showModalRegister = function() {
    modalRegister.modal('show');
};

var hideModalRegister = () => {
    modalRegister.modal('hide');
};

var showModalLogin = () => {
    modalLogin.modal('show');
};

var hideModalLogin = () => {
    modalLogin.modal('hide');
};

var showResendActiveSms = () => {
    $('.resend_sms_captcha_wrap').show();
    return false;
}

modalLogin.find('.show-modal-register').click(function(e) {
    e.preventDefault();
    modalLogin.modal('hide');
    setTimeout(() => {
        modalRegister.modal();
    }, 500);
});
// active code
modalActiveCode.find('form').submit(function(event) {
    event.preventDefault();
    var code = modalActiveCode.find('input[name=activeCode]').val();

    if (!code || code.length < 5) {
        return showAlert(modalActiveErr, 'Mã kích hoạt chưa hợp lệ.');
    }

    // axios
    //     .get('activate/' + code + '?type=sms')
    //     .then(({ data }) => {
    //         if (data.status == 1) {
    //             modalActiveCode.modal('hide');
    //             window.location.href = '/';
    //         } else {
    //             // showAlert(modalActiveErr, 'Mã kích hoạt chưa hợp lệ.');
    //         }
    //     })
    //     .catch(err => {
    //         console.log(err);
    //         if (err.response && err.response.data && err.response.data.errors) {
    //             // var errors = _.values(err.response.data.errors);
    //             // showAlert(modalActiveErr, errors[0]);
    //         }
    //     });
    window.location.href = window.app_url + '/activate_sms/' + code + '?type=sms';
});
// Resend sms
// modalActiveCode.find('.btn_resend_sms').click(function(event) {
//     event.preventDefault();
//     // let captcha = modalActiveCode.find('input[name=g-recaptcha-response]').val();
//
//     let fData = $('#fResendActiveCode').serialize();
//     axios
//         .post('sms/resend', fData)
//         .then(({ data }) => {
//             if (data.status == 1) {
//                 $('.sms-alert-sent').text('Mã kích hoạt đã được gửi lại tới số điện thoại của bạn.');
//                 $('.resend_sms_captcha_wrap').hide();
//                 $('.showResendSmsWrap').hide();
//             } else {
//                 showAlert(modalActiveErr, data.message);
//             }
//         })
//         .catch(err => {
//             console.log(err);
//             if (err.response && err.response.data && err.response.data.errors) {
//                 var errors = _.values(err.response.data.errors);
//                 showAlert(modalActiveErr, errors[0]);
//                 // refreshCaptcha2();
//             }
//         });
// });

modalActiveCode.find('.showResendSmsWrap').click(function (event) {
    showResendActiveSms();
});



// register
modalRegister.find('form').submit(function(event) {
    // event.preventDefault();
    // var email = modalRegister.find('input[name=email]').val();
    var password = modalRegister.find('input[name=password]').val();
    var password_confirmation = modalRegister.find('input[name=password_confirmation]').val();
    // var phone = modalRegister.find('input[name=phone]').val();
    var city = parseInt(modalRegister.find('select[name=city]').val());
    // var last_name = modalRegister.find('input[name=last_name]').val();
    // var name = modalRegister.find('input[name=name]').val();
    // var company_id = modalRegister.find('input[name=company_id]').val();
    // var personal_id = modalRegister.find('input[name=personal_id]').val();
    // var captcha = modalRegister.find('input[name=g-recaptcha-response]').val();
    if (password.length < 5) {
        return showAlert(modalRegisterErr, 'Mật khẩu ít nhất phải từ 5 kí tự');
    }
    if (password != password_confirmation) {
        return showAlert(modalRegisterErr, 'Hãy nhập lại chính xác mật khẩu');
    }

    if (city == 0) {
        return showAlert(modalRegisterErr, 'Hãy chọn 1 tình/thảnh phố');
    }
    // this.submit();
    return true;
    // var data = $('#fRegisterByPopup').serialize();
    // axios
    //     .post('register', data)
    //     .then(({ data }) => {
    //         if (data.status == 1) {
    //             modalRegister.modal('hide');
    //             setTimeout(() => {
    //                 // modalLogin.modal('show');
    //                 // modalLogin
    //                 //     .find('.alert-info')
    //                 //     .removeClass('d-none')
    //                 //     .addClass('show')
    //                 //     .find('.content')
    //                 //     .text('Đăng ký thành công!, vui lòng kiểm tra email để kích hoạt tài khoản');
    //                 // setTimeout(() => {
    //                 //     modalLogin
    //                 //         .find('.alert-info')
    //                 //         .addClass('d-none')
    //                 //         .removeClass('show');
    //                 // }, 3000);
    //                 modalActiveCode.modal('show');
    //             }, 300);
    //         } else {
    //             showAlert(modalRegisterErr, data.message);
    //             // modalRegister.find('img.img-captcha').attr('src', data.newCaptcha);
    //             // modalRegister.find('input[name=captcha_value]').val(data.newHash);
    //             refreshCaptcha();
    //         }
    //     })
    //     .catch(err => {
    //         console.log(err);
    //         if (err.response && err.response.data && err.response.data.errors) {
    //             var errors = _.values(err.response.data.errors);
    //             showAlert(modalRegisterErr, errors[0]);
    //             refreshCaptcha();
    //         }
    //     });
});
$('.captcha-f5').click(function (e) {
    refreshCaptcha();
});
$('.captcha2-f5').click(function (e) {
    refreshCaptcha2();
});
modalLogin.find('form').submit(function(event) {
    event.preventDefault();
    var email = modalLogin.find('input[name=email]').val();
    var password = modalLogin.find('input[name=password]').val();
    var data = {
        email,
        password
    };

    axios
        .post('/login', data)
        .then(({ data }) => {
            if (data.status == 1) {
                window.location.href = '/';
            } else {
                return showAlert(modalLoginErr, data.errors[0]);
            }
        })
        .catch(err => {
            // console.log(err);
        });
});

var modalChangePassword = $('#modal-change-password');
var modalChangePasswordErr = modalChangePassword.find('.alert-danger').first();
modalChangePassword.find('form').submit(function(event) {
    event.preventDefault();
    var data = {
        current_password: modalChangePassword.find('input[name=current_password]').val(),
        new_password: modalChangePassword.find('input[name=new_password]').val(),
        new_password_confirmation: modalChangePassword.find('input[name=new_password_confirmation]').val()
    };

    axios
        .post('change-password', data)
        .then(({ data }) => {
            if (data.status == 1) {
                window.location.href = '/trang-ca-nhan';
            } else {
                var msg = 'Error';
                if (data.errors && data.errors[0]) {
                    msg = data.errors[0];
                    showAlert(modalChangePasswordErr, msg);
                }
            }
        })
        .catch(err => {
            if (err.response && err.response.data && err.response.data.errors) {
                var errors = _.values(err.response.data.errors);
                showAlert(modalChangePasswordErr, errors[0]);
            }
        });
});

var modalUpdateProfile = $('#modal-update-profile');
var modalUpdateProfileErr = modalUpdateProfile.find('.alert-danger').first();
modalUpdateProfile.find('form').submit(function(event) {
    event.preventDefault();
    var data = {
        name: modalUpdateProfile.find('input[name=name]').val()
        // phone: modalUpdateProfile.find('input[name=phone]').val()
    };

    axios
        .post('profile', data)
        .then(({ data }) => {
            if (data.status == 1) {
                window.location.href = '/trang-ca-nhan';
            } else {
                var msg = 'Error';
                if (data.errors && data.errors[0]) {
                    msg = data.errors[0];
                    showAlert(modalUpdateProfileErr, msg);
                }
            }
        })
        .catch(err => {
            if (err.response && err.response.data && err.response.data.errors) {
                var errors = _.values(err.response.data.errors);
                showAlert(modalUpdateProfileErr, errors[0]);
            }
        });
});

function refreshCaptcha() {
    // axios
    // .post('/captcha/new')
    // .then(({ data }) => {
    //     modalRegister.find('img.img-captcha').attr('src', data.newCaptcha);
    //     modalRegister.find('input[name=captcha_value]').val(data.newHash);
    //     modalForgotPassword.find('img.img-captcha').attr('src', data.newCaptcha);
    //     modalForgotPassword.find('input[name=captcha_value]').val(data.newHash);
    // })
    // .catch(err => {
    //     console.log(err);
    // });
}

function refreshCaptcha2() {
    // axios
    //     .post('/captcha/new', {
    //         type: 2
    //     })
    //     .then(({ data }) => {
    //         modalActiveCode.find('img.img-captcha').attr('src', data.newCaptcha);
    //         modalActiveCode.find('input[name=captcha_value]').val(data.newHash);
    //     })
    //     .catch(err => {
    //         console.log(err);
    //     });
}

var modalForgotPassword = $('#modal-forgot-password');
var modalForgotPasswordErr = modalForgotPassword.find('.alert-danger').first();
var modalForgotPasswordSuccess = modalForgotPassword.find('.alert-success').first();
modalForgotPassword.find('form').submit(function(event) {
    event.preventDefault();
    var data = $('#fForgotPassDialog').serialize();

    modalForgotPasswordErr.addClass('d-none');
    modalForgotPasswordSuccess.addClass('d-none');

    axios
        .post('request-forgot-password', data)
        .then(({ data }) => {
            if (data.status == 1) {
                showAlert(modalForgotPasswordSuccess, 'Gửi yêu cầu thay đổi mật khẩu thành công, xin hay kiểm tra email!');
                modalForgotPassword.find('input[name=email]').val('');
            } else {
                var msg = 'Error';
                if (data.errors && data.errors[0]) {
                    msg = data.errors[0];
                    showAlert(modalForgotPasswordErr, msg);
                }
            }
        })
        .catch(err => {
            if (err.response && err.response.data && err.response.data.errors) {
                var errors = _.values(err.response.data.errors);
                showAlert(modalForgotPasswordErr, errors[0]);
            }
        });
});

modalLogin.find('.show-modal-forgot-password').click(function(e) {
    e.preventDefault();
    modalLogin.modal('hide');
    modalForgotPassword.modal('show');
});

$('#change-avatar-btn').click(function(event) {
    event.preventDefault();
    $('#avatar-file-input').click();
});

$('#avatar-file-input').change(function() {
    const file = $(this)[0].files[0];
    const form = new FormData();
    form.append('file', file);
    form.append('folder', 'avatars');
    form.append('thumb', '1');

    const config = {
        onUploadProgress: progressEvent => {
            // let percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);
            // console.log(percentCompleted);
        }
    };

    axios
        .post('/upload-image', form, config)
        .then(response => {
            if (response.data.success) {
                updateAvatar(response.data.file.filename);
            }
            $('#avatar-file-input').val('');
        })
        .catch(error => {
            $('#avatar-file-input').val('');
            alert('Ảnh không hợp lệ.');
        });
});

const updateAvatar = avatar => {
    axios.post('/update-avatar', { avatar }).then(response => {
        window.location.href = '/trang-ca-nhan';
    });
};
