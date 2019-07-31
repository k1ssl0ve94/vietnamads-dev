require('summernote/dist/summernote-bs4.min.js');
require('summernote-image-title/summernote-image-title');
require('./bootstrap');
require('./tabler');

window.Vue = require('vue');
import Container from './Container';
import router from './router';
import store from './store';
import Toasted from 'vue-toasted';
import Multiselect from 'vue-multiselect';
import { Datetime } from 'vue-datetime';
import vue2Dropzone from 'vue2-dropzone';
import vSelect from 'vue-select';
import draggable from 'vuedraggable';
import InputTag from 'vue-input-tag';
import * as VueGoogleMaps from 'vue2-google-maps';
import numFormat from 'vue-filter-number-format';
import Autocomplete from 'vuejs-auto-complete';

Vue.filter('numFormat', numFormat);


Vue.prototype.$bus = new Vue({});

Vue.use(Toasted);

Vue.use(VueGoogleMaps, {
    load: {
        key: 'AIzaSyCnb2wM0Oq0UKPeALULzCyRWUbQtQDLz04'
        // libraries: 'places' // This is required if you use the Autocomplete plugin
        // OR: libraries: 'places,drawing'
        // OR: libraries: 'places,drawing,visualization'
        // (as you require)

        //// If you want to set the version, you can do so:
        // v: '3.26',
    }

    //// If you intend to programmatically custom event listener code
    //// (e.g. `this.$refs.gmap.$on('zoom_changed', someFunc)`)
    //// instead of going through Vue templates (e.g. `<GmapMap @zoom_changed="someFunc">`)
    //// you might need to turn this on.
    // autobindAllEvents: false,

    //// If you want to manually install components, e.g.
    //// import {GmapMarker} from 'vue2-google-maps/src/components/marker'
    //// Vue.component('GmapMarker', GmapMarker)
    //// then disable the following:
    // installComponents: true,
});

Vue.toasted.register('alertError', payload => (payload.message ? payload.message : 'Oops.. Something Went Wrong..'), {
    type: 'error',
    icon: 'fa-times-circle-o',
    iconPack: 'fontawesome',
    className: 'bg-danger',
    duration: 3000,
    action: [
        {
            text: 'Close',
            onClick: (e, toastObject) => {
                toastObject.goAway(0);
            }
        }
    ]
});

Vue.toasted.register('alertSuccess', payload => (payload.message ? payload.message : 'Success!'), {
    type: 'success',
    icon: 'fa-check',
    iconPack: 'fontawesome',
    className: 'bg-success',
    duration: 3000,
    action: [
        {
            text: 'Close',
            onClick: (e, toastObject) => {
                toastObject.goAway(0);
            }
        }
    ]
});

Vue.toasted.register('alertInfo', payload => (payload.message ? payload.message : 'Info'), {
    type: 'info',
    icon: 'fa-info-circle',
    iconPack: 'fontawesome',
    className: 'bg-info',
    duration: 3000,
    action: [
        {
            text: 'Close',
            onClick: (e, toastObject) => {
                toastObject.goAway(0);
            }
        }
    ]
});
Vue.component('multiselect', Multiselect);
Vue.component('loading', require('./components/Loading'));
Vue.component('dimmer', require('./components/Dimmer'));
Vue.component('pagination', require('./components/Pagination'));
Vue.component('modal-confirm', require('./components/ModalConfirm'));
Vue.component('form-message', require('./components/FormMessage'));
Vue.component('datetime', Datetime);
Vue.component('vue-dropzone', vue2Dropzone);
Vue.component('v-select', vSelect);
Vue.component('draggable', draggable);
Vue.component('input-tag', InputTag);
Vue.component('autocomplete', Autocomplete);

window.axios.interceptors.response.use(
    response => {
        if (response.data.errors) {
            store.dispatch('handleError', response.data.errors);
        }

        return response;
    },
    error => {
        store.dispatch('handleError', error);

        return Promise.reject(error);
    }
);

const app = new Vue({
    el: '#app',
    router,
    store,
    template: '<container/>',
    components: {
        Container
    }
});
