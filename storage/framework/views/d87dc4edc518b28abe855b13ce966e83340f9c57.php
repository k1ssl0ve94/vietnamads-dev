<?php
    $user = auth()->user();
?>
<div class="modal fade modal-vnads" id="modal-login" tabindex="-1" role="dialog" aria-hidden="true">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <div class="modal-dialog" role="document">
        <h5 class="modal-title">Đăng nhập tài khoản</h5>
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6">
                        <a href="/login-facebook" class="btn btn-primary btn-sm btn-block">Đăng nhập bằng Facebook</a>
                    </div>
                    <div class="col-sm-6">
                        <a href="/login-google" class="btn btn-danger btn-sm btn-block">Đăng nhập bằng Google</a>
                    </div>
                </div>
                <div class="text-center mt-2 mb-2">Hoặc</div>
                <form action="">
                    <div class="alert alert-danger alert-dismissible fade d-none" role="alert">
                        <div class="content">
                        </div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="alert alert-info alert-dismissible fade d-none" role="alert">
                        <div class="content">
                        </div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" placeholder="Nhập Email" name="email" required>
                        </div>
                        <div class="col-sm-6 form-group">
                            <label>Mật khẩu</label>
                            <input type="password" class="form-control" placeholder="Nhập mật khẩu" name="password" required>
                        </div>
                        <div class="col-sm-6 form-group">
                            <button class="btn btn-primary btn-sm btn-block" type="submit">Đăng nhập</button>
                        </div>
                        <div class="col-sm-6 form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" checked="checked" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                    Nhớ mật khẩu
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
                <p>
                    <a href="#" class="show-modal-forgot-password">Quên mật khẩu</a><br> Bạn chưa có tài khoản? <a href="#" class="show-modal-register">Đăng ký</a>
                </p>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-subscribe" tabindex="-1" role="dialog" aria-hidden="true">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <div class="modal-dialog" role="document">
        <form action="">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Đăng ký nhận tin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" placeholder="Nhập email của bạn" required>
                    </div>
                    
                        
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Đăng ký</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade modal-vnads" id="modal-register" tabindex="-1" role="dialog" aria-hidden="true">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <div class="modal-dialog" role="document">
        <h5 class="modal-title">Đăng ký tài khoản mới</h5>
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6">
                        <a href="/login-facebook" class="btn btn-primary btn-sm btn-block">Đăng nhập bằng Facebook</a>
                    </div>
                    <div class="col-sm-6">
                        <a href="/login-google" class="btn btn-danger btn-sm btn-block">Đăng nhập bằng Google</a>
                    </div>
                </div>
                <div class="text-center mt-2 mb-2">Hoặc tạo tài khoản tại đây</div>
                <div class="alert alert-danger alert-dismissible fade d-none" role="alert">
                    <div class="content">
                    </div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo e(route('register')); ?>" id="fRegisterByPopup" method="POST">
                    <?php echo csrf_field(); ?>

                    <div class="form-group">
                        <input type="email" class="form-control" placeholder="Nhập Email (*)" name="email" required>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Nhập mật khẩu (*)" name="password" required>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Nhập lại mật khẩu (*)" name="password_confirmation" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Nhập họ (*)" name="last_name" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Nhập tên (*)" name="name" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Số điện thoại (*)" name="phone" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="MST/ĐKKD(công ty)" name="company_id">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="CMND(cá nhân)" name="personal_id">
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="city">
                            <option value="0">Chọn tỉnh/thành phố  (*)</option>
                            <?php $__currentLoopData = config('city'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($id); ?>"><?php echo e($name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <?php echo NoCaptcha::display(); ?>

                    </div>
                    <div class="form-group">
                        <small style="color: red">Các trường gắn (*) là bắt buộc.</small>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-sm btn-block" type="submit">Đăng ký</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-active-account" tabindex="-1" role="dialog" aria-hidden="true">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <div class="modal-dialog" role="document">
        <form action="" id="fResendActiveCode">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Kích hoạt tài khoản</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info sms-alert-sent">
                        <p>Mã kích hoạt đã được gửi tới số điện thoại của bạn.</p>
                    </div>
                    <div class="alert alert-danger alert-dismissible fade d-none" role="alert">
                        <div class="content">
                        </div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="form-group">
                        <label>Active code</label>
                        <input type="text" class="form-control" name="activeCode" placeholder="Nhập mã kích hoạt" required>
                    </div>
                    
                    
                        
                            

                            
                                
                            
                            
                                
                                 
                                
                            
                        
                    
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-toggle="modal"
                            data-target="#modal-verify-phone"
                    >Xác minh thủ công</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Kích hoạt</button>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="modal fade modal-vnads" id="modal-ask-post-type" tabindex="-1" role="dialog" aria-hidden="true">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h3 class="text-center">BẠN MUỐN <br>ĐĂNG LOẠI TIN RAO NÀO</h3>
                <p class="text-center text-select"><small>Chọn loại hình đăng tin mong muốn</small></p>
                <p class="text-center text-danger">
                    Lưu ý: vietnamads.vn chỉ cho đăng các tin rao liên quan đến công việc, hoạt động quảng cáo và marketing. Nếu qúy vị đăng tin không đúng mục đích này khi kiểm duyệt chúng tôi sẽ xóa không báo trước, trường hợp cố tình sẽ bị khóa tài khoản vĩnh viễn. Trân trọng!
                </p>
                <div class="row">
                    <div class="col-md-4 text-right">
                        <a href="<?php echo e(route('get-create-product', ['tab' => 1])); ?>" class="btn btn-primary mb-2">Biển quảng cáo</a>
                    </div>
                    <div class="col-md-8">
                        <span>Nếu bạn cung cấp các vị trí quảng cáo hiện hình, hiện hữu</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 text-right"><a href="<?php echo e(route('get-create-product', ['tab' => 2])); ?>" class="btn btn-primary mb-2">Quảng cáo truyền thông</a></div>
                    <div class="col-md-8">
                        <span>Nếu bạn cung cấp các giải pháp, dịch vụ quảng cáo và marketing trên các phương tiện truyền thông, sự kiện</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 text-right">
                        <a href="<?php echo e(route('get-create-product', ['tab' => 3])); ?>" class="btn btn-primary mb-2">Digital marketing</a>
                    </div>
                    <div class="col-md-8">
                        <span>Nếu bạn cung cấp các phương thức, giải pháp quảng cáo cho Digital Marketing,
                            các mạng xã hội, diễn đàn, booking...</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 text-right">
                        <a href="<?php echo e(route('get-create-product', ['tab' => 4])); ?>" class="btn btn-primary mb-2">Ads banner</a>
                    </div>
                    <div class="col-md-8">
                        <span>Nếu bạn cung cấp các vị trí hiển thị banner quảng cáo online trên
                            websites, hệ thống tiếp thị liên kết, ứng dụng...</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 text-right">
                        <a href="<?php echo e(route('get-create-product', ['tab' => 5])); ?>" class="btn btn-primary mb-2">Nghiệp vụ khác</a>
                    </div>
                    <div class="col-md-8">
                        <span>Nếu bạn làm hoặc cung cấp các dịch vụ liên quan hoặc nhân sự chuyên ngành quảng cáo hoặc marketing</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 text-right">
                        <a href="<?php echo e(route('get-create-product', ['tab' => 6])); ?>" class="btn btn-primary mb-2">Cần thuê dịch vụ</a>
                    </div>
                    <div class="col-md-8">
                        <span>Bạn cần tìm hình thức, dịch vụ quảng cáo, marketing khác cho bạn?</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-change-password" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Đổi mật khẩu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST" class="form">
                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissible fade d-none" role="alert">
                        <div class="content"></div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="form-group">
                        <label>Mật khẩu hiện tại *</label>
                        <input type="password" class="form-control" name="current_password" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <label>Mật khẩu mới *</label>
                        <input type="password" class="form-control" name="new_password" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <label>Nhập lại mật khẩu *</label>
                        <input type="password" class="form-control" name="new_password_confirmation" placeholder="" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php if(auth()->check()): ?>
<div class="modal fade" id="modal-update-profile" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Đổi thông tin cá nhân</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POSt" class="form">
                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissible fade d-none" role="alert">
                        <div class="content"></div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="form-group">
                        <label>Họ tên *</label>
                        <input type="text" class="form-control" name="name" placeholder="" required value="<?php echo e($user->name); ?>">
                    </div>
                    <div class="form-group">
                        <label>Số điện thoại</label>
                        <input type="text" readonly
                               class="form-control" name="phone" placeholder="" required value="<?php echo e($user->phone); ?>">
                        <div>
                            <small>Nếu bạn muốn thay đổi số điện thoại, vui lòng liên hệ Admin.</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>


<div class="modal fade modal-vnads" id="modal-forgot-password" tabindex="-1" role="dialog" aria-hidden="true">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <div class="modal-dialog" role="document">
        <h5 class="modal-title">Quên mật khẩu</h5>
        <div class="modal-content">
            <div class="modal-body">
                <form action="" id="fForgotPassDialog">
                    <div class="alert alert-danger alert-dismissible fade d-none" role="alert">
                        <div class="content">
                        </div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="alert alert-success alert-dismissible fade d-none" role="alert">
                        <div class="content"></div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <p>Nhập địa chỉ email đăng ký tài khoản để nhận mã xác nhận đổi mật khẩu mới</p>
                    <div class="form-group">
                        <input type="email" class="form-control" placeholder="Nhập Email" name="email" required>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <?php echo NoCaptcha::display(); ?>

                        </div>
                    </div>
                    <div class="form-group text-center">
                        <button class="btn btn-primary" type="submit">Xác nhận</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-send-message" tabindex="-1" role="dialog" aria-hidden="true">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <div class="modal-dialog" role="document">
        <form action="">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Gửi tin cho tác giả</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert result"></div>
                    <div class="form-group">
                        <label>Nội dung</label>
                        <input name="to_user" type="hidden">
                        <input name="from_product" type="hidden">
                        <textarea class="form-control" rows="4" id="dialog_message_content_"
                            name="message_content"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Gửi tin</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modal-gift-code" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sử dụng Gift code</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POSt" class="form">
                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissible fade d-none" role="alert">
                        <div class="content"></div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="form-group">
                        <label>Gift code *</label>
                        <input type="text" class="form-control"
                               name="gift_code" placeholder="" required value="">
                        <br/>
                        <small>Chú ý: Mỗi gift code chỉ được sử dụng 1 lần.</small>
                        <br/>
                        <small class="error" style="color: red"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Sử dụng</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-verify-phone" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xác nhận điện thoại</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POSt" class="form">
                <div class="modal-body text-center">
                    <p>
                        Để sử dụng dịch vụ bạn vui lòng kích hoạt tài khoản bằng SMS.<br/>
                        Xác nhận bằng cách gửi tin nhắn tới số <strong class="text-danger">091.956.2247</strong> theo cú pháp: <br/>
                        <strong>
                            kichhoat + Mã tài khoản
                        </strong><br/>
                        Hoặc gọi đến tổng đài <strong class="text-danger">1900 0127</strong> để nhân viên của chúng tôi hỗ trợ cho bạn<br/>
                        Mã tài khoản bạn có thể lấy trong <a href="<?php echo e(route('profile')); ?>">trang cá nhân</a>.<br/>
                    </p>
                    <p>
                        <strong>Tài khoản của bạn sẽ được xử lý tin xác nhận trong vòng 5 phút.</strong>
                    </p>
                    <p>
                        Chúng tôi sẽ sử dụng số điện thoại của bạn để gửi Gift code cũng như các chương trình khuyến mại
                        từ Vietnamads.vn<br/>
                        Mỗi tài khoản chỉ được sử dụng 1 số điện thoại duy nhất và không được sử dụng thêm. <br/>
                        <strong>Vietnamads.vn trân trọng!</strong>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                </div>
            </form>
        </div>
    </div>
</div>