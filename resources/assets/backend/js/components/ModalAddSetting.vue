<template>
  <div class="modal fade" id="modal-add-setting" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form @submit.prevent="save">
          <div class="modal-body">
            <form-message/>
            <div class="form-group">
              <label class="form-control-label">Key</label>
              <input class="form-control" required v-model="form.key">
            </div>
            <div class="form-group">
              <label class="form-control-label">Value</label>
              <input class="form-control" required v-model="form.value">
            </div>
            <div class="form-group">
              <label class="form-control-label">Group</label>
              <input class="form-control" v-model="form.group">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Add</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import $ from 'jquery';
export default {
  data() {
    return {
      form: {
        key: '',
        value: '',
        group: '',
      }
    }
  },
  methods: {
    show() {
      this.resetForm();
      $('#modal-add-setting').modal();
    },
    hide() {
      $('#modal-add-setting').hide();
    },
    resetForm() {
      this.form = {
        key: '',
        value: '',
        group: '',
      };
    },
    save() {
      axios.post('/api/admin/settings', this.form).then(response => {
        const { setting } = response.data;

        if (setting) {
          this.resetForm();
          this.$store.dispatch("alertSuccess", "Add Setting success");
        } else {
          this.$store.dispatch("alertError", "Error!!");
        }
      });
    }
  }
}
</script>