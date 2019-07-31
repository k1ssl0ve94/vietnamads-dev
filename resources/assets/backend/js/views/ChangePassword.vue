<template>
    <div id="change-password" class="row">
        <div class="col-lg-6 col-md-8 offset-lg-3 offset-md-2">
            <form action @submit.prevent="changePassword">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Change password</h2>
                    </div>
                    <form-message/>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Current Password</label>
                            <input
                                type="password"
                                class="form-control"
                                placeholder="Enter your current password here"
                                v-model="form.current_password"
                                required
                            >
                        </div>
                        <div class="form-group">
                            <label>New Password</label>
                            <input
                                type="password"
                                class="form-control"
                                placeholder="Enter new password here"
                                v-model="form.new_password"
                                required
                            >
                        </div>
                        <div class="form-group">
                            <label>Confirm new Password</label>
                            <input
                                type="password"
                                class="form-control"
                                placeholder="Confirm your new password here"
                                v-model="form.new_password_confirmation"
                                required
                            >
                        </div>
                    </div>
                    <div class="card-footer d-flex">
                        <router-link to="/" class="btn btn-link">Cancel</router-link>
                        <button type="submit" class="btn btn-primary ml-auto">Change</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            form: {
                current_password: '',
                new_password: '',
                new_password_confirmation: ''
            },
            defaultForm: {},
        };
    },
    created() {
        this.defaultForm = Object.assign({}, this.form);
    },
    methods: {
        reset() {
            this.form = Object.assign({}, this.defaultForm);
        },
        changePassword() {
            this.$store.commit('updateFormErrors', []);
            axios.post('/api/admin/change-password', this.form).then(response => {
                if (response.data.status) {
                    this.reset();
                    this.$store.dispatch('alertSuccess', 'Change rassword success!');
                } else if (response.data.errors) {
                    this.$store.dispatch('formErrors', response.data.errors);
                } else {
                    this.$store.dispatch('formErrors', ['Error!!']);
                }
            }).catch(error => {
                this.$store.dispatch('handleError', error);
            })
        }
    }
};
</script>
