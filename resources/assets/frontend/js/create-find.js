if ($('#form-create-find').length > 0) {
    new Vue({
        el: '#form-create-find',
        data: {
            cities: window.locations,
            settings: window.all_settings,
            msg: '',
            form: {
                title: '',
                city: '',
                district: '',
                content: '',
                contact_name: '',
                contact_phone: '',
                contact_email: '',
                contact_address: '',
                youtube_link: '',
                direct_link1: '',
                direct_link2: '',
                direct_link3: '',
                direct_link4: '',
                category: '',
                level: '0',
                package_option: 0,
                images: [],
                price: '',
                price_unit: '',
                lat: 0,
                long: 0,
            },
            reportedMapCenter: { lat: 21.0227788, lng: 105.8194541 },
            mapCenter: { lat: 21.0227788, lng: 105.8194541 },
            price_type: '1',
            errors: {},
            categories: [],
            defaultData: {},
            productData: [],
            servicePackages: [],
            selectedPackage: {
                options: []
            },
            isShowMap: false,
            totalFee: 0,
            currentId: '',
            previousCityId: '',
            dropzoneOptions: {
                url: '/upload-image',
                addRemoveLinks: true,
                maxFilesize: 3,
                acceptedFiles: 'image/*',
                maxFiles: typeof allowImgNb != "undefined" ? allowImgNb : 12,
                headers: {
                    'X-CSRF-TOKEN': window.axios.defaults.headers.common['X-CSRF-TOKEN']
                }
            }
        },
        created() {
            this.getProductData();
            this.defaultData = Object.assign({}, this.form);
        },
        watch: {
            'form.city': function() {
                if (this.form.city != this.previousCityId) {
                    this.form.district = '';
                }
            }
        },
        computed: {
            districts: function() {
                if (!this.form.city) {
                    return [];
                }
                let city = this.cities.find(c => c.id == this.form.city);
                return city.district;
            },
            packageOptions(){
                if (!this.form.level || !this.servicePackages.length) {
                    return [];
                }
                let selectedPackage2 = this.servicePackages.find(s => s.id == this.form.level);
                // this.selectedPackage = selectedPackage2;
                return selectedPackage2.options;
            }
        },
        methods: {
            calculateFee(){
                if (!this.form.level || !this.form.package_option
                    || this.selectedPackage == undefined) {
                    this.totalFee = 0;
                    return;
                }
                let selectOption = this.selectedPackage.options.find(t => t.id == this.form.package_option);
                if (selectOption){
                    this.totalFee = selectOption.totalFee;
                } else {
                    this.totalFee = 0;
                }
            },
            selectPackage(){
                if (!this.form.level || !this.servicePackages.length) {
                    this.selectedPackage = {
                        options: [],
                        id: ''
                    };
                    this.package_option = '0';
                    this.calculateFee();
                    return [];
                }
                this.selectedPackage = this.servicePackages.find(s => s.id === this.form.level);
                if (this.selectedPackage == undefined) {
                    this.selectedPackage = {
                        options: [],
                        id: ''
                    };
                }
                this.package_option = '0';
                this.calculateFee();
            },
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
            getProductData() {
                let urlGetData = '/product-data';
                if (currentProductId !== undefined) {
                    urlGetData += '?currentId=' + currentProductId;
                }
                axios.get(urlGetData).then(response => {
                    this.productData = response.data.product.find;
                    this.categories = response.data.category.filter(cat => cat.parent_id == 6);
                    this.servicePackages = response.data.servicePackages;
                    // this.selectedPackage = this.servicePackages[0];
                    if (response.data.currentProduct) {
                        this.previousCityId = response.data.currentProduct.city;
                        this.form = response.data.currentProduct;
                        this.form.images = [];
                        if (this.form.price > 0) {
                            this.price_type = 2;
                        }
                        this.selectedPackage = this.servicePackages.find(s => s.id == this.form.level);
                        this.calculateFee();
                    }
                });
            },
            submit() {
                if (this.price_type == '1') {
                    this.form.price = 0;
                    this.form.price_unit = '';
                }
                if (this.form.price == '') {
                    this.form.price = 0;
                }
                if (this.isShowMap) {
                    this.form.lat = this.reportedMapCenter.lat;
                    this.form.long = this.reportedMapCenter.lng;
                }
                if (this.currentId != '') {
                    this.form.id = this.currentId;
                }
                this.errors = {};
                axios
                    .post('/dang-tin/find', this.form)
                    .then(resp => {
                        if (resp.data.status) {
                            window.location.href = '/trang-ca-nhan';
                        } else {
                            this.msg = resp.data.message ? resp.data.message : 'Đã có lỗi xảy ra';
                            window.scrollTo(0, 0);
                        }
                    })
                    .catch(err => {
                        if (err.response && err.response.data && err.response.data.errors) {
                            this.errors = err.response.data.errors;
                            // this.$refs.recaptcha.reset();
                        } else {
                            alert('error');
                        }
                    });
            },
            reset() {
                this.form = this.defaultData;
                this.$refs.createPanoDropzone.removeAllFiles();
                this.errors = {};
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
    });
}
