import Vue from 'vue';
import * as R from 'ramda';
const TIME_DISPLAY_FORM_MESSAGE = 8000;

export default {
    state: {
        form: {
            errors: [],
            success: ''
        },
        route: {
            name: '',
            path: ''
        },
        roles: [],
        permissions: [],
        settings: [],
        location: null
    },
    actions: {
        alertSuccess({ commit }, message) {
            Vue.toasted.global.alertSuccess({
                message
            });
        },
        alertError({ commit }, message) {
            Vue.toasted.global.alertError({
                message
            });
        },
        alertInfo({ commit }, message) {
            Vue.toasted.global.alertInfo({
                message
            });
        },
        handleError({ commit, dispatch }, errorData) {
            let errors = [];
            if (errorData.response) {
                if (errorData.response.status == 401) {
                    dispatch('logout', {
                        root: true
                    });
                    dispatch('formErrors', [errorData.response.data.message]);
                    return;
                } else if (errorData.response.status >= 500) {
                    dispatch('formErrors', ['Internal Server Error!']);
                    return;
                } else if (errorData.response.data.errors) {
                    errorData = errorData.response.data.errors;
                }
            }

            R.forEachObjIndexed((value, key) => {
                errors = errors.concat(value);
            }, errorData);


            dispatch('formErrors', errors);
        },
        formSuccess({ commit }, message) {
            commit('updateFormSuccess', message);

            setTimeout(() => {
                commit('updateFormSuccess', '');
            }, TIME_DISPLAY_FORM_MESSAGE);
        },
        formErrors({ commit }, errors) {
            commit('updateFormErrors', errors);
            window.scrollTo(0, 0);

            setTimeout(() => {
                commit('updateFormErrors', []);
            }, TIME_DISPLAY_FORM_MESSAGE);
        },
        fetchRolesAndPermissions({ commit }) {
            axios.get(`/api/admin/roles`).then(response => {
                commit('updateRoles', response.data.roles);
                commit('updatePermissions', response.data.permissions);
            });
        },
        fetchSettings({ commit }) {
            axios.get(`/api/admin/settings/all`).then(response => {
                commit('updateSettings', response.data);
            });
        },
        fetchLocation({ state, commit }) {
            if (state.location) {
                return;
            }
            axios.get(`/js/location.json`).then(response => {
                commit('updateLocation', response.data);
            });
        }
    },
    getters: {
        errorTypes: state => {
            return [];
        },
        tags: state => {
            return [];
        }
    },
    mutations: {
        updateFormErrors(state, errors) {
            state.form.errors = errors;
        },
        updateFormSuccess(state, success) {
            state.form.success = success;
        },
        updateRouteInto(state, route) {
            state.route = route;
        },
        updateRoles(state, roles) {
            state.roles = roles;
        },
        updatePermissions(state, permissions) {
            state.permissions = permissions;
        },
        updateRole(state, { id, name }) {
            state.roles.forEach((role, index) => {
                if (role.id == id) {
                    state.roles[index].name = name;
                }
            });
        },
        updateSettings(state, settings) {
            state.settings = settings;
        },
        updateLocation(state, location) {
            state.location = location;
        }
    }
};
