<template>
  <div class="modal fade" id="modal-preview-issue" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Issue: {{ title }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div v-html="content"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
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
      issue: null
    };
  },
  computed: {
    title() {
      return this.issue && this.issue.title ? this.issue.title : 'content';
    },
    content() {
      return this.issue && this.issue.title ? this.issue.content : 'NO Content';
    }
  },
  methods: {
    show(issue) {
      this.issue = issue;
      $('#modal-preview-issue').modal('show');
    }
  }
};
</script>