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
                            <h6>1. Cơ chế</h6>
                            <div class="alert alert-warning">
                                Bắt buộc : Nhà cung cấp khi đăng tin lên vietnamads.vn tại các thư mục
                                <strong>biển quảng cáo, quảng cáo truyền thông, digital marketing, ads banner, nghiệp vụ quảng cáo</strong> bắt buộc phải
                                đăng các tin mà các tin đó cung cấp dịch vụ quảng cáo hoặc marketing để mọi người có
                                thể sử dụng. Nếu cố tình đăng những tin không liên quan, hoặc spam các tin tức không
                                liên quan đến các ngành tiếp thị, quảng cáo, marketing ban quản trị và
                                kiểm duyệt viên sẽ khóa nick đó vĩnh viễn.
                            </div>
                            <img class="image img-thumbnail" src="{{url('/images/guide/dang-tin/step1.png')}}"/>
                            <br/>
                            <p>
                                Phần cần tìm dịch vụ dành cho các user đăng các tin có nhu cần thuê, cần tìm.
                            </p>
                            <img class="image img-thumbnail" src="{{url('/images/guide/dang-tin/step2.png')}}"/>
                        </div>
                        <br/>
                        <div>
                            <h6>2. Loại tin</h6>
                            <p>
                                Khi đã đăng nhập bạn hay click nút “ đăng tin rao” góc phải trên màn hình
                            </p>
                            <img class="image img-thumbnail" src="{{url('/images/guide/dang-tin/step3.png')}}"/>
                            <p>
                               <strong>Có 6 mục đăng tin dành cho bạn</strong>
                            </p>
                            <img class="image img-thumbnail" src="{{url('/images/guide/dang-tin/step4.png')}}"/>
                            <p>
                                <strong>I. Biển quảng cáo: <br/></strong>
                                +Là khi bạn muốn cho thuê hoặc cung cấp các vị trí lắp đặt quảng cáo hiện hữu ngoài đời thật.
                            </p>
                            <p>
                                <strong>II. Quảng cáo quyền thông: <br/></strong>
                                + Là khi bạn muốn mọi người đăng các tin quảng cáo lên kênh hoặc hệ truyền thông của bạn
                                <br/>
                                + Hoặc bạn có hệ thống, chương trình, nội dung có thể chèn quảng cáo
                            </p>
                            <p>
                                <strong>III. Digital Marketing:<br/></strong>
                                + Là khi bạn có 1 kênh, trang, hội nhóm hoặc chính trang cá nhân có lượng tương tác lớn,
                                bạn có thể cho phép để mọi người đăng tin quảng cáo lên đó<br/>
                                + Là khi bạn cung cấp các cách thức, giải pháp marketing trên không gian mạng cũng như các dịch vụ digital marketing
                            </p>
                            <p>
                                <strong>IV. Ads Banner:<br/></strong>
                                + Là khi bạn là webmaster hoặc sở hữu trang web có nội dung thu hút và bạn cho
                                phép mọi người đăng banner quảng cáo lên website của mình
                            </p>
                            <p>
                                <strong>V. Nghiệp vụ quảng cáo:<br/></strong>
                                + Là tổng hợp các công việc trong ngành quảng cáo và marketing từ thi công biển quảng cáo, thiết kế, làm phim, chụp ảnh...
                                Mà người truy cập trang có thể sẽ liên hệ bạn để thuê
                            </p>
                            <p>
                                <strong>VI. Cần thuê dịch vụ:<br/></strong>
                                + Mục này là dành cho người dùng các nhà cung cấp không được đăng tin vào đây.
                                Mục đích dành cho người dùng nếu không tìm được nhà cung cấp mong muốn. Bạn hãy đăng tin vào mục này !
                            </p>
                        </div>
                        <div>
                            <h6>3: Quy định đăng tin</h6>
                            <p>
                                Tại trang đăng tin bạn cần lưu ý các điều sau:<br/>
                                + Các mục có dấu (*) là bắt buộc phải khai báo<br/>
                                + Chỉ được đăng tối đa 12 ảnh, mỗi ảnh tối đa 3MB<br/>
                                + Nếu dùng bản đồ bạn chỉ cần chọn “ lựa chọn vị trí trên bản đồ” và di chuyển map là mũi tên sẽ tự
                                đến vị trí bạn cần đánh dấu là xong. Sau khi đăng tin sẽ hiển thị chế độ view by map đúng vị trí đó<br/>
                                + Vị trí địa lí không bắt buộc bạn phải khai báo phường/xã và đường/phố. Nhưng bạn nên thêm vào nếu
                                như vị trí của biển quảng cáo của bạn có. Vị trí địa lí tại các hình thức biển quảng cáo
                                là xác định vị trí của biển quảng cáo đó ( trừ biển quảng cáo trên phương tiện di chuyển )<br/>
                                +  Vị trí địa lí tại các hình thức khác “ biển quảng cáo” là muốn xác định vị trí trụ sở của
                                nhà cung cấp. Dành cho khách hàng có nhu cầu xác định nhà cung cấp đó và làm việc trực tiếp<br/>
                                + Tất cả các link (direct link) bạn muốn dán lên tin đăng phải đầy đủ
                                ( copy toàn bộ cụm URL gồm cả tiền tố http) Ví dụ : https://www.vietnamads.vn
                                hoặc https://vietnamads.vn. Trường hợp bạn không làm như vậy. URL sẽ không tự động hiển thị và
                                trỏ đến trang mà bạn muốn. ( tin đăng gói basic sẽ không được trỏ )
                            </p>
                            <img class="image img-thumbnail" src="{{url('/images/guide/dang-tin/step5.png')}}"/>
                            <p>
                                + Nếu bạn muốn có video hiển thị trên tin rao nhằm tăng nội dung cho tin rao của bạn hãy
                                copy toàn cụm URL của video trên youtube đó và dán vào youtube link.
                            </p>
                            <img class="image img-thumbnail" src="{{url('/images/guide/dang-tin/step6.png')}}"/>
                            <p>
                                + Khi đã hoàn thành khai báo đầy đủ hãy click nút “đăng tin” để chúng tôi kiểm duyệt và
                                xuất bản tin của bạn ( gói Enterprise ko cần kiểm duyệt mà được tự động xuất bản luôn)
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