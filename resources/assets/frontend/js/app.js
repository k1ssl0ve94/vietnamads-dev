require('./bootstrap');
require('./common');
require('./auth');

import Datetime from 'vue-datetime';
import VueRecaptcha from 'vue-recaptcha';
import vue2Dropzone from 'vue2-dropzone';
import vSelect from 'vue-select';
import numFormat from 'vue-filter-number-format';
import * as VueGoogleMaps from 'vue2-google-maps';

Vue.filter('numFormat', numFormat);

Vue.use(VueGoogleMaps, {
    load: {
        key: 'AIzaSyCnb2wM0Oq0UKPeALULzCyRWUbQtQDLz04'
    }
});

Vue.use(Datetime);
Vue.component('vue-recaptcha', VueRecaptcha);
Vue.component('vue-dropzone', vue2Dropzone);
Vue.component('v-select', vSelect);

require('./jquery.number.min');
require('./create-ad');
require('./create-find');
require('./create-other');
require('./create-pano');
require('./create-social');
require('./create-web');
require('./product');
require('./advanced-search');
require('./box-search');
require('./map');
require('./profile');
