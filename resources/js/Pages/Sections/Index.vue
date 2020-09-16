<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">Daftar Sections</h1>
    <div class="mb-6 flex justify-between items-center">
      <search-filter v-model="form.search" class="w-full max-w-md mr-4" @reset="reset">
        <label class="block text-gray-700">Trashed:</label>
        <select v-model="form.trashed" class="mt-1 w-full form-select">
          <option :value="null" />
          <option value="with">With Trashed</option>
          <option value="only">Only Trashed</option>
        </select>
      </search-filter>
      <inertia-link class="btn-indigo" :href="route('sections.create')">
        <span class="mr-2"><strong>+</strong></span>
        <span>Tambah</span>
        <span class="hidden md:inline">Sections</span>
      </inertia-link>
    </div>
    <div class="bg-white rounded shadow overflow-x-auto">
      <sorted-table :values="sections.data" class="w-full whitespace-no-wrap">
        <tr class="text-left font-bold">
          <th style="border:0px; padding:1.5rem;">
            <sort-link name="name" class="py-12 text-gray-700">Nama Section</sort-link>
          </th>
        </tr>
        <tbody slot="body" slot-scope="sort">
          <tr v-for="section in sort.values" :key="section.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
            <td class="border-t">
              <inertia-link class="px-6 py-2 flex items-center focus:text-indigo-500" :href="route('sections.edit', section.id)">
                {{ section.name }}
                <icon v-if="section.deleted_at" name="trash" class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2" />
              </inertia-link>
            </td>
            <td class="border-t w-px">
              <inertia-link class="px-4 flex items-center" :href="route('sections.edit', section.id)" tabindex="-1">
                <icon name="cheveron-right" class="block mt-2 w-6 h-6 fill-gray-400" />
              </inertia-link>
            </td>
          </tr>
          <tr v-if="sections.data.length === 0">
            <td class="border-t px-6 py-4" colspan="4">No sections found.</td>
          </tr>
        </tbody>
      </sorted-table>
    </div>
    <pagination :links="sections.links" />
  </div>
</template>

<script>
import Icon from '@/Shared/Icon'
import Layout from '@/Shared/Layout'
import mapValues from 'lodash/mapValues'
import Pagination from '@/Shared/Pagination'
import pickBy from 'lodash/pickBy'
import SearchFilter from '@/Shared/SearchFilter'
import throttle from 'lodash/throttle'

export default {
  metaInfo: { title: 'Daftar Sections' },
  layout: Layout,
  components: {
    Icon,
    Pagination,
    SearchFilter,
  },
  props: {
    sections: Object,
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
        this.$inertia.replace(this.route('sections', Object.keys(query).length ? query : { remember: 'forget' }))
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
