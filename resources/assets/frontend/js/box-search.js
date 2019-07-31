if ($('#box-search').length > 0) {
    new Vue({
        el: '#box-search',
        data: {
            form_pano: {
                sub_cat: '',
                city: '',
                district: '',
                street: '',
                ward: '',
                provider: '',
                pano_type: '',
                pano_size: '',
                pano_border: '',
                price_range: ''
            },
            form_ad: {
                sub_cat: '',
                city: '',
                district: '',
                provider: '',
                price_range: ''
            },
            form_social: {
                sub_cat: '',
                city: '',
                district: '',
                social_type: '',
                social_follow: '',
                price_range: '',
                provider: ''
            },
            form_web: {
                sub_cat: '',
                city: '',
                district: '',
                web_type: '',
                web_position: '',
                price_range: '',
                provider: ''
            },
            form_other: {
                sub_cat: '',
                city: '',
                district: '',
                price_range: '',
                provider: ''
            },
            cities: window.locations,
            categories: [],
            productData: {}
        },
        created() {
            this.getProductData();
        },
        computed: {
            orderedCities() {
                var cities = this.cities.map(c => {
                    return {
                        id: c.id,
                        name: c.name
                    };
                });
                arr = [24, 29, 15, 27, 49, 42, 2, 54, 40, 13, 56];
                topCities = cities
                    .filter(c => arr.includes(c.id))
                    .sort(function(c1, c2) {
                        return arr.indexOf(c1.id) - arr.indexOf(c2.id);
                    });
                cities = cities.filter(c => !arr.includes(c.id));

                return [...topCities, ...cities];
            },
            pano_city_default_text() {
                if (this.form_pano.sub_cat == 5) {
                    return 'Chọn tỉnh, thành phố (địa bàn quảng cáo)';
                }
                return 'Chọn tỉnh, thành phố (vị trí quảng cáo)';
            },
            pano_district_default_text() {
                if (this.form_pano.sub_cat == 5) {
                    return 'Chọn tỉnh, thành phố (địa bàn quảng cáo)';
                }
                return 'Chọn quận, huyện (vị trí quảng cáo)';
            },
            is_pano_show_street() {
                if ([1, 2, 3].includes(this.form_pano.sub_cat)) {
                    return true;
                }
                return false;
            },
            is_pano_show_ward() {
                if ([4].includes(this.form_pano.sub_cat)) {
                    return true;
                }
                return false;
            },
            is_pano_show_type() {
                if ([1, 2, 3, 4, 6, 8].includes(this.form_pano.sub_cat)) {
                    return true;
                }
                return false;
            },
            is_pano_show_size() {
                if ([1, 2, 3, 4, 6, 7, 8].includes(this.form_pano.sub_cat)) {
                    return true;
                }
                return false;
            },
            panoCats() {
                return this.categories.filter(c => c.parent_id == 1);
            },
            adCats() {
                return this.categories.filter(c => c.parent_id == 2);
            },
            socialCats() {
                return this.categories.filter(c => c.parent_id == 3);
            },
            adsCats() {
                return this.categories.filter(c => c.parent_id == 4);
            },
            webCats() {
                return this.categories.filter(c => c.parent_id == 5);
            },
            districts: function() {
                if (!this.form_pano.city) {
                    return [];
                }
                let city = this.cities.find(c => c.id == this.form_pano.city);
                return city.district;
            },
            adDistricts: function() {
                if (!this.form_ad.city) {
                    return [];
                }
                let city = this.cities.find(c => c.id == this.form_ad.city);
                return city.district;
            },
            socialDistricts: function() {
                if (!this.form_social.city) {
                    return [];
                }
                let city = this.cities.find(c => c.id == this.form_social.city);
                return city.district;
            },
            webDistricts: function() {
                if (!this.form_web.city) {
                    return [];
                }
                let city = this.cities.find(c => c.id == this.form_web.city);
                return city.district;
            },
            otherDistricts: function() {
                if (!this.form_other.city) {
                    return [];
                }
                let city = this.cities.find(c => c.id == this.form_other.city);
                return city.district;
            },
            panoStreets() {
                if (!this.form_pano.city) {
                    return [];
                }
                let city = this.cities.find(c => c.id == this.form_pano.city);
                if (!city || !city.district) {
                    return [];
                }

                let district = city.district.find(d => d.id == this.form_pano.district);
                if (!district || !district.street) {
                    return [];
                }
                return district.street;
            },
            panoWards() {
                if (!this.form_pano.city) {
                    return [];
                }
                let city = this.cities.find(c => c.id == this.form_pano.city);
                if (!city || !city.district) {
                    return [];
                }

                let district = city.district.find(d => d.id == this.form_pano.district);
                if (!district || !district.ward) {
                    return [];
                }
                return district.ward;
            }
        },
        methods: {
            getProductData() {
                axios.get('/product-data').then(resp => {
                    this.productData = resp.data.product;
                    this.categories = resp.data.category;
                });
            },
            searchPano() {
                var parentCat = this.productData.category[0];
                let params = Object.assign({}, this.form_pano);
                const query = _.map(params, (v, k) => {
                    return encodeURIComponent(k) + '=' + encodeURIComponent(v);
                }).join('&');
                var url = `/${parentCat['slug']}?${query}`;
                window.location.href = url;
            },
            searchAd() {
                var parentCat = this.productData.category[1];
                let params = Object.assign({}, this.form_ad);
                const query = _.map(params, (v, k) => {
                    return encodeURIComponent(k) + '=' + encodeURIComponent(v);
                }).join('&');
                var url = `/${parentCat['slug']}?${query}`;
                window.location.href = url;
            },
            searchSocial() {
                var parentCat = this.productData.category[2];
                let params = Object.assign({}, this.form_social);
                const query = _.map(params, (v, k) => {
                    return encodeURIComponent(k) + '=' + encodeURIComponent(v);
                }).join('&');
                var url = `/${parentCat['slug']}?${query}`;
                window.location.href = url;
            },
            searchAdsBanner() {
                var parentCat = this.productData.category[3];
                let params = Object.assign({}, this.form_web);
                const query = _.map(params, (v, k) => {
                    return encodeURIComponent(k) + '=' + encodeURIComponent(v);
                }).join('&');
                var url = `/${parentCat['slug']}?${query}`;
                window.location.href = url;
            },
            searchWeb() {
                var parentCat = this.productData.category[4];
                let params = Object.assign({}, this.form_other);
                const query = _.map(params, (v, k) => {
                    return encodeURIComponent(k) + '=' + encodeURIComponent(v);
                }).join('&');
                var url = `/${parentCat['slug']}?${query}`;
                window.location.href = url;
            }
        }
    });
}
