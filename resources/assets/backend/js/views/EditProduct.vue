<template>
    <div
        id="edit-product"
        class="row"
    >
        <div class="col-md-12">
            <form
                action
                @submit.prevent="editProduct"
            >
                <div class="card">
                    <dimmer v-show="loading" />
                    <div class="card-header">
                        <h2 class="card-title">Edit Product #{{id}}</h2>
                    </div>
                    <form-message />
                    <div
                        class="card-body"
                        v-if="!loading"
                    >
                        <div class="form-row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Language</label>
                                    <select v-model="form.lang" class="form-control">
                                        <option value="0">Vietnamese</option>
                                        <option value="1">English</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Title</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="form.title"
                                        required
                                    >
                                </div>
                                <div class="form-group">
                                    <label>Content</label>
                                    <textarea
                                        class="form-control"
                                        rows="6"
                                        v-model="form.content"
                                        required
                                    ></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Images</label>
                                    <vue-dropzone
                                        id="create-pano-dropzone"
                                        ref="createPanoDropzone"
                                        :options="dropzoneOptions"
                                        :use-custom-slot="true"
                                        v-on:vdropzone-sending="sendingEvent"
                                        v-on:vdropzone-success="onUploadSuccess"
                                        v-on:vdropzone-removed-file="removeImage"
                                    >
                                        <div class="dropzone-custom-content">
                                            <h6 class="dropzone-custom-title">Click để tải ảnh hoặc kéo thả vào đây</h6>
                                        </div>
                                    </vue-dropzone>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select
                                                class="form-control"
                                                v-model="price_type"
                                            >
                                                <option value="1">Thỏa thuận</option>
                                                <option value="2">Cụ thể(VNĐ)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="row"
                                    v-if="price_type == '2'"
                                >
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Mức giá</label>
                                            <input
                                                type="text"
                                                class="form-control"
                                                v-model="form.price"
                                                placeholder="Nhập mức giá"
                                            >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Đơn vị</label>
                                            <input
                                                type="text"
                                                class="form-control"
                                                v-model="form.price_unit"
                                                placeholder="Nhập đơn vị giá"
                                            >
                                        </div>
                                    </div>
                                    <!--<div class="col-md-6">-->
                                        <!--<div class="form-group">-->
                                            <!--<datetime-->
                                                <!--type="date"-->
                                                <!--input-id="create-web-from"-->
                                                <!--v-model="form.from"-->
                                                <!--input-class="form-control"-->
                                                <!--placeholder="Chọn ngày bắt đầu"-->
                                            <!--&gt;</datetime>-->
                                        <!--</div>-->
                                    <!--</div>-->
                                    <!--<div class="col-md-6">-->
                                        <!--<div class="form-group">-->
                                            <!--<datetime-->
                                                <!--type="date"-->
                                                <!--input-id="create-web-to"-->
                                                <!--v-model="form.to"-->
                                                <!--input-class="form-control"-->
                                                <!--placeholder="Chọn ngày kết thúc"-->
                                            <!--&gt;</datetime>-->
                                        <!--</div>-->
                                    <!--</div>-->
                                </div>
                                <div
                                    class="row"
                                    v-if="metadata.product"
                                >
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Category</label>
                                            <select
                                                class="form-control"
                                                v-model="form.category_parent"
                                            >
                                                <option value>Select Category</option>
                                                <template v-if="metadata && metadata.product">
                                                    <option
                                                        v-for="item in metadata.product.category"
                                                        :value="item.id"
                                                        :key="item.id"
                                                    >{{ item.name }}</option>abc
                                                </template>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Sub Category</label>
                                            <select
                                                class="form-control"
                                                v-model="form.category"
                                            >
                                                <option value>Select Sub Category</option>
                                                <option
                                                    v-for="item in subCats"
                                                    :value="item.id"
                                                    :key="item.id"
                                                >{{ item.name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <template v-if="form.category_parent == 1">
                                        <div class="col-md-12">
                                            <h4>Pano biển quảng cáo</h4>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select
                                                    class="form-control"
                                                    v-model="form.pano_type"
                                                >
                                                    <option value>Chọn loại biển</option>
                                                    <option
                                                        v-for="item in metadata.product.pano.type"
                                                        :value="item.id"
                                                        :key="item.id"
                                                    >{{ item.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select
                                                    class="form-control"
                                                    v-model="form.provider"
                                                >
                                                    <option value>Chọn đơn vị cung cấp</option>
                                                    <option
                                                        v-for="item in metadata.product.provider"
                                                        :value="item.id"
                                                        :key="item.id"
                                                    >{{ item.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select
                                                    class="form-control"
                                                    v-model="form.pano_size"
                                                >
                                                    <option value>Chọn kích thước</option>
                                                    <option
                                                        v-for="item in metadata.product.pano.size"
                                                        :value="item.id"
                                                        :key="item.id"
                                                    >{{ item.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <select
                                                class="form-control"
                                                v-model="form.pano_border"
                                            >
                                                <option value>Chọn Khung</option>
                                                <option
                                                    v-for="item in metadata.product.pano.border"
                                                    :value="item.id"
                                                    :key="'pano_border_'+ item.id"
                                                >{{ item.name }}</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select
                                                    class="form-control"
                                                    v-model="form.pano_light"
                                                >
                                                    <option value>Chọn đèn điện</option>
                                                    <option
                                                        v-for="item in metadata.product.pano.light"
                                                        :value="item.id"
                                                        :key="'pano_light_'+ item.id"
                                                    >{{ item.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </template>
                                    <template v-else-if="form.category_parent == 2">
                                        <div class="col-md-12">
                                            <h4>Quảng cáo truyền thông</h4>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <select
                                                    class="form-control"
                                                    v-model="form.provider"
                                                >
                                                    <option value>Chọn đơn vị cung cấp</option>
                                                    <option
                                                        v-for="item in metadata.product.provider"
                                                        :value="item.id"
                                                        :key="'ad_provider_' + item.id"
                                                    >{{ item.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <select
                                                    class="form-control"
                                                    v-model="form.ad_channel"
                                                >
                                                    <option value>Loại kênh</option>
                                                    <option
                                                        v-for="item in metadata.product.ad.channel"
                                                        :value="item.id"
                                                        :key="'ad_channel_' + item.id"
                                                    >{{ item.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <select
                                                    class="form-control"
                                                    v-model="form.ad_coverage"
                                                >
                                                    <option value>Chọn độ phủ sóng</option>
                                                    <option
                                                        v-for="item in metadata.product.ad.coverage"
                                                        :value="item.id"
                                                        :key="'ad_coverage_' + item.id"
                                                    >{{ item.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <select
                                                    class="form-control"
                                                    v-model="form.ad_time"
                                                >
                                                    <option value>Chọn thời lượng xuất bản</option>
                                                    <option
                                                        v-for="item in metadata.product.ad.time"
                                                        :value="item.id"
                                                        :key="'ad_time_' + item.id"
                                                    >{{ item.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </template>
                                    <template v-else-if="form.category_parent == 3">
                                        <div class="col-md-12">
                                            <h4>Digital marketing</h4>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select
                                                    class="form-control"
                                                    v-model="form.social_type"
                                                >
                                                    <option value>Chọn loại quảng cáo</option>
                                                    <option
                                                        v-for="item in metadata.product.social.type"
                                                        :value="item.id"
                                                        :key="'social_type_'+ item.id"
                                                    >{{ item.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select
                                                    class="form-control"
                                                    v-model="form.provider"
                                                >
                                                    <option value>Chọn đơn vị cung cấp</option>
                                                    <option
                                                        v-for="item in metadata.product.provider"
                                                        :value="item.id"
                                                        :key="'social_provider_' + item.id"
                                                    >{{ item.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select
                                                    class="form-control"
                                                    v-model="form.social_follow"
                                                >
                                                    <option value>Lượt theo dõi</option>
                                                    <option
                                                        v-for="item in metadata.product.social.follow"
                                                        :value="item.id"
                                                        :key="'social_follow_'+item.id"
                                                    >{{ item.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </template>
                                    <template v-else-if="form.category_parent == 4">
                                        <div class="col-md-12">
                                            <h4>Ads banner</h4>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select
                                                    class="form-control"
                                                    v-model="form.web_type"
                                                >
                                                    <option value>Chọn hình thức hiển thị</option>
                                                    <option
                                                        v-for="item in metadata.product.web.type"
                                                        :value="item.id"
                                                        :key="'web_type_' + item.id"
                                                    >{{ item.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select
                                                    class="form-control"
                                                    v-model="form.provider"
                                                >
                                                    <option value>Chọn đơn vị cung cấp</option>
                                                    <option
                                                        v-for="item in metadata.product.provider"
                                                        :value="item.id"
                                                        :key="'web_provider_'+item.id"
                                                    >{{ item.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select
                                                    class="form-control"
                                                    v-model="form.web_position"
                                                >
                                                    <option value>Chọn trang xuất hiện</option>
                                                    <option
                                                        v-for="item in metadata.product.web.position"
                                                        :value="item.id"
                                                        :key="'web_position_' + item.id "
                                                    >{{ item.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </template>
                                    <template v-else-if="form.category_parent == 5">
                                        <div class="col-md-12">
                                            <h4>Nghiệp vụ khác</h4>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <select
                                                    class="form-control"
                                                    v-model="form.provider"
                                                >
                                                    <option value>Chọn đơn vị cung cấp</option>
                                                    <option
                                                        v-for="item in metadata.product.provider"
                                                        :value="item.id"
                                                        :key="'other_provider_' +item.id"
                                                    >{{ item.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                                <div class="form-group">
                                    <v-select
                                        taggable
                                        multiple
                                        v-model="form.tags_text"
                                        :options="tagOptions"
                                        @search="onSearchTag"
                                        :filterBy="filterFunction"
                                    ></v-select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>User ID</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="user_id"
                                        v-model="form.user_id"
                                        required
                                    >
                                </div>
                                <div class="form-group">
                                    <label>City</label>
                                    <select
                                        class="form-control"
                                        name="status"
                                        v-model="form.city"
                                    >
                                        <option value>Select a city</option>
                                        <option
                                            v-for="city in cities"
                                            :value="city.id"
                                            :key="city.id"
                                        >{{ city.name }}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select
                                        class="form-control"
                                        v-model="form.district"
                                    >
                                        <option value>Chọn quận huyện</option>
                                        <option
                                            v-for="d in districts"
                                            :value="d.id"
                                            :key="d.id"
                                        >{{ d.pre + ' ' + d.name }}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select
                                        class="form-control"
                                        v-model="form.ward"
                                    >
                                        <option value>select ward</option>
                                        <option
                                            v-for="w in wards"
                                            :value="w.id"
                                            :key="w.id"
                                        >{{ w.pre + ' ' + w.name }}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select
                                        class="form-control"
                                        v-model="form.street"
                                    >
                                        <option value>select street</option>
                                        <option
                                            v-for="s in streets"
                                            :value="s.id"
                                            :key="s.id"
                                        >{{ s.pre + ' ' + s.name }}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Contact Name</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="form.contact_name"
                                    >
                                </div>
                                <div class="form-group">
                                    <label>Contact Phone</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="form.contact_phone"
                                    >
                                </div>
                                <div class="form-group">
                                    <label>Contact Email</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="form.contact_email"
                                    >
                                </div>
                                <div class="form-group">
                                    <label>Contact Address</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="form.contact_address"
                                    >
                                </div>
                                <div class="form-group">
                                    <label>Note</label>
                                    <textarea
                                        class="form-control"
                                        rows="4"
                                        v-model="form.note"
                                    ></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12">
                                <h5>Map</h5>
                            </div>
                            <div class="col-12">
                                <GmapMap
                                    :center="mapCenter"
                                    :zoom="14"
                                    map-type-id="roadmap"
                                    style="width: 100%; height: 400px"
                                    @center_changed="mapUpdateCenter"
                                    @idle="syncMap"
                                >
                                    <GmapMarker :position="reportedMapCenter" />
                                </GmapMap>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex">
                        <router-link
                            to="/products"
                            class="btn btn-link"
                        >Cancel</router-link>
                        <button
                            type="submit"
                            class="btn btn-primary ml-auto"
                        >Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { mapState } from 'vuex';
import { format as dateFormat, parse as parseDate } from 'date-fns';

export default {
    data() {
        return {
            loading: false,
            form: {
                title: '',
                content: '',
                city: '',
                district: '',
                ward: '',
                street: '',
                status: 0,
                level: 1,
                category: '',
                category_parent: '',
                user_id: '',
                images: [],
                provider: '',
                contact_name: '',
                contact_phone: '',
                contact_email: '',
                contact_address: '',
                youtube_link: '',
                direct_link1: '',
                direct_link2: '',
                direct_link3: '',
                direct_link4: '',
                from: '',
                to: '',
                price: '',
                price_unit: '',
                // pano
                pano_type: '',
                pano_size: '',
                pano_border: '',
                pano_light: '',

                // ad
                ad_channel: '',
                ad_coverage: '',
                ad_time: '',

                // social
                social_type: '',
                social_follow: '',

                // web
                web_type: '',
                web_position: '',

                tags_text: [],
                lat: 0,
                long: 0
            },
            reportedMapCenter: { lat: 21.0227788, lng: 105.8194541 },
            mapCenter: { lat: 21.0227788, lng: 105.8194541 },
            tagOptions: [],
            price_type: '1',
            isUploading: false,
            percentCompleted: 0,
            metadata: {},
            defaultForm: {},
            dropzoneOptions: {
                url: '/api/admin/upload',
                addRemoveLinks: true,
                maxFilesize: 3,
                acceptedFiles: 'image/*',
                maxFiles: 12,
                headers: {
                    Authorization: window.axios.defaults.headers.common['Authorization']
                }
            },
            id: 0
        };
    },
    created() {
        this.defaultForm = Object.assign({}, this.form);
        this.fetchMetaData();
        this.id = this.$route.params.id;
        this.fetchProduct();
    },
    watch: {
        'form.category_parent': function(value, oldValue) {
            if (oldValue != '') {
                this.form.category = '';
            }
        },
        'form.city': function() {
            this.form.district = '';
        },
        'form.district': function() {
            this.form.ward = '';
            this.form.street = '';
        }
    },
    computed: {
        ...mapState({
            cities: state => state.common.location
        }),
        subCats() {
            if (!this.form.category_parent) {
                return [];
            }
            if (!this.metadata) {
                return [];
            }
            return this.metadata.category.filter(cat => cat.parent_id == this.form.category_parent);
        },
        districts: function() {
            if (!this.form.city) {
                return [];
            }
            let city = this.cities.find(c => c.id == this.form.city);
            return city.district;
        },
        wards() {
            if (!this.form.district) {
                return [];
            }
            let city = this.cities.find(c => c.id == this.form.city);
            let dist = city.district.find(d => d.id == this.form.district);
            return dist.ward;
        },
        streets() {
            if (!this.form.district) {
                return [];
            }
            let city = this.cities.find(c => c.id == this.form.city);
            let dist = city.district.find(d => d.id == this.form.district);
            return dist.street;
        }
    },
    methods: {
        sendingEvent(file, xhr, formData) {
            formData.append('folder', 'products');
        },
        onUploadSuccess(file, response) {
            this.form.images.push({
                filename: response.file.filename,
                original: response.file.original
            });
        },
        onUploadError(file, message, xhr){
            // console.log(file, 'upload fail');
        },
        removeImage(file, error, xhr) {
            this.form.images = this.form.images.filter(img => img.original != file.name);
        },
        fetchMetaData() {
            axios.get('/api/admin/product-data').then(resp => {
                this.metadata = resp.data;
            });
        },
        fetchProduct() {
            this.loading = true;
            axios
                .get(`/api/admin/products/${this.id}`)
                .then(response => {
                    this.loading = false;
                    this.form = response.data.product;
                    if (this.form.price > 0) {
                        this.price_type = 2;
                    } else {
                        this.price_type = 1;
                    }
                    if (this.form.from) {
                        this.form.from = dateFormat(parseDate(this.form.from), 'YYYY-MM-DDTHH:mm:ssZ');
                    }
                    this.form.pano_border = this.form.pano_border ? this.form.pano_border : '';
                    this.form.pano_light = this.form.pano_light ? this.form.pano_light : '';
                    this.reportedMapCenter = {
                        lat: parseFloat(this.form.lat),
                        lng: parseFloat(this.form.long),
                    };
                    var images = JSON.parse(this.form.images);
                    this.form.images = [];
                    setTimeout(() => {
                        this.initImage(images);
                    }, 500);
                })
                .catch(error => {
                    this.loading = false;
                });
        },
        initImage(images) {
            for (var i = 0; i < images.length; i++) {
                var file = { size: 80, name: images[i], type: 'image/png' };
                var url = `/storage/uploads/products/${images[i]}`;
                this.form.images.push({
                    filename: images[i],
                    original: images[i]
                });
                this.$refs.createPanoDropzone.manuallyAddFile(file, url);
            }
        },
        editProduct() {
            if (this.price_type == '1') {
                this.form.price = 0;
                this.form.price_unit = '';
            }
            this.form.lat = this.reportedMapCenter.lat;
            this.form.long = this.reportedMapCenter.lng;
            this.$store.commit('updateFormErrors', []);
            axios.put(`/api/admin/products/${this.id}`, this.form).then(response => {
                if (response.data.status) {
                    this.$store.dispatch('alertSuccess', 'Edit product success');
                } else {
                    this.$store.dispatch('formErrors', ['Error!!']);
                }
            });
        },
        resetFormData() {
            this.form = Object.assign({}, this.defaultForm);
        },
        onSearchTag(search, loading) {
            loading(true);
            this.searchTag(loading, search, this);
        },
        searchTag: _.debounce((loading, search, vm) => {
            axios.get(`/api/admin/tags?name=${search}`).then(resp => {
                vm.tagOptions = resp.data.tags;
                loading(false);
            });
        }, 350),
        filterFunction(option, label, search) {
            label = label.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
            search = search.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
            return (label || '').toLowerCase().indexOf(search.toLowerCase()) > -1;
        },
        mapUpdateCenter(latLng) {
            this.reportedMapCenter = {
                lat: latLng.lat(),
                lng: latLng.lng()
            };
        },
        syncMap() {
            this.mapCenter = this.reportedMapCenter;
        }
    }
};
</script>

<style lang="scss" scoped>
.img-preview {
    margin-bottom: 20px;
    img {
        max-height: 200px;
    }
}
.vdatetime {
    display: block;
}
#edit-product .vue-input-tag-wrapper {
    border: 1px solid rgba(0, 40, 100, 0.12);
    color: #495057;
    font-size: 14px;
    border-radius: 3px;
    padding: 0.375rem 0.75rem;
    .new-tag {
        font-size: 14px;
    }
}
.dropzone {
    padding: 5px;
}
.dropzone .dz-preview .dz-details {
    padding: 10px;
}
.dropzone .dz-preview {
    margin: 5px;
}
</style>
