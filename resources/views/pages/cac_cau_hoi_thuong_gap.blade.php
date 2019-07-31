@extends('master_fluid')
@section('breadcrumb')
    {{ Breadcrumbs::render('about', $page, $slug) }}
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
                            <h6>1. Mất bao lâu thì tin đăng của tôi được duyệt và xuất bản ?</h6>
                            <p>
                                - Tin đăng của bạn sẽ được bộ phận kiểm duyệt của vietnamads.vn xem lại và xuất bản.
                                Lưu ý tin đăng của bạn sẽ được kiểm duyệt và xuất bản trong thời gian nhanh nhất 15 phút và lâu nhất 3 tiếng.
                            </p>
                            <p>
                                - Các tin đăng không đúng quy định và vi phạm chính sách sẽ không được duyệt và bị xóa bỏ.
                                Bạn vui lòng đọc kĩ hướng dẫn về
                                <a target="_blank" href="{{route('guide', ['page' => 'quy-dinh-dang-tin'])}}">quy định đăng tin</a>
                                và đăng đúng nội dung.
                            </p>
                        </div>
                        <br/>
                        <div>
                            <h6>2. Làm sao để tin đăng của tôi có thẻ tag ?</h6>
                            <p>
                                - Tin đăng của bạn khi được duyệt sẽ được bộ phận của vietnamads.vn
                                thêm các thẻ tag tương ứng dựa vào nội dung tin đăng của bạn.
                            </p>
                            <p>
                                - Hoặc sau khi đăng tin xong bạn có thể gọi đến trung tâm hỗ trợ 1900 0127
                                yêu cầu thêm các thẻ tag mà bạn muốn vào tin rao của bạn.
                            </p>
                            <p>
                                - Thêm thẻ tag sẽ tăng khả năng điều hướng người dùng, tăng trải nghiệm người dùng khi xem tin của bạn.
                            </p>
                        </div>
                        <br/>
                        <div>
                            <h6>3. Tại sao tôi thêm direct link cuối bài viết mà không hiện ?</h6>
                            <p>
                                - Bạn lưu ý phải copy cả URL gồm cả cụm tiền tố… định dạng URL bắt buộc phải có cả tiền tố mới hiển thị trên tin rao
                                ví dụ (https://www.vietnamads.vn)
                            </p>
                            <p>
                                - Nếu không tin rao của bạn sẽ không hiển thị link đó trỏ đến trang mà bạn muốn.
                            </p>
                        </div>
                        <br/>
                        <div>
                            <h6>4. Link trong bài viết của tôi không trỏ đến mà chỉ hiện dạng text ?</h6>
                            <p>
                                - Do bạn đang sử dụng gói tin basic nhất.
                                Chúng tôi không setup trỏ trực tiếp đến trang của bạn cho gói tin này. Bạn hãy xem kĩ ở phần báo
                                <a href="{{route('pricing')}}">giá tin rao</a>
                            </p>
                        </div>
                        <br/>
                        <div>
                            <h6>5. Làm thế nào để tôi có số dư khuyến mãi ?</h6>
                            <p>
                                - Số dư khuyến mãi sẽ được nạp vào tài khoản của bạn bằng gift code.
                                Lưu ý số dư khuyến mãi chỉ có thể dùng để đăng tin.
                            </p>
                        </div>
                        <br/>
                        <div>
                            <h6>6. Làm thế nào để tôi có thể nhận gift code từ vietnamads.vn ?</h6>
                            <p>
                                - Gift code sẽ được gửi đến sđt của bạn vào mỗi dịp mà chúng tôi khuyến mãi và sẽ thông báo trước đó. Xin bạn hãy lưu ý
                            </p>
                            <p>
                                - Đặc biệt tài khoản VIP sẽ được hưởng thêm gift code khuyến mãi 20% giá trị mỗi lần nạp tiền.
                            </p>
                        </div>
                        <br/>
                        <div>
                            <h6>7. Tại sao giftcode của tôi bị lỗi ?</h6>
                            <p>
                                - Do gift code của bạn đã được ai đó sử dụng hoặc đã sử dụng rồi.
                            </p>
                            <p>
                                - Tài khoản của bạn chỉ được sử dụng 1 gift code cho mỗi 1 chiến dịch khuyến mãi mà chúng tôi công bố.
                            </p>
                        </div>
                        <br/>
                        <div>
                            <h6>8. Tại sao chế độ up tin tự động vẫn hoạt động trong khi tin của tôi không được làm mới ?</h6>
                            <p>
                                - Là do số dư tài khoản chính của bạn đã hết. Bạn lưu ý một khi chế độ up tin tự động sẽ không thể nào
                                dừng được cho đến khi hết số lần làm mới ( kể cả bạn không đủ số dư tài khoản chính thì chức năng này
                                vẫn chạy nhưng ko làm mới được tin rao. Xin bạn lưu ý )
                            </p>
                        </div>
                        <br/>
                        <div>
                            <h6>9. Tại sao tin rao của tôi không import được video youtube ?</h6>
                            <p>
                                - Bạn lưu ý phải copy cả URL của video đó trên youtube gồm cả tiền tố  http...
                                 định dạng URL bắt buộc phải có cả tiền tố mới hiển thị trên tin rao ví dụ (https://www.vietnamads.vn/ )
                            </p>
                            <p>
                                - Nếu không tin rao của bạn sẽ không hiển thị video youtube đó đó trỏ đến trang mà bạn muốn.
                            </p>
                            <p>
                                - Mỗi một tin rao chỉ được phép import 1 video trên youtube
                            </p>
                        </div>
                        <br/>
                        <div>
                            <h6>10. Tại sao xem chế độ map không thấy gì ?</h6>
                            <p>
                                - Bạn phải chọn vị trí địa lí là tỉnh/thành phố
                                mới có thể xem được các đánh dấu của người đăng trên bản đồ (nếu người đăng tin sử dụng chức năng này)
                            </p>
                        </div>
                        <br/>
                        <div>
                            <h6>11. Làm sao để tài khoản của tôi trở thành tài khoản VIP ?</h6>
                            <p>
                                - Để trở thành tài khoản VIP bạn cần 1 trong 3 yếu tố:
                                <br/>+ Tài khoản của bạn đã nạp trên 10 triệu – bạn có thể gọi chúng tôi để kiểm tra và nâng cấp VIP cho bạn
                                <br/>+ Bạn phải là đối tác của vietnamads.vn và muốn hợp tác lâu dài
                                – là đơn vị cần cung cấp số lượng lớn dịch vụ quảng cáo và marketing đến thị trường Việt Nam.
                                Chúng tôi sẽ sắp xếp nhân lực hỗ trợ cho bạn miễn phí để tiếp cận đến thị trường tốt nhất.
                                Xin hãy gọi theo số 0934828881 gặp bộ phận kết nối của chúng tôi
                                + Bạn phải là người quen biết và thân thiết với ban lãnh đạo vietnamads.vn.
                                Đã từng giúp đỡ vietnamads.vn trong những bước phát triển đầu tiên
                            </p>
                        </div>
                        <br/>
                        <div>
                            <h6>12. Tài khoản VIP được hưởng gì ?</h6>
                            <p>
                                - Giảm giá 20% tất cả các dịch vụ của vietnamads.vn.
                                Mỗi khi nạp tiền thành công tài khoản VIP được nạp thêm 20% số tiền
                            </p>
                            <p>
                                - Được hưởng chính sách nhiều hơn mỗi đợt khuyến mãi của vietnamads.vn
                            </p>
                            <p>
                                - Được vietnamads.vn cắt cử nhân viên hỗ trợ riêng 24/7
                            </p>
                        </div>
                        <br/>
                        <div>
                            <h6>13. Tin rao của tôi bị disable chức năng làm mới tin rao ?</h6>
                            <p>
                                - Do tin rao của bạn đã hết hạn
                            </p>
                            <p>
                                - Bạn lưu ý: Hiện tại vietnamads.vn <b>đang ưu đãi</b> cho tất cả các thành viên …….
                                Kể cả khi hết hạn, vietnamads.vn vẫn cho phép tin rao hiển thị 365 ngày(đưa về chế độ basic)
                                sau đó mới xóa .Chỉ có điều bạn không được làm mới tin rao đó nữa !
                            </p>
                        </div>
                        <br/>
                        <div>
                            <h6>14. Tin rao của tôi không xuất hiện trong thẻ “nhóm tin nổi bật” ?</h6>
                            <p>
                                - Chỉ có cá nhân khởi tạo và đăng kí với vietnamads.vn mới được thêm các tin rao tùy ý vào trong các
                                thư mực của “nhóm tin nổi bật” . Bạn hãy đọc thêm tại
                                <a target="_blank" href="{{route('guide', ['page' => 'day-tin-len-top'])}}">đây</a>
                                để tìm hiểu về cách hoạt động “nhóm tin nổi bật”
                            </p>
                        </div>
                        <br/>
                        <div>
                            <h6>15. Tin rao của tôi không xuất hiện trong thẻ gợi ý có các thư mục ?</h6>
                            <p>
                                - Bạn lưu ý 2 loại thẻ gợi ý khi người dùng tra cứu sẽ hiện ra ở trang danh mục
                                <br/>+ Thẻ “gợi ý tìm kiếm” Các tin rao sẽ được đội ngũ kiểm duyệt và xuất bản của chúng tôi thêm vào các thư mục
                                tương ứng của thẻ này – tùy vào nội dung tin rao có hợp lí hay không
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