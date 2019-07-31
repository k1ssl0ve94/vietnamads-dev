import Vue from 'vue';
import router from '../router';

export default {
    state: {
        user: {},
        token: '',
        user_token: '', // user token is used for check in frontend
    },
    getters: {
        isLoggedIn: ({ user }) => user && user.id > 0,
        hasPermission: ({ user }) => permission => user && user.permissions && user.permissions.includes(permission)
    },
    actions: {
        login({ dispatch, commit }, payload) {
            axios
                .post('/api/admin/login', {
                    email: payload.email,
                    password: payload.password
                })
                .then(response => {
                    if (response.data.user) {
                        commit('updateCurrentUser', response.data.user);
                        commit('updateToken', response.data.token);
                        router.push('/');
                        dispatch('alertSuccess', 'Login success, welcome back!', {
                            root: true
                        });
                    }
                });
        },
        logout({ commit }) {
            commit('updateCurrentUser', {});
            commit('updateToken', '');
            router.push('/login');
        },
        updateAxiosToken({ state }) {
            if (state.token) {
                window.axios.defaults.headers.common['Authorization'] = `Bearer ${state.token}`;
            }
        },
        fetchUserInfo({ commit }) {
            axios
                .get('/api/admin/admins/info')
                .then(response => {
                    if (response.data) {
                        commit('updateCurrentUser', response.data.user);
                        commit('updateCurrentUserToken', response.data.user_token);
                        Vue.prototype.$bus.$emit('fetch_current_info', response.data.user);
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        }
    },
    mutations: {
        updateCurrentUser(state, user) {
            state.user = user;
        },
        updateCurrentUserToken(state, token) {
            state.user_token = token;
        },
        updateToken(state, token) {
            if (token) {
                window.axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
            } else {
                window.axios.defaults.headers.common['Authorization'] = '';
            }

            state.token = token;
        }
    }
};
