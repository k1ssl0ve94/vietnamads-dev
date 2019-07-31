<template>
  <div class="modal fade" id="modal-confirm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header border-0" :class="[`bg-${type}`]">
          <h5 class="modal-title text-white">Confirmation</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body p-5">
          {{ message }}
        </div>

        <div class="modal-footer border-0">
          <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-danger" v-if="type == 'danger'" @click="ok">Continue</button>
          <button type="button" class="btn btn-warning" v-if="type == 'warning'" @click="ok">Continue</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import $ from 'jquery';

export default {
  data() {
    return {
      event: '',
      message: 'Are you sure?',
      payload: {},
      type: 'danger'
    };
  },
  methods: {
    show(event, message, payload, type = 'danger') {
      this.payload = payload;
      this.event = event;
      this.message = message;
      this.type = type;
      $('#modal-confirm').modal('show');
    },
    hide() {
      $('#modal-confirm').modal('hide');
    },
    ok() {
      this.$emit(`${this.event}_ok`, this.payload);
    },
    cancel() {
      this.$emit(`${this.event}_cancel`, this.payload);
    }
  }
};
</script>