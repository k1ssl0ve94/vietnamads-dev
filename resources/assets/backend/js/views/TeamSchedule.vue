<style lang="scss">
#team-schedule {
  table {
    td {
      cursor: pointer;
      padding: 0.3rem;
      font-size: 0.9rem;
      &:hover {
        background-color: #eee;
      }
    }
    th {
      padding: 0.3rem;
    }
  }
  .table th,
  .text-wrap table th {
    color: #333;
  }
}
</style>

<template>
  <div id="team-schedule">
    <loading v-show="loading" />
    <div class="row" v-show="!loading">
      <div class="col-12 text-center" v-show="!hasRole">No roles!</div>
      <div class="col-md-2" v-show="hasRole">
        <select class="form-control custom-select mb-3" v-model="currentMonth" @change="fetchSchedule">
          <option v-for="month in months" :value="month">{{ month }}</option>
        </select>
      </div>
      <div class="col-md-12" v-show="hasRole">
        <div class="table-responsive">
          <table class="table table-bordered table-vcenter text-nowrap">
            <template v-for="(data, week) in times">
              <tr :key="week + '-day'">
                <th rowspan="2">{{ week }}</th>
                <th colspan="2" v-for="day in data" class="text-center">{{day}}</th>
              </tr>
              <tr :key="week + '-ca'">
                <th>GHC</th>
                <th>GNHC</th>
                <th>GHC</th>
                <th>GNHC</th>
                <th>GHC</th>
                <th>GNHC</th>
                <th>GHC</th>
                <th>GNHC</th>
                <th>GHC</th>
                <th>GNHC</th>
                <th>GHC</th>
                <th>GNHC</th>
                <th>GHC</th>
                <th>GNHC</th>
              </tr>
              <tr v-for="role in roles" :key="week + role.id">
                <th>{{ role.name }}</th>
                <template v-for="day in data">
                  <schedule-td v-on:showModalAssign="(schedule) => { showModalAssign(day, role.id, 'ghc', schedule) }" :type="'ghc'" :day="day" :roleId="role.id" />
                  <schedule-td v-on:showModalAssign="(schedule) => { showModalAssign(day, role.id, 'gnhc', schedule) }" :type="'gnhc'" :day="day" :roleId="role.id" />
                </template>
              </tr>
            </template>
          </table>
        </div>
      </div>
    </div>
    <div class="modal fade" id="modal-select-member" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Select Member</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p class="text-center" v-show="team.members.length == 0">No members</p>
            <div class="list-group" v-if="team.members && team.members.length > 0">
              <a href="#" class="list-group-item list-group-item-action" v-for="user in team.members" :key="user.id" @click.prevent="assign(user)">{{ user.name }}</a>
            </div>
          </div>
          <div class="modal-footer" v-if="showDelete">
            <button class="btn btn-danger mr-auto" @click.prevent="assign(null)">Delete</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
</template>

<script>
import { mapState } from 'vuex';
import ScheduleTd from '../components/ScheduleTd';

export default {
  data() {
    return {
      roles: [],
      times: [],
      data: [],
      loading: false,
      currentMonth: '',
      months: [],
      selectedDate: '',
      selectedRoleId: 0,
      showDelete: false
    };
  },
  computed: {
    ...mapState({
      team: state => state.team.currentTeam
    }),
    hasRole() {
      return this.roles.length > 0;
    }
  },
  created() {
    this.fetchSchedule();
  },
  methods: {
    fetchSchedule() {
      this.loading = true;
      axios
        .get(`/api/admin/teams/${this.team.id}/schedule`, {
          params: {
            month: this.currentMonth
          }
        })
        .then(response => {
          this.roles = response.data.roles;
          this.times = response.data.times;
          this.data = response.data.schedules;
          this.currentMonth = response.data.currentMonth;
          this.months = response.data.months;
          this.loading = false;
          this.$store.commit('updateTeamSchedules', response.data.schedules);
        });
    },
    showModalAssign(date, roleId, type, schedule) {
      this.showDelete = !!schedule;
      this.selectedDate = date;
      this.selectedRoleId = roleId;
      this.selectedType = type;
      $('#modal-select-member').modal('show');
    },
    assign(user) {
      let userId = 0;
      if (user) {
        userId = user.id;
      }
      axios
        .post(`/api/admin/teams/${this.team.id}/assign`, {
          team_id: this.team.id,
          user_id: userId,
          role_id: this.selectedRoleId,
          type: this.selectedType,
          date_str: this.selectedDate
        })
        .then(response => {
          if (response.data.schedule) {
            if (response.data.delete) {
              this.$store.commit('deleteSchedule', response.data.schedule);
            } else {
              this.$store.commit('updateSchedule', response.data.schedule);
            }
          }

          $('#modal-select-member').modal('hide');
        });
    }
  },
  components: {
    ScheduleTd
  }
};
</script>

