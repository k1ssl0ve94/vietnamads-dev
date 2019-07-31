<template>
  <td :class="type" @click="showModalAssign">
    <template v-if="schedule">
      <span class="badge badge-success">{{ schedule.user_name }}</span>
    </template>
  </td>
</template>

<script>
import { mapState } from 'vuex';

export default {
  props: ['type', 'day', 'roleId'],
  computed: {
    schedules() {
      return this.$store.state.team.schedules;
    },
    schedule() {
      return this.schedules.find(schedule => schedule.date_str == this.day && schedule.role_id == this.roleId && schedule.type == this.type);
    }
  },
  methods: {
    showModalAssign() {
      this.$emit('showModalAssign', this.schedule);
    }
  }
};
</script>