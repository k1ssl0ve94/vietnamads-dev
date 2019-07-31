<div class="create-product-form" id="form-create-find" v-cloak>
    <form action="" @submit.prevent="submit">
        <p class="text-red">Lưu ý: Các thông tin có dấu (*) là bắt buộc bạn phải khai báo. Chúng tôi sẽ sử dụng thông tin đó để hiển thị theo xu hướng
            tìm kiếm của người dùng giúp tin rao của bạn tiếp cận hiểu quả nhất đến người dùng!</p>
        @if(!isset($product))
        <h6>Thông tin cơ bản</h6>
        <div class="alert alert-danger" v-if="msg" role="alert">@{{ msg }}</div>
        <div class="divider"></div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Tiêu đề tin rao của bạn <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="Nhập tiêu đề" v-model="form.title" required >
                    <span v-if="errors.title" class="form-text text-danger">@{{ errors.title[0] }}</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="">Dịch vụ quảng cáo mà bạn tìm kiếm ? <span class="text-danger">*</span></label>
                    <select class="form-control" v-model="form.category" required >
                        <option value="">Chọn dịch vụ cần tìm</option>
                        <option v-for="item in categories" :value="item.id">@{{ item.name }}</option>
                    </select>
                    <span v-if="errors.category" class="form-text text-danger">@{{ errors.category[0] }}</span>
                </div>
            </div>
        </div>
        <div class="divider"></div>
        <div class="row">
            <div class="col-12">
                <label>Vị trí quảng cáo bạn cung cấp càng nhiều thông tin thì khả năng được tìm càng cao <span class="text-danger">*</span></label>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <select class="form-control" v-model="form.city" required >
                        <option value="">Chọn tỉnh, thành phố</option>
                        <option v-for="city in cities" :value="city.id">@{{ city.name }}</option>
                    </select>
                    <span v-if="errors.city" class="form-text text-danger">@{{ errors.city[0] }}</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <select class="form-control" v-model="form.district">
                        <option value="">Chọn quận huyện</option>
                        <option v-for="d in districts" :value="d.id">@{{ d.pre + ' ' + d.name }}</option>
                    </select>
                    <span v-if="errors.district" class="form-text text-danger">@{{ errors.district[0] }}</span>
                </div>
            </div>
        </div>
        <div class="divider"></div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Giá</label>
                    <select class="form-control" v-model="price_type">
                        <option value="1">Thỏa thuận</option>
                        <option value="2">Cụ thể(VNĐ)</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row" v-show="price_type == '2'">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">Mức giá bạn đưa ra cho người xem (điền số) <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" v-model="form.price" placeholder="Nhập mức giá">
                    <span v-if="errors.price" class="form-text text-danger">@{{ errors.price[0] }}</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">Đơn vị giá bạn đưa ra cho người xem (vd: 500 triệu/năm hoặc 30 triệu/tháng) <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" v-model="form.price_unit" placeholder="Nhập đơn vị giá">
                    <span v-if="errors.price_unit" class="form-text text-danger">@{{ errors.price_unit[0] }}</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    Tổng tiền: @{{ form.price | numFormat}} vnđ / @{{ form.price_unit }}
                </div>
            </div>
        </div>
        @endif
        <h6>Thông tin mô tả <span class="text-danger">*</span></h6>
        <div class="divider"></div>
        <div class="form-group">
            <textarea class="form-control" v-model="form.content" rows="6" placeholder="Nhập tối đa 3000 ký tự *" required ></textarea>
            <span v-if="errors.content" class="form-text text-danger">@{{ errors.content[0] }}</span>
        </div>
        <h5>Liên hệ</h5>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="">Tên người liên hệ của nhà cung cấp? <span class="text-danger">*</span></label>
                    <input type="text" v-model="form.contact_name" class="form-control" placeholder="Nhập tên liên hệ *" required >
                    <span v-if="errors.contact_name" class="form-text text-danger">@{{ errors.contact_name[0] }}</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="">Số điện thoại người cung cấp <span class="text-danger">*</span></label>
                    <input type="text" v-model="form.contact_phone" class="form-control" placeholder="Điện thoại *" required >
                    <span v-if="errors.contact_phone" class="form-text text-danger">@{{ errors.contact_phone[0] }}</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="">Địa chỉ liên hệ <span class="text-danger">*</span></label>
                    <input type="text" v-model="form.contact_address" class="form-control" placeholder="Nhập địa chỉ *" required >
                    <span v-if="errors.contact_address" class="form-text text-danger">@{{ errors.contact_address[0] }}</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="">Email để liện lạc với người cung cấp <span class="text-danger">*</span></label>
                    <input type="email" v-model="form.contact_email" class="form-control" placeholder="Email *" required >
                    <span v-if="errors.contact_email" class="form-text text-danger">@{{ errors.contact_email[0] }}</span>
                </div>
            </div>
        </div>
        @include('partials.current_images')
        @include('partials.select-position-on-map')
        @include('partials.service-packages')
        <div class="row">
            <div class="col-md-6 pt-2">
                <button class="btn btn-primary" type="submit">Đăng tin</button>
                <button class="btn btn-link" @click.prevent="reset">Reset</button>
            </div>
        </div>
    </form>
</div>