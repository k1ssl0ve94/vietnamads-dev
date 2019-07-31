@extends('master_fluid')
@section('breadcrumb')
{{ Breadcrumbs::render('baogia-sub', $page, $slug) }}
@endsection
@section('title')
<title>{{ $page }} | VietnamAds</title>
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
                <div class="card-body">
                    <div class="">
                        <div class="alert alert-warning">
                            <strong>
                                Vietnamads.vn cung cấp chức năng thư mục riêng hiển thị ở “nhóm tin nổi bật”
                                dành riêng cho các khách hàng có nhu cầu muốn tiếp cận các tin rao của mình tốt hơn đến người xem
                            </strong>
                        </div>
                        <div>
                            <h6>ĐẶC ĐIỂM</h6>
                            <p>
                                + Chỉ có các tin rao mà người đã đăng kí thư mục đó <b>đồng ý mới được thêm vào .
                                    Không nhất thiết phải là các tin rao cùng 1 tài khoản , số lượng không giới hạn</b>, người đăng
                                kí thư mục chỉ cần cung cấp danh sách ID các tin rao muốn thêm vào thư mục đó cho bộ phận
                                phụ trách  ( tổng đài 1900 0127 hoặc hotline: 0934828881 ) để vietnamads.vn thêm vào trên hệ thống
                            </p>
                            <p>
                                + <b>Luôn hiển thị</b> tiêu đề thư mục ở “nhóm tin nổi bật” khi người xem tra cứu hoặc tìm kiếm
                                theo hình thức đó – làm người xem chú ý để truy cập tìm hiểu nhóm tin rao này
                            </p>
                            <p>
                                + <b>Tiêu đề tùy ý</b> đặt theo ý bạn muốn ,nhưng <b>không được trùng với người khác đăng kí</b> và nên
                                tối ưu để tạo chuyển đổi cho bạn tốt nhất – tiêu đề <b>không nên quá dài</b>
                            </p>
                            <p>
                                + Có thể <b>đổi tên thư mục (tiêu đề)</b> nếu bạn muốn nhưng các tin rao trong thư mục sẽ
                                không mất đi trừ khi bạn dùng tài khoản đăng tin xóa.
                            </p>
                            <p>
                                + Bạn lưu ý thứ tự sắp xếp tại thẻ “ nhóm tin nổi bật” là ngẫu nhiên dựa vào xu hướng của
                                người xem tạo trải nghiệm người dùng tốt nhất chứ không lặp đi lặp lại 1 thứ tự
                            </p>
                            <p>
                                + Tại thư mục riêng của bạn sẽ ko có chế độ xem trên bản đồ, nhưng tin rao vẫn hiển thị đánh dấu trên map
                            </p>
                            <p>
                                + Quá thời hạn kí kết thư mục sẽ không được hiển thị ở thẻ nhóm tin nổi bật nữa
                            </p>
                            <h6>Liên hệ</h6>
                            <p>
                                + Hotline call : <b>0934828881</b> (Manager) <b>0919562247</b> (Saler)
                                hoặc tổng đài  <b>1900 0127</b> ( giờ hành chính )
                            </p>
                            <p>
                                + Email: admin@vietnamads.vn or contact@vietnamads.vn
                            </p>
                        </div>
                        <br/>
                        <div>
                            <h6>Mô tả</h6>
                            <p>
                                <strong>1. Thẻ “nhóm tin nổi bật” là tên danh sách các thư mục khách hàng đăng kí luôn xuất
                                    hiện tại các trường thư mục khi người dùng truy cập hoặc dùng bộ lọc tìm kiếm:</strong>
                            </p>
                            <img class="image img-thumbnail" src="{{url('/images/guide/baogia/tin1.png')}}"/>
                            <p>
                                + Nhóm tin nổi bật của thư mục và các thư mục con của “Biển quảng cáo”<br/>
                                + Nhóm tin nổi bật của thư mục và các thư mục con của “Quảng cáo truyền thông”<br/>
                                + Nhóm tin nổi bật của thư mục và các thư mục con của “Digital marketing”<br/>
                                + Nhóm tin nổi bật của thư mục và các thư mục con của “Ads banner”<br/>
                                + Nhóm tin nổi bật của thư mục và các thư mục con của “Nghiệp vụ quảng cáo”<br/>
                                + Nhóm tin nổi bật của thư mục và các thư mục con của “ Cần thuê dịch vụ”<br/>
                                <strong>
                                    Ví dụ nếu bạn đăng kí thư mục có tiêu đề “ biển quảng cáo cao tốc Pháp Vân” cho
                                    trường thư mục “Biển quảng cáo” thì:
                                </strong><br/>
                                Nếu người dùng truy cập bằng menu hoặc sử dụng bộ lọc tìm kiếm liên quan đến
                                “biển quảng cáo” hoặc các trường con của “biển quảng cáo” là :<br/>
                                + nhà dân, công trình<br/>
                                + quốc lộ tỉnh lộ<br/>
                                + trên đường phố<br/>
                                + trung tâm công cộng<br/>
                                + trên phương tiện di chuyển<br/>
                                + hộp đèn<br/>
                                + màn hình frame<br/>
                                + biển quảng cáo khác<br/>
                                <strong>
                                    Thì thẻ “nhóm tin nổi bật” sẽ luôn luôn xuất hiện ở các trang danh sách tin rao mà
                                    người dùng tra cứu hoặc tìm kiếm các các tin rao trong các thư mục đó (như hình dưới):
                                </strong><br/>
                                + Tra cứu hoặc tìm kiếm theo “biển quảng cáo” sẽ hiện ra thẻ nhóm tin nổi bật có thư mục
                                riêng “biển quảng cáo cao tốc Pháp Vân”<br/>
                            </p>
                            <img class="image img-thumbnail" src="{{url('/images/guide/baogia/tin2.png')}}"/>
                            <p>
                                + Tra cứu hoặc tìm kiếm theo “ biển quảng cáo nhà dân công trình” cũng sẽ hiện ra thẻ
                                nhóm tin nổi bật có thư mục riêng “biển quảng cáo cao tốc Pháp Vân”
                            </p>
                            <img class="image img-thumbnail" src="{{url('/images/guide/baogia/tin3.png')}}"/>
                            <p>
                                + Người dùng quan tâm đến tiêu đề thư mục “nhóm tin nổi bật” đó sẽ click vào để xem các tin rao của bạn
                                Ví dụ ở đây: bạn thêm các tin rao của mình vào thư mục “biển quảng cáo cao tốc
                                Pháp Vân” thì nó sẽ hiện ra trong thư mục này
                            </p>
                            <img class="image img-thumbnail" src="{{url('/images/guide/baogia/tin4.png')}}"/>
                            <p>
                                <strong>
                                    2. Báo giá thư mục riêng “nhóm tin nổi bật”:
                                </strong><br/>
                                + Người dùng dịch vụ này đăng kí và kí hợp đồng tối thiểu 3 tháng hoặc nhiều hơn<br/>
                                + Giá đã gồm VAT<br/>
                                + Vietnamads.vn chỉ cho phép hiển thị tối đa 15 tiêu đề (thư mục) trên thẻ
                                “nhóm tin nổi bật” cùng lúc! Nếu đã đủ 15 thư mục quý khách có thể đặt trước hoặc chờ.
                                Hãy gọi <b>1900 0127</b> hoặc hotline: <b>0934828881</b> để biết thêm chi tiết<br/>
                                + <b>Quý khách vui lòng thánh toán 100% hợp đồng trước khi triển khai dich vụ này cho quý khách</b><br/>
                            </p>
                            <img class="image img-thumbnail" src="{{url('/images/guide/baogia/tin5.png')}}"/>
                        </div>


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