<template>
  <nav aria-label="Page navigation example">
    <ul class="pagination justify-content-end">
      <li class="page-item" :class="{disabled: !hasPrevious}">
        <a class="page-link" href="#" aria-label="Previous" @click.prevent="goto(data.current_page - 1)">
          <span aria-hidden="true">&laquo;</span>
          <span class="sr-only">Previous</span>
        </a>
      </li>
      <li class="page-item" v-for="page in pages" :key="page" :class="{active: page == data.current_page}">
        <a class="page-link" href="#" @click.prevent="goto(page)">{{ page }}</a>
      </li>
      <li class="page-item" :class="{disabled: !hasNext}">
        <a class="page-link" href="#" aria-label="Next" @click.prevent="goto(data.current_page + 1)">
          <span aria-hidden="true">&raquo;</span>
          <span class="sr-only">Next</span>
        </a>
      </li>
    </ul>
  </nav>
</template>

<script>
export default {
  props: {
    data: {
      type: Object,
      require: true,
    }
  },
  computed: {
    hasPrevious() {
      return this.data.current_page > 1;
    },
    hasNext() {
      return this.data.current_page < this.data.last_page;
    },
    pages() {
      let from = this.data.current_page - 2;
      if (from < 1) {
        from = 1;
      }
      let to = this.data.current_page + 2;
      if (to > this.data.last_page) {
        to = this.data.last_page;
      }
      return _.range(from, to + 1);
    }
  },
  methods: {
    goto(page) {
      this.$emit('goto_page', page);
    }
  }
}
</script>

