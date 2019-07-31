if ($('#map-detail-product').length > 0) {
    new Vue({
        el: '#map-detail-product',
        data: {
            position: { lat: 21.0227788, lng: 105.8194541 }
        },
        created() {
            var lat = parseFloat($('#map-detail-product').data('lat'));
            var lng = parseFloat($('#map-detail-product').data('lng'));
            if (lat != 0 && lat != 0) {
                this.position.lat = lat;
                this.position.lng = lng;
            }
        },
        methods: {}
    });
}

if ($('#map-container').length > 0) {
    const catId = $('#advanced-search-map').data('cat');
    const subCatId = $('#advanced-search-map').data('sub-cat');
    var defaultCity = { label: 'Chọn tỉnh/thành phố', value: '' };
    var defaultDistrict = { label: 'Chọn quận/huyện', value: '' };
    var defaultWard = { label: 'Chọn phường/xã', value: '' };
    var defaultStreet = { label: 'Chọn đường/phố', value: '' };
    var defaultSubCat = { label: 'Chọn hình thức', value: '' };
    new Vue({
        el: '#map-container',
        data: {
            cat_id: catId,
            sub_cat: defaultSubCat,
            position: { lat: 21.0227788, lng: 105.8194541 },
            params: window.map_params,
            cityLatLngs: window.cityLatLngs,
            products: [],
            infoContent: '',
            current_product: {},
            infoWindowPos: null,
            infoWinOpen: false,
            infoOptions: {
                pixelOffset: {
                    width: 0,
                    height: -35
                }
            },
            form: {
                city: defaultCity,
                district: defaultDistrict,
                ward: defaultWard,
                street: defaultStreet,
                provider: { label: 'Chọn nhà cung câp', value: '' },
                price_range: { label: 'Chọn khoảng giá', value: '' },

                pano_type: { label: 'Chọn loại biển', value: '' },
                pano_size: { label: 'Chọn kích thước', value: '' },
                pano_border: { label: 'Chọn Khung', value: '' },
                pano_light: { label: 'Chọn đèn điện', value: '' },

                social_type: { label: 'Chọn loại quảng cáo', value: '' },
                social_follow: { label: 'Chọn theo dõi', value: '' },

                web_type: { label: 'Chọn hình thức hiển thị', value: '' },
                web_position: { label: 'Chọn trang xuất hiện', value: '' }
            },
            currentMidx: null,
            order: window.map_params.order || '',
            has_image: window.map_params.has_image || false,
            has_video: window.map_params.has_video || false,
            productData: {},
            providers: [{ label: 'Chọn nhà cung câp', value: '' }],
            categories: [],
            locations: window.locations
        },
        created() {
            this.getProductData();
        },
        mounted() {
            if (this.params.city) {
                var city = this.locations.find(c => c.id == this.params.city);
                if (city) {
                    this.form.city = {
                        label: city.name,
                        value: city.id
                    };
                    this.moveMapToCity(this.params.city);
                }
            }

            if (this.params.district) {
                this.locations.forEach(city => {
                    var district = city.district.find(d => d.id == this.params.district);
                    if (district) {
                        this.form.district = {
                            label: district.pre + ' ' + district.name,
                            value: district.id
                        };
                    }
                });
            }

            if (this.params.ward && this.params.district) {
                this.locations.forEach(city => {
                    var district = city.district.find(d => d.id == this.params.district);
                    if (district) {
                        var ward = district.ward.find(w => w.id == this.params.ward);
                        this.form.ward = {
                            label: ward.pre + ' ' + ward.name,
                            value: ward.id
                        };
                    }
                });
            }

            if (this.params.street && this.params.district) {
                this.locations.forEach(city => {
                    var district = city.district.find(d => d.id == districtID);
                    if (district) {
                        var street = district.street.find(w => w.id == this.params.street);
                        this.form.street = {
                            label: street.pre + ' ' + street.name,
                            value: street.id
                        };
                    }
                });
            }

            if (this.params.provider) {
                this.form.provider.value = this.params.provider;
            }

            if (this.params.price_range) {
                this.form.price_range.value = this.params.price_range;
            }

            if (this.cat_id == 1) {
                this.form.pano_type.value = this.params.pano_type;
                this.form.pano_size.value = this.params.pano_size;
                this.form.pano_border.value = this.params.pano_border;
                this.form.pano_light.value = this.params.pano_light;
            } else if (this.cat_id == 3) {
                this.form.social_type.value = this.params.social_type;
                this.form.social_follow.value = this.params.social_follow;
            } else if (this.cat_id == 4) {
                this.form.web_type.value = this.params.web_type;
                this.form.web_position.value = this.params.web_position;
            }

            this.fetchProducts();
        },
        computed: {
            subCats() {
                var data = this.categories.filter(c => c.parent_id == this.cat_id);
                var subCats = [defaultSubCat];
                data.forEach(c => {
                    subCats.push({
                        label: c.name,
                        value: c.id
                    });
                });
                return subCats;
            },
            cities() {
                var cities = [defaultCity];
                var cities = this.locations.map(c => {
                    return {
                        label: c.name,
                        value: c.id
                    };
                });
                arr = [24, 29, 15, 27, 49, 42, 2, 54, 40, 13, 56];
                topCities = cities
                    .filter(c => arr.includes(c.value))
                    .sort(function(c1, c2) {
                        return arr.indexOf(c1.value) - arr.indexOf(c2.value);
                    });
                cities = cities.filter(c => !arr.includes(c.value));

                return [defaultCity, ...topCities, ...cities];
            },
            districts() {
                var districts = [defaultDistrict];
                if (!this.form.city.value) {
                    return districts;
                }
                let city = this.locations.find(c => c.id == this.form.city.value);
                city.district.forEach(dist => {
                    districts.push({
                        label: dist.pre + ' ' + dist.name,
                        value: dist.id
                    });
                });
                return districts;
            },
            wards() {
                var wards = [defaultWard];
                if (!this.form.district.value) {
                    return wards;
                }
                let city = this.locations.find(c => c.id == this.form.city.value);
                let district = city.district.find(d => d.id == this.form.district.value);
                district.ward.forEach(ward => {
                    wards.push({
                        label: ward.pre + ' ' + ward.name,
                        value: ward.id
                    });
                });
                return wards;
            },
            streets() {
                var streets = [defaultStreet];
                if (!this.form.district.value) {
                    return streets;
                }
                let city = this.locations.find(c => c.id == this.form.city.value);
                let district = city.district.find(d => d.id == this.form.district.value);
                district.street.forEach(street => {
                    streets.push({
                        label: street.pre + ' ' + street.name,
                        value: street.id
                    });
                });
                return streets;
            },
            priceRanges() {
                let data = [];
                if (this.productData.price_range) {
                    data = this.productData.price_range.map(i => {
                        return {
                            label: i.name,
                            value: i.id
                        };
                    });
                }
                data.unshift({ label: 'Chọn khoảng giá', value: '' });
                return data;
            },
            markers() {
                let data = [];
                this.products.forEach(p => {
                    data.push({
                        id: p.id,
                        title: p.title,
                        position: {
                            lat: parseFloat(p.lat),
                            lng: parseFloat(p.long)
                        }
                    });
                });
                return data;
            },
            is_show_provider() {
                return ![6].includes(this.cat_id);
            },
            is_show_ward() {
                // hide by cat_id
                if ([2, 3, 4, 5, 6].includes(this.cat_id)) {
                    return false;
                }
                return ![5, 6, 7, 8].includes(this.sub_cat.value);
            },
            is_show_street() {
                // hide by cat_id
                if ([2, 3, 4, 5, 6].includes(this.cat_id)) {
                    return false;
                }
                // sub cat
                return ![4, 5, 6, 7, 8].includes(this.sub_cat.value);
            },
            is_pano_type() {
                return ![5, 7].includes(this.sub_cat.value);
            },
            is_pano_size() {
                return ![5].includes(this.sub_cat.value);
            },
            is_pano_border() {
                return ![5, 6, 7].includes(this.sub_cat.value);
            },
            is_pano_light() {
                return ![5, 6, 7].includes(this.sub_cat.value);
            },
            panoTypes() {
                let data = this.productData.pano.type.map(i => {
                    return {
                        label: i.name,
                        value: i.id
                    };
                });
                data.unshift({ label: 'Chọn loại biển', value: '' });
                return data;
            },
            panoSizes() {
                let data = this.productData.pano.size.map(i => {
                    return {
                        label: i.name,
                        value: i.id
                    };
                });
                data.unshift({ label: 'Chọn kích thước', value: '' });
                return data;
            },
            panoBorders() {
                let data = this.productData.pano.border.map(i => {
                    return {
                        label: i.name,
                        value: i.id
                    };
                });
                data.unshift({ label: 'Chọn Khung', value: '' });
                return data;
            },
            panoLights() {
                let data = this.productData.pano.light.map(i => {
                    return {
                        label: i.name,
                        value: i.id
                    };
                });
                data.unshift({ label: 'Chọn đèn điện', value: '' });
                return data;
            },
            socialTypes() {
                let data = this.productData.social.type.map(i => {
                    return {
                        label: i.name,
                        value: i.id
                    };
                });
                data.unshift({ label: 'Chọn loại quảng cáo', value: '' });
                return data;
            },
            socialFollows() {
                let data = this.productData.social.follow.map(i => {
                    return {
                        label: i.name,
                        value: i.id
                    };
                });
                data.unshift({ label: 'Chọn theo dõi', value: '' });
                return data;
            },
            webTypes() {
                let data = this.productData.web.type.map(i => {
                    return {
                        label: i.name,
                        value: i.id
                    };
                });
                data.unshift({ label: 'Chọn hình thức hiển thị', value: '' });
                return data;
            },
            webPositions() {
                let data = this.productData.web.position.map(i => {
                    return {
                        label: i.name,
                        value: i.id
                    };
                });
                data.unshift({ label: 'Chọn trang xuất hiện', value: '' });
                return data;
            }
        },
        watch: {
            order(value) {
                this.params.order = value;
                this.fetchProducts();
            },
            has_image(value) {
                this.params.has_image = value ? 'yes' : '';
                this.fetchProducts();
            },
            has_video(value) {
                this.params.has_video = value ? 'yes' : '';
                this.fetchProducts();
            }
        },
        methods: {
            getProductData() {
                axios.get('/product-data').then(response => {
                    this.productData = response.data.product;
                    this.categories = response.data.category;
                    var cat = this.categories.find(c => c.id == subCatId);
                    if (cat) {
                        this.sub_cat = {
                            label: cat.name,
                            value: cat.id
                        };
                    }
                    response.data.product.provider.forEach(p => {
                        this.providers.push({
                            label: p.name,
                            value: p.id
                        });
                    });
                    setTimeout(() => {
                        this.initSelectorLabel();
                    }, 100);
                });
            },
            fetchProducts() {
                // console.log(this.params);
                if (this.params.city == '') {
                    return;
                }
                // do not filter by bounds
                // var bounds = this.$refs.gmap.$mapObject.getBounds();
                // if (!bounds) {
                //     return;
                // }
                // var northEast = bounds.getNorthEast();
                // var southWest = bounds.getSouthWest();

                // var params = Object.assign({}, this.params, {
                //     north_east: northEast,
                //     south_west: southWest
                // });
                axios.get('/ban-do/ajax', { params : this.params }).then(resp => {
                    this.products = resp.data.products;
                    url = window.location.origin + window.location.pathname + '?' + $.param(this.params);
                    window.history.pushState("", "", url);
                });
            },
            syncMap() {
                // this.fetchProducts();
            },
            toggleInfoWindow(p, idx) {
                this.infoWindowPos = p.position;
                this.current_product = p;
                if (this.currentMidx == idx) {
                    this.infoWinOpen = !this.infoWinOpen;
                } else {
                    this.infoWinOpen = true;
                    this.currentMidx = idx;
                }
            },
            initSelectorLabel() {
                if (this.form.provider.value != '') {
                    var i = this.providers.find(i => i.value == this.form.provider.value);
                    if (i) {
                        this.form.provider = {
                            label: i.label,
                            value: i.value
                        };
                    }
                }
                if (this.form.price_range.value != '') {
                    var i = this.priceRanges.find(i => i.value == this.form.price_range.value);
                    if (i) {
                        this.form.price_range = {
                            label: i.label,
                            value: i.value
                        };
                    }
                }
                if (this.form.pano_type.value != '') {
                    var i = this.panoTypes.find(i => i.value == this.form.pano_type.value);
                    if (i) {
                        this.form.pano_type = {
                            label: i.label,
                            value: i.value
                        };
                    }
                }
                if (this.form.pano_size.value != '') {
                    var i = this.panoSizes.find(i => i.value == this.form.pano_size.value);
                    if (i) {
                        this.form.pano_size = {
                            label: i.label,
                            value: i.value
                        };
                    }
                }
                if (this.form.pano_border.value != '') {
                    var i = this.panoBorders.find(i => i.value == this.form.pano_border.value);
                    if (i) {
                        this.form.pano_border = {
                            label: i.label,
                            value: i.value
                        };
                    }
                }
                if (this.form.social_type.value != '') {
                    var i = this.socialTypes.find(i => i.value == this.form.social_type.value);
                    if (i) {
                        this.form.social_type = {
                            label: i.label,
                            value: i.value
                        };
                    }
                }
                if (this.form.social_follow.value != '') {
                    var i = this.socialFollows.find(i => i.value == this.form.social_follow.value);
                    if (i) {
                        this.form.social_follow = {
                            label: i.label,
                            value: i.value
                        };
                    }
                }
                if (this.form.web_type.value != '') {
                    var i = this.webTypes.find(i => i.value == this.form.web_type.value);
                    if (i) {
                        this.form.web_type = {
                            label: i.label,
                            value: i.value
                        };
                    }
                }
                if (this.form.web_position.value != '') {
                    var i = this.webPositions.find(i => i.value == this.form.web_position.value);
                    if (i) {
                        this.form.web_position = {
                            label: i.label,
                            value: i.value
                        };
                    }
                }
            },
            submit() {
                this.params.city = this.form.city.value;
                this.params.district = this.form.district.value;
                this.params.pano_border = this.form.pano_border.value;
                this.params.pano_light = this.form.pano_light.value;
                this.params.pano_size = this.form.pano_size.value;
                this.params.pano_type = this.form.pano_type.value;
                this.params.price_range = this.form.price_range.value;
                this.params.provider = this.form.provider.value;
                this.params.social_follow = this.form.social_follow.value;
                this.params.social_type = this.form.social_type.value;
                this.params.street = this.form.street.value;
                this.params.ward = this.form.ward.value;
                this.params.web_position = this.form.web_position.value;
                this.params.web_type = this.form.web_type.value;
                this.params.sub_cat_id = this.sub_cat.value;

                this.fetchProducts();
                this.moveMapToCity(this.params.city);
            },
            moveMapToCity(cityID) {
                var city = this.locations.find(c => c.id == cityID);
                if (city && this.cityLatLngs[city.code]) {
                    this.position = { lat: this.cityLatLngs[city.code][0], lng: this.cityLatLngs[city.code][1] };
                }
            }
        }
    });
}
