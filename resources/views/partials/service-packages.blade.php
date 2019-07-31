@if(!isset($product))
<h5>Lịch đăng tin (Bạn phải chọn gói đăng tin và số ngày đăng)</h5>
<div class="divider"></div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <select class="form-control" id="package_value" required
                    name="level" v-model="form.level" v-if="servicePackages.length"
             @change="selectPackage">
                <option value="0">- Chọn gói đăng -</option>
                <option v-for="spackage in servicePackages"
                        :value="spackage.id" :key="spackage.id"
                    >
                    @{{spackage.name}}
                </option>
            </select>
            <select class="form-control" id="package_option" required
                    name="package_option" v-model="form.package_option"
                @change="calculateFee">
                <option value="0">Chọn số ngày đăng</option>
                <option v-for="option in selectedPackage.options"
                        :value="option.id" :key="option.id">
                    @{{option.name}} (@{{option.days}} ngày):
                    @{{option.totalFee}} VNĐ
                </option>
            </select>
            <p class="text-red font-weight-bold" style="font-size: 15px">
                Giá tiền:
                <span v-if="totalFee">@{{ totalFee }} vnđ</span>
                <span v-else>Chọn ngày đăng</span>
            </p>
        </div>
    </div>
    <div class="col-md-8">
        <div class="text-red font-weight-bold" style="font-size: 15px">
            <div v-if="form.level != '0' && selectedPackage.id != ''">
                <p>Thời gian làm mới sau: @{{selectedPackage.manual_refresh | numFormat}} giờ.</p>
                <p :style="'color:' + selectedPackage.title_color"><strong>Màu tiêu đề</strong></p>
                <p :style="'color:' + selectedPackage.parameter_color"><strong>Màu thông số</strong></p>
                <p :style="'color:' + selectedPackage.price_color"><strong>Giá: @{{ totalFee }} vnđ</strong></p>
            </div>
        </div>
    </div>
</div>
@endif
