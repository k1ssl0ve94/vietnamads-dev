<template>
    <div id="emails">
        <div class="page-header">
            <h1 class="page-title">Email</h1>
        </div>
        <div class="mb-3">
            <form-message/>
        </div>
        <form action method="post" @submit.prevent="submit">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Info</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for>Subject</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="form.subject"
                                    placeholder="Please enter subject"
                                    required
                                >
                            </div>
                        </div>
                        <div class="card-body d-flex">
                            <button class="btn btn-link" @click.prevent="resetForm">reset</button>
                            <button type="submit" class="btn btn-primary ml-auto">Submit</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Select Post</div>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item" v-for="post in posts" :key="post.id">
                                    <div class="form-check">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            :value="post.id"
                                            v-model="form.post_ids"
                                            :id="'checkbox-post-'+post.id"
                                        >
                                        <label
                                            class="form-check-label"
                                            :for="'checkbox-post-'+post.id"
                                        >{{ `${post.id} - ${post.title}` }}</label>
                                    </div>
                                </li>
                            </ul>
                            <div class="text-center pt-3">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button
                                        type="button"
                                        class="btn btn-primary"
                                        @click.prevent="page-=1"
                                    >Previous</button>
                                    <button
                                        type="button"
                                        class="btn btn-default"
                                        disabled
                                    >Page: {{ page }}</button>
                                    <button
                                        type="button"
                                        class="btn btn-primary"
                                        @click.prevent="page+=1"
                                    >Next</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: {
                subject: '',
                post_ids: []
            },
            posts: [],
            page: 1,
            defaultForm: {}
        };
    },
    created() {
        this.defaultForm = Object.assign({}, this.form);
        this.fetchPost(1);
    },
    watch: {
        page(value) {
            if (value <= 0) {
                this.page = 1;
                return;
            }
            this.fetchPost(value);
        }
    },
    methods: {
        resetForm() {
            this.form = Object.assign({}, this.defaultForm);
        },
        submit() {
            if (this.form.post_ids.length == 0) {
                this.$store.dispatch('formErrors', ['You must select at least one post']);
                return;
            }
            axios
                .post('/api/admin/subscribers/email', this.form)
                .then(resp => {
                    this.$store.dispatch('alertSuccess', 'Send Email success');
                    console.log(resp.data);
                    this.resetForm();
                })
                .catch(err => {
                    console.log(err);
                    this.$store.dispatch('handleError', err);
                });
        },
        fetchPost(page = 1) {
            axios
                .get(`/api/admin/posts?page=${this.page}`)
                .then(resp => {
                    console.log(resp.data);
                    this.posts = resp.data.data;
                })
                .catch(err => {
                    console.log(err);
                    this.$store.dispatch('handleError', err);
                });
        }
    }
};
</script>
