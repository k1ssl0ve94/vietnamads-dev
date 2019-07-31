<style lang="scss" scoped>
.logo-login {
  height: 60px;
}
</style>

<template>
  <div class="page-single">
    <div class="container">
      <div class="row">
        <div class="col col-login mx-auto">
          <div class="text-center mb-6">
            <img src="/demo/logo.svg" class="logo-login" alt="">
          </div>
            <form class="card" action="" method="post" @submit.prevent="login">
              <div class="card-body p-6">
                <div class="card-title">Login to your account</div>
                <form-message />
                <div class="form-group">
                  <label class="form-label">Email address</label>
                  <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" required v-model="form.email">
              </div>
                  <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" required v-model="form.password">
              </div>
                    <div class="form-footer">
                      <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                    </div>
                  </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
export default {
  data() {
    return {
      form: {
        email: '',
        password: ''
      }
    };
  },
  methods: {
    login() {
      this.$store.dispatch('login', this.form);
    }
  }
};
</script>