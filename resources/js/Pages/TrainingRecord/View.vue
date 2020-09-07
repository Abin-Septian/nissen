<template>
  <div />
</template>

<script>
import Layout from '@/Shared/Layout'
import mapValues from 'lodash/mapValues'
import pickBy from 'lodash/pickBy'
import throttle from 'lodash/throttle'

export default {
  metaInfo: { title: 'Employees' },
  layout: Layout,
  components: {
  },
  props: {
    employees: Object,
    filters: Object,
  },
  data() {
    return {
      form: {
        search: this.filters.search,
        trashed: this.filters.trashed,
      },
    }
  },
  watch: {
    form: {
      handler: throttle(function() {
        let query = pickBy(this.form)
        this.$inertia.replace(this.route('employees', Object.keys(query).length ? query : { remember: 'forget' }))
      }, 150),
      deep: true,
    },
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null)
    },
  },
}
</script>
