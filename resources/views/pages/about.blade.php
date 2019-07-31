@extends('master_fluid')
@section('breadcrumb')
    {{ Breadcrumbs::render('about', $page, $slug) }}
@endsection
@section('title')
    <title>Giới thiệu | VietnamAds</title>
@endsection
@section('meta-tags')
    <meta name="description" content="{{$page}}">
@endsection
@section('main')
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="card card-primary">
                <div class="card-header">{{ $page }}</div>
                <div class="card-body content">
                    <div class="alert-info alert">
                        <strong>Vietnamads.vn</strong> là trang thông tin về các dịch vụ quảng cáo và marketing
                        của Việt Nam. Khi người đăng là người sở hữu hoặc cung cấp các <strong>hạ tầng, dịch vụ,
                            hệ thống hoặc nội dung</strong> có giá trị thu hút và có sức mạnh truyền tải,
                        quảng bá và tiếp thị cho các thương hiệu, dịch vụ, sản phẩm hoặc cá nhân muốn quảng cáo.
                        Team vietnamads.vn đã tạo ra hệ thống sắp xếp và thiết kế để người truy cập dễ dàng tra cứu và
                        lựa chọn hình thức quảng cáo và marketing phù hợp nhất với mục đích của mình.
                        Cùng với đó đội ngũ của vietnamads.vn luôn 24/7 hỗ trợ và xử lí các thông tin được đăng lên
                        các nhà quảng cáo và marketing sẽ không phải lo lắng.
                    </div>
                    <br/>
                    <div>
                        <h6>Chúng tôi thấy rằng tại Việt Nam hiện tại :</h6>
                        <ul class="list-group">
                            <li class="list-group-item">
                                <i class="fa fa-plus"></i> Có hơn <strong>6 triệu loại biển quảng cáo</strong> lớn nhỏ, cố định và di động...
                            </li>
                            <li class="list-group-item">
                                <i class="fa fa-plus"></i>
                                Tới <strong>450 nghìn chương trình,nội dung</strong> được sản xuất mỗi ngày gồm truyền hình,
                                phát thanh, ấn phẩm, báo mạng, email, sms, mạng xã hội...
                            </li>
                            <li class="list-group-item">
                                <i class="fa fa-plus"></i>
                                Gần <strong>1,2 triệu cộng đồng</strong> của Việt Nam trên không gian mạng đang hoạt động với hàng tỷ lượt xem và theo dõi...
                                chưa kể các tài khoản cá nhân trên mạng có độ thu hút và ảnh hưởng lên tới
                                <strong>4 triệu tài khoản</strong> gồm đủ các lĩnh vực.
                            </li>
                            <li class="list-group-item">
                                <i class="fa fa-plus"></i>
                                <strong>3 triệu người Việt cùng 6000 công ty</strong> đang hoạt động trong các lĩnh vực quảng cáo,
                                branding, digital marketing... tại Việt Nam
                            </li>
                            <li class="list-group-item">
                                <i class="fa fa-plus"></i>
                                Có đến hơn <strong>1,2 triệu nhu cầu</strong> sử dụng các dịch vụ quảng cáo và marketing mỗi ngày
                            </li>
                        </ul>
                    </div>
                    <br/>
                    <div>
                        <h6>Vấn đề là:</h6>
                        <ul class="list-group">
                            <li class="list-group-item">
                                <i class="fa fa-plus"></i> Với số lượng cực nhiều giải pháp quảng cáo và marketing mà chưa hề có một hệ thống
                                nào sắp xếp và phân bố
                                cho mọi người dễ tra cứu và liên hệ với bên <strong>dịch vụ quảng cáo và marketing</strong>
                                để sử dụng mặc dù nhu cầu rất cao.
                            </li>
                            <li class="list-group-item">
                                <i class="fa fa-plus"></i> Các nhà làm dịch vụ quảng cáo và marketing vẫn chi các khoản tiền
                                hàng năm cho việc tiếp cận người dùng nhưng vẫn <strong>không tiếp cận được đến đúng người cần dùng</strong>.
                            </li>
                            <li class="list-group-item">
                                <i class="fa fa-plus"></i> Các hội nhóm, cá nhân trên mạng có lượt tương tác lớn
                                <strong>không biết tận dụng</strong> nhiều để sử dụng kiếm tiền mà vẫn luôn phụ thuộc vào các công cụ
                                quảng cáo có sẵn như Google và Facebook...
                                thậm chí mất rất nhiều tiền để xây dựng mà <strong>không có nguồn thu</strong>
                                vì không tiếp cận được với nguồn khách hàng có nhu cầu.
                            </li>
                            <li class="list-group-item">
                                <i class="fa fa-plus"></i> Các chương trình truyền thông và nội dung trên mạng được chú ý nhiều nhưng chưa biết
                                đến nhu cầu quảng cáo mà người khác <strong>sẵn sàng bỏ tiền</strong> để chèn vào hoặc hiện trên lịch phát sóng.
                            </li>
                        </ul>
                    </div>
                    <div>
                        Đó là lí do <strong>vietnamads.vn</strong> ra đời nhằm mục đích khiến các khách hàng có nhu cầu quảng cáo và marketing
                        dễ dàng tiếp cận được các nhà cung cấp dịch vụ và ngược lại các công ty và nhà cung cấp không phải
                        mất thời gian đi tìm kiếm khách hàng mà chỉ cần đăng tin lên <strong>vietnamads.vn</strong>.
                    </div>
                    <br/>
                    <div>
                        <h6>Các dịch vụ chính của chúng tôi:</h6>
                        <ul class="list-group">
                            <li class="list-group-item">
                                <i class="fa fa-plus"></i> Đăng tin rao về dịch vụ, sản phẩm quảng cáo và marketing
                            </li>
                            <li class="list-group-item">
                                <i class="fa fa-plus"></i> Đăng banner quảng cáo cho các nhà cung cấp
                            </li>
                            <li class="list-group-item">
                                <i class="fa fa-plus"></i> Đăng bài viết quảng bá
                            </li>
                            <li class="list-group-item">
                                <i class="fa fa-plus"></i> Dựa vào xu hướng người dùng hiển thị các sản phẩm của nhà cung cấp dịch vụ quảng cáo và marketing
                            </li>
                        </ul>
                    </div>
                    <br/>
                    <div class="alert alert-info">
                        <h6>Địa chỉ liên hệ:</h6>
                        <p>
                            Tầng 8, tòa nhà số 315 Trường Chính, Tp Hà Nội
                        </p>
                        <p>Tổng đài 24/7: <strong>1900 0127 ( giờ hành chính)</strong></p>
                        <p>Kinh doanh : <strong>024.3999.2996</strong></p>
                        <p>Chăm sóc đối tác VIP : <strong>024.3999.2995</strong></p>
                        <p>Email:<br/>
                            - <strong>contact@vietnamads.vn (liên hệ)</strong><br/>
                            - <strong>support@vietnamads.vn (hỗ trợ)</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            @include('partials.col-right-about')
        </div>
    </div>
</div>
@endsection