<?php
    $title = '';
    $description = '';
    $metaTitle = 'VietnamAds';
    $metaKeys = 'VietnamAds';
    $metaDescription = 'VietnamAds';
    $metaCanonical = \Illuminate\Support\Facades\Request::url();
    $isClassCategory = false;
    if ($cat && isset($cat['name'])) {
        $title .= $cat['name'];
        $description = $cat['description'];
        $metaDescription = $description;
    }
    if (!empty($subCat) && !empty($subCat->name)){
        $title .=  strtolower(' ' . $subCat->name);
        if ($subCat->description) {
            $description = $subCat->description;
        }
        $metaKeys = $subCat->meta_keywords ? : $metaKeys;
        $metaDescription = $subCat->meta_description ? : $metaDescription;
        $metaCanonical = $subCat->meta_canonical ? : $metaCanonical;
    } else {
        $subCat = null;
    }
    if ($city) {
        $c = \App\Lib\Location::getCity($city);
        if ($c && isset($cat['name'])) {
            $title .= ' ' . $c['name'];
        }
    }
    if(isset($classCategory) && $classCategory) {
        $title = $classCategory->name;
        $isClassCategory = true;
        if ($classCategory->description) {
            $description = $classCategory->description;
        }
        $metaKeys = $classCategory->meta_keywors ? : $metaKeys;
        $metaDescription = $classCategory->meta_description ? : $metaDescription;
        $metaCanonical = $classCategory->meta_canonical ? : $metaCanonical;
    }
    $title = trim($title). " trên bản đồ";
    $metaDescription = "Xem trên bản đồ ".$metaDescription;
?>
<?php $__env->startSection('title'); ?> <?php if(!empty($cat)): ?>
<title><?php echo e($title); ?> | VietnamAds</title>
<?php else: ?>
<title>Tin rao | VietnamAds</title>
<?php endif; ?> <?php echo $__env->yieldSection(); ?>

<?php $__env->startSection('meta-tags'); ?>
    <meta name="keywords" content="<?php echo e($metaKeys); ?>">
    <meta name="description" content="<?php echo e($metaDescription); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main'); ?>
<script>
    window.map_params = <?php echo json_encode($params); ?>;
</script>
<div class="row">
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">
                <h2><?php echo e($title); ?></h2>
            </div>
            <div class="card-body" id="map-container" v-cloak>
                <div class="row">
                    <div class="col-12">
                        <div class="product-filter">
                            <form action="" class="form-inline">
                                <span>Sắp xếp theo: </span>
                                <select class="form-control" name="order" v-model="order">
                                    <option value="">Thông thường</option>
                                    <option value="newest">Tin mới nhất</option>
                                    <option value="no_price">Giá thỏa thuận</option>
                                    <option value="lowest_price">Giá thấp nhất</option>
                                    <option value="highest_price">Giá cao nhất</option>
                                </select>
                                <div class="form-check ml-3">
                                    <input type="checkbox" class="form-check-input" id="productHasImage" v-model="has_image">
                                    <label class="form-check-label" for="productHasImage">Tin rao có ảnh</label>
                                </div>
                                <div class="form-check ml-3">
                                    <input type="checkbox" class="form-check-input" id="productHasVideo" v-model="has_video">
                                    <label class="form-check-label" for="productHasVideo">Tin rao video</label>
                                </div>
                                <a href="<?php echo e($viewListUrl); ?>" class="btn btn-link">Xem danh sách</a>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3" id="map-product-list">
                        <template v-if="params.city">
                            <div class="post clearfix product-map" v-for="p in products">
                                <h3>
                                    <a :href="p.link" class="title d-block" :title="p.title">{{ p.title_limit }}</a>
                                </h3>
                                <div class="thumb rounded">
                                    <a :href="p.link" :title="p.title">
                                        <img :src="p.thumb_url" class="img-fluid" :alt="p.title">
                                    </a>
                                </div>
                                <div class="info">
                                    <ul class="meta">
                                        <li><img src="/imgs/icons/meta_icon_4.png" class="meta-icon"> {{ p.price_text }}</li>
                                        <li><img src="/imgs/icons/meta_icon_1.png" class="meta-icon"> {{ p.to_date_text }}</li>
                                        <li><img src="/imgs/icons/meta_icon_3.png" class="meta-icon"> {{ p.location_text }}</li>
                                    </ul>
                                </div>
                            </div>
                            <p class="text-center" v-if="products.length == 0">Không tìm thấy tin rao nào</p>
                        </template>
                        <template v-else>
                            <p class="text-center text-danger font-weight-bold">Hãy lựa chọn địa điểm</p>
                        </template>
                    </div>
                    <div class="col-md-9">
                        <div>
                            <gmap-map :center="position" :zoom="12" map-type-id="roadmap" style="width: 100%; height: 680px" ref="gmap" @idle="syncMap">
                                <gmap-info-window :options="infoOptions" :position="infoWindowPos" :opened="infoWinOpen" @closeclick="infoWinOpen=false">
                                    <div class="marker-product-info clearfix">
                                        <h5><a :href="current_product.link">{{ current_product.title_limit }}</a></h5>
                                        <a class="thumb" :href="current_product.link"><img :src="current_product.thumb_url"></a>
                                        <div class="pb-1"><strong>Giá</strong>: {{ current_product.price_text }}</div>
                                        <div><strong>Thời gian</strong>: {{ current_product.to_date_text }}</div>
                                    </div>
                                </gmap-info-window>
                                <gmap-marker :key="i" v-for="(p, i) in products" :position="p.position" :clickable="true" @click="toggleInfoWindow(p,i)" />
                            </gmap-map>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row" id="advanced-search-map" data-cat="<?php echo e($cat ? $cat['id'] : ''); ?>" data-sub-cat="<?php echo e(isset($subCat) && isset($subCat['id']) ? $subCat['id'] : ''); ?>">
                    <div class="form-group col-md-3" v-if="subCats.length > 0">
                        <v-select :options="subCats" :searchable="false" v-model="sub_cat"></v-select>
                    </div>
                    <template v-if="cat_id == 4 && productData.web">
                        <div class="form-group col-md-3">
                            <v-select :options="webTypes" :searchable="false" v-model="form.web_type"></v-select>
                        </div>
                        <div class="form-group col-md-3">
                            <v-select :options="webPositions" :searchable="false" v-model="form.web_position"></v-select>
                        </div>
                    </template>
                    <div class="form-group col-md-3">
                        <v-select :options="cities" v-model="form.city" placeholder="Chọn tỉnh/thành phố"></v-select>
                    </div>
                    <div class="form-group col-md-3">
                        <v-select :options="districts" v-model="form.district" :resetOnOptionsChange="true"></v-select>
                    </div>
                    <div class="form-group col-md-3" v-show="is_show_ward">
                        <v-select :options="wards" v-model="form.ward" :resetOnOptionsChange="true"></v-select>
                    </div>
                    <div class="form-group col-md-3" v-show="is_show_street">
                        <v-select :options="streets" v-model="form.street" :resetOnOptionsChange="true"></v-select>
                    </div>
                    <div class="form-group col-md-3" v-show="is_show_provider">
                        <v-select :options="providers" :searchable="false" v-model="form.provider"></v-select>
                    </div>
                    <div class="form-group col-md-3">
                        <v-select :options="priceRanges" :searchable="false" v-model="form.price_range"></v-select>
                    </div>
                    <template v-if="cat_id == 1 && productData.pano">
                        <div class="form-group col-md-3" v-show="is_pano_type">
                            <v-select :options="panoTypes" :searchable="false" v-model="form.pano_type"></v-select>
                        </div>
                        <div class="form-group col-md-3" v-show="is_pano_size">
                            <v-select :options="panoSizes" :searchable="false" v-model="form.pano_size"></v-select>
                        </div>
                        <div class="form-group col-md-3" v-show="is_pano_border">
                            <v-select :options="panoBorders" :searchable="false" v-model="form.pano_border"></v-select>
                        </div>
                        <div class="form-group col-md-3" v-show="is_pano_light">
                            <v-select :options="panoLights" :searchable="false" v-model="form.pano_light"></v-select>
                        </div>
                    </template>
                    <div class="form-group col-12">
                        <button class="btn btn-primary" @click.prevent="submit">Xác nhận lọc</button>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('master_one_column', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>