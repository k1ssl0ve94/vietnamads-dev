import router from '../router';

const state = {
  currentTeam: {},
  schedules: [],
};

const getters = {};
const actions = {};
const mutations = {
  updateCurrentTeam(state, team) {
    state.currentTeam = team;
  },
  updateTeamSchedules(state, schedules) {
    state.schedules = schedules;
  },
  updateSchedule(state, schedule) {
    const index = _.findIndex(state.schedules, {
      date_str: schedule.date_str,
      role_id: schedule.role_id,
      type: schedule.type,
    });

    if (index < 0) {
      Vue.set(state.schedules, state.schedules.length, schedule);
    } else {
      Vue.set(state.schedules, index, schedule);
    }
  },
  deleteSchedule(state, schedule) {
    const index = _.findIndex(state.schedules, {
      date_str: schedule.date_str,
      role_id: schedule.role_id,
      type: schedule.type,
    });

    if (index >= 0) {
      Vue.delete(state.schedules, index);
    }
  }
};

export default { state, getters, actions, mutations };
