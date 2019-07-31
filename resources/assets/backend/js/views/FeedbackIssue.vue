<style lang="scss" scoped>
#feedback-issue {
  padding-top: 30px;
}
</style>

<template>
  <div id="feedback-issue">
    <loading v-show="isLoading" />
    <div class="container" v-if="!isLoading && issue.id">
      <div class="row">
        <div class="col-md-8 offset-md-2">
          <div class="card">
            <div class="card-header">
              <h2 class="card-title">Feedback Issue #{{issue.id}}</h2>
            </div>
            <div class="card-body" v-show="success">Feedback done! Thank you!</div>
            <form-message />
            <form action="" @submit.prevent="submitFeedback" v-show="!success">
              <div class="card-body">
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <th scope="row" class="w-25">Title</th>
                      <td>{{ issue.title }}</td>
                    </tr>
                    <tr>
                      <th scope="row" class="w-25">Created By</th>
                      <td>{{ issue.created_email }}</td>
                    </tr>
                    <tr>
                      <th scope="row" class="w-25">Rating</th>
                      <td>
                        <select class="form-control" v-model="form.rating">
                          <option value="1">1</option>
                          <option value="2">2</option>
                          <option value="3">3</option>
                          <option value="4">4</option>
                          <option value="5">5</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row" class="w-25">Comment</th>
                      <td>
                        <textarea class="form-control" rows="4" v-model="form.comment"></textarea>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="card-footer">
                <button class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
import Loading from '../components/Loading';
export default {
  data() {
    return {
      token: this.$route.params.token,
      isLoading: true,
      issue: {},
      form: {
        rating: '1',
        comment: ''
      },
      success: false,
    }
  },
  mounted() {
    this.fetchIssue();
  },
  methods: {
    fetchIssue() {
      this.isLoading = true;
      axios.get(`/api/admin/issues/detail-token/${this.token}`).then(response => {
        this.issue = response.data.issue;
        this.isLoading = false;
      }).catch(err => {
        this.isLoading = false;
        console.log(err)
      })
    },
    submitFeedback() {
      this.isLoading = true;
      axios.post(`/api/admin/issues/detail-token/${this.token}`, {
        rating: this.form.rating,
        comment: this.form.comment,
      }).then(response => {
        this.isLoading = false;
        if (response.data.success) {
          this.success = true;
        }
      }).catch(err => {
        this.isLoading = false;
        console.log(err)
      })
    }
  },
  components: {
    Loading
  }
}
</script>

