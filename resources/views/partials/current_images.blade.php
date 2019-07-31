<h6>Link trực tiếp</h6>
<div class="row">
    <div class="col-md-12">
        <label>Youtube link: (Bạn cần copy cả tiền tố của url thì link mới hiển thị, ví dụ https://www.vietnamads.vn)</label>
        <input type="text" class="form-control"
            name="youtube_link" v-model="form.youtube_link"/>
    </div>
    <div class="col-md-12">
        <label>Direct link: </label>
        <input type="text" class="form-control"
               name="direct_link[]" v-model="form.direct_link1" placeholder="Direct link 1"/><br/>
        <input type="text" class="form-control"
               name="direct_link[]" v-model="form.direct_link2" placeholder="Direct link 2"/><br/>
        <input type="text" class="form-control"
               name="direct_link[]" v-model="form.direct_link3" placeholder="Direct link 3"/><br/>
        <input type="text" class="form-control"
               name="direct_link[]" v-model="form.direct_link4" placeholder="Direct link 4"/><br/>
        <small>Link này chỉ hiển thị trong tin rao khi bạn chọn gói đăng tương ứng.</small>
    </div>
</div>
<div class="divider"></div>
@if(!isset($product) || $allowImgNb > 0)
<h6>Hình Ảnh</h6>
<vue-dropzone id="create-pano-dropzone"
              ref="createPanoDropzone"
              :use-custom-dropzone-options=true
              :options="dropzoneOptions"
              :use-custom-slot="true"
              v-on:vdropzone-sending="sendingEvent"
              v-on:vdropzone-success="onUploadSuccess"
              v-on:vdropzone-removed-file="removeImage"
              v-on:vdropzone-error="onUploadError"
>
    <div class="dropzone-custom-content">
        <h6 class="dropzone-custom-title">Click để tải ảnh hoặc kéo thả vào đây</h6>
    </div>
</vue-dropzone>
@endif
@if(isset($product))
    <h6>Ảnh hiện tại </h6>
    <div class="divider"></div>
    <div class="row">
        @foreach($product->getThumbURLs() as $imgUrl)
            <div class="col-md-3">
                <img class="img-thumbnail"
                    src="{{$imgUrl}}"/>
            </div>
        @endforeach
    </div>
@endif
<p>Bạn được upload tối đa 12 ảnh. Mỗi ảnh tối đa 3Mb.
    Chú ý trong trường hợp sửa tin, bạn được phép tải thêm số ảnh còn thiếu trong trường hợp chưa đủ 12 ảnh.<br>
    Tin rao có ảnh chắc chắn sẽ dễ được liên hệ nhiều hơn rất nhiều lần tin rao không có ảnh.
    Bạn nên sử dụng ảnh của bạn trên tin rao.<br>
    Vietnamads.vn sẽ đánh dấu lên ảnh để tránh cho người xem copy ảnh của bạn.
    Chúng tôi khuyễn khích đăng ảnh bạn sở hữu, tự chụp hoặc không có dấu tích trên ảnh.</p>
