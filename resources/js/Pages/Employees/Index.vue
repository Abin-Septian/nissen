<template>
  <div>
    <h1 class="mb-8 font-bold text-2xl">Daftar Karyawan</h1>
    <div class="mb-6 flex justify-between items-center">
      <search-filter v-model="form.search" class="w-full max-w-md mr-4" @reset="reset">
        <label class="block text-gray-700">Tipe data (aktif / non aktif):</label>
        <select v-model="form.trashed" class="mt-1 w-full form-select">
          <option :value="null">Aktif</option>
          <option value="only">Non Aktif</option>
          <option value="with">Semua</option>
        </select>
      </search-filter>
      <inertia-link class="btn-indigo" :href="route('employees.create')">
        <span class="mr-2">
          <strong>+</strong>
        </span>
        <span>Tambah</span>
        <span class="hidden md:inline">Karyawan</span>
      </inertia-link>
    </div>
    <div class="bg-white rounded shadow overflow-x-auto text-sm">
      <table class="w-full table-auto">
        <tr class="text-left font-bold">
          <th style="border:0px; padding:1.5rem;">
            NIK
          </th>
          <th style="border:0px; padding:1.5rem;">
            Nama
          </th>
          <th style="border:0px; padding:1.5rem;">
            Posisi
          </th>
          <th style="border:0px; padding:1.5rem;">
            Departement
          </th>
          <th style="border:0px; padding:1.5rem;">
            Bagian
          </th>
          <th style="border:0px; padding:1.5rem;" colspan="2">
            Tanggal Masuk
          </th>
        </tr>
        <tr v-for="employee in employees.data" :key="employee.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('employees.edit', employee.id)" tabindex="-1">
              {{ employee.nik }}
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('employees.edit', employee.id)">
              {{ employee.name }}
              <icon v-if="employee.deleted_at" name="trash" class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2" />
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('employees.edit', employee.id)" tabindex="-1">
              <div v-if="employee.position">
                {{ employee.position.name }}
              </div>
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('employees.edit', employee.id)" tabindex="-1">
              <div v-if="employee.department">
                {{ employee.department.name }}
              </div>
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('employees.edit', employee.id)" tabindex="-1">
              <div v-if="employee.section">
                {{ employee.section.name }}
              </div>
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('employees.edit', employee.id)" tabindex="-1">
              {{ employee.date_entry }}
            </inertia-link>
          </td>
          <td class="border-t w-px">
            <inertia-link class="px-4 pt-4 flex items-center" :href="route('employees.edit', employee.id)" tabindex="-1">
              <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
            </inertia-link>
          </td>
        </tr>
        <tr v-if="employees.length === 0">
          <td class="border-t px-6 py-4" colspan="7">Karyawan tidak ditemukan.</td>
        </tr>
      </table>
    </div>
    <pagination :links="employees.links" />
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
  metaInfo: { title: 'Daftar Karyawan' },
  layout: Layout,
  components: {
    Icon,
    Pagination,
    SearchFilter,
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
