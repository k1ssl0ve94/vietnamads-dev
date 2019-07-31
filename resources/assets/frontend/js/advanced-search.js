if ($('#advanced-search').length > 0) {
    const catId = $('#advanced-search').data('cat');
    const subCatId = $('#advanced-search').data('sub-cat');
    var formSearch = $('.form-search');
    var defaultCity = { label: 'Chọn tỉnh/thành phố', value: '' };
    var defaultDistrict = { label: 'Chọn quận/huyện', value: '' };
    var defaultWard = { label: 'Chọn phường/xã', value: '' };
    var defaultStreet = { label: 'Chọn đường/phố', value: '' };
    var defaultCat = { label: 'Chọn danh mục', value: '' };
    var defaultSubCat = { label: 'Chọn hình thức', value: '' };
    if (catId == 1) {
        defaultCity.label = 'Chọn tỉnh/thành phố (vị trí quảng cáo)';
        defaultDistrict.label = 'Chọn quận/huyện (vị trí quảng cáo)';
        defaultWard.label = 'Chọn phường/xã (vị trí quảng cáo)';
        defaultStreet.label = 'Chọn đường/phố (vị trí quảng cáo)';
    } else {
        defaultCity.label += ' (nơi cung câp)';
        defaultDistrict.label += ' (nơi cung câp)';
    }
    new Vue({
        el: '#advanced-search',
        data: {
            cat_id: catId,
            cat: defaultCat,
            sub_cat: defaultSubCat,
            locations: window.locations,
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
            defaultForm: {},
            productData: {
                price_range: []
            },
            providers: [{ label: 'Chọn nhà cung câp', value: '' }],
            categories: []
        },
        created() {
            this.defaultForm = Object.assign({}, this.form);
            this.getProductData();
        },
        mounted() {
            var cityID = formSearch.find('[name=city]').val();
            if (cityID != '') {
                var city = this.locations.find(c => c.id == cityID);
                if (city) {
                    this.form.city = {
                        label: city.name,
                        value: city.id
                    };
                }
            }
            var districtID = formSearch.find('[name=district]').val();
            if (districtID != '') {
                this.locations.forEach(city => {
                    var district = city.district.find(d => d.id == districtID);
                    if (district) {
                        this.form.district = {
                            label: district.pre + ' ' + district.name,
                            value: district.id
                        };
                    }
                });
            }
            var wardID = formSearch.find('[name=ward]').val();
            if (wardID != '') {
                this.locations.forEach(city => {
                    var district = city.district.find(d => d.id == districtID);
                    if (district) {
                        var ward = district.ward.find(w => w.id == wardID);
                        this.form.ward = {
                            label: ward.pre + ' ' + ward.name,
                            value: ward.id
                        };
                    }
                });
            }
            var streetID = formSearch.find('[name=street]').val();
            if (streetID != '') {
                this.locations.forEach(city => {
                    var district = city.district.find(d => d.id == districtID);
                    if (district) {
                        var street = district.street.find(w => w.id == streetID);
                        this.form.street = {
                            label: street.pre + ' ' + street.name,
                            value: street.id
                        };
                    }
                });
            }
            var providerID = formSearch.find('[name=provider]').val();
            if (providerID != '') {
                this.form.provider.value = providerID;
            }
            var priceRangeID = formSearch.find('[name=price_range]').val();
            if (priceRangeID != '') {
                this.form.price_range.value = priceRangeID;
            }

            if (this.cat_id == 1) {
                this.form.pano_type.value = formSearch.find('[name=pano_type]').val();
                this.form.pano_size.value = formSearch.find('[name=pano_size]').val();
                this.form.pano_border.value = formSearch.find('[name=pano_border]').val();
                this.form.pano_light.value = formSearch.find('[name=pano_light]').val();
            } else if (this.cat_id == 3) {
                this.form.social_type.value = formSearch.find('[name=social_type]').val();
                this.form.social_follow.value = formSearch.find('[name=social_follow]').val();
            } else if (this.cat_id == 4) {
                this.form.web_type.value = formSearch.find('[name=web_type]').val();
                this.form.web_position.value = formSearch.find('[name=web_position]').val();
            }
        },
        watch: {
            'form.city': function(value, oldValue) {
                if (oldValue.value != '') {
                    this.form.district = defaultDistrict;
                }
            },
            'form.district': function() {
                // this.form.ward = defaultWard;
                // this.form.street = defaultStreet;
            },
            'form.ward': function(value) {
                if (value === null) {
                    this.form.city.ward = defaultWard;
                }
            },
            'form.street': function(value) {
                if (value === null) {
                    this.form.city.street = defaultStreet;
                }
            },
            sub_cat(cat) {
                // tren phuong tien di chuyen
                if (cat.value == 5) {
                    defaultCity.label = 'Chọn tỉnh/thành phố (địa bàn quảng cáo)';
                    return;
                } else if (catId == 1) {
                    defaultCity.label = 'Chọn tỉnh/thành phố (vị trí quảng cáo)';
                    defaultDistrict.label = 'Chọn quận/huyện (vị trí quảng cáo)';
                }
            },
            cat(cat) {
                if (cat.value) {
                    this.cat_id = cat.value;
                }
            }
        },
        computed: {
            cats() {
                var cats = [];
                if (this.productData.category) {
                    this.productData.category.forEach(c => {
                        cats.push({
                            label: c.name,
                            value: c.id
                        });
                    });
                }
                return cats;
            },
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
                let data = this.productData.price_range.map(i => {
                    return {
                        label: i.name,
                        value: i.id
                    };
                });
                data.unshift({ label: 'Chọn khoảng giá', value: '' });
                return data;
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
            }
        },
        methods: {
            submit() {
                if (this.cat.value && catId != this.cat.value) {
                    var cat = this.productData.category.find(c => c.id == this.cat.value);
                    formSearch.attr('action', window.location.origin + '/' + cat.slug);
                }

                formSearch.find('[name=city]').val(this.form.city.value);
                formSearch.find('[name=district]').val(this.form.district.value);
                formSearch.find('[name=ward]').val(this.form.ward.value);
                formSearch.find('[name=street]').val(this.form.street.value);
                formSearch.find('[name=provider]').val(this.form.provider.value);
                formSearch.find('[name=price_range]').val(this.form.price_range.value);
                if (this.sub_cat.value != '') {
                    formSearch.find('[name=sub_cat]').val(this.sub_cat.value);
                }

                if (this.cat_id == 1) {
                    formSearch.find('[name=pano_type]').val(this.form.pano_type.value);
                    formSearch.find('[name=pano_size]').val(this.form.pano_size.value);
                    formSearch.find('[name=pano_border]').val(this.form.pano_border.value);
                    formSearch.find('[name=pano_light]').val(this.form.pano_light.value);
                } else if (this.cat_id == 2) {
                    // formSearch.find('[name=ad_channel]').val(this.form.ad_channel.value);
                    // formSearch.find('[name=ad_coverage]').val(this.form.ad_coverage.value);
                    // formSearch.find('[name=ad_time]').val(this.form.ad_time.value);
                } else if (this.cat_id == 3) {
                    formSearch.find('[name=social_type]').val(this.form.social_type.value);
                    formSearch.find('[name=social_follow]').val(this.form.social_follow.value);
                } else if (this.cat_id == 4) {
                    formSearch.find('[name=web_type]').val(this.form.web_type.value);
                    formSearch.find('[name=web_position]').val(this.form.web_position.value);
                }

                formSearch.submit();
            },
            getProductData() {
                axios.get('/product-data').then(response => {
                    this.productData = response.data.product;
                    this.categories = response.data.category;

                    let subCat = this.categories.find(c => c.id == subCatId);

                    if (subCat) {
                        this.sub_cat = {
                            label: subCat.name,
                            value: subCat.id
                        };
                    }

                    let cat = this.productData.category.find(c => c.id == catId);
                    if (cat) {
                        this.cat = {
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
                // social_type
                if (this.form.social_type.value != '') {
                    var i = this.socialTypes.find(i => i.value == this.form.social_type.value);
                    if (i) {
                        this.form.social_type = {
                            label: i.label,
                            value: i.value
                        };
                    }
                }
                // social_follow
                if (this.form.social_follow.value != '') {
                    var i = this.socialFollows.find(i => i.value == this.form.social_follow.value);
                    if (i) {
                        this.form.social_follow = {
                            label: i.label,
                            value: i.value
                        };
                    }
                }
                // web_type
                if (this.form.web_type.value != '') {
                    var i = this.webTypes.find(i => i.value == this.form.web_type.value);
                    if (i) {
                        this.form.web_type = {
                            label: i.label,
                            value: i.value
                        };
                    }
                }
                // web_position
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
            reset() {
                this.form = Object.assign({}, this.defaultForm);
                this.cat_id = catId;
                this.cat = defaultCat;
                this.sub_cat = defaultSubCat;
            }
        }
    });
}
