<div id="box-search" v-cloak>
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="nav-tab-1" data-toggle="tab" href="#nav-content-1" role="tab"
                aria-controls="nav-content-1" aria-selected="true"><?php echo e($productConfig['category'][0]['name']); ?></a>
            <a class="nav-item nav-link" id="nav-tab-2" data-toggle="tab" href="#nav-content-2" role="tab"
                aria-controls="nav-content-2" aria-selected="false"><?php echo e($productConfig['category'][1]['name']); ?></a>
            <a class="nav-item nav-link" id="nav-tab-3" data-toggle="tab" href="#nav-content-3" role="tab"
                aria-controls="nav-content-3" aria-selected="false"><?php echo e($productConfig['category'][2]['name']); ?></a>
            <a class="nav-item nav-link" id="nav-tab-4" data-toggle="tab" href="#nav-content-4" role="tab"
                aria-controls="nav-content-4" aria-selected="false"><?php echo e($productConfig['category'][3]['name']); ?></a>
            <a class="nav-item nav-link" id="nav-tab-5" data-toggle="tab" href="#nav-content-5" role="tab"
                aria-controls="nav-content-5" aria-selected="false"><?php echo e($productConfig['category'][4]['name']); ?></a>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-content-1" role="tabpanel" aria-labelledby="nav-tab-1">
            <div class="form-group">
                <select class="form-control" v-model="form_pano.sub_cat">
                    <option value>Chọn hình thức</option>
                    <option v-for="cat in panoCats" :value="cat.id">{{ cat.name }}</option>
                </select>
            </div>
            <div class="form-group">
                <select class="form-control" v-model="form_pano.city">
                    <option value>{{ pano_city_default_text }}</option>
                    <option v-for="city in orderedCities" :value="city.id">{{ city.name }}</option>
                </select>
            </div>
            <div class="form-group">
                <select class="form-control" v-model="form_pano.district">
                    <option value>{{ pano_district_default_text }}</option>
                    <option v-for="d in districts" :value="d.id">{{ d.pre + ' ' + d.name }}</option>
                </select>
            </div>
            <div class="form-group" v-show="is_pano_show_street">
                <select class="form-control" v-model="form_pano.street">
                    <option value>Chọn đường</option>
                    <option v-for="d in panoStreets" :value="d.id">{{ d.pre + ' ' + d.name }}</option>
                </select>
            </div>
            <div class="form-group" v-show="is_pano_show_ward">
                <select class="form-control" v-model="form_pano.ward">
                    <option value>Chọn phường xã</option>
                    <option v-for="d in panoWards" :value="d.id">{{ d.pre + ' ' + d.name }}</option>
                </select>
            </div>
            <div class="form-group" v-show="is_pano_show_type">
                <select class="form-control" v-if="productData.pano" v-model="form_pano.pano_type">
                    <option value>Chọn loại biển</option>
                    <option v-for="item in productData.pano.type" :value="item.id">{{ item.name }}</option>
                </select>
            </div>
            <div class="form-group"v-show="is_pano_show_size">
                <select class="form-control" v-if="productData.pano" v-model="form_pano.pano_size">
                    <option value>Chọn kích thước</option>
                    <option v-for="item in productData.pano.size" :value="item.id">{{ item.name }}</option>
                </select>
            </div>
            <div class="form-group">
                <select class="form-control" v-if="productData.pano" v-model="form_pano.provider">
                    <option value>Chọn đơn vị cung cấp</option>
                    <option v-for="item in productData.provider" :value="item.id">{{ item.name }}</option>
                </select>
            </div>
            <div class="form-group">
                <select class="form-control" v-if="productData.pano" v-model="form_pano.price_range">
                    <option value>Chọn khoảng giá</option>
                    <option v-for="item in productData.price_range" :value="item.id">{{ item.name }}</option>
                </select>
            </div>
            <div class="d-flex">
                <a href="<?php echo e(route('category', ['catSlug' => config('product.category')[0]['slug']])); ?>" class="mr-auto text-danger font-weight-bold"><i class="fa fa-plus-circle" aria-hidden="true"></i> <?php echo e(__('msg.search_advanced')); ?></a>
                <button class="btn btn-primary btn-sm ml-auto" @click.prevent="searchPano"><?php echo e(__('msg.search_fast')); ?></button>
            </div>
        </div>
        <div class="tab-pane fade" id="nav-content-2" role="tabpanel" aria-labelledby="nav-tab-2">
            <div class="form-group">
                <select class="form-control" v-model="form_ad.sub_cat">
                    <option value>Chọn hình thức</option>
                    <option v-for="cat in adCats" :value="cat.id">{{ cat.name }}</option>
                </select>
            </div>
            <div class="form-group">
                <select class="form-control" v-model="form_ad.city">
                    <option value>Chọn tỉnh, thành phố (nơi cung cấp)</option>
                    <option v-for="city in orderedCities" :value="city.id">{{ city.name }}</option>
                </select>
            </div>
            <div class="form-group">
                <select class="form-control" v-model="form_ad.district">
                    <option value>Chọn quận, huyện (nơi cung cấp)</option>
                    <option v-for="d in adDistricts" :value="d.id">{{ d.pre + ' ' + d.name }}</option>
                </select>
            </div>
            <div class="form-group">
                <select class="form-control" v-if="productData.ad" v-model="form_ad.provider">
                    <option value>Chọn đơn vị cung cấp</option>
                    <option v-for="item in productData.provider" :value="item.id">{{ item.name }}</option>
                </select>
            </div>
            <div class="form-group">
                <select class="form-control" v-if="productData.ad" v-model="form_ad.price_range">
                    <option value>Chọn khoảng giá</option>
                    <option v-for="item in productData.price_range" :value="item.id">{{ item.name }}</option>
                </select>
            </div>
            <div class="d-flex">
                <a href="<?php echo e(route('category', ['catSlug' => config('product.category')[1]['slug']])); ?>" class="mr-auto text-danger font-weight-bold"><i class="fa fa-plus-circle" aria-hidden="true"></i> <?php echo e(__('msg.search_advanced')); ?></a>
                <button class="btn btn-primary btn-sm ml-auto" @click.prevent="searchAd"><?php echo e(__('msg.search_fast')); ?></button>
            </div>
        </div>
        <div class="tab-pane fade" id="nav-content-3" role="tabpanel" aria-labelledby="nav-tab-3">
            <div class="form-group">
                <select class="form-control" v-model="form_social.sub_cat">
                    <option value>Chọn hình thức</option>
                    <option v-for="cat in socialCats" :value="cat.id">{{ cat.name }}</option>
                </select>
            </div>
            <div class="form-group">
                <select class="form-control" v-model="form_social.city">
                    <option value>Chọn tỉnh, thành phố (nơi cung cấp)</option>
                    <option v-for="city in orderedCities" :value="city.id">{{ city.name }}</option>
                </select>
            </div>
            <div class="form-group">
                <select class="form-control" v-model="form_social.district">
                    <option value>Chọn quận, huyện (nơi cung cấp)</option>
                    <option v-for="d in socialDistricts" :value="d.id">{{ d.pre + ' ' + d.name }}</option>
                </select>
            </div>
            <div class="form-group">
                <select class="form-control" v-if="productData.social" v-model="form_social.provider">
                    <option value>Chọn đơn vị cung cấp</option>
                    <option v-for="item in productData.provider" :value="item.id">{{ item.name }}</option>
                </select>
            </div>
            <div class="form-group">
                <select class="form-control" v-if="productData.social" v-model="form_social.price_range">
                    <option value>Chọn khoảng giá</option>
                    <option v-for="item in productData.price_range" :value="item.id">{{ item.name }}</option>
                </select>
            </div>
            <div class="d-flex">
                <a href="<?php echo e(route('category', ['catSlug' => config('product.category')[2]['slug']])); ?>" class="mr-auto text-danger font-weight-bold"><i class="fa fa-plus-circle" aria-hidden="true"></i> <?php echo e(__('msg.search_advanced')); ?></a>
                <button class="btn btn-primary btn-sm ml-auto" @click.prevent="searchSocial"><?php echo e(__('msg.search_fast')); ?></button>
            </div>
        </div>
        <div class="tab-pane fade" id="nav-content-4" role="tabpanel" aria-labelledby="nav-tab-4">
            <div class="form-group">
                <select class="form-control" v-model="form_web.sub_cat">
                    <option value>Chọn loại trang</option>
                    <option v-for="cat in adsCats" :value="cat.id">{{ cat.name }}</option>
                </select>
            </div>
            <div class="form-group">
                <select class="form-control" v-if="productData.web" v-model="form_web.web_type">
                    <option value>Loại hình thức hiển thị</option>
                    <option v-for="item in productData.web.type" :value="item.id">{{ item.name }}</option>
                </select>
            </div>
            <div class="form-group">
                <select class="form-control" v-if="productData.web" v-model="form_web.web_position">
                    <option value>Chọn trang xuất hiện</option>
                    <option v-for="item in productData.web.position" :value="item.id">{{ item.name }}</option>
                </select>
            </div>
            <div class="form-group">
                <select class="form-control" v-model="form_web.city">
                    <option value>Chọn tỉnh, thành phố (nơi cung cấp)</option>
                    <option v-for="city in orderedCities" :value="city.id">{{ city.name }}</option>
                </select>
            </div>
            <div class="form-group">
                <select class="form-control" v-model="form_web.district">
                    <option value>Chọn quận, huyện (nơi cung cấp)</option>
                    <option v-for="d in webDistricts" :value="d.id">{{ d.pre + ' ' + d.name }}</option>
                </select>
            </div>
            <div class="form-group">
                <select class="form-control" v-if="productData.web" v-model="form_web.provider">
                    <option value>Chọn đơn vị cung cấp</option>
                    <option v-for="item in productData.provider" :value="item.id">{{ item.name }}</option>
                </select>
            </div>
            <div class="form-group">
                <select class="form-control" v-if="productData.web" v-model="form_web.price_range">
                    <option value>Chọn khoảng giá</option>
                    <option v-for="item in productData.price_range" :value="item.id">{{ item.name }}</option>
                </select>
            </div>
            <div class="d-flex">
                <a href="<?php echo e(route('category', ['catSlug' => config('product.category')[3]['slug']])); ?>" class="mr-auto text-danger font-weight-bold"><i class="fa fa-plus-circle" aria-hidden="true"></i> <?php echo e(__('msg.search_advanced')); ?></a>
                <button class="btn btn-primary btn-sm ml-auto" @click.prevent="searchAdsBanner"><?php echo e(__('msg.search_fast')); ?></button>
            </div>
        </div>
        <div class="tab-pane fade" id="nav-content-5" role="tabpanel" aria-labelledby="nav-tab-4">
            <div class="form-group">
                <select class="form-control" v-model="form_other.sub_cat">
                    <option value>Chọn hình thức</option>
                    <option v-for="cat in webCats" :value="cat.id">{{ cat.name }}</option>
                </select>
            </div>
            <div class="form-group">
                <select class="form-control" v-model="form_other.city">
                    <option value>Chọn tỉnh, thành phố (nơi cung cấp)</option>
                    <option v-for="city in orderedCities" :value="city.id">{{ city.name }}</option>
                </select>
            </div>
            <div class="form-group">
                <select class="form-control" v-model="form_other.district">
                    <option value>Chọn quận, huyện (nơi cung cấp)</option>
                    <option v-for="d in otherDistricts" :value="d.id">{{ d.pre + ' ' + d.name }}</option>
                </select>
            </div>
            <div class="form-group">
                <select class="form-control" v-if="productData" v-model="form_other.provider">
                    <option value>Chọn đơn vị cung cấp</option>
                    <option v-for="item in productData.provider" :value="item.id">{{ item.name }}</option>
                </select>
            </div>
            <div class="form-group">
                <select class="form-control" v-if="productData" v-model="form_other.price_range">
                    <option value>Chọn khoảng giá</option>
                    <option v-for="item in productData.price_range" :value="item.id">{{ item.name }}</option>
                </select>
            </div>
            <div class="d-flex">
                <a href="<?php echo e(route('category', ['catSlug' => config('product.category')[4]['slug']])); ?>" class="mr-auto text-danger font-weight-bold"><i class="fa fa-plus-circle" aria-hidden="true"></i> <?php echo e(__('msg.search_advanced')); ?></a>
                <button class="btn btn-primary btn-sm ml-auto" @click.prevent="searchWeb"><?php echo e(__('msg.search_fast')); ?></button>
            </div>
        </div>
    </div>
</div>