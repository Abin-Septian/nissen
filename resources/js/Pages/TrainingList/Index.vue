<template>
  <div>
    <h1 class="mb-8 font-bold text-2xl">Daftar Training</h1>
    <div class="mb-6 flex justify-between items-center">
      <search-filter v-model="form.search" class="w-full max-w-md mr-4" @reset="reset">
        <label class="block text-gray-700">Tipe data (aktif / non aktif):</label>
        <select v-model="form.trashed" class="mt-1 w-full form-select">
          <option :value="null">Aktif</option>
          <option value="only">Non Aktif</option>
          <option value="with">Semua</option>
        </select>
      </search-filter>
      <inertia-link class="btn-indigo" :href="route('trainings.create')">
        <span class="mr-2">
          <strong>
            +
          </strong>
        </span>
        <span>Tambah</span>
        <span class="hidden md:inline">Training</span>
      </inertia-link>
    </div>
    <div class="bg-white rounded shadow overflow-x-auto text-sm">
      <table class="w-full table-auto">
        <tr class="text-left font-bold">
          <th class="px-6 pt-6 pb-4">Training</th>
          <th class="px-6 pt-6 pb-4">Tanggal Training</th>
          <th class="px-6 pt-6 pb-4">Jenis Training</th>
          <th class="px-6 pt-6 pb-4">Trainer</th>
          <th class="px-6 pt-6 pb-4" colspan="2">Departemen</th>
        </tr>
        <tr v-for="training in trainings.data" :key="training.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('training_list.show', training.id)">
              {{ training.name }}
              <icon v-if="training.deleted_at" name="trash" class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2" />
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('training_list.show', training.id)" tabindex="-1">
              {{ training.date }}
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('training_list.show', training.id)" tabindex="-1">
              {{ training.type.type }}
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('training_list.show', training.id)" tabindex="-1">
              {{ training.trainer }}
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('training_list.show', training.id)" tabindex="-1">
              {{ training.department.name }}
            </inertia-link>
          </td>
          <td class="border-t w-px">
            <inertia-link class="px-4 flex items-center" :href="route('training_list.show', training.id)" tabindex="-1">
              <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
            </inertia-link>
          </td>
        </tr>
        <tr v-if="trainings.data.length === 0">
          <td class="border-t px-6 py-4" colspan="3">No training found.</td>
        </tr>
      </table>
    </div>
    <pagination :links="trainings.links" />
  </div>
</template>

<script>
import Icon from '@/Shared/Icon'
import Layout from '@/Shared/Layout'
import Pagination from '@/Shared/Pagination'
import pickBy from 'lodash/pickBy'
import SearchFilter from '@/Shared/SearchFilter'
import throttle from 'lodash/throttle'

export default {
  metaInfo: { name: 'Training' },
  layout: Layout,
  components: {
    Icon,
    Pagination,
    SearchFilter,
  },
  props: {
    trainings: Object,
    filters: Object,
  },
  data() {
    return {
      form: {
        admin : this.$parent.owner,
        idDepartment : this.$parent.department_id,
        search: this.filters.search,
        trashed: this.filters.trashed,
      },
    }
  },
  watch: {
    form: {
      handler: throttle(function() {
        let query = pickBy(this.form)
        this.$inertia.replace(this.route('training_list', Object.keys(query).length ? query : { idDepartment: this.form.department_id, admin: this.form.owner, remember: 'forget'}), query)
      }, 150),
      deep: true,
    },
  },
  methods: {
    reset() {
      this.form.search = null,
      this.form.filters = null
    },
  },
}
</script>