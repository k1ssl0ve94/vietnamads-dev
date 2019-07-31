import router from '../router';

const state = {
  users: []
};

const getters = {};
const actions = {
  fetchAllUsers({ commit }) {
    axios.get(`/api/admin/admins/all`).then(response => {
      commit('updateUsers', response.data);
    });
  }
};
const mutations = {
  updateUsers(state, users) {
    state.users = users;
  }
};

export default { state, getters, actions, mutations };
