<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">Daftar Departement</h1>
    <div class="mb-6 flex justify-between items-center">
      <search-filter v-model="form.search" class="w-full max-w-md mr-4" @reset="reset">
        <label class="block text-gray-700">Trashed:</label>
        <select v-model="form.trashed" class="mt-1 w-full form-select">
          <option :value="null" />
          <option value="with">With Trashed</option>
          <option value="only">Only Trashed</option>
        </select>
      </search-filter>
      <inertia-link class="btn-indigo" :href="route('departments.create')">
        <span class="mr-3">
          <strong>+</strong>
        </span>
        <span>Tambah</span>
        <span class="hidden md:inline">Department</span>
      </inertia-link>
    </div>
    <div class="bg-white rounded shadow overflow-x-auto">
      <sorted-table :values="dept" class="w-full whitespace-no-wrap">
        <tr class="text-left font-bold">
          <th style="border:0px; padding:1.5rem;">
            <sort-link name="name" class="py-12 text-gray-700">Nama Departement</sort-link>
          </th>
        </tr>
        <tbody slot="body" slot-scope="sort">
          <tr v-for="department in sort.values" :key="department.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
            <td class="border-t">
              <inertia-link class="px-6 py-2 flex items-center focus:text-indigo-500" :href="route('departments.edit', department.id)">
                {{ department.name }}
                <icon v-if="department.deleted_at" name="trash" class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2" />
              </inertia-link>
            </td>
            <td class="border-t w-px">
              <inertia-link class="px-4 flex items-center" :href="route('departments.edit', department.id)" tabindex="-1">
                <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
              </inertia-link>
            </td>
          </tr>
        </tbody>
        <tr v-if="departments.data.length === 0">
          <td class="border-t px-6 py-4" colspan="4">No departments found.</td>
        </tr>
      </sorted-table>
    </div>
    <pagination :links="departments.links" />
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
  metaInfo: { title: 'Departments' },
  layout: Layout,
  components: {
    Icon,
    Pagination,
    SearchFilter,
  },
  props: {
    departments: Object,
    filters: Object,
  },
  data() {
    return {
      form: {
        search: this.filters.search,
        trashed: this.filters.trashed,
      },
      dept : this.departments.data,
    }
  },
  watch: {
    form: {
      handler: throttle(function() {
        let query = pickBy(this.form)
        this.$inertia.replace(this.route('departments', Object.keys(query).length ? query : { remember: 'forget' }))
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
