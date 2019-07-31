<div class="card card-primary" id="advanced-search" data-cat="{{ isset($cat) && isset($cat['id']) ? $cat['id'] : '' }}" data-sub-cat="{{ isset($subCat) && isset($subCat['id']) ? $subCat['id'] : '' }}" v-cloak>
    <div class="card-header"><h2>Tìm kiếm nâng cao</h2></div>
    <div class="card-body">
        <div class="form-group">
            <v-select :options="cats" :searchable="false" v-model="cat"></v-select>
        </div>
        <div class="form-group" v-if="subCats.length > 0">
            <v-select :options="subCats" :searchable="false" v-model="sub_cat"></v-select>
        </div>
        <template v-if="cat_id == 4 && productData.web">
            <div class="form-group">
                <v-select :options="webTypes" :searchable="false" v-model="form.web_type"></v-select>
            </div>
            <div class="form-group">
                <v-select :options="webPositions" :searchable="false" v-model="form.web_position"></v-select>
            </div>
        </template>
        <div class="form-group">
            <v-select :options="cities" v-model="form.city" placeholder="Chọn tỉnh/thành phố"></v-select>
        </div>
        <div class="form-group">
            <v-select :options="districts" v-model="form.district" :resetOnOptionsChange="true"></v-select>
        </div>
        <div class="form-group" v-show="is_show_ward">
            <v-select :options="wards" v-model="form.ward" :resetOnOptionsChange="true"></v-select>
        </div>
        <div class="form-group" v-show="is_show_street">
            <v-select :options="streets" v-model="form.street" :resetOnOptionsChange="true"></v-select>
        </div>
        <div class="form-group" v-show="is_show_provider">
            <v-select :options="providers" :searchable="false" v-model="form.provider"></v-select>
        </div>
        <div class="form-group">
            <v-select :options="priceRanges" :searchable="false" v-model="form.price_range"></v-select>
        </div>
        <template v-if="cat_id == 1 && productData.pano">
            <div class="form-group" v-show="is_pano_type">
                <v-select :options="panoTypes" :searchable="false" v-model="form.pano_type"></v-select>
            </div>
            <div class="form-group" v-show="is_pano_size">
                <v-select :options="panoSizes" :searchable="false" v-model="form.pano_size"></v-select>
            </div>
            <div class="form-group" v-show="is_pano_border">
                <v-select :options="panoBorders" :searchable="false" v-model="form.pano_border"></v-select>
            </div>
            <div class="form-group" v-show="is_pano_light">
                <v-select :options="panoLights" :searchable="false" v-model="form.pano_light"></v-select>
            </div>
        </template>
        <div class="form-group text-center">
            <button class="btn btn-primary" @click.prevent="submit">Xác nhận lọc</button>
            <button class="btn btn-link" @click.prevent="reset">Reset bộ lọc</button>
        </div>
    </div>
</div>