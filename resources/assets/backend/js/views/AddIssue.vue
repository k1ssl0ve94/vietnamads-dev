<style lang="scss" scoped>
.fe-calendar {
  position: absolute;
  top: 10px;
  right: 22px;
  font-size: 18px;
}
.vdatetime {
  width: 100%;
}
</style>

<template>
  <form action="" @submit.prevent="addIssue">
    <div class="card">
      <div class="card-header">
        <h2 class="card-title">Add Ticket</h2>
      </div>
      <form-message/>
      <div class="card-body">
        <div class="form-group row">
          <label class="col-form-label col-sm-2">Priority</label>
          <div class="col-sm-1">
            <select class="form-control" v-model="form.priority">
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
                <input type="text" class="form-control" name="title" required v-model="form.title">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-sm-4">Order By</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="created_email" required v-model="form.created_email">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-sm-4">Source</label>
              <div class="col-sm-8">
                <select class="form-control" v-model="form.source">
                  <option v-for="source in sources" :key="source.id" :value="source.id">{{ source.value }}</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-sm-4">Create at</label>
              <div class="col-sm-8">
                <input type="text" readonly class="form-control-plaintext" :value="currentTime">
              </div>
            </div>
          </div>
          <div class="col">
            <div class="form-group row">
              <label class="col-form-label col-sm-4">Product</label>
              <div class="col-sm-8">
                <select class="form-control" v-model="form.product">
                  <option value="0">-- Select a Product --</option>
                  <option v-for="product in products" :key="product.id" :value="product.id">{{ product.value }}</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-sm-4">System</label>
              <div class="col-sm-8">
                <select class="form-control" v-model="form.system">
                  <option value="0">-- Select a System --</option>
                  <option v-for="system in systems" :key="system.id" :value="system.id">{{ system.value }}</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-sm-4">Channel</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="name" v-model="form.channel" :disabled="disabledChannel">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-sm-4">Status</label>
              <div class="col-sm-8 h4">
                <span class="badge badge-danger" v-if="form.assignee_id == 0">Open - LT1</span>
                <span class="badge badge-secondary" v-if="form.assignee_id > 0">Under repair - LT2A</span>
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
                <select class="form-control" v-model="form.type">
                  <option value="0">-- Select a Type --</option>
                  <option v-for="issueType in issueTypes" :key="issueType.id" :value="issueType.id">{{ issueType.value }}</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-sm-4">Assign</label>
              <div class="col-sm-8">
                <multiselect v-model="selectedAssignee" track-by="id" label="name" placeholder="Select a Assignee" :options="users" :searchable="true" :allow-empty="true">
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
                <select class="form-control" v-model="form.error_type">
                  <option value="0">-- Select a Error Type --</option>
                  <option v-for="errorType in errorTypes" :key="errorType.id" :value="errorType.id">{{ errorType.value }}</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-sm-4">Deadline</label>
              <div class="col-sm-8">
                <datetime type="datetime" v-model="form.deadline" input-class="form-control"></datetime>
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
              <input type="file" class="custom-file-input" name="example-file-input-custom" ref="fileUpload" @change="fileChange">
              <label class="custom-file-label">Choose file</label>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-form-label col-sm-2">Tags</label>
          <div class="col-sm-4">
            <multiselect v-model="form.tag" :options="tagOptions" :multiple="true" :taggable="true" @tag="addTag"></multiselect>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-form-label col-sm-2">Reason</label>
          <div class="col-sm-10">
            <textarea class="form-control" rows="4" v-model="form.reason"></textarea>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-form-label col-sm-2">Action</label>
          <div class="col-sm-10">
            <textarea class="form-control" rows="4" v-model="form.action"></textarea>
          </div>
        </div>
        <hr class="d-none">
        <div class="form-group row d-none">
          <label class="col-form-label col-sm-2">Rating</label>
          <div class="col-sm-1">
            <select class="form-control" v-model="form.priority">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
            </select>
          </div>
        </div>
        <div class="form-group row d-none">
          <label class="col-form-label col-sm-2">Comment</label>
          <div class="col-sm-10">
            <textarea class="form-control" rows="4" v-model="form.comment"></textarea>
          </div>
        </div>
      </div>
      <div class="card-footer d-flex">
        <router-link to="/tickets" class="btn btn-link">Cancel</router-link>
        <button type="submit" class="btn btn-primary ml-auto">Add Ticket</button>
      </div>
    </div>
  </form>
</template>

<script>
import { mapState, mapGetters } from 'vuex';
import { format as dateFormat, startOfMonth, addDays } from 'date-fns';

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
        rating: 0,
        attachments: []
      },
      loading: true,
      selectedAssignee: null,
      now: new Date(),
      percentCompleted: 0,
      isUploading: false
    };
  },
  created() {
    setInterval(() => (this.now = new Date()), 1000 * 30); // 30s
    this.form.deadline = dateFormat(addDays(new Date(), 2), 'YYYY-MM-DDTHH:mm:ssZ');
  },
  mounted() {
    this.form.source = this.sourceWebId;
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
  computed: {
    ...mapState({
      roles: state => state.common.roles,
      users: state => state.user.users
    }),
    ...mapGetters(['departments', 'products', 'systems', 'sources', 'issueTypes', 'errorTypes', 'sourceWebId', 'tags']),
    currentTime() {
      return dateFormat(this.now, 'YYYY/MM/DD HH:mm');
    },
    disabledChannel() {
      return this.form.source == this.sourceWebId;
    },
    tagOptions() {
      return this.tags.map(tag => tag.value);
    }
  },
  watch: {
    selectedAssignee() {
      this.form.assignee_id = this.selectedAssignee ? this.selectedAssignee.id : 0;
    }
  },
  methods: {
    validateForm() {
      const errors = [];
      if (!this.form.title) {
        errors.push('Title is required.');
      }
      if (!this.form.created_email) {
        errors.push('Order By is required.');
      }
      if (!this.form.deadline) {
        errors.push('Deadline is required.');
      }
      if (!this.form.product) {
        errors.push('Product must be selected.');
      }
      if (!this.form.type) {
        errors.push('Type must be selected.');
      }
      if (!this.form.error_type) {
        errors.push('Error type must be selected.');
      }
      if (errors.length > 0) {
        this.$store.dispatch('formErrors', errors);
        return false;
      }
      return true;
    },
    addIssue() {
      if (!this.validateForm()) {
        return;
      }
      axios.post('/api/admin/issues', this.form).then(response => {
        if (response.data.issue) {
          this.resetFormData();
          this.$store.dispatch('alertSuccess', 'Add ticket success');
          this.$router.push('/tickets');
        } else {
          this.$store.dispatch('formErrors', ['Error!!']);
          window.scrollTo(0, 0);
        }
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
    resetFormData() {
      this.selectedAssignee = null;
      this.form = {
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
        rating: 0,
        attachments: []
      };
    }
  }
};
</script>

