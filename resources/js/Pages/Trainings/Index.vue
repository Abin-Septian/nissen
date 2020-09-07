<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">Training List</h1>
    <div class="mb-6 flex justify-between items-center">
      <inertia-link class="btn-indigo" :href="route('trainings.create')">
        <span>Create</span>
        <span class="hidden md:inline">Training</span>
      </inertia-link>
    </div>
    <div class="bg-white rounded shadow overflow-x-auto">
      <table class="w-full whitespace-no-wrap">
        <tr class="text-left font-bold">
          <th class="px-6 pt-6 pb-4">Training</th>
          <th class="px-6 pt-6 pb-4">Date</th>
          <th class="px-6 pt-6 pb-4" colspan="2">Trainer</th>
        </tr>
        <tr v-for="training in trainings.data" :key="training.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('trainings.edit', training.id)">
              {{ training.title }}
              <icon v-if="training.deleted_at" name="trash" class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2" />
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('trainings.edit', training.id)" tabindex="-1">
              {{ training.date }}
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('trainings.edit', training.id)" tabindex="-1">
              {{ training.trainer }}
            </inertia-link>
          </td>
        </tr>
        <tr v-if="trainings.data.length === 0">
          <td class="border-t px-6 py-4" colspan="4">No training found.</td>
        </tr>
      </table>
    </div>
    <pagination :links="trainings.links" />
  </div>
</template>

<script>
import Icon from '@/Shared/Icon'
import Layout from '@/Shared/Layout'
import mapValues from 'lodash/mapValues'
import Pagination from '@/Shared/Pagination'
import pickBy from 'lodash/pickBy'
import throttle from 'lodash/throttle'

export default {
  metaInfo: { title: 'Training' },
  layout: Layout,
  components: {
    Icon,
    Pagination,
  },
  props: {
    trainings: Object,
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
        this.$inertia.replace(this.route('trainings', Object.keys(query).length ? query : { remember: 'forget' }))
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