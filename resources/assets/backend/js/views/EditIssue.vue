<style lang="scss" scoped>
.fe-calendar {
  position: absolute;
  top: 10px;
  right: 22px;
  font-size: 18px;
}
.card-title {
  margin-right: 10px;
}
.card-header {
  .btn {
    margin-right: 5px;
  }
}
.comment-form {
  padding: 1rem 1.5rem;
  border-bottom: 1px solid rgba(0, 40, 100, 0.12);
}
.vdatetime {
  width: 100%;
}
</style>
<template>
  <form action="" @submit.prevent="confirmEditIssue">
    <div class="card">
      <dimmer v-show="loading" />
      <div class="card-header">
        <h2 class="card-title">Ticket #{{ issueID }}</h2>
        <template v-if="edit">
          <button type="button" class="btn btn-complete btn-sm" v-if="showComplete" @click="complete">Complete</button>
          <button type="button" class="btn btn-pending btn-sm" v-if="showPending" @click="pending">Pending</button>
          <button type="button" class="btn btn-secondary btn-danger btn-sm" v-if="form.status == 4 || form.status == 3" @click="reOpen">Re-Open</button>
          <button type="button" class="btn btn-danger btn-sm" v-if="showCancel" @click="cancel">Cancel</button>
          <button type="submit" class="btn btn-primary btn-sm">Update Issue</button>
        </template>
        <ul class="nav nav-pills card-header-pills ml-auto">
          <li class="nav-item">
            <a class="nav-link" :href="'/feedback-issue/' + feedbackToken" target="_blank">Feedback</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" :class="{'active': showEditForm}" href="#" @click="showInfo">Info</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" :class="{'active': showHistory}" href="#" @click="showLogs">Logs</a>
          </li>
        </ul>
      </div>
      <form-message/>
      <div class="card-body" v-show="showEditForm">
        <div class="form-group row">
          <label class="col-form-label col-sm-2">ID</label>
          <div class="col-sm-10 pt-2">
            {{ issueID }}
          </div>
        </div>
        <div class="form-group row">
          <div class="col-md-6">
            <div class="row">
              <label class="col-form-label col-sm-4">Time to First Response</label>
              <div class="col-sm-8 pt-2">{{ timeToFirstResponse }}</div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="row">
              <label class="col-form-label col-sm-4">Repairing time</label>
              <div class="col-sm-8 pt-2">{{ repairingTime }}</div>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-md-6">
            <div class="row">
              <label class="col-form-label col-sm-4">Buy-off time</label>
              <div class="col-sm-8 pt-2">{{ buyOffTime }}</div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="row">
              <label class="col-form-label col-sm-4">Time to restore service</label>
              <div class="col-sm-8 pt-2">{{ timeToRestoreService }}</div>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-form-label col-sm-2">Priority</label>
          <div class="col-sm-1">
            <select class="form-control" v-model="form.priority" :disabled="!edit">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <div class="form-group row">
              <label class="col-form-label col-sm-4">Title</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="title" required v-model="form.title" :disabled="!edit">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-sm-4">Order By</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="created_email" required v-model="form.created_email" :disabled="!edit">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-sm-4">Source</label>
              <div class="col-sm-8">
                <select class="form-control" v-model="form.source" disabled="disabled">
                  <option v-for="source in sources" :key="source.id" :value="source.id">{{ source.value }}</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-sm-4">Create at</label>
              <div class="col-sm-8">
                <input type="text" readonly class="form-control-plaintext" :value="form.created_at">
              </div>
            </div>
          </div>
          <div class="col">
            <div class="form-group row">
              <label class="col-form-label col-sm-4">Product</label>
              <div class="col-sm-8">
                <select class="form-control" v-model="form.product" :disabled="!edit">
                  <option v-for="product in products" :key="product.id" :value="product.id">{{ product.value }}</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-sm-4">System</label>
              <div class="col-sm-8">
                <select class="form-control" v-model="form.system" :disabled="!edit">
                  <option value="0">-- Select a System --</option>
                  <option v-for="system in systems" :key="system.id" :value="system.id">{{ system.value }}</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-sm-4">Channel</label>
              <div class="col-sm-8">
                <input type="text" class="form-control-plaintext" readonly name="name" v-model="form.channel">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-sm-4">Status</label>
              <div class="col-sm-8 h4">
                <select class="form-control" v-model="form.status" disabled="true">
                  <option value="1">Open - LT1</option>
                  <option value="2">Close - LT8</option>
                  <option value="3">Pending - LT2B</option>
                  <option value="4">Buy Off - LT5</option>
                  <option value="5">Under repair - LT2A</option>
                  <option value="6">Cancel</option>
                </select>
              </div>
            </div>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col">
            <div class="form-group row">
              <label class="col-form-label col-sm-4">Type</label>
              <div class="col-sm-8">
                <select class="form-control" v-model="form.type" :disabled="!edit">
                  <option value="0">-- Select a Type --</option>
                  <option v-for="issueType in issueTypes" :key="issueType.id" :value="issueType.id">{{ issueType.value }}</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-sm-4">Assign</label>
              <div class="col-sm-8">
                <multiselect v-model="selectedAssignee" track-by="id" label="name" placeholder="Select a Assignee" :options="users" :searchable="true" :allow-empty="true" :disabled="!edit">
                  <template slot="singleLabel" slot-scope="{ option }">{{ option.id }} - {{ option.name }}</template>
                  <template slot="option" slot-scope="{ option }">{{ option.id }} - {{ option.name }}</template>
                </multiselect>
                <!-- <pre class="language-json"><code>{{ selectedAssignee  }}</code></pre> -->
              </div>
            </div>
          </div>
          <div class="col">
            <div class="form-group row">
              <label class="col-form-label col-sm-4">Error Type</label>
              <div class="col-sm-8">
                <select class="form-control" v-model="form.error_type" :disabled="!edit">
                  <option value="0">-- Select a Error Type --</option>
                  <option v-for="errorType in errorTypes" :key="errorType.id" :value="errorType.id">{{ errorType.value }}</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-sm-4">Deadline</label>
              <div class="col-sm-8">
                <datetime type="datetime" v-model="form.deadline" input-class="form-control" :disabled="!edit"></datetime>
                <i class="fe fe-calendar"></i>
              </div>
            </div>
          </div>
        </div>
        <hr>
        <div class="form-group row">
          <label class="col-form-label col-sm-2">Content</label>
          <div class="col-sm-10">
            <textarea class="form-control summernote" rows="4" v-model="form.content"></textarea>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-form-label col-sm-2">Attachments</label>
          <div class="col-sm-10">
            <ul>
              <li v-for="att in form.attachments" :key="att.filename">
                <a :href="att.url" target="_blank">{{ att.original }}</a> -
                <a href="#delete" @click.prevent="deleteAttachment(att)">Delete</a>
              </li>
            </ul>
            <p v-if="isUploading">Uploading: {{ percentCompleted }}%</p>
            <div class="custom-file" style="max-width: 300px" v-show="!isUploading">
              <input type="file" class="custom-file-input" name="example-file-input-custom" ref="fileUpload" @change="fileChange" :disabled="!edit">
              <label class="custom-file-label">Choose file</label>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-form-label col-sm-2">Tags</label>
          <div class="col-sm-4">
            <multiselect v-model="form.tag" :options="tagOptions" :multiple="true" :taggable="true" @tag="addTag" :disabled="!edit"></multiselect>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-form-label col-sm-2">Reason</label>
          <div class="col-sm-10">
            <textarea class="form-control" rows="4" v-model="form.reason" :disabled="!edit"></textarea>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-form-label col-sm-2">Action</label>
          <div class="col-sm-10">
            <textarea class="form-control" rows="4" v-model="form.action" :disabled="!edit"></textarea>
          </div>
        </div>
        <hr v-show="showRatingAndComment">
        <div class="form-group row" v-show="showRatingAndComment">
          <label class="col-form-label col-sm-2">Rating</label>
          <div class="col-sm-1">
            <select class="form-control" v-model="form.rating">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
            </select>
          </div>
        </div>
        <div class="form-group row" v-show="showRatingAndComment">
          <label class="col-form-label col-sm-2">Comment</label>
          <div class="col-sm-10">
            <textarea class="form-control" rows="4" v-model="form.comment"></textarea>
          </div>
        </div>
      </div>
      <div class="comment-form" v-if="showHistory">
        <div class="row">
          <div class="col-md-10">
            <textarea class="form-control" rows="3" placeholder="Enter your comment" v-model="comment"></textarea>
          </div>
          <div class="col-md-2">
            <button class="btn btn-primary btn-block" @click.prevent="addComment">Submit</button>
          </div>
        </div>
      </div>
      <div class="table-responsive" v-show="showHistory">
        <table class="table card-table table-vcenter text-nowrap">
          <thead>
            <tr>
              <th>Time</th>
              <th>User</th>
              <th>Status</th>
              <th>Message</th>
              <th>Diff Time</th>
              <th>Type</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="log in logs" :key="log.id">
              <td>{{ log.created_at }}</td>
              <td>{{ log.username }}</td>
              <td>
                <template v-if="log.status == 1">
                  <span class="badge badge-open">Open - LT1</span>
                </template>
                <template v-else-if="log.status == 2">
                  <span class="badge badge-close">Close - LT8</span>
                </template>
                <template v-else-if="log.status == 3">
                  <span class="badge badge-danger">Pending - LT2B</span>
                </template>
                <template v-else-if="log.status == 4">
                  <span class="badge badge-buy-off">Buy Off - LT5</span>
                </template>
                <template v-else-if="log.status == 5">
                  <span class="badge badge-under-repair">Under repair - LT2A</span>
                </template>
                <template v-else-if="log.status == 6">
                  <span class="badge badge-cancel">Cancel</span>
                </template>
              </td>
              <td>{{ log.message }}</td>
              <td>{{ log.diff_time | formatDiffTime }}</td>
              <td>{{ log.type == 0 ? 'Log' : 'Comment' }}</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="card-footer">
        <!-- <template v-if="showEditForm">
          <button type="submit" class="btn btn-primary ml-auto">Update Issue</button>
        </template> -->
      </div>
    </div>
    <modal-confirm ref="modalConfirm" />
  </form>
</template>

<script>
import { mapState, mapGetters } from 'vuex';
import { format as dateFormat, parse as parseDate } from 'date-fns';

export default {
  data() {
    return {
      form: {
        priority: 1,
        title: '',
        created_email: '',
        product: 0,
        system: 0,
        source: 0,
        channel: '',
        type: 0,
        error_type: 0,
        assignee_id: 0,
        tag: [],
        deadline: '',
        content: '',
        reason: '',
        action: '',
        comment: '',
        rating: 1,
        attachments: []
      },
      logs: [],
      loading: true,
      selectedAssignee: null,
      percentCompleted: 0,
      isUploading: false,
      showEditForm: true,
      showHistory: false,
      feedbackToken: '',
      comment: '',
      edit: false
    };
  },
  filters: {
    formatDiffTime(value) {
      var sec_num = parseInt(value, 10); // don't forget the second param
      var hours = Math.floor(sec_num / 3600);
      var minutes = Math.floor((sec_num - hours * 3600) / 60);
      var seconds = sec_num - hours * 3600 - minutes * 60;

      if (hours < 10) {
        hours = '0' + hours;
      }
      if (minutes < 10) {
        minutes = '0' + minutes;
      }
      if (seconds < 10) {
        seconds = '0' + seconds;
      }
      return hours + ':' + minutes + ':' + seconds;
    }
  },
  created() {
    this.id = this.$route.params.id;
    this.fetchIssue();
    this.$store.dispatch('fetchSettings');

    this.$bus.$on('fetch_current_info', user => {
      this.checkEdit();
    });
  },
  mounted() {
    this.checkEdit();
    this.$refs.modalConfirm.$on('edit_issue_ok', () => {
      this.$refs.modalConfirm.hide();
      this.editIssue();
    });
  },
  computed: {
    ...mapState({
      roles: state => state.common.roles,
      users: state => state.user.users
    }),
    ...mapGetters(['departments', 'products', 'systems', 'sources', 'issueTypes', 'errorTypes', 'sourceWebId', 'sourceSlackId', 'tags', 'hasPermission']),
    disabledChannel() {
      return this.form.source == this.sourceWebId;
    },
    tagOptions() {
      return this.tags.map(tag => tag.value);
    },
    showRatingAndComment() {
      if (this.form.status == '1' || this.form.status == '4' || this.form.status == '5') {
        return false;
      }
      return true;
    },
    showComplete() {
      if (this.form.status == '5') {
        if (!this.form.deadline) {
          return true;
        }

        const deadline = parseDate(this.form.deadline);

        if (deadline && deadline < new Date()) {
          return false;
        }

        return true;
      }

      return false;
    },
    showPending() {
      return this.form.status == '5';
    },
    showCancel() {
      return this.form.status != '6' && this.form.status != '2';
    },
    timeToFirstResponse() {
      if (this.form.first_response_at && this.form.created_at) {
        return moment(this.form.first_response_at).diff(moment(this.form.created_at), 'seconds') + 's';
      }
      return 'N/A';
    },
    repairingTime() {
      if (this.form.buy_off_at && this.form.created_at) {
        return moment(this.form.buy_off_at).diff(moment(this.form.created_at), 'seconds') + 's';
      }
      return 'N/A';
    },
    buyOffTime() {
      if (this.form.assign_at && this.form.close_at) {
        return moment(this.form.close_at).diff(moment(this.form.assign_at), 'seconds') + 's';
      }
      return 'N/A';
    },
    timeToRestoreService() {
      if (this.form.created_at && this.form.close_at) {
        return moment(this.form.close_at).diff(moment(this.form.created_at), 'seconds') + 's';
      }
      return 'N/A';
    },
    issueID() {
      if (this.form.code) {
        return `${this.form.code}-${this.form.id}`;
      }
      return this.form.id;
    }
  },
  watch: {
    selectedAssignee() {
      this.form.assignee_id = this.selectedAssignee ? this.selectedAssignee.id : 0;
    }
  },
  methods: {
    checkEdit() {
      if (this.hasPermission('edit ticket')) {
        this.edit = true;
      }
    },
    initSummerNote() {
      const $vm = this;
      $(document).ready(function() {
        $('.summernote').summernote({
          toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
          ],
          callbacks: {
            onChange: (contents, $editable) => {
              // console.log('onChange:', contents, $editable);
              $vm.form.content = contents;
            }
          }
        });
      });
    },
    fetchIssue() {
      this.loading = true;
      axios
        .get(`/api/admin/issues/${this.id}`)
        .then(response => {
          this.loading = false;
          this.formatIssueResponse(response);
        })
        .catch(error => {
          this.loading = false;
        });
    },
    formatIssueResponse(response) {
      this.form = response.data.issue;
      if (this.form.assignee_id) {
        this.selectedAssignee = this.findUserById(this.form.assignee_id);
      }
      if (this.form.deadline) {
        this.form.deadline = dateFormat(parseDate(this.form.deadline), 'YYYY-MM-DDTHH:mm:ssZ');
      }
      this.feedbackToken = response.data.token;
      this.logs = response.data.logs;

      this.initSummerNote();
    },
    findUserById(id) {
      const users = this.users.filter(user => user.id == id);
      if (users.length > 0) {
        return users[0];
      }
      return null;
    },
    confirmEditIssue() {
      if (!this.edit) {
        return;
      }
      this.$refs.modalConfirm.show('edit_issue', 'Are you sure to update this issue?', {}, 'warning');
    },
    editIssue() {
      this.loading = true;
      axios
        .put(`/api/admin/issues/${this.id}`, this.form)
        .then(response => {
          this.loading = false;
          if (response.data.issue) {
            this.formatIssueResponse(response);

            this.$store.dispatch('formSuccess', 'Update issue success');
            window.scrollTo(0, 0);
          } else {
            this.$store.dispatch('formErrors', ['Error!!']);
          }
        })
        .catch(err => {
          console.log(err);
          this.loading = false;
        });
    },
    addTag(newTag) {
      this.form.tag.push(newTag);
      this.tagOptions.push(newTag);
    },
    fileChange() {
      this.uploadFile(this.$refs.fileUpload.files[0]);
    },
    uploadFile(file) {
      const form = new FormData();
      form.append('file', file);

      const config = {
        onUploadProgress: progressEvent => {
          this.percentCompleted = Math.round(progressEvent.loaded * 100 / progressEvent.total);
        }
      };

      this.isUploading = true;

      axios
        .post('/api/admin/upload', form, config)
        .then(response => {
          if (response.data.success) {
            this.form.attachments.push(response.data.file);
          }
          this.$refs.fileUpload.value = '';
          this.isUploading = false;
        })
        .catch(error => {
          this.$refs.fileUpload.value = '';
          this.isUploading = false;
          console.log(error);
        });
    },
    deleteAttachment(att) {
      this.form.attachments = this.form.attachments.filter(a => a.filename != att.filename);
    },
    showInfo() {
      this.showEditForm = true;
      this.showHistory = false;
    },
    showLogs() {
      this.showEditForm = false;
      this.showHistory = true;
    },
    complete() {
      this.form.status = 4;
      this.editIssue();
    },
    reOpen() {
      this.form.status = 5;
      this.editIssue();
    },
    pending() {
      this.form.status = 3;
      this.editIssue();
    },
    cancel() {
      this.form.status = 6;
      this.editIssue();
    },
    addComment() {
      this.loading = true;
      axios
        .post(`/api/admin/issues/${this.id}/logs`, { message: this.comment })
        .then(response => {
          console.log(response.data);
          this.comment = '';
          this.loading = false;
          this.formatIssueResponse(response);
        })
        .catch(err => {
          this.loading = false;
          console.log(err);
        });
    }
  }
};
</script>

